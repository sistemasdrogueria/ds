<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Http\Client;

/**
 * Estados Controller
 *
 * @property \App\Model\Table\EstadosTable $Estados
 */
class DescargasController extends AppController
{
		public function initialize(){
        parent::initialize();
        
        // Include the FlashComponent
        $this->loadComponent('Flash');
        // Load Files model
        $this->loadModel('Files');

    }

	public function isAuthorized()
    {
		if (in_array($this->request->action,['index','revista','catalogo','descargarlistado','descargar','descargarformato','excel','revistadownload','archivo','index_admin','subirarchivo','add_admin','edit_admin','delete_admin'])) {
		
				if($this->request->session()->read('Auth.User.role')=='admin') 
				{				
					return true;			
				}			
				else 
				{	
					if($this->request->session()->read('Auth.User.role')=='client') 
					{	
						$tiene= $this->tienepermiso('descargas',$this->request->action);
						if (!$tiene)
							$this->Flash->error(__('No tiene permisos para ingresar'),['key' => 'changepass']);
						return $tiene;			
					}	
					else
					{
						if($this->request->session()->read('Auth.User.role')=='provider') 
						{				
							return false;			
						}
						else
						{
							$this->Flash->error(__('No tiene permisos para ingresar'),['key' => 'changepass']);
							return false;	
						}	
					}	
				}		
            }		
		else 
			{			    		
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
		$this->viewBuilder()->layout('store');
		
    }
	
	 public function archivo()
    {
      
		$this->loadModel('ClientesNovedades');
		
		$clientesnovedades = $this->ClientesNovedades->find('all')->where(['clientes_novedades_tipos_id = 11'])->order(['fecha'=>'DESC']);
		$this->set('clientesnovedades',$clientesnovedades->toArray());

		$this->viewBuilder()->layout('store');
		
    }
	public function catalogo()
    {
        
		$this->viewBuilder()->layout('store');
		
    }
	
	public function revista()
    {
        $this->viewBuilder()->layout('magazine');
		
		
    }
	
	public function descargarlistado($opcion=null)
	{
		
			if ($opcion==1)
			{
				$name= "aumentos";	
				$tipo="txt";				
			}
			if ($opcion==2)
			{
				$name= "descuentosptm";
				$tipo="txt";
			}
			if ($opcion==3)
			{
				$name= "articulos";
				$tipo="zip";
			}
				$direccion = 'http://200.117.237.178:8080/down/arch/'.$name.'.'.$tipo;
								
				$servidor = $_SERVER['SERVER_NAME'];
				if ($servidor==="www.drogueriasur.com.ar" || $servidor==="drogueriasur.com.ar")
				$direccion2 = $_SERVER['DOCUMENT_ROOT'] . 'ds/webroot/file/'. $name.'.'.$tipo;
				else
				$direccion2 = $_SERVER['DOCUMENT_ROOT'] . '/webroot/file/'. $name.'.'.$tipo;
				
				$context = stream_context_create(array('http' => array('method' => 'HEAD')));
				$remoteFileHeaders = get_headers($direccion, 1, $context);
				
				// Verifica si se pudo obtener la información del encabezado
				if ($remoteFileHeaders !== false && isset($remoteFileHeaders['Last-Modified'])) {
					// Obtiene la fecha de modificación del encabezado HTTP
					$fecha_modificacion_remota = strtotime($remoteFileHeaders['Last-Modified']);
					
					// Formatea la fecha de modificación según tus preferencias
					$fecha_modificacion_formateada = date("Y-m-d_H:i", $fecha_modificacion_remota);
					
					// Ahora puedes utilizar $fecha_modificacion_formateada o $fecha_modificacion_remota en tu aplicación
					
				} else {
			
				}
				
			
			if ( copy($direccion, $direccion2) ) {
				$nombre_archivo_fecha = $name.'_'.$fecha_modificacion_formateada.'.'.$tipo;
			}else{
				
				$nombre_archivo_fecha = $name.'_'.$fecha_modificacion_formateada.'.'.$tipo;
			}
			$this->response->type($tipo);
			
			$this->response->file($direccion2,['download' => true, 'name' => $nombre_archivo_fecha]);

			return $this->response;
			
	}
		
	public function descargarformato($opcion=null)
	{

		switch ($opcion) {
			case 1:
			$name= "Formato_Factura_Digital_v1.pdf";	
			$tipo="pdf";
			break;
			case 2:
			$name= "Formato_Factura_Digital_v2.pdf";
			$tipo="pdf";
			break;
			case 3:
			$name= "Formato_Pedido_Respuesto_Falta.pdf";
			$tipo="pdf";
			break;
			case 4:
			$name= "Formato_Trazabilidad.pdf";
			$tipo="pdf";
			break;
			case 5:
			$name= "Formato_Producto.pdf";
			$tipo="pdf";
			break;
			case 6:
			$name= "Manual_Procedimiento_Ticket.pdf";
			$tipo="pdf";
			break;
			case 7:
			$name= "Formato_Notas_Digital.pdf";
			$tipo="pdf";
			break;

		}

		//$direccion = 'http://200.117.237.178:8080/down/arch/'.$name;
		$servidor = $_SERVER['SERVER_NAME'];
		if ($servidor==="www.drogueriasur.com.ar" || $servidor==="drogueriasur.com.ar")
		
		$direccion2 = $_SERVER['DOCUMENT_ROOT'] . '/ds/webroot/file/'. $name;
		else
		$direccion2 = $_SERVER['DOCUMENT_ROOT'] . '/webroot/file/'. $name;
		
		/*if ( copy($direccion, $direccion2) ) {
			
		}else{
			
		}*/
		$this->response->type($tipo);
		
		$this->response->file($direccion2,['download' => true, 'name' => $name]);

		return $this->response;
		
	}
	
	public function descargar($archivo = null, $tipo = null)
	{
			//$this->request->session()->write('SERVER',$_SERVER['SERVER_NAME']);$this->request->session()->write('DOCUMENT_ROOT',$_SERVER['DOCUMENT_ROOT']);
			$servidor = $_SERVER['SERVER_NAME'];
				if ($servidor==="www.drogueriasur.com.ar" || $servidor==="drogueriasur.com.ar")
				$direccion2 = $_SERVER['DOCUMENT_ROOT'] . '/ds/webroot/file/'. $archivo;
				else
				$direccion2 = $_SERVER['DOCUMENT_ROOT'] . '/webroot/file/'. $archivo;
				
				$this->response->type($tipo);
				
				$this->response->file($direccion2,['download' => true, 'name' => $archivo]);
	
				return $this->response;

		}

	public function categoriaylaboratorio()
	{
		$this->loadModel('Categorias');
		$this->loadModel('Laboratorios');
		if ($this->request->session()->read('Categorias')== null)
		{
	
		$categorias = $this->Categorias->find('list',['keyField' => 'id','valueField'=>'nombre']);

		$this->request->session()->write('Categorias',$categorias->toArray());
			
		}
		else{
			
			//$laboratorios =$this->request->session()->read('Laboratorios');
			$categorias = $this->request->session()->read('Categorias');
		}	
		$laboratorios = $this->Laboratorios->find('list',['keyField' => 'id','valueField'=>'nombre'])->order(['id' => 'ASC']);
		$this->request->session()->write('Laboratorios',$laboratorios ->toArray());
		$this->set('categorias',$categorias );
		$this->set('laboratorios',$laboratorios->toArray());
		
	}
	
private function validateRecaptcha($token)
	{
		$secretKey = Configure::read('Recaptcha.secret_key');
    $client = new Client();

    $response = $client->post('https://www.google.com/recaptcha/api/siteverify', [
        'secret' => $secretKey,
        'response' => $token
    ]);
		
    if (!$response->isOk()) {
        return ['success' => false, 'message' => 'Error al conectar con el servicio de reCAPTCHA.'];
    }
		$responseData = json_decode($response->body(), true);
  
    
    if (isset($responseData['success']) && $responseData['success'] === true) {
		
          // Verificar que la puntuación es mayor a 0.5
        if (isset($responseData['score']) && $responseData['score'] > 0.5) {

            return ['success' => true,'score'=>$responseData['score'],'hostname'=>$responseData['hostname'], 'action'=>$responseData['action']];
        } else {
            // Si la puntuación es 0.5 o menos, asumir que podría ser un bot
            return ['success' => false, 'message' => 'La puntuación de reCAPTCHA indica que podrías ser un bot.'];
        }
    } elseif (isset($responseData['error-codes']) && is_array($responseData['error-codes'])) {	
        if (in_array('timeout-or-duplicate', $responseData['error-codes'])) {
            return ['success' => false, 'message' => 'El token de reCAPTCHA ha expirado o es duplicado. Por favor, inténtalo de nuevo.'];
        }
        // Aquí puedes añadir otros códigos de error específicos si es necesario
        return ['success' => false, 'message' => 'Error de reCAPTCHA. Por favor, inténtalo de nuevo.'];
    }

    return ['success' => false, 'message' => 'Error desconocido al validar reCAPTCHA.'];
}
	
	public function excel($cat = null){
		$recaptchaToken = $this->request->getData('recaptcha');
		$recaptchaValidation = $this->validateRecaptcha($recaptchaToken);
		if ($recaptchaValidation['success']) {
			if ($recaptchaValidation['score'] > 0.5) {
		
		set_time_limit(300);
		$this->viewBuilder()->layout('ajax');	
		$this->loadModel('Articulos');
		$cat = $this->request->data['cat'];
		if(!empty($cat))
		{
		if ($cat == 2)
		$query = $this->Articulos->find('all')	
					->select(['troquel','descripcion_sist','categoria_id','codigo_barras','codigo_barras2','codigo_barras3',
						'precio_publico','precio_final','stock','iva','clave_amp','pack','eliminado','laboratorio_id','precio_actualizacion'])	
					->where(['categoria_id>2','categoria_id<6','eliminado'=>0]);
		else
		$query = $this->Articulos->find('all')	
					->select(['troquel','descripcion_sist','categoria_id','codigo_barras','codigo_barras2','codigo_barras3',
						'precio_publico','precio_final','stock','iva','clave_amp','pack','eliminado','laboratorio_id','precio_actualizacion'])	
					->where(['eliminado'=>0]);
		}
		if ($query!=null)
		
			$articulos = $query->toArray();
		
		else
			$articulos = null;
	
		$this->categoriaylaboratorio();
		$this->set('articulos',$articulos);
		$this->response->type('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		}else {
			$this->Flash->error('Fallo el reCAPTCHA, recargue la pagina e intente nuevamente.');
			$error = "";
		}
		}else{
			 
				$this->loadModel('LogsCatchaFaileds');
					$logscatcha = $this->LogsCatchaFaileds->newEntity();
					//debug(date('Y-m-d H:i:s'));
					$logscatcha['codigo_cliente'] = $this->request->session()->read('Auth.User.codigo');
					$logscatcha['ip'] = $this->request->clientIp();
					$logscatcha['status'] = $recaptchaValidation['message'];
					$logscatcha['host'] = "descargas";
					if ($this->LogsCatchaFaileds->save($logscatcha)) {
					}

		
		}
		}
	
	public function revistadownload(){
		$this->response->type('pdf');

			// Optionally force file download
			//
			//
			//$this->response->file('temp'. DS .'DETFAC'.$codigo.'.TXT');
			$this->response->file(
			'file'. DS .'Revista_Octubre_2015.pdf',
			['download' => true, 'name' => 'Revista_Octubre_2015.pdf']
			);

			return $this->response;
			
			//return $this->redirect($this->referer());
		
	}
    /**
     * View method
     *
     * @param string|null $id Estado id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        
    }

    /**
     * Edit method
     *
     * @param string|null $id Estado id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        
    }

    /**
     * Delete method
     *
     * @param string|null $id Estado id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
       
    }
	
	public function edit_admin($id = null)
 {
		$this->viewBuilder()->layout('admin');
        $file = $this->Files->get($id, [
            'contain' => []
        ]);

		if ($this->request->is(['patch', 'post', 'put'])) {
            $file = $this->Files->patchEntity($file, $this->request->data);
			
			$uploadData = '';
			if(!empty($this->request->data['file']['name'])){
                $fileName = $this->request->data['file']['name'];
                $uploadPath = 'img/ofertas/';
                
                $uploadFile = $uploadPath.'thumb_'.$fileName;
				
                if(move_uploaded_file($this->request->data['file']['tmp_name'],$uploadFile)){
                    $file->name = $fileName;
                    $file->path = $uploadPath;
                    $file->modified = date("Y-m-d H:i:s");
                    if ($this->Files->save($file)) {
                        $this->Flash->success(__('Se guardo correctamente'),['key' => 'changepass']);
                    }else{
                        $this->Flash->error(__('No se pudo guardar correctamente.'),['key' => 'changepass']);
						$this->redirect($this->referer());
                    }
                }else{
                    $this->Flash->error(__('No se pudo subir el archivo.'),['key' => 'changepass']);
					$this->redirect($this->referer());
                }
            }

        }
        $this->set(compact('file'));
        $this->set('_serialize', ['file']);
		$this->set('titulo','Modificar file');
    }

	
	public function delete_admin($id = null)
	{
		$this->viewBuilder()->layout('admin');
        $this->request->allowMethod(['post', 'delete']);
        $file = $this->Files->get($id);
        if ($this->Files->delete($file)) {
            $this->Flash->success(__('Se borro correstamente.'),['key' => 'changepass']);
			return $this->redirect(['action' => 'index_admin']);
        } else {
            $this->Flash->error(__('No se pudo eliminar, intente nuevamente.'),['key' => 'changepass']);
			return $this->redirect(['action' => 'index_admin']);
        }
        
    }
	
	public function add_admin()
	{
		$this->viewBuilder()->layout('admin');
		$this->set('titulo','Subir archivos de Descargas');
	}
	
	public function index_admin()
	{
		$this->viewBuilder()->layout('admin');
		$this->paginate = [
			'limit' => 100,
		];
		$files=$this->Files->find('all')->where(['status >'=>1]);
		
		$this->set('files',$this->paginate($files));
		/*
		$uploads_dir = '/uploads';
		foreach ($_FILES["pictures"]["error"] as $key => $error) {
			if ($error == UPLOAD_ERR_OK) {
				$tmp_name = $_FILES["pictures"]["tmp_name"][$key];
				// basename() puede evitar ataques de denegación de sistema de ficheros;
				// podría ser apropiada más validación/saneamiento del nombre del fichero
				$name = basename($_FILES["pictures"]["name"][$key]);
				move_uploaded_file($tmp_name, "$uploads_dir/$name");
			}
		}
		*/
		/*if ($this->request->is(['patch', 'post', 'put'])) {
		$uploadData = '';
			if(!empty($this->request->data['file']['name'])){
                $fileName = $this->request->data['file']['name'];
                $uploadPath = 'img/ofertas/';
                
                $uploadFile = $uploadPath.'thumb_'.$fileName;
				$oferta['imagen']= $fileName;
                if(move_uploaded_file($this->request->data['file']['tmp_name'],$uploadFile)){
                    $uploadData = $this->Files->newEntity();
                    $uploadData->name = $fileName;
                    $uploadData->path = $uploadPath;
                    $uploadData->created = date("Y-m-d H:i:s");
                    $uploadData->modified = date("Y-m-d H:i:s");
					$uploadData->status = 2;
                    if ($this->Files->save($uploadData)) {
                        //$this->Flash->success(__('File has been uploaded and inserted successfully.'),['key' => 'changepass']);
                    }else{
                        $this->Flash->error(__('Unable to upload file, please try again.'),['key' => 'changepass']);
						$this->redirect($this->referer());
                    }
                }else{
                    $this->Flash->error(__('Unable to upload file, please try again.'),['key' => 'changepass']);
					$this->redirect($this->referer());
                }
            }
		}
		*/
		$this->set('titulo','Administrador de archivos de Descargas');
	}
	
	public function subirarchivo($opcion=null)
	{
		
		if ($this->request->is(['patch', 'post', 'put'])) {
		$uploadData = '';
			if(!empty($this->request->data['file']['name'])){
                $fileName = $this->request->data['file']['name'];
                
				$uploadPath = 'descargas/';
				
			
                $uploadFile = $uploadPath.$fileName;
				$oferta['imagen']= $fileName;
                if(move_uploaded_file($this->request->data['file']['tmp_name'],$uploadFile)){
                    $uploadData = $this->Files->newEntity();
                    $uploadData->name = $fileName;
                    $uploadData->path = $uploadPath;
					$uploadData->descripcion = $this->request->data['descripcion'];
                    $uploadData->created = date("Y-m-d H:i:s");
                    $uploadData->modified = date("Y-m-d H:i:s");
					$uploadData->status = $this->request->data['status'];
                    if ($this->Files->save($uploadData)) {
                        $this->Flash->success(__('File has been uploaded and inserted successfully.'),['key' => 'changepass']);
						$this->redirect($this->referer());
                    }else{
                        $this->Flash->error(__('Unable to upload file, please try again.'),['key' => 'changepass']);
						$this->redirect($this->referer());
                    }
                }else{
                    $this->Flash->error(__('Unable to upload file, please try again.'),['key' => 'changepass']);
					$this->redirect($this->referer());
                }
            }
		}
	}
	
}
