<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * NotasCuerpo Entity
 *
 * @property int $id
 * @property int $nota_cabeceras_id
 * @property int $tipo
 * @property int $nota_ds
 * @property int $articulo_id
 * @property bool $iva
 * @property int $cantidad
 * @property float $precio_unitario
 * @property string $descripcion
 * @property int $pedido_ds
 * @property \Cake\I18n\Time $creado
 *
 * @property \App\Model\Entity\NotasCabecera $notas_cabecera
 * @property \App\Model\Entity\Articulo $articulo
 */
class NotasCuerpo extends Entity
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
