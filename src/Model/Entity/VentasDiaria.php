<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * VentasDiaria Entity
 *
 * @property int $id
 * @property int $cliente_id
 * @property \Cake\I18n\Date $fecha
 * @property int $items
 * @property float $i_1
 * @property int $u_1
 * @property float $i_2
 * @property int $u_2
 * @property float $i_3
 * @property int $u_3
 * @property float $i_4
 * @property int $u_4
 * @property float $i_5
 * @property int $u_5
 * @property float $i_6
 * @property int $u_6
 * @property float $i_7
 * @property int $u_7
 * @property float $transfer
 * @property \Cake\I18n\Time $creado
 * @property \Cake\I18n\Time $modificado
 *
 * @property \App\Model\Entity\Cliente $cliente
 */
class VentasDiaria extends Entity
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
        'id' => false
    ];
}
