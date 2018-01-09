<?php
namespace App\Controller;

use App\Model\Table\AssetsTableEx;
use App\Model\Table\ArticlesTableEx;
use App\Model\Table\NotesTableEx;
use App\Controller\AppController;
use Cake\Network\Exception\NotFoundException;

/**
* Articles Controller
*
* @property \App\Model\Table\ArticlesTable $Articles
*
* @method \App\Model\Entity\Article[] paginate($object = null, array $settings = [])
*/
class ArticlesController extends AppController
{
  /**
  * initialize method.
  */
  public function initialize()
  {
    parent::initialize();
    $this->loadModel("Categories");
    $this->loadModel('NotesModules');
  }

  /**
  * beforeFilter
  */
  public function beforeFilter($event)
  {
    parent::beforeFilter($event);
    $this->Auth->allow("categories");

    $this->addRelatedLink(['Articles', 'edit'], 'New Article');

  }

  /**
  * Index method
  *
  * @return \Cake\Http\Response|void
  */
  public function index()
  {
    $this->paginate = [
      'contain' => ['Notes', 'Categories']
    ];
    $articles = $this->paginate($this->Articles);
    $layers   = $this->Articles->getLayers();

    $this->set(compact('articles', 'layers'));
  }

  /**
  * Edit method
  *
  * @param string|null $id Article id.
  * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
  * @throws \Cake\Network\Exception\NotFoundException When record not found.
  */
  public function edit($id = null)
  {
    $article = null;

    if(is_null($id)) {
      $article = $this->Articles->newEntity();
    } else {
      $article = $this->Articles->get($id, [
        'contain' => []
      ]);
    }

    if ($this->request->is(['post', 'put'])) {
      $article = $this->Articles->patchEntity($article, $this->request->getData());
      if ($this->Articles->save($article)) {
        $this->Flash->success(__('The article has been saved.'));

        return $this->redirect(['action' => 'index']);
      }
      $this->Flash->error(__('The article could not be saved. Please, try again.'));
    }
    $notes = $this->Articles->Notes->find('list', ['limit' => 200]);
    $categories = $this->Articles->Categories->find('list', ['limit' => 200]);
    $layers = $this->Articles->getLayers();
    $this->set(compact('article', 'notes', 'categories', 'layers'));
  }

  /**
  * Delete method
  *
  * @param string|null $id Article id.
  * @return \Cake\Http\Response|null Redirects to index.
  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
  */
  public function delete($id = null)
  {
    $this->request->allowMethod(['post', 'delete']);
    $article = $this->Articles->get($id);
    if ($this->Articles->delete($article)) {
      $this->Flash->success(__('The article has been deleted.'));
    } else {
      $this->Flash->error(__('The article could not be deleted. Please, try again.'));
    }

    return $this->redirect(['action' => 'index']);
  }

  /**
   * スニペット一覧
   */
  public function snippets($category_id = null)
  {
    $this->categories(ArticlesTableEx::LAYER_SNIP, $category_id);
  }

  /**
   * ブログ一覧
   */
  public function blogs($category_id = null)
  {
    $this->categories(ArticlesTableEx::LAYER_BLOG, $category_id);
  }

  /**
   * スニペットの表示
   */
  public function snippet($id = null)
  {
    $this->note(ArticlesTableEx::LAYER_SNIP, $id);
  }

  /**
   * ブログの表示
   */
  public function blog($id = null)
  {
    $this->note(ArticlesTableEx::LAYER_BLOG, $id);
  }

  /**
  * memos,blogsアクション用の処理。
  * 記事一覧を表示するためのデータを取得し、Viewへセットします。
  *
  * @param int $layer 取得する記事のレイヤーを指定します。
  * @param int|null $category_id 取得する記事のカテゴリを指定、null時は全カテゴリ。
  * @return null
  * @throws Cake\Network\Exception\NotFoundException; パラメータ不正時。
  */
  private function categories($layer, $category_id)
  {
    // 変数定義
    $categories; $datas;

    // 指定されたlayerの記事で使われているカテゴリリストを取得
    $categories = $this->Articles->getCategoriesUsedIn($layer);

    /**
    * カテゴリIDが指定されている(null以外)場合の事前処理
    * 1.使用されていないカテゴリだった場合はNotFoundの例外を吐き出します。
    * 2.存在するカテゴリであればパンくずメニューにカテゴリへのリンクを追加します。
    */
    if(!is_null($category_id))
    {
      // カテゴリリストに存在しなければNot Found
      if(!array_key_exists($category_id, $categories)) {
        throw new NotFoundException();
      }

      // パンくずを設定。
      $this->addCrumb($categories[$category_id]);

      // 記事を取得
      $datas = $this->Articles->getArticlesOfPublic($layer, [$category_id]);
    } else {
      $datas = $this->Articles->getArticlesOfPublic($layer, array_keys($categories), 20);
    }

    $this->set(compact('datas', 'categories'));
  }

  /**
  * 記事に登録されているノート情報の取得とViewへのセット。
  */
  public function note($layer, $id)
  {
    // 記事情報を取得
    $article = $this->Articles->getArticleOfPublic($layer, $id);

    // 記事が指定されたレイヤーと異なる場合はNot Found
    if(is_null($article)){
      throw new NotFoundException();
    }

    // 関連リンクに編集ページを追加
    if($this->isLogin()) {
      $this->addRelatedLink(['Notes', 'edit', $article->note_id], 'Edit Note');
    }

    // 記事のパンくずリストをセットアップ。
    $this->setupBreadcrumb($article);

    // モジュールデータを取得
    $modules = $this->NotesModules->getModulesUsedIn($article->note_id);
    $assets = $this->NotesModules->getAssetsUsedIn($article->note_id);

    // Viewへセット
    $note = $article->note;
    $this->set(compact('note', 'modules'));
    $this->setElementVar("assets", $assets);
  }

  /**
  * 記事のパンくずメニューを設定する。
  */
  private function setupBreadcrumb($article)
  {
    // パンくずリストの設定。layerによってアクションを変更。
    $actions = [
      ArticlesTableEx::LAYER_SNIP => 'snippets',
      ArticlesTableEx::LAYER_BLOG => 'blogs',
    ];

    $params = [
      'controller'  => 'Articles',
      'action'      => $actions[$article->layer],
      $article->category->id
    ];

    $this->addCrumb($article->category->name, $params);
    $this->addCrumb($article->note->title);
  }
}
