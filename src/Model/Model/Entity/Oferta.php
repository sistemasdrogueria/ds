<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Oferta Entity.
 *
 * @property int $id
 * @property int $articulo_id
 * @property \App\Model\Entity\Articulo $articulo
 * @property string $descripcion
 * @property string $detalle
 * @property string $busqueda
 * @property float $descuento_producto
 * @property int $unidades_minimas
 * @property \Cake\I18n\Time $fecha_desde
 * @property \Cake\I18n\Time $fecha_hasta
 * @property string $plazos
 * @property int $oferta_tipo_id
 * @property \App\Model\Entity\OfertasTipo $ofertas_tipo
 * @property int $unidades_maximas
 * @property string $imagen
 * @property int $activo
 * @property int $habilitada
 */
class Oferta extends Entity
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
        '*' => true,
        'id' => true,
    ];
}
