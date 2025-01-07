<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Cake\Database\Expression\QueryExpression;
use Cake\Datasource\ConnectionManager;

/**
 * OfertasTipos Controller
 *
 * @property \App\Model\Table\OfertasTiposTable $OfertasTipos
 */
class OfertasTiposController extends AppController
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
	if (in_array($this->request->action, ['index_admin','edit_admin','delete_admin','view_admin','index_admin_search','add_admin'])) {
       
            if($this->request->session()->read('Auth.User.role')=='admin') 
            {				
                return true;			
            }			
            else 
				{	
						if($this->request->session()->read('Auth.User.role')=='client') 
						{	
						$tiene= $this->tienepermiso('ofertas',$this->request->action);
						if (!$tiene)
							$this->Flash->error(__('No tiene permisos para ingresar'),['key' => 'changepass']);
						return $tiene;			
						}	
						else
						{
						$this->Flash->error(__('No tiene permisos para ingresar'),['key' => 'changepass']);
						$this->redirect($this->referer());
								
					
						return false;	
						}
				}		
            }		
			else 
			{			
				$this->Flash->error(__('No tiene permisos para ingresar'),['key' => 'changepass']);		
				$this->redirect($this->referer());	
				return false;	
				
			}
		return parent::isAuthorized($user);
	}


    public function index_admin()
    {
		$this->viewBuilder()->layout('admin2');
        $this->paginate = [
			'limit' => 100,
			'contain'=>[]
		];
		
		if ($this->request->is('post','get')) {
			
			
			if ($this->request->data['termino']!= null)
				$termsearchp = '%'.$this->request->data['termino'].'%';
			else
				$termsearchp ="";
            if ($this->request->data['ubicacion']!= null)
				$ubicacion = $this->request->data['ubicacion'];
			else
				$ubicacion =0;
						
			
			
            $ofertastipos = $this->OfertasTipos->find('all');
            
            if ($termsearchp!="")
                $ofertastipos->where(['nombre LIKE'=>$termsearchp]);
            if ($ubicacion  !=0)	
                $ofertastipos->where(['ubicacion'=>$ubicacion]);

            if ($ofertastipos!=null)
                $ofertastipos = $this->paginate($ofertastipos->order(['OfertasTipos.id'=>'DESC']));
            else
                $ofertastipos = null;		
		}
		else
		{
            
			$ofertastipos = $this->paginate($this->OfertasTipos->find('all')->order(['id'=>'DESC']));
		}
		
		//$OfertasTipos =  $this->OfertasTipos->find('list', ['keyField' => 'id','valueField' => 'nombre']);
		
        $this->set('ofertastipos',$ofertastipos->toArray());
				
		
        
        $this->set('_serialize', ['ofertastipos']);
		$this->set('titulo','Lista de Tipos de Ofertas');
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('ofertasTipos', $this->paginate($this->OfertasTipos));
        $this->set('_serialize', ['ofertasTipos']);
    }

    /**
     * View method
     *
     * @param string|null $id Ofertas Tipo id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $ofertasTipo = $this->OfertasTipos->get($id, [
            'contain' => []
        ]);
        $this->set('ofertasTipo', $ofertasTipo);
        $this->set('_serialize', ['ofertasTipo']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add_admin()
    {
        $this->viewBuilder()->layout('admin2');
        $ofertasTipo = $this->OfertasTipos->newEntity();
        if ($this->request->is('post')) {
            $ofertasTipo = $this->OfertasTipos->patchEntity($ofertasTipo, $this->request->data);
            if ($this->OfertasTipos->save($ofertasTipo)) {
                $this->Flash->success(__('The ofertas tipo has been saved.'),['key' => 'changepass']);		
                return $this->redirect(['action' => 'index_admin']);
            } else {
                $this->Flash->error(__('The ofertas tipo could not be saved. Please, try again.'),['key' => 'changepass']);		
            }
        }
        $this->set(compact('ofertasTipo'));
        $this->set('_serialize', ['ofertasTipo']);
        $this->set('titulo','Agregar Tipo de Oferta');
    }

    /**
     * Edit method
     *
     * @param string|null $id Ofertas Tipo id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit_admin($id = null)
    {
        $this->viewBuilder()->layout('admin2');
        $ofertasTipo = $this->OfertasTipos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ofertasTipo = $this->OfertasTipos->patchEntity($ofertasTipo, $this->request->data);
            if ($this->OfertasTipos->save($ofertasTipo)) {
                $this->Flash->success(__('The ofertas tipo has been saved.'),['key' => 'changepass']);		
                return $this->redirect(['action' => 'index_admin']);
            } else {
                $this->Flash->error(__('The ofertas tipo could not be saved. Please, try again.'),['key' => 'changepass']);		
            }
        }
        $this->set(compact('ofertasTipo'));
        $this->set('_serialize', ['ofertasTipo']);
        $this->set('titulo','Editar Tipo de Oferta');
    }

    /**
     * Delete method
     *
     * @param string|null $id Ofertas Tipo id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete_admin($id = null)
    {
        $this->viewBuilder()->layout('admin2');
        $this->request->allowMethod(['post', 'delete','ajax']);
        $id = $this->request->getData('id');
        
        $ofertasTipo = $this->OfertasTipos->get($id);
        if ($this->OfertasTipos->delete($ofertasTipo)) {
            $responseData = ['success' => true, 'responseText' => "eliminado", 'status' => 200];

            $this->response->body(json_encode($responseData));
            

            return $this->response;

        } else {
            $this->Flash->error(__('The ofertas tipo could not be deleted. Please, try again.'),['key' => 'changepass']);		
        }
        /*$response = ['ok'];
        echo json_encode($response);
        $this->set('response', $response);
         */
    }
}
