<?php
namespace App\Controller;

use App\Controller\AppController;

/**
* Notes Controller
*
* @property \App\Model\Table\NotesTable $Notes
*
* @method \App\Model\Entity\Note[] paginate($object = null, array $settings = [])
*/
class NotesController extends AppController
{
  /**
  * before action method
  */
  public function beforeFilter($event) {
    parent::beforeFilter($event);

    $this->addRelatedLink(['Notes'   , 'index' ], 'List Notes');
    $this->addRelatedLink(['Notes'   , 'edit'  ], 'New Note');
    $this->addRelatedLink(['Modules' , 'add'   ], 'New Module');
    $this->addRelatedLink(['Modules' , 'index' ], 'List Modules');
    $this->addRelatedLink(['Sections', 'add'   ], 'New Section');
    $this->addRelatedLink(['Sections', 'index' ], 'List Sections');


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
    $notes = $this->paginate($this->Notes);
    $statuses =$this->Notes->getStatuses();
    $this->set(compact('notes', 'statuses'));
  }

  /**
  * View method
  *
  * @param string|null $id Note id.
  * @return \Cake\Http\Response|void
  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
  */
  public function view($id = null)
  {
    $this->addStyle("note");
    $note = $this->Notes->get($id, [
      'contain' => ['Categories', 'Modules', 'Tags', 'Sections', 'Articles']
    ]);

    $this->addCrumb($note->category->name);

    $this->set('note', $note);
  }

  /**
  * Edit method
  *
  * @param string|null $id Note id.
  * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
  * @throws \Cake\Network\Exception\NotFoundException When record not found.
  */
  public function edit($id = null)
  {
    $this->addScript("/venders/marked/marked.min.js");
    $this->addStyle("note");
    $note = null;
    if(is_null($id)) {
      $note = $this->Notes->newEntity();
    } else {
      $note = $this->Notes->get($id, [
        'contain' => ['Modules', 'Tags', 'Sections']
      ]);
    }

    if ($this->request->is(['post', 'put'])) {
      $note = $this->Notes->patchEntity($note, $this->request->getData());
      if ($this->Notes->save($note)) {
        $this->Flash->success(__('The note has been saved.'));
        return $this->redirect(['action' => 'index']);
      }

      $this->Flash->error(__('The note could not be saved. Please, try again.'));
    }
    $categories = $this->Notes->Categories->find('list', ['limit' => 200]);
    $modules = $this->Notes->Modules->find('list', ['limit' => 200]);
    $tags = $this->Notes->Tags->find('list', ['limit' => 200]);
    $sections = $this->Notes->Sections->find('list', ['limit' => 200]);
    $statuses = $this->Notes->getStatuses();
    $this->set(compact('note', 'categories', 'modules', 'tags', 'sections', 'statuses'));
  }

  /**
  * Delete method
  *
  * @param string|null $id Note id.
  * @return \Cake\Http\Response|null Redirects to index.
  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
  */
  public function delete($id = null)
  {
    $this->request->allowMethod(['post', 'delete']);
    $note = $this->Notes->get($id);
    if ($this->Notes->delete($note)) {
      $this->Flash->success(__('The note has been deleted.'));
    } else {
      $this->Flash->error(__('The note could not be deleted. Please, try again.'));
    }

    return $this->redirect(['action' => 'index']);
  }
}
