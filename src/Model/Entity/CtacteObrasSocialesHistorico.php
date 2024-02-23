<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CtacteObrasSocialesHistorico Entity
 *
 * @property int $id
 * @property int $cliente_id
 * @property \Cake\I18n\Time $fecha
 * @property float $importe
 * @property int $obra_social_id
 * @property int $nro_nota
 * @property int $tipo_nota
 *
 * @property \App\Model\Entity\Cliente $cliente
 * @property \App\Model\Entity\ObraSocial $obra_social
 */
class CtacteObrasSocialesHistorico extends Entity
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
        'id' => false
    ];
}
