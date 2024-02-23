<?php
namespace App\Model\Table;

use App\Model\Entity\Fragancia;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Fragancias Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Marcas
 * @property \Cake\ORM\Association\BelongsTo $Generos
 */
class FraganciasTable extends Table
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

        $this->table('fragancias');
        $this->displayField('id');
        $this->primaryKey('id');
		
        $this->belongsTo('Marcas', [
            'foreignKey' => 'marca_id'
        ]);
        $this->belongsTo('Generos', [
            'foreignKey' => 'genero_id'
        ]);
		 $this->hasMany('FraganciasPresentaciones', [
            'foreignKey' => 'fragancia_id',
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
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');

        $validator
            ->allowEmpty('nombre');

        $validator
            ->allowEmpty('imagen');

        $validator
            ->add('eliminado', 'valid', ['rule' => 'boolean'])
            ->allowEmpty('eliminado');

        $validator
            ->add('creado', 'valid', ['rule' => 'datetime'])
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
        $rules->add($rules->existsIn(['marca_id'], 'Marcas'));
        $rules->add($rules->existsIn(['genero_id'], 'Generos'));
        return $rules;
    }
}
