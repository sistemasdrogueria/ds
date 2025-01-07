<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;


class Outlet extends Entity
{

   
    protected $_accessible = [
        '*' => true,
        'id' => true,
    ];
}
