<?php
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
/**
 * Sistemas Model
 *
 * @property \App\Model\Table\ClientesConfiguracionesTable|\Cake\ORM\Association\HasMany $ClientesConfiguraciones
 *
 * @method \App\Model\Entity\Sistema get($primaryKey, $options = [])
 * @method \App\Model\Entity\Sistema newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Sistema[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Sistema|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Sistema patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Sistema[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Sistema findOrCreate($search, callable $callback = null, $options = [])
 */
class SistemasTable extends Table
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
        $this->setTable('sistemas');       
        $this->setDisplayField('id');        
        $this->setPrimaryKey('id');
        $this->hasMany('ClientesConfiguraciones', [
            'foreignKey' => 'sistema_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {        $validator->integer('id')->allowEmpty('id', 'create');        
             $validator->scalar('nombre')->maxLength('nombre', 100)->allowEmpty('nombre');        
             $validator->integer('ean_init')->allowEmpty('ean_init');        
             $validator->integer('ean_long')->allowEmpty('ean_long');        
             $validator->integer('cantidad_init')->allowEmpty('cantidad_init');       
              $validator->integer('cantidad_long')->allowEmpty('cantidad_long');        
              $validator->integer('descripcion_init')->allowEmpty('descripcion_init');        
              $validator->integer('descripcion_long')->allowEmpty('descripcion_long');        
              $validator->scalar('old')->maxLength('old', 20)->allowEmpty('old');        
              return $validator;
    }}
