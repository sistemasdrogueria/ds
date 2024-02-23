<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\I18n\Time;
use Cake\Database\Connection;
use Cake\Datasource\ConnectionManager;

/**
 * Catalogos Controller
 *
 * @property \App\Model\Table\CatalogosTable $Catalogos
 *
 * @method \App\Model\Entity\Catalogo[] paginate($object = null, array $settings = [])
 */
class CatalogosController extends AppController
{


	public function initialize(){
        parent::initialize();
        // Include the FlashComponent
        $this->loadComponent('Flash');
        // Load Files model
        $this->loadModel('Files');

    }
    
    public function beforeFilter(Event $event)
    {
       // allow all action
        $this->Auth->allow(['solares','especial']);
    }

	public function isAuthorized()
    {
		 if (in_array($this->request->action, ['index','revista','especial','especial2','especial3','add','edit','delete'])) {
       
            if($this->request->session()->read('Auth.User.role')=='admin') 
            {				
                return true;			
            }			
            else {	
                if($this->request->session()->read('Auth.User.role')=='client') 
                {	
						$tiene= $this->tienepermiso('catalogos',$this->request->action);
						if (!$tiene)
							$this->Flash->error(__('No tiene permisos para ingresar'),['key' => 'changepass']);
						return $tiene;			
                }	
                else {
					if($this->request->session()->read('Auth.User.role')=='provider') 
					{
						$this->Flash->error(__('No tiene permisos para ingresar'),['key' => 'changepass']);
						$this->redirect(['controller' => 'carritos', 'action' => 'index']);	
						return false;						
					}
					else {
						$this->Flash->error(__('No tiene permisos para ingresar'),['key' => 'changepass']);
						$this->redirect(['controller' => 'Pages', 'action' => 'home']);
						return false;	
					}
                    
                }	
            }		
            }		
			else 
			{
				if (in_array($this->request->action, ['view']))
				{
					return true;
				}
				else
				{
					$this->Flash->error(__('No tiene permisos para ingresar'));		
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

	public function revista()
    {
        $this->viewBuilder()->layout('magazine');
		$catalogo = $this->Catalogos->find('all')->where(['tipo_catalogo'=>1])->order(['id' => 'desc'])->first([]);
		$this->set('catalogo', $catalogo);
    }
	
	public function especial()
    {
        $this->viewBuilder()->layout('magazine2');
		$catalogo = $this->Catalogos->find('all')->where(['tipo_catalogo'=>2])->order(['id' => 'desc'])->first([]);
		$this->set('catalogo', $catalogo);		
    }
    public function solares()
    {
        $this->viewBuilder()->layout('magazine3');
		$catalogo = $this->Catalogos->find('all')->where(['tipo_catalogo'=>3])->order(['id' => 'desc'])->first([]);
		$this->set('catalogo', $catalogo);
    }
    
	public function especial2()
	{
        $this->viewBuilder()->layout('magazine3');
		$catalogo = $this->Catalogos->find('all')->where(['tipo_catalogo'=>3])->order(['id' => 'desc'])->first([]);
		$this->set('catalogo', $catalogo);
    }

	public function especial3()
	{
        $this->viewBuilder()->layout('magazine4');
		$catalogo = $this->Catalogos->find('all')->where(['tipo_catalogo'=>4])->order(['id' => 'desc'])->first([]);
		$this->set('catalogo', $catalogo);
    }


    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $catalogos = $this->paginate($this->Catalogos);
		$this->viewBuilder()->layout('store');
        $this->set(compact('catalogos'));
        $this->set('_serialize', ['catalogos']);
    }

    /**
     * View method
     *
     * @param string|null $id Catalogo id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $catalogo = $this->Catalogos->get($id, [
            'contain' => []
        ]);

        $this->set('catalogo', $catalogo);
        $this->set('_serialize', ['catalogo']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$this->viewBuilder()->layout('admin');
        $catalogo = $this->Catalogos->newEntity();
        if ($this->request->is('post')) {
            $catalogo = $this->Catalogos->patchEntity($catalogo, $this->request->getData());
            if ($this->Catalogos->save($catalogo)) {
                $this->Flash->success(__('The catalogo has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The catalogo could not be saved. Please, try again.'));
        }
        $this->set(compact('catalogo'));
        $this->set('_serialize', ['catalogo']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Catalogo id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$this->viewBuilder()->layout('admin');
        $catalogo = $this->Catalogos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $catalogo = $this->Catalogos->patchEntity($catalogo, $this->request->getData());
            if ($this->Catalogos->save($catalogo)) {
                $this->Flash->success(__('The catalogo has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The catalogo could not be saved. Please, try again.'));
        }
        $this->set(compact('catalogo'));
        $this->set('_serialize', ['catalogo']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Catalogo id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
		$this->viewBuilder()->layout('admin');
        $this->request->allowMethod(['post', 'delete']);
        $catalogo = $this->Catalogos->get($id);
        if ($this->Catalogos->delete($catalogo)) {
            $this->Flash->success(__('The catalogo has been deleted.'));
        } else {
            $this->Flash->error(__('The catalogo could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
