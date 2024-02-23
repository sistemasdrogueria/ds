<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Estados Controller
 *
 * @property \App\Model\Table\EstadosTable $Estados
 */
class HelpsController extends AppController
{


	public function isAuthorized()
    {
         
		 if (in_array($this->request->action,['index'])) {
				
				
                if(($this->request->session()->read('Auth.User.role')=='client') || (($this->request->session()->read('Auth.User.role')=='provider') ))
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
    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        
		$this->viewBuilder()->layout('store');
		
    }

    /**
     * View method
     *
     * @param string|null $id Estado id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        
    }

    /**
     * Edit method
     *
     * @param string|null $id Estado id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        
    }

    /**
     * Delete method
     *
     * @param string|null $id Estado id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
       
    }
}
