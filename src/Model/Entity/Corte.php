<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Corte Entity
 *
 * @property int $id
 * @property string $codigo
 * @property int $provincia_id
 * @property \Cake\I18n\Time $hora_n
 * @property \Cake\I18n\Time $hora_d
 * @property int $dia_n
 * @property int $dia_d
 * @property \Cake\I18n\Time $proximo_h
 * @property int $proximo_d
 * @property int $salida_n_id
 * @property int $salida_d_id
 *
 * @property \App\Model\Entity\Provincia $provincia
 * @property \App\Model\Entity\SalidaN $salida_n
 * @property \App\Model\Entity\SalidaD $salida_d
 */
class Corte extends Entity
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
        
        'hora_n' => true,
        'hora_d' => true,
        'hora_f' => true,
        'dia_n' => true,
        'dia_d' => true,
        'proximo_h' => true,
        'proximo_d' => true,
        'salida_n_id' => true,
        'salida_d_id' => true,
        'salida_f_id' => true,
        'salida_n' => true,
        'salida_d' => true,
        'salida_f' => true
    ];
}
