<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Job Entity
 *
 * @property int $id
 * @property string $titulo
 * @property string $descripcion
 * @property int $puesto_id
 * @property \Cake\I18n\Date $fecha
 * @property \Cake\I18n\Time $creado
 * @property bool $activo
 * @property int $cantidad_vacante
 * @property string $requerimiento
 *
 * @property \App\Model\Entity\Puesto $puesto
 */
class Job extends Entity
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
        'titulo' => true,
        'tareas' => true,
        'puesto_id' => true,
		'sector_id' => true,
        'fecha' => true,
        'creado' => true,
        'activo' => true,
		'sexo' => true,
		'edad' => true,
		'horario' => true,
		'nivel_educacion' => true,
		'disponibilidad' => true,
		'tareas' => true,
        'cantidad_vacante' => true,
        'requerimiento' => true,
        'puesto' => true
    ];
}
