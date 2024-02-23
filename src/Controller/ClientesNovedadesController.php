<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 *ClientesNovedades Controller
 * * @property \App\Model\Table\ClientesNovedadesTable $ClientesNovedades *
 * @method \App\Model\Entity\ClientesNovedade[] paginate($object = null, array $settings = []) */
class ClientesNovedadesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {        $this->paginate = [
            'contain' => ['ClientesNovedadesTipos']
        ];        $clientesNovedades = $this->paginate($this->ClientesNovedades);

        $this->set(compact('clientesNovedades'));
        $this->set('_serialize', ['clientesNovedades']);
    }

    /**
     * View method
     *
     * @param string|null $idClientes Novedade id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $clientesNovedade = $this->ClientesNovedades->get($id, [
            'contain' => ['ClientesNovedadesTipos']
        ]);

        $this->set('clientesNovedade', $clientesNovedade);
        $this->set('_serialize', ['clientesNovedade']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $clientesNovedade = $this->ClientesNovedades->newEntity();
        if ($this->request->is('post')) {
            $clientesNovedade = $this->ClientesNovedades->patchEntity($clientesNovedade, $this->request->getData());
            if ($this->ClientesNovedades->save($clientesNovedade)) {
                $this->Flash->success(__('Theclientes novedade has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Theclientes novedade could not be saved. Please, try again.'));
        }        $clientesNovedadesTipos = $this->ClientesNovedades->ClientesNovedadesTipos->find('list', ['limit' => 200]);
        $this->set(compact('clientesNovedade', 'clientesNovedadesTipos'));
        $this->set('_serialize', ['clientesNovedade']);
    }

    /**
     * Edit method
     *
     * @param string|null $idClientes Novedade id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $clientesNovedade = $this->ClientesNovedades->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $clientesNovedade = $this->ClientesNovedades->patchEntity($clientesNovedade, $this->request->getData());
            if ($this->ClientesNovedades->save($clientesNovedade)) {
                $this->Flash->success(__('Theclientes novedade has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Theclientes novedade could not be saved. Please, try again.'));
        }        $clientesNovedadesTipos = $this->ClientesNovedades->ClientesNovedadesTipos->find('list', ['limit' => 200]);
        $this->set(compact('clientesNovedade', 'clientesNovedadesTipos'));
        $this->set('_serialize', ['clientesNovedade']);
    }

    /**
     * Delete method
     *
     * @param string|null $idClientes Novedade id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $clientesNovedade = $this->ClientesNovedades->get($id);
        if ($this->ClientesNovedades->delete($clientesNovedade)) {
            $this->Flash->success(__('Theclientes novedade has been deleted.'));
        } else {
            $this->Flash->error(__('Theclientes novedade could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
