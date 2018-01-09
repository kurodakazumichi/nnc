<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Notes Model
 *
 * @property \App\Model\Table\CategoriesTable|\Cake\ORM\Association\BelongsTo $Categories
 * @property \App\Model\Table\ArticlesTable|\Cake\ORM\Association\HasMany $Articles
 * @property \App\Model\Table\ModulesTable|\Cake\ORM\Association\BelongsToMany $Modules
 * @property \App\Model\Table\TagsTable|\Cake\ORM\Association\BelongsToMany $Tags
 * @property \App\Model\Table\SectionsTable|\Cake\ORM\Association\BelongsToMany $Sections
 *
 * @method \App\Model\Entity\Note get($primaryKey, $options = [])
 * @method \App\Model\Entity\Note newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Note[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Note|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Note patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Note[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Note findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class NotesTable extends AppTable
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

        $this->setTable('notes');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Categories', [
            'foreignKey' => 'category_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Articles', [
            'foreignKey' => 'note_id'
        ]);
        $this->belongsToMany('Modules', [
            'foreignKey' => 'note_id',
            'targetForeignKey' => 'module_id',
            'joinTable' => 'notes_modules'
        ]);
        $this->belongsToMany('Tags', [
            'foreignKey' => 'note_id',
            'targetForeignKey' => 'tag_id',
            'joinTable' => 'notes_tags'
        ]);
        $this->belongsToMany('Sections', [
            'foreignKey' => 'note_id',
            'targetForeignKey' => 'section_id',
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
            ->scalar('memo')
            ->maxLength('memo', 128)
            ->allowEmpty('memo');

        $validator
            ->scalar('title')
            ->maxLength('title', 128)
            ->requirePresence('title', 'create')
            ->notEmpty('title');

        $validator
            ->scalar('body')
            ->requirePresence('body', 'create')
            ->notEmpty('body');

        $validator
            ->scalar('css')
            ->allowEmpty('css');

        $validator
            ->scalar('js')
            ->allowEmpty('js');

        $validator
            ->scalar('search_word')
            ->maxLength('search_word', 45)
            ->allowEmpty('search_word');

        $validator
            ->scalar('description')
            ->maxLength('description', 128)
            ->allowEmpty('description');

        $validator
            ->scalar('status')
            ->maxLength('status', 1)
            ->requirePresence('status', 'create')
            ->notEmpty('status');

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
        $rules->add($rules->existsIn(['category_id'], 'Categories'));

        return $rules;
    }
}
