<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * LogsAccesos Controller
 *
 * @property \App\Model\Table\LogsAccesosTable $LogsAccesos
 */
class LogsAccesosController extends AppController
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
        $this->set('logsAccesos', $this->paginate($this->LogsAccesos));
        $this->set('_serialize', ['logsAccesos']);
    }

    /**
     * View method
     *
     * @param string|null $id Logs Acceso id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $logsAcceso = $this->LogsAccesos->get($id, [
            'contain' => ['Clientes']
        ]);
        $this->set('logsAcceso', $logsAcceso);
        $this->set('_serialize', ['logsAcceso']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($logacceso = null)
    {
        $logsAcceso = $this->LogsAccesos->newEntity();
        //if ($this->request->is('post')) {
            $logsAcceso = $this->LogsAccesos->patchEntity($logsAcceso, $logacceso);
            if ($this->LogsAccesos->save($logsAcceso)) {
                $this->Flash->success('The logs acceso has been saved.');
               return $this->redirect($this->Auth->redirectUrl());
//			   return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The logs acceso could not be saved. Please, try again.');
            }
        //}
        //$clientes = $this->LogsAccesos->Clientes->find('list', ['limit' => 200]);
        //$this->set(compact('logsAcceso', 'clientes'));
        //$this->set('_serialize', ['logsAcceso']);
		return $this->redirect($this->Auth->redirectUrl());
    }

    /**
     * Edit method
     *
     * @param string|null $id Logs Acceso id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $logsAcceso = $this->LogsAccesos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $logsAcceso = $this->LogsAccesos->patchEntity($logsAcceso, $this->request->data);
            if ($this->LogsAccesos->save($logsAcceso)) {
                $this->Flash->success('The logs acceso has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The logs acceso could not be saved. Please, try again.');
            }
        }
        $clientes = $this->LogsAccesos->Clientes->find('list', ['limit' => 200]);
        $this->set(compact('logsAcceso', 'clientes'));
        $this->set('_serialize', ['logsAcceso']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Logs Acceso id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $logsAcceso = $this->LogsAccesos->get($id);
        if ($this->LogsAccesos->delete($logsAcceso)) {
            $this->Flash->success('The logs acceso has been deleted.');
        } else {
            $this->Flash->error('The logs acceso could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
