<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * NotesTags Model
 *
 * @property \App\Model\Table\NotesTable|\Cake\ORM\Association\BelongsTo $Notes
 * @property \App\Model\Table\TagsTable|\Cake\ORM\Association\BelongsTo $Tags
 *
 * @method \App\Model\Entity\NotesTag get($primaryKey, $options = [])
 * @method \App\Model\Entity\NotesTag newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\NotesTag[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\NotesTag|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\NotesTag patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\NotesTag[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\NotesTag findOrCreate($search, callable $callback = null, $options = [])
 */
class NotesTagsTable extends AppTable
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

        $this->setTable('notes_tags');
        $this->setDisplayField('note_id');
        $this->setPrimaryKey(['note_id', 'tag_id']);

        $this->belongsTo('Notes', [
            'foreignKey' => 'note_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Tags', [
            'foreignKey' => 'tag_id',
            'joinType' => 'INNER'
        ]);
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
        $rules->add($rules->existsIn(['tag_id'], 'Tags'));

        return $rules;
    }
}
