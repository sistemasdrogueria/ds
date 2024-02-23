<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CtacteDocumentoCarteras Controller
 *
 * @property \App\Model\Table\CtacteDocumentoCarterasTable $CtacteDocumentoCarteras
 */
class CtacteDocumentoCarterasController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Clientes']
        ];
		
		
        $this->set('ctacteDocumentoCarteras', $this->paginate($this->CtacteDocumentoCarteras));
        $this->set('_serialize', ['ctacteDocumentoCarteras']);
    }

    /**
     * View method
     *
     * @param string|null $id Ctacte Documento Cartera id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $ctacteDocumentoCartera = $this->CtacteDocumentoCarteras->get($id, [
            'contain' => ['Clientes']
        ]);
        $this->set('ctacteDocumentoCartera', $ctacteDocumentoCartera);
        $this->set('_serialize', ['ctacteDocumentoCartera']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $ctacteDocumentoCartera = $this->CtacteDocumentoCarteras->newEntity();
        if ($this->request->is('post')) {
            $ctacteDocumentoCartera = $this->CtacteDocumentoCarteras->patchEntity($ctacteDocumentoCartera, $this->request->data);
            if ($this->CtacteDocumentoCarteras->save($ctacteDocumentoCartera)) {
                $this->Flash->success(__('The ctacte documento cartera has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The ctacte documento cartera could not be saved. Please, try again.'));
            }
        }
        $clientes = $this->CtacteDocumentoCarteras->Clientes->find('list', ['limit' => 200]);
        $this->set(compact('ctacteDocumentoCartera', 'clientes'));
        $this->set('_serialize', ['ctacteDocumentoCartera']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Ctacte Documento Cartera id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $ctacteDocumentoCartera = $this->CtacteDocumentoCarteras->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ctacteDocumentoCartera = $this->CtacteDocumentoCarteras->patchEntity($ctacteDocumentoCartera, $this->request->data);
            if ($this->CtacteDocumentoCarteras->save($ctacteDocumentoCartera)) {
                $this->Flash->success(__('The ctacte documento cartera has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The ctacte documento cartera could not be saved. Please, try again.'));
            }
        }
        $clientes = $this->CtacteDocumentoCarteras->Clientes->find('list', ['limit' => 200]);
        $this->set(compact('ctacteDocumentoCartera', 'clientes'));
        $this->set('_serialize', ['ctacteDocumentoCartera']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Ctacte Documento Cartera id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ctacteDocumentoCartera = $this->CtacteDocumentoCarteras->get($id);
        if ($this->CtacteDocumentoCarteras->delete($ctacteDocumentoCartera)) {
            $this->Flash->success(__('The ctacte documento cartera has been deleted.'));
        } else {
            $this->Flash->error(__('The ctacte documento cartera could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
