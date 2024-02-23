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
 * Novedades Controller
 *
 * @property \App\Model\Table\NovedadesTable $Novedades
 */
class NovedadesController extends AppController
{
		public function initialize(){
        parent::initialize();
        
        // Include the FlashComponent
        $this->loadComponent('Flash');
        // Load Files model
        $this->loadModel('Files');

    }
	
	 public function beforeFilter(Event $event)
    {
       // allow all action
        $this->Auth->allow(['exposur','view','condiciones']);
    }
	
	public function isAuthorized()
    {
     

	 
		 if (in_array($this->request->action, ['comunicado','edit', 'delete','add','index','delete_admin','index_admin','add_admin','edit_admin','view_admin','patagoniamed','ofertasperfumeria','promoespecial2','noticia','promoespecial','promoespecialdownload','catalogo','perfumeria','exhibidores','eventos'])) {
       
            if($this->request->session()->read('Auth.User.role')=='admin') 
            {				
                return true;			
            }			
            else {	
                if($this->request->session()->read('Auth.User.role')=='client') 
                {	
					
						$tiene= $this->tienepermiso('novedades',$this->request->action);
						if (!$tiene)
							$this->Flash->error(__('No tiene permisos para ingresar'),['key' => 'changepass']);
						return $tiene;			
                }	
                else {
					if($this->request->session()->read('Auth.User.role')=='provider') 
					{
						$this->Flash->error(__('No tiene permisos para ingresar'),['key' => 'changepass']);
						$this->redirect(['controller' => 'carritos', 'action' => 'index']);	
						return false;						
					}
					else {
						$this->Flash->error(__('No tiene permisos para ingresar'),['key' => 'changepass']);
						
						$this->redirect(['controller' => 'Pages', 'action' => 'home']);
						return false;	
					}
                    
                }	
            }		
            }		
			else 
			{
				if (in_array($this->request->action, ['view']))
				{
					return true;
				}
				else
				{
					$this->Flash->error(__('No tiene permisos para ingresar'));		
					$this->redirect(['controller' => 'Pages', 'action' => 'home']);  		
					return false;	
				}
			}
		return parent::isAuthorized($user);
    }

	
    public function eventos(){
		$this->viewBuilder()->layout('store');
    }
    
	public function exposur(){
		$this->viewBuilder()->layout('store');
	}
  /**
     * Index method
     *
     * @return void
     */
    public function comunicado()
    {
		$this->viewBuilder()->layout('store');
		
		$this->loadModel('Users');
		
		$user = $this->Users->get($this->request->session()->read('Auth.User.id'), [
            'contain' => ['Clientes']
        ]);
		
		
		$user['notificacion'] = 0;
		$this->Users->save($user);
		$this->request->session()->write('notificacion',0);
        $this->set('novedades', $this->paginate(
		$this->Novedades->find()
		->where(['activo' =>'1'])
		->andWhere(['interno' =>'1'])
		->order(['id' => 'DESC'])
		));
		$novedades2 = $this->Novedades->find()
		->where(['activo' =>'1'])
		->andWhere(['interno' =>'0'])
		->order(['id' => 'DESC']);
		$this->set('novedades2', $novedades2);
        $this->set('_serialize', ['novedades']);
		$this->set('titulo','Listado de Noticias');
    }

	public function catalogo(){
		$this->viewBuilder()->layout('store');
		
	}
	


	
	 public function ofertasperfumeria()
    {
		$this->viewBuilder()->layout('store');
       
    }

	 public function promoespecial()
    {
		$this->viewBuilder()->layout('magazine2');
       
    }
	
	 public function promoespecial2()
    {
		$this->viewBuilder()->layout('magazine3');
       
    }
	
	public function promoespecialdownload(){
		$this->response->type('xlsx');

			// Optionally force file download
			//
			//
			//$this->response->file('temp'. DS .'DETFAC'.$codigo.'.TXT');
			
			$this->response->file(
			'file'. DS .'Catalogo_Solares_17-18.xlsx',
			['download' => true, 'name' => 'Catalogo_Solares_17.xlsx']
			);

			return $this->response;
			
			return $this->redirect($this->referer());
		
	}
	
