<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ReclamosTipo Entity.
 */
class ReclamosTipo extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'nombre' => true,
        'reclamos' => true,
    ];
}
