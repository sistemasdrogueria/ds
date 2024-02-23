<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FacturasCuerposItemsLotesVcto Entity
 *
 * @property int $id
 * @property int $nota
 * @property int $articulo_id
 * @property string $serie
 * @property string $lote
 * @property \Cake\I18n\Date $vencimiento
 * @property string $cantidad
 * @property \Cake\I18n\Date $fecha
 * @property int $cliente_id
 * @property \Cake\I18n\Time $created
 *
 * @property \App\Model\Entity\Articulo $articulo
 * @property \App\Model\Entity\Cliente $cliente
 */
class FacturasCuerposItemsLotesVcto extends Entity
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
        'nota' => true,
        'articulo_id' => true,
        'serie' => true,
        'lote' => true,
        'vencimiento' => true,
        'cantidad' => true,
        'fecha' => true,
        'cliente_id' => true,
        'created' => true,
        'articulo' => true,
        'cliente' => true
    ];
}
