<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ReclamosEstados Controller
 *
 * @property \App\Model\Table\ReclamosEstadosTable $ReclamosEstados
 */
class ReclamosEstadosController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('reclamosEstados', $this->paginate($this->ReclamosEstados));
        $this->set('_serialize', ['reclamosEstados']);
    }

    /**
     * View method
     *
     * @param string|null $id Reclamos Estado id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $reclamosEstado = $this->ReclamosEstados->get($id, [
            'contain' => []
        ]);
        $this->set('reclamosEstado', $reclamosEstado);
        $this->set('_serialize', ['reclamosEstado']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $reclamosEstado = $this->ReclamosEstados->newEntity();
        if ($this->request->is('post')) {
            $reclamosEstado = $this->ReclamosEstados->patchEntity($reclamosEstado, $this->request->data);
            if ($this->ReclamosEstados->save($reclamosEstado)) {
                $this->Flash->success(__('The reclamos estado has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The reclamos estado could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('reclamosEstado'));
        $this->set('_serialize', ['reclamosEstado']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Reclamos Estado id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $reclamosEstado = $this->ReclamosEstados->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $reclamosEstado = $this->ReclamosEstados->patchEntity($reclamosEstado, $this->request->data);
            if ($this->ReclamosEstados->save($reclamosEstado)) {
                $this->Flash->success(__('The reclamos estado has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The reclamos estado could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('reclamosEstado'));
        $this->set('_serialize', ['reclamosEstado']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Reclamos Estado id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $reclamosEstado = $this->ReclamosEstados->get($id);
        if ($this->ReclamosEstados->delete($reclamosEstado)) {
            $this->Flash->success(__('The reclamos estado has been deleted.'));
        } else {
            $this->Flash->error(__('The reclamos estado could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
