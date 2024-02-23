<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CarritosPreventas Controller
 *
 * @property \App\Model\Table\CarritosPreventasTable $CarritosPreventas
 *
 * @method \App\Model\Entity\CarritosPreventa[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CarritosPreventasController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Clientes', 'Articulos', 'Combos', 'Categorias']
        ];
        $carritosPreventas = $this->paginate($this->CarritosPreventas);

        $this->set(compact('carritosPreventas'));
    }

    /**
     * View method
     *
     * @param string|null $id Carritos Preventa id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $carritosPreventa = $this->CarritosPreventas->get($id, [
            'contain' => ['Clientes', 'Articulos', 'Combos', 'Categorias']
        ]);

        $this->set('carritosPreventa', $carritosPreventa);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $carritosPreventa = $this->CarritosPreventas->newEntity();
        if ($this->request->is('post')) {
            $carritosPreventa = $this->CarritosPreventas->patchEntity($carritosPreventa, $this->request->getData());
            if ($this->CarritosPreventas->save($carritosPreventa)) {
                $this->Flash->success(__('The carritos preventa has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The carritos preventa could not be saved. Please, try again.'));
        }
        $clientes = $this->CarritosPreventas->Clientes->find('list', ['limit' => 200]);
        $articulos = $this->CarritosPreventas->Articulos->find('list', ['limit' => 200]);
        $combos = $this->CarritosPreventas->Combos->find('list', ['limit' => 200]);
        $categorias = $this->CarritosPreventas->Categorias->find('list', ['limit' => 200]);
        $this->set(compact('carritosPreventa', 'clientes', 'articulos', 'combos', 'categorias'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Carritos Preventa id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $carritosPreventa = $this->CarritosPreventas->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $carritosPreventa = $this->CarritosPreventas->patchEntity($carritosPreventa, $this->request->getData());
            if ($this->CarritosPreventas->save($carritosPreventa)) {
                $this->Flash->success(__('The carritos preventa has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The carritos preventa could not be saved. Please, try again.'));
        }
        $clientes = $this->CarritosPreventas->Clientes->find('list', ['limit' => 200]);
        $articulos = $this->CarritosPreventas->Articulos->find('list', ['limit' => 200]);
        $combos = $this->CarritosPreventas->Combos->find('list', ['limit' => 200]);
        $categorias = $this->CarritosPreventas->Categorias->find('list', ['limit' => 200]);
        $this->set(compact('carritosPreventa', 'clientes', 'articulos', 'combos', 'categorias'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Carritos Preventa id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $carritosPreventa = $this->CarritosPreventas->get($id);
        if ($this->CarritosPreventas->delete($carritosPreventa)) {
            $this->Flash->success(__('The carritos preventa has been deleted.'));
        } else {
            $this->Flash->error(__('The carritos preventa could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
