<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Reclamo Entity.
 */
class Reclamo extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'cliente_id' => true,
        'factura_numero' => true,
        'guia_numero' => true,
        'reclamos_tipo_id' => true,
        'transporte' => true,
        'observaciones' => true,
        'fecha_recepcion' => true,
        'estado_id' => true,
        'cliente' => true,
        'reclamos_tipo' => true,
        'estado' => true,
    ];
}
