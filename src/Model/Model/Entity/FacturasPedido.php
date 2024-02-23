<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FacturasPedido Entity.
 */
class FacturasPedido extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'cliente_id' => true,
        'pedido_id' => true,
        'pedido_fecha' => true,
        'pedido_ds_numero' => true,
        'pedido_tipo' => true,
        'envio_numero' => true,
        'envio_fecha' => true,
        'recibido_fecha' => true,
        'estado' => true,
        'codigo_operadora' => true,
        'remito_numero' => true,
        'factura_numero' => true,
        'factura_fecha' => true,
        'factura_tipo_elegida' => true,
        'factura_tipo_aplicada' => true,
        'factura_tipo_elegida_descuento' => true,
        'factura_tipo_aplicada_descuento' => true,
        'factura_tipo_elegida_vencimiento' => true,
        'factura_tipo_aplicada_vencimiento' => true,
        'combo' => true,
        'combo_fecha_vigencia' => true,
        'mensaje' => true,
        'mensaje_pedido' => true,
        'exento_total' => true,
        'exento_descuento' => true,
        'gravado_total' => true,
        'gravado_descuento' => true,
        'iva' => true,
        'perc_rg3337' => true,
        'ingreso_brutos' => true,
        'total' => true,
        'total_items' => true,
        'total_unidades' => true,
        'cliente' => true,
        'pedido' => true,
    ];
}
