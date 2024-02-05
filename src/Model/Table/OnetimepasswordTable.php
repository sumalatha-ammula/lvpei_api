<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Onetimepassword Model
 *
 * @method \App\Model\Entity\Onetimepassword newEmptyEntity()
 * @method \App\Model\Entity\Onetimepassword newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Onetimepassword[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Onetimepassword get($primaryKey, $options = [])
 * @method \App\Model\Entity\Onetimepassword findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Onetimepassword patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Onetimepassword[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Onetimepassword|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Onetimepassword saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Onetimepassword[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Onetimepassword[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Onetimepassword[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Onetimepassword[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class OnetimepasswordTable extends Table
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

        $this->setTable('onetimepassword');
        $this->setDisplayField('email');
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
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email');

        $validator
            ->scalar('otp')
            ->maxLength('otp', 200)
            ->requirePresence('otp', 'create')
            ->notEmptyString('otp');

        $validator
            ->dateTime('createdon')
            ->notEmptyDateTime('createdon');

        return $validator;
    }
}
