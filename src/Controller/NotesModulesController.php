<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * NotesModules Controller
 *
 * @property \App\Model\Table\NotesModulesTable $NotesModules
 *
 * @method \App\Model\Entity\NotesModule[] paginate($object = null, array $settings = [])
 */
class NotesModulesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Notes', 'Modules']
        ];
        $notesModules = $this->paginate($this->NotesModules);

        $this->set(compact('notesModules'));
    }

    /**
     * View method
     *
     * @param string|null $id Notes Module id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $notesModule = $this->NotesModules->get($id, [
            'contain' => ['Notes', 'Modules']
        ]);

        $this->set('notesModule', $notesModule);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $notesModule = $this->NotesModules->newEntity();
        if ($this->request->is('post')) {
            $notesModule = $this->NotesModules->patchEntity($notesModule, $this->request->getData());
            if ($this->NotesModules->save($notesModule)) {
                $this->Flash->success(__('The notes module has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The notes module could not be saved. Please, try again.'));
        }
        $notes = $this->NotesModules->Notes->find('list', ['limit' => 200]);
        $modules = $this->NotesModules->Modules->find('list', ['limit' => 200]);
        $this->set(compact('notesModule', 'notes', 'modules'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Notes Module id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $notesModule = $this->NotesModules->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $notesModule = $this->NotesModules->patchEntity($notesModule, $this->request->getData());
            if ($this->NotesModules->save($notesModule)) {
                $this->Flash->success(__('The notes module has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The notes module could not be saved. Please, try again.'));
        }
        $notes = $this->NotesModules->Notes->find('list', ['limit' => 200]);
        $modules = $this->NotesModules->Modules->find('list', ['limit' => 200]);
        $this->set(compact('notesModule', 'notes', 'modules'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Notes Module id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $notesModule = $this->NotesModules->get($id);
        if ($this->NotesModules->delete($notesModule)) {
            $this->Flash->success(__('The notes module has been deleted.'));
        } else {
            $this->Flash->error(__('The notes module could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
