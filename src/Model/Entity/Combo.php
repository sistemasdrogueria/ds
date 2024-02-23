<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Combo Entity.
 */
class Combo extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'nombre' => true,
        'desde' => true,
        'hasta' => true,
        'carritos_items' => true,
        'pedidos_items' => true,
    ];
}
