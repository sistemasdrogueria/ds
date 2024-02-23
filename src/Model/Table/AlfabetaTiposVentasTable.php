<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AlfabetaTiposVentas Model
 *
 * @method \App\Model\Entity\AlfabetaTiposVenta get($primaryKey, $options = [])
 * @method \App\Model\Entity\AlfabetaTiposVenta newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\AlfabetaTiposVenta[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AlfabetaTiposVenta|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AlfabetaTiposVenta patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AlfabetaTiposVenta[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\AlfabetaTiposVenta findOrCreate($search, callable $callback = null, $options = [])
 */
class AlfabetaTiposVentasTable extends Table
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

        $this->setTable('alfabeta_tipos_ventas');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
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
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('nombre')
            ->maxLength('nombre', 60)
            ->allowEmpty('nombre');

        return $validator;
    }
}
