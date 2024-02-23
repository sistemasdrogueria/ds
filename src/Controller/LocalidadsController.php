<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Localidads Controller
 *
 * @property \App\Model\Table\LocalidadsTable $Localidads
 */
class LocalidadsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Provincias']
        ];
        $this->set('localidads', $this->paginate($this->Localidads));
        $this->set('_serialize', ['localidads']);
    }

    /**
     * View method
     *
     * @param string|null $id Localidad id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $localidad = $this->Localidads->get($id, [
            'contain' => ['Provincias', 'Clientes', 'Proveedors', 'Sucursals']
        ]);
        $this->set('localidad', $localidad);
        $this->set('_serialize', ['localidad']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $localidad = $this->Localidads->newEntity();
        if ($this->request->is('post')) {
            $localidad = $this->Localidads->patchEntity($localidad, $this->request->data);
            if ($this->Localidads->save($localidad)) {
                $this->Flash->success('The localidad has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The localidad could not be saved. Please, try again.');
            }
        }
        $provincias = $this->Localidads->Provincias->find('list', ['limit' => 200]);
        $this->set(compact('localidad', 'provincias'));
        $this->set('_serialize', ['localidad']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Localidad id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $localidad = $this->Localidads->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $localidad = $this->Localidads->patchEntity($localidad, $this->request->data);
            if ($this->Localidads->save($localidad)) {
                $this->Flash->success('The localidad has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The localidad could not be saved. Please, try again.');
            }
        }
        $provincias = $this->Localidads->Provincias->find('list', ['limit' => 200]);
        $this->set(compact('localidad', 'provincias'));
        $this->set('_serialize', ['localidad']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Localidad id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $localidad = $this->Localidads->get($id);
        if ($this->Localidads->delete($localidad)) {
            $this->Flash->success('The localidad has been deleted.');
        } else {
            $this->Flash->error('The localidad could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
