<?php
namespace App\Model\Table;

use App\Model\Entity\ComprasSemana;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ComprasSemanas Model
 */
class ComprasSemanasTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('compras_semanas');
        $this->displayField('id');
        $this->primaryKey('id');
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
            ->allowEmpty('codigo')
            ->add('numero', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('numero')
            ->add('fecha_factura', 'valid', ['rule' => 'date'])
            ->allowEmpty('fecha_factura')
            ->add('importe', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('importe')
            ->allowEmpty('tipo')
            ->add('fecha_vencimiento', 'valid', ['rule' => 'date'])
            ->allowEmpty('fecha_vencimiento');

        return $validator;
    }
}
