<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ModulesAssets Model
 *
 * @property \App\Model\Table\ModulesTable|\Cake\ORM\Association\BelongsTo $Modules
 * @property \App\Model\Table\AssetsTable|\Cake\ORM\Association\BelongsTo $Assets
 *
 * @method \App\Model\Entity\ModulesAsset get($primaryKey, $options = [])
 * @method \App\Model\Entity\ModulesAsset newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ModulesAsset[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ModulesAsset|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ModulesAsset patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ModulesAsset[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ModulesAsset findOrCreate($search, callable $callback = null, $options = [])
 */
class ModulesAssetsTable extends AppTable
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

        $this->setTable('modules_assets');
        $this->setDisplayField('module_id');
        $this->setPrimaryKey(['module_id', 'asset_id']);

        $this->belongsTo('Modules', [
            'foreignKey' => 'module_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Assets', [
            'foreignKey' => 'asset_id',
            'joinType' => 'INNER'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('order_no')
            ->requirePresence('order_no', 'create')
            ->notEmpty('order_no');

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
        $rules->add($rules->existsIn(['module_id'], 'Modules'));
        $rules->add($rules->existsIn(['asset_id'], 'Assets'));

        return $rules;
    }
}
