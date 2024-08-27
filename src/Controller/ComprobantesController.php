<?php
namespace App\Controller;
use Cake\I18n\Time;
use App\Controller\AppController;
use Cake\Filesystem\File;
use Cake\Network\Request;
use CakePdf\Pdf\CakePdf;
use CakePdf\Pdf\Engine\WkHtmlToPdfEngine;

/**
 *Comprobantes Controller
 *
 *@property \App\Model\Table\ComprobantesTable $Comprobantes
 */
class ComprobantesController extends AppController
{

	public function isAuthorized()
    {
		if (in_array($this->request->action,['search','index','view_admin','search_admin','index_admin','home','downloadfile','traza','downloadfiletxt','downloadfiletrazatxt','view','downloadfiletxt2','downloadfiletxt3','downloadfiletxtselect','excel','trazapdf','lotevctopdf','view_nota_admin','downloadfilenew'])) {
       
				if($this->request->session()->read('Auth.User.role')=='admin') {				
					return true;			
				} else {	
					if($this->request->session()->read('Auth.User.role')=='client') {	
						$tiene= $this->tienepermiso('comprobantes',$this->request->action);
						if (!$tiene)
							$this->Flash->error(__('No tiene permisos para ingresar'),['key'=>'changepass']);
						return $tiene;			
					} else {
						if($this->request->session()->read('Auth.User.role')=='provider') {				
							return false;			
						}
						else 
						if ($this->request->session()->read('Auth.User.role')=='adminS') {
						return true;
						} 
						else
						{
							$this->Flash->error(__('No tiene permisos para ingresar'),['key'=>'changepass']);
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

	public function initialize()
	{
		parent::initialize();
		$this->loadComponent('RequestHandler');
	}
    
	public function sumacarrito()
	{
		$this->loadModel('Carritos');
		$carritocon = $this->Carritos->find('all')
					->where(['Carritos.cliente_id'=>$this->request->session()->read('Auth.User.cliente_id')])
					->order(['Carritos.id'=>'DESC']);
		$this->set('carritos', $carritocon->toArray());
		$descuento_pf = $this->request->session()->read('Auth.User.pf_dcto');
		$totalcarrito=0;
		$totalitems=0;
		$totalunidades=0;			
		foreach ($carritocon as $carrito): 
			$totalitems+=1;
			if ($carrito['tipo_precio']=="P")
				$totalcarrito= $totalcarrito + $carrito['cantidad']*$carrito['precio_publico'];
			else
				$totalcarrito= $totalcarrito + $carrito['cantidad']*round(h($carrito['precio_publico'])*$descuento_pf, 3);
			$totalunidades= $totalunidades + $carrito['cantidad'];
		endforeach; 
		$this->set('totalitems',$totalitems);
		$this->set('totalcarrito',$totalcarrito);
		$this->set('totalunidades',$totalunidades);
		$this->set('carritos', $carritocon->toArray());
		return $carritocon;
	}
	
	public function clientecredito()
	{
		$this->loadModel('ClientesCreditos');
		$clientecreditos = $this->ClientesCreditos->find('all')	
					->where(['cliente_id'=>$this->request->session()->read('Auth.User.cliente_id')]);
		$clientecredito = $clientecreditos->first();
		$this->set('creditodisponible',$clientecredito['credito_maximo']-$clientecredito['credito_consumo']);
		if ($clientecredito['compra_minima']!=null)
				$this->request->session()->write('compra_minima',$clientecredito['compra_minima']);		
			else
				$this->request->session()->write('compra_minima',500);		
	}
	
	public function categoriaylaboratorio()
	{
		if ($this->request->session()->read('Categorias')==null) {
		$this->loadModel('Categorias');
		$this->loadModel('Laboratorios');
		$categorias = $this->Categorias->find('list',['keyField'=>'id','valueField'=>'nombre']);
		$laboratorios = $this->Laboratorios->find('list',['keyField'=>'id','valueField'=>'nombre'])->order(['nombre'=>'ASC']);
		$this->request->session()->write('Categorias',$categorias->toArray());
		$this->request->session()->write('Laboratorios',$laboratorios->toArray());	
		} else {
			$laboratorios =$this->request->session()->read('Laboratorios');
			$categorias = $this->request->session()->read('Categorias');
		}	
		$this->set('categorias',$categorias);
		$this->set('laboratorios',$laboratorios);
	}
	
	/**
     *Index method
     *
     *@return void
     */
    public function index()
    {
		$this->viewBuilder()->layout('store');
        $this->paginate = [
			'limit'=>100,
            //'contain'=>['Clientes']
        ];
		if ($this->request->is('post','get')){	
			if ($this->request->data['cliente_id']!=null)
				$cliente_id = $this->request->data['cliente_id'];
			else
				$cliente_id = $this->request->session()->read('Auth.User.cliente_id');
		    $this->request->session()->write('cliente_id', $cliente_id);
			/*$this->loadModel('Clientes');
			$client = $this->Clientes->get($this->request->session()->read('cliente_id'));		
			$this->request->session()->write('client',$client); */
		} else {
			if (!empty($this->request->session()->read('cliente_id')))
				$cliente_id = $this->request->session()->read('cliente_id');
			else			
				$cliente_id = $this->request->session()->read('Auth.User.cliente_id');
			$this->request->session()->write('cliente_id',$cliente_id);
			/*if (empty($this->request->session()->read('client')))
			{
				$this->loadModel('Clientes');
				$client = $this->Clientes->get($this->request->session()->read('cliente_id'));		
				$this->request->session()->write('client',$client);
			} */
		}
		
		$fecha = Time::now();
		$fecha->setDate($fecha->year, $fecha->month, 1);
		$fecha = $fecha->i18nFormat('yyyy-MM-dd');
		
		$fecha2 = Time::now();
		$fecha2->modify('+1 days');
		$fecha2= $fecha2->i18nFormat('yyyy-MM-dd');
		
		$query = $this->Comprobantes->find('all')
					->contain (['ComprobantesTipos'])
					->where(['cliente_id'=>$this->request->session()->read('cliente_id')])
					->andWhere(['fecha BETWEEN :start AND :end'])
								->bind(':start', $fecha, 'date')
								->bind(':end',   $fecha2, 'date')
					->order(['fecha'=>'DESC','nota'=>'DESC']);
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
			$clientes[$this->request->session()->read('Auth.User.cliente_id')] = $this->request->session()->read('Auth.User.codigo').' - '.$this->request->session()->read('Auth.User.razon');
		*/
		$this->listadocliente();
		//$this->listadocliente();
		//$this->set('clientes',$clientes);
        $this->set('comprobantes', $this->paginate($query));
        $this->set('_serialize',['comprobantes']);
    }

	
	public function listadocliente(){
		$clientes=array();
		$this->loadModel('Clientes');
		if ($this->request->session()->read('Auth.User.cuentaprincipal')==1){
			if ($this->request->session()->read('Auth.User.grupo') >0)	
			$Clientes = $this->Clientes->find('all')->Select(['id','codigo','nombre'])->where(['grupo_id'=>$this->request->session()->read('Auth.User.grupo')]);
			else
			$Clientes = $this->Clientes->find('all')->Select(['id','codigo','nombre'])->where(['id'=>$this->request->session()->read('Auth.User.cliente_id')]);
			foreach ($Clientes as $opcion) {
				$clientes[$opcion['id']] = $opcion['codigo'].' - '.$opcion['nombre'];    
			}	 
		} else {
			// enero 2021 no funciona mas cuentas 70
			$clientes[$this->request->session()->read('Auth.User.cliente_id')] = $this->request->session()->read('Auth.User.codigo').' - '.$this->request->session()->read('Auth.User.razon');
			if ($this->request->session()->read('Auth.User.codigo_postal')==9410 || $this->request->session()->read('Auth.User.codigo_postal')==9420)
			{
				if ($this->request->session()->read('Auth.User.codigo')>71000)
				{
				$Clientes = $this->Clientes->find('all')
					->Select(['Clientes.id','Clientes.codigo','Clientes.nombre','ce.cliente_export_id','ce.cta_comun','ce.cliente_comun_id'])
					->join(['ce'=>['table'=>'clientes_exports','type'=>'INNER','conditions'=>'ce.cliente_export_id = Clientes.id']])
					->where(['Clientes.id'=>$this->request->session()->read('Auth.User.cliente_id')]);
				foreach ($Clientes as $opcion) {
					$clientes[$opcion['ce']['cliente_comun_id']] = $opcion['ce']['cta_comun'].' - '.$this->request->session()->read('Auth.User.razon');    
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
        $this->paginate = [
			'limit'=>100,
            'contain'=>['Clientes','ComprobantesTipos']
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
					->order(['fecha'=>'ASC']);
					
		
        $this->set('comprobantes', $this->paginate($query));
        $this->set('_serialize',['comprobantes']);
		$this->set('titulo','Comprobantes');
    }
	
	public function search2()
    {
		$this->viewBuilder()->layout('store');
		if ($this->request->is('post')) {	
			if ($this->request->data['fechadesde']!=null) {
				$fechadesde = $this->request->data['fechadesde'];
			} else {
				$fechadesde=0;
			}
			if ($this->request->data['fechahasta']!=null) {
				$fechahasta = $this->request->data['fechahasta'];
			}	
			else
			{
				$fechahasta =0;
			}
			if ($this->request->data['terminobuscar']!=null)
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
		'limit'=>90,
		];
		
		if ($fechahasta!=0) {
			//$fechahasta2 = Time::now();
			$fechahasta2 = Time::createFromFormat(
			'd/m/Y',
			$fechahasta,
			'America/Argentina/Buenos_Aires');
			$fechahasta2->modify('+1 days');
			$fechahasta2->i18nFormat('yyyy-MM-dd');
		} else {
			$fechahasta2 = Time::now();
			$fechahasta2->modify('+1 days');
			//$fechahasta2 = $fechahasta2->i18nFormat('yyyy-MM-dd');
		}
		if ($fechadesde!=0) {
			//$fechadesde2 = Time::now();
			$fechadesde2 = Time::createFromFormat(
				'd/m/Y',
			$fechadesde,
			'America/Argentina/Buenos_Aires');
			$fechadesde2->i18nFormat('yyyy-MM-dd');
		} else {
			$fechadesde2 = Time::now();
			if ($fechahasta!=0)
				$fechadesde2->setDate($fechadesde2->year, $fechahasta2->month, 1);
			else
				$fechadesde2->setDate($fechadesde2->year, $fechadesde2->month, 1);
			$fechadesde2->i18nFormat('yyyy-MM-dd');
		}


	  	if ($termsearchp!="") {
			if (($fechadesde!=0) && ($fechahasta!=0)) {
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
					'pe'=>[
						'table'=>'pedidos_items',
						'type'=>'left',
						'conditions'=>'pe.pedido_id = Pedidos.id',
					],
					'a'=>[
						'table'=>'articulos',
						'type'=>'left',
						'conditions'=>'a.id = pe.articulo_id',
					]
				])
				->where(['Pedidos.cliente_id'=>$this->request->session()->read('Auth.User.cliente_id')])
				->where(['a.descripcion_pag LIKE'=>$termsearchp])
				->orWhere(['a.troquel LIKE'=>$termsearchp])
				->andWhere(["Pedidos.creado BETWEEN '".$fechadesde2->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta2->i18nFormat('yyyy-MM-dd')."'"])
				->group('Pedidos.id')
				->order(['fecha'=>'ASC']);
			}
			else
			{
				if (($fechadesde!=0) || ($fechahasta!=0))
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
					'pe'=>[
						'table'=>'pedidos_items',
						'type'=>'INNER',
						'conditions'=>'pe.pedido_id = Pedidos.id',
					],
					'a'=>[
						'table'=>'articulos',
						'type'=>'INNER',
						'conditions'=>'a.id = pe.articulo_id',
					]
				])
				->where(['Pedidos.cliente_id'=>$this->request->session()->read('Auth.User.cliente_id')])
				->where(['a.descripcion_pag LIKE'=>$termsearchp])
				->orWhere(['a.troquel LIKE'=>$termsearchp])
				->andWhere(["Pedidos.creado BETWEEN '".$fechadesde2->i18nFormat('yyyy-MM-dd')."' AND '".$fechadesde2->i18nFormat('yyyy-MM-dd')."'"])
				->group('Pedidos.id')
				->order(['fecha'=>'ASC']);
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
						'pe'=>[
							'table'=>'pedidos_items',
							'type'=>'INNER',
							'conditions'=>'pe.pedido_id = Pedidos.id',
						],
						'a'=>[
							'table'=>'articulos',
							'type'=>'INNER',
							'conditions'=>'a.id = pe.articulo_id',
						]
					])
					->where(['Pedidos.cliente_id'=>$this->request->session()->read('Auth.User.cliente_id')])
					->where(['a.descripcion_pag LIKE'=>$termsearchp])
					->orWhere(['a.troquel LIKE'=>$termsearchp])
					->group('Pedidos.id')
					->order(['fecha'=>'ASC']);
				}	
			}
		}
        else
		{
			if (($fechadesde!=0) || ($fechahasta!=0))
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
					'pe'=>[
						'table'=>'pedidos_items',
						'type'=>'INNER',
						'conditions'=>'pe.pedido_id = Pedidos.id',
					],
					'a'=>[
						'table'=>'articulos',
						'type'=>'INNER',
						'conditions'=>'a.id = pe.articulo_id',
					]
				])*/
				->where(['Pedidos.cliente_id'=>$this->request->session()->read('Auth.User.cliente_id')])
				->andWhere(["Pedidos.creado BETWEEN '".$fechadesde2->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta2->i18nFormat('yyyy-MM-dd')."'"])
				->group('Pedidos.id')
				->order(['fecha'=>'ASC']);
			}
			else
					{
						$pedidosA=null;
						$this->redirect($this->referer());
					}		
		}
		if ($pedidosA!=null){
			$pedidos = $this->paginate($pedidosA);
		} else
			$pedidos = null;
		//debug($pedidos);
		$this->set('pedidos',$pedidos);
		$this->loadModel('Estados');
		$estados=$this->Estados->find('all');
		$this->set('estados', $estados->toArray());
		
		$this->loadModel('Carritos');
		$carritocon = $this->Carritos->find('all')	
					->where(['Carritos.cliente_id'=>$this->request->session()->read('Auth.User.cliente_id')])
					->order(['Carritos.id'=>'DESC']);
		$totalcarrito=0;
		$totalitems=0;
		$totalunidades=0;
		$this->loadModel('ClientesCreditos');
		$clientecreditos = $this->ClientesCreditos->find('all')	
					->where(['cliente_id'=>$this->request->session()->read('Auth.User.cliente_id')]);
		$clientecredito = $clientecreditos->first();
		$this->set('creditodisponible',$clientecredito['credito_maximo']-$clientecredito['credito_consumo']);
	
		foreach ($carritocon as $carrito): 
			$totalitems+=1;
			$totalcarrito= $totalcarrito + $carrito['cantidad']*round(h($carrito['precio_publico'])*0.807, 3);
			$totalunidades= $totalunidades + $carrito['cantidad'];
		endforeach; 
		$this->set('totalitems',$totalitems);
		$this->set('totalcarrito',$totalcarrito);
		$this->set('totalunidades',$totalunidades);
    }

