<?php
namespace App\Controller;

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

  }

  /**
  * beforeFilter
  */
  public function beforeFilter($event)
  {
    parent::beforeFilter($event);
    $this->Auth->allow("categories");

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
   * 記事一覧
   */
  public function articles($category_id = null)
  {
    $layer = ArticlesTableEx::LAYER_NEW;
    $categories = $this->Articles->Categories->find('list')->toArray();

    if(!is_null($category_id) && !array_key_exists($category_id, $categories)){
      throw new NotFoundException();
    }

    $where = ['Articles.layer' => $layer];

    if(!is_null($category_id)) {
      $where['Categories.id'] = $category_id;

      $this->addCrumb($categories[$category_id], ["controller" => "articles", "action" => "articles", $category_id]);
    }

    $articles = $this->Articles->find()
    ->contain(['Notes', 'Categories'])
    ->where($where)
    ->order(['Categories.order_no' => 'desc']);

    $grouping = [];

    foreach($articles as $article) {
      $grouping[$article->category->id][] = $article;
    }
    $categories = $this->Articles->Categories->find('list')->toArray();

    $this->set(compact('grouping', 'categories'));
  }

  /**
   * ブログ一覧
   */
  public function blogs($category_id = null)
  {
    $layer = ArticlesTableEx::LAYER_BLOG;
    $categories = $this->Articles->Categories->find('list')->toArray();

    if(!is_null($category_id) && !array_key_exists($category_id, $categories)){
      throw new NotFoundException();
    }

    $where = ['Articles.layer' => $layer];

    if(!is_null($category_id)) {
      $where['Categories.id'] = $category_id;

      $this->addCrumb($categories[$category_id], ["controller" => "articles", "action" => "articles", $category_id]);
    }

    $articles = $this->Articles->find()
    ->contain(['Notes', 'Categories'])
    ->where($where)
    ->order(['Categories.order_no' => 'desc']);

    $grouping = [];

    foreach($articles as $article) {
      $grouping[$article->category->id][] = $article;
    }
    $categories = $this->Articles->Categories->find('list')->toArray();

    $this->set(compact('grouping', 'categories'));
  }

  /**
   * 記事の表示
   */
  public function display($id = null)
  {
    $article = $this->Articles->get($id, ['contain' => ['Notes', 'Categories']]);


    $this->addCrumb($article->category->name, ["controller" => "articles", "action" => "articles", $article->category->id]);
    $this->addCrumb($article->note->title);

    $this->addScript("/venders/marked/marked.min.js");
    $this->addScript("/js/share/note.js");
    $this->addStyle("note");

    $this->set(compact('article'));
  }
}
