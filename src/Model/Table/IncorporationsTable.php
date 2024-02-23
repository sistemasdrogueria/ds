<?php
namespace App\Model\Table;

use App\Model\Entity\Incorporation;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Incorporations Model
 *
 * @property \App\Model\Table\IncorporationsTiposTable|\Cake\ORM\Association\BelongsTo $IncorporationsTipos
 *
 * @method \App\Model\Entity\Incorporation get($primaryKey, $options = [])
 * @method \App\Model\Entity\Incorporation newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Incorporation[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Incorporation|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Incorporation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Incorporation[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Incorporation findOrCreate($search, callable $callback = null, $options = [])
 */
class IncorporationsTable extends Table
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

        $this->table('incorporations');
        $this->displayField('id');
        $this->primaryKey('id');

    	/*$this->table('ofertas');
        $this->displayField('id');
        $this->primaryKey('id');*/

		
        $this->belongsTo('IncorporationsTipos', [
            'foreignKey' => 'incorporations_tipos_id'
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
            ->allowEmpty('id', 'create');
        /*$validator
            ->integer('id')
            ->allowEmpty('id', 'create');*/

        $validator
            ->scalar('descripcion')
            ->allowEmpty('descripcion');

        $validator
            ->date('fecha_desde')
            ->allowEmpty('fecha_desde');

        $validator
            ->date('fecha_hasta')
            ->allowEmpty('fecha_hasta');

        $validator
            ->scalar('imagen')
            ->maxLength('imagen', 255)
            ->allowEmpty('imagen');

        $validator
            ->allowEmpty('habilitada');

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
        $rules->add($rules->existsIn(['incorporations_tipos_id'], 'IncorporationsTipos'));

        return $rules;
    }
}
