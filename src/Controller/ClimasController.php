<?php

namespace App\Controller;


use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\I18n\Time;
use Cake\Database\Connection;
use Cake\ORM\TableRegistry;
use Cake\Database\Expression\QueryExpression;
use Cake\Datasource\ConnectionManager;

/**
 * Climas Controller
 *
 * @property \App\Model\Table\ClimasTable $Climas
 *
 * @method \App\Model\Entity\Clima[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ClimasController extends AppController
{

    public function initialize()
    {
        parent::initialize();

        // Include the FlashComponent
        $this->loadComponent('Flash');
        // Load Files model
        $this->loadModel('Files');
    }

    public function beforeFilter(Event $event)
    {
        // allow all action
        $this->Auth->allow(['index']);
    }

    public function isAuthorized()
    {
        if (in_array($this->request->action, ['edit', 'delete', 'add', 'index', 'localidad', 'mostrarsearch'])) {

            if ($this->request->session()->read('Auth.User.role') == 'admin') {
                return true;
            } else {
                if ($this->request->session()->read('Auth.User.role') == 'client') {

                    $tiene = $this->tienepermiso('climas', $this->request->action);
                    if (!$tiene)
                        $this->Flash->error(__('No tiene permisos para ingresar'), ['key' => 'changepass']);
                    return $tiene;
                } else {
                    if ($this->request->session()->read('Auth.User.role') == 'provider') {
                        $this->Flash->error(__('No tiene permisos para ingresar'), ['key' => 'changepass']);
                        $this->redirect(['controller' => 'carritos', 'action' => 'index']);
                        return false;
                    } else {

                        if ($this->request->session()->read('Auth.User.role') == 'deposit') {
                            return true;
                        } else
                        $this->Flash->error(__('No tiene permisos para ingresar'), ['key' => 'changepass']);

                        $this->redirect(['controller' => 'Pages', 'action' => 'home']);
                        return false;
                    }
                    }
                }
            }
         else {
            if (in_array($this->request->action, ['view'])) {
                return true;
            } else {
                $this->Flash->error(__('No tiene permisos para ingresar'));
                $this->redirect(['controller' => 'Pages', 'action' => 'home']);
                return false;
            }
        }
        return parent::isAuthorized($user);
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Transportes', 'Localidads']
        ];
        $climas = $this->paginate($this->Climas);
        $this->loadModel('Clientes');
        $provincia = $this->Clientes->find('list', ['keyField' => rtrim('pro.provincia_id_api'), 'valueField' => rtrim('pro.nombre')])
            ->select([('pro.provincia_id_api'), rtrim('pro.nombre')])
            ->join(
                [
                    'table' => 'provincias',
                    'alias' => 'pro',
                    'type' => 'INNER',
                    'conditions' => [
                        'Clientes.provincia_id = pro.id',
                        'Clientes.eliminado' => 0,
                        ' Clientes.habilitado' => 1,

                    ]
                ]
            );
        $this->set('provincias', $provincia);
        $this->viewBuilder()->layout('admin_depo');
        $this->set(compact('climas'));
    }

    /**
     * View method
     *
     * @param string|null $id Clima id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $clima = $this->Climas->get($id, [
            'contain' => ['Transportes', 'Localidads']
        ]);

        $this->set('clima', $clima);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $clima = $this->Climas->newEntity();
        if ($this->request->is('post', 'ajax')) {
            $clima2 = $this->Climas->find('all')->where(['localidad_id_api' => $this->request->data['localidad_id_api']])->first();

            if (is_null($clima2)) {
                $this->loadModel('Cortes');
                $clima['nombre'] =           $this->request->data['nombre'];
                $corte = $this->Cortes->find('all')->where(['codigo' => $this->request->data['transporte_id']])->first();

                if (!is_null($corte)) {
                    $clima['transporte_id'] =    $corte['salida_n_id'];
                } else {
                    $clima['transporte_id'] = null;
                }
                $clima['localidad_id'] =     $this->request->data['localidad_id'];
                $clima['localidad_id_api'] = $this->request->data['localidad_id_api'];
                $clima['provincia_id_api'] = $this->request->data['provincia_id_api'];
                $clima['orden'] = 0;

                if ($this->Climas->save($clima)) {
                    $clim = $this->Climas->find('all');
                    $this->set('climas', $this->paginate($clim));
                    $this->set('_serialize', ['climas']);
                    $responseData = 1;
                    $this->response->body(json_encode($responseData));
                    return $this->response;
                }
              
                $responseData = 0;
                $this->response->body(json_encode($responseData));
                return $this->response;
            } else {

                $responseData = 2;
                $this->response->body(json_encode($responseData));
            }
        }
    }



    /**
     * Edit method
     *
     * @param string|null $id Clima id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $clima = $this->Climas->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $clima = $this->Climas->patchEntity($clima, $this->request->getData());
            if ($this->Climas->save($clima)) {
                $this->Flash->success(__('The clima has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The clima could not be saved. Please, try again.'));
        }
        $transportes = $this->Climas->Transportes->find('list', ['limit' => 200]);
        $localidads = $this->Climas->Localidads->find('list', ['limit' => 200]);
        $this->set(compact('clima', 'transportes', 'localidads'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Clima id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete()
    {
        if ($this->request->is(['ajax', 'post'])) {

            if (!empty($this->request->data['id'])) {
                $id = $this->request->data['id'];
                $this->viewBuilder()->layout('vacio');
                $clima = $this->Climas->get($id);
                if ($this->Climas->delete($clima)) {
                    $responseData = 1;
                    echo json_encode($responseData);
                } else {
                    $responseData = 0;
                    echo json_encode($responseData);
                }
            }
        }
    }

    public function localidad()
    {
        if ($this->request->is(['ajax', 'post'])) {
            $this->viewBuilder()->layout('vacio');

            if (!empty($this->request->data['idp'])) {
                $idp = $this->request->data['idp'];
                $this->loadModel('Localidads');
                $localidads = $this->Localidads->find('all')

                    ->join(
                        [
                            'table' => 'clientes',
                            'alias' => 'Cliente',
                            'type' => 'INNER',
                            'conditions' => [
                                'Cliente.localidad_id = Localidads.id',
                                'Cliente.eliminado' => 0,
                                ' Cliente.habilitado' => 1,

                            ]
                        ]
                    )
                    ->where(['provincia_id_api' => $idp])
                    ->order(['Localidads.nombre' => 'ASC']);
                $localidad = $localidads->toArray();
                $local = array_unique($localidad);
                $responseData = ['success' => true, 'responseText' => "eliminado", 'status' => 200, 'localidad' => $local];
                $this->request->session()->write('local', $local);
                $this->set('responseData', $responseData);
                $this->set('_serialize', ['responseData']);
                $this->set('localidad', $local);

                echo json_encode($responseData);
            }



            if (isset($this->request->data['terminobuscar'])) {

                $terminobuscar = $this->request->data['terminobuscar'];

                if (!empty($this->request->data['terminobuscar'])) {
                    $this->loadModel('Localidads');
                    $localidads = $this->Localidads->find()

                        ->join(
                            [
                                'table' => 'clientes',
                                'alias' => 'Cliente',
                                'type' => 'INNER',
                                'conditions' => [
                                    'Cliente.localidad_id = Localidads.id',
                                    'Cliente.eliminado' => 0,
                                    ' Cliente.habilitado' => 1,

                                ]
                            ]
                        )
                        ->where(['Localidads.nombre LIKE' => $terminobuscar]);
                    $localidad = $localidads->toArray();
                    $local = array_unique($localidad);
                    $responseData = ['status' => 200, 'localidad' => $local];
                    echo json_encode($responseData);
                }
            }
        }
    }


    public function mostrarsearch()
    {
        if ($this->request->is(['ajax', 'post'])) {
            $this->viewBuilder()->layout('busquedajax');
            if (!empty($this->request->data['localidadidapi'])) {
                $localidadidapi = $this->request->data['localidadidapi'];
                $this->request->session()->write('localidadidapi', $localidadidapi);
                $this->set('localidadidapi', $localidadidapi);
            }
        }
    }
}
