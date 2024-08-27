<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * NotasCuerpos Model
 *
 * @property \Cake\ORM\Association\BelongsTo $NotasCabeceras
 * @property \Cake\ORM\Association\BelongsTo $Articulos
 *
 * @method \App\Model\Entity\NotasCuerpo get($primaryKey, $options = [])
 * @method \App\Model\Entity\NotasCuerpo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\NotasCuerpo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\NotasCuerpo|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\NotasCuerpo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\NotasCuerpo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\NotasCuerpo findOrCreate($search, callable $callback = null)
 */
class NotasCuerposItemsTable extends Table
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

        $this->table('notas_cuerpos_items');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('NotasCabeceras', [
            'foreignKey' => 'nota_cabeceras_id'
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
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->integer('tipo')
            ->allowEmpty('tipo');

        $validator
            ->integer('nota_ds')
            ->allowEmpty('nota_ds');

        $validator
            ->boolean('iva')
            ->allowEmpty('iva');

        $validator
            ->integer('cantidad')
            ->allowEmpty('cantidad');

        $validator
            ->numeric('precio_unitario')
            ->allowEmpty('precio_unitario');

        $validator
            ->allowEmpty('descripcion');

        $validator
            ->integer('pedido_ds')
            ->allowEmpty('pedido_ds');

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
        $rules->add($rules->existsIn(['nota_cabeceras_id'], 'NotasCabeceras'));
        $rules->add($rules->existsIn(['articulo_id'], 'Articulos'));

        return $rules;
    }
}
