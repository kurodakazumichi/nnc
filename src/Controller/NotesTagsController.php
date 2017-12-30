<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * NotesTags Controller
 *
 * @property \App\Model\Table\NotesTagsTable $NotesTags
 *
 * @method \App\Model\Entity\NotesTag[] paginate($object = null, array $settings = [])
 */
class NotesTagsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Notes', 'Tags']
        ];
        $notesTags = $this->paginate($this->NotesTags);

        $this->set(compact('notesTags'));
    }

    /**
     * View method
     *
     * @param string|null $id Notes Tag id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $notesTag = $this->NotesTags->get($id, [
            'contain' => ['Notes', 'Tags']
        ]);

        $this->set('notesTag', $notesTag);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $notesTag = $this->NotesTags->newEntity();
        if ($this->request->is('post')) {
            $notesTag = $this->NotesTags->patchEntity($notesTag, $this->request->getData());
            if ($this->NotesTags->save($notesTag)) {
                $this->Flash->success(__('The notes tag has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The notes tag could not be saved. Please, try again.'));
        }
        $notes = $this->NotesTags->Notes->find('list', ['limit' => 200]);
        $tags = $this->NotesTags->Tags->find('list', ['limit' => 200]);
        $this->set(compact('notesTag', 'notes', 'tags'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Notes Tag id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $notesTag = $this->NotesTags->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $notesTag = $this->NotesTags->patchEntity($notesTag, $this->request->getData());
            if ($this->NotesTags->save($notesTag)) {
                $this->Flash->success(__('The notes tag has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The notes tag could not be saved. Please, try again.'));
        }
        $notes = $this->NotesTags->Notes->find('list', ['limit' => 200]);
        $tags = $this->NotesTags->Tags->find('list', ['limit' => 200]);
        $this->set(compact('notesTag', 'notes', 'tags'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Notes Tag id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $notesTag = $this->NotesTags->get($id);
        if ($this->NotesTags->delete($notesTag)) {
            $this->Flash->success(__('The notes tag has been deleted.'));
        } else {
            $this->Flash->error(__('The notes tag could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
