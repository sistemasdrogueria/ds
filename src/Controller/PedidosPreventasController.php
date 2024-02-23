<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * PedidosPreventas Controller
 *
 * @property \App\Model\Table\PedidosPreventasTable $PedidosPreventas
 *
 * @method \App\Model\Entity\PedidosPreventa[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PedidosPreventasController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Clientes', 'Sucursals', 'Estados', 'PedidosStatuses']
        ];
        $pedidosPreventas = $this->paginate($this->PedidosPreventas);

        $this->set(compact('pedidosPreventas'));
    }

    /**
     * View method
     *
     * @param string|null $id Pedidos Preventa id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $pedidosPreventa = $this->PedidosPreventas->get($id, [
            'contain' => ['Clientes', 'Sucursals', 'Estados', 'PedidosStatuses']
        ]);

        $this->set('pedidosPreventa', $pedidosPreventa);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $pedidosPreventa = $this->PedidosPreventas->newEntity();
        if ($this->request->is('post')) {
            $pedidosPreventa = $this->PedidosPreventas->patchEntity($pedidosPreventa, $this->request->getData());
            if ($this->PedidosPreventas->save($pedidosPreventa)) {
                $this->Flash->success(__('The pedidos preventa has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The pedidos preventa could not be saved. Please, try again.'));
        }
        $clientes = $this->PedidosPreventas->Clientes->find('list', ['limit' => 200]);
        $sucursals = $this->PedidosPreventas->Sucursals->find('list', ['limit' => 200]);
        $estados = $this->PedidosPreventas->Estados->find('list', ['limit' => 200]);
        $pedidosStatuses = $this->PedidosPreventas->PedidosStatuses->find('list', ['limit' => 200]);
        $this->set(compact('pedidosPreventa', 'clientes', 'sucursals', 'estados', 'pedidosStatuses'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Pedidos Preventa id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $pedidosPreventa = $this->PedidosPreventas->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $pedidosPreventa = $this->PedidosPreventas->patchEntity($pedidosPreventa, $this->request->getData());
            if ($this->PedidosPreventas->save($pedidosPreventa)) {
                $this->Flash->success(__('The pedidos preventa has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The pedidos preventa could not be saved. Please, try again.'));
        }
        $clientes = $this->PedidosPreventas->Clientes->find('list', ['limit' => 200]);
        $sucursals = $this->PedidosPreventas->Sucursals->find('list', ['limit' => 200]);
        $estados = $this->PedidosPreventas->Estados->find('list', ['limit' => 200]);
        $pedidosStatuses = $this->PedidosPreventas->PedidosStatuses->find('list', ['limit' => 200]);
        $this->set(compact('pedidosPreventa', 'clientes', 'sucursals', 'estados', 'pedidosStatuses'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Pedidos Preventa id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $pedidosPreventa = $this->PedidosPreventas->get($id);
        if ($this->PedidosPreventas->delete($pedidosPreventa)) {
            $this->Flash->success(__('The pedidos preventa has been deleted.'));
        } else {
            $this->Flash->error(__('The pedidos preventa could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
