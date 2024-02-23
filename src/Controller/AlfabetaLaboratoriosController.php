<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * AlfabetaLaboratorios Controller
 *
 * @property \App\Model\Table\AlfabetaLaboratoriosTable $AlfabetaLaboratorios
 *
 * @method \App\Model\Entity\AlfabetaLaboratorio[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AlfabetaLaboratoriosController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $alfabetaLaboratorios = $this->paginate($this->AlfabetaLaboratorios);

        $this->set(compact('alfabetaLaboratorios'));
    }

    /**
     * View method
     *
     * @param string|null $id Alfabeta Laboratorio id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $alfabetaLaboratorio = $this->AlfabetaLaboratorios->get($id, [
            'contain' => ['AlfabetaArticulos']
        ]);

        $this->set('alfabetaLaboratorio', $alfabetaLaboratorio);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $alfabetaLaboratorio = $this->AlfabetaLaboratorios->newEntity();
        if ($this->request->is('post')) {
            $alfabetaLaboratorio = $this->AlfabetaLaboratorios->patchEntity($alfabetaLaboratorio, $this->request->getData());
            if ($this->AlfabetaLaboratorios->save($alfabetaLaboratorio)) {
                $this->Flash->success(__('The alfabeta laboratorio has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The alfabeta laboratorio could not be saved. Please, try again.'));
        }
        $this->set(compact('alfabetaLaboratorio'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Alfabeta Laboratorio id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $alfabetaLaboratorio = $this->AlfabetaLaboratorios->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $alfabetaLaboratorio = $this->AlfabetaLaboratorios->patchEntity($alfabetaLaboratorio, $this->request->getData());
            if ($this->AlfabetaLaboratorios->save($alfabetaLaboratorio)) {
                $this->Flash->success(__('The alfabeta laboratorio has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The alfabeta laboratorio could not be saved. Please, try again.'));
        }
        $this->set(compact('alfabetaLaboratorio'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Alfabeta Laboratorio id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $alfabetaLaboratorio = $this->AlfabetaLaboratorios->get($id);
        if ($this->AlfabetaLaboratorios->delete($alfabetaLaboratorio)) {
            $this->Flash->success(__('The alfabeta laboratorio has been deleted.'));
        } else {
            $this->Flash->error(__('The alfabeta laboratorio could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
