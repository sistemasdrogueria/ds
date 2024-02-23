<?php
namespace App\Model\Table;

use App\Model\Entity\ClientesExport;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ClientesExports Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ClienteComuns
 * @property \Cake\ORM\Association\BelongsTo $ClienteExports
 */
class ClientesExportsTable extends Table
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

        $this->table('clientes_exports');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('ClienteComuns', [
            'foreignKey' => 'cliente_comun_id'
        ]);
        $this->belongsTo('ClienteExports', [
            'foreignKey' => 'cliente_export_id'
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
            ->add('cta_comun', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('cta_comun');

        $validator
            ->add('cta_exportacion', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('cta_exportacion');

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
        $rules->add($rules->existsIn(['cliente_comun_id'], 'ClienteComuns'));
        $rules->add($rules->existsIn(['cliente_export_id'], 'ClienteExports'));
        return $rules;
    }
}
