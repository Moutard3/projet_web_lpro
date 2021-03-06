<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FormsQuestions Model
 *
 * @property \App\Model\Table\FormsTable&\Cake\ORM\Association\BelongsTo $Forms
 * @property \App\Model\Table\QuestionsTable&\Cake\ORM\Association\BelongsTo $Questions
 *
 * @method \App\Model\Entity\FormsQuestion get($primaryKey, $options = [])
 * @method \App\Model\Entity\FormsQuestion newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\FormsQuestion[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FormsQuestion|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FormsQuestion saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FormsQuestion patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FormsQuestion[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\FormsQuestion findOrCreate($search, callable $callback = null, $options = [])
 */
class FormsQuestionsTable extends Table
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

        $this->setTable('forms_questions');
        $this->setDisplayField('form_id');
        $this->setPrimaryKey(['form_id', 'question_id']);

        $this->belongsTo('Forms', [
            'foreignKey' => 'form_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Questions', [
            'foreignKey' => 'question_id',
            'joinType' => 'INNER',
        ]);
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
        $rules->add($rules->existsIn(['form_id'], 'Forms'));
        $rules->add($rules->existsIn(['question_id'], 'Questions'));

        return $rules;
    }
}
