<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Grupos Model
 *
 * @property \App\Model\Table\SubcategoriasTable|\Cake\ORM\Association\BelongsTo $Subcategorias
 * @property \App\Model\Table\ArticulosTable|\Cake\ORM\Association\HasMany $Articulos
 * @property \App\Model\Table\ClientesTable|\Cake\ORM\Association\HasMany $Clientes
 * @property \App\Model\Table\SubgruposTable|\Cake\ORM\Association\HasMany $Subgrupos
 * @property \App\Model\Table\CtacteTipoPagosTable|\Cake\ORM\Association\BelongsToMany $CtacteTipoPagos
 *
 * @method \App\Model\Entity\Grupo get($primaryKey, $options = [])
 * @method \App\Model\Entity\Grupo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Grupo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Grupo|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Grupo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Grupo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Grupo findOrCreate($search, callable $callback = null, $options = [])
 */
class GruposTable extends Table
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

        $this->setTable('grupos');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Subcategorias', [
            'foreignKey' => 'subcategoria_id'
        ]);
        $this->hasMany('Articulos', [
            'foreignKey' => 'grupo_id'
        ]);
        $this->hasMany('Clientes', [
            'foreignKey' => 'grupo_id'
        ]);
        $this->hasMany('Subgrupos', [
            'foreignKey' => 'grupo_id'
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
            ->scalar('nombre')
            ->maxLength('nombre', 40)
            ->requirePresence('nombre', 'create')
            ->notEmpty('nombre');

        $validator
            ->scalar('descripcion')
            ->maxLength('descripcion', 100)
            ->allowEmpty('descripcion');

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
       

        return $rules;
    }
}
