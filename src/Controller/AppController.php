<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{/*
	public $helpers = [
    'Html' => [
        'className' => 'Bootstrap3.BootstrapHtml'
    ],
    'Form' => [
        'className' => 'Bootstrap3.BootstrapForm'
    ],
    'Paginator' => [
        'className' => 'Bootstrap3.BootstrapPaginator'
    ],
    'Modal' => [
        'className' => 'Bootstrap3.BootstrapModal'
    ]
];
	*/
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * @return void
     */
	public function initialize()
    {
		parent::initialize();
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
            'loginRedirect' => [
                'controller' => 'Users',
                'action' => 'index'
            ],
            'logoutRedirect' => [
                'controller' => 'Pages',
                'action' => 'display',
                'home'
            ],
			'authorize' => 'Controller'
        ]);
		
    }

    public function beforeFilter(Event $event)
    {
        $this->Auth->allow(['display','tienepermiso','view']);
		$this->Auth->config('authorize', ['Controller']);
    }
	
	public function tienepermiso($clase= null,$permiso = null){
		/*if ($tipo=='admin'),tipo=null&& $tipo=='client'
			return true;*/	
		$this->loadModel('Permisos');
		$permiso_list = $this->Permisos->find('all')->where(['nombre' => $permiso])->andWhere(['clase' => $clase]);
		$permiso_uno=$permiso_list->first();
        $this->loadModel('LogsEstadisticas');
				$logs = $this->LogsEstadisticas->newEntity();
				$logs['fecha'] = date('Y-m-d H:i:s');
				//debug(date('Y-m-d H:i:s'));
                $logs['user_id'] = $this->request->session()->read('Auth.User.id');
                $logs['cliente_id'] = $this->request->session()->read('Auth.User.cliente_id');
                $logs['permiso_id'] = $permiso_uno['id'];
				//$logs['ip'] = $this->request->clientIp(); 
				if ($this->LogsEstadisticas->save($logs))
				{
				}
        $this->loadModel('PermisosPerfiles');
        $tienepermisos = $this->PermisosPerfiles->find('all')
			->where(['perfiles_id' => $this->request->session()->read('Auth.User.perfile_id')])
			->andWhere(['permisos_id IN' => [$permiso_uno['id']]]);	
		if ($tienepermisos->count()>0 )
		{
			return true;	
		}
		else
		{
			return false;
		}
	}
}
