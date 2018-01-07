<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
* Books Ex Model
*/
class BooksTableEx extends BooksTable
{
  /**
   * Const variables
   */
  const LAYER_TECHNICAL = 0;
  const LAYER_TEACHING  = 1;
  const LAYER_EXERCISE  = 2;

  protected $layers = [
    BooksTableEx::LAYER_TECHNICAL => '技術書',
    BooksTableEx::LAYER_TEACHING  => '教材',
    BooksTableEx::LAYER_EXERCISE  => '問題集'
  ];

  public function getLayers ()
  {
    return $this->layers;
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
    $this->setEntityClass('App\Model\Entity\BookEx');
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
