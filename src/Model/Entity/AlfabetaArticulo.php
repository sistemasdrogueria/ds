<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AlfabetaArticulo Entity
 *
 * @property int $id
 * @property string $troquel
 * @property string $nombre
 * @property string $presentacion
 * @property int $alfabeta_laboratorio_id
 * @property float $precio
 * @property \Cake\I18n\Time $fecha
 * @property int $alfabeta_categoria_id
 * @property bool $importado
 * @property int $alfabeta_tipo_venta_id
 * @property bool $iva
 * @property bool $baja
 * @property string $codigo_barra
 * @property int $articulo_id
 * @property int $unidad
 * @property string $tamano
 * @property bool $cadena_frio
 * @property int $chequeo
 * @property string $gtin
 * @property int $eliminado
 * @property \Cake\I18n\Time $creado
 *
 * @property \App\Model\Entity\AlfabetaLaboratorio $alfabeta_laboratorio
 * @property \App\Model\Entity\AlfabetaCategoria $alfabeta_categoria
 * @property \App\Model\Entity\AlfabetaTipoVenta $alfabeta_tipo_venta
 * @property \App\Model\Entity\Articulo $articulo
 * @property \App\Model\Entity\AlfabetaArticulosEan[] $alfabeta_articulos_eans
 * @property \App\Model\Entity\AlfabetaArticulosExtra[] $alfabeta_articulos_extras
 * @property \App\Model\Entity\AlfabetaMultidroga[] $alfabeta_multidrogas
 */
class AlfabetaArticulo extends Entity
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
        'troquel' => true,
        'nombre' => true,
        'presentacion' => true,
        'alfabeta_laboratorio_id' => true,
        'precio' => true,
        'fecha' => true,
        'alfabeta_categoria_id' => true,
        'importado' => true,
        'alfabeta_tipo_venta_id' => true,
        'iva' => true,
        'baja' => true,
        'codigo_barra' => true,
        'articulo_id' => true,
        'unidad' => true,
        'tamano' => true,
        'cadena_frio' => true,
        'chequeo' => true,
        'gtin' => true,
        'eliminado' => true,
        'creado' => true,
        'alfabeta_laboratorio' => true,
        'alfabeta_categoria' => true,
        'alfabeta_tipo_venta' => true,
        'articulo' => true,
        'alfabeta_articulos_eans' => true,
        'alfabeta_articulos_extras' => true,
        'alfabeta_multidrogas' => true
    ];
}
