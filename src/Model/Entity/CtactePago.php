<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CtactePago Entity.
 *
 * @property int $id
 * @property int $cliente_id
 * @property \App\Model\Entity\Cliente $cliente
 * @property string $detalle
 * @property \Cake\I18n\Time $fecha_ingreso
 * @property \Cake\I18n\Time $fecha_aplicacion
 * @property int $nota
 * @property int $signo
 * @property float $importe
 * @property bool $chequeo
 */
class CtactePago extends Entity
{

}
