<?php
namespace App\Model\Table;

use App\Model\Entity\CtactePago;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CtactePagos Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Clientes
 */
class CtactePagosTable extends Table
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

        $this->table('ctacte_pagos');

        $this->belongsTo('Clientes', [
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
            ->requirePresence('id', 'create')
            ->notEmpty('id');

        $validator
            ->allowEmpty('detalle');

        $validator
            ->add('fecha_ingreso', 'valid', ['rule' => 'date'])
            ->allowEmpty('fecha_ingreso');

        $validator
            ->add('fecha_aplicacion', 'valid', ['rule' => 'date'])
            ->allowEmpty('fecha_aplicacion');

        $validator
            ->add('nota', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('nota');

        $validator
            ->add('signo', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('signo');

        $validator
            ->add('importe', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('importe');

        $validator
            ->add('chequeo', 'valid', ['rule' => 'boolean'])
            ->allowEmpty('chequeo');

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
        $rules->add($rules->existsIn(['cliente_id'], 'Clientes'));
        return $rules;
    }
}
