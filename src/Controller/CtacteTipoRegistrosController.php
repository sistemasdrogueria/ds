<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CtacteTipoRegistros Controller
 *
 * @property \App\Model\Table\CtacteTipoRegistrosTable $CtacteTipoRegistros
 */
class CtacteTipoRegistrosController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('ctacteTipoRegistros', $this->paginate($this->CtacteTipoRegistros));
        $this->set('_serialize', ['ctacteTipoRegistros']);
    }

    /**
     * View method
     *
     * @param string|null $id Ctacte Tipo Registro id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $ctacteTipoRegistro = $this->CtacteTipoRegistros->get($id, [
            'contain' => []
        ]);
        $this->set('ctacteTipoRegistro', $ctacteTipoRegistro);
        $this->set('_serialize', ['ctacteTipoRegistro']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $ctacteTipoRegistro = $this->CtacteTipoRegistros->newEntity();
        if ($this->request->is('post')) {
            $ctacteTipoRegistro = $this->CtacteTipoRegistros->patchEntity($ctacteTipoRegistro, $this->request->data);
            if ($this->CtacteTipoRegistros->save($ctacteTipoRegistro)) {
                $this->Flash->success(__('The ctacte tipo registro has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The ctacte tipo registro could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('ctacteTipoRegistro'));
        $this->set('_serialize', ['ctacteTipoRegistro']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Ctacte Tipo Registro id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $ctacteTipoRegistro = $this->CtacteTipoRegistros->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ctacteTipoRegistro = $this->CtacteTipoRegistros->patchEntity($ctacteTipoRegistro, $this->request->data);
            if ($this->CtacteTipoRegistros->save($ctacteTipoRegistro)) {
                $this->Flash->success(__('The ctacte tipo registro has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The ctacte tipo registro could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('ctacteTipoRegistro'));
        $this->set('_serialize', ['ctacteTipoRegistro']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Ctacte Tipo Registro id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ctacteTipoRegistro = $this->CtacteTipoRegistros->get($id);
        if ($this->CtacteTipoRegistros->delete($ctacteTipoRegistro)) {
            $this->Flash->success(__('The ctacte tipo registro has been deleted.'));
        } else {
            $this->Flash->error(__('The ctacte tipo registro could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
