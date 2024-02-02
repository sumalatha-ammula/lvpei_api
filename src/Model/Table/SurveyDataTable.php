<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SurveyData Model
 *
 * @property \App\Model\Table\SurveyQuestionsTable&\Cake\ORM\Association\BelongsTo $SurveyQuestions
 * @property \App\Model\Table\PartcipantsTable&\Cake\ORM\Association\BelongsTo $Partcipants
 *
 * @method \App\Model\Entity\SurveyData newEmptyEntity()
 * @method \App\Model\Entity\SurveyData newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\SurveyData[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SurveyData get($primaryKey, $options = [])
 * @method \App\Model\Entity\SurveyData findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\SurveyData patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SurveyData[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\SurveyData|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SurveyData saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SurveyData[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\SurveyData[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\SurveyData[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\SurveyData[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class SurveyDataTable extends Table
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

        $this->setTable('survey_data');
        $this->setDisplayField('geo_location');
        $this->setPrimaryKey('id');

        $this->belongsTo('SurveyQuestions', [
            'foreignKey' => 'survey_questions_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Partcipants', [
            'foreignKey' => 'partcipants_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Survey', [
            'foreignKey' => 'survey_id',
            'joinType' => 'INNER',
        ]);

        $this->belongsTo('MasterOptions', [
            'foreignKey' => 'option_data',
            'joinType' => 'INNER',
      ]);

        $this->belongsTo('FieldExecutive', [
            'foreignKey' => 'field_executive_id',
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
            ->notEmptyString('survey_questions_id');

        $validator
            ->requirePresence('field_executive_id', 'create')
            ->notEmptyString('field_executive_id');

        $validator
            ->dateTime('datetime')
            ->notEmptyDateTime('datetime');

        $validator
            ->scalar('geo_location')
            ->maxLength('geo_location', 255)
            ->requirePresence('geo_location', 'create')
            ->notEmptyString('geo_location');

        $validator
            ->scalar('question')
            ->maxLength('question', 255)
            ->allowEmptyString('question');

        $validator
            ->scalar('option_data')
            ->maxLength('option_data', 255)
            ->requirePresence('option_data', 'create')
            ->allowEmptyString('option_data');

        $validator
            ->dateTime('sync_time')
            ->notEmptyDateTime('sync_time');

        $validator
            ->scalar('partcipants_id')
            ->notEmptyString('partcipants_id');

        $validator
            ->integer('unid')
            ->requirePresence('unid', 'create')
            ->notEmptyString('unid');

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
        $rules->add($rules->existsIn('survey_questions_id', 'SurveyQuestions'), ['errorField' => 'survey_questions_id']);
        $rules->add($rules->existsIn('partcipants_id', 'Partcipants'), ['errorField' => 'partcipants_id']);

        return $rules;
    }
}
