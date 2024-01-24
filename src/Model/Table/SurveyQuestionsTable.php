<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SurveyQuestions Model
 *
 * @property \App\Model\Table\SurveyQuestionsTable&\Cake\ORM\Association\BelongsTo $ParentSurveyQuestions
 * @property \App\Model\Table\SurveyQuestionsTable&\Cake\ORM\Association\HasMany $ChildSurveyQuestions
 *
 * @method \App\Model\Entity\SurveyQuestion newEmptyEntity()
 * @method \App\Model\Entity\SurveyQuestion newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\SurveyQuestion[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SurveyQuestion get($primaryKey, $options = [])
 * @method \App\Model\Entity\SurveyQuestion findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\SurveyQuestion patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SurveyQuestion[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\SurveyQuestion|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SurveyQuestion saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SurveyQuestion[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\SurveyQuestion[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\SurveyQuestion[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\SurveyQuestion[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class SurveyQuestionsTable extends Table
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

        $this->setTable('survey_questions');
        $this->setDisplayField('section');
        $this->setPrimaryKey('id');

        $this->belongsTo('ParentSurveyQuestions', [
            'className' => 'SurveyQuestions',
            'foreignKey' => 'parent_id',
        ]);
        $this->hasMany('ChildSurveyQuestions', [
            'className' => 'SurveyQuestions',
            'foreignKey' => 'parent_id',
        ]);
        $this->belongsTo('MasterMain',[
            // 'className' => 'SurveyQuestions',
            'foreignkey' => 'master_main_id',
            
         ]);
         $this->belongsTo('MasterOptions', [
            'foreignKey' => 'master_main_id',
            'joinType' => 'INNER',
         ]);
        $this->belongsTo('survey', [
           'foreignKey' => 'survey_id',
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
            ->requirePresence('survey_id', 'create')
            ->notEmptyString('survey_id');

        $validator
            ->scalar('section')
            ->maxLength('section', 255)
            ->requirePresence('section', 'create')
            ->notEmptyString('section');

        $validator
            ->scalar('question')
            ->maxLength('question', 255)
            ->requirePresence('question', 'create')
            ->notEmptyString('question');

        $validator
            ->scalar('option_type')
            ->maxLength('option_type', 33)
            ->requirePresence('option_type', 'create')
            ->notEmptyString('option_type');

        $validator
            ->requirePresence('master_main_id', 'create')
            ->notEmptyString('master_main_id');

        $validator
            ->allowEmptyString('parent_id');

        $validator
            ->scalar('show_if')
            ->maxLength('show_if', 255)
            ->allowEmptyString('show_if');

        $validator
            ->dateTime('created_on')
            ->notEmptyDateTime('created_on');

        $validator
            ->integer('created_by')
            ->requirePresence('created_by', 'create')
            ->notEmptyString('created_by');

        $validator
            ->notEmptyString('is_clinical');

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
        $rules->add($rules->existsIn('parent_id', 'ParentSurveyQuestions'), ['errorField' => 'parent_id']);

        return $rules;
    }
}
