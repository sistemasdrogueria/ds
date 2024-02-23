<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ClientesAltas Model
 *
 * @method \App\Model\Entity\ClientesAlta get($primaryKey, $options = [])
 * @method \App\Model\Entity\ClientesAlta newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ClientesAlta[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ClientesAlta|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ClientesAlta patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ClientesAlta[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ClientesAlta findOrCreate($search, callable $callback = null, $options = [])
 */
class ClientesAltasTable extends Table
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

        $this->setTable('clientes_altas');
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
            ->scalar('razon_social')
            ->maxLength('razon_social', 50)
            ->requirePresence('razon_social', 'create')
            ->notEmpty('razon_social');

        $validator
            ->scalar('nombre_fantasia')
            ->maxLength('nombre_fantasia', 50)
            ->requirePresence('nombre_fantasia', 'create')
            ->notEmpty('nombre_fantasia');

        $validator
            ->scalar('domicilio')
            ->requirePresence('domicilio', 'create')
            ->notEmpty('domicilio');

        $validator
            ->scalar('localidad')
            ->requirePresence('localidad', 'create')
            ->notEmpty('localidad');

        $validator
            ->scalar('codigo_postal')
            ->requirePresence('codigo_postal', 'create')
            ->add('celular', [
                'length' => [
                'rule' => ['maxLength', 6],
                'message' => 'El número es demasiado largo'
            ]])
            ->notEmpty('codigo_postal');

        $validator
            ->scalar('provincia')
            ->requirePresence('provincia', 'create')
            ->notEmpty('provincia');
/*
        $validator
            ->scalar('telefono')
            ->maxLength('telefono', 15)
            ->allowEmpty('telefono');

        $validator
            ->scalar('celular')
            ->maxLength('celular', 15)
            ->allowEmpty('celular');
*/

            $validator
            ->notEmpty('celular')
            ->requirePresence('celular', 'create')
            ->add('celular', [
                'length' => [
                'rule' => ['minLength', 6],
                'message' => 'El número de telefono es corto'
            ]])
            ->add('celular', 'custom', [
            
                'rule' => function($value, $context) {
                    return (bool) preg_match('/^[0-9\-]+$/', $value);
                    //return preg_match('/^[0-9]+$/', $value);
                    },
                'message' => 'Ingrese un número de telefono'
            ]);
            $validator
            ->notEmpty('telefono')
            ->requirePresence('telefono', 'create')
            ->add('telefono', [
                'length' => [
                'rule' => ['minLength', 2],
                'message' => 'La caracteristica de telefono es corto'
            ]])
            ->add('telefono', 'custom', [
            
                'rule' => function($value, $context) {
                    return (bool) preg_match('/^[0-9\-]+$/', $value);
                    //return preg_match('/^[0-9]+$/', $value);
                    },
                'message' => 'Ingrese un número de caracteristica'
            ]);



        $validator
            ->email('email')
            ->allowEmpty('email');

        $validator
            ->scalar('cuit')
            ->maxLength('cuit', 13)
            ->requirePresence('cuit', 'create')
            ->notEmpty('cuit')
            ->requirePresence('cuit', 'create')
            ->add('cuit', [
                'length' => [
                'rule' => ['minLength', 13],
                'message' => 'El número de CUIT es corto'
            ]])
            ->add('cuit', 'custom', [
            
                'rule' => function($value, $context) {
                    return (bool) preg_match('/^[0-9\-]+$/', $value);
                    //return preg_match('/^[0-9]+$/', $value);
                    },
                'message' => 'Ingrese un número de CUIT'
            ]);

        $validator
            ->scalar('comentario')
            ->allowEmpty('comentario');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['email']));

        return $rules;
    }
}
