<?php
namespace App\Model\Table;

use App\Model\Entity\Publication;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Publications Model
 *
 * @method \App\Model\Entity\Publication get($primaryKey, $options = [])
 * @method \App\Model\Entity\Publication newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Publication[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Publication|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Publication patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Publication[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Publication findOrCreate($search, callable $callback = null, $options = [])
 */
class PublicationsTable extends Table
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

        $this->setTable('publications');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
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
            ->scalar('descripcion')
            ->allowEmpty('descripcion');

        $validator
            ->scalar('url_controlador')
            ->maxLength('url_controlador', 100)
            ->allowEmpty('url_controlador');

        $validator
            ->scalar('url_metodo')
            ->maxLength('url_metodo', 100)
            ->allowEmpty('url_metodo');

        $validator
            ->date('fecha_desde')
            ->allowEmpty('fecha_desde');

        $validator
            ->date('fecha_hasta')
            ->allowEmpty('fecha_hasta');

        $validator
            ->scalar('imagen')
            ->maxLength('imagen', 255)
            ->allowEmpty('imagen');

        $validator
            ->allowEmpty('habilitada');

        return $validator;
    }
}
