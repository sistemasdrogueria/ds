<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CarritosTemps Controller
 *
 * @property \App\Model\Table\CarritosTempsTable $CarritosTemps
 */
class CarritosTempsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Clientes', 'Articulos', 'Combos']
        ];
        $this->set('carritosTemps', $this->paginate($this->CarritosTemps));
        $this->set('_serialize', ['carritosTemps']);
    }

    /**
     * View method
     *
     * @param string|null $id Carritos Temp id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $carritosTemp = $this->CarritosTemps->get($id, [
            'contain' => ['Clientes', 'Articulos', 'Combos']
        ]);
        $this->set('carritosTemp', $carritosTemp);
        $this->set('_serialize', ['carritosTemp']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $carritosTemp = $this->CarritosTemps->newEntity();
        if ($this->request->is('post')) {
            $carritosTemp = $this->CarritosTemps->patchEntity($carritosTemp, $this->request->data);
            if ($this->CarritosTemps->save($carritosTemp)) {
                $this->Flash->success(__('The carritos temp has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The carritos temp could not be saved. Please, try again.'));
            }
        }
        $clientes = $this->CarritosTemps->Clientes->find('list', ['limit' => 200]);
        $articulos = $this->CarritosTemps->Articulos->find('list', ['limit' => 200]);
        $combos = $this->CarritosTemps->Combos->find('list', ['limit' => 200]);
        $this->set(compact('carritosTemp', 'clientes', 'articulos', 'combos'));
        $this->set('_serialize', ['carritosTemp']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Carritos Temp id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $carritosTemp = $this->CarritosTemps->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $carritosTemp = $this->CarritosTemps->patchEntity($carritosTemp, $this->request->data);
            if ($this->CarritosTemps->save($carritosTemp)) {
                $this->Flash->success(__('The carritos temp has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The carritos temp could not be saved. Please, try again.'));
            }
        }
        $clientes = $this->CarritosTemps->Clientes->find('list', ['limit' => 200]);
        $articulos = $this->CarritosTemps->Articulos->find('list', ['limit' => 200]);
        $combos = $this->CarritosTemps->Combos->find('list', ['limit' => 200]);
        $this->set(compact('carritosTemp', 'clientes', 'articulos', 'combos'));
        $this->set('_serialize', ['carritosTemp']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Carritos Temp id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $carritosTemp = $this->CarritosTemps->get($id);
        if ($this->CarritosTemps->delete($carritosTemp)) {
            $this->Flash->success(__('The carritos temp has been deleted.'));
        } else {
            $this->Flash->error(__('The carritos temp could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
