<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * AlfabetaTamanos Controller
 *
 * @property \App\Model\Table\AlfabetaTamanosTable $AlfabetaTamanos
 *
 * @method \App\Model\Entity\AlfabetaTamano[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AlfabetaTamanosController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $alfabetaTamanos = $this->paginate($this->AlfabetaTamanos);

        $this->set(compact('alfabetaTamanos'));
    }

    /**
     * View method
     *
     * @param string|null $id Alfabeta Tamano id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $alfabetaTamano = $this->AlfabetaTamanos->get($id, [
            'contain' => ['AlfabetaArticulosExtras']
        ]);

        $this->set('alfabetaTamano', $alfabetaTamano);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $alfabetaTamano = $this->AlfabetaTamanos->newEntity();
        if ($this->request->is('post')) {
            $alfabetaTamano = $this->AlfabetaTamanos->patchEntity($alfabetaTamano, $this->request->getData());
            if ($this->AlfabetaTamanos->save($alfabetaTamano)) {
                $this->Flash->success(__('The alfabeta tamano has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The alfabeta tamano could not be saved. Please, try again.'));
        }
        $this->set(compact('alfabetaTamano'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Alfabeta Tamano id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $alfabetaTamano = $this->AlfabetaTamanos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $alfabetaTamano = $this->AlfabetaTamanos->patchEntity($alfabetaTamano, $this->request->getData());
            if ($this->AlfabetaTamanos->save($alfabetaTamano)) {
                $this->Flash->success(__('The alfabeta tamano has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The alfabeta tamano could not be saved. Please, try again.'));
        }
        $this->set(compact('alfabetaTamano'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Alfabeta Tamano id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $alfabetaTamano = $this->AlfabetaTamanos->get($id);
        if ($this->AlfabetaTamanos->delete($alfabetaTamano)) {
            $this->Flash->success(__('The alfabeta tamano has been deleted.'));
        } else {
            $this->Flash->error(__('The alfabeta tamano could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
