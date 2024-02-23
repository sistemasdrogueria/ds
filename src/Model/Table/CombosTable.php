<?php
namespace App\Model\Table;

use App\Model\Entity\Combo;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Combos Model
 */
class CombosTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('combos');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->hasMany('CarritosItems', [
            'foreignKey' => 'combo_id'
        ]);
        $this->hasMany('PedidosItems', [
            'foreignKey' => 'combo_id'
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
            ->requirePresence('nombre', 'create')
            ->notEmpty('nombre')
            ->add('desde', 'valid', ['rule' => 'date'])
            ->allowEmpty('desde')
            ->add('hasta', 'valid', ['rule' => 'date'])
            ->allowEmpty('hasta');

        return $validator;
    }
}
