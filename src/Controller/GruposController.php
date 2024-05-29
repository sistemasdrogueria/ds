<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Grupos Controller
 *
 * @property \App\Model\Table\GruposTable $Grupos
 *
 * @method \App\Model\Entity\Grupo[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class GruposController extends AppController
{

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
					$tiene= $this->tienepermiso('Grupos',$this->request->action);
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


    public function index_admin()
    {
 
        $this->paginate = [		
			'maxLimit'=>500,
			'limit' => 500,
            'offset' => 0,
            'order' => ['Grupos.id' => 'desc']];
            
        if ($this->request->is('post','get')) {

			if ($this->request->data['termino']!= null)
				$termsearchp = '%'.$this->request->data['termino'].'%';
			else
        		$termsearchp ="";
            if ($this->request->data['grupotipo']!= null)
				$grupotipo = $this->request->data['grupotipo'];
			else
				$grupotipo=0;

        

		    $this->request->session()->write('termsearchp',$termsearchp);
            $this->request->session()->write('grupotipo',$grupotipo);

		    if (($termsearchp !="") || ($grupotipo!=0))
				{	
					$gruposA = $this->Grupos->find('all');
				}
			else
				{
					$gruposA=null;
				}	
			
	
	
	
	  	    if ($termsearchp!="")
                $gruposA->where(['Grupos.nombre LIKE'=>$termsearchp]);
            if ($grupotipo!=0)
                $gruposA->where(['Grupos.grupos_tipos_id LIKE'=>$grupotipo]);
                
			if ($gruposA!=null)
				$grupos = $this->paginate($gruposA);
			else
				$grupos = null;		
        
                
            }
            else
		{
		
			
			$grupos = $this->paginate($this->Grupos->find());
		}






        
            
        $this->set('titulo','Grupos');
        $this->viewBuilder()->layout('admin');
        $this->set('grupos', $grupos);
        $this->set('_serialize', ['grupos']);
        $this->loadModel('GruposTipos');
        $grupostipos = $this->GruposTipos->find('list',['keyField' => 'id','valueField'=>'nombre']);
        $this->set('grupostipos', $grupostipos->toArray());
        $this->set('_serialize', ['grupostipos']);
        
	
    }

    /**
     * View method
     *
     * @param string|null $id Grupo id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view_admin($id = null)
    {
        $this->set('titulo','Grupo');
       
        $this->viewBuilder()->layout('admin');
        $grupo = $this->Grupos->get($id, [
            
        ]);
        $this->set('grupo', $grupo);
        $this->set('_serialize', ['grupo']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Subcategorias']
        ];
        $grupos = $this->paginate($this->Grupos);

        $this->set(compact('grupos'));
    }

    /**
     * View method
     *
     * @param string|null $id Grupo id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $grupo = $this->Grupos->get($id, [
            'contain' => ['Subcategorias', 'Articulos', 'Subgrupos']
        ]);

        $this->set('grupo', $grupo);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $grupo = $this->Grupos->newEntity();
        if ($this->request->is('post')) {
            $grupo = $this->Grupos->patchEntity($grupo, $this->request->getData());
            if ($this->Grupos->save($grupo)) {
                $this->Flash->success(__('The grupo has been saved.'),['key' => 'changepass']);

                return $this->redirect(['action' => 'index_admin']);
            }
            $this->Flash->error(__('The grupo could not be saved. Please, try again.'),['key' => 'changepass']);
        }
        $subcategorias = $this->Grupos->Subcategorias->find('list', ['limit' => 200]);
        $ctacteTipoPagos = $this->Grupos->CtacteTipoPagos->find('list', ['limit' => 200]);
        $this->set(compact('grupo', 'subcategorias'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Grupo id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $grupo = $this->Grupos->get($id, [
           
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $grupo = $this->Grupos->patchEntity($grupo, $this->request->getData());
            if ($this->Grupos->save($grupo)) {
                $this->Flash->success(__('The grupo has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The grupo could not be saved. Please, try again.'));
        }
        $subcategorias = $this->Grupos->Subcategorias->find('list', ['limit' => 200]);
        $ctacteTipoPagos = $this->Grupos->CtacteTipoPagos->find('list', ['limit' => 200]);
        $this->set(compact('grupo', 'subcategorias' ));
    }

    /**
     * Delete method
     *
     * @param string|null $id Grupo id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $grupo = $this->Grupos->get($id);
        if ($this->Grupos->delete($grupo)) {
            $this->Flash->success(__('The grupo has been deleted.'));
        } else {
            $this->Flash->error(__('The grupo could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


    public function edit_admin($id = null)
    {
        $this->loadModel('GruposTipos');
        $grupostipos = $this->GruposTipos->find('list',['keyField' => 'id','valueField'=>'nombre']);
        $this->set('grupostipos', $grupostipos->toArray());
        $this->set('_serialize', ['grupostipos']);
	    $this->viewBuilder()->layout('admin');
         $grupo = $this->Grupos->get($id, ['contain' => []]);

 
		if ($this->request->is(['patch', 'post', 'put'])) {
            $grupo = $this->Grupos->patchEntity($grupo, $this->request->getData());

			$uploadData = '';
			if(!empty($this->request->data['file']['name'])){
                $fileName = $this->request->data['file']['name'];
                if ($this->request->data['file']['size'] >614400)
				{
					$this->Flash->error(__('Supero Los 600kb, demasiado grande la imagen.'),['key' => 'changepass']);
					$this->redirect($this->referer());

				}
             
                $uploadPath = 'img/grupos/';
                

                $uploadFile = $uploadPath.$fileName;
				$grupo['imagen']= $fileName;
                if(move_uploaded_file($this->request->data['file']['tmp_name'],$uploadFile)){
                    $this->loadModel('Files');
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
			
			if ($this->Grupos->save($grupo)) {
                
				$this->Flash->success('La Grupo se guardo correctamente.',['key' => 'changepass']);
                return $this->redirect(['action' => 'index_admin']);
            } else {
                $this->Flash->error('La Grupo no se guardo.',['key' => 'changepass']);
            }
        }


		
	   $this->set(compact('grupo'));

		$this->set('titulo','Modificar Logo - Grupo');
    }

    /**
     * Delete method
     *
     * @param string|null $id Grupo id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete_admin($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $grupo = $this->Grupos->get($id);
        if ($this->Grupos->delete($grupo)) {
            $this->Flash->success(__('The grupo has been deleted.'));
        } else {
            $this->Flash->error(__('The grupo could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index_admin']);
    }



    public function add_admin()
    {
        $this->loadModel('GruposTipos');
        $grupostipos = $this->GruposTipos->find('list',['keyField' => 'id','valueField'=>'nombre']);
        $this->set('grupostipos', $grupostipos->toArray());
        $this->set('_serialize', ['grupostipos']);

		$this->viewBuilder()->layout('admin');
		$this->set('titulo','Grupos');
        $grupo = $this->Grupos->newEntity();
        if ($this->request->is('post')) {
            $grupo = $this->Grupos->patchEntity($grupo, $this->request->data);
            $grupo['descripcion']= $grupo['nombre'];
            
            $uploadPath = $_SERVER['DOCUMENT_ROOT'];
			$uploadData ="";
			if(!empty($this->request->data['file']['name'])){

				if ($this->request->data['file']['size'] >614400)
				{
					$this->Flash->error(__('Supero Los 600kb, demasiado grande la imagen.'),['key' => 'changepass']);
					$this->redirect($this->referer());

				}
                $fileName = $this->request->data['file']['name'];
				

				$uploadPath = 'img/grupos/';
			
                    
                $uploadFile = $uploadPath.$fileName;
				
                $grupo['imagen']= $fileName;
                if(file_exists($uploadFile)) {
                    chmod($uploadFile,0755); //Change the file permissions if allowed
                    unlink($uploadFile); //remove the file
                }

                if(move_uploaded_file($this->request->data['file']['tmp_name'],$uploadFile)){
                    $this->loadModel('Files');
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

            if ($this->Grupos->save($grupo)) {

                $this->Flash->success(__('La Grupo fue cargada correctamente'),['key' => 'changepass']);
                return $this->redirect(['action' => 'index_admin']);
            } else {
				$this->Flash->error(__('No se pudo cargar la Grupo, intente nuevamente'),['key' => 'changepass']);
                $this->redirect($this->referer());	
            }
        }
		
        $this->set(compact('grupo'));
        $this->set('_serialize', ['grupo']);
    }
}
