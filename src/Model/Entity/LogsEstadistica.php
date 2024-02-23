<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LogsEstadistica Entity
 *
 * @property int $id
 * @property \Cake\I18n\Time $fecha
 * @property int $cliente_id
 * @property int $user_id
 * @property string $ip
 * @property bool $super
 * @property string $seccion
 * @property int $permiso_id
 *
 * @property \App\Model\Entity\Cliente $cliente
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Permiso $permiso
 */
class LogsEstadistica extends Entity
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
        'fecha' => true,
        'cliente_id' => true,
        'user_id' => true,
        'ip' => true,
        'super' => true,
        'seccion' => true,
        'permiso_id' => true,
        'cliente' => true,
        'user' => true,
        'permiso' => true
    ];
}
