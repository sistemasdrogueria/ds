<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Laboratorio Entity.
 */
class Laboratorio extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'codigo' => true,
        'nombre' => true,
        'articulos' => true,
    ];
}
