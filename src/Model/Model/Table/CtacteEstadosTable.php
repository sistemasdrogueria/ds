<?php
namespace App\Model\Table;

use App\Model\Entity\CtacteEstado;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CtacteEstados Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Clientes
 * @property \Cake\ORM\Association\BelongsTo $CtacteTipoRegistros
 */
class CtacteEstadosTable extends Table
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

        $this->table('ctacte_estados');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('Clientes', [
            'foreignKey' => 'cliente_id'
        ]);
        $this->belongsTo('CtacteTipoRegistros', [
            'foreignKey' => 'ctacte_tipo_registros_id'
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
            ->add('fecha_compra', 'valid', ['rule' => 'date'])
            ->allowEmpty('fecha_compra');

        $validator
            ->add('fecha_vencimiento', 'valid', ['rule' => 'date'])
            ->allowEmpty('fecha_vencimiento');

        $validator
            ->add('importe', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('importe');

        $validator
            ->add('signo', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('signo');

        $validator
            ->add('transfer', 'valid', ['rule' => 'boolean'])
            ->allowEmpty('transfer');

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
        $rules->add($rules->existsIn(['ctacte_tipo_registros_id'], 'CtacteTipoRegistros'));
        return $rules;
    }
}
