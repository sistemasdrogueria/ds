<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Sucursals Controller
 *
 * @property \App\Model\Table\SucursalsTable $Sucursals
 */
class SucursalsController extends AppController
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
        $this->set('sucursals', $this->paginate($this->Sucursals));
        $this->set('_serialize', ['sucursals']);
    }

    /**
     * View method
     *
     * @param string|null $id Sucursal id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $sucursal = $this->Sucursals->get($id, [
            'contain' => ['Clientes', 'Provincias', 'Localidads', 'Pedidos']
        ]);
        $this->set('sucursal', $sucursal);
        $this->set('_serialize', ['sucursal']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $sucursal = $this->Sucursals->newEntity();
        if ($this->request->is('post')) {
            $sucursal = $this->Sucursals->patchEntity($sucursal, $this->request->data);
            if ($this->Sucursals->save($sucursal)) {
                $this->Flash->success('The sucursal has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The sucursal could not be saved. Please, try again.');
            }
        }
        $clientes = $this->Sucursals->Clientes->find('list', ['limit' => 200]);
        $provincias = $this->Sucursals->Provincias->find('list', ['limit' => 200]);
        $localidads = $this->Sucursals->Localidads->find('list', ['limit' => 200]);
        $this->set(compact('sucursal', 'clientes', 'provincias', 'localidads'));
        $this->set('_serialize', ['sucursal']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Sucursal id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $sucursal = $this->Sucursals->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $sucursal = $this->Sucursals->patchEntity($sucursal, $this->request->data);
            if ($this->Sucursals->save($sucursal)) {
                $this->Flash->success('The sucursal has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The sucursal could not be saved. Please, try again.');
            }
        }
        $clientes = $this->Sucursals->Clientes->find('list', ['limit' => 200]);
        $provincias = $this->Sucursals->Provincias->find('list', ['limit' => 200]);
        $localidads = $this->Sucursals->Localidads->find('list', ['limit' => 200]);
        $this->set(compact('sucursal', 'clientes', 'provincias', 'localidads'));
        $this->set('_serialize', ['sucursal']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Sucursal id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $sucursal = $this->Sucursals->get($id);
        if ($this->Sucursals->delete($sucursal)) {
            $this->Flash->success('The sucursal has been deleted.');
        } else {
            $this->Flash->error('The sucursal could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
