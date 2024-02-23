<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TransfersFilesLaboratorio Entity
 *
 * @property int $id
 * @property string $nombre_laboratorio
 * @property string $numero_pedido_proveedor
 * @property string $numero_posicion
 * @property string $status
 * @property string $fecha_factura
 * @property string $drogueria
 * @property string $lab
 * @property string $numero_pedido
 * @property string $fecha_transfer
 * @property string $cliente
 * @property string $nombre
 * @property string $ean
 * @property string $descripcion
 * @property string $unidades
 * @property string $descuento
 * @property string $contacto
 * @property string $telefono
 * @property string $cuit
 * @property string $domicilio
 * @property string $codigo_postal
 * @property string $localidad
 * @property string $provincia
 * @property string $transfer
 * @property string $plazo
 * @property int $nro_lote
 * @property int $proveedor_id
 * @property \Cake\I18n\Time $creado
 *
 * @property \App\Model\Entity\Proveedor $proveedor
 */
class TransfersFilesLaboratorio extends Entity
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
        'nombre_laboratorio' => true,
        'numero_pedido_proveedor' => true,
        'numero_posicion' => true,
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
        'transfer' => true,
        'plazo' => true,
        'nro_lote' => true,
        'proveedor_id' => true,
        'creado' => true,
        'proveedor' => true
    ];
}
