<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Provincia Entity.
 */
class Provincia extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'nombre' => true,
        'codigo' => true,
        'clientes' => true,
        'proveedors' => true,
        'sucursals' => true,
    ];
}
