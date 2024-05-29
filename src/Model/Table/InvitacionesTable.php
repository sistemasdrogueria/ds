<?php
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
/**
 * Invitaciones Model
 *
 * @method \App\Model\Entity\Invitacione get($primaryKey, $options = [])
 * @method \App\Model\Entity\Invitacione newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Invitacione[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Invitacione|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Invitacione patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Invitacione[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Invitacione findOrCreate($search, callable $callback = null, $options = [])
 */
class InvitacionesTable extends Table
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
        $this->setTable('invitaciones');  
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
    $validator->scalar('nombre')->maxLength('nombre', 50)->allowEmpty('nombre');        
    $validator->scalar('apellido')->maxLength('apellido', 50)->allowEmpty('apellido');        
    $validator->scalar('codigo_ds')->maxLength('codigo_ds', 50)->allowEmpty('codigo_ds');        
    $validator->email('email')->allowEmpty('email');        
    $validator->scalar('telefono')->maxLength('telefono', 50)->allowEmpty('telefono');        
    $validator->scalar('asistencia')->maxLength('asistencia', 50)->allowEmpty('asistencia');     
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
        //$rules->add($rules->isUnique(['email']));
        return $rules;
    }}
