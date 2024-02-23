<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CtacteObrasSocialesHistoricos Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Clientes
 * @property \Cake\ORM\Association\BelongsTo $ObraSocials
 *
 * @method \App\Model\Entity\CtacteObrasSocialesHistorico get($primaryKey, $options = [])
 * @method \App\Model\Entity\CtacteObrasSocialesHistorico newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CtacteObrasSocialesHistorico[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CtacteObrasSocialesHistorico|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CtacteObrasSocialesHistorico patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CtacteObrasSocialesHistorico[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CtacteObrasSocialesHistorico findOrCreate($search, callable $callback = null, $options = [])
 */
class CtacteObrasSocialesHistoricosTable extends Table
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

        $this->table('ctacte_obras_sociales_historicos');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Clientes', [
            'foreignKey' => 'cliente_id'
        ]);
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
        $rules->add($rules->existsIn(['cliente_id'], 'Clientes'));
        $rules->add($rules->existsIn(['obra_social_id'], 'ObraSocials'));

        return $rules;
    }
}
