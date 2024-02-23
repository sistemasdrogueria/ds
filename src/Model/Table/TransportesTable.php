<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Transportes Model
 *
 * @method \App\Model\Entity\Transporte get($primaryKey, $options = [])
 * @method \App\Model\Entity\Transporte newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Transporte[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Transporte|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Transporte patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Transporte[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Transporte findOrCreate($search, callable $callback = null, $options = [])
 */
class TransportesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('transportes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('nombre')
            ->maxLength('nombre', 50)
            ->allowEmpty('nombre');

        return $validator;
    }
}
