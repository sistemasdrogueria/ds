<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\ORM\Query;
use Cake\ORM\TableRegistry;


use Cake\Database\Expression\QueryExpression;
use Cake\Datasource\ConnectionManager;
/**
 * Incorporations Controller
 *
 * @property \App\Model\Table\IncorporationsTable $Incorporations
 *
 * @method \App\Model\Entity\Incorporation[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class IncorporationsController extends AppController
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
		 if (in_array($this->request->action, ['edit_admin', 'delete_admin','add_admin','index_admin','edit_incorporation_admin'])) {
       
            if($this->request->session()->read('Auth.User.role')=='admin') 
            {				
                return true;			
            }			
            else 
            {	
                if($this->request->session()->read('Auth.User.role')=='client') 
                {				
					$tiene= $this->tienepermiso('incorporations',$this->request->action);
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
		
        $this->paginate = [
            'contain' => ['IncorporationsTipos']
        ];
        $incorporations = $this->paginate($this->Incorporations);

        $this->set(compact('incorporations'));
    }

	public function index_admin()
    {
		$this->viewBuilder()->layout('admin');
        $this->paginate = [
			'limit' => 100,
			'order' => ['Incorporations.id' => 'DESC']
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
				$incorporationtipo = $this->request->data['incorporationtipo'];
			else
				$incorporationtipo=0;
			
			
			$this->request->session()->write('incorporationtipo',$incorporationtipo);
			
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

			if (($fechadesde !=0) || ($fechahasta !=0) || ($termsearchp !="") || ($incorporationtipo!=0))
				{	
					$incorporacionA = $this->Incorporations->find('all');
				}
			else
				{
					$incorporacionA=null;
					//$this->redirect($this->referer());
				}	
			
		if ($incorporationtipo!=0)
		{
			$incorporacionA->where(['Incorporations.incorporations_tipos_id'=>$incorporationtipo]);
		}
		if (($fechadesde !=0) || ($fechahasta !=0))
			$incorporacionA->andWhere(["Incorporations.fecha_desde BETWEEN '".$fechadesde2->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta2->i18nFormat('yyyy-MM-dd')."'"]);
	  	if ($termsearchp!="")
			$incorporacionA->where(['Incorporations.descripcion LIKE'=>$termsearchp]);
			if ($incorporacionA!=null)
				$incorporations = $this->paginate($incorporacionA);
			else
				$incorporations = null;		
		}
		else
		{
			$incorporationtipo =  $this->request->session()->read('incorporationtipo');
			$fechahasta = $this->request->session()->read('fechahasta');
		    $fechadesde = $this->request->session()->read('fechadesde');
			$termsearchp = $this->request->session()->read('termsearchp');
			$incorporations = $this->paginate($this->Incorporations->find());
		}
		$this->loadModel('IncorporationsTipos');
		$IncorporationsTipos =  $this->IncorporationsTipos->find('list', ['keyField' => 'id','valueField' => 'nombre'])->order(['nombre'=>'ASC']);
		$this->set('incorporationstipos2',$IncorporationsTipos ->toArray());
				
		$this->set('incorporationstipos',$this->IncorporationsTipos->find()->toArray());
        $this->set('incorporations', $incorporations);
        $this->set('_serialize', ['incorporations']);
		$this->set('titulo','Lista de Incorporaciones');
    }
	
	public function add_admin_perfumeria()
    {
		$this->viewBuilder()->layout('admin');
		$this->set('titulo','Perfumeria');
        $oferta = $this->Ofertas->newEntity();
        if ($this->request->is('post')) {
            $oferta = $this->Ofertas->patchEntity($oferta, $this->request->data);
			$fechadesde = Time::createFromFormat('d/m/Y',$this->request->data['fecha_desde'],'America/Argentina/Buenos_Aires');
			$fechadesde->i18nFormat('yyyy-MM-dd');
			$fechahasta = Time::createFromFormat('d/m/Y',$this->request->data['fecha_hasta'],'America/Argentina/Buenos_Aires');
			$fechahasta->i18nFormat('yyyy-MM-dd');
			
			$oferta['fecha_desde'] = $fechadesde;
			$oferta['fecha_hasta'] = $fechahasta;
			$uploadData = '';
			if(!empty($this->request->data['file']['name'])){
                $fileName = $this->request->data['file']['name'];
				if ($this->request->data['file']['size'] >614400)
				{
					$this->Flash->error(__('Supero Los 600kb, demasiado grande la imagen.'),['key' => 'changepass']);
					$this->redirect($this->referer());

				}

				$uploadPath = 'img/incorporations/';
				switch ($this->request->data['oferta_tipo_id']) {
					case 1:
						$uploadPath = $uploadPath.'selectivas/' ;
						break;
					case 2:
						$uploadPath = $uploadPath.'semiselectivas/' ;
						break;
					case 3:
						$uploadPath = $uploadPath.'dermo/' ;
						break;
					case 4:
						$uploadPath = $uploadPath.'makeup/' ;
						break;
					case 5:
						$uploadPath = $uploadPath.'solares/' ;
						break;
					case 6:
						$uploadPath = $uploadPath.'perfumerias/' ;
						break;
					case 7:
						$uploadPath = $uploadPath.'patagonia/' ;
						break;
					case 8:
							$uploadPath = $uploadPath.'nutricion/' ;
							break;

							case 9:
								$uploadPath = $uploadPath.'expovirtual/' ;
								break;
								case 12:
									$uploadPath = $uploadPath.'delia/' ;
									break;
						}
				
				
              
                $uploadFile = $uploadPath.$fileName;
				$oferta['imagen']= $fileName;
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
				$this->redirect($this->referer());
            }

            if ($this->Ofertas->save($oferta)) {

                $this->Flash->success(__('La oferta fue cargada correctamente'),['key' => 'changepass']);
                return $this->redirect(['action' => 'index_admin']);
            } else {
				$this->Flash->error(__('No se pudo cargar la oferta, intente nuevamente'),['key' => 'changepass']);
                $this->redirect($this->referer());	
            }
        }
		$this->loadModel('OfertasTipos');
        $OfertasTipos =  $this->OfertasTipos->find('list', ['keyField' => 'id','valueField' => 'nombre']);
		$this->set('ofertastipos',$OfertasTipos ->toArray());
        $this->set(compact('oferta','ofertastipos'));
        $this->set('_serialize', ['oferta']);
    }
  

	
    /**
     * View method
     *
     * @param string|null $id Incorporation id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view_admin($id = null)
    {
        $incorporation = $this->Incorporations->get($id, [
            'contain' => ['IncorporationsTipos']
        ]);

        $this->set('incorporation', $incorporation);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
	 
	 public function edit_incorporation_admin()
    {
		$incorporations = TableRegistry::get('Incorporations');
		$entities = $incorporations->newEntities($this->request->getData());
		
		//$ofertas = TableRegistry::get('Ofertas');
		//$entities = $ofertas->newEntities($this->request->data());
		$this->set('entities', $entities);
		
		foreach ($entities as $incorporation) {
				
				
				$habilitada = $incorporation['habilitada'];
				$id = $incorporation['id'];	
				
				$incorporation = $this->Incorporations->get($id
				, ['contain' => []]);
				
				$incorporation['habilitada'] = $habilitada;	
				
				if ($this->Incorporations->save($incorporation))
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
/*	 
    public function add_admin()
    {
        $incorporation = $this->Incorporations->newEntity();
        if ($this->request->is('post')) {
            $incorporation = $this->Incorporations->patchEntity($incorporation, $this->request->getData());
            if ($this->Incorporations->save($incorporation)) {
                $this->Flash->success(__('The incorporation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The incorporation could not be saved. Please, try again.'));
        }
        $incorporationsTipos = $this->Incorporations->IncorporationsTipos->find('list', ['limit' => 200]);
        $this->set(compact('incorporation', 'incorporationsTipos'));
    }
*/
   public function add_admin()
    {
		$this->viewBuilder()->layout('admin');
		$this->set('titulo','Incorporación');
        $incorporation = $this->Incorporations->newEntity();
        if ($this->request->is('post')) {
            $incorporation = $this->Incorporations->patchEntity($incorporation, $this->request->data);
			$fechadesde = Time::createFromFormat('d/m/Y',$this->request->data['fecha_desde'],'America/Argentina/Buenos_Aires');
			$fechadesde->i18nFormat('yyyy-MM-dd');
			$fechahasta = Time::createFromFormat('d/m/Y',$this->request->data['fecha_hasta'],'America/Argentina/Buenos_Aires');
			$fechahasta->i18nFormat('yyyy-MM-dd');
			
			$incorporation['fecha_desde'] = $fechadesde;
			$incorporation['fecha_hasta'] = $fechahasta;
			$uploadData = '';
			if(!empty($this->request->data['file']['name'])){
                $fileName = $this->request->data['file']['name'];
				if ($this->request->data['file']['size'] >614400)
				{
					$this->Flash->error(__('Supero Los 600kb, demasiado grande la imagen.'),['key' => 'changepass']);
					$this->redirect($this->referer());

				}
				$uploadPath = 'img/incorporations/';
				switch ($this->request->data['incorporations_tipos_id']) {
							case 1:
								$uploadPath = $uploadPath.'selectivas/' ;
								break;
							case 2:
								$uploadPath = $uploadPath.'semiselectivas/' ;
								break;
							case 3:
								$uploadPath = $uploadPath.'dermo/' ;
								break;
							case 4:
								$uploadPath = $uploadPath.'makeup/' ;
								break;
							case 5:
								$uploadPath = $uploadPath.'solares/' ;
								break;
							case 6:
								$uploadPath = $uploadPath.'perfumerias/' ;
								break;
							case 7:
								$uploadPath = $uploadPath.'patagonia/' ;
								break;
							case 8:
									$uploadPath = $uploadPath.'nutricion/' ;
									break;
									case 9:
										$uploadPath = $uploadPath.'expovirtual/' ;
										break;
										case 12:
											$uploadPath = $uploadPath.'delia/' ;
											break;
						}
				
				
              
                $uploadFile = $uploadPath.$fileName;
				$incorporation['imagen']= $fileName;
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
				$this->redirect($this->referer());
            }

            if ($this->Incorporations->save($incorporation)) {

                $this->Flash->success(__('La Incorporacion fue cargada correctamente'),['key' => 'changepass']);
                return $this->redirect(['action' => 'index_admin']);
            } else {
				$this->Flash->error(__('No se pudo cargar la Incorporacion, intente nuevamente'),['key' => 'changepass']);
                $this->redirect($this->referer());	
            }
        }
		$this->loadModel('IncorporationsTipos');
        $IncorporationsTipos =  $this->IncorporationsTipos->find('list', ['keyField' => 'id','valueField' => 'nombre']);
		$this->set('incorporationstipos',$IncorporationsTipos ->toArray());
        $this->set(compact('incorporation','incorporationstipos'));
        $this->set('_serialize', ['incorporation']);
    }
  
    public function edit_admin($id = null)
    {
		$this->viewBuilder()->layout('admin');
       $incorporation = $this->Incorporations->get($id, [
            'contain' => []
        ]);

		if ($this->request->is(['patch', 'post', 'put'])) {
            $incorporation = $this->Incorporations->patchEntity($incorporation, $this->request->getData());
			
            $fechadesde = Time::createFromFormat('d/m/Y',$this->request->data['fecha_desde'],'America/Argentina/Buenos_Aires');
			$fechadesde->i18nFormat('yyyy-MM-dd');
			$fechahasta = Time::createFromFormat('d/m/Y',$this->request->data['fecha_hasta'],'America/Argentina/Buenos_Aires');
			$fechahasta->i18nFormat('yyyy-MM-dd');
		
			
			$incorporation['fecha_desde'] = $fechadesde;
			$incorporation['fecha_hasta'] = $fechahasta;
			
			
			$uploadData = '';
			if(!empty($this->request->data['file']['name'])){
                $fileName = $this->request->data['file']['name'];
                if ($this->request->data['file']['size'] >614400)
				{
					$this->Flash->error(__('Supero Los 600kb, demasiado grande la imagen.'),['key' => 'changepass']);
					$this->redirect($this->referer());

				}
			
				$uploadPath = 'img/incorporations/';
				switch ($this->request->data['incorporations_tipos_id']) {
					case 1:
						$uploadPath = $uploadPath.'selectivas/' ;
						break;
					case 2:
						$uploadPath = $uploadPath.'semiselectivas/' ;
						break;
					case 3:
						$uploadPath = $uploadPath.'dermo/' ;
						break;
					case 4:
						$uploadPath = $uploadPath.'makeup/' ;
						break;
					case 5:
						$uploadPath = $uploadPath.'solares/' ;
						break;
					case 6:
						$uploadPath = $uploadPath.'perfumerias/' ;
						break;
					case 7:
						$uploadPath = $uploadPath.'patagonia/' ;
						break;
						case 8:
							$uploadPath = $uploadPath.'nutricion/' ;
							break;
							case 9:
								$uploadPath = $uploadPath.'expovirtual/' ;
								break;
								case 12:
									$uploadPath = $uploadPath.'delia/' ;
									break;
						}
						
                $uploadFile = $uploadPath.$fileName;
				$incorporation['imagen']= $fileName;
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
			
			if ($this->Incorporations->save($incorporation)) {
                
				$this->Flash->success('La incorporacion se guardo correctamente.',['key' => 'changepass']);
                return $this->redirect(['action' => 'index_admin']);
            } else {
                $this->Flash->error('La incorporacion no se guardo.',['key' => 'changepass']);
            }
        }
		$this->loadModel('IncorporationsTipos');
		$incorporationstipos = $this->IncorporationsTipos->find('list',['keyField' => 'id','valueField'=>'nombre']);
		$incorporationstipos = $incorporationstipos->toArray();
		
	   $this->set(compact('incorporation', 'incorporationstipos'));

		$this->set('titulo','Modificar Incorporación');
    }

	
    /**
     * Delete method
     *
     * @param string|null $id Incorporation id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */

	public function delete_admin($id = null)
    {
		$this->viewBuilder()->layout('admin');
		$id = $this->request->getData('id');
		$this->request->allowMethod(['post', 'get', 'delete', 'ajax']);
		$incorporation = $this->Incorporations->get($id);
		if (!empty($incorporation)) {

		
			if ($this->Incorporations->delete($incorporation)) {
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
