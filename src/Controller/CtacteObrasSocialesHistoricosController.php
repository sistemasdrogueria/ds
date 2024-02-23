<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CtacteObrasSocialesHistoricos Controller
 *
 * @property \App\Model\Table\CtacteObrasSocialesHistoricosTable $CtacteObrasSocialesHistoricos
 */
class CtacteObrasSocialesHistoricosController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Clientes', 'ObraSocials']
        ];
        $ctacteObrasSocialesHistoricos = $this->paginate($this->CtacteObrasSocialesHistoricos);

        $this->set(compact('ctacteObrasSocialesHistoricos'));
        $this->set('_serialize', ['ctacteObrasSocialesHistoricos']);
    }

    /**
     * View method
     *
     * @param string|null $id Ctacte Obras Sociales Historico id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $ctacteObrasSocialesHistorico = $this->CtacteObrasSocialesHistoricos->get($id, [
            'contain' => ['Clientes', 'ObraSocials']
        ]);

        $this->set('ctacteObrasSocialesHistorico', $ctacteObrasSocialesHistorico);
        $this->set('_serialize', ['ctacteObrasSocialesHistorico']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $ctacteObrasSocialesHistorico = $this->CtacteObrasSocialesHistoricos->newEntity();
        if ($this->request->is('post')) {
            $ctacteObrasSocialesHistorico = $this->CtacteObrasSocialesHistoricos->patchEntity($ctacteObrasSocialesHistorico, $this->request->getData());
            if ($this->CtacteObrasSocialesHistoricos->save($ctacteObrasSocialesHistorico)) {
                $this->Flash->success(__('The ctacte obras sociales historico has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ctacte obras sociales historico could not be saved. Please, try again.'));
        }
        $clientes = $this->CtacteObrasSocialesHistoricos->Clientes->find('list', ['limit' => 200]);
        $obraSocials = $this->CtacteObrasSocialesHistoricos->ObraSocials->find('list', ['limit' => 200]);
        $this->set(compact('ctacteObrasSocialesHistorico', 'clientes', 'obraSocials'));
        $this->set('_serialize', ['ctacteObrasSocialesHistorico']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Ctacte Obras Sociales Historico id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $ctacteObrasSocialesHistorico = $this->CtacteObrasSocialesHistoricos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ctacteObrasSocialesHistorico = $this->CtacteObrasSocialesHistoricos->patchEntity($ctacteObrasSocialesHistorico, $this->request->getData());
            if ($this->CtacteObrasSocialesHistoricos->save($ctacteObrasSocialesHistorico)) {
                $this->Flash->success(__('The ctacte obras sociales historico has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ctacte obras sociales historico could not be saved. Please, try again.'));
        }
        $clientes = $this->CtacteObrasSocialesHistoricos->Clientes->find('list', ['limit' => 200]);
        $obraSocials = $this->CtacteObrasSocialesHistoricos->ObraSocials->find('list', ['limit' => 200]);
        $this->set(compact('ctacteObrasSocialesHistorico', 'clientes', 'obraSocials'));
        $this->set('_serialize', ['ctacteObrasSocialesHistorico']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Ctacte Obras Sociales Historico id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ctacteObrasSocialesHistorico = $this->CtacteObrasSocialesHistoricos->get($id);
        if ($this->CtacteObrasSocialesHistoricos->delete($ctacteObrasSocialesHistorico)) {
            $this->Flash->success(__('The ctacte obras sociales historico has been deleted.'));
        } else {
            $this->Flash->error(__('The ctacte obras sociales historico could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
