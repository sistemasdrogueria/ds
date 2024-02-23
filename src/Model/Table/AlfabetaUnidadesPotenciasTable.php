<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AlfabetaUnidadesPotencias Model
 *
 * @method \App\Model\Entity\AlfabetaUnidadesPotencia get($primaryKey, $options = [])
 * @method \App\Model\Entity\AlfabetaUnidadesPotencia newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\AlfabetaUnidadesPotencia[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AlfabetaUnidadesPotencia|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AlfabetaUnidadesPotencia patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AlfabetaUnidadesPotencia[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\AlfabetaUnidadesPotencia findOrCreate($search, callable $callback = null, $options = [])
 */
class AlfabetaUnidadesPotenciasTable extends Table
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

        $this->setTable('alfabeta_unidades_potencias');
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
            ->scalar('descripcion')
            ->maxLength('descripcion', 50)
            ->allowEmpty('descripcion');

        return $validator;
    }
}
