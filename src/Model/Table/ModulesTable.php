<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Modules Model
 *
 * @property \App\Model\Table\AssetsTable|\Cake\ORM\Association\BelongsToMany $Assets
 * @property \App\Model\Table\NotesTable|\Cake\ORM\Association\BelongsToMany $Notes
 *
 * @method \App\Model\Entity\Module get($primaryKey, $options = [])
 * @method \App\Model\Entity\Module newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Module[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Module|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Module patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Module[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Module findOrCreate($search, callable $callback = null, $options = [])
 */
class ModulesTable extends AppTable
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

        $this->setTable('modules');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsToMany('Assets', [
            'foreignKey' => 'module_id',
            'targetForeignKey' => 'asset_id',
            'joinTable' => 'modules_assets'
        ]);
        $this->belongsToMany('Notes', [
            'foreignKey' => 'module_id',
            'targetForeignKey' => 'note_id',
            'joinTable' => 'notes_modules'
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
            ->scalar('name')
            ->maxLength('name', 128)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->scalar('prefix_script')
            ->allowEmpty('prefix_script');

        $validator
            ->scalar('postfix_script')
            ->allowEmpty('postfix_script');

        $validator
            ->integer('order_no')
            ->requirePresence('order_no', 'create')
            ->notEmpty('order_no');

        return $validator;
    }
}
