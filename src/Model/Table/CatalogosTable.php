<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Catalogos Model
 *
 * @method \App\Model\Entity\Catalogo get($primaryKey, $options = [])
 * @method \App\Model\Entity\Catalogo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Catalogo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Catalogo|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Catalogo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Catalogo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Catalogo findOrCreate($search, callable $callback = null, $options = [])
 */
class CatalogosTable extends Table
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
 $this->table('catalogos');
        //$this->setTable('catalogos');
		$this->displayField('nombre');
       //$this->setDisplayField('id');
        //$this->setPrimaryKey('id');
		 $this->primaryKey('id');
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
            ->allowEmpty('nombre');

        $validator
            ->integer('paginas')
            ->allowEmpty('paginas');

        $validator
            ->integer('tipo_catalogo')
            ->allowEmpty('tipo_catalogo');

        $validator
            ->dateTime('desde')
            ->allowEmpty('desde');

        $validator
            ->dateTime('hasta')
            ->allowEmpty('hasta');

        $validator
            ->dateTime('creado')
            ->allowEmpty('creado');

        return $validator;
    }
}
