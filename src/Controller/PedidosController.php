<?php
namespace App\Controller;

use Cake\ORM\Query;
use App\Controller\AppController;
use Cake\Log\Log;
use App\Model\Entity\Pedido;
use Cake\Database\Connection;
use Cake\Datasource\ConnectionManager;
use Cake\I18n\Time;
use Cake\Filesystem\File;
/**
 * Pedidos Controller
 *
 * @property \App\Model\Table\PedidosTable $Pedidos
 */
class PedidosController extends AppController
{
	public function isAuthorized()
    {
           if (in_array($this->request->action, ['index_admin','duplicate_admin','view_admin','view_admin_new','index_admin_search','impreso','pami_admin','pami_admin_search','index_admin_reporte','reportPedidosExcel','importresultredirect','importresultventas','confirmpedidojax','index_admin_new'])) {
       
            if($this->request->session()->read('Auth.User.role')=='admin') 	
			return true;			
            else 
				if($this->request->session()->read('Auth.User.role')=='adminS') 	
                return true;			
            else 
				$this->Flash->error(__('No tiene permisos para ingresar'),['key' => 'changepass']);
				return false;
			}
			else
			{
				
			
				if (in_array($this->request->action, ['index','edit', 'carritoadd','delete','add','downloadfilefaltastxt','confirmarpedido','search','import','faltas','view','searchproduct','downloadfiletxt','expo','index_admin_reporte','reportPedidosExcel','importresultredirect','importresultventas']))			
				{
					if($this->request->session()->read('Auth.User.role')=='client') 
					{
						$tiene= $this->tienepermiso('pedidos',$this->request->action);
						if (!$tiene)
							$this->Flash->error(__('No tiene permisos para ingresar'),['key' => 'changepass']);
						return $tiene;	
						
					}
								
					else
					{
						$this->Flash->error(__('No tiene permisos para ingresar'),['key' => 'changepass']);
						return false;
					}	
					
				}
				else
				{
					$this->Flash->error(__('No tiene permisos para ingresar'),['key' => 'changepass']);
					return false;	
				}
	
			}
				
		return parent::isAuthorized($user);
    }
	
