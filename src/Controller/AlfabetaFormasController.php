<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * AlfabetaFormas Controller
 *
 * @property \App\Model\Table\AlfabetaFormasTable $AlfabetaFormas
 *
 * @method \App\Model\Entity\AlfabetaForma[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AlfabetaFormasController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $alfabetaFormas = $this->paginate($this->AlfabetaFormas);

        $this->set(compact('alfabetaFormas'));
    }

    /**
     * View method
     *
     * @param string|null $id Alfabeta Forma id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $alfabetaForma = $this->AlfabetaFormas->get($id, [
            'contain' => ['AlfabetaArticulosExtras']
        ]);

        $this->set('alfabetaForma', $alfabetaForma);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $alfabetaForma = $this->AlfabetaFormas->newEntity();
        if ($this->request->is('post')) {
            $alfabetaForma = $this->AlfabetaFormas->patchEntity($alfabetaForma, $this->request->getData());
            if ($this->AlfabetaFormas->save($alfabetaForma)) {
                $this->Flash->success(__('The alfabeta forma has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The alfabeta forma could not be saved. Please, try again.'));
        }
        $this->set(compact('alfabetaForma'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Alfabeta Forma id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $alfabetaForma = $this->AlfabetaFormas->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $alfabetaForma = $this->AlfabetaFormas->patchEntity($alfabetaForma, $this->request->getData());
            if ($this->AlfabetaFormas->save($alfabetaForma)) {
                $this->Flash->success(__('The alfabeta forma has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The alfabeta forma could not be saved. Please, try again.'));
        }
        $this->set(compact('alfabetaForma'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Alfabeta Forma id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $alfabetaForma = $this->AlfabetaFormas->get($id);
        if ($this->AlfabetaFormas->delete($alfabetaForma)) {
            $this->Flash->success(__('The alfabeta forma has been deleted.'));
        } else {
            $this->Flash->error(__('The alfabeta forma could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
