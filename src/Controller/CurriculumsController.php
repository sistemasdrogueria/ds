<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\I18n\Time;
/**
 * Curriculums Controller
 *
 * @property \App\Model\Table\CurriculumsTable $Curriculums
 *
 * @method \App\Model\Entity\Curriculum[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CurriculumsController extends AppController
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
        $this->Auth->allow(['index','add']);
    }
	
	public function isAuthorized()
    {
         
		 if (in_array($this->request->action,['index','add'])) {
                return true;			
                //if($this->request->session()->read('Auth.User.role')=='client') 
            }		
			else 
			{		
				if (in_array($this->request->action,['display','home']))
				{
					return true;
				}
				else
				{
					if (in_array($this->request->action, ['index_admin','view_admin','downloadfile','delete_admin','leido'])) {
       
					if($this->request->session()->read('Auth.User.role')=='adminR') 	
							return true;			
					else
						$this->Flash->error('No tiene permisos para ingresar - No Direct',['key' => 'changepass']);    
						
					$this->redirect(['controller' => 'Pages', 'action' => 'home']);  		
					return false;	}
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
       	$this->viewBuilder()->layout('job');
		$curriculum = $this->Curriculums->newEntity();
		$this->loadModel('Provincias');
		 
		 $provincias = $this->Provincias->find('list',['keyField' => 'id','valueField'=>'nombre']);
		 $sectors =  $this->Curriculums->Sectors->find('list', ['keyField' => 'id','valueField' => 'nombre']);
		 $sectors=$sectors->toArray();
 
		 $this->set(compact('curriculum','sectors','provincias'));
 
    }

	
	public function index_admin()
    {
		$this->viewBuilder()->layout('admin3');
		  $this->paginate = [
            'contain' => ['Sectors'],
			'limit' => 500,
			'maxLimit' => 400,
			'order'=> ['Curriculums.creado' => 'DESC']
        ];
		
		if ($this->request->is('post'))
		{	
	
			if ($this->request->data['fechadesde']!= null)
			{
				$fechadesde = $this->request->data['fechadesde'];
			}	
			else
			{
				$fechadesde=0;
			}
			if ($this->request->data['fechahasta']!= null)
			{
				$fechahasta = $this->request->data['fechahasta'];
			}	
			else
			{
				$fechahasta =0;
			}
			if ($this->request->data['termino']!= null)
			{
				$termino = '%'.$this->request->data['termino'].'%';
			}	
			else
			{
				$termino ="";
			}	
			if ($this->request->data['sector_id']!= null)
			{
				$sector = $this->request->data['sector_id'];
			}	
			else
			{
				$sector =0;
			}	
			
			$this->request->session()->write('termino',$termino);
			$this->request->session()->write('sector',$sector);
			
			$this->request->session()->write('fechadesde',$fechadesde);	
			$this->request->session()->write('fechahasta',$fechahasta);
		}
		else 
		{
			$fechahasta = 0; //$this->request->session()->read('fechahasta');
		    $fechadesde = 0; //$this->request->session()->read('fechadesde');
			$termino = ""; //$this->request->session()->read('termino');
			$sector = 0;//$this->request->session()->read('sector');
			
		}
		if ($fechahasta!=0)
		{
			//$fechahasta2 = Time::now();
			$fechahasta2 = Time::createFromFormat(
			'd/m/Y',
			$fechahasta,
			'America/Argentina/Buenos_Aires');
			$fechahasta2->modify('+1 days');
			$fechahasta2->i18nFormat('yyyy-MM-dd');
		}
		else
		{
			$fechahasta2 = Time::now();
			$fechahasta2-> modify('+1 days');
			//$fechahasta2 = $fechahasta2->i18nFormat('yyyy-MM-dd');
		}
		if ($fechadesde!=0)
		{
			//$fechadesde2 = Time::now();
			$fechadesde2 = Time::createFromFormat(
				'd/m/Y',
			$fechadesde,
			'America/Argentina/Buenos_Aires');
			$fechadesde2->i18nFormat('yyyy-MM-dd');
		}
		else
		{
			$fechadesde2 = Time::now();
			$fechadesde2->i18nFormat('yyyy-MM-dd');
		}
		
		if ($this->request->is('post'))
		{
		$curriculums = $this->Curriculums->find('all')
								->order(['Curriculums.creado' => 'DESC']);
		}
		else
		$curriculums = $this->Curriculums->find('all');
		if ($termino!="")
		{
			$curriculums->where(['nombres LIKE'=>$termino])->orWhere(['apellidos LIKE'=>$termino]);
		}
		
		if (($fechadesde !=0) && ($fechahasta !=0))
		    	$curriculums->andWhere(["creado BETWEEN '".$fechadesde2->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta2->i18nFormat('yyyy-MM-dd')."'"]);
		else
				if (($fechadesde !=0) || ($fechahasta !=0))
					$curriculums->andWhere(["creado BETWEEN '".$fechadesde2->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta2->i18nFormat('yyyy-MM-dd')."'"]);


		if ($sector!=0)
		{
				$curriculums->where(['sector_id' => $sector]);
		}
		
		if (($fechadesde !=0) && ($fechahasta !=0) && ($sector!=0) && ($termino!=""))
					{
							$curriculums=null;
							$this->redirect($this->referer());
					}
		if ($curriculums!=null)
		{
			$curriculums = $this->paginate($curriculums);
		}
		else
			$curriculums = null;
										
		$sectors =  $this->Curriculums->Sectors->find('list', ['keyField' => 'id','valueField' => 'nombre']);
		$sectors=$sectors ->toArray();
		
		//$curriculums = $this->paginate($curriculums);
								
        $this->set(compact('curriculums','sectors'));
		$this->set('titulo','Listado de Curriculms');
	}
	
	public function downloadfile ($nombreArchivo = null,$id =null){
		
			//$this->response->type('pdf');

			// Optionally force file download
			//
			//
			//$this->response->file('temp'. DS .'DETFAC'.$codigo.'.TXT');
			 $curriculum = $this->Curriculums->get($id, [
            'contain' => []
        ]);

           // $curriculum = $this->Curriculums->patchEntity($curriculum, $this->request->getData());
            $curriculum['leido']=1;
			if ($this->Curriculums->save($curriculum)) {
                $this->Flash->success(__('The curriculum has been saved.'));
	
               // return $this->redirect(['action' => 'index']);
            }
            //$this->Flash->error(__('The curriculum could not be saved. Please, try again.'));
        
			
			$nombre_fichero = 'cv'. DS .$nombreArchivo;

				if (file_exists($nombre_fichero)) {
					$this->response->file(
					$nombre_fichero,
					['download' => true, 'name' => $nombreArchivo]
					);
					return $this->response;
				}
				else
				{ $this->Flash->error(__('Momentaneamente no disponible, intente mas tarde.'),['key' => 'changepass']);
				$this->redirect($this->referer());}
			
		
	}
    /**
     * View method
     *
     * @param string|null $id Curriculum id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view_admin($id = null)
    {
		$this->viewBuilder()->layout('admin3');
        $curriculum = $this->Curriculums->get($id, [
            'contain' => ['sectors']
        ]);
		$this->set('titulo','Detalle de Curriculm');
        $this->set('curriculum', $curriculum);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$this->loadModel('Provincias');
		 
		 $provincias = $this->Provincias->find('list',['keyField' => 'id','valueField'=>'nombre']);
		
		$this->viewBuilder()->layout('job');
        $curriculum = $this->Curriculums->newEntity();
        if ($this->request->is('post')) {
            $curriculum = $this->Curriculums->patchEntity($curriculum, $this->request->getData());
            
			$uploadData = '';
			if(!empty($this->request->data['file']['name'])){
                $fileName = 'cv_'.$curriculum['documento'].'_'.$this->request->data['file']['name'];
                $uploadPath = 'cv/';
                $uploadFile = $uploadPath.$fileName;
				$curriculum['archivo_cv']= $fileName;
                if(move_uploaded_file($this->request->data['file']['tmp_name'],$uploadFile)){
                    $uploadData = $this->Files->newEntity();
                    $uploadData->name = $fileName;
                    $uploadData->path = $uploadPath;
                    $uploadData->created = date("Y-m-d H:i:s");
                    $uploadData->modified = date("Y-m-d H:i:s");
                    if ($this->Files->save($uploadData)) {
                        //$this->Flash->success(__('File has been uploaded and inserted successfully.'),['key' => 'changepass']);
                    }else{
                        $this->Flash->error(__('No se subio el archivo, intente nuevamente.'),['key' => 'changepass']);
						$this->redirect($this->referer());
                    }
                }else{
                    $this->Flash->error(__('No se subio el archivo, intente nuevamente.'),['key' => 'changepass']);
					$this->redirect($this->referer());
                }
            }else{
                $this->Flash->error(__('No se subio el archivo, intente nuevamente.'),['key' => 'changepass']);
				$this->redirect($this->referer());
            }
						
			if ($this->Curriculums->save($curriculum)) {
                $this->Flash->success(__('El curriculum fue envio.'),['key' => 'changepass']);

                return $this->redirect(['action' => 'index']);
			}
			
            $this->Flash->error(__('El curriculum no fue enviado. Por Favor intente de nuevo.'),['key' => 'changepass']);
        }
		
		$sectors =  $this->Curriculums->Sectors->find('list', ['keyField' => 'id','valueField' => 'nombre']);
		$sectors=$sectors ->toArray();
        $this->set(compact('curriculum','sectors','provincias'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Curriculum id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $curriculum = $this->Curriculums->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $curriculum = $this->Curriculums->patchEntity($curriculum, $this->request->getData());
            if ($this->Curriculums->save($curriculum)) {
                $this->Flash->success(__('The curriculum has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The curriculum could not be saved. Please, try again.'));
        }
        //$sectors = $this->Curriculums->Sectors->find('list', ['limit' => 200]);
        $this->set(compact('curriculum' ));
    }

    /**
     * Delete method
     *
     * @param string|null $id Curriculum id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete_admin($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $curriculum = $this->Curriculums->get($id);
        if ($this->Curriculums->delete($curriculum)) {
            $this->Flash->success(__('The curriculum has been deleted.'));
        } else {
            $this->Flash->error(__('The curriculum could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index_admin']);
    }
}
