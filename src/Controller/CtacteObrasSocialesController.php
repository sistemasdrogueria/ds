<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CtacteObrasSociales Controller
 *
 * @property \App\Model\Table\CtacteObrasSocialesTable $CtacteObrasSociales
 */
class CtacteObrasSocialesController extends AppController
{

	public function isAuthorized()
    {
		if (in_array($this->request->action, ['search','home','index'])) {
       
				if($this->request->session()->read('Auth.User.role')=='admin') 
				{				
					return true;			
				}			
				else 
				{	
					if($this->request->session()->read('Auth.User.role')=='client') 
					{	
						$tiene= $this->tienepermiso('ctacteobrassociales',$this->request->action);
						if (!$tiene)
							$this->Flash->error(__('No tiene permisos para ingresar'),['key' => 'changepass']);
						return $tiene;			
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
    public function index()
    {
        $this->paginate = [
            'contain' => ['ObraSociales']
        ];
        $this->set('ctacteObrasSociales', $this->paginate($this->CtacteObrasSociales));
        $this->set('_serialize', ['ctacteObrasSociales']);
    }

    /**
     * View method
     *
     * @param string|null $id Ctacte Obras Sociale id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $ctacteObrasSociale = $this->CtacteObrasSociales->get($id, [
            'contain' => ['ObraSociales']
        ]);
        $this->set('ctacteObrasSociale', $ctacteObrasSociale);
        $this->set('_serialize', ['ctacteObrasSociale']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $ctacteObrasSociale = $this->CtacteObrasSociales->newEntity();
        if ($this->request->is('post')) {
            $ctacteObrasSociale = $this->CtacteObrasSociales->patchEntity($ctacteObrasSociale, $this->request->data);
            if ($this->CtacteObrasSociales->save($ctacteObrasSociale)) {
                $this->Flash->success(__('The ctacte obras sociale has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The ctacte obras sociale could not be saved. Please, try again.'));
            }
        }
        $obraSociales = $this->CtacteObrasSociales->ObraSociales->find('list', ['limit' => 200]);
        $this->set(compact('ctacteObrasSociale', 'obraSociales'));
        $this->set('_serialize', ['ctacteObrasSociale']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Ctacte Obras Sociale id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $ctacteObrasSociale = $this->CtacteObrasSociales->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ctacteObrasSociale = $this->CtacteObrasSociales->patchEntity($ctacteObrasSociale, $this->request->data);
            if ($this->CtacteObrasSociales->save($ctacteObrasSociale)) {
                $this->Flash->success(__('The ctacte obras sociale has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The ctacte obras sociale could not be saved. Please, try again.'));
            }
        }
        $obraSociales = $this->CtacteObrasSociales->ObraSociales->find('list', ['limit' => 200]);
        $this->set(compact('ctacteObrasSociale', 'obraSociales'));
        $this->set('_serialize', ['ctacteObrasSociale']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Ctacte Obras Sociale id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ctacteObrasSociale = $this->CtacteObrasSociales->get($id);
        if ($this->CtacteObrasSociales->delete($ctacteObrasSociale)) {
            $this->Flash->success(__('The ctacte obras sociale has been deleted.'));
        } else {
            $this->Flash->error(__('The ctacte obras sociale could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
