<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Impresoras Model
 *
 * @method \App\Model\Entity\Impresora get($primaryKey, $options = [])
 * @method \App\Model\Entity\Impresora newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Impresora[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Impresora|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Impresora patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Impresora[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Impresora findOrCreate($search, callable $callback = null, $options = [])
 */
class ImpresorasTable extends Table
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

        $this->setTable('impresoras');
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
            ->scalar('modelo')
            ->maxLength('modelo', 100)
            ->allowEmpty('modelo');

        $validator
            ->scalar('marca')
            ->maxLength('marca', 100)
            ->allowEmpty('marca');

        $validator
            ->scalar('sector')
            ->maxLength('sector', 100)
            ->allowEmpty('sector');

        $validator
            ->scalar('ip')
            ->maxLength('ip', 20)
            ->allowEmpty('ip');

        $validator
            ->integer('sistema')
            ->allowEmpty('sistema');

        $validator
            ->dateTime('creado')
            ->allowEmpty('creado');

        $validator
            ->dateTime('modificado')
            ->allowEmpty('modificado');

        return $validator;
    }
}
