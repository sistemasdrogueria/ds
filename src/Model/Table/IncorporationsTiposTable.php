<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * IncorporationsTipos Model
 *
 * @method \App\Model\Entity\IncorporationsTipo get($primaryKey, $options = [])
 * @method \App\Model\Entity\IncorporationsTipo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\IncorporationsTipo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\IncorporationsTipo|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\IncorporationsTipo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\IncorporationsTipo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\IncorporationsTipo findOrCreate($search, callable $callback = null, $options = [])
 */
class IncorporationsTiposTable extends Table
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

        $this->setTable('incorporations_tipos');
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
            ->maxLength('nombre', 40)
            ->requirePresence('nombre', 'create')
            ->notEmpty('nombre');

        return $validator;
    }
}
