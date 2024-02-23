<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Perfile Entity.
 */
class Perfile extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'nombre' => true,
        'usuarios' => true,
    ];
}
