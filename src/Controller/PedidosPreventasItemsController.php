<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * PedidosPreventasItems Controller
 *
 * @property \App\Model\Table\PedidosPreventasItemsTable $PedidosPreventasItems
 *
 * @method \App\Model\Entity\PedidosPreventasItem[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PedidosPreventasItemsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Pedidos', 'Articulos', 'Combos', 'PedidosItemsStatuses']
        ];
        $pedidosPreventasItems = $this->paginate($this->PedidosPreventasItems);

        $this->set(compact('pedidosPreventasItems'));
    }

    /**
     * View method
     *
     * @param string|null $id Pedidos Preventas Item id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $pedidosPreventasItem = $this->PedidosPreventasItems->get($id, [
            'contain' => ['Pedidos', 'Articulos', 'Combos', 'PedidosItemsStatuses']
        ]);

        $this->set('pedidosPreventasItem', $pedidosPreventasItem);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $pedidosPreventasItem = $this->PedidosPreventasItems->newEntity();
        if ($this->request->is('post')) {
            $pedidosPreventasItem = $this->PedidosPreventasItems->patchEntity($pedidosPreventasItem, $this->request->getData());
            if ($this->PedidosPreventasItems->save($pedidosPreventasItem)) {
                $this->Flash->success(__('The pedidos preventas item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The pedidos preventas item could not be saved. Please, try again.'));
        }
        $pedidos = $this->PedidosPreventasItems->Pedidos->find('list', ['limit' => 200]);
        $articulos = $this->PedidosPreventasItems->Articulos->find('list', ['limit' => 200]);
        $combos = $this->PedidosPreventasItems->Combos->find('list', ['limit' => 200]);
        $pedidosItemsStatuses = $this->PedidosPreventasItems->PedidosItemsStatuses->find('list', ['limit' => 200]);
        $this->set(compact('pedidosPreventasItem', 'pedidos', 'articulos', 'combos', 'pedidosItemsStatuses'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Pedidos Preventas Item id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $pedidosPreventasItem = $this->PedidosPreventasItems->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $pedidosPreventasItem = $this->PedidosPreventasItems->patchEntity($pedidosPreventasItem, $this->request->getData());
            if ($this->PedidosPreventasItems->save($pedidosPreventasItem)) {
                $this->Flash->success(__('The pedidos preventas item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The pedidos preventas item could not be saved. Please, try again.'));
        }
        $pedidos = $this->PedidosPreventasItems->Pedidos->find('list', ['limit' => 200]);
        $articulos = $this->PedidosPreventasItems->Articulos->find('list', ['limit' => 200]);
        $combos = $this->PedidosPreventasItems->Combos->find('list', ['limit' => 200]);
        $pedidosItemsStatuses = $this->PedidosPreventasItems->PedidosItemsStatuses->find('list', ['limit' => 200]);
        $this->set(compact('pedidosPreventasItem', 'pedidos', 'articulos', 'combos', 'pedidosItemsStatuses'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Pedidos Preventas Item id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $pedidosPreventasItem = $this->PedidosPreventasItems->get($id);
        if ($this->PedidosPreventasItems->delete($pedidosPreventasItem)) {
            $this->Flash->success(__('The pedidos preventas item has been deleted.'));
        } else {
            $this->Flash->error(__('The pedidos preventas item could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
