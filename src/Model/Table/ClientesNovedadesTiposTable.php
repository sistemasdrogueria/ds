<?php
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;/**
 * ClientesNovedadesTipos Model
 *
 * @method \App\Model\Entity\ClientesNovedadesTipo get($primaryKey, $options = [])
 * @method \App\Model\Entity\ClientesNovedadesTipo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ClientesNovedadesTipo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ClientesNovedadesTipo|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ClientesNovedadesTipo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ClientesNovedadesTipo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ClientesNovedadesTipo findOrCreate($search, callable $callback = null, $options = [])
 */
class ClientesNovedadesTiposTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config):void
    {
        parent::initialize($config);        
        $this->setTable('clientes_novedades_tipos');        
        $this->setDisplayField('id');        
        $this->setPrimaryKey('id');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator):Validator
    {        
        $validator->integer('id')->allowEmpty('id', 'create');        
        $validator->scalar('nombre')->maxLength('nombre', 100)->requirePresence('nombre', 'create')->notEmpty('nombre');        
        return $validator;
    }}
