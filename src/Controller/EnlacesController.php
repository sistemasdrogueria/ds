<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Network\Email\Email;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;


/**
 *Enlaces Controller
 * *
 * @method \App\Model\Entity\Enlace[] paginate($object = null, array $settings = []) */
//AppCompartirController
class EnlacesController extends AppController
{


    public function initialize()
    {
        parent::initialize();

        // Include the FlashComponent
        $this->loadComponent('Flash');
        // Load Files model
        $this->loadModel('Files');
    }

    public function beforeFilter(Event $event)
    {
        // allow all action
        $this->Auth->allow(['agregar', 'index', 'condiciones', 'formulario','sendemail']);
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */


    public function index()
    {
        $this->viewBuilder()->layout('formulario');
    }


    public function formulario()
    {
        $this->viewBuilder()->layout('formulario');
    }

    /**
     * View method
     *
     * @param string|null $idEnlace id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $enlace = $this->Enlaces->get($id, [
            'contain' => []
        ]);

        $this->set('enlace', $enlace);
        $this->set('_serialize', ['enlace']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->viewBuilder()->setLayout('formulario');
        $formulariosend = false;
        if ($this->request->is('post')) {

            $this->loadModel("Invitaciones");
            $enlace = $this->Invitaciones->newEntity();
            $enlace = $this->Invitaciones->patchEntity($enlace, $this->request->getData());
            if ($this->Invitaciones->save($enlace)) {
                $this->Flash->success(__('Formulario enviado .'));
                $formulariosend = true;
                //  return $this->redirect(['action' => 'index']);
            } else {
                $formulariosend = false;
                $this->Flash->error(__('Theenlace could not be saved. Please, try again.'));
            }
        }
        $this->set('formulariosend', $formulariosend);
        $this->set('asistencia', $enlace->asistencia);
    }

    public function agregar()
    {
        if ($this->request->is('post')) {
            $this->viewBuilder()->setLayout('formulario');
            $this->loadModel("Invitaciones");

            $enlace = $this->Invitaciones->newEntity();
            $enlace = $this->Invitaciones->patchEntity($enlace, $this->request->getData());
            if ($this->Invitaciones->save($enlace)) {
              $this->sendemail($enlace->email,$enlace->nombre);
                $formulariosend = 1;
                //  return $this->redirect(['action' => 'index']);
            } else {
                $formulariosend = 0;
            }

            $this->set('formulariosend', $formulariosend);
        }
    }
    /**
     * Edit method
     *
     * @param string|null $idEnlace id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $enlace = $this->Enlaces->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $enlace = $this->Enlaces->patchEntity($enlace, $this->request->getData());
            if ($this->Enlaces->save($enlace)) {
                $this->Flash->success(__('Theenlace has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Theenlace could not be saved. Please, try again.'));
        }
        $this->set(compact('enlace'));
        $this->set('_serialize', ['enlace']);
    }

    public function sendemail($para,$nombre){
        $cont_email = 'mdedios@drogueriasur.com.ar';
		$cont_cuerpo = '';
		$cont_name ='Formulario de invitación';
		$email = new Email();
		$email->transport('gmail');
        $bar = ucfirst(strtolower($nombre));
		try {
			
			$res = $email->from(['sistemas@drogueriasur.com.ar' => 'Drogueria Sur S.A.'])
				->template('invitaciones')
				->emailFormat('html')

				->to([$para])
				//->bcc(["cobranzas@drogueriasur.com.ar"=>"cobranzas@drogueriasur.com.ar"])
				->subject($cont_name)
				->viewVars(['nombre'=>$bar])
				->send($cont_cuerpo);

		
		} catch (Exception $e) {

			echo 'Exception : ',  $e->getMessage(), "\n";

		}



    }
    /**
     * Delete method
     *
     * @param string|null $idEnlace id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $enlace = $this->Enlaces->get($id);
        if ($this->Enlaces->delete($enlace)) {
            $this->Flash->success(__('Theenlace has been deleted.'));
        } else {
            $this->Flash->error(__('Theenlace could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
