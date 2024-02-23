<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Carrito Entity.
 */
class Carrito extends Entity
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
        'precio_publico' => true,
        'descuento' => true,
        'unidad_minima' => true,
        'tipo_precio' => true,
        'plazoley_dcto' => true,
        'combo_id' => true,
        'tipo_oferta' => true,
        'tipo_oferta_elegida' => true,
        'tipo_fact' => true,
		'tipo_venta' => true,
        'creado' => true,
        'modificado' => true,
        'cliente' => true,
        'articulo' => true,
        'combo' => true,
		'descripcion' =>true,
		'categoria_id' =>true,
		'compra_min'=>true,
		'compra_multiplo'=>true,
        'compra_max'=>true,
        'combo_tipo_id'=>true,
        'multiplo'=>true,
        'descuento_id'=>true,
        'user_id'=>true,

    ];
}
