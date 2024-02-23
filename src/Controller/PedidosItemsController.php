<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * PedidosItems Controller
 *
 * @property \App\Model\Table\PedidosItemsTable $PedidosItems
 */
class PedidosItemsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Pedidos', 'Articulos', 'Combos']
        ];
        $this->set('pedidosItems', $this->paginate($this->PedidosItems));
        $this->set('_serialize', ['pedidosItems']);
    }

    /**
     * View method
     *
     * @param string|null $id Pedidos Item id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $pedidosItem = $this->PedidosItems->get($id, [
            'contain' => ['Pedidos', 'Articulos', 'Combos']
        ]);
        $this->set('pedidosItem', $pedidosItem);
        $this->set('_serialize', ['pedidosItem']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $pedidosItem = $this->PedidosItems->newEntity();
        if ($this->request->is('post')) {
            $pedidosItem = $this->PedidosItems->patchEntity($pedidosItem, $this->request->data);
            if ($this->PedidosItems->save($pedidosItem)) {
                $this->Flash->success('The pedidos item has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The pedidos item could not be saved. Please, try again.');
            }
        }
        $pedidos = $this->PedidosItems->Pedidos->find('list', ['limit' => 200]);
        $articulos = $this->PedidosItems->Articulos->find('list', ['limit' => 200]);
        $combos = $this->PedidosItems->Combos->find('list', ['limit' => 200]);
        $this->set(compact('pedidosItem', 'pedidos', 'articulos', 'combos'));
        $this->set('_serialize', ['pedidosItem']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Pedidos Item id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $pedidosItem = $this->PedidosItems->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $pedidosItem = $this->PedidosItems->patchEntity($pedidosItem, $this->request->data);
            if ($this->PedidosItems->save($pedidosItem)) {
                $this->Flash->success('The pedidos item has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The pedidos item could not be saved. Please, try again.');
            }
        }
        $pedidos = $this->PedidosItems->Pedidos->find('list', ['limit' => 200]);
        $articulos = $this->PedidosItems->Articulos->find('list', ['limit' => 200]);
        $combos = $this->PedidosItems->Combos->find('list', ['limit' => 200]);
        $this->set(compact('pedidosItem', 'pedidos', 'articulos', 'combos'));
        $this->set('_serialize', ['pedidosItem']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Pedidos Item id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $pedidosItem = $this->PedidosItems->get($id);
        if ($this->PedidosItems->delete($pedidosItem)) {
            $this->Flash->success('The pedidos item has been deleted.');
        } else {
            $this->Flash->error('The pedidos item could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
