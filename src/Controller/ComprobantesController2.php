<?php
namespace App\Controller;
use Cake\I18n\Time;
use App\Controller\AppController;
use Cake\Filesystem\File;
use Cake\Network\Request;

/**
 * Comprobantes Controller
 *
 * @property \App\Model\Table\ComprobantesTable $Comprobantes
 */
class ComprobantesController extends AppController
{

	public function isAuthorized()
    {
	     if (in_array($this->request->action, ['view','search','index','view_admin','search_admin','index_admin','home','downloadfile','downloadfiletrazatxt','traza','downloadfiletxt','downloadfiletxt2','downloadfiletxtselect','excel'])) {
    			if($this->request->session()->read('Auth.User.role')=='admin') 
				{				
					return true;			
				}			
				else 
				{	
					if($this->request->session()->read('Auth.User.role')=='client') 
					{	
						$tiene= $this->tienepermiso('comprobantes',$this->request->action);
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
     *  Index
     */
	public function index()// LISTO
    {
		$this->viewBuilder()->layout('store');
        $this->paginate = [
			'limit' => 50
            //'contain' => ['Clientes']
        ];
		if ($this->request->is('post','get'))
		{	
			if ($this->request->data['cliente_id']!= null)
				$cliente_id = $this->request->data['cliente_id'];
			else
				$cliente_id = $this->request->session()->read('Auth.User.cliente_id');
		    $this->request->session()->write('cliente_id',$cliente_id);
			
			$this->loadModel('Clientes');
			$client = $this->Clientes->get($this->request->session()->read('cliente_id'));		
			$this->request->session()->write('client',$client);
		}
		else 
		{
			if (!empty($this->request->session()->read('cliente_id')))
				$cliente_id = $this->request->session()->read('cliente_id');
			else			
				$cliente_id = $this->request->session()->read('Auth.User.cliente_id');
			$this->request->session()->write('cliente_id',$cliente_id);
			if (empty($this->request->session()->read('client')))
			{
				$this->loadModel('Clientes');
				$client = $this->Clientes->get($this->request->session()->read('cliente_id'));		
				$this->request->session()->write('client',$client);
			}
		}
		
		
		$fecha = Time::now();
		$fecha->setDate($fecha->year, $fecha->month, 1);
		$fecha->i18nFormat('yyyy-MM-dd');
		
		$fecha2 = Time::now();
		$fecha2->modify('+1 days');
		$fecha2= $fecha2->i18nFormat('yyyy-MM-dd');
		
		$query = $this->Comprobantes->find('all')
					->contain (['ComprobantesTipos'])
					->where(['cliente_id' => $this->request->session()->read('cliente_id')])
					->andWhere(['fecha BETWEEN :start AND :end'])
								->bind(':start', $fecha, 'date')
								->bind(':end',   $fecha2, 'date')
					->order(['fecha' => 'ASC','nota'=>'ASC']);
					
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
			$clientes[$this->request->session()->read('Auth.User.cliente_id')] = $this->request->session()->read('Auth.User.codigo').' - '.$this->request->session()->read('Auth.User.razon');
		
		$this->set('clientes',$clientes);
        $this->set('comprobantes', $this->paginate($query));
        $this->set('_serialize', ['comprobantes']);
    }

	
	/** 
	* Search 
	*/
	public function search()// LISTO
    {
		if ($this->request->is('post','get'))
		{	
			if ($this->request->data['cliente_id']!= null)
				$cliente_id = $this->request->data['cliente_id'];
			else
				$cliente_id = $this->request->session()->read('Auth.User.cliente_id');
		    $this->request->session()->write('cliente_id',$cliente_id);
			
			$this->loadModel('Clientes');
			$client = $this->Clientes->get($this->request->session()->read('cliente_id'));		
			$this->request->session()->write('client',$client);
		}
		else 
		{
			if (!empty($this->request->session()->read('cliente_id')))
				$cliente_id = $this->request->session()->read('cliente_id');
			else			
				$cliente_id = $this->request->session()->read('Auth.User.cliente_id');
			$this->request->session()->write('cliente_id',$cliente_id);
			if (empty($this->request->session()->read('client')))
			{
				$this->loadModel('Clientes');
				$client = $this->Clientes->get($this->request->session()->read('cliente_id'));		
				$this->request->session()->write('client',$client);
			}
		}
		if ($this->request->is('post'))
		{	
			if ($this->request->data['fechadesde']!= null)
				$fechadesde = $this->request->data['fechadesde'];
			else
				$fechadesde=0;
			if ($this->request->data['fechahasta']!= null)
				$fechahasta = $this->request->data['fechahasta'];
			else
				$fechahasta =0;
			if ($this->request->data['terminobuscar']!= null)
				$termsearch = $this->request->data['terminobuscar'];
			else
				$termsearch ="";
			if ($this->request->data['factura']!= null)
				$factura = $this->request->data['factura'];
			else
				$factura=0;
			if ($this->request->data['notacredito']!= null)
				$notacredito = $this->request->data['notacredito'];
			else
				$notacredito=0;
			if ($this->request->data['notadebito']!= null)
				$notadebito = $this->request->data['notadebito'];
			else
				$notadebito=0;
			if ($this->request->data['recibo']!= null)
				$recibo = $this->request->data['recibo'];
			else
				$recibo=0;
			$this->request->session()->write('termsearch',$termsearch);
			$this->request->session()->write('fechadesde',$fechadesde);	
			$this->request->session()->write('fechahasta',$fechahasta);

			$this->request->session()->write('factura',$factura);
			$this->request->session()->write('notacredito',$notacredito);	
			$this->request->session()->write('notadebito',$notadebito);
			$this->request->session()->write('recibo',$recibo);
		}
		else 
		{
	
			$fechahasta = $this->request->session()->read('fechahasta');
		    $fechadesde = $this->request->session()->read('fechadesde');
			$termsearch = $this->request->session()->read('termsearch');
			
			$factura = $this->request->session()->read('factura');
		    $notacredito = $this->request->session()->read('notacredito');
			$notadebito = $this->request->session()->read('notadebito');
			$recibo = $this->request->session()->read('recibo');
			
		}
		
		$this->viewBuilder()->layout('store');
        
		$this->paginate = [
			'limit' => 50
            //'contain' => ['Clientes', 'ComprobantesTipos']
        ];
		
		$query = $this->Comprobantes->find('all')
									->contain (['ComprobantesTipos'])
									->where(['cliente_id' => $this->request->session()->read('cliente_id')]);
		
		$filtro = array();
		if ($factura==1) array_push($filtro, 1);
		if ($notadebito==1) array_push($filtro, 2);
		if ($notacredito==1) array_push($filtro, 3);
		if ($recibo==1)	array_push($filtro, 4);
		
		if ($factura==1 || $notadebito==1 || $notacredito==1 || $recibo==1)
			$query->andWhere(['Comprobantes.comprobante_tipo_id in '=>$filtro]);
		

		if ($fechahasta!=0)
		{
			$fechahasta2 = Time::createFromFormat('d/m/Y',$fechahasta,'America/Argentina/Buenos_Aires');
			$fechahasta2->modify('+1 days');
			$fechahasta2->i18nFormat('yyyy-MM-dd');
			
		}
		else
		{
			$fechahasta2 = Time::now();
			$fechahasta2-> modify('+1 days');
		}
		if ($fechadesde!=0)
		{
			$fechadesde2 = Time::createFromFormat('d/m/Y',$fechadesde,'America/Argentina/Buenos_Aires');
			$fechadesde2->i18nFormat('yyyy-MM-dd');
		}
		else
		{
			$fechadesde2 = Time::now();
			if ($fechahasta!=0)
				$fechadesde2->setDate($fechadesde2->year, $fechahasta2->month, 1);
			else
				$fechadesde2->setDate($fechadesde2->year, $fechadesde2->month, 1);
			$fechadesde2->i18nFormat('yyyy-MM-dd');
		}

		$query->andWhere(["Comprobantes.fecha BETWEEN '".$fechadesde2->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta2->i18nFormat('yyyy-MM-dd')."'"])
		->order(['fecha' => 'ASC']);
		if ($termsearch!="")
		{
			$query->andWhere([
					'OR' => [['Comprobantes.nota'=>$termsearch], 
					['Comprobantes.numero'=>$termsearch]],
				]);
			
		}
        else
		{
		}
		if ($query!=null)
		
			$comprobantes = $this->paginate($query);
		
		else
			$comprobantes = null;

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
			$clientes[$this->request->session()->read('Auth.User.cliente_id')] = $this->request->session()->read('Auth.User.codigo').' - '.$this->request->session()->read('Auth.User.razon');
	
		$this->set('clientes', $clientes);
        $this->set('comprobantes', $comprobantes);
        $this->set('_serialize', ['comprobantes']);
	}

	public function search2()
    {
		$this->viewBuilder()->layout('store');
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
			if ($this->request->data['terminobuscar']!= null)
			{
				$termsearchp = '%'.$this->request->data['terminobuscar'].'%';
			}	
			else
			{
				$termsearchp ="";
			}	
			$this->request->session()->write('termsearchp',$termsearchp);
			$this->request->session()->write('fechadesde',$fechadesde);	
			$this->request->session()->write('fechahasta',$fechahasta);
		}
		else 
		{
			$fechahasta = $this->request->session()->read('fechahasta');
		    $fechadesde = $this->request->session()->read('fechadesde');
			$termsearchp = $this->request->session()->read('termsearchp');
		}
		
        $this->paginate = [		
		'limit' => 50,
		];
		
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
			if ($fechahasta!=0)
				$fechadesde2->setDate($fechadesde2->year, $fechahasta2->month, 1);
			else
				$fechadesde2->setDate($fechadesde2->year, $fechadesde2->month, 1);
			$fechadesde2->i18nFormat('yyyy-MM-dd');
		}


	  	if ($termsearchp!="")
		{
			if (($fechadesde !=0) && ($fechahasta !=0))
			{
				$pedidosA = $this->Pedidos->find('all')
				->select(['id', 
				'creado', 
				'cliente_id', 
				'sucursal_id', 
				'tipo_fact', 
				'forma_envio', 
				'estado_id'])
				->hydrate(false)
				->join([
					'pe' => [
						'table' => 'pedidos_items',
						'type' => 'left',
						'conditions' => 'pe.pedido_id = Pedidos.id',
					],
					'a' => [
						'table' => 'articulos',
						'type' => 'left',
						'conditions' => 'a.id = pe.articulo_id',
					]
				])
				->where(['Pedidos.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
				->where(['a.descripcion_pag LIKE'=>$termsearchp])
				->orWhere(['a.troquel LIKE'=>$termsearchp])
				->andWhere(["Pedidos.creado BETWEEN '".$fechadesde2->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta2->i18nFormat('yyyy-MM-dd')."'"])
				->group('Pedidos.id')
				->order(['fecha' => 'ASC']);
	
			}
			else
			{
				if (($fechadesde !=0) || ($fechahasta !=0))
				{
				 $pedidosA = $this->Pedidos->find('all')
				->select(['id', 
				'creado', 
				'cliente_id', 
				'sucursal_id', 
				'tipo_fact', 
				'forma_envio', 
				'estado_id'])
				->hydrate(false)
				->join([
					'pe' => [
						'table' => 'pedidos_items',
						'type' => 'INNER',
						'conditions' => 'pe.pedido_id = Pedidos.id',
					],
					'a' => [
						'table' => 'articulos',
						'type' => 'INNER',
						'conditions' => 'a.id = pe.articulo_id',
					]
				])
				->where(['Pedidos.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
				->where(['a.descripcion_pag LIKE'=>$termsearchp])
				->orWhere(['a.troquel LIKE'=>$termsearchp])
				->andWhere(["Pedidos.creado BETWEEN '".$fechadesde2->i18nFormat('yyyy-MM-dd')."' AND '".$fechadesde2->i18nFormat('yyyy-MM-dd')."'"])
				->group('Pedidos.id')
				->order(['fecha' => 'ASC']);
				}
				else
				{
					 $pedidosA = $this->Pedidos->find('all')
					->select(['id', 
					'creado', 
					'cliente_id', 
					'sucursal_id', 
					'tipo_fact', 
					'forma_envio', 
					'estado_id'])
					->hydrate(false)
					->join([
						'pe' => [
							'table' => 'pedidos_items',
							'type' => 'INNER',
							'conditions' => 'pe.pedido_id = Pedidos.id',
						],
						'a' => [
							'table' => 'articulos',
							'type' => 'INNER',
							'conditions' => 'a.id = pe.articulo_id',
						]
					])
					->where(['Pedidos.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
					->where(['a.descripcion_pag LIKE'=>$termsearchp])
					->orWhere(['a.troquel LIKE'=>$termsearchp])
					->group('Pedidos.id')
					->order(['fecha' => 'ASC']);
				}	
			}
		}
        else
		{
			if (($fechadesde !=0) || ($fechahasta !=0))
			{
				$pedidosA = $this->Pedidos->find('all')
				/*->select(['id', 
					'creado', 
					'cliente_id', 
					'sucursal_id', 
					'tipo_fact', 
					'forma_envio', 
					'estado_id'])
				->hydrate(false)
				->join([
					'pe' => [
						'table' => 'pedidos_items',
						'type' => 'INNER',
						'conditions' => 'pe.pedido_id = Pedidos.id',
					],
					'a' => [
						'table' => 'articulos',
						'type' => 'INNER',
						'conditions' => 'a.id = pe.articulo_id',
					]
				])*/
				->where(['Pedidos.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
				->andWhere(["Pedidos.creado BETWEEN '".$fechadesde2->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta2->i18nFormat('yyyy-MM-dd')."'"])
				->group('Pedidos.id')
				->order(['fecha' => 'ASC']);
			}
			else
					{
						$pedidosA=null;
						$this->redirect($this->referer());
					}
				
					
		}
		if ($pedidosA!=null)
		{
			$pedidos = $this->paginate($pedidosA);
		}
		else
			$pedidos = null;
		//debug($pedidos);
		$this->set('pedidos',$pedidos);
		$this->loadModel('Estados');
		$estados=$this->Estados->find('all');
		$this->set('estados', $estados->toArray());
		
		$this->loadModel('Carritos');
		$carritocon = $this->Carritos->find('all')	
					->where(['Carritos.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
					->order(['Carritos.id' => 'DESC']);
		$totalcarrito=0;
		$totalitems=0;
		$totalunidades=0;
		$this->loadModel('ClientesCreditos');
		$clientecreditos = $this->ClientesCreditos->find('all')	
					->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]);
		$clientecredito = $clientecreditos->first();
		$this->set('creditodisponible',$clientecredito['credito_maximo']-$clientecredito['credito_consumo']);
	
		foreach ($carritocon as $carrito): 
			$totalitems+=1;
			$totalcarrito= $totalcarrito + $carrito['cantidad']*round(h($carrito['precio_publico'])*0.807, 3);
			$totalunidades= $totalunidades + $carrito['cantidad'] ;
		endforeach; 
		$this->set('totalitems',$totalitems);
		$this->set('totalcarrito',$totalcarrito);
		$this->set('totalunidades',$totalunidades);
    }
	
	public function traza($id = null)
    {
		$this->viewBuilder()->layout('store');
        $comprobante = $this->Comprobantes->get($id, [
            'contain' => ['ComprobantesTipos']
        ]);
		$this->loadModel('Trazas');
        $this->paginate = [
            'contain' => ['Articulos', 'Clientes']
        ];
		
		
		$query =$this->Trazas->find('all')
							 ->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
							 ->andWhere(['nota'=>$comprobante->nota]);
							 
        $this->set('trazas', $this->paginate($query));
        $this->set('_serialize', ['trazas']);
        
        
        $this->set(compact('comprobante'));
        $this->set('_serialize', ['comprobante']);
    }
    	
	public function excel()
	{
		$this->viewBuilder()->layout('ajax');
	
		if ($this->request->is('post','get'))
		{	
			if ($this->request->data['fechadesde']!= null)
				$fechadesde = $this->request->data['fechadesde'];
			else
				$fechadesde=0;
			if ($this->request->data['fechahasta']!= null)
				$fechahasta = $this->request->data['fechahasta'];
			else
				$fechahasta =0;
			if ($this->request->data['terminobuscar']!= null)
				$termsearch = $this->request->data['terminobuscar'];
			else
				$termsearch ="";
			$this->request->session()->write('termsearch',$termsearch);
			$this->request->session()->write('fechadesde',$fechadesde);	
			$this->request->session()->write('fechahasta',$fechahasta);
		}
		else 
		{
			$fechahasta = $this->request->session()->read('fechahasta');
		    $fechadesde = $this->request->session()->read('fechadesde');
			$termsearch = $this->request->session()->read('termsearch');
		}
		
		$this->loadModel('FacturasCabeceras');
        $this->paginate = [
            'limit' => 2000
        ];
		
		if ($fechahasta!=0)
		{
			$fecha2 = Time::createFromFormat('d/m/Y',$fechahasta,'America/Argentina/Buenos_Aires');
			$fecha2->modify('+1 days');
		}
		else
		{
			$fecha2 = Time::now();
			$fecha2-> modify('+1 days');
		}
		if ($fechadesde!=0)
		{
			$fecha= Time::createFromFormat('d/m/Y',$fechadesde,'America/Argentina/Buenos_Aires');
		}
		else
		{
			$fecha = Time::now();
			if ($fechahasta!=0)
				$fecha->setDate($fecha2->year, $fecha2->month, 1);
			else
				$fecha->setDate($fecha->year, $fecha->month, 1);
			//$fechadesde2->i18nFormat('yyyy-MM-dd');
		}
		$facturascabeceras = $this->FacturasCabeceras->find('all')	
					->contain(['Comprobantes'])
					->join([
					'c' => [
						'table' => 'comprobantes',
						'type' => 'LEFT',
						'conditions' => 'FacturasCabeceras.comprobante_id = c.id',
					]
					])
					
					->where(['FacturasCabeceras.cliente_id' => $this->request->session()->read('cliente_id')])
					->andWhere(["FacturasCabeceras.fecha BETWEEN '".$fecha->i18nFormat('yyyy-MM-dd')."' AND '".$fecha2->i18nFormat('yyyy-MM-dd')."'"])
					->order(['FacturasCabeceras.fecha' => 'ASC','FacturasCabeceras.pedido_ds' => 'ASC'])
					->group('FacturasCabeceras.pedido_ds');
		if ($termsearch!="")
		{
			$facturascabeceras->andWhere([
					'OR' => [['c.nota'=>$termsearch], 
					['c.numero'=>$termsearch]],
				]);
			
		}
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
					
					->where(['NotasCabeceras.cliente_id' => $this->request->session()->read('cliente_id')])
					->andWhere(["NotasCabeceras.fecha BETWEEN '".$fecha->i18nFormat('yyyy-MM-dd')."' AND '".$fecha2->i18nFormat('yyyy-MM-dd')."'"])
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
	
     /**
     * View 
     */
	public function view($id = null, $fecha=null)	// LISTO
    {
		$this->set('fecha', $fecha);
		$this->viewBuilder()->layout('store');
        $comprobante = $this->Comprobantes->get($id, [
            'contain' => ['Clientes', 'ComprobantesTipos']
        ]);
		
		if ($this->request->is('post','get'))
		{	
			if ($this->request->data['cliente_id']!= null)
				$cliente_id = $this->request->data['cliente_id'];
			else
				$cliente_id = $this->request->session()->read('Auth.User.cliente_id');
		    $this->request->session()->write('cliente_id',$cliente_id);
		}
		else 
		{
			if (!empty($this->request->session()->read('cliente_id')))
				$cliente_id = $this->request->session()->read('cliente_id');
			else			
				$cliente_id = $this->request->session()->read('Auth.User.cliente_id');
			$this->request->session()->write('cliente_id',$cliente_id);
		}
		
        $this->set('comprobante', $comprobante);
        $this->set('_serialize', ['comprobante']);
		
		switch ($comprobante['comprobante_tipo_id']) {
				
				case 1:
					$nombreArchivo= 'FACTURA';
					break;
				case 2:
					$nombreArchivo= 'NOTA DE DEBITO';
					break;
				case 3:
					$nombreArchivo= 'NOTA DE CREDITO';
					break;
				case 4:
					$nombreArchivo= 'RECIBO OFICIAL';
					break;
				case 5:
					$nombreArchivo= 'FACTURA';
					break;
			}

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
			$clientes[$this->request->session()->read('Auth.User.cliente_id')] = $this->request->session()->read('Auth.User.codigo').' - '.$this->request->session()->read('Auth.User.razon');
	
		$this->set('clientes', $clientes);	
			
		$titulo = str_pad($comprobante['seccion'], 4, "0", STR_PAD_LEFT).'-'.$comprobante['numero'];
		$this->set('titulo',$nombreArchivo.' N°: '.$titulo.' NOTA N°: '.$comprobante['nota']);
    }

	public function downloadfile ($nota = null, $tipo=null, $fecha =null) // LISTO
	{
			$this->response->type('pdf');
			switch ($tipo) {
				
				case 1:
					$nombreArchivo= 'FACT01';
					break;
				case 2:
					$nombreArchivo= 'COMP02';
					break;
				case 3:
					$nombreArchivo= 'COMP03';
					break;
				case 4:
					$nombreArchivo= 'COMP04';
					break;
				case 5:
					$nombreArchivo= 'FACT01';
					break;
			}
			$nota = str_pad($nota, 6, '0', STR_PAD_LEFT);
			
			
			if ($fecha>20170423)
				$nota = $nota.$fecha;
			
			$nombre_fichero = 'temp'. DS .'Comprobantes'. DS .$nombreArchivo.$nota.'.pdf';

				if (file_exists($nombre_fichero)) {
					$this->response->file(
					$nombre_fichero,
					['download' => true, 'name' => $nombreArchivo.$nota.'.pdf']
					);
					return $this->response;
				}
				else
				{ $this->Flash->error(__('Momentaneamente no disponible, intente mas tarde.'),['key' => 'changepass']);
				$this->redirect($this->referer());}
			
		
	}

	public function downloadfiletxt2($nota = null) //LISTO
	{
		$this->viewBuilder()->layout('store');
		$this->loadModel('FacturasCabeceras');
		$this->loadModel('FacturasCuerposItems');
		/*$this->paginate = [
            'contain' => ['Comprobantes'],
        ];*/
		$query = $this->FacturasCabeceras->find('all')	
					->contain(['FacturasCuerposItems','Comprobantes','FacturasCuerposItems.Articulos'])//,'Articulos'
					->hydrate(false)
					->join([
					'c' => [
						'table' => 'comprobantes',
						'type' => 'INNER',
						'conditions' => 'FacturasCabeceras.comprobante_id = c.id',
					],
					'ci' => [
						'table' => 'facturas_cuerpos_items',
						'type' => 'INNER',
						'conditions' => 'FacturasCabeceras.id = ci.facturas_encabezados_id',
					],
					])
					->where(['FacturasCabeceras.cliente_id' => $this->request->session()->read('cliente_id'),'c.nota'=>$nota])
					->order(['FacturasCabeceras.fecha' => 'ASC'])
					->group('c.id');
		
		$cliente = $this->request->session()->read('client')
		if ($query!=null)
		
			$facturascabeceras = $query->toArray();
		
		else
			$facturascabeceras = null;
		
		
		if ($query->isEmpty()) { 
			$this->Flash->error(__('Momentaneamente no disponible, intente mas tarde.'),['key' => 'changepass']);
			$this->redirect($this->referer());}
		else
		{
			
		$this->request->session()->write('facturascabeceras2',$facturascabeceras);
		$nombrearhivodirectorio = 'temp'. DS ;
		$nombrearhivo= 'F'.str_pad($nota, 6, "0", STR_PAD_LEFT).str_pad($cliente['codigo'], 6, "0", STR_PAD_LEFT).'.TXT';
		$file = new File($nombrearhivodirectorio.$nombrearhivo, true, 0777);
		$codigo = str_pad($cliente['codigo'], 6, "0", STR_PAD_LEFT);
		
		foreach ($facturascabeceras as $fc): 
			$espacio = "\t";
			$item = 'C'.$espacio;
			$item .= $codigo.$espacio;
			$item .= str_pad($fc['comprobante']['seccion'], 4, "0", STR_PAD_LEFT);
			$item .= $fc['letra'];
			$item .= str_pad($fc['comprobante']['numero'], 8, "0", STR_PAD_LEFT).$espacio;
			$item .= str_pad($cliente['nombre'], 30, " ", STR_PAD_RIGHT).$espacio;
			$item .= 'AUT'.$espacio;  
			$imp = (int)($fc['imp_gravado']* 100);
			$item .= str_pad($imp, 15, "0", STR_PAD_LEFT).$espacio;
			$imp = (int)($fc['imp_exento']*100);
			$item .= str_pad($imp, 15, "0", STR_PAD_LEFT).$espacio;
			$imp = (int)($fc['imp_iva']*100);
			$item .= str_pad($imp, 13, "0", STR_PAD_LEFT).$espacio;
			$imp = (int)($fc['imp_rg3337']*100);
			$item .= str_pad($imp, 13, "0", STR_PAD_LEFT).$espacio;
			$imp = (int)($fc['imp_ingreso_bruto']*100);
			$item .= str_pad($imp , 13, "0", STR_PAD_LEFT).$espacio;
			$imp = (int)($fc['total']*100);
			$item .= str_pad($imp , 15, "0", STR_PAD_LEFT).$espacio;
			$item .= date_format($fc['fecha'],'dmY').$espacio;
			$item .= str_pad($fc['pedido_ds'], 6, "0", STR_PAD_LEFT);
			$file->write($item."\r\n");
			foreach ($fc['facturas_cuerpos_items'] as $fci): 
				$itemart = 'D'.$espacio;	
				$itemart .= $codigo.$espacio;
				$itemart .= str_pad($fc['comprobante']['seccion'], 4, "0", STR_PAD_LEFT);
				$itemart .= $fc['letra'];
				$itemart .= str_pad($fc['comprobante']['numero'], 8, "0", STR_PAD_LEFT).$espacio;
				$itemart .= str_pad('0'.$fci['articulo']['categoria_id'], 2, "0", STR_PAD_LEFT).$espacio;
				$itemart .= str_pad($fci['articulo']['codigo_barras'], 13, "0", STR_PAD_LEFT).$espacio;
				$itemart .= str_pad($fci['articulo']['descripcion_sist'], 30, " ", STR_PAD_RIGHT).$espacio;
				if ($fci['iva'])
					$itemart .= '1';
				else
					$itemart .= '0';
				$itemart .= $espacio. str_pad($fci['cantidad_facturada'], 6, "0", STR_PAD_LEFT).$espacio;
				$imp = (int)($fci['precio_unitario']*100);
				$itemart .= str_pad($imp , 13, "0", STR_PAD_LEFT).$espacio;
				$imp = (int)($fci['precio_publico']*100);
				$itemart .= str_pad($imp , 11, "0", STR_PAD_LEFT).$espacio;
				$imp = (int)($fci['precio_total']*100);
				$itemart .= str_pad($imp , 15, "0", STR_PAD_LEFT).$espacio;
				$file->write($itemart.."\r\n");
			endforeach; 

		endforeach; 
		$file->close(); // Be sure to close the file when you're done
		if (file_exists($nombrearhivodirectorio.$nombrearhivo)) {
					$this->response->type('txt');

					$this->response->file(
					$nombrearhivodirectorio.$nombrearhivo,
					['download' => true, 'name' => $nombrearhivo]
					);

					return $this->response;
				}
				else
				{ $this->Flash->error(__('Momentaneamente no disponible, intente mas tarde.'),['key' => 'changepass']);
				$this->redirect($this->referer());}
		}
	}
	
	public function exportarselect() //LISTO
	{
		$entities = $this->request->data();
		$this->set('entities', $entities);
		$listaarray = array();
	
		foreach ($entities as $comprobant) {		
				if 	($comprobant['seleccionar'])
					array_push($listaarray,$comprobant['id']);
		
		}
				
		$this->viewBuilder()->layout('store');
	
		$this->loadModel('FacturasCabeceras');
		$this->loadModel('FacturasCuerposItems');
		$this->paginate = [
        ];
		
		if (!empty($listaarray))
		{
		$query = $this->FacturasCabeceras->find('all')	
					->contain(['FacturasCuerposItems','Comprobantes','FacturasCuerposItems.Articulos'])
					->hydrate(false)
				
					->join([
					'c' => [
						'table' => 'comprobantes',
						'type' => 'INNER',
						'conditions' => 'FacturasCabeceras.comprobante_id = c.id',
					],
					'ci' => [
						'table' => 'facturas_cuerpos_items',
						'type' => 'INNER',
						'conditions' => 'FacturasCabeceras.id = ci.facturas_encabezados_id',
					],
				
					])
					->where(['FacturasCabeceras.cliente_id' => $this->request->session()->read('cliente_id'),'c.id in '=>$listaarray])
					->order(['FacturasCabeceras.fecha' => 'ASC'])
					->group('c.id');
					
		$client = $this->request->session()->read('client');		
		$this->request->session()->write('facturascabeceras3',$query->toArray());
		if ($query!=null)
		{
			$facturascabeceras = $query->toArray();
			//$this->request->session()->write('facturascabeceras3',$facturascabeceras);
		}
		else
			$facturascabeceras = null;
		}
		else
		{
			$facturascabeceras = null;
			$this->Flash->error(__('Seleccione algun comprobante'),['key' => 'changepass']);
			$this->redirect($this->referer());
		}
		$this->request->session()->write('facturascabeceras2',$facturascabeceras);
		$nombrearhivodirectorio = 'temp'. DS ;
		$codigo = str_pad($client['codigo'], 6, "0", STR_PAD_LEFT);
		$nombrearhivodirectorio = 'temp'. DS ;
		$nombrearhivo = 'DETFAC'.$codigo.'.TXT';
		$file = new File($nombrearhivodirectorio.$nombrearhivo, true, 0777);
		if (is_null($facturascabeceras))
		{
			$this->Flash->error(__('Seleccione una opcion'),['key' => 'changepass']);
			$this->redirect($this->referer());
			
		}
		else
		{
			
			foreach ($facturascabeceras as $fc): 
				$espacio = "\t";
				$item = 'C'.$espacio;
				$item .= $codigo.$espacio;
				$item .= str_pad($fc['comprobante']['seccion'], 4, "0", STR_PAD_LEFT);
				$item .= $fc['letra'];
				$item .= str_pad($fc['comprobante']['numero'], 8, "0", STR_PAD_LEFT).$espacio;
				$item .= str_pad($client['nombre'], 30, " ", STR_PAD_RIGHT).$espacio;
				$item .= 'AUT'.$espacio;  
				$imp = (int)($fc['imp_gravado']* 100);
				
				$item .= str_pad($imp, 15, "0", STR_PAD_LEFT).$espacio;
				$imp = (int)($fc['imp_exento']*100);
				$item .= str_pad($imp, 15, "0", STR_PAD_LEFT).$espacio;
				$imp = (int)($fc['imp_iva']*100);
				//$imp = number_format($fc['imp_iva'],2,'.','');
				$item .= str_pad($imp, 13, "0", STR_PAD_LEFT).$espacio;
				$imp = (int)($fc['imp_rg3337']*100);
				$item .= str_pad($imp, 13, "0", STR_PAD_LEFT).$espacio;
				$imp = (int)($fc['imp_ingreso_bruto']*100);
				$item .= str_pad($imp , 13, "0", STR_PAD_LEFT).$espacio;
				$imp = (int)($fc['total']*100);
				//$imp = number_format($fc['total'],2,'.','');
				
				$item .= str_pad($imp , 15, "0", STR_PAD_LEFT).$espacio;
				$item .= date_format($fc['fecha'],'dmY').$espacio;
				$item .= str_pad($fc['pedido_ds'], 6, "0", STR_PAD_LEFT);
				$file->write($item. "\r\n");
				foreach ($fc['facturas_cuerpos_items'] as $fci): 
					$itemart = 'D'.$espacio;	
					$itemart .= $codigo.$espacio;
					$itemart .= str_pad($fc['comprobante']['seccion'], 4, "0", STR_PAD_LEFT);
					$itemart .= $fc['letra'];
					$itemart .= str_pad($fc['comprobante']['numero'], 8, "0", STR_PAD_LEFT).$espacio;
						
					$itemart .= str_pad('0'.$fci['articulo']['categoria_id'], 2, "0", STR_PAD_LEFT).$espacio;
					
					$itemart .= str_pad($fci['codigo_barra'], 13, "0", STR_PAD_LEFT).$espacio;
					
					$itemart .= str_pad($fci['descripcion'], 30, " ", STR_PAD_RIGHT).$espacio;
					
					if ($fci['iva'])
					$itemart .= '1';
					else
					$itemart .= '0';
					
					$itemart .= $espacio. str_pad($fci['cantidad_facturada'], 6, "0", STR_PAD_LEFT).$espacio;
					//$imp = $fci['precio_unitario'];
					$imp = (int)($fci['precio_unitario']*100);// number_format($fci['precio_unitario'],2,'.','');
					$itemart .= str_pad($imp , 13, "0", STR_PAD_LEFT).$espacio;
					$imp = (int)($fci['precio_publico']*100);//$imp = number_format($fci['precio_publico'],2,'.','');
					//$imp = $fci['precio_publico'];
					$itemart .= str_pad($imp , 11, "0", STR_PAD_LEFT).$espacio;
					
					$imp = (int)($fci['precio_total']*100);//number_format($fci['precio_total'],2,'.','');
					//$imp = $fci['precio_total'];
					$itemart .= str_pad($imp , 15, "0", STR_PAD_LEFT).$espacio;
					
					$file->write($itemart. "\r\n");
				endforeach; 
				//$file->append(utf8_encode($string));
				//$file->create('I am overwriting the contents of this file');
				
				
			endforeach; 
			
			// $file->append('I am adding to the bottom of this file.');
			// $file->delete(); // I am deleting this file
			$file->close(); // Be sure to close the file when you're done
			

			$this->response->type('txt');

			$this->response->file(
			$nombrearhivodirectorio.$nombrearhivo,
			['download' => true, 'name' => $nombrearhivo]
			);

			return $this->response;
		}
		
		
	}

	public function downloadfiletrazatxt ($id=null) // LISTO
	{
		$comprobante = $this->Comprobantes->get($id, [
            'contain' => ['ComprobantesTipos']
        ]);
		$this->loadModel('Trazas');
		
		$query =$this->Trazas->find('all')
							 ->contain(['Articulos'])
							 ->where(['cliente_id' => $comprobante->cliente_id])
							 ->andWhere(['nota'=>$comprobante->nota]);
		
		$client = $this->request->session()->read('client');
				
		//Facturas
		$this->set('query2', $query->isEmpty());
		if ($query->isEmpty())
		{ $this->Flash->error(__('Momentaneamente no disponible, intente mas tarde.'),['key' => 'changepass']);
			$this->redirect($this->referer());}
		else
		{
			$nombreArchivo= 'TRAZA'.str_pad($comprobante->nota, 6, "0", STR_PAD_LEFT).str_pad($client['codigo'], 6, "0", STR_PAD_LEFT);
			$file = new File('temp'. DS .'Comprobantes'. DS .$nombreArchivo.'.TXT', true, 0777);
			
			$line = ."\r\n" . 'PRODUCTO                       GTIN           SERIE                LOTE                 VENC'.."\r\n";
			$file->write($line,'w');
			foreach ($query as $row): 
				$fecha = date_format($row['vencimiento'],'Ymd');
				$line = str_pad($row['articulo']['descripcion_sist'], 31).
						str_pad($row['articulo']['codigo_barras'], 14,"0", STR_PAD_LEFT).' '.
						str_pad($row['serie'], 21, " ").
						str_pad($row['lote'], 21).
						str_pad($fecha, 8).."\r\n";
				$file->write($line,'w');

			endforeach; 
		
			$file->close(); // Be sure to close the file when you're done
			$this->response->type('txt');
			$nombre_fichero = 'temp'. DS .'Comprobantes'. DS .$nombreArchivo.'.TXT';
				if (file_exists($nombre_fichero)) {
					$this->response->file(
					'temp'. DS .'Comprobantes'. DS .$nombreArchivo.'.TXT',
					['download' => true, 'name' => $nombreArchivo.'.TXT']
					);
				}
			return $this->response;
		}	
	}		

	public function downloadfiletxtselect() //LISTO
	{
		$entities = $this->request->data();
		$this->set('entities', $entities);
		$listaarray = array();
		$cliente_id = $this->request->session()->read('cliente_id');
	
		foreach ($entities as $comprobant) {	
				
				if 	($comprobant['seleccionar'])
				{
					$cliente_id= $comprobant['cliente_id'];
					array_push($listaarray,$comprobant['id']);
				
				}
		
		}
		
		$client = $this->request->session()->read('client');
		
		$this->viewBuilder()->layout('store');
	
		$this->loadModel('FacturasCabeceras');
		$this->loadModel('FacturasCuerposItems');
		/*$this->paginate = [
            'contain' => ['Comprobantes'],
        ];*/
		
		if (!empty($listaarray))
		{
		$query = $this->FacturasCabeceras->find('all')	
					->contain(['FacturasCuerposItems','Comprobantes','FacturasCuerposItems.Articulos'])
					->hydrate(false)
				
					->join([
					'c' => [
						'table' => 'comprobantes',
						'type' => 'INNER',
						'conditions' => 'FacturasCabeceras.comprobante_id = c.id',
					],
					'ci' => [
						'table' => 'facturas_cuerpos_items',
						'type' => 'INNER',
						'conditions' => 'FacturasCabeceras.id = ci.facturas_encabezados_id',
					],
				
					])
					->where(['FacturasCabeceras.cliente_id' => $client['id'],'c.id in '=>$listaarray])
					->order(['FacturasCabeceras.fecha' => 'ASC'])
					->group('c.id');
		$this->request->session()->write('facturascabeceras3',$query->toArray());
		if ($query!=null)
		{
			$facturascabeceras = $query->toArray();
			//$this->request->session()->write('facturascabeceras3',$facturascabeceras);
		}
		else
			$facturascabeceras = null;
		}
		else
		{
			$facturascabeceras = null;
			$this->Flash->error(__('Seleccione algun comprobante'),['key' => 'changepass']);
			$this->redirect($this->referer());
		}
			
		
		$this->request->session()->write('facturascabeceras2',$facturascabeceras);
		$nombrearhivodirectorio = 'temp'. DS ;
		
		
		$nombrearhivo= 'varios.TXT';
		$file = new File($nombrearhivodirectorio.$nombrearhivo, true, 0777);
		$codigo = str_pad($client['codigo'], 6, "0", STR_PAD_LEFT);
		 
		if (is_null($facturascabeceras))
		{
			$this->Flash->error(__('Seleccione una opcion'),['key' => 'changepass']);
			$this->redirect($this->referer());
			
		}
		else
		{
			
			foreach ($facturascabeceras as $fc): 
				$espacio = "\t";
				$item = 'C'.$espacio;
				$item .= $codigo.$espacio;
				$item .= str_pad($fc['comprobante']['seccion'], 4, "0", STR_PAD_LEFT);
				$item .= $fc['letra'];
				$item .= str_pad($fc['comprobante']['numero'], 8, "0", STR_PAD_LEFT).$espacio;
				$item .= str_pad($client['nombre'], 30, " ", STR_PAD_RIGHT).$espacio;
				$item .= 'AUT'.$espacio;  
				$imp = (int)($fc['imp_gravado']* 100);
				
				$item .= str_pad($imp, 15, "0", STR_PAD_LEFT).$espacio;
				$imp = (int)($fc['imp_exento']*100);
				$item .= str_pad($imp, 15, "0", STR_PAD_LEFT).$espacio;
				$imp = (int)($fc['imp_iva']*100);
				//$imp = number_format($fc['imp_iva'],2,'.','');
				$item .= str_pad($imp, 13, "0", STR_PAD_LEFT).$espacio;
				$imp = (int)($fc['imp_rg3337']*100);
				$item .= str_pad($imp, 13, "0", STR_PAD_LEFT).$espacio;
				$imp = (int)($fc['imp_ingreso_bruto']*100);
				$item .= str_pad($imp , 13, "0", STR_PAD_LEFT).$espacio;
				$imp = (int)($fc['total']*100);
				//$imp = number_format($fc['total'],2,'.','');
				
				$item .= str_pad($imp , 15, "0", STR_PAD_LEFT).$espacio;
				$item .= date_format($fc['fecha'],'dmY').$espacio;
				$item .= str_pad($fc['pedido_ds'], 6, "0", STR_PAD_LEFT);
				
				
				$file->write($item. "\r\n");
				foreach ($fc['facturas_cuerpos_items'] as $fci): 
					$itemart = 'D'.$espacio;	
					$itemart .= $codigo.$espacio;
					$itemart .= str_pad($fc['comprobante']['seccion'], 4, "0", STR_PAD_LEFT);
					$itemart .= $fc['letra'];
					$itemart .= str_pad($fc['comprobante']['numero'], 8, "0", STR_PAD_LEFT).$espacio;
						
					$itemart .= str_pad('0'.$fci['articulo']['categoria_id'], 2, "0", STR_PAD_LEFT).$espacio;
					
					$itemart .= str_pad($fci['codigo_barra'], 13, "0", STR_PAD_LEFT).$espacio;
					
					$itemart .= str_pad($fci['descripcion'], 30, " ", STR_PAD_RIGHT).$espacio;
					
					if ($fci['iva'])
					$itemart .= '1';
					else
					$itemart .= '0';
					
					$itemart .= $espacio. str_pad($fci['cantidad_facturada'], 6, "0", STR_PAD_LEFT).$espacio;
					//$imp = $fci['precio_unitario'];
					$imp = (int)($fci['precio_unitario']*100);// number_format($fci['precio_unitario'],2,'.','');
					$itemart .= str_pad($imp , 13, "0", STR_PAD_LEFT).$espacio;
					$imp = (int)($fci['precio_publico']*100);//$imp = number_format($fci['precio_publico'],2,'.','');
					//$imp = $fci['precio_publico'];
					$itemart .= str_pad($imp , 11, "0", STR_PAD_LEFT).$espacio;
					
					$imp = (int)($fci['precio_total']*100);//number_format($fci['precio_total'],2,'.','');
					//$imp = $fci['precio_total'];
					$itemart .= str_pad($imp , 15, "0", STR_PAD_LEFT).$espacio;
					
					$file->write($itemart. "\r\n");
				endforeach; 
				//$file->append(utf8_encode($string));
				//$file->create('I am overwriting the contents of this file');
				
				
			endforeach; 
			
			// $file->append('I am adding to the bottom of this file.');
			// $file->delete(); // I am deleting this file
			$file->close(); // Be sure to close the file when you're done
			

			$this->response->type('txt');

			$this->response->file(
			$nombrearhivodirectorio.$nombrearhivo,
			['download' => true, 'name' => $nombrearhivo]
			);

			return $this->response;
		}
		
		
	}

	public function downloadfiletxt ($nota = null) // LISTO
	{
		$this->loadModel('FacturasCuerposItems');
		$query = $this->FacturasCuerposItems->find('all')	
					->contain(['FacturasCabeceras','Articulos'])//,'Articulos'
					->join([
					'fc' => [
						'table' => 'facturas_cabeceras',
						'type' => 'INNER',
						'conditions' => 'fc.id = FacturasCuerposItems.facturas_encabezados_id',
					]
					])
					->where(['fc.cliente_id' => $this->request->session()->read('cliente_id')])
					->where(['FacturasCuerposItems.pedido_ds'=>$nota])
					->order(['fc.fecha' => 'ASC'])
					->group('FacturasCuerposItems.articulo_id');
		$this->request->session()->write('querytest',$query->toArray());
		$client = $this->request->session()->read('client');
		
		if ($query->isEmpty())
		{ $this->Flash->error(__('Momentaneamente no disponible, intente mas tarde.'),['key' => 'changepass']);
			$this->redirect($this->referer());}
		else
		{
			$nombreArchivo= 'F'.str_pad($nota, 6, "0", STR_PAD_LEFT).$str_pad(client('codigo'), 6, "0", STR_PAD_LEFT);
			$file = new File('temp'. DS .'Comprobantes'. DS .$nombreArchivo.'.TXT', true, 0777);
			$file->write("\n",'w');
			foreach ($query as $row): 
			
				$line = str_pad($row['troquel'], 8, " ", STR_PAD_LEFT).
						str_pad($row['codigo_barra'], 13).
						str_pad($row['descripcion'], 30).
						str_pad($row['cantidad_facturada'], 4, "0", STR_PAD_LEFT)."\r\n";
				$file->write($line,'w');

			endforeach; 
			$file->close(); // Be sure to close the file when you're done
			$this->response->type('txt');
			$nombre_fichero = 'temp'. DS .'Comprobantes'. DS .$nombreArchivo.'.TXT';

				if (file_exists($nombre_fichero)) {
					$this->response->file(
					'temp'. DS .'Comprobantes'. DS .$nombreArchivo.'.TXT',
					['download' => true, 'name' => $nombreArchivo.'.TXT']
					);
				}
			return $this->response;
		}
	}		

	/**
	* 	Index Admin
	*/
	public function index_admin()
    {
		$this->viewBuilder()->layout('admin');
        $this->paginate = [
			'limit' => 50,
            'contain' => ['Clientes', 'ComprobantesTipos']
        ];

		$fecha = Time::now();
		$fecha->setDate($fecha->year, $fecha->month, 1);
		$fecha->i18nFormat('yyyy-MM-dd');
		
		$fecha2 = Time::now();
		$fecha2->modify('+1 days');
		$fecha2= $fecha2->i18nFormat('yyyy-MM-dd');
		
		$query = $this->Comprobantes->find('all')
					->andWhere(['fecha BETWEEN :start AND :end'])
								->bind(':start', $fecha, 'date')
								->bind(':end',   $fecha2, 'date')
					->order(['fecha' => 'ASC']);
					
		
        $this->set('comprobantes', $this->paginate($query));
        $this->set('_serialize', ['comprobantes']);
		$this->set('titulo','Comprobantes');
    }
	
	/**
	*	Search Admin
	*/
	public function search_admin()
    {
		if ($this->request->is('post'))
		{	
			
			if ($this->request->data['fechadesde']!= null)
				$fechadesde = $this->request->data['fechadesde'];
			else
				$fechadesde=0;
			if ($this->request->data['fechahasta']!= null)
				$fechahasta = $this->request->data['fechahasta'];
			else
				$fechahasta =0;
			if ($this->request->data['terminobuscar']!= null)
				$termsearch = $this->request->data['terminobuscar'];
			else
				$termsearch ="";
				if ($this->request->data['terminocliente']!= null)
				$termclient = $this->request->data['terminocliente'];
			else
				$termclient ="";
			
			if ($this->request->data['factura']!= null)
				$factura = $this->request->data['factura'];
			else
				$factura=0;
			if ($this->request->data['notacredito']!= null)
				$notacredito = $this->request->data['notacredito'];
			else
				$notacredito=0;
			if ($this->request->data['notadebito']!= null)
				$notadebito = $this->request->data['notadebito'];
			else
				$notadebito=0;
			if ($this->request->data['recibo']!= null)
				$recibo = $this->request->data['recibo'];
			else
				$recibo=0;

				
		
		
			$this->request->session()->write('termclient',$termclient);
			$this->request->session()->write('termsearch',$termsearch);
			$this->request->session()->write('fechadesde',$fechadesde);	
			$this->request->session()->write('fechahasta',$fechahasta);

			$this->request->session()->write('factura',$factura);
			$this->request->session()->write('notacredito',$notacredito);	
			$this->request->session()->write('notadebito',$notadebito);
			$this->request->session()->write('recibo',$recibo);
		}
		else 
		{
			$termclient= $this->request->session()->read('termclient');
			$fechahasta = $this->request->session()->read('fechahasta');
		    $fechadesde = $this->request->session()->read('fechadesde');
			$termsearch = $this->request->session()->read('termsearch');
			
			$factura = $this->request->session()->read('factura');
		    $notacredito = $this->request->session()->read('notacredito');
			$notadebito = $this->request->session()->read('notadebito');
			$recibo = $this->request->session()->read('recibo');
			
		}
		
		$this->viewBuilder()->layout('admin');
        
		$this->paginate = [
			'limit' => 50,
            'contain' => ['Clientes', 'ComprobantesTipos']
        ];
		$query = $this->Comprobantes->find('all');
		if ($termclient !="")
		{
			$query->join([
					'c' => [
						'table' => 'clientes',
						'type' => 'left',
						'conditions' => 'c.id = Comprobantes.cliente_id',
					]
				])
					->where(['c.codigo' => $termclient]);
		}
		$filtro = array();
		if ($factura==1) array_push($filtro, 1);
		if ($notadebito==1) array_push($filtro, 2);
		if ($notacredito==1) array_push($filtro, 3);
		if ($recibo==1)	array_push($filtro, 4);
		
		if ($recibo==1 || $notadebito==1 || $notacredito==1 || $recibo==1)
			$query->andWhere(['Comprobantes.comprobante_tipo_id in '=>$filtro]);
		

		if ($fechahasta!=0)
		{
			$fechahasta2 = Time::createFromFormat('d/m/Y',$fechahasta,'America/Argentina/Buenos_Aires');
			$fechahasta2->modify('+1 days');
			$fechahasta2->i18nFormat('yyyy-MM-dd');
			
		}
		else
		{
			$fechahasta2 = Time::now();
			$fechahasta2-> modify('+1 days');
		}
		if ($fechadesde!=0)
		{
			$fechadesde2 = Time::createFromFormat('d/m/Y',$fechadesde,'America/Argentina/Buenos_Aires');
			$fechadesde2->i18nFormat('yyyy-MM-dd');
		}
		else
		{
			$fechadesde2 = Time::now();
			if ($fechahasta!=0)
				$fechadesde2->setDate($fechadesde2->year, $fechahasta2->month, 1);
			else
				$fechadesde2->setDate($fechadesde2->year, $fechadesde2->month, 1);
			$fechadesde2->i18nFormat('yyyy-MM-dd');
		}

		$query->andWhere(["Comprobantes.fecha BETWEEN '".$fechadesde2->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta2->i18nFormat('yyyy-MM-dd')."'"])
		->order(['fecha' => 'ASC']);
		if ($termsearch!="")
		{
			$query->andWhere([
					'OR' => [['Comprobantes.nota'=>$termsearch], 
					['Comprobantes.numero'=>$termsearch]],
				]);
			
		}
        else
		{
		}
		if ($query!=null)
		
			$comprobantes = $this->paginate($query);
		
		else
			$comprobantes = null;

        $this->set('comprobantes', $comprobantes);
        $this->set('_serialize', ['comprobantes']);
		$this->set('titulo','Lista Comprobantes');
	}

	/** 
	*	View admin
	*/
	public function view_admin($id = null, $fecha=null)
    {
		$this->set('fecha', $fecha);
		$this->viewBuilder()->layout('admin');
        $comprobante = $this->Comprobantes->get($id, [
            'contain' => ['Clientes', 'ComprobantesTipos']
        ]);
        $this->set('comprobante', $comprobante);
        $this->set('_serialize', ['comprobante']);
		
		switch ($comprobante['comprobante_tipo_id']) {
				
				case 1:
					$nombreArchivo= 'FACTURA';
					break;
				case 2:
					$nombreArchivo= 'NOTA DE DEBITO';
					break;
				case 3:
					$nombreArchivo= 'NOTA DE CREDITO';
					break;
				case 4:
					$nombreArchivo= 'RECIBO OFICIAL';
					break;
				case 5:
					$nombreArchivo= 'FACTURA';
					break;
			}	
		$titulo = str_pad($comprobante['seccion'], 4, "0", STR_PAD_LEFT).'-'.$comprobante['numero'];
		$this->set('titulo',$nombreArchivo.' N°: '.$titulo.' NOTA N°: '.$comprobante['nota']);
    }

}