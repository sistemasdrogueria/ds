<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Recall Entity
 *
 * @property int $id
 * @property \Cake\I18n\Time $fecha
 * @property string $titulo
 * @property string $detalle
 * @property \Cake\I18n\Time $creado
 *
 * @property \App\Model\Entity\File[] $files
 */
class Recall extends Entity
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
        'titulo' => true,
        'detalle' => true,
        'creado' => true,
        'files' => true
    ];
}
