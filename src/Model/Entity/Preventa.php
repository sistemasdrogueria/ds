<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Preventa Entity
 *
 * @property int $id
 * @property int $articulo_id
 * @property \Cake\I18n\Date $fecha_desde
 * @property \Cake\I18n\Date $fecha_hasta
 * @property string $tipo_oferta
 * @property string $tipo_venta
 * @property string $tipo_precio
 * @property int $uni_min
 * @property int $uni_max
 * @property int $uni_tope
 * @property float $dto_drogueria
 * @property string $plazo
 * @property string $discrimina_iva
 * @property int $chequeo
 *
 * @property \App\Model\Entity\Articulo $articulo
 * @property \App\Model\Entity\Carrito[] $carritos
 * @property \App\Model\Entity\Pedido[] $pedidos
 */
class Preventa extends Entity
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
	    //'id' => true,
        'articulo_id' => true,
        'fecha_desde' => true,
        'fecha_hasta' => true,
        'tipo_oferta' => true,
        'tipo_venta' => true,
        'tipo_precio' => true,
        'uni_min' => true,
        'uni_max' => true,
        'uni_tope' => true,
        'dto_drogueria' => true,
        'plazo' => true,
        'discrimina_iva' => true,
        'chequeo' => true,
        'articulo' => true,
        'proveedor_id'=>true,
		'combo'=>true,
		
    ];
}
