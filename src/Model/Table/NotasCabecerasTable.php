<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * NotasCabeceras Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Clientes
 * @property \Cake\ORM\Association\BelongsTo $Comprobantes
 *
 * @method \App\Model\Entity\NotasCabecera get($primaryKey, $options = [])
 * @method \App\Model\Entity\NotasCabecera newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\NotasCabecera[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\NotasCabecera|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\NotasCabecera patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\NotasCabecera[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\NotasCabecera findOrCreate($search, callable $callback = null)
 */
class NotasCabecerasTable extends Table
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

        $this->table('notas_cabeceras');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Clientes', [
            'foreignKey' => 'cliente_id'
        ]);
        $this->belongsTo('Comprobantes', [
            'foreignKey' => 'comprobante_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('NotasCuerposItems', [
            'foreignKey' => 'notas_cabeceras_id',
            'dependent' => true,
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
            ->integer('nota')
            ->allowEmpty('nota');

        $validator
            ->allowEmpty('letra');

        $validator
            ->allowEmpty('tipo');

        $validator
            ->decimal('imp_exento')
            ->allowEmpty('imp_exento');

        $validator
            ->decimal('imp_gravado')
            ->allowEmpty('imp_gravado');

        $validator
            ->numeric('imp_iva')
            ->allowEmpty('imp_iva');

        $validator
            ->numeric('imp_rg3337')
            ->allowEmpty('imp_rg3337');

        $validator
            ->numeric('imp_ingreso_bruto')
            ->allowEmpty('imp_ingreso_bruto');

        $validator
            ->numeric('total')
            ->allowEmpty('total');

        $validator
            ->integer('estado')
            ->allowEmpty('estado');

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
        $rules->add($rules->existsIn(['comprobante_id'], 'Comprobantes'));

        return $rules;
    }
}
