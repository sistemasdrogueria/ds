<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Pedido Entity.
 */
class Pedido extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'creado' => true,
        'cliente_id' => true,
        'sucursal_id' => true,
        'tipo_fact' => true,
        'cliente' => true,
        'sucursal' => true,
		'forma_envio' => true,
		'impreso'=>true,
    ];
		
}
