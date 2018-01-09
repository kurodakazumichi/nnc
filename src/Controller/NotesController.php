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
  * initialize method.
  */
  public function initialize()
  {
    parent::initialize();
    $this->loadModel('NotesModules');
  }

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

    if(!is_null($id)) {
      $this->addRelatedLink(['Notes', 'note', $id], "Public View");
    }

    if(is_null($id)) {
      $note = $this->Notes->newEntity();
    } else {
      $note = $this->Notes->get($id, ['contain' => ['Modules', 'Tags', 'Sections']]);
    }

    if ($this->request->is(['post', 'put'])) {
      $note = $this->Notes->patchEntity($note, $this->request->getData());
      if ($this->Notes->save($note)) {

        $this->Flash->success(__('The note has been saved.'));
        return $this->redirect(['action' => 'edit', $note->id]);
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

  /**
  * カテゴリー別ノート一覧。
  */
  public function notes($category_id = null)
  {
    // 変数定義
    $categories; $datas;

    // 公開中のノートで使用されているカテゴリのリストを取得
    $categories = $this->Notes->getCategoriesUsedIn();

    /**
    * カテゴリIDが指定されている(null以外)場合の事前処理
    * 1.使用されていないカテゴリだった場合はNotFoundの例外を吐き出します。
    * 2.存在するカテゴリであればパンくずメニューにカテゴリへのリンクを追加します。
    */
    if(!is_null($category_id))
    {
      // カテゴリリストに存在しなければNot Found
      if(!array_key_exists($category_id, $categories)) {
        throw new NotFoundException();
      }

      // パンくずを設定。
      $this->addCrumb($categories[$category_id]);

      // 記事を取得
      $datas = $this->Notes->getNotesOfPublic([$category_id]);
    } else {
      $datas = $this->Notes->getNotesOfPublic(array_keys($categories), 20);
    }

    $this->set(compact('datas', 'categories'));
  }

  /**
  * 公開用ノートページ。
  */
  public function note($id)
  {
    // 記事情報を取得
    $note = $this->Notes->getNoteOfPublic($id, $this->isLogin());

    // ノートがなければNot Found
    if(is_null($note)){
      throw new NotFoundException();
    }

    // ログイン中はノートの状態を表示
    if($this->isLogin()) {
      $this->Flash->set($this->Notes->getStatuses()[$note->status]);
    }

    // 関連リンクに編集ページを追加
    if($this->isLogin()) {
      $this->addRelatedLink(['Notes', 'edit', $note->id], 'Edit Note');
    }

    // 記事のパンくずリストをセットアップ。
    $this->addCrumb($note->category->name, ['controller' => 'Notes', 'action' => 'notes', $note->category_id]);
    $this->addCrumb($note->title);

    // モジュールデータを取得
    $modules = $this->NotesModules->getModulesUsedIn($note->id);
    $assets = $this->NotesModules->getAssetsUsedIn($note->id);

    // Viewへセット
    $this->set(compact('note', 'modules'));
    $this->setElementVar("assets", $assets);
  }
}
