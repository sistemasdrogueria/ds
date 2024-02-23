<?php
namespace App\Model\Table;

use App\Model\Entity\CtacteObrasSociale;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CtacteObrasSociales Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ObraSociales
 */
class CtacteObrasSocialesTable extends Table
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

        $this->table('ctacte_obras_sociales');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('ObraSociales', [
            'foreignKey' => 'obra_social_id'
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
            ->add('importe', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('importe');

        $validator
            ->add('nro_nota', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('nro_nota');

        $validator
            ->add('tipo_nota', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('tipo_nota');

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
        $rules->add($rules->existsIn(['obra_social_id'], 'ObraSociales'));
        return $rules;
    }
}
