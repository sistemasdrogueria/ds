<?php
namespace App\Model\Table;

use App\Model\Entity\ReclamosItem;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ReclamosItems Model
 */
class ReclamosItemsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('reclamos_items');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('Reclamos', [
            'foreignKey' => 'reclamo_id'
        ]);
        $this->belongsTo('Articulos', [
            'foreignKey' => 'articulo_id'
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
            ->add('cantidad', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('cantidad')
            ->allowEmpty('detalle');

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
        $rules->add($rules->existsIn(['articulo_id'], 'Articulos'));
        return $rules;
    }
}
