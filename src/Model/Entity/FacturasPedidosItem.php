<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FacturasPedidosItem Entity.
 */
class FacturasPedidosItem extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'facturas_pedido_id' => true,
        'nro_envio' => true,
        'troquel' => true,
        'descripcion' => true,
        'cantidad_pedida' => true,
        'cantidad_facturada' => true,
        'precio_facturado' => true,
        'desc_aplicado' => true,
        'estado_stock' => true,
        'nro_pedido_dsur' => true,
        'facturas_pedido' => true,
    ];
}
