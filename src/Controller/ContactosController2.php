<?php
namespace App\Controller;

use App\Controller\AppController;
//use Cake\Network\Email\Email;
use Cake\Mailer\Email;
use Cake\Network\Request;
/*
Email::configTransport('gmail', [
    'host' => 'smtp.gmail.com',
    'port' => 587,
	  'className' => 'Smtp',
            // The following keys are used in SMTP transports
          
            'timeout' => 30,
            'username' => 'sistemasdrogueriasur@gmail.com',
            'password' => 'Autor8075',
         	'tls' => true
]);
*/
/**
 * Contactos Controller
 *
 * @property \App\Model\Table\ContactosTable $Contactos
 */
class ContactosController extends AppController
{
	public function isAuthorized()
    {
           if (in_array($this->request->action, ['enviar_mail','sendContacto','add'])) {
                return true;			
          
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
     * @return void
     */
    public function index()
    {
		$this->layout = 'admin';
        $this->set('contactos', $this->paginate($this->Contactos));
        $this->set('_serialize', ['contactos']);
    }

    /**
     * View method
     *
     * @param string|null $id Contacto id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
		$this->layout = 'admin';
        $contacto = $this->Contactos->get($id, [
            'contain' => []
        ]);
        $this->set('contacto', $contacto);
        $this->set('_serialize', ['contacto']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		//$this->layout = 'admin';
        $contacto = $this->Contactos->newEntity();
        if ($this->request->is('post')) {
            $contacto = $this->Contactos->patchEntity($contacto, $this->request->data);
            if ($this->Contactos->save($contacto)) {
                $this->Flash->success('The contacto has been saved.');
                return $this->redirect(['controller'=>'pages','action' => 'display']);
            } else {
                $this->Flash->error('The contacto could not be saved. Please, try again.');
            }
        }
        $this->set(compact('contacto'));
        $this->set('_serialize', ['contacto']);
    }

	public function enviar_mail()
    {
        $contacto = $this->Contactos->newEntity();
        if ($this->request->is('post')) {
            $contacto = $this->Contactos->patchEntity($contacto, $this->request->data);
           
			$this->request->session()->write('contacto',$contacto);
			$this->sendContacto($contacto['detalle'],$contacto['email'],$contacto['nombre']);   
			
			return $this->redirect(['controller'=>'pages','action' => 'display']);
			/*if ($this->Contactos->save($contacto)) {
                                                  
				
				$this->Flash->success('The contacto has been saved.');
                
            } else {
                $this->Flash->error('The contacto could not be saved. Please, try again.');
				//return $this->redirect(['controller' => 'contactos','action' => 'add']);
            }*/
        }
        $this->set(compact('contacto'));
        $this->set('_serialize', ['contacto']);
    }
	
	/*		
        $contacto = $this->Contactos->newEntity();
        if ($this->request->is('post')) {
            $contacto = $this->Contactos->patchEntity($contacto, $this->request->data);
            if ($this->Contactos->save($contacto)) {
				$this->sendContacto($contacto['detalle'],$contacto['email'],$contacto['nombre']);                                     
				//$this->Session->setFlash(__('<div class="success canhide">Su consulta fue recibida. Pronto nos pondremos en contacto con usted.</div>', true));
                    	
               $this->Flash->success('The contacto has been saved.');
                //return $this->redirect(['controller' => 'pages','action' => 'home']);
            } else {
                $this->Flash->error('The contacto could not be saved. Please, try again.');
				return $this->redirect(['controller' => 'contactos','action' => 'index']);
            }
        }*/
	
    /**
     * Edit method
     *
     * @param string|null $id Contacto id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$this->layout = 'admin';
        $contacto = $this->Contactos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $contacto = $this->Contactos->patchEntity($contacto, $this->request->data);
            if ($this->Contactos->save($contacto)) {
                $this->Flash->success('The contacto has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The contacto could not be saved. Please, try again.');
            }
        }
        $this->set(compact('contacto'));
        $this->set('_serialize', ['contacto']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Contacto id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
		$this->layout = 'admin';
        $this->request->allowMethod(['post', 'delete']);
        $contacto = $this->Contactos->get($id);
        if ($this->Contactos->delete($contacto)) {
            $this->Flash->success('The contacto has been deleted.');
        } else {
            $this->Flash->error('The contacto could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
	
				
           
        // Enviar email   
     function sendContacto($cont_cuerpo,$cont_email,$cont_name) {
			    
				$email = new Email();
				$email->transport('gmail');
					try 
					{
						$res = $email->from([$cont_email => $cont_name])
							->to([$cont_email => $cont_name])
							->subject('Consulta realizada de drogueriasur.com.ar')
							->send($cont_cuerpo);

					} 
					catch (Exception $e) {

						echo 'Exception : ',  $e->getMessage(), "\n";
						
					}
            }          

}
