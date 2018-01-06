<?php
namespace App\Controller;

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
    $this->addCrumb("記事(1ch)", "/1ch");
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
  * View method
  *
  * @param string|null $id Article id.
  * @return \Cake\Http\Response|void
  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
  */
  public function view($id = null)
  {
    $article = $this->Articles->get($id, [
      'contain' => ['Notes', 'Categories']
    ]);

    $this->set('article', $article);
  }

  /**
  * Add method
  *
  * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
  */
  public function add()
  {
    $article = $this->Articles->newEntity();
    if ($this->request->is('post')) {
      $article = $this->Articles->patchEntity($article, $this->request->getData());
      if ($this->Articles->save($article)) {
        $this->Flash->success(__('The article has been saved.'));

        return $this->redirect(['action' => 'index']);
      }
      $this->Flash->error(__('The article could not be saved. Please, try again.'));
    }
    $notes = $this->Articles->Notes->find('list', ['limit' => 200]);
    $categories = $this->Articles->Categories->find('list', ['limit' => 200]);
    $this->set(compact('article', 'notes', 'categories'));
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
  * 1ch
  */
  public function categories($category_id = null)
  {

    if(is_null($this->request->layer)) {
      throw new NotFoundException();
    }

    $articles = $this->Articles->find()
    ->where(['layer' => $this->request->layer
  ]);




  $this->set(compact('articles'));
}
}
