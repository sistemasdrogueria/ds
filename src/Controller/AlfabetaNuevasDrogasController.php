<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * AlfabetaNuevasDrogas Controller
 *
 * @property \App\Model\Table\AlfabetaNuevasDrogasTable $AlfabetaNuevasDrogas
 *
 * @method \App\Model\Entity\AlfabetaNuevasDroga[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AlfabetaNuevasDrogasController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $alfabetaNuevasDrogas = $this->paginate($this->AlfabetaNuevasDrogas);

        $this->set(compact('alfabetaNuevasDrogas'));
    }

    /**
     * View method
     *
     * @param string|null $id Alfabeta Nuevas Droga id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $alfabetaNuevasDroga = $this->AlfabetaNuevasDrogas->get($id, [
            'contain' => []
        ]);

        $this->set('alfabetaNuevasDroga', $alfabetaNuevasDroga);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $alfabetaNuevasDroga = $this->AlfabetaNuevasDrogas->newEntity();
        if ($this->request->is('post')) {
            $alfabetaNuevasDroga = $this->AlfabetaNuevasDrogas->patchEntity($alfabetaNuevasDroga, $this->request->getData());
            if ($this->AlfabetaNuevasDrogas->save($alfabetaNuevasDroga)) {
                $this->Flash->success(__('The alfabeta nuevas droga has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The alfabeta nuevas droga could not be saved. Please, try again.'));
        }
        $this->set(compact('alfabetaNuevasDroga'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Alfabeta Nuevas Droga id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $alfabetaNuevasDroga = $this->AlfabetaNuevasDrogas->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $alfabetaNuevasDroga = $this->AlfabetaNuevasDrogas->patchEntity($alfabetaNuevasDroga, $this->request->getData());
            if ($this->AlfabetaNuevasDrogas->save($alfabetaNuevasDroga)) {
                $this->Flash->success(__('The alfabeta nuevas droga has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The alfabeta nuevas droga could not be saved. Please, try again.'));
        }
        $this->set(compact('alfabetaNuevasDroga'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Alfabeta Nuevas Droga id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $alfabetaNuevasDroga = $this->AlfabetaNuevasDrogas->get($id);
        if ($this->AlfabetaNuevasDrogas->delete($alfabetaNuevasDroga)) {
            $this->Flash->success(__('The alfabeta nuevas droga has been deleted.'));
        } else {
            $this->Flash->error(__('The alfabeta nuevas droga could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
