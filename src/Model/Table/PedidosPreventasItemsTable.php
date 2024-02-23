<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PedidosPreventasItems Model
 *
 * @property \App\Model\Table\PedidosTable|\Cake\ORM\Association\BelongsTo $Pedidos
 * @property \App\Model\Table\ArticulosTable|\Cake\ORM\Association\BelongsTo $Articulos
 * @property \App\Model\Table\CombosTable|\Cake\ORM\Association\BelongsTo $Combos
 * @property \App\Model\Table\PedidosItemsStatusesTable|\Cake\ORM\Association\BelongsTo $PedidosItemsStatuses
 *
 * @method \App\Model\Entity\PedidosPreventasItem get($primaryKey, $options = [])
 * @method \App\Model\Entity\PedidosPreventasItem newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PedidosPreventasItem[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PedidosPreventasItem|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PedidosPreventasItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PedidosPreventasItem[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PedidosPreventasItem findOrCreate($search, callable $callback = null, $options = [])
 */
class PedidosPreventasItemsTable extends Table
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

        $this->setTable('pedidos_preventas_items');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('PedidosPreventas', [
            'foreignKey' => 'pedidos_preventa_id'
        ]);
        $this->belongsTo('Articulos', [
            'foreignKey' => 'articulo_id'
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
            ->maxLength('tipo_precio', 1)
            ->allowEmpty('tipo_precio');

        $validator
            ->scalar('plazoley_dcto')
            ->maxLength('plazoley_dcto', 10)
            ->allowEmpty('plazoley_dcto');

        $validator
            ->scalar('tipo_oferta')
            ->maxLength('tipo_oferta', 2)
            ->allowEmpty('tipo_oferta');

        $validator
            ->scalar('tipo_oferta_elegida')
            ->maxLength('tipo_oferta_elegida', 2)
            ->allowEmpty('tipo_oferta_elegida');

        $validator
            ->scalar('tipo_fact')
            ->maxLength('tipo_fact', 2)
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
        $rules->add($rules->existsIn(['pedidos_preventa_id'], 'PedidosPreventas'));
        $rules->add($rules->existsIn(['articulo_id'], 'Articulos'));

        return $rules;
    }
}
