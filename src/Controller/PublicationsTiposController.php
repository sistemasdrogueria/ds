<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * PublicationsTipos Controller
 *
 * @property \App\Model\Table\PublicationsTiposTable $PublicationsTipos
 *
 * @method \App\Model\Entity\PublicationsTipo[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PublicationsTiposController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $publicationsTipos = $this->paginate($this->PublicationsTipos);

        $this->set(compact('publicationsTipos'));
    }

    /**
     * View method
     *
     * @param string|null $id Publications Tipo id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $publicationsTipo = $this->PublicationsTipos->get($id, [
            'contain' => []
        ]);

        $this->set('publicationsTipo', $publicationsTipo);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $publicationsTipo = $this->PublicationsTipos->newEntity();
        if ($this->request->is('post')) {
            $publicationsTipo = $this->PublicationsTipos->patchEntity($publicationsTipo, $this->request->getData());
            if ($this->PublicationsTipos->save($publicationsTipo)) {
                $this->Flash->success(__('The publications tipo has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The publications tipo could not be saved. Please, try again.'));
        }
        $this->set(compact('publicationsTipo'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Publications Tipo id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $publicationsTipo = $this->PublicationsTipos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $publicationsTipo = $this->PublicationsTipos->patchEntity($publicationsTipo, $this->request->getData());
            if ($this->PublicationsTipos->save($publicationsTipo)) {
                $this->Flash->success(__('The publications tipo has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The publications tipo could not be saved. Please, try again.'));
        }
        $this->set(compact('publicationsTipo'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Publications Tipo id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $publicationsTipo = $this->PublicationsTipos->get($id);
        if ($this->PublicationsTipos->delete($publicationsTipo)) {
            $this->Flash->success(__('The publications tipo has been deleted.'));
        } else {
            $this->Flash->error(__('The publications tipo could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
