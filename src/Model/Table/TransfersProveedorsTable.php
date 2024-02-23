<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TransfersProveedors Model
 *
 * @property \App\Model\Table\ProveedorsTable|\Cake\ORM\Association\BelongsTo $Proveedors
 *
 * @method \App\Model\Entity\TransfersProveedor get($primaryKey, $options = [])
 * @method \App\Model\Entity\TransfersProveedor newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TransfersProveedor[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TransfersProveedor|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TransfersProveedor patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TransfersProveedor[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TransfersProveedor findOrCreate($search, callable $callback = null, $options = [])
 */
class TransfersProveedorsTable extends Table
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

        $this->setTable('transfers_proveedors');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Proveedors', [
            'foreignKey' => 'proveedor_id'
        ]);

        $this->belongsTo('TransfersImports', [
            'foreignKey' => 'transfers_import_id'
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
            ->integer('numero_pedido_proveedor')
            ->allowEmpty('numero_pedido_proveedor');

        $validator
            ->integer('status')
            ->allowEmpty('status');

        $validator
            ->date('fecha_factura')
            ->allowEmpty('fecha_factura');

        $validator
            ->integer('drogueria')
            ->allowEmpty('drogueria');

        $validator
            ->integer('lab')
            ->allowEmpty('lab');

        $validator
            ->integer('numero_pedido')
            ->allowEmpty('numero_pedido');

        $validator
            ->dateTime('fecha_transfer')
            ->allowEmpty('fecha_transfer');

        $validator
            ->integer('cliente')
            ->allowEmpty('cliente');

        $validator
            ->scalar('nombre')
            ->maxLength('nombre', 30)
            ->allowEmpty('nombre');

        $validator
            ->scalar('ean')
            ->maxLength('ean', 14)
            ->allowEmpty('ean');

        $validator
            ->scalar('descripcion')
            ->maxLength('descripcion', 40)
            ->allowEmpty('descripcion');

        $validator
            ->integer('unidades')
            ->allowEmpty('unidades');

        $validator
            ->numeric('descuento')
            ->allowEmpty('descuento');

        $validator
            ->scalar('contacto')
            ->maxLength('contacto', 50)
            ->allowEmpty('contacto');

        $validator
            ->scalar('telefono')
            ->maxLength('telefono', 20)
            ->allowEmpty('telefono');

        $validator
            ->scalar('cuit')
            ->maxLength('cuit', 15)
            ->allowEmpty('cuit');

        $validator
            ->scalar('domicilio')
            ->maxLength('domicilio', 60)
            ->allowEmpty('domicilio');

        $validator
            ->integer('codigo_postal')
            ->allowEmpty('codigo_postal');

        $validator
            ->scalar('localidad')
            ->maxLength('localidad', 60)
            ->allowEmpty('localidad');

        $validator
            ->scalar('provincia')
            ->maxLength('provincia', 60)
            ->allowEmpty('provincia');

        $validator
            ->dateTime('creado')
            ->allowEmpty('creado');

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
        $rules->add($rules->existsIn(['proveedor_id'], 'Proveedors'));

        return $rules;
    }
}
