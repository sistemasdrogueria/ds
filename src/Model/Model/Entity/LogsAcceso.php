<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LogsAcceso Entity.
 */
class LogsAcceso extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'fecha' => true,
        'usuario_id' => true,
        'ip' => true,
        'super' => true,
    ];
}
