<?php
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
/**
 * ClientesNovedades Model
 *
 * @property \App\Model\Table\ClientesNovedadesTiposTable|\Cake\ORM\Association\BelongsTo $ClientesNovedadesTipos
 *
 * @method \App\Model\Entity\ClientesNovedade get($primaryKey, $options = [])
 * @method \App\Model\Entity\ClientesNovedade newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ClientesNovedade[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ClientesNovedade|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ClientesNovedade patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ClientesNovedade[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ClientesNovedade findOrCreate($search, callable $callback = null, $options = [])
 */
class ClientesNovedadesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);        $this->setTable('clientes_novedades');        $this->setDisplayField('id');        $this->setPrimaryKey('id');
        $this->belongsTo('ClientesNovedadesTipos', [
            'foreignKey' => 'clientes_novedades_tipos_id',
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
    {        $validator->integer('id')->allowEmpty('id', 'create');        $validator->scalar('titulo')->maxLength('titulo', 200)->requirePresence('titulo', 'create')->notEmpty('titulo');        $validator->scalar('descripcion')->maxLength('descripcion', 16777215)->requirePresence('descripcion', 'create')->notEmpty('descripcion');        $validator->scalar('img_file')->maxLength('img_file', 200)->allowEmpty('img_file');        $validator->date('fecha')->allowEmpty('fecha');        $validator->boolean('activo')->allowEmpty('activo');        $validator->dateTime('creado')->requirePresence('creado', 'create')->notEmpty('creado');        return $validator;
    }
    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {        $rules->add($rules->existsIn(['clientes_novedades_tipos_id'], 'ClientesNovedadesTipos'));
        return $rules;
    }}
