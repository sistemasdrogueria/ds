<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
/**
 * CtacteEstados Controller
 *
 * @property \App\Model\Table\CtacteEstadosTable $CtacteEstados
 */
class CtacteEstadosController extends AppController
{


	public function isAuthorized()
    {
       if (in_array($this->request->action, ['search','deudaavencer','deudavencida','credito','documentocartera','home','index','obrasocial','excel','tarjetaexcel','comprasexcel'])) {
       
				if($this->request->session()->read('Auth.User.role')=='admin') 
				{				
					return true;			
				}			
				else 
				{	
					if($this->request->session()->read('Auth.User.role')=='client') 
					{	
						$tiene= $this->tienepermiso('ctacteestados',$this->request->action);
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


public function comprasexcel(){

		$this->viewBuilder()->layout('ajax');

		$ctacteComprasSemanales =json_decode( $this->request->data['ctacteComprasSemanales'], true);
		//$desde=$this->request->data['desde'];

		$this->set('ctacteComprasSemanales',$ctacteComprasSemanales);
		//$this->set('desde',$desde);
		//$this->request->session()->write('prueba',$ctacteComprasSemanales);

		$this->response->type('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	
	}

	public function ctactedeudavencida($opcion=null,$opcion2=null)
	{
		//DEUDA VENCIDA
		$totalvencida=0;
		$totalvencida2=0;
		$totalvencida3=0;
		$totalvencida4=0;
		$totalvencida5=0;
		$totalvencida6=0;
				
		$fecha = Time::now();
		$fecha->modify('+1 days');
		$fech = $fecha->i18nFormat('yyyy-MM-dd');
		$ctacteestadosvencida = $this->CtacteEstados->find('all')
								->where(['cliente_id' => $this->request->session()->read('cliente_id')])
								->andWhere(['fecha_vencimiento <' => $fech])
								
								->andWhere(['ctacte_tipo_registros_id <>' => 7])
								->andWhere(['ctacte_tipo_registros_id <>' => 4])
								->andWhere(['ctacte_tipo_registros_id <>' => 1])
								
								->andWhere(['fecha_vencimiento <>' => '0101-01-01'])
								->order(['fecha_vencimiento' => 'ASC','fecha_compra'=>'ASC']);
								
		foreach ($ctacteestadosvencida as $ctacteestado): 
				$importesuma = $ctacteestado['importe'];
			
				if ($ctacteestado['signo'] == 1)
						$importesuma =  (-1) * $importesuma;
				/*
				if ($ctacteestado['signo'] == 1 && $ctacteestado['ctacte_tipo_registros_id']==4)
						$totalvencida+=0;
				else*/
				if ($ctacteestado['ctacte_tipo_registros_id']!=4)
				$totalvencida+= $importesuma;
					
				switch ($ctacteestado['ctacte_tipo_registros_id']) {
					case 1 :
						//if ($ctacteestado['signo']==0)
						//$totalvencida2 += $importesuma;
						break;

					case 2:
						$totalvencida2 += $importesuma;
						break;
					case 3:
						$totalvencida3 += $importesuma;
						break;
					case 4:
						if ($ctacteestado['signo'] == 0)
						$totalvencida4 += $importesuma;
						break;
					case 5:
						$totalvencida5 += $importesuma;
						break;
					case 6:
						$totalvencida6 += $importesuma;
						break;	
				}
		endforeach; 
		$totalvencidaX = array($totalvencida,$totalvencida2,$totalvencida3,$totalvencida5,$totalvencida6,$totalvencida4);
		$this->set('totalvencidaX',$totalvencidaX);
		if ($opcion != null)
		{
			$ctacteestadosvencida->andWhere(['ctacte_tipo_registros_id ' => $opcion]);
		}
		if ($opcion2 == 1)
		{
			$ctacteEstados= $ctacteestadosvencida;
			$this->set('ctacteEstados',$this->paginate($ctacteEstados));
		}
		$clientes = $this->request->session()->read('clientes');
		$this->set('clientes',$clientes);
		return $totalvencida;
	}
	
	public function ctactedeudaavencer($opcion=null,$opcion2=null)
	{
		$fecha = Time::now();
		$fecha ->modify('+1 days');
		$fech = $fecha->i18nFormat('yyyy-MM-dd');
		$totalavencer=0;
		$totalavencer2=0;
		$totalavencer3=0;
		$totalavencer5=0;
		$totalavencer6=0;
		//DEUDA A VENCER								
		$ctacteestadosavencer = $this->CtacteEstados->find('all')	
								->where(['cliente_id' => $this->request->session()->read('cliente_id')])
								->andWhere(['ctacte_tipo_registros_id <>' => 7])
								->andWhere(['ctacte_tipo_registros_id <>' => 4])
								->andWhere(['fecha_vencimiento >=' => $fech])
								->order(['fecha_vencimiento' => 'ASC','fecha_compra'=>'ASC']);
								
		
		foreach ($ctacteestadosavencer as $ctacteestado): 
				$importesuma = $ctacteestado['importe'];
			
				if ($ctacteestado['signo'] == 1)
						$importesuma =  (-1) * $importesuma ;
				
					$totalavencer+= $importesuma;
					
					switch ($ctacteestado['ctacte_tipo_registros_id']) {
						case 1 :
							if ($ctacteestado['signo']==0)
							$totalavencer2 += $importesuma;
							break;
						case 2:
						$totalavencer2 += $importesuma;
						break;
					case 3:
						$totalavencer3 += $importesuma;
						break;
					case 5:
						$totalavencer5 += $importesuma;
						break;
					case 6:
						$totalavencer6 += $importesuma;
						break;	
				}
	
		endforeach; 
		$totalavencerX = array($totalavencer,$totalavencer2,$totalavencer3,$totalavencer5,$totalavencer6);
			$this->set('totalavencerX',$totalavencerX);
		if ($opcion != null)
			$ctacteestadosavencer->	andWhere(['ctacte_tipo_registros_id ' => $opcion]);
		if ($opcion2 == 1)
		{
			$ctacteEstados= $ctacteestadosavencer;
			$this->set('ctacteEstados',$this->paginate($ctacteEstados));
		}
		$clientes = $this->request->session()->read('clientes');
		$this->set('clientes',$clientes);
		return $totalavencer;
	}
	
	public function ctactecredito($opcion=null)
	{
		$totalcredito=0;
		$ctacteestadoscredito =$this->CtacteEstados->find('all')
							->where(['cliente_id' => $this->request->session()->read('cliente_id')])
							->andWhere(['OR' => [['ctacte_tipo_registros_id =7'],['ctacte_tipo_registros_id = 4'],['ctacte_tipo_registros_id = 1']]]							
							);

		foreach ($ctacteestadoscredito as $ctacteestado): 
				$importesuma = $ctacteestado['importe'];
				if ($ctacteestado['ctacte_tipo_registros_id'] ==7)
				{
						if ($ctacteestado['signo']==1)
							$totalcredito= $totalcredito + $importesuma;
						else
							$totalcredito= $totalcredito - $importesuma;
				}		
				if ($ctacteestado['ctacte_tipo_registros_id'] == 4)
				{
					if ($ctacteestado['signo']==1)
						$totalcredito= $totalcredito + $importesuma;
					/*if ($ctacteestado['signo']==1 &&  $ctacteestado['obra_social']!=0)
							$totalcredito= $totalcredito + $ctacteestado['importe'];*/
				}
				if ($ctacteestado['ctacte_tipo_registros_id'] ==1)
				{
					if ($ctacteestado['signo']==0)	
					$totalcredito= $totalcredito - $importesuma;
					else
					$totalcredito= $totalcredito + $importesuma;
				}
				
		endforeach; 	
		
		$this->set('totalcredito',$totalcredito);
		$clientes = $this->request->session()->read('clientes');
		$this->set('clientes',$clientes);
		return $totalcredito;
	}
	public function ctactenotadebito($opcion=null)
	{
		$totalnotadebito=0;
		$ctacteestadoscredito =$this->CtacteEstados->find('all')
							->where(['cliente_id' => $this->request->session()->read('cliente_id')])
							->andWhere(['OR' => [['ctacte_tipo_registros_id = 4']]]);
							//->andWhere(['OR' => [['ctacte_tipo_registros_id =7'],['ctacte_tipo_registros_id = 4'],['fecha_vencimiento =' => '0101-01-01']]]);
			

					//CREDITO SIN ASIGNAR
		foreach ($ctacteestadoscredito as $ctacteestado): 
				if ($ctacteestado['signo']!=1)
				$totalnotadebito= $totalnotadebito + $ctacteestado['importe'];
		endforeach; 	
		
		$this->set('totalnotadebito',$totalnotadebito);
		$clientes = $this->request->session()->read('clientes');
		$this->set('clientes',$clientes);
		return $totalnotadebito;
	}
	
	
	public function clientecreditoasignado()
	{
		//CLIENTE CREDITO ASIGNADOS
		$this->loadModel('ClientesCreditos');
		$clientecreditos = $this->ClientesCreditos->find('all')	
								->where(['cliente_id' => $this->request->session()->read('cliente_id')]);
		$clientecredito = $clientecreditos->first();			
		$this->set('clientecredito',$clientecredito);
		$clientes = $this->request->session()->read('clientes');
		$this->set('clientes',$clientes);
	}

	public function ctacteobrasocial($opcion=null)
	{
	//OBRA SOCIAL
		$this->loadModel('CtacteObrasSociales');
		$totalobrasocial =0;
		$ctacteestadosobrasocial =$this->CtacteEstados->find('all')
								->hydrate(false)
								->join([
									'table' => 'ctacte_obras_sociales',
									'alias' => 'o',
									'type' => 'LEFT',
									 'conditions' => [
									'o.fecha = fecha_vencimiento',
									'o.importe' => 'CtaCteEstados.importe',
									'o.cliente_id' => 'CtaCteEstados.cliente_id'
									]		
								])
								->where(['CtacteEstados.cliente_id' => $this->request->session()->read('cliente_id')])
								->andWhere(['CtacteEstados.ctacte_tipo_registros_id = 7']);
	
		//OBRA SOCIAL
		foreach ($ctacteestadosobrasocial as $ctacteestado): 
				if ($ctacteestado['signo']!=0)
				$totalobrasocial= $totalobrasocial + $ctacteestado['importe'];
				else
					$totalobrasocial= $totalobrasocial - $ctacteestado['importe'];
				/*
				$importesuma = $ctacteestado['importe'];
			
				if ($ctacteestado['signo'] == 1)
						$importesuma =  (-1) * $importesuma;
					
				$totalobrasocial+= $importesuma;*/
				
		endforeach;
		
		$this->set('totalobrasocial',$totalobrasocial);
		if ($opcion==1)
		{
				$this->loadModel('CtacteObrasSociales');
				if ($totalobrasocial==0)
				{
					
					$totalobrasocial =$this->CtacteObrasSociales->find('all')
											->where(['cliente_id' => $this->request->session()->read('cliente_id')])
											->andWhere(['id <'=>10]);
				}
				else
					$totalobrasocial =$this->CtacteObrasSociales->find('all')
											->where(['cliente_id' => $this->request->session()->read('cliente_id')])
											->order(['fecha' => 'ASC','nro_nota'=>'ASC']);
		}
		$clientes = $this->request->session()->read('clientes');
		$this->set('clientes',$clientes);
		return $totalobrasocial;
	}
	
	public function ctactedocumento($opcion=null)
	{
		//DOCUMENTOS	
		$totalcartera=0;		
    	$fecha = Time::now();
		$fech = $fecha->i18nFormat('yyyy-MM-dd');
		$this->loadModel('CtacteDocumentoCarteras');
		$ctactedocumentoscartera = $this->CtacteDocumentoCarteras->find('all')	
								->where(['cliente_id' => $this->request->session()->read('cliente_id')])
								->andWhere(['fecha_deposito >' => $fech]);
		foreach ($ctactedocumentoscartera as $ctacteestado): 
				$totalcartera= $totalcartera + $ctacteestado['importe'];
		endforeach;
		
		$this->set('totalcartera',$totalcartera);
		if ($opcion==1)
		{
				
				$totalcartera= $ctactedocumentoscartera;
			
		}
		$clientes = $this->request->session()->read('clientes');
		$this->set('clientes',$clientes);
		return $totalcartera;
	}
	
	public function tarjetaexcel()
    {
		$this->viewBuilder()->layout('ajax');

		$this->loadModel('CtacteTarjetasCreditos');
		$ctacteestadostarjetacredito = $this->CtacteTarjetasCreditos->find('all')	
								->where(['cliente_id' => $this->request->session()->read('cliente_id'), 'aplicado'=>0])
								->order(['fecha_acreditacion'=>'ASC']);
	
		$this->set('ctacteestadostarjetacredito',$ctacteestadostarjetacredito->toArray());
		$this->loadModel('CtacteTipoRegistros');
		$this->set('ctactetiporegistros', $this->CtacteTipoRegistros->find('list', ['keyField' => 'id','valueField' => 'nombre']));

		$this->response->type('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }
	
	
	public function ctactetarjetacredito($opcion=null,$totalcredito=null)
	{
		$totaltarjetacredito=0;
		//TARJETA DE CREDITO
		$this->loadModel('CtacteTarjetasCreditos');
		$ctacteestadostarjetacredito = $this->CtacteTarjetasCreditos->find('all')	
								->where(['cliente_id' => $this->request->session()->read('cliente_id'),
									'aplicado'=>0]);
		
		//TARJETA DE CREDITO
		foreach ($ctacteestadostarjetacredito as $ctacteestado): 
				$totaltarjetacredito = $totaltarjetacredito + $ctacteestado['importe'];
		endforeach; 
		
		
		if ($totalcredito==0)
		{
			$totaltarjetacredito=0;
			$ctacteestadostarjetacredito->andWhere(['id <'=>10]);
		}
		$this->set('totaltarjetacredito',$totaltarjetacredito);
		$clientes = $this->request->session()->read('clientes');
		$this->set('clientes',$clientes);
		
		return $ctacteestadostarjetacredito;
	}
	
	
    /*
     * Index method
     *
     * @return void
     */
    public function index()
    {
		$this->viewBuilder()->layout('store');
        $this->paginate = [
			'limit' => 1000,
			'maxLimit' => 1000
			
        ];
		if ($this->request->is('post','get'))
		{	
			if ($this->request->data['cliente_id']!= null)
				$cliente_id = $this->request->data['cliente_id'];
			else
				$cliente_id = $this->request->session()->read('cliente_id');

		    $this->request->session()->write('cliente_id',$cliente_id);
		}
		else 
		{
			if (!empty($this->request->session()->read('cliente_id')))
				$cliente_id = $this->request->session()->read('cliente_id');
			else			
			{
				$cliente_id = $this->request->session()->read('Auth.User.cliente_id');
				$this->request->session()->write('cliente_id',$cliente_id);
			}
			
			
		}
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
		$this->set('clientes',$clientes);	*/
		
		$this->listadocliente();
		
		$totalvencida=0;
		$totalavencer=0;
		$totalcredito=0;
		$totalcartera=0;
		$totalobrasocial=0;
		$totaltarjetacredito=0;
		$totalnotadebito =0;
		$opcion=null;
		
		$fecha = Time::now();
		$fech = $fecha->i18nFormat('yyyy-MM-dd');
		
		// Estado todos los registros
		$ctacte = $this->CtacteEstados->find('all')
								->where(['cliente_id' => $cliente_id])
								->order(['fecha_vencimiento' => 'ASC','ctacte_tipo_registros_id'=>'ASC']);
	
		//CLIENTE CREDITO ASIGNADOS
		$this->clientecreditoasignado();
	
		//DEUDA VENCIDA
		$totalvencida = $this->ctactedeudavencida($opcion,$opcion);
		
		//DEUDA A VENCER								
		$totalavencer = $this->ctactedeudaavencer($opcion,$opcion);
	  
		//CREDITO SIN ASIGNAR
		$totalcredito = $this->ctactecredito($opcion);
		
		// Deuda vencida
		$totalnotadebito =$this->ctactenotadebito($opcion);
		
		//OBRA SOCIAL
		$totalobrasocial =$this->ctacteobrasocial($opcion);
		
		//DOCUMENTOS
		$totalcartera = $this->ctactedocumento($opcion);			
		
		//TARJETA DE CREDITO
		$totaltarjetacredito = $this->ctactetarjetacredito($opcion,$totalcredito);
		
	
		$this->loadModel('CtacteTipoRegistros');
		$this->set('ctactetiporegistros', $this->CtacteTipoRegistros->find('list', ['keyField' => 'id','valueField' => 'nombre']));

		
		$this->set('totaldeuda',$totalcartera+$totalavencer-$totalcredito+$totalvencida+$totalnotadebito);
		
		$ctacteEstados= $ctacte;
		$this->set('ctacteEstados',$this->paginate($ctacteEstados));
        $this->set('_serialize', ['ctacteEstados']);
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
	
	/*
	public function excel()
    {
		$this->viewBuilder()->layout('ajax');
		$totalvencida=0;
		$totalavencer=0;
		$totalcredito=0;
		$totalcartera=0;
		$totalobrasocial=0;
		$totaltarjetacredito=0;
		$opcion=null;
		
		$fecha = Time::now();
		$fech = $fecha->i18nFormat('yyyy-MM-dd');
		
		// Estado todos los registros
		$ctacte = $this->CtacteEstados->find('all')
								->contain(['CtacteObrasSociales']) 

								->join([
								'cos' => [
									'table' => 'ctacte_obras_sociales',
									'type' => 'LEFT',
									'conditions' => 'cos.id = CtacteEstados.ctacte_obras_sociales_id',
								]])
								->where(['CtacteEstados.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
								->order(['CtacteEstados.fecha_vencimiento' => 'ASC','CtacteEstados.fecha_compra'=>'ASC']);
	
		//CLIENTE CREDITO ASIGNADOS
		$this->clientecreditoasignado();
	
		//DEUDA VENCIDA
		$totalvencida = $this->ctactedeudavencida($opcion,$opcion);
		
		//DEUDA A VENCER								
		$totalavencer = $this->ctactedeudaavencer($opcion,$opcion);
	  
		//CREDITO SIN ASIGNAR
		$totalcredito = $this->ctactecredito($opcion);
		
		//OBRA SOCIAL
		$totalobrasocial =$this->ctacteobrasocial($opcion);
		
		//DOCUMENTOS
		$totalcartera = $this->ctactedocumento($opcion);			
		
		//TARJETA DE CREDITO
		$totaltarjetacredito = $this->ctactetarjetacredito($opcion,$totalcredito);
		
	
		$this->loadModel('CtacteTipoRegistros');
		$this->set('ctactetiporegistros', $this->CtacteTipoRegistros->find('list', ['keyField' => 'id','valueField' => 'nombre']));

		
		$this->set('totaldeuda',$totalcartera+$totalavencer-$totalcredito+$totalvencida);
		
		$ctacteEstados= $ctacte->toArray();;
		$this->set('ctacteEstados',$ctacteEstados);
       ///$this->set('_serialize', ['ctacteEstados']);
		
		$this->response->type('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }
	*/
	
	
	public function excel()
    {
		$this->viewBuilder()->layout('ajax');
		$totalvencida=0;
		$totalavencer=0;
		$totalcredito=0;
		$totalcartera=0;
		$totalobrasocial=0;
		$totaltarjetacredito=0;
		$opcion=null;
		
		$fecha = Time::now();
		$fech = $fecha->i18nFormat('yyyy-MM-dd');
		
		// Estado todos los registros
		$ctacte = $this->CtacteEstados->find('all')
								->contain(['CtacteObrasSociales']) 
								
								->join([
								'cos' => [
									'table' => 'ctacte_obras_sociales',
									'type' => 'LEFT',
									'conditions' => 'cos.ctacte_estado_id = CtacteEstados.id',
								]])
								->where(['CtacteEstados.cliente_id' => $this->request->session()->read('cliente_id')])
								->order(['CtacteEstados.fecha_vencimiento' => 'ASC','CtacteEstados.fecha_compra'=>'ASC'])
								->group(['CtacteEstados.id']);
		
		//CLIENTE CREDITO ASIGNADOS
		$this->clientecreditoasignado();
	
		//DEUDA VENCIDA
		$totalvencida = $this->ctactedeudavencida($opcion,$opcion);
		
		//DEUDA A VENCER								
		$totalavencer = $this->ctactedeudaavencer($opcion,$opcion);
	  
		//CREDITO SIN ASIGNAR
		$totalcredito = $this->ctactecredito($opcion);
		
		//OBRA SOCIAL
		$totalobrasocial =$this->ctacteobrasocial($opcion);
		
		//DOCUMENTOS
		$totalcartera = $this->ctactedocumento($opcion);			
		
		//TARJETA DE CREDITO
		$totaltarjetacredito = $this->ctactetarjetacredito($opcion,$totalcredito);
		
		$this->loadModel('CtacteTarjetasCreditos');
		$ctacteestadostarjetacredito = $this->CtacteTarjetasCreditos->find('all')	
								->where(['cliente_id' => $this->request->session()->read('cliente_id'), 'aplicado'=>0]);
	
		$this->set('ctacteestadostarjetacredito',$ctacteestadostarjetacredito->toArray());
		$this->loadModel('CtacteTipoRegistros');
		$this->set('ctactetiporegistros', $this->CtacteTipoRegistros->find('list', ['keyField' => 'id','valueField' => 'nombre']));
		
		$this->loadModel('ObraSociales');
		$this->set('obrasociales', $this->ObraSociales->find('list', ['keyField' => 'id','valueField' => 'nombre']));
		
		$this->set('totaldeuda',$totalcartera+$totalavencer-$totalcredito+$totalvencida);
		
		$ctacteEstados= $ctacte->toArray();
		$this->set('ctacteEstados',$ctacteEstados);
       ///$this->set('_serialize', ['ctacteEstados']);
		
		$this->response->type('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }
	
	public function deudaavencer($opcion=null)
    {
		$this->viewBuilder()->layout('store');
        $this->paginate = [
			'limit' => 1000,
			'maxLimit' => 1000
        ];
		$totalvencida=0;
		$totalavencer=0;
		$totalcredito=0;
		$totalcartera=0;
		$totalnotadebito =0;
		$totaltarjetacredito=0;
		$opcion2=null;
	
		//CLIENTE CREDITO ASIGNADOS
		$this->clientecreditoasignado();
	
		//DEUDA VENCIDA
		$totalvencida = $this->ctactedeudavencida($opcion,$opcion2);
		
		//DEUDA A VENCER								
		$totalavencer = $this->ctactedeudaavencer($opcion,1);
	  
		//CREDITO SIN ASIGNAR
		$totalcredito = $this->ctactecredito($opcion);
		
		$totalnotadebito =$this->ctactenotadebito($opcion);
		
		//OBRA SOCIAL
		$ctacteobrasocial =$this->ctacteobrasocial($opcion);
		
		//DOCUMENTOS
		$totalcartera = $this->ctactedocumento($opcion);			
		
		//TARJETA DE CREDITO
		$totaltarjetacredito = $this->ctactetarjetacredito($opcion,$totalcredito);

		$this->loadModel('CtacteTipoRegistros');
		$this->set('ctactetiporegistros', $this->CtacteTipoRegistros->find('list', ['keyField' => 'id','valueField' => 'nombre']));
		
		$this->set('totaldeuda',$totalcartera+$totalavencer-$totalcredito+$totalvencida+$totalnotadebito);
		
		
        $this->set('_serialize', ['ctacteEstados']);
    }
	
	public function deudavencida($opcion = null)
    {
		$this->viewBuilder()->layout('store');
        $this->paginate = [
			'limit' => 1000,
			'maxLimit' => 1000
        ];
		$totalvencida=0;
		$totalavencer=0;
		$totalcredito=0;
		$totalcartera=0;
		$totaltarjetacredito=0;
		$opcion2=null;
	$totalnotadebito=0;
		//CLIENTE CREDITO ASIGNADOS
		$this->clientecreditoasignado();
	
		//DEUDA VENCIDA
		$totalvencida = $this->ctactedeudavencida($opcion,1);
		
		//DEUDA A VENCER								
		$totalavencer = $this->ctactedeudaavencer($opcion,$opcion2);
	  
		//CREDITO SIN ASIGNAR
		$totalcredito = $this->ctactecredito($opcion);
		
		$totalnotadebito =$this->ctactenotadebito($opcion);
		
		//OBRA SOCIAL
		$ctacteobrasocial =$this->ctacteobrasocial($opcion);
		
		//DOCUMENTOS
		$totalcartera = $this->ctactedocumento($opcion);			
		
		//TARJETA DE CREDITO
		$totaltarjetacredito = $this->ctactetarjetacredito($opcion,$totalcredito);

		$this->loadModel('CtacteTipoRegistros');
		$this->set('ctactetiporegistros', $this->CtacteTipoRegistros->find('list', ['keyField' => 'id','valueField' => 'nombre']));
		
		$this->set('totaldeuda',$totalcartera+$totalavencer-$totalcredito+$totalvencida+$totalnotadebito);
		
		
        $this->set('_serialize', ['ctacteEstados']);
    }
	
	public function credito()
    {
		$this->viewBuilder()->layout('store');
        $this->paginate = [
			'limit' => 500
        ];
		$totalvencida=0;
		$totalavencer=0;
		$totalcredito=0;
		$totalcartera=0;
		$totalobrasocial=0;
		$opcion=null;
		$totalnotadebito=0;
		$fecha = Time::now();
		$fech = $fecha->i18nFormat('yyyy-MM-dd');

		//CLIENTE CREDITO ASIGNADOS
		$this->clientecreditoasignado();
	
		//DEUDA VENCIDA
		$totalvencida = $this->ctactedeudavencida($opcion,$opcion);
		
		//DEUDA A VENCER								
		$totalavencer = $this->ctactedeudaavencer($opcion,$opcion);
	  
		//CREDITO SIN ASIGNAR
		$totalcredito = $this->ctactecredito($opcion);
		
		$totalnotadebito = $this->ctactenotadebito($opcion);
		
		//OBRA SOCIAL
		$totalobrasocial =$this->ctacteobrasocial($opcion);
		
		//DOCUMENTOS
		$totalcartera = $this->ctactedocumento($opcion);			
		
		//TARJETA DE CREDITO
		$ctacteestadostarjetacredito = $this->ctactetarjetacredito(1,$totalcredito);
		
		$this->set('ctacteCreditos',$this->paginate($ctacteestadostarjetacredito));
	
		$this->loadModel('CtacteTipoRegistros');
		$this->set('ctactetiporegistros', $this->CtacteTipoRegistros->find('list', ['keyField' => 'id','valueField' => 'nombre']));

		
		$this->set('totaldeuda',$totalcartera+$totalavencer-$totalcredito+$totalvencida+$totalnotadebito);
    }
	
	public function documentocartera()
    {
		$this->viewBuilder()->layout('store');
        $this->paginate = [
			'limit' => 500
        ];
		$totalvencida=0;
		$totalavencer=0;
		$totalcredito=0;
		$totalcartera=0;
		$totaltarjetacredito=0;
		$opcion2=null;
		$totalnotadebito=0;
		//CLIENTE CREDITO ASIGNADOS
		$this->clientecreditoasignado();
	
		//DEUDA VENCIDA
		$totalvencida = $this->ctactedeudavencida($opcion2,$opcion2);
		
		//DEUDA A VENCER								
		$totalavencer = $this->ctactedeudaavencer($opcion2,$opcion2);
		$totalnotadebito = $this->ctactenotadebito($opcion2);
		
		//CREDITO SIN ASIGNAR
		$totalcredito = $this->ctactecredito($opcion2);
		
		//OBRA SOCIAL
		$ctacteobrasocial =$this->ctacteobrasocial($opcion2);
		
		//DOCUMENTOS
		$ctactedocumento = $this->ctactedocumento(1);			
		
		//TARJETA DE CREDITO
		$totaltarjetacredito = $this->ctactetarjetacredito($opcion2,$totalcredito);
		
		$this->set('totaldeuda',$totalcartera+$totalavencer-$totalcredito+$totalvencida+$totalnotadebito);
		$ctacteEstados = $ctactedocumento;
		$this->set('ctacteEstados',$this->paginate($ctacteEstados));
		//$this->set('_serialize', ['ctacteEstados']);
    }

	public function obrasocial()
    {
		$this->viewBuilder()->layout('store');
        $this->paginate = [
			'limit' => 500
        ];
		$totalvencida=0;
		$totalavencer=0;
		$totalcredito=0;
		$totalcartera=0;
		$opcion=null;
		$totalnotadebito=0;
		$fecha = Time::now();
		$fech = $fecha->i18nFormat('yyyy-MM-dd');

		//CLIENTE CREDITO ASIGNADOS
		$this->clientecreditoasignado();
	
		//DEUDA VENCIDA
		$totalvencida = $this->ctactedeudavencida($opcion,$opcion);
		
		//DEUDA A VENCER								
		$totalavencer = $this->ctactedeudaavencer($opcion,$opcion);
	  
		//CREDITO SIN ASIGNAR
		$totalcredito = $this->ctactecredito($opcion);
		
		$totalnotadebito = $this->ctactenotadebito($opcion);
		
		//OBRA SOCIAL
		$ctacteObrasSociales =$this->ctacteobrasocial(1);
		
		//DOCUMENTOS
		$totalcartera = $this->ctactedocumento($opcion);			
		
		//TARJETA DE CREDITO
		$ctacteestadostarjetacredito = $this->ctactetarjetacredito(null,$totalcredito);

		$this->loadModel('ObraSociales');
		$this->set('obrasociales', $this->ObraSociales->find('list', ['keyField' => 'id','valueField' => 'nombre']));
		
		$this->set('totaldeuda',$totalcartera+$totalavencer-$totalcredito+$totalvencida+$totalnotadebito);
		
		$this->set('ctacteObrasSociales',$this->paginate($ctacteObrasSociales));
        $this->set('_serialize', ['ctacteObrasSociales']);
    }
	
	
    /**
     * View method
     *
     * @param string|null $id Ctacte Estado id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
		$this->viewBuilder()->layout('store');
        $ctacteEstado = $this->CtacteEstados->get($id, [
            'contain' => ['CtacteTipoRegistros']
        ]);
        $this->set('ctacteEstado', $ctacteEstado);
        $this->set('_serialize', ['ctacteEstado']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $ctacteEstado = $this->CtacteEstados->newEntity();
        if ($this->request->is('post')) {
            $ctacteEstado = $this->CtacteEstados->patchEntity($ctacteEstado, $this->request->data);
            if ($this->CtacteEstados->save($ctacteEstado)) {
                $this->Flash->success(__('The ctacte estado has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The ctacte estado could not be saved. Please, try again.'));
            }
        }
        $clientes = $this->CtacteEstados->Clientes->find('list', ['limit' => 200]);
        $ctacteTipoRegistros = $this->CtacteEstados->CtacteTipoRegistros->find('list', ['limit' => 200]);
        $this->set(compact('ctacteEstado', 'clientes', 'ctacteTipoRegistros'));
        $this->set('_serialize', ['ctacteEstado']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Ctacte Estado id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $ctacteEstado = $this->CtacteEstados->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ctacteEstado = $this->CtacteEstados->patchEntity($ctacteEstado, $this->request->data);
            if ($this->CtacteEstados->save($ctacteEstado)) {
                $this->Flash->success(__('The ctacte estado has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The ctacte estado could not be saved. Please, try again.'));
            }
        }
        $clientes = $this->CtacteEstados->Clientes->find('list', ['limit' => 200]);
        $ctacteTipoRegistros = $this->CtacteEstados->CtacteTipoRegistros->find('list', ['limit' => 200]);
        $this->set(compact('ctacteEstado', 'clientes', 'ctacteTipoRegistros'));
        $this->set('_serialize', ['ctacteEstado']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Ctacte Estado id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ctacteEstado = $this->CtacteEstados->get($id);
        if ($this->CtacteEstados->delete($ctacteEstado)) {
            $this->Flash->success(__('The ctacte estado has been deleted.'));
        } else {
            $this->Flash->error(__('The ctacte estado could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
