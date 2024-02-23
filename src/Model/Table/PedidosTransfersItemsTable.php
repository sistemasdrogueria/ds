<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PedidosTransfersItems Model
 *
 * @property \App\Model\Table\PedidosTransfersTable|\Cake\ORM\Association\BelongsTo $PedidosTransfers
 * @property \App\Model\Table\ArticulosTable|\Cake\ORM\Association\BelongsTo $Articulos
 * @property \App\Model\Table\CombosTable|\Cake\ORM\Association\BelongsTo $Combos
 * @property \App\Model\Table\PedidosItemsStatusesTable|\Cake\ORM\Association\BelongsTo $PedidosItemsStatuses
 *
 * @method \App\Model\Entity\PedidosTransfersItem get($primaryKey, $options = [])
 * @method \App\Model\Entity\PedidosTransfersItem newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PedidosTransfersItem[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PedidosTransfersItem|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PedidosTransfersItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PedidosTransfersItem[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PedidosTransfersItem findOrCreate($search, callable $callback = null, $options = [])
 */
class PedidosTransfersItemsTable extends Table
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

        $this->setTable('pedidos_transfers_items');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('PedidosTransfers', [
            'foreignKey' => 'pedidos_transfer_id'
        ]);
        $this->belongsTo('Articulos', [
            'foreignKey' => 'articulo_id'
        ]);
        $this->belongsTo('Combos', [
            'foreignKey' => 'combo_id'
        ]);
        $this->belongsTo('PedidosItemsStatuses', [
            'foreignKey' => 'pedidos_items_status_id'
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
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->dateTime('agregado')
            ->allowEmpty('agregado');

        $validator
            ->numeric('cantidad')
            ->allowEmpty('cantidad');

        $validator
            ->numeric('precio_publico')
            ->allowEmpty('precio_publico');

        $validator
            ->numeric('descuento')
            ->allowEmpty('descuento');

        $validator
            ->allowEmpty('unidad_minima');

        $validator
            ->scalar('tipo_precio')
            ->maxLength('tipo_precio', 3)
            ->allowEmpty('tipo_precio');

        $validator
            ->scalar('plazoley_dcto')
            ->maxLength('plazoley_dcto', 30)
            ->allowEmpty('plazoley_dcto');

        $validator
            ->scalar('tipo_oferta')
            ->maxLength('tipo_oferta', 6)
            ->allowEmpty('tipo_oferta');

        $validator
            ->scalar('tipo_oferta_elegida')
            ->maxLength('tipo_oferta_elegida', 6)
            ->allowEmpty('tipo_oferta_elegida');

        $validator
            ->scalar('tipo_fact')
            ->maxLength('tipo_fact', 6)
            ->allowEmpty('tipo_fact');

        $validator
            ->integer('cantidad_facturada')
            ->allowEmpty('cantidad_facturada');

        $validator
            ->integer('nro_pedido_ds')
            ->allowEmpty('nro_pedido_ds');

        $validator
            ->dateTime('procesado')
            ->allowEmpty('procesado');

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
        $rules->add($rules->existsIn(['pedidos_transfer_id'], 'PedidosTransfers'));
        $rules->add($rules->existsIn(['articulo_id'], 'Articulos'));
        $rules->add($rules->existsIn(['combo_id'], 'Combos'));
        $rules->add($rules->existsIn(['pedidos_items_status_id'], 'PedidosItemsStatuses'));

        return $rules;
    }
}
