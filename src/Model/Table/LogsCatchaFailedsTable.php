<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LogCatchaFaileds Model
 *
 * @method \App\Model\Entity\LogCatchaFailed get($primaryKey, $options = [])
 * @method \App\Model\Entity\LogCatchaFailed newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\LogCatchaFailed[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LogCatchaFailed|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LogCatchaFailed patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\LogCatchaFailed[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\LogCatchaFailed findOrCreate($search, callable $callback = null, $options = [])
 */
class LogCatchaFailedsTable extends Table
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
        $this->setTable('logs_catcha_faileds');
        $this->displayField('id');
        $this->primaryKey('id');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
       $validator->add('id', 'valid', ['rule' => 'numeric']);
        $validator->scalar('ip')->maxLength('ip', 30)->allowEmpty('ip');
        $validator->scalar('status')->maxLength('status', 150)->allowEmpty('status');
        $validator->dateTime('fecha')->allowEmpty('fecha');
        $validator->scalar('codigo_cliente')->maxLength('codigo_cliente', 30)->allowEmpty('codigo_cliente');
        return $validator;
    }
}
