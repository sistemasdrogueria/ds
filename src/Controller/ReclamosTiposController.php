<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ReclamosTipos Controller
 *
 * @property \App\Model\Table\ReclamosTiposTable $ReclamosTipos
 */
class ReclamosTiposController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
		$this->layout = 'admin';
        $this->set('reclamosTipos', $this->paginate($this->ReclamosTipos));
        $this->set('_serialize', ['reclamosTipos']);
    }

    /**
     * View method
     *
     * @param string|null $id Reclamos Tipo id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $reclamosTipo = $this->ReclamosTipos->get($id, [
            'contain' => ['Reclamos']
        ]);
        $this->set('reclamosTipo', $reclamosTipo);
        $this->set('_serialize', ['reclamosTipo']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $reclamosTipo = $this->ReclamosTipos->newEntity();
        if ($this->request->is('post')) {
            $reclamosTipo = $this->ReclamosTipos->patchEntity($reclamosTipo, $this->request->data);
            if ($this->ReclamosTipos->save($reclamosTipo)) {
                $this->Flash->success('The reclamos tipo has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The reclamos tipo could not be saved. Please, try again.');
            }
        }
        $this->set(compact('reclamosTipo'));
        $this->set('_serialize', ['reclamosTipo']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Reclamos Tipo id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $reclamosTipo = $this->ReclamosTipos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $reclamosTipo = $this->ReclamosTipos->patchEntity($reclamosTipo, $this->request->data);
            if ($this->ReclamosTipos->save($reclamosTipo)) {
                $this->Flash->success('The reclamos tipo has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The reclamos tipo could not be saved. Please, try again.');
            }
        }
        $this->set(compact('reclamosTipo'));
        $this->set('_serialize', ['reclamosTipo']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Reclamos Tipo id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $reclamosTipo = $this->ReclamosTipos->get($id);
        if ($this->ReclamosTipos->delete($reclamosTipo)) {
            $this->Flash->success('The reclamos tipo has been deleted.');
        } else {
            $this->Flash->error('The reclamos tipo could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
