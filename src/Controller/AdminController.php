<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Log\Log;
use Cake\I18n\Time;
use Cake\Database\Expression\QueryExpression;
use Cake\Datasource\ConnectionManager;
use Cake\Mailer\Email;
use Cake\Network\Request;

class AdminController extends AppController
{
	public function isAuthorized()
    {
		 if (in_array($this->request->action, ['index'])) {
       
				if($this->request->session()->read('Auth.User.role')=='admin') 
				{				
					return true;			
				}			
				else 
				{	
					$this->redirect(array('controller' => 'carritos', 'action' => 'index'));	
					return false;						
				}		
            }		
			else 
			{		
				$this->Flash->error(__('No tiene permisos para ingresar'),['key' => 'changepass']);
				return $false;			
                
				
			}
		return parent::isAuthorized($user);
    }
		
    /**
     * Edit method
     *
     * @param string|null $id Reclamo id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
	public function index()
    {
		$this->viewBuilder()->layout('admin');
      
		$this->set('titulo','Lista de reclamos');
	
    }


}
