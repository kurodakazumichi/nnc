<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * NotesModules Model
 *
 * @property \App\Model\Table\NotesTable|\Cake\ORM\Association\BelongsTo $Notes
 * @property \App\Model\Table\ModulesTable|\Cake\ORM\Association\BelongsTo $Modules
 *
 * @method \App\Model\Entity\NotesModule get($primaryKey, $options = [])
 * @method \App\Model\Entity\NotesModule newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\NotesModule[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\NotesModule|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\NotesModule patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\NotesModule[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\NotesModule findOrCreate($search, callable $callback = null, $options = [])
 */
class NotesModulesTable extends AppTable
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

        $this->setTable('notes_modules');
        $this->setDisplayField('note_id');
        $this->setPrimaryKey(['note_id', 'module_id']);

        $this->belongsTo('Notes', [
            'foreignKey' => 'note_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Modules', [
            'foreignKey' => 'module_id',
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
        $rules->add($rules->existsIn(['note_id'], 'Notes'));
        $rules->add($rules->existsIn(['module_id'], 'Modules'));

        return $rules;
    }
}
