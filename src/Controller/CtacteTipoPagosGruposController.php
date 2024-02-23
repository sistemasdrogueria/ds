<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CtacteTipoPagosGrupos Controller
 *
 * @property \App\Model\Table\CtacteTipoPagosGruposTable $CtacteTipoPagosGrupos
 */
class CtacteTipoPagosGruposController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('ctacteTipoPagosGrupos', $this->paginate($this->CtacteTipoPagosGrupos));
        $this->set('_serialize', ['ctacteTipoPagosGrupos']);
    }

    /**
     * View method
     *
     * @param string|null $id Ctacte Tipo Pagos Grupo id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $ctacteTipoPagosGrupo = $this->CtacteTipoPagosGrupos->get($id, [
            'contain' => []
        ]);
        $this->set('ctacteTipoPagosGrupo', $ctacteTipoPagosGrupo);
        $this->set('_serialize', ['ctacteTipoPagosGrupo']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $ctacteTipoPagosGrupo = $this->CtacteTipoPagosGrupos->newEntity();
        if ($this->request->is('post')) {
            $ctacteTipoPagosGrupo = $this->CtacteTipoPagosGrupos->patchEntity($ctacteTipoPagosGrupo, $this->request->data);
            if ($this->CtacteTipoPagosGrupos->save($ctacteTipoPagosGrupo)) {
                $this->Flash->success(__('The ctacte tipo pagos grupo has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The ctacte tipo pagos grupo could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('ctacteTipoPagosGrupo'));
        $this->set('_serialize', ['ctacteTipoPagosGrupo']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Ctacte Tipo Pagos Grupo id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $ctacteTipoPagosGrupo = $this->CtacteTipoPagosGrupos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ctacteTipoPagosGrupo = $this->CtacteTipoPagosGrupos->patchEntity($ctacteTipoPagosGrupo, $this->request->data);
            if ($this->CtacteTipoPagosGrupos->save($ctacteTipoPagosGrupo)) {
                $this->Flash->success(__('The ctacte tipo pagos grupo has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The ctacte tipo pagos grupo could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('ctacteTipoPagosGrupo'));
        $this->set('_serialize', ['ctacteTipoPagosGrupo']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Ctacte Tipo Pagos Grupo id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ctacteTipoPagosGrupo = $this->CtacteTipoPagosGrupos->get($id);
        if ($this->CtacteTipoPagosGrupos->delete($ctacteTipoPagosGrupo)) {
            $this->Flash->success(__('The ctacte tipo pagos grupo has been deleted.'));
        } else {
            $this->Flash->error(__('The ctacte tipo pagos grupo could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
