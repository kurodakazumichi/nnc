<?php
namespace App\Controller;

use App\Controller\AppController;

/**
* Assets Controller
*
* @property \App\Model\Table\AssetsTable $Assets
*
* @method \App\Model\Entity\Asset[] paginate($object = null, array $settings = [])
*/
class AssetsController extends AppController
{
  /**
  * before action method.
  */
  public function beforeFilter($event)
  {
    parent::beforeFilter($event);
  }

  /**
  * Index method
  *
  * @return \Cake\Http\Response|void
  */
  public function index()
  {
    $assets = $this->paginate($this->Assets);
    $kinds = $this->Assets->getKinds();
    $this->set(compact('assets', 'kinds'));
  }

  /**
  * View method
  *
  * @param string|null $id Asset id.
  * @return \Cake\Http\Response|void
  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
  */
  public function view($id = null)
  {
    $asset = $this->Assets->get($id, [
      'contain' => ['Modules']
    ]);

    $this->set('asset', $asset);
  }

  /**
  * Edit method
  *
  * @param string|null $id Asset id.
  * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
  * @throws \Cake\Network\Exception\NotFoundException When record not found.
  */
  public function edit($id = null)
  {
    $asset = null;
    if(is_null($id)) {
      $asset = $this->Assets->newEntity();
    } else {
      $asset = $this->Assets->get($id, [
        'contain' => ['Modules']
      ]);
    }

    if ($this->request->is(['patch', 'post', 'put'])) {
      $asset = $this->Assets->patchEntity($asset, $this->request->getData());
      if ($this->Assets->save($asset)) {
        $this->Flash->success(__('The asset has been saved.'));

        return $this->redirect(['action' => 'index']);
      }
      $this->Flash->error(__('The asset could not be saved. Please, try again.'));
    }
    $modules = $this->Assets->Modules->find('list', ['limit' => 200]);
    $kinds = $this->Assets->getKinds();
    $this->set(compact('asset', 'modules', 'kinds'));
  }

  /**
  * Delete method
  *
  * @param string|null $id Asset id.
  * @return \Cake\Http\Response|null Redirects to index.
  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
  */
  public function delete($id = null)
  {
    $this->request->allowMethod(['post', 'delete']);
    $asset = $this->Assets->get($id);
    if ($this->Assets->delete($asset)) {
      $this->Flash->success(__('The asset has been deleted.'));
    } else {
      $this->Flash->error(__('The asset could not be deleted. Please, try again.'));
    }

    return $this->redirect(['action' => 'index']);
  }
}
