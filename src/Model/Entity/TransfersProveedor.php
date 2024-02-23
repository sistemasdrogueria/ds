<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TransfersProveedor Entity
 *
 * @property int $id
 * @property int $numero_pedido_proveedor
 * @property int $status
 * @property \Cake\I18n\Date $fecha_factura
 * @property int $drogueria
 * @property int $lab
 * @property int $numero_pedido
 * @property \Cake\I18n\Time $fecha_transfer
 * @property int $cliente
 * @property string $nombre
 * @property string $ean
 * @property string $descripcion
 * @property int $unidades
 * @property float $descuento
 * @property string $contacto
 * @property string $telefono
 * @property string $cuit
 * @property string $domicilio
 * @property int $codigo_postal
 * @property string $localidad
 * @property string $provincia
 * @property \Cake\I18n\Time $creado
 * @property int $proveedor_id
 *
 * @property \App\Model\Entity\Proveedor $proveedor
 */
class TransfersProveedor extends Entity
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
        'numero_pedido_proveedor' => true,
        'numero_posicion'=>true,
        'status' => true,
        'fecha_factura' => true,
        'drogueria' => true,
        'lab' => true,
        'numero_pedido' => true,
        'fecha_transfer' => true,
        'cliente' => true,
        'nombre' => true,
        'ean' => true,
        'descripcion' => true,
        'unidades' => true,
        'descuento' => true,
        'contacto' => true,
        'telefono' => true,
        'cuit' => true,
        'domicilio' => true,
        'codigo_postal' => true,
        'localidad' => true,
        'provincia' => true,
        'creado' => true,
        'proveedor_id' => true,
        'proveedor' => true
    ];
}
