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

  /**
  * 指定されたレイヤーに所属する記事で使われているカテゴリリストを取得する。
  * $publicOnly = trueの場合、一般公開されてる記事に限定される。
  */
  public function getCategoriesUsedIn($layer, $publicOnly = true)
  {
    // where条件を定義
    $where = ['Articles.layer' => $layer];
    if($publicOnly) {
      $where['Articles.published'] = true;
      $where['Notes.status !='] = NotesTableEx::STATUS_PRIVATE;
    }

    return $this->find('list', ['keyField' => 'Categories.id', 'valueField' => 'Categories.name'])
      ->contain(['Notes', 'Categories'])
      ->where($where)
      ->select(['Categories.id', 'Categories.name'])
      ->group('Articles.category_id')
      ->order('Categories.order_no')
      ->toArray();
  }

  /**
  * 指定された条件で一般公開されている記事を取得する。
  * 一致するものがなかった場合はnullを返却する。
  */
  public function getArticleOfPublic($layer, $id)
  {
    $article = $this->find()
      ->contain(['Notes', 'Categories'])
      ->where([
        'Articles.layer'      => $layer,
        'Articles.id'         => $id,
        'Articles.published'  => true,
        'Notes.status !='     => NotesTableEx::STATUS_PRIVATE
      ]);

    return $article->first();
  }

  public function getArticlesOfPublic($layer, $categories, $limit = 0)
  {
    $articles = [];

    foreach($categories as $category_id) {

      $query = $this
        ->find()
        ->contain('Notes')
        ->order(['Notes.modified' => 'desc'])
        ->where([
          'Articles.layer'        => $layer,
          'Articles.category_id'  => $category_id,
          'Articles.published'    => true,
          'Notes.status !='       => NotesTableEx::STATUS_PRIVATE
        ]);

        if(0 < $limit) {
          $query->limit($limit);
        }

        $articles[$category_id] = $query;
    }

    return $articles;
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
