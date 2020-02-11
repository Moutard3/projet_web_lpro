<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * StudentResults Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\FormsTable&\Cake\ORM\Association\BelongsTo $Forms
 *
 * @method \App\Model\Entity\StudentResult get($primaryKey, $options = [])
 * @method \App\Model\Entity\StudentResult newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\StudentResult[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\StudentResult|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\StudentResult saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\StudentResult patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\StudentResult[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\StudentResult findOrCreate($search, callable $callback = null, $options = [])
 */
class StudentResultsTable extends Table
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

        $this->setTable('student_results');
        $this->setDisplayField('user_id');
        $this->setPrimaryKey(['user_id', 'form_id']);

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Forms', [
            'foreignKey' => 'form_id',
            'joinType' => 'INNER',
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
            ->numeric('result')
            ->requirePresence('result', 'create')
            ->notEmptyString('result');

        $validator
            ->boolean('published')
            ->requirePresence('published', 'create')
            ->notEmptyString('published');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['form_id'], 'Forms'));

        return $rules;
    }
}
