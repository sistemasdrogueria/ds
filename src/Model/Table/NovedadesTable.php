<?php
namespace App\Model\Table;

use App\Model\Entity\Novedade;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Novedades Model
 */
class NovedadesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('novedades');
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
            ->allowEmpty('id', 'create')
            ->requirePresence('titulo', 'create')
            ->notEmpty('titulo')
            ->requirePresence('descripcion', 'create')
            ->notEmpty('descripcion')
			->requirePresence('descripcion_completa', 'create')
            ->notEmpty('descripcion_completa')
            ->requirePresence('tipo', 'create')
            ->notEmpty('tipo')
            ->add('fecha', 'valid', ['rule' => 'date'])
            ->requirePresence('fecha', 'create')
            ->notEmpty('fecha')
            ->add('activo', 'valid', ['rule' => 'numeric'])
            ->requirePresence('activo', 'create')
            ->notEmpty('activo');

        return $validator;
    }
	



	   /*public $actsAs = array(
        'Upload.Upload' => array(
            'img_file' => array(
                'fields' => array('dir' => 'dir'),               
                'thumbnailSizes' => array('big' => '200x200',
                    'small' =>'120x120',
                    'thumb' =>'80x80'),
                'thumbnailMethod'=> 'php',
                'allowedTypes' => array(
                'jpg' => array('image/jpeg','image/pjpeg')
            )
                
            )           
           
          
        )
    );*/
}
