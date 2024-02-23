<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AlfabetaLaboratorios Model
 *
 * @property \App\Model\Table\AlfabetaArticulosTable|\Cake\ORM\Association\HasMany $AlfabetaArticulos
 *
 * @method \App\Model\Entity\AlfabetaLaboratorio get($primaryKey, $options = [])
 * @method \App\Model\Entity\AlfabetaLaboratorio newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\AlfabetaLaboratorio[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AlfabetaLaboratorio|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AlfabetaLaboratorio patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AlfabetaLaboratorio[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\AlfabetaLaboratorio findOrCreate($search, callable $callback = null, $options = [])
 */
class AlfabetaLaboratoriosTable extends Table
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

        $this->setTable('alfabeta_laboratorios');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('AlfabetaArticulos', [
            'foreignKey' => 'alfabeta_laboratorio_id'
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
            ->scalar('nombre')
            ->maxLength('nombre', 40)
            ->allowEmpty('nombre');

        $validator
            ->integer('codigo')
            ->allowEmpty('codigo');

        $validator
            ->boolean('eliminado')
            ->allowEmpty('eliminado');

        return $validator;
    }
}
