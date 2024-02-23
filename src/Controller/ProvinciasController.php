<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Provincias Controller
 *
 * @property \App\Model\Table\ProvinciasTable $Provincias
 */
class ProvinciasController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('provincias', $this->paginate($this->Provincias));
        $this->set('_serialize', ['provincias']);
    }

    /**
     * View method
     *
     * @param string|null $id Provincia id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $provincia = $this->Provincias->get($id, [
            'contain' => ['Clientes', 'Proveedors', 'Sucursals']
        ]);
        $this->set('provincia', $provincia);
        $this->set('_serialize', ['provincia']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $provincia = $this->Provincias->newEntity();
        if ($this->request->is('post')) {
            $provincia = $this->Provincias->patchEntity($provincia, $this->request->data);
            if ($this->Provincias->save($provincia)) {
                $this->Flash->success('The provincia has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The provincia could not be saved. Please, try again.');
            }
        }
        $this->set(compact('provincia'));
        $this->set('_serialize', ['provincia']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Provincia id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $provincia = $this->Provincias->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $provincia = $this->Provincias->patchEntity($provincia, $this->request->data);
            if ($this->Provincias->save($provincia)) {
                $this->Flash->success('The provincia has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The provincia could not be saved. Please, try again.');
            }
        }
        $this->set(compact('provincia'));
        $this->set('_serialize', ['provincia']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Provincia id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $provincia = $this->Provincias->get($id);
        if ($this->Provincias->delete($provincia)) {
            $this->Flash->success('The provincia has been deleted.');
        } else {
            $this->Flash->error('The provincia could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
