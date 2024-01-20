<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MasterOptions Model
 *
 * @method \App\Model\Entity\MasterOption newEmptyEntity()
 * @method \App\Model\Entity\MasterOption newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\MasterOption[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MasterOption get($primaryKey, $options = [])
 * @method \App\Model\Entity\MasterOption findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\MasterOption patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MasterOption[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\MasterOption|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MasterOption saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MasterOption[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\MasterOption[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\MasterOption[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\MasterOption[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class MasterOptionsTable extends Table
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

        $this->setTable('master_options');
        $this->setDisplayField('option_value');
        $this->setPrimaryKey('id');

        $this->hasOne('SurveyQuestions', [
            'foreignKey' => 'master_main_id',
        ]);

        $this->belongsTo('MasterMain', [
            'foreignKey' => 'master_main_id',
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
            ->requirePresence('master_main_id', 'create')
            ->notEmptyString('master_main_id');

        $validator
            ->scalar('option_value')
            ->maxLength('option_value', 255)
            ->requirePresence('option_value', 'create')
            ->notEmptyString('option_value');

        $validator
            ->requirePresence('sort', 'create')
            ->notEmptyString('sort');

        $validator
            ->dateTime('created_on')
            ->notEmptyDateTime('created_on');

        $validator
            ->integer('created_by')
            ->requirePresence('created_by', 'create')
            ->notEmptyString('created_by');

        $validator
            ->requirePresence('status', 'create')
            ->notEmptyString('status');

        return $validator;
    }
}
