<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Ofertas Controller
 *
 * @property \App\Model\Table\OfertasTable $Ofertas
 */
class OfertasController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Articulos', 'OfertasTipos']
        ];
        $this->set('ofertas', $this->paginate($this->Ofertas));
        $this->set('_serialize', ['ofertas']);
    }

    /**
     * View method
     *
     * @param string|null $id Oferta id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $oferta = $this->Ofertas->get($id, [
            'contain' => ['Articulos', 'OfertasTipos']
        ]);
        $this->set('oferta', $oferta);
        $this->set('_serialize', ['oferta']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $oferta = $this->Ofertas->newEntity();
        if ($this->request->is('post')) {
            $oferta = $this->Ofertas->patchEntity($oferta, $this->request->data);
            if ($this->Ofertas->save($oferta)) {
                $this->Flash->success(__('The oferta has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The oferta could not be saved. Please, try again.'));
            }
        }
        $articulos = $this->Ofertas->Articulos->find('list', ['limit' => 200]);
        $ofertasTipos = $this->Ofertas->OfertasTipos->find('list', ['limit' => 200]);
        $this->set(compact('oferta', 'articulos', 'ofertasTipos'));
        $this->set('_serialize', ['oferta']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Oferta id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $oferta = $this->Ofertas->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $oferta = $this->Ofertas->patchEntity($oferta, $this->request->data);
            if ($this->Ofertas->save($oferta)) {
                $this->Flash->success(__('The oferta has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The oferta could not be saved. Please, try again.'));
            }
        }
        $articulos = $this->Ofertas->Articulos->find('list', ['limit' => 200]);
        $ofertasTipos = $this->Ofertas->OfertasTipos->find('list', ['limit' => 200]);
        $this->set(compact('oferta', 'articulos', 'ofertasTipos'));
        $this->set('_serialize', ['oferta']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Oferta id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $oferta = $this->Ofertas->get($id);
        if ($this->Ofertas->delete($oferta)) {
            $this->Flash->success(__('The oferta has been deleted.'));
        } else {
            $this->Flash->error(__('The oferta could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
