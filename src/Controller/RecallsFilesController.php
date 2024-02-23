<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * RecallsFiles Controller
 *
 * @property \App\Model\Table\RecallsFilesTable $RecallsFiles
 *
 * @method \App\Model\Entity\RecallsFile[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RecallsFilesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Recalls']
        ];
        $recallsFiles = $this->paginate($this->RecallsFiles);

        $this->set(compact('recallsFiles'));
    }

    /**
     * View method
     *
     * @param string|null $id Recalls File id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $recallsFile = $this->RecallsFiles->get($id, [
            'contain' => ['Recalls']
        ]);

        $this->set('recallsFile', $recallsFile);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $recallsFile = $this->RecallsFiles->newEntity();
        if ($this->request->is('post')) {
            $recallsFile = $this->RecallsFiles->patchEntity($recallsFile, $this->request->getData());
            if ($this->RecallsFiles->save($recallsFile)) {
                $this->Flash->success(__('The recalls file has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The recalls file could not be saved. Please, try again.'));
        }
        $recalls = $this->RecallsFiles->Recalls->find('list', ['limit' => 200]);
        $this->set(compact('recallsFile', 'recalls'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Recalls File id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $recallsFile = $this->RecallsFiles->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $recallsFile = $this->RecallsFiles->patchEntity($recallsFile, $this->request->getData());
            if ($this->RecallsFiles->save($recallsFile)) {
                $this->Flash->success(__('The recalls file has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The recalls file could not be saved. Please, try again.'));
        }
        $recalls = $this->RecallsFiles->Recalls->find('list', ['limit' => 200]);
        $this->set(compact('recallsFile', 'recalls'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Recalls File id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $recallsFile = $this->RecallsFiles->get($id);
        if ($this->RecallsFiles->delete($recallsFile)) {
            $this->Flash->success(__('The recalls file has been deleted.'));
        } else {
            $this->Flash->error(__('The recalls file could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
