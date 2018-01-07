<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
* Assets Ex Model
*/
class AssetsTableEx extends AssetsTable
{
  /**
  * Const variables
  */
  const KIND_JS  = 0;
  const KIND_CSS = 1;

  protected $kinds = [
    AssetsTableEx::KIND_JS  => 'javascript',
    AssetsTableEx::KIND_CSS => 'css'
  ];

  public function getKinds($addEmpty = false)
  {
    $kinds = $this->kinds;
    if($addEmpty) {
      $kinds = array_merge([""], $kinds);
    }
    return $kinds;
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
    $this->setEntityClass("App\Model\Entity\AssetEx");
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
