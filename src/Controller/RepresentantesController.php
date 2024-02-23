<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Representantes Controller
 *
 * @property \App\Model\Table\RepresentantesTable $Representantes
 */
class RepresentantesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('representantes', $this->paginate($this->Representantes));
        $this->set('_serialize', ['representantes']);
    }

    /**
     * View method
     *
     * @param string|null $id Representante id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $representante = $this->Representantes->get($id, [
            'contain' => ['Clientes']
        ]);
        $this->set('representante', $representante);
        $this->set('_serialize', ['representante']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $representante = $this->Representantes->newEntity();
        if ($this->request->is('post')) {
            $representante = $this->Representantes->patchEntity($representante, $this->request->data);
            if ($this->Representantes->save($representante)) {
                $this->Flash->success('The representante has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The representante could not be saved. Please, try again.');
            }
        }
        $this->set(compact('representante'));
        $this->set('_serialize', ['representante']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Representante id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $representante = $this->Representantes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $representante = $this->Representantes->patchEntity($representante, $this->request->data);
            if ($this->Representantes->save($representante)) {
                $this->Flash->success('The representante has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The representante could not be saved. Please, try again.');
            }
        }
        $this->set(compact('representante'));
        $this->set('_serialize', ['representante']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Representante id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $representante = $this->Representantes->get($id);
        if ($this->Representantes->delete($representante)) {
            $this->Flash->success('The representante has been deleted.');
        } else {
            $this->Flash->error('The representante could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
