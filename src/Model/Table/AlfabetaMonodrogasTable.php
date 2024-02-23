<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AlfabetaMonodrogas Model
 *
 * @property \App\Model\Table\AlfabetaArticulosExtrasTable|\Cake\ORM\Association\HasMany $AlfabetaArticulosExtras
 *
 * @method \App\Model\Entity\AlfabetaMonodroga get($primaryKey, $options = [])
 * @method \App\Model\Entity\AlfabetaMonodroga newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\AlfabetaMonodroga[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AlfabetaMonodroga|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AlfabetaMonodroga patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AlfabetaMonodroga[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\AlfabetaMonodroga findOrCreate($search, callable $callback = null, $options = [])
 */
class AlfabetaMonodrogasTable extends Table
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

        $this->setTable('alfabeta_monodrogas');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('AlfabetaArticulosExtras', [
            'foreignKey' => 'alfabeta_monodroga_id'
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
            ->maxLength('descripcion', 32)
            ->allowEmpty('descripcion');

        return $validator;
    }
}
