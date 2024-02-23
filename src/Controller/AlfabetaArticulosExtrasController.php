<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * AlfabetaArticulosExtras Controller
 *
 * @property \App\Model\Table\AlfabetaArticulosExtrasTable $AlfabetaArticulosExtras
 *
 * @method \App\Model\Entity\AlfabetaArticulosExtra[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AlfabetaArticulosExtrasController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['AlfabetaArticulos', 'Articulos', 'AlfabetaTamanos', 'AlfabetaAccionFars', 'AlfabetaMonodrogas', 'AlfabetaFormas', 'AlfabetaUnidadPotencias', 'AlfabetaTipoUnidads']
        ];
        $alfabetaArticulosExtras = $this->paginate($this->AlfabetaArticulosExtras);

        $this->set(compact('alfabetaArticulosExtras'));
    }

    /**
     * View method
     *
     * @param string|null $id Alfabeta Articulos Extra id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $alfabetaArticulosExtra = $this->AlfabetaArticulosExtras->get($id, [
            'contain' => ['AlfabetaArticulos', 'Articulos', 'AlfabetaTamanos', 'AlfabetaAccionFars', 'AlfabetaMonodrogas', 'AlfabetaFormas', 'AlfabetaUnidadPotencias', 'AlfabetaTipoUnidads']
        ]);

        $this->set('alfabetaArticulosExtra', $alfabetaArticulosExtra);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $alfabetaArticulosExtra = $this->AlfabetaArticulosExtras->newEntity();
        if ($this->request->is('post')) {
            $alfabetaArticulosExtra = $this->AlfabetaArticulosExtras->patchEntity($alfabetaArticulosExtra, $this->request->getData());
            if ($this->AlfabetaArticulosExtras->save($alfabetaArticulosExtra)) {
                $this->Flash->success(__('The alfabeta articulos extra has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The alfabeta articulos extra could not be saved. Please, try again.'));
        }
        $alfabetaArticulos = $this->AlfabetaArticulosExtras->AlfabetaArticulos->find('list', ['limit' => 200]);
        $articulos = $this->AlfabetaArticulosExtras->Articulos->find('list', ['limit' => 200]);
        $alfabetaTamanos = $this->AlfabetaArticulosExtras->AlfabetaTamanos->find('list', ['limit' => 200]);
        $alfabetaAccionFars = $this->AlfabetaArticulosExtras->AlfabetaAccionFars->find('list', ['limit' => 200]);
        $alfabetaMonodrogas = $this->AlfabetaArticulosExtras->AlfabetaMonodrogas->find('list', ['limit' => 200]);
        $alfabetaFormas = $this->AlfabetaArticulosExtras->AlfabetaFormas->find('list', ['limit' => 200]);
        $alfabetaUnidadPotencias = $this->AlfabetaArticulosExtras->AlfabetaUnidadPotencias->find('list', ['limit' => 200]);
        $alfabetaTipoUnidads = $this->AlfabetaArticulosExtras->AlfabetaTipoUnidads->find('list', ['limit' => 200]);
        $this->set(compact('alfabetaArticulosExtra', 'alfabetaArticulos', 'articulos', 'alfabetaTamanos', 'alfabetaAccionFars', 'alfabetaMonodrogas', 'alfabetaFormas', 'alfabetaUnidadPotencias', 'alfabetaTipoUnidads'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Alfabeta Articulos Extra id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $alfabetaArticulosExtra = $this->AlfabetaArticulosExtras->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $alfabetaArticulosExtra = $this->AlfabetaArticulosExtras->patchEntity($alfabetaArticulosExtra, $this->request->getData());
            if ($this->AlfabetaArticulosExtras->save($alfabetaArticulosExtra)) {
                $this->Flash->success(__('The alfabeta articulos extra has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The alfabeta articulos extra could not be saved. Please, try again.'));
        }
        $alfabetaArticulos = $this->AlfabetaArticulosExtras->AlfabetaArticulos->find('list', ['limit' => 200]);
        $articulos = $this->AlfabetaArticulosExtras->Articulos->find('list', ['limit' => 200]);
        $alfabetaTamanos = $this->AlfabetaArticulosExtras->AlfabetaTamanos->find('list', ['limit' => 200]);
        $alfabetaAccionFars = $this->AlfabetaArticulosExtras->AlfabetaAccionFars->find('list', ['limit' => 200]);
        $alfabetaMonodrogas = $this->AlfabetaArticulosExtras->AlfabetaMonodrogas->find('list', ['limit' => 200]);
        $alfabetaFormas = $this->AlfabetaArticulosExtras->AlfabetaFormas->find('list', ['limit' => 200]);
        $alfabetaUnidadPotencias = $this->AlfabetaArticulosExtras->AlfabetaUnidadPotencias->find('list', ['limit' => 200]);
        $alfabetaTipoUnidads = $this->AlfabetaArticulosExtras->AlfabetaTipoUnidads->find('list', ['limit' => 200]);
        $this->set(compact('alfabetaArticulosExtra', 'alfabetaArticulos', 'articulos', 'alfabetaTamanos', 'alfabetaAccionFars', 'alfabetaMonodrogas', 'alfabetaFormas', 'alfabetaUnidadPotencias', 'alfabetaTipoUnidads'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Alfabeta Articulos Extra id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $alfabetaArticulosExtra = $this->AlfabetaArticulosExtras->get($id);
        if ($this->AlfabetaArticulosExtras->delete($alfabetaArticulosExtra)) {
            $this->Flash->success(__('The alfabeta articulos extra has been deleted.'));
        } else {
            $this->Flash->error(__('The alfabeta articulos extra could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
