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
