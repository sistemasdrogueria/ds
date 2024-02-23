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

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Network\Email\Email;
/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController
{
	
    /**
     * Displays a view
     *
     * @return void|\Cake\Network\Response
     * @throws \Cake\Network\Exception\NotFoundException When the view file could not
     *   be found or \Cake\View\Exception\MissingTemplateException in debug mode.
     */
	 
	public function isAuthorized()
    {
         
		 if (in_array($this->request->action,['descargas'])) {
                return true;			
                //if($this->request->session()->read('Auth.User.role')=='client') 
            }		
			else 
			{		
				if (in_array($this->request->action,['display','home']))
				{
					return true;
				}
				else
				{
					$this->Flash->error(__('No tiene permisos para ingresar - No Direct'));		
					$this->redirect(['controller' => 'Pages', 'action' => 'home']);  		
					return false;	
				}
			}
		return parent::isAuthorized($user);
    } 
	 
    public function display()
    {
        $path = func_get_args();
		$this->loadmodel('Novedades');
		$novedades = $this->Novedades->find('all')
		->where(['activo' =>'1','interno' =>'0'])
		->order(['id' => 'DESC'])
		->limit(4);
		
		$this->set('novedades',$novedades);
        $this->set('_serialize', ['novedades']);
        $this->loadModel('Ofertas');
        $ofertasX = $this->Ofertas->find('all')
		->contain(['Articulos','articulos.Descuentos' => [
			'queryBuilder' => function ($q) {
				return $q->where([
					'tipo_venta = "D"','fecha_hasta >=CURRENT_DATE()','tipo_oferta in ("RV","RR","OR","FR","TD","RL")']); // Full conditions for filtering
			}
		]
		])
		->hydrate(false)
		->join([
			'table' => 'descuentos',
			'alias' => 'd',
			'type' => 'left',
				'conditions' => [
			'd.articulo_id = Ofertas.articulo_id',
			'd.tipo_venta = "D"',
			'd.fecha_hasta >=CURRENT_DATE()',
			'd.tipo_oferta in ("RV","RR","OR","TD","RL","FR")'
			]		
		]
		)
		->where(['Ofertas.activo=1','Ofertas.fecha_hasta >=CURRENT_DATE()','oferta_tipo_id'=>3])
		->order(['Ofertas.id' => 'DESC'])->limit('4'); 
        
        //$ofertasX = $this->Ofertas->find('all')->where(['activo'=>1,'fecha_hasta >=CURRENT_DATE()','ubicacion'=>3])->limit('4');  
		
		$this->set('ofertasX',$ofertasX->toArray());

		$this->loadModel('Publications');
		$publications = $this->Publications->find('all')->where(['fecha_hasta >=CURRENT_DATE()','habilitada' =>'1','ubicacion'=>'1'])->order(['orden' => 'asc'])->all();
		$this->set('inicio_slider',$publications->toArray());
		$publications = $this->Publications->find('all')->where(['fecha_hasta >=CURRENT_DATE()','habilitada' =>'1','ubicacion'=>'15'])->order(['orden' => 'asc'])->all();
		$this->set('inicio_slider2',$publications->toArray());

		if (!empty($this->request->session()->read('Auth')))
		{
				if ($this->request->session()->read('Auth.User.role') === 'admin') {
					
					$this->redirect(['controller' => 'pedidos','action' => 'index_admin']);
				} 
				else if ($this->request->session()->read('Auth.User.role') === 'client'){
					
					$this->redirect(['controller' => 'carritos','action' => 'index']);
				}
			
		}
		$this->set('ipClien',$this->request->clientIp());
        $count = count($path);
        if (!$count) {
            return $this->redirect('/');
        }
        $page = $subpage = null;

        if (!empty($path[0])) {
            $page = $path[0];
        }
        if (!empty($path[1])) {
            $subpage = $path[1];
        }
        $this->set(compact('page', 'subpage'));

        try {
            $this->render(implode('/', $path));
        } catch (MissingTemplateException $e) {
            if (Configure::read('debug')) {
                throw $e;
            }
            throw new NotFoundException();
        }
		
		
		
    }
	
	public function descargas()
    {
		$this->layout = 'store';
		
		
	}
	

	
}
