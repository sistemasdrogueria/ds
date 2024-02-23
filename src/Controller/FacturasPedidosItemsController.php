<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * FacturasPedidosItems Controller
 *
 * @property \App\Model\Table\FacturasPedidosItemsTable $FacturasPedidosItems
 */
class FacturasPedidosItemsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['FacturasPedidos']
        ];
        $this->set('facturasPedidosItems', $this->paginate($this->FacturasPedidosItems));
        $this->set('_serialize', ['facturasPedidosItems']);
    }

    /**
     * View method
     *
     * @param string|null $id Facturas Pedidos Item id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $facturasPedidosItem = $this->FacturasPedidosItems->get($id, [
            'contain' => ['FacturasPedidos']
        ]);
        $this->set('facturasPedidosItem', $facturasPedidosItem);
        $this->set('_serialize', ['facturasPedidosItem']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $facturasPedidosItem = $this->FacturasPedidosItems->newEntity();
        if ($this->request->is('post')) {
            $facturasPedidosItem = $this->FacturasPedidosItems->patchEntity($facturasPedidosItem, $this->request->data);
            if ($this->FacturasPedidosItems->save($facturasPedidosItem)) {
                $this->Flash->success('The facturas pedidos item has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The facturas pedidos item could not be saved. Please, try again.');
            }
        }
        $facturasPedidos = $this->FacturasPedidosItems->FacturasPedidos->find('list', ['limit' => 200]);
        $this->set(compact('facturasPedidosItem', 'facturasPedidos'));
        $this->set('_serialize', ['facturasPedidosItem']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Facturas Pedidos Item id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $facturasPedidosItem = $this->FacturasPedidosItems->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $facturasPedidosItem = $this->FacturasPedidosItems->patchEntity($facturasPedidosItem, $this->request->data);
            if ($this->FacturasPedidosItems->save($facturasPedidosItem)) {
                $this->Flash->success('The facturas pedidos item has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The facturas pedidos item could not be saved. Please, try again.');
            }
        }
        $facturasPedidos = $this->FacturasPedidosItems->FacturasPedidos->find('list', ['limit' => 200]);
        $this->set(compact('facturasPedidosItem', 'facturasPedidos'));
        $this->set('_serialize', ['facturasPedidosItem']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Facturas Pedidos Item id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $facturasPedidosItem = $this->FacturasPedidosItems->get($id);
        if ($this->FacturasPedidosItems->delete($facturasPedidosItem)) {
            $this->Flash->success('The facturas pedidos item has been deleted.');
        } else {
            $this->Flash->error('The facturas pedidos item could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
