<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Subcategoria Entity.
 */
class Subcategoria extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'nombre' => true,
        'descripcion' => true,
        'categoria_id' => true,
        'categoria' => true,
        'articulos' => true,
    ];
}
