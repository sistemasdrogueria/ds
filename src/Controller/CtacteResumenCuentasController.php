<?php
namespace App\Controller;
use Cake\I18n\Time;
use App\Controller\AppController;
use Cake\Filesystem\File;
/**
 * CtacteResumenCuentas Controller
 *
 * @property \App\Model\Table\CtacteResumenCuentasTable $CtacteResumenCuentas
 *
 * @method \App\Model\Entity\CtacteResumenCuenta[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CtacteResumenCuentasController extends AppController
{
	public function isAuthorized()
    {
		if (in_array($this->request->action, ['search','home','index','downloadfile'])) {
       
				if($this->request->session()->read('Auth.User.role')=='admin') 
				{				
					return true;			
				}			
				else 
				{	
					if($this->request->session()->read('Auth.User.role')=='client') 
					{	
						$tiene= $this->tienepermiso('ctacteresumencuentas',$this->request->action);
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
     * @return \Cake\Http\Response|void
     */
   public function index()
    {
		$this->viewBuilder()->layout('store');
		$ctactesemanas =$this->CtacteResumenCuentas->find('all')->order(['nro_sistema' => 'DESC']);
			
		$first =0;
		foreach ($ctactesemanas as $opcion) {
			if ($first==0)
			{
				$first=date_format($opcion['desde'],'Ymd');
				
			}
			$semanas[date_format($opcion['desde'],'Ymd')] = date_format($opcion['desde'],'d-m-Y').' al '.date_format($opcion['hasta'],'d-m-Y'). ' Semana '.$opcion['nro_sistema'];    
		}	
		$semanas[$first]="Seleccione Semana";
		 	$clientes=Array();
		if ($this->request->session()->read('Auth.User.cuentaprincipal')==1 && $this->request->session()->read('Auth.User.grupo')>0)
		{
			$this->loadModel('Clientes');
			
			$Clientes = $this->Clientes->find('all')->Select(['id','codigo','nombre'])->where(['grupo_id'=>$this->request->session()->read('Auth.User.grupo')]);
			$first =0;
			foreach ($Clientes as $opcion) {
			
				$clientes[$opcion['codigo']] = $opcion['codigo'].' - '.$opcion['nombre'];    
			}	
			 
		}
		else
		{
			$clientes[$this->request->session()->read('Auth.User.codigo')] = $this->request->session()->read('Auth.User.codigo').' - '.$this->request->session()->read('Auth.User.razon');
		}
		$this->set('clientes',$clientes);		
		//$this->request->session()->write('Auth.User.grupo',$cliente['grupo_id']);	
		
        $this->set('ctacteResumenCuentas', $semanas);
		//$this->set('ctacteResumenSemanales', $this->CtacteResumenSemanales);
        $this->set('_serialize', ['ctacteResumenCuentas']);
    }
    
	
		public function listadocliente()
	{
		$clientes=Array();
		if ($this->request->session()->read('Auth.User.cuentaprincipal')==1 && $this->request->session()->read('Auth.User.grupo')>0)
		{
			$this->loadModel('Clientes');
			$Clientes = $this->Clientes->find('all')->Select(['id','codigo','nombre'])->where(['grupo_id'=>$this->request->session()->read('Auth.User.grupo')]);
			foreach ($Clientes as $opcion) {
				$clientes[$opcion['id']] = $opcion['codigo'].' - '.$opcion['nombre'];    
			}	 
		}
		else
		{
			$clientes[$this->request->session()->read('Auth.User.cliente_id')] = $this->request->session()->read('Auth.User.codigo').' - '.$this->request->session()->read('Auth.User.razon');
			$this->loadModel('Clientes');
			if ($this->request->session()->read('Auth.User.codigo_postal')==9410 || $this->request->session()->read('Auth.User.codigo_postal')==9420)
			{
				if ($this->request->session()->read('Auth.User.codigo')>71000)
				{
				$Clientes = $this->Clientes->find('all')
					->Select(['Clientes.id','Clientes.codigo','Clientes.nombre','ce.cliente_export_id','ce.cta_comun','ce.cliente_comun_id'])
					->join(['ce' => ['table' => 'clientes_exports','type' => 'INNER','conditions' => 'ce.cliente_export_id = Clientes.id']])
					->where(['Clientes.id'=>$this->request->session()->read('Auth.User.cliente_id')]);
				foreach ($Clientes as $opcion) {
					$clientes[$opcion['ce']['cliente_comun_id']] = $opcion['ce']['cta_comun'].' - '.$this->request->session()->read('Auth.User.razon');    
				}	 
				}
					
			}
		}
		$this->set('clientes',$clientes);
		
		$this->request->session()->write('clientes',$clientes);
		return $clientes;
	}
	
	public function downloadfile ($numero = null, $codigo =null){
			$this->response->type('pdf');
			$nombreArchivo ='RCTA';
			$nota =str_pad($codigo, 6, '0', STR_PAD_LEFT).
								   str_pad($numero, 8, '0', STR_PAD_LEFT);
			
			
			$nombre_fichero = 'temp'. DS .'Comprobantes'. DS .$nombreArchivo.$nota.'.pdf';

			if (file_exists($nombre_fichero)) {
					$this->response->file(
					$nombre_fichero,
					['download' => true, 'name' => $nombreArchivo.$nota.'.pdf']
					);
					return $this->response;
			}
			else
			{ 
				$this->Flash->error(__('Momentaneamente no disponible, intente mas tarde.'),['key' => 'changepass']);
				$this->redirect($this->referer());
			}
		}
    /**
     * View method
     *
     * @param string|null $id Ctacte Resumen Cuenta id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $ctacteResumenCuenta = $this->CtacteResumenCuentas->get($id, [
            'contain' => []
        ]);

        $this->set('ctacteResumenCuenta', $ctacteResumenCuenta);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $ctacteResumenCuenta = $this->CtacteResumenCuentas->newEntity();
        if ($this->request->is('post')) {
            $ctacteResumenCuenta = $this->CtacteResumenCuentas->patchEntity($ctacteResumenCuenta, $this->request->getData());
            if ($this->CtacteResumenCuentas->save($ctacteResumenCuenta)) {
                $this->Flash->success(__('The ctacte resumen cuenta has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ctacte resumen cuenta could not be saved. Please, try again.'));
        }
        $this->set(compact('ctacteResumenCuenta'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Ctacte Resumen Cuenta id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $ctacteResumenCuenta = $this->CtacteResumenCuentas->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ctacteResumenCuenta = $this->CtacteResumenCuentas->patchEntity($ctacteResumenCuenta, $this->request->getData());
            if ($this->CtacteResumenCuentas->save($ctacteResumenCuenta)) {
                $this->Flash->success(__('The ctacte resumen cuenta has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ctacte resumen cuenta could not be saved. Please, try again.'));
        }
        $this->set(compact('ctacteResumenCuenta'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Ctacte Resumen Cuenta id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ctacteResumenCuenta = $this->CtacteResumenCuentas->get($id);
        if ($this->CtacteResumenCuentas->delete($ctacteResumenCuenta)) {
            $this->Flash->success(__('The ctacte resumen cuenta has been deleted.'));
        } else {
            $this->Flash->error(__('The ctacte resumen cuenta could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
