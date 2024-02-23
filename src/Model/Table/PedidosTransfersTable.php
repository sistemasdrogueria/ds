<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PedidosTransfers Model
 *
 * @property \App\Model\Table\ClientesTable|\Cake\ORM\Association\BelongsTo $Clientes
 * @property \App\Model\Table\SucursalsTable|\Cake\ORM\Association\BelongsTo $Sucursals
 * @property \App\Model\Table\EstadosTable|\Cake\ORM\Association\BelongsTo $Estados
 * @property \App\Model\Table\PedidosStatusesTable|\Cake\ORM\Association\BelongsTo $PedidosStatuses
 * @property \App\Model\Table\ProveedorsTable|\Cake\ORM\Association\BelongsTo $Proveedors
 * @property \App\Model\Table\PedidosTrasnfersItemsTable|\Cake\ORM\Association\HasMany $PedidosTrasnfersItems
 *
 * @method \App\Model\Entity\PedidosTransfer get($primaryKey, $options = [])
 * @method \App\Model\Entity\PedidosTransfer newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PedidosTransfer[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PedidosTransfer|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PedidosTransfer patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PedidosTransfer[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PedidosTransfer findOrCreate($search, callable $callback = null, $options = [])
 */
class PedidosTransfersTable extends Table
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

        $this->setTable('pedidos_transfers');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Clientes', [
            'foreignKey' => 'cliente_id'
        ]);
        $this->belongsTo('Sucursals', [
            'foreignKey' => 'sucursal_id'
        ]);
        $this->belongsTo('Estados', [
            'foreignKey' => 'estado_id'
        ]);
        $this->belongsTo('PedidosStatus', [
            'foreignKey' => 'pedidos_status_id'
        ]);
        $this->belongsTo('Proveedors', [
            'foreignKey' => 'proveedor_id'
        ]);
        $this->hasMany('PedidosTrasnfersItems', [
            'foreignKey' => 'pedidos_transfer_id'
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
            ->dateTime('creado')
            ->allowEmpty('creado');

        $validator
            ->scalar('tipo_fact')
            ->maxLength('tipo_fact', 2)
            ->allowEmpty('tipo_fact');

        $validator
            ->integer('forma_envio')
            ->allowEmpty('forma_envio');

        $validator
            ->scalar('comentario')
            ->maxLength('comentario', 40)
            ->allowEmpty('comentario');

        $validator
            ->scalar('oferta_plazo')
            ->maxLength('oferta_plazo', 16)
            ->allowEmpty('oferta_plazo');

        $validator
            ->integer('nro_pedido_ds')
            ->allowEmpty('nro_pedido_ds');

        $validator
            ->integer('cantidad_item')
            ->allowEmpty('cantidad_item');

        $validator
            ->dateTime('procesado')
            ->allowEmpty('procesado');

        $validator
            ->allowEmpty('impreso');

        $validator
            ->boolean('finalizado')
            ->allowEmpty('finalizado');

        $validator
            ->integer('transfer')
            ->allowEmpty('transfer');

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
        $rules->add($rules->existsIn(['sucursal_id'], 'Sucursals'));
        $rules->add($rules->existsIn(['estado_id'], 'Estados'));
        $rules->add($rules->existsIn(['pedidos_status_id'], 'PedidosStatus'));
        $rules->add($rules->existsIn(['proveedor_id'], 'Proveedors'));

        return $rules;
    }
}
