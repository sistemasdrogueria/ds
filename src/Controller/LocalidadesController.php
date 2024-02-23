<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Localidades Controller
 *
 * @property \App\Model\Table\LocalidadesTable $Localidades
 */
class LocalidadesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('localidades', $this->paginate($this->Localidades));
        $this->set('_serialize', ['localidades']);
    }

    /**
     * View method
     *
     * @param string|null $id Localidade id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $localidade = $this->Localidades->get($id, [
            'contain' => []
        ]);
        $this->set('localidade', $localidade);
        $this->set('_serialize', ['localidade']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $localidade = $this->Localidades->newEntity();
        if ($this->request->is('post')) {
            $localidade = $this->Localidades->patchEntity($localidade, $this->request->data);
            if ($this->Localidades->save($localidade)) {
                $this->Flash->success('The localidade has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The localidade could not be saved. Please, try again.');
            }
        }
        $this->set(compact('localidade'));
        $this->set('_serialize', ['localidade']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Localidade id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $localidade = $this->Localidades->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $localidade = $this->Localidades->patchEntity($localidade, $this->request->data);
            if ($this->Localidades->save($localidade)) {
                $this->Flash->success('The localidade has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The localidade could not be saved. Please, try again.');
            }
        }
        $this->set(compact('localidade'));
        $this->set('_serialize', ['localidade']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Localidade id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $localidade = $this->Localidades->get($id);
        if ($this->Localidades->delete($localidade)) {
            $this->Flash->success('The localidade has been deleted.');
        } else {
            $this->Flash->error('The localidade could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
