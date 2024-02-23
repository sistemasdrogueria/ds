<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ClientesCreditos Controller
 *
 * @property \App\Model\Table\ClientesCreditosTable $ClientesCreditos
 */
class ClientesCreditosController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Clientes']
        ];
        $this->set('clientesCreditos', $this->paginate($this->ClientesCreditos));
        $this->set('_serialize', ['clientesCreditos']);
    }

    /**
     * View method
     *
     * @param string|null $id Clientes Credito id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $clientesCredito = $this->ClientesCreditos->get($id, [
            'contain' => ['Clientes']
        ]);
        $this->set('clientesCredito', $clientesCredito);
        $this->set('_serialize', ['clientesCredito']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $clientesCredito = $this->ClientesCreditos->newEntity();
        if ($this->request->is('post')) {
            $clientesCredito = $this->ClientesCreditos->patchEntity($clientesCredito, $this->request->data);
            if ($this->ClientesCreditos->save($clientesCredito)) {
                $this->Flash->success(__('The clientes credito has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The clientes credito could not be saved. Please, try again.'));
            }
        }
        $clientes = $this->ClientesCreditos->Clientes->find('list', ['limit' => 200]);
        $this->set(compact('clientesCredito', 'clientes'));
        $this->set('_serialize', ['clientesCredito']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Clientes Credito id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $clientesCredito = $this->ClientesCreditos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $clientesCredito = $this->ClientesCreditos->patchEntity($clientesCredito, $this->request->data);
            if ($this->ClientesCreditos->save($clientesCredito)) {
                $this->Flash->success(__('The clientes credito has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The clientes credito could not be saved. Please, try again.'));
            }
        }
        $clientes = $this->ClientesCreditos->Clientes->find('list', ['limit' => 200]);
        $this->set(compact('clientesCredito', 'clientes'));
        $this->set('_serialize', ['clientesCredito']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Clientes Credito id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $clientesCredito = $this->ClientesCreditos->get($id);
        if ($this->ClientesCreditos->delete($clientesCredito)) {
            $this->Flash->success(__('The clientes credito has been deleted.'));
        } else {
            $this->Flash->error(__('The clientes credito could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
