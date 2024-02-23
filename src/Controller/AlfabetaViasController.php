<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * AlfabetaVias Controller
 *
 * @property \App\Model\Table\AlfabetaViasTable $AlfabetaVias
 *
 * @method \App\Model\Entity\AlfabetaVia[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AlfabetaViasController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $alfabetaVias = $this->paginate($this->AlfabetaVias);

        $this->set(compact('alfabetaVias'));
    }

    /**
     * View method
     *
     * @param string|null $id Alfabeta Via id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $alfabetaVia = $this->AlfabetaVias->get($id, [
            'contain' => []
        ]);

        $this->set('alfabetaVia', $alfabetaVia);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $alfabetaVia = $this->AlfabetaVias->newEntity();
        if ($this->request->is('post')) {
            $alfabetaVia = $this->AlfabetaVias->patchEntity($alfabetaVia, $this->request->getData());
            if ($this->AlfabetaVias->save($alfabetaVia)) {
                $this->Flash->success(__('The alfabeta via has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The alfabeta via could not be saved. Please, try again.'));
        }
        $this->set(compact('alfabetaVia'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Alfabeta Via id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $alfabetaVia = $this->AlfabetaVias->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $alfabetaVia = $this->AlfabetaVias->patchEntity($alfabetaVia, $this->request->getData());
            if ($this->AlfabetaVias->save($alfabetaVia)) {
                $this->Flash->success(__('The alfabeta via has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The alfabeta via could not be saved. Please, try again.'));
        }
        $this->set(compact('alfabetaVia'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Alfabeta Via id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $alfabetaVia = $this->AlfabetaVias->get($id);
        if ($this->AlfabetaVias->delete($alfabetaVia)) {
            $this->Flash->success(__('The alfabeta via has been deleted.'));
        } else {
            $this->Flash->error(__('The alfabeta via could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
