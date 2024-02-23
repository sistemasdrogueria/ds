<?php
namespace App\Model\Table;

use App\Model\Entity\FacturasPedido;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FacturasPedidos Model
 */
class FacturasPedidosTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('facturas_pedidos');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('Clientes', [
            'foreignKey' => 'cliente_id'
        ]);
        $this->belongsTo('Pedidos', [
            'foreignKey' => 'pedido_id'
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
            ->add('pedido_fecha', 'valid', ['rule' => 'date'])
            ->allowEmpty('pedido_fecha')
            ->add('pedido_ds_numero', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('pedido_ds_numero')
            ->allowEmpty('pedido_tipo')
            ->add('envio_numero', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('envio_numero')
            ->add('envio_fecha', 'valid', ['rule' => 'date'])
            ->allowEmpty('envio_fecha')
            ->add('recibido_fecha', 'valid', ['rule' => 'date'])
            ->allowEmpty('recibido_fecha')
            ->allowEmpty('estado')
            ->add('codigo_operadora', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('codigo_operadora')
            ->add('remito_numero', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('remito_numero')
            ->add('factura_numero', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('factura_numero')
            ->add('factura_fecha', 'valid', ['rule' => 'date'])
            ->allowEmpty('factura_fecha')
            ->allowEmpty('factura_tipo_elegida')
            ->allowEmpty('factura_tipo_aplicada')
            ->add('factura_tipo_elegida_descuento', 'valid', ['rule' => 'decimal'])
            ->allowEmpty('factura_tipo_elegida_descuento')
            ->add('factura_tipo_aplicada_descuento', 'valid', ['rule' => 'decimal'])
            ->allowEmpty('factura_tipo_aplicada_descuento')
            ->add('factura_tipo_elegida_vencimiento', 'valid', ['rule' => 'date'])
            ->allowEmpty('factura_tipo_elegida_vencimiento')
            ->add('factura_tipo_aplicada_vencimiento', 'valid', ['rule' => 'date'])
            ->allowEmpty('factura_tipo_aplicada_vencimiento')
            ->allowEmpty('combo')
            ->add('combo_fecha_vigencia', 'valid', ['rule' => 'date'])
            ->allowEmpty('combo_fecha_vigencia')
            ->allowEmpty('mensaje')
            ->allowEmpty('mensaje_pedido')
            ->add('exento_total', 'valid', ['rule' => 'decimal'])
            ->allowEmpty('exento_total')
            ->add('exento_descuento', 'valid', ['rule' => 'decimal'])
            ->allowEmpty('exento_descuento')
            ->add('gravado_total', 'valid', ['rule' => 'decimal'])
            ->allowEmpty('gravado_total')
            ->add('gravado_descuento', 'valid', ['rule' => 'decimal'])
            ->allowEmpty('gravado_descuento')
            ->add('iva', 'valid', ['rule' => 'decimal'])
            ->allowEmpty('iva')
            ->add('perc_rg3337', 'valid', ['rule' => 'decimal'])
            ->allowEmpty('perc_rg3337')
            ->add('ingreso_brutos', 'valid', ['rule' => 'decimal'])
            ->allowEmpty('ingreso_brutos')
            ->add('total', 'valid', ['rule' => 'decimal'])
            ->allowEmpty('total')
            ->add('total_items', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('total_items')
            ->add('total_unidades', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('total_unidades');

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
        $rules->add($rules->existsIn(['pedido_id'], 'Pedidos'));
        return $rules;
    }
}
