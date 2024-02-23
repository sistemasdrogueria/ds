<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Comprobantes Controller
 *
 * @property \App\Model\Table\ComprobantesTable $Comprobantes
 */
class ComprobantesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Clientes', 'ComprobantesTipos']
        ];
        $this->set('comprobantes', $this->paginate($this->Comprobantes));
        $this->set('_serialize', ['comprobantes']);
    }

    /**
     * View method
     *
     * @param string|null $id Comprobante id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $comprobante = $this->Comprobantes->get($id, [
            'contain' => ['Clientes', 'ComprobantesTipos']
        ]);
        $this->set('comprobante', $comprobante);
        $this->set('_serialize', ['comprobante']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $comprobante = $this->Comprobantes->newEntity();
        if ($this->request->is('post')) {
            $comprobante = $this->Comprobantes->patchEntity($comprobante, $this->request->data);
            if ($this->Comprobantes->save($comprobante)) {
                $this->Flash->success(__('The comprobante has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The comprobante could not be saved. Please, try again.'));
            }
        }
        $clientes = $this->Comprobantes->Clientes->find('list', ['limit' => 200]);
        $comprobantesTipos = $this->Comprobantes->ComprobantesTipos->find('list', ['limit' => 200]);
        $this->set(compact('comprobante', 'clientes', 'comprobantesTipos'));
        $this->set('_serialize', ['comprobante']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Comprobante id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $comprobante = $this->Comprobantes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $comprobante = $this->Comprobantes->patchEntity($comprobante, $this->request->data);
            if ($this->Comprobantes->save($comprobante)) {
                $this->Flash->success(__('The comprobante has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The comprobante could not be saved. Please, try again.'));
            }
        }
        $clientes = $this->Comprobantes->Clientes->find('list', ['limit' => 200]);
        $comprobantesTipos = $this->Comprobantes->ComprobantesTipos->find('list', ['limit' => 200]);
        $this->set(compact('comprobante', 'clientes', 'comprobantesTipos'));
        $this->set('_serialize', ['comprobante']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Comprobante id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $comprobante = $this->Comprobantes->get($id);
        if ($this->Comprobantes->delete($comprobante)) {
            $this->Flash->success(__('The comprobante has been deleted.'));
        } else {
            $this->Flash->error(__('The comprobante could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
