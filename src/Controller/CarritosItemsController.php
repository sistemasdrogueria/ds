<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CarritosItems Controller
 *
 * @property \App\Model\Table\CarritosItemsTable $CarritosItems
 */
class CarritosItemsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Carritos', 'Articulos', 'Combos']
        ];
        $this->set('carritosItems', $this->paginate($this->CarritosItems));
        $this->set('_serialize', ['carritosItems']);
    }

    /**
     * View method
     *
     * @param string|null $id Carritos Item id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $carritosItem = $this->CarritosItems->get($id, [
            'contain' => ['Carritos', 'Articulos', 'Combos']
        ]);
        $this->set('carritosItem', $carritosItem);
        $this->set('_serialize', ['carritosItem']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $carritosItem = $this->CarritosItems->newEntity();
        if ($this->request->is('post')) {
            $carritosItem = $this->CarritosItems->patchEntity($carritosItem, $this->request->data);
            if ($this->CarritosItems->save($carritosItem)) {
                $this->Flash->success('The carritos item has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The carritos item could not be saved. Please, try again.');
            }
        }
        $carritos = $this->CarritosItems->Carritos->find('list', ['limit' => 200]);
        $articulos = $this->CarritosItems->Articulos->find('list', ['limit' => 200]);
        $combos = $this->CarritosItems->Combos->find('list', ['limit' => 200]);
        $this->set(compact('carritosItem', 'carritos', 'articulos', 'combos'));
        $this->set('_serialize', ['carritosItem']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Carritos Item id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $carritosItem = $this->CarritosItems->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $carritosItem = $this->CarritosItems->patchEntity($carritosItem, $this->request->data);
            if ($this->CarritosItems->save($carritosItem)) {
                $this->Flash->success('The carritos item has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The carritos item could not be saved. Please, try again.');
            }
        }
        $carritos = $this->CarritosItems->Carritos->find('list', ['limit' => 200]);
        $articulos = $this->CarritosItems->Articulos->find('list', ['limit' => 200]);
        $combos = $this->CarritosItems->Combos->find('list', ['limit' => 200]);
        $this->set(compact('carritosItem', 'carritos', 'articulos', 'combos'));
        $this->set('_serialize', ['carritosItem']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Carritos Item id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $carritosItem = $this->CarritosItems->get($id);
        if ($this->CarritosItems->delete($carritosItem)) {
            $this->Flash->success('The carritos item has been deleted.');
        } else {
            $this->Flash->error('The carritos item could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
