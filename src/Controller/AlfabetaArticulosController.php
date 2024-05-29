<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * AlfabetaArticulos Controller
 *
 * @property \App\Model\Table\AlfabetaArticulosTable $AlfabetaArticulos
 *
 * @method \App\Model\Entity\AlfabetaArticulo[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AlfabetaArticulosController extends AppController
{



    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['AlfabetaLaboratorios', 'AlfabetaCategorias', 'AlfabetaTipoVentas', 'Articulos']
        ];
        $alfabetaArticulos = $this->paginate($this->AlfabetaArticulos);

        $this->set(compact('alfabetaArticulos'));
    }

    /**
     * View method
     *
     * @param string|null $id Alfabeta Articulo id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $alfabetaArticulo = $this->AlfabetaArticulos->get($id, [
            'contain' => ['AlfabetaLaboratorios', 'AlfabetaCategorias', 'AlfabetaTipoVentas', 'Articulos', 'AlfabetaArticulosEans', 'AlfabetaArticulosExtras', 'AlfabetaMultidrogas']
        ]);

        $this->set('alfabetaArticulo', $alfabetaArticulo);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $alfabetaArticulo = $this->AlfabetaArticulos->newEntity();
        if ($this->request->is('post')) {
            $alfabetaArticulo = $this->AlfabetaArticulos->patchEntity($alfabetaArticulo, $this->request->getData());
            if ($this->AlfabetaArticulos->save($alfabetaArticulo)) {
                $this->Flash->success(__('The alfabeta articulo has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The alfabeta articulo could not be saved. Please, try again.'));
        }
        $alfabetaLaboratorios = $this->AlfabetaArticulos->AlfabetaLaboratorios->find('list', ['limit' => 200]);
        $alfabetaCategorias = $this->AlfabetaArticulos->AlfabetaCategorias->find('list', ['limit' => 200]);
        $alfabetaTipoVentas = $this->AlfabetaArticulos->AlfabetaTipoVentas->find('list', ['limit' => 200]);
        $articulos = $this->AlfabetaArticulos->Articulos->find('list', ['limit' => 200]);
        $this->set(compact('alfabetaArticulo', 'alfabetaLaboratorios', 'alfabetaCategorias', 'alfabetaTipoVentas', 'articulos'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Alfabeta Articulo id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $alfabetaArticulo = $this->AlfabetaArticulos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $alfabetaArticulo = $this->AlfabetaArticulos->patchEntity($alfabetaArticulo, $this->request->getData());
            if ($this->AlfabetaArticulos->save($alfabetaArticulo)) {
                $this->Flash->success(__('The alfabeta articulo has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The alfabeta articulo could not be saved. Please, try again.'));
        }
        $alfabetaLaboratorios = $this->AlfabetaArticulos->AlfabetaLaboratorios->find('list', ['limit' => 200]);
        $alfabetaCategorias = $this->AlfabetaArticulos->AlfabetaCategorias->find('list', ['limit' => 200]);
        $alfabetaTipoVentas = $this->AlfabetaArticulos->AlfabetaTipoVentas->find('list', ['limit' => 200]);
        $articulos = $this->AlfabetaArticulos->Articulos->find('list', ['limit' => 200]);
        $this->set(compact('alfabetaArticulo', 'alfabetaLaboratorios', 'alfabetaCategorias', 'alfabetaTipoVentas', 'articulos'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Alfabeta Articulo id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $alfabetaArticulo = $this->AlfabetaArticulos->get($id);
        if ($this->AlfabetaArticulos->delete($alfabetaArticulo)) {
            $this->Flash->success(__('The alfabeta articulo has been deleted.'));
        } else {
            $this->Flash->error(__('The alfabeta articulo could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
