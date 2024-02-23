<?php
namespace App\Model\Table;

use App\Model\Entity\Oferta;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Ofertas Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Articulos
 * @property \Cake\ORM\Association\BelongsTo $OfertasTipos
 */
class OfertasTable extends Table
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
	    
		//$this->addBehavior('Burzum/Imagine.Imagine');
		
        $this->table('ofertas');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Articulos', [
            'foreignKey' => 'articulo_id'
        ]);
        $this->belongsTo('OfertasTipos', [
            'foreignKey' => 'oferta_tipo_id'
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
            ->allowEmpty('detalle');

        $validator
            ->allowEmpty('busqueda');

        $validator
            ->add('descuento_producto', 'valid', ['rule' => 'decimal'])
            ->allowEmpty('descuento_producto');

        $validator
            ->add('unidades_minimas', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('unidades_minimas');

        $validator
            ->add('fecha_desde', 'valid', ['rule' => 'date'])
            ->allowEmpty('fecha_desde');

        $validator
            ->add('fecha_hasta', 'valid', ['rule' => 'date'])
            ->allowEmpty('fecha_hasta');

        $validator
            ->allowEmpty('plazos');

        $validator
            ->add('unidades_maximas', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('unidades_maximas');

        $validator
            ->allowEmpty('imagen');

        $validator
            ->add('activo', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('activo');

        $validator
            ->add('habilitada', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('habilitada');

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
        $rules->add($rules->existsIn(['oferta_tipo_id'], 'OfertasTipos'));
        return $rules;
    }
}