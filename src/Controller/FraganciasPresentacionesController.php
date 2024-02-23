<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * FraganciasPresentaciones Controller
 *
 * @property \App\Model\Table\FraganciasPresentacionesTable $FraganciasPresentaciones
 */
class FraganciasPresentacionesController extends AppController
{
	
		public function isAuthorized()
    {
		if (in_array($this->request->action, ['edit_admin', 'delete_admin','search_admin','index_admin','view_admin'])) {
       
				if($this->request->session()->read('Auth.User.role')=='admin') 
				{				
					return true;			
				}			
				else 
				{	
					if($this->request->session()->read('Auth.User.role')=='client') 
					{	
						//$tiene= $this->tienepermiso('carritos',$this->request->action);
						/*if (!$tiene)
							$this->Flash->error(__('No tiene permisos para ingresar'),['key' => 'changepass']);*/
						return false;			
					}	
					else
					{
						if($this->request->session()->read('Auth.User.role')=='provider') 
						{				
							return false;			
						}
						else
						{
							$this->Flash->error(__('No tiene permisos para ingresar'),['key' => 'changepass']);
							return false;	
						}	
					}	
				}		
            }		
		else 
			{			    		
				return false;		
			}	
		return parent::isAuthorized($user);
    }
	

	
    /**
     * Index method
     *
     * @return void
     */
    public function index_admin()
    {
        $this->paginate = [
            'contain' => ['Articulos', 'Fragancias']
        ];
        $this->set('fraganciasPresentaciones', $this->paginate($this->FraganciasPresentaciones));
        $this->set('_serialize', ['fraganciasPresentaciones']);
    }

    /**
     * View method
     *
     * @param string|null $id Fragancias Presentacione id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view_admin($id = null)
    {
        $fraganciasPresentacione = $this->FraganciasPresentaciones->get($id, [
            'contain' => ['Articulos', 'Fragancias']
        ]);
        $this->set('fraganciasPresentacione', $fraganciasPresentacione);
        $this->set('_serialize', ['fraganciasPresentacione']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add_admin()
    {
        $fraganciasPresentacione = $this->FraganciasPresentaciones->newEntity();
        if ($this->request->is('post')) {
            $fraganciasPresentacione = $this->FraganciasPresentaciones->patchEntity($fraganciasPresentacione, $this->request->data);
            if ($this->FraganciasPresentaciones->save($fraganciasPresentacione)) {
                $this->Flash->success(__('The fragancias presentacione has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The fragancias presentacione could not be saved. Please, try again.'));
            }
        }
        $articulos = $this->FraganciasPresentaciones->Articulos->find('list', ['limit' => 200]);
        $fragancias = $this->FraganciasPresentaciones->Fragancias->find('list', ['limit' => 200]);
        $this->set(compact('fraganciasPresentacione', 'articulos', 'fragancias'));
        $this->set('_serialize', ['fraganciasPresentacione']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Fragancias Presentacione id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit_admin($id = null)
    {
		$this->viewBuilder()->layout('admin');
        $fraganciasPresentacione = $this->FraganciasPresentaciones->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $fraganciasPresentacione = $this->FraganciasPresentaciones->patchEntity($fraganciasPresentacione, $this->request->data);
            if ($this->FraganciasPresentaciones->save($fraganciasPresentacione)) {
                $this->Flash->success(__('The fragancias presentacione has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The fragancias presentacione could not be saved. Please, try again.'));
            }
        }
        $articulos = $this->FraganciasPresentaciones->Articulos->find('list', ['limit' => 200]);
        $fragancias = $this->FraganciasPresentaciones->Fragancias->find('list', ['limit' => 200]);
        $this->set(compact('fraganciasPresentacione', 'articulos', 'fragancias'));
        $this->set('_serialize', ['fraganciasPresentacione']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Fragancias Presentacione id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete_admin($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $fraganciasPresentacione = $this->FraganciasPresentaciones->get($id);
        if ($this->FraganciasPresentaciones->delete($fraganciasPresentacione)) {
            $this->Flash->success(__('The fragancias presentacione has been deleted.'));
        } else {
            $this->Flash->error(__('The fragancias presentacione could not be deleted. Please, try again.'));
        }
        $this->redirect($this->referer());
    }
}
