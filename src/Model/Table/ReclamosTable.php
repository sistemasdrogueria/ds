<?php
namespace App\Model\Table;

use App\Model\Entity\Reclamo;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Reclamos Model
 */
class ReclamosTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('reclamos');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('Clientes', [
            'foreignKey' => 'cliente_id'
        ]);
        $this->belongsTo('ReclamosTipos', [
            'foreignKey' => 'reclamos_tipo_id'
        ]);
        $this->belongsTo('ReclamosEstados', [
            'foreignKey' => 'estado_id'
        ]);
        $this->hasMany('ReclamosItems', [
            'foreignKey' => 'reclamo_id',
            'dependent' => true,
        ]);
        $this->hasMany('ReclamosMensajes', [
            'foreignKey' => 'reclamo_id',
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
            ->add('factura_numero', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('factura_numero')
            ->allowEmpty('observaciones')
            ->add('fecha_recepcion', 'valid', ['rule' => 'datetime'])
            ->allowEmpty('fecha_recepcion');

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
        $rules->add($rules->existsIn(['reclamos_tipo_id'], 'ReclamosTipos'));
        $rules->add($rules->existsIn(['estado_id'], 'ReclamosEstados'));
        return $rules;
    }
}
