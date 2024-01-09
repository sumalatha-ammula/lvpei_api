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
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->requirePresence('fe_id', 'create')
            ->notEmptyString('fe_id');

        $validator
            ->requirePresence('survey_id', 'create')
            ->notEmptyString('survey_id');

        $validator
            ->scalar('is_survey')
            ->maxLength('is_survey', 255)
            ->requirePresence('is_survey', 'create')
            ->notEmptyString('is_survey');

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
            ->maxLength('mobile', 32)
            ->requirePresence('mobile', 'create')
            ->notEmptyString('mobile');

        $validator
            ->scalar('adharnumber')
            ->maxLength('adharnumber', 255)
            ->requirePresence('adharnumber', 'create')
            ->notEmptyString('adharnumber');

        $validator
            ->scalar('occupation')
            ->maxLength('occupation', 255)
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
            ->scalar('monthlyincome')
            ->maxLength('monthlyincome', 255)
            ->requirePresence('monthlyincome', 'create')
            ->notEmptyString('monthlyincome');

        return $validator;
    }
}
