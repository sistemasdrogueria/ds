<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ClientesAlta Entity
 *
 * @property int $id
 * @property string $razon_social
 * @property string $nombre_fantasia
 * @property string $domicilio
 * @property int $localidad
 * @property string $codigo_postal
 * @property int $provincia
 * @property string $telefono
 * @property string $celular
 * @property string $email
 * @property string $inicio_actividad
 * @property string $farmaceutico_nombre
 * @property string $farmaceutico_matricula
 * @property string $gln
 * @property string $cuit
 * @property string $comentario
 * @property \Cake\I18n\Time $creado
 */
class ClientesAlta extends Entity
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
        'razon_social' => true,
        'nombre_fantasia' => true,
        'domicilio' => true,
        'localidad' => true,
        'codigo_postal' => true,
        'provincia' => true,
        'telefono' => true,
        'celular' => true,
        'email' => true,
        'inicio_actividad' => true,
        'farmaceutico_nombre' => true,
        'farmaceutico_matricula' => true,
        'gln' => true,
        'cuit' => true,
        'comentario' => true,
        'creado' => true
    ];
}
