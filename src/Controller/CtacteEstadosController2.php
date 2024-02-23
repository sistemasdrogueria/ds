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
		if (in_array($this->request->action, ['search','deudaavencer','deudavencida','credito','documentocartera','home','index','obrasocial'])) {
       
				if($this->request->session()->read('Auth.User.role')=='admin') 
				{				
					return true;			
				}			
				else 
				{	
					if($this->request->session()->read('Auth.User.role')=='client') 
					{	
						$tiene= $this->tienepermiso('ctacteestados',$this->request->action);
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
        $this->paginate = [
            //'contain' => ['CtacteTipoRegistros'],
			'limit' => 11
        ];
		$totalvencida=0;
		$totalavencer=0;
		$totalcredito=0;
		$totalcartera=0;
		$totalobrasocial=0;
		$totaltarjetacredito=0;
		
		$fecha = Time::now();
		$fech = $fecha->i18nFormat('yyyy-MM-dd');
		
		//DEUDA VENCIDA
		$ctacteestadosvencida = $this->CtacteEstados->find('all')
								->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
								->andWhere(['fecha_vencimiento <' => $fech])
								->andWhere(['ctacte_tipo_registros_id <>' => 7])
								->andWhere(['ctacte_tipo_registros_id <>' => 4])
								->andWhere(['fecha_vencimiento <>' => '0101-01-01']);
		//DEUDA A VENCER								
		$ctacteestadosavencer = $this->CtacteEstados->find('all')	
								->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
								->andWhere(['ctacte_tipo_registros_id <>' => 7])
								->andWhere(['ctacte_tipo_registros_id <>' => 4])
								->andWhere(['fecha_vencimiento >=' => $fech]);
		//CREDITO SIN ASIGNAR
		$ctacteestadoscredito =$this->CtacteEstados->find('all')
								->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
								/*->andWhere(['ctacte_tipo_registros_id =' => 7])
								->andWhere(['ctacte_tipo_registros_id =' => 4])*/
								//->andWhere()		
							->andWhere(['OR' => [['ctacte_tipo_registros_id =7'],['ctacte_tipo_registros_id = 4'],['fecha_vencimiento =' => '0101-01-01']]]);
		//OBRA SOCIAL
		$ctacteestadosobrasocial =$this->CtacteEstados->find('all')
								->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
								->andWhere(['ctacte_tipo_registros_id = 7']);
		
		//DOCUMENTOS						
		$this->loadModel('CtacteDocumentoCarteras');
		$ctactedocumentoscartera = $this->CtacteDocumentoCarteras->find('all')	
								->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
								->andWhere(['fecha_deposito >' => $fech]);
		//TARJETA DE CREDITO
		$this->loadModel('CtacteTarjetasCreditos');
		$ctacteestadostarjetacredito = $this->CtacteTarjetasCreditos->find('all')	
								->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]);
		//CLIENTE CREDITO ASIGNADOS
		$this->loadModel('ClientesCreditos');
		$clientecreditos = $this->ClientesCreditos->find('all')	
								->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]);
		$clientecredito = $clientecreditos->first();			

		//DEUDA VENCIDA
		foreach ($ctacteestadosvencida as $ctacteestado): 
				
				if ($ctacteestado['signo'] == 0)
						$totalvencida = $totalvencida + $ctacteestado['importe'];
				if ($ctacteestado['signo'] == 1)
						$totalvencida = $totalvencida - $ctacteestado['importe'];
		endforeach; 
		//DEUDA A VENCER
		foreach ($ctacteestadosavencer as $ctacteestado): 
				if ($ctacteestado['signo'] == 0)
						$totalavencer = $totalavencer + $ctacteestado['importe'];
				if ($ctacteestado['signo'] == 1)
						$totalavencer = $totalavencer - $ctacteestado['importe'];
				
		endforeach; 
		//CREDITO SIN ASIGNAR
		foreach ($ctacteestadoscredito as $ctacteestado): 
				$totalcredito= $totalcredito + $ctacteestado['importe'];
		endforeach; 
		//DOCUMENTOS
		foreach ($ctactedocumentoscartera as $ctacteestado): 
				$totalcartera= $totalcartera + $ctacteestado['importe'];
		endforeach;
		//OBRA SOCIAL
		foreach ($ctacteestadosobrasocial as $ctacteestado): 
				$totalobrasocial= $totalobrasocial + $ctacteestado['importe'];
		endforeach;
		//TARJETA DE CREDITO
		foreach ($ctacteestadostarjetacredito as $ctacteestado): 
				$totaltarjetacredito = $totaltarjetacredito + $ctacteestado['importe'];
		endforeach; 
		
		
		$this->set('clientecredito',$clientecredito);
		$this->set('totalobrasocial',$totalobrasocial);
		$this->set('totalcredito',$totalcredito);
		$this->set('totalavencer',$totalavencer);
		$this->set('totalvencida',$totalvencida);
		$this->set('totalcartera',$totalcartera);
		$this->set('totaltarjetacredito',$totaltarjetacredito);
		$this->loadModel('CtacteTipoRegistros');
		
		$this->set('ctactetiporegistros', $this->CtacteTipoRegistros->find('list', ['keyField' => 'id','valueField' => 'nombre']));
		$this->set('totaldeuda',$totalcartera+$totalavencer-$totalcredito+$totalvencida);
		
		$ctacteEstados= $ctacteestadosvencida;
		$this->set('ctacteEstados',$this->paginate($ctacteEstados));
        $this->set('_serialize', ['ctacteEstados']);
    }

	public function deudaavencer()
    {
		$this->viewBuilder()->layout('store');
        $this->paginate = [
            //'contain' => ['CtacteTipoRegistros'],
			'limit' => 11
        ];
		$totalvencida=0;
		$totalavencer=0;
		$totalcredito=0;
		$totalcartera=0;
		$totalobrasocial=0;
		$totaltarjetacredito=0;
		
		$fecha = Time::now();
		$fech = $fecha->i18nFormat('yyyy-MM-dd');
		
		//DEUDA VENCIDA
		$ctacteestadosvencida = $this->CtacteEstados->find('all')
								->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
								->andWhere(['fecha_vencimiento <' => $fech])
								->andWhere(['ctacte_tipo_registros_id <>' => 7])
								->andWhere(['ctacte_tipo_registros_id <>' => 4])
								->andWhere(['fecha_vencimiento <>' => '0101-01-01']);
		//DEUDA A VENCER								
		$ctacteestadosavencer = $this->CtacteEstados->find('all')	
								->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
								->andWhere(['ctacte_tipo_registros_id <>' => 7])
								->andWhere(['ctacte_tipo_registros_id <>' => 4])
								->andWhere(['fecha_vencimiento >=' => $fech]);
		//CREDITO SIN ASIGNAR
		$ctacteestadoscredito =$this->CtacteEstados->find('all')
								->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
								/*->andWhere(['ctacte_tipo_registros_id =' => 7])
								->andWhere(['ctacte_tipo_registros_id =' => 4])*/
								//->andWhere()		
							->andWhere(['OR' => [['ctacte_tipo_registros_id =7'],['ctacte_tipo_registros_id = 4'],['fecha_vencimiento =' => '0101-01-01']]]);
		//OBRA SOCIAL
		$ctacteestadosobrasocial =$this->CtacteEstados->find('all')
								->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
								->andWhere(['ctacte_tipo_registros_id = 7']);
		
		//DOCUMENTOS						
		$this->loadModel('CtacteDocumentoCarteras');
		$ctactedocumentoscartera = $this->CtacteDocumentoCarteras->find('all')	
								->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
								->andWhere(['fecha_deposito >' => $fech]);
		//TARJETA DE CREDITO
		$this->loadModel('CtacteTarjetasCreditos');
		$ctacteestadostarjetacredito = $this->CtacteTarjetasCreditos->find('all')	
								->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]);
		//CLIENTE CREDITO ASIGNADOS
		$this->loadModel('ClientesCreditos');
		$clientecreditos = $this->ClientesCreditos->find('all')	
								->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]);
		$clientecredito = $clientecreditos->first();			

		//DEUDA VENCIDA
		foreach ($ctacteestadosvencida as $ctacteestado): 
				
				if ($ctacteestado['signo'] == 0)
						$totalvencida = $totalvencida + $ctacteestado['importe'];
				if ($ctacteestado['signo'] == 1)
						$totalvencida = $totalvencida - $ctacteestado['importe'];
		endforeach; 
		//DEUDA A VENCER
		foreach ($ctacteestadosavencer as $ctacteestado): 
				if ($ctacteestado['signo'] == 0)
						$totalavencer = $totalavencer + $ctacteestado['importe'];
				if ($ctacteestado['signo'] == 1)
						$totalavencer = $totalavencer - $ctacteestado['importe'];
				
		endforeach; 
		//CREDITO SIN ASIGNAR
		foreach ($ctacteestadoscredito as $ctacteestado): 
				$totalcredito= $totalcredito + $ctacteestado['importe'];
		endforeach; 
		//DOCUMENTOS
		foreach ($ctactedocumentoscartera as $ctacteestado): 
				$totalcartera= $totalcartera + $ctacteestado['importe'];
		endforeach;
		//OBRA SOCIAL
		foreach ($ctacteestadosobrasocial as $ctacteestado): 
				$totalobrasocial= $totalobrasocial + $ctacteestado['importe'];
		endforeach;
		//TARJETA DE CREDITO
		foreach ($ctacteestadostarjetacredito as $ctacteestado): 
				$totaltarjetacredito = $totaltarjetacredito + $ctacteestado['importe'];
		endforeach; 
		
		
		$this->set('clientecredito',$clientecredito);
		$this->set('totalobrasocial',$totalobrasocial);
		$this->set('totalcredito',$totalcredito);
		$this->set('totalavencer',$totalavencer);
		$this->set('totalvencida',$totalvencida);
		$this->set('totalcartera',$totalcartera);
		$this->set('totaltarjetacredito',$totaltarjetacredito);
		$this->loadModel('CtacteTipoRegistros');
		
		$this->set('ctactetiporegistros', $this->CtacteTipoRegistros->find('list', ['keyField' => 'id','valueField' => 'nombre']));
		$this->set('totaldeuda',$totalcartera+$totalavencer-$totalcredito+$totalvencida);
		$ctacteEstados= $ctacteestadosavencer;
		$this->set('ctacteEstados',$this->paginate($ctacteEstados));
        $this->set('_serialize', ['ctacteEstados']);
    }
	
	public function deudavencida()
    {
		$this->viewBuilder()->layout('store');
        $this->paginate = [
            //'contain' => ['CtacteTipoRegistros'],
			'limit' => 11
        ];
		$totalvencida=0;
		$totalavencer=0;
		$totalcredito=0;
		$totalcartera=0;
		$totalobrasocial=0;
		$totaltarjetacredito=0;
		
		$fecha = Time::now();
		$fech = $fecha->i18nFormat('yyyy-MM-dd');
		
		//DEUDA VENCIDA
		$ctacteestadosvencida = $this->CtacteEstados->find('all')
								->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
								->andWhere(['fecha_vencimiento <' => $fech])
								->andWhere(['ctacte_tipo_registros_id <>' => 7])
								->andWhere(['ctacte_tipo_registros_id <>' => 4])
								->andWhere(['fecha_vencimiento <>' => '0101-01-01']);
		//DEUDA A VENCER								
		$ctacteestadosavencer = $this->CtacteEstados->find('all')	
								->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
								->andWhere(['ctacte_tipo_registros_id <>' => 7])
								->andWhere(['ctacte_tipo_registros_id <>' => 4])
								->andWhere(['fecha_vencimiento >=' => $fech]);
		//CREDITO SIN ASIGNAR
		$ctacteestadoscredito =$this->CtacteEstados->find('all')
								->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
								/*->andWhere(['ctacte_tipo_registros_id =' => 7])
								->andWhere(['ctacte_tipo_registros_id =' => 4])*/
								//->andWhere()		
							->andWhere(['OR' => [['ctacte_tipo_registros_id =7'],['ctacte_tipo_registros_id = 4'],['fecha_vencimiento =' => '0101-01-01']]]);
		//OBRA SOCIAL
		$ctacteestadosobrasocial =$this->CtacteEstados->find('all')
								->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
								->andWhere(['ctacte_tipo_registros_id = 7']);
		
		//DOCUMENTOS						
		$this->loadModel('CtacteDocumentoCarteras');
		$ctactedocumentoscartera = $this->CtacteDocumentoCarteras->find('all')	
								->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
								->andWhere(['fecha_deposito >' => $fech]);
		//TARJETA DE CREDITO
		$this->loadModel('CtacteTarjetasCreditos');
		$ctacteestadostarjetacredito = $this->CtacteTarjetasCreditos->find('all')	
								->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]);
		//CLIENTE CREDITO ASIGNADOS
		$this->loadModel('ClientesCreditos');
		$clientecreditos = $this->ClientesCreditos->find('all')	
								->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]);
		$clientecredito = $clientecreditos->first();			

		//DEUDA VENCIDA
		foreach ($ctacteestadosvencida as $ctacteestado): 
				
				if ($ctacteestado['signo'] == 0)
						$totalvencida = $totalvencida + $ctacteestado['importe'];
				if ($ctacteestado['signo'] == 1)
						$totalvencida = $totalvencida - $ctacteestado['importe'];
		endforeach; 
		//DEUDA A VENCER
		foreach ($ctacteestadosavencer as $ctacteestado): 
				if ($ctacteestado['signo'] == 0)
						$totalavencer = $totalavencer + $ctacteestado['importe'];
				if ($ctacteestado['signo'] == 1)
						$totalavencer = $totalavencer - $ctacteestado['importe'];
				
		endforeach; 
		//CREDITO SIN ASIGNAR
		foreach ($ctacteestadoscredito as $ctacteestado): 
				$totalcredito= $totalcredito + $ctacteestado['importe'];
		endforeach; 
		//DOCUMENTOS
		foreach ($ctactedocumentoscartera as $ctacteestado): 
				$totalcartera= $totalcartera + $ctacteestado['importe'];
		endforeach;
		//OBRA SOCIAL
		foreach ($ctacteestadosobrasocial as $ctacteestado): 
				$totalobrasocial= $totalobrasocial + $ctacteestado['importe'];
		endforeach;
		//TARJETA DE CREDITO
		foreach ($ctacteestadostarjetacredito as $ctacteestado): 
				$totaltarjetacredito = $totaltarjetacredito + $ctacteestado['importe'];
		endforeach; 
		
		
		$this->set('clientecredito',$clientecredito);
		$this->set('totalobrasocial',$totalobrasocial);
		$this->set('totalcredito',$totalcredito);
		$this->set('totalavencer',$totalavencer);
		$this->set('totalvencida',$totalvencida);
		$this->set('totalcartera',$totalcartera);
		$this->set('totaltarjetacredito',$totaltarjetacredito);
		$this->loadModel('CtacteTipoRegistros');
		
		$this->set('ctactetiporegistros', $this->CtacteTipoRegistros->find('list', ['keyField' => 'id','valueField' => 'nombre']));
		$this->set('totaldeuda',$totalcartera+$totalavencer-$totalcredito+$totalvencida);
		//$ctacteEstados= $ctacteestadosavencer;
		$ctacteEstados= $ctacteestadosvencida;
		//$ctacteEstados= $ctacteestadosvencida;
		/*$this->CtacteEstados->find('all')	
					->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
					
					->andWhere(['fecha_vencimiento >=' => $fech]);
					*/
		$this->set('ctacteEstados',$this->paginate($ctacteEstados));
        $this->set('_serialize', ['ctacteEstados']);
    }
	
	public function credito()
    {
		
		$this->viewBuilder()->layout('store');
        $this->paginate = [
            //'contain' => ['CtacteTipoRegistros'],
			'limit' => 11
        ];
		$totalvencida=0;
		$totalavencer=0;
		$totalcredito=0;
		$totalcartera=0;
		$totalobrasocial=0;
		$totaltarjetacredito=0;
		
		$fecha = Time::now();
		$fech = $fecha->i18nFormat('yyyy-MM-dd');
		
		//DEUDA VENCIDA
		$ctacteestadosvencida = $this->CtacteEstados->find('all')
								->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
								->andWhere(['fecha_vencimiento <' => $fech])
								->andWhere(['ctacte_tipo_registros_id <>' => 7])
								->andWhere(['ctacte_tipo_registros_id <>' => 4])
								->andWhere(['fecha_vencimiento <>' => '0101-01-01']);
		//DEUDA A VENCER								
		$ctacteestadosavencer = $this->CtacteEstados->find('all')	
								->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
								->andWhere(['ctacte_tipo_registros_id <>' => 7])
								->andWhere(['ctacte_tipo_registros_id <>' => 4])
								->andWhere(['fecha_vencimiento >=' => $fech]);
		//CREDITO SIN ASIGNAR
		$ctacteestadoscredito =$this->CtacteEstados->find('all')
								->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
								/*->andWhere(['ctacte_tipo_registros_id =' => 7])
								->andWhere(['ctacte_tipo_registros_id =' => 4])*/
								//->andWhere()		
							->andWhere(['OR' => [['ctacte_tipo_registros_id =7'],['ctacte_tipo_registros_id = 4'],['fecha_vencimiento =' => '0101-01-01']]]);
		//OBRA SOCIAL
		$ctacteestadosobrasocial =$this->CtacteEstados->find('all')
								->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
								->andWhere(['ctacte_tipo_registros_id = 7']);
		
		//DOCUMENTOS						
		$this->loadModel('CtacteDocumentoCarteras');
		$ctactedocumentoscartera = $this->CtacteDocumentoCarteras->find('all')	
								->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
								->andWhere(['fecha_deposito >' => $fech]);
		//TARJETA DE CREDITO
		$this->loadModel('CtacteTarjetasCreditos');
		$ctacteestadostarjetacredito = $this->CtacteTarjetasCreditos->find('all')	
								->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]);
		//CLIENTE CREDITO ASIGNADOS
		$this->loadModel('ClientesCreditos');
		$clientecreditos = $this->ClientesCreditos->find('all')	
								->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]);
		$clientecredito = $clientecreditos->first();			

		//DEUDA VENCIDA
		foreach ($ctacteestadosvencida as $ctacteestado): 
				
				if ($ctacteestado['signo'] == 0)
						$totalvencida = $totalvencida + $ctacteestado['importe'];
				if ($ctacteestado['signo'] == 1)
						$totalvencida = $totalvencida - $ctacteestado['importe'];
		endforeach; 
		//DEUDA A VENCER
		foreach ($ctacteestadosavencer as $ctacteestado): 
				if ($ctacteestado['signo'] == 0)
						$totalavencer = $totalavencer + $ctacteestado['importe'];
				if ($ctacteestado['signo'] == 1)
						$totalavencer = $totalavencer - $ctacteestado['importe'];
				
		endforeach; 
		//CREDITO SIN ASIGNAR
		foreach ($ctacteestadoscredito as $ctacteestado): 
				$totalcredito= $totalcredito + $ctacteestado['importe'];
		endforeach; 
		//DOCUMENTOS
		foreach ($ctactedocumentoscartera as $ctacteestado): 
				$totalcartera= $totalcartera + $ctacteestado['importe'];
		endforeach;
		//OBRA SOCIAL
		foreach ($ctacteestadosobrasocial as $ctacteestado): 
				$totalobrasocial= $totalobrasocial + $ctacteestado['importe'];
		endforeach;
		//TARJETA DE CREDITO
		foreach ($ctacteestadostarjetacredito as $ctacteestado): 
				$totaltarjetacredito = $totaltarjetacredito + $ctacteestado['importe'];
		endforeach; 
		
		
		$this->set('clientecredito',$clientecredito);
		$this->set('totalobrasocial',$totalobrasocial);
		$this->set('totalcredito',$totalcredito);
		$this->set('totalavencer',$totalavencer);
		$this->set('totalvencida',$totalvencida);
		$this->set('totalcartera',$totalcartera);
		$this->set('totaltarjetacredito',$totaltarjetacredito);
		$this->loadModel('CtacteTipoRegistros');
		
		$this->set('ctactetiporegistros', $this->CtacteTipoRegistros->find('list', ['keyField' => 'id','valueField' => 'nombre']));
		$this->set('totaldeuda',$totalcartera+$totalavencer-$totalcredito+$totalvencida);
		
		$this->set('ctacteCreditos',$this->paginate($ctacteestadostarjetacredito));
        $this->set('_serialize', ['ctacteCreditos']);
    }
	
	public function documentocartera()
    {
		$this->viewBuilder()->layout('store');
        $this->paginate = [
            //'contain' => ['CtacteTipoRegistros'],
			'limit' => 11
        ];
		$totalvencida=0;
		$totalavencer=0;
		$totalcredito=0;
		$totalcartera=0;
		$totalobrasocial=0;
		$totaltarjetacredito=0;
		
		$fecha = Time::now();
		$fech = $fecha->i18nFormat('yyyy-MM-dd');
		
		//DEUDA VENCIDA
		$ctacteestadosvencida = $this->CtacteEstados->find('all')
								->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
								->andWhere(['fecha_vencimiento <' => $fech])
								->andWhere(['ctacte_tipo_registros_id <>' => 7])
								->andWhere(['ctacte_tipo_registros_id <>' => 4])
								->andWhere(['fecha_vencimiento <>' => '0101-01-01']);
		//DEUDA A VENCER								
		$ctacteestadosavencer = $this->CtacteEstados->find('all')	
								->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
								->andWhere(['ctacte_tipo_registros_id <>' => 7])
								->andWhere(['ctacte_tipo_registros_id <>' => 4])
								->andWhere(['fecha_vencimiento >=' => $fech]);
		//CREDITO SIN ASIGNAR
		$ctacteestadoscredito =$this->CtacteEstados->find('all')
								->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
								/*->andWhere(['ctacte_tipo_registros_id =' => 7])
								->andWhere(['ctacte_tipo_registros_id =' => 4])*/
								//->andWhere()		
							->andWhere(['OR' => [['ctacte_tipo_registros_id =7'],['ctacte_tipo_registros_id = 4'],['fecha_vencimiento =' => '0101-01-01']]]);
		//OBRA SOCIAL
		$ctacteestadosobrasocial =$this->CtacteEstados->find('all')
								->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
								->andWhere(['ctacte_tipo_registros_id = 7']);
		
		//DOCUMENTOS						
		$this->loadModel('CtacteDocumentoCarteras');
		$ctactedocumentoscartera = $this->CtacteDocumentoCarteras->find('all')	
								->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
								->andWhere(['fecha_deposito >' => $fech]);
		//TARJETA DE CREDITO
		$this->loadModel('CtacteTarjetasCreditos');
		$ctacteestadostarjetacredito = $this->CtacteTarjetasCreditos->find('all')	
								->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]);
		//CLIENTE CREDITO ASIGNADOS
		$this->loadModel('ClientesCreditos');
		$clientecreditos = $this->ClientesCreditos->find('all')	
								->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]);
		$clientecredito = $clientecreditos->first();			

		//DEUDA VENCIDA
		foreach ($ctacteestadosvencida as $ctacteestado): 
				
				if ($ctacteestado['signo'] == 0)
						$totalvencida = $totalvencida + $ctacteestado['importe'];
				if ($ctacteestado['signo'] == 1)
						$totalvencida = $totalvencida - $ctacteestado['importe'];
		endforeach; 
		//DEUDA A VENCER
		foreach ($ctacteestadosavencer as $ctacteestado): 
				if ($ctacteestado['signo'] == 0)
						$totalavencer = $totalavencer + $ctacteestado['importe'];
				if ($ctacteestado['signo'] == 1)
						$totalavencer = $totalavencer - $ctacteestado['importe'];
				
		endforeach; 
		//CREDITO SIN ASIGNAR
		foreach ($ctacteestadoscredito as $ctacteestado): 
				$totalcredito= $totalcredito + $ctacteestado['importe'];
		endforeach; 
		//DOCUMENTOS
		foreach ($ctactedocumentoscartera as $ctacteestado): 
				$totalcartera= $totalcartera + $ctacteestado['importe'];
		endforeach;
		//OBRA SOCIAL
		foreach ($ctacteestadosobrasocial as $ctacteestado): 
				$totalobrasocial= $totalobrasocial + $ctacteestado['importe'];
		endforeach;
		//TARJETA DE CREDITO
		foreach ($ctacteestadostarjetacredito as $ctacteestado): 
				$totaltarjetacredito = $totaltarjetacredito + $ctacteestado['importe'];
		endforeach; 
		
		
		$this->set('clientecredito',$clientecredito);
		$this->set('totalobrasocial',$totalobrasocial);
		$this->set('totalcredito',$totalcredito);
		$this->set('totalavencer',$totalavencer);
		$this->set('totalvencida',$totalvencida);
		$this->set('totalcartera',$totalcartera);
		$this->set('totaltarjetacredito',$totaltarjetacredito);
		$this->loadModel('CtacteTipoRegistros');
		
		$this->set('ctactetiporegistros', $this->CtacteTipoRegistros->find('list', ['keyField' => 'id','valueField' => 'nombre']));
		$this->set('totaldeuda',$totalcartera+$totalavencer-$totalcredito+$totalvencida);
		//$ctacteEstados= $ctacteestadosavencer;
		$ctacteEstados= $ctactedocumentoscartera;
		//$ctacteEstados= $ctacteestadosvencida;
		/*$this->CtacteEstados->find('all')	
					->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
					
					->andWhere(['fecha_vencimiento >=' => $fech]);
					*/
		$this->set('ctacteEstados',$this->paginate($ctacteEstados));
        $this->set('_serialize', ['ctacteEstados']);
    }

	public function obrasocial()
    {
		$this->viewBuilder()->layout('store');
        $this->paginate = [
            //'contain' => ['CtacteTipoRegistros'],
			'limit' => 11
        ];
		$totalvencida=0;
		$totalavencer=0;
		$totalcredito=0;
		$totalcartera=0;
		$totalobrasocial=0;
		$totaltarjetacredito=0;
		
		$fecha = Time::now();
		$fech = $fecha->i18nFormat('yyyy-MM-dd');
		
		//DEUDA VENCIDA
		$ctacteestadosvencida = $this->CtacteEstados->find('all')
								->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
								->andWhere(['fecha_vencimiento <' => $fech])
								->andWhere(['ctacte_tipo_registros_id <>' => 7])
								->andWhere(['ctacte_tipo_registros_id <>' => 4])
								->andWhere(['fecha_vencimiento <>' => '0101-01-01']);
		//DEUDA A VENCER								
		$ctacteestadosavencer = $this->CtacteEstados->find('all')	
								->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
								->andWhere(['ctacte_tipo_registros_id <>' => 7])
								->andWhere(['ctacte_tipo_registros_id <>' => 4])
								->andWhere(['fecha_vencimiento >=' => $fech]);
		//CREDITO SIN ASIGNAR
		$ctacteestadoscredito =$this->CtacteEstados->find('all')
								->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
								/*->andWhere(['ctacte_tipo_registros_id =' => 7])
								->andWhere(['ctacte_tipo_registros_id =' => 4])*/
								//->andWhere()		
							->andWhere(['OR' => [['ctacte_tipo_registros_id =7'],['ctacte_tipo_registros_id = 4'],['fecha_vencimiento =' => '0101-01-01']]]);
		//OBRA SOCIAL
		$ctacteestadosobrasocial =$this->CtacteEstados->find('all')
								->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
								->andWhere(['ctacte_tipo_registros_id = 7']);
		
		//DOCUMENTOS						
		$this->loadModel('CtacteDocumentoCarteras');
		$ctactedocumentoscartera = $this->CtacteDocumentoCarteras->find('all')	
								->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
								->andWhere(['fecha_deposito >' => $fech]);
		//TARJETA DE CREDITO
		$this->loadModel('CtacteTarjetasCreditos');
		$ctacteestadostarjetacredito = $this->CtacteTarjetasCreditos->find('all')	
								->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]);
		//CLIENTE CREDITO ASIGNADOS
		$this->loadModel('ClientesCreditos');
		$clientecreditos = $this->ClientesCreditos->find('all')	
								->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]);
		$clientecredito = $clientecreditos->first();			

		//DEUDA VENCIDA
		foreach ($ctacteestadosvencida as $ctacteestado): 
				
				if ($ctacteestado['signo'] == 0)
						$totalvencida = $totalvencida + $ctacteestado['importe'];
				if ($ctacteestado['signo'] == 1)
						$totalvencida = $totalvencida - $ctacteestado['importe'];
		endforeach; 
		//DEUDA A VENCER
		foreach ($ctacteestadosavencer as $ctacteestado): 
				if ($ctacteestado['signo'] == 0)
						$totalavencer = $totalavencer + $ctacteestado['importe'];
				if ($ctacteestado['signo'] == 1)
						$totalavencer = $totalavencer - $ctacteestado['importe'];
				
		endforeach; 
		//CREDITO SIN ASIGNAR
		foreach ($ctacteestadoscredito as $ctacteestado): 
				$totalcredito= $totalcredito + $ctacteestado['importe'];
		endforeach; 
		//DOCUMENTOS
		foreach ($ctactedocumentoscartera as $ctacteestado): 
				$totalcartera= $totalcartera + $ctacteestado['importe'];
		endforeach;
		//OBRA SOCIAL
		foreach ($ctacteestadosobrasocial as $ctacteestado): 
				$totalobrasocial= $totalobrasocial + $ctacteestado['importe'];
		endforeach;
		//TARJETA DE CREDITO
		foreach ($ctacteestadostarjetacredito as $ctacteestado): 
				$totaltarjetacredito = $totaltarjetacredito + $ctacteestado['importe'];
		endforeach; 
		
		
		$this->set('clientecredito',$clientecredito);
		$this->set('totalobrasocial',$totalobrasocial);
		$this->set('totalcredito',$totalcredito);
		$this->set('totalavencer',$totalavencer);
		$this->set('totalvencida',$totalvencida);
		$this->set('totalcartera',$totalcartera);
		$this->set('totaltarjetacredito',$totaltarjetacredito);
		$this->loadModel('CtacteTipoRegistros');
		
		$this->set('ctactetiporegistros', $this->CtacteTipoRegistros->find('list', ['keyField' => 'id','valueField' => 'nombre']));
		$this->set('totaldeuda',$totalcartera+$totalavencer-$totalcredito+$totalvencida);
		$this->loadModel('CtacteObrasSociales');
	    $ctacteObrasSociales =$this->CtacteObrasSociales->find('all')->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]);
		
		$this->set('ctacteObrasSociales',$this->paginate($ctacteObrasSociales));
        $this->set('_serialize', ['ctacteEstados']);
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
