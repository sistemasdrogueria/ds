<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Articulo Entity.
 */
class Articulo extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'troquel' => true,
        'descripcion_sist' => true,
        'descripcion_pag' => true,
        'categoria_id' => true,
        'subcategoria_id' => true,
        'codigo_barras' => true,
        'laboratorio_id' => true,
        'precio_publico' => true,
        'precio_final' => true,
        'stock' => true,
        'cadena_frio' => true,
        'iva' => true,
        'msd' => true,
        'clave_amp' => true,
        'trazable' => true,
        'pack' => true,
        'categoria' => true,
        'subcategoria' => true,
        'laboratorio' => true,
        'carritos_items' => true,
        'descuentos' => true,
        'ofertas' => true,
        'pedidos_items' => true,
         'fv_cerca'=> true,
        'fv'=> true,
		'pedidos_preventas_items' => true,
        'reclamos_items' => true,
    ];
}
