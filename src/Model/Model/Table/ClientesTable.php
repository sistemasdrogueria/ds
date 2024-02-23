<?php
namespace App\Model\Table;

use App\Model\Entity\Cliente;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Clientes Model
 */
class ClientesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('clientes');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('Provincias', [
            'foreignKey' => 'provincia_id'
        ]);
        $this->belongsTo('Localidads', [
            'foreignKey' => 'localidad_id'
        ]);
        $this->belongsTo('Representantes', [
            'foreignKey' => 'representante_id'
        ]);
        $this->hasMany('Carritos', [
            'foreignKey' => 'cliente_id'
        ]);
        $this->hasMany('FacturasPedidos', [
            'foreignKey' => 'cliente_id'
        ]);
		$this->hasMany('ClientesCreditos', [
            'foreignKey' => 'cliente_id'
        ]);
        $this->hasMany('LogsAccesos', [
            'foreignKey' => 'cliente_id'
        ]);
        $this->hasMany('Pedidos', [
            'foreignKey' => 'cliente_id'
        ]);
        $this->hasMany('Reclamos', [
            'foreignKey' => 'cliente_id'
        ]);
        $this->hasMany('Sucursals', [
            'foreignKey' => 'cliente_id'
        ]);
        $this->hasMany('Users', [
            'foreignKey' => 'cliente_id'
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
            ->add('codigo', 'valid', ['rule' => 'numeric'])
            ->requirePresence('codigo', 'create')
            ->notEmpty('codigo')
            ->allowEmpty('razon_social')
            ->allowEmpty('cuit')
            ->allowEmpty('nombre')
            ->allowEmpty('codigo_postal')
            ->allowEmpty('domicilio')
            ->allowEmpty('telefono')
            ->add('tienesucursal', 'valid', ['rule' => 'boolean'])
            ->allowEmpty('tienesucursal')
            ->add('email', 'valid', ['rule' => 'email'])
            ->allowEmpty('email')
            ->add('email_alternativo', 'valid', ['rule' => 'email'])
			->allowEmpty('email_alternativo')
			
            ->add('clave_pedidos', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('clave_pedidos')
            ->add('codigo_pedidos', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('codigo_pedidos')
            ->add('ofertaxmail', 'valid', ['rule' => 'boolean'])
            ->allowEmpty('ofertaxmail')
            ->add('respuestaxmail', 'valid', ['rule' => 'boolean'])
            ->allowEmpty('respuestaxmail')
            ->allowEmpty('clacli');

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
