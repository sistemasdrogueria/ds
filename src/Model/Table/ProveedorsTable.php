<?php
namespace App\Model\Table;

use App\Model\Entity\Proveedor;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Proveedors Model
 */
class ProveedorsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('proveedors');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('Provincias', [
            'foreignKey' => 'provincia_id'
        ]);
        $this->belongsTo('Localidads', [
            'foreignKey' => 'localidad_id'
        ]);
        $this->hasMany('Ofertas', [
            'foreignKey' => 'proveedor_id'
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
            ->add('codigo', 'valid', ['rule' => 'numeric'])
            ->requirePresence('codigo', 'create')
            ->notEmpty('codigo')
            ->allowEmpty('razon_social')
            ->allowEmpty('domicilio')
            ->allowEmpty('codigo_postal')
            ->allowEmpty('cuit')
            ->allowEmpty('categoria')
            ->add('separa_transfer', 'valid', ['rule' => 'boolean'])
            ->allowEmpty('separa_transfer');

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
        $rules->add($rules->existsIn(['localidad_id'], 'Localidads'));
        return $rules;
    }
}
