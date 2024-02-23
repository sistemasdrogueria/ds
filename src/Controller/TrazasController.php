<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Trazas Controller
 *
 * @property \App\Model\Table\TrazasTable $Trazas
 */
class TrazasController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Articulos', 'Clientes']
        ];
        $this->set('trazas', $this->paginate($this->Trazas));
        $this->set('_serialize', ['trazas']);
    }

    /**
     * View method
     *
     * @param string|null $id Traza id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $traza = $this->Trazas->get($id, [
            'contain' => ['Articulos', 'Clientes']
        ]);
        $this->set('traza', $traza);
        $this->set('_serialize', ['traza']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $traza = $this->Trazas->newEntity();
        if ($this->request->is('post')) {
            $traza = $this->Trazas->patchEntity($traza, $this->request->data);
            if ($this->Trazas->save($traza)) {
                $this->Flash->success(__('The traza has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The traza could not be saved. Please, try again.'));
            }
        }
        $articulos = $this->Trazas->Articulos->find('list', ['limit' => 200]);
        $clientes = $this->Trazas->Clientes->find('list', ['limit' => 200]);
        $this->set(compact('traza', 'articulos', 'clientes'));
        $this->set('_serialize', ['traza']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Traza id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $traza = $this->Trazas->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $traza = $this->Trazas->patchEntity($traza, $this->request->data);
            if ($this->Trazas->save($traza)) {
                $this->Flash->success(__('The traza has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The traza could not be saved. Please, try again.'));
            }
        }
        $articulos = $this->Trazas->Articulos->find('list', ['limit' => 200]);
        $clientes = $this->Trazas->Clientes->find('list', ['limit' => 200]);
        $this->set(compact('traza', 'articulos', 'clientes'));
        $this->set('_serialize', ['traza']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Traza id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $traza = $this->Trazas->get($id);
        if ($this->Trazas->delete($traza)) {
            $this->Flash->success(__('The traza has been deleted.'));
        } else {
            $this->Flash->error(__('The traza could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
