<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ObraSociales Controller
 *
 * @property \App\Model\Table\ObraSocialesTable $ObraSociales
 */
class ObraSocialesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('obraSociales', $this->paginate($this->ObraSociales));
        $this->set('_serialize', ['obraSociales']);
    }

    /**
     * View method
     *
     * @param string|null $id Obra Sociale id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $obraSociale = $this->ObraSociales->get($id, [
            'contain' => []
        ]);
        $this->set('obraSociale', $obraSociale);
        $this->set('_serialize', ['obraSociale']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $obraSociale = $this->ObraSociales->newEntity();
        if ($this->request->is('post')) {
            $obraSociale = $this->ObraSociales->patchEntity($obraSociale, $this->request->data);
            if ($this->ObraSociales->save($obraSociale)) {
                $this->Flash->success(__('The obra sociale has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The obra sociale could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('obraSociale'));
        $this->set('_serialize', ['obraSociale']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Obra Sociale id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $obraSociale = $this->ObraSociales->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $obraSociale = $this->ObraSociales->patchEntity($obraSociale, $this->request->data);
            if ($this->ObraSociales->save($obraSociale)) {
                $this->Flash->success(__('The obra sociale has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The obra sociale could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('obraSociale'));
        $this->set('_serialize', ['obraSociale']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Obra Sociale id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $obraSociale = $this->ObraSociales->get($id);
        if ($this->ObraSociales->delete($obraSociale)) {
            $this->Flash->success(__('The obra sociale has been deleted.'));
        } else {
            $this->Flash->error(__('The obra sociale could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
