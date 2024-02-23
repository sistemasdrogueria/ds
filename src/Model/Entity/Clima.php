<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Clima Entity
 *
 * @property int $id
 * @property string $nombre
 * @property int $transporte_id
 * @property int $localidad_id
 * @property string $url
 * @property \Cake\I18n\Time $creado
 * @property int $orden
 *
 * @property \App\Model\Entity\Transporte $transporte
 * @property \App\Model\Entity\Localidad $localidad
 */
class Clima extends Entity
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
        'transporte_id' => true,
        'localidad_id' => true,
        'url' => true,
        'creado' => true,
        'orden' => true,
        'transporte' => true,
        'localidad' => true,
        'localidad_id_api' => true,
        'provincia_id_api' => true
    ];
}
