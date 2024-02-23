<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ReclamosItemsTemp Entity.
 */
class ReclamosItemsTemp extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'cliente_id' => true,
        'articulo_id' => true,
        'cantidad' => true,
        'detalle' => true,
        'fecha_vencimiento' => true,
        'lote' => true,
        'serie' => true,
        'creado' => true,
        'cliente' => true,
        'articulo' => true,
    ];
}
