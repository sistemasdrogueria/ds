<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * PermisosPerfiles Controller
 *
 * @property \App\Model\Table\PermisosPerfilesTable $PermisosPerfiles
 */
class PermisosPerfilesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Perfiles', 'Permisos']
        ];
        $this->set('permisosPerfiles', $this->paginate($this->PermisosPerfiles));
        $this->set('_serialize', ['permisosPerfiles']);
    }

    /**
     * View method
     *
     * @param string|null $id Permisos Perfile id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $permisosPerfile = $this->PermisosPerfiles->get($id, [
            'contain' => ['Perfiles', 'Permisos']
        ]);
        $this->set('permisosPerfile', $permisosPerfile);
        $this->set('_serialize', ['permisosPerfile']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $permisosPerfile = $this->PermisosPerfiles->newEntity();
        if ($this->request->is('post')) {
            $permisosPerfile = $this->PermisosPerfiles->patchEntity($permisosPerfile, $this->request->data);
            if ($this->PermisosPerfiles->save($permisosPerfile)) {
                $this->Flash->success(__('The permisos perfile has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The permisos perfile could not be saved. Please, try again.'));
            }
        }
        $perfiles = $this->PermisosPerfiles->Perfiles->find('list', ['limit' => 200]);
        $permisos = $this->PermisosPerfiles->Permisos->find('list', ['limit' => 200]);
        $this->set(compact('permisosPerfile', 'perfiles', 'permisos'));
        $this->set('_serialize', ['permisosPerfile']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Permisos Perfile id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $permisosPerfile = $this->PermisosPerfiles->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $permisosPerfile = $this->PermisosPerfiles->patchEntity($permisosPerfile, $this->request->data);
            if ($this->PermisosPerfiles->save($permisosPerfile)) {
                $this->Flash->success(__('The permisos perfile has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The permisos perfile could not be saved. Please, try again.'));
            }
        }
        $perfiles = $this->PermisosPerfiles->Perfiles->find('list', ['limit' => 200]);
        $permisos = $this->PermisosPerfiles->Permisos->find('list', ['limit' => 200]);
        $this->set(compact('permisosPerfile', 'perfiles', 'permisos'));
        $this->set('_serialize', ['permisosPerfile']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Permisos Perfile id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $permisosPerfile = $this->PermisosPerfiles->get($id);
        if ($this->PermisosPerfiles->delete($permisosPerfile)) {
            $this->Flash->success(__('The permisos perfile has been deleted.'));
        } else {
            $this->Flash->error(__('The permisos perfile could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
