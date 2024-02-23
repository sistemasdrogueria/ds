<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CarritosTransfer Entity
 *
 * @property int $id
 * @property int $cliente_id
 * @property int $articulo_id
 * @property string $descripcion
 * @property int $cantidad
 * @property float $precio_publico
 * @property float $descuento
 * @property int $unidad_minima
 * @property string $tipo_precio
 * @property string $plazoley_dcto
 * @property int $combo_id
 * @property string $tipo_oferta
 * @property string $tipo_oferta_elegida
 * @property string $tipo_fact
 * @property \Cake\I18n\Time $creado
 * @property \Cake\I18n\Time $modificado
 * @property int $categoria_id
 * @property int $compra_min
 * @property int $compra_multiplo
 * @property int $compra_max
 * @property int $compra_cerrado
 * @property int $proveedor_id
 * @property int $transfer_proveedor_id
 * @property int $nro_transfer
 *
 * @property \App\Model\Entity\Combo $combo
 * @property \App\Model\Entity\Cliente $cliente
 * @property \App\Model\Entity\Articulo $articulo
 * @property \App\Model\Entity\Categoria $categoria
 * @property \App\Model\Entity\Proveedor $proveedor
 * @property \App\Model\Entity\TransferProveedor $transfer_proveedor
 */
class CarritosTransfer extends Entity
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
        'cliente_id' => true,
        'articulo_id' => true,
        'descripcion' => true,
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
        'creado' => true,
        'modificado' => true,
        'categoria_id' => true,
        'compra_min' => true,
        'compra_multiplo' => true,
        'compra_max' => true,
        'compra_cerrado' => true,
        'combo' => true,
        'proveedor_id' => true,
        'transfer_proveedor_id' => true,
        'nro_transfer' => true,
        'cliente' => true,
        'articulo' => true,
        'categoria' => true,
        'proveedor' => true,
        'transfer_proveedor' => true
    ];
}
