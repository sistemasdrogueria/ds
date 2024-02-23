<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Publication Entity
 *
 * @property int $id
 * @property string $descripcion
 * @property string $url_controlador
 * @property string $url_metodo
 * @property string $url_campo
 * @property \Cake\I18n\Date $fecha_desde
 * @property \Cake\I18n\Date $fecha_hasta
 * @property string $imagen
 * @property int $habilitada
 */
class Publication extends Entity
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
