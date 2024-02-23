<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ReclamosItemsTemp Controller
 *
 * @property \App\Model\Table\ReclamosItemsTempTable $ReclamosItemsTemp
 */
class ReclamosItemsTempController extends AppController
{
	public function isAuthorized()
    {
         
		 if (in_array($this->request->action, ['edit', 'delete','add','index'])) {
       
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
					
						//$this->redirect(array('controller' => 'carritos', 'action' => 'index'));	
						return true;						
					}
					else {
						
						return false;	
						$this->Flash->error(__('No tiene permisos para ingresar'));
						return $this->redirect(['controller' => 'Pages', 'action' => 'home']);
					}
                    
                }	
            }		
            }		
			else 
			{			
				$this->Flash->error(__('No tiene permisos para ingresar'));		
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
        $this->set('reclamosItemsTemp', $this->paginate($this->ReclamosItemsTemp));
        $this->set('_serialize', ['reclamosItemsTemp']);
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
        $reclamosItemsTemp = $this->ReclamosItemsTemp->get($id, [
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
    public function add()
    {
        $reclamosItemsTemp = $this->ReclamosItemsTemp->newEntity();
        if ($this->request->is('post')) {
            $reclamosItemsTemp = $this->ReclamosItemsTemp->patchEntity($reclamosItemsTemp, $this->request->data);
            $reclamosItemsTemp['cliente_id']=$this->request->session()->read('Auth.User.cliente_id');
			if ($this->ReclamosItemsTemp->save($reclamosItemsTemp)) {
                $this->Flash->success(__('The reclamos items temp has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The reclamos items temp could not be saved. Please, try again.'));
            }
        }
        $clientes = $this->ReclamosItemsTemp->Clientes->find('list', ['limit' => 200]);
        $articulos = $this->ReclamosItemsTemp->Articulos->find('list', ['limit' => 200]);
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
        $reclamosItemsTemp = $this->ReclamosItemsTemp->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $reclamosItemsTemp = $this->ReclamosItemsTemp->patchEntity($reclamosItemsTemp, $this->request->data);
            if ($this->ReclamosItemsTemp->save($reclamosItemsTemp)) {
                $this->Flash->success(__('The reclamos items temp has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The reclamos items temp could not be saved. Please, try again.'));
            }
        }
        $clientes = $this->ReclamosItemsTemp->Clientes->find('list', ['limit' => 200]);
        $articulos = $this->ReclamosItemsTemp->Articulos->find('list', ['limit' => 200]);
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
        $reclamosItemsTemp = $this->ReclamosItemsTemp->get($id);
        if ($this->ReclamosItemsTemp->delete($reclamosItemsTemp)) {
            $this->Flash->success(__('The reclamos items temp has been deleted.'));
        } else {
            $this->Flash->error(__('The reclamos items temp could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
