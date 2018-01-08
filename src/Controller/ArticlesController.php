<?php
namespace App\Controller;

use App\Model\Table\AssetsTableEx;
use App\Model\Table\ArticlesTableEx;
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
   * メモ一覧
   */
  public function memos($category_id = null)
  {
    $layer = ArticlesTableEx::LAYER_MEMO;
    $this->categories($layer, $category_id);
  }

  /**
   * ブログ一覧
   */
  public function blogs($category_id = null)
  {
    $layer = ArticlesTableEx::LAYER_BLOG;
    $this->categories($layer, $category_id);
  }

  /**
   * 記事の表示
   */
  public function display($id = null)
  {
    $article = $this->Articles->get($id, ['contain' => ['Notes', 'Categories']]);

    if($this->isLogin()) {
      $this->addRelatedLink(['Notes', 'edit', $article->note_id], 'Edit Note');
    }

    $this->addCrumb($article->category->name, ["controller" => "articles", "action" => "articles", $article->category->id]);
    $this->addCrumb($article->note->title);

    $this->addScript("/venders/marked/marked.min.js");
    $this->addScript("/js/share/note.js");
    $this->addStyle("note");

    $this->loadModel('NotesModules');
    $modules = $this->NotesModules
      ->find()
      ->contain(['Modules'])
      ->order(['NotesModules.order_no'])
      ->where(['note_id' => $article->note_id]);

    $assets = $this->NotesModules
      ->find()
      ->select(['Assets.kind', 'Assets.src'])
      ->join([
        'ModulesAssets' => [
          'table' => 'modules_assets',
          'type'  => 'left',
          'conditions' => 'ModulesAssets.module_id = NotesModules.module_id'
        ],
        'Assets' => [
          'table' => 'assets',
          'type'  => 'left',
          'conditions' => 'ModulesAssets.asset_id = Assets.id'
        ]
      ])
      ->order(['NotesModules.order_no', 'ModulesAssets.order_no'])
      ->where(['NotesModules.note_id' => $article->note->id]);

    foreach($assets as $asset) {
      switch($asset->Assets['kind']){
        case AssetsTableEx::KIND_JS :
          $this->addScript($asset->Assets['src']);
          break;
        case AssetsTableEx::KIND_CSS :
          $this->addStyle($asset->Assets['src']);
          break;
      }
    }

    $this->set(compact('article', 'modules'));
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

      // パンくずリストの設定。layerによってアクションを変更。
      $actions = [
        ArticlesTableEx::LAYER_MEMO => 'memos',
        ArticlesTableEx::LAYER_BLOG => 'blogs',
      ];

      $params = [
        'controller'  => 'Articles',
        'action'      => $actions[$layer],
        $category_id
      ];

      $this->addCrumb($categories[$category_id], $params);
    }

    // 表示用の記事リストデータを取得。
    $grouping = [];

    if(is_null($category_id)) {
      $grouping = $this->getArticles($layer, $categories, 20);
    } else {
      $grouping = $this->getArticles($layer, [$category_id => ""]);
    }

    $this->set(compact('grouping', 'categories'));
  }

  /**
  * カテゴリ毎に記事を取得します。
  * @param int $layer 取得する記事のレイヤーを指定します。
  * @param array $categories 取得する記事のカテゴリリスト。
  * @param int $limit 取得最大数。0以下の場合は無効。
  * @return keyをカテゴリIDとしたqueryの配列。
  */
  private function getArticles($layer, $categories, $limit = 0)
  {
    $articles = [];

    foreach($categories as $id => $name) {

      $query = $this->Articles
        ->find()
        ->where([
          'Articles.layer'        => $layer,
          'Articles.category_id'  => $id,
        ])
        ->contain('Notes');

        if(0 < $limit) {
          $query->limit($limit);
        }

        $articles[$id] = $query;
    }

    return $articles;
  }
}
