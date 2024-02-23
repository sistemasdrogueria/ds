<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FraganciasPresentacione Entity.
 *
 * @property int $id
 * @property int $articulo_id
 * @property \App\Model\Entity\Articulo $articulo
 * @property int $fragancia_id
 * @property \App\Model\Entity\Fragancia $fragancia
 * @property string $detalle
 * @property \Cake\I18n\Time $creado
 */
class FraganciasPresentacione extends Entity
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
    ];
}
