<?php
namespace App\Model\Table;

use App\Model\Entity\CarritosItem;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CarritosItems Model
 */
class CarritosItemsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('carritos_items');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('Carritos', [
            'foreignKey' => 'carrito_id'
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
            ->add('agregado', 'valid', ['rule' => 'date'])
            ->allowEmpty('agregado')
            ->add('cantidad', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('cantidad')
            ->add('precio_publico', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('precio_publico')
            ->add('descuento', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('descuento')
            ->add('unidad_minima', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('unidad_minima')
            ->allowEmpty('tipo_precio')
            ->allowEmpty('plazoley_dcto')
            ->allowEmpty('tipo_oferta')
            ->allowEmpty('tipo_oferta_elegida')
            ->allowEmpty('tipo_fact');

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
        $rules->add($rules->existsIn(['carrito_id'], 'Carritos'));
        $rules->add($rules->existsIn(['articulo_id'], 'Articulos'));
        $rules->add($rules->existsIn(['combo_id'], 'Combos'));
        return $rules;
    }
}
