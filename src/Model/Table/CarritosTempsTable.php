<?php
namespace App\Model\Table;

use App\Model\Entity\CarritosTemp;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CarritosTemps Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Clientes
 * @property \Cake\ORM\Association\BelongsTo $Articulos
 * @property \Cake\ORM\Association\BelongsTo $Combos
 */
class CarritosTempsTable extends Table
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

        $this->table('carritos_temps');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Clientes', [
            'foreignKey' => 'cliente_id'
        ]);
        $this->belongsTo('Articulos', [
            'foreignKey' => 'articulo_id'
        ]);
        $this->belongsTo('Combos', [
            'foreignKey' => 'combo_id'
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
            ->allowEmpty('id', 'create');

        $validator
            ->allowEmpty('descripcion');

        $validator
            ->add('cantidad', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('cantidad');

        $validator
            ->add('precio_publico', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('precio_publico');

        $validator
            ->add('descuento', 'valid', ['rule' => 'decimal'])
            ->allowEmpty('descuento');

        $validator
            ->add('unidad_minima', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('unidad_minima');

        $validator
            ->allowEmpty('tipo_precio');

        $validator
            ->allowEmpty('plazoley_dcto');

        $validator
            ->allowEmpty('tipo_oferta');

        $validator
            ->allowEmpty('tipo_oferta_elegida');

        $validator
            ->allowEmpty('tipo_fact');

        $validator
            ->add('creado', 'valid', ['rule' => 'datetime'])
            ->allowEmpty('creado');

        $validator
            ->add('modificado', 'valid', ['rule' => 'datetime'])
            ->allowEmpty('modificado');

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
        $rules->add($rules->existsIn(['combo_id'], 'Combos'));
        return $rules;
    }
}
