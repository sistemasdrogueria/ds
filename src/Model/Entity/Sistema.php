<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
/**
 * Sistema Entity
 *
 * @property int $id
 * @property string $nombre
 * @property int $ean_init
 * @property int $ean_long
 * @property int $cantidad_init
 * @property int $cantidad_long
 * @property int $descripcion_init
 * @property int $descripcion_long
 * @property string $old
 *
 * @property \App\Model\Entity\ClientesConfiguracione[] $clientes_configuraciones
 */
class Sistema extends Entity
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
        'nombre' => true,
        'ean_init' => true,
        'ean_long' => true,
        'cantidad_init' => true,
        'cantidad_long' => true,
        'descripcion_init' => true,
        'descripcion_long' => true,
        'old' => true,
        'clientes_configuraciones' => true
    ];}