    /**
     * View method
     *
     * @param string|null $id Novedade id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    
    
    public function view($id = null)
    {
		$this->viewBuilder()->layout('default');
        $novedade = $this->Novedades->find()->where(['id'=>$id])->first([]);
        if (is_null($novedade))
            return $this->redirect(['controller'=>'Pages','action' => 'home']);
        $this->set('novedade', $novedade);
        $this->set('_serialize', ['novedade']);


        $this->loadModel('Ofertas');
        $ofertasX = $this->Ofertas->find('all')
		->contain(['Articulos','articulos.Descuentos' => [
			'queryBuilder' => function ($q) {
				return $q->where([
					'tipo_venta = "D"','fecha_hasta >=CURRENT_DATE()','tipo_oferta in ("RV","RR","OR","FR","TD","RL")']); // Full conditions for filtering
			}
		]
		])
		->hydrate(false)
		->join([
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
		->where(['Ofertas.activo=1','Ofertas.fecha_hasta >=CURRENT_DATE()','Ofertas.oferta_tipo_id'=>3])
		->order(['Ofertas.id' => 'DESC'])->limit('4'); 
        
        //$ofertasX = $this->Ofertas->find('all')->where(['activo'=>1,'fecha_hasta >=CURRENT_DATE()','ubicacion'=>3])->limit('4');  
		
		$this->set('ofertasX',$ofertasX->toArray());

		$this->loadModel('Publications');
		$publications = $this->Publications->find('all')->where(['fecha_hasta >=CURRENT_DATE()','habilitada' =>'1','ubicacion'=>'1'])->order(['orden' => 'asc'])->all();
		$this->set('inicio_slider',$publications->toArray());
    }

	public function noticia($id = null)
    {
		$this->viewBuilder()->layout('store');
        $novedade = $this->Novedades->get($id, [
            'contain' => []
        ]);
        $this->set('novedade', $novedade);
        $this->set('_serialize', ['novedade']);
    
		
			$novedades2 = $this->Novedades->find()
		->where(['activo' =>'1'])
		->andWhere(['interno' =>'0'])->limit('15')
		->order(['id' => 'DESC']);
		$this->set('novedades2', $novedades2);
	}
    /**
     * Index method
     *
     * @return void
     *//*
    public function index_admin()
    {
      


	    $this->set('novedades', $this->paginate($this->Novedades->find()->order(['id' => 'DESC'])));
        $this->set('_serialize', ['novedades']);
		
    }*/

    public function index_admin()
	{
		$this->set('titulo','Listado de Noticias');
		$this->viewBuilder()->layout('admin');
        $this->paginate = [
			'limit' => 250,
			'maxLimit' => 250,
		];
		
		if ($this->request->is('post','get')) {
			
			if ($this->request->data['fechadesde']!= null)
				$fechadesde = $this->request->data['fechadesde'];
			else
				$fechadesde=0;
			if ($this->request->data['fechahasta']!= null)
				$fechahasta = $this->request->data['fechahasta'];
			else
				$fechahasta =0;
			if ($this->request->data['termino']!= null)
				$termsearchp = '%'.$this->request->data['termino'].'%';
			else
				$termsearchp ="";
			
			
	
			$this->request->session()->write('termsearchp',$termsearchp);
			$this->request->session()->write('fechadesde',$fechadesde);	
			$this->request->session()->write('fechahasta',$fechahasta);
			if ($fechahasta!=0)
			{
				//$fechahasta2 = Time::now();
				$fechahasta2 = Time::createFromFormat('d/m/Y',$fechahasta,'America/Argentina/Buenos_Aires');
				$fechahasta2->modify('+1 days');
				$fechahasta2->i18nFormat('yyyy-MM-dd');
			}
			else
			{
				$fechahasta2 = Time::now();
				$fechahasta2-> modify('+1 days');
				$fechahasta2 = $fechahasta2->i18nFormat('yyyy-MM-dd');
			}
			if ($fechadesde!=0)
			{
				//$fechadesde2 = Time::now();
				$fechadesde2 = Time::createFromFormat('d/m/Y',$fechadesde,'America/Argentina/Buenos_Aires');
				$fechadesde2->i18nFormat('yyyy-MM-dd');
			}
			else
			{
				$fechadesde2 = Time::now();
				if ($fechahasta!=0)
					$fechadesde2->setDate($fechadesde2->year, $fechahasta2->month, 1);
				else
					$fechadesde2->setDate($fechadesde2->year, $fechadesde2->month, 1);
				$fechadesde2->i18nFormat('yyyy-MM-dd');
			}

			if (($fechadesde !=0) || ($fechahasta !=0) || ($termsearchp !=""))
				{	
					$novedades = $this->Novedades->find('all');
				}
			else
				{
					$novedades=null;
					//$this->redirect($this->referer());
				}	
			
	
	
		if (($fechadesde !=0) || ($fechahasta !=0))
			$novedades->andWhere(["Novedades.fecha BETWEEN '".$fechadesde2->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta2->i18nFormat('yyyy-MM-dd')."'"]);
	  	if ($termsearchp!="")
				
            $novedades->andWhere([
					
                'OR' => [['Novedades.descripcion LIKE'=>$termsearchp],['Novedades.titulo LIKE'=>$termsearchp],['Novedades.descripcion_completa LIKE'=>$termsearchp]

                ]
            ]);

	
		if ($novedades!=null)
				$novedades = $this->paginate($novedades->order(['id'=>'DESC']));
			else
				$novedades = null;		
		}
		else
		{
		
			$fechahasta = $this->request->session()->read('fechahasta');
		    $fechadesde = $this->request->session()->read('fechadesde');
			$termsearchp = $this->request->session()->read('termsearchp');
			$novedades = $this->paginate($this->Novedades->find('all')->order(['id'=>'DESC']));
		}
		
	
        $this->set('novedades', $novedades);
        $this->set('_serialize', ['novedades']);
    }

