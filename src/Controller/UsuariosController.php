<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;

/**
 * Usuarios Controller
 *
 * @property \App\Model\Table\UsuariosTable $Usuarios
 */
class UsuariosController extends AppController
{
	
	public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow('add','edit','index');
    }
	
    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
		$this->layout = 'admin';
        $this->paginate = [
            'contain' => ['Clientes', 'Perfiles']
        ];
        $this->set('usuarios', $this->paginate($this->Usuarios));
        $this->set('_serialize', ['usuarios']);
		
		$this->set('titulo','Lista de Usuarios');
    }

    /**
     * View method
     *
     * @param string|null $id Usuario id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
		$this->layout = 'admin';
        $usuario = $this->Usuarios->get($id, [
            'contain' => ['Clientes', 'Perfiles', 'LogsAccesos']
        ]);
        $this->set('usuario', $usuario);
        $this->set('_serialize', ['usuario']);
		$this->set('titulo','Ver Usuario');
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
	$this->layout = 'admin';
        $usuario = $this->Usuarios->newEntity();
        if ($this->request->is('post')) {
            $usuario = $this->Usuarios->patchEntity($usuario, $this->request->data);
			
            if ($this->Usuarios->save($usuario)) {
                $this->Flash->success('The usuario has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The usuario could not be saved. Please, try again.');
            }
        }
        $clientes = $this->Usuarios->Clientes->find('list', ['limit' => 200]);
		
        $perfiles = $this->Usuarios->Perfiles->find('list', ['limit' => 200]);
        $this->set(compact('usuario', 'clientes', 'perfiles'));
        $this->set('_serialize', ['usuario']);
		$this->set('titulo','Agregar Usuario');
    }

    /**
     * Edit method
     *
     * @param string|null $id Usuario id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
	$this->layout = 'admin';
        $usuario = $this->Usuarios->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $usuario = $this->Usuarios->patchEntity($usuario, $this->request->data);
            if ($this->Usuarios->save($usuario)) {
                $this->Flash->success('The usuario has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The usuario could not be saved. Please, try again.');
            }
        }
        $clientes = $this->Usuarios->Clientes->find('list', ['limit' => 200]);
        $perfiles = $this->Usuarios->Perfiles->find('list', ['limit' => 200]);
        $this->set(compact('usuario', 'clientes', 'perfiles'));
        $this->set('_serialize', ['usuario']);
		$this->set('titulo','Editar Usuario');
    }

    /**
     * Delete method
     *
     * @param string|null $id Usuario id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
	$this->layout = 'admin';
        $this->request->allowMethod(['post', 'delete']);
        $usuario = $this->Usuarios->get($id);
        if ($this->Usuarios->delete($usuario)) {
            $this->Flash->success('The usuario has been deleted.');
        } else {
            $this->Flash->error('The usuario could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
		
    }
	    public function login() {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error('Your username or password is incorrect.');
        }
    }
    public function logout() {
        $this->Flash->success('You are now logged out.');
        return $this->redirect($this->Auth->logout());
    }

}
