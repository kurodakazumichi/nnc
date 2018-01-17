<?php
namespace App\Controller;

use App\Controller\AppController;


/**
* Categories Controller
*
* @property \App\Model\Table\CategoriesTable $Categories
*
* @method \App\Model\Entity\Category[] paginate($object = null, array $settings = [])
*/
class CategoriesController extends AppController
{
  /**
   * Action list of ajax only.
   */
  protected $ajaxOnlyActions = ["add", "edit", "reorder", "delete"];

  /**
   * before action method
   */
  public function beforeFilter($event) {
    parent::beforeFilter($event);
  }

  /**
  * Index method
  *
  * @return \Cake\Http\Response|void
  */
  public function index()
  {
    $this->gadgets = false;
    
    // カテゴリ一覧取得(ページャー)
    $categories = $this->paginate(
       $this->Categories
      ,$this->Categories->getPaginateConfigWithRelated()
    );

    // 新規登録用Entity
    $category = $this->Categories->newEntity();

    // View設定
    $this->set(compact('categories', 'category'));
  }

  /**
  * Add method
  *
  * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
  */
  public function add ()
  {
    $this->request->allowMethod("post");

    // order_noは最大値+1を取得して設定する。
    $data = $this->request->data;
    $data['order_no'] = $this->Categories->getMaxOrderNo() + 1;

    // 新規レコード作成
    $category = $this->Categories->newEntity();
    $category = $this->Categories->patchEntity($category, $data);

    // 保存
    $this->save($category);
  }

  /**
  * Edit method
  *
  * @param string|null $id Category id.
  * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
  * @throws \Cake\Network\Exception\NotFoundException When record not found.
  */
  public function edit($id = null)
  {
    $this->request->allowMethod(['put']);

    // 更新するのは名称のみとするので、リクエストから名称だけ取得
    $data = ["name" => $this->request->data("name")];

    $category = $this->Categories->get($id);
    $category = $this->Categories->patchEntity($category, $data);

    // 保存
    $this->save($category);
  }



  /**
   * Renumber categories order.
   */
  public function reorder() {
    $this->request->allowMethod(['put']);
    $articles = [];

    $ids = $this->request->getData()['category-id'];
    $no = 0;
    foreach($ids as $id) {
      $category = $this->Categories->get($id);

      $articles[] = $this->Categories->patchEntity($category, ["order_no" => $no++]);

    }

    $this->Categories->getConnection()->transactional(function () use ($articles){
      foreach($articles as $category) {
        $this->Categories->save($category);
      }
    });





    exit;
  }

  /**
  * Delete method
  *
  * @param string|null $id Category id.
  * @return \Cake\Http\Response|null Redirects to index.
  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
  */
  public function delete($id = null)
  {
    $msg = "";
    $this->request->allowMethod(['delete']);
    $category = $this->Categories->get($id);
    if ($this->Categories->delete($category)) {
      $msg = $category->name . "を削除しました。";
    } else {
      $msg = "エラーが発生し、削除できませんでした。";
    }

    $this->outputSimpleText($msg);
  }


  // Category Entityの保存
  private function save($category)
  {
    // 想定されるエラーチェック
    if($category->getError("name")) {
      $errors = $category->getError("name");
      $this->outputJsonText(array_shift($errors), "error");
      return;
    }

    // 保存
    if($this->Categories->save($category)) {
      $this->outputJsonText($category->name, "ok");
    } else {
      $this->outputJsonText(__('システムエラー'), "error");
    }
  }
}
