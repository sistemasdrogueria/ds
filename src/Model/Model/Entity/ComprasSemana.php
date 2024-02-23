<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ComprasSemana Entity.
 */
class ComprasSemana extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'codigo' => true,
        'numero' => true,
        'fecha_factura' => true,
        'importe' => true,
        'tipo' => true,
        'fecha_vencimiento' => true,
    ];
}
