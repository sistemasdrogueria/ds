<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AlfabetaMultidrogas Model
 *
 * @property \App\Model\Table\AlfabetaArticulosTable|\Cake\ORM\Association\BelongsTo $AlfabetaArticulos
 * @property \App\Model\Table\ArticulosTable|\Cake\ORM\Association\BelongsTo $Articulos
 * @property \App\Model\Table\AlfabetaNuevaDrogasTable|\Cake\ORM\Association\BelongsTo $AlfabetaNuevaDrogas
 * @property \App\Model\Table\AlfabetaUnidadPotenciasTable|\Cake\ORM\Association\BelongsTo $AlfabetaUnidadPotencias
 *
 * @method \App\Model\Entity\AlfabetaMultidroga get($primaryKey, $options = [])
 * @method \App\Model\Entity\AlfabetaMultidroga newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\AlfabetaMultidroga[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AlfabetaMultidroga|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AlfabetaMultidroga patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AlfabetaMultidroga[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\AlfabetaMultidroga findOrCreate($search, callable $callback = null, $options = [])
 */
class AlfabetaMultidrogasTable extends Table
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

        $this->setTable('alfabeta_multidrogas');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('AlfabetaArticulos', [
            'foreignKey' => 'alfabeta_articulo_id'
        ]);
        $this->belongsTo('Articulos', [
            'foreignKey' => 'articulo_id'
        ]);
        $this->belongsTo('AlfabetaNuevaDrogas', [
            'foreignKey' => 'alfabeta_nueva_droga_id'
        ]);
        $this->belongsTo('AlfabetaUnidadPotencias', [
            'foreignKey' => 'alfabeta_unidad_potencia_id'
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
        $rules->add($rules->existsIn(['alfabeta_nueva_droga_id'], 'AlfabetaNuevaDrogas'));
        $rules->add($rules->existsIn(['alfabeta_unidad_potencia_id'], 'AlfabetaUnidadPotencias'));

        return $rules;
    }
}
