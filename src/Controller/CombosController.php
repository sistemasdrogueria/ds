<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Combos Controller
 *
 * @property \App\Model\Table\CombosTable $Combos
 */
class CombosController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('combos', $this->paginate($this->Combos));
        $this->set('_serialize', ['combos']);
    }

    /**
     * View method
     *
     * @param string|null $id Combo id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $combo = $this->Combos->get($id, [
            'contain' => ['CarritosItems', 'PedidosItems']
        ]);
        $this->set('combo', $combo);
        $this->set('_serialize', ['combo']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $combo = $this->Combos->newEntity();
        if ($this->request->is('post')) {
            $combo = $this->Combos->patchEntity($combo, $this->request->data);
            if ($this->Combos->save($combo)) {
                $this->Flash->success('The combo has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The combo could not be saved. Please, try again.');
            }
        }
        $this->set(compact('combo'));
        $this->set('_serialize', ['combo']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Combo id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $combo = $this->Combos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $combo = $this->Combos->patchEntity($combo, $this->request->data);
            if ($this->Combos->save($combo)) {
                $this->Flash->success('The combo has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The combo could not be saved. Please, try again.');
            }
        }
        $this->set(compact('combo'));
        $this->set('_serialize', ['combo']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Combo id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $combo = $this->Combos->get($id);
        if ($this->Combos->delete($combo)) {
            $this->Flash->success('The combo has been deleted.');
        } else {
            $this->Flash->error('The combo could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
