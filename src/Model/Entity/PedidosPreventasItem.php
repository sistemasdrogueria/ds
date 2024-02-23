<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PedidosPreventasItem Entity
 *
 * @property int $id
 * @property \Cake\I18n\Time $agregado
 * @property int $pedido_id
 * @property int $articulo_id
 * @property float $cantidad
 * @property float $precio_publico
 * @property float $descuento
 * @property int $unidad_minima
 * @property string $tipo_precio
 * @property string $plazoley_dcto
 * @property int $combo_id
 * @property string $tipo_oferta
 * @property string $tipo_oferta_elegida
 * @property string $tipo_fact
 * @property int $cantidad_facturada
 * @property int $nro_pedido_ds
 * @property int $pedidos_items_status_id
 * @property \Cake\I18n\Time $procesado
 *
 * @property \App\Model\Entity\Pedido $pedido
 * @property \App\Model\Entity\Articulo $articulo
 * @property \App\Model\Entity\Combo $combo
 * @property \App\Model\Entity\PedidosItemsStatus $pedidos_items_status
 */
class PedidosPreventasItem extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'agregado' => true,
        'pedidos_preventa_id' => true,
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
        'cantidad_facturada' => true,
        'nro_pedido_ds' => true,
        'pedidos_items_status_id' => true,
        'procesado' => true,
        'pedidos_preventa' => true,
        'articulo' => true,
        'combo' => true,
        'pedidos_items_status' => true
    ];
}
