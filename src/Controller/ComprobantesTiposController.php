<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ComprobantesTipos Controller
 *
 * @property \App\Model\Table\ComprobantesTiposTable $ComprobantesTipos
 */
class ComprobantesTiposController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('comprobantesTipos', $this->paginate($this->ComprobantesTipos));
        $this->set('_serialize', ['comprobantesTipos']);
    }

    /**
     * View method
     *
     * @param string|null $id Comprobantes Tipo id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $comprobantesTipo = $this->ComprobantesTipos->get($id, [
            'contain' => []
        ]);
        $this->set('comprobantesTipo', $comprobantesTipo);
        $this->set('_serialize', ['comprobantesTipo']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $comprobantesTipo = $this->ComprobantesTipos->newEntity();
        if ($this->request->is('post')) {
            $comprobantesTipo = $this->ComprobantesTipos->patchEntity($comprobantesTipo, $this->request->data);
            if ($this->ComprobantesTipos->save($comprobantesTipo)) {
                $this->Flash->success(__('The comprobantes tipo has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The comprobantes tipo could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('comprobantesTipo'));
        $this->set('_serialize', ['comprobantesTipo']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Comprobantes Tipo id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $comprobantesTipo = $this->ComprobantesTipos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $comprobantesTipo = $this->ComprobantesTipos->patchEntity($comprobantesTipo, $this->request->data);
            if ($this->ComprobantesTipos->save($comprobantesTipo)) {
                $this->Flash->success(__('The comprobantes tipo has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The comprobantes tipo could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('comprobantesTipo'));
        $this->set('_serialize', ['comprobantesTipo']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Comprobantes Tipo id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $comprobantesTipo = $this->ComprobantesTipos->get($id);
        if ($this->ComprobantesTipos->delete($comprobantesTipo)) {
            $this->Flash->success(__('The comprobantes tipo has been deleted.'));
        } else {
            $this->Flash->error(__('The comprobantes tipo could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
