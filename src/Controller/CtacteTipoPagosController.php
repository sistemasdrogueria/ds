<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CtacteTipoPagos Controller
 *
 * @property \App\Model\Table\CtacteTipoPagosTable $CtacteTipoPagos
 */
class CtacteTipoPagosController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('ctacteTipoPagos', $this->paginate($this->CtacteTipoPagos));
        $this->set('_serialize', ['ctacteTipoPagos']);
    }

    /**
     * View method
     *
     * @param string|null $id Ctacte Tipo Pago id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $ctacteTipoPago = $this->CtacteTipoPagos->get($id, [
            'contain' => []
        ]);
        $this->set('ctacteTipoPago', $ctacteTipoPago);
        $this->set('_serialize', ['ctacteTipoPago']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $ctacteTipoPago = $this->CtacteTipoPagos->newEntity();
        if ($this->request->is('post')) {
            $ctacteTipoPago = $this->CtacteTipoPagos->patchEntity($ctacteTipoPago, $this->request->data);
            if ($this->CtacteTipoPagos->save($ctacteTipoPago)) {
                $this->Flash->success(__('The ctacte tipo pago has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The ctacte tipo pago could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('ctacteTipoPago'));
        $this->set('_serialize', ['ctacteTipoPago']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Ctacte Tipo Pago id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $ctacteTipoPago = $this->CtacteTipoPagos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ctacteTipoPago = $this->CtacteTipoPagos->patchEntity($ctacteTipoPago, $this->request->data);
            if ($this->CtacteTipoPagos->save($ctacteTipoPago)) {
                $this->Flash->success(__('The ctacte tipo pago has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The ctacte tipo pago could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('ctacteTipoPago'));
        $this->set('_serialize', ['ctacteTipoPago']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Ctacte Tipo Pago id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ctacteTipoPago = $this->CtacteTipoPagos->get($id);
        if ($this->CtacteTipoPagos->delete($ctacteTipoPago)) {
            $this->Flash->success(__('The ctacte tipo pago has been deleted.'));
        } else {
            $this->Flash->error(__('The ctacte tipo pago could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
