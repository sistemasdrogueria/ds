<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Laboratorios Controller
 *
 * @property \App\Model\Table\LaboratoriosTable $Laboratorios
 */
class LaboratoriosController extends AppController
{
    public function isAuthorized()
    {
        if (in_array($this->request->action, ['add', 'search', 'vaciar', 'confirm', 'restriciones', 'index_admin', 'edit_admin', 'edit_admin_all'])) {

            if ($this->request->session()->read('Auth.User.role') == 'admin') {
                return true;
            } else {
                if ($this->request->session()->read('Auth.User.role') == 'client') {
                    $tiene = $this->tienepermiso('carritos', $this->request->action);
                    if (!$tiene)
                        $this->Flash->error(__('No tiene permisos para ingresar'), ['key' => 'changepass']);
                    return $tiene;
                } else {
                    if ($this->request->session()->read('Auth.User.role') == 'provider') {
                        return false;
                    } else {
                        $this->Flash->error(__('No tiene permisos para ingresar'), ['key' => 'changepass']);
                        return false;
                    }
                }
            }
        } else {
            return false;
        }
        return parent::isAuthorized($user);
    }
    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('laboratorios', $this->paginate($this->Laboratorios));
        $this->set('_serialize', ['laboratorios']);
    }

    /**
     * View method
     *
     * @param string|null $id Laboratorio id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $laboratorio = $this->Laboratorios->get($id, [
            'contain' => ['Articulos']
        ]);
        $this->set('laboratorio', $laboratorio);
        $this->set('_serialize', ['laboratorio']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $laboratorio = $this->Laboratorios->newEntity();
        if ($this->request->is('post')) {
            $laboratorio = $this->Laboratorios->patchEntity($laboratorio, $this->request->data);
            if ($this->Laboratorios->save($laboratorio)) {
                $this->Flash->success('The laboratorio has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The laboratorio could not be saved. Please, try again.');
            }
        }
        $this->set(compact('laboratorio'));
        $this->set('_serialize', ['laboratorio']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Laboratorio id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $laboratorio = $this->Laboratorios->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $laboratorio = $this->Laboratorios->patchEntity($laboratorio, $this->request->data);
            if ($this->Laboratorios->save($laboratorio)) {
                $this->Flash->success('The laboratorio has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The laboratorio could not be saved. Please, try again.');
            }
        }
        $this->set(compact('laboratorio'));
        $this->set('_serialize', ['laboratorio']);
    }


    public function index_admin($id = null)
    {
        $this->viewBuilder()->layout('admin');

        $this->paginate = [
            'contain' => [],
            'limit' => 300,
            'offset' => 0,
            'order' => ['id' => 'asc']
        ];
        $labora = $this->Laboratorios->find('all')->where(['eliminado' => 0]);
        $this->set('titulo', 'Modificar restricción laboratorios');
        $this->set('laboratorios', $this->paginate($labora));
        $this->set('_serialize', ['laboratorios']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Laboratorio id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $laboratorio = $this->Laboratorios->get($id);
        if ($this->Laboratorios->delete($laboratorio)) {
            $this->Flash->success('The laboratorio has been deleted.');
        } else {
            $this->Flash->error('The laboratorio could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
    
    public function edit_admin()
    {
        $this->request->allowMethod(['post']);
        if ($this->request->is('post')) {
            $id = $this->request->getData('id');
            $restriciones = $this->request->getData('restriciones');
            $unidades = $this->request->getData('unidades');

            $laboratorio = $this->Laboratorios->get($id, [
                'contain' => []
            ]);

            if ($this->request->is(['patch', 'post', 'put'])) {
                $laboratorio = $this->Laboratorios->patchEntity($laboratorio, $this->request->data);
                if ($this->Laboratorios->save($laboratorio)) {

                    $respuesta = ["respuesta" => "ok"];
                    $this->response->body(json_encode($respuesta));
                     $this->upgradearticulos($id, null, $unidades);
                    return $this->response;
                    // return $this->redirect(['action' => 'index']);
                } else {
                    $respuesta = ["respuesta" => false];

                    $this->response->body(json_encode($respuesta));

                    return $this->response;
                }
            }
        }
    }

    public function edit_admin_all()
    {
        $this->request->allowMethod(['post']);
        if ($this->request->is('post')) {
            $restriciones = $this->request->getData('restriciones');
            $unidades = $this->request->getData('unidades');
            $this->Laboratorios->updateAll(
                ['restriciones' => $restriciones, 'unidades' => $unidades],
                // Campos a actualizar
                ['eliminado' => 0] // Condición
            );
             $this->upgradearticulosall($unidades);
            $respuesta = ["respuesta" => "ok"];
            $this->response->body(json_encode($respuesta));
      
            return $this->response;
        }
    }

    public function upgradearticulos($labid, $provid, $unidades)
    {
        $this->loadmodel('Articulos');
        $conditions = ['eliminado' => 0];

        if (!is_null($labid)) {
            $conditions['laboratorio_id'] = $labid;
        }

        if (!is_null($provid)) {
            $conditions['proveedor_id'] = $provid;
        }

        $result = $this->Articulos->find('all')->where($conditions)->toArray();
            $new_value = $unidades; 

    $this->Articulos->updateAll(
        ['restringido_unid_w' => $new_value], // Campos y valores a actualizar
        $conditions // Condición
    );

        return $result;
    }

     public function upgradearticulosall($unidades)
    {
        $this->loadmodel('Articulos');
        $conditions = ['eliminado' => 0];

        $result = $this->Articulos->find('all')->where($conditions)->toArray();
            $new_value = $unidades; 

    $this->Articulos->updateAll(
        ['restringido_unid_w' => $new_value], // Campos y valores a actualizar
        $conditions // Condición
    );

        return $result;
    }
}
