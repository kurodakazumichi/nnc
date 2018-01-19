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
    $this->gadgets = false;
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
    $this->loadModel('Assets');
    if(is_null($id)) {
      $module = $this->Modules->newEntity();
    } else {
      $module = $this->Modules->get($id, [
        'contain' => ['Assets', 'Notes']
      ]);
    }

    $this->loadModel('ModulesAssets');

    $params = $this->request->getData();

    if ($this->request->is(['patch', 'post', 'put'])) {
      $module = $this->Modules->patchEntity($module, $params);
      if ($this->Modules->save($module)) {

        foreach($params['assets']['_ids'] as $key => $asset_id) {
          $entity = $this->ModulesAssets->find()->where(['ModulesAssets.module_id' => $module->id, 'ModulesAssets.asset_id' => $asset_id])->first();
          $entity = $this->ModulesAssets->patchEntity($entity, ['order_no' => $key]);
          $this->ModulesAssets->save($entity);
        }


        $this->Flash->success(__('The module has been saved.'));

        return $this->redirect(['action' => 'index']);
      }
      $this->Flash->error(__('The module could not be saved. Please, try again.'));
    }
    $assets = $this->ModulesAssets->find()->select(['Assets.id', 'Assets.src'])->Contain('Assets')->where(['ModulesAssets.module_id' => $id])->order(['ModulesAssets.order_no']);
    //$assets = $this->Modules->Assets->find('list', ['valueField' => 'src'])->order(['ModulesAssets.order_no']);
    $asset_kinds = $this->Assets->getKinds();
    $this->set(compact('module', 'assets', 'asset_kinds'));
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
