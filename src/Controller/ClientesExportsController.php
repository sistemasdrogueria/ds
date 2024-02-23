<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ClientesExports Controller
 *
 * @property \App\Model\Table\ClientesExportsTable $ClientesExports
 */
class ClientesExportsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ClienteComuns', 'ClienteExports']
        ];
        $this->set('clientesExports', $this->paginate($this->ClientesExports));
        $this->set('_serialize', ['clientesExports']);
    }

    /**
     * View method
     *
     * @param string|null $id Clientes Export id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $clientesExport = $this->ClientesExports->get($id, [
            'contain' => ['ClienteComuns', 'ClienteExports']
        ]);
        $this->set('clientesExport', $clientesExport);
        $this->set('_serialize', ['clientesExport']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $clientesExport = $this->ClientesExports->newEntity();
        if ($this->request->is('post')) {
            $clientesExport = $this->ClientesExports->patchEntity($clientesExport, $this->request->data);
            if ($this->ClientesExports->save($clientesExport)) {
                $this->Flash->success(__('The clientes export has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The clientes export could not be saved. Please, try again.'));
            }
        }
        $clienteComuns = $this->ClientesExports->ClienteComuns->find('list', ['limit' => 200]);
        $clienteExports = $this->ClientesExports->ClienteExports->find('list', ['limit' => 200]);
        $this->set(compact('clientesExport', 'clienteComuns', 'clienteExports'));
        $this->set('_serialize', ['clientesExport']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Clientes Export id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $clientesExport = $this->ClientesExports->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $clientesExport = $this->ClientesExports->patchEntity($clientesExport, $this->request->data);
            if ($this->ClientesExports->save($clientesExport)) {
                $this->Flash->success(__('The clientes export has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The clientes export could not be saved. Please, try again.'));
            }
        }
        $clienteComuns = $this->ClientesExports->ClienteComuns->find('list', ['limit' => 200]);
        $clienteExports = $this->ClientesExports->ClienteExports->find('list', ['limit' => 200]);
        $this->set(compact('clientesExport', 'clienteComuns', 'clienteExports'));
        $this->set('_serialize', ['clientesExport']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Clientes Export id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $clientesExport = $this->ClientesExports->get($id);
        if ($this->ClientesExports->delete($clientesExport)) {
            $this->Flash->success(__('The clientes export has been deleted.'));
        } else {
            $this->Flash->error(__('The clientes export could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
