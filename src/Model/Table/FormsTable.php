<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Forms Model
 *
 * @property \App\Model\Table\QuestionsTable&\Cake\ORM\Association\BelongsToMany $Questions
 * @property \App\Model\Table\StudentAnswersTable&\Cake\ORM\Association\HasMany $StudentAnswers
 * @property \App\Model\Table\StudentResultsTable&\Cake\ORM\Association\HasMany $StudentResults
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\Form get($primaryKey, $options = [])
 * @method \App\Model\Entity\Form newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Form[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Form|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Form saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Form patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Form[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Form findOrCreate($search, callable $callback = null, $options = [])
 */
class FormsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('forms');
        $this->setDisplayField('display_name');
        $this->setPrimaryKey('id');

        $this->belongsToMany('Questions', [
            'foreignKey' => 'form_id',
            'through' => 'FormsQuestions',
        ]);
        $this->hasMany('StudentAnswers', [
            'foreignKey' => 'form_id',
        ]);
        $this->hasMany('StudentResults', [
            'foreignKey' => 'form_id',
        ]);

        $this->belongsTo('Users', [
            'foreignKey' => 'created_by',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->nonNegativeInteger('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->integer('created_by')
            ->requirePresence('created_by', 'create')
            ->notEmptyString('created_by');

        $validator
            ->scalar('display_name')
            ->maxLength('display_name', 255)
            ->requirePresence('display_name', 'create')
            ->notEmptyString('display_name');

        $validator
            ->boolean('active')
            ->requirePresence('active', 'create')
            ->notEmptyString('active');

        $validator
            ->date('closed_on')
            ->requirePresence('closed_on', 'create')
            ->allowEmptyDateTime('closed_on');

        return $validator;
    }
}
