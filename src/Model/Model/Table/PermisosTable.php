<?php
namespace App\Model\Table;

use App\Model\Entity\Permiso;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Permisos Model
 *
 * @property \Cake\ORM\Association\BelongsToMany $Perfiles
 */
class PermisosTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('permisos');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsToMany('Perfiles', [
            'foreignKey' => 'permiso_id',
            'targetForeignKey' => 'perfile_id',
            'joinTable' => 'permisos_perfiles'
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
            ->allowEmpty('clase');
            
        $validator
            ->allowEmpty('nombre');

        return $validator;
    }
}
