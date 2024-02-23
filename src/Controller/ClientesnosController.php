<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Clientesnos Controller
 *
 * @property \App\Model\Table\ClientesnosTable $Clientesnos
 */
class ClientesnosController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('clientesnos', $this->paginate($this->Clientesnos));
        $this->set('_serialize', ['clientesnos']);
    }

    /**
     * View method
     *
     * @param string|null $id Clientesno id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $clientesno = $this->Clientesnos->get($id, [
            'contain' => []
        ]);
        $this->set('clientesno', $clientesno);
        $this->set('_serialize', ['clientesno']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $clientesno = $this->Clientesnos->newEntity();
        if ($this->request->is('post')) {
            $clientesno = $this->Clientesnos->patchEntity($clientesno, $this->request->data);
            if ($this->Clientesnos->save($clientesno)) {
                $this->Flash->success(__('The clientesno has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The clientesno could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('clientesno'));
        $this->set('_serialize', ['clientesno']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Clientesno id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $clientesno = $this->Clientesnos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $clientesno = $this->Clientesnos->patchEntity($clientesno, $this->request->data);
            if ($this->Clientesnos->save($clientesno)) {
                $this->Flash->success(__('The clientesno has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The clientesno could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('clientesno'));
        $this->set('_serialize', ['clientesno']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Clientesno id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $clientesno = $this->Clientesnos->get($id);
        if ($this->Clientesnos->delete($clientesno)) {
            $this->Flash->success(__('The clientesno has been deleted.'));
        } else {
            $this->Flash->error(__('The clientesno could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
