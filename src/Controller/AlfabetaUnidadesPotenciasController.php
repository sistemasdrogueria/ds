<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * AlfabetaUnidadesPotencias Controller
 *
 * @property \App\Model\Table\AlfabetaUnidadesPotenciasTable $AlfabetaUnidadesPotencias
 *
 * @method \App\Model\Entity\AlfabetaUnidadesPotencia[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AlfabetaUnidadesPotenciasController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $alfabetaUnidadesPotencias = $this->paginate($this->AlfabetaUnidadesPotencias);

        $this->set(compact('alfabetaUnidadesPotencias'));
    }

    /**
     * View method
     *
     * @param string|null $id Alfabeta Unidades Potencia id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $alfabetaUnidadesPotencia = $this->AlfabetaUnidadesPotencias->get($id, [
            'contain' => []
        ]);

        $this->set('alfabetaUnidadesPotencia', $alfabetaUnidadesPotencia);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $alfabetaUnidadesPotencia = $this->AlfabetaUnidadesPotencias->newEntity();
        if ($this->request->is('post')) {
            $alfabetaUnidadesPotencia = $this->AlfabetaUnidadesPotencias->patchEntity($alfabetaUnidadesPotencia, $this->request->getData());
            if ($this->AlfabetaUnidadesPotencias->save($alfabetaUnidadesPotencia)) {
                $this->Flash->success(__('The alfabeta unidades potencia has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The alfabeta unidades potencia could not be saved. Please, try again.'));
        }
        $this->set(compact('alfabetaUnidadesPotencia'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Alfabeta Unidades Potencia id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $alfabetaUnidadesPotencia = $this->AlfabetaUnidadesPotencias->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $alfabetaUnidadesPotencia = $this->AlfabetaUnidadesPotencias->patchEntity($alfabetaUnidadesPotencia, $this->request->getData());
            if ($this->AlfabetaUnidadesPotencias->save($alfabetaUnidadesPotencia)) {
                $this->Flash->success(__('The alfabeta unidades potencia has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The alfabeta unidades potencia could not be saved. Please, try again.'));
        }
        $this->set(compact('alfabetaUnidadesPotencia'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Alfabeta Unidades Potencia id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $alfabetaUnidadesPotencia = $this->AlfabetaUnidadesPotencias->get($id);
        if ($this->AlfabetaUnidadesPotencias->delete($alfabetaUnidadesPotencia)) {
            $this->Flash->success(__('The alfabeta unidades potencia has been deleted.'));
        } else {
            $this->Flash->error(__('The alfabeta unidades potencia could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
