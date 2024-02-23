<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * FacturasCuerposItems Controller
 *
 * @property \App\Model\Table\FacturasCuerposItemsTable $FacturasCuerposItems
 */
class FacturasCuerposItemsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['FacturasCabeceras', 'Articulos']
        ];
        $this->set('facturasCuerposItems', $this->paginate($this->FacturasCuerposItems));
        $this->set('_serialize', ['facturasCuerposItems']);
    }

    /**
     * View method
     *
     * @param string|null $id Facturas Cuerpos Item id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $facturasCuerposItem = $this->FacturasCuerposItems->get($id, [
            'contain' => ['FacturasCabeceras', 'Articulos']
        ]);
        $this->set('facturasCuerposItem', $facturasCuerposItem);
        $this->set('_serialize', ['facturasCuerposItem']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $facturasCuerposItem = $this->FacturasCuerposItems->newEntity();
        if ($this->request->is('post')) {
            $facturasCuerposItem = $this->FacturasCuerposItems->patchEntity($facturasCuerposItem, $this->request->data);
            if ($this->FacturasCuerposItems->save($facturasCuerposItem)) {
                $this->Flash->success(__('The facturas cuerpos item has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The facturas cuerpos item could not be saved. Please, try again.'));
            }
        }
        $facturasCabeceras = $this->FacturasCuerposItems->FacturasCabeceras->find('list', ['limit' => 200]);
        $articulos = $this->FacturasCuerposItems->Articulos->find('list', ['limit' => 200]);
        $this->set(compact('facturasCuerposItem', 'facturasCabeceras', 'articulos'));
        $this->set('_serialize', ['facturasCuerposItem']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Facturas Cuerpos Item id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $facturasCuerposItem = $this->FacturasCuerposItems->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $facturasCuerposItem = $this->FacturasCuerposItems->patchEntity($facturasCuerposItem, $this->request->data);
            if ($this->FacturasCuerposItems->save($facturasCuerposItem)) {
                $this->Flash->success(__('The facturas cuerpos item has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The facturas cuerpos item could not be saved. Please, try again.'));
            }
        }
        $facturasCabeceras = $this->FacturasCuerposItems->FacturasCabeceras->find('list', ['limit' => 200]);
        $articulos = $this->FacturasCuerposItems->Articulos->find('list', ['limit' => 200]);
        $this->set(compact('facturasCuerposItem', 'facturasCabeceras', 'articulos'));
        $this->set('_serialize', ['facturasCuerposItem']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Facturas Cuerpos Item id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $facturasCuerposItem = $this->FacturasCuerposItems->get($id);
        if ($this->FacturasCuerposItems->delete($facturasCuerposItem)) {
            $this->Flash->success(__('The facturas cuerpos item has been deleted.'));
        } else {
            $this->Flash->error(__('The facturas cuerpos item could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
