<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\I18n\Time;
/**
 * Clientes Controller
 *
 * @property \App\Model\Table\ClientesTable $Clientes
 */
class ClientesController extends AppController
{

	public function isAuthorized()
    {
	if (in_array($this->request->action,['edit_admin','delete','add','index_admin','comunicado','view_admin','view','edit_cuenta','crear','edit_email','habilitar','edit_credito_admin','edit_cliente_admin','parameters','edit_parameters','saveconditions'])) {
       
            if($this->request->session()->read('Auth.User.role')=='admin') 
            {				
                return true;			
            }			
            else {	
                if($this->request->session()->read('Auth.User.role')=='client') 
                {
					$tiene = $this->tienepermiso('clientes', $this->request->action);
					 if (in_array($this->request->action,['view','edit_cuenta','edit_email','comunicado','parameters','edit_parameters','saveconditions']))
					 {
						
						 return true;
					 }
					 else
					 {
						$this->redirect(array('controller' => 'Carritos', 'action' => 'index'));
						$this->Flash->error(__('No tiene permisos para ingresar'),['key' => 'changepass']);
						return false; 
					 }
								
                }	
                else {
					if($this->request->session()->read('Auth.User.role')=='provider') 
					{
					
						if (in_array($this->request->action,['view']))
					 {
						 return true;
					 }
					 else
					 {
						$this->redirect(array('controller' => 'Carritos', 'action' => 'index'));
						$this->Flash->error(__('No tiene permisos para ingresar'),['key' => 'changepass']);
						return false; 
					 }					
					}
					else {
						
						return false;	
						$this->Flash->error(__('No tiene permisos para ingresar'),['key' => 'changepass']);
						return $this->redirect(['controller' => 'Pages', 'action' => 'home']);
					}
                    
                }	
            }		
            }		
			else 
			{			
				$this->Flash->error(__('No tiene permisos para ingresar - No Direct'),['key' => 'changepass']);		
				$this->redirect(['controller' => 'Pages', 'action' => 'home']);  		
				return false;	
				
			}
		return parent::isAuthorized($user);
    }
	
    /**
     * Index method
     *
     * @return void
     */
    public function index_admin()
    {
		$this->viewBuilder()->layout('admin');
        $this->paginate = [
            'contain' => ['ClientesCreditos'],
			'limit' => 400,  
			'maxLimit' => 400,         
			'order' => ['Clientes.id' => 'DESC']
        ];
		
        
        $this->set('_serialize', ['clientes']);
		$this->set('titulo','Lista de Clientes');
		if ($this->request->is('post')) {
		 
			$termsearch ="";
			if ($this->request->data['termino']!= null)
			{
				$terminocompleto = explode(" ", $this->request->data['termino']);
				
				if (count($terminocompleto)>1)
				{
						foreach ($terminocompleto as $terminosimple): 
							$termsearch = $termsearch.'%'.$terminosimple.'%';
						endforeach; 
				}
				else
					if (is_numeric($terminocompleto[0]))
						$termsearch=$terminocompleto[0];
					else
						$termsearch = '%'.$terminocompleto[0].'%';
				
			}	
				
			if (is_numeric($termsearch))
				$result = $this->Clientes->find('all')->contain(['ClientesCreditos'])->where(['codigo ='=>$termsearch]);	
			else
				$result = $this->Clientes->find('all')->contain(['ClientesCreditos'])->where(['razon_social LIKE'=>$termsearch]);
			
				
				
				
			$this->set('clientes', $this->paginate($result));
			$this->set('_serialize', ['clientes']);
	}
		else
			$this->set('clientes', $this->paginate($this->Clientes->find('all')->contain(['ClientesCreditos'])));
		
		
		
    }

