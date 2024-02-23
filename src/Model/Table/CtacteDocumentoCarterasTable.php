<?php
namespace App\Model\Table;

use App\Model\Entity\CtacteDocumentoCartera;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CtacteDocumentoCarteras Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Clientes
 */
class CtacteDocumentoCarterasTable extends Table
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

        $this->table('ctacte_documento_carteras');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('Clientes', [
            'foreignKey' => 'cliente_id'
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
            ->add('fecha_deposito', 'valid', ['rule' => 'date'])
            ->allowEmpty('fecha_deposito');

        $validator
            ->add('nro_cheque', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('nro_cheque');

        $validator
            ->add('fecha_ingreso', 'valid', ['rule' => 'date'])
            ->allowEmpty('fecha_ingreso');

        $validator
            ->add('importe', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('importe');

        $validator
            ->add('origen', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('origen');

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
        return $rules;
    }
}
