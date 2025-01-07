<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RespuestasSorteoDiaMadre Model
 *
 * @property \App\Model\Table\ClientesTable|\Cake\ORM\Association\BelongsTo $Clientes
 * @property \App\Model\Table\SorteoDiaMadresTable|\Cake\ORM\Association\BelongsTo $SorteoDiaMadres
 *
 * @method \App\Model\Entity\RespuestasSorteoDiaMadre get($primaryKey, $options = [])
 * @method \App\Model\Entity\RespuestasSorteoDiaMadre newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\RespuestasSorteoDiaMadre[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RespuestasSorteoDiaMadre|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RespuestasSorteoDiaMadre patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\RespuestasSorteoDiaMadre[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\RespuestasSorteoDiaMadre findOrCreate($search, callable $callback = null, $options = [])
 */
class RespuestasSorteoDiaMadreTable extends Table
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
        $this->setTable('respuestas_sorteo_dia_madre');
         $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('Clientes', [
            'foreignKey' => 'cliente_id'
        ]);
        $this->belongsTo('SorteoDiaMadres', [
            'foreignKey' => 'sorteo_dia_madre_id'
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
        $validator->integer('id')->requirePresence('id', 'create')->notEmpty('id');
        $validator->dateTime('creado')->allowEmpty('creado');
        $validator->scalar('texto_generado')->maxLength('texto_generado', 250)->allowEmpty('texto_generado');
        $validator->boolean('participando')->allowEmpty('participando');
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
        $rules->add($rules->existsIn(['sorteo_dia_madre_id'], 'SorteoDiaMadres'));
        return $rules;
    }
}
