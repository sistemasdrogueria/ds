<?php
namespace App\Model\Table;

use App\Model\Entity\FacturasCuerposItem;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FacturasCuerposItems Model
 *
 * @property \Cake\ORM\Association\BelongsTo $FacturasCabeceras
 * @property \Cake\ORM\Association\BelongsTo $Articulos
 */
class FacturasCuerposItemsTable extends Table
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

        $this->table('facturas_cuerpos_items');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('FacturasCabeceras', [
            'foreignKey' => 'facturas_encabezados_id'
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
            ->allowEmpty('id', 'create');

        $validator
            ->add('pedido_ds', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('pedido_ds');

        $validator
            ->add('iva', 'valid', ['rule' => 'boolean'])
            ->allowEmpty('iva');

        $validator
            ->add('cantidad_facturada', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('cantidad_facturada');

        $validator
            ->add('precio_unitario', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('precio_unitario');

        $validator
            ->add('precio_publico', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('precio_publico');

        $validator
            ->add('precio_total', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('precio_total');

        $validator
            ->allowEmpty('descripcion');

        $validator
            ->allowEmpty('troquel');

        $validator
            ->allowEmpty('codigo_barra');

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
        $rules->add($rules->existsIn(['facturas_encabezados_id'], 'FacturasCabeceras'));
        $rules->add($rules->existsIn(['articulo_id'], 'Articulos'));
        return $rules;
    }
}
