<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Sections Model
 *
 * @property \App\Model\Table\BooksTable|\Cake\ORM\Association\BelongsToMany $Books
 * @property \App\Model\Table\NotesTable|\Cake\ORM\Association\BelongsToMany $Notes
 *
 * @method \App\Model\Entity\Section get($primaryKey, $options = [])
 * @method \App\Model\Entity\Section newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Section[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Section|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Section patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Section[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Section findOrCreate($search, callable $callback = null, $options = [])
 */
class SectionsTable extends AppTable
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

        $this->setTable('sections');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->belongsToMany('Books', [
            'foreignKey' => 'section_id',
            'targetForeignKey' => 'book_id',
            'joinTable' => 'books_sections'
        ]);
        $this->belongsToMany('Notes', [
            'foreignKey' => 'section_id',
            'targetForeignKey' => 'note_id',
            'joinTable' => 'sections_notes'
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
            ->scalar('title')
            ->maxLength('title', 64)
            ->requirePresence('title', 'create')
            ->notEmpty('title');

        $validator
            ->scalar('memo')
            ->maxLength('memo', 128)
            ->allowEmpty('memo');

        $validator
            ->integer('order_no')
            ->requirePresence('order_no', 'create')
            ->notEmpty('order_no');

        return $validator;
    }
}
