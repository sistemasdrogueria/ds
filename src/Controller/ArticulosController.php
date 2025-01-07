<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\ORM\Query;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
/**
 * Articulos Controller
 *
 * @property \App\Model\Table\ArticulosTable $Articulos
 */
class ArticulosController extends AppController
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
		 if (in_array($this->request->action, ['index_admin','edit_admin', 'delete','add','nuevos','index_imagen','imagenesreset','imagenreset','ordenupdate','search_articulos','buscar','buscarfactura'])) {
       
            if($this->request->session()->read('Auth.User.role')=='admin') 
            {				
                return true;			
            }			
            else 
            {	
                if($this->request->session()->read('Auth.User.role')=='client') 
                {				
					$tiene= $this->tienepermiso('articulos',$this->request->action);
					if (!$tiene)
						$this->Flash->error(__('No tiene permisos para ingresar'),['key' => 'changepass']);
					return $tiene;					
                }	
                else
                {
					if($this->request->session()->read('Auth.User.role')=='provider') 
					{
					
						$this->redirect(array('controller' => 'Articulos', 'action' => 'index_admin'));	
						return false;						
					}
					else
					{

						if($this->request->session()->read('Auth.User.role')=='deposit') 
					{
					
						//$this->redirect(array('controller' => 'Articulos', 'action' => 'search_articulos'));	
						return true;						
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
            }		
			
		return parent::isAuthorized($user);
    }

	public function index_imagen()
    {

		//
		$this->viewBuilder()->layout('admin');
		$this->paginate = [
            'contain' => ['Laboratorios','Categorias'],
			'limit' => 200 , 'maxLimit' => 5000
        ];
        //$this->set('_serialize', ['articulos']);
		$this->set('titulo','Articulos');
		$this->categoriaylaboratorio();
		
		$articulosA = $this->Articulos->find()
						->where(['Articulos.eliminado'=>0])
						->andWhere(['Articulos.imagen NOT IN ("sinimagen.png","medicamento.jpg","perfumeria.jpg")','codigo_barras != REPLACE(imagen, ".jpg", "")']);

		$articulos = $this->paginate($articulosA);
			
		$this->set(compact('articulos'));
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
	
	public function clientecredito()
	{
		$this->loadModel('ClientesCreditos');
		if ($this->request->session()->read('Auth.User.cliente_id') !=36231)
			 $cliente = $this->request->session()->read('Auth.User.cliente_id');
		 else
			 $cliente = 36230;
		
		$clientecreditos = $this->ClientesCreditos->find('all')	
					->where(['cliente_id' => $cliente]);
		
		$clientecredito = $clientecreditos->first();
		
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
    public function index_admin()
    {

		//SELECT id,descripcion_sist, codigo_barras , REPLACE(imagen, '.jpg', '') AS nombre_imagen, fecha_alta FROM articulos WHERE imagen NOT IN ("sinimagen.png","perfumeria.jpg","medicamento.jpg") AND codigo_barras != REPLACE(imagen, '.jpg', '') 

		$this->viewBuilder()->layout('admin2');
		$this->paginate = [
            'contain' => ['Laboratorios','Categorias','Subcategorias'],
			'limit' => 500 , 'maxLimit' => 1000, 'order' => array('Articulos.fecha_alta' => 'DESC')
        ];
        //$this->set('_serialize', ['articulos']);
		$this->set('titulo','Articulos');
		$this->categoriaylaboratorio();
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
			if ($this->request->data['subcategoria_id']!= null)
			{
				$subcategoriaid = $this->request->data['subcategoria_id'];
			}	
			else
			{
				$subcategoriaid=0;
			}
			if ($this->request->data['laboratorio_id']!= null)
			{
				$laboratorioid = $this->request->data['laboratorio_id'];
			}	
			else
			{
				$laboratorioid =0;
			}
			if ($this->request->data['marca_id']!= null)
			{
				$marcaid = $this->request->data['marca_id'];
			}	
			else
			{
				$marcaid =0;
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
			$this->request->session()->write('marcaid',$marcaid);
			$this->request->session()->write('subcategoriaid',$subcategoriaid);
		}
		else 
		{
			$categoriaid = $this->request->session()->read('categoriaid');
			$subcategoriaid = $this->request->session()->read('subcategoriaid');
		    $laboratorioid = $this->request->session()->read('laboratorioid');
			$termsearch = $this->request->session()->read('termsearch');
			$marcaid = $this->request->session()->read('marcaid');
			
		}
		
		$articulosA = $this->Articulos->find()
						->where(['Articulos.eliminado'=>0]);
				
		if ($termsearch!="")
		{
			if ($termsearch=="%imagen%")
			$articulosA->andWhere(['Articulos.imagen NOT IN ("sinimagen.png","medicamento.jpg","perfumeria.jpg")']);
			else
			if ($termsearch=="%sinimagen%")
			$articulosA->andWhere(['Articulos.imagen NOT IN ("sinimagen.png","medicamento.jpg","perfumeria.jpg")']);
			
			else
			$articulosA->andWhere([
					'OR' => [['Articulos.descripcion_pag LIKE'=>$termsearch], 
					['Articulos.troquel LIKE'=>$termsearch],['Articulos.codigo_barras LIKE'=>$termsearch],['Articulos.codigo_barras2 LIKE'=>$termsearch],['Articulos.codigo_barras3 LIKE'=>$termsearch]],
				]);
		}	
		
		
		if ($categoriaid !=0) 
			$articulosA->andWhere(['Articulos.categoria_id'=>$categoriaid]);
			if ($subcategoriaid !=0) 
			$articulosA->andWhere(['Articulos.subcategoria_id'=>$subcategoriaid]);
		if ($laboratorioid !=0)
			$articulosA->andWhere(['Articulos.laboratorio_id'=>$laboratorioid]);	
		
			if ($marcaid !=0)
			$articulosA->andWhere(['Articulos.marca_id'=>$marcaid]);	
		
			//$articulosA->order(['fecha_alta'=>'DESC']);
			$articulos = $this->paginate($articulosA);
			$this->loadModel('Marcas');
			$marcas = $this->Marcas->find('list',['keyField' => 'id','valueField'=>'nombre'])->where(['marcas_tipos_id not in (10,11,12)'])->order(['nombre'=>'ASC']);
			$this->set('marcas', $marcas->toArray());
			$this->set('_serialize', ['marcas']);
			
			$this->loadModel('Subcategorias');
			$subcategorias = $this->Subcategorias->find('list',['keyField' => 'id','valueField'=>'nombre'])->order(['nombre'=>'ASC']);
			$this->set('subcategorias', $subcategorias->toArray());
			$this->set('_serialize', ['subcategorias']);

			$this->set(compact('articulos'));
    }

	public function search_articulos()
    {
		$this->viewBuilder()->layout('admin_depo');
			$this->categoriaylaboratorio();
	
    }

	public function buscar(){

		if($this->request->is(['ajax'])){
		$this->viewBuilder()->layout('busquedajaxadmin');

		$this->request->allowMethod(['ajax', 'post']);
		$this->loadModel('Articulos');
		$this->loadModel('AlfabetaArticulosExtras');

		$this->paginate = [
			'limit' => 1000, 'maxLimit' => 1000, 'offset' => 0,
			'order' => ['Articulos.descripcion_pag' => 'asc']
		];
		$terminobuscar = $this->request->data('terminobuscar');

		if ($terminobuscar == '' ) {

			$query = '';
			$this->set('articulos', null);
		} else {

			$query = $this->Articulos->find()
				->hydrate(false);
	
			if ($terminobuscar != "") {

				$terminocompleto = explode(" ", $terminobuscar);
				$termsearch ="";
				if (count($terminocompleto)>1)
				{
						foreach ($terminocompleto as $terminosimple): 
							$termsearch = $termsearch.'%'.$terminosimple.'%';
						endforeach; 
				}
				else{	$termsearch = '%' . $terminocompleto[0] . '%';}


				$query->andwhere(['OR' => [['Articulos.descripcion_pag LIKE'=>$termsearch], 
				['Articulos.troquel LIKE'=>$termsearch],['Articulos.codigo_barras LIKE'=>$termsearch],['Articulos.codigo_barras2 LIKE'=>$termsearch],['Articulos.codigo_barras3 LIKE'=>$termsearch]], 'eliminado' => 0]);
			
			}
			$this->set('articulos', $this->paginate($query));
			$this->set('_serialize', ['articulos']);
		}
	}
}


public function buscarfactura(){

		if($this->request->is(['ajax'])){
		$this->viewBuilder()->layout('busquedajaxadmin');

		$codigocliente = $this->request->data('codigocliente');			
		$notacomprobante = $this->request->data('notacomprobante');
		$numerocomprobante = $this->request->data('numerocomprobante');

		$this->request->allowMethod(['ajax', 'post']);
		$this->loadModel('Clientes');
		$this->loadModel('Comprobantes');
		$this->loadModel('FacturasCabeceras');
		$this->loadModel('FacturasCuerposItems');


	
		if ($codigocliente == '' && $notacomprobante =='' && $numerocomprobante == '' ) {
			$query = null;
		
		} else {

			$cliente = $this->Clientes->find()
				->where(['codigo'=>$codigocliente])->first();
			 if(!is_null($cliente)){
				$idcliente = $cliente['id'];
				$clientenombre= $cliente['nombre'];	
			 }
		 
		 if($cliente != null){
					
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
				->where(['FacturasCabeceras.cliente_id' => $cliente['id'],'c.nota'=>$notacomprobante,'c.numero'=>$numerocomprobante,'c.cliente_id'=>$idcliente])
				->order(['FacturasCabeceras.fecha' => 'ASC'])->group('c.id');		
	
	if(!is_null($query)){
				$this->set('articulosf',$query->toArray());
				$this->set('clientenombre',$clientenombre);	
				$this->set('cliente',$cliente);	
				$this->set('_serialize', ['articulosf']);
				}else{
				$this->set('articulosf', null);
				$this->set('clientenombre',null);	
				$this->set('cliente', null);	
				}	
	
		}
		}

		
	}
}

public function ordenupdate() {
	$this->loadComponent('RequestHandler');
	if ($this->request->is(['ajax','post'])) {
		$id = $this->request->data['id'];
		$quantity = isset($this->request->data['quantity']) ? $this->request->data['quantity'] : 1;
				
		$articulo = $this->Articulos->get($id, [
			'contain' => []
		]);
		$articulo['fp_orden'] = $quantity;

			if ($this->Articulos->save($articulo)) {
	
						$responseData = ['success' => true,'responseText'=>"'Se modifico la cantidad correctamente.'",'status'=>200,'articulo'=>$articulo ];		

				
			} 
			else
			{
						$responseData = ['success' => false, 'responseText'=>"'No se pudo modificar la cantidad correctamente,'",'status'=>400 ];
									
			}

			echo json_encode($responseData);

			//echo json_encode($carro);
			$this->set('responseData', $responseData);
			$this->set('articulo', $articulo);
			$this->set('_serialize', ['responseData','articulo']);
			//echo json_encode($carro);
		//$product = $this->Cart->add($id, $quantity, $productmodId);
	}
	//$cart = $this->CarritosPreventas->getcart();
	
	die;
}	
public function imagenesreset($id = null)
    {
		//$this->loadModel('CarritosTemps');

		//$articulos = TableRegistry::get('Articulos');
		$entities = $this->request->data();
		
		
		//$this->request->session()->write('entities',$entities);
		foreach ($entities as $articulo) {
				
				
				$eliminar= (int)$articulo['eliminado'];
				$id=(int)$articulo['id'];
				if ($eliminar>0)
				{
				$articulo2 = $this->Articulos->get($id);
				$articulo2['imagen']= 'sinimagen.png';
				if ($this->Articulos->save($articulo2)) {
					$this->Flash->success('Se borro la imagen.',['key' => 'changepass']);
				} else {
					$this->Flash->error('No se pudo borrar la imagen, intente de nuevo',['key' => 'changepass']);
				}
				}
				else
				$this->Flash->error('No se pudo borrar la imagen, intente de nuevo'+$id+ ' '+$eliminar,['key' => 'changepass']);
				
			
		
		}

		$this->redirect($this->referer());

        
    }

	public function nuevos()
    {
		$this->viewBuilder()->layout('store');
		
        $this->paginate = [		
		'contain' => ['Descuentos'],
		'limit' => 90,
		'offset' => 0, 
        'order' => ['Articulos.descripcion_pag' => 'asc']];

		$this->clientecredito();
		$carritos = $this->sumacarrito();
		$this->categoriaylaboratorio();
		
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
			$this->request->session()->write('termsearchn',$termsearch);
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
			if (!empty($this->request->session()->read('termsearchn')))
				if ($termsearch =="") $termsearch = $this->request->session()->read('termsearchn');
		}

		$fecha = Time::now();
		$fecha = $fecha->i18nFormat('yyyy-MM-dd');
		
	  	$articulosA = $this->Articulos->find()
				->contain(['Carritos' => [
						
						'queryBuilder' => function ($q) {
							return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); // Full conditions for filtering
						}
					]
				])
				->hydrate(false)
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
					)
					->where(['Articulos.nuevo'=>1,'Articulos.eliminado'=>0]);
		
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
										$articulosA->andWhere(['Articulos.eliminado'=>0]);
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

	public function search()
    {
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
			if ($this->request->data['ofertas']!= null)
			{
				$ofertas = $this->request->data['ofertas'];
			}	
			else
				{
				$ofertas =0;
			}
			
			if ($this->request->data['terminobuscar']!= null)
			{
				$termsearch = '%'.$this->request->data['terminobuscar'].'%';
			}	
			else
			{
				$termsearch ="";
			}	
			
			$this->request->session()->write('ofertas',$ofertas);
			$this->request->session()->write('termsearch',$termsearch);
			$this->request->session()->write('categoriaid',$categoriaid);	
			$this->request->session()->write('laboratorioid',$laboratorioid);
		}
		else 
		{
			$categoriaid = $this->request->session()->read('categoriaid');
		    $laboratorioid = $this->request->session()->read('laboratorioid');
			$termsearch = $this->request->session()->read('termsearch');
			$ofertas = $this->request->session()->read('ofertas');
		}
		$this->layout = 'store';
		//,'Carritos'
        $this->paginate = [		
		'contain' => ['Laboratorios','Categorias','Descuentos','Carritos'],
		'limit' => 11,
		'offset' => 0, 
        'order' => ['Articulos.descripcion_pag' => 'asc']];
				
		$this->categoriaylaboratorio();
		$this->clientecredito();
		$this->sumacarrito();
		$this->loadModel('Articulos');
	  	$articulosA = $this->Articulos->find()
				
				->hydrate(false)
					->join([
						'table' => 'descuentos',
						'alias' => 'd',
						'type' => 'LEFT',
						 'conditions' => [
						'd.articulo_id = Articulos.id',
						'd.tipo_venta = "D"',
						'd.fecha_hasta >=' => '2015-01-01',
						'd.tipo_oferta in ("RV","RR","OR","TD")'
						]		
					]
					)
					->join([
						'table' => 'carritos',
						'alias' => 'c',
						'type' => 'LEFT',
						'conditions' => [
						'c.articulo_id = Articulos.id',
						'c.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]		
					]		
					);
					
		if ($termsearch!="")
		{
			$articulosA->andWhere([
					
					'OR' => [['Articulos.descripcion_pag LIKE'=>$termsearch], 
					['Articulos.troquel LIKE'=>$termsearch],['Articulos.codigo_barras LIKE'=>$termsearch]],
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
					else
					{
						if ($ofertas ==0)
						{
							$articulosA=null;
							$this->redirect($this->referer());
						}
					}
				}
			}		
		}
		if ($ofertas!=0)
		{			
			if ($ofertas==1)			
			{
				$articulosA->andWhere([
					
					'OR' => [['d.tipo_oferta'=>"RR"], 
					['d.tipo_oferta'=>"RV"]],
				]);
				
			}
			else
			if ($ofertas==2)			
			{
				$articulosA->andWhere([
					
					'OR' => [['d.tipo_oferta'=>"OR"], 
					['d.tipo_oferta'=>"TD"]],
				]);
		
			}
			else
			if ($ofertas==3)			
			{
				$articulosA->andWhere([
					
					'OR' => [['d.tipo_oferta'=>"OR"], 
					['d.tipo_oferta'=>"TD"],
					['d.tipo_oferta'=>"RR"], 
					['d.tipo_oferta'=>"RV"]					
					]
				]);
		
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
     * View method
     *
     * @param string|null $id Articulo id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $articulo = $this->Articulos->get($id, [
            'contain' => ['Categorias',  'Laboratorios', 'CarritosItems', 'Descuentos', 'Ofertas', 'PedidosItems', 'ReclamosItems']
        ]);
        $this->set('articulo', $articulo);
        $this->set('_serialize', ['articulo']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     
    public function add()
    {
        $articulo = $this->Articulos->newEntity();
        if ($this->request->is('post')) {
            $articulo = $this->Articulos->patchEntity($articulo, $this->request->data);
            if ($this->Articulos->save($articulo)) {
                $this->Flash->success('The articulo has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The articulo could not be saved. Please, try again.');
            }
        }
        $categorias = $this->Articulos->Categorias->find('list', ['limit' => 200]);
        $subcategorias = $this->Articulos->Categorias->find('list', ['limit' => 200]);
        $laboratorios = $this->Articulos->Laboratorios->find('list', ['limit' => 200]);
        $this->set(compact('articulo', 'categorias', 'laboratorios'));
        $this->set('_serialize', ['articulo']);
    }
	*/
    /**
     * Edit method
     *
     * @param string|null $id Articulo id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */

    public function edit_admin($id = null)
    {
		$this->set('titulo','Modificar Articulo - IMAGEN Y VC');
		$this->viewBuilder()->layout('admin2');
        $articulo = $this->Articulos->get($id, [
			'contain' => ['Categorias',  'Laboratorios','Subcategorias','Proveedors'] 
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $articulo = $this->Articulos->patchEntity($articulo, $this->request->data);
			
			$uploadData = '';
			if(!empty($this->request->data['file']['name'])){
                $fileName = $articulo['codigo_barras'].'.jpg';
                $uploadPath = 'img/productos/';
                $uploadFile = $uploadPath.$articulo['codigo_barras'].'.jpg';
				$articulo['imagen']= $fileName;
                if(move_uploaded_file($this->request->data['file']['tmp_name'],$uploadFile)){
                    $uploadData = $this->Files->newEntity();
                    $uploadData->name = $fileName;
                    $uploadData->path = $uploadPath;
                    $uploadData->created = date("Y-m-d H:i:s");
                    $uploadData->modified = date("Y-m-d H:i:s");
                    if ($this->Files->save($uploadData)) {
                        //$this->Flash->success(__('File has been uploaded and inserted successfully.'),['key' => 'changepass']);
                    }else{
                        $this->Flash->error(__('Unable to upload file, please try again.'),['key' => 'changepass']);
						$this->redirect($this->referer());
                    }
                }else{
                    $this->Flash->error(__('Unable to upload file, please try again.'),['key' => 'changepass']);
					$this->redirect($this->referer());
                }
            }/*else{
                $this->Flash->error(__('Please choose a file to upload.'),['key' => 'changepass']);
				$this->redirect($this->referer());
            }*/
			if(!empty($this->request->data['file2']['name'])){
                $fileName = 'big_'.$articulo['codigo_barras'].'.jpg';
                $uploadPath = 'img/productos/';
                $uploadFile = $uploadPath.'big_'.$articulo['codigo_barras'].'.jpg';
				//$articulo['imagen']= $fileName;
                if(move_uploaded_file($this->request->data['file2']['tmp_name'],$uploadFile)){
                    $uploadData = $this->Files->newEntity();
                    $uploadData->name = $fileName;
                    $uploadData->path = $uploadPath;
                    $uploadData->created = date("Y-m-d H:i:s");
                    $uploadData->modified = date("Y-m-d H:i:s");
                    if ($this->Files->save($uploadData)) {
                        //$this->Flash->success(__('File has been uploaded and inserted successfully.'),['key' => 'changepass']);
                    }else{
                        $this->Flash->error(__('Unable to upload file, please try again.'),['key' => 'changepass']);
						$this->redirect($this->referer());
                    }
                }else{
                    $this->Flash->error(__('Unable to upload file, please try again.'),['key' => 'changepass']);
					$this->redirect($this->referer());
                }
            }
				/*else{
                $this->Flash->error(__('Please choose a file to upload.'),['key' => 'changepass']);
				$this->redirect($this->referer());
            }*/
			if ($articulo['fv_cerca']==0 && $articulo['fv']!=null)
			$articulo['fv']=null;

            if ($this->Articulos->save($articulo)) {
                $this->Flash->success('The articulo has been saved.',['key' => 'changepass']);
                return $this->redirect(['action' => 'index_admin']);
            } else {
                $this->Flash->error('The articulo could not be saved. Please, try again.',['key' => 'changepass']);
            }
        }
        $this->set(compact('articulo'));
        $this->set('_serialize', ['articulo']);
		
		$this->loadModel('Marcas');
		$marcas = $this->Marcas->find('list',['keyField' => 'id','valueField'=>'nombre'])->where(['marcas_tipos_id not in (10,11,12)'])->order(['nombre'=>'ASC']);
		$this->set('marcas', $marcas->toArray());
		$this->set('_serialize', ['marcas']);
		
		$this->loadModel('Grupos');
		$grupos = $this->Grupos->find('list',['keyField' => 'id','valueField'=>'nombre'])->order(['nombre'=>'ASC']);
		$this->set('grupos', $grupos->toArray());
		$this->set('_serialize', ['grupos']);
		$this->loadModel('Subgrupos');
		$subgrupos = $this->Subgrupos->find('list',['keyField' => 'id','valueField'=>'nombre'])->order(['nombre'=>'ASC']);
		$this->set('subgrupos', $subgrupos->toArray());
		$this->set('_serialize', ['subgrupos']);
		
	}
	
	
	public function imagenreset($id = null)
    {
       // $this->request->allowMethod(['post', 'delete']);
		$articulo = $this->Articulos->get($id);
		$articulo['imagen']= 'sinimagen.png';

        if ($this->Articulos->save($articulo)) {
            $this->Flash->success('Se borro la imagen.',['key' => 'changepass']);
        } else {
            $this->Flash->error('No se pudo borrar la imagen, intente de nuevo',['key' => 'changepass']);
		}
		return $this->redirect($this->referer());
        
    }
    /**
     * Delete method
     *
     * @param string|null $id Articulo id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
    
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $articulo = $this->Articulos->get($id);
        if ($this->Articulos->delete($articulo)) {
            $this->Flash->success('The articulo has been deleted.');
        } else {
            $this->Flash->error('The articulo could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
	*/
}