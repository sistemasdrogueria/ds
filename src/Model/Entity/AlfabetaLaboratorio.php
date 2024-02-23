<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AlfabetaLaboratorio Entity
 *
 * @property int $id
 * @property string $nombre
 * @property int $codigo
 * @property bool $eliminado
 *
 * @property \App\Model\Entity\AlfabetaArticulo[] $alfabeta_articulos
 */
class AlfabetaLaboratorio extends Entity
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
        'nombre' => true,
        'codigo' => true,
        'eliminado' => true,
        'alfabeta_articulos' => true
    ];
}
