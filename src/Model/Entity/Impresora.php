<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Impresora Entity
 *
 * @property int $id
 * @property string $modelo
 * @property string $marca
 * @property string $sector
 * @property string $ip
 * @property int $sistema
 * @property \Cake\I18n\Time $creado
 * @property \Cake\I18n\Time $modificado
 */
class Impresora extends Entity
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
        'modelo' => true,
        'marca' => true,
        'sector' => true,
        'ip' => true,
        'sistema' => true,
        'creado' => true,
        'modificado' => true
    ];
}
