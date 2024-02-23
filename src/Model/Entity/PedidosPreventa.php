<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PedidosPreventa Entity
 *
 * @property int $id
 * @property \Cake\I18n\Time $creado
 * @property int $cliente_id
 * @property int $sucursal_id
 * @property string $tipo_fact
 * @property int $forma_envio
 * @property int $estado_id
 * @property string $comentario
 * @property string $oferta_plazo
 * @property int $nro_pedido_ds
 * @property int $pedidos_status_id
 * @property int $cantidad_item
 * @property \Cake\I18n\Time $procesado
 * @property int $impreso
 * @property bool $finalizado
 *
 * @property \App\Model\Entity\Cliente $cliente
 * @property \App\Model\Entity\Sucursal $sucursal
 * @property \App\Model\Entity\Estado $estado
 * @property \App\Model\Entity\PedidosStatus $pedidos_status
 */
class PedidosPreventa extends Entity
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
        'creado' => true,
        'cliente_id' => true,
        'sucursal_id' => true,
        'tipo_fact' => true,
        'forma_envio' => true,
        'estado_id' => true,
        'comentario' => true,
        'oferta_plazo' => true,
        'nro_pedido_ds' => true,
        'pedidos_status_id' => true,
        'cantidad_item' => true,
        'procesado' => true,
        'impreso' => true,
        'finalizado' => true,
        'cliente' => true,
        'sucursal' => true,
        'estado' => true,
        'pedidos_status' => true
    ];
}
