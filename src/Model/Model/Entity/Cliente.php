<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Cliente Entity.
 */
class Cliente extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'codigo' => true,
        'razon_social' => true,
        'cuit' => true,
        'nombre' => true,
        'codigo_postal' => true,
        'domicilio' => true,
        'provincia_id' => true,
        'localidad_id' => true,
        'telefono' => true,
        'tienesucursal' => true,
        'representante_id' => true,
        'email' => true,
        'email_alternativo' => true,
        'clave_pedidos' => true,
        'codigo_pedidos' => true,
        'ofertaxmail' => true,
        'respuestaxmail' => true,
		'actualizo_correo'=> true,
        'clacli' => true,
        'provincia' => true,
        'localidad' => true,
        'representante' => true,
        'carritos' => true,
        'facturas_pedidos' => true,
        'logs_accesos' => true,
        'pedidos' => true,
        'reclamos' => true,
        'sucursals' => true,
        'usuarios' => true,
    ];
}
