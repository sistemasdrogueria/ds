<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Grupo Entity
 *
 * @property int $id
 * @property string $nombre
 * @property string $descripcion
 * @property int $subcategoria_id
 *
 * @property \App\Model\Entity\Subcategoria $subcategoria
 * @property \App\Model\Entity\Articulo[] $articulos
 * @property \App\Model\Entity\Cliente[] $clientes
 * @property \App\Model\Entity\Subgrupo[] $subgrupos
 * @property \App\Model\Entity\CtacteTipoPago[] $ctacte_tipo_pagos
 */
class Grupo extends Entity
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
        'id' => true,
        'nombre' => true,
        'descripcion' => true,
        'imagen' => true,
        'grupos_tipos_id'=>true,
        'subcategoria_id' => true,
        'subcategoria' => true,
        'articulos' => true,
        'subgrupos' => true,

    ];
}
