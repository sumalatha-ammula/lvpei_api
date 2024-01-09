<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MasterMain Model
 *
 * @method \App\Model\Entity\MasterMain newEmptyEntity()
 * @method \App\Model\Entity\MasterMain newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\MasterMain[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MasterMain get($primaryKey, $options = [])
 * @method \App\Model\Entity\MasterMain findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\MasterMain patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MasterMain[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\MasterMain|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MasterMain saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MasterMain[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\MasterMain[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\MasterMain[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\MasterMain[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class MasterMainTable extends Table
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

        $this->setTable('master_main');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('SurveyQuestions',[
            'foreignkey' => 'id',
            'joinType' => 'INNER',
         ]);
         
        $this->hasMany('MasterOptions',[
            'foreignkey' => 'id',
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
            ->scalar('name')
            ->maxLength('name', 200)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->dateTime('created_on')
            ->notEmptyDateTime('created_on');

        $validator
            ->requirePresence('status', 'create')
            ->notEmptyString('status');

        $validator
            ->requirePresence('created_by', 'create')
            ->notEmptyString('created_by');

        return $validator;
    }
}
