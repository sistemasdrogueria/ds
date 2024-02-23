<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Proveedore Entity.
 */
class Proveedore extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'codigo' => true,
        'razon_social' => true,
        'domicilio' => true,
        'codigo_postal' => true,
        'provincia_id' => true,
        'localidad_id' => true,
        'cuit' => true,
        'categoria' => true,
        'separa_transfer' => true,
        'provincia' => true,
        'localidad' => true,
    ];
}