	/*
	public function sumacarrito()
	{
		$this->loadModel('Carritos');
		$carritocon = $this->Carritos->find('all')
					->where(['Carritos.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
					->order(['Carritos.id' => 'DESC']);
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
	}*/
	public function importresultventas()
	{
		$this->viewBuilder()->layout('ajax');
		if ($this->request->is(['ajax', 'post'])) {

			$this->request->allowMethod(['ajax', 'post']);


		}$this->response->type('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	}

		public function importresultredirect()
	{
		
		$this->viewBuilder()->layout('admin');
	//$this->response->type('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
return $this->redirect(['action' => 'importresultventas']);
	
	}
	public function sumacarrito()
	{
		$this->loadModel('Carritos');
		$carritocon = $this->Carritos->find('all')
					->contain(['Articulos'])
					->where(['Carritos.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
					->order(['Carritos.id' => 'DESC']);
		$this->set('carritos', $carritocon->toArray());
		
		$descuento_pf = $this->request->session()->read('Auth.User.pf_dcto');
		$condicion 	  = $this->request->session()->read('Auth.User.condicion');
		$coef         = $this->request->session()->read('Auth.User.coef');
		
		$totalcarrito=0;
		$totalitems=0;
		$totalunidades=0;			
		foreach ($carritocon as $carrito): 
			$totalitems+=1;
			/*if ($carrito['tipo_precio']=="P")
				$totalcarrito= $totalcarrito + $carrito['cantidad']*$carrito['precio_publico'];
			else
				$totalcarrito= $totalcarrito + $carrito['cantidad']*round(h($carrito['precio_publico'])*$descuento_pf, 3);*/
			$totalunidades= $totalunidades + $carrito['cantidad'];
			
			$cant_carrito=$carrito['cantidad'];
			$subtotal = 0;
//MEDICAMENTOS
if (($carrito['categoria_id'] !=5) && ($carrito['categoria_id'] !=4)  && ($carrito['categoria_id'] !=3) &&($carrito['categoria_id'] !=2))
{
	if ($carrito['categoria_id'] ===1)	  $coef2 = 1; else $coef2 = $coef; 
	if ($carrito['articulo']['laboratorio_id']===15) $coef2 = 0.892; 
	
	
	//DESCUENTOS
	if ($carrito['descuento']>0)
	{
		//TIPO_VENTA=D
		if ($carrito['tipo_oferta_elegida']=='D')
		{
		$cant_uni_min = $carrito['unidad_minima'];
		//TIPO_PRECIO P
		if ($carrito['tipo_precio']=='P')
		{
			
			 if ($cant_carrito>=$cant_uni_min)
			 {
				$descuentooferta = $carrito['descuento'];
				$precio = $carrito['precio_publico']*$coef2;
				$precio -=$precio*$descuentooferta/100;
				$subtotal = $precio * $cant_carrito;
			 }
			 else
			 {
				$precio  = $carrito['precio_publico'];
				$precio  = $precio*$descuento_pf*$coef2;
				$precio -= $precio*$condicion/100;
				$subtotal = $precio*$cant_carrito; 
			 }
		}
		
		else
		{
		//TIPO_PRECIO F
			if ($carrito['tipo_precio']=='F')
			{
				$precio = $carrito['precio_publico']/(1.21);
					
				if ($cant_carrito>=$cant_uni_min)
				{
					$descuentooferta = $carrito['descuento'];
					$precio  = $precio*$descuento_pf * $coef2;
					$precio -= $precio*$condicion/100;
					$precio -= $precio*$descuentooferta/100;
					$subtotal = $precio*$cant_carrito;
				}
				else
					$subtotal = $carrito['precio_publico']*$descuento_pf*$coef2*$cant_carrito; 
			}
		}
		}
		else
		{
			$precio = $carrito['precio_publico']*$descuento_pf*$coef2;
			if ($carrito['articulo']['msd']!=1){
				$precio -= $precio*$condicion/100;
			}			
			$subtotal = $precio * $cant_carrito;
			
		}
	}
	else
	{
		$precio = $carrito['precio_publico']*$descuento_pf*$coef2;
			if ($carrito['articulo']['msd']!=1){
				$precio -= $precio*$condicion/100;
			}			
			$subtotal = $precio * $cant_carrito;
	}
	
	if ($carrito['articulo']['cadena_frio']==1 && $carrito['articulo']['subcategoria_id']!=10) 
		$subtotal = $subtotal*1.0248;
}
else
{
	if ($carrito['descuento']>0){ 				
	if ($carrito['tipo_oferta_elegida']=='D')
	{
		$cant_uni_min = $carrito['unidad_minima'];
		if ($cant_carrito>=$cant_uni_min)
		{
			$descuentooferta = $carrito['descuento'];
			$precio = $carrito['precio_publico'];
			if ($carrito['tipo_precio']=='P')
			{
				$precio -=$precio*$descuentooferta/100;
			}
			if ($carrito['tipo_precio']=='F')
			{
				$precio = $precio*$descuento_pf;
				//$precio -= $precio*$condicion/100;
				$precio -=$precio*$descuentooferta/100;
			}	
				$subtotal = $precio * $cant_carrito;
		}
		else
		{
			$precio = $carrito['precio_publico']*$descuento_pf;
			if ($coef !=1)	$precio = $precio*$coef;
				$subtotal = $precio * $cant_carrito;
		}
			
	}
	}
	else	
	{
		
		$precio = $carrito['precio_publico']*$descuento_pf*$coef;
		$subtotal = $precio * $cant_carrito;
	}
}
		$totalcarrito= $totalcarrito +$subtotal;
			
			
			
		endforeach; 
		$this->set('totalitems',$totalitems);
		$this->set('totalcarrito',$totalcarrito);
		$this->set('totalunidades',$totalunidades);
		$this->set('carritos', $carritocon->toArray());
		return $carritocon;
	}
	
	public function sumaexpoimporte()
	{
	

		$this->loadModel('PedidosPreventasItems');
		
	        
		$articulosX = $this->PedidosPreventasItems->find('all')
									
				->contain(['PedidosPreventas'=> [
					'queryBuilder' => function ($q) {
						return $q->where(['PedidosPreventas.id = pedidos_preventa_id ']); // Full conditions for filtering
					}
				]/*,'Articulos.Preventas'=> [
					'queryBuilder' => function ($q) {
						return $q->where(['Preventas.id = articulo_id']); // Full conditions for filtering
					}
				]*/
				,'Articulos' => [
						'queryBuilder' => function ($q) {
							return $q->where(['Articulos.id = articulo_id']); // Full conditions for filtering
						}
					]
				])
				->where([
						'Articulos.eliminado'=>0,'PedidosPreventas.cliente_id'=>$this->request->session()->read('Auth.User.cliente_id'),
						]);
		

		$this->set('articulosX', $articulosX->toArray());
		
		$total_items=0;
		$total_unidades=0;			
		$total_importe =0;
		$total_importe_stock =0;

		$descuento_pf = $this->request->session()->read('Auth.User.pf_dcto');
		$descuento_pf2= $descuento_pf;
		$condicion 	  = $this->request->session()->read('Auth.User.condicion');
		$coef         = $this->request->session()->read('Auth.User.coef');
		$condiciongeneral = 100*(1-($descuento_pf * (1-$condicion/100)));

		foreach ($articulosX as $item): 
			$total_items+=1;
			
			if (!empty($item['articulo']))
			{
			$cantidad  = $item['cantidad'];
			$descuento = $item['descuento'];
			$categoria = $item['articulo']['categoria_id'];
			$p_publico = $item['articulo']['precio_publico'];
			$t_precio  = $item['tipo_precio'];
			$iva 	   = $item['articulo']['iva'];

			$total_unidades += $cantidad;

			$subtotal_importe = 0;
			
			//MEDICAMENTOS
			if (($categoria !=5) && ($categoria !=4)  && ($categoria !=3) &&($categoria !=2))
				{
					if ($categoria ===1)	  
						$coef2 = 1; else $coef2 = $coef; 
					
					//DESCUENTOS
					if ($descuento>0)
					{
						
						//TIPO_VENTA=P
						if ($t_precio==='P')
						{
								$precio = $p_publico*$coef2;
								$precio -=$precio*$descuento/100;
								
						}
						
						//TIPO_PRECIO F
						if ($t_precio==='F')
						{
							
							if ($iva ==1) 
								{$precio = $p_publico/(1.21);}
								
								$precio  = $precio*$descuento_pf * $coef2;
								$precio -= $precio*$condicion/100;
								$precio -= $precio*$descuento/100;
								
							
						}
						$subtotal_importe = $precio*$cantidad;
					}
					else
					{
						$precio = $p_publico;
						$precio -= $precio*($condiciongeneral-1)/100;
						$subtotal_importe = $precio*$cantidad;
					}
					

				}
			else
				{
				$precio = $p_publico;
				if ($descuento>0)
				{ 	
					
					if ($t_precio=='P')
					{
						$precio -=$precio*$descuento/100;
					}
					if ($t_precio=='F')
					{
						$precio = $precio*$descuento_pf;
						//$precio -= $precio*$condicion/100;
						$precio -=$precio*$descuento/100;
					}	
					
					

				}
				else
					$precio = $precio*$descuento_pf;
				
				$subtotal_importe = $precio * $cantidad;

			}
			$total_importe+= $subtotal_importe;
		}


		endforeach; 
		$this->set('total_items',$total_items);
		$this->set('total_unidades',$total_unidades);
		$this->set('total_importe', $total_importe);
		//$this->set('carritos', $carritocon->toArray());
		return $articulosX;
	}

	public function expo()
	{
		$this->viewBuilder()->layout('store');
       
        if ($this->request->is('post')) {
				
			
        }
		$this->loadModel('PedidosPreventas');
		$pedido = $this->PedidosPreventas->find('all')
		->contain(['Clientes'=> [
						
						'queryBuilder' => function ($q) {
							return $q->where(['cliente_id = Clientes.id ']); // Full conditions for filtering
						}
					]])
				->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')	])->first([]);
			
			
		
		$cliente = $pedido['cliente'];	
			$this->set('cliente',$cliente);
		
		$this->loadModel('PedidosPreventasItems');
		
	        
		$articulosA = $this->PedidosPreventasItems->find('all')
									
				->contain(['PedidosPreventas','PedidosPreventas.Clientes'=> [
						
						'queryBuilder' => function ($q) {
							return $q->where(['PedidosPreventas.cliente_id = Clientes.id ']); // Full conditions for filtering
						}
					],			
				'Articulos.Laboratorios','Articulos.Preventas','Articulos' => [
						
						'queryBuilder' => function ($q) {
							return $q->where(['Articulos.id = articulo_id']); // Full conditions for filtering
						}
					]
				])				
					->where([
						'PedidosPreventas.cliente_id'=>$this->request->session()->read('Auth.User.cliente_id'),
						'Articulos.eliminado'=>0]);
		


						$this->sumaexpoimporte();	
		if (!empty($articulosA))
		{
		
			
		
			$this->paginate = [		
				'limit' => 900,
				'maxLimit' => 900,
			'offset' => 0, 
			];
			//'order' => ['Articulos.descripcion_pag' => 'asc']andWhere(['Articulos.eliminado'=>0])-
			$articulosA->order(['Laboratorios.nombre'=>'asc','Articulos.descripcion_pag' => 'asc']);
			$articulos = $this->paginate($articulosA);
		}
		else
			$articulos = null;
		
	
		
		$this->categoriaylaboratorio();
		$cliente = $this->request->session()->write('cliente',$cliente);	
        $this->set(compact('articulos'));
		
	}
	
	public function clientecredito()
	{
		$this->loadModel('ClientesCreditos');
	  /*   if ($this->request->session()->read('Auth.User.cliente_id') !=36231)
			 $cliente = $this->request->session()->read('Auth.User.cliente_id');
		 else
			 $cliente = 36230;
		*/
		$cliente = $this->request->session()->read('Auth.User.cliente_id');
		$clientecreditos = $this->ClientesCreditos->find('all')	->where(['cliente_id' => $cliente]);
		$clientecredito = $clientecreditos->first();
		
		if (is_null($clientecredito))
		{
			$this->loadModel('Clientes');
			$cliente= $this->Clientes->find('all')->where(['codigo'=>$this->request->session()->read('Auth.User.codigo'),'id not in'=>$this->request->session()->read('Auth.User.cliente_id')])->first();
		
			$clientecreditos = $this->ClientesCreditos->find('all')->where(['cliente_id' => $cliente['id']]);
			$clientecredito = $clientecreditos->first();

		}
		
		$creditodisponible = $clientecredito['credito_maximo']-$clientecredito['credito_consumo'];



		if ($creditodisponible<0)
			$creditodisponible =0;

			
		$this->set('creditodisponible',$creditodisponible);
		
		$this->request->session()->write('creditodisponible',$creditodisponible);

		if ($clientecredito['compra_minima']!=null)
				$this->request->session()->write('compra_minima',$clientecredito['compra_minima']);		
			else
				$this->request->session()->write('compra_minima',1500);		
	}
	
	public function categoriaylaboratorio()
	{
		if ($this->request->session()->read('Categorias')== null)
		{
		$this->loadModel('Categorias');
		$this->loadModel('Laboratorios');
		$categorias = $this->Categorias->find('list',['keyField' => 'id','valueField'=>'nombre']);
		$laboratorios = $this->Laboratorios->find('list',['keyField' => 'id','valueField'=>'nombre'])->order(['nombre' => 'ASC']);

		$this->request->session()->write('Categorias',$categorias->toArray());
		$this->request->session()->write('Laboratorios',$laboratorios ->toArray());
			
		}
		else{
			
			$laboratorios =$this->request->session()->read('Laboratorios');
			$categorias = $this->request->session()->read('Categorias');
		}	
		$this->set('categorias',$categorias );
		$this->set('laboratorios',$laboratorios);
		
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
			'limit' => 100,
			'maxLimit' => 100,
            'contain' => ['Clientes']
        ];
		$fecha = Time::now();
		$fech = $fecha->modify('-'.(date("w")-1).' days');
		$fecha = Time::now();
		$fecha->modify('+ 1 days');
		$fech2= $fecha->i18nFormat('yyyy-MM-dd');
				
		//echo $fecha->format('Y-m-d') . "\n";
		
		$pedidos = $this->Pedidos->find('all')
								->where(['Pedidos.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
								->andWhere(['Pedidos.creado BETWEEN :start AND :end'])
								->bind(':start', $fech, 'date')
								->bind(':end',   $fech2, 'date')
								->order(['Pedidos.id' => 'DESC']);
								/*->andWhere(["Pedidos.creado BETWEEN '".$fechadesde2->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta2->i18nFormat('yyyy-MM-dd')."'"])
								->group('Pedidos.id');*/
								
		//debug( date('Y-m-d', strtotime('+1 day')));
		$this->loadModel('Estados');
		$estados=$this->Estados->find('all');
		$this->set('estados', $estados->toArray());
		//debug($this->paginate($pedidos));
        $this->set('pedidos', $this->paginate($pedidos));
        $this->set('_serialize', ['pedidos']);
		
		
		$this->clientecredito();
		$this->sumacarrito();

    }

	public function downloadfiletxt($id = null)
    {
		$this->viewBuilder()->layout('store');

		$this->loadModel('PedidosItems');

        $pedidositems =$this->PedidosItems->find()
		 ->contain(['Articulos'])
		 ->where(['pedido_id'=>$id])
		 ->order(['Articulos.descripcion_pag' => 'ASC']);

		if ($pedidositems->isEmpty())
		{ $this->Flash->error(__('Momentaneamente no disponible, intente mas tarde.'),['key' => 'changepass']);
			$this->redirect($this->referer());}
		else
		{		
			
			$nombreArchivo= 'respuesta'.
			//$this->request->session()->read('Auth.User.codigo').
			str_pad($this->request->session()->read('Auth.User.codigo'), 6, "0", STR_PAD_LEFT).
			str_pad($id, 8, "0", STR_PAD_LEFT);
			$file = new File('temp'. DS .'Comprobantes'. DS .$nombreArchivo.'.TXT', true, 0777);
			$file->write("\n",'w');
			foreach ($pedidositems as $row): 
			
				$line = 
						str_pad($row['cantidad'], 4, "0", STR_PAD_LEFT).
						str_pad($row['cantidad_facturada'], 4, "0", STR_PAD_LEFT).
						str_pad($row['articulo']['codigo_barras'], 13," ").
						str_pad($row['articulo']['troquel'], 8, " ").
						str_pad($row['articulo']['descripcion_sist'], 30).
						str_pad($row['pedidos_items_status_id'], 2,0,STR_PAD_LEFT).
						"\r\n";
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
	
	
	public function search()
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
				$termino = '%'.$this->request->data['terminobuscar'].'%';
			}	
			else
			{
				$termino ="";
			}	
			$this->request->session()->write('termino',$termino);
			$this->request->session()->write('fechadesde',$fechadesde);	
			$this->request->session()->write('fechahasta',$fechahasta);
		}
		else 
		{
			$fechahasta = $this->request->session()->read('fechahasta');
		    $fechadesde = $this->request->session()->read('fechadesde');
			$termino = $this->request->session()->read('termino');
		}
		
        $this->paginate = [		
		'limit' => 100,
		'maxLimit' => 100,
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
			$fechahasta2-> i18nFormat('yyyy-MM-dd');
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


	  	if ($termino!="")
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
				'estado_id',
				'nro_pedido_ds',
				'impreso',
				'pedidos_status_id'])
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
				
				->where(['a.descripcion_pag LIKE'=>$termino])
				->orWhere(['a.troquel LIKE'=>$termino])
				->andWhere(["Pedidos.creado BETWEEN '".$fechadesde2->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta2->i18nFormat('yyyy-MM-dd')."'"])
				->where(['Pedidos.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
				->group('Pedidos.id');
	
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
				'estado_id',
				'impreso',
				'nro_pedido_ds',
				'pedidos_status_id'])
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
				->where(['a.descripcion_pag LIKE'=>$termino])
				->orWhere(['a.troquel LIKE'=>$termino])
				->andWhere(["Pedidos.creado BETWEEN '".$fechadesde2->i18nFormat('yyyy-MM-dd')."' AND '".$fechadesde2->i18nFormat('yyyy-MM-dd')."'"])
				->group('Pedidos.id');
				
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
					'estado_id',
					'impreso',
				'nro_pedido_ds',
				'pedidos_status_id'])
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
					->where(['a.descripcion_pag LIKE'=>$termino])
					->orWhere(['a.troquel LIKE'=>$termino])
					->group('Pedidos.id');
				}	
			}
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
					'estado_id',
					'impreso',
				'nro_pedido_ds',
				'pedidos_status_id'])
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
				->andWhere(["Pedidos.creado BETWEEN '".$fechadesde2->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta2->i18nFormat('yyyy-MM-dd')."'"])
				->group('Pedidos.id');
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
		
		$this->clientecredito();
		$this->sumacarrito();
    }

	
	
    /**
     * View method
     *
     * @param string|null $id Pedido id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
/*		$this->viewBuilder()->layout('store');
      
        $pedido = $this->Pedidos->get($id, [
		          
			
            'contain' => ['Clientes']
        ]);
		


		$this->loadModel('PedidosItems');

        $this->set('pedido', $pedido);
        $this->set('_serialize', ['pedido']);
		$this->set('titulo','Vista del Pedidos');
		$this->paginate = [
			
			'limit' => 500,
			'maxLimit' => 1000,   
			
			'order' => ['Articulos.descripcion_pag' => 'ASC'],
            'contain' => ['Pedidos', 'Articulos']
        ];
		
        $this->set('pedidosItems', $this->paginate($this->PedidosItems->find()->where(['pedido_id'=>$id])->order(['Articulos.descripcion_pag' => 'ASC'])));
		$this->set('_serialize', ['pedidosItems']);
		
*/


		$this->viewBuilder()->layout('store');
		$pedido =  $this->Pedidos->find()->contain(['Clientes'])->where(['Pedidos.id'=>$id,'Pedidos.cliente_id'=>$this->request->session()->read('Auth.User.cliente_id')])->first();
		//$this->request->session()->write('pedidox',$pedido);
		
		if (is_null($pedido))
		{
		$this->Flash->error(__('No se pudo encontrar el pedido'),['key' => 'changepass']);
		//return $this->redirect($this->referer());
		return $this->redirect(['controller'=>'Pedidos','action' => 'index']);
		}
		else
		{
		$this->loadModel('PedidosItems');

        $this->set('pedido', $pedido);
        $this->set('_serialize', ['pedido']);
		$this->set('titulo','Vista del Pedidos');
		$this->paginate = [
			
			'limit' => 500,
			'maxLimit' => 1000,   
			
			'order' => ['Articulos.descripcion_pag' => 'ASC'],
            'contain' => ['Pedidos', 'Articulos']
        ];
		
        $this->set('pedidosItems', $this->paginate($this->PedidosItems->find()->where(['pedido_id'=>$id])->order(['Articulos.descripcion_pag' => 'ASC'])));
		$this->set('_serialize', ['pedidosItems']);
		}

    }

    /**
     * Add method
	 * Envia genera el pedido, separa cada uno de
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function addOld()
    {
		$this->viewBuilder()->layout('store');
		$this->loadModel('Carritos');
		$carritocon = $this->Carritos->find('all')	
					->where(['Carritos.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]);
		$sumacarrito = $this->request->data['compra'];
		$this->request->session()->write('sumacarrito',$sumacarrito);
		/*
		foreach ($carritocon as $carrito) {
		
		if (($carrito['cantidad']=='0') || ($carrito['cantidad']!=''))
		{
			$carritosTemp = $this->Carritos->get($carrito['id']);
			
			if ($this->Carritos->delete($carritosTemp)) {
			//$this->Flash->success('Se elimino el producto de los importados.',['key' => 'changepass']);
			}
		}
		}
		*/
		
		if ($this->request->session()->read('Auth.User.habilitado')==0)
		{
			$this->loadModel('Clientes');
			$cliente= $this->Clientes->get($this->request->session()->read('Auth.User.cliente_id'));
			$this->request->session()->write('Auth.User.habilitado',$cliente['habilitado']);
			$this->request->session()->write('Auth.User.coef',$cliente['coeficiente']);
			$this->request->session()->write('Auth.User.condicion',$cliente['condicion_descuento']);
			if ($this->request->session()->read('Auth.User.habilitado')==0)
			{
			$this->Flash->error(__('La cuenta se encuentra momentáneamente suspendida - Por favor comuníquese con el sector cobranzas - (0291) 458 3051/52/53'),['key' => 'changepass']);
			return $this->redirect($this->referer());
			}
		}
		if ($sumacarrito<$this->request->session()->read('compra_minima'))
		{
			
			$fechahasta = Time::now();
			$fechahasta->modify('+1 days');
			$fechahasta->i18nFormat('yyyy-MM-dd');
		
			$fechadesde = Time::now();
			$fechadesde->i18nFormat('yyyy-MM-dd');

			$pedidos = $this->Pedidos->find('all')
			->select(['id'])
			->where(["cliente_id"=>$this->request->session()->read('Auth.User.cliente_id'),"Pedidos.creado BETWEEN '".$fechadesde->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta->i18nFormat('yyyy-MM-dd')."'"]);
			
			//->order(['Pedidos.id' => 'DESC']);
			if ($pedidos->isEmpty())
			{
				$this->Flash->error(__('*El monto de la compra no supera los $'.$this->request->session()->read('compra_minima')),['key' => 'changepass']);
				return $this->redirect($this->referer());

			}

			//$this->Flash->error(__('El monto de la compra no supera los $'.$this->request->session()->read('compra_minima')),['key' => 'changepass']);
			//return $this->redirect($this->referer());
		}
		if ($sumacarrito>$this->request->session()->read('creditodisponible'))
		{
			$this->Flash->error(__('LA COMPRA SUPERA SU CREDITO DISPONIBLE. SALDO INSUFICIENTE.'),['key' => 'changepass']);
			return $this->redirect($this->referer());
		}
		//$this->Flash->error(__('En estos momentos nos encontramos actualizando esta sección, intente en 5 minutos. Disculpe las molestias'),['key' => 'changepass']);
		//return $this->redirect($this->referer());
		
		if ($carritocon->count()>0)
		{
			$conn = ConnectionManager::get('default');
			$cliente_id=$this->request->session()->read('Auth.User.cliente_id');
			$cliente_cod= $this->request->session()->read('Auth.User.codigo');
			$envio = $this->request->data['enviodomicilio'];
			$comentario = $this->request->data['observaciones'];
			$fecha = date('Y-m-d H:i:s');
			$conn->query('CALL CopiarCarrito('.$cliente_id.');');
			$conn->query('CALL actualizarcarritosindescuento('.$cliente_id.');');
			
			if ($this->request->session()->read('Auth.User.codigo_postal')==9405 || $this->request->session()->read('Auth.User.codigo_postal')==9410 || $this->request->session()->read('Auth.User.codigo_postal')==9420)
			{	
				//Cliente de la Isla	
				//$this->loadModel('Clientes');
				//$cliente_export_id = $cliente_id;
				//$cliente_comun_id = $cliente_id;
				/*$Clientes = $this->Clientes->find('all')
						->Select(['Clientes.id','Clientes.codigo','Clientes.nombre','ce.cliente_export_id','ce.cta_comun','ce.cliente_comun_id'])
						->join(['ce' => ['table' => 'clientes_exports','type' => 'INNER','conditions' => 'ce.cliente_export_id = Clientes.id OR ce.cliente_comun_id = Clientes.id']])
						->where(['Clientes.id'=>$cliente_id]);
					foreach ($Clientes as $opcion) {
						$cliente_export_id= $opcion['ce']['cliente_export_id']; 
						$cliente_comun_id= $opcion['ce']['cliente_comun_id'];
					}
					
				*/	
				if ($this->request->session()->read('Auth.User.codigo_postal')==9405)	
				
				{
					$cliente_comun_id = $cliente_id;
					$cliente_export_id= $cliente_id;
				}
				/*
				if ($cliente_comun_id == 0)
				{
					$this->Flash->error(__('Existio un error, por favor comunicarse con sistemas.'),['key' => 'changepass']);
					return $this->redirect($this->referer());
				}
				if ($cliente_export_id == 0)
				{
					$this->Flash->error(__('Existio un error, por favor comunicarse con sistemas.'),['key' => 'changepass']);
					return $this->redirect($this->referer());
				}*/
				
				//Separo los items el Tipo Oferta TR
				$carritotr = $this->Carritos->find('all')->select(['plazoley_dcto'])->distinct(['plazoley_dcto'])
						->where(['Carritos.cliente_id' => $cliente_id])
						->andWhere(['Carritos.tipo_fact'=>'TR']);
				if ($carritotr->count()>0)		{
					//$this->request->session()->write('plazo',$carritotr->toArray());
					foreach ($carritotr as $carrito): 
						$plazo = $carrito['plazoley_dcto'];

						//AgregarPedidoTDF`(IN cliente_id INT, IN sucursal_id INT, IN envio INT,IN fecha DATETIME,IN tipo_factura VARCHAR(2),IN comentario VARCHAR(200),IN oferta_plazo VARCHAR(10), IN normal INT)
						$conn->query('CALL AgregarPedidoTDF('.$cliente_id.','.$envio.','.$envio.',"'.$fecha.'","TR","'.$comentario .'","'.$plazo.'",0);');
						//$conn->query('CALL AgregarPedidoIsla('.$cliente_id.','.$cliente_comun_id.','.$cliente_export_id.','.$envio.','.$envio.',"'.$fecha.'","TR","'.$comentario .'","'.$plazo.'",0,0);');
					endforeach;			}
				// Separo los items el Tipo Oferta TL
				$carritotl = $this->Carritos->find('all')->select(['plazoley_dcto'])->distinct(['plazoley_dcto'])
						->where(['Carritos.cliente_id' => $cliente_id])
						->andWhere(['Carritos.tipo_fact'=>'TL']);
				if ($carritotl->count()>0)		{
					//$this->request->session()->write('plazo2',$carritotl->toArray());
					foreach ($carritotl as $carrito): 
						
						if ($carrito['articulo_id']>27338 && $carrito['articulo_id']<27344)
							$comentario='P.PAMI';
						
					
						$plazo = $carrito['plazoley_dcto'];
						$conn->query('CALL AgregarPedidoTDF('.$cliente_id.','.$envio.','.$envio.',"'.$fecha.'","TL","'.$comentario .'","'.$plazo.'",0);');
						//$conn->query('CALL AgregarPedidoIsla('.$cliente_id.','.$cliente_comun_id.','.$cliente_export_id.','.$envio.','.$envio.',"'.$fecha.'","TL","'.$comentario .'","'.$plazo.'",0,0);');
					endforeach;		}

				// Separo los items el Tipo Oferta N
				$carriton = $this->Carritos->find('all')->select(['plazoley_dcto'])->distinct(['plazoley_dcto'])
						->where(['Carritos.cliente_id' => $cliente_id])
						->andWhere(['Carritos.tipo_fact'=>'N']);
				if ($carriton->count()>0)		{
						$plazo = 'HABITUAL';
						$conn->query('CALL AgregarPedidoTDF('.$cliente_id.','.$envio.','.$envio.',"'.$fecha.'","N","'.$comentario .'","'.$plazo.'",1);');
						//$conn->query('CALL AgregarPedidoIsla('.$cliente_id.','.$cliente_comun_id.','.$cliente_export_id.','.$envio.','.$envio.',"'.$fecha.'","N","'.$comentario .'","'.$plazo.'",0,1);');
				}		
			}
			else
			{	// Cliente QUE no es de la isla
				//Separo los items el Tipo Oferta TR
				$carritotr = $this->Carritos->find('all')->select(['plazoley_dcto'])->distinct(['plazoley_dcto'])
						->where(['Carritos.cliente_id' => $cliente_id])
						->andWhere(['Carritos.tipo_fact'=>'TR']);
				if ($carritotr->count()>0)		{
					
					foreach ($carritotr as $carrito): 
						$plazo = $carrito['plazoley_dcto'];
						$conn->query('CALL AgregarPedido('.$cliente_id.','.$cliente_id.','.$envio.','.$envio.',"'.$fecha.'","TR","'.$comentario .'","'.$plazo.'",0,0);');
					endforeach;			}
				// Separo los items el Tipo Oferta TL
				$carritotl = $this->Carritos->find('all')->select(['articulo_id','plazoley_dcto'])->distinct(['plazoley_dcto'])
						->where(['Carritos.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
						->andWhere(['Carritos.tipo_fact'=>'TL']);
				if ($carritotl->count()>0)
				{
					//$this->request->session()->write('plazo2',$carritotl->toArray());
					foreach ($carritotl as $carrito): 
					
						if ($carrito['articulo_id']>27338 && $carrito['articulo_id']<27344)
							$comentario2='P.PAMI '.$comentario;
						else
							$comentario2= $comentario;
						$plazo = $carrito['plazoley_dcto'];
						$conn->query('CALL AgregarPedido('.$cliente_id.','.$cliente_id.','.$envio.','.$envio.',"'.$fecha.'","TL","'.$comentario2 .'","'.$plazo.'",0,0);');
					endforeach;
				}
				
				/*
				$carritotl = $this->Carritos->find('all')->select(['plazoley_dcto'])->distinct(['plazoley_dcto'])
						->where(['Carritos.cliente_id' => $cliente_id])
						->andWhere(['Carritos.tipo_fact'=>'TL']);
				if ($carritotl->count()>0)		{
					
					foreach ($carritotl as $carrito): 
						$plazo = $carrito['plazoley_dcto'];
						$conn->query('CALL ConfirmarPedidoIsla('.$cliente_id.','.$cliente_id.','.$envio.','.$envio.',"'.$fecha.'","TL","'.$comentario .'","'.$plazo.'",0,0);');
					endforeach;		}*/
				// Separo los items el Tipo Oferta N
				$carriton = $this->Carritos->find('all')->select(['plazoley_dcto'])->distinct(['plazoley_dcto'])
						->where(['Carritos.cliente_id' => $cliente_id])
						->andWhere(['Carritos.tipo_fact'=>'N']);
				if ($carriton->count()>0)		{
					$plazo = 'HABITUAL';
					$conn->query('CALL AgregarPedido('.$cliente_id.','.$cliente_id.','.$envio.','.$envio.',"'.$fecha.'","N","'.$comentario .'","'.$plazo.'",0,1);');
				}		
				
					// Separo los items el Tipo Oferta N
				
				/*if ($carriton->count()>0)
				{
					
					foreach ($carriton as $carrito): 
						$plazo = $carrito['plazoley_dcto'];
						$conn->query('CALL AgregarPedido('.$cliente_id.','.$cliente_id.','.$envio.','.$envio.',"'.$fecha.'","N","'.$comentario .'","'.$plazo.'",0,0);');
					endforeach;
				}
				*/

			}
				
			$this->Flash->warning(__(' Se envio correctamente el pedido, Gracias por Elegirnos!'),['key' => 'changepass']);
			return $this->redirect(['controller'=>'Carritos','action' => 'index']);
		}
		else
		{
			$this->Flash->error(__('No tiene productos en el Carritos'),['key' => 'changepass']);
			$this->redirect($this->referer());
		}
    }
	
	public function add()
    {
		$this->viewBuilder()->layout('store');
		$this->loadModel('Carritos');
		$carritocon = $this->Carritos->find('all')	
					->where(['Carritos.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]);
		$sumacarrito = $this->request->data['compra'];
		$this->request->session()->write('sumacarrito',$sumacarrito);
	
		
		if ($this->request->session()->read('Auth.User.habilitado')==0)
		{
			$this->loadModel('Clientes');
			$cliente= $this->Clientes->get($this->request->session()->read('Auth.User.cliente_id'));
			$this->request->session()->write('Auth.User.habilitado',$cliente['habilitado']);
			$this->request->session()->write('Auth.User.coef',$cliente['coeficiente']);
			$this->request->session()->write('Auth.User.condicion',$cliente['condicion_descuento']);
			if ($this->request->session()->read('Auth.User.habilitado')==0)
			{
			$this->Flash->error(__('La cuenta se encuentra momentáneamente suspendida - Por favor comuníquese con el sector cobranzas - (0291) 458 3051/52/53'),['key' => 'changepass']);
			return $this->redirect($this->referer());
			}
		}
		if ($sumacarrito<$this->request->session()->read('compra_minima'))
		{
			
			$fechahasta = Time::now();
			$fechahasta->modify('+1 days');
			$fechahasta->i18nFormat('yyyy-MM-dd');
		
			$fechadesde = Time::now();
			$fechadesde->i18nFormat('yyyy-MM-dd');

			$pedidos = $this->Pedidos->find('all')
			->select(['id'])
			->where(["cliente_id"=>$this->request->session()->read('Auth.User.cliente_id'),"Pedidos.creado BETWEEN '".$fechadesde->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta->i18nFormat('yyyy-MM-dd')."'"]);
			
			
			if ($pedidos->isEmpty())
			{

				$this->loadModel('FacturasCabeceras');
				$facturascabeceras = $this->FacturasCabeceras->find('all')
				->where(['FacturasCabeceras.cliente_id' => $this->request->session()->read('Auth.User.cliente_id'),"FacturasCabeceras.fecha BETWEEN '" . $fechadesde->i18nFormat('yyyy-MM-dd') . "' AND '" . $fechahasta->i18nFormat('yyyy-MM-dd') . "'"])
	
				->order(['FacturasCabeceras.fecha' => 'ASC'])
				->group('FacturasCabeceras.pedido_ds');
				if ($facturascabeceras->isEmpty())
				{
					$this->Flash->error(__('*El monto de la compra no supera los $'.$this->request->session()->read('compra_minima')),['key' => 'changepass']);
					return $this->redirect($this->referer());
				}
			}

		
		}
		if ($sumacarrito>$this->request->session()->read('creditodisponible'))
		{
			$this->Flash->error(__('LA COMPRA SUPERA SU CREDITO DISPONIBLE. SALDO INSUFICIENTE.'),['key' => 'changepass']);
			return $this->redirect($this->referer());
		}
		
		
		if ($carritocon->count()>0)
		{
			$conn = ConnectionManager::get('default');
			$cliente_id=$this->request->session()->read('Auth.User.cliente_id');
			$cliente_cod= $this->request->session()->read('Auth.User.codigo');
			$envio = $this->request->data['enviodomicilio'];
			$comentario = $this->request->data['observaciones'];
			$fecha = date('Y-m-d H:i:s');
			$conn->query('CALL CopiarCarrito('.$cliente_id.');');
			$conn->query('CALL actualizarcarritosindescuento('.$cliente_id.');');
			
			if ($this->request->session()->read('Auth.User.codigo_postal')==9410 || $this->request->session()->read('Auth.User.codigo_postal')==9420)
			{	
				
				//Separo los items el Tipo Oferta TR
				$carritotr = $this->Carritos->find('all')->select(['plazoley_dcto'])->distinct(['plazoley_dcto'])
						->where(['Carritos.cliente_id' => $cliente_id])
						->andWhere(['Carritos.tipo_fact'=>'TR']);
				if ($carritotr->count()>0)		{
					foreach ($carritotr as $carrito): 
						$plazo = $carrito['plazoley_dcto'];
						$conn->query('CALL AgregarPedidoTDF('.$cliente_id.','.$envio.','.$envio.',"'.$fecha.'","TR","'.$comentario .'","'.$plazo.'",0);');
					endforeach;			
				}
				// Separo los items el Tipo Oferta TL
				$carritotl = $this->Carritos->find('all')->select(['plazoley_dcto'])->distinct(['plazoley_dcto'])
						->where(['Carritos.cliente_id' => $cliente_id])
						->andWhere(['Carritos.tipo_fact'=>'TL']);
				if ($carritotl->count()>0)		{
					foreach ($carritotl as $carrito): 
						if ($carrito['articulo_id']>27338 && $carrito['articulo_id']<27344)
							$comentario='P.PAMI';
						$plazo = $carrito['plazoley_dcto'];
						$conn->query('CALL AgregarPedidoTDF('.$cliente_id.','.$envio.','.$envio.',"'.$fecha.'","TL","'.$comentario .'","'.$plazo.'",0);');
					endforeach;		
				}
				// Separo los items el Tipo Oferta N
				$carriton = $this->Carritos->find('all')->select(['plazoley_dcto'])->distinct(['plazoley_dcto'])
						->where(['Carritos.cliente_id' => $cliente_id])
						->andWhere(['Carritos.tipo_fact'=>'N']);
				if ($carriton->count()>0)		{
						$plazo = 'HABITUAL';
						$conn->query('CALL AgregarPedidoTDF('.$cliente_id.','.$envio.','.$envio.',"'.$fecha.'","N","'.$comentario .'","'.$plazo.'",1);');
						
				}		
			}
			else
			{	// Cliente QUE no es de la isla
				//Separo los items el Tipo Oferta TR
				$carritotr = $this->Carritos->find('all')->select(['plazoley_dcto'])->distinct(['plazoley_dcto'])
						->where(['Carritos.cliente_id' => $cliente_id])
						->andWhere(['Carritos.tipo_fact'=>'TR']);
				if ($carritotr->count()>0)		{
					
					foreach ($carritotr as $carrito): 
						$plazo = $carrito['plazoley_dcto'];
						$conn->query('CALL AgregarPedido('.$cliente_id.','.$cliente_id.','.$envio.','.$envio.',"'.$fecha.'","TR","'.$comentario .'","'.$plazo.'",0,0);');
					endforeach;			}
				// Separo los items el Tipo Oferta TL
				/*$carritotl = $this->Carritos->find('all')->select(['articulo_id','plazoley_dcto'])->distinct(['plazoley_dcto'])
						->where(['Carritos.cliente_id' => $cliente_id])
						->andWhere(['Carritos.tipo_fact'=>'TL']);
				*/
				$carritotl = $this->Carritos->find('all')
				->select(['plazoley_dcto','articulo_id'])
				->where(['Carritos.cliente_id' => $cliente_id,	'Carritos.tipo_fact' => 'TL'])
				->group('Carritos.plazoley_dcto');
				if ($carritotl->count()>0)
				{
					foreach ($carritotl as $carrito): 
					
						if ($carrito['articulo_id']>27338 && $carrito['articulo_id']<27344)
							$comentario2='P.PAMI '.$comentario;
						else
							$comentario2= $comentario;
						$plazo = $carrito['plazoley_dcto'];
						$conn->query('CALL AgregarPedido('.$cliente_id.','.$cliente_id.','.$envio.','.$envio.',"'.$fecha.'","TL","'.$comentario2 .'","'.$plazo.'",0,0);');
					endforeach;
				}
				
			
				// Separo los items el Tipo Oferta N
				$carriton = $this->Carritos->find('all')->select(['plazoley_dcto'])->distinct(['plazoley_dcto'])
						->where(['Carritos.cliente_id' => $cliente_id])
						->andWhere(['Carritos.tipo_fact'=>'N']);
				if ($carriton->count()>0)		{
					
						$plazo = 'HABITUAL';
						$conn->query('CALL AgregarPedido('.$cliente_id.','.$cliente_id.','.$envio.','.$envio.',"'.$fecha.'","N","'.$comentario .'","'.$plazo.'",0,1);');
	
				}		
				
				// Separo los items el Tipo Oferta N
				/*if ($carriton->count()>0)
				{
					foreach ($carriton as $carrito): 
						$plazo = $carrito['plazoley_dcto'];
						$conn->query('CALL AgregarPedido('.$cliente_id.','.$cliente_id.','.$envio.','.$envio.',"'.$fecha.'","N","'.$comentario .'","'.$plazo.'",0,1);');
					endforeach;
				}
				*/
			}
				
			$this->Flash->warning(__(' Se envio correctamente el pedido, Gracias por Elegirnos!'),['key' => 'changepass']);
			return $this->redirect(['controller'=>'Carritos','action' => 'index']);
		}
		else
		{
			$this->Flash->error(__('No tiene productos en el Carritos'),['key' => 'changepass']);
			$this->redirect($this->referer());
		}
    }

	public function cargarpedidoisla($recupera){
		
				// Separo los items el Tipo Oferta TR
				$carritotr = $this->Carritos->find('all')->select(['plazoley_dcto'])->distinct(['plazoley_dcto'])
						->where(['Carritos.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
						->andWhere(['Carritos.tipo_fact'=>'TR']);
				
				if ($carritotr->count()>0)
				{
					//$this->request->session()->write('plazo',$carritotr->toArray());
					foreach ($carritotr as $carrito): 
						$plazo = $carrito['plazoley_dcto'];
						$conn->query('CALL ConfirmarPedidoIsla('.$cliente_id.','.$cliente_id.','.$envio.','.$envio.',"'.$fecha.'","TR","'.$comentario .'","'.$plazo.'",0,0);');
					endforeach;
				}
				// Separo los items el Tipo Oferta TL
				$carritotl = $this->Carritos->find('all')->select(['plazoley_dcto'])->distinct(['plazoley_dcto'])
						->where(['Carritos.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
						->andWhere(['Carritos.tipo_fact'=>'TL']);
				if ($carritotl->count()>0)
				{
					//$this->request->session()->write('plazo2',$carritotl->toArray());
					foreach ($carritotl as $carrito): 
						$plazo = $carrito['plazoley_dcto'];
						$conn->query('CALL ConfirmarPedidoIsla('.$cliente_id.','.$cliente_id.','.$envio.','.$envio.',"'.$fecha.'","TL","'.$comentario .'","'.$plazo.'",0,0);');
					endforeach;
				}
				
				// Separo los items el Tipo Oferta N
				$carriton = $this->Carritos->find('all')->select(['plazoley_dcto'])->distinct(['plazoley_dcto'])
						->where(['Carritos.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
						->andWhere(['Carritos.tipo_fact'=>'N']);
				if ($carriton->count()>0)
				{
					$plazo = 'HABITUAL';
					$conn->query('CALL ConfirmarPedidoIsla('.$cliente_id.','.$cliente_id.','.$envio.','.$envio.',"'.$fecha.'","N","'.$comentario .'","'.$plazo.'",0,1);');
				}
		
		
	}
	

	public function downloadfilefaltastxt($id = null)
    {
		$this->viewBuilder()->layout('store');

		$this->loadModel('PedidosItems');

        $pedidositems =$this->PedidosItems->find()
		 ->contain(['Articulos'])
		 ->where(['pedido_id'=>$id])
		 ->where(["pedidos_items_status_id>0"])
		 ->order(['Articulos.descripcion_pag' => 'ASC']);

		if ($pedidositems->isEmpty())
		{ $this->Flash->error(__('Momentaneamente no disponible, intente mas tarde.'),['key' => 'changepass']);
			$this->redirect($this->referer());}
		else
		{
			
			
			$nombreArchivo= 'falta'.str_pad($this->request->session()->read('Auth.User.codigo'), 6, "0", STR_PAD_LEFT).str_pad($id, 8, "0", STR_PAD_LEFT);
			$file = new File('temp'. DS .'Comprobantes'. DS .$nombreArchivo.'.TXT', true, 0777);
			$file->write("\n",'w');
				 /*
					$line =   '0'.
						str_pad($this->request->session()->read('Auth.User.codigo'), 8, "0", STR_PAD_LEFT).
						str_pad("", 2," ").
						str_pad($id, 8, 0,STR_PAD_LEFT)."\r\n";
				$file->write($line,'w');
				*/
			foreach ($pedidositems as $row): 
			
				$line = 
						str_pad($row['articulo']['codigo_barras'], 13," ").
						str_pad($row['articulo']['descripcion_sist'], 30).
						str_pad($row['cantidad']-$row['cantidad_facturada'], 4, "0", STR_PAD_LEFT).
						str_pad($row['pedidos_items_status_id'], 2,0,STR_PAD_LEFT).
						"\r\n";
				$file->write($line,'w');
			endforeach; 
			$file->close(); // Be sure to close the file when you're done
			$this->response->type('txt');
			$nombre_fichero = 'temp'. DS .'Comprobantes'. DS .$nombreArchivo.'.TXT';

				if (file_exists($nombre_fichero)) {
					$this->response->file('temp'. DS .'Comprobantes'. DS .$nombreArchivo.'.TXT',['download' => true, 'name' => $nombreArchivo.'.TXT']);
				}

			return $this->response;
			
		}
	   
    }

    /**
     * Edit method
     *
     * @param string|null $id Pedido id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$this->viewBuilder()->layout('store');
        $pedido = $this->Pedidos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $pedido = $this->Pedidos->patchEntity($pedido, $this->request->data);
            if ($this->Pedidos->save($pedido)) {
                $this->Flash->success('Se guardo los cambios.',['key' => 'changepass']);
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('No Se guardo los cambios,intente de nuevo',['key' => 'changepass']);
            }
        }
        $clientes = $this->Pedidos->Clientes->find('list', ['limit' => 200]);
        $sucursals = $this->Pedidos->Sucursals->find('list', ['limit' => 200]);
        $this->set(compact('pedido', 'clientes', 'sucursals'));
        $this->set('_serialize', ['pedido']);
    }

	public function impreso($id = null)
    {
		
        $pedido = $this->Pedidos->get($id, [
            'contain' => []
        ]);
		$pedido['impreso']=1;
		$this->set('id',$id);
        if ($this->request->is(['get'])) {
            $pedido = $this->Pedidos->patchEntity($pedido, $this->request->data);
			$pedido['impreso']=1;
            if ($this->Pedidos->save($pedido)) {
                $this->Flash->success('Se guardo los cambios.',['key' => 'changepass']);
                
            } else {
                $this->Flash->error('No Se guardo los cambios,intente de nuevo',['key' => 'changepass']);
            }
        }
		$this->redirect($this->referer());
        
    }
	
	public function searchproduct()
    {
		$this->viewBuilder()->layout('store');
		$fechahasta=0;
		$fechadesde =0;
		$termino ="";
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
				$terminocompleto = explode(" ", $this->request->data['terminobuscar']);
				$termino ="";
				if (count($terminocompleto)>1)
				{
						foreach ($terminocompleto as $terminosimple): 
							$termino = $termino.'%'.$terminosimple.'%';
						endforeach; 
				}
				else
					$termino = '%'.$terminocompleto[0].'%';
				
			}	
			else
			{
				$termino ="";
			}				
			$this->request->session()->write('termino',$termino);
			$this->request->session()->write('fechadesde',$fechadesde);	
			$this->request->session()->write('fechahasta',$fechahasta);
		}
		else 
		{
			$fechahasta = $this->request->session()->read('fechahasta');
		    $fechadesde = $this->request->session()->read('fechadesde');
			$termino = $this->request->session()->read('termino');
		}
		
        $this->paginate = [		
		//'limit' => 11,
		];

		$this->loadModel('FacturasCabeceras');
		$this->loadModel('FacturasCuerposItems');
		$this->paginate = [
            'contain' => ['FacturasCabeceras'],
			'limit' => 1000,
			'maxLimit' => 1000
        ];
	
		if ($fechahasta!=0)
		{
			$fechahasta2 = Time::createFromFormat('d/m/Y',$fechahasta,'America/Argentina/Buenos_Aires');
			$fechahasta2->modify('+1 days');
		}
		else
		{
			$fechahasta2 = Time::now();
			$fechahasta2-> modify('+1 days');
			$fechahasta=1;
		}
		if ($fechadesde!=0)
		{
			$fechadesde2 = Time::createFromFormat('d/m/Y',$fechadesde,'America/Argentina/Buenos_Aires');
		}
		else
		{
			$fechadesde2 = Time::now();
			if ($fechahasta!=0)
				$fechadesde2->setDate($fechadesde2->year, $fechahasta2->month, 1);
			else
				$fechadesde2->setDate($fechadesde2->year, $fechadesde2->month, 1);
			//$fechadesde2->i18nFormat('yyyy-MM-dd');
			$fechadesde=1;
		}
		
						
			$query = $this->FacturasCuerposItems->find('all')	
					//->contain(['FacturasCabeceras'])//,'Articulos'Comprobantes
					->hydrate(false)
					->join([
					'fc' => [
						'table' => 'facturas_cabeceras',
						'type' => 'LEFT',
						'conditions' => ['fc.id = FacturasCuerposItems.facturas_encabezados_id',
						'fc.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')
						]
					]
					
					])
					->andWhere(['fc.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
						->order(['fc.fecha' => 'ASC'])
					
					->group('fc.id');
					
		if (($fechadesde !=0) || ($fechahasta !=0) )
			{
				 
				 $query->andWhere(["fc.fecha BETWEEN '".$fechadesde2->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta2->i18nFormat('yyyy-MM-dd')."'"]);
		
				 
			}
			
		
	  	if ($termino!="")
		{
			$query->andWhere([
					
					'OR' => [['FacturasCuerposItems.descripcion LIKE'=>$termino], 
					['FacturasCuerposItems.troquel LIKE'=>$termino],['FacturasCuerposItems.codigo_barra LIKE'=>$termino]],
				]);
		}
       
		if ($query!=null)
		{
			$resultados = $this->paginate($query);
		}
		else
			$resultados = null;
		
		
		
		$this->set('resultados',$resultados);

    }
	
	public function faltas()
    {
		$this->viewBuilder()->layout('store');
		//,'Carritos'
        $this->paginate = [		
		'contain' => ['Laboratorios','Categorias','Descuentos','Carritos'],
		'limit' => 100,
		'offset' => 0, 
        'order' => ['Articulos.descripcion_pag' => 'asc']];
		$this->categoriaylaboratorio();
		$this->clientecredito();
		$this->sumacarrito();

		
		
			$fechahasta = Time::now();
			$fechahasta->i18nFormat('yyyy-MM-dd');
			$fechahasta-> modify('+1 days');
			$fechadesde = Time::now();
			$fechadesde->i18nFormat('yyyy-MM-dd');
			$fechadesde-> modify('-7 days');

		if ($this->request->is('post'))
		{	
	
			if ($this->request->data['categoria_id']!= null)
			{
				$categoriaid = $this->request->data['categoria_id'];
			}	
			else
			{
				$categoriaid=0;
			}
			if ($this->request->data['laboratorio_id']!= null)
			{
				$laboratorioid = $this->request->data['laboratorio_id'];
			}	
			else
				{
				$laboratorioid =0;
			}
		
			
			if ($this->request->data['terminobuscar']!= null)
			{
				$terminocompleto = explode(" ", $this->request->data['terminobuscar']);
				$termsearch ="";
				if (count($terminocompleto)>1)
				{
						foreach ($terminocompleto as $terminosimple): 
							$termsearch = $termsearch.'%'.$terminosimple.'%';
						endforeach; 
				}
				else
					$termsearch = '%'.$terminocompleto[0].'%';
				
			}	
			else
			{
				$termsearch ="";
			}	
			$this->request->session()->write('termsearch',$termsearch);
			$this->request->session()->write('categoriaid',$categoriaid);	
			$this->request->session()->write('laboratorioid',$laboratorioid);
		}
		else 
		{	
			
			$categoriaid = 0;
			if (!empty($this->request->session()->read('categoriaid')))
				$categoriaid = $this->request->session()->read('categoriaid');
			
			$laboratorioid = 0;//$this->request->session()->read('laboratorioid');
			if (!empty($this->request->session()->read('laboratorioid')))
				$laboratorioid = $this->request->session()->read('laboratorioid');
				$termsearch = "";
			if (!empty($this->request->session()->read('termsearch')))
				if ($termsearch =="") $termsearch = $this->request->session()->read('termsearch');
		}


		$this->loadModel('Articulos');
		$fecha = Time::now();
		$fecha->i18nFormat('yyyy-MM-dd');
	  	$articulosA = $this->Articulos->find()
				->contain(['Carritos' => [
						
						'queryBuilder' => function ($q) {
							return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); // Full conditions for filtering
						}
					]
				])
					->hydrate(false)
					->join([
						'table' => 'pedidos',
						'alias' => 'p',
						'type' => 'inner',
						'conditions' => [
						
						'p.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]		
					])
					->join([
						'table' => 'pedidos_items',
						'alias' => 'pe',
						'type' => 'inner',
						'conditions' => ['pe.pedido_id = p.id',
						'pe.articulo_id = Articulos.id']
					])
				
					->join([
						'table' => 'descuentos',
						'alias' => 'd',
						'type' => 'LEFT',
						 'conditions' => [
						'd.articulo_id = Articulos.id',
						'd.tipo_venta = "D"',
						'd.fecha_hasta >=' => $fecha,
						'd.tipo_oferta in ("RV","RR","OR","FR","TD","RL")'
						]		
					]
					);
		
		
		//'conditions' => 'd.articulo_id = Articulos.id and CURRENT_DATE() <= d.fecha_hasta and d.tipo_venta in ("D ","  ")',
		$articulosA->where(["p.creado BETWEEN '".$fechadesde->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta->i18nFormat('yyyy-MM-dd')."'"])
				->andWhere(["pe.nro_pedido_ds IS NOT NULL"])
				->andWhere(["pe.cantidad_facturada"=>0])
				->andWhere(['Articulos.stock'=>'S']);
				
		if ($termsearch!="")
				{
					$articulosA->andWhere([
							
							'OR' => [['Articulos.descripcion_pag LIKE'=>$termsearch], 
							['Articulos.troquel LIKE'=>$termsearch],['Articulos.codigo_barras LIKE'=>$termsearch],['Articulos.codigo_barras2 LIKE'=>$termsearch]],
						]);
		
					if (($categoriaid !=0) && ($laboratorioid !=0))
					{
						$articulosA->andWhere(['Articulos.laboratorio_id'=>$laboratorioid])
								   ->andWhere(['Articulos.categoria_id'=>$categoriaid]);
									
					}
					else
					{
						if ($laboratorioid !=0)
						{
							$articulosA->andWhere(['Articulos.laboratorio_id'=>$laboratorioid]);
						}
						else
						{
							if ($categoriaid !=0)
							{	
								$articulosA->andWhere(['Articulos.categoria_id'=>$categoriaid]);
							}
							else
							{	
								$articulosA->orWhere(['Articulos.codigo_barras LIKE'=>$termsearch]);
								
							}
						}
					}
				}
				else
				{
					if (($categoriaid !=0) && ($laboratorioid !=0))
					{
						$articulosA->where(['Articulos.laboratorio_id'=>$laboratorioid])
								->where(['Articulos.categoria_id'=>$categoriaid]);
					}
					else
					{
						if ($laboratorioid !=0)
						{
							$articulosA->where(['Articulos.laboratorio_id'=>$laboratorioid]);
						}
						else
						{
							if ($categoriaid !=0)
							{
								$articulosA->where(['Articulos.categoria_id'=>$categoriaid]);
							}
							
						}
					}		
				}			
		
		if ($articulosA!=null)
		{
			$articulos = $this->paginate($articulosA);
		}
		else
			$articulos = null;
		
		$this->set(compact('articulos'));
		
		
    }
	
	
    /**
     * Delete method
     *
     * @param string|null $id Pedido id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
		$this->viewBuilder()->layout('store');
        $this->request->allowMethod(['post', 'delete']);
        $pedido = $this->Pedidos->get($id);
        if ($this->Pedidos->delete($pedido)) {
            $this->Flash->success('Se eliminio correctamente.',['key' => 'changepass']);
        } else {
            $this->Flash->error('No se puedo eliminar, intente nuevamente',['key' => 'changepass']);
        }
        return $this->redirect(['action' => 'index']);
    }
	
	public function import()
	{
		$this->viewBuilder()->layout('store');
	}	

	public function pami_admin()
    {
		$this->viewBuilder()->layout('admin2');
        $this->paginate = [
			'limit' => 500,
			'maxLimit' => 1000,         
			//'contain' => ['Clientes']
			
		];
		
		$this->viewBuilder()->layout('admin2');
        $this->paginate = [
			'limit' => 500,
			'maxLimit' => 1000,         
			//'contain' => ['Clientes']
			
		];
		
		if ($this->request->is('post'))
		{	
	
			if (!empty($this->request->data['fechadesde']))
			{
				$fechadesde = $this->request->data['fechadesde'];
			}	
			else
			{
				$fechadesde=0;
			}

			//if ($this->request->data['fechahasta']!= null)
			if (!empty($this->request->data['fechahasta']))
			{
				$fechahasta = $this->request->data['fechahasta'];
			}	
			else
			{
				$fechahasta =0;
			}
			if ($this->request->data['termino']!= null)
			{
				$termino = '%'.$this->request->data['termino'].'%';
			}	
			else
			{
				$termino ="";
			}	
			if ($this->request->data['termino2']!= null)
			{
				$termino2 = $this->request->data['termino2'];
			}	
			else
			{
				$termino2 ="";
			}	
			if ($this->request->data['termino3']!= null)
			{
				$termino3 = $this->request->data['termino3'];
			}	
			else
			{
				$termino3 ="";
			}	
			$this->request->session()->write('termino',$termino);
			$this->request->session()->write('termino2',$termino2);
			$this->request->session()->write('termino3',$termino3);
			$this->request->session()->write('fechadesde',$fechadesde);	
			$this->request->session()->write('fechahasta',$fechahasta);
		}
		else 
		{
			
			if (!empty($this->request->session()->read('fechahasta')))
				$fechahasta = $this->request->session()->read('fechahasta');
			else
				$fechahasta = 0;
			if (!empty($this->request->session()->read('fechadesde')))
				$fechadesde = $this->request->session()->read('fechadesde');
				else
				$fechadesde =0;
			$termino = $this->request->session()->read('termino');
			$termino2 = $this->request->session()->read('termino2');
			$termino3 = $this->request->session()->read('termino3');
		}

		if ($fechahasta!=0)
		{
			//$fechahasta2 = Time::now();
			$fechahasta2 = Time::createFromFormat('d/m/Y',$fechahasta,'America/Argentina/Buenos_Aires');
			$fechahasta2->modify('+1 days');
			$fechahasta2->i18nFormat('yyyy-MM-dd');
		}
		else
		{
			$fechahasta2 = Time::now();
			$fechahasta2-> modify('+1 days');
			//$fechahasta2->i18nFormat('yyyy-MM-dd');
			//$fechahasta2 = $fechahasta2->i18nFormat('yyyy-MM-dd');
		}
		if ($fechadesde!=0)
		{
			//$fechadesde2 = Time::now();
			$fechadesde2 = Time::createFromFormat('d/m/Y',$fechadesde,'America/Argentina/Buenos_Aires');
			//$fechadesde2->i18nFormat('yyyy-MM-dd');
		}
		else
		{
			$fechadesde2 = Time::now();
			$fechadesde2-> modify('-7 days');
			//$fechadesde2->i18nFormat('yyyy-MM-dd');
		}
		/*	$fechahasta2 = Time::now();
			
			$fechahasta2->modify('+1 days');
			$fechahasta2->i18nFormat('yyyy-MM-dd');
			
			$fechadesde2 = Time::now();
			$fechadesde2->modify('-7 days');
			
			$fechadesde2->i18nFormat('yyyy-MM-dd');
		*/
		$pedidos = $this->Pedidos->find('all')
				->select(['id',	'creado', 'c.codigo','c.razon_social', 'sucursal_id', 'tipo_fact', 'forma_envio', 'estado_id','nro_pedido_ds','comentario','impreso','pedidos_status_id'])
				->hydrate(false)
				->join([
					'c' => [
						'table' => 'clientes',
						'type' => 'left',
						'conditions' => 'c.id = Pedidos.cliente_id',
					],
					'pe' => [
						'table' => 'pedidos_items',
						'type' => 'left',
						'conditions' => 'pe.pedido_id = Pedidos.id',
					]
				])
			
			->where(["Pedidos.creado BETWEEN '".$fechadesde2->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta2->i18nFormat('yyyy-MM-dd')."'"])
			->where(['pe.articulo_id in (27339,27340,27341,27342,27343)'])
			->order(['Pedidos.id' => 'DESC'])	
			
			
			->group('Pedidos.id');			
		
		//$this->resumenpedidos($pedidos);
				
        $this->set('pedidos', $this->paginate($pedidos));
        $this->set('_serialize', ['pedidos']);
		$this->loadModel('Estados');
		$estados = $this->Estados->find('all');
		$this->set('estados',$estados->toArray());
		$this->set('titulo','PEDIDOS PAÑALES PAMI');
    }
	

	public function index_admin_new()
    {
		$this->viewBuilder()->layout('admin2');
		$this->paginate = [
          
			'limit' => 500,
			 'maxLimit' => 1000
        ];
		
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
			if ($this->request->data['termino']!= null)
			{
				$termino = '%'.$this->request->data['termino'].'%';
			}	
			else
			{
				$termino ="";
			}	
			if ($this->request->data['termino2']!= null)
			{
				$termino2 = $this->request->data['termino2'];
			}	
			else
			{
				$termino2 ="";
			}	
			if ($this->request->data['termino3']!= null)
			{
				$termino3 = $this->request->data['termino3'];
			}	
			else
			{
				$termino3 ="";
			}	
			$this->request->session()->write('termino',$termino);
			$this->request->session()->write('termino2',$termino2);
			$this->request->session()->write('termino3',$termino3);
			$this->request->session()->write('fechadesde',$fechadesde);	
			$this->request->session()->write('fechahasta',$fechahasta);
		}
		else 
		{

			$session = $this->request->session();
			if ($session->check('fechahasta')) {
				$fechahasta = $session->read('fechahasta');
			} else {
				$fechahasta = 0; // o un valor por defecto
			}
			
			if ($session->check('fechadesde')) {
				$fechadesde = $session->read('fechadesde');
			} else {
				$fechadesde = 0; // o un valor por defecto
			}
			
			if ($session->check('termino')) {
				$termino = $session->read('termino');
			} else {
				$termino = ""; // o un valor por defecto
			}
			
			if ($session->check('termino2')) {
				$termino2 = $session->read('termino2');
			} else {
				$termino2 = ""; // o un valor por defecto
			}
			
			if ($session->check('termino3')) {
				$termino3 = $session->read('termino3');
			} else {
				$termino3 = ""; // o un valor por defecto
			}
		}
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
			//$fechahasta2-> modify('-1 days');
			$fechahasta2->i18nFormat('yyyy-MM-dd');
			$fechahasta =1;
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
			$fechadesde2->modify('-1 days');
			$fechadesde2->i18nFormat('yyyy-MM-dd');
			$fechadesde =1;
		}
		// siempre
		$pedidosA = $this->Pedidos->find('all')
				->select(['id',	'creado', 'c.codigo','c.razon_social','cliente_id', 'sucursal_id', 'tipo_fact', 'forma_envio', 'estado_id','nro_pedido_ds','impreso','pedidos_status_id','comentario'])
				->hydrate(false)
				->join([
					'c' => [
						'table' => 'clientes',
						'type' => 'left',
						'conditions' => 'c.id = Pedidos.cliente_id',
					]
				])
				->order(['Pedidos.id' => 'DESC'])
				->group('Pedidos.id');
		// 
		if ($termino!="")
		{
		$pedidosA ->join([
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
				]);	
		}

				
	  	if ($termino!="")
		{
			$pedidosA->where(['a.descripcion_pag LIKE'=>$termino])->orWhere(['a.troquel LIKE'=>$termino]);
		}
		
		if (($fechadesde !=0) && ($fechahasta !=0))
		    	$pedidosA->andWhere(["Pedidos.creado BETWEEN '".$fechadesde2->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta2->i18nFormat('yyyy-MM-dd')."'"]);
		else
				if (($fechadesde !=0) || ($fechahasta !=0))
					$pedidosA->andWhere(["Pedidos.creado BETWEEN '".$fechadesde2->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta2->i18nFormat('yyyy-MM-dd')."'"]);

		if ($termino3!="")
		{
				$pedidosA->where(['c.codigo'=>$termino3])->orWhere(['c.nombre LIKE'=>"%".$termino3."%"]);
		}
		if ($termino2!="")
		{
				$pedidosA->where(['Pedidos.id' => $termino2]);
		}
		
		if (($fechadesde !=0) && ($fechahasta !=0) && ($termino2!="") && ($termino!="") && ($termino3!="") )
					{
							$pedidosA=null;
							$this->redirect($this->referer());
					}
		if ($pedidosA!=null)
		{
			$pedidos = $this->paginate($pedidosA);
		}
		else
			$pedidos = null;
		
		
		$this->loadModel('Estados');
		$estados = $this->Estados->find('all');
		$this->set('estados',$estados->toArray());
		
		$this->set('pedidos',$pedidos);
		$this->set('titulo','Lista de Resultado de pedidos ' .$fechadesde2->i18nFormat('yyyy-MM-dd').' - '.$fechahasta2->i18nFormat('yyyy-MM-dd') );
    }

	public function index_admin_search()
    {
		$this->viewBuilder()->layout('admin2');
		$this->paginate = [
          
			'limit' => 500,
			 'maxLimit' => 1000
        ];
		
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
			if ($this->request->data['termino']!= null)
			{
				$termino = '%'.$this->request->data['termino'].'%';
			}	
			else
			{
				$termino ="";
			}	
			if ($this->request->data['termino2']!= null)
			{
				$termino2 = $this->request->data['termino2'];
			}	
			else
			{
				$termino2 ="";
			}	
			if ($this->request->data['termino3']!= null)
			{
				$termino3 = $this->request->data['termino3'];
			}	
			else
			{
				$termino3 ="";
			}	
			if ($this->request->data['termino4']!= null)
			{
				$termino4 = $this->request->data['termino4'];
			}	
			else
			{
				$termino4 =0;
			}	
			$this->request->session()->write('termino',$termino);
			$this->request->session()->write('termino2',$termino2);
			$this->request->session()->write('termino3',$termino3);
			$this->request->session()->write('termino4',$termino4);
			$this->request->session()->write('fechadesde',$fechadesde);	
			$this->request->session()->write('fechahasta',$fechahasta);
		}
		else 
		{
			$fechahasta = $this->request->session()->read('fechahasta');
		    $fechadesde = $this->request->session()->read('fechadesde');
			$termino = $this->request->session()->read('termino');
			$termino2 = $this->request->session()->read('termino2');
			$termino3 = $this->request->session()->read('termino3');
			$termino4 = $this->request->session()->read('termino4');
		}
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
			$fechadesde2->i18nFormat('yyyy-MM-dd');
		}
		// siempre
		$pedidosA = $this->Pedidos->find('all')
				->select(['id',	'creado', 'c.codigo','c.razon_social', 'sucursal_id', 'tipo_fact', 'forma_envio', 'estado_id','nro_pedido_ds','impreso','pedidos_status_id','comentario','cliente_id'])
				->hydrate(false)
				->join([
					'c' => [
						'table' => 'clientes',
						'type' => 'left',
						'conditions' => 'c.id = Pedidos.cliente_id',
					]
				])
				->order(['Pedidos.id' => 'DESC'])
				->group('Pedidos.id');
		// 
		if ($termino!="")
		{
		$pedidosA ->join([
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
				]);	
		}

				
	  	if ($termino!="")
		{
			$pedidosA->where(['a.descripcion_pag LIKE'=>$termino])->orWhere(['a.troquel LIKE'=>$termino]);
		}
		
		if (($fechadesde !=0) && ($fechahasta !=0))
		    	$pedidosA->andWhere(["Pedidos.creado BETWEEN '".$fechadesde2->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta2->i18nFormat('yyyy-MM-dd')."'"]);
		else
				if (($fechadesde !=0) || ($fechahasta !=0))
					$pedidosA->andWhere(["Pedidos.creado BETWEEN '".$fechadesde2->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta2->i18nFormat('yyyy-MM-dd')."'"]);

		if ($termino3!="")
		{
				$pedidosA->where(['c.codigo'=>$termino3])->orWhere(['c.nombre LIKE'=>"%".$termino3."%"]);
		}
		if ($termino2!="")
		{
				$pedidosA->where(['Pedidos.id' => $termino2]);
		}
		
		if ($termino4!=0)
		{
			if (($fechadesde ==0) && ($fechahasta ==0))
		    	$pedidosA->andWhere(["Pedidos.creado BETWEEN '".$fechadesde2->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta2->i18nFormat('yyyy-MM-dd')."'"]);

			switch ($termino4) {
				case 1:
					$pedidosA->where(['Pedidos.forma_envio' => 99]);
					break;
				case 2:
					$pedidosA->where(['Pedidos.forma_envio' => 98]);
					break;
				case 3:
					$pedidosA->where(['Pedidos.tipo_fact' => 'N']);
					break;
				case 4:
					$pedidosA->where(['Pedidos.tipo_fact in ("TR","TL")']);
					break;
				case 5:
					$pedidosA->where(['Pedidos.comentario' => 'P.PAMI ']);
					break;
				case 6:
					$pedidosA->where(['Pedidos.estado_id' => 1]);
					break;
				case 7:
					$pedidosA->where(['Pedidos.estado_id '=> 2]);
					break;
				case 8:

					

					$pedidosA->where(['c.codigo>79000 and c.codigo<79999']);
					break;
				default:
					// Manejo de caso por defecto
					//throw new InvalidArgumentException("El valor de termino4 no es válido.");
			}

		}
		if (($fechadesde !=0) && ($fechahasta !=0) && ($termino2!="") && ($termino!="") && ($termino3!="") && ($termino4!=0)  )
					{
							$pedidosA=null;
							$this->redirect($this->referer());
					}
		if ($pedidosA!=null)
		{
			$pedidos = $this->paginate($pedidosA);
		}
		else
			$pedidos = null;
		
		
		$this->loadModel('Estados');
		$estados = $this->Estados->find('all');
		$this->set('estados',$estados->toArray());
		
		$this->set('pedidos',$pedidos);
		$this->set('titulo','Lista de Resultado de pedidos');
    }

	public function duplicate_admin($tipopedido = null , $cliente_id = null )
    {
		$this->viewBuilder()->layout('admin2');
		$this->paginate = [
          
			'limit' => 500,
			 'maxLimit' => 1000
        ];
		
		if ($this->request->is('post'))
		{	
			if ($this->request->data['tipopedido']!= null)
			{
				$tipopedido = $this->request->data['tipopedido'];
			}	
			else
			{
				$tipopedido="";
			}
			if ($this->request->data['cliente_id']!= null)
			{
				$cliente_id = $this->request->data['cliente_id'];
			}	
			else
			{
				$cliente_id=0;
			}
			


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
			if ($this->request->data['termino']!= null)
			{
				$termino = '%'.$this->request->data['termino'].'%';
			}	
			else
			{
				$termino ="";
			}	
			if ($this->request->data['termino2']!= null)
			{
				$termino2 = $this->request->data['termino2'];
			}	
			else
			{
				$termino2 ="";
			}	
			if ($this->request->data['termino3']!= null)
			{
				$termino3 = $this->request->data['termino3'];
			}	
			else
			{
				$termino3 ="";
			}	
			if ($this->request->data['termino4']!= null)
			{
				$termino4 = $this->request->data['termino4'];
			}	
			else
			{
				$termino4 =0;
			}	
			$this->request->session()->write('termino',$termino);
			$this->request->session()->write('termino2',$termino2);
			$this->request->session()->write('termino3',$termino3);
			$this->request->session()->write('termino4',$termino4);
			$this->request->session()->write('fechadesde',$fechadesde);	
			
			$this->request->session()->write('fechahasta',$fechahasta);

			$this->request->session()->write('tipopedido',$tipopedido);	
			$this->request->session()->write('duplicate_cliente_id',$cliente_id);
		}
		else 
		{
			//$fechahasta = $this->request->session()->read('fechahasta');
		    //$fechadesde = $this->request->session()->read('fechadesde');
			$termino = $this->request->session()->read('termino');
			$termino2 = $this->request->session()->read('termino2');
			$termino3 = $this->request->session()->read('termino3');
			$termino4 = $this->request->session()->read('termino4');
			//$tipopedido = $this->request->session()->read('tipopedido');
			//$cliente_id = $this->request->session()->read('duplicate_cliente_id');


		}
		if (!empty($fechahasta))
		{
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
				$fechahasta2->modify('+1 days');
				//$fechahasta2 = $fechahasta2->i18nFormat('yyyy-MM-dd');
			}
		}
		else
		{
			$fechahasta2 = Time::now();
			$fechahasta2->modify('+1 days');
			//$fechahasta2 = $fechahasta2->i18nFormat('yyyy-MM-dd');
			$fechahasta =1;
		}

		if (!empty($fechadesde))
		{
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
				$fechadesde2->i18nFormat('yyyy-MM-dd');
			}
		}
		else
		{
			$fechadesde =1;
			$fechadesde2 = Time::now();
			$fechadesde2->modify('-1 days');
			$fechadesde2->i18nFormat('yyyy-MM-dd');
			//$fechahasta2 = $fechahasta2->i18nFormat('yyyy-MM-dd');
		}
		// siempre
		$pedidosA = $this->Pedidos->find('all')
				->select(['id',	'creado', 'c.codigo','c.razon_social', 'sucursal_id', 'tipo_fact', 'forma_envio', 'estado_id','nro_pedido_ds','impreso','pedidos_status_id','comentario','cliente_id'])
				->hydrate(false)
				->join([
					'c' => [
						'table' => 'clientes',
						'type' => 'left',
						'conditions' => 'c.id = Pedidos.cliente_id',
					]
				])
				->order(['Pedidos.id' => 'DESC'])
				->group('Pedidos.id');
		// 
		if ($termino!="")
		{
		$pedidosA ->join([
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
				]);	
		}

				
	  	if ($termino!="")
		{
			$pedidosA->where(['a.descripcion_pag LIKE'=>$termino])->orWhere(['a.troquel LIKE'=>$termino]);
		}
		
		if (($fechadesde !=0) && ($fechahasta !=0))
		    	$pedidosA->andWhere(["Pedidos.creado BETWEEN '".$fechadesde2->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta2->i18nFormat('yyyy-MM-dd')."'"]);
		else
				if (($fechadesde !=0) || ($fechahasta !=0))
					$pedidosA->andWhere(["Pedidos.creado BETWEEN '".$fechadesde2->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta2->i18nFormat('yyyy-MM-dd')."'"]);

		if ($termino3!="")
		{
				$pedidosA->where(['c.codigo'=>$termino3])->orWhere(['c.nombre LIKE'=>"%".$termino3."%"]);
		}
		if ($termino2!="")
		{
				$pedidosA->where(['Pedidos.id' => $termino2]);
		}
		
		if ($tipopedido !="")
		{
			$pedidosA->where(['Pedidos.tipo_fact' => $tipopedido]);
		}

		if ($cliente_id !=0)
		{
			$pedidosA->where(['Pedidos.cliente_id' => $cliente_id]);
		}


		if ($termino4!=0)
		{
			if (($fechadesde ==0) && ($fechahasta ==0))
		    	$pedidosA->andWhere(["Pedidos.creado BETWEEN '".$fechadesde2->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta2->i18nFormat('yyyy-MM-dd')."'"]);

			switch ($termino4) {
				case 1:
					$pedidosA->where(['Pedidos.forma_envio' => 99]);
					break;
				case 2:
					$pedidosA->where(['Pedidos.forma_envio' => 98]);
					break;
				case 3:
					$pedidosA->where(['Pedidos.tipo_fact' => 'N']);
					break;
				case 4:
					$pedidosA->where(['Pedidos.tipo_fact in ("TR","TL")']);
					break;
				case 5:
					$pedidosA->where(['Pedidos.comentario' => 'P.PAMI ']);
					break;
				case 6:
					$pedidosA->where(['Pedidos.estado_id' => 1]);
					break;
				case 7:
					$pedidosA->where(['Pedidos.estado_id '=> 2]);
					break;
				case 8:

					

					$pedidosA->where(['c.codigo>79000 and c.codigo<79999']);
					break;
				default:
					// Manejo de caso por defecto
					//throw new InvalidArgumentException("El valor de termino4 no es válido.");
			}

		}
		if (($fechadesde !=0) && ($fechahasta !=0) && ($termino2!="") && ($termino!="") && ($termino3!="") && ($termino4!=0)  )
					{
							$pedidosA=null;
							$this->redirect($this->referer());
					}
		if ($pedidosA!=null)
		{
			$pedidos = $this->paginate($pedidosA);
		}
		else
			$pedidos = null;
		
		
		$this->loadModel('Estados');
		$estados = $this->Estados->find('all');
		$this->set('estados',$estados->toArray());
		
		$this->set('pedidos',$pedidos);
		$this->set('titulo','Lista de Resultado de pedidos');
    }

	public function pami_admin_search()
    {
		$this->viewBuilder()->layout('admin2');
		$this->paginate = [
          
			'limit' => 500,
			 'maxLimit' => 1000
        ];
		
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
			if ($this->request->data['termino']!= null)
			{
				$termino = '%'.$this->request->data['termino'].'%';
			}	
			else
			{
				$termino ="";
			}	
			if ($this->request->data['termino2']!= null)
			{
				$termino2 = $this->request->data['termino2'];
			}	
			else
			{
				$termino2 ="";
			}	
			if ($this->request->data['termino3']!= null)
			{
				$termino3 = $this->request->data['termino3'];
			}	
			else
			{
				$termino3 ="";
			}	
			$this->request->session()->write('termino',$termino);
			$this->request->session()->write('termino2',$termino2);
			$this->request->session()->write('termino3',$termino3);
			$this->request->session()->write('fechadesde',$fechadesde);	
			$this->request->session()->write('fechahasta',$fechahasta);
		}
		else 
		{
			$fechahasta = $this->request->session()->read('fechahasta');
		    $fechadesde = $this->request->session()->read('fechadesde');
			$termino = $this->request->session()->read('termino');
			$termino2 = $this->request->session()->read('termino2');
			$termino3 = $this->request->session()->read('termino3');
		}
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
			$fechahasta2-> modify('-7 days');
			$fechadesde2->i18nFormat('yyyy-MM-dd');
		}
		// siempre
		$pedidosA = $this->Pedidos->find('all')
				->select(['id',	'creado', 'c.codigo','c.razon_social', 'sucursal_id', 'tipo_fact', 'forma_envio', 'estado_id','nro_pedido_ds','impreso','pedidos_status_id','comentario'])
				->hydrate(false)
				->join([
					'c' => [
						'table' => 'clientes',
						'type' => 'left',
						'conditions' => 'c.id = Pedidos.cliente_id',
					],
					'pe' => [
						'table' => 'pedidos_items',
						'type' => 'left',
						'conditions' => 'pe.pedido_id = Pedidos.id',
					]
				])
				->where(['pe.articulo_id in (27339,27340,27341,27342,27343)'])
				->order(['Pedidos.id' => 'DESC'])
				->group('Pedidos.id');

		if (($fechadesde !=0) && ($fechahasta !=0))
		    	$pedidosA->andWhere(["Pedidos.creado BETWEEN '".$fechadesde2->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta2->i18nFormat('yyyy-MM-dd')."'"]);
		else
				if (($fechadesde !=0) || ($fechahasta !=0))
					$pedidosA->andWhere(["Pedidos.creado BETWEEN '".$fechadesde2->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta2->i18nFormat('yyyy-MM-dd')."'"]);

		if ($termino3!="")
		{
				$pedidosA->where(['c.codigo'=>$termino3])->orWhere(['c.nombre LIKE'=>"%".$termino3."%"]);
		}
		if ($termino2!="")
		{
				$pedidosA->where(['Pedidos.id' => $termino2]);
		}
		
		IF (($fechadesde !=0) && ($fechahasta !=0) && ($termino2!="") && ($termino!="") && ($termino3!="") )
					{
							$pedidosA=null;
							$this->redirect($this->referer());
					}
		if ($pedidosA!=null)
		{
			$pedidos = $this->paginate($pedidosA);
		}
		else
			$pedidos = null;
		
		
		$this->loadModel('Estados');
		$estados = $this->Estados->find('all');
		$this->set('estados',$estados->toArray());
		
		$this->set('pedidos',$pedidos);
		$this->set('titulo','Lista de Resultado de pedidos');
    }

	public function index_admin_reporte(){
	$this->viewBuilder()->layout('admin');
   }

   	public function reportPedidosExcel()
	{
			$this->viewBuilder()->layout('ajax');
		$fechadesde = $this->request->getData('fechain');
		$fechahasta = $this->request->getData('fechafi');
		$query = $this->Pedidos->find();
		$query
			->select([
				'day' => $query->func()->day(['Pedidos.creado' => 'literal']),
				'UniFact_t' => $query->func()->sum('pit.cantidad_facturada'),
				'total_cantidad' => $query->func()->sum('pit.cantidad'),
				'c.codigo',
				'c.razon_social',
				'c.codigo_postal',
			])
			->join([
				'pit' => [
					'table' => 'pedidos_items',
					'type' => 'INNER',
					'conditions' => 'pit.pedido_id = Pedidos.id',
				],
				'a' => [
					'table' => 'articulos',
					'type' => 'INNER',
					'conditions' => 'pit.articulo_id = a.id',
				],
				'c' => [
					'table' => 'clientes',
					'type' => 'INNER',
					'conditions' => 'c.id = Pedidos.cliente_id',
				],
			])
			->where([
				'pit.cantidad_facturada IS NOT NULL',
				'Pedidos.creado BETWEEN :start AND :end',
				'Pedidos.plataforma' => 1,
			])
			//->bind(':start',$fechadesde, 'datetime')
			//->bind(':end', $fechahasta, 'datetime')
		  ->bind(':start', $fechadesde . ' 00:00:00', 'datetime')
    ->bind(':end', $fechahasta . ' 23:59:59', 'datetime')
			->group(['DAY(Pedidos.creado)', 'Pedidos.cliente_id']);
		$responseData = ['3' => true, 'responseText' => "2", 'status' => 200, 'resultados' => $query->toArray()];
				$this->request->session()->write('resultados', $query->toArray());
			$this->response->type('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		echo json_encode($responseData);
		
	}
	public function index_admin()
    {
		$this->viewBuilder()->layout('admin2');
        $this->paginate = [
			'limit' => 500,
			'maxLimit' => 1000,         
			//'contain' => ['Clientes']
			
        ];
			$fechahasta2 = Time::now();
			
			$fechahasta2->modify('+1 days');
			$fechahasta2->i18nFormat('yyyy-MM-dd');
		
			$fechadesde2 = Time::now();
			$fechadesde2->i18nFormat('yyyy-MM-dd');

		$pedidos = $this->Pedidos->find('all')
				->select(['id',	'creado', 'c.codigo','c.razon_social', 'sucursal_id', 'tipo_fact', 'forma_envio', 'estado_id','nro_pedido_ds','comentario','impreso','pedidos_status_id','cliente_id'])
				->hydrate(false)
				->join([
					'c' => [
						'table' => 'clientes',
						'type' => 'left',
						'conditions' => 'c.id = Pedidos.cliente_id',
					]
				])
			
			->where(["Pedidos.creado BETWEEN '".$fechadesde2->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta2->i18nFormat('yyyy-MM-dd')."'"])
			->order(['Pedidos.id' => 'DESC'])	
			->group('Pedidos.id');			
        $this->set('pedidos', $this->paginate($pedidos));
        $this->set('_serialize', ['pedidos']);
		$this->loadModel('Estados');
		$estados = $this->Estados->find('all');
		$this->set('estados',$estados->toArray());
		$this->set('titulo','PEDIDOS');
    }

	public function index_admin_search2()
    {
		$this->viewBuilder()->layout('admin2');
        $this->paginate = [
            'contain' => ['Clientes']
        ];
        $this->set('pedidos', $this->paginate($this->Pedidos));
        $this->set('_serialize', ['pedidos']);
		$this->set('titulo','Lista de pedidos');
    }

    /**
     * View method
     *
     * @param string|null $id Pedido id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view_admin($id = null)
    {
		$this->viewBuilder()->layout('admin2');
        $pedido = $this->Pedidos->get($id, [
            'contain' => ['Clientes']
        ]);
		$this->loadModel('PedidosItems');
		$this->loadModel('PedidosItemsStatus');
		$itemstatus = $this->PedidosItemsStatus->find('list',['keyField' => 'id','valueField'=>'nombre']);
		$this->set('itemstatus', $itemstatus->toArray());
		
        $this->set('pedido', $pedido);
		
        $this->set('_serialize', ['pedido']);
		$this->set('titulo','Vista del Pedidos');
		$this->paginate = [
			'limit' => 1000,
			'maxLimit' => 1000,
            'contain' => ['Pedidos', 'Articulos'],
			'order' => ['Articulos.descripcion_pag' => 'ASC']
			
        ];
        $this->set('pedidosItems', $this->paginate($this->PedidosItems->find()->where(['pedido_id'=>$id])));
        $this->set('_serialize', ['pedidosItems']);
		
    }

	public function view_admin_new($id = null)
    {
		$this->viewBuilder()->layout('adminS');
        $pedido = $this->Pedidos->get($id, [
            'contain' => ['Clientes']
        ]);
		$this->loadModel('PedidosItems');
		$this->loadModel('PedidosItemsStatus');
		$itemstatus = $this->PedidosItemsStatus->find('list',['keyField' => 'id','valueField'=>'nombre']);
		$this->set('itemstatus', $itemstatus->toArray());
		
        $this->set('pedido', $pedido);
		
        $this->set('_serialize', ['pedido']);
		$this->set('titulo','Vista del Pedidos');
		$this->paginate = [
			'limit' => 1000,
			'maxLimit' => 1000,
            'contain' => ['Pedidos', 'Articulos'],
			'order' => ['Articulos.descripcion_pag' => 'ASC']
			
        ];
        $this->set('pedidosItems', $this->paginate($this->PedidosItems->find()->where(['pedido_id'=>$id])));
        $this->set('_serialize', ['pedidosItems']);
		
    }
}
