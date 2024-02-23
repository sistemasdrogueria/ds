<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PermisosPerfile Entity.
 */
class PermisosPerfile extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'perfiles_id' => true,
        'permisos_id' => true,
        'perfile' => true,
        'permiso' => true,
    ];
}
