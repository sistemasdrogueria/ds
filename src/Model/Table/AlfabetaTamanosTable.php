<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AlfabetaTamanos Model
 *
 * @property \App\Model\Table\AlfabetaArticulosExtrasTable|\Cake\ORM\Association\HasMany $AlfabetaArticulosExtras
 *
 * @method \App\Model\Entity\AlfabetaTamano get($primaryKey, $options = [])
 * @method \App\Model\Entity\AlfabetaTamano newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\AlfabetaTamano[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AlfabetaTamano|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AlfabetaTamano patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AlfabetaTamano[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\AlfabetaTamano findOrCreate($search, callable $callback = null, $options = [])
 */
class AlfabetaTamanosTable extends Table
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

        $this->setTable('alfabeta_tamanos');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('AlfabetaArticulosExtras', [
            'foreignKey' => 'alfabeta_tamano_id'
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
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('descripcion')
            ->maxLength('descripcion', 50)
            ->allowEmpty('descripcion');

        return $validator;
    }
}
