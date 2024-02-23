<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Cortes Model
 *
 * @property \App\Model\Table\ProvinciasTable|\Cake\ORM\Association\BelongsTo $Provincias
 * @method \App\Model\Entity\Corte get($primaryKey, $options = [])
 * @method \App\Model\Entity\Corte newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Corte[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Corte|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Corte patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Corte[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Corte findOrCreate($search, callable $callback = null, $options = [])
 */
class CortesTable extends Table
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

        $this->setTable('cortes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Transportes', [
            'foreignKey' => 'salida_f_id'
        ]);

        $this->belongsTo('Transportes', [
            'foreignKey' => 'salida_d_id'
        ]);
        $this->belongsTo('Transportes', [
            'foreignKey' => 'salida_n_id'
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
            ->scalar('codigo')
            ->maxLength('codigo', 10)
            ->requirePresence('codigo', 'create')
            ->notEmpty('codigo');
            
        $validator
            ->time('hora_n')
            ->allowEmpty('hora_n');

        $validator
            ->time('hora_d')
            ->allowEmpty('hora_d');

        $validator
            ->integer('dia_n')
            ->allowEmpty('dia_n');

        $validator
            ->integer('dia_d')
            ->allowEmpty('dia_d');
            $validator
            ->dateTime('proximo')
            ->allowEmpty('proximo');
      
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
        $rules->add($rules->existsIn(['salida_f_id'], 'Transportes'));
        $rules->add($rules->existsIn(['salida_n_id'], 'Transportes'));
        $rules->add($rules->existsIn(['salida_d_id'], 'Transportes'));
        return $rules;
    }
}
