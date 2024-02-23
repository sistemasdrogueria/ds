<?php
namespace App\Model\Table;

use App\Model\Entity\Descuento;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Descuentos Model
 */
class DescuentosTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('descuentos');
        $this->displayField('id');
        $this->primaryKey('id');
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
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create')
            ->add('fecha_desde', 'valid', ['rule' => 'date'])
            ->allowEmpty('fecha_desde')
            ->add('fecha_hasta', 'valid', ['rule' => 'date'])
            ->allowEmpty('fecha_hasta')
            ->add('precio_costo', 'valid', ['rule' => 'decimal'])
            ->allowEmpty('precio_costo')
            ->add('dto_patagonia', 'valid', ['rule' => 'decimal'])
            ->allowEmpty('dto_patagonia')
            ->add('dto_drogueria', 'valid', ['rule' => 'decimal'])
            ->allowEmpty('dto_drogueria')
            ->add('unidadfact', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('unidadfact')
            ->allowEmpty('discrimina_iva');

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
