<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Proveedors Controller
 *
 * @property \App\Model\Table\ProveedorsTable $Proveedors
 */
class ProveedorsController extends AppController
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
        $this->set('proveedors', $this->paginate($this->Proveedors));
        $this->set('_serialize', ['proveedors']);
    }

    /**
     * View method
     *
     * @param string|null $id Proveedor id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $proveedor = $this->Proveedors->get($id, [
            'contain' => ['Provincias', 'Localidads', 'Ofertas']
        ]);
        $this->set('proveedor', $proveedor);
        $this->set('_serialize', ['proveedor']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $proveedor = $this->Proveedors->newEntity();
        if ($this->request->is('post')) {
            $proveedor = $this->Proveedors->patchEntity($proveedor, $this->request->data);
            if ($this->Proveedors->save($proveedor)) {
                $this->Flash->success('The proveedor has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The proveedor could not be saved. Please, try again.');
            }
        }
        $provincias = $this->Proveedors->Provincias->find('list', ['limit' => 200]);
        $localidads = $this->Proveedors->Localidads->find('list', ['limit' => 200]);
        $this->set(compact('proveedor', 'provincias', 'localidads'));
        $this->set('_serialize', ['proveedor']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Proveedor id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $proveedor = $this->Proveedors->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $proveedor = $this->Proveedors->patchEntity($proveedor, $this->request->data);
            if ($this->Proveedors->save($proveedor)) {
                $this->Flash->success('The proveedor has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The proveedor could not be saved. Please, try again.');
            }
        }
        $provincias = $this->Proveedors->Provincias->find('list', ['limit' => 200]);
        $localidads = $this->Proveedors->Localidads->find('list', ['limit' => 200]);
        $this->set(compact('proveedor', 'provincias', 'localidads'));
        $this->set('_serialize', ['proveedor']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Proveedor id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $proveedor = $this->Proveedors->get($id);
        if ($this->Proveedors->delete($proveedor)) {
            $this->Flash->success('The proveedor has been deleted.');
        } else {
            $this->Flash->error('The proveedor could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
