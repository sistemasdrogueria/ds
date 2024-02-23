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
           if (in_array($this->request->action, ['index_admin','view_admin','index_admin_search','impreso','pami_admin','pami_admin_search'])) {
       
            if($this->request->session()->read('Auth.User.role')=='admin') 	
                return true;			
            else 
				$this->Flash->error(__('No tiene permisos para ingresar'),['key' => 'changepass']);
				return false;
			}
			else
			{
				
			
				if (in_array($this->request->action, ['index','edit', 'carritoadd','delete','add','downloadfilefaltastxt','confirmarpedido','search','import','faltas','view','searchproduct','downloadfiletxt']))			
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
	}
	
	public function clientecredito()
	{
		$this->loadModel('ClientesCreditos');
		$clientecreditos = $this->ClientesCreditos->find('all')	
					->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]);
		$clientecredito = $clientecreditos->first();
		$this->set('creditodisponible',$clientecredito['credito_maximo']-$clientecredito['credito_consumo']);
		if ($clientecredito['compra_minima']!=null)
				$this->request->session()->write('compra_minima',$clientecredito['compra_minima']);		
			else
				$this->request->session()->write('compra_minima',500);		
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
		$fech = $fecha->i18nFormat('yyyy-MM-dd');
		$fecha->modify('+1 days');
		$fech2= $fecha->i18nFormat('yyyy-MM-dd');
				
		//echo $fecha->format('Y-m-d') . "\n";
		
		$pedidos = $this->Pedidos->find('all')
								->where(['Pedidos.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
								->andWhere(['Pedidos.creado BETWEEN :start AND :end'])
								->bind(':start', $fech, 'date')
								->bind(':end',   $fech2, 'date');
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
				->where(['Pedidos.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
				->where(['a.descripcion_pag LIKE'=>$termino])
				->orWhere(['a.troquel LIKE'=>$termino])
				->andWhere(["Pedidos.creado BETWEEN '".$fechadesde2->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta2->i18nFormat('yyyy-MM-dd')."'"])
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
		$this->viewBuilder()->layout('store');
      
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
    }

    /**
     * Add method
	 * Envia genera el pedido, separa cada uno de
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
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
			$this->Flash->error(__('El monto de la compra no supera los $'.$this->request->session()->read('compra_minima')),['key' => 'changepass']);
			return $this->redirect($this->referer());
		}
		
		$this->Flash->error(__('En estos momentos nos encontramos actualizando esta sección, intente en 5 minutos. Disculpe las molestias'),['key' => 'changepass']);
		return $this->redirect($this->referer());
		
		if ($carritocon->count()>0)
		{
			$conn = ConnectionManager::get('default');
			
			$cliente_id=$this->request->session()->read('Auth.User.cliente_id');
			$cliente_cod= $this->request->session()->read('Auth.User.codigo');
			$envio = $this->request->data['enviodomicilio'];
			$comentario = $this->request->data['observaciones'];
			$fecha = date('Y-m-d H:i:s');
			// 
			$conn->query('CALL CopiarCarrito('.$cliente_id.');');
			
			$conn->query('CALL actualizarcarritosindescuento('.$cliente_id.');');
			
			//if (($cliente_cod>70000 && $cliente_cod<80000))
			//{
				// Busco el codigo que tiene asociado cliente_export
				// separo por recupera_iva=0
						// separo por tr
						// separo por tl
						// separo por N
				// separo por recupera_iva=1
						// separo por tr
						// separo por tl
						// separo por N
						
			/*$carritotr = $this->Carritos->find('all')	
					->select(['plazoley_dcto'])
					->distinct(['plazoley_dcto'])
					->where(['Carritos.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
					->andWhere(['Carritos.tipo_fact'=>'TR']);
			
			if ($carritotr->count()>0)
			{
				$this->request->session()->write('plazo',$carritotr->toArray());
				foreach ($carritotr as $carrito): 
					$plazo = $carrito['plazoley_dcto'];
					
					$conn->query('CALL ConfirmarPedido('.$cliente_id.','.$envio.','.$envio.',"'.$fecha.'","TR","'.$comentario .'","'.$plazo.'");');
					
				endforeach;
				$stringresult .= "carritotr ".$carritotr->count();
			}
			
			$carritotl = $this->Carritos->find('all')	
					->select(['plazoley_dcto'])
					->distinct(['plazoley_dcto'])
					->where(['Carritos.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
					->andWhere(['Carritos.tipo_fact'=>'TL']);
			
			if ($carritotl->count()>0)
			{
				$this->request->session()->write('plazo2',$carritotl->toArray());
				foreach ($carritotl as $carrito): 
					$plazo = $carrito['plazoley_dcto'];
					
					$conn->query('CALL ConfirmarPedido('.$cliente_id.','.$envio.','.$envio.',"'.$fecha.'","TL","'.$comentario .'","'.$plazo.'");');
				
				endforeach;

				$stringresult .= "carritotl ".$carritotl->count();
			}
			$carriton = $this->Carritos->find('all')	
					->select(['plazoley_dcto'])
					->distinct(['plazoley_dcto'])
					->where(['Carritos.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
					->andWhere(['Carritos.tipo_fact'=>'N']);
			if ($carriton->count()>0)
			{
				$plazo = 'HABITUAL';
				$conn->query('CALL ConfirmarPedidoN('.$cliente_id.','.$envio.','.$envio.',"'.$fecha.'","N","'.$comentario .'","'.$plazo.'");');
				
				$stringresult .= "carriton ".$carriton->count();
			}
				*/
				
				
				// Separo los items el Tipo Oferta TR
			/*	$carritotr = $this->Carritos->find('all')->select(['plazoley_dcto'])->distinct(['plazoley_dcto'])
						->where(['Carritos.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
						->andWhere(['Carritos.tipo_fact'=>'TR']);
				
				if ($carritotr->count()>0)
				{
					//$this->request->session()->write('plazo',$carritotr->toArray());
					foreach ($carritotr as $carrito): 
						$plazo = $carrito['plazoley_dcto'];
						$conn->query('CALL ConfirmarPedidoIsla2('.$cliente_id.','.$cliente_id.','.$envio.','.$envio.',"'.$fecha.'","TR","'.$comentario .'","'.$plazo.'",0,0);');
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
						$conn->query('CALL ConfirmarPedidoIsla2('.$cliente_id.','.$cliente_id.','.$envio.','.$envio.',"'.$fecha.'","TL","'.$comentario .'","'.$plazo.'",0,0);');
					endforeach;
				}
				
				// Separo los items el Tipo Oferta N
				$carriton = $this->Carritos->find('all')->select(['plazoley_dcto'])->distinct(['plazoley_dcto'])
						->where(['Carritos.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
						->andWhere(['Carritos.tipo_fact'=>'N']);
				if ($carriton->count()>0)
				{
					$plazo = 'HABITUAL';
					$conn->query('CALL ConfirmarPedidoIsla2('.$cliente_id.','.$cliente_id.','.$envio.','.$envio.',"'.$fecha.'","N","'.$comentario .'","'.$plazo.'",0,1);');
				}
			
			
			}
			else
			{*/
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
				//$carritotl = $this->Carritos->find('all')->select(['plazoley_dcto'])->distinct(['plazoley_dcto'])
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
						$conn->query('CALL ConfirmarPedidoIsla('.$cliente_id.','.$cliente_id.','.$envio.','.$envio.',"'.$fecha.'","TL","'.$comentario2 .'","'.$plazo.'",0,0);');
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
			
			
			//}
			
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
						str_pad($row['cantidad'], 4, "0", STR_PAD_LEFT).
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
		'limit' => 11,
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
						'd.tipo_oferta in ("RV","RR","OR","TD")'
						]		
					]
					);
		
		
		//'conditions' => 'd.articulo_id = Articulos.id and CURRENT_DATE() <= d.fecha_hasta and d.tipo_venta in ("D ","  ")',
		$articulosA->where(["p.creado BETWEEN '".$fechadesde->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta->i18nFormat('yyyy-MM-dd')."'"])
				->andWhere(["pe.nro_pedido_ds IS NOT NULL"])
				->andWhere(["pe.cantidad_facturada"=>0])
				->andWhere(['Articulos.stock'=>'S']);
				
				
		
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
			$fechahasta2 = Time::now();
			
			$fechahasta2->modify('+1 days');
			$fechahasta2->i18nFormat('yyyy-MM-dd');
			$fechadesde2 = Time::now();
			$fechadesde2->modify('-7 days');
			
			$fechadesde2->i18nFormat('yyyy-MM-dd');

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
				->select(['id',	'creado', 'c.codigo','c.razon_social', 'sucursal_id', 'tipo_fact', 'forma_envio', 'estado_id','nro_pedido_ds','comentario','impreso','pedidos_status_id'])
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
		$this->set('titulo','Lista de pedidos');
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
}
