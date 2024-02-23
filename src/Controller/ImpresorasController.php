<?php
namespace App\Controller;
use Cake\Event\Event;
use App\Controller\AppController;

/**
 * Impresoras Controller
 *
 * @property \App\Model\Table\ImpresorasTable $Impresoras
 *
 * @method \App\Model\Entity\Impresora[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ImpresorasController extends AppController
{
    public function initialize(){
        parent::initialize();
        
        // Include the FlashComponent
        $this->loadComponent('Flash');
    

    }
    public function isAuthorized()
    {
           if (in_array($this->request->action, ['index'])) {
               
            if($this->request->session()->read('Auth.User.role')=='admin') 
                {				
                return true;			
                }			
            else 
                {	
            
                $this->Flash->error(__('No tiene permisos para ingresar'),['key' => 'changepass']);
                return false;			
                }
			}
			else
			{
				
			    $this->Flash->error(__('No tiene permisos para ingresar'),['key' => 'changepass']);
				return false;
				
	
			}
				
		return parent::isAuthorized($user);
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->set('titulo','Lista de Impresoras');
        $this->viewBuilder()->layout('admin');
        $impresoras = $this->paginate($this->Impresoras);

        $this->set(compact('impresoras'));
    }

    /**
     * View method
     *
     * @param string|null $id Impresora id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $impresora = $this->Impresoras->get($id, [
            'contain' => []
        ]);

        $this->set('impresora', $impresora);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $impresora = $this->Impresoras->newEntity();
        if ($this->request->is('post')) {
            $impresora = $this->Impresoras->patchEntity($impresora, $this->request->getData());
            if ($this->Impresoras->save($impresora)) {
                $this->Flash->success(__('The impresora has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The impresora could not be saved. Please, try again.'));
        }
        $this->set(compact('impresora'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Impresora id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $impresora = $this->Impresoras->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $impresora = $this->Impresoras->patchEntity($impresora, $this->request->getData());
            if ($this->Impresoras->save($impresora)) {
                $this->Flash->success(__('The impresora has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The impresora could not be saved. Please, try again.'));
        }
        $this->set(compact('impresora'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Impresora id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $impresora = $this->Impresoras->get($id);
        if ($this->Impresoras->delete($impresora)) {
            $this->Flash->success(__('The impresora has been deleted.'));
        } else {
            $this->Flash->error(__('The impresora could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
