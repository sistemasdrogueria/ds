<?php
namespace App\Model\Table;

use App\Model\Entity\Articulo;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Articulos Model
 */
class ArticulosTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('articulos');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('Categorias', [
            'foreignKey' => 'categoria_id'
        ]);
        $this->belongsTo('Laboratorios', [
            'foreignKey' => 'laboratorio_id'
        ]);
        $this->belongsTo('Proveedors', [
            'foreignKey' => 'proveedor_id'
        ]);
        $this->belongsTo('Subcategorias', [
            'foreignKey' => 'subcategoria_id'
        ]);
        $this->hasMany('CarritosItems', [
            'foreignKey' => 'articulo_id'
        ]);
		$this->hasMany('Carritos', [
            'foreignKey' => 'articulo_id'
        ]);
        $this->hasMany('CarritosFaltas', [
            'foreignKey' => 'articulo_id'
        ]);

        $this->hasMany('Descuentos', [
            'foreignKey' => 'articulo_id'
        ]);
        $this->hasMany('Ofertas', [
            'foreignKey' => 'articulo_id'
        ]);
        $this->hasMany('PedidosItems', [
            'foreignKey' => 'articulo_id'
        ]);
        $this->hasMany('ReclamosItems', [
            'foreignKey' => 'articulo_id'
        ]);
		 $this->hasMany('CarritosTemps', [
            'foreignKey' => 'articulo_id'
        ]);
		$this->hasMany('Preventas', [
            'foreignKey' => 'articulo_id'
        ]);
		$this->hasMany('CarritosPreventas', [
            'foreignKey' => 'articulo_id'
        ]);
			   $this->hasMany('PedidosPreventasItems', [
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
            ->allowEmpty('troquel')
            ->allowEmpty('descripcion_sist')
            ->allowEmpty('descripcion_pag')
            ->allowEmpty('codigo_barras')
            ->add('precio_publico', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('precio_publico')
            ->add('precio_final', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('precio_final')
            ->allowEmpty('stock')
            ->add('cadena_frio', 'valid', ['rule' => 'boolean'])
            ->allowEmpty('cadena_frio')
            ->add('iva', 'valid', ['rule' => 'boolean'])
            ->allowEmpty('iva')
            ->add('msd', 'valid', ['rule' => 'boolean'])
            ->allowEmpty('msd')
            ->add('clave_amp', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('clave_amp')
            ->add('trazable', 'valid', ['rule' => 'boolean'])
            ->allowEmpty('trazable')
            ->add('pack', 'valid', ['rule' => 'boolean'])
            ->allowEmpty('pack');

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
        $rules->add($rules->existsIn(['categoria_id'], 'Categorias'));
        $rules->add($rules->existsIn(['subcategoria_id'], 'Subcategorias'));
        $rules->add($rules->existsIn(['laboratorio_id'], 'Laboratorios'));
        return $rules;
    }
}
