<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * NotasCabeceras Controller
 *
 * @property \App\Model\Table\NotasCabecerasTable $NotasCabeceras
 */
class NotasCabecerasController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Clientes', 'Comprobantes']
        ];
        $notasCabeceras = $this->paginate($this->NotasCabeceras);

        $this->set(compact('notasCabeceras'));
        $this->set('_serialize', ['notasCabeceras']);
    }

    /**
     * View method
     *
     * @param string|null $id Notas Cabecera id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $notasCabecera = $this->NotasCabeceras->get($id, [
            'contain' => ['Clientes', 'Comprobantes']
        ]);

        $this->set('notasCabecera', $notasCabecera);
        $this->set('_serialize', ['notasCabecera']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $notasCabecera = $this->NotasCabeceras->newEntity();
        if ($this->request->is('post')) {
            $notasCabecera = $this->NotasCabeceras->patchEntity($notasCabecera, $this->request->data);
            if ($this->NotasCabeceras->save($notasCabecera)) {
                $this->Flash->success(__('The notas cabecera has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The notas cabecera could not be saved. Please, try again.'));
            }
        }
        $clientes = $this->NotasCabeceras->Clientes->find('list', ['limit' => 200]);
        $comprobantes = $this->NotasCabeceras->Comprobantes->find('list', ['limit' => 200]);
        $this->set(compact('notasCabecera', 'clientes', 'comprobantes'));
        $this->set('_serialize', ['notasCabecera']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Notas Cabecera id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $notasCabecera = $this->NotasCabeceras->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $notasCabecera = $this->NotasCabeceras->patchEntity($notasCabecera, $this->request->data);
            if ($this->NotasCabeceras->save($notasCabecera)) {
                $this->Flash->success(__('The notas cabecera has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The notas cabecera could not be saved. Please, try again.'));
            }
        }
        $clientes = $this->NotasCabeceras->Clientes->find('list', ['limit' => 200]);
        $comprobantes = $this->NotasCabeceras->Comprobantes->find('list', ['limit' => 200]);
        $this->set(compact('notasCabecera', 'clientes', 'comprobantes'));
        $this->set('_serialize', ['notasCabecera']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Notas Cabecera id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $notasCabecera = $this->NotasCabeceras->get($id);
        if ($this->NotasCabeceras->delete($notasCabecera)) {
            $this->Flash->success(__('The notas cabecera has been deleted.'));
        } else {
            $this->Flash->error(__('The notas cabecera could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