    /**
     * View method
     *
     * @param string|null $id Novedade id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view_admin($id = null)
    {
		$this->viewBuilder()->layout('admin');
        $novedade = $this->Novedades->get($id, [
            'contain' => []
        ]);
        $this->set('novedade', $novedade);
        $this->set('_serialize', ['novedade']);
		$this->set('titulo','Visualizar Noticia');
    }
    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add_admin()
    {
		$this->viewBuilder()->layout('admin');
        $novedade = $this->Novedades->newEntity();

        if ($this->request->is('post')) {
            	
			$novedade = $this->Novedades->patchEntity($novedade, $this->request->data);
			$fecha = Time::createFromFormat('d/m/Y',$this->request->data['fecha'],'America/Argentina/Buenos_Aires');
			$fecha->i18nFormat('yyyy-MM-dd');

			
			if(!empty($this->request->data['file']['name'])){
                $fileName = $this->request->data['file']['name'];
				
				$uploadPath = 'img/novedades/';

                $uploadFile = $uploadPath.$fileName;
				$novedade['img_file']= $fileName;
                if(move_uploaded_file($this->request->data['file']['tmp_name'],$uploadFile)){
                    $uploadData = $this->Files->newEntity();
                    $uploadData->name = $fileName;
                    $uploadData->path = $uploadPath;
                    $uploadData->created = date("Y-m-d H:i:s");
                    $uploadData->modified = date("Y-m-d H:i:s");
					if ($this->request->data['file']['type'] =='application/pdf')
						$novedade['archivopdf']= 1;
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
            }else{
                $this->Flash->error(__('Please choose a file to upload.'),['key' => 'changepass']);
				$this->redirect($this->referer());
            }

            if(!empty($this->request->data['file2']['name'])){
                $fileName2 = $this->request->data['file2']['name'];
				
				$uploadPath2 = 'img/novedades/';

                $uploadFile2 = $uploadPath2.$fileName2;
				$novedade['img_file2']= $fileName2;
                if(move_uploaded_file($this->request->data['file2']['tmp_name'],$uploadFile2)){
                    $uploadData2 = $this->Files->newEntity();
                    $uploadData2->name = $fileName2;
                    $uploadData2->path = $uploadPath2;
                    $uploadData2->created = date("Y-m-d H:i:s");
                    $uploadData2->modified = date("Y-m-d H:i:s");
					if ($this->request->data['file2']['type'] =='application/pdf')
						$novedade['archivopdf']= 1;
                    if ($this->Files->save($uploadData2)) {
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

			$novedade['fecha'] = $fecha;
			if ($this->Novedades->save($novedade)) {
                $this->Flash->success('Se guardaron los cambios.',['class'=>'alert_success']);
				
				$conn = ConnectionManager::get('default');
				$conn->query('CALL actualizarnovedadesnotificacion();');
				//	<h4 class="alert_warning">A Warning Alert</h4>
				
				//<h4 class="alert_error">An Error Message</h4>
				
				//<h4 class="alert_success">A Success Message</h4>
			
			
				return $this->redirect($this->referer());
                //return $this->redirect(['action' => 'index_admin']);
            } else {
                $this->Flash->error('No se puedo guardar la publicacion. Por favor intente de nuevo',['class'=>'alert_error']);
            }
        }
        $this->set(compact('novedade'));
        $this->set('_serialize', ['novedade']);
		$this->set('titulo','Agregar Noticia');
    }

    /**
     * Edit method
     *
     * @param string|null $id Novedade id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit_admin($id = null)
    {
	$this->viewBuilder()->layout('admin');
        $novedade = $this->Novedades->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $novedade = $this->Novedades->patchEntity($novedade, $this->request->data);
            $fecha = Time::createFromFormat('d/m/Y',$this->request->data['fecha'],'America/Argentina/Buenos_Aires');
			$fecha->i18nFormat('yyyy-MM-dd');
			$novedade->fecha=$fecha;
			
			
			if(!empty($this->request->data['file']['name'])){
                $fileName = $this->request->data['file']['name'];
				
				$uploadPath = 'img/novedades/';

                $uploadFile = $uploadPath.$fileName;
				$novedade['img_file']= $fileName;
                if(move_uploaded_file($this->request->data['file']['tmp_name'],$uploadFile)){
                    $uploadData = $this->Files->newEntity();
                    $uploadData->name = $fileName;
                    $uploadData->path = $uploadPath;
                    $uploadData->created = date("Y-m-d H:i:s");
                    $uploadData->modified = date("Y-m-d H:i:s");
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
            
            if(!empty($this->request->data['file2']['name'])){
                $fileName2 = $this->request->data['file2']['name'];
				
				$uploadPath2 = 'img/novedades/';

                $uploadFile2 = $uploadPath2.$fileName2;
				$novedade['img_file2']= $fileName2;
                if(move_uploaded_file($this->request->data['file2']['tmp_name'],$uploadFile2)){
                    $uploadData2 = $this->Files->newEntity();
                    $uploadData2->name = $fileName2;
                    $uploadData2->path = $uploadPath2;
                    $uploadData2->created = date("Y-m-d H:i:s");
                    $uploadData2->modified = date("Y-m-d H:i:s");
                    if ($this->Files->save($uploadData2)) {
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

			if ($this->Novedades->save($novedade)) {
				$this->Flash->success('Se modifico correctamente.',['class'=>'alert_success']);
               
                return $this->redirect(['action' => 'index_admin']);
            } else {
				$this->Flash->error('No se puedo modificar la publicacion. Por favor intente de nuevo',['class'=>'alert_error']);
                
            }
        }
        $this->set(compact('novedade'));
        $this->set('_serialize', ['novedade']);
		$this->set('titulo','Editar Noticia');
    }

    /**
     * Delete method
     *
     * @param string|null $id Novedade id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */

