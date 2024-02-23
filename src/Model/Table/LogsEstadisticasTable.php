<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LogsEstadisticas Model
 *
 * @property \App\Model\Table\ClientesTable|\Cake\ORM\Association\BelongsTo $Clientes
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\PermisosTable|\Cake\ORM\Association\BelongsTo $Permisos
 *
 * @method \App\Model\Entity\LogsEstadistica get($primaryKey, $options = [])
 * @method \App\Model\Entity\LogsEstadistica newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\LogsEstadistica[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LogsEstadistica|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LogsEstadistica patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\LogsEstadistica[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\LogsEstadistica findOrCreate($search, callable $callback = null, $options = [])
 */
class LogsEstadisticasTable extends Table
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

        $this->setTable('logs_estadisticas');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Clientes', [
            'foreignKey' => 'cliente_id'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
        $this->belongsTo('Permisos', [
            'foreignKey' => 'permiso_id'
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
            ->dateTime('fecha')
            ->allowEmpty('fecha');

        $validator
            ->scalar('ip')
            ->maxLength('ip', 15)
            ->allowEmpty('ip');

        $validator
            ->boolean('super')
            ->allowEmpty('super');

        $validator
            ->scalar('seccion')
            ->maxLength('seccion', 50)
            ->allowEmpty('seccion');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['permiso_id'], 'Permisos'));

        return $rules;
    }
}
