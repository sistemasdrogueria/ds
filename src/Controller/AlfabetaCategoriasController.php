<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * AlfabetaCategorias Controller
 *
 * @property \App\Model\Table\AlfabetaCategoriasTable $AlfabetaCategorias
 *
 * @method \App\Model\Entity\AlfabetaCategoria[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AlfabetaCategoriasController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $alfabetaCategorias = $this->paginate($this->AlfabetaCategorias);

        $this->set(compact('alfabetaCategorias'));
    }

    /**
     * View method
     *
     * @param string|null $id Alfabeta Categoria id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $alfabetaCategoria = $this->AlfabetaCategorias->get($id, [
            'contain' => ['AlfabetaArticulos']
        ]);

        $this->set('alfabetaCategoria', $alfabetaCategoria);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $alfabetaCategoria = $this->AlfabetaCategorias->newEntity();
        if ($this->request->is('post')) {
            $alfabetaCategoria = $this->AlfabetaCategorias->patchEntity($alfabetaCategoria, $this->request->getData());
            if ($this->AlfabetaCategorias->save($alfabetaCategoria)) {
                $this->Flash->success(__('The alfabeta categoria has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The alfabeta categoria could not be saved. Please, try again.'));
        }
        $this->set(compact('alfabetaCategoria'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Alfabeta Categoria id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $alfabetaCategoria = $this->AlfabetaCategorias->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $alfabetaCategoria = $this->AlfabetaCategorias->patchEntity($alfabetaCategoria, $this->request->getData());
            if ($this->AlfabetaCategorias->save($alfabetaCategoria)) {
                $this->Flash->success(__('The alfabeta categoria has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The alfabeta categoria could not be saved. Please, try again.'));
        }
        $this->set(compact('alfabetaCategoria'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Alfabeta Categoria id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $alfabetaCategoria = $this->AlfabetaCategorias->get($id);
        if ($this->AlfabetaCategorias->delete($alfabetaCategoria)) {
            $this->Flash->success(__('The alfabeta categoria has been deleted.'));
        } else {
            $this->Flash->error(__('The alfabeta categoria could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
