<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TransfersImports Model
 *
 * @property \App\Model\Table\TransferFilesLaboratoriosTable|\Cake\ORM\Association\BelongsTo $TransferFilesLaboratorios
 * @property \App\Model\Table\ProveedorsTable|\Cake\ORM\Association\BelongsTo $Proveedors
 *
 * @method \App\Model\Entity\TransfersImport get($primaryKey, $options = [])
 * @method \App\Model\Entity\TransfersImport newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TransfersImport[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TransfersImport|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TransfersImport patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TransfersImport[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TransfersImport findOrCreate($search, callable $callback = null, $options = [])
 */
class TransfersImportsTable extends Table
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

        $this->setTable('transfers_imports');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('TransfersFilesLaboratorios', [
            'foreignKey' => 'transfers_files_laboratorio_id'
        ]);
        $this->belongsTo('Proveedors', [
            'foreignKey' => 'proveedor_id'
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
            ->scalar('nombre_file')
            ->maxLength('nombre_file', 150)
            ->allowEmpty('nombre_file');

        $validator
            ->dateTime('importado')
            ->allowEmpty('importado');

        $validator
            ->dateTime('procesado')
            ->allowEmpty('procesado');

        $validator
            ->dateTime('facturado')
            ->allowEmpty('facturado');

        $validator
            ->integer('estado')
            ->allowEmpty('estado');

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
        $rules->add($rules->existsIn(['transfers_files_laboratorio_id'], 'TransfersFilesLaboratorios'));
        $rules->add($rules->existsIn(['proveedor_id'], 'Proveedors'));

        return $rules;
    }
}
