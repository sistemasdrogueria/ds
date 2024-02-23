<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CtacteResumenCuentas Model
 *
 * @method \App\Model\Entity\CtacteResumenCuenta get($primaryKey, $options = [])
 * @method \App\Model\Entity\CtacteResumenCuenta newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CtacteResumenCuenta[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CtacteResumenCuenta|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CtacteResumenCuenta patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CtacteResumenCuenta[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CtacteResumenCuenta findOrCreate($search, callable $callback = null, $options = [])
 */
class CtacteResumenCuentasTable extends Table
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

        $this->setTable('ctacte_resumen_cuentas');
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
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->integer('nro_sistema')
            ->allowEmpty('nro_sistema');

        $validator
            ->integer('nro_semana')
            ->allowEmpty('nro_semana');

        $validator
            ->date('desde')
            ->allowEmpty('desde');

        $validator
            ->date('hasta')
            ->allowEmpty('hasta');

        return $validator;
    }
}
