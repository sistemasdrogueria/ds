<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ReclamosItem Entity.
 */
class ReclamosItem extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'reclamo_id' => true,
        'articulo_id' => true,
        'cantidad' => true,
        'detalle' => true,
        'reclamo' => true,
        'articulo' => true,
    ];
}
