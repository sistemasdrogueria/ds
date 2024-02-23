<?php
namespace App\Model\Table;

use App\Model\Entity\Clientesno;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Clientesnos Model
 *
 */
class ClientesnosTable extends Table
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

        $this->table('clientesnos');
        $this->displayField('codigo');
        $this->primaryKey(['codigo', 'sucursal']);

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
            ->add('codigo', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('codigo', 'create');

        $validator
            ->allowEmpty('razon_social');

        $validator
            ->allowEmpty('password');

        $validator
            ->allowEmpty('codigo_postal');

        $validator
            ->add('provincia', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('provincia');

        $validator
            ->allowEmpty('representante');

        $validator
            ->allowEmpty('cambio_clave');

        $validator
            ->add('email', 'valid', ['rule' => 'email'])
            ->allowEmpty('email');

        $validator
            ->add('clave_pedidos', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('clave_pedidos');

        $validator
            ->add('codigo_pedidos', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('codigo_pedidos');

        $validator
            ->allowEmpty('clacli');

        $validator
            ->allowEmpty('e_mail');

        $validator
            ->allowEmpty('domicilio');

        $validator
            ->allowEmpty('provinciatxt');

        $validator
            ->allowEmpty('localidad');

        $validator
            ->add('ofertaxmail', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('ofertaxmail');

        $validator
            ->add('respxmail', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('respxmail');

        $validator
            ->add('sucursal', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('sucursal', 'create');

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
