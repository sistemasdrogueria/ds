<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;/**
 * ClientesNovedade Entity
 *
 * @property int $id
 * @property string $titulo
 * @property string $descripcion
 * @property int $clientes_novedades_tipos_id
 * @property string $img_file
 * @property \Cake\I18n\Date $fecha
 * @property bool $activo
 * @property \Cake\I18n\Time $creado
 *
 * @property \App\Model\Entity\ClientesNovedadesTipo $clientes_novedades_tipo
 */
class ClientesNovedade extends Entity
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
        'descripcion' => true,
        'clientes_novedades_tipos_id' => true,
        'img_file' => true,
        'fecha' => true,
        'activo' => true,
        'creado' => true,
        'clientes_novedades_tipo' => true
    ];

}
