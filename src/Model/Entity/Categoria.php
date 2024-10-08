<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Categoria Entity.
 */
class Categoria extends Entity
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
        'articulos' => true,
        'subcategorias' => true,
    ];
}
