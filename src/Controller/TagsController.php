<?php
namespace App\Controller;

use App\Controller\AppController;

/**
* Tags Controller
*
* @property \App\Model\Table\TagsTable $Tags
*
* @method \App\Model\Entity\Tag[] paginate($object = null, array $settings = [])
*/
class TagsController extends AppController
{

  /**
  * Index method
  *
  * @return \Cake\Http\Response|void
  */
  public function index()
  {
    $tags = $this->paginate($this->Tags);

    $this->set(compact('tags'));
  }

  /**
  * View method
  *
  * @param string|null $id Tag id.
  * @return \Cake\Http\Response|void
  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
  */
  public function view($id = null)
  {
    $tag = $this->Tags->get($id, [
      'contain' => ['Notes']
    ]);

    $this->set('tag', $tag);
  }

  /**
  * Add method
  *
  * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
  */
  public function add()
  {
    $tag = $this->Tags
      ->find()
      ->where(['name' => $this->request->getData()["name"]])
      ->first();

    if(!$tag) {
      $tag = $this->Tags->newEntity();
      if ($this->request->is('post')) {
        $tag = $this->Tags->patchEntity($tag, $this->request->getData());
        if (!$this->Tags->save($tag)) {

        }
      }
    }

    $result = ['id' => $tag->id, 'name' => $tag->name];
    $this->outputJsonText($result, "ok");
  }

  /**
  * Edit method
  *
  * @param string|null $id Tag id.
  * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
  * @throws \Cake\Network\Exception\NotFoundException When record not found.
  */
  public function edit($id = null)
  {
    $tag = $this->Tags->get($id, [
      'contain' => ['Notes']
    ]);
    if ($this->request->is(['patch', 'post', 'put'])) {
      $tag = $this->Tags->patchEntity($tag, $this->request->getData());
      if ($this->Tags->save($tag)) {
        $this->Flash->success(__('The tag has been saved.'));

        return $this->redirect(['action' => 'index']);
      }
      $this->Flash->error(__('The tag could not be saved. Please, try again.'));
    }
    $notes = $this->Tags->Notes->find('list', ['limit' => 200]);
    $this->set(compact('tag', 'notes'));
  }

  /**
  * Delete method
  *
  * @param string|null $id Tag id.
  * @return \Cake\Http\Response|null Redirects to index.
  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
  */
  public function delete($id = null)
  {
    $this->request->allowMethod(['post', 'delete']);
    $tag = $this->Tags->get($id);
    if ($this->Tags->delete($tag)) {
      $this->Flash->success(__('The tag has been deleted.'));
    } else {
      $this->Flash->error(__('The tag could not be deleted. Please, try again.'));
    }

    return $this->redirect(['action' => 'index']);
  }


  public function search()
  {
    $tags = $this->Tags->find();
    $tags
    ->select(['Tags.id', 'Tags.name', 'note_count' => $tags->func()->count('NotesTags.tag_id')])
    ->join([
      'NotesTags' => [
        'table' => 'notes_tags',
        'type'  => 'left',
        'conditions' => ['NotesTags.tag_id =Tags.id']
      ]
    ])
    ->group(['Tags.id', 'Tags.name'])
    ->order(['Tags.name']);

    if(isset($this->request->query['name'])){
      $keyword = $this->request->query['name'];
      $tags->where(['name LIKE' => "%$keyword%"]);
    }


    $result = [];

    foreach($tags as $tag) {
      $result[] = ['id' => $tag->id, 'name' => $tag->name, 'count' => $tag->note_count];
    }

    if(empty($result)) {
      $result[] = ['id' => -1, 'name' => $keyword, 'count' => 0];
    }

    $this->outputJsonText($result, "ok");

  }
}
