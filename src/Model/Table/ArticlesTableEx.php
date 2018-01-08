<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
* Articles Ex Model
*/
class ArticlesTableEx extends ArticlesTable
{
  /**
  * Const variables
  */
  const LAYER_MEMO = 0;
  const LAYER_BLOG  = 1;

  /**
  * レイヤー定義
  */
  protected $layers =
  [
    ArticlesTableEx::LAYER_MEMO => 'メモ',
    ArticlesTableEx::LAYER_BLOG => 'ブログ'
  ];

  /**
  * レイヤーリストを返す。
  */
  public function getLayers() {
    return $this->layers;
  }

  public function getCategoriesUsedIn($layer)
  {
    return $this->find('list', ['keyField' => 'Categories.id', 'valueField' => 'Categories.name'])
      ->contain(['Categories'])
      ->where(['Articles.layer' => $layer])
      ->select(['Categories.id', 'Categories.name'])
      ->group('Articles.category_id')
      ->order('Categories.order_no')
      ->toArray();
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
    $this->setEntityClass('App\Model\Entity\ArticleEx');
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
