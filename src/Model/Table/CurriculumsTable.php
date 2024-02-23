<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Curriculums Model
 *
 * @property \App\Model\Table\PuestosTable|\Cake\ORM\Association\BelongsTo $Puestos
 *
 * @method \App\Model\Entity\Curriculum get($primaryKey, $options = [])
 * @method \App\Model\Entity\Curriculum newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Curriculum[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Curriculum|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Curriculum patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Curriculum[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Curriculum findOrCreate($search, callable $callback = null, $options = [])
 */
class CurriculumsTable extends Table
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

        $this->setTable('curriculums');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Sectors', [
            'foreignKey' => 'sector_id',
            'joinType' => 'INNER'
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
            ->scalar('nombres')
            ->maxLength('nombres', 100)
            ->requirePresence('nombres', 'create')
            ->notEmpty('nombres');

        $validator
            ->scalar('apellidos')
            ->maxLength('apellidos', 100)
            ->requirePresence('apellidos', 'create')
            ->notEmpty('apellidos');

           
        
		$validator
		
		->notEmpty('documento')
		->maxLength('documento', 9)
        ->requirePresence('documento', 'create')
		->add('documento', [
			'length' => [
            'rule' => ['minLength', 7],
            'message' => 'El número de documento es corto'
        ]])
		->add('documento', 'custom', [
		
			'rule' => function($value, $context) {
				return (bool) preg_match('/^[0-9\-]+$/', $value);
				//return preg_match('/^[0-9]+$/', $value);
				},
			'message' => 'Ingrese un número de documento'
		]);
	   
		$validator
		
		->notEmpty('telefono')
		->requirePresence('telefono', 'create')
		->add('telefono', [
			'length' => [
            'rule' => ['minLength', 6],
            'message' => 'El número de telefono es corto'
        ]])
		->add('telefono', 'custom', [
		
			'rule' => function($value, $context) {
				return (bool) preg_match('/^[0-9\-]+$/', $value);
				//return preg_match('/^[0-9]+$/', $value);
				},
			'message' => 'Ingrese un número de telefono'
        ]);
        $validator
        ->notEmpty('telefono_cod')
		->requirePresence('telefono_cod', 'create')
		->add('telefono_cod', [
			'length' => [
            'rule' => ['minLength', 2],
            'message' => 'La caracteristica de telefono es corto'
        ]])
		->add('telefono_cod', 'custom', [
		
			'rule' => function($value, $context) {
				return (bool) preg_match('/^[0-9\-]+$/', $value);
				//return preg_match('/^[0-9]+$/', $value);
				},
			'message' => 'Ingrese un número de caracteristica'
        ]);
        
        $validator
            ->email('email')
            ->allowEmpty('email');

        $validator
            ->date('fecha_nacimiento')
            ->requirePresence('fecha_nacimiento', 'create')
            ->notEmpty('fecha_nacimiento');


        $validator
            ->scalar('archivo_cv')
            ->maxLength('archivo_cv', 100)
            ->requirePresence('archivo_cv', 'create')
            ->notEmpty('archivo_cv');

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
        $rules->add($rules->isUnique(['email'], 'Este email ya fue ingresado'));
        $rules->add($rules->existsIn(['sector_id'], 'Sectors'));

        return $rules;
    }
}
