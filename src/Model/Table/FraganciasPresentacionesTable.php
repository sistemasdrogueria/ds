<?php
namespace App\Model\Table;

use App\Model\Entity\FraganciasPresentacione;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FraganciasPresentaciones Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Articulos
 * @property \Cake\ORM\Association\BelongsTo $Fragancias
 */
class FraganciasPresentacionesTable extends Table
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

        $this->table('fragancias_presentaciones');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('Articulos', [
            'foreignKey' => 'articulo_id',
			'joinType' => 'INNER',
        ]);
        $this->belongsTo('Fragancias', [
            'foreignKey' => 'fragancia_id',
			'joinType' => 'INNER',
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
            ->allowEmpty('detalle');

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
        $rules->add($rules->existsIn(['articulo_id'], 'Articulos'));
        $rules->add($rules->existsIn(['fragancia_id'], 'Fragancias'));
	    return $rules;
    }
}
