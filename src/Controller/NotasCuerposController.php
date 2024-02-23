<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * NotasCuerpos Controller
 *
 * @property \App\Model\Table\NotasCuerposTable $NotasCuerpos
 */
class NotasCuerposController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['NotasCabeceras', 'Articulos']
        ];
        $notasCuerpos = $this->paginate($this->NotasCuerpos);

        $this->set(compact('notasCuerpos'));
        $this->set('_serialize', ['notasCuerpos']);
    }

    /**
     * View method
     *
     * @param string|null $id Notas Cuerpo id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $notasCuerpo = $this->NotasCuerpos->get($id, [
            'contain' => ['NotasCabeceras', 'Articulos']
        ]);

        $this->set('notasCuerpo', $notasCuerpo);
        $this->set('_serialize', ['notasCuerpo']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $notasCuerpo = $this->NotasCuerpos->newEntity();
        if ($this->request->is('post')) {
            $notasCuerpo = $this->NotasCuerpos->patchEntity($notasCuerpo, $this->request->data);
            if ($this->NotasCuerpos->save($notasCuerpo)) {
                $this->Flash->success(__('The notas cuerpo has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The notas cuerpo could not be saved. Please, try again.'));
            }
        }
        $notasCabeceras = $this->NotasCuerpos->NotasCabeceras->find('list', ['limit' => 200]);
        $articulos = $this->NotasCuerpos->Articulos->find('list', ['limit' => 200]);
        $this->set(compact('notasCuerpo', 'notasCabeceras', 'articulos'));
        $this->set('_serialize', ['notasCuerpo']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Notas Cuerpo id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $notasCuerpo = $this->NotasCuerpos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $notasCuerpo = $this->NotasCuerpos->patchEntity($notasCuerpo, $this->request->data);
            if ($this->NotasCuerpos->save($notasCuerpo)) {
                $this->Flash->success(__('The notas cuerpo has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The notas cuerpo could not be saved. Please, try again.'));
            }
        }
        $notasCabeceras = $this->NotasCuerpos->NotasCabeceras->find('list', ['limit' => 200]);
        $articulos = $this->NotasCuerpos->Articulos->find('list', ['limit' => 200]);
        $this->set(compact('notasCuerpo', 'notasCabeceras', 'articulos'));
        $this->set('_serialize', ['notasCuerpo']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Notas Cuerpo id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $notasCuerpo = $this->NotasCuerpos->get($id);
        if ($this->NotasCuerpos->delete($notasCuerpo)) {
            $this->Flash->success(__('The notas cuerpo has been deleted.'));
        } else {
            $this->Flash->error(__('The notas cuerpo could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
