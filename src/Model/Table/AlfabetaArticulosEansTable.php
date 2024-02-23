<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AlfabetaArticulosEans Model
 *
 * @property \App\Model\Table\AlfabetaArticulosTable|\Cake\ORM\Association\BelongsTo $AlfabetaArticulos
 *
 * @method \App\Model\Entity\AlfabetaArticulosEan get($primaryKey, $options = [])
 * @method \App\Model\Entity\AlfabetaArticulosEan newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\AlfabetaArticulosEan[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AlfabetaArticulosEan|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AlfabetaArticulosEan patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AlfabetaArticulosEan[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\AlfabetaArticulosEan findOrCreate($search, callable $callback = null, $options = [])
 */
class AlfabetaArticulosEansTable extends Table
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

        $this->setTable('alfabeta_articulos_eans');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('AlfabetaArticulos', [
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
            ->scalar('codigo_barra')
            ->maxLength('codigo_barra', 13)
            ->allowEmpty('codigo_barra');

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

        return $rules;
    }
}
