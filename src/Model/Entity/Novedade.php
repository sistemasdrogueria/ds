<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Novedade Entity.
 */
class Novedade extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'titulo' => true,
        'descripcion' => true,
		'descripcion_completa'=>true,
        'tipo' => true,
		
        'fecha' => true,
        'activo' => true,
		'interno'=>true,
    ];
	

}
