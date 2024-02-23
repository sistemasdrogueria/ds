<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CarritosItem Entity.
 */
class CarritosItem extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'agregado' => true,
        'carrito_id' => true,
        'articulo_id' => true,
        'cantidad' => true,
        'precio_publico' => true,
        'descuento' => true,
        'unidad_minima' => true,
        'tipo_precio' => true,
        'plazoley_dcto' => true,
        'combo_id' => true,
        'tipo_oferta' => true,
        'tipo_oferta_elegida' => true,
        'tipo_fact' => true,
        'carrito' => true,
        'articulo' => true,
        'combo' => true,
    ];
}
