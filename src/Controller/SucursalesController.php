<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Sucursales Controller
 *
 * @property \App\Model\Table\SucursalesTable $Sucursales
 */
class SucursalesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Clientes', 'Provincias', 'Localidads']
        ];
        $this->set('sucursales', $this->paginate($this->Sucursales));
        $this->set('_serialize', ['sucursales']);
    }

    /**
     * View method
     *
     * @param string|null $id Sucursale id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $sucursale = $this->Sucursales->get($id, [
            'contain' => ['Clientes', 'Provincias', 'Localidads']
        ]);
        $this->set('sucursale', $sucursale);
        $this->set('_serialize', ['sucursale']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $sucursale = $this->Sucursales->newEntity();
        if ($this->request->is('post')) {
            $sucursale = $this->Sucursales->patchEntity($sucursale, $this->request->data);
            if ($this->Sucursales->save($sucursale)) {
                $this->Flash->success('The sucursale has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The sucursale could not be saved. Please, try again.');
            }
        }
        $clientes = $this->Sucursales->Clientes->find('list', ['limit' => 200]);
        $provincias = $this->Sucursales->Provincias->find('list', ['limit' => 200]);
        $localidads = $this->Sucursales->Localidads->find('list', ['limit' => 200]);
        $this->set(compact('sucursale', 'clientes', 'provincias', 'localidads'));
        $this->set('_serialize', ['sucursale']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Sucursale id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $sucursale = $this->Sucursales->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $sucursale = $this->Sucursales->patchEntity($sucursale, $this->request->data);
            if ($this->Sucursales->save($sucursale)) {
                $this->Flash->success('The sucursale has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The sucursale could not be saved. Please, try again.');
            }
        }
        $clientes = $this->Sucursales->Clientes->find('list', ['limit' => 200]);
        $provincias = $this->Sucursales->Provincias->find('list', ['limit' => 200]);
        $localidads = $this->Sucursales->Localidads->find('list', ['limit' => 200]);
        $this->set(compact('sucursale', 'clientes', 'provincias', 'localidads'));
        $this->set('_serialize', ['sucursale']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Sucursale id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $sucursale = $this->Sucursales->get($id);
        if ($this->Sucursales->delete($sucursale)) {
            $this->Flash->success('The sucursale has been deleted.');
        } else {
            $this->Flash->error('The sucursale could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
