<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PedidosPreventas Model
 *
 * @property \App\Model\Table\ClientesTable|\Cake\ORM\Association\BelongsTo $Clientes
 * @property \App\Model\Table\SucursalsTable|\Cake\ORM\Association\BelongsTo $Sucursals
 * @property \App\Model\Table\EstadosTable|\Cake\ORM\Association\BelongsTo $Estados
 * @property \App\Model\Table\PedidosStatusesTable|\Cake\ORM\Association\BelongsTo $PedidosStatuses
 *
 * @method \App\Model\Entity\PedidosPreventa get($primaryKey, $options = [])
 * @method \App\Model\Entity\PedidosPreventa newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PedidosPreventa[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PedidosPreventa|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PedidosPreventa patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PedidosPreventa[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PedidosPreventa findOrCreate($search, callable $callback = null, $options = [])
 */
class PedidosPreventasTable extends Table
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

        $this->setTable('pedidos_preventas');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Clientes', [
            'foreignKey' => 'cliente_id'
        ]);
      
			$this->hasMany('PedidosPreventasItems', [
            'foreignKey' => 'pedidos_preventa_id',
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
