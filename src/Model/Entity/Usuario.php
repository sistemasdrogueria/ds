<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Usuario Entity.
 */
class Usuario extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'nombre' => true,
        'cliente_id' => true,
		'role'=>true,
        'perfile_id' => true,
        'clave' => true,
        'creacion' => true,
        'ultimo_cambio' => true,
        'cliente' => true,
        'perfile' => true,
        'usuarios_tipo' => true,
        'logs_accesos' => true,
    ];
}
