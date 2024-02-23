<?php
namespace App\Model\Table;

use App\Model\Entity\FacturasCabecera;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FacturasCabeceras Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Clientes
 * @property \Cake\ORM\Association\BelongsTo $Comprobantes
 */
class FacturasCabecerasTable extends Table
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

        $this->table('facturas_cabeceras');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Clientes', [
            'foreignKey' => 'cliente_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Comprobantes', [
            'foreignKey' => 'comprobante_id',
            'joinType' => 'INNER'
        ]);
		$this->hasMany('FacturasCuerposItems', [
            'foreignKey' => 'facturas_encabezados_id',
            'dependent' => true,
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
            ->allowEmpty('id', 'create');

        $validator
            ->add('fecha', 'valid', ['rule' => 'date'])
            ->allowEmpty('fecha');

        $validator
            ->add('pedido_ds', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('pedido_ds');

        $validator
            ->allowEmpty('letra');

        $validator
            ->allowEmpty('pedido_tipo');

        $validator
            ->add('imp_exento', 'valid', ['rule' => 'decimal'])
            ->allowEmpty('imp_exento');

        $validator
            ->add('imp_gravado', 'valid', ['rule' => 'decimal'])
            ->allowEmpty('imp_gravado');

        $validator
            ->add('imp_iva', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('imp_iva');

        $validator
            ->add('imp_rg3337', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('imp_rg3337');

        $validator
            ->add('imp_ingreso_bruto', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('imp_ingreso_bruto');

        $validator
            ->add('total', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('total');

        $validator
            ->add('total_items', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('total_items');

        $validator
            ->add('total_unidades', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('total_unidades');

        $validator
            ->add('estado', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('estado');

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
        $rules->add($rules->existsIn(['comprobante_id'], 'Comprobantes'));
        return $rules;
    }
}
