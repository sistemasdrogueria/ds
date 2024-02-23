<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ComprasSemanas Controller
 *
 * @property \App\Model\Table\ComprasSemanasTable $ComprasSemanas
 */
class ComprasSemanasController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('comprasSemanas', $this->paginate($this->ComprasSemanas));
        $this->set('_serialize', ['comprasSemanas']);
    }

    /**
     * View method
     *
     * @param string|null $id Compras Semana id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $comprasSemana = $this->ComprasSemanas->get($id, [
            'contain' => []
        ]);
        $this->set('comprasSemana', $comprasSemana);
        $this->set('_serialize', ['comprasSemana']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $comprasSemana = $this->ComprasSemanas->newEntity();
        if ($this->request->is('post')) {
            $comprasSemana = $this->ComprasSemanas->patchEntity($comprasSemana, $this->request->data);
            if ($this->ComprasSemanas->save($comprasSemana)) {
                $this->Flash->success('The compras semana has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The compras semana could not be saved. Please, try again.');
            }
        }
        $this->set(compact('comprasSemana'));
        $this->set('_serialize', ['comprasSemana']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Compras Semana id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $comprasSemana = $this->ComprasSemanas->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $comprasSemana = $this->ComprasSemanas->patchEntity($comprasSemana, $this->request->data);
            if ($this->ComprasSemanas->save($comprasSemana)) {
                $this->Flash->success('The compras semana has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The compras semana could not be saved. Please, try again.');
            }
        }
        $this->set(compact('comprasSemana'));
        $this->set('_serialize', ['comprasSemana']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Compras Semana id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $comprasSemana = $this->ComprasSemanas->get($id);
        if ($this->ComprasSemanas->delete($comprasSemana)) {
            $this->Flash->success('The compras semana has been deleted.');
        } else {
            $this->Flash->error('The compras semana could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
