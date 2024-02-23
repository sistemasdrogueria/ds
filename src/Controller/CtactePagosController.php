<?php
namespace App\Controller;
use Cake\I18n\Time;
use App\Controller\AppController;
use Cake\Mailer\Email;
use Cake\Network\Request;
use Cake\Filesystem\File;
use Cake\Event\Event;
/**
 * CtactePagos Controller
 *
 * @property \App\Model\Table\CtactePagosTable $CtactePagos
 */
class CtactePagosController extends AppController
{

	
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['validararchivos']);
    }

public function isAuthorized()
    {
		if (in_array($this->request->action,['index','search','excel','info','enviarsolicitud'])) {
				if($this->request->session()->read('Auth.User.role')=='admin') 
				{				
					return true;			
				}			
				else 
				{	
					if($this->request->session()->read('Auth.User.role')=='client') 
					{	
						$tiene= $this->tienepermiso('ctactepagos',$this->request->action);
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
    
		public function validararchivos(){
		$nombre = $this->request->getData('nombre');
	
		$rutaArchivo = WWW_ROOT . 'temp' . DS . 'Comprobantes' . DS .''.$nombre.'';
		
		 $file = new File($rutaArchivo);
    if ($file->exists()) {
         $archivo =1;
    } else {
         $archivo =0;
    }
		$this->response->body(json_encode($archivo));
		return $this->response;
	}
	
	public function ctactesearchpagos($fecha =null,$fecha2 =null,$opcion=null, $cliente_id=null)
	{
		$this->paginate = [
            'contain' => ['Clientes'],
			'limit' => 500,
			'maxLimit' => 1000
        ];
		
		$totalpagos1=0;
		$totalpagos2=0;
		$totalpagos3=0;
		$totalpagos4=0;
		$totalpagos5=0;
		$totalpagos6=0;

		$pagos = $this->CtactePagos->find('all')
				->select([
				
				'cliente_id', 
				'tipo_pago_id', 
				'fecha_ingreso', 
				'signo', 
				'importe', 
				'tp.grupo'])
				->hydrate(false)
				->join([
					'tp' => [
						'table' => 'ctacte_tipo_pagos',
						'type' => 'left',
						'conditions' => 'tp.id = CtactePagos.tipo_pago_id',
					]
				])
				->where(["CtactePagos.fecha_ingreso BETWEEN '".$fecha->i18nFormat('yyyy-MM-dd')."' AND '".$fecha2->i18nFormat('yyyy-MM-dd')."'"])
				->andWhere(['cliente_id' => $cliente_id]);

		
		$totalpagos=0;						
		foreach ($pagos as $ctactepago): 
				$importesuma = $ctactepago['importe'];
				if ($ctactepago['signo']==1)
					$totalpagos-= $importesuma;	
				else
					$totalpagos+= $importesuma;
			
					
				switch ($ctactepago['tp']['grupo']) {
					case 1:
						$totalpagos1 += $importesuma;
						break;
					case 2:
						$totalpagos2 += $importesuma;
						break;
					case 3:
						$totalpagos3 += $importesuma;
						
						break;
					case 4:
						$totalpagos4 += $importesuma;
						break;
					case 5:
						$totalpagos5 += $importesuma;
						break;
					case 6:
						if ($ctactepago['signo']==1)
						$totalpagos6 -= $importesuma;	
						else
						$totalpagos6 += $importesuma;
						break;	
				}
		endforeach; 
		$pagos = $this->CtactePagos->find('all')
				->select([
				'id', 
				'cliente_id', 
				'tipo_pago_id', 
				'detalle', 
				'fecha_ingreso', 
				'fecha_aplicacion', 
				'nota', 
				'signo', 
				'importe', 
				'chequeo',
				'tp.grupo',
				'tp.nombre'])
				->hydrate(false)
				->join([
					'tp' => [
						'table' => 'ctacte_tipo_pagos',
						'type' => 'left',
						'conditions' => 'tp.id = CtactePagos.tipo_pago_id',
					]
				])
				->where(["CtactePagos.fecha_ingreso BETWEEN '".$fecha->i18nFormat('yyyy-MM-dd')."' AND '".$fecha2->i18nFormat('yyyy-MM-dd')."'"])
				/*
				->where(['fecha_ingreso BETWEEN :start AND :end'])
								->bind(':start', $fecha, 'date')
								->bind(':end',   $fecha2, 'date')*/
				->andWhere(['cliente_id' => $cliente_id]);
		if ($opcion !=0)
				$pagos= $pagos->andWhere(['tp.grupo'=>$opcion]);
		
		$pagos->order(['fecha_ingreso' => 'ASC']);
		$this->set('ctactePagos', $this->paginate($pagos));
		
		
		
		//$this->set('_serialize', ['ctactePagos']);
		$totalpagosX = array($totalpagos1,$totalpagos2,$totalpagos3,$totalpagos4,$totalpagos5,$totalpagos6);
		$this->set('totalpagosX',$totalpagosX);
		return $totalpagos;
	}
	
	
	public function ctactesearchos($fecha =null,$fecha2 =null, $cliente_id=null)
	{
		$this->paginate = [
            'contain' => ['Clientes'],
			'limit' => 500,
			'maxLimit' => 1000
        ];
		
				
		$this->loadModel('CtacteObrasSocialesHistoricos');
		
		$pagos = $this->CtacteObrasSocialesHistoricos->find('all')
				->select([
				'id',
				'cliente_id', 
				
				'fecha', 
				 'signo',
				'importe', 
				'obra_social_id', 
				'nro_nota',
				'ob.id',
				'ob.nombre'])
				
				->join([
					'ob' => [
						'table' => 'obra_sociales',
						'type' => 'left',
						'conditions' => 'ob.id = CtacteObrasSocialesHistoricos.obra_social_id',
					]
				])
				//->where(["CtacteObrasSocialesHistoricos.fecha BETWEEN '".$fecha."' AND '".$fecha2."'"])
				->where(["CtacteObrasSocialesHistoricos.fecha BETWEEN '".$fecha->i18nFormat('yyyy-MM-dd')."' AND '".$fecha2->i18nFormat('yyyy-MM-dd')."'"])
				
				->andWhere(['CtacteObrasSocialesHistoricos.cliente_id' => $cliente_id]);

		
		$totalos=0;	
		$importesuma=0;					
		foreach ($pagos as $ctacteos): 
				$importesuma = str_replace(".", ",", $ctacteos['importe']);
				
			
				if ($ctacteos['signo']==1)
					$totalos -= (int)$importesuma;
				else
				{
					//if (is_numeric($importesuma))
					$totalos += (int)$importesuma;	
				}
		endforeach; 
				
		$pagos->order(['CtacteObrasSocialesHistoricos.fecha' => 'ASC']);
		$this->set('ctactePagosOS', $this->paginate($pagos));
		
		
		
		//$this->set('_serialize', ['ctactePagos']);
		
		$this->set('totalpagos7',$totalos);
		return $totalos;
	}
	

	/**
     * Index method
     *
     * @return void
     */
    public function index()
    {
		$this->viewBuilder()->layout('store');

		if ($this->request->is('post')) {
			if ($this->request->data['cliente_id']!= null)
				$cliente_id = $this->request->data['cliente_id'];
			else
				$cliente_id=$this->request->session()->read('Auth.User.cliente_id');
			if ($this->request->data['tipo_pago_id']=!null)
					$opcion=(int)$this->request->data['tipo_pago_id'];
				else
					$opcion=0;
			if ($this->request->data['fechadesde']!= null)
					$fechadesde = $this->request->data['fechadesde'];
				else
					$fechadesde=0;
			if ($this->request->data['fechahasta']!= null)
					$fechahasta = $this->request->data['fechahasta'];
				else
					$fechahasta =0;
			$this->set('opcion',$opcion);
			if ($fechahasta!=0)
			{
				$fecha2 = Time::createFromFormat('d/m/Y',$fechahasta,'America/Argentina/Buenos_Aires');
				$fecha2->modify('+1 days');
				//$fecha2->i18nFormat('yyyy-MM-dd');
			}
			else
			{
				$fecha2 = Time::now();
				$fecha2-> modify('+1 days');
				//$fecha2-> i18nFormat('yyyy-MM-dd');
			}
			if ($fechadesde!=0)
			{
				$fecha = Time::createFromFormat('d/m/Y',$fechadesde,'America/Argentina/Buenos_Aires');
				//$fecha = $fecha->i18nFormat('yyyy-MM-dd');
			}
			else
			{
				$fecha = Time::now();
				if ($fechahasta!=0)
					$fecha->setDate($fecha->year, $fecha2->month, 1);
				else
					$fecha->setDate($fecha->year, $fecha->month, 1);
				//$fecha = $fecha->i18nFormat('yyyy-MM-dd');
			}
			$this->request->session()->write('cliente_id',$cliente_id);
			$this->request->session()->write('fechadesde2',$fecha);	
			$this->request->session()->write('fechahasta2',$fecha2);
		}
		else
		{
			$fecha = Time::now();
			$fecha->setDate($fecha->year, $fecha->month, 1);
			//$fecha=$fecha->i18nFormat('yyyy-MM-dd');
			
			$fecha2 = Time::now();
			$fecha2->modify('+1 days');
			//$fecha2= $fecha2->i18nFormat('yyyy-MM-dd');
			$opcion=0;
			$cliente_id=$this->request->session()->read('Auth.User.cliente_id');
			$this->request->session()->write('cliente_id',$cliente_id);	
			$this->request->session()->write('fechadesde2',$fecha);	
			$this->request->session()->write('fechahasta2',$fecha2);
		}
		
	
		
		$totalpagos = $this->ctactesearchpagos($fecha,$fecha2,$opcion,$cliente_id);
		$totalpagos+= $this->ctactesearchos($fecha,$fecha2,$cliente_id);
		$this->set('totalpagos',$totalpagos);
		$this->set('opcion',0);
		/*
		$clientes=Array();
		if ($this->request->session()->read('Auth.User.cuentaprincipal')==1)
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
		}
		$this->set('clientes',$clientes);*/
		$this->listadocliente();
		
		$this->loadModel('CtacteTipoPagosGrupos');
		$TipoPagosGrupos = $this->CtacteTipoPagosGrupos->find('list',['keyField' => 'id','valueField'=>'nombre'])->order(['nombre' => 'ASC']);
		$tipopagosgrupos = $TipoPagosGrupos->toArray();
		//$tipopagosgrupos[0]="Seleccione Concepto";
		//$this->request->session()->write('TipoPagosGrupos',$TipoPagosGrupos->toArray());
        $this->set('TipoPagosGrupos',$tipopagosgrupos);
       
    }

	public function listadocliente()
	{
		$clientes=Array();
		if ($this->request->session()->read('Auth.User.cuentaprincipal')==1)
		{
			$this->loadModel('Clientes');
			if ($this->request->session()->read('Auth.User.grupo') >0)
			
			$Clientes = $this->Clientes->find('all')->Select(['id','codigo','nombre'])->where(['grupo_id'=>$this->request->session()->read('Auth.User.grupo')]);
			else
			$Clientes = $this->Clientes->find('all')->Select(['id','codigo','nombre'])->where(['id'=>$this->request->session()->read('Auth.User.cliente_id')]);
			
			
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
	
	public function search($tipo = null)
    {
		$this->viewBuilder()->layout('store');
         /*$clientes=Array();
		if ($this->request->session()->read('Auth.User.cuentaprincipal')==1)
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
		}
		$this->set('clientes',$clientes);*/
		$this->listadocliente();
		
		if ($this->request->is('post')) {
			if ($this->request->data['cliente_id']!= null)
				$cliente_id = $this->request->data['cliente_id'];
			else
				$cliente_id = $this->request->session()->read('Auth.User.cliente_id');
			if ($this->request->data['tipo_pago_id']!=null)
					$opcion=$this->request->data['tipo_pago_id'];
				else
					$opcion=0;
			if ($this->request->data['fechadesde']!= null)
					$fechadesde = $this->request->data['fechadesde'];
				else
					$fechadesde=0;
			if ($this->request->data['fechahasta']!= null)
					$fechahasta = $this->request->data['fechahasta'];
				else
					$fechahasta =0;
			//$this->set('opcion',$opcion);
			if ($tipo==null)
			{
				if ($fechahasta!=0)
				{
					$fecha2 = Time::createFromFormat('d/m/Y',$fechahasta,'America/Argentina/Buenos_Aires');
					$fecha2->modify('+1 days');
					//$fecha2->i18nFormat('yyyy-MM-dd');
				}
				else
				{
					$fecha2 = Time::now();
					$fecha2-> modify('+1 days');
					//$fecha2-> i18nFormat('yyyy-MM-dd');
				}
				if ($fechadesde!=0)
				{
					$fecha = Time::createFromFormat('d/m/Y',$fechadesde,'America/Argentina/Buenos_Aires');
					//$fecha->i18nFormat('yyyy-MM-dd');
				}
				else
				{
					$fecha = Time::now();
					//$fecha = Time::createFromFormat('d/m/Y',Time::now(),'America/Argentina/Buenos_Aires');
					if ($fechahasta!=0)
						$fecha->setDate($fecha->year, $fecha2->month, 1);
					else
						$fecha->setDate($fecha->year, $fecha->month, 1);
					//$fecha->i18nFormat('yyyy-MM-dd');
				}
				$this->request->session()->write('cliente_id',$cliente_id);
				$this->request->session()->write('tipopagoid',$opcion);	
				$this->request->session()->write('fechadesde2',$fecha);	
				$this->request->session()->write('fechahasta2',$fecha2);
			}
			else
			{
				$this->request->session()->write('cliente_id',$cliente_id);
				$fecha2 = $this->request->session()->read('fechahasta2');
				$fecha = $this->request->session()->read('fechadesde2');
			}
		}
		else
		{
			$cliente_id = $this->request->session()->read('cliente_id');
			$fecha2 = $this->request->session()->read('fechahasta2');
		    $fecha = $this->request->session()->read('fechadesde2');
	
			$opcion=0;
		}
		if ($tipo !=null)
		{
			$opcion=(int)$tipo;
			$cliente_id = $this->request->session()->read('cliente_id');
		}
		$this->set('opcion',$opcion);
		$totalpagos = $this->ctactesearchpagos($fecha,$fecha2,$opcion,$cliente_id);
		$totalpagos+= $this->ctactesearchos($fecha,$fecha2,$cliente_id);
		$this->set('totalpagos',$totalpagos);
		$this->loadModel('CtacteTipoPagosGrupos');
		$TipoPagosGrupos = $this->CtacteTipoPagosGrupos->find('list',['keyField' => 'id','valueField'=>'nombre'])->order(['nombre' => 'ASC']);
		$tipopagosgrupos = $TipoPagosGrupos->toArray();
		//$tipopagosgrupos[0]="Seleccione Concepto";
		//$this->request->session()->write('TipoPagosGrupos',$TipoPagosGrupos->toArray());
        $this->set('TipoPagosGrupos',$tipopagosgrupos);
       
    }

    /**
     * View method
     *
     * @param string|null $id Ctacte Pago id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $ctactePago = $this->CtactePagos->get($id, [
            'contain' => ['Clientes']
        ]);
        $this->set('ctactePago', $ctactePago);
        $this->set('_serialize', ['ctactePago']);
	}
	
	public function info()
    {
		$this->viewBuilder()->layout('store');
    }
    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $ctactePago = $this->CtactePagos->newEntity();
        if ($this->request->is('post')) {
            $ctactePago = $this->CtactePagos->patchEntity($ctactePago, $this->request->data);
            if ($this->CtactePagos->save($ctactePago)) {
                $this->Flash->success(__('The ctacte pago has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The ctacte pago could not be saved. Please, try again.'));
            }
        }
        $clientes = $this->CtactePagos->Clientes->find('list', ['limit' => 200]);
        $this->set(compact('ctactePago', 'clientes'));
        $this->set('_serialize', ['ctactePago']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Ctacte Pago id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $ctactePago = $this->CtactePagos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ctactePago = $this->CtactePagos->patchEntity($ctactePago, $this->request->data);
            if ($this->CtactePagos->save($ctactePago)) {
                $this->Flash->success(__('The ctacte pago has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The ctacte pago could not be saved. Please, try again.'));
            }
        }
        $clientes = $this->CtactePagos->Clientes->find('list', ['limit' => 200]);
        $this->set(compact('ctactePago', 'clientes'));
        $this->set('_serialize', ['ctactePago']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Ctacte Pago id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ctactePago = $this->CtactePagos->get($id);
        if ($this->CtactePagos->delete($ctactePago)) {
            $this->Flash->success(__('The ctacte pago has been deleted.'));
        } else {
            $this->Flash->error(__('The ctacte pago could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
	
	public function excel()
    {
		$cliente_id = $this->request->session()->read('cliente_id');
		if (!empty($this->request->session()->read['tipopagoid2']))
			$opcion=(int)$this->request->session()->read['tipopagoid2'];
		else
			$opcion=0;
		$this->viewBuilder()->layout('ajax');

		if (!empty($this->request->session()->read('fechadesde2')))
				$fecha = $this->request->session()->read('fechadesde2');
		else
			{
				$fecha = Time::now();
				$fecha->setDate($fecha->year, $fecha->month, 1);
				//$fecha = $fecha->i18nFormat('yyyy-MM-dd');
			}
			
		if (!empty($this->request->session()->read('fechahasta2')))
				$fecha2 = $this->request->session()->read('fechahasta2');
		else
			{
				$fecha2 = Time::now();
				$fecha2->modify('+1 days');
				//$fecha2= $fecha2->i18nFormat('yyyy-MM-dd');
			}
		
		$this->loadModel('Clientes');
		$cliente = $this->Clientes->get($cliente_id);

		$this->set('cliente',$cliente);	
		$this->set('opcion2',$opcion);		
		$totalpagos = $this->ctactesearchpagos($fecha,$fecha2,$opcion,$cliente_id);
		$totalpagos+= $this->ctactesearchos($fecha,$fecha2,$cliente_id);
		$this->set('totalpagos',$totalpagos);
		
		$this->response->type('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	}
	
	


	function enviarsolicitud($opcion = null) {
		
		$this->loadModel('Clientes');
		$cliente = $this->Clientes->find('all')->where(['id'=>$this->request->session()->read('Auth.User.cliente_id')])
			->first(); 
			
		 $cont_email ='cobranzas@drogueriasur.com.ar';
		 $cont_cuerpo ='';
		 $cont_name = 'Solicitud de tarjeta';
		if ($opcion ==1)
		$cont_name = 'Solicitud de tarjeta de deposito Banco Credicoop';
		if ($opcion ==2)
		$cont_name = 'Solicitud de tarjeta de deposito Banco Nación';
		if ($opcion ==3)
		$cont_name = 'Solicitud de tarjeta de credito Banco Patagonia Distribution';
		
		if ($opcion ==4)
		$cont_name = 'Solicitud de tarjeta Pactar de Banco Provincia';
		if ($opcion ==5)
		$cont_name = 'Solicitud de Talonario de Cobinpro de Banco Provincia';			  
		$this->request->session()->write('para',$cont_email);
		$email = new Email();
		$email->transport('gmail');
			try 
			{
								
				$res = $email->from(['cobranzas@drogueriasur.com.ar' => 'Drogueria Sur S.A.'])
					->replyTo(['cobranzas@drogueriasur.com.ar' => 'Creditos y Cobranzas'])
					
					->template('solicitud')
					->emailFormat('html')
					->to([$cont_email => $cont_email])
					
					//->bcc(["cobranzas@drogueriasur.com.ar"=>"cobranzas@drogueriasur.com.ar"])
					->subject($cont_name)
					->viewVars(['cliente'=>$cliente, 'opcion'=>$opcion])
					->send($cont_cuerpo);
				$this->Flash->success(__('Se envio la solicitud correctamente'),['key' => 'changepass']);
				return $this->redirect($this->referer());
			} 
			catch (Exception $e) {

				echo 'Exception : ',  $e->getMessage(), "\n";
				$this->Flash->error(__('No Se pudo enviar la solicitud correctamente'),['key' => 'changepass']);
				return $this->redirect($this->referer());
			}
			
	}     
}
