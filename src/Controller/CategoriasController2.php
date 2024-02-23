<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Categorias Controller
 *
 * @property \App\Model\Table\CategoriasTable $Categorias
 */
class CategoriasController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index_admin()
    {
		$this->layout = 'admin';
        $this->set('categorias', $this->paginate($this->Categorias));
        $this->set('_serialize', ['categorias']);
		$this->set('titulo','Lista de Categorias');
    }

    /**
     * View method
     *
     * @param string|null $id Categoria id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view_admin($id = null)
    {
		$this->layout = 'admin';
        $categoria = $this->Categorias->get($id, [
            'contain' => ['Subcategorias']
        ]);
        $this->set('categoria', $categoria);
		
		$query = $this->Subcategorias;//'all')->select(['id', 'nombre'])->where(['Subcategoria.categoria_id >' => $id]);
		$this->set('categorias', $this->paginate($query));
		$this->set('_serialize', ['categorias']);
        $this->set('_serialize', ['categoria']);
		$this->set('titulo','Detalle de la Categorias');
		
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add_admin()
    {
		$this->layout = 'admin';
        $categoria = $this->Categorias->newEntity();
        if ($this->request->is('post')) {
            $categoria = $this->Categorias->patchEntity($categoria, $this->request->data);
            if ($this->Categorias->save($categoria)) {
                $this->Flash->success('The categoria has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The categoria could not be saved. Please, try again.');
            }
        }
        $this->set(compact('categoria'));
        $this->set('_serialize', ['categoria']);
		$this->set('titulo','Agregar Categoria');
    }

    /**
     * Edit method
     *
     * @param string|null $id Categoria id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit_admin($id = null)
    {
		$this->layout = 'admin';
        $categoria = $this->Categorias->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $categoria = $this->Categorias->patchEntity($categoria, $this->request->data);
            if ($this->Categorias->save($categoria)) {
                $this->Flash->success('The categoria has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The categoria could not be saved. Please, try again.');
            }
        }


        $this->set(compact('categoria'));
        $this->set('_serialize', ['categoria']);
		$this->set('titulo','Editar Categoria');
    }

    /**
     * Delete method
     *
     * @param string|null $id Categoria id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete_admin($id = null)
    {
		$this->layout = 'admin';
        $this->request->allowMethod(['post', 'delete']);
        $categoria = $this->Categorias->get($id);
        if ($this->Categorias->delete($categoria)) {
            $this->Flash->success('The categoria has been deleted.');
        } else {
            $this->Flash->error('The categoria could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
