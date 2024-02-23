<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Filesystem\File;
use Cake\Network\Request;
use Cake\Database\Expression\QueryExpression;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;
/**
 * Preventas Controller
 *
 * @property \App\Model\Table\PreventasTable $Preventas
 *
 * @method \App\Model\Entity\Preventa[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PreventasController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Articulos']
        ];
        $preventas = $this->paginate($this->Preventas);

        $this->set(compact('preventas'));
    }

    /**
     * View method
     *
     * @param string|null $id Preventa id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $preventa = $this->Preventas->get($id, [
            'contain' => ['Articulos', 'Carritos', 'Pedidos']
        ]);

        $this->set('preventa', $preventa);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $preventa = $this->Preventas->newEntity();
        if ($this->request->is('post')) {
            $preventa = $this->Preventas->patchEntity($preventa, $this->request->getData());
            if ($this->Preventas->save($preventa)) {
                $this->Flash->success(__('The preventa has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The preventa could not be saved. Please, try again.'));
        }
        $articulos = $this->Preventas->Articulos->find('list', ['limit' => 200]);
        $carritos = $this->Preventas->Carritos->find('list', ['limit' => 200]);
        $pedidos = $this->Preventas->Pedidos->find('list', ['limit' => 200]);
        $this->set(compact('preventa', 'articulos', 'carritos', 'pedidos'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Preventa id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $preventa = $this->Preventas->get($id, [
            'contain' => ['Carritos', 'Pedidos']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $preventa = $this->Preventas->patchEntity($preventa, $this->request->getData());
            if ($this->Preventas->save($preventa)) {
                $this->Flash->success(__('The preventa has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The preventa could not be saved. Please, try again.'));
        }
        $articulos = $this->Preventas->Articulos->find('list', ['limit' => 200]);
        $carritos = $this->Preventas->Carritos->find('list', ['limit' => 200]);
        $pedidos = $this->Preventas->Pedidos->find('list', ['limit' => 200]);
        $this->set(compact('preventa', 'articulos', 'carritos', 'pedidos'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Preventa id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $preventa = $this->Preventas->get($id);
        if ($this->Preventas->delete($preventa)) {
            $this->Flash->success(__('The preventa has been deleted.'));
        } else {
            $this->Flash->error(__('The preventa could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