	public function comunicado($id = null)
    {
		$this->viewBuilder()->layout('store');
        $cliente = $this->Clientes->get($this->request->session()->read('Auth.User.cliente_id'));
        if ($this->request->is(['patch', 'post', 'put'])) {
			$this->Flash->success('COMUNICADO.',['key' => 'changepass']);
			/*
			
             //$cliente = $this->Clientes->patchEntity($cliente, $this->request->data);
			 $cliente['email'] = $this->request->data['email'];
			 $cliente['email_alternativo'] = $this->request->data['email_alternativo'];
			 $cliente['actualizo_correo'] =1;
			 $this->request->session()->write('clienteXX',$cliente);
		   if ($this->Clientes->save($cliente)) {
				
				$this->request->session()->write('Auth.User.actualizo_correo',2);
                $this->Flash->success('Se realizo los cambios correctamente.',['key' => 'changepass']);
                return $this->redirect(['controller'=>'carritos','action' => 'index']);
            } else {
                $this->Flash->error('No se pudo guardar, Intente nuevamente.',['key' => 'changepass']);
            }*/
        }
        $this->set(compact('cliente'));
        $this->set('_serialize', ['cliente']);
    }

    /**
     * View method
     *
     * @param string|null $id Cliente id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
		$this->viewBuilder()->layout('store');
       
		
		if (empty($this->request->session()->read('Auth.User.cliente_id')))
		{
			return $this->redirect(['controller'=>'users','action' => 'index']);
			
		}

		$cliente = $this->Clientes->get($this->request->session()->read('Auth.User.cliente_id'), [
            'contain' => ['Provincias','Localidads']
        ]);
		$this->loadModel('Users');
		$users= $this->Users->find('all')
				->where(['cliente_id'=>$this->request->session()->read('Auth.User.cliente_id')])
				->andWhere(['role'=>'client'])
				->andWhere(['perfile_id <>'=>$this->request->session()->read('Auth.User.perfile_id')]);
		$this->set('users',$users);
        $this->set('cliente', $cliente);
        $this->set('_serialize', ['cliente']);
		$this->loadModel('Perfiles');
		$this->set('perfiles',$this->Perfiles->find('list',['keyField' => 'id','valueField'=>'nombre']));
		
		
    }

	public function parameters($id = null)
    {
		$this->viewBuilder()->layout('store');
       
		
		if (empty($this->request->session()->read('Auth.User.cliente_id')))
		{
			return $this->redirect(['controller'=>'users','action' => 'index']);
			
		}

		$cliente = $this->Clientes->get($this->request->session()->read('Auth.User.cliente_id'), [
            'contain' => ['Provincias','Localidads']
        ]);
		$this->loadModel('Users');
		$users= $this->Users->find('all')
				->where(['cliente_id'=>$this->request->session()->read('Auth.User.cliente_id')])
				->andWhere(['role'=>'client'])
				->andWhere(['perfile_id <>'=>$this->request->session()->read('Auth.User.perfile_id')]);
		$this->set('users',$users);
        $this->set('cliente', $cliente);
        $this->set('_serialize', ['cliente']);
		$this->loadModel('Perfiles');
		$this->set('perfiles',$this->Perfiles->find('list',['keyField' => 'id','valueField'=>'nombre']));
		
		
    }
	    /**
     * View method
     *
     * @param string|null $id Cliente id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view_admin($id = null)
    {
		$this->viewBuilder()->layout('admin');
       
		$this->loadModel('Clientes');
		$cliente = $this->Clientes->get($id, [
            'contain' => ['Provincias','Localidads']
        ]);
		$this->loadModel('Users');
		$users= $this->Users->find('all')
				->where(['cliente_id'=>$id])
				->andWhere(['role'=>'client']);
		$this->set('users',$users);
        $this->set('cliente', $cliente);
        $this->set('_serialize', ['cliente']);
		$this->loadModel('Perfiles');
		$this->set('perfiles',$this->Perfiles->find('list',['keyField' => 'id','valueField'=>'nombre']));
		$this->set('titulo','Resumen Cliente');
		
    }

	
    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$this->viewBuilder()->layout('admin');
        $cliente = $this->Clientes->newEntity();
        if ($this->request->is('post')) {
            $cliente = $this->Clientes->patchEntity($cliente, $this->request->data);
            if ($this->Clientes->save($cliente)) {
                $this->Flash->success('El cliente fue guardado',['key' => 'changepass']);
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('No se pudo guardar. Intente nuevamente.',['key' => 'changepass']);
            }
        }
        $provincias = $this->Clientes->Provincias->find('list', ['limit' => 200]);
        $localidads = $this->Clientes->Localidads->find('list', ['limit' => 200]);
        $representantes = $this->Clientes->Representantes->find('list', ['limit' => 200]);
        $this->set(compact('cliente', 'provincias', 'localidads', 'representantes'));
        $this->set('_serialize', ['cliente']);
    }

	public function crear($d = null,$h = null)
    {
		//$this->request->session()->write('parametros',$d.$h);
		$this->viewBuilder()->layout('admin');
		$this->loadModel('Users');
		$this->loadModel('Clientesnos');
		$Clientes = $this->Clientes->find('all')
		->join([
						'table' => 'clientesnos',
						'alias' => 'cn',
						'type' => 'LEFT',
						 'conditions' => [
						'cn.codigo = Clientes.codigo',
						
						]		
					])
					->Select(['Clientes.id','Clientes.codigo','Clientes.nombre','cn.password'])
					->where(['Clientes.codigo >'=>$this->request->query('d')])
					->andWhere(['Clientes.codigo <'=>$this->request->query('h')]);
		$this->set('clientes', $Clientes);
		//->Select(['clientes.id','cleintes.codigo','clientes.nombre','cn.password'])->where(['codigo >'=>78808]);
		foreach ($Clientes as $opcion) {
			
			$user = $this->Users->newEntity();
				if ($opcion['codigo']<10000)
					$user['role'] = 'provider';
				else
					$user['role'] = 'client';
				
				//$user = $this->Users->patchEntity($user, $this->request->data);
				$user['username'] = $opcion['codigo'];
				$user['cliente_id']= $opcion['id'];
				$user['password'] = $opcion['cn']['password'];
				$user['perfile_id'] = 1;
				if ($this->Users->save($user)) {
										
				}
				/*
				$user = $this->Users->newEntity();
				$user['username'] = 's'.$opcion['codigo'];
				$user['cliente_id']= $opcion['id'];
				$user['password'] = '78963214';
				$user['super'] = 1;
				$user['perfile_id'] = 1;
				if ($this->Users->save($user)) {
										
				} */
			
		}
		
		return $this->redirect(['controller'=>'users','action' => 'index']);
    }
	
	
    /**
     * Edit method
     *
     * @param string|null $id Cliente id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit_admin($id = null)
    {
				
		$this->viewBuilder()->layout('admin');
		$cliente = $this->Clientes->newEntity();
		$cliente = $this->Clientes->get($id, [
            'contain' => ['Provincias','Localidads']
        ]);
		$this->set('titulo','Editar Clientes');
		
		$this->loadModel('ClientesCreditos');
		$fecha = Time::now();
		$fecha = $fecha->i18nFormat('yyyy-MM-dd');
		
		$clientesCredito = $this->ClientesCreditos->find('all')
			->where(['cliente_id' =>$id]);
		$clientesCredito = $clientesCredito->first();
		
		if ($clientesCredito ==null)	
		{
			 $clientesCredito = $this->ClientesCreditos->newEntity();
			 //$clientesCredito['cliente_id']=$id;
		}

        $this->set('cliente_id',$id);
        $this->set(compact('clientesCredito', 'cliente'));
        $this->set('_serialize', ['clientesCredito']);
        $this->set('cliente', $cliente);
        $this->set('_serialize', ['cliente']);
		
		
    }
	
	public function edit_cliente_admin($id = null)
    {
				
		$this->viewBuilder()->layout('admin');
		$cliente = $this->Clientes->newEntity();
		$cliente = $this->Clientes->get($id, [
            'contain' => ['Provincias','Localidads']
        ]);
		$this->set('titulo','Editar Clientes');
		
		
		$fecha = Time::now();
		$fecha = $fecha->i18nFormat('yyyy-MM-dd');
		
		
		
		
        if ($this->request->is(['patch', 'post', 'put'])) {
            $cliente = $this->Clientes->patchEntity($cliente, $this->request->data);
		
			
			if (!empty($this->request->data['habilitado']))
				$cliente['habilitado'] = $this->request->data['habilitado'];
			
			if (!empty($this->request->data['actualizo_gln']))
			$cliente['actualizo_gln'] = $this->request->data['actualizo_gln'];
		
			if (!empty($this->request->data['comunidadsur']))
			$cliente['comunidadsur'] = $this->request->data['comunidadsur'];
			
			if (!empty($this->request->data['farmapoint']))
			$cliente['farmapoint'] = $this->request->data['farmapoint'];
			if (!empty($this->request->data['tufarmapoint']))
			$cliente['tufarmapoint'] = $this->request->data['tufarmapoint'];
			
			if (!empty($this->request->data['selectos']))
			$cliente['selectos'] = $this->request->data['selectos'];

			if (!empty($this->request->data['cuentaprincipal']))
			$cliente['cuentaprincipal'] = $this->request->data['cuentaprincipal'];
			if (!empty($this->request->data['email']))
			$cliente['email'] =$this->request->data['email'];		
			if (!empty($this->request->data['email_alternativo']))
			$cliente['email_alternativo'] =$this->request->data['email_alternativo'];

			if ($this->Clientes->save($cliente)) {
                $this->Flash->success(__('Los cambios fueron guardados. '.$this->request->data['habilitado']),['key' => 'changepass']);
                return $this->redirect(['action' => 'index_admin']);
            } 
			else {
                $this->Flash->error(__('Los cambios no fue guardado. Intente nuevamente.'),['key' => 'changepass']);
            }
        }
        $this->set('cliente_id',$id);
        $this->set('cliente', $cliente);
        $this->set('_serialize', ['cliente']);
		
		
    }
	
	public function edit_credito_admin($id = null)
    {
				
		$this->viewBuilder()->layout('admin');
	    $this->set('titulo','Editar Clientes');
		
		$this->loadModel('ClientesCreditos');
		$fecha = Time::now();
		$fecha = $fecha->i18nFormat('yyyy-MM-dd');
		
		$clientesCredito = $this->ClientesCreditos->find('all')
			->where(['cliente_id' =>$id]);
		$clientesCredito = $clientesCredito->first();
		
		if ($clientesCredito ==null)	
		{
			 $clientesCredito = $this->ClientesCreditos->newEntity();
			 //$clientesCredito['cliente_id']=$id;
		}
		
		
        if ($this->request->is(['patch', 'post', 'put'])) {
            $clientesCredito = $this->ClientesCreditos->patchEntity($clientesCredito, $this->request->data);
			$clientesCredito['cliente_id']=$fecha;
			$clientesCredito['cliente_id']=$id;
			
            if ($this->ClientesCreditos->save($clientesCredito)) {
                $this->Flash->success(__('Se actualizo el credito'),['key' => 'changepass']);
                $this->redirect($this->referer());
            } 
			else {
                $this->Flash->error(__('Los cambios no fueron guardados (CREDITO). Intente nuevamente.'),['key' => 'changepass']);
            }

			
        }
        $this->set(compact('clientesCredito'));
        $this->set('_serialize', ['clientesCredito']);
    }

	public function edit_cuenta($id = null)
    {
		$this->viewBuilder()->layout('store');
        $cliente = $this->Clientes->get($this->request->session()->read('Auth.User.cliente_id'), [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $cliente = $this->Clientes->patchEntity($cliente, $this->request->data);
            if ($this->Clientes->save($cliente)) {
                $this->Flash->success('Se realizo los cambios correctamente.',['key' => 'changepass']);
                return $this->redirect(['action' => 'view']);
            } else {
                $this->Flash->error('No se pudo guardar, Intente nuevamente.',['key' => 'changepass']);
            }
        }
        $provincias = $this->Clientes->Provincias->find('list', ['limit' => 200]);
        $localidads = $this->Clientes->Localidads->find('list', ['limit' => 200]);
        $representantes = $this->Clientes->Representantes->find('list', ['limit' => 200]);
        $this->set(compact('cliente', 'provincias', 'localidads', 'representantes'));
        $this->set('_serialize', ['cliente']);
    }
	
	public function edit_email($id = null)
    {
		$this->viewBuilder()->layout('store');
        $cliente = $this->Clientes->get($this->request->session()->read('Auth.User.cliente_id'), [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
			
			
            $cliente = $this->Clientes->patchEntity($cliente, $this->request->data);
			if (!empty($this->request->data['email']))
			 $cliente['email'] = $this->request->data['email'];
			 if (!empty($this->request->data['email_alternativo']))
			 $cliente['email_alternativo'] = $this->request->data['email_alternativo'];
			 $cliente['actualizo_correo'] =1;
		   if ($this->Clientes->save($cliente)) {
				$this->request->session()->write('Auth.User.actualizo_correo',1);
				
                $this->Flash->success('Se realizo los cambios correctamente.',['key' => 'changepass']);
                return $this->redirect(['controller'=>'carritos','action' => 'index']);
            } else {
                $this->Flash->error('No se pudo guardar, Intente nuevamente.',['key' => 'changepass']);
            }
        }
        $this->set(compact('cliente'));
        $this->set('_serialize', ['cliente']);
    }
    
	public function edit_parameters($id = null)
    {
		$this->viewBuilder()->layout('store');
        $cliente = $this->Clientes->get($this->request->session()->read('Auth.User.cliente_id'), [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $cliente = $this->Clientes->patchEntity($cliente, $this->request->data);

			$cliente["coef_pyf"]= str_replace(",",".",$this->request->data["coef_pyf"]);

            if ($this->Clientes->save($cliente)) {
                $this->request->session()->write('Auth.User.coef_pyf',$cliente['coef_pyf']);
				$this->Flash->success('Se realizo los cambios correctamente.',['key' => 'changepass']);
                return $this->redirect(['action' => 'view']);
            } else {
                $this->Flash->error('No se pudo guardar, Intente nuevamente.',['key' => 'changepass']);
            }
        }
        //$provincias = $this->Clientes->Provincias->find('list', ['limit' => 200]);
        //$localidads = $this->Clientes->Localidads->find('list', ['limit' => 200]);

        $this->set(compact('cliente'));
        $this->set('_serialize', ['cliente']);
    }
	
	/**
     * Delete method
     *
     * @param string|null $id Cliente id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {/*
		$this->viewBuilder()->layout('admin');
        $this->request->allowMethod(['post', 'delete']);
        $cliente = $this->Clientes->get($id);
        if ($this->Clientes->delete($cliente)) {
            $this->Flash->success('The cliente has been deleted.');
        } else {
            $this->Flash->error('The cliente could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);*/
    }
	public function saveconditions(){

		     $cliente = $this->Clientes->get($this->request->session()->read('Auth.User.cliente_id'), [
            'contain' => []
        ]);

		  if ($this->request->is(['patch', 'post', 'put'])) {
            $cliente = $this->Clientes->patchEntity($cliente, $this->request->data);

			$cliente["conditions"] = 1;

            if ($this->Clientes->save($cliente)) {
					$this->request->session()->write('Auth.User.conditions', 1);
				$responseData= ['response'=> 'success', 'save'=>1];
            		$this->response->body(json_encode($responseData));
					return $this->response;
            } else {
                $this->Flash->error('No se pudo guardar, Intente nuevamente.',['key' => 'changepass']);
            }
        }
	}
}
