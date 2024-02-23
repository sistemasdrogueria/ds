<?php
namespace App\Model\Table;
use App\Model\Entity\Preventa;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Preventas Model
 *
 * @property \App\Model\Table\ArticulosTable|\Cake\ORM\Association\BelongsTo $Articulos
 * @property \App\Model\Table\CarritosTable|\Cake\ORM\Association\BelongsToMany $Carritos
 * @property \App\Model\Table\PedidosTable|\Cake\ORM\Association\BelongsToMany $Pedidos
 *
 * @method \App\Model\Entity\Preventa get($primaryKey, $options = [])
 * @method \App\Model\Entity\Preventa newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Preventa[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Preventa|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Preventa patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Preventa[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Preventa findOrCreate($search, callable $callback = null, $options = [])
 */
class PreventasTable extends Table
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

        $this->table('preventas');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Articulos', [
            'foreignKey' => 'articulo_id',
            
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
            ->date('fecha_desde')
            ->allowEmpty('fecha_desde');

        $validator
            ->date('fecha_hasta')
            ->allowEmpty('fecha_hasta');

        $validator
            ->scalar('tipo_oferta')
            ->maxLength('tipo_oferta', 2)
            ->allowEmpty('tipo_oferta');

        $validator
            ->scalar('tipo_venta')
            ->maxLength('tipo_venta', 2)
            ->allowEmpty('tipo_venta');

        $validator
            ->scalar('tipo_precio')
            ->maxLength('tipo_precio', 2)
            ->allowEmpty('tipo_precio');

        $validator
            ->integer('uni_min')
            ->allowEmpty('uni_min');

        $validator
            ->integer('uni_max')
            ->allowEmpty('uni_max');

        $validator
            ->integer('uni_tope')
            ->allowEmpty('uni_tope');

        $validator
            ->decimal('dto_drogueria')
            ->allowEmpty('dto_drogueria');

        $validator
            ->scalar('plazo')
            ->maxLength('plazo', 12)
            ->allowEmpty('plazo');

        $validator
            ->scalar('discrimina_iva')
            ->maxLength('discrimina_iva', 1)
            ->allowEmpty('discrimina_iva');

        $validator
            ->integer('chequeo')
            ->allowEmpty('chequeo');

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
        $rules->add($rules->existsIn(['articulo_id'], 'Articulos'));

        return $rules;
    }
}
