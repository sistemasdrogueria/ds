<?php
namespace App\Controller;
use Cake\I18n\Time;
use App\Controller\AppController;

/**
 * Publications Controller
 *
 * @property \App\Model\Table\PublicationsTable $Publications
 *
 * @method \App\Model\Entity\Publication[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PublicationsController extends AppController
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
		 if (in_array($this->request->action, ['edit_admin', 'delete_admin','add_admin','index_admin','update_admin'])) {
       
            if($this->request->session()->read('Auth.User.role')=='admin') 
            {				
                return true;			
            }			
            else 
            {	
                if($this->request->session()->read('Auth.User.role')=='client') 
                {				
					$tiene= $this->tienepermiso('publications',$this->request->action);
					if (!$tiene)
						$this->Flash->error(__('No tiene permisos para ingresar'),['key' => 'changepass']);
					return $tiene;					
                }	
                else
                {
					if($this->request->session()->read('Auth.User.role')=='provider') 
					{
					
						$this->redirect(array('controller' => 'Articulos', 'action' => 'index'));	
						return false;						
					}
					else
					{
						$this->Flash->error(__('No tiene permisos para ingresar'),['key' => 'changepass']);
						$this->redirect(['controller' => 'Pages', 'action' => 'home']);
						return false;	
					}
                    
                }	
            }		
            }		
			else 
			{			    		
				if (in_array($this->request->action, ['index']))
				{
					return true;
					
				}
				else
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
        $publications = $this->paginate($this->Publications);

        $this->set(compact('publications'));
    }
	
	public function update_admin() {
		$this->loadComponent('RequestHandler');
        if ($this->request->is(['ajax','post'])) {
            $id = $this->request->data['id'];
	
			$publication = $this->Publications->find()->where(['id'=>$id])->first([]);

			$responseData = ['success' => false,'responseText'=>"''",'status'=>400 ];		


                if (empty($publication))
                {
                    $responseData = ['success' => false, 'responseText'=>"'No se pudo modificar correctamente,'",'status'=>400 ];
                }
				
				if ($publication['habilitada'])
				$publication['habilitada'] =0;
				else
				$publication['habilitada'] =1;

			    /*echo json_encode($quantity); ->pasar datos*/
				if ($this->Publications->save($publication)) {
							$responseData = ['success' => true,'responseText'=>"'Se modifico correctamente.'",'status'=>200,'carro'=>$publication ];						
				} 
				else
				{
							$responseData = ['success' => false, 'responseText'=>"'No se pudo modificar correctamente,'",'status'=>400 ];
										
				}

				echo json_encode($responseData);

				//echo json_encode($carro);
				$this->set('responseData', $responseData);
				
				$this->set('_serialize', ['responseData']);
				

			
				//echo json_encode($carro);
			//$product = $this->Cart->add($id, $quantity, $productmodId);
        }
        //$cart = $this->CarritosPreventas->getcart();
        
        die;


	}
		
	public function index_admin()
	{
		$this->loadModel('PublicationsTipos');
        $publicationsTipos =  $this->PublicationsTipos->find('list', ['keyField' => 'id','valueField' => 'nombre']);
		$this->set('publicationsTipos',$publicationsTipos->toArray());
		$this->viewBuilder()->layout('admin2');
        $this->paginate = [
			'limit' => 100,
			'order' => (['Publications.id' => 'DESC'])
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
			if ($this->request->data['tipo']!= null)
				$tipo = $this->request->data['tipo'];
			else
				$tipo=0;
			
			
			$this->request->session()->write('publicaciontipo',$tipo);
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

			if (($fechadesde !=0) || ($fechahasta !=0) || ($termsearchp !="") || ($tipo!=0))
				{	
					$publicationsA = $this->Publications->find('all');
				}
			else
				{
					$publicationsA=null;
					//$this->redirect($this->referer());
				}	
			
	
	
		if (($fechadesde !=0) || ($fechahasta !=0))
			$publicationsA->andWhere(["Publications.fecha_desde BETWEEN '".$fechadesde2->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta2->i18nFormat('yyyy-MM-dd')."'"]);
	  	if ($termsearchp!="")
			$publicationsA->where(['Publications.descripcion LIKE'=>$termsearchp]);
		
		if ($tipo !=0)
			$publicationsA->where(['Publications.ubicacion'=>$tipo]);
		
		if ($publicationsA!=null)
		{
				//$publicationsA->order(['Publications.id' => 'DESC']);
				$publications = $this->paginate($publicationsA);
		}
			else
				$publications = null;		
		}
		else
		{
		
			$fechahasta = $this->request->session()->read('fechahasta');
		    $fechadesde = $this->request->session()->read('fechadesde');
			$termsearchp = $this->request->session()->read('termsearchp');
			$publications = $this->paginate($this->Publications->find());
		}
		
	
        $this->set('publications', $publications);
        $this->set('_serialize', ['publications']);
		$this->set('titulo','Lista de Publicaciones');
    }
    /**
     * View method
     *
     * @param string|null $id Publication id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view_admin($id = null)
    {
        $publication = $this->Publications->get($id, [
            'contain' => []
        ]);

        $this->set('publication', $publication);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */

	  public function edit_publication_admin()
    {
		$publications = TableRegistry::get('Publications');
		$entities = $publications->newEntities($this->request->getData());
		
		//$ofertas = TableRegistry::get('Ofertas');
		//$entities = $ofertas->newEntities($this->request->data());
		$this->set('entities', $entities);
		
		foreach ($entities as $publication) {
				
				
				$habilitada = $publication['habilitada'];
				$id = $publication['id'];	
				
				$publication = $this->Publications->get($id
				, ['contain' => []]);
				
				$publication['habilitada'] = $habilitada;	
				
				if ($this->Publications->save($publication))
				{
					$this->Flash->success('Se guardo los cambios correctamente.',['key' => 'changepass']);
					//$this->redirect($this->referer());
				}
				else
				{
					$this->Flash->error('No se pudo guardar los cambios. Intente de nuevo',['key' => 'changepass']);
				}
		}
		//$this->set('carritos2', $carros);
		$this->redirect($this->referer());
    }

	 
	public function add_admin()
    {
		$this->loadModel('PublicationsTipos');
        $publicationsTipos =  $this->PublicationsTipos->find('list', ['keyField' => 'id','valueField' => 'nombre']);
		$this->set('publicationsTipos',$publicationsTipos->toArray());

		$this->viewBuilder()->layout('admin');
		$this->set('titulo','Publicación');
        $publication = $this->Publications->newEntity();
        if ($this->request->is('post')) {
            $publication = $this->Publications->patchEntity($publication, $this->request->data);
			$fechadesde = Time::createFromFormat('d/m/Y',$this->request->data['fecha_desde'],'America/Argentina/Buenos_Aires');
			$fechadesde->i18nFormat('yyyy-MM-dd');
			$fechahasta = Time::createFromFormat('d/m/Y',$this->request->data['fecha_hasta'],'America/Argentina/Buenos_Aires');
			$fechahasta->i18nFormat('yyyy-MM-dd');
			
			$publication['fecha_desde'] = $fechadesde;
			$publication['fecha_hasta'] = $fechahasta;
			if ($publication['localidad'] =="")
			$publication['localidad'] ="0";
			$uploadData = '';
			if(!empty($this->request->data['file']['name'])){
                $fileName = $this->request->data['file']['name'];
				if ($this->request->data['file']['size'] >512000)
				{
					$this->Flash->error(__('Supero Los 500kb, demasiado grande la imagen.'),['key' => 'changepass']);
					$this->redirect($this->referer());

				}
				if ($publication['ubicacion']!=1 && $publication['ubicacion']!=9)
					$uploadPath = 'img/publicaciones/';
				else
					$uploadPath = 'img/inicio/';
                $uploadFile = $uploadPath.$fileName;
				$publication['imagen']= $fileName;
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
            }else{
                $this->Flash->error(__('Please choose a file to upload.'),['key' => 'changepass']);
				//$this->redirect($this->referer());
            }

            if ($this->Publications->save($publication)) {

                $this->Flash->success(__('La Publicación fue cargada correctamente'),['key' => 'changepass']);
                return $this->redirect(['action' => 'index_admin']);
            } else {
				$this->Flash->error(__('No se pudo cargar la Publicación, intente nuevamente'),['key' => 'changepass']);
                $this->redirect($this->referer());	
            }
        }
		
        $this->set(compact('publication'));
		$this->set('_serialize', ['publication']);
		
		$this->loadModel('Laboratorios');

		$Laboratorios = $this->Laboratorios->find('all')->Select(['id','codigo','nombre'])->order(['nombre' => 'ASC']);
			
		foreach ($Laboratorios as $opcion) {
	
			$laboratorios[$opcion['id']] = $opcion['codigo'].' - '.$opcion['nombre'];    
		}	
       
        $this->set('laboratorios',$laboratorios);
      
		$this->loadModel('Marcas');
		$marcas =$this->Marcas->find('list',['keyField' => 'id','valueField'=>'nombre'])
										->order(['nombre' => 'ASC']);	
		$this->set(compact('marcas'));

    }
	
    /**
     * Edit method
     *
     * @param string|null $id Publication id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
	
	public function edit_admin($id = null)
    {
		$this->loadModel('PublicationsTipos');
        $publicationsTipos =  $this->PublicationsTipos->find('list', ['keyField' => 'id','valueField' => 'nombre']);
		$this->set('publicationsTipos',$publicationsTipos->toArray());
	$this->viewBuilder()->layout('admin');
       $publication = $this->Publications->get($id, [
            'contain' => []
        ]);

		if ($this->request->is(['patch', 'post', 'put'])) {
            $publication = $this->Publications->patchEntity($publication, $this->request->getData());
			
            $fechadesde = Time::createFromFormat('d/m/Y',$this->request->data['fecha_desde'],'America/Argentina/Buenos_Aires');
			$fechadesde->i18nFormat('yyyy-MM-dd');
			$fechahasta = Time::createFromFormat('d/m/Y',$this->request->data['fecha_hasta'],'America/Argentina/Buenos_Aires');
			$fechahasta->i18nFormat('yyyy-MM-dd');
			$publication['fecha_desde'] = $fechadesde;
			$publication['fecha_hasta'] = $fechahasta;
			$uploadData = '';
			if(!empty($this->request->data['file']['name'])){
				if ($this->request->data['file']['size'] >512000)
				{
					$this->Flash->error(__('Supero Los 500kb, demasiado grande la imagen.'),['key' => 'changepass']);
					$this->redirect($this->referer());

				}
                $fileName = $this->request->data['file']['name'];
				
				if ($publication['ubicacion']!=1 && $publication['ubicacion']!=9) 
				$uploadPath = 'img/publicaciones/';
			else
				$uploadPath = 'img/inicio/';
                //$uploadPath = 'img/publicaciones';
				
                $uploadFile = $uploadPath.$fileName;
				$publication['imagen']= $fileName;
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
                    $this->Flash->error(__('Unable to upload file, please try again 2. '.$fileName.' '.$uploadPath),['key' => 'changepass']);
					$this->redirect($this->referer());
                }
            }
			
			if ($this->Publications->save($publication)) {
                
				$this->Flash->success('La Publicación se guardo correctamente.',['key' => 'changepass']);
                return $this->redirect(['action' => 'index_admin']);
            } else {
                $this->Flash->error('La Publicación no se guardo.',['key' => 'changepass']);
            }
        }

		$this->loadModel('Marcas');
		$marcas =$this->Marcas->find('list',['keyField' => 'id','valueField'=>'nombre'])
										->order(['nombre' => 'ASC']);	
		$this->set(compact('marcas'));
		
		$this->loadModel('Laboratorios');

		$Laboratorios = $this->Laboratorios->find('all')->Select(['id','codigo','nombre'])
		->order(['nombre' => 'ASC']);
			
		foreach ($Laboratorios as $opcion) {
	
			$laboratorios[$opcion['id']] = $opcion['codigo'].' - '.$opcion['nombre'];    
		}	
       
        $this->set(compact( 'laboratorios'));
	   $this->set(compact('publication'));

		$this->set('titulo','Modificar Publicación');
    }

    /**
     * Delete method
     *
     * @param string|null $id Publication id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */

	public function delete_admin($id = null)
    {
		$this->viewBuilder()->layout('admin');
		$id = $this->request->getData('id');
		$this->request->allowMethod(['post', 'get', 'delete', 'ajax']);
		$publication = $this->Publications->get($id);
		if (!empty($publication)) {

		
			if ($this->Publications->delete($publication)) {
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
}
