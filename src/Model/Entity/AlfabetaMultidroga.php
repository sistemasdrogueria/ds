<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AlfabetaMultidroga Entity
 *
 * @property int $id
 * @property int $alfabeta_articulo_id
 * @property int $articulo_id
 * @property int $alfabeta_nueva_droga_id
 * @property string $potencia
 * @property int $alfabeta_unidad_potencia_id
 *
 * @property \App\Model\Entity\AlfabetaArticulo $alfabeta_articulo
 * @property \App\Model\Entity\Articulo $articulo
 * @property \App\Model\Entity\AlfabetaNuevaDroga $alfabeta_nueva_droga
 * @property \App\Model\Entity\AlfabetaUnidadPotencia $alfabeta_unidad_potencia
 */
class AlfabetaMultidroga extends Entity
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
        'alfabeta_nueva_droga_id' => true,
        'potencia' => true,
        'alfabeta_unidad_potencia_id' => true,
        'alfabeta_articulo' => true,
        'articulo' => true,
        'alfabeta_nueva_droga' => true,
        'alfabeta_unidad_potencia' => true
    ];
}
