<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Recalls Controller
 *
 * @property \App\Model\Table\RecallsTable $Recalls
 *
 * @method \App\Model\Entity\Recall[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RecallsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $recalls = $this->paginate($this->Recalls);

        $this->set(compact('recalls'));
    }

    /**
     * View method
     *
     * @param string|null $id Recall id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $recall = $this->Recalls->get($id, [
            'contain' => ['Files']
        ]);

        $this->set('recall', $recall);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $recall = $this->Recalls->newEntity();
        if ($this->request->is('post')) {
            $recall = $this->Recalls->patchEntity($recall, $this->request->getData());
            if ($this->Recalls->save($recall)) {
                $this->Flash->success(__('The recall has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The recall could not be saved. Please, try again.'));
        }
        $files = $this->Recalls->Files->find('list', ['limit' => 200]);
        $this->set(compact('recall', 'files'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Recall id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $recall = $this->Recalls->get($id, [
            'contain' => ['Files']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $recall = $this->Recalls->patchEntity($recall, $this->request->getData());
            if ($this->Recalls->save($recall)) {
                $this->Flash->success(__('The recall has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The recall could not be saved. Please, try again.'));
        }
        $files = $this->Recalls->Files->find('list', ['limit' => 200]);
        $this->set(compact('recall', 'files'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Recall id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $recall = $this->Recalls->get($id);
        if ($this->Recalls->delete($recall)) {
            $this->Flash->success(__('The recall has been deleted.'));
        } else {
            $this->Flash->error(__('The recall could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
