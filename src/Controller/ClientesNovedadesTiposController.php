<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 *ClientesNovedadesTipos Controller
 * * @property \App\Model\Table\ClientesNovedadesTiposTable $ClientesNovedadesTipos *
 * @method \App\Model\Entity\ClientesNovedadesTipo[] paginate($object = null, array $settings = []) 
 * */
class ClientesNovedadesTiposController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {        
        $clientesNovedadesTipos = $this->paginate($this->ClientesNovedadesTipos);

        $this->set(compact('clientesNovedadesTipos'));
        $this->set('_serialize', ['clientesNovedadesTipos']);
    }

    /**
     * View method
     *
     * @param string|null $idClientes Novedades Tipo id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $clientesNovedadesTipo = $this->ClientesNovedadesTipos->get($id, [
            'contain' => []
        ]);

        $this->set('clientesNovedadesTipo', $clientesNovedadesTipo);
        $this->set('_serialize', ['clientesNovedadesTipo']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $clientesNovedadesTipo = $this->ClientesNovedadesTipos->newEntity();
        if ($this->request->is('post')) {
            $clientesNovedadesTipo = $this->ClientesNovedadesTipos->patchEntity($clientesNovedadesTipo, $this->request->getData());
            if ($this->ClientesNovedadesTipos->save($clientesNovedadesTipo)) {
                $this->Flash->success(__('Theclientes novedades tipo has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Theclientes novedades tipo could not be saved. Please, try again.'));
        }        $this->set(compact('clientesNovedadesTipo'));
        $this->set('_serialize', ['clientesNovedadesTipo']);
    }

    /**
     * Edit method
     *
     * @param string|null $idClientes Novedades Tipo id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $clientesNovedadesTipo = $this->ClientesNovedadesTipos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $clientesNovedadesTipo = $this->ClientesNovedadesTipos->patchEntity($clientesNovedadesTipo, $this->request->getData());
            if ($this->ClientesNovedadesTipos->save($clientesNovedadesTipo)) {
                $this->Flash->success(__('Theclientes novedades tipo has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Theclientes novedades tipo could not be saved. Please, try again.'));
        }        $this->set(compact('clientesNovedadesTipo'));
        $this->set('_serialize', ['clientesNovedadesTipo']);
    }

    /**
     * Delete method
     *
     * @param string|null $idClientes Novedades Tipo id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $clientesNovedadesTipo = $this->ClientesNovedadesTipos->get($id);
        if ($this->ClientesNovedadesTipos->delete($clientesNovedadesTipo)) {
            $this->Flash->success(__('Theclientes novedades tipo has been deleted.'));
        } else {
            $this->Flash->error(__('Theclientes novedades tipo could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
