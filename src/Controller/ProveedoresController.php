<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Proveedores Controller
 *
 * @property \App\Model\Table\ProveedoresTable $Proveedores
 */
class ProveedoresController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Provincias', 'Localidads']
        ];
        $this->set('proveedores', $this->paginate($this->Proveedores));
        $this->set('_serialize', ['proveedores']);
    }

    /**
     * View method
     *
     * @param string|null $id Proveedore id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $proveedore = $this->Proveedores->get($id, [
            'contain' => ['Provincias', 'Localidads']
        ]);
        $this->set('proveedore', $proveedore);
        $this->set('_serialize', ['proveedore']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $proveedore = $this->Proveedores->newEntity();
        if ($this->request->is('post')) {
            $proveedore = $this->Proveedores->patchEntity($proveedore, $this->request->data);
            if ($this->Proveedores->save($proveedore)) {
                $this->Flash->success('The proveedore has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The proveedore could not be saved. Please, try again.');
            }
        }
        $provincias = $this->Proveedores->Provincias->find('list', ['limit' => 200]);
        $localidads = $this->Proveedores->Localidads->find('list', ['limit' => 200]);
        $this->set(compact('proveedore', 'provincias', 'localidads'));
        $this->set('_serialize', ['proveedore']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Proveedore id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $proveedore = $this->Proveedores->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $proveedore = $this->Proveedores->patchEntity($proveedore, $this->request->data);
            if ($this->Proveedores->save($proveedore)) {
                $this->Flash->success('The proveedore has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The proveedore could not be saved. Please, try again.');
            }
        }
        $provincias = $this->Proveedores->Provincias->find('list', ['limit' => 200]);
        $localidads = $this->Proveedores->Localidads->find('list', ['limit' => 200]);
        $this->set(compact('proveedore', 'provincias', 'localidads'));
        $this->set('_serialize', ['proveedore']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Proveedore id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $proveedore = $this->Proveedores->get($id);
        if ($this->Proveedores->delete($proveedore)) {
            $this->Flash->success('The proveedore has been deleted.');
        } else {
            $this->Flash->error('The proveedore could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
