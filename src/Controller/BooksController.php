<?php
namespace App\Controller;

use App\Controller\AppController;

/**
* Books Controller
*
* @property \App\Model\Table\BooksTable $Books
*
* @method \App\Model\Entity\Book[] paginate($object = null, array $settings = [])
*/
class BooksController extends AppController
{
  /**
  * before action method
  */
  public function beforeFilter($event)
  {
    parent::beforeFilter($event);

    $this->addRelatedLink(['Books'    , 'index' ], 'List Books');
    $this->addRelatedLink(['Books'    , 'edit'  ], 'New Book');
    $this->addRelatedLink(['Sections' , 'index' ], 'List Sections');
    $this->addRelatedLink(['Sections' , 'add'   ], 'New Section');
  }

  /**
  * Index method
  *
  * @return \Cake\Http\Response|void
  */
  public function index()
  {
    $this->paginate = [
      'contain' => ['Categories']
    ];
    $books = $this->paginate($this->Books);

    $this->set(compact('books'));
  }

  /**
  * View method
  *
  * @param string|null $id Book id.
  * @return \Cake\Http\Response|void
  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
  */
  public function view($id = null)
  {
    $book = $this->Books->get($id, [
      'contain' => ['Categories', 'Sections']
    ]);

    $this->set('book', $book);
  }

  /**
  * Edit method
  *
  * @param string|null $id Book id.
  * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
  * @throws \Cake\Network\Exception\NotFoundException When record not found.
  */
  public function edit($id = null)
  {
    $book = null;

    if(is_null($id)) {
      $book = $this->Books->newEntity();
    } else {
      $book = $this->Books->get($id, ['contain' => ['Sections']]);
    }

    if ($this->request->is(['patch', 'post', 'put'])) {
      $book = $this->Books->patchEntity($book, $this->request->getData());
      if ($this->Books->save($book)) {
        $this->Flash->success(__('The book has been saved.'));

        return $this->redirect(['action' => 'index']);
      }
      $this->Flash->error(__('The book could not be saved. Please, try again.'));
    }
    $categories = $this->Books->Categories->find('list', ['limit' => 200]);
    $sections = $this->Books->Sections->find('list', ['limit' => 200]);
    $layers = $this->Books->getLayers();
    $this->set(compact('book', 'categories', 'sections', 'layers'));
  }

  /**
  * Delete method
  *
  * @param string|null $id Book id.
  * @return \Cake\Http\Response|null Redirects to index.
  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
  */
  public function delete($id = null)
  {
    $this->request->allowMethod(['post', 'delete']);
    $book = $this->Books->get($id);
    if ($this->Books->delete($book)) {
      $this->Flash->success(__('The book has been deleted.'));
    } else {
      $this->Flash->error(__('The book could not be deleted. Please, try again.'));
    }

    return $this->redirect(['action' => 'index']);
  }
}
