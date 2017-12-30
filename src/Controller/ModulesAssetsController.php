<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ModulesAssets Controller
 *
 * @property \App\Model\Table\ModulesAssetsTable $ModulesAssets
 *
 * @method \App\Model\Entity\ModulesAsset[] paginate($object = null, array $settings = [])
 */
class ModulesAssetsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Modules', 'Assets']
        ];
        $modulesAssets = $this->paginate($this->ModulesAssets);

        $this->set(compact('modulesAssets'));
    }

    /**
     * View method
     *
     * @param string|null $id Modules Asset id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $modulesAsset = $this->ModulesAssets->get($id, [
            'contain' => ['Modules', 'Assets']
        ]);

        $this->set('modulesAsset', $modulesAsset);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $modulesAsset = $this->ModulesAssets->newEntity();
        if ($this->request->is('post')) {
            $modulesAsset = $this->ModulesAssets->patchEntity($modulesAsset, $this->request->getData());
            if ($this->ModulesAssets->save($modulesAsset)) {
                $this->Flash->success(__('The modules asset has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The modules asset could not be saved. Please, try again.'));
        }
        $modules = $this->ModulesAssets->Modules->find('list', ['limit' => 200]);
        $assets = $this->ModulesAssets->Assets->find('list', ['limit' => 200]);
        $this->set(compact('modulesAsset', 'modules', 'assets'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Modules Asset id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $modulesAsset = $this->ModulesAssets->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $modulesAsset = $this->ModulesAssets->patchEntity($modulesAsset, $this->request->getData());
            if ($this->ModulesAssets->save($modulesAsset)) {
                $this->Flash->success(__('The modules asset has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The modules asset could not be saved. Please, try again.'));
        }
        $modules = $this->ModulesAssets->Modules->find('list', ['limit' => 200]);
        $assets = $this->ModulesAssets->Assets->find('list', ['limit' => 200]);
        $this->set(compact('modulesAsset', 'modules', 'assets'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Modules Asset id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $modulesAsset = $this->ModulesAssets->get($id);
        if ($this->ModulesAssets->delete($modulesAsset)) {
            $this->Flash->success(__('The modules asset has been deleted.'));
        } else {
            $this->Flash->error(__('The modules asset could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
