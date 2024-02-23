<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TransfersFilesLaboratorios Model
 *
 * @property \App\Model\Table\ProveedorsTable|\Cake\ORM\Association\BelongsTo $Proveedors
 *
 * @method \App\Model\Entity\TransfersFilesLaboratorio get($primaryKey, $options = [])
 * @method \App\Model\Entity\TransfersFilesLaboratorio newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TransfersFilesLaboratorio[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TransfersFilesLaboratorio|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TransfersFilesLaboratorio patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TransfersFilesLaboratorio[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TransfersFilesLaboratorio findOrCreate($search, callable $callback = null, $options = [])
 */
class TransfersFilesLaboratoriosTable extends Table
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

        $this->setTable('transfers_files_laboratorios');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Proveedors', [
            'foreignKey' => 'proveedor_id'
        ]);
        $this->hasMany('TransfersImports', [
            'foreignKey' => 'transfers_files_laboratorio_id'
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
            ->scalar('nombre_laboratorio')
            ->maxLength('nombre_laboratorio', 100)
            ->allowEmpty('nombre_laboratorio');

        $validator
            ->scalar('numero_pedido_proveedor')
            ->maxLength('numero_pedido_proveedor', 2)
            ->allowEmpty('numero_pedido_proveedor');

        $validator
            ->scalar('numero_posicion')
            ->maxLength('numero_posicion', 2)
            ->allowEmpty('numero_posicion');

        $validator
            ->scalar('status')
            ->maxLength('status', 2)
            ->allowEmpty('status');

        $validator
            ->scalar('fecha_factura')
            ->maxLength('fecha_factura', 2)
            ->allowEmpty('fecha_factura');

        $validator
            ->scalar('drogueria')
            ->maxLength('drogueria', 2)
            ->allowEmpty('drogueria');

        $validator
            ->scalar('lab')
            ->maxLength('lab', 2)
            ->allowEmpty('lab');

        $validator
            ->scalar('numero_pedido')
            ->maxLength('numero_pedido', 2)
            ->allowEmpty('numero_pedido');

        $validator
            ->scalar('fecha_transfer')
            ->maxLength('fecha_transfer', 2)
            ->allowEmpty('fecha_transfer');

        $validator
            ->scalar('cliente')
            ->maxLength('cliente', 2)
            ->allowEmpty('cliente');

        $validator
            ->scalar('nombre')
            ->maxLength('nombre', 2)
            ->allowEmpty('nombre');

        $validator
            ->scalar('ean')
            ->maxLength('ean', 2)
            ->allowEmpty('ean');

        $validator
            ->scalar('descripcion')
            ->maxLength('descripcion', 2)
            ->allowEmpty('descripcion');

        $validator
            ->scalar('unidades')
            ->maxLength('unidades', 2)
            ->allowEmpty('unidades');

        $validator
            ->scalar('descuento')
            ->maxLength('descuento', 2)
            ->allowEmpty('descuento');

        $validator
            ->scalar('contacto')
            ->maxLength('contacto', 2)
            ->allowEmpty('contacto');

        $validator
            ->scalar('telefono')
            ->maxLength('telefono', 2)
            ->allowEmpty('telefono');

        $validator
            ->scalar('cuit')
            ->maxLength('cuit', 2)
            ->allowEmpty('cuit');

        $validator
            ->scalar('domicilio')
            ->maxLength('domicilio', 2)
            ->allowEmpty('domicilio');

        $validator
            ->scalar('codigo_postal')
            ->maxLength('codigo_postal', 2)
            ->allowEmpty('codigo_postal');

        $validator
            ->scalar('localidad')
            ->maxLength('localidad', 2)
            ->allowEmpty('localidad');

        $validator
            ->scalar('provincia')
            ->maxLength('provincia', 2)
            ->allowEmpty('provincia');

        $validator
            ->scalar('transfer')
            ->maxLength('transfer', 2)
            ->allowEmpty('transfer');

        $validator
            ->scalar('plazo')
            ->maxLength('plazo', 2)
            ->allowEmpty('plazo');

        $validator
            ->integer('nro_lote')
            ->allowEmpty('nro_lote');

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
