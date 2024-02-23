<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * AlfabetaMultidrogas Controller
 *
 * @property \App\Model\Table\AlfabetaMultidrogasTable $AlfabetaMultidrogas
 *
 * @method \App\Model\Entity\AlfabetaMultidroga[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AlfabetaMultidrogasController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['AlfabetaArticulos', 'Articulos', 'AlfabetaNuevaDrogas', 'AlfabetaUnidadPotencias']
        ];
        $alfabetaMultidrogas = $this->paginate($this->AlfabetaMultidrogas);

        $this->set(compact('alfabetaMultidrogas'));
    }

    /**
     * View method
     *
     * @param string|null $id Alfabeta Multidroga id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $alfabetaMultidroga = $this->AlfabetaMultidrogas->get($id, [
            'contain' => ['AlfabetaArticulos', 'Articulos', 'AlfabetaNuevaDrogas', 'AlfabetaUnidadPotencias']
        ]);

        $this->set('alfabetaMultidroga', $alfabetaMultidroga);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $alfabetaMultidroga = $this->AlfabetaMultidrogas->newEntity();
        if ($this->request->is('post')) {
            $alfabetaMultidroga = $this->AlfabetaMultidrogas->patchEntity($alfabetaMultidroga, $this->request->getData());
            if ($this->AlfabetaMultidrogas->save($alfabetaMultidroga)) {
                $this->Flash->success(__('The alfabeta multidroga has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The alfabeta multidroga could not be saved. Please, try again.'));
        }
        $alfabetaArticulos = $this->AlfabetaMultidrogas->AlfabetaArticulos->find('list', ['limit' => 200]);
        $articulos = $this->AlfabetaMultidrogas->Articulos->find('list', ['limit' => 200]);
        $alfabetaNuevaDrogas = $this->AlfabetaMultidrogas->AlfabetaNuevaDrogas->find('list', ['limit' => 200]);
        $alfabetaUnidadPotencias = $this->AlfabetaMultidrogas->AlfabetaUnidadPotencias->find('list', ['limit' => 200]);
        $this->set(compact('alfabetaMultidroga', 'alfabetaArticulos', 'articulos', 'alfabetaNuevaDrogas', 'alfabetaUnidadPotencias'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Alfabeta Multidroga id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $alfabetaMultidroga = $this->AlfabetaMultidrogas->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $alfabetaMultidroga = $this->AlfabetaMultidrogas->patchEntity($alfabetaMultidroga, $this->request->getData());
            if ($this->AlfabetaMultidrogas->save($alfabetaMultidroga)) {
                $this->Flash->success(__('The alfabeta multidroga has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The alfabeta multidroga could not be saved. Please, try again.'));
        }
        $alfabetaArticulos = $this->AlfabetaMultidrogas->AlfabetaArticulos->find('list', ['limit' => 200]);
        $articulos = $this->AlfabetaMultidrogas->Articulos->find('list', ['limit' => 200]);
        $alfabetaNuevaDrogas = $this->AlfabetaMultidrogas->AlfabetaNuevaDrogas->find('list', ['limit' => 200]);
        $alfabetaUnidadPotencias = $this->AlfabetaMultidrogas->AlfabetaUnidadPotencias->find('list', ['limit' => 200]);
        $this->set(compact('alfabetaMultidroga', 'alfabetaArticulos', 'articulos', 'alfabetaNuevaDrogas', 'alfabetaUnidadPotencias'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Alfabeta Multidroga id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $alfabetaMultidroga = $this->AlfabetaMultidrogas->get($id);
        if ($this->AlfabetaMultidrogas->delete($alfabetaMultidroga)) {
            $this->Flash->success(__('The alfabeta multidroga has been deleted.'));
        } else {
            $this->Flash->error(__('The alfabeta multidroga could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
