<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ReclamosItemsTemps Controller
 *
 * @property \App\Model\Table\ReclamosItemsTempsTable $ReclamosItemsTemps
 */
class ReclamosItemsTempsController extends AppController
{
public function isAuthorized()
    {
         
		 if (in_array($this->request->action, ['edit', 'delete','add_item','index','vaciar'])) {
       
            if($this->request->session()->read('Auth.User.role')=='admin') 
            {				
                return true;			
            }			
            else {	
                if($this->request->session()->read('Auth.User.role')=='client') 
                {				
					//$this->redirect(array('controller' => 'Articulos', 'action' => 'index'));
                    return true;			
                }	
                else {
					if($this->request->session()->read('Auth.User.role')=='provider') 
					{
					
						$this->Flash->error(__('No tiene permisos para ingresar'),['key' => 'changepass']);
						//$this->redirect(array('controller' => 'carritos', 'action' => 'index'));	
						return false;						
					}
					else {
						
						return false;	
						$this->Flash->error(__('No tiene permisos para ingresar'),['key' => 'changepass']);
						return $this->redirect(['controller' => 'Pages', 'action' => 'home']);
					}
                    
                }	
            }		
            }		
			else 
			{			
				$this->Flash->error(__('No tiene permisos para ingresar'),['key' => 'changepass']);		
				$this->redirect(['controller' => 'Pages', 'action' => 'home']);  		
				return false;	
				
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
        $this->paginate = [
            'contain' => ['Clientes', 'Articulos']
        ];
        $this->set('reclamosItemsTemps', $this->paginate($this->ReclamosItemsTemps));
        $this->set('_serialize', ['reclamosItemsTemps']);
    }

    /**
     * View method
     *
     * @param string|null $id Reclamos Items Temp id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $reclamosItemsTemp = $this->ReclamosItemsTemps->get($id, [
            'contain' => ['Clientes', 'Articulos']
        ]);
        $this->set('reclamosItemsTemp', $reclamosItemsTemp);
        $this->set('_serialize', ['reclamosItemsTemp']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add_item()
    {
        $reclamosItemsTemp = $this->ReclamosItemsTemps->newEntity();
        if ($this->request->is('post')) {
            $reclamosItemsTemp = $this->ReclamosItemsTemps->patchEntity($reclamosItemsTemp, $this->request->data);
            $reclamosItemsTemp['cliente_id']=$this->request->session()->read('Auth.User.cliente_id');
		
			if ($this->ReclamosItemsTemps->save($reclamosItemsTemp)) {
                $this->Flash->success(__('The reclamos items temp has been saved.'),['key' => 'changepass']);
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The reclamos items temp could not be saved. Please, try again.'),['key' => 'changepass']);
            }
        }
        $clientes = $this->ReclamosItemsTemps->Clientes->find('list', ['limit' => 200]);
        $articulos = $this->ReclamosItemsTemps->Articulos->find('list', ['limit' => 200]);
        $this->set(compact('reclamosItemsTemp', 'clientes', 'articulos'));
        $this->set('_serialize', ['reclamosItemsTemp']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Reclamos Items Temp id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $reclamosItemsTemp = $this->ReclamosItemsTemps->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $reclamosItemsTemp = $this->ReclamosItemsTemps->patchEntity($reclamosItemsTemp, $this->request->data);
            if ($this->ReclamosItemsTemps->save($reclamosItemsTemp)) {
                $this->Flash->success(__('The reclamos items temp has been saved.'),['key' => 'changepass']);
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The reclamos items temp could not be saved. Please, try again.'),['key' => 'changepass']);
            }
        }
        $clientes = $this->ReclamosItemsTemps->Clientes->find('list', ['limit' => 200]);
        $articulos = $this->ReclamosItemsTemps->Articulos->find('list', ['limit' => 200]);
        $this->set(compact('reclamosItemsTemp', 'clientes', 'articulos'));
        $this->set('_serialize', ['reclamosItemsTemp']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Reclamos Items Temp id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $reclamosItemsTemp = $this->ReclamosItemsTemps->get($id);
        if ($this->ReclamosItemsTemps->delete($reclamosItemsTemp)) {
            $this->Flash->success(__('Se quito el item del ticket.'),['key' => 'changepass']);
        } else {
            $this->Flash->error(__('No se pudo quitar el item del ticket, intente de nuevo.'),['key' => 'changepass']);
        }
        $this->redirect($this->referer());
    }
	
	public function vaciar()
    {
        if ($this->deleteReclamo()) {
            $this->Flash->success('Los items del Reclamo fueron quitados.',['key' => 'changepass']);
			$this->redirect($this->referer());
        } else {
            $this->Flash->error('El Reclamo no pudo ser vaciado. Intente de nuevo.',['key' => 'changepass']);
			$this->redirect($this->referer());
        }  
    }
	
	public function deleteReclamo()
	{
		return $this->ReclamosItemsTemps->deleteAll(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]);
	}
	
}
