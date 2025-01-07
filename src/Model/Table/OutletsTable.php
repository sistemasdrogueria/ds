<?php
namespace App\Model\Table;use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;/**
 * Outlet Model
 *
 * @property \App\Model\Table\ArticulosTable|\Cake\ORM\Association\BelongsTo $Articulos
 *
 * @method \App\Model\Entity\Outlet get($primaryKey, $options = [])
 * @method \App\Model\Entity\Outlet newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Outlet[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Outlet|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Outlet patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Outlet[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Outlet findOrCreate($search, callable $callback = null, $options = [])
 */
class OutletsTable extends Table
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
        $this->setTable('outlets');       
                $this->setDisplayField('id');
        $this->setPrimaryKey('id');        

        $this->belongsTo('Articulos', [
            'foreignKey' => 'articulo_id'
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
        $validator ->integer('id')->allowEmpty('id', 'create');       
        $validator->date('fecha_inicio')->allowEmpty('fecha_inicio');        
        $validator->date('fecha_final')->allowEmpty('fecha_final');        
        $validator->scalar('condicion')->maxLength('condicion', 100)->allowEmpty('condicion');        
        $validator->integer('descuento_por_condicion')->allowEmpty('descuento_por_condicion');        
        $validator->boolean('activo')->allowEmpty('activo');        
        $validator->integer('unidades_stock')->allowEmpty('unidades_stock');       
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
    {        $rules->add($rules->existsIn(['articulo_id'], 'Articulos'));
        return $rules;
    }}
