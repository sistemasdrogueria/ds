<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ArticulosEans Controller
 *
 * @property \App\Model\Table\ArticulosEansTable $ArticulosEans
 */
class ArticulosEansController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Articulos']
        ];
        $this->set('articulosEans', $this->paginate($this->ArticulosEans));
        $this->set('_serialize', ['articulosEans']);
    }

    /**
     * View method
     *
     * @param string|null $id Articulos Ean id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $articulosEan = $this->ArticulosEans->get($id, [
            'contain' => ['Articulos']
        ]);
        $this->set('articulosEan', $articulosEan);
        $this->set('_serialize', ['articulosEan']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $articulosEan = $this->ArticulosEans->newEntity();
        if ($this->request->is('post')) {
            $articulosEan = $this->ArticulosEans->patchEntity($articulosEan, $this->request->data);
            if ($this->ArticulosEans->save($articulosEan)) {
                $this->Flash->success(__('The articulos ean has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The articulos ean could not be saved. Please, try again.'));
            }
        }
        $articulos = $this->ArticulosEans->Articulos->find('list', ['limit' => 200]);
        $this->set(compact('articulosEan', 'articulos'));
        $this->set('_serialize', ['articulosEan']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Articulos Ean id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $articulosEan = $this->ArticulosEans->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $articulosEan = $this->ArticulosEans->patchEntity($articulosEan, $this->request->data);
            if ($this->ArticulosEans->save($articulosEan)) {
                $this->Flash->success(__('The articulos ean has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The articulos ean could not be saved. Please, try again.'));
            }
        }
        $articulos = $this->ArticulosEans->Articulos->find('list', ['limit' => 200]);
        $this->set(compact('articulosEan', 'articulos'));
        $this->set('_serialize', ['articulosEan']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Articulos Ean id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $articulosEan = $this->ArticulosEans->get($id);
        if ($this->ArticulosEans->delete($articulosEan)) {
            $this->Flash->success(__('The articulos ean has been deleted.'));
        } else {
            $this->Flash->error(__('The articulos ean could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
