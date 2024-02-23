<?php
namespace App\Model\Table;

use App\Model\Entity\CtacteComprasSemanale;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CtacteComprasSemanales Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Clientes
 */
class CtacteComprasSemanalesTable extends Table
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

        $this->table('ctacte_compras_semanales');
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
            ->add('numero', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('numero');

        $validator
            ->add('fecha_factura', 'valid', ['rule' => 'date'])
            ->allowEmpty('fecha_factura');

        $validator
            ->add('importe', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('importe');

        $validator
            ->add('tipo', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('tipo');

        $validator
            ->add('fecha_vencimiento', 'valid', ['rule' => 'date'])
            ->allowEmpty('fecha_vencimiento');

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