	public function search()
    {
		
		if ($this->request->is('post','get')) {	
			if ($this->request->data['cliente_id']!=null)
				$cliente_id = $this->request->data['cliente_id'];
			else
				$cliente_id = $this->request->session()->read('Auth.User.cliente_id');
		    $this->request->session()->write('cliente_id',$cliente_id);
			/*$this->loadModel('Clientes');
			$client = $this->Clientes->get($this->request->session()->read('cliente_id'));		
			$this->request->session()->write('client',$client);*/
		} else {
			if (!empty($this->request->session()->read('cliente_id')))
				$cliente_id = $this->request->session()->read('cliente_id');
			else			
				$cliente_id = $this->request->session()->read('Auth.User.cliente_id');
			$this->request->session()->write('cliente_id',$cliente_id);
			/*if (empty($this->request->session()->read('client')))
			{
				$this->loadModel('Clientes');
				$client = $this->Clientes->get($this->request->session()->read('cliente_id'));		
				$this->request->session()->write('client',$client);
			}*/
		}
		if ($this->request->is('post')) {	
			if ($this->request->data['fechadesde']!=null)
				$fechadesde = $this->request->data['fechadesde'];
			else
				$fechadesde=0;
			if ($this->request->data['fechahasta']!=null)
				$fechahasta = $this->request->data['fechahasta'];
			else
				$fechahasta=0;
			if ($this->request->data['terminobuscar']!=null)
				$termsearch = $this->request->data['terminobuscar'];
			else
				$termsearch ="";
			if ($this->request->data['factura']!=null)
				$factura = $this->request->data['factura'];
			else
				$factura=0;
			if ($this->request->data['notacredito']!=null)
				$notacredito = $this->request->data['notacredito'];
			else
				$notacredito=0;
			if ($this->request->data['notadebito']!=null)
				$notadebito = $this->request->data['notadebito'];
			else
				$notadebito=0;
			if ($this->request->data['recibo']!=null)
				$recibo = $this->request->data['recibo'];
			else
				$recibo=0;
			$this->request->session()->write('termsearchcomp',$termsearch);
			$this->request->session()->write('fechadesdecomp',$fechadesde);	
			$this->request->session()->write('fechahastacomp',$fechahasta);

			$this->request->session()->write('factura',$factura);
			$this->request->session()->write('notacredito',$notacredito);	
			$this->request->session()->write('notadebito',$notadebito);
			$this->request->session()->write('recibo',$recibo);
		} else {
	
			$fechahasta = $this->request->session()->read('fechahastacomp');
		    $fechadesde = $this->request->session()->read('fechadesdecomp');
			$termsearch = $this->request->session()->read('termsearchcomp');
			$factura = $this->request->session()->read('factura');
		    $notacredito = $this->request->session()->read('notacredito');
			$notadebito = $this->request->session()->read('notadebito');
			$recibo = $this->request->session()->read('recibo');		
		}
		if (isset($this->request->data['btnexcel'])) {
			//$this->excel();
			return $this->redirect(['action'=>'excel']);
		}
		
		
		$this->viewBuilder()->layout('store');
        
		$this->paginate = [
			'limit'=>100,
            //'contain'=>['Clientes','ComprobantesTipos']
        ];
		
		$query = $this->Comprobantes->find('all')
									->contain(['ComprobantesTipos'])
									->where(['cliente_id'=>$this->request->session()->read('cliente_id')]);
		
		$filtro = array();
		if ($factura==1) array_push($filtro, 1);
		if ($notadebito==1) array_push($filtro, 2);
		if ($notacredito==1) array_push($filtro, 3);
		if ($recibo==1)	array_push($filtro, 4);
		
		if ($factura==0 || $notadebito==0 || $notacredito==0 || $recibo==0)
		{
			if ($factura==1 || $notadebito==1 || $notacredito==1 || $recibo==1)
				$query->andWhere(['Comprobantes.comprobante_tipo_id in '=>$filtro]);
		}

		if ($fechahasta!=0)
		{
			$fechahasta2 = Time::createFromFormat('d/m/Y',$fechahasta,'America/Argentina/Buenos_Aires');
			$fechahasta2->modify('+1 days');
			$fechahasta2->i18nFormat('yyyy-MM-dd');
		} else {
			$fechahasta2 = Time::now();
			$fechahasta2->modify('+1 days');
		}
		if ($fechadesde!=0) {
			$fechadesde2 = Time::createFromFormat('d/m/Y',$fechadesde,'America/Argentina/Buenos_Aires');
			$fechadesde2->i18nFormat('yyyy-MM-dd');
		} else {
			$fechadesde2 = Time::now();
			if ($fechahasta!=0)
				$fechadesde2->setDate($fechadesde2->year, $fechahasta2->month, 1);
			else
				$fechadesde2->setDate($fechadesde2->year, $fechadesde2->month, 1);
			$fechadesde2->i18nFormat('yyyy-MM-dd');
		}

		$query->andWhere(["Comprobantes.fecha BETWEEN '".$fechadesde2->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta2->i18nFormat('yyyy-MM-dd')."'"])
		->order(['fecha'=>'DESC']);
		if ($termsearch!="")
		{
			$query->andWhere([
					'OR'=>[['Comprobantes.nota'=>$termsearch], 
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
			$clientes[$this->request->session()->read('Auth.User.cliente_id')] = $this->request->session()->read('Auth.User.codigo').' - '.$this->request->session()->read('Auth.User.razon');
		*/
		$this->listadocliente();
		//$this->set('clientes', $clientes);
        $this->set('comprobantes', $comprobantes);
        $this->set('_serialize',['comprobantes']);
	}
	
	public function search_admin()
    {
		if ($this->request->is('post'))
		{	
			
			if ($this->request->data['fechadesde']!=null)
				$fechadesdec = $this->request->data['fechadesde'];
			else
				$fechadesdec=0;
			if ($this->request->data['fechahasta']!=null)
				$fechahastac = $this->request->data['fechahasta'];
			else
				$fechahastac =0;
			if ($this->request->data['terminobuscarf']!=null)
				$termsearchf = $this->request->data['terminobuscarf'];
			else
				$termsearchf ="";
			if ($this->request->data['terminobuscarn']!=null)
				$termsearchn = $this->request->data['terminobuscarn'];
			else
				$termsearchn ="";
				if ($this->request->data['terminocliente']!=null)
				$termclient = $this->request->data['terminocliente'];
			else
				$termclient ="";
			
			if ($this->request->data['factura']!=null)
				$factura = $this->request->data['factura'];
			else
				$factura=0;
			if ($this->request->data['notacredito']!=null)
				$notacredito = $this->request->data['notacredito'];
			else
				$notacredito=0;
			if ($this->request->data['notadebito']!=null)
				$notadebito = $this->request->data['notadebito'];
			else
				$notadebito=0;
			if ($this->request->data['recibo']!=null)
				$recibo = $this->request->data['recibo'];
			else
				$recibo=0;

				
		
		
			$this->request->session()->write('termclient',$termclient);
			$this->request->session()->write('termsearchf',$termsearchf);
			$this->request->session()->write('termsearchn',$termsearchn);
			$this->request->session()->write('fechadesdec',$fechadesdec);	
			$this->request->session()->write('fechahastac',$fechahastac);

			$this->request->session()->write('factura',$factura);
			$this->request->session()->write('notacredito',$notacredito);	
			$this->request->session()->write('notadebito',$notadebito);
			$this->request->session()->write('recibo',$recibo);
		} else {
			$termclient= $this->request->session()->read('termclient');
			$fechahastac = $this->request->session()->read('fechahastac');
		    $fechadesdec = $this->request->session()->read('fechadesdec');
			$termsearchn = $this->request->session()->read('termsearchn');
			$termsearchf = $this->request->session()->read('termsearchf');
			
			$factura = $this->request->session()->read('factura');
		    $notacredito = $this->request->session()->read('notacredito');
			$notadebito = $this->request->session()->read('notadebito');
			$recibo = $this->request->session()->read('recibo');
		}
		
		$this->viewBuilder()->layout('admin');
        
		$this->paginate = [
			'limit'=>100,
            'contain'=>['Clientes', 'ComprobantesTipos']
        ];
		$query = $this->Comprobantes->find('all');
		if ($termclient !="")
		{
			$query->join([
					'c'=>[
						'table'=>'clientes',
						'type'=>'left',
						'conditions'=>'c.id = Comprobantes.cliente_id',
					]
				])
					->where(['c.codigo'=>$termclient]);
		}
		$filtro = array();
		if ($factura==1) array_push($filtro, 1);
		if ($notadebito==1) array_push($filtro, 2);
		if ($notacredito==1) array_push($filtro, 3);
		if ($recibo==1)	array_push($filtro, 4);
		
		if ($recibo==1 || $notadebito==1 || $notacredito==1 || $recibo==1)
			$query->andWhere(['Comprobantes.comprobante_tipo_id in '=>$filtro]);
		

		if ($fechahastac!=0)
		{
			$fechahasta2 = Time::createFromFormat('d/m/Y',$fechahastac,'America/Argentina/Buenos_Aires');
			$fechahasta2->modify('+1 days');
			$fechahasta2->i18nFormat('yyyy-MM-dd');
		}
		else
		{
			$fechahasta2 = Time::now();
			$fechahasta2->modify('+1 days');
		}
		if ($fechadesdec!=0)
		{
			$fechadesde2 = Time::createFromFormat('d/m/Y',$fechadesdec,'America/Argentina/Buenos_Aires');
			$fechadesde2->i18nFormat('yyyy-MM-dd');
		}
		else
		{
			$fechadesde2 = Time::now();
			if ($fechahastac!=0)
				$fechadesde2->setDate($fechadesde2->year, $fechahasta2->month, 1);
			else
				$fechadesde2->setDate($fechadesde2->year, $fechadesde2->month, 1);
			$fechadesde2->i18nFormat('yyyy-MM-dd');
		}

		$query->andWhere(["Comprobantes.fecha BETWEEN '".$fechadesde2->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta2->i18nFormat('yyyy-MM-dd')."'"])
		->order(['fecha'=>'ASC']);
		if ($termsearchn!="")
		{
			$query->andWhere(['Comprobantes.nota'=>$termsearchn]);		
			
		}
        if ($termsearchf!="")
		{
			$query->andWhere(['Comprobantes.numero'=>$termsearchf]);
		}
		if ($query!=null)
		
			$comprobantes = $this->paginate($query);
		
		else
			$comprobantes = null;

        $this->set('comprobantes', $comprobantes);
        $this->set('_serialize', ['comprobantes']);
		$this->set('titulo','Lista Comprobantes');
	}

	public function traza($id = null)
    {
		$this->viewBuilder()->layout('store');
        $comprobante = $this->Comprobantes->get($id,[
            'contain'=>['ComprobantesTipos']
        ]);
		$this->loadModel('Trazas');
        $this->paginate = [
            'contain'=>['Articulos','Clientes']
        ];
		
		
		$query =$this->Trazas->find('all')
							 ->where(['cliente_id'=>$this->request->session()->read('cliente_id')])
							 ->andWhere(['nota'=>$comprobante->nota/*,'cod_transaccion<>"0"'*/]);
							 
        $this->set('trazas', $this->paginate($query));
        $this->set('_serialize',['trazas']);
        
        
        $this->set(compact('comprobante'));
        $this->set('_serialize',['comprobante']);
    }
   
      public function trazapdf($id = null)
    {
		$this->viewBuilder()->layout('pdf');
        $comprobante = $this->Comprobantes->get($id,[
            'contain'=>['ComprobantesTipos','Clientes','Clientes.Provincias','Clientes.Localidads']
        ]);
		$this->loadModel('Trazas');
        $this->paginate = [
			'contain'=>['Articulos','Clientes'],
			'limit'=>60
        ];
		
		
		$query =$this->Trazas->find('all')
								->contain(['Clientes'])
							 ->where(['cliente_id'=>$this->request->session()->read('cliente_id')])
							 
							 ->andWhere(['nota'=>$comprobante->nota/*,'cod_transaccion<>"0"'*/])
							 ->order(['Trazas.id'=>'DESC']);
							 
							 
        $this->set('trazas', $this->paginate($query));
		$this->set('_serialize', ['trazas']);
        

		
        $this->set(compact('comprobante'));
        $this->set('_serialize', ['comprobante']);

		$this->loadModel('FacturasCuerposItemsLotesVctos');

		$query =$this->FacturasCuerposItemsLotesVctos->find('all')
		->contain(['Clientes'])
		->where(['cliente_id'=>$this->request->session()->read('cliente_id')])
		->andWhere(['nota'=>$comprobante['nota']/*,'cod_transaccion<>"0"'*/])
		->order(['FacturasCuerposItemsLotesVctos.id'=>'DESC']);
		$this->set('lotevctos', $query->toArray());

		$this->loadModel('FacturasCabeceras');					 
		$facturascabeceras = $this->FacturasCabeceras->find('all')	
		->where(['FacturasCabeceras.comprobante_id'=>$id])->first();
		

		$this->set(compact('facturascabeceras'));
        $this->set('_serialize',['facturascabeceras']);

		$this->viewBuilder()->options([
			'pdfConfig'=>[
				'orientation'=>'portrait',
				'filename'=>'Traza_' . $comprobante->nota . '.pdf'
			]
		]);
	}


	public function lotevctopdf($id = null)
    {
		$this->viewBuilder()->layout('pdf');
		
        $comprobante = $this->Comprobantes->get($id,[
            'contain'=>['ComprobantesTipos','Clientes','Clientes.Provincias','Clientes.Localidads']
        ]);
		
        $this->paginate = [
            'contain'=>['Articulos','Clientes'], 'limit'=>100
        ];

		$this->loadModel('Trazas');
		
		$query =$this->Trazas->find('all')
							->contain(['Clientes'])
							 ->where(['cliente_id'=>$this->request->session()->read('cliente_id')])
							 ->andWhere(['nota'=>$comprobante->nota/*,'cod_transaccion<>"0"'*/])
							 ->order(['Trazas.id'=>'DESC']);
							 
							 
        $this->set('trazas', $this->paginate($query));
		$this->set('_serialize',['trazas']);

		$this->loadModel('FacturasCuerposItemsLotesVctos');

		$query =$this->FacturasCuerposItemsLotesVctos->find('all')
		->contain(['Clientes'])
		->where(['cliente_id'=>$this->request->session()->read('cliente_id')])
		->andWhere(['nota'=>$comprobante['nota']/*,'cod_transaccion<>"0"'*/])
		->order(['FacturasCuerposItemsLotesVctos.id'=>'DESC']);
		$this->set('lotevctos', $this->paginate($query));

		$this->loadModel('FacturasCabeceras');					 
		$facturascabeceras = $this->FacturasCabeceras->find('all')->where(['FacturasCabeceras.comprobante_id'=>$id])->first();
		
		$this->set(compact('facturascabeceras'));
        $this->set('_serialize',['facturascabeceras']);
							 
       
		$this->set('_serialize',['lotevctos']);
        
     
		
        $this->set(compact('comprobante'));
        $this->set('_serialize',['comprobante']);
		
		
		$this->viewBuilder()->options([
			'pdfConfig'=>[
				'orientation'=>'portrait',
				'filename'=>'LoteVcto_' . $comprobante['nota'] . '.pdf'
			]
		]);	
	}
   /*
	public function excel(){
		$this->viewBuilder()->layout('ajax');
			
		if ($this->request->is('post','get'))
		{	
			if ($this->request->data['fechadesde']!=null)
				$fechadesde = $this->request->data['fechadesde'];
			else
				$fechadesde=0;
			if ($this->request->data['fechahasta']!=null)
				$fechahasta = $this->request->data['fechahasta'];
			else
				$fechahasta =0;
			if ($this->request->data['terminobuscar']!=null)
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
					->join([
					'c'=>[
						'table'=>'comprobantes',
						'type'=>'LEFT',
						'conditions'=>'FacturasCabeceras.comprobante_id = c.id',
					]
					])
					
					->where(['FacturasCabeceras.cliente_id'=>$this->request->session()->read('Auth.User.cliente_id')])
					->andWhere(["FacturasCabeceras.fecha BETWEEN '".$fecha->i18nFormat('yyyy-MM-dd')."' AND '".$fecha2->i18nFormat('yyyy-MM-dd')."'"])
					->order(['FacturasCabeceras.fecha'=>'ASC']);
		if ($termsearch!="")
		{
			$facturascabeceras->andWhere([
					'OR'=>[['c.nota'=>$termsearch], 
					['c.numero'=>$termsearch]],
				]);
			
		}
		$this->loadModel('NotasCabeceras');
		$notascabeceras = $this->NotasCabeceras->find('all')	
					->contain(['Comprobantes'
					])
					->join([
					'c'=>[
						'table'=>'comprobantes',
						'type'=>'LEFT',
						'conditions'=>'NotasCabeceras.comprobante_id = c.id',
					]
					])
					
					->where(['NotasCabeceras.cliente_id'=>$this->request->session()->read('Auth.User.cliente_id')])
					->andWhere(["NotasCabeceras.fecha BETWEEN '".$fecha->i18nFormat('yyyy-MM-dd')."' AND '".$fecha2->i18nFormat('yyyy-MM-dd')."'"])
					->order(['NotasCabeceras.fecha'=>'ASC']);
		
		//$facturascabeceras->order(['FacturasCabeceras.fecha'=>'ASC']);
		
		
		$this->request->session()->write('notasCabeceras',$notascabeceras->toArray());
		$this->request->session()->write('facturasCabeceras',$facturascabeceras->toArray());
		
        $this->set('facturasCabeceras', $facturascabeceras->toArray());
		
        //$this->set('_serialize',['facturasCabeceras']);
		
		$this->response->type('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	}
	*/
	
	public function excel(){
		$this->viewBuilder()->layout('ajax');
	
		if ($this->request->is('post','get')){	
			if ($this->request->data['fechadesde']!=null)
				$fechadesde = $this->request->data['fechadesde'];
			else
				$fechadesde=0;
			if ($this->request->data['fechahasta']!=null)
				$fechahasta = $this->request->data['fechahasta'];
			else
				$fechahasta =0;
			if ($this->request->data['terminobuscar']!=null)
				$termsearch = $this->request->data['terminobuscar'];
			else
				$termsearch ="";

			if ($this->request->data['cliente_id']!=null)
				$cliente_id = $this->request->data['cliente_id'];
			else
				$cliente_id = $this->request->session()->read('Auth.User.cliente_id');
			$this->request->session()->write('cliente_id',$cliente_id);
			$this->request->session()->write('termsearch',$termsearch);
			$this->request->session()->write('fechadesdecomp',$fechadesde);	
			$this->request->session()->write('fechahastacomp',$fechahasta);
		} else {
			$fechahasta = $this->request->session()->read('fechahastacomp');
		    $fechadesde = $this->request->session()->read('fechadesdecomp');
			$termsearch = $this->request->session()->read('termsearch');
			if (!empty($this->request->session()->read('cliente_id')))
			$cliente_id = $this->request->session()->read('cliente_id');
				else			
			$cliente_id = $this->request->session()->read('Auth.User.cliente_id');
			$this->request->session()->write('cliente_id',$cliente_id);
		}
		




		$this->loadModel('FacturasCabeceras');
        $this->paginate = [
            'contain'=>['Comprobantes','Clientes'],
			'limit'=>50000,
			'maxLimit'=>50000,
        ];
		
		if ($fechahasta!=0) {
			$fecha2 = Time::createFromFormat('d/m/Y',$fechahasta,'America/Argentina/Buenos_Aires');
			//$fecha2->modify('+1 days');
		} else {
			$fecha2 = Time::now();
			//$fecha2-> modify('+1 days');
		}
		if ($fechadesde!=0) {
			$fecha= Time::createFromFormat('d/m/Y',$fechadesde,'America/Argentina/Buenos_Aires');
		} else {
			$fecha = Time::now();
			if ($fechahasta!=0)
				$fecha->setDate($fecha2->year, $fecha2->month, 1);
			else
				$fecha->setDate($fecha->year, $fecha->month, 1);
			//$fechadesde2->i18nFormat('yyyy-MM-dd');
		}
		$this->loadModel('Clientes');
		$cliente_id = $this->request->session()->read('cliente_id');
	
		$grupo = array();
		$client = $this->Clientes->get($cliente_id);
		if ($client['cuentaprincipal']>0) {
			$grupo = $this->Clientes->find('all')->where(['grupo_id'=>$client['grupo_id']])->select('id');
			//$grupo = $grupo->toArray();
		} else {
			$grupo[1]=$client['id'];
		}
		$facturascabeceras = $this->FacturasCabeceras->find('all')	
					->contain(['Clientes','Comprobantes'])
					/*->join([
					'c'=>[
						'table'=>'comprobantes',
						'type'=>'LEFT',
						'conditions'=>'FacturasCabeceras.comprobante_id = c.id',
					]
					])*/
					->where(['FacturasCabeceras.cliente_id IN'=>$grupo])
					//->where(['FacturasCabeceras.cliente_id'=>$this->request->session()->read('cliente_id')])
					->andWhere(["FacturasCabeceras.fecha BETWEEN '".$fecha->i18nFormat('yyyy-MM-dd')."' AND '".$fecha2->i18nFormat('yyyy-MM-dd')."'"])
					->order(['FacturasCabeceras.fecha'=>'ASC','FacturasCabeceras.pedido_ds'=>'ASC'])
					//->order(['FacturasCabeceras.fecha'=>'ASC','FacturasCabeceras.pedido_ds'=>'ASC' ])
					->group('FacturasCabeceras.pedido_ds');
		if ($termsearch!="") {
			$facturascabeceras->andWhere([
					'OR'=>[['c.nota'=>$termsearch],['c.numero'=>$termsearch]]]);
		}
		//$facturascabeceras->order(['FacturasCabeceras.fecha'=>'ASC']);
		$this->loadModel('NotasCabeceras');
		$notascabeceras = $this->NotasCabeceras->find('all')	
			->contain(['Clientes','Comprobantes','NotasCuerposItems'])
					/*->contain(['Comprobantes'])
					->join([
					'nci'=>[
						'table'=>'notas_cuerpos_items',
						'type'=>'inner',
						'conditions'=>'NotasCabeceras.id = nci.notas_cabeceras_id',
					]
					])*/
					->where(['NotasCabeceras.cliente_id IN'=>$grupo])
					//->where(['NotasCabeceras.cliente_id'=>$this->request->session()->read('cliente_id')])
					->andWhere(["NotasCabeceras.fecha BETWEEN '".$fecha->i18nFormat('yyyy-MM-dd')."' AND '".$fecha2->i18nFormat('yyyy-MM-dd')."'"])
					->order(['NotasCabeceras.fecha'=>'ASC'])
					->group('NotasCabeceras.nota');

					
		$this->request->session()->write('notasCabeceras',$notascabeceras->toArray());
		$this->request->session()->write('facturasCabeceras',$this->paginate($facturascabeceras));
		
        $this->set('facturasCabeceras', $this->paginate($facturascabeceras));
        $this->set('notasCabeceras', $notascabeceras->toArray());
        
		$this->set('_serialize',['facturasCabeceras']);
		$this->set('_serialize',['notasCabeceras']);
		$this->response->type('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	}
	
     /**
     *View method
     *
     *@param string|null $id Comprobante id.
     *@return void
     *@throws \Cake\Network\Exception\NotFoundException When record not found.
     */
	public function view($id = null, $fecha=null)
    {
		$this->set('fecha', $fecha);
		$this->viewBuilder()->layout('store');
			//dd($this->request);
		if (!empty($this->request->session()->read('Auth.User'))) {

		$comprobante = $this->Comprobantes->find("all")->contain(['Clientes','ComprobantesTipos'])->where(['Comprobantes.id'=>$id])->first();

		if ($this->request->is('post','get'))
		{	
			if ($this->request->data['cliente_id']!=null)
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

		$this->paginate = [
			'contain'=>['FacturasCabeceras','Articulos'],
			'limit'=>100,
				'maxLimit'=>100,
        	];
			if (strval($comprobante['cliente_id']) === strval($cliente_id)) {
		$comprobante = $this->Comprobantes->find("all")->contain(['Clientes','ComprobantesTipos'])->where(['Comprobantes.id'=>$id,'Comprobantes.cliente_id' =>$cliente_id])->first();
		$this->set('comprobante', $comprobante);
        $this->set('_serialize',['comprobante']);
		$facturas=0;
		$notas=0;
		switch ($comprobante['comprobante_tipo_id']) {
				
				case 1:
					$facturas=1;
					$nombreArchivo= 'FACTURA';
					break;
				case 2:
					$notas =1;
					$nombreArchivo= 'NOTA DE DEBITO';
					break;
				case 3:
					$notas =1;
					$nombreArchivo= 'NOTA DE CREDITO';
					break;
				case 4:
					$notas =1;
					$nombreArchivo= 'RECIBO OFICIAL';
					break;
				case 5:
					$facturas=1;
					$nombreArchivo= 'FACTURA';
					break;
			}

		$clientes=array();
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
			if ($facturas>0)
		{
		
			
		$this->loadModel('FacturasCabeceras');

			$fechac = substr($fecha,0,4).'-'.substr($fecha,4,2).'-'.substr($fecha,6,2);
    	    $facturasCabecera = $this->FacturasCabeceras->find()->contain(['Clientes','Comprobantes'])->where(['comprobante_id'=>$id,'FacturasCabeceras.fecha'=>$fechac])->first();
		
			$this->paginate = [
			'contain'=>['FacturasCabeceras','Articulos'],
			'limit'=>100,
				'maxLimit'=>100,
        	];
        	$this->loadModel('FacturasCuerposItems');
			$facturasCuerposItems =	$this->FacturasCuerposItems->find('all')->where(['facturas_encabezados_id'=>$facturasCabecera['id']]);
										
			$this->set('facturasCuerposItems', $this->paginate($facturasCuerposItems));
        	$this->set('_serialize',['facturasCuerposItems']);
		
		
        $this->set('facturasCabecera', $facturasCabecera);
		$this->set('_serialize',['facturasCabecera']);
		
		
		
		$this->loadModel('FacturasCuerposItemsLotesVctos');
        $this->paginate = [
            'contain'=>['Articulos','Clientes'],	'limit'=>100,
			'maxLimit'=>100,
        ];
		
		
		$query =$this->FacturasCuerposItemsLotesVctos->find('all')
							 ->contain(['Articulos'])
							 ->where(['cliente_id'=>$this->request->session()->read('cliente_id')])
							 ->andWhere(['nota'=>$comprobante['nota']]);
							 
        $this->set('lotevctos', $query->toArray());
        $this->set('_serialize',['lotevctos']);
		}
		
		if ($notas>0)
		{
			$this->loadModel('NotasCabeceras');
			$fechac = substr($fecha, 0, 4) . '-' . substr($fecha, 4, 2) . '-' . substr($fecha, 6, 2);
			$notascabecera = $this->NotasCabeceras->find('all')->contain(['Comprobantes'])
			->where(['NotasCabeceras.comprobante_id'=>$id, 'NotasCabeceras.fecha'=>$fechac])->first();
			$this->request->session()->write('notasCabecera',$notascabecera->toArray());							
		
			$this->set('notasCabecera',$notascabecera->toArray());
			

			$this->loadModel('NotasCuerposItems');
			$notasCuerposItems = $this->NotasCuerposItems->find('all')->contain(['Articulos'])
			->join([
				'a'=>[
					'table'=>'articulos',
					'type'=>'left',
					'conditions'=>'a.id = NotasCuerposItems.articulo_id'
				]
			])				
			->where(['notas_cabeceras_id'=>$notascabecera['id']]);

			$this->set('notasCuerposItems',$notasCuerposItems->toArray());
			$this->set('_serialize',['notasCuerposItems']);

		}

		$this->loadModel('Trazas'); 
		$query =$this->Trazas->find('all')
							->contain(['Articulos'])
							->where(['cliente_id'=>$this->request->session()->read('cliente_id')])
							->andWhere(['nota'=>$comprobante['nota']/*,'cod_transaccion<>"0"'*/]);
		$this->set('trazas', $query->toArray());
		$titulo = str_pad($comprobante['seccion'], 4, "0", STR_PAD_LEFT).'-'.$comprobante['numero'];
		$this->set('titulo',$nombreArchivo.' N°: '.$titulo.' NOTA N°: '.$comprobante['nota']);
    } else {
				$this->Flash->error(__('Este comprobante no te pertenece.'));
				return $this->redirect([
					'controller'=>'Comprobantes',
					'action'=>'index',
				]);
			}
		} else {
			return $this->redirect([
				'controller'=>'Users',
				'action'=>'login',
			]);
		}
		}


	public function view_admin($id = null, $fecha=null)
    {
		$this->set('fecha', $fecha);
		$this->viewBuilder()->layout('admin');
        $comprobante = $this->Comprobantes->get($id,[
            'contain'=>['Clientes','ComprobantesTipos']
        ]);
        $this->set('comprobante', $comprobante);
        $this->set('_serialize',['comprobante']);
		
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

	public function view_nota_admin($cliente_id=null ,$nota = null, $fecha = null)
	{
		//$this->set('fecha', $fecha);
		$this->viewBuilder()->layout('adminS');

		$comprobante = $this->Comprobantes->find("all")->contain(['Clientes','ComprobantesTipos'])
		->where(['Comprobantes.nota'=>$nota,'Comprobantes.cliente_id' =>$cliente_id, 'Comprobantes.fecha >='=>$fecha])->first();
		$this->set('comprobante', $comprobante);
		$this->set('_serialize',['comprobante']);
		

		switch ($comprobante['comprobante_tipo_id']) {

			case 1:
				$nombreArchivo = 'FACTURA';
				break;
			case 2:
				$nombreArchivo = 'NOTA DE DEBITO';
				break;
			case 3:
				$nombreArchivo = 'NOTA DE CREDITO';
				break;
			case 4:
				$nombreArchivo = 'RECIBO OFICIAL';
				break;
			case 5:
				$nombreArchivo = 'FACTURA';
				break;
		}
		$titulo = str_pad($comprobante['seccion'], 4, "0", STR_PAD_LEFT) . '-' . $comprobante['numero'];
		$this->set('titulo', $nombreArchivo . ' N°: ' . $titulo . ' NOTA N°: ' . $comprobante['nota']);
	}
	
    /**
     *Add method
     *
     *@return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $comprobante = $this->Comprobantes->newEntity();
        if ($this->request->is('post')) {
            $comprobante = $this->Comprobantes->patchEntity($comprobante, $this->request->data);
            if ($this->Comprobantes->save($comprobante)) {
                $this->Flash->success(__('The comprobante has been saved.'));
                return $this->redirect(['action'=>'index']);
            } else {
                $this->Flash->error(__('The comprobante could not be saved. Please, try again.'));
            }
        }
        $clientes = $this->Comprobantes->Clientes->find('list',['limit'=>200]);
        $comprobanteTipos = $this->Comprobantes->ComprobantesTipos->find('list',['limit'=>200]);
        $this->set(compact('comprobante','clientes','comprobantesTipos'));
        $this->set('_serialize',['comprobante']);
    }

    /**
     *Edit method
     *
     *@param string|null $id Comprobante id.
     *@return void Redirects on successful edit, renders view otherwise.
     *@throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $comprobante = $this->Comprobantes->get($id,[
            'contain'=>[]
        ]);
        if ($this->request->is(['patch','post','put'])) {
            $comprobante = $this->Comprobantes->patchEntity($comprobante, $this->request->data);
            if ($this->Comprobantes->save($comprobante)) {
                $this->Flash->success(__('The comprobante has been saved.'));
                return $this->redirect(['action'=>'index']);
            } else {
                $this->Flash->error(__('The comprobante could not be saved. Please, try again.'));
            }
        }
        $clientes = $this->Comprobantes->Clientes->find('list',['limit'=>200]);
        $comprobanteTipos = $this->Comprobantes->ComprobanteTipos->find('list',['limit'=>200]);
        $this->set(compact('comprobante','clientes','comprobanteTipos'));
        $this->set('_serialize',['comprobante']);
    }

    /**
     *Delete method
     *
     *@param string|null $id Comprobante id.
     *@return void Redirects to index.
     *@throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post','delete']);
        $comprobante = $this->Comprobantes->get($id);
        if ($this->Comprobantes->delete($comprobante)) {
            $this->Flash->success(__('The comprobante has been deleted.'));
        } else {
            $this->Flash->error(__('The comprobante could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action'=>'index']);
    }
	
	public function downloadfiletrazatxt($id=null){
		
		$comprobante = $this->Comprobantes->get($id,[
            'contain'=>['ComprobantesTipos']
        ]);
		$this->loadModel('Trazas');
        /*$this->paginate = [
            'contain'=>['Articulos','Clientes']
        ];*/
		
		
		$query =$this->Trazas->find('all')
							->contain(['Articulos','Clientes'])
							 ->where(['cliente_id'=>$this->request->session()->read('cliente_id')])
							 ->andWhere(['nota'=>$comprobante->nota,'cod_transaccion<>"0"']);
		
								 
		//Facturas
		$this->set('query2', $query->isEmpty());
		if ($query->isEmpty()) { 
			$this->Flash->error(__('Momentaneamente no disponible, intente mas tarde.'),['key'=>'changepass']);
			$this->redirect($this->referer());
		} else {
			$client = $this->request->session()->read('client');
			$nombreArchivo= 'TRAZA'.str_pad($comprobante->nota, 6, "0", STR_PAD_LEFT).str_pad($client['codigo'], 6, "0", STR_PAD_LEFT);
			$file = new File('temp'. DS .'Comprobantes'. DS .$nombreArchivo.'.TXT', true, 0777);
			
			$line = "\r\n".'PRODUCTO                       GTIN           SERIE                LOTE                 VENC'."\r\n";
			$file->write($line,'w');
			foreach ($query as $row): 
				$fecha = date_format($row['vencimiento'],'Ymd');
				$line = str_pad($row['articulo']['descripcion_sist'], 31).
						str_pad($row['articulo']['codigo_barras'], 14,"0", STR_PAD_LEFT).' '.
						str_pad($row['serie'], 21, " ").
						str_pad($row['lote'], 21).
						str_pad($fecha, 8)."\r\n";
				$file->write($line,'w');

			endforeach; 
			$file->close(); // Be sure to close the file when you're done
			$this->response->type('txt');
			$nombre_fichero = 'temp'. DS .'Comprobantes'. DS .$nombreArchivo.'.TXT';

				if (file_exists($nombre_fichero)) {
					$this->response->file(
					'temp'. DS .'Comprobantes'. DS .$nombreArchivo.'.TXT',
					['download'=>true, 'name'=>$nombreArchivo.'.TXT']
					);
				}

			return $this->response;
		}
	}		

	public function downloadfiletxt($nota = null,$fecha =null){
		
		$this->loadModel('FacturasCuerposItems');
		$query = $this->FacturasCuerposItems->find('all')	
					->contain(['FacturasCabeceras','Articulos'])//,'Articulos'
					//->hydrate(false)
				
					->join([
					
					'fc'=>[
						'table'=>'facturas_cabeceras',
						'type'=>'INNER',
						'conditions'=>'fc.id = FacturasCuerposItems.facturas_encabezados_id',
					]
					])
					->where(['fc.cliente_id'=>$this->request->session()->read('cliente_id')])
					->where(['FacturasCuerposItems.pedido_ds'=>$nota,'fc.fecha'=>$fecha])
					->order(['fc.fecha'=>'ASC'])
					
					->group('FacturasCuerposItems.articulo_id');
		$this->request->session()->write('querytest',$query->toArray());

		if ($query->isEmpty())
		{ 
			$this->Flash->error(__('Momentaneamente no disponible, intente mas tarde.'),['key'=>'changepass']);
			$this->redirect($this->referer());
		} else {
			$codigo = str_pad($this->request->session()->read('Auth.User.codigo'), 6, "0", STR_PAD_LEFT);

			$nombreArchivo= 'F'.str_pad($nota, 6, "0", STR_PAD_LEFT).$codigo;
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
					['download'=>true, 'name'=>$nombreArchivo.'.TXT']
					);
				}

			return $this->response;	
		}		
	}		

	public function downloadfile($nota = null, $tipo=null, $fecha =null)
	{
		
			$this->response->type('pdf');

			// Optionally force file download
			//
			//
			//$this->response->file('temp'. DS .'DETFAC'.$codigo.'.TXT');
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
					['download'=>true, 'name'=>$nombreArchivo.$nota.'.pdf']
					);
					return $this->response;
				} else { 
					$this->Flash->error(__('Momentaneamente no disponible, intente mas tarde.'),['key'=>'changepass']);
				$this->redirect($this->referer());
			}
	}

	public function downloadfilenew($nota = null, $cliente_id = null, $fecha = null)
	{

		$this->response->type('pdf');

		// Optionally force file download
		//
		//
		//$this->response->file('temp'. DS .'DETFAC'.$codigo.'.TXT');
		$comprobante = $this->Comprobantes->find("all")->contain(['Clientes','ComprobantesTipos'])
		->where(['Comprobantes.nota'=>$nota,'Comprobantes.cliente_id' =>$cliente_id, 'Comprobantes.fecha >='=>$fecha])->first();
		$this->set('comprobante', $comprobante);
		$this->set('_serialize',['comprobante']);
		

		switch ($comprobante['comprobante_tipo_id']) {

			case 1:
				$nombreArchivo = 'FACT01';
				break;
			case 2:
				$nombreArchivo = 'COMP02';
				break;
			case 3:
				$nombreArchivo = 'COMP03';
				break;
			case 4:
				$nombreArchivo = 'COMP04';
				break;
			case 5:
				$nombreArchivo = 'FACT01';
				break;
		}
		$nota = str_pad($nota, 6, '0', STR_PAD_LEFT);




		if ($fecha > 20170423)
			$nota = $nota . date_format($comprobante['fecha'], 'Ymd');
			//$comprobante['fecha'];

		$nombre_fichero = 'temp' . DS . 'Comprobantes' . DS . $nombreArchivo . $nota . '.pdf';

		if (file_exists($nombre_fichero)) {
			$this->response->file(
				$nombre_fichero,
				['download'=>true, 'name'=>$nombreArchivo . $nota . '.pdf']
			);
			return $this->response;
		} else {
			$this->Flash->error(__('Momentaneamente no disponible, intente mas tarde.'),['key'=>'changepass']);
			$this->redirect($this->referer());
		}
	}


	public function downloadfiletxt2($nota = null,$fecha =null)
	{
				
		$this->viewBuilder()->layout('store');
	
		$this->loadModel('FacturasCabeceras');
		$this->loadModel('FacturasCuerposItems');
		$this->paginate = [];
		
		$query = $this->FacturasCabeceras->find('all')	
					->contain(['FacturasCuerposItems','Comprobantes','FacturasCuerposItems.Articulos'])//,'Articulos'
					->hydrate(false)
					
					->join([
					'c'=>[
						'table'=>'comprobantes',
						'type'=>'INNER',
						'conditions'=>'FacturasCabeceras.comprobante_id = c.id',
					],
					'ci'=>[
						'table'=>'facturas_cuerpos_items',
						'type'=>'INNER',
						'conditions'=>'FacturasCabeceras.id = ci.facturas_encabezados_id',
					],
					])
					->where(['FacturasCabeceras.cliente_id'=>$this->request->session()->read('cliente_id'),'c.nota'=>$nota,'c.fecha'=>$fecha])
					->order(['FacturasCabeceras.fecha'=>'ASC'])
					->group('c.id');
		
		if ($query!=null)
		
			$facturascabeceras = $query->toArray();
		
		else
			$facturascabeceras = null;
		
		
		if ($query->isEmpty())
		{ $this->Flash->error(__('Momentaneamente no disponible, intente mas tarde.'),['key'=>'changepass']);
			$this->redirect($this->referer());}
		else
		{
			
		$this->request->session()->write('facturascabeceras2',$facturascabeceras);
		$nombrearhivodirectorio = 'temp'. DS;

		if ($this->request->session()->read('Auth.User.cliente_id') != $this->request->session()->read('cliente_id'))
		{
			$this->loadModel('Clientes');
			$client = $this->Clientes->get($this->request->session()->read('cliente_id'));		
			$codigo = str_pad($client['codigo'], 6, "0", STR_PAD_LEFT);
			$nombre = $client['nombre'];
		}
		else
		{
			$codigo = str_pad($this->request->session()->read('Auth.User.codigo'), 6, "0", STR_PAD_LEFT);
			$nombre = $this->request->session()->read('Auth.User.razon');
		}
		
		$nombrearhivo= 'F'.str_pad($nota, 6, "0", STR_PAD_LEFT).$codigo.'.TXT';
		$file = new File($nombrearhivodirectorio.$nombrearhivo, true, 0777);
		
		$descuento_pf = $this->request->session()->read('Auth.User.pf_dcto');
        $condicion = $this->request->session()->read('Auth.User.condicion');
        $condiciongeneral = (1-($descuento_pf * (1-$condicion/100)));

		foreach ($facturascabeceras as $fc): 
			$espacio = "\t";
			$item = 'C'.$espacio;
			$item .= $codigo.$espacio;
			$item .= str_pad($fc['comprobante']['seccion'], 4, "0", STR_PAD_LEFT);
			$item .= $fc['letra'];
			$item .= str_pad($fc['comprobante']['numero'], 8, "0", STR_PAD_LEFT).$espacio;
			$item .= str_pad($nombre, 30, " ", STR_PAD_RIGHT).$espacio;
			$item .= 'AUT'.$espacio;  
			$imp = $fc['imp_gravado']* 100;
			
			$item .= str_pad($imp, 15, "0", STR_PAD_LEFT).$espacio;
			$imp = $fc['imp_exento']*100;
			$item .= str_pad($imp, 15, "0", STR_PAD_LEFT).$espacio;
			$imp = $fc['imp_iva']*100;
			//$imp = number_format($fc['imp_iva'],2,'.','');
			$item .= str_pad($imp, 13, "0", STR_PAD_LEFT).$espacio;
			$imp = $fc['imp_rg3337']*100;
			$item .= str_pad($imp, 13, "0", STR_PAD_LEFT).$espacio;
			$imp = $fc['imp_ingreso_bruto']*100;
			$item .= str_pad($imp, 13, "0", STR_PAD_LEFT).$espacio;
			$imp = $fc['total']*100;
			//$imp = number_format($fc['total'],2,'.','');
			
			$item .= str_pad($imp, 15, "0", STR_PAD_LEFT).$espacio;
			$item .= date_format($fc['fecha'],'dmY').$espacio;
			$item .= str_pad($fc['pedido_ds'], 6, "0", STR_PAD_LEFT).$espacio;
			if (!is_null($fc['fecha_vencimiento']))
			$item .= date_format($fc['fecha_vencimiento'],'dmY');
			else
			$item .= date_format($fc['fecha'],'dmY');

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
				//$imp = $fci['precio_unitario'];
				$imp = $fci['precio_unitario']*100;// number_format($fci['precio_unitario'],2,'.','');
				$itemart .= str_pad($imp, 13, "0", STR_PAD_LEFT).$espacio;
				$precio_publico = $fci['precio_publico'];
				if ($this->request->session()->read('Auth.User.provincia_id') ==23)
                {
                    if ($fci['descuento']>0)
                    	$descuentoI = $fci['descuento']/100;
                        else
						{
                    		$descuentoI = $condiciongeneral;                    
							$precio_publico = round($fci['precio_unitario']/(1 - $descuentoI),2);
						}
                }	
				
				$imp = $precio_publico*100;//$imp = number_format($fci['precio_publico'],2,'.','');
				//$imp = $fci['precio_publico'];
				$itemart .= str_pad($imp, 11, "0", STR_PAD_LEFT).$espacio;
				
				$imp = $fci['precio_total']*100;//number_format($fci['precio_total'],2,'.','');
				//$imp = $fci['precio_total'];
				$itemart .= str_pad($imp, 15, "0", STR_PAD_LEFT).$espacio;
				
				$descuento = $fci['descuento']*100;
				$itemart .= str_pad($descuento, 5, "0", STR_PAD_LEFT).$espacio;

				$file->write($itemart."\r\n");
			endforeach; 
			//$file->append(utf8_encode($string));
			//$file->create('I am overwriting the contents of this file');
			
		endforeach; 
		
		// $file->append('I am adding to the bottom of this file.');
		// $file->delete(); // I am deleting this file
		$file->close(); // Be sure to close the file when you're done
		
		if (file_exists($nombrearhivodirectorio.$nombrearhivo)) {
					$this->response->type('txt');

					$this->response->file(
					$nombrearhivodirectorio.$nombrearhivo,
					['download'=>true, 'name'=>$nombrearhivo]
					);

					return $this->response;
				} else { 
					$this->Flash->error(__('Momentaneamente no disponible, intente mas tarde.'),['key'=>'changepass']);
					$this->redirect($this->referer());
				}
		}
	}

	public function downloadfiletxt3($nota = null, $fecha = null)
	{

		$this->viewBuilder()->layout('store');

		$this->loadModel('NotasCabeceras');
		$this->loadModel('NotasCuerposItems');
		$this->paginate = [];

		$query = $this->NotasCabeceras->find('all')
			->contain(['NotasCuerposItems','Comprobantes','NotasCuerposItems.Articulos']) //,'Articulos'
			->hydrate(false)

			->join([
				'c'=>[
					'table'=>'comprobantes',
					'type'=>'INNER',
					'conditions'=>'NotasCabeceras.comprobante_id = c.id',
				],
				'ci'=>[
					'table'=>'notas_cuerpos_items',
					'type'=>'LEFT',
					'conditions'=>'NotasCabeceras.id = ci.notas_cabeceras_id',
				],
			])
			->where(['NotasCabeceras.cliente_id'=>$this->request->session()->read('cliente_id'), 'c.nota'=>$nota, 'c.fecha'=>$fecha])
			->order(['NotasCabeceras.fecha'=>'ASC'])
			->group('c.id');

		if ($query!=null)

			$notascabeceras = $query->toArray();

		else
			$notascabeceras = null;


		if ($query->isEmpty()) {
			$this->Flash->error(__('Momentaneamente no disponible, intente mas tarde.'),['key'=>'changepass']);
			$this->redirect($this->referer());
		} else {

			$this->request->session()->write('notascabeceras2', $notascabeceras);
			$nombrearhivodirectorio = 'temp' . DS;

			if ($this->request->session()->read('Auth.User.cliente_id')!=$this->request->session()->read('cliente_id')) {
				$this->loadModel('Clientes');
				$client = $this->Clientes->get($this->request->session()->read('cliente_id'));
				$codigo = str_pad($client['codigo'], 6, "0", STR_PAD_LEFT);
				$nombre = $client['nombre'];
			} else {
				$codigo = str_pad($this->request->session()->read('Auth.User.codigo'), 6, "0", STR_PAD_LEFT);
				$nombre = $this->request->session()->read('Auth.User.razon');
			}

			$nombrearhivo = 'N' . str_pad($nota, 6, "0", STR_PAD_LEFT) . $codigo . '.TXT';
			$file = new File($nombrearhivodirectorio . $nombrearhivo, true, 0777);


			foreach ($notascabeceras as $nc) :
				$espacio = "\t";
				$item = 'C'.$espacio;
				$item .= $codigo.$espacio;
				$item .= str_pad($nc['comprobante']['seccion'], 4, "0", STR_PAD_LEFT);
				$item .= $nc['letra'];
				$item .= str_pad($nc['comprobante']['numero'], 8, "0", STR_PAD_LEFT).$espacio;
				$item .= str_pad($nombre, 30, " ", STR_PAD_RIGHT).$espacio;
				$item .= 'AUT'.$espacio;
				$imp = $nc['imp_gravado']*100;

				$item .= str_pad($imp, 15, "0", STR_PAD_LEFT).$espacio;
				$imp = $nc['imp_exento']*100;
				$item .= str_pad($imp, 15, "0", STR_PAD_LEFT).$espacio;
				$imp = $nc['imp_iva']*100;
				//$imp = number_format($nc['imp_iva'],2,'.','');
				$item .= str_pad($imp, 13, "0", STR_PAD_LEFT).$espacio;
				$imp = $nc['imp_rg3337']*100;
				$item .= str_pad($imp, 13, "0", STR_PAD_LEFT).$espacio;
				$imp = $nc['imp_ingreso_bruto']*100;
				$item .= str_pad($imp, 13, "0", STR_PAD_LEFT).$espacio;
				$imp = $nc['total']*100;
				//$imp = number_format($nc['total'],2,'.','');

				$item .= str_pad($imp, 15, "0", STR_PAD_LEFT).$espacio;
				$item .= date_format($nc['fecha'], 'dmY').$espacio;
				$item .= str_pad($nc['nota'], 6, "0", STR_PAD_LEFT).$espacio;
				$item .= date_format($nc['fecha'], 'dmY').$espacio;
				$item .= $nc['tipo'];
				$file->write($item."\r\n");
				foreach ($nc['notas_cuerpos_items'] as $nci) :
					$itemart = 'D'.$espacio;
					$itemart .= $codigo.$espacio;
					$itemart .= str_pad($nc['comprobante']['seccion'], 4, "0", STR_PAD_LEFT);
					$itemart .= $nc['letra'];
					$itemart .= str_pad($nc['comprobante']['numero'], 8, "0", STR_PAD_LEFT).$espacio;


					$itemart .= '00'.$espacio;
					if (!empty($nci['articulo']))
					{
					$itemart .= str_pad($nci['articulo']['codigo_barras'], 13, "0", STR_PAD_LEFT).$espacio;

					$itemart .= str_pad($nci['articulo']['descripcion_sist'], 30, " ", STR_PAD_RIGHT).$espacio;

					}
					else
					{
					$itemart .= "0000000000000".$espacio;
					$descripcion = preg_replace('/[\x00-\x1F\x7F]/u', '', $nci['descripcion']);
					$itemart .= str_pad(trim($descripcion), 30, " ", STR_PAD_RIGHT).$espacio;
					}
					if ($nci['iva'])
						$itemart .= '1';
					else
						$itemart .= '0';
					$cantidad = $nci['cantidad'];
					if ($cantidad ==0) $cantidad =1;
					$itemart .= $espacio . str_pad($cantidad, 6, "0", STR_PAD_LEFT).$espacio;
					$imp = $nci['precio_unitario']*100; // number_format($nci['precio_unitario'],2,'.','');
					$itemart .= str_pad($imp, 13, "0", STR_PAD_LEFT).$espacio;
					$itemart .= "00000000000".$espacio;
					$imp = $nci['precio_unitario']*$cantidad*100; //number_format($nci['precio_total'],2,'.','');
					//$imp = $nci['precio_total'];
					$itemart .= str_pad($imp, 15, "0", STR_PAD_LEFT).$espacio;
					$itemart .= "00000".$espacio;
					$itemart .= str_pad($nci['nota_correccion'], 6, "0", STR_PAD_LEFT).$espacio;	
					$file->write($itemart."\r\n");
				endforeach;
			//$file->append(utf8_encode($string));
			//$file->create('I am overwriting the contents of this file');

			endforeach;

			// $file->append('I am adding to the bottom of this file.');
			// $file->delete(); // I am deleting this file
			$file->close(); // Be sure to close the file when you're done

			if (file_exists($nombrearhivodirectorio . $nombrearhivo)) {
				$this->response->type('txt');

				$this->response->file(
					$nombrearhivodirectorio . $nombrearhivo,
					['download'=>true, 'name'=>$nombrearhivo]
				);

				return $this->response;
			} else {
				$this->Flash->error(__('Momentaneamente no disponible, intente mas tarde.'),['key'=>'changepass']);
				$this->redirect($this->referer());
			}
		}
	}

	
	public function downloadfiletxtselect()
	{
		$entities = $this->request->data();
		$this->set('entities', $entities);
		$listaarray = array();

	
		foreach ($entities as $comprobant) {		
				if ($comprobant['seleccionar'])
					array_push($listaarray,$comprobant['id']);
		
		}
				
		$this->viewBuilder()->layout('store');
	
		$this->loadModel('FacturasCabeceras');
		$this->loadModel('FacturasCuerposItems');
		/*$this->paginate = [
            'contain'=>['Comprobantes'],
        ];*/
		
		if (!empty($listaarray))
		{
		$query = $this->FacturasCabeceras->find('all')	
					->contain(['FacturasCuerposItems','Comprobantes','FacturasCuerposItems.Articulos'])
					->hydrate(false)
				
					->join([
					'c'=>[
						'table'=>'comprobantes',
						'type'=>'INNER',
						'conditions'=>'FacturasCabeceras.comprobante_id = c.id',
					],
					'ci'=>[
						'table'=>'facturas_cuerpos_items',
						'type'=>'INNER',
						'conditions'=>'FacturasCabeceras.id = ci.facturas_encabezados_id',
					],
				
					])
					->where(['FacturasCabeceras.cliente_id'=>$this->request->session()->read('cliente_id'),'c.id in '=>$listaarray])
					->order(['FacturasCabeceras.fecha'=>'ASC'])
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
			$this->Flash->error(__('Seleccione algun comprobante'),['key'=>'changepass']);
			$this->redirect($this->referer());
		}
			
		
		$this->request->session()->write('facturascabeceras2',$facturascabeceras);
		$nombrearhivodirectorio = 'temp'. DS;

		if ($this->request->session()->read('Auth.User.cliente_id')!=$this->request->session()->read('cliente_id'))
		{
			$this->loadModel('Clientes');
			$client = $this->Clientes->get($this->request->session()->read('cliente_id'));		
			$codigo = str_pad($client['codigo'], 6, "0", STR_PAD_LEFT);
			$nombre = $client['nombre'];

		}
		else
		{
			$codigo = str_pad($this->request->session()->read('Auth.User.codigo'), 6, "0", STR_PAD_LEFT);
			$nombre = $this->request->session()->read('Auth.User.razon');
		}
		$nombrearhivodirectorio = 'temp'. DS;
		$nombrearhivo = 'DETFAC'.$codigo.'.TXT';
		
		
		$file = new File($nombrearhivodirectorio.$nombrearhivo, true, 0777);
		
		 
		if (is_null($facturascabeceras))
		{
			$this->Flash->error(__('Seleccione una opcion'),['key'=>'changepass']);
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
				$item .= str_pad($nombre, 30, " ", STR_PAD_RIGHT).$espacio;
				$item .= 'AUT'.$espacio;  
				$imp = (int)($fc['imp_gravado']*100);
				
				$item .= str_pad($imp, 15, "0", STR_PAD_LEFT).$espacio;
				$imp = (int)($fc['imp_exento']*100);
				$item .= str_pad($imp, 15, "0", STR_PAD_LEFT).$espacio;
				$imp = (int)($fc['imp_iva']*100);
				//$imp = number_format($fc['imp_iva'],2,'.','');
				$item .= str_pad($imp, 13, "0", STR_PAD_LEFT).$espacio;
				$imp = (int)($fc['imp_rg3337']*100);
				$item .= str_pad($imp, 13, "0", STR_PAD_LEFT).$espacio;
				$imp = (int)($fc['imp_ingreso_bruto']*100);
				$item .= str_pad($imp, 13, "0", STR_PAD_LEFT).$espacio;
				$imp = (int)($fc['total']*100);
				//$imp = number_format($fc['total'],2,'.','');
				
				$item .= str_pad($imp, 15, "0", STR_PAD_LEFT).$espacio;
				$item .= date_format($fc['fecha'],'dmY').$espacio;
				$item .= str_pad($fc['pedido_ds'], 6, "0", STR_PAD_LEFT).$espacio;
				if (!is_null($fc['fecha_vencimiento']))
				$item .= date_format($fc['fecha_vencimiento'],'dmY');
				else
				$item .= date_format($fc['fecha'],'dmY');
				
				$file->write($item."\r\n");
				foreach ($fc['facturas_cuerpos_items'] as $fci): 
					$itemart = 'D'.$espacio;	
					$itemart .= $codigo.$espacio;
					$itemart .= str_pad($fc['comprobante']['seccion'], 4, "0", STR_PAD_LEFT);
					$itemart .= $fc['letra'];
					$itemart .= str_pad($fc['comprobante']['numero'], 8, "0", STR_PAD_LEFT).$espacio;
						
					$itemart .= str_pad('0'.$fci['articulo']['categoria_id'], 2, "0", STR_PAD_LEFT).$espacio;
					
					$itemart .= str_pad($fci['codigo_barra'], 13, "0", STR_PAD_LEFT).$espacio;
					//$itemart .= str_pad($fci['articulo']['codigo_barras'], 13, "0", STR_PAD_LEFT).$espacio;
					
					$itemart .= str_pad($fci['descripcion'], 30, " ", STR_PAD_RIGHT).$espacio;
					
					if ($fci['iva'])
					$itemart .= '1';
					else
					$itemart .= '0';
					
					$itemart .= $espacio. str_pad($fci['cantidad_facturada'], 6, "0", STR_PAD_LEFT).$espacio;
					//$imp = $fci['precio_unitario'];
					$imp = (int)($fci['precio_unitario']*100);// number_format($fci['precio_unitario'],2,'.','');
					$itemart .= str_pad($imp, 13, "0", STR_PAD_LEFT).$espacio;
					$imp = (int)($fci['precio_publico']*100);//$imp = number_format($fci['precio_publico'],2,'.','');
					//$imp = $fci['precio_publico'];
					$itemart .= str_pad($imp, 11, "0", STR_PAD_LEFT).$espacio;
					
					$imp = (int)($fci['precio_total']*100);//number_format($fci['precio_total'],2,'.','');
					//$imp = $fci['precio_total'];
					$itemart .= str_pad($imp, 15, "0", STR_PAD_LEFT).$espacio;

					$descuento = $fci['descuento']*100;
					$itemart .= str_pad($descuento, 5, "0", STR_PAD_LEFT).$espacio;
					
					$file->write($itemart."\r\n");
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
			['download'=>true, 'name'=>$nombrearhivo]
			);

			return $this->response;
		}	
	}
}
