<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * FacturasPedidos Controller
 *
 * @property \App\Model\Table\FacturasPedidosTable $FacturasPedidos
 */
class FacturasPedidosController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Clientes', 'Pedidos']
        ];
        $this->set('facturasPedidos', $this->paginate($this->FacturasPedidos));
        $this->set('_serialize', ['facturasPedidos']);
    }

    /**
     * View method
     *
     * @param string|null $id Facturas Pedido id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $facturasPedido = $this->FacturasPedidos->get($id, [
            'contain' => ['Clientes', 'Pedidos']
        ]);
        $this->set('facturasPedido', $facturasPedido);
        $this->set('_serialize', ['facturasPedido']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $facturasPedido = $this->FacturasPedidos->newEntity();
        if ($this->request->is('post')) {
            $facturasPedido = $this->FacturasPedidos->patchEntity($facturasPedido, $this->request->data);
            if ($this->FacturasPedidos->save($facturasPedido)) {
                $this->Flash->success('The facturas pedido has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The facturas pedido could not be saved. Please, try again.');
            }
        }
        $clientes = $this->FacturasPedidos->Clientes->find('list', ['limit' => 200]);
        $pedidos = $this->FacturasPedidos->Pedidos->find('list', ['limit' => 200]);
        $this->set(compact('facturasPedido', 'clientes', 'pedidos'));
        $this->set('_serialize', ['facturasPedido']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Facturas Pedido id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $facturasPedido = $this->FacturasPedidos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $facturasPedido = $this->FacturasPedidos->patchEntity($facturasPedido, $this->request->data);
            if ($this->FacturasPedidos->save($facturasPedido)) {
                $this->Flash->success('The facturas pedido has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The facturas pedido could not be saved. Please, try again.');
            }
        }
        $clientes = $this->FacturasPedidos->Clientes->find('list', ['limit' => 200]);
        $pedidos = $this->FacturasPedidos->Pedidos->find('list', ['limit' => 200]);
        $this->set(compact('facturasPedido', 'clientes', 'pedidos'));
        $this->set('_serialize', ['facturasPedido']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Facturas Pedido id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $facturasPedido = $this->FacturasPedidos->get($id);
        if ($this->FacturasPedidos->delete($facturasPedido)) {
            $this->Flash->success('The facturas pedido has been deleted.');
        } else {
            $this->Flash->error('The facturas pedido could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
