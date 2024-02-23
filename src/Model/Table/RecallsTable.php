<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Recalls Model
 *
 * @property \App\Model\Table\FilesTable|\Cake\ORM\Association\BelongsToMany $Files
 *
 * @method \App\Model\Entity\Recall get($primaryKey, $options = [])
 * @method \App\Model\Entity\Recall newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Recall[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Recall|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Recall patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Recall[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Recall findOrCreate($search, callable $callback = null, $options = [])
 */
class RecallsTable extends Table
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

        $this->setTable('recalls');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('RecallsFiles', [
            'foreignKey' => 'recall_id'
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
            ->dateTime('fecha')
            ->allowEmpty('fecha');

        $validator
            ->scalar('titulo')
            ->maxLength('titulo', 250)
            ->allowEmpty('titulo');

        $validator
            ->scalar('detalle')
            ->allowEmpty('detalle');

        $validator
            ->dateTime('creado')
            ->allowEmpty('creado');

        return $validator;
    }
}
