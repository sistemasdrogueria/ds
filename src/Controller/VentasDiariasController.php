<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * VentasDiarias Controller
 *
 * @property \App\Model\Table\VentasDiariasTable $VentasDiarias
 *
 * @method \App\Model\Entity\VentasDiaria[] paginate($object = null, array $settings = [])
 */
class VentasDiariasController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Clientes']
        ];
        $ventasDiarias = $this->paginate($this->VentasDiarias);

        $this->set(compact('ventasDiarias'));
        $this->set('_serialize', ['ventasDiarias']);
    }

    /**
     * View method
     *
     * @param string|null $id Ventas Diaria id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $ventasDiaria = $this->VentasDiarias->get($id, [
            'contain' => ['Clientes']
        ]);

        $this->set('ventasDiaria', $ventasDiaria);
        $this->set('_serialize', ['ventasDiaria']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $ventasDiaria = $this->VentasDiarias->newEntity();
        if ($this->request->is('post')) {
            $ventasDiaria = $this->VentasDiarias->patchEntity($ventasDiaria, $this->request->getData());
            if ($this->VentasDiarias->save($ventasDiaria)) {
                $this->Flash->success(__('The ventas diaria has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ventas diaria could not be saved. Please, try again.'));
        }
        $clientes = $this->VentasDiarias->Clientes->find('list', ['limit' => 200]);
        $this->set(compact('ventasDiaria', 'clientes'));
        $this->set('_serialize', ['ventasDiaria']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Ventas Diaria id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $ventasDiaria = $this->VentasDiarias->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ventasDiaria = $this->VentasDiarias->patchEntity($ventasDiaria, $this->request->getData());
            if ($this->VentasDiarias->save($ventasDiaria)) {
                $this->Flash->success(__('The ventas diaria has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ventas diaria could not be saved. Please, try again.'));
        }
        $clientes = $this->VentasDiarias->Clientes->find('list', ['limit' => 200]);
        $this->set(compact('ventasDiaria', 'clientes'));
        $this->set('_serialize', ['ventasDiaria']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Ventas Diaria id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ventasDiaria = $this->VentasDiarias->get($id);
        if ($this->VentasDiarias->delete($ventasDiaria)) {
            $this->Flash->success(__('The ventas diaria has been deleted.'));
        } else {
            $this->Flash->error(__('The ventas diaria could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
