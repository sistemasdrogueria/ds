<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Cake\Mailer\Email;
use Cake\ORM\Query;
use Cake\Log\Log;
use Cake\Database\Connection;
use Cake\Datasource\ConnectionManager;
/**
 * ClientesAltas Controller
 *
 * @property \App\Model\Table\ClientesAltasTable $ClientesAltas
 *
 * @method \App\Model\Entity\ClientesAlta[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ClientesAltasController extends AppController
{

    public function beforeFilter(Event $event)
    {
       // allow all action
        $this->Auth->allow(['add','view','sh']);
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */

    public function isAuthorized()
    {

					if (in_array($this->request->action, ['index_admin','view_admin','edit_admin','delete_admin','add_admin'])) {
       
					if($this->request->session()->read('Auth.User.role')=='adminR') 	
							return true;			
					else
						$this->Flash->error('No tiene permisos para ingresar - No Direct',['key' => 'changepass']);    
						
					$this->redirect(['controller' => 'Pages', 'action' => 'home']);  		
					return false;	
					}
					
				
			
		return parent::isAuthorized($user);
    } 

    public function index()
    {
        $clientesAltas = $this->paginate($this->ClientesAltas);

        $this->set(compact('clientesAltas'));
    }

    /**
     * View method
     *
     * @param string|null $id Clientes Alta id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $clientesAlta = $this->ClientesAltas->get($id, [
            'contain' => []
        ]);

        $this->set('clientesAlta', $clientesAlta);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->viewBuilder()->layout('client');
        $clientesAlta = $this->ClientesAltas->newEntity();
        if ($this->request->is('post')) {
            $clientesAlta = $this->ClientesAltas->patchEntity($clientesAlta, $this->request->getData());
            if ($this->ClientesAltas->save($clientesAlta)) {
                //$this->Flash->success(__('SOLICITUD ENVIADA CORRECTAMENTE. PRONTO UN EJECUTIVO DE VENTAS SE PONDRA EN CONTACTO CON VOS! '),['key' => 'changepass']);
                $this->enviaraperturacuenta($clientesAlta);
                $this->Flash->success(__('SOLICITUD ENVIADA CORRECTAMENTE. PRONTO UN EJECUTIVO DE VENTAS SE PONDRA EN CONTACTO CON VOS! '),['key' => 'changepass']);
				return $this->redirect(['controller'=>'Pages','action' => 'index']);
                
            }
            $this->Flash->error(__('No se pudo procesar la solicitud, intente nuevamente, revise los datos ingresados.'),['key' => 'changepass']);
        }
        $this->set(compact('clientesAlta'));
        $this->loadModel('Provincias');
		
        $provincias = $this->Provincias->find('list',['keyField' => 'id','valueField'=>'nombre']);
       
        $this->set(compact('provincias'));


    }

    /**
     * Edit method
     *
     * @param string|null $id Clientes Alta id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $clientesAlta = $this->ClientesAltas->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $clientesAlta = $this->ClientesAltas->patchEntity($clientesAlta, $this->request->getData());
            if ($this->ClientesAltas->save($clientesAlta)) {
                $this->Flash->success(__('The clientes alta has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The clientes alta could not be saved. Please, try again.'));
        }
        $this->set(compact('clientesAlta'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Clientes Alta id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $clientesAlta = $this->ClientesAltas->get($id);
        if ($this->ClientesAltas->delete($clientesAlta)) {
            $this->Flash->success(__('The clientes alta has been deleted.'));
        } else {
            $this->Flash->error(__('The clientes alta could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


    function enviaraperturacuenta($clientealta = null) {
		
		
		$opcion=1;
		$cont_email ='mdedios@drogueriasur.com.ar';
		$cont_cuerpo ='';
        $cont_name = ' Solicitud de Apertura de Cuenta';
         
        $this->loadModel('Provincias');
		
        $provincias = $this->Provincias->find('list',['keyField' => 'id','valueField'=>'nombre']);
        
        $this->request->session()->write('para',$cont_email);
		$email = new Email();
		$email->transport('gmail');
		try 
		{
					//$para = 		 $cont_email;

				
					$para = 'coubinia@drogueriasur.com.ar';
					
					$res = $email->from(['sistemas@drogueriasur.com.ar' => 'Drogueria Sur S.A.'])
					->replyTo(['mdedios@drogueriasur.com.ar' => 'Sistemas'])
					
					->template('solicitudaperturacuenta')
					->emailFormat('html')
					
					->to([$para])
					//->bcc(["cobranzas@drogueriasur.com.ar"=>"cobranzas@drogueriasur.com.ar"])
					->subject($cont_name)
					->viewVars(['clientealta'=>$clientealta,'provincias'=> $provincias->toArray()])
					->send($cont_cuerpo);
					
			
		} 
		catch (Exception $e) {

				echo 'Exception : ',  $e->getMessage(), "\n";
				$this->Flash->error(__('No Se pudo enviar la solicitud correctamente'),['key' => 'changepass']);
				return $this->redirect($this->referer());
		}
			
	} 
}
