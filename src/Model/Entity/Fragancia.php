<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Fragancia Entity.
 *
 * @property int $id
 * @property string $nombre
 * @property string $imagen
 * @property int $marca_id
 * @property \App\Model\Entity\Marca $marca
 * @property int $genero_id
 * @property \App\Model\Entity\Genero $genero
 * @property bool $eliminado
 * @property \Cake\I18n\Time $creado
 */
class Fragancia extends Entity
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
        '*' => true
      
    ];
}
