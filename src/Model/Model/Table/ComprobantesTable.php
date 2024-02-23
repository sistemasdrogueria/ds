<?php
namespace App\Model\Table;

use App\Model\Entity\Comprobante;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Comprobantes Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Clientes
 * @property \Cake\ORM\Association\BelongsTo $ComprobantesTipos
 */
class ComprobantesTable extends Table
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

        $this->table('comprobantes');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Clientes', [
            'foreignKey' => 'cliente_id'
        ]);
        $this->belongsTo('ComprobantesTipos', [
            'foreignKey' => 'comprobante_tipo_id'
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
            ->add('fecha', 'valid', ['rule' => 'date'])
            ->allowEmpty('fecha');

        $validator
            ->add('nota', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('nota');

        $validator
            ->add('seccion', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('seccion');

        $validator
            ->add('numero', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('numero');

        $validator
            ->add('importe', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('importe');

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
        $rules->add($rules->existsIn(['comprobante_tipo_id'], 'ComprobantesTipos'));
        return $rules;
    }
}
