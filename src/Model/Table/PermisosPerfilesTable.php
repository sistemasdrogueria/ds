<?php
namespace App\Model\Table;

use App\Model\Entity\PermisosPerfile;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PermisosPerfiles Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Perfiles
 * @property \Cake\ORM\Association\BelongsTo $Permisos
 */
class PermisosPerfilesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('permisos_perfiles');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('Perfiles', [
            'foreignKey' => 'perfiles_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Permisos', [
            'foreignKey' => 'permisos_id',
            'joinType' => 'INNER'
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
        $rules->add($rules->existsIn(['perfiles_id'], 'Perfiles'));
        $rules->add($rules->existsIn(['permisos_id'], 'Permisos'));
        return $rules;
    }
}
