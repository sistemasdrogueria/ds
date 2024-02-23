<?php
namespace App\Model\Table;

use App\Model\Entity\Usuario;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Usuarios Model
 */
class UsuariosTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('usuarios');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('Clientes', [
            'foreignKey' => 'cliente_id'
        ]);
        $this->belongsTo('Perfiles', [
            'foreignKey' => 'perfile_id'
        ]);

        $this->hasMany('LogsAccesos', [
            'foreignKey' => 'usuario_id'
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
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create')
            ->requirePresence('nombre', 'create')
            ->notEmpty('nombre')
            ->allowEmpty('clave')
            ->add('creacion', 'valid', ['rule' => 'date'])
            ->allowEmpty('creacion')
            ->add('ultimo_cambio', 'valid', ['rule' => 'date'])
            ->allowEmpty('ultimo_cambio')
			
			->notEmpty('role', 'Se requiere un Rol')
			->add('role', 'inList', [
                'rule' => ['inList', ['admin', 'client','provider']],
                'message' => 'Por favor ingrese un role'
            ]);
			
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
        $rules->add($rules->existsIn(['perfile_id'], 'Perfiles'));
        return $rules;
    }
}
