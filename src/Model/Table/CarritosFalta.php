<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CarritosFalta Entity
 *
 * @property int $id
 * @property int $cliente_id
 * @property int $articulo_id
 * @property string $descripcion
 * @property int $cantidad
 * @property float $precio_publico
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
 * @property int $descuento_id
 * @property int $multiplo
 * @property int $combo_tipo_id
 * @property int $cantidad_solicitada
 *
 * @property \App\Model\Entity\Descuento $descuento
 * @property \App\Model\Entity\Cliente $cliente
 * @property \App\Model\Entity\Articulo $articulo
 * @property \App\Model\Entity\Combo $combo
 * @property \App\Model\Entity\Categoria $categoria
 * @property \App\Model\Entity\ComboTipo $combo_tipo
 */
class CarritosFalta extends Entity
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
        'descuento_id' => true,
        'multiplo' => true,
        'combo_tipo_id' => true,
        'cantidad_solicitada' => true,
        'cliente' => true,
        'articulo' => true,
        'combo' => true,
        'categoria' => true,
        'combo_tipo' => true
    ];
}
