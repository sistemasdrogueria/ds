<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * VentasDiarias Model
 *
 * @property \App\Model\Table\ClientesTable|\Cake\ORM\Association\BelongsTo $Clientes
 *
 * @method \App\Model\Entity\VentasDiaria get($primaryKey, $options = [])
 * @method \App\Model\Entity\VentasDiaria newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\VentasDiaria[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\VentasDiaria|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\VentasDiaria patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\VentasDiaria[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\VentasDiaria findOrCreate($search, callable $callback = null, $options = [])
 */
class VentasDiariasTable extends Table
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

        $this->setTable('ventas_diarias');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Clientes', [
            'foreignKey' => 'cliente_id'
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
            ->date('fecha')
            ->allowEmpty('fecha');

        $validator
            ->integer('items')
            ->allowEmpty('items');

        $validator
            ->numeric('i_1')
            ->allowEmpty('i_1');

        $validator
            ->integer('u_1')
            ->allowEmpty('u_1');

        $validator
            ->numeric('i_2')
            ->allowEmpty('i_2');

        $validator
            ->integer('u_2')
            ->allowEmpty('u_2');

        $validator
            ->numeric('i_3')
            ->allowEmpty('i_3');

        $validator
            ->integer('u_3')
            ->allowEmpty('u_3');

        $validator
            ->numeric('i_4')
            ->allowEmpty('i_4');

        $validator
            ->integer('u_4')
            ->allowEmpty('u_4');

        $validator
            ->numeric('i_5')
            ->allowEmpty('i_5');

        $validator
            ->integer('u_5')
            ->allowEmpty('u_5');

        $validator
            ->numeric('i_6')
            ->allowEmpty('i_6');

        $validator
            ->integer('u_6')
            ->allowEmpty('u_6');

        $validator
            ->numeric('i_7')
            ->allowEmpty('i_7');

        $validator
            ->integer('u_7')
            ->allowEmpty('u_7');

        $validator
            ->numeric('transfer')
            ->allowEmpty('transfer');

        $validator
            ->dateTime('creado')
            ->allowEmpty('creado');

        $validator
            ->dateTime('modificado')
            ->allowEmpty('modificado');

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
        $rules->add($rules->existsIn(['cliente_id'], 'Clientes'));

        return $rules;
    }
}
