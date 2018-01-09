<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
* Notes Ex Model
*/
class NotesTableEx extends NotesTable
{
  /**
  * Const variables
  */
  const STATUS_PRIVATE = 0;
  const STATUS_PUBLIC  = 1;
  const STATUS_FIXING  = 2;

  /**
  * ステータスを定義
  */
  protected $statuses =
  [
    NotesTableEx::STATUS_PRIVATE => '非公開',
    NotesTableEx::STATUS_PUBLIC => '公開',
    NotesTableEx::STATUS_FIXING => '修正中'
  ];

  /**
  * ステータスリストを返す。
  */
  public function getStatuses() {
    return $this->statuses;
  }

  /**
  * ノートで使われているカテゴリリストを取得する。
  * $publicOnly = trueの場合、一般公開されてる記事に限定される。
  */
  public function getCategoriesUsedIn($publicOnly = true)
  {
    $query = $this->find('list', ['keyField' => 'Categories.id', 'valueField' => 'Categories.name'])
      ->contain(['Categories'])
      ->select(['Categories.id', 'Categories.name'])
      ->group('Notes.category_id')
      ->order('Categories.order_no');

    if($publicOnly) {
      $query->where(['Notes.status !=' => NotesTableEx::STATUS_PRIVATE]);
    }
      return $query->toArray();
  }

  /**
  * 公開されているノートを取得する。
  * 管理者の場合は非公開でも取得する。
  */
  public function getNoteOfPublic($id, $isAdmin = false)
  {
    $where = ['Notes.id' => $id];
    if(!$isAdmin) {
      $where['Notes.status !='] = NotesTableEx::STATUS_PRIVATE;
    }

    $article = $this->find()
      ->contain(['Categories'])
      ->where($where);

    return $article->first();
  }
  /**
  * 公開されているノートをカテゴリ別に取得する。
  */
  public function getNotesOfPublic($categories, $limit = 0)
  {
    $notes = [];

    foreach($categories as $category_id) {

      $query = $this
        ->find()
        ->order(['Notes.modified' => 'desc'])
        ->where([
          'Notes.category_id'  => $category_id,
          'Notes.status !='       => NotesTableEx::STATUS_PRIVATE
        ]);

        if(0 < $limit) {
          $query->limit($limit);
        }

        $notes[$category_id] = $query;
    }

    return $notes;
  }

  /**
  * Initialize method
  *
  * @param array $config The configuration for the Table.
  * @return void
  */
  public function initialize(array $config)
  {
    parent::initialize($config);
    $this->setEntityClass('App\Model\Entity\NoteEx');
  }

  /**
  * Default validation rules.
  *
  * @param \Cake\Validation\Validator $validator Validator instance.
  * @return \Cake\Validation\Validator
  */
  public function validationDefault(Validator $validator)
  {
    parent::validationDefault($validator);

    $validator
      ->integer('cateogory_id')
      ->notEmpty('cateogory_id');

    return $validator;
  }

  /**
  * Returns a rules checker object that will be used for validating
  * application integrity.
  *
  * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
  * @return \Cake\ORM\RulesChecker
  */
  public function buildRules(RulesChecker $rules)
  {
    parent::buildRules($rules);
    return $rules;
  }
}
