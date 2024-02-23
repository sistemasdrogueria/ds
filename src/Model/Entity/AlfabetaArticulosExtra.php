<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AlfabetaArticulosExtra Entity
 *
 * @property int $id
 * @property int $alfabeta_articulo_id
 * @property int $articulo_id
 * @property int $alfabeta_tamano_id
 * @property int $alfabeta_accion_far_id
 * @property int $alfabeta_monodroga_id
 * @property int $alfabeta_forma_id
 * @property string $potencia
 * @property int $alfabeta_unidad_potencia_id
 * @property int $alfabeta_tipo_unidad_id
 * @property int $alfabeta_vias
 * @property \Cake\I18n\Time $creado
 *
 * @property \App\Model\Entity\AlfabetaArticulo $alfabeta_articulo
 * @property \App\Model\Entity\Articulo $articulo
 * @property \App\Model\Entity\AlfabetaTamano $alfabeta_tamano
 * @property \App\Model\Entity\AlfabetaAccionFar $alfabeta_accion_far
 * @property \App\Model\Entity\AlfabetaMonodroga $alfabeta_monodroga
 * @property \App\Model\Entity\AlfabetaForma $alfabeta_forma
 * @property \App\Model\Entity\AlfabetaUnidadPotencia $alfabeta_unidad_potencia
 * @property \App\Model\Entity\AlfabetaTipoUnidad $alfabeta_tipo_unidad
 */
class AlfabetaArticulosExtra extends Entity
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
        'alfabeta_articulo_id' => true,
        'articulo_id' => true,
        'alfabeta_tamano_id' => true,
        'alfabeta_accion_far_id' => true,
        'alfabeta_monodroga_id' => true,
        'alfabeta_forma_id' => true,
        'potencia' => true,
        'alfabeta_unidad_potencia_id' => true,
        'alfabeta_tipo_unidad_id' => true,
        'alfabeta_vias' => true,
        'creado' => true,
        'alfabeta_articulo' => true,
        'articulo' => true,
        'alfabeta_tamano' => true,
        'alfabeta_accion_far' => true,
        'alfabeta_monodroga' => true,
        'alfabeta_forma' => true,
        'alfabeta_unidad_potencia' => true,
        'alfabeta_tipo_unidad' => true
    ];
}
