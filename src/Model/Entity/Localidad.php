<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Localidad Entity.
 */
class Localidad extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'nombre' => true,
        'codigo' => true,
        'provincia_id' => true,
        'provincia' => true,
        'clientes' => true,
        'proveedors' => true,
        'sucursals' => true,
    ];
}
