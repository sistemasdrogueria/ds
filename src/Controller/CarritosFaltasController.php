<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CarritosFaltas Controller
 *
 * @property \App\Model\Table\CarritosFaltasTable $CarritosFaltas
 *
 * @method \App\Model\Entity\CarritosFalta[] paginate($object = null, array $settings = [])
 */
class CarritosFaltasController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Clientes', 'Articulos']
        ];
        $carritosFaltas = $this->paginate($this->CarritosFaltas);

        $this->set(compact('carritosFaltas'));
        $this->set('_serialize', ['carritosFaltas']);
    }

    /**
     * View method
     *
     * @param string|null $id Carritos Falta id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $carritosFalta = $this->CarritosFaltas->get($id, [
            'contain' => ['Clientes', 'Articulos']
        ]);

        $this->set('carritosFalta', $carritosFalta);
        $this->set('_serialize', ['carritosFalta']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $carritosFalta = $this->CarritosFaltas->newEntity();
        if ($this->request->is('post')) {
            $carritosFalta = $this->CarritosFaltas->patchEntity($carritosFalta, $this->request->getData());
            if ($this->CarritosFaltas->save($carritosFalta)) {
                $this->Flash->success(__('The carritos falta has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The carritos falta could not be saved. Please, try again.'));
        }
        $clientes = $this->CarritosFaltas->Clientes->find('list', ['limit' => 200]);
        $articulos = $this->CarritosFaltas->Articulos->find('list', ['limit' => 200]);

        $this->set(compact('carritosFalta', 'clientes', 'articulos'));
        $this->set('_serialize', ['carritosFalta']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Carritos Falta id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $carritosFalta = $this->CarritosFaltas->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $carritosFalta = $this->CarritosFaltas->patchEntity($carritosFalta, $this->request->getData());
            if ($this->CarritosFaltas->save($carritosFalta)) {
                $this->Flash->success(__('The carritos falta has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The carritos falta could not be saved. Please, try again.'));
        }
        $clientes = $this->CarritosFaltas->Clientes->find('list', ['limit' => 200]);
        $articulos = $this->CarritosFaltas->Articulos->find('list', ['limit' => 200]);

        $this->set(compact('carritosFalta', 'clientes', 'articulos'));
        $this->set('_serialize', ['carritosFalta']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Carritos Falta id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $carritosFalta = $this->CarritosFaltas->get($id);
        if ($this->CarritosFaltas->delete($carritosFalta)) {
            $this->Flash->success(__('The carritos falta has been deleted.'));
        } else {
            $this->Flash->error(__('The carritos falta could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
