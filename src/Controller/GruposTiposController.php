<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * GruposTipos Controller
 *
 * @property \App\Model\Table\GruposTiposTable $GruposTipos
 *
 * @method \App\Model\Entity\GruposTipo[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class GruposTiposController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $gruposTipos = $this->paginate($this->GruposTipos);

        $this->set(compact('gruposTipos'));
    }

    /**
     * View method
     *
     * @param string|null $id Grupos Tipo id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $gruposTipo = $this->GruposTipos->get($id, [
            'contain' => []
        ]);

        $this->set('gruposTipo', $gruposTipo);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $gruposTipo = $this->GruposTipos->newEntity();
        if ($this->request->is('post')) {
            $gruposTipo = $this->GruposTipos->patchEntity($gruposTipo, $this->request->getData());
            if ($this->GruposTipos->save($gruposTipo)) {
                $this->Flash->success(__('The grupos tipo has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The grupos tipo could not be saved. Please, try again.'));
        }
        $this->set(compact('gruposTipo'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Grupos Tipo id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $gruposTipo = $this->GruposTipos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $gruposTipo = $this->GruposTipos->patchEntity($gruposTipo, $this->request->getData());
            if ($this->GruposTipos->save($gruposTipo)) {
                $this->Flash->success(__('The grupos tipo has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The grupos tipo could not be saved. Please, try again.'));
        }
        $this->set(compact('gruposTipo'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Grupos Tipo id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $gruposTipo = $this->GruposTipos->get($id);
        if ($this->GruposTipos->delete($gruposTipo)) {
            $this->Flash->success(__('The grupos tipo has been deleted.'));
        } else {
            $this->Flash->error(__('The grupos tipo could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
