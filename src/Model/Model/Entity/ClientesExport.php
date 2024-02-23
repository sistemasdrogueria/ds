<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ClientesExport Entity.
 *
 * @property int $id
 * @property int $cta_comun
 * @property int $cta_exportacion
 * @property int $cliente_comun_id
 * @property \App\Model\Entity\ClienteComun $cliente_comun
 * @property int $cliente_export_id
 * @property \App\Model\Entity\ClienteExport $cliente_export
 */
class ClientesExport extends Entity
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
        '*' => true,
        'id' => false,
    ];
}
