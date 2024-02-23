<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AlfabetaArticulos Model
 *
 * @property \App\Model\Table\AlfabetaLaboratoriosTable|\Cake\ORM\Association\BelongsTo $AlfabetaLaboratorios
 * @property \App\Model\Table\AlfabetaCategoriasTable|\Cake\ORM\Association\BelongsTo $AlfabetaCategorias
 * @property \App\Model\Table\AlfabetaTipoVentasTable|\Cake\ORM\Association\BelongsTo $AlfabetaTipoVentas
 * @property \App\Model\Table\ArticulosTable|\Cake\ORM\Association\BelongsTo $Articulos
 * @property \App\Model\Table\AlfabetaArticulosEansTable|\Cake\ORM\Association\HasMany $AlfabetaArticulosEans
 * @property \App\Model\Table\AlfabetaArticulosExtrasTable|\Cake\ORM\Association\HasMany $AlfabetaArticulosExtras
 * @property \App\Model\Table\AlfabetaMultidrogasTable|\Cake\ORM\Association\HasMany $AlfabetaMultidrogas
 *
 * @method \App\Model\Entity\AlfabetaArticulo get($primaryKey, $options = [])
 * @method \App\Model\Entity\AlfabetaArticulo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\AlfabetaArticulo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AlfabetaArticulo|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AlfabetaArticulo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AlfabetaArticulo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\AlfabetaArticulo findOrCreate($search, callable $callback = null, $options = [])
 */
class AlfabetaArticulosTable extends Table
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

        $this->setTable('alfabeta_articulos');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('AlfabetaLaboratorios', [
            'foreignKey' => 'alfabeta_laboratorio_id'
        ]);
        $this->belongsTo('AlfabetaCategorias', [
            'foreignKey' => 'alfabeta_categoria_id'
        ]);
        $this->belongsTo('AlfabetaTipoVentas', [
            'foreignKey' => 'alfabeta_tipo_venta_id'
        ]);
        $this->belongsTo('Articulos', [
            'foreignKey' => 'articulo_id'
        ]);
        $this->hasMany('AlfabetaArticulosEans', [
            'foreignKey' => 'alfabeta_articulo_id'
        ]);
        $this->hasMany('AlfabetaArticulosExtras', [
            'foreignKey' => 'alfabeta_articulo_id'
        ]);
        $this->hasMany('AlfabetaMultidrogas', [
            'foreignKey' => 'alfabeta_articulo_id'
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
            ->scalar('troquel')
            ->maxLength('troquel', 8)
            ->allowEmpty('troquel');

        $validator
            ->scalar('nombre')
            ->maxLength('nombre', 50)
            ->allowEmpty('nombre');

        $validator
            ->scalar('presentacion')
            ->maxLength('presentacion', 24)
            ->allowEmpty('presentacion');

        $validator
            ->numeric('precio')
            ->allowEmpty('precio');

        $validator
            ->dateTime('fecha')
            ->allowEmpty('fecha');

        $validator
            ->boolean('importado')
            ->allowEmpty('importado');

        $validator
            ->boolean('iva')
            ->allowEmpty('iva');

        $validator
            ->boolean('baja')
            ->allowEmpty('baja');

        $validator
            ->scalar('codigo_barra')
            ->maxLength('codigo_barra', 14)
            ->allowEmpty('codigo_barra');

        $validator
            ->integer('unidad')
            ->allowEmpty('unidad');

        $validator
            ->scalar('tamano')
            ->maxLength('tamano', 5)
            ->allowEmpty('tamano');

        $validator
            ->boolean('cadena_frio')
            ->allowEmpty('cadena_frio');

        $validator
            ->integer('chequeo')
            ->allowEmpty('chequeo');

        $validator
            ->scalar('gtin')
            ->maxLength('gtin', 14)
            ->allowEmpty('gtin');

        $validator
            ->allowEmpty('eliminado');

        $validator
            ->dateTime('creado')
            ->allowEmpty('creado');

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
        $rules->add($rules->existsIn(['alfabeta_laboratorio_id'], 'AlfabetaLaboratorios'));
        $rules->add($rules->existsIn(['alfabeta_categoria_id'], 'AlfabetaCategorias'));
        $rules->add($rules->existsIn(['alfabeta_tipo_venta_id'], 'AlfabetaTipoVentas'));
        $rules->add($rules->existsIn(['articulo_id'], 'Articulos'));

        return $rules;
    }
}
