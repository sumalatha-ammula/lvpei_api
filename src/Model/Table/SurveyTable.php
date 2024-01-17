<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Survey Model
 *
 * @method \App\Model\Entity\Survey newEmptyEntity()
 * @method \App\Model\Entity\Survey newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Survey[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Survey get($primaryKey, $options = [])
 * @method \App\Model\Entity\Survey findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Survey patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Survey[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Survey|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Survey saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Survey[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Survey[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Survey[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Survey[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class SurveyTable extends Table
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

        $this->setTable('survey');
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
            ->scalar('country')
            ->maxLength('country', 255)
            ->requirePresence('country', 'create')
            ->notEmptyString('country');

        $validator
            ->scalar('village')
            ->maxLength('village', 255)
            ->requirePresence('village', 'create')
            ->notEmptyString('village');

        $validator
            ->dateTime('created_on')
            ->notEmptyDateTime('created_on');

        $validator
            ->scalar('created_by')
            ->maxLength('created_by', 255)
            ->requirePresence('created_by', 'create')
            ->notEmptyString('created_by');

        $validator
            ->requirePresence('status', 'create')
            ->notEmptyString('status');

        $validator
            ->requirePresence('field_executive_id', 'create')
            ->notEmptyString('field_executive_id');

        return $validator;
    }
}
