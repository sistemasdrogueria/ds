<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ReclamosMensajes Model
 *
 * @property \App\Model\Table\ReclamosTable|\Cake\ORM\Association\BelongsTo $Reclamos
 * @property \App\Model\Table\ClientesTable|\Cake\ORM\Association\BelongsTo $Clientes
 *
 * @method \App\Model\Entity\ReclamosMensaje get($primaryKey, $options = [])
 * @method \App\Model\Entity\ReclamosMensaje newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ReclamosMensaje[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ReclamosMensaje|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ReclamosMensaje patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ReclamosMensaje[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ReclamosMensaje findOrCreate($search, callable $callback = null, $options = [])
 */
class ReclamosMensajesTable extends Table
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
        $this->setTable('reclamos_mensajes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->belongsTo('Reclamos', [
            'foreignKey' => 'reclamo_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Clientes', [
            'foreignKey' => 'cliente_id',
            'joinType' => 'LEFT'
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
        $validator->integer('id')->allowEmpty('id', 'create');
        $validator->dateTime('creado')->allowEmpty('creado');
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
        $rules->add($rules->existsIn(['reclamo_id'], 'Reclamos'));
        $rules->add($rules->existsIn(['cliente_id'], 'Clientes'));
        return $rules;
    }
}
