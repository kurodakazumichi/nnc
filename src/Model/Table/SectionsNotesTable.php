<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SectionsNotes Model
 *
 * @property \App\Model\Table\SectionsTable|\Cake\ORM\Association\BelongsTo $Sections
 * @property \App\Model\Table\NotesTable|\Cake\ORM\Association\BelongsTo $Notes
 *
 * @method \App\Model\Entity\SectionsNote get($primaryKey, $options = [])
 * @method \App\Model\Entity\SectionsNote newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\SectionsNote[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SectionsNote|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SectionsNote patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SectionsNote[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\SectionsNote findOrCreate($search, callable $callback = null, $options = [])
 */
class SectionsNotesTable extends AppTable
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

        $this->setTable('sections_notes');
        $this->setDisplayField('section_id');
        $this->setPrimaryKey(['section_id', 'note_id']);

        $this->belongsTo('Sections', [
            'foreignKey' => 'section_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Notes', [
            'foreignKey' => 'note_id',
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
        $rules->add($rules->existsIn(['section_id'], 'Sections'));
        $rules->add($rules->existsIn(['note_id'], 'Notes'));

        return $rules;
    }
}
