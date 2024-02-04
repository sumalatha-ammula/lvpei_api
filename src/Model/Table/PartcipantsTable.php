<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Partcipants Model
 *
 * @method \App\Model\Entity\Partcipant newEmptyEntity()
 * @method \App\Model\Entity\Partcipant newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Partcipant[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Partcipant get($primaryKey, $options = [])
 * @method \App\Model\Entity\Partcipant findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Partcipant patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Partcipant[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Partcipant|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Partcipant saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Partcipant[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Partcipant[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Partcipant[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Partcipant[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class PartcipantsTable extends Table
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

        $this->setTable('partcipants');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Survey', [
            'foreignKey' => 'survey_id',
            'joinType'=>'INNER',
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
            ->scalar('name')
            ->maxLength('name', 250)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->allowEmptyString('field_executive_id');

        $validator
            ->allowEmptyString('survey_id');

        $validator
            ->scalar('is_survey')
            ->maxLength('is_survey', 255)
            ->allowEmptyString('is_survey');

        $validator
            ->dateTime('created_on')
            ->notEmptyDateTime('created_on');

        $validator
            ->integer('created_by')
            ->requirePresence('created_by', 'create')
            ->notEmptyString('created_by');

        $validator
            ->scalar('age')
            ->maxLength('age', 32)
            ->requirePresence('age', 'create')
            ->notEmptyString('age');

        $validator
            ->scalar('mobile')
            ->maxLength('mobile', 20)
            ->requirePresence('mobile', 'create')
            ->notEmptyString('mobile');

        $validator
            ->scalar('adharnumber')
            ->maxLength('adharnumber', 200)
            ->requirePresence('adharnumber', 'create')
            ->notEmptyString('adharnumber');

        $validator
            ->scalar('occupation')
            ->maxLength('occupation', 200)
            ->requirePresence('occupation', 'create')
            ->notEmptyString('occupation');

        $validator
            ->scalar('gender')
            ->maxLength('gender', 20)
            ->requirePresence('gender', 'create')
            ->notEmptyString('gender');

        $validator
            ->scalar('status')
            ->maxLength('status', 200)
            ->requirePresence('status', 'create')
            ->notEmptyString('status');

        $validator
            ->requirePresence('monthlyincome', 'create')
            ->notEmptyString('monthlyincome');

        $validator
            ->scalar('country')
            ->maxLength('country', 30)
            ->requirePresence('country', 'create')
            ->notEmptyString('country');

        $validator
            ->scalar('state')
            ->maxLength('state', 33)
            ->requirePresence('state', 'create')
            ->notEmptyString('state');

        $validator
            ->scalar('district')
            ->maxLength('district', 33)
            ->requirePresence('district', 'create')
            ->notEmptyString('district');

        $validator
            ->scalar('education')
            ->maxLength('education', 100)
            ->requirePresence('education', 'create')
            ->notEmptyString('education');

        $validator
            ->integer('idcode')
            ->requirePresence('idcode', 'create')
            ->notEmptyString('idcode');

        $validator
            ->scalar('landmark')
            ->maxLength('landmark', 250)
            ->requirePresence('landmark', 'create')
            ->notEmptyString('landmark');

        $validator
            ->integer('clustercode')
            ->requirePresence('clustercode', 'create')
            ->notEmptyString('clustercode');

        $validator
            ->integer('indiviadualcode')
            ->requirePresence('indiviadualcode', 'create')
            ->notEmptyString('indiviadualcode');

        $validator
            ->integer('unid')
            ->requirePresence('unid', 'create')
            ->notEmptyString('unid');

        $validator
            ->notEmptyString('is_examine');

        $validator
            ->scalar('occupation_others')
            ->maxLength('occupation_others', 255)
            ->allowEmptyString('occupation_others');

        $validator
            ->scalar('education_others')
            ->maxLength('education_others', 255)
            ->allowEmptyString('education_others');

        return $validator;
    }
}
