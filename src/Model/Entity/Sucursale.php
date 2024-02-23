<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Sucursale Entity.
 */
class Sucursale extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'cliente_id' => true,
        'razon_social' => true,
        'cuit' => true,
        'nombre' => true,
        'codigo_postal' => true,
        'domicilio' => true,
        'provincia_id' => true,
        'localidad_id' => true,
        'telefono' => true,
        'email' => true,
        'email_alternativo' => true,
        'clave_pedidos' => true,
        'codigo_pedidos' => true,
        'ofertaxmail' => true,
        'respuestaxmail' => true,
        'cliente' => true,
        'provincia' => true,
        'localidad' => true,
    ];
}
