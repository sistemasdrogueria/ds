<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Permiso Entity.
 */
class Permiso extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'clase' => true,
        'nombre' => true,
        'perfiles' => true,
    ];
}
