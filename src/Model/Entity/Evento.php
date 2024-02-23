<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Evento Entity
 *
 * @property int $id
 * @property string $nombre
 * @property int $lugar
 * @property \Cake\I18n\Time $fecha
 * @property int $cantidad_fotos
 * @property string $carpeta_fotos
 * @property \Cake\I18n\Time $creado
 */
class Evento extends Entity
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
        'lugar' => true,
        'fecha' => true,
        'cantidad_fotos' => true,
        'carpeta_fotos' => true,
        'creado' => true
    ];
}
