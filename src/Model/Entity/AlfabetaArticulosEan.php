<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AlfabetaArticulosEan Entity
 *
 * @property int $id
 * @property int $alfabeta_articulo_id
 * @property string $codigo_barra
 * @property \Cake\I18n\Time $creado
 *
 * @property \App\Model\Entity\AlfabetaArticulo $alfabeta_articulo
 */
class AlfabetaArticulosEan extends Entity
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
        'codigo_barra' => true,
        'creado' => true,
        'alfabeta_articulo' => true
    ];
}
