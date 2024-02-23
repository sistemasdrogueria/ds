<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * UsuariosTipos Controller
 *
 * @property \App\Model\Table\UsuariosTiposTable $UsuariosTipos
 */
class UsuariosTiposController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('usuariosTipos', $this->paginate($this->UsuariosTipos));
        $this->set('_serialize', ['usuariosTipos']);
    }

    /**
     * View method
     *
     * @param string|null $id Usuarios Tipo id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $usuariosTipo = $this->UsuariosTipos->get($id, [
            'contain' => []
        ]);
        $this->set('usuariosTipo', $usuariosTipo);
        $this->set('_serialize', ['usuariosTipo']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $usuariosTipo = $this->UsuariosTipos->newEntity();
        if ($this->request->is('post')) {
            $usuariosTipo = $this->UsuariosTipos->patchEntity($usuariosTipo, $this->request->data);
            if ($this->UsuariosTipos->save($usuariosTipo)) {
                $this->Flash->success('The usuarios tipo has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The usuarios tipo could not be saved. Please, try again.');
            }
        }
        $this->set(compact('usuariosTipo'));
        $this->set('_serialize', ['usuariosTipo']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Usuarios Tipo id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $usuariosTipo = $this->UsuariosTipos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $usuariosTipo = $this->UsuariosTipos->patchEntity($usuariosTipo, $this->request->data);
            if ($this->UsuariosTipos->save($usuariosTipo)) {
                $this->Flash->success('The usuarios tipo has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The usuarios tipo could not be saved. Please, try again.');
            }
        }
        $this->set(compact('usuariosTipo'));
        $this->set('_serialize', ['usuariosTipo']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Usuarios Tipo id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $usuariosTipo = $this->UsuariosTipos->get($id);
        if ($this->UsuariosTipos->delete($usuariosTipo)) {
            $this->Flash->success('The usuarios tipo has been deleted.');
        } else {
            $this->Flash->error('The usuarios tipo could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
