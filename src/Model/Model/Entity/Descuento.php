<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Descuento Entity.
 */
class Descuento extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'articulo_id' => true,
        'fecha_desde' => true,
        'fecha_hasta' => true,
        'precio_costo' => true,
        'dto_patagonia' => true,
        'dto_drogueria' => true,
        'unidadfact' => true,
        'discrimina_iva' => true,
        'articulo' => true,
    ];
}
