<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * IncorporationsTipos Controller
 *
 * @property \App\Model\Table\IncorporationsTiposTable $IncorporationsTipos
 *
 * @method \App\Model\Entity\IncorporationsTipo[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class IncorporationsTiposController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $incorporationsTipos = $this->paginate($this->IncorporationsTipos);

        $this->set(compact('incorporationsTipos'));
    }

    /**
     * View method
     *
     * @param string|null $id Incorporations Tipo id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $incorporationsTipo = $this->IncorporationsTipos->get($id, [
            'contain' => []
        ]);

        $this->set('incorporationsTipo', $incorporationsTipo);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $incorporationsTipo = $this->IncorporationsTipos->newEntity();
        if ($this->request->is('post')) {
            $incorporationsTipo = $this->IncorporationsTipos->patchEntity($incorporationsTipo, $this->request->getData());
            if ($this->IncorporationsTipos->save($incorporationsTipo)) {
                $this->Flash->success(__('The incorporations tipo has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The incorporations tipo could not be saved. Please, try again.'));
        }
        $this->set(compact('incorporationsTipo'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Incorporations Tipo id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $incorporationsTipo = $this->IncorporationsTipos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $incorporationsTipo = $this->IncorporationsTipos->patchEntity($incorporationsTipo, $this->request->getData());
            if ($this->IncorporationsTipos->save($incorporationsTipo)) {
                $this->Flash->success(__('The incorporations tipo has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The incorporations tipo could not be saved. Please, try again.'));
        }
        $this->set(compact('incorporationsTipo'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Incorporations Tipo id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $incorporationsTipo = $this->IncorporationsTipos->get($id);
        if ($this->IncorporationsTipos->delete($incorporationsTipo)) {
            $this->Flash->success(__('The incorporations tipo has been deleted.'));
        } else {
            $this->Flash->error(__('The incorporations tipo could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
