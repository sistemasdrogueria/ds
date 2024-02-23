<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
/**
 * Cortes Controller
 *
 * @property \App\Model\Table\CortesTable $Cortes
 *
 * @method \App\Model\Entity\Corte[] paginate($object = null, array $settings = [])
 */
class CortesController extends AppController
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
					$tiene= $this->tienepermiso('cortes',$this->request->action);
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
    public function index_admin()
    {
        $this->paginate = [		
            'contain' => ['Transportes'],
			'maxLimit'=>500,
			'limit' => 500,
            'offset' => 0,
            'order' => ['salida_n_id' => 'asc','salida_d_id'=>'asc']];


        $this->set('titulo','Horarios de cortes');
   


		if ($this->request->is('post','get')) {
			
			if ($this->request->data['transporte_id']!= null)
				$transporte_id = $this->request->data['transporte_id'];
			else
				$transporte_id=0;
			if ($this->request->data['termino']!= null)
				$termino = $this->request->data['termino'];
			else
				$termino ="";
			
			
			
		
			$this->request->session()->write('termino',$termino);
			$this->request->session()->write('transporte_id',$transporte_id);	

			if (($termino !=0) || ($transporte_id !=0))
				{	
					$cortesH = $this->Cortes->find('all');
				}
			else
				{
					$cortesH=null;
					//$this->redirect($this->referer());
				}	
			
	
	
		if ($termino !="") 
			$cortesH->andWhere(['Cortes.codigo' =>$termino]);
	  	if ($transporte_id!=0 && $transporte_id!="")
             $cortesH->andWhere(['OR' => [['salida_n_id'=>$transporte_id],['salida_d_id'=>$transporte_id],['salida_f_id'=>$transporte_id]]]);
			
             $cortes = $this->paginate($cortesH);

		}
		else
		{
			
			
			$termino = $this->request->session()->read('termino');
		    $transporte_id = $this->request->session()->read('transporte_id');
            $cortes = $this->paginate($this->Cortes->find());
			
		}


        $this->loadModel('Transportes');
        $salidas = $this->Transportes->find('list',['keyField' => 'id','valueField'=>'nombre']);
        $this->viewBuilder()->layout('admin');
        $this->set('salidas', $salidas->toArray()); 
        
        $this->viewBuilder()->layout('admin');
        $this->set(compact('cortes'));
        $this->set('_serialize', ['cortes']);
   
    }

    /**
     * View method
     *
     * @param string|null $id Corte id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view_admin($id = null)
    {
        $corte = $this->Cortes->get($id, [
            'contain' => ['Transportes']
        ]);
        $this->viewBuilder()->layout('admin');
        $this->set('corte', $corte);
        $this->set('_serialize', ['corte']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add_admin()
    {
        $this->set('titulo','Agregar horario de corte');
        $corte = $this->Cortes->newEntity();
        if ($this->request->is('post')) {
            $corte = $this->Cortes->patchEntity($corte, $this->request->getData());
            // Obtener la fecha y hora actual
            $fechaActual = Time::now();
            // Establecer una hora particular (por ejemplo, 15:30:00)
            if ($corte['dia_n'] ==0 && $corte['dia_d']==0)
            {
                $horaN = clone $fechaActual;
                $horaD = clone $fechaActual;
                $horaN->modify($corte['hora_n']);
                $horaD->modify($corte['hora_d']);    
                if ($fechaActual> $horaD)
                {
                    $corte['proximo_h'] = $horaN->format('Y-m-d H:i:s');
                    $corte['proximo_d'] = 1;
                }
                else
                {
                    $corte['proximo_h'] = $horaD->format('Y-m-d H:i:s');
                    $corte['proximo_d'] = 0;
                }

            } 
            if ($corte['dia_n'] ==0 && $corte['dia_d']==8)
            {
                
                $horaN = clone $fechaActual;
                $horaN->modify($corte['hora_n']->format('H:i:s'));
                $corte['proximo_h'] = $horaN->format('Y-m-d H:i:s');
                $corte['proximo_d'] = 1;
                
                $this->request->session()->write('hora_N', $corte['hora_n']);

            }
            if ($corte['dia_d'] ==0 && $corte['dia_n']==8)
            {
                $horaD = clone $fechaActual;
                $horaD->modify($corte['hora_d']);
                
                $corte['proximo_h'] = $horaD->format('Y-m-d H:i:s');
                $corte['proximo_d'] = 1;
            }


            if ($this->Cortes->save($corte)) {
                $this->Flash->success(__('The corte has been saved.'),['key' => 'changepass']);

                return $this->redirect(['action' => 'index_admin']);
            }
            $this->Flash->error(__('The corte could not be saved. Please, try again.'),['key' => 'changepass']);
        }
        $this->loadModel('Transportes');
        $salidas = $this->Transportes->find('list',['keyField' => 'id','valueField'=>'nombre']);
        $this->viewBuilder()->layout('admin');
        $this->set('salidas', $salidas->toArray());    
        $this->set(compact('corte'));
        $this->set('_serialize', ['corte']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Corte id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit_admin($id = null)
    {
        $this->set('titulo','Editar horario de corte');
        $this->viewBuilder()->layout('admin');
        $corte = $this->Cortes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $corte = $this->Cortes->patchEntity($corte, $this->request->getData());
            if ($this->Cortes->save($corte)) {
                $this->Flash->success(__('SE MODIFICO'),['key' => 'changepass']);
                return $this->redirect(['action' => 'index_admin']);
            }
            $this->Flash->error(__('The corte could not be saved. Please, try again.'),['key' => 'changepass']);
        }
        
        $this->loadModel('Transportes');
        $salidas = $this->Transportes->find('list',['keyField' => 'id','valueField'=>'nombre']);
        $this->viewBuilder()->layout('admin');
        $this->set('salidas', $salidas->toArray());    
        
        $this->set(compact('corte'));
        $this->set('_serialize', ['corte']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Corte id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete_admin($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $corte = $this->Cortes->get($id);
        if ($this->Cortes->delete($corte)) {
            $this->Flash->success(__('The corte has been deleted.'),['key' => 'changepass']);
        } else {
            $this->Flash->error(__('The corte could not be deleted. Please, try again.'),['key' => 'changepass']);
        }

        return $this->redirect(['action' => 'index_admin']);
    }
}
