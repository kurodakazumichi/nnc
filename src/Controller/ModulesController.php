<?php
namespace App\Controller;

use App\Controller\AppController;

/**
* Modules Controller
*
* @property \App\Model\Table\ModulesTable $Modules
*
* @method \App\Model\Entity\Module[] paginate($object = null, array $settings = [])
*/
class ModulesController extends AppController
{
  /**
  * before action method.
  */
  public function beforeFilter($event)
  {
    parent::beforeFilter($event);

    $this->addRelatedLink(['Modules' , 'index' ], 'List Modules');
    $this->addRelatedLink(['Modules' , 'edit'  ], 'New Module');
  }

  /**
  * Index method
  *
  * @return \Cake\Http\Response|void
  */
  public function index()
  {
    $modules = $this->paginate($this->Modules);

    $this->set(compact('modules'));
  }

  /**
  * View method
  *
  * @param string|null $id Module id.
  * @return \Cake\Http\Response|void
  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
  */
  public function view($id = null)
  {
    $module = $this->Modules->get($id, [
      'contain' => ['Assets', 'Notes']
    ]);

    $this->set('module', $module);
  }

  /**
  * Edit method
  *
  * @param string|null $id Module id.
  * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
  * @throws \Cake\Network\Exception\NotFoundException When record not found.
  */
  public function edit($id = null)
  {
    $module = null;
    
    if(is_null($id)) {
      $module = $this->Modules->newEntity();
    } else {
      $module = $this->Modules->get($id, [
        'contain' => ['Assets', 'Notes']
      ]);
    }

    if ($this->request->is(['patch', 'post', 'put'])) {
      $module = $this->Modules->patchEntity($module, $this->request->getData());
      if ($this->Modules->save($module)) {
        $this->Flash->success(__('The module has been saved.'));

        return $this->redirect(['action' => 'index']);
      }
      $this->Flash->error(__('The module could not be saved. Please, try again.'));
    }
    $assets = $this->Modules->Assets->find('list', ['limit' => 200]);
    $notes = $this->Modules->Notes->find('list', ['limit' => 200]);
    $this->set(compact('module', 'assets', 'notes'));
  }

  /**
  * Delete method
  *
  * @param string|null $id Module id.
  * @return \Cake\Http\Response|null Redirects to index.
  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
  */
  public function delete($id = null)
  {
    $this->request->allowMethod(['post', 'delete']);
    $module = $this->Modules->get($id);
    if ($this->Modules->delete($module)) {
      $this->Flash->success(__('The module has been deleted.'));
    } else {
      $this->Flash->error(__('The module could not be deleted. Please, try again.'));
    }

    return $this->redirect(['action' => 'index']);
  }
}
