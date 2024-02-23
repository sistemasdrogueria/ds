<?php
namespace App\Model\Table;

use App\Model\Entity\CtacteResumenSemanale;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CtacteResumenSemanales Model
 *
 */
class CtacteResumenSemanalesTable extends Table
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

        $this->table('ctacte_resumen_semanales');
        $this->displayField('id');
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
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');

        $validator
            ->add('nro_sistema', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('nro_sistema');

        $validator
            ->add('nro_semana', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('nro_semana');

        $validator
            ->add('desde', 'valid', ['rule' => 'date'])
            ->allowEmpty('desde');

        $validator
            ->add('hasta', 'valid', ['rule' => 'date'])
            ->allowEmpty('hasta');

        return $validator;
    }
}
