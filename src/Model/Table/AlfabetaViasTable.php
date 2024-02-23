<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AlfabetaVias Model
 *
 * @method \App\Model\Entity\AlfabetaVia get($primaryKey, $options = [])
 * @method \App\Model\Entity\AlfabetaVia newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\AlfabetaVia[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AlfabetaVia|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AlfabetaVia patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AlfabetaVia[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\AlfabetaVia findOrCreate($search, callable $callback = null, $options = [])
 */
class AlfabetaViasTable extends Table
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

        $this->setTable('alfabeta_vias');
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
            ->maxLength('descripcion', 60)
            ->allowEmpty('descripcion');

        return $validator;
    }
}
