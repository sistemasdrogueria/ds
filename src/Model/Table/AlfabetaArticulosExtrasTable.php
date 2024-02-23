<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AlfabetaArticulosExtras Model
 *
 * @property \App\Model\Table\AlfabetaArticulosTable|\Cake\ORM\Association\BelongsTo $AlfabetaArticulos
 * @property \App\Model\Table\ArticulosTable|\Cake\ORM\Association\BelongsTo $Articulos
 * @property \App\Model\Table\AlfabetaTamanosTable|\Cake\ORM\Association\BelongsTo $AlfabetaTamanos
 * @property \App\Model\Table\AlfabetaAccionFarsTable|\Cake\ORM\Association\BelongsTo $AlfabetaAccionFars
 * @property \App\Model\Table\AlfabetaMonodrogasTable|\Cake\ORM\Association\BelongsTo $AlfabetaMonodrogas
 * @property \App\Model\Table\AlfabetaFormasTable|\Cake\ORM\Association\BelongsTo $AlfabetaFormas
 * @property \App\Model\Table\AlfabetaUnidadPotenciasTable|\Cake\ORM\Association\BelongsTo $AlfabetaUnidadPotencias
 * @property \App\Model\Table\AlfabetaTipoUnidadsTable|\Cake\ORM\Association\BelongsTo $AlfabetaTipoUnidads
 *
 * @method \App\Model\Entity\AlfabetaArticulosExtra get($primaryKey, $options = [])
 * @method \App\Model\Entity\AlfabetaArticulosExtra newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\AlfabetaArticulosExtra[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AlfabetaArticulosExtra|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AlfabetaArticulosExtra patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AlfabetaArticulosExtra[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\AlfabetaArticulosExtra findOrCreate($search, callable $callback = null, $options = [])
 */
class AlfabetaArticulosExtrasTable extends Table
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

        $this->setTable('alfabeta_articulos_extras');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('AlfabetaArticulos', [
            'foreignKey' => 'alfabeta_articulo_id'
        ]);
        $this->belongsTo('Articulos', [
            'foreignKey' => 'articulo_id'
        ]);
        $this->belongsTo('AlfabetaTamanos', [
            'foreignKey' => 'alfabeta_tamano_id'
        ]);
        $this->belongsTo('AlfabetaAccionFars', [
            'foreignKey' => 'alfabeta_accion_far_id'
        ]);
        $this->belongsTo('AlfabetaMonodrogas', [
            'foreignKey' => 'alfabeta_monodroga_id'
        ]);
        $this->belongsTo('AlfabetaFormas', [
            'foreignKey' => 'alfabeta_forma_id'
        ]);
        $this->belongsTo('AlfabetaUnidadPotencias', [
            'foreignKey' => 'alfabeta_unidad_potencia_id'
        ]);
        $this->belongsTo('AlfabetaTipoUnidads', [
            'foreignKey' => 'alfabeta_tipo_unidad_id'
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
            ->scalar('potencia')
            ->maxLength('potencia', 16)
            ->allowEmpty('potencia');

        $validator
            ->integer('alfabeta_vias')
            ->allowEmpty('alfabeta_vias');

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
        $rules->add($rules->existsIn(['alfabeta_articulo_id'], 'AlfabetaArticulos'));
        $rules->add($rules->existsIn(['articulo_id'], 'Articulos'));
        $rules->add($rules->existsIn(['alfabeta_tamano_id'], 'AlfabetaTamanos'));
        $rules->add($rules->existsIn(['alfabeta_accion_far_id'], 'AlfabetaAccionFars'));
        $rules->add($rules->existsIn(['alfabeta_monodroga_id'], 'AlfabetaMonodrogas'));
        $rules->add($rules->existsIn(['alfabeta_forma_id'], 'AlfabetaFormas'));
        $rules->add($rules->existsIn(['alfabeta_unidad_potencia_id'], 'AlfabetaUnidadPotencias'));
        $rules->add($rules->existsIn(['alfabeta_tipo_unidad_id'], 'AlfabetaTipoUnidads'));

        return $rules;
    }
}
