<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AlfabetaAccionesFars Model
 *
 * @method \App\Model\Entity\AlfabetaAccionesFar get($primaryKey, $options = [])
 * @method \App\Model\Entity\AlfabetaAccionesFar newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\AlfabetaAccionesFar[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AlfabetaAccionesFar|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AlfabetaAccionesFar patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AlfabetaAccionesFar[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\AlfabetaAccionesFar findOrCreate($search, callable $callback = null, $options = [])
 */
class AlfabetaAccionesFarsTable extends Table
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

        $this->setTable('alfabeta_acciones_fars');
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
            ->maxLength('descripcion', 32)
            ->allowEmpty('descripcion');

        return $validator;
    }
}
