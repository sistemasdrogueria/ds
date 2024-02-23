<?php
namespace App\Model\Table;

use App\Model\Entity\Sucursal;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Sucursals Model
 */
class SucursalsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('sucursals');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('Clientes', [
            'foreignKey' => 'cliente_id'
        ]);
        $this->belongsTo('Provincias', [
            'foreignKey' => 'provincia_id'
        ]);
        $this->belongsTo('Localidads', [
            'foreignKey' => 'localidad_id'
        ]);
        $this->hasMany('Carritos', [
            'foreignKey' => 'sucursal_id'
        ]);
        $this->hasMany('Pedidos', [
            'foreignKey' => 'sucursal_id'
        ]);
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
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create')
            ->allowEmpty('razon_social')
            ->allowEmpty('cuit')
            ->allowEmpty('nombre')
            ->allowEmpty('codigo_postal')
            ->allowEmpty('domicilio')
            ->allowEmpty('telefono')
            ->add('email', 'valid', ['rule' => 'email'])
            ->allowEmpty('email')
            ->allowEmpty('email_alternativo')
            ->add('clave_pedidos', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('clave_pedidos')
            ->add('codigo_pedidos', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('codigo_pedidos')
            ->add('ofertaxmail', 'valid', ['rule' => 'boolean'])
            ->allowEmpty('ofertaxmail')
            ->add('respuestaxmail', 'valid', ['rule' => 'boolean'])
            ->allowEmpty('respuestaxmail');

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
        $rules->add($rules->existsIn(['cliente_id'], 'Clientes'));
        $rules->add($rules->existsIn(['provincia_id'], 'Provincias'));
        $rules->add($rules->existsIn(['localidad_id'], 'Localidads'));
        return $rules;
    }
}
