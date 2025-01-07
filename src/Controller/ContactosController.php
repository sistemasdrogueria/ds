<?php

namespace App\Controller;

use App\Controller\AppController;
//use Cake\Network\Email\Email;
use Cake\Mailer\Email;
use Cake\Network\Request;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\Http\Client;
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
    public function beforeFilter(Event $event)
	{
		parent::beforeFilter($event);
		// Allow users to register and logout.
		// You should not add the "login" action to allow list. Doing so would
		// cause problems with normal functioning of AuthComponent.
		$this->Auth->allow(['enviar_mail', 'sendContacto', 'add']);
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
                return $this->redirect(['controller' => 'pages', 'action' => 'display']);
            } else {
                $this->Flash->error('The contacto could not be saved. Please, try again.');
            }
        }
        $this->set(compact('contacto'));
        $this->set('_serialize', ['contacto']);
    }

    private function validateRecaptcha($token)
    {
        $secretKey = Configure::read('Recaptcha.secret_key');
        $client = new Client();

        $response = $client->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $secretKey,
            'response' => $token
        ]);

        if (!$response->isOk()) {
            return ['success' => false, 'message' => 'Error al conectar con el servicio de reCAPTCHA.'];
        }
        $responseData = json_decode($response->body(), true);


        if (isset($responseData['success']) && $responseData['success'] === true && $responseData['score'] > 0.8 ) {
            return ['success' => true];
        } elseif (isset($responseData['error-codes']) && is_array($responseData['error-codes'])) {
            if (in_array('timeout-or-duplicate', $responseData['error-codes'])) {
                return ['success' => false, 'message' => 'El token de reCAPTCHA ha expirado o es duplicado. Por favor, inténtalo de nuevo.'];
            }
            // Aquí puedes añadir otros códigos de error específicos si es necesario
            return ['success' => false, 'message' => 'Error de reCAPTCHA. Por favor, inténtalo de nuevo.'];
        }

        return ['success' => false, 'message' => 'Error desconocido al validar reCAPTCHA.'];
    }

    
    public function enviar_mail()
    {
        $contacto = $this->Contactos->newEntity();
        if ($this->request->is('post')) {
            $recaptchaToken = $this->request->getData('g-recaptcha-response');
            if ($this->validateRecaptcha($recaptchaToken)) {
                $contacto = $this->Contactos->patchEntity($contacto, $this->request->data);

                $this->request->session()->write('contacto', $contacto);
                $this->sendContacto($contacto['detalle'], $contacto['email'], $contacto['nombre'], $contacto['telefono'], $contacto['departamento']);

                return $this->redirect(['controller' => 'pages', 'action' => 'display']);
            }
        }
        $this->set(compact('contacto'));
        $this->set('_serialize', ['contacto']);
    }


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
    function sendContacto($cont_cuerpo, $cont_email, $cont_name, $cont_phone, $quien)
    {
        /*switch ($quien) {
					
					    case 0: $para = 'ventas@drogueriasur.com.ar'; break;
						case 1: $para = 'cobranzas@drogueriasur.com.ar'; break;
						case 2: $para = 'compras@drogueriasur.com.ar'; break;
						case 3: $para = 'ventas@drogueriasur.com.ar'; break;
						case 4: $para = 'perfumeria@drogueriasur.com.ar'; break;
						case 5: $para = 'sistemas@drogueriasur.com.ar'; break;
						//case 5: $para = 'mdedios@drogueriasur.com.ar'; break;
						
					}*/
        $para = 'contacto@drogueriasur.com.ar';
        $email = new Email();
        $email->transport('gmail');
        try {
            $res = $email->from([$cont_email => 'drogueriasur.com.ar'])
                ->replyTo([$cont_email => $cont_name])
                ->template('default', 'default')
                ->emailFormat('html')
                ->to([$para => $para])
                ->subject('Consulta realizada de drogueriasur.com.ar')
                ->viewVars(['nombre' => $cont_name, 'correo' => $cont_email, 'telefono' => $cont_phone])
                ->send($cont_cuerpo);
        } catch (Exception $e) {

            echo 'Exception : ',  $e->getMessage(), "\n";
        }
    }
}
