<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use App\Model\Table\AssetsTableEx;

/**
* NotesModules Ex Model
*/
class NotesModulesTableEx extends NotesModulesTable
{
  /**
  * 指定されたノートで使用しているモジュールを取得。
  */
  public function getModulesUsedIn($note_id)
  {
    $datas = $this->find()
      ->contain(['Modules'])
      ->order(['NotesModules.order_no'])
      ->where(['note_id' => $note_id]);

    $modules = [];

    foreach($datas as $data){
      $modules[] = $data->module;
    }

    return $modules;
  }

  public function getAssetsUsedIn($note_id)
  {
    $datas = $this->find()
      ->select(['Assets.kind', 'Assets.src'])
      ->join([
        'ModulesAssets' => [
          'table' => 'modules_assets',
          'type'  => 'left',
          'conditions' => 'ModulesAssets.module_id = NotesModules.module_id'
        ],
        'Assets' => [
          'table' => 'assets',
          'type'  => 'left',
          'conditions' => 'ModulesAssets.asset_id = Assets.id'
        ]
      ])
      ->order(['NotesModules.order_no', 'ModulesAssets.order_no'])
      ->where(['NotesModules.note_id' => $note_id]);

    $assets = [];

    foreach($datas as $data) {
      $assets[] = $data->Assets;
    }

    return $assets;
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
    $this->setEntityClass('App\Model\Entity\NotesModuleEx');
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
