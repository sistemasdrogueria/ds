<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AlfabetaCategoria Entity
 *
 * @property int $id
 * @property string $codigo
 * @property string $nombre
 * @property string $descripcion
 *
 * @property \App\Model\Entity\AlfabetaArticulo[] $alfabeta_articulos
 */
class AlfabetaCategoria extends Entity
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
        'codigo' => true,
        'nombre' => true,
        'descripcion' => true,
        'alfabeta_articulos' => true
    ];
}
