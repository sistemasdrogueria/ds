<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ReclamosItems Controller
 *
 * @property \App\Model\Table\ReclamosItemsTable $ReclamosItems
 */
class ReclamosItemsController extends AppController
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
					$this->redirect(array('controller' => 'Articulos', 'action' => 'index'));
                    return false;			
                }	
                else {
					if($this->request->session()->read('Auth.User.role')=='provider') 
					{
					
						$this->redirect(array('controller' => 'carritos', 'action' => 'index'));	
						return false;						
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
            'contain' => ['Reclamos', 'Articulos']
        ];
        $this->set('reclamosItems', $this->paginate($this->ReclamosItems));
        $this->set('_serialize', ['reclamosItems']);
    }

    /**
     * View method
     *
     * @param string|null $id Reclamos Item id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $reclamosItem = $this->ReclamosItems->get($id, [
            'contain' => ['Reclamos', 'Articulos']
        ]);
        $this->set('reclamosItem', $reclamosItem);
        $this->set('_serialize', ['reclamosItem']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $reclamosItem = $this->ReclamosItems->newEntity();
        if ($this->request->is('post')) {
            $reclamosItem = $this->ReclamosItems->patchEntity($reclamosItem, $this->request->data);
            if ($this->ReclamosItems->save($reclamosItem)) {
                $this->Flash->success('The reclamos item has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The reclamos item could not be saved. Please, try again.');
            }
        }
        $reclamos = $this->ReclamosItems->Reclamos->find('list', ['limit' => 200]);
        $articulos = $this->ReclamosItems->Articulos->find('list', ['limit' => 200]);
        $this->set(compact('reclamosItem', 'reclamos', 'articulos'));
        $this->set('_serialize', ['reclamosItem']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Reclamos Item id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $reclamosItem = $this->ReclamosItems->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $reclamosItem = $this->ReclamosItems->patchEntity($reclamosItem, $this->request->data);
            if ($this->ReclamosItems->save($reclamosItem)) {
                $this->Flash->success('The reclamos item has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The reclamos item could not be saved. Please, try again.');
            }
        }
        $reclamos = $this->ReclamosItems->Reclamos->find('list', ['limit' => 200]);
        $articulos = $this->ReclamosItems->Articulos->find('list', ['limit' => 200]);
        $this->set(compact('reclamosItem', 'reclamos', 'articulos'));
        $this->set('_serialize', ['reclamosItem']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Reclamos Item id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $reclamosItem = $this->ReclamosItems->get($id);
        if ($this->ReclamosItems->delete($reclamosItem)) {
            $this->Flash->success('The reclamos item has been deleted.');
        } else {
            $this->Flash->error('The reclamos item could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
