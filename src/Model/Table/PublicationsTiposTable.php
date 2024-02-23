<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PublicationsTipos Model
 *
 * @method \App\Model\Entity\PublicationsTipo get($primaryKey, $options = [])
 * @method \App\Model\Entity\PublicationsTipo newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PublicationsTipo[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PublicationsTipo|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PublicationsTipo patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PublicationsTipo[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PublicationsTipo findOrCreate($search, callable $callback = null, $options = [])
 */
class PublicationsTiposTable extends Table
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

        $this->setTable('publications_tipos');
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
            ->scalar('nombre')
            ->maxLength('nombre', 50)
            ->requirePresence('nombre', 'create')
            ->notEmpty('nombre');

        return $validator;
    }
}
