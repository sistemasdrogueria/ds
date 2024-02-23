<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * NotasCabecera Entity
 *
 * @property int $id
 * @property \Cake\I18n\Time $fecha
 * @property int $cliente_id
 * @property int $nota
 * @property string $letra
 * @property int $comprobante_id
 * @property string $tipo
 * @property float $imp_exento
 * @property float $imp_gravado
 * @property float $imp_iva
 * @property float $imp_rg3337
 * @property float $imp_ingreso_bruto
 * @property float $total
 * @property int $estado
 *
 * @property \App\Model\Entity\Cliente $cliente
 * @property \App\Model\Entity\Comprobante $comprobante
 */
class NotasCabecera extends Entity
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
