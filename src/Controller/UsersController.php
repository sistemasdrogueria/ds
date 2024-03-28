<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Http\Client;
use Cake\Core\Configure;
use Cake\Mailer\Email;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{

	public function isAuthorized()
	{
		if (in_array($this->request->action, ['index', 'view', 'edit_admin', 'add_admin', 'delete_admin', 'index_search_admin', 'edit','loginValidacion','validateLogin'])) {

			if ($this->request->session()->read('Auth.User.role') == 'admin')
				return true;
			else
				$this->Flash->error(__('No tiene permisos para ingresar'), ['key' => 'changepass']);
			$this->redirect($this->referer());
			return false;
		} else {
			if ($this->request->session()->read('Auth.User.role') == 'client') {
				$tiene = $this->tienepermiso('users', $this->request->action);
				if (!$tiene)
					$this->Flash->error(__('No tiene permisos para ingresar'), ['key' => 'changepass']);
				return $tiene;
			} else {
				if ($this->request->session()->read('Auth.User.role') == 'provider') {
					return false;
				} else {
					if (in_array($this->request->action, ['reset'])) {
						return true;
					} else {
						$this->Flash->error(__('No tiene permisos para ingresar'), ['key' => 'changepass']);
						$this->redirect($this->referer());
						return false;
					}
				}
			}
		}

		return parent::isAuthorized($user);
	}

	public function beforeFilter(Event $event)
	{
		parent::beforeFilter($event);
		// Allow users to register and logout.
		// You should not add the "login" action to allow list. Doing so would
		// cause problems with normal functioning of AuthComponent.
		$this->Auth->allow(['logout', 'loginValidacion', 'mailtosend','validateLogin']);
	}
		private function validateRecaptcha($token)
	{
		$secretKey = Configure::read('Recaptcha.secret_key');

    $client = new Client();

    $response = $client->post('https://www.google.com/recaptcha/api/siteverify', [
        'secret' => '6Lf0c0EUAAAAADy1h9W0s9Sc64TXVI4iNl8v8Ysu',
        'response' => $token
    ]);

	
    if (!$response->isOk()) {
        return ['success' => false, 'message' => 'Error al conectar con el servicio de reCAPTCHA.'];
    }
		$responseData = json_decode($response->body(), true);
  

    if (isset($responseData['success']) && $responseData['success'] === true) {
		
          // Verificar que la puntuación es mayor a 0.5
  return ['success' => true, 'score'=>"",'hostname'=>$responseData['hostname'], 'action'=>""];
      
    } elseif (isset($responseData['error-codes']) && is_array($responseData['error-codes'])) {	
        if (in_array('timeout-or-duplicate', $responseData['error-codes'])) {
            return ['success' => false, 'message' => 'El token de reCAPTCHA ha expirado o es duplicado. Por favor, inténtalo de nuevo.'];
        }
        // Aquí puedes añadir otros códigos de error específicos si es necesario
        return ['success' => false, 'message' => 'Error de reCAPTCHA. Por favor, inténtalo de nuevo.'];
    }

    return ['success' => false, 'message' => 'Error desconocido al validar reCAPTCHA.'];
}

	public function login()
	{
		if ($this->request->is('post')) {
			$recaptchaToken = $this->request->getData('g-recaptcha-response');
			$tokensinrecaptcha = $this->request->getData('tokensinrecatpcha');

			$ip = $this->request->clientIp();
			if (strpos($ip, '200.117.237.178') === 0 || strpos($ip, '200.51.41.202') === 0 ||  strpos($ip, '168.85.96.') === 0) {
			$recaptchaValidation['success'] = true;
			}else{
			$recaptchaValidation = $this->validateRecaptcha($recaptchaToken);

			}
			if(!empty($tokensinrecaptcha)){

				$recaptchaValidation['success'] = true;

				}
						$recaptchaValidation['success'] = true;
		
			if ($recaptchaValidation['success']) {
				$user = $this->Auth->identify();
				if ($user) {
					$this->request->session()->destroy();
					$this->Auth->setUser($user);
					$this->loadModel('LogsAccesos');
					$logsAcceso = $this->LogsAccesos->newEntity();

					$logsAcceso['fecha'] = date('Y-m-d H:i:s');
					//debug(date('Y-m-d H:i:s'));
					$logsAcceso['usuario_id'] = $this->request->session()->read('Auth.User.id');
					$logsAcceso['ip'] = $this->request->clientIp();
					if ($this->LogsAccesos->save($logsAcceso)) {
					}
					$this->loadModel('Clientes');
					$this->loadModel('Localidads');
					$cliente = $this->Clientes->get($this->request->session()->read('Auth.User.cliente_id'));
					$this->request->session()->write('Auth.User.razon', $cliente['razon_social']);
					$this->request->session()->write('Auth.User.codigo', $cliente['codigo']);
					$this->request->session()->write('Auth.User.habilitado', $cliente['habilitado']);
					$this->request->session()->write('Auth.User.coef', $cliente['coeficiente']);
					$this->request->session()->write('Auth.User.condicion', $cliente['condicion_descuento']);
					$this->request->session()->write('Auth.User.codigo_postal', $cliente['codigo_postal']);
					$this->request->session()->write('Auth.User.actualizo_correo', $cliente['actualizo_correo']);
					$this->request->session()->write('Auth.User.cuentaprincipal', $cliente['cuentaprincipal']);
					$this->request->session()->write('Auth.User.grupo', $cliente['grupo_id']);
					$this->request->session()->write('Auth.User.pf_dcto', $cliente['preciofarmacia_descuento']);
					$this->request->session()->write('Auth.User.comunidadsur', $cliente['comunidadsur']);
					$this->request->session()->write('Auth.User.farmapoint', $cliente['farmapoint']);
					$this->request->session()->write('Auth.User.provincia_id', $cliente['provincia_id']);
					$this->request->session()->write('Auth.User.gln', $cliente['gln']);
					$this->request->session()->write('Auth.User.nota_pami', $cliente['nota_pami']);
					$this->request->session()->write('Auth.User.actualizo_ingreso', 0);
					$this->request->session()->write('Auth.User.venta_restringida', $cliente['venta_restringida']);
					$this->request->session()->write('Auth.User.adherido_cofa', $cliente['adherido_cofa']);
					$this->request->session()->write('Auth.User.coef_pyf', $cliente['coef_pyf']);
						if($cliente['conditions']== 1){
								$this->request->session()->write('Auth.User.conditions', 1);
							}else{
								$this->request->session()->write('Auth.User.conditions', 0);
							}
							
					$localidads = $this->Localidads->find()->where(['id' => $cliente['localidad_id']])->first();
					if ($localidads != null) {
						if ($localidads['localidad_id_api'] != null) {
							$this->request->session()->write('Auth.User.localidad_id_meteo', $localidads['localidad_id_api']);
						}
					}
					$this->request->session()->write('creditovisualizar', $cliente['credito_visualizar']);
					if ($this->request->session()->read('Auth.User.perfile_id') == 8)
						return $this->redirect(['controller' => 'Users', 'action' => 'logout']);

					//$this->request->session()->write('Auth.User.restringido',$cliente['restringido']);
					//$this->request->session()->write('Auth.User.restringido_unidades',$cliente['restringido_unidades']);
					//$this->Flash->warning('Bienvenido a Drogueria Sur. Por el momento solo '.$cliente['restringido_unidades'].' unidades x producto(medicamentos). Disculpe las molestias.',['key' => 'changepass']);
					//$this->Flash->warning('Bienvenido a Drogueria Sur S.A.',['key' => 'changepass']);
					/*$this->loadModel('Localidads');
				$localidad= $this->Localidads->get($cliente['localidad_id']);
				$this->request->session()->write('Auth.User.cierre',$localidad['hora']);*/

					$this->request->session()->write('notificacion', $user['notificacion']);
					if ($user['role'] === 'admin') {

						return $this->redirect(['controller' => 'pedidos', 'action' => 'index_admin']);
					} else if ($user['role'] === 'client') {
						if ($this->request->session()->read('Auth.User.perfile_id') == 5)
							return $this->redirect(['controller' => 'catalogos', 'action' => 'revista']);
						else
							return $this->redirect(['controller' => 'carritos', 'action' => 'index']);
					} else if ($user['role'] === 'provider') {
						$this->loadModel('Proveedors');
						$proveedors = $this->Proveedors->get($this->request->session()->read('Auth.User.proveedor_id'));
						$this->request->session()->write('Auth.User.razon', $proveedors['razon_social']);
						$this->request->session()->write('Auth.User.codigo', $proveedors['codigo']);
						$this->request->session()->write('Auth.User.codigo_postal', $proveedors['codigo_postal']);
						$this->request->session()->write('Auth.User.actualizo_correo', $cliente['actualizo_correo']);

						return $this->redirect(['controller' => 'Transfers', 'action' => 'index']);
					} else if ($user['role'] === 'adminR') {

						return $this->redirect(['controller' => 'jobs', 'action' => 'index_admin']);
					} else if ($user['role'] === 'deposit') {

						return $this->redirect(['controller' => 'depositos', 'action' => 'index']);
					}
				} else {
					$ip = $this->request->clientIp();
					if (strpos($ip, '200.117.237.178') === 0 || strpos($ip, '200.51.41.202') === 0 ||  strpos($ip, '168.85.96.') === 0) {
						//$this->request->session()->write('local','SI '.$ip );

						$this->request->data['username'] = 's' . $this->request->data['username'];

						$user = $this->Auth->identify();
						if ($user) {
							$this->request->session()->destroy();
							$this->Auth->setUser($user);
							$this->loadModel('LogsAccesos');
							$logsAcceso = $this->LogsAccesos->newEntity();

							$logsAcceso['fecha'] = date('Y-m-d H:i:s');
							//debug(date('Y-m-d H:i:s'));
							$logsAcceso['usuario_id'] = $this->request->session()->read('Auth.User.id');
							$logsAcceso['ip'] = $this->request->clientIp();
							if ($this->LogsAccesos->save($logsAcceso)) {
							}
							$this->loadModel('Clientes');
							$this->loadModel('Localidads');
							$cliente = $this->Clientes->get($this->request->session()->read('Auth.User.cliente_id'));
							$this->request->session()->write('Auth.User.razon', $cliente['razon_social']);
							$this->request->session()->write('Auth.User.codigo', $cliente['codigo']);
							$this->request->session()->write('Auth.User.habilitado', $cliente['habilitado']);
							$this->request->session()->write('Auth.User.coef', $cliente['coeficiente']);
							$this->request->session()->write('Auth.User.condicion', $cliente['condicion_descuento']);
							$this->request->session()->write('Auth.User.codigo_postal', $cliente['codigo_postal']);
							$this->request->session()->write('Auth.User.actualizo_correo', $cliente['actualizo_correo']);
							$this->request->session()->write('Auth.User.cuentaprincipal', $cliente['cuentaprincipal']);
							$this->request->session()->write('Auth.User.grupo', $cliente['grupo_id']);
							$this->request->session()->write('Auth.User.pf_dcto', $cliente['preciofarmacia_descuento']);
							$this->request->session()->write('Auth.User.comunidadsur', $cliente['comunidadsur']);
							$this->request->session()->write('Auth.User.farmapoint', $cliente['farmapoint']);
							$this->request->session()->write('Auth.User.provincia_id', $cliente['provincia_id']);
							$this->request->session()->write('Auth.User.gln', $cliente['gln']);
							$this->request->session()->write('Auth.User.nota_pami', $cliente['nota_pami']);
							$this->request->session()->write('Auth.User.actualizo_ingreso', 0);
							$this->request->session()->write('Auth.User.venta_restringida', $cliente['venta_restringida']);
							$this->request->session()->write('Auth.User.adherido_cofa', $cliente['adherido_cofa']);
							$this->request->session()->write('Auth.User.coef_pyf', $cliente['coef_pyf']);
							if($cliente['conditions']== 1){
								$this->request->session()->write('Auth.User.conditions', 1);
							}else{
								$this->request->session()->write('Auth.User.conditions', 0);
							}
							
							$localidads = $this->Localidads->find()->where(['id' => $cliente['localidad_id']])->first();
							if ($localidads != null) {
								if ($localidads['localidad_id_api'] != null) {
									$this->request->session()->write('Auth.User.localidad_id_meteo', $localidads['localidad_id_api']);
								}
							}
							$this->request->session()->write('creditovisualizar', $cliente['credito_visualizar']);
							//$this->Flash->warning('Bienvenido a Drogueria Sur S.A.',['key' => 'changepass']);
							//$this->request->session()->write('Auth.User.restringido',$cliente['restringido']);
							//$this->request->session()->write('Auth.User.restringido_unidades',$cliente['restringido_unidades']);
							//$this->Flash->warning('Bienvenido a Drogueria Sur. Por el momento solo '.$cliente['restringido_unidades'].' unidades x producto. Disculpe las molestias.',['key' => 'changepass']);
							/*$this->loadModel('Localidads');
					$localidad= $this->Localidads->get($cliente['localidad_id']);
					$this->request->session()->write('Auth.User.cierre',$localidad['hora']);*/

							$this->request->session()->write('notificacion', $user['notificacion']);
							if ($user['role'] === 'admin') {

								return $this->redirect(['controller' => 'pedidos', 'action' => 'index_admin']);
							} else if ($user['role'] === 'client') {
								if ($this->request->session()->read('Auth.User.perfile_id') == 5)
									return $this->redirect(['controller' => 'catalogos', 'action' => 'revista']);
								else
									return $this->redirect(['controller' => 'carritos', 'action' => 'index']);
							} else if ($user['role'] === 'provider') {
								$this->loadModel('Proveedors');
								$proveedors = $this->Proveedors->get($this->request->session()->read('Auth.User.proveedor_id'));
								$this->request->session()->write('Auth.User.razon', $proveedors['razon_social']);
								$this->request->session()->write('Auth.User.codigo', $proveedors['codigo']);
								$this->request->session()->write('Auth.User.codigo_postal', $proveedors['codigo_postal']);
								$this->request->session()->write('Auth.User.actualizo_correo', $cliente['actualizo_correo']);

								return $this->redirect(['controller' => 'Transfers', 'action' => 'index']);
							} else if ($user['role'] === 'adminR') {

								return $this->redirect(['controller' => 'jobs', 'action' => 'index_admin']);
							} else if ($user['role'] === 'deposit') {

								return $this->redirect(['controller' => 'depositos', 'action' => 'index']);
							}
						} else {
							$this->Flash->error(__('Usuario o Password incorrecto, pruebe nuevamente', ['key' => 'changepass']));
							return $this->redirect($this->referer());
						}
					} else {
						$this->Flash->error(__('Usuario o Password incorrecto, pruebe nuevamente', ['key' => 'changepass']));
						return $this->redirect($this->referer());
					}
				}
			} else {

				$this->loadModel('LogsCatchaFaileds');
				$logscatcha = $this->LogsCatchaFaileds->newEntity();

				//debug(date('Y-m-d H:i:s'));
				$logscatcha['codigo_cliente'] = $this->request->getData('username');
				$logscatcha['ip'] = $this->request->clientIp();
				$logscatcha['status'] = $recaptchaValidation['message'];
			    $logscatcha['host'] = "login";
				if ($this->LogsCatchaFaileds->save($logscatcha)) {
				}
			}
		}
		$this->loadModel('Ofertas');
		$ofertasX = $this->Ofertas->find('all')
			->contain([
				'Articulos', 'articulos.Descuentos' => [
					'queryBuilder' => function ($q) {
						return $q->where([
							'tipo_venta = "D"', 'fecha_hasta >=CURRENT_DATE()', 'tipo_oferta in ("RV","RR","OR","FR","TD","RL")'
						]); // Full conditions for filtering
					}
				]
			])
			->hydrate(false)
			->join(
				[
					'table' => 'descuentos',
					'alias' => 'd',
					'type' => 'left',
					'conditions' => [
						'd.articulo_id = Ofertas.articulo_id',
						'd.tipo_venta = "D"',
						'd.fecha_hasta >=CURRENT_DATE()',
						'd.tipo_oferta in ("RV","RR","OR","TD","RL","FR")'
					]
				]
			)
			->where(['Ofertas.activo=1', 'Ofertas.fecha_hasta >=CURRENT_DATE()', 'ubicacion' => 3])
			->order(['Ofertas.id' => 'DESC'])->limit('4');

		//$ofertasX = $this->Ofertas->find('all')->where(['activo'=>1,'fecha_hasta >=CURRENT_DATE()','ubicacion'=>3])->limit('4');  

		$this->set('ofertasX', $ofertasX->toArray());

		$this->loadModel('Publications');
		$this->set('ipClien',$this->request->clientIp());
		$publications = $this->Publications->find('all')->where(['fecha_hasta >=CURRENT_DATE()', 'habilitada' => '1', 'ubicacion' => '1'])->order(['id' => 'DESC'])->all();
		$this->set('inicio_slider', $publications->toArray());
	}


public function loginValidacion()
		{
			$this->viewBuilder()->layout('vacio');
			$this->loadModel('Clientes');
			if ($this->request->is('ajax')) {
				$user = $this->Auth->identify();
				if ($user) {
					$this->Auth->setUser($user);
					// Respuesta de éxito
					$cliente = $this->Clientes->get($this->request->session()->read('Auth.User.cliente_id'));
					$user = $this->Users->get($this->request->session()->read('Auth.User.id'));
					$tokengenerado = bin2hex(random_bytes(20));
					$user['_token'] = $tokengenerado;

					if ($this->Users->save($user)) {
					}
					$email = ""; // Initialize $email with an empty string

					if (!empty($cliente['email'])) {
						$email = $cliente['email']; // Set to 'email' if it exists
					} elseif (!empty($cliente['email_alternativo'])) {
						$email = $cliente['email_alternativo']; // Set to 'email_alternativo' if 'email' doesn't exist
					}

					if (!empty($email)) {
						$this->Auth->logout();
						echo json_encode(['status' => 'success', 'message' => 'Login successful', 'email' => $email, 'datadi' => $user['id'], 'validate' => $tokengenerado]);
					} else {
						$this->Auth->logout();
						echo json_encode(['status' => 'success', 'message' => 'Login successful', 'email' => '']);
					}
				} else {
					// Respuesta de fallo
					echo json_encode(['status' => 'error', 'message' => 'Username or password is incorrect']);
				}
			}
		}

		public function validateLogin()
		{
			$this->viewBuilder()->layout('vacio');
			$this->loadModel('Clientes');
			$id = $this->request->getData('id');
			$token = $this->request->getData('token');

			if ($this->request->is('ajax')) {
				$user = $this->Users->get($id);
				if ($user['_token'] == $token) {
					echo json_encode(['status' => 'success', 'message' => 'valido']);
				} else {
					echo json_encode(['status' => 'error', 'message' => 'novalido']);
				}
			}
		}

			public  function mailtosend()
		{
			$this->viewBuilder()->layout('vacio');
			$emails =   $this->request->getData('email');
			$id =   $this->request->getData('id');
			//$validate =   $this->request->getData('token');
			$this->loadModel('Clientes');


			$clientes = $this->Clientes
				->find('all')
				->where(['email' => $emails])
				->orWhere(['email_alternativo' => $emails]);
			$tokengenerado = bin2hex(random_bytes(20));
			
			if ($this->request->is('post')) {

				$user = $this->Users->get($id);
				$user['_token'] = $tokengenerado;
				if ($this->Users->save($user)) {

					$email = new Email();
					$email->transport('gmail');
					try {
						/*foreach($arregloemail as $direccion) {
							$res->addTo($direccion);
						}*/
						$res = $email->from(['sistemas@drogueriasur.com.ar' => 'Drogueria Sur S.A.'])
							///->replyTo(['reclamos@drogueriasur.com.ar' => 'Reclamos y devoluciones Drogueria Sur S.A.'])
							->template('email')
							->emailFormat('html')
							->to([$emails])
							//->to([$arregloemail=>$arregloemail])
							//->bcc(["reclamos@drogueriasur.com.ar"=>"reclamos@drogueriasur.com.ar"])
							->subject('Código  Validación')
							->viewVars(['usuario' => $clientes->toArray(), 'codigo' => $tokengenerado])
							->send();
						$enviadomail = 1;
					} catch (Exception $e) {
						echo 'Exception : ',  $e->getMessage(), "\n";
						$enviadomail = 0;
					}
					echo json_encode(['status' => 'success', 'email' => 1]);
				} else {
					echo json_encode(['status' => 'success', 'email' => 0]);
				}
			}
		}
	public function logout()
	{
		return $this->redirect($this->Auth->logout());
	}

	/**
	 * View method
	 *
	 * @param string|null $id User id.
	 * @return void
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */

	public function add_user()
	{
		$this->viewBuilder()->layout('store');
		$user = $this->Users->newEntity();
		if ($this->request->is('post')) {
			$user = $this->Users->patchEntity($user, $this->request->data);
			$user['username'] = $user['username'] . '.' . $this->request->session()->read('Auth.User.username');
			$user['role'] = 'client';
			$user['cliente_id'] = $this->request->session()->read('Auth.User.cliente_id');
			if ($this->Users->save($user)) {
				$this->Flash->success('El usuario creo con exito.', ['key' => 'changepass']);
				return $this->redirect(['controller' => 'clientes', 'action' => 'view']);
			} else {
				$this->Flash->error('El usuario no se guardo. Por favor pruebe nuevamente.', ['key' => 'changepass']);
			}
		}
		$this->loadModel('Proveedors');
		$this->loadModel('Clientes');
		$Clientes = $this->Clientes->find('all')->Select(['id', 'codigo', 'nombre']);
		foreach ($Clientes as $opcion) {
			$clientes[$opcion['id']] = $opcion['codigo'] . ' - ' . $opcion['nombre'];
		}

		/*$this->loadModel('Proveedors');
		$Proveedors = $this->Proveedors->find('all')->Select(['id','codigo','razon_social']);
		foreach ($Proveedors as $opcion) {
			$proveedors[$opcion['id']] = $opcion['codigo'].' - '.$opcion['razon_social'];    
		}*/
		$this->set(compact('user', 'clientes'/*,'proveedors'*/));
		$this->set('_serialize', ['user']);
		$this->set('titulo', 'Agregar Usuario');
		return $this->redirect(['controller' => 'clientes', 'action' => 'view']);
	}
	/**
	 * Edit method
	 *
	 * @param string|null $id User id.
	 * @return void Redirects on successful edit, renders view otherwise.
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */

	public function edit($id = null)
	{
		$this->viewBuilder()->layout('store');
		$user = $this->Users->get($id, [
			'contain' => ['Clientes']
		]);


		if ($this->request->is(['patch', 'post', 'put'])) {
			//$this->data['User']['password'],$this->data['User']['confirm_password'])
			$user = $this->Users->patchEntity($user, $this->request->data);
			$user['username'] = $user['username'] . '.' . $this->request->session()->read('Auth.User.username');

			if ($this->Users->save($user)) {
				$this->Flash->success('El usuario se guardo.', ['key' => 'changepass']);
				return $this->redirect(['controller' => 'clientes', 'action' => 'view']);
			} else {
				$this->Flash->error('El usuario no se guardo. Por favor pruebe nuevamente.', ['key' => 'changepass']);
			}
		}
		$this->loadModel('Clientes');
		$cliente = $this->Clientes->get($this->request->session()->read('Auth.User.cliente_id'), [
			'contain' => ['Provincias', 'Localidads']
		]);

		$users = $this->Users->find('all')
			->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
			->andWhere(['role' => 'client'])
			->andWhere(['perfile_id <>' => $this->request->session()->read('Auth.User.perfile_id')])
			->andWhere(['super <>' => 1]);
		$this->set('users', $users);
		$this->set('cliente', $cliente);
		$this->set('_serialize', ['cliente']);
		$this->loadModel('Perfiles');
		$this->set('perfiles', $this->Perfiles->find('list', ['keyField' => 'id', 'valueField' => 'nombre'])->where(['id<8']));
		//$this->set('perfiles',$this->Perfiles->find('list',['keyField' => 'id','valueField'=>'nombre']));
		$this->set('user', $user);
	}

	public function add()
	{
		$this->viewBuilder()->layout('busquedajax');

		$this->loadModel('Clientes');
		$cliente = $this->Clientes->get($this->request->session()->read('Auth.User.cliente_id'), [
			'contain' => ['Provincias', 'Localidads']
		]);

		$users = $this->Users->find('all')
			->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
			->andWhere(['role' => 'client', 'super <>' => 1]);


		if ($this->request->session()->read('Auth.User.perfile_id') != 1)
			$users->andWhere(['perfile_id <>' => $this->request->session()->read('Auth.User.perfile_id')]);


		$this->set('users', $users);
		$this->set('cliente', $cliente);
		$this->set('_serialize', ['cliente']);
		$this->loadModel('Perfiles');
		if (34526 != $this->request->session()->read('Auth.User.cliente_id'))
			$this->set('perfiles', $this->Perfiles->find('list', ['keyField' => 'id', 'valueField' => 'nombre'])->where(['id<8']));
		else
			$this->set('perfiles', $this->Perfiles->find('list', ['keyField' => 'id', 'valueField' => 'nombre']));
	}


	public function change_password()
	{
		$this->viewBuilder()->layout('busquedajax');
		$this->loadModel('Clientes');
		$cliente = $this->Clientes->get($this->request->session()->read('Auth.User.cliente_id'), [
			'contain' => ['Provincias', 'Localidads']
		]);
		/*$user = $this->Users->get($this->request->session()->read('Auth.User.id'), [
            'contain' => ['clientes']
        ]);*/
		$this->set(compact('cliente'));
		if ($this->request->is(['patch', 'post', 'put'])) {
			//Se verifican 2 cosas: 
			//  1º Si la clave actual proporcionada coincide con la del usuario registrado 	
			//  2º Si la clave nueva coincide con la confirmación				
			if (
				empty($this->request->data['current_password']) &&
				empty($this->request->data['password']) &&
				empty($this->request->data['confirm_new_password'])
			) {
				$this->Flash->error('Ingrese los campos correctamente', ['key' => 'changepass']);  //,['key' => 'changepass']
			} else {
				//paso 1    
				//$user = $this->Users->patchEntity($user, $this->request->data);
				$user = $this->Auth->identify();
				if ($user) {
					// paso 2
					if ($this->request->data['current_password'] == $this->request->data['confirm_new_password']) {
						$user2 = $this->Users->get($this->request->session()->read('Auth.User.id'));
						$user2 = $this->Users->patchEntity($user2, $this->request->data);
						$user2['password'] = $this->request->data['current_password'];
						if ($this->Users->save($user2)) {
							$this->Flash->success('El usuario se guardo.', ['key' => 'changepass']);
							return $this->redirect(['controller' => 'clientes', 'action' => 'view']);
						} else {
							$this->Flash->error('El usuario no se guardo. Por favor pruebe nuevamente.', ['key' => 'changepass']); //,['key' => 'changepass']
						}
					} else {
						$this->Flash->error('Las contraseñas no son iguales, vuelva a escribirlas', ['key' => 'changepass']);
						//$this->Session->setFlash(__('<div class="success canhide">El usuario fue guardado correctamente.</div>', true));
					}
				} else {
					$this->Flash->error('La contraseña actual no es correcta, vuelva a intentar', ['key' => 'changepass']);
				}
			}
		}
		//  $this->set(compact('user'));
		$this->set('_serialize', ['user']);
		//$this->set('titulo','Editar Usuario');
	}
	/**
	 * Delete method
	 *
	 * @param string|null $id User id.
	 * @return void Redirects to index.
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */
	public function delete($id = null)
	{
		$this->request->allowMethod(['post', 'delete']);
		$user = $this->Users->get($id);
		if ($this->Users->delete($user)) {
			$this->Flash->success('El usuario se elimino correctamente.', ['key' => 'changepass']);
		} else {
			$this->Flash->error('El usuario no se elimino. Por favor pruebe nuevamente.', ['key' => 'changepass']);
		}
		return $this->redirect($this->referer());
	}

	/**
	 * Index method
	 *
	 * @return void
	 */
	public function index()
	{
		$this->viewBuilder()->layout('admin');
		$this->paginate = [
			'contain' => ['Clientes'],
			'limit' => 200,

			'order' => ['Users.id' => 'DESC']
		];
		$this->set('users', $this->paginate($this->Users));
		$this->set('_serialize', ['users']);
		$this->set('titulo', 'Lista de Usuarios');
	}

	public function index_search_admin()
	{
		$this->viewBuilder()->layout('admin');


		if ($this->request->is('post')) {
			$this->paginate = [
				'contain' => ['Clientes'], 'limit' => 200,
			];
			$termsearch = "";
			if ($this->request->data['termino'] != null) {
				$terminocompleto = explode(" ", $this->request->data['termino']);

				if (count($terminocompleto) > 1) {
					foreach ($terminocompleto as $terminosimple) :
						$termsearch = $termsearch . '%' . $terminosimple . '%';
					endforeach;
				} else
					if (is_numeric($terminocompleto[0]))
					$termsearch = $terminocompleto[0];
				else
					$termsearch = '%' . $terminocompleto[0] . '%';
			}

			if (is_numeric($termsearch))
				$result = $this->Users->find('all')->where(['username =' => $termsearch]);

			else {
				$result = $this->Users->find('all')
					->hydrate(false)
					->join(
						[
							'table' => 'clientes',
							'alias' => 'c',
							'type' => 'LEFT',
							'conditions' => [
								'c.id = Users.cliente_id'
							]
						]
					)
					->where([
						'OR' => [
							['username LIKE' => $termsearch],
							['c.razon_social LIKE' => $termsearch]
						]
					]);
			}

			$this->set('users', $this->paginate($result));
			$this->set('_serialize', ['users']);
		}


		$this->set('titulo', 'Lista de Usuarios');
	}

	/**
	 * View method
	 *
	 * @param string|null $id User id.
	 * @return void
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */
	public function view_admin($id = null)
	{
		$this->viewBuilder()->layout('admin');
		$user = $this->Users->get($id, [
			'contain' => []
		]);
		$this->set('user', $user);
		$this->set('_serialize', ['user']);
		$this->set('titulo', 'Ver Usuario');
	}

	/**
	 * Add method
	 *
	 * @return void Redirects on successful add, renders view otherwise.
	 */
	public function add_admin()
	{
		$this->viewBuilder()->layout('admin');
		$user = $this->Users->newEntity();
		if ($this->request->is('post')) {
			$user = $this->Users->patchEntity($user, $this->request->data);
			if ($this->Users->save($user)) {
				$this->Flash->success('El usuario creo con exito.', ['key' => 'changepass']);
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error('El usuario no se guardo. Por favor pruebe nuevamente.', ['key' => 'changepass']);
			}
		}

		$this->loadModel('Clientes');
		$Clientes = $this->Clientes->find('all')->Select(['id', 'codigo', 'nombre'])
			->order(['id' => 'DESC']);

		foreach ($Clientes as $opcion) {

			$clientes[$opcion['id']] = $opcion['codigo'] . ' - ' . $opcion['nombre'];
		}
		$this->loadModel('Perfiles');
		$this->set('perfiles', $this->Perfiles->find('list', ['keyField' => 'id', 'valueField' => 'nombre']));

		$this->set(compact('user', 'clientes'));
		$this->set('_serialize', ['user']);
		$this->set('titulo', 'Agregar Usuario');
	}

	public function add_user_admin()
	{
		$this->viewBuilder()->layout('store');
		$user = $this->Users->newEntity();
		if ($this->request->is('post')) {
			$user = $this->Users->patchEntity($user, $this->request->data);
			$user['username'] = $user['username'] . '.' . $this->request->session()->read('Auth.User.username');
			$user['role'] = 'client';
			$user['cliente_id'] = $this->request->session()->read('Auth.User.cliente_id');
			if ($this->Users->save($user)) {
				$this->Flash->success('El usuario creo con exito.', ['key' => 'changepass']);
				return $this->redirect(['controller' => 'clientes', 'action' => 'view']);
			} else {
				$this->Flash->error('El usuario no se guardo. Por favor pruebe nuevamente.', ['key' => 'changepass']);
			}
		}
		$this->loadModel('Proveedors');
		$this->loadModel('Clientes');
		$Clientes = $this->Clientes->find('all')->Select(['id', 'codigo', 'nombre']);
		foreach ($Clientes as $opcion) {
			$clientes[$opcion['id']] = $opcion['codigo'] . ' - ' . $opcion['nombre'];
		}

		$Proveedors = $this->Proveedors->find('all')->Select(['id', 'codigo', 'razon_social']);
		foreach ($Proveedors as $opcion) {
			$proveedors[$opcion['id']] = $opcion['codigo'] . ' - ' . $opcion['razon_social'];
		}
		$this->set(compact('user', 'clientes', 'proveedors'));
		$this->set('_serialize', ['user']);
		$this->set('titulo', 'Agregar Usuario');
		return $this->redirect(['controller' => 'clientes', 'action' => 'view']);
	}
	/**
	 * Edit method
	 *
	 * @param string|null $id User id.
	 * @return void Redirects on successful edit, renders view otherwise.
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */
	public function edit_admin($id = null)
	{
		$this->viewBuilder()->layout('admin');
		$user = $this->Users->get($id, [
			'contain' => []
		]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			//$this->data['User']['password'],$this->data['User']['confirm_password'])
			$user = $this->Users->patchEntity($user, $this->request->data);

			if ($this->Users->save($user)) {
				$this->Flash->success('El usuario se guardo.', ['key' => 'changepass']);
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error('El usuario no se guardo. Por favor pruebe nuevamente.', ['key' => 'changepass']);
			}
		}
		$this->loadModel('Clientes');
		$Clientes = $this->Clientes->find('all')->Select(['id', 'codigo', 'nombre']);
		foreach ($Clientes as $opcion) {

			$clientes[$opcion['id']] = $opcion['codigo'] . ' - ' . $opcion['nombre'];
		}
		$this->set(compact('user', 'clientes'));
		$this->set('_serialize', ['user']);
		$this->set('titulo', 'Editar Usuario');
	}



	public function change_password_admin()
	{
		$this->viewBuilder()->layout('store');
		$this->loadModel('Clientes');
		$cliente = $this->Clientes->get($this->request->session()->read('Auth.User.cliente_id'), [
			'contain' => ['Provincias', 'Localidads']
		]);
		/*$user = $this->Users->get($this->request->session()->read('Auth.User.id'), [
            'contain' => ['clientes']
        ]);*/
		$this->set(compact('cliente'));
		if ($this->request->is(['patch', 'post', 'put'])) {
			//Se verifican 2 cosas: 
			//  1º Si la clave actual proporcionada coincide con la del usuario registrado 	
			//  2º Si la clave nueva coincide con la confirmación				
			if (
				empty($this->request->data['current_password']) &&
				empty($this->request->data['password']) &&
				empty($this->request->data['confirm_new_password'])
			) {
				$this->Flash->error('Ingrese los campos correctamente', ['key' => 'changepass']);  //,['key' => 'changepass']
			} else {
				//paso 1    
				//$user = $this->Users->patchEntity($user, $this->request->data);
				$user = $this->Auth->identify();
				if ($user) {
					// paso 2
					if ($this->request->data['current_password'] == $this->request->data['confirm_new_password']) {
						$user2 = $this->Users->get($this->request->session()->read('Auth.User.id'));
						$user2 = $this->Users->patchEntity($user2, $this->request->data);
						$user2['password'] = $this->request->data['current_password'];
						if ($this->Users->save($user2)) {
							$this->Flash->success('El usuario se guardo.', ['key' => 'changepass']);
							return $this->redirect(['controller' => 'clientes', 'action' => 'view']);
						} else {
							$this->Flash->error('El usuario no se guardo. Por favor pruebe nuevamente.', ['key' => 'changepass']); //,['key' => 'changepass']
						}
					} else {
						$this->Flash->error('Las contraseñas no son iguales, vuelva a escribirlas', ['key' => 'changepass']);
						//$this->Session->setFlash(__('<div class="success canhide">El usuario fue guardado correctamente.</div>', true));
					}
				} else {
					$this->Flash->error('La contraseña actual no es correcta, vuelva a intentar', ['key' => 'changepass']);
				}
			}
		}
		$this->set(compact('user'));
		$this->set('_serialize', ['user']);
		//$this->set('titulo','Editar Usuario');
	}
	/**
	 * Delete method
	 *
	 * @param string|null $id User id.
	 * @return void Redirects to index.
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */
	public function delete_admin($id = null)
	{
		$this->request->allowMethod(['post', 'delete']);
		$user = $this->Users->get($id);
		if ($this->Users->delete($user)) {
			$this->Flash->success('El usuario se elimino correctamente.');
		} else {
			$this->Flash->error('El usuario no se elimino. Por favor pruebe nuevamente.');
		}
		return $this->redirect(['action' => 'index']);
	}

	public function reset($token = null, $id = null)
	{
		//$token=$this->params['url']['v1'];
		//$id=$this->params['url']['v2'];


		$this->viewBuilder()->layout('default');
		$this->request->session()->write('parametros', $this->request->params['pass']);

		/*$this->loadModel('Clientes');
		$cliente = $this->Clientes->find($id, [
            'contain' => []
        ]);*/
		//$user = $this->Users->get($id);

		$user = $this->Users->find('all')
			->where(['id' => $id])
			->first();
		//$this->set(compact('cliente'));
		if ($this->request->is(['patch', 'post', 'put'])) {
			//Se verifican 2 cosas: 
			//  1º Si la clave actual proporcionada coincide con la del usuario registrado 	
			//  2º Si la clave nueva coincide con la confirmación				
			if (
				empty($this->request->data['current_password']) &&
				empty($this->request->data['password']) &&
				empty($this->request->data['confirm_new_password'])
			) {
				$this->Flash->error('Ingrese los campos correctamente', ['key' => 'changepass']);  //,['key' => 'changepass']
			} else {
				//paso 1    
				//$user = $this->Users->patchEntity($user, $this->request->data);
				//$user = $this->Auth->identify();
				if ($user) {
					// paso 2
					/* if  ($this->request->data['current_password'] == $this->request->data['confirm_new_password']) 
                    {
						    $user2 = $this->Users->get($this->request->session()->read('Auth.User.id'));
						    $user2 = $this->Users->patchEntity($user2, $this->request->data);
							$user2['password']=$this->request->data['current_password'];
 						    if ($this->Users->save($user2)) {
								$this->Flash->success('El usuario se guardo.',['key' => 'changepass']);
								return $this->redirect(['controller'=>'clientes','action' => 'view']);
							} else {
								$this->Flash->error('El usuario no se guardo. Por favor pruebe nuevamente.',['key' => 'changepass']);//,['key' => 'changepass']
							}
                    }
                    
                     else
                     {
                          $this->Flash->error('Las contraseñas no son iguales, vuelva a escribirlas',['key' => 'changepass']);
                          //$this->Session->setFlash(__('<div class="success canhide">El usuario fue guardado correctamente.</div>', true));
                     }
*/
				} else {
					$this->Flash->error('La contraseña actual no es correcta, vuelva a intentar', ['key' => 'changepass']);
				}
			}
		}
		$this->set(compact('user'));
		$this->set('_serialize', ['user']);
	}
}
