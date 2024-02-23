<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Climas Model
 *
 * @property \App\Model\Table\TransportesTable|\Cake\ORM\Association\BelongsTo $Transportes
 * @property \App\Model\Table\LocalidadsTable|\Cake\ORM\Association\BelongsTo $Localidads
 *
 * @method \App\Model\Entity\Clima get($primaryKey, $options = [])
 * @method \App\Model\Entity\Clima newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Clima[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Clima|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Clima patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Clima[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Clima findOrCreate($search, callable $callback = null, $options = [])
 */
class ClimasTable extends Table
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

        $this->setTable('climas');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Transportes', [
            'foreignKey' => 'transporte_id'
        ]);
        $this->belongsTo('Localidads', [
            'foreignKey' => 'localidad_id'
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
            ->scalar('nombre')
            ->maxLength('nombre', 50)
            ->allowEmpty('nombre');

        $validator
            ->scalar('url')
            ->maxLength('url', 200)
            ->allowEmpty('url');

        $validator
            ->dateTime('creado')
            ->allowEmpty('creado');

        $validator
            ->integer('orden')
            ->allowEmpty('orden');
            
        $validator
            ->integer('localidad_id_api')
            ->allowEmpty('localidad_id_api');
                  
        $validator
            ->integer('provincia_id_api')
            ->allowEmpty('provincia_id_api');

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
        $rules->add($rules->existsIn(['transporte_id'], 'Transportes'));
        $rules->add($rules->existsIn(['localidad_id'], 'Localidads'));

        return $rules;
    }
}
