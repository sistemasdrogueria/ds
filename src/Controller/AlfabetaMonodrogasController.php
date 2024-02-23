<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * AlfabetaMonodrogas Controller
 *
 * @property \App\Model\Table\AlfabetaMonodrogasTable $AlfabetaMonodrogas
 *
 * @method \App\Model\Entity\AlfabetaMonodroga[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AlfabetaMonodrogasController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $alfabetaMonodrogas = $this->paginate($this->AlfabetaMonodrogas);

        $this->set(compact('alfabetaMonodrogas'));
    }

    /**
     * View method
     *
     * @param string|null $id Alfabeta Monodroga id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $alfabetaMonodroga = $this->AlfabetaMonodrogas->get($id, [
            'contain' => ['AlfabetaArticulosExtras']
        ]);

        $this->set('alfabetaMonodroga', $alfabetaMonodroga);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $alfabetaMonodroga = $this->AlfabetaMonodrogas->newEntity();
        if ($this->request->is('post')) {
            $alfabetaMonodroga = $this->AlfabetaMonodrogas->patchEntity($alfabetaMonodroga, $this->request->getData());
            if ($this->AlfabetaMonodrogas->save($alfabetaMonodroga)) {
                $this->Flash->success(__('The alfabeta monodroga has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The alfabeta monodroga could not be saved. Please, try again.'));
        }
        $this->set(compact('alfabetaMonodroga'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Alfabeta Monodroga id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $alfabetaMonodroga = $this->AlfabetaMonodrogas->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $alfabetaMonodroga = $this->AlfabetaMonodrogas->patchEntity($alfabetaMonodroga, $this->request->getData());
            if ($this->AlfabetaMonodrogas->save($alfabetaMonodroga)) {
                $this->Flash->success(__('The alfabeta monodroga has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The alfabeta monodroga could not be saved. Please, try again.'));
        }
        $this->set(compact('alfabetaMonodroga'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Alfabeta Monodroga id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $alfabetaMonodroga = $this->AlfabetaMonodrogas->get($id);
        if ($this->AlfabetaMonodrogas->delete($alfabetaMonodroga)) {
            $this->Flash->success(__('The alfabeta monodroga has been deleted.'));
        } else {
            $this->Flash->error(__('The alfabeta monodroga could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
