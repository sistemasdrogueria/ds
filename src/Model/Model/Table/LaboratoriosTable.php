<?php
namespace App\Model\Table;

use App\Model\Entity\Laboratorio;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Laboratorios Model
 */
class LaboratoriosTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('laboratorios');
        $this->displayField('nombre');
        $this->primaryKey('id');
        $this->hasMany('Articulos', [
            'foreignKey' => 'laboratorio_id'
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
            ->requirePresence('codigo', 'create')
            ->notEmpty('codigo')
            ->allowEmpty('nombre');

        return $validator;
    }
}
