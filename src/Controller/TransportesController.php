<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Transportes Controller
 *
 * @property \App\Model\Table\TransportesTable $Transportes
 *
 * @method \App\Model\Entity\Transporte[] paginate($object = null, array $settings = [])
 */
class TransportesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $transportes = $this->paginate($this->Transportes);

        $this->set(compact('transportes'));
        $this->set('_serialize', ['transportes']);
    }

    /**
     * View method
     *
     * @param string|null $id Transporte id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $transporte = $this->Transportes->get($id, [
            'contain' => []
        ]);

        $this->set('transporte', $transporte);
        $this->set('_serialize', ['transporte']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $transporte = $this->Transportes->newEntity();
        if ($this->request->is('post')) {
            $transporte = $this->Transportes->patchEntity($transporte, $this->request->getData());
            if ($this->Transportes->save($transporte)) {
                $this->Flash->success(__('The transporte has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The transporte could not be saved. Please, try again.'));
        }
        $this->set(compact('transporte'));
        $this->set('_serialize', ['transporte']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Transporte id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $transporte = $this->Transportes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $transporte = $this->Transportes->patchEntity($transporte, $this->request->getData());
            if ($this->Transportes->save($transporte)) {
                $this->Flash->success(__('The transporte has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The transporte could not be saved. Please, try again.'));
        }
        $this->set(compact('transporte'));
        $this->set('_serialize', ['transporte']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Transporte id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $transporte = $this->Transportes->get($id);
        if ($this->Transportes->delete($transporte)) {
            $this->Flash->success(__('The transporte has been deleted.'));
        } else {
            $this->Flash->error(__('The transporte could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
