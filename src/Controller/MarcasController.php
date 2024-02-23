<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Marcas Controller
 *
 * @property \App\Model\Table\MarcasTable $Marcas
 */
class MarcasController extends AppController
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
		 if (in_array($this->request->action, ['edit_admin', 'delete_admin','add_admin','index_admin'])) {
       
            if($this->request->session()->read('Auth.User.role')=='admin') 
            {				
                return true;			
            }			
            else 
            {	
                if($this->request->session()->read('Auth.User.role')=='client') 
                {				
					$tiene= $this->tienepermiso('Marcas',$this->request->action);
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
     * @return void
     */
    public function index_admin()
    {
 
        $this->paginate = [		
			'maxLimit'=>500,
			'limit' => 500,
            'offset' => 0,
            'order' => ['Marcas.id' => 'desc']];
            
        if ($this->request->is('post','get')) {

			if ($this->request->data['termino']!= null)
				$termsearchp = '%'.strtoupper($this->request->data['termino']).'%';
			else
        		$termsearchp ="";
            if ($this->request->data['marcatipo']!= null)
				$marcatipo = $this->request->data['marcatipo'];
			else
				$marcatipo=0;

        

		    $this->request->session()->write('termsearchp',$termsearchp);
            $this->request->session()->write('marcatipo',$marcatipo);

		    if (($termsearchp !="") || ($marcatipo!=0))
				{	
					$marcasA = $this->Marcas->find('all');
				}
			else
				{
					$marcasA=null;
				}	
			
	
	
	
	  	    if ($termsearchp!="")
                $marcasA->where(['nombre LIKE'=>$termsearchp]);
            if ($marcatipo!=0)
                $marcasA->where(['marcas_tipos_id LIKE'=>$marcatipo]);
                
			if ($marcasA!=null)
				$marcas = $this->paginate($marcasA);
			else
				$marcas = null;		
        
                
            }
            else
		{
		
			
			$marcas = $this->paginate($this->Marcas->find());
		}






        
            
        $this->set('titulo','Agregar Logo - Marca');
        $this->viewBuilder()->layout('admin');
        $this->set('marcas', $marcas);
        $this->set('_serialize', ['marcas']);
        $this->loadModel('MarcasTipos');
        $marcastipos = $this->MarcasTipos->find('list',['keyField' => 'id','valueField'=>'nombre'])->order(['nombre'=>'ASC']);
        $this->set('marcastipos', $marcastipos->toArray());
        $this->set('_serialize', ['marcastipos']);
        
	
    }

    /**
     * View method
     *
     * @param string|null $id Marca id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view_admin($id = null)
    {
        $this->set('titulo','Marca');
       
        $this->viewBuilder()->layout('admin');
        $marca = $this->Marcas->get($id, [
            'contain' => ['Fragancias']
        ]);
        $this->set('marca', $marca);
        $this->set('_serialize', ['marca']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add_adminx()
    {
        $this->viewBuilder()->layout('admin');
        $marca = $this->Marcas->newEntity();
        if ($this->request->is('post')) {
            $marca = $this->Marcas->patchEntity($marca, $this->request->data);
            if ($this->Marcas->save($marca)) {
                $this->Flash->success(__('The marca has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The marca could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('marca'));
        $this->set('_serialize', ['marca']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Marca id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit_adminx($id = null)
    {
        $this->set('titulo','Editar Marca');
        
        $this->viewBuilder()->layout('admin');
        $marca = $this->Marcas->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $marca = $this->Marcas->patchEntity($marca, $this->request->data);
            if ($this->Marcas->save($marca)) {
                $this->Flash->success(__('The marca has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The marca could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('marca'));
        $this->set('_serialize', ['marca']);
    }

    public function edit_admin($id = null)
    {
        $this->loadModel('MarcasTipos');
        $marcastipos = $this->MarcasTipos->find('list',['keyField' => 'id','valueField'=>'nombre']);
        $this->set('marcastipos', $marcastipos->toArray());
        $this->set('_serialize', ['marcastipos']);
	    $this->loadModel('Laboratorios');
		$laboratorios = $this->Laboratorios->find('list',['keyField' => 'id','valueField'=>'nombre'])->where(['eliminado=0'])->order(['nombre' => 'ASC']);
		$this->set('laboratorios',$laboratorios->toArray());

        $this->viewBuilder()->layout('admin');
       $marca = $this->Marcas->get($id, [
            'contain' => []
        ]);

		if ($this->request->is(['patch', 'post', 'put'])) {
            $marca = $this->Marcas->patchEntity($marca, $this->request->getData());

			$uploadData = '';
			if(!empty($this->request->data['file']['name'])){
                $fileName = $this->request->data['file']['name'];
                if ($this->request->data['file']['size'] >614400)
				{
					$this->Flash->error(__('Supero Los 600kb, demasiado grande la imagen.'),['key' => 'changepass']);
					$this->redirect($this->referer());

				}
             	
                if ($marca['marcas_tipos_id']!=11 && $marca['marcas_tipos_id']!=12)
                $uploadPath = 'img/marcas/';
                else
                {
                $uploadPath = 'img/logos/';
                $extension = ".jpg";
                if ($this->request->data['file']['type'] =='image/jpeg')
                $extension = ".jpg";
                if ($this->request->data['file']['type'] =='image/png')
                $extension = ".png";
                if ($this->request->data['file']['type'] =='image/gif')
                $extension = ".gif";
                $fileName = $marca['laboratorio_id'].$extension;               
                }

                $uploadFile = $uploadPath.$fileName;
				$marca['imagen']= $fileName;
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
			
			if ($this->Marcas->save($marca)) {
                
				$this->Flash->success('La Marca se guardo correctamente.',['key' => 'changepass']);
                return $this->redirect(['action' => 'index_admin']);
            } else {
                $this->Flash->error('La Marca no se guardo.',['key' => 'changepass']);
            }
        }


		
	   $this->set(compact('marca'));

		$this->set('titulo','Modificar Logo - Marca');
    }

    /**
     * Delete method
     *
     * @param string|null $id Marca id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */

    public function delete_admin($id = null)
    {
		$this->viewBuilder()->layout('admin');
		$id = $this->request->getData('id');
		$this->request->allowMethod(['post', 'get', 'delete', 'ajax']);
		$marca = $this->Marcas->get($id);
		if (!empty($marca)) {

            if ($this->Marcas->delete($marca)) {
			
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

    public function edit_marca_admin()
    {
		$marcas = TableRegistry::get('Marcas');
		$entities = $marcas->newEntities($this->request->getData());
		
		//$ofertas = TableRegistry::get('Ofertas');
		//$entities = $ofertas->newEntities($this->request->data());
		$this->set('entities', $entities);
		
		foreach ($entities as $marca) {
				
				
				$habilitada = $marca['habilitada'];
				$id = $marca['id'];	
				
				$marca = $this->Marcas->get($id,['contain' => []]);
				
				$marca['habilitada'] = $habilitada;	
				
				if ($this->Marcas->save($marca))
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
        $this->loadModel('MarcasTipos');
        $marcastipos = $this->MarcasTipos->find('list',['keyField' => 'id','valueField'=>'nombre']);
        $this->set('marcastipos', $marcastipos->toArray());
        $this->set('_serialize', ['marcastipos']);

		$this->loadModel('Laboratorios');
		$laboratorios = $this->Laboratorios->find('list',['keyField' => 'id',
        'valueField' => function ($row) {
            return $row['nombre'] . ' - ' . $row['codigo']; // Unir los dos campos
        }])->where(['eliminado=0'])->order(['nombre' => 'ASC']);
		$this->set('laboratorios',$laboratorios->toArray());

		$this->viewBuilder()->layout('admin');
		$this->set('titulo','Logos - Marcas');
        $marca = $this->Marcas->newEntity();
        if ($this->request->is('post')) {
            $marca = $this->Marcas->patchEntity($marca, $this->request->data);

			$uploadData = '';
			if(!empty($this->request->data['file']['name'])){

				if ($this->request->data['file']['size'] >614400)
				{
					$this->Flash->error(__('Supero Los 600kb, demasiado grande la imagen.'),['key' => 'changepass']);
					$this->redirect($this->referer());

				}
                $fileName = $this->request->data['file']['name'];
				
                if ($marca['marcas_tipos_id']!=11 && $marca['marcas_tipos_id']!=12)
                    $uploadPath = 'img/marcas/';
                 else
                {
                    $uploadPath = 'img/logos/';
                    $extension = ".jpg";
                    if ($this->request->data['file']['type'] =='image/jpeg')
                    $extension = ".jpg";
                    if ($this->request->data['file']['type'] =='image/png')
                    $extension = ".png";
                    if ($this->request->data['file']['type'] =='image/gif')
                    $extension = ".gif";


                    $fileName = $marca['laboratorio_id'].$extension;               
                }
                
                $uploadFile = $uploadPath.$fileName;
				$marca['imagen']= $fileName;
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

            if ($this->Marcas->save($marca)) {

                $this->Flash->success(__('La Marca fue cargada correctamente'),['key' => 'changepass']);
                return $this->redirect(['action' => 'index_admin']);
            } else {
				$this->Flash->error(__('No se pudo cargar la Marca, intente nuevamente'),['key' => 'changepass']);
                $this->redirect($this->referer());	
            }
        }
		
        $this->set(compact('marca'));
        $this->set('_serialize', ['marca']);
    }
	
}