    public function delete_admin($id = null)
    {
		$this->viewBuilder()->layout('admin');
		$id = $this->request->getData('id');
		$this->request->allowMethod(['post', 'get', 'delete', 'ajax']);
	     $novedade = $this->Novedades->get($id);
		if (!empty($novedade)) {

		
			if ($this->Novedades->delete($novedade)) {
				$responseData = ['success' => true, 'responseText' => "eliminado", 'status' => 200];

				$this->response->body(json_encode($responseData));
				

				return $this->response;

				// $this->Flash->success('Se elimino correctamente del carro.',['key' => 'changepass']);
			}
			 else {
				$this->Flash->error('No se pudo eliminar, intente nuevamente', ['key' => 'changepass']);
			}
    }
	}

    
    public function exhibidores()
	{
		$this->viewBuilder()->layout('store');
		 $this->paginate = [
			'limit' => 500
			
		];
		$fechahasta2 = Time::now();
				$fechahasta2-> modify('+1 days');
				$fechahasta2 = $fechahasta2->i18nFormat('yyyy-MM-dd');
			$fechahasta = Time::now();
		$this->loadModel('Incorporations');
		$incorporationsA = $this->Incorporations->find('all');
		$incorporationsA->where(['habilitada'=>1,'incorporations_tipos_id '=>5])
				->andWhere(["Incorporations.fecha_hasta > '".$fechahasta->i18nFormat('yyyy-MM-dd')."'"])
				 ->order(['id' => 'DESC']);
		$incorporations = $this->paginate($incorporationsA);
		
		$this->loadModel('IncorporationsTipos');
		$IncorporationsTipos =  $this->IncorporationsTipos->find('list', ['keyField' => 'id','valueField' => 'nombre']);
		$this->set('incorporationstipos',$IncorporationsTipos ->toArray());
		
        $this->set('incorporations', $incorporations);
        $this->set('_serialize', ['incorporations']);

    }
    
	public function perfumeria()
	{
		$this->viewBuilder()->layout('store');
		 $this->paginate = [
			'limit' => 500
			
		];
		$fechahasta2 = Time::now();
				$fechahasta2-> modify('+1 days');
				$fechahasta2 = $fechahasta2->i18nFormat('yyyy-MM-dd');
			$fechahasta = Time::now();
		$this->loadModel('Incorporations');
		$incorporationsA = $this->Incorporations->find('all');
		$incorporationsA->where(['habilitada'=>1,'incorporations_tipos_id <'=>7])
				->andWhere(["Incorporations.fecha_hasta > '".$fechahasta->i18nFormat('yyyy-MM-dd')."'"])
				 ->order(['id' => 'DESC']);
		$incorporations = $this->paginate($incorporationsA);
		
		$this->loadModel('IncorporationsTipos');
		$IncorporationsTipos =  $this->IncorporationsTipos->find('list', ['keyField' => 'id','valueField' => 'nombre']);
		$this->set('incorporationstipos',$IncorporationsTipos ->toArray());
		
        $this->set('incorporations', $incorporations);
        $this->set('_serialize', ['incorporations']);

	}

	
     public function condiciones(){
	$this->viewBuilder()->layout('store');
       
	 }
	
	
}
