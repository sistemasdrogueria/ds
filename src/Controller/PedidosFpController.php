<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Http\Client;

/**
 *PedidosFp Controller
 * *
 * @method \App\Model\Entity\PedidosFp[] paginate($object = null, array $settings = []) */
class PedidosFpController extends AppController
{

    public function isAuthorized()
    {
        if (in_array($this->request->action, ['index_admin','search'])) {

            if ($this->request->session()->read('Auth.User.role') == 'admin' ||$this->request->session()->read('Auth.User.role') == 'farmapoint'  )
                return true;
            else 
				if ($this->request->session()->read('Auth.User.role') == 'adminS')
                return true;
            else
                $this->Flash->error(__('No tiene permisos para ingresar'), ['key' => 'changepass']);
            return false;
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
        $pedidosFp = $this->paginate($this->PedidosFp);

        $this->set(compact('pedidosFp'));
        $this->set('_serialize', ['pedidosFp']);
    }

    public function index_admin()
    {
        $this->viewBuilder()->layout('admin');
        // $pedidosFp = $this->paginate($this->PedidosFp);

        $http = new Client();

        // Realiza la solicitud GET a la API
        $response = $http->get('https://drogueriasur.com.ar/fp-api-laravel/public/api/getPedidosFp');

        if ($response->isOk()) {
            $pedidosFp = json_decode($response->body(), true);
            // Puedes hacer lo que necesites con $pedidosFp aquí
        } else {
            // Manejar el error
            $this->Flash->error(__('Error al obtener los pedidos de la API.'));
            $pedidosFp = []; // Inicializa como un array vacío si hay error
        }
        $this->set('titulo', 'Pedidos Tu Farmapoint');
        $this->set(compact('pedidosFp'));
        $this->set('_serialize', ['pedidosFp']);
    }

    public function search()
    {
        $this->viewBuilder()->setLayout('vacio');
        $fechadesde = $this->request->getData('fechadesde');
        $fechahasta = $this->request->getData('fechahasta');
        $terminobuscarfp = $this->request->getData('terminobuscarfp');
        $terminobuscards = $this->request->getData('terminobuscards');
        $terminobuscarcodigods = $this->request->getData('terminobuscarcodigods');
        // $pedidosFp = $this->paginate($this->PedidosFp);

        $http = new Client();

        // Realiza la solicitud GET a la API
        $response = $http->post(
            'https://drogueriasur.com.ar/fp-api-laravel/public/api/searchPedidosFp',
            [
                'fechadesde' => $fechadesde,
                'fechahasta' => $fechahasta,
                'terminobuscarfp'=>$terminobuscarfp,
                'terminobuscards'=>$terminobuscards,
                'terminobuscarcodigods'=>$terminobuscarcodigods,
            ]
        );

        if ($response->isOk()) {
            $pedidosFp = json_decode($response->body(), true);
            $data="exitosa la consulta";
            // Puedes hacer lo que necesites con $pedidosFp aquí
        } else {
            // Manejar el error
            $data="fallo la consulta";
            $pedidosFp = []; // Inicializa como un array vacío si hay error
        }

        	$this->response->body(json_encode(['message' =>$data, 'pedidosFp'=>$pedidosFp]));
		return $this->response;
        
    }


    /**
     * View method
     *
     * @param string|null $idPedidos Fp id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $pedidosFp = $this->PedidosFp->get($id, [
            'contain' => []
        ]);

        $this->set('pedidosFp', $pedidosFp);
        $this->set('_serialize', ['pedidosFp']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $pedidosFp = $this->PedidosFp->newEntity();
        if ($this->request->is('post')) {
            $pedidosFp = $this->PedidosFp->patchEntity($pedidosFp, $this->request->getData());
            if ($this->PedidosFp->save($pedidosFp)) {
                $this->Flash->success(__('Thepedidos fp has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Thepedidos fp could not be saved. Please, try again.'));
        }
        $this->set(compact('pedidosFp'));
        $this->set('_serialize', ['pedidosFp']);
    }

    /**
     * Edit method
     *
     * @param string|null $idPedidos Fp id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $pedidosFp = $this->PedidosFp->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $pedidosFp = $this->PedidosFp->patchEntity($pedidosFp, $this->request->getData());
            if ($this->PedidosFp->save($pedidosFp)) {
                $this->Flash->success(__('Thepedidos fp has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Thepedidos fp could not be saved. Please, try again.'));
        }
        $this->set(compact('pedidosFp'));
        $this->set('_serialize', ['pedidosFp']);
    }

    /**
     * Delete method
     *
     * @param string|null $idPedidos Fp id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $pedidosFp = $this->PedidosFp->get($id);
        if ($this->PedidosFp->delete($pedidosFp)) {
            $this->Flash->success(__('Thepedidos fp has been deleted.'));
        } else {
            $this->Flash->error(__('Thepedidos fp could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
