<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FacturasCuerposItemsLotesVctos Model
 *
 * @property \App\Model\Table\ArticulosTable|\Cake\ORM\Association\BelongsTo $Articulos
 * @property \App\Model\Table\ClientesTable|\Cake\ORM\Association\BelongsTo $Clientes
 *
 * @method \App\Model\Entity\FacturasCuerposItemsLotesVcto get($primaryKey, $options = [])
 * @method \App\Model\Entity\FacturasCuerposItemsLotesVcto newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\FacturasCuerposItemsLotesVcto[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FacturasCuerposItemsLotesVcto|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FacturasCuerposItemsLotesVcto patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FacturasCuerposItemsLotesVcto[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\FacturasCuerposItemsLotesVcto findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class FacturasCuerposItemsLotesVctosTable extends Table
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

        $this->setTable('facturas_cuerpos_items_lotes_vctos');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Articulos', [
            'foreignKey' => 'articulo_id'
        ]);
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
            ->integer('nota')
            ->allowEmpty('nota');

        $validator
            ->scalar('serie')
            ->maxLength('serie', 20)
            ->allowEmpty('serie');

        $validator
            ->scalar('lote')
            ->maxLength('lote', 10)
            ->allowEmpty('lote');

        $validator
            ->date('vencimiento')
            ->allowEmpty('vencimiento');

        $validator
            ->scalar('cantidad')
            ->maxLength('cantidad', 10)
            ->allowEmpty('cantidad');

        $validator
            ->date('fecha')
            ->allowEmpty('fecha');

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
        $rules->add($rules->existsIn(['articulo_id'], 'Articulos'));
        $rules->add($rules->existsIn(['cliente_id'], 'Clientes'));

        return $rules;
    }
}
