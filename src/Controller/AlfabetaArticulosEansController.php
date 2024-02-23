<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * AlfabetaArticulosEans Controller
 *
 * @property \App\Model\Table\AlfabetaArticulosEansTable $AlfabetaArticulosEans
 *
 * @method \App\Model\Entity\AlfabetaArticulosEan[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AlfabetaArticulosEansController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['AlfabetaArticulos']
        ];
        $alfabetaArticulosEans = $this->paginate($this->AlfabetaArticulosEans);

        $this->set(compact('alfabetaArticulosEans'));
    }

    /**
     * View method
     *
     * @param string|null $id Alfabeta Articulos Ean id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $alfabetaArticulosEan = $this->AlfabetaArticulosEans->get($id, [
            'contain' => ['AlfabetaArticulos']
        ]);

        $this->set('alfabetaArticulosEan', $alfabetaArticulosEan);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $alfabetaArticulosEan = $this->AlfabetaArticulosEans->newEntity();
        if ($this->request->is('post')) {
            $alfabetaArticulosEan = $this->AlfabetaArticulosEans->patchEntity($alfabetaArticulosEan, $this->request->getData());
            if ($this->AlfabetaArticulosEans->save($alfabetaArticulosEan)) {
                $this->Flash->success(__('The alfabeta articulos ean has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The alfabeta articulos ean could not be saved. Please, try again.'));
        }
        $alfabetaArticulos = $this->AlfabetaArticulosEans->AlfabetaArticulos->find('list', ['limit' => 200]);
        $this->set(compact('alfabetaArticulosEan', 'alfabetaArticulos'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Alfabeta Articulos Ean id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $alfabetaArticulosEan = $this->AlfabetaArticulosEans->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $alfabetaArticulosEan = $this->AlfabetaArticulosEans->patchEntity($alfabetaArticulosEan, $this->request->getData());
            if ($this->AlfabetaArticulosEans->save($alfabetaArticulosEan)) {
                $this->Flash->success(__('The alfabeta articulos ean has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The alfabeta articulos ean could not be saved. Please, try again.'));
        }
        $alfabetaArticulos = $this->AlfabetaArticulosEans->AlfabetaArticulos->find('list', ['limit' => 200]);
        $this->set(compact('alfabetaArticulosEan', 'alfabetaArticulos'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Alfabeta Articulos Ean id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $alfabetaArticulosEan = $this->AlfabetaArticulosEans->get($id);
        if ($this->AlfabetaArticulosEans->delete($alfabetaArticulosEan)) {
            $this->Flash->success(__('The alfabeta articulos ean has been deleted.'));
        } else {
            $this->Flash->error(__('The alfabeta articulos ean could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
