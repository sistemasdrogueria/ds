<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Curriculum Entity
 *
 * @property int $id
 * @property string $nombres
 * @property string $apellidos
 * @property string $tipo_documento
 * @property string $documento
 * @property string $email
 * @property \Cake\I18n\Date $fecha_nacimiento
 * @property int $puesto_id
 * @property string $archivo_cv
 * @property string $foto
 *
 * @property \App\Model\Entity\Puesto $puesto
 */
class Curriculum extends Entity
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
        'nombres' => true,
        'apellidos' => true,
        'tipo_documento' => true,
        'documento' => true,
        'telefono_cod'=>true,
        'telefono'=>true,
        'email' => true,
        'fecha_nacimiento' => true,
        'ciudad_residencia'=>true,
        'ciudad_residencia_provincia_id'=>true,
        'ciudad_residencia_cp'=>true,
		'sector_id'=>true,
        'archivo_cv' => true

    ];
}
