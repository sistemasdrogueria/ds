<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Perfiles Controller
 *
 * @property \App\Model\Table\PerfilesTable $Perfiles
 */
class PerfilesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('perfiles', $this->paginate($this->Perfiles));
        $this->set('_serialize', ['perfiles']);
    }

    /**
     * View method
     *
     * @param string|null $id Perfile id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $perfile = $this->Perfiles->get($id, [
            'contain' => ['Usuarios']
        ]);
        $this->set('perfile', $perfile);
        $this->set('_serialize', ['perfile']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $perfile = $this->Perfiles->newEntity();
        if ($this->request->is('post')) {
            $perfile = $this->Perfiles->patchEntity($perfile, $this->request->data);
            if ($this->Perfiles->save($perfile)) {
                $this->Flash->success('The perfile has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The perfile could not be saved. Please, try again.');
            }
        }
        $this->set(compact('perfile'));
        $this->set('_serialize', ['perfile']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Perfile id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $perfile = $this->Perfiles->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $perfile = $this->Perfiles->patchEntity($perfile, $this->request->data);
            if ($this->Perfiles->save($perfile)) {
                $this->Flash->success('The perfile has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The perfile could not be saved. Please, try again.');
            }
        }
        $this->set(compact('perfile'));
        $this->set('_serialize', ['perfile']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Perfile id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $perfile = $this->Perfiles->get($id);
        if ($this->Perfiles->delete($perfile)) {
            $this->Flash->success('The perfile has been deleted.');
        } else {
            $this->Flash->error('The perfile could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
