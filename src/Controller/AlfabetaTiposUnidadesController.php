<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * AlfabetaTiposUnidades Controller
 *
 * @property \App\Model\Table\AlfabetaTiposUnidadesTable $AlfabetaTiposUnidades
 *
 * @method \App\Model\Entity\AlfabetaTiposUnidade[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AlfabetaTiposUnidadesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $alfabetaTiposUnidades = $this->paginate($this->AlfabetaTiposUnidades);

        $this->set(compact('alfabetaTiposUnidades'));
    }

    /**
     * View method
     *
     * @param string|null $id Alfabeta Tipos Unidade id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $alfabetaTiposUnidade = $this->AlfabetaTiposUnidades->get($id, [
            'contain' => []
        ]);

        $this->set('alfabetaTiposUnidade', $alfabetaTiposUnidade);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $alfabetaTiposUnidade = $this->AlfabetaTiposUnidades->newEntity();
        if ($this->request->is('post')) {
            $alfabetaTiposUnidade = $this->AlfabetaTiposUnidades->patchEntity($alfabetaTiposUnidade, $this->request->getData());
            if ($this->AlfabetaTiposUnidades->save($alfabetaTiposUnidade)) {
                $this->Flash->success(__('The alfabeta tipos unidade has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The alfabeta tipos unidade could not be saved. Please, try again.'));
        }
        $this->set(compact('alfabetaTiposUnidade'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Alfabeta Tipos Unidade id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $alfabetaTiposUnidade = $this->AlfabetaTiposUnidades->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $alfabetaTiposUnidade = $this->AlfabetaTiposUnidades->patchEntity($alfabetaTiposUnidade, $this->request->getData());
            if ($this->AlfabetaTiposUnidades->save($alfabetaTiposUnidade)) {
                $this->Flash->success(__('The alfabeta tipos unidade has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The alfabeta tipos unidade could not be saved. Please, try again.'));
        }
        $this->set(compact('alfabetaTiposUnidade'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Alfabeta Tipos Unidade id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $alfabetaTiposUnidade = $this->AlfabetaTiposUnidades->get($id);
        if ($this->AlfabetaTiposUnidades->delete($alfabetaTiposUnidade)) {
            $this->Flash->success(__('The alfabeta tipos unidade has been deleted.'));
        } else {
            $this->Flash->error(__('The alfabeta tipos unidade could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
