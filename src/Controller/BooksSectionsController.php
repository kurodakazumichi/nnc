<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * BooksSections Controller
 *
 * @property \App\Model\Table\BooksSectionsTable $BooksSections
 *
 * @method \App\Model\Entity\BooksSection[] paginate($object = null, array $settings = [])
 */
class BooksSectionsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Books', 'Sections']
        ];
        $booksSections = $this->paginate($this->BooksSections);

        $this->set(compact('booksSections'));
    }

    /**
     * View method
     *
     * @param string|null $id Books Section id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $booksSection = $this->BooksSections->get($id, [
            'contain' => ['Books', 'Sections']
        ]);

        $this->set('booksSection', $booksSection);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $booksSection = $this->BooksSections->newEntity();
        if ($this->request->is('post')) {
            $booksSection = $this->BooksSections->patchEntity($booksSection, $this->request->getData());
            if ($this->BooksSections->save($booksSection)) {
                $this->Flash->success(__('The books section has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The books section could not be saved. Please, try again.'));
        }
        $books = $this->BooksSections->Books->find('list', ['limit' => 200]);
        $sections = $this->BooksSections->Sections->find('list', ['limit' => 200]);
        $this->set(compact('booksSection', 'books', 'sections'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Books Section id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $booksSection = $this->BooksSections->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $booksSection = $this->BooksSections->patchEntity($booksSection, $this->request->getData());
            if ($this->BooksSections->save($booksSection)) {
                $this->Flash->success(__('The books section has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The books section could not be saved. Please, try again.'));
        }
        $books = $this->BooksSections->Books->find('list', ['limit' => 200]);
        $sections = $this->BooksSections->Sections->find('list', ['limit' => 200]);
        $this->set(compact('booksSection', 'books', 'sections'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Books Section id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $booksSection = $this->BooksSections->get($id);
        if ($this->BooksSections->delete($booksSection)) {
            $this->Flash->success(__('The books section has been deleted.'));
        } else {
            $this->Flash->error(__('The books section could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
