<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CarritosPreventas Model
 *
 * @property \App\Model\Table\ClientesTable|\Cake\ORM\Association\BelongsTo $Clientes
 * @property \App\Model\Table\ArticulosTable|\Cake\ORM\Association\BelongsTo $Articulos
 * @property \App\Model\Table\CombosTable|\Cake\ORM\Association\BelongsTo $Combos
 * @property \App\Model\Table\CategoriasTable|\Cake\ORM\Association\BelongsTo $Categorias
 *
 * @method \App\Model\Entity\CarritosPreventa get($primaryKey, $options = [])
 * @method \App\Model\Entity\CarritosPreventa newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CarritosPreventa[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CarritosPreventa|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CarritosPreventa patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CarritosPreventa[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CarritosPreventa findOrCreate($search, callable $callback = null, $options = [])
 */
class CarritosPreventasTable extends Table
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
/*
        $this->setTable('carritos_preventas');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Clientes', [
            'foreignKey' => 'cliente_id'
        ]);
        $this->belongsTo('Articulos', [
            'foreignKey' => 'articulo_id'
        ]);*/
    $this->table('carritos_preventas');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('Clientes', [
            'foreignKey' => 'cliente_id'
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
            ->scalar('descripcion')
            ->maxLength('descripcion', 150)
            ->allowEmpty('descripcion');

        $validator
            ->integer('cantidad')
            ->allowEmpty('cantidad');

        $validator
            ->numeric('precio_publico')
            ->allowEmpty('precio_publico');

        $validator
            ->decimal('descuento')
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
            ->dateTime('creado')
            ->allowEmpty('creado');

        $validator
            ->dateTime('modificado')
            ->allowEmpty('modificado');

        $validator
            ->integer('compra_min')
            ->allowEmpty('compra_min');

        $validator
            ->integer('compra_multiplo')
            ->allowEmpty('compra_multiplo');

        $validator
            ->integer('compra_max')
            ->allowEmpty('compra_max');

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
        $rules->add($rules->existsIn(['articulo_id'], 'Articulos'));

        //$rules->add($rules->existsIn(['categoria_id'], 'Categorias'));

        return $rules;
    }
}
