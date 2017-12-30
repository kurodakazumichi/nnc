<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Assets Model
 *
 * @property \App\Model\Table\ModulesTable|\Cake\ORM\Association\BelongsToMany $Modules
 *
 * @method \App\Model\Entity\Asset get($primaryKey, $options = [])
 * @method \App\Model\Entity\Asset newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Asset[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Asset|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Asset patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Asset[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Asset findOrCreate($search, callable $callback = null, $options = [])
 */
class AssetsTable extends AppTable
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

        $this->setTable('assets');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsToMany('Modules', [
            'foreignKey' => 'asset_id',
            'targetForeignKey' => 'module_id',
            'joinTable' => 'modules_assets'
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
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('kind')
            ->maxLength('kind', 1)
            ->requirePresence('kind', 'create')
            ->notEmpty('kind');

        $validator
            ->scalar('memo')
            ->maxLength('memo', 128)
            ->allowEmpty('memo');

        $validator
            ->scalar('src')
            ->maxLength('src', 256)
            ->requirePresence('src', 'create')
            ->notEmpty('src');

        return $validator;
    }
}
