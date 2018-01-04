<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Categories Ex Model
 */
class CategoriesTableEx extends CategoriesTable
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
      parent::initialize($config);
      $this->setEntityClass('App\Model\Entity\CategoryEx');
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

    /**
     * order_noの最大値を取得する。
     */
    public function getMaxOrderNo() {
      $query = $this->find();
      $order_no = $query->select(['max' => $query->func()->max('order_no')])->first()->max;
      return $order_no;
    }

    /**
     * 基本のページネーター設定を取得する。
     */
    public function getPaginateConfig()
    {
      $config = [
         'fields'         => ['id', 'name', 'order_no']
        ,'sortWhitelist'  => ['id', 'name', 'order_no']
        ,'join'           => []
        ,'group'          => []
        ,'order'          => ['order_no' => 'asc']
        ,'limit'          => 100
        ,'maxLimit'       => 100
      ];

      return $config;
    }

    /**
     * 関連するNotes, Articles, Booksの件数を表示するためのページネーター設定値を取得。
     */
    public function getPaginateConfigWithRelated()
    {
      $query = $this->query();

      // Notes, Articles, Booksを関連づける設定を追記
      $config = $this->getPaginateConfig();

      // Notes, Articles, Booksのカウント列を追加
      $config['fields'] = array_merge($config['fields'], [
         'note_count'     => $query->func()->count("Notes.id")
        ,'article_count'  => $query->func()->count('Articles.id')
        ,'book_count'     => $query->func()->count('Books.id')
      ]);

      $config['sortWhitelist'] = array_merge($config['sortWhitelist'],[
        'note_count'
      ]);

      // テーブル結合条件
      $config['join'] = array_merge($config['join'], [
        'Notes' => [
          'table' => 'notes',
          'type' => 'left',
          'conditions' => 'notes.category_id = categories.id'
        ],
        'Articles' => [
          'table' => 'articles',
          'type' => 'left',
          'conditions' => 'articles.category_id = categories.id'
        ],
        'Books' => [
          'table' => 'books',
          'type' => 'left',
          'conditions' => 'books.category_id = categories.id'
        ]
      ]);

      // 件数取得のためのgrouping設定
      $config['group'] = array_merge($config['group'], [
        'Categories.id', 'Categories.name', 'Categories.order_no'
      ]);

      return $config;
    }
}
