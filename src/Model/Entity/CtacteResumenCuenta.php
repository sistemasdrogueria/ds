<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CtacteResumenCuenta Entity
 *
 * @property int $id
 * @property int $nro_sistema
 * @property int $nro_semana
 * @property \Cake\I18n\Date $desde
 * @property \Cake\I18n\Date $hasta
 */
class CtacteResumenCuenta extends Entity
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
        'nro_sistema' => true,
        'nro_semana' => true,
        'desde' => true,
        'hasta' => true
    ];
}
