<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * FacturasCabeceras Controller
 *
 * @property \App\Model\Table\FacturasCabecerasTable $FacturasCabeceras
 */
class FacturasCabecerasController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Clientes', 'Comprobantes']
        ];
        $this->set('facturasCabeceras', $this->paginate($this->FacturasCabeceras));
        $this->set('_serialize', ['facturasCabeceras']);
    }

    /**
     * View method
     *
     * @param string|null $id Facturas Cabecera id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $facturasCabecera = $this->FacturasCabeceras->get($id, [
            'contain' => ['Clientes', 'Comprobantes']
        ]);
        $this->set('facturasCabecera', $facturasCabecera);
        $this->set('_serialize', ['facturasCabecera']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $facturasCabecera = $this->FacturasCabeceras->newEntity();
        if ($this->request->is('post')) {
            $facturasCabecera = $this->FacturasCabeceras->patchEntity($facturasCabecera, $this->request->data);
            if ($this->FacturasCabeceras->save($facturasCabecera)) {
                $this->Flash->success(__('The facturas cabecera has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The facturas cabecera could not be saved. Please, try again.'));
            }
        }
        $clientes = $this->FacturasCabeceras->Clientes->find('list', ['limit' => 200]);
        $comprobantes = $this->FacturasCabeceras->Comprobantes->find('list', ['limit' => 200]);
        $this->set(compact('facturasCabecera', 'clientes', 'comprobantes'));
        $this->set('_serialize', ['facturasCabecera']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Facturas Cabecera id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $facturasCabecera = $this->FacturasCabeceras->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $facturasCabecera = $this->FacturasCabeceras->patchEntity($facturasCabecera, $this->request->data);
            if ($this->FacturasCabeceras->save($facturasCabecera)) {
                $this->Flash->success(__('The facturas cabecera has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The facturas cabecera could not be saved. Please, try again.'));
            }
        }
        $clientes = $this->FacturasCabeceras->Clientes->find('list', ['limit' => 200]);
        $comprobantes = $this->FacturasCabeceras->Comprobantes->find('list', ['limit' => 200]);
        $this->set(compact('facturasCabecera', 'clientes', 'comprobantes'));
        $this->set('_serialize', ['facturasCabecera']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Facturas Cabecera id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $facturasCabecera = $this->FacturasCabeceras->get($id);
        if ($this->FacturasCabeceras->delete($facturasCabecera)) {
            $this->Flash->success(__('The facturas cabecera has been deleted.'));
        } else {
            $this->Flash->error(__('The facturas cabecera could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
