<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * SectionsNotes Controller
 *
 * @property \App\Model\Table\SectionsNotesTable $SectionsNotes
 *
 * @method \App\Model\Entity\SectionsNote[] paginate($object = null, array $settings = [])
 */
class SectionsNotesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Sections', 'Notes']
        ];
        $sectionsNotes = $this->paginate($this->SectionsNotes);

        $this->set(compact('sectionsNotes'));
    }

    /**
     * View method
     *
     * @param string|null $id Sections Note id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $sectionsNote = $this->SectionsNotes->get($id, [
            'contain' => ['Sections', 'Notes']
        ]);

        $this->set('sectionsNote', $sectionsNote);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $sectionsNote = $this->SectionsNotes->newEntity();
        if ($this->request->is('post')) {
            $sectionsNote = $this->SectionsNotes->patchEntity($sectionsNote, $this->request->getData());
            if ($this->SectionsNotes->save($sectionsNote)) {
                $this->Flash->success(__('The sections note has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sections note could not be saved. Please, try again.'));
        }
        $sections = $this->SectionsNotes->Sections->find('list', ['limit' => 200]);
        $notes = $this->SectionsNotes->Notes->find('list', ['limit' => 200]);
        $this->set(compact('sectionsNote', 'sections', 'notes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Sections Note id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $sectionsNote = $this->SectionsNotes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $sectionsNote = $this->SectionsNotes->patchEntity($sectionsNote, $this->request->getData());
            if ($this->SectionsNotes->save($sectionsNote)) {
                $this->Flash->success(__('The sections note has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sections note could not be saved. Please, try again.'));
        }
        $sections = $this->SectionsNotes->Sections->find('list', ['limit' => 200]);
        $notes = $this->SectionsNotes->Notes->find('list', ['limit' => 200]);
        $this->set(compact('sectionsNote', 'sections', 'notes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Sections Note id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $sectionsNote = $this->SectionsNotes->get($id);
        if ($this->SectionsNotes->delete($sectionsNote)) {
            $this->Flash->success(__('The sections note has been deleted.'));
        } else {
            $this->Flash->error(__('The sections note could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
