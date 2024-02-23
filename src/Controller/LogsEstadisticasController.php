<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * LogsEstadisticas Controller
 *
 * @property \App\Model\Table\LogsEstadisticasTable $LogsEstadisticas
 *
 * @method \App\Model\Entity\LogsEstadistica[] paginate($object = null, array $settings = [])
 */
class LogsEstadisticasController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Clientes', 'Users', 'Permisos']
        ];
        $logsEstadisticas = $this->paginate($this->LogsEstadisticas);

        $this->set(compact('logsEstadisticas'));
        $this->set('_serialize', ['logsEstadisticas']);
    }

    /**
     * View method
     *
     * @param string|null $id Logs Estadistica id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $logsEstadistica = $this->LogsEstadisticas->get($id, [
            'contain' => ['Clientes', 'Users', 'Permisos']
        ]);

        $this->set('logsEstadistica', $logsEstadistica);
        $this->set('_serialize', ['logsEstadistica']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $logsEstadistica = $this->LogsEstadisticas->newEntity();
        if ($this->request->is('post')) {
            $logsEstadistica = $this->LogsEstadisticas->patchEntity($logsEstadistica, $this->request->getData());
            if ($this->LogsEstadisticas->save($logsEstadistica)) {
                $this->Flash->success(__('The logs estadistica has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The logs estadistica could not be saved. Please, try again.'));
        }
        $clientes = $this->LogsEstadisticas->Clientes->find('list', ['limit' => 200]);
        $users = $this->LogsEstadisticas->Users->find('list', ['limit' => 200]);
        $permisos = $this->LogsEstadisticas->Permisos->find('list', ['limit' => 200]);
        $this->set(compact('logsEstadistica', 'clientes', 'users', 'permisos'));
        $this->set('_serialize', ['logsEstadistica']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Logs Estadistica id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $logsEstadistica = $this->LogsEstadisticas->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $logsEstadistica = $this->LogsEstadisticas->patchEntity($logsEstadistica, $this->request->getData());
            if ($this->LogsEstadisticas->save($logsEstadistica)) {
                $this->Flash->success(__('The logs estadistica has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The logs estadistica could not be saved. Please, try again.'));
        }
        $clientes = $this->LogsEstadisticas->Clientes->find('list', ['limit' => 200]);
        $users = $this->LogsEstadisticas->Users->find('list', ['limit' => 200]);
        $permisos = $this->LogsEstadisticas->Permisos->find('list', ['limit' => 200]);
        $this->set(compact('logsEstadistica', 'clientes', 'users', 'permisos'));
        $this->set('_serialize', ['logsEstadistica']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Logs Estadistica id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $logsEstadistica = $this->LogsEstadisticas->get($id);
        if ($this->LogsEstadisticas->delete($logsEstadistica)) {
            $this->Flash->success(__('The logs estadistica has been deleted.'));
        } else {
            $this->Flash->error(__('The logs estadistica could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
