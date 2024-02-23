<?php
namespace App\Model\Table;

use App\Model\Entity\Localidad;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Localidads Model
 */
class LocalidadsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('localidads');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('Provincias', [
            'foreignKey' => 'provincia_id'
        ]);
        $this->hasMany('Clientes', [
            'foreignKey' => 'localidad_id'
        ]);
        $this->hasMany('Proveedors', [
            'foreignKey' => 'localidad_id'
        ]);
        $this->hasMany('Sucursals', [
            'foreignKey' => 'localidad_id'
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
            ->requirePresence('codigo', 'create')
            ->notEmpty('codigo');

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
        $rules->add($rules->existsIn(['provincia_id'], 'Provincias'));
        return $rules;
    }
}
