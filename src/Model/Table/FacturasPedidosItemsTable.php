<?php
namespace App\Model\Table;

use App\Model\Entity\FacturasPedidosItem;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FacturasPedidosItems Model
 */
class FacturasPedidosItemsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('facturas_pedidos_items');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('FacturasPedidos', [
            'foreignKey' => 'facturas_pedido_id'
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
            ->add('nro_envio', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('nro_envio')
            ->allowEmpty('troquel')
            ->allowEmpty('descripcion')
            ->add('cantidad_pedida', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('cantidad_pedida')
            ->add('cantidad_facturada', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('cantidad_facturada')
            ->add('precio_facturado', 'valid', ['rule' => 'decimal'])
            ->allowEmpty('precio_facturado')
            ->add('desc_aplicado', 'valid', ['rule' => 'decimal'])
            ->allowEmpty('desc_aplicado')
            ->allowEmpty('estado_stock')
            ->add('nro_pedido_dsur', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('nro_pedido_dsur');

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
        $rules->add($rules->existsIn(['facturas_pedido_id'], 'FacturasPedidos'));
        return $rules;
    }
}
