<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Contacto Entity.
 */
class Contacto extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'nombre' => true,
        'email' => true,
        'telefono' => true,
        'detalle' => true,
        'departamento' => true,
    ];
}
