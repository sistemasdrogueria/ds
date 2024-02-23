<?php
namespace App\Model\Table;

use App\Model\Entity\ReclamosTipo;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ReclamosTipos Model
 */
class ReclamosTiposTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('reclamos_tipos');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->hasMany('Reclamos', [
            'foreignKey' => 'reclamos_tipo_id'
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
            ->add('nombre', 'valid', ['rule' => 'date'])
            ->allowEmpty('nombre');

        return $validator;
    }
}
