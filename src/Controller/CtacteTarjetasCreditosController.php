<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CtacteTarjetasCreditos Controller
 *
 * @property \App\Model\Table\CtacteTarjetasCreditosTable $CtacteTarjetasCreditos
 */
class CtacteTarjetasCreditosController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Clientes']
        ];
        $this->set('ctacteTarjetasCreditos', $this->paginate($this->CtacteTarjetasCreditos));
        $this->set('_serialize', ['ctacteTarjetasCreditos']);
    }

    /**
     * View method
     *
     * @param string|null $id Ctacte Tarjetas Credito id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $ctacteTarjetasCredito = $this->CtacteTarjetasCreditos->get($id, [
            'contain' => ['Clientes']
        ]);
        $this->set('ctacteTarjetasCredito', $ctacteTarjetasCredito);
        $this->set('_serialize', ['ctacteTarjetasCredito']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $ctacteTarjetasCredito = $this->CtacteTarjetasCreditos->newEntity();
        if ($this->request->is('post')) {
            $ctacteTarjetasCredito = $this->CtacteTarjetasCreditos->patchEntity($ctacteTarjetasCredito, $this->request->data);
            if ($this->CtacteTarjetasCreditos->save($ctacteTarjetasCredito)) {
                $this->Flash->success(__('The ctacte tarjetas credito has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The ctacte tarjetas credito could not be saved. Please, try again.'));
            }
        }
        $clientes = $this->CtacteTarjetasCreditos->Clientes->find('list', ['limit' => 200]);
        $this->set(compact('ctacteTarjetasCredito', 'clientes'));
        $this->set('_serialize', ['ctacteTarjetasCredito']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Ctacte Tarjetas Credito id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $ctacteTarjetasCredito = $this->CtacteTarjetasCreditos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ctacteTarjetasCredito = $this->CtacteTarjetasCreditos->patchEntity($ctacteTarjetasCredito, $this->request->data);
            if ($this->CtacteTarjetasCreditos->save($ctacteTarjetasCredito)) {
                $this->Flash->success(__('The ctacte tarjetas credito has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The ctacte tarjetas credito could not be saved. Please, try again.'));
            }
        }
        $clientes = $this->CtacteTarjetasCreditos->Clientes->find('list', ['limit' => 200]);
        $this->set(compact('ctacteTarjetasCredito', 'clientes'));
        $this->set('_serialize', ['ctacteTarjetasCredito']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Ctacte Tarjetas Credito id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ctacteTarjetasCredito = $this->CtacteTarjetasCreditos->get($id);
        if ($this->CtacteTarjetasCreditos->delete($ctacteTarjetasCredito)) {
            $this->Flash->success(__('The ctacte tarjetas credito has been deleted.'));
        } else {
            $this->Flash->error(__('The ctacte tarjetas credito could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
