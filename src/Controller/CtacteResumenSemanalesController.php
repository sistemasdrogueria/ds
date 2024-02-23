<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CtacteResumenSemanales Controller
 *
 * @property \App\Model\Table\CtacteResumenSemanalesTable $CtacteResumenSemanales
 */
class CtacteResumenSemanalesController extends AppController
{
	public function isAuthorized()
    {
		if (in_array($this->request->action, ['home','index','index_admin','view_admin','downloadfile','downloadexcel'])) {
       
				if($this->request->session()->read('Auth.User.role')=='admin') 
				{				
					return true;			
				}			
				else 
				{	
					if($this->request->session()->read('Auth.User.role')=='client') 
					{	
						$tiene= $this->tienepermiso('ctacteresumensemanales',$this->request->action);
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
		$ctactesemanas =$this->CtacteResumenSemanales->find('all')->order(['nro_sistema' => 'DESC']);
			
		$first =0;
		foreach ($ctactesemanas as $opcion) {
			if ($first==0)
			{
				$first=$opcion['nro_sistema'];
				
			}
			$semanas[$opcion['nro_sistema']] = date_format($opcion['desde'],'d-m-Y').' al '.date_format($opcion['hasta'],'d-m-Y'). ' R '.$opcion['nro_sistema'];    
		}	
		$semanas[$first]="Seleccione Semana";
		/*$clientes=Array();
		if ($this->request->session()->read('Auth.User.cuentaprincipal')==1)
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
*/		
		$this->loadModel('Novedades');
		$this->set('novedades', $this->paginate(
			$this->Novedades->find()
			->where(['activo' =>'1','interno' =>'1','importante'=>'2'])
			->order(['id' => 'DESC'])
			));


		$this->listadocliente();
        $this->set('ctacteResumenSemanales', $semanas);
		//$this->set('ctacteResumenSemanales', $this->CtacteResumenSemanales);
        $this->set('_serialize', ['ctacteResumenSemanales']);
		}
	


		public function listadocliente(){
		$clientes=Array();
		$this->loadModel('Clientes');
		if ($this->request->session()->read('Auth.User.cuentaprincipal')==1 && $this->request->session()->read('Auth.User.grupo')>0)
		{
			$Clientes = $this->Clientes->find('all')->Select(['id','codigo','nombre'])->where(['grupo_id'=>$this->request->session()->read('Auth.User.grupo')]);
			foreach ($Clientes as $opcion) {
				$clientes[$opcion['codigo']] = $opcion['codigo'].' - '.$opcion['nombre'];    
			}	 
		}
		else
		{
			$clientes[$this->request->session()->read('Auth.User.codigo')] = $this->request->session()->read('Auth.User.codigo').' - '.$this->request->session()->read('Auth.User.razon');
			if ($this->request->session()->read('Auth.User.codigo_postal')==9410 || $this->request->session()->read('Auth.User.codigo_postal')==9420)
			{
				if ($this->request->session()->read('Auth.User.codigo')>71000)
				{
				$Clientes = $this->Clientes->find('all')
					->Select(['Clientes.id','Clientes.codigo','Clientes.nombre','ce.cliente_export_id','ce.cta_comun','ce.cliente_comun_id'])
					->join(['ce' => ['table' => 'clientes_exports','type' => 'INNER','conditions' => 'ce.cliente_export_id = Clientes.id']])
					->where(['Clientes.id'=>$this->request->session()->read('Auth.User.cliente_id')]);
				foreach ($Clientes as $opcion) {
					$clientes[$opcion['ce']['cta_comun']] = $opcion['ce']['cta_comun'].' - '.$this->request->session()->read('Auth.User.razon');    
					}	 
				}
			}
		}
		$this->set('clientes',$clientes);
		//return $clientes;
	 }
	
	public function index_admin()
    {
		$this->viewBuilder()->layout('admin');
		$ctactesemanas =$this->CtacteResumenSemanales->find('all')->order(['nro_sistema' => 'DESC']);
	
		$first =0;
		foreach ($ctactesemanas as $opcion) {
			if ($first==0)
			{
				$first=$opcion['nro_sistema'];
				
			}
			$semanas[$opcion['nro_sistema']] = date_format($opcion['desde'],'d-m-Y').' al '.date_format($opcion['hasta'],'d-m-Y');    
		}	
		$semanas[$first]="Seleccione Resumen";
		
		$this->loadModel('Clientes');
		$Clientes = $this->Clientes->find('all')->Select(['id','codigo','nombre']);
		foreach ($Clientes as $opcion) {
	
			$clientes[$opcion['codigo']] = $opcion['codigo'].' - '.$opcion['nombre'];    
		}		
		
		
		
		  $this->set('clientes', $clientes);
        $this->set('ctacteResumenSemanales', $semanas);
		//$this->set('ctacteResumenSemanales', $this->CtacteResumenSemanales);
        $this->set('_serialize', ['ctacteResumenSemanales']);
		$this->set('titulo','Resumen Semanal');
    }

	 public function view_admin()
    {
		$this->viewBuilder()->layout('admin');
		$ctactesemanas =$this->CtacteResumenSemanales->find('all')->order(['nro_sistema' => 'DESC']);
		foreach ($ctactesemanas as $opcion) {
			$semanas[$opcion['nro_sistema']] = date_format($opcion['desde'],'d-m-Y').' al '.date_format($opcion['hasta'],'d-m-Y');    
		}		
		
        $this->set('ctacteResumenSemanales', $semanas);
		//$this->set('ctacteResumenSemanales', $this->CtacteResumenSemanales);
        $this->set('_serialize', ['ctacteResumenSemanales']);
		$this->set('titulo','Resumen Semanal');
    }
	
	
	
    /**
     * View method
     *
     * @param string|null $id Ctacte Resumen Semanale id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $ctacteResumenSemanale = $this->CtacteResumenSemanales->get($id, [
            'contain' => []
        ]);
        $this->set('ctacteResumenSemanale', $ctacteResumenSemanale);
        $this->set('_serialize', ['ctacteResumenSemanale']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $ctacteResumenSemanale = $this->CtacteResumenSemanales->newEntity();
        if ($this->request->is('post')) {
            $ctacteResumenSemanale = $this->CtacteResumenSemanales->patchEntity($ctacteResumenSemanale, $this->request->data);
            if ($this->CtacteResumenSemanales->save($ctacteResumenSemanale)) {
                $this->Flash->success(__('The ctacte resumen semanale has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The ctacte resumen semanale could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('ctacteResumenSemanale'));
        $this->set('_serialize', ['ctacteResumenSemanale']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Ctacte Resumen Semanale id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $ctacteResumenSemanale = $this->CtacteResumenSemanales->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ctacteResumenSemanale = $this->CtacteResumenSemanales->patchEntity($ctacteResumenSemanale, $this->request->data);
            if ($this->CtacteResumenSemanales->save($ctacteResumenSemanale)) {
                $this->Flash->success(__('The ctacte resumen semanale has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The ctacte resumen semanale could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('ctacteResumenSemanale'));
        $this->set('_serialize', ['ctacteResumenSemanale']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Ctacte Resumen Semanale id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ctacteResumenSemanale = $this->CtacteResumenSemanales->get($id);
        if ($this->CtacteResumenSemanales->delete($ctacteResumenSemanale)) {
            $this->Flash->success(__('The ctacte resumen semanale has been deleted.'));
        } else {
            $this->Flash->error(__('The ctacte resumen semanale could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

	public function downloadexcel($numero , $codigo){
		
		$this->viewBuilder()->layout('ajax');
		
		$ctactesemanas =$this->CtacteResumenSemanales->find('all')->where(['nro_sistema' => $numero])->first([]);
		$this->set('ctactesemanas', $ctactesemanas);
		$this->loadModel('Clientes');
		$cliente = $this->Clientes->find('all')->where(['codigo' => $codigo])->first([]);
		$this->set('cliente', $cliente);
		$this->loadModel('FacturasCabeceras');
        $this->paginate = [
            'contain' => ['Comprobantes'],
			'limit' => 2000,
			'maxLimit' => 2000,
        ];
		
		//$fechad= Time::createFromFormat('Y-m-d H:i:s',$ctactesemanas['desde'],'America/New_York');
		//$fechah= Time::createFromFormat('Y-m-d H:i:s',$ctactesemanas['hasta'],'America/New_York');
		$fechad= $ctactesemanas['desde'];
		$fechah= $ctactesemanas['hasta'];

		$facturascabeceras = $this->FacturasCabeceras->find('all')	
					->join([
					'c' => [
						'table' => 'comprobantes',
						'type' => 'LEFT',
						'conditions' => 'FacturasCabeceras.comprobante_id = c.id',
					]
					])
					
					->where(['FacturasCabeceras.cliente_id' => $cliente['id'], 'c.anulado=0'])
					
					->andWhere(["FacturasCabeceras.fecha BETWEEN '".$fechad->i18nFormat('yyyy-MM-dd')."' AND '".$fechah->i18nFormat('yyyy-MM-dd')."'"])
					->order(['FacturasCabeceras.fecha' => 'ASC','FacturasCabeceras.pedido_ds' => 'ASC'])
					
					//->order(['FacturasCabeceras.fecha' => 'ASC','FacturasCabeceras.pedido_ds' => 'ASC' ])
					->group('FacturasCabeceras.pedido_ds');
		
		//$facturascabeceras->order(['FacturasCabeceras.fecha' => 'ASC']);
		$this->loadModel('NotasCabeceras');
		$notascabeceras = $this->NotasCabeceras->find('all')	
					->contain(['Comprobantes'])
					->join([
					'c' => [
						'table' => 'comprobantes',
						'type' => 'LEFT',
						'conditions' => 'NotasCabeceras.comprobante_id = c.id',
					]
					])
					
					->where(['NotasCabeceras.cliente_id' => $cliente['id']])
					->andWhere(["NotasCabeceras.fecha BETWEEN '".$fechad->i18nFormat('yyyy-MM-dd')."' AND '".$fechah->i18nFormat('yyyy-MM-dd')."'"])
					
					//->andWhere(["NotasCabeceras.fecha BETWEEN '".$fecha->i18nFormat('yyyy-MM-dd')."' AND '".$fecha2->i18nFormat('yyyy-MM-dd')."'"])
					->order(['NotasCabeceras.fecha' => 'ASC'])
					->group('NotasCabeceras.nota');

					
		$this->request->session()->write('notasCabeceras',$notascabeceras->toArray());
		
		$this->request->session()->write('facturasCabeceras',$this->paginate($facturascabeceras));
		
        $this->set('facturasCabeceras', $this->paginate($facturascabeceras));
        $this->set('notasCabeceras', $notascabeceras->toArray());
        
		$this->set('_serialize', ['facturasCabeceras']);
		$this->set('_serialize', ['notasCabeceras']);
		$this->response->type('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	}
		
	public function downloadfile ($numero = null, $codigo =null){
			$this->response->type('pdf');
			$nombreArchivo ='RESU';
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
	
}
