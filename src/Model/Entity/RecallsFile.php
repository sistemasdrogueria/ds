<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RecallsFile Entity
 *
 * @property int $id
 * @property string $name
 * @property int $recall_id
 * @property string $tipo
 * @property string $file
 * @property string $path
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property int $status
 *
 * @property \App\Model\Entity\Recall $recall
 */
class RecallsFile extends Entity
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
        'name' => true,
        'recall_id' => true,
        'tipo' => true,
        'file' => true,
        'path' => true,
        'created' => true,
        'modified' => true,
        'status' => true,
        'recall' => true
    ];
}
