<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * FacturasCuerposItemsLotesVctos Controller
 *
 * @property \App\Model\Table\FacturasCuerposItemsLotesVctosTable $FacturasCuerposItemsLotesVctos
 *
 * @method \App\Model\Entity\FacturasCuerposItemsLotesVcto[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FacturasCuerposItemsLotesVctosController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Articulos', 'Clientes']
        ];
        $facturasCuerposItemsLotesVctos = $this->paginate($this->FacturasCuerposItemsLotesVctos);

        $this->set(compact('facturasCuerposItemsLotesVctos'));
    }

    /**
     * View method
     *
     * @param string|null $id Facturas Cuerpos Items Lotes Vcto id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $facturasCuerposItemsLotesVcto = $this->FacturasCuerposItemsLotesVctos->get($id, [
            'contain' => ['Articulos', 'Clientes']
        ]);

        $this->set('facturasCuerposItemsLotesVcto', $facturasCuerposItemsLotesVcto);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $facturasCuerposItemsLotesVcto = $this->FacturasCuerposItemsLotesVctos->newEntity();
        if ($this->request->is('post')) {
            $facturasCuerposItemsLotesVcto = $this->FacturasCuerposItemsLotesVctos->patchEntity($facturasCuerposItemsLotesVcto, $this->request->getData());
            if ($this->FacturasCuerposItemsLotesVctos->save($facturasCuerposItemsLotesVcto)) {
                $this->Flash->success(__('The facturas cuerpos items lotes vcto has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The facturas cuerpos items lotes vcto could not be saved. Please, try again.'));
        }
        $articulos = $this->FacturasCuerposItemsLotesVctos->Articulos->find('list', ['limit' => 200]);
        $clientes = $this->FacturasCuerposItemsLotesVctos->Clientes->find('list', ['limit' => 200]);
        $this->set(compact('facturasCuerposItemsLotesVcto', 'articulos', 'clientes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Facturas Cuerpos Items Lotes Vcto id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $facturasCuerposItemsLotesVcto = $this->FacturasCuerposItemsLotesVctos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $facturasCuerposItemsLotesVcto = $this->FacturasCuerposItemsLotesVctos->patchEntity($facturasCuerposItemsLotesVcto, $this->request->getData());
            if ($this->FacturasCuerposItemsLotesVctos->save($facturasCuerposItemsLotesVcto)) {
                $this->Flash->success(__('The facturas cuerpos items lotes vcto has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The facturas cuerpos items lotes vcto could not be saved. Please, try again.'));
        }
        $articulos = $this->FacturasCuerposItemsLotesVctos->Articulos->find('list', ['limit' => 200]);
        $clientes = $this->FacturasCuerposItemsLotesVctos->Clientes->find('list', ['limit' => 200]);
        $this->set(compact('facturasCuerposItemsLotesVcto', 'articulos', 'clientes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Facturas Cuerpos Items Lotes Vcto id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $facturasCuerposItemsLotesVcto = $this->FacturasCuerposItemsLotesVctos->get($id);
        if ($this->FacturasCuerposItemsLotesVctos->delete($facturasCuerposItemsLotesVcto)) {
            $this->Flash->success(__('The facturas cuerpos items lotes vcto has been deleted.'));
        } else {
            $this->Flash->error(__('The facturas cuerpos items lotes vcto could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
