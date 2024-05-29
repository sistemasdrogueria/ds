<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * AlfabetaAccionesFars Controller
 *
 * @property \App\Model\Table\AlfabetaAccionesFarsTable $AlfabetaAccionesFars
 *
 * @method \App\Model\Entity\AlfabetaAccionesFar[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AlfabetaAccionesFarsController extends AppController
{
    


    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $alfabetaAccionesFars = $this->paginate($this->AlfabetaAccionesFars);

        $this->set(compact('alfabetaAccionesFars'));
    }

    /**
     * View method
     *
     * @param string|null $id Alfabeta Acciones Far id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $alfabetaAccionesFar = $this->AlfabetaAccionesFars->get($id, [
            'contain' => []
        ]);

        $this->set('alfabetaAccionesFar', $alfabetaAccionesFar);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $alfabetaAccionesFar = $this->AlfabetaAccionesFars->newEntity();
        if ($this->request->is('post')) {
            $alfabetaAccionesFar = $this->AlfabetaAccionesFars->patchEntity($alfabetaAccionesFar, $this->request->getData());
            if ($this->AlfabetaAccionesFars->save($alfabetaAccionesFar)) {
                $this->Flash->success(__('The alfabeta acciones far has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The alfabeta acciones far could not be saved. Please, try again.'));
        }
        $this->set(compact('alfabetaAccionesFar'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Alfabeta Acciones Far id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $alfabetaAccionesFar = $this->AlfabetaAccionesFars->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $alfabetaAccionesFar = $this->AlfabetaAccionesFars->patchEntity($alfabetaAccionesFar, $this->request->getData());
            if ($this->AlfabetaAccionesFars->save($alfabetaAccionesFar)) {
                $this->Flash->success(__('The alfabeta acciones far has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The alfabeta acciones far could not be saved. Please, try again.'));
        }
        $this->set(compact('alfabetaAccionesFar'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Alfabeta Acciones Far id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $alfabetaAccionesFar = $this->AlfabetaAccionesFars->get($id);
        if ($this->AlfabetaAccionesFars->delete($alfabetaAccionesFar)) {
            $this->Flash->success(__('The alfabeta acciones far has been deleted.'));
        } else {
            $this->Flash->error(__('The alfabeta acciones far could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
