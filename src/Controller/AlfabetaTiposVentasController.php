<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * AlfabetaTiposVentas Controller
 *
 * @property \App\Model\Table\AlfabetaTiposVentasTable $AlfabetaTiposVentas
 *
 * @method \App\Model\Entity\AlfabetaTiposVenta[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AlfabetaTiposVentasController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $alfabetaTiposVentas = $this->paginate($this->AlfabetaTiposVentas);

        $this->set(compact('alfabetaTiposVentas'));
    }

    /**
     * View method
     *
     * @param string|null $id Alfabeta Tipos Venta id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $alfabetaTiposVenta = $this->AlfabetaTiposVentas->get($id, [
            'contain' => []
        ]);

        $this->set('alfabetaTiposVenta', $alfabetaTiposVenta);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $alfabetaTiposVenta = $this->AlfabetaTiposVentas->newEntity();
        if ($this->request->is('post')) {
            $alfabetaTiposVenta = $this->AlfabetaTiposVentas->patchEntity($alfabetaTiposVenta, $this->request->getData());
            if ($this->AlfabetaTiposVentas->save($alfabetaTiposVenta)) {
                $this->Flash->success(__('The alfabeta tipos venta has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The alfabeta tipos venta could not be saved. Please, try again.'));
        }
        $this->set(compact('alfabetaTiposVenta'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Alfabeta Tipos Venta id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $alfabetaTiposVenta = $this->AlfabetaTiposVentas->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $alfabetaTiposVenta = $this->AlfabetaTiposVentas->patchEntity($alfabetaTiposVenta, $this->request->getData());
            if ($this->AlfabetaTiposVentas->save($alfabetaTiposVenta)) {
                $this->Flash->success(__('The alfabeta tipos venta has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The alfabeta tipos venta could not be saved. Please, try again.'));
        }
        $this->set(compact('alfabetaTiposVenta'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Alfabeta Tipos Venta id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $alfabetaTiposVenta = $this->AlfabetaTiposVentas->get($id);
        if ($this->AlfabetaTiposVentas->delete($alfabetaTiposVenta)) {
            $this->Flash->success(__('The alfabeta tipos venta has been deleted.'));
        } else {
            $this->Flash->error(__('The alfabeta tipos venta could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
