<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AlfabetaFormas Model
 *
 * @property \App\Model\Table\AlfabetaArticulosExtrasTable|\Cake\ORM\Association\HasMany $AlfabetaArticulosExtras
 *
 * @method \App\Model\Entity\AlfabetaForma get($primaryKey, $options = [])
 * @method \App\Model\Entity\AlfabetaForma newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\AlfabetaForma[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AlfabetaForma|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AlfabetaForma patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AlfabetaForma[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\AlfabetaForma findOrCreate($search, callable $callback = null, $options = [])
 */
class AlfabetaFormasTable extends Table
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

        $this->setTable('alfabeta_formas');

        $this->hasMany('AlfabetaArticulosExtras', [
            'foreignKey' => 'alfabeta_forma_id'
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
            ->requirePresence('id', 'create')
            ->notEmpty('id');

        $validator
            ->scalar('descripcion')
            ->maxLength('descripcion', 50)
            ->allowEmpty('descripcion');

        return $validator;
    }
}
