<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TransfersImport Entity
 *
 * @property int $id
 * @property int $transfer_files_laboratorio_id
 * @property string $nombre_file
 * @property int $proveedor_id
 * @property \Cake\I18n\Time $importado
 * @property \Cake\I18n\Time $procesado
 * @property \Cake\I18n\Time $facturado
 * @property int $estado
 * @property \Cake\I18n\Time $creado
 *
 * @property \App\Model\Entity\TransferFilesLaboratorio $transfer_files_laboratorio
 * @property \App\Model\Entity\Proveedor $proveedor
 */
class TransfersImport extends Entity
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
        'transfers_files_laboratorio_id' => true,
        'nombre_file' => true,
        'proveedor_id' => true,
        'importado' => true,
        'procesado' => true,
        'facturado' => true,
        'estado' => true,
        'creado' => true,
   
        'proveedor' => true
    ];
}
