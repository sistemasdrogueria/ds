<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Filesystem\File;
use Cake\Network\Request;
use Cake\Database\Expression\QueryExpression;
use Cake\Datasource\ConnectionManager;
//use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

use PhpOffice\PhpSpreadsheet\IOFactory;
use Cake\ORM\TableRegistry;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Helper;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Cake\Routing\Router;
require ROOT.DS.'vendor' .DS. 'phpoffice/phpspreadsheet/src/Bootstrap.php';
/**
 * Carritos Controller
 *
 * @property \App\Model\Table\CarritosTable $Carritos
 */
class CarritosController extends AppController
{
	public function isAuthorized()
    {
		if (in_array($this->request->action, ['searchadd','pami','ofertavc','edit', 'delete','delete_temp','add','search','vaciar','confirm','import','importresult','importresultexcel','index','home','carritoadd','carritoaddall','downloadfile','carritoaddoferta','vaciarimport','carritotempadd','carritotempaddall','importconfirm','view','excel','fraganciaselectiva','resultfraganciaselectiva','sale','farmapoint','promocion','insumos','blackfriday'])) {
       
				if($this->request->session()->read('Auth.User.role')=='admin') 
				{				
					return true;			
				}			
				else 
				{	
					if($this->request->session()->read('Auth.User.role')=='client') 
					{	
						$tiene= $this->tienepermiso('carritos',$this->request->action);
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
/*
	public function sumacarrito()
	{
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
	*/
	public function sumacarrito()
	{
		/*
		$carritocon = $this->Carritos->find('all')
					->contain(['Articulos'])
					->where(['Carritos.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
					->order(['Carritos.cantidad  < Carritos.unidad_minima '=> 'DESC','Carritos.id' => 'DESC']);
		
		$this->set('carritos', $carritocon->toArray());
		*/
		$carritocon1 = $this->Carritos->find('all')
		->contain(['Articulos'])
		->where(['Carritos.cliente_id' => $this->request->session()->read('Auth.User.cliente_id'),'Carritos.cantidad  < Carritos.unidad_minima', 'Carritos.unidad_minima IS NOT NULL' ])
		->order(['Carritos.id' => 'DESC']);

		$carritocon2 = $this->Carritos->find('all')
				->contain(['Articulos'])
				->where(['Carritos.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
				->andWhere([
				
					'OR' => [['Carritos.cantidad  >= Carritos.unidad_minima '], 
					['Carritos.unidad_minima IS NULL']]
				])
				->order(['Carritos.id' => 'DESC']);
		$c1 = $carritocon1->toArray();
		$c2 = $carritocon2->toArray();
		$carritocon = array_merge($c1,$c2);
		$this->set('carritos', $carritocon);



		$descuento_pf = $this->request->session()->read('Auth.User.pf_dcto');
		$descuento_pf2= $descuento_pf;
		$condicion 	  = $this->request->session()->read('Auth.User.condicion');
		$coef         = $this->request->session()->read('Auth.User.coef');
		
		$condiciongeneral = 100*(1-($descuento_pf * (1-$condicion/100)));

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
	//if ($carrito['articulo']['laboratorio_id']===15) $coef2 = 0.892; 
	
	
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
				if ($carrito['articulo']['iva'] ==1)
					$precio = $precio/(1.21);
				
				$precio  = $precio*$descuento_pf*$coef2;
				if ($carrito['articulo']['msd']!=1)
				$precio -= $precio*$condicion/100;
				$subtotal = $precio*$cant_carrito; 
			 }
		}
		
		else
		{
		//TIPO_PRECIO F
			if ($carrito['tipo_precio']=='F')
			{
				$precio  = $carrito['precio_publico'];
				if ($carrito['articulo']['iva'] ==1) 
				$precio = $precio/(1.21);
					
				if ($cant_carrito>=$cant_uni_min)
				{
					$descuentooferta = $carrito['descuento'];
					$precio  = $precio*$descuento_pf * $coef2;
					$precio -= $precio*$condicion/100;
					$precio -= $precio*$descuentooferta/100;
					$subtotal = $precio*$cant_carrito;
				}
				else
				{
					
					if ($carrito['articulo']['mcdp']==0)
						{
							$precio  = $precio*$descuento_pf * $coef2;
							if ($carrito['articulo']['msd']!=1){
								$precio -= $precio*$condicion/100;
							}
						}
						else
						{
							$precio -= $precio*($condiciongeneral-1)/100;
						}
						$subtotal = $precio*$cant_carrito;
					
					//$subtotal = $precio*$descuento_pf*$coef2*$cant_carrito; 
					
				}
			}
		}
		}
		else
		{
			$precio  = $carrito['precio_publico'];
			if ($carrito['articulo']['mcdp']==0)
			{
				$precio  = $precio*$descuento_pf * $coef2;
				if ($carrito['articulo']['msd']!=1){
					$precio -= $precio*$condicion/100;
				}
			}
			else
			{
				$precio -= $precio*($condiciongeneral-1)/100;
			}
			$subtotal = $precio*$cant_carrito;
			
			
		}
	}
	else
	{
		$precio = $carrito['precio_publico'];
		if ($carrito['articulo']['iva'] ==1)
				$precio = $precio/(1.21);
		
				if ($carrito['articulo']['mcdp']==0)
				{
					$precio  = $precio*$descuento_pf * $coef2;
					if ($carrito['articulo']['msd']!=1){
						$precio -= $precio*$condicion/100;
					}
				}
				else
				{
					$precio -= $precio*($condiciongeneral-1)/100;
				}
				$subtotal = $precio*$cant_carrito;		

		
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
		if ($carrito['articulo']['id']>27338 && $carrito['articulo']['id']<27345)
				$descuento_pf =0.807;
				else
				$descuento_pf= $descuento_pf2;

		$precio = $carrito['precio_publico']*$descuento_pf*$coef;
		$subtotal = $precio * $cant_carrito;
	}
}
		$totalcarrito= $totalcarrito +$subtotal;
			
			
			
		endforeach; 
		$this->set('totalitems',$totalitems);
		$this->set('totalcarrito',$totalcarrito);
		$this->set('totalunidades',$totalunidades);
		$this->set('carritos', $carritocon);
		//$this->set('carritos', $carritocon->toArray());
		return $carritocon;
	}
	
	public function promocion($lab_id = null,$tipo_oferta = null,$termsearch=null,$indice = null ){
		$this->viewBuilder()->layout('storefp');
		$this->paginate = [		
			'contain' => [],
			'limit' => 82,
			'offset' => 0, 
			'order' => ['Articulos.descripcion_pag' => 'asc']];			
		$this->clientecredito();
		$this->sumacarrito();	
		$this->loadModel('Articulos');
		$this->loadModel('Carritos');
		//$this->categoriaylaboratorio2();	
		if ($tipo_oferta!='TD' && $tipo_oferta!='TH' && $tipo_oferta!='OR'&& $lab_id!= 135 )
		{
			$this->categoriaylaboratorio();	
			if ($tipo_oferta!='P') 
			{
			$articulos = $this->Articulos->find('all')
					->contain(['Descuentos' => [
						
						'queryBuilder' => function ($q) {
							return $q->where(['tipo_oferta in ("TD","BF","RV")']); // Full conditions for filtering
						}
					]
					,'Carritos' => [
						
						'queryBuilder' => function ($q) {
							return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); // Full conditions for filtering
						}
					]
				])
					
					
				->hydrate(false)
					->join([
						'table' => 'descuentos',
						'alias' => 'd',
						'type' => 'INNER',
						 'conditions' => [
						'd.articulo_id = Articulos.id',
						'd.tipo_venta = "D"',
						'd.tipo_oferta' => $tipo_oferta
						 ]	
					]
					)
					
				->where(['Articulos.laboratorio_id'=>$lab_id,'Articulos.eliminado'=>0,'Articulos.stock <> "F"','Articulos.stock <>"D"'
					])
				->andWhere(['Articulos.descripcion_pag LIKE'=>'%'.$termsearch.'%'])
				//->where(['Articulos.imagen NOT IN ("sinimagen.png","perfumeria.jpg","medicamento.jpg")'])
				->order(['Articulos.descripcion_sist' => 'ASC']);

				$this->request->session()->write('articulosxx',$articulos->toArray());
			}
			else
			{
				$articulos = $this->Articulos->find('all')
				->contain(['Descuentos','Carritos' => [
						
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
						'd.tipo_venta = "D"'
						 ]	
					]
					)
					
				->where(['Articulos.laboratorio_id'=>$lab_id,'Articulos.eliminado'=>0,'Articulos.stock <> "F"','Articulos.stock <>"D"'])
				->andWhere(['Articulos.descripcion_pag LIKE'=>$termsearch.'%'])
				//->where(['Articulos.imagen NOT IN ("sinimagen.png","perfumeria.jpg","medicamento.jpg")'])
				->order(['Articulos.descripcion_sist' => 'ASC']);
				$articulos = $this->paginate($articulos);
				$this->request->session()->write('articulosxx',$articulos->toArray());
						 
				}
			}
				else
				{
					$this->categoriaylaboratorio2();	
					
					$fecha = Time::now();
					
						$articulosA = $this->Articulos->find()
								->contain(['Laboratorios','Descuentos','Carritos' => [
									
									'queryBuilder' => function ($q) {
										return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); // Full conditions for filtering
									}
								]
							])
							->hydrate(false)
								->join([
									'table' => 'descuentos',
									'alias' => 'd',
									'type' => 'INNER',
									 'conditions' => [
									'd.articulo_id = Articulos.id',
									'd.tipo_venta = "D"',
									'd.fecha_hasta >=' => $fecha->i18nFormat('yyyy-MM-dd'),
									'd.tipo_oferta in ("TD","OR","RL","RV","TH")'
									]
								]
								)
								->where(['Articulos.eliminado'=>0])
								->andWhere(['Articulos.laboratorio_id'=>$lab_id]);
				
			
					if ($articulosA!=null)
					{
						$limit =100;
						if ($articulosA->count()<100 && $articulosA->count()>50 )
						{
							$limit = 150;
						}
						if ($articulosA->count()>100 )
						{
							$limit= 300;
						}
						
						$this->paginate = [		
						'limit' => $limit,
						'offset' => 0, 
						];
					
						$articulosA->andWhere(['Articulos.eliminado'=>0])->group(['Articulos.id'])
									->order(['Laboratorios.nombre'=>'asc','d.tipo_precio'=>'asc','Articulos.descripcion_pag' => 'asc']);
						$articulos = $this->paginate($articulosA);
			
				}
			}
			$this->set('indice',$indice);
				$this->set('tipo_oferta',$tipo_oferta);
		/*
		$connection = ConnectionManager::get('default');

			$ofertas = $connection->execute('SELECT ofertas.*,articulos.id AS articuloid, articulos.precio_publico, articulos.categoria_id, articulos.compra_max, 
		  descuentos.dto_drogueria, descuentos.articulo_id, descuentos.plazo, descuentos.uni_min, descuentos.tipo_oferta, descuentos.tipo_venta, descuentos.tipo_precio ,ofertas.oferta_tipo_id 
		  FROM ofertas LEFT JOIN articulos on articulos.id = ofertas.articulo_id INNER JOIN descuentos on descuentos.articulo_id =  articulos.id and 
		  descuentos.tipo_venta = "D" and	descuentos.fecha_hasta >=CURRENT_DATE() and	descuentos.tipo_oferta in ("RV","RR","OR","TD","RL","FR","FP") where ofertas.activo=1 and articulos.stock<>"F" and articulos.imagen NOT IN ("sinimagen.png","perfumeria.jpg","medicamento.jpg" ORDER BY ofertas.id DESC ' )->fetchAll('assoc');
		*/
		/*	$connection = ConnectionManager::get('default');
		$ofertas = $connection->execute('SELECT ofertas.*,articulos.id AS articuloid, articulos.precio_publico, articulos.laboratorio_id, articulos.categoria_id,  articulos.compra_max, articulos.msd, 
		  descuentos.dto_drogueria, descuentos.articulo_id, descuentos.plazo, descuentos.uni_min, descuentos.tipo_oferta, descuentos.tipo_venta, descuentos.tipo_precio ,ofertas.oferta_tipo_id 
		  FROM ofertas LEFT JOIN articulos on articulos.id = ofertas.articulo_id INNER JOIN descuentos on descuentos.articulo_id =  articulos.id and 
		  descuentos.tipo_venta = "D" and	descuentos.fecha_hasta >=CURRENT_DATE() and	descuentos.tipo_oferta in ("RV","RR","OR","TD","RL","FR") where ofertas.activo=1 and articulos.stock<>"F" ORDER BY ofertas.id DESC ' )->fetchAll('assoc');
	
		
		$this->set('ofertas',$ofertas);
		*/
		
				
			
		$this->set(compact('articulos'));
		$this->set('_serialize', 'articulos');
		$this->set('lab_id',$lab_id);


	}

	public function farmapoint()
    {
		$this->viewBuilder()->layout('storefp');
        if ($this->request->session()->read('Auth.User.farmapoint')==0)
			$this->redirect($this->referer());
		
			$this->loadModel('LogsAccesos');
			$logsAcceso = $this->LogsAccesos->newEntity();
			
			$logsAcceso['fecha'] = date('Y-m-d H:i:s');
			//debug(date('Y-m-d H:i:s'));
			$logsAcceso['usuario_id'] = $this->request->session()->read('Auth.User.id');
			$logsAcceso['ip'] = $this->request->clientIp(); 
			$logsAcceso['seccion']=1;
			if ($this->LogsAccesos->save($logsAcceso))
			{
			}	

		$this->clientecredito();
		$this->sumacarrito();	
	
		$this->loadModel('Articulos');
		
		$articulos = $this->Articulos->find('all')
					->contain(['Descuentos' => [
						
						'queryBuilder' => function ($q) {
							return $q->where(['tipo_oferta = "FP"']); // Full conditions for filtering
						}
					]
				])
					
					
				->hydrate(false)
					->join([
						'table' => 'descuentos',
						'alias' => 'd',
						'type' => 'INNER',
						 'conditions' => [
						'd.articulo_id = Articulos.id',
						'd.tipo_venta = "D"',
						'd.tipo_oferta = "FP"'
						]		
					]
					)
					
				->where(['Articulos.eliminado'=>0,'Articulos.stock <> "F"','Articulos.stock <>"D"'])
				->where(['Articulos.imagen NOT IN ("sinimagen.png","perfumeria.jpg","medicamento.jpg")']);
				
				$this->request->session()->write('articulosxx',$articulos->toArray());
				//$this->set('articulosxx',$articulos);
		/*
		$connection = ConnectionManager::get('default');

			$ofertas = $connection->execute('SELECT ofertas.*,articulos.id AS articuloid, articulos.precio_publico, articulos.categoria_id, articulos.compra_max, 
		  descuentos.dto_drogueria, descuentos.articulo_id, descuentos.plazo, descuentos.uni_min, descuentos.tipo_oferta, descuentos.tipo_venta, descuentos.tipo_precio ,ofertas.oferta_tipo_id 
		  FROM ofertas LEFT JOIN articulos on articulos.id = ofertas.articulo_id INNER JOIN descuentos on descuentos.articulo_id =  articulos.id and 
		  descuentos.tipo_venta = "D" and	descuentos.fecha_hasta >=CURRENT_DATE() and	descuentos.tipo_oferta in ("RV","RR","OR","TD","RL","FR","FP") where ofertas.activo=1 and articulos.stock<>"F" and articulos.imagen NOT IN ("sinimagen.png","perfumeria.jpg","medicamento.jpg" ORDER BY ofertas.id DESC ' )->fetchAll('assoc');
		*/
			$connection = ConnectionManager::get('default');
		$ofertas = $connection->execute('SELECT ofertas.*,articulos.id AS articuloid, articulos.precio_publico, articulos.laboratorio_id, articulos.categoria_id,  articulos.compra_max, articulos.msd, 
		  descuentos.dto_drogueria, descuentos.articulo_id, descuentos.plazo, descuentos.uni_min, descuentos.tipo_oferta, descuentos.tipo_venta, descuentos.tipo_precio ,ofertas.oferta_tipo_id 
		  FROM ofertas LEFT JOIN articulos on articulos.id = ofertas.articulo_id INNER JOIN descuentos on descuentos.articulo_id =  articulos.id and 
		  descuentos.tipo_venta = "D" and	descuentos.fecha_hasta >=CURRENT_DATE() and	descuentos.tipo_oferta in ("RV","RR","OR","TD","RL","FR") where ofertas.activo=1 and articulos.stock<>"F" ORDER BY ofertas.id DESC ' )->fetchAll('assoc');
	
		
		$this->set('ofertas',$ofertas);
		$articulos = $articulos->toArray();
				
			
		$this->set(compact('articulos'));
		$this->set('_serialize', 'articulos');
		
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
		$laboratorios = $this->Laboratorios->find('list',['keyField' => 'id','valueField'=>'nombre'])->where(['eliminado=0'])->order(['nombre' => 'ASC']);

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

	public function categoriaylaboratorio2()
	{
		if ($this->request->session()->read('Categorias')== null)
		{
		$this->loadModel('Categorias');
		$this->loadModel('Laboratorios');
		$categorias = $this->Categorias->find('list',['keyField' => 'id','valueField'=>'nombre']);
		$laboratorios = $this->Laboratorios->find('list',['keyField' => 'id','valueField'=>'nombre'])->andWhere(['tipo'=>1])->order(['nombre' => 'ASC']);

		$this->request->session()->write('Categorias',$categorias->toArray());
		$this->request->session()->write('Laboratorios2',$laboratorios ->toArray());
			
		}
		else{
			$this->loadModel('Laboratorios');
			$laboratorios = $this->Laboratorios->find('list',['keyField' => 'id','valueField'=>'nombre'])->andWhere(['tipo'=>1])->order(['nombre' => 'ASC']);
			$this->request->session()->write('Laboratorios2',$laboratorios ->toArray());
			
			$laboratorios =$this->request->session()->read('Laboratorios2');
			$categorias = $this->request->session()->read('Categorias');
		}	
		$this->set('categorias',$categorias );
		$this->set('laboratorios',$laboratorios);
		
	}
	
    /**
     * Index method
     *
     * @return void
    *//*
    public function index()
    {
		
		if ($this->request->session()->read('Auth.User.perfile_id')==5)
			return $this->redirect($this->Auth->logout());
		
		$this->viewBuilder()->layout('store');
		$this->clientecredito();
		$this->sumacarrito();
		

		$this->clientecredito();
		$this->sumacarrito();	
		$this->set('articulos',null);
		$this->loadModel('Articulos');
		
		$articulos = $this->Articulos->find('all')
					->contain(['Descuentos' => [
						
						'queryBuilder' => function ($q) {
							return $q->where(['tipo_oferta = "HS"']); // Full conditions for filtering
						}
					]
				])
					
					
				->hydrate(false)
					->join([
						'table' => 'descuentos',
						'alias' => 'd',
						'type' => 'INNER',
						 'conditions' => [
						'd.articulo_id = Articulos.id',
						'd.tipo_venta = "D"',
						'd.tipo_oferta = "HS"'
						]		
					]
					)
					
				->where(['Articulos.eliminado'=>0,'Articulos.stock <> "F"','Articulos.stock <>"D"'])
				->where(['Articulos.imagen NOT IN ("sinimagen.png","perfumeria.jpg","medicamento.jpg")']);
				
				$this->request->session()->write('articulosxx',$articulos->toArray());
			
				//$this->set('articulosxx',$articulos);
		
		$connection = ConnectionManager::get('default');

			$ofertas = $connection->execute('SELECT ofertas.*,articulos.id AS articuloid, articulos.precio_publico, articulos.categoria_id, articulos.compra_max, 
		  descuentos.dto_drogueria, descuentos.articulo_id, descuentos.plazo, descuentos.uni_min, descuentos.tipo_oferta, descuentos.tipo_venta, descuentos.tipo_precio ,ofertas.oferta_tipo_id 
		  FROM ofertas LEFT JOIN articulos on articulos.id = ofertas.articulo_id INNER JOIN descuentos on descuentos.articulo_id =  articulos.id and 
		  descuentos.tipo_venta = "D" and	descuentos.fecha_hasta >=CURRENT_DATE() and	descuentos.tipo_oferta in ("RV","RR","OR","TD","RL","FR","FP") where ofertas.activo=1 and articulos.stock<>"F" and articulos.imagen NOT IN ("sinimagen.png","perfumeria.jpg","medicamento.jpg" ORDER BY ofertas.id DESC ' )->fetchAll('assoc');
		
			$connection = ConnectionManager::get('default');
		$ofertas = $connection->execute('SELECT ofertas.*,articulos.id AS articuloid, articulos.precio_publico, articulos.laboratorio_id, articulos.categoria_id,  articulos.compra_max, articulos.msd, articulos.imagen AS imagencb,
		  descuentos.dto_drogueria, descuentos.articulo_id, descuentos.plazo, descuentos.uni_min, descuentos.tipo_oferta, descuentos.tipo_venta, descuentos.tipo_precio ,ofertas.oferta_tipo_id 
		  FROM ofertas LEFT JOIN articulos on articulos.id = ofertas.articulo_id INNER JOIN descuentos on descuentos.articulo_id =  articulos.id and 
		  descuentos.tipo_venta = "D" and	descuentos.fecha_hasta >=CURRENT_DATE() and	descuentos.tipo_oferta in ("RV","RR","OR","TD","RL","FR") where ofertas.activo=1 and articulos.stock<>"F" ORDER BY ofertas.id DESC ' )->fetchAll('assoc');
	
		
		$this->set('ofertas',$ofertas);
		
		$articuloshs = $articulos->toArray();
				
			
		$this->set(compact('articuloshs'));
		$this->set('_serialize', 'articuloshs');
		
		
		$connection = ConnectionManager::get('default'); 
		$ofertas = $connection->execute('SELECT ofertas.id, ofertas.articulo_id, ofertas.descripcion, ofertas.detalle, ofertas.busqueda, ofertas.descuento_producto, ofertas.unidades_minimas, ofertas.fecha_desde, ofertas.fecha_hasta, ofertas.plazos, ofertas.oferta_tipo_id, 
			ofertas.unidades_maximas, ofertas.activo, ofertas.habilitada, ofertas.tipo_precio, ofertas.aplicaen ,articulos.imagen as imagen
			,articulos.id AS articuloid, articulos.precio_publico, articulos.categoria_id, articulos.compra_max,  
		  	descuentos.dto_drogueria, descuentos.articulo_id, descuentos.plazo, descuentos.uni_min, descuentos.tipo_oferta, descuentos.tipo_venta, descuentos.tipo_precio ,ofertas.oferta_tipo_id 
		  FROM ofertas LEFT JOIN articulos on articulos.id = ofertas.articulo_id INNER JOIN descuentos on descuentos.articulo_id =  articulos.id and 
		  descuentos.tipo_venta = "D" and descuentos.fecha_hasta >=CURRENT_DATE() and	descuentos.tipo_oferta in ("RV","RR","OR","RL","FR","TD") where ofertas.activo=1 and articulos.stock<>"F" ORDER BY ofertas.id DESC ' )->fetchAll('assoc');
		
		$this->categoriaylaboratorio();
		//
		if ($this->request->session()->read('ofertaspatagonias')== null)
		{
			$ofertaspatagonias = $connection->execute('SELECT ofertas.*, articulos.precio_publico, 
			descuentos.dto_drogueria, descuentos.articulo_id, descuentos.plazo, descuentos.uni_min, descuentos.tipo_oferta, descuentos.tipo_venta, descuentos.tipo_precio ,ofertas.oferta_tipo_id ,ofertas.detalle, ofertas.busqueda
			FROM ofertas LEFT JOIN articulos on articulos.id = ofertas.articulo_id LEFT JOIN descuentos on descuentos.articulo_id =  articulos.id and 
			descuentos.tipo_venta = "D" and	descuentos.fecha_hasta >=CURRENT_DATE() and	descuentos.tipo_oferta in ("RV","RR","OR","TD","RL","SS","VC") where ofertas.activo=1 and ofertas.oferta_tipo_id = 6' )->fetchAll('assoc');
			$this->request->session()->write('ofertaspatagonias',$ofertaspatagonias);	
		}
		$this->loadModel('Ofertas');
		$ofertasX = $this->Ofertas->find('all')
		->where(['oferta_tipo_id'=>11, 'activo'=>1]);
		$this->set('ofertasX',$this->paginate($ofertasX));

		$this->loadModel('Novedades');
		$noticias = $this->Novedades->find()->where(['activo' =>'1'])->andWhere(['interno' =>'1','importante'=>'1'])
		->order(['id' => 'DESC']);
		$this->set('noticiaimportante',$noticias->first());
		$this->set('novedades',$this->paginate($noticias) );
		$this->loadModel('Publications');
		$publications = $this->Publications->find('all')->where(['habilitada' =>'1'])->order(['id' => 'DESC'])->all();
		
		$this->set('sursale',$publications->first());
		$this->set('sursale2',$publications->skip(1)->first());
		
		$this->loadModel('Cortes');
		$corte = $this->Cortes->find()->where(['codigo' =>$this->request->session()->read('Auth.User.codigo_postal')])->first();
		$this->request->session()->write('Auth.User.cierre',$corte['proximo_h']);

		$this->loadModel('Ofertas');
		
		$this->set('sursale',$this->Ofertas->find()->where(['activo' =>'1','oferta_tipo_id'=>9])->order(['id' => 'DESC'])->first());
		$this->set('sursale2',$this->Ofertas->find()->where(['activo' =>'1','oferta_tipo_id'=>10])->order(['id' => 'DESC'])->first());
		$this->set(compact('ofertas'));

		if (!$this->request->session()->read('Auth.User.actualizo_correo'))
		{
			return $this->redirect(['controller'=>'clientes','action' => 'edit_email']);
		}
		if ($this->request->session()->read('Auth.User.actualizo_gln')<1 && $this->request->session()->read('Auth.User.actualizo_ingreso')<1)
		{
			$this->request->session()->write('Auth.User.actualizo_ingreso',1);
			return $this->redirect(['controller'=>'clientes','action' => 'comunicado']);
		}
    }
*/

	public function blackfriday()
    {
		$this->paginate = [		
			'contain' => [],
			'limit' => 82,
			'offset' => 0, 
			'order' => ['Articulos.descripcion_pag' => 'asc']];	

		if ($this->request->session()->read('Auth.User.perfile_id')==5)
			return $this->redirect($this->Auth->logout());
		
		$this->viewBuilder()->layout('store');
		$this->clientecredito();
		$this->sumacarrito();
		

		$this->clientecredito();
		$this->sumacarrito();	
		//$this->set('articulos',null);
		$this->loadModel('Articulos');
		
		$articulosbf = $this->Articulos->find('all')
					->contain(['Descuentos' => [
						
						'queryBuilder' => function ($q) {
							return $q->where(['tipo_oferta = "BF"']); // Full conditions for filtering
						}
					]
					,'Carritos' => [
						
						'queryBuilder' => function ($q) {
							return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); // Full conditions for filtering
						}
					]
				])
					
					
				->hydrate(false)
					->join([
						'table' => 'descuentos',
						'alias' => 'd',
						'type' => 'INNER',
						 'conditions' => [
						'd.articulo_id = Articulos.id',
						'd.tipo_venta = "D"',
						'd.tipo_oferta = "BF"'
						]		
					]
					)
					
				->where(['Articulos.eliminado'=>0,'Articulos.stock <> "F"','Articulos.stock <>"D"'])
				->order(['Articulos.laboratorio_id' => 'DESC','Articulos.descripcion_sist'=>'DESC']);

		$articulos = $this->paginate($articulosbf);	
		$this->set('articulos',$articulos);
		$this->set('_serialize', 'articulos');

		$this->categoriaylaboratorio();


    }
	/* NUEVO*/
	public function index()
    {
		$this->viewBuilder()->layout('store');
        /*$this->paginate = [
						'contain' => ['Laboratorios','Categorias'],
						'limit' => 11,
						'order' => ['Articulos.descripcion_pag' => 'asc']];
		$this->loadModel('Articulos');
		$this->clientecredito();
		$carritos = $this->sumacarrito();
	
		$this->loadModel('Ofertas');
		
		$connection = ConnectionManager::get('default');
		$ofertas = $connection->execute('SELECT ofertas.*, articulos.precio_publico, articulos.compra_max, articulos.categoria_id, 
		  descuentos.dto_drogueria, descuentos.articulo_id, descuentos.plazo, descuentos.uni_min, descuentos.tipo_oferta, descuentos.tipo_venta, descuentos.tipo_precio 
		  FROM ofertas LEFT JOIN articulos on articulos.id = ofertas.articulo_id LEFT JOIN descuentos on descuentos.articulo_id =  articulos.id and 
		  descuentos.tipo_venta = "D" and	descuentos.fecha_hasta >=CURRENT_DATE() and	descuentos.tipo_oferta in ("RV","RR","OR","TD","RL","FR") where ofertas.activo=1 and and articulos.stock<>"F" ORDER BY ofertas.id DESC ')->fetchAll('assoc');
		$this->set('ofertas',$ofertas);
				    
        $articulos = null;//$this->paginate($this->Articulos);
		$this->set(compact('articulos'));
		$this->categoriaylaboratorio(); */
			
		if ($this->request->session()->read('Auth.User.perfile_id')==5)
			return $this->redirect($this->Auth->logout());
		
		$this->paginate = ['limit' => 100];
		$this->viewBuilder()->layout('store');

		$fecha = Time::now();
		$fecha = $fecha->i18nFormat('yyyy-MM-dd');
		$this->loadModel('Ofertas');
		
		$ofertasX = $this->Ofertas->find('all')->where(['oferta_tipo_id'=>11,'activo'=>1,'fecha_hasta >=CURRENT_DATE()']);
		
		$this->set('ofertasX',$this->paginate($ofertasX));
				
		$ofertasY = $this->Ofertas->find('all')
		->contain(['Articulos','articulos.Descuentos' => [
			'queryBuilder' => function ($q) {
				return $q->where([
					'tipo_venta = "D"','fecha_hasta >=CURRENT_DATE()','tipo_oferta in ("RV","RR","OR","FR","TD","RL")']); // Full conditions for filtering
			}
		]
		])
		->hydrate(false)
		->join([
			'table' => 'descuentos',
			'alias' => 'd',
			'type' => 'left',
				'conditions' => [
			'd.articulo_id = Ofertas.articulo_id',
			'd.tipo_venta = "D"',
			'd.fecha_hasta >=' => $fecha,
			'd.tipo_oferta in ("RV","RR","OR","TD","RL","FR")'
			]		
		]
		)
		->where(['Ofertas.activo=1','Articulos.stock<>"F"'])
		->where(['Ofertas.fecha_hasta >=' => $fecha])
		->order(['Ofertas.id' => 'DESC']);
		//$ofertasZ =$ofertasY;
		$this->set('ofertasY',$this->paginate($ofertasY));
		//$this->set('ofertasZ',$this->paginate($ofertasZ->where(['Ofertas.ubicacion in (1,2)'])->order(['Ofertas.id' => 'DESC'])));
		//$this->set('ofertasY',$this->paginate($ofertasY->where(['Ofertas.ubicacion in (0)'])->order(['Ofertas.id' => 'DESC'])));
		
		//$this->set(compact('ofertasY'));
		/* Ofertas*/
		$connection = ConnectionManager::get('default'); 
		/*$ofertas = $connection->execute('SELECT ofertas.id, ofertas.articulo_id, ofertas.descripcion, ofertas.detalle, ofertas.busqueda, ofertas.descuento_producto, ofertas.unidades_minimas, ofertas.fecha_desde, ofertas.fecha_hasta, ofertas.plazos, ofertas.oferta_tipo_id, 
		ofertas.unidades_maximas, ofertas.activo, ofertas.habilitada, ofertas.tipo_precio, ofertas.aplicaen ,articulos.imagen as imagen
		,articulos.id AS articuloid, articulos.precio_publico, articulos.categoria_id, articulos.compra_max, 
		descuentos.dto_drogueria, descuentos.articulo_id, descuentos.plazo, descuentos.uni_min, descuentos.tipo_oferta, descuentos.tipo_venta, descuentos.tipo_precio ,ofertas.oferta_tipo_id 
		FROM ofertas LEFT JOIN articulos on articulos.id = ofertas.articulo_id INNER JOIN descuentos on descuentos.articulo_id =  articulos.id and 
		descuentos.tipo_venta = "D" and	descuentos.fecha_hasta >=CURRENT_DATE() and	descuentos.tipo_oferta in ("RV","RR","OR","FR","TD","RL") where ofertas.activo=1 and articulos.stock<>"F" ORDER BY ofertas.id DESC ' )->fetchAll('assoc');
		$this->set(compact('ofertas'));*/
				
		$this->set('articulos',null);
		/* Cargar informacion credito y laboratorio*/
		$this->clientecredito();
		$this->sumacarrito();
		$this->categoriaylaboratorio();
		
		/* Horario de Corte */		
		$this->loadModel('Cortes');
		$corte = $this->Cortes->find()->where(['codigo' =>$this->request->session()->read('Auth.User.codigo_postal')])->first();
		$this->request->session()->write('Auth.User.cierre',$corte['proximo_h']);


		/* Novedades Importes*/
		$this->loadModel('Novedades');
		$noticias = $this->Novedades->find()->where(['activo' =>'1'])->andWhere(['interno' =>'1','importante'=>'1'])->order(['id' => 'DESC']);
		$this->set('noticiaimportante',$noticias->first());
		$this->set('novedades',$this->paginate($noticias) );
		/* Publicaciones*/
		$this->loadModel('Publications');
		$publications = $this->Publications->find('all')->where(['fecha_hasta >=CURRENT_DATE()','habilitada' =>'1','ubicacion'=>'2'])->order(['id' => 'DESC'])->all();
		$this->set('sursale',$publications->first());
		$this->set('sursale2',$publications->skip(1)->first());

		if (!$this->request->session()->read('Auth.User.actualizo_correo'))
		{
			return $this->redirect(['controller'=>'clientes','action' => 'edit_email']);
		}
		if (!$this->request->session()->read('Auth.User.actualizo_gln') && !$this->request->session()->read('Auth.User.actualizo_ingreso'))
		{
			$this->request->session()->write('Auth.User.actualizo_ingreso',1);
			return $this->redirect(['controller'=>'clientes','action' => 'comunicado']);
		}
		 

    }

	public function home()
    {
		$this->viewBuilder()->layout('store');
        /*$this->paginate = [
						'contain' => ['Laboratorios','Categorias'],
						'limit' => 11,
						'order' => ['Articulos.descripcion_pag' => 'asc']];
		$this->loadModel('Articulos');
		$this->clientecredito();
		$carritos = $this->sumacarrito();
	
		$this->loadModel('Ofertas');
		
		$connection = ConnectionManager::get('default');
		$ofertas = $connection->execute('SELECT ofertas.*, articulos.precio_publico, articulos.compra_max, articulos.categoria_id, 
		  descuentos.dto_drogueria, descuentos.articulo_id, descuentos.plazo, descuentos.uni_min, descuentos.tipo_oferta, descuentos.tipo_venta, descuentos.tipo_precio 
		  FROM ofertas LEFT JOIN articulos on articulos.id = ofertas.articulo_id LEFT JOIN descuentos on descuentos.articulo_id =  articulos.id and 
		  descuentos.tipo_venta = "D" and	descuentos.fecha_hasta >=CURRENT_DATE() and	descuentos.tipo_oferta in ("RV","RR","OR","TD","RL","FR") where ofertas.activo=1 and and articulos.stock<>"F" ORDER BY ofertas.id DESC ')->fetchAll('assoc');
		$this->set('ofertas',$ofertas);
				    
        $articulos = null;//$this->paginate($this->Articulos);
		$this->set(compact('articulos'));
		$this->categoriaylaboratorio(); */
			
		if ($this->request->session()->read('Auth.User.perfile_id')==5)
			return $this->redirect($this->Auth->logout());
		
		$this->paginate = ['limit' => 100];
		$this->viewBuilder()->layout('store');

		$fecha = Time::now();
		$fecha = $fecha->i18nFormat('yyyy-MM-dd');
		$this->loadModel('Ofertas');
		
		$ofertasX = $this->Ofertas->find('all')->where(['oferta_tipo_id'=>11,'activo'=>1]);
		
		$this->set('ofertasX',$this->paginate($ofertasX));
				
		$ofertasY = $this->Ofertas->find('all')
		->contain(['Articulos','articulos.Descuentos' => [
			'queryBuilder' => function ($q) {
				return $q->where([
					'tipo_venta = "D"','fecha_hasta >=CURRENT_DATE()','tipo_oferta in ("RV","RR","OR","FR","TD","RL")']); // Full conditions for filtering
			}
		]
		])
		->hydrate(false)
		->join([
			'table' => 'descuentos',
			'alias' => 'd',
			'type' => 'left',
				'conditions' => [
			'd.articulo_id = Ofertas.articulo_id',
			'd.tipo_venta = "D"',
			'd.fecha_hasta >=' => $fecha,
			'd.tipo_oferta in ("RV","RR","OR","TD","RL","FR")'
			]		
		]
		)
		->where(['Ofertas.activo=1','Articulos.stock<>"F"'])
		->where(['Ofertas.fecha_hasta >=CURRENT_DATE()'])
		->order(['Ofertas.id' => 'DESC']);
		//$ofertasZ =$ofertasY;
		$this->set('ofertasY',$this->paginate($ofertasY));
		//$this->set('ofertasZ',$this->paginate($ofertasZ->where(['Ofertas.ubicacion in (1,2)'])->order(['Ofertas.id' => 'DESC'])));
		//$this->set('ofertasY',$this->paginate($ofertasY->where(['Ofertas.ubicacion in (0)'])->order(['Ofertas.id' => 'DESC'])));
		
		//$this->set(compact('ofertasY'));
		/* Ofertas*/
		$connection = ConnectionManager::get('default'); 
		/*$ofertas = $connection->execute('SELECT ofertas.id, ofertas.articulo_id, ofertas.descripcion, ofertas.detalle, ofertas.busqueda, ofertas.descuento_producto, ofertas.unidades_minimas, ofertas.fecha_desde, ofertas.fecha_hasta, ofertas.plazos, ofertas.oferta_tipo_id, 
		ofertas.unidades_maximas, ofertas.activo, ofertas.habilitada, ofertas.tipo_precio, ofertas.aplicaen ,articulos.imagen as imagen
		,articulos.id AS articuloid, articulos.precio_publico, articulos.categoria_id, articulos.compra_max, 
		descuentos.dto_drogueria, descuentos.articulo_id, descuentos.plazo, descuentos.uni_min, descuentos.tipo_oferta, descuentos.tipo_venta, descuentos.tipo_precio ,ofertas.oferta_tipo_id 
		FROM ofertas LEFT JOIN articulos on articulos.id = ofertas.articulo_id INNER JOIN descuentos on descuentos.articulo_id =  articulos.id and 
		descuentos.tipo_venta = "D" and	descuentos.fecha_hasta >=CURRENT_DATE() and	descuentos.tipo_oferta in ("RV","RR","OR","FR","TD","RL") where ofertas.activo=1 and articulos.stock<>"F" ORDER BY ofertas.id DESC ' )->fetchAll('assoc');
		$this->set(compact('ofertas'));*/
				
		$this->set('articulos',null);
		/* Cargar informacion credito y laboratorio*/
		$this->clientecredito();
		$this->sumacarrito();
		$this->categoriaylaboratorio();
		
		/* Horario de Corte */		
		$this->loadModel('Cortes');
		$corte = $this->Cortes->find()->where(['codigo' =>$this->request->session()->read('Auth.User.codigo_postal')])->first();
		$this->request->session()->write('Auth.User.cierre',$corte['proximo_h']);


		/* Novedades Importes*/
		$this->loadModel('Novedades');
		$noticias = $this->Novedades->find()->where(['activo' =>'1'])->andWhere(['interno' =>'1','importante'=>'1'])->order(['id' => 'DESC']);
		$this->set('noticiaimportante',$noticias->first());
		$this->set('novedades',$this->paginate($noticias) );
		/* Publicaciones*/
		$this->loadModel('Publications');
		$publications = $this->Publications->find('all')->where(['habilitada' =>'1'])->order(['id' => 'DESC'])->all();
		$this->set('sursale',$publications->first());
		$this->set('sursale2',$publications->skip(1)->first());

		if (!$this->request->session()->read('Auth.User.actualizo_correo'))
		{
			return $this->redirect(['controller'=>'clientes','action' => 'edit_email']);
		}
		if (!$this->request->session()->read('Auth.User.actualizo_gln') && !$this->request->session()->read('Auth.User.actualizo_ingreso'))
		{
			$this->request->session()->write('Auth.User.actualizo_ingreso',1);
			return $this->redirect(['controller'=>'clientes','action' => 'comunicado']);
		}
		 

    }

 /*
	public function confirm()
    {
		$this->viewBuilder()->layout('store');
        $this->paginate = [	'contain' => ['Articulos'],'limit' => 500 , 'maxLimit' => 1000,
		  'order'=>(['Articulos.descripcion_sist' => 'ASC'])
		];
		$this->clientecredito();
		$carritos = $this->sumacarrito();
		$this->loadModel('Clientes');
		$cliente = $this->Clientes->get($this->request->session()->read('Auth.User.cliente_id'), [
            'contain' => ['Provincias','Localidads']
        ]);
		$this->request->session()->write('Auth.User.pf_dcto',$cliente['preciofarmacia_descuento']);
		$this->loadModel('Sucursals');
		$sucursales= $this->Sucursals->find('all')->where(['cliente_id'=>$this->request->session()->read('Auth.User.cliente_id')])
		->contain(['Localidads']);
		$this->set('sucursales',$sucursales);
		$this->set('cliente',$cliente);
		$this->set('carritos', $this->paginate($carritos));
		$this->set(compact('carritos'));
    }*/
	
	
	
	public function confirm()
    {
		
		$this->loadModel('Clientes');
		$cliente = $this->Clientes->get($this->request->session()->read('Auth.User.cliente_id'), [
            'contain' => ['Provincias','Localidads']
        ]);
		$this->request->session()->write('Auth.User.pf_dcto',$cliente['preciofarmacia_descuento']);
		$this->loadModel('Sucursals');
		$sucursales= $this->Sucursals->find('all')->where(['cliente_id'=>$this->request->session()->read('Auth.User.cliente_id')])
		->contain(['Localidads']);
		$this->set('sucursales',$sucursales);
		$this->set('cliente',$cliente);
		
		$this->loadModel('Cortes');
		$corte = $this->Cortes->find()->where(['codigo' =>$this->request->session()->read('Auth.User.codigo_postal')])->first();
		$this->request->session()->write('Auth.User.cierre',$corte['proximo_h']);

		$this->viewBuilder()->layout('store');

        $this->paginate = [		
		'contain' => ['Descuentos'],
		'limit' => 70,
		'offset' => 0, 
        'order' => ['Articulos.descripcion_pag' => 'asc']];
		$this->loadModel('Articulos');
		
		$this->clientecredito();
		$this->sumacarrito();

		$fecha = Time::now();
		//$fecha = Time::createFromFormat('d/m/Y',$fecha,'America/Argentina/Buenos_Aires');
	     $fecha = $fecha->i18nFormat('yyyy-MM-dd');
		$this->request->session()->write('fechamierda',$fecha);
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
						'd.tipo_oferta in ("RV","RR","OR","TD","RL","SS","VC")'
						]		
					]
					)
					->join([
						'table' => 'carritos',
						'alias' => 'c',
						'type' => 'LEFT',
						'conditions' => [
						
						'c.articulo_id = Articulos.id',
						'c.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')
						]		
					]		
					)
				->where(['c.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]);
				//'d.articulo_id = Articulos.id and CURRENT_DATE() <= d.fecha_hasta and d.tipo_venta in ("D ","  ")',
		
		if ($articulosA!=null)
		{
			$articulosA->andWhere(['eliminado'=>0]);
			$articulos = $this->paginate($articulosA);
		}
		else
			$articulos = null;
		$this->set(compact('articulos'));

		$this->categoriaylaboratorio();

		$this->loadModel('Publications');
		$publications = $this->Publications->find('all')->where(['fecha_hasta >=CURRENT_DATE()','habilitada' =>'1','ubicacion'=>'3'])->order(['id' => 'DESC'])->all();
		$this->set('confirm1',$publications->first());
		$this->set('confirm2',$publications->skip(1)->first());
    }
 
	public function delete_temp($id = null)
    {    
		$this->loadModel('CarritosTemps');
        $this->request->allowMethod(['post','get', 'delete']);
        $carritosTemp = $this->CarritosTemps->get($id);
        if ($this->CarritosTemps->delete($carritosTemp)) {
            $this->Flash->success('Se elimino correctamente.',['key' => 'changepass']);
        } else {
            $this->Flash->error('No se pudo eliminar, intente nuevamente',['key' => 'changepass']);
        }
       $this->redirect($this->referer());
    }
    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$carrito = $this->Carritos->newEntity();
        if ($this->request->is('post')) {
            $carrito = $this->Carritos->patchEntity($carrito, $this->request->data);
            if ($this->Carritos->save($carrito)) {
                $this->Flash->success('Se guardo correctamente',['key' => 'changepass']);
                $this->redirect($this->referer());
            } else 
                $this->Flash->error('No se guardo, intente de nuevo',['key' => 'changepass']);
        }
        $clientes = $this->Carritos->Clientes->find('list', ['limit' => 200]);
        $sucursals = $this->Carritos->Sucursals->find('list', ['limit' => 200]);
        $this->set(compact('carrito', 'clientes', 'sucursals'));
        $this->set('_serialize', ['carrito']);
    }

	
	public function pami()
    {
		$this->categoriaylaboratorio();
		$this->viewBuilder()->layout('store');
		//,'Carritos'
        $this->paginate = [		
		'contain' => ['Descuentos','Carritos'],
		'limit' => 11,
		'offset' => 0, 
        'order' => ['Articulos.descripcion_pag' => 'asc']];
		$this->loadModel('Articulos');
		$this->clientecredito();
		$this->sumacarrito();
				
		$fecha = Time::now();
		//$fecha->i18nFormat('YYYY-MM-dd');
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
						'd.fecha_hasta >=' => $fecha->i18nFormat('yyyy-MM-dd'),
						'd.tipo_oferta in ("RV","RR","OR","TD","TL")'
						]		
					]
					)
					->where(['Articulos.id in (27339,27340,27341,27342,27343)']);
					
		if ($articulosA!=null)
		{
			$limit =25;
			if ($articulosA->count()<100 && $articulosA->count()>50 )
			{
				$limit = 50;
			}
			if ($articulosA->count()>100 )
			{
				$limit= 75;
			}
			
			$this->paginate = [		
			'contain' => ['Descuentos','Carritos'],
			'limit' => $limit,
			'offset' => 0, 
			'order' => ['Articulos.descripcion_pag' => 'asc']];
									
			$articulosA->andWhere(['eliminado'=>0])->group(['Articulos.id']);
			$articulos = $this->paginate($articulosA);
		}
		else
			$articulos = null;
		$this->set(compact('articulos'));
    }
	
	public function insumos()
    {
		$this->categoriaylaboratorio();
		$this->viewBuilder()->layout('store');
		//,'Carritos'
        $this->paginate = [		
		'contain' => ['Descuentos','Carritos'],
		'limit' => 11,
		'offset' => 0, 
        'order' => ['Articulos.descripcion_pag' => 'asc']];
		$this->loadModel('Articulos');
		$this->clientecredito();
		$this->sumacarrito();
				
		$fecha = Time::now();
		//$fecha->i18nFormat('YYYY-MM-dd');
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
						'd.fecha_hasta >=' => $fecha->i18nFormat('yyyy-MM-dd'),
						'd.tipo_oferta in ("RV","RR","OR","TD")'
						]		
					]
					)
					->where(['Articulos.laboratorio_id in (462,382)']);
					
					
		if ($articulosA!=null)
		{
			$limit =25;
			if ($articulosA->count()<100 && $articulosA->count()>50 )
			{
				$limit = 50;
			}
			if ($articulosA->count()>100 )
			{
				$limit= 75;
			}
			
			$this->paginate = [		
			'contain' => ['Descuentos','Carritos'],
			'limit' => $limit,
			'offset' => 0, 
			'order' => ['Articulos.descripcion_pag' => 'asc']];
									
			$articulosA->andWhere(['eliminado'=>0])->group(['Articulos.id']);
			$articulos = $this->paginate($articulosA);
		}
		else
			$articulos = null;
		$this->set(compact('articulos'));
    }

	public function carritoadd()
    {
		if ($this->request->data['cantidad']!='')
		{
			if (((int)$this->request->data['cantidad']>0) && ((int)$this->request->data['cantidad']<1000))			
			{
			if ((int)$this->request->data['categoria_id']==7) 
			{
				
				$this->Flash->error('No se puede agregar este producto al carro de compras. ',['key' => 'changepass']);
				return $this->redirect($this->referer());
			}
		
			$carritocon2 = $this->Carritos->find()
			->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
			->where(['articulo_id' =>  $this->request->data['articulo_id']]);
		if($carritocon2->count()==0)
			{
				$carrito = $this->Carritos->newEntity();
				$carrito['cliente_id']=$this->request->session()->read('Auth.User.cliente_id');
				$carrito['creado']=date('Y-m-d H:i:s');
				$carrito['cantidad'] = $this->request->data['cantidad'];
				$carrito['articulo_id'] = $this->request->data['articulo_id'];
				$carrito['precio_publico'] = $this->request->data['precio_publico']; 	
				$carrito['descripcion'] = $this->request->data['descripcion']; 	
				$carrito['descuento'] = $this->request->data['descuento']; 	
				$carrito['plazoley_dcto'] = $this->request->data['plazoley_dcto']; 	
				$carrito['unidad_minima'] = $this->request->data['unidad_minima']; 	
				$carrito['tipo_oferta'] = $this->request->data['tipo_oferta']; 	
				$carrito['tipo_oferta_elegida'] = $this->request->data['tipo_venta']; 
				$carrito['tipo_precio'] = $this->request->data['tipo_precio']; 
				
				if ($carrito['tipo_precio']=='P' && ($carrito['tipo_oferta']=='TD' || $carrito['tipo_oferta']=='TL' || $carrito['tipo_oferta']=='OR' || $carrito['tipo_oferta']=='OD'||$carrito['tipo_oferta']=='TH')) 
                        $carrito['tipo_fact']= 'TR';
					else
						if ($carrito['tipo_precio']=='F' && ($carrito['tipo_oferta']=='TD' || $carrito['tipo_oferta']=='TL' || $carrito['tipo_oferta']=='OR' || $carrito['tipo_oferta']=='OD'||$carrito['tipo_oferta']=='TH')) 
						
							$carrito['tipo_fact']= 'TL';
						else 
							$carrito['tipo_fact']= 'N';
				
				
				
				if ($this->Carritos->save($carrito))
				{
					$this->Flash->success('Se agrego al carro correctamente.',['key' => 'changepass']);
					$this->redirect($this->referer());
				}
				else
				{
					$this->Flash->error('No se pudo agregar al carro de compras. Intente de nuevo',['key' => 'changepass']);
				}
			}
			else
			{
				foreach ($carritocon2 as $carro):
					$id=$carro['id'];
					$cant = $this->request->data['cantidad'];
				endforeach; 
				$carrito = $this->Carritos->get($id, ['contain' => []]);
				$carrito['cantidad']=$cant;	
				
				if ($this->Carritos->save($carrito)) {
					$this->Flash->success('Se agrego al carro correctamente dos.',['key' => 'changepass']);
				}
				else
				{
					$this->Flash->error('No se pudo agregar al carro de compras. Intente de nuevo',['key' => 'changepass']);
				}
				$this->redirect($this->referer());
			}
		}
		
		else
		{
			$this->Flash->error('Ingrese un numero que sea menor a 1000. Intente de nuevo',['key' => 'changepass']);
			$this->redirect($this->referer());
		}
	}
		else
		{
			
			$this->redirect($this->referer());
		}
    }

	public function view()
    {

		$this->viewBuilder()->layout('store');

        $this->paginate = [		
		'contain' => [],
		'limit' => 70,
		'offset' => 0, 
        'order' => ['Articulos.descripcion_pag' => 'asc']];
		$this->loadModel('Articulos');
		
		$this->clientecredito();
		$this->sumacarrito();

		$fecha = Time::now();
		//$fecha = Time::createFromFormat('d/m/Y',$fecha,'America/Argentina/Buenos_Aires');
	     $fecha = $fecha->i18nFormat('yyyy-MM-dd');
		$this->request->session()->write('fechamierda',$fecha);
	  	$articulosA = $this->Articulos->find()
				->contain(['Descuentos','Carritos' => [
						
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
						'd.tipo_oferta in ("RV","RR","OR","TD","RL","SS","FR")'
						]		
					]
					)
					->join([
						'table' => 'carritos',
						'alias' => 'c',
						'type' => 'LEFT',
						'conditions' => [
						
						'c.articulo_id = Articulos.id',
						'c.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')
						]		
					]		
					)
				->where(['c.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]);
				//'d.articulo_id = Articulos.id and CURRENT_DATE() <= d.fecha_hasta and d.tipo_venta in ("D ","  ")',
		
		if ($articulosA!=null)
		{
			$articulosA->andWhere(['eliminado'=>0])->group(['Articulos.id']);
			$articulos = $this->paginate($articulosA);
		}
		else
			$articulos = null;
		$this->set(compact('articulos'));

		$this->categoriaylaboratorio();
			
    }

	public function fraganciaselectiva()
    {
		
		$this->request->session()->write('marcaid',0);
		$this->request->session()->write('termsearch2',"");
		$this->request->session()->write('marcaid',0);		
		$this->loadModel('Marcas');
		$this->loadModel('Generos');
		
		$marcas = $this->Marcas->find('list', ['keyField' => 'id','valueField' => 'nombre'])->where(['marcas_tipos_id'=>1])->order(['nombre' => 'ASC']);
        $generos = $this->Generos->find('list', ['keyField' => 'id','valueField' => 'nombre']);
		$marcas->toArray();
		$generos->toArray();
		$this->set(compact('marcas','generos'));
		
		$this->viewBuilder()->layout('store');
        $this->paginate = ['limit' => 5];
		
		$this->clientecredito();
		$this->sumacarrito();
			
		$this->loadModel('Incorporations');
		$incorporationsA = $this->Incorporations->find('all');
		$incorporationsA->where(['habilitada'=>1,'incorporations_tipos_id '=>1])->limit([5])->order(['id' => 'DESC']);
		$incorporations = $this->paginate($incorporationsA);
        $this->set('incorporations', $incorporations);

		$marcas2 = $this->Marcas->find('all')->where(['marcas_tipos_id'=>1]);
		$marcas2->toArray();
		
		$this->set(compact('marcas2'));
	  //$this->Flash->warning('Nos encontramos actualizado la seccion, intente mas tarde',['key' => 'changepass']);     
       //$this->redirect($this->referer());
	}
	
	public function resultfraganciaselectiva($marcaid =null, $generoid=null)
    {
		
		if ($this->request->is('post'))
		{	
			$termsearch2 ="";		
			if ($this->request->data['terminobuscar']!= null)
			{
				$terminocompleto = explode(" ", $this->request->data['terminobuscar']);
				$termsearch2 ="";
				if (count($terminocompleto)>1)
				{
						foreach ($terminocompleto as $terminosimple): 
							$termsearch2 = $termsearch2.'%'.$terminosimple.'%';
						endforeach; 
				}
				else
					$termsearch2 = '%'.$terminocompleto[0].'%';
			}	
	 
			$this->request->session()->write('termsearch2',$termsearch2);
		}
		else
		{
			$termsearch2 = $this->request->session()->read('termsearch2');
		}
		IF (is_null($marcaid))
		{
			if (!is_null($this->request->session()->read('marcaid'))) 
			$marcaid = $this->request->session()->read('marcaid');
			else
			$marcaid=0;
		}
		else
			$this->request->session()->write('marcaid',$marcaid);
			
		IF (is_null($generoid))
		{
			if (!is_null($this->request->session()->read('generoid'))) 
			$generoid = $this->request->session()->read('generoid');
			else
			$generoid=0;
			
		}
		else
			$this->request->session()->write('generoid',$generoid);

		$this->loadModel('Marcas');
		$this->loadModel('Generos');
		
		$marcas = $this->Marcas->find('list', ['keyField' => 'id','valueField' => 'nombre'])->where(['marcas_tipos_id'=>1])->order(['nombre' => 'ASC']);
        $generos = $this->Generos->find('list', ['keyField' => 'id','valueField' => 'nombre']);
		$marcas->toArray();
		$generos->toArray();
		$this->set(compact('marcas','generos'));
		
		$this->viewBuilder()->layout('store');
        $this->paginate = [	'limit' => 16];
		
		$this->clientecredito();
		$this->sumacarrito();		
		$this->loadModel('Fragancias');
			
		$fragancia = $this->Fragancias->find()
										  ->contain(['FraganciasPresentaciones','FraganciasPresentaciones.Articulos',
										  'FraganciasPresentaciones.Articulos.Carritos' => [
						
						'queryBuilder' => function ($q) {
							return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); // Full conditions for filtering
						}
					]
				  ]);
		
		if ($marcaid!=0 && $marcaid!=100)
		{
			 $fragancia->where(['marca_id'=>$marcaid]);			
		}
		if ($generoid!=0)
		{
			$fragancia->where(['genero_id'=>$generoid]);
		}
		if ($termsearch2 !="")
		{
			$fragancia->where(['nombre LIKE'=>$termsearch2]);
		}
		$this->set('fragancias',$this->paginate($fragancia) );
		

	}
	
	public function carritoaddall()
    {
		$carritos = TableRegistry::get('Carritos');
		$entities = $carritos->newEntities($this->request->data());
		$this->set('carritos2', $this->request->data);
		$this->loadModel('Articulos');
		
		foreach ($entities as $carrito) {
		$carrito['cliente_id'] = $this->request->session()->read('Auth.User.cliente_id');

		if ($carrito['cantidad']!='')
		{
			$articulo = $this->Articulos->find()
								->where(['id' =>  $carrito['articulo_id']])
								->first();
								
			if (((int)$carrito['cantidad']>0) && ((int)$carrito['cantidad']<1000))			
			{
			$categoria=(int)$articulo['categoria_id'];	
			
			if ($this->request->session()->read('Auth.User.habilitado')==2)	
				{
					if ($categoria==6 || $categoria==7)    
				    {
						$this->Flash->error('No se puede agregar este producto al carro de compras. ',['key' => 'changepass']);
						return $this->redirect($this->referer());					
					}
				}
			if ($this->request->session()->read('Auth.User.habilitado')==3)	
				{
					if ($categoria!=5 && $categoria!=4)
				    {
						$this->Flash->error('No se puede agregar este producto al carro de compras. ',['key' => 'changepass']);
						return $this->redirect($this->referer());					
					}
					if ($categoria==5 && $articulo['restringido_perf']!=0)
					{
						$this->Flash->error('No se puede agregar este producto al carro de compras. ',['key' => 'changepass']);
						return $this->redirect($this->referer());
					}
				}
			
			if ((int)$carrito['categoria_id']==7) 
			{
				
				$this->Flash->error('No se puede agregar este producto al carro de compras. ',['key' => 'changepass']);
				//return $this->redirect($this->referer());
			}
			else
			{
			$carritocon2 = $this->Carritos->find()
								->where(['cliente_id' => $carrito['cliente_id']])
								->where(['articulo_id' =>  $carrito['articulo_id']]);
		    if($carritocon2->count()==0)
			{
				// Inserto Registro al carrito
				// asigno tipo de facturacion.
				if ((int)$articulo['compra_multiplo']>1)
					if ((int)$carrito['cantidad'] %(int)$articulo['compra_multiplo'] != 0)
					{
						$this->Flash->error('No se agrego '.$carrito['descripcion']. ' al carro de compras, la cantidad tiene que ser multiplo de '.$carrito['compra_multiplo'] ,['key' => 'changepass']);	
						return $this->redirect($this->referer());
					}
				if ((int)$carrito['cantidad'] <(int)$articulo['compra_min'])
					{
						$this->Flash->error('No se agrego '.$carrito['descripcion']. ' al carro de compras, la cantidad tiene minima de venta es de '.$carrito['compra_min'] ,['key' => 'changepass']);	
						return $this->redirect($this->referer());
					}
				$carrito['creado'] = date('Y-m-d H:i:s');
				$carrito['tipo_oferta_elegida'] = $carrito['tipo_venta']; 
				if ($carrito['tipo_precio']=='P' && ($carrito['tipo_oferta']=='TD' || $carrito['tipo_oferta']=='TL' || $carrito['tipo_oferta']=='OR' || $carrito['tipo_oferta']=='OD'||$carrito['tipo_oferta']=='TH')) 
                        $carrito['tipo_fact']= 'TR';
					else
						if ($carrito['tipo_precio']=='F' && ($carrito['tipo_oferta']=='TD' || $carrito['tipo_oferta']=='TL' || $carrito['tipo_oferta']=='OR' || $carrito['tipo_oferta']=='OD'||$carrito['tipo_oferta']=='TH')) 
							$carrito['tipo_fact']= 'TL';
						else 
							$carrito['tipo_fact']= 'N';
				
				$cantidad = $carrito['cantidad'];
				$cantidadmax = $carrito['compra_max'];
				/*if ($carrito['categoria_id']!=5 && $carrito['categoria_id']!=4 )
				$cantidadmax = 100;
				else
				$cantidadmax = 500;	
				*/
				if ($cantidad>$cantidadmax && $this->request->session()->read('Auth.User.grupo')!=33 && $this->request->session()->read('Auth.User.grupo')!=1)
					$carrito['cantidad'] = $cantidadmax;		
				if ($this->Carritos->save($carrito))
				{
					if ($cantidad>$cantidadmax && $this->request->session()->read('Auth.User.grupo')!=33 && $this->request->session()->read('Auth.User.grupo')!=1)
					$this->Flash->success('Se agrego al carro correctamente. Solo '.$cantidadmax.' unidades',['key' => 'changepass']);
					else
					$this->Flash->success('Se agrego al carro correctamente.',['key' => 'changepass']);	
				
				}
				else
					$this->Flash->error('No se pudo agregar al carro de compras. Intente de nuevo',['key' => 'changepass']);
				
			}
			else
			{
				// Modifico la cantidad al carrito
				foreach ($carritocon2 as $carro):
					$id=$carro['id'];
					$cant = $carrito['cantidad'];
					$carrito2 =  $carrito;
				endforeach; 
				$carrito = $this->Carritos->get($id, ['contain' => []]);
				$carrito['cantidad']=$cant;	
				
				$carrito['modificado']=date('Y-m-d H:i:s');
				$carrito['tipo_oferta_elegida'] = $carrito2['tipo_venta']; 
				$carrito['precio_publico'] = $carrito2['precio_publico']; 	
				$carrito['descuento'] = $carrito2['descuento']; 	
				$carrito['plazoley_dcto'] = $carrito2['plazoley_dcto']; 	
				$carrito['unidad_minima'] = $carrito2['unidad_minima']; 	
				$carrito['tipo_oferta'] = $carrito2['tipo_oferta']; 	
				$carrito['compra_max'] = $carrito2['compra_max']; 
				$carrito['tipo_precio'] = $carrito2['tipo_precio']; 
				//$carrito['tipo_oferta_elegida'] = $carrito2['tipo_venta']; 
				$carrito['categoria_id'] = $carrito2['categoria_id']; 
				
				if ($carrito['tipo_precio']=='P' && ($carrito['tipo_oferta']=='TD' || $carrito['tipo_oferta']=='TL' || $carrito['tipo_oferta']=='OR' || $carrito['tipo_oferta']=='OD'||$carrito['tipo_oferta']=='TH')) 
                        $carrito['tipo_fact']= 'TR';
					else
						if ($carrito['tipo_precio']=='F' && ($carrito['tipo_oferta']=='TD' || $carrito['tipo_oferta']=='TL' || $carrito['tipo_oferta']=='OR' || $carrito['tipo_oferta']=='OD'||$carrito['tipo_oferta']=='TH')) 
							$carrito['tipo_fact']= 'TL';
						else 
							$carrito['tipo_fact']= 'N';
						
				if ((int)$articulo['compra_multiplo']>1)
					if ((int)$carrito['cantidad'] %(int)$articulo['compra_multiplo'] != 0)
					{
						$this->Flash->error('No se agrego '.$carrito['descripcion']. ' al carro de compras, la cantidad tiene que ser multiplo de '.$carrito['compra_multiplo'] ,['key' => 'changepass']);	
						return $this->redirect($this->referer());
					}
				if ((int)$carrito['cantidad'] <(int)$articulo['compra_min'])
					{
						$this->Flash->error('No se agrego '.$carrito['descripcion']. ' al carro de compras, la cantidad tiene minima de venta es de '.$carrito['compra_min'] ,['key' => 'changepass']);	
						return $this->redirect($this->referer());
					}
				$cantidad = $carrito['cantidad'];
				$cantidadmax = $carrito['compra_max'];
				/*if ($carrito['categoria_id']!=5 && $carrito['categoria_id']!=4 )
				$cantidadmax = 100;
				else
				$cantidadmax = 500;	*/
				if ($cantidad>$cantidadmax && $this->request->session()->read('Auth.User.grupo')!=33 && $this->request->session()->read('Auth.User.grupo')!=1)
					$carrito['cantidad'] = $cantidadmax;
				
				if ($this->Carritos->save($carrito)) {
					if ($cantidad>$cantidadmax && $this->request->session()->read('Auth.User.grupo')!=33 && $this->request->session()->read('Auth.User.grupo')!=1)
						$this->Flash->success('Se modifico la cantidad del producto correctamente. Solo '.$cantidadmax.' unidades',['key' => 'changepass']);
					else
						$this->Flash->success('Se modifico la cantidad del producto correctamente.',['key' => 'changepass']);
				}
				else
				{
					$this->Flash->error('No se pudo agregar al carro de compras. Intente de nuevo',['key' => 'changepass']);
				}
				//$this->redirect($this->referer());
			}
			}
		}
		else
		{
			if ((int)$carrito['cantidad']==0)
			{
				$carritos =$this->Carritos->find('all')
								->where(['cliente_id' => $carrito['cliente_id']])
								->where(['articulo_id' =>  $carrito['articulo_id']])
								->first();
				if ($carritos !=null)
				{	
					if ($this->Carritos->delete($carritos)) 
					$this->Flash->success('Se elimino el producto de carro de compras.',['key' => 'changepass']);
					//$this->redirect($this->referer());
				}
			}
			else
			{
				$this->Flash->error('Ingrese un numero que sea menor a 1000. Intente de nuevo',['key' => 'changepass']);
				//$this->redirect($this->referer());
			}
		}
			
		}
		else
		{
			if ($carrito['cantidad']=='')
			{
				$carritos =$this->Carritos->find('all')
								->where(['cliente_id' => $carrito['cliente_id']])
								->where(['articulo_id' =>  $carrito['articulo_id']])
								->first();
				if ($carritos !=null)
				{	
						if ($this->Carritos->delete($carritos)) 
							$this->Flash->success('Se elimino el producto de carro de compras.',['key' => 'changepass']);
						//$this->redirect($this->referer());
				}
			}
			else
			{
				$this->redirect($this->referer());
			}
			
		}
		}
		$this->redirect($this->referer());
    }
	
	public function carritoaddoferta()
    {
		$carritocon2 = $this->Carritos->find()
			->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
			->where(['articulo_id' =>  $this->request->data['articulo_id']]);
		if($carritocon2->count()==0)
			{
				$carrito = $this->Carritos->newEntity();
				$carrito['cliente_id']=$this->request->session()->read('Auth.User.cliente_id');
				$carrito['creado']=date('Y-m-d H:i:s');
				$carrito['cantidad'] = $this->request->data['cantidad'];
				$carrito['articulo_id'] = $this->request->data['articulo_id'];
				$carrito['precio_publico'] = $this->request->data['precio_publico']; 	
				$carrito['descripcion'] = $this->request->data['descripcion']; 	
				$carrito['descuento'] = $this->request->data['descuento']; 	
				$carrito['plazoley_dcto'] = $this->request->data['plazoley_dcto']; 	
				$carrito['unidad_minima'] = $this->request->data['unidad_minima']; 	
				$carrito['tipo_oferta'] = $this->request->data['tipo_oferta']; 	
				$carrito['tipo_oferta_elegida'] = $this->request->data['tipo_venta']; 
				$carrito['tipo_precio'] = $this->request->data['tipo_precio']; 
				$carrito['categoria_id'] = $this->request->data['categoria_id']; 
				$carrito['compra_max'] = $this->request->data['compra_max']; 
				
				if ($carrito['tipo_precio']=='P' && ($carrito['tipo_oferta']=='TD' || $carrito['tipo_oferta']=='TL' || $carrito['tipo_oferta']=='OR' || $carrito['tipo_oferta']=='OD'||$carrito['tipo_oferta']=='TH')) 
                        $carrito['tipo_fact']= 'TR';
					else
						if ($carrito['tipo_precio']=='F' && ($carrito['tipo_oferta']=='TD' || $carrito['tipo_oferta']=='TL' || $carrito['tipo_oferta']=='OR' || $carrito['tipo_oferta']=='OD'||$carrito['tipo_oferta']=='TH')) 
						
							$carrito['tipo_fact']= 'TL';
						else 
							$carrito['tipo_fact']= 'N';
				$cantidad = $carrito['cantidad'];
				$cantidadmax = $carrito['compra_max']; 
				/*if ($carrito['categoria_id']!=5 && $carrito['categoria_id']!=4 )
				$cantidadmax = 100;
				else
				$cantidadmax = 500;	*/
				if ($cantidad>$cantidadmax && $this->request->session()->read('Auth.User.grupo')!=33 && $this->request->session()->read('Auth.User.grupo')!=1)
					$carrito['cantidad'] = $cantidadmax;		
				if ($this->Carritos->save($carrito))
				{
					if ($cantidad>$cantidadmax && $this->request->session()->read('Auth.User.grupo')!=33 && $this->request->session()->read('Auth.User.grupo')!=1)
					$this->Flash->success('Se agrego al carro correctamente. Solo '.$cantidadmax.' unidades',['key' => 'changepass']);
					else
					$this->Flash->success('Se agrego al carro correctamente.',['key' => 'changepass']);
				}
				else
				{
					$this->Flash->error('No se pudo agregar al carro de compras. Intente de nuevo',['key' => 'changepass']);
				}
				$this->redirect($this->referer());
			}
			else
			{
				foreach ($carritocon2 as $carro):
					$id=$carro['id'];
					$cant = $this->request->data['cantidad']+$carro['cantidad'];
				endforeach; 
				$carrito = $this->Carritos->get($id, ['contain' => []]);
				$carrito['cantidad']=$cant;	
				$cantidad = $carrito['cantidad'];
				$cantidadmax = $carrito['compra_max']; 
				/*if ($carrito['categoria_id']!=5 && $carrito['categoria_id']!=4 )
				$cantidadmax = 100;
				else
				$cantidadmax = 500;	*/
				if ($cantidad>$cantidadmax && $this->request->session()->read('Auth.User.grupo')!=33 && $this->request->session()->read('Auth.User.grupo')!=1)
					$carrito['cantidad'] = $cantidadmax;		
				
				
				if ($this->Carritos->save($carrito)) {
					if ($cantidad>$cantidadmax && $this->request->session()->read('Auth.User.grupo')!=33 && $this->request->session()->read('Auth.User.grupo')!=1)
					$this->Flash->success('Se modifico el carro correctamente. Solo '.$cantidadmax.' unidades',['key' => 'changepass']);
					else
					$this->Flash->success('Se modifico el carro correctamente.',['key' => 'changepass']);
					
				}
				else
				{
					$this->Flash->error('No se pudo agregar al carro de compras. Intente de nuevo',['key' => 'changepass']);
				}
				$this->redirect($this->referer());
			}
		
    }
	
	public function carritotempadd()
    {
		if (($this->request->data['cantidad']!='0') &&  ($this->request->data['cantidad']!=''))
		{
			$this->loadModel('CarritosTemps');
			
		$carritocon2 = $this->CarritosTemps->find()
			->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
			->where(['articulo_id' =>  $this->request->data['articulo_id']]);
		if($carritocon2->count()==0)
			{
				$carrito = $this->CarritosTemps->newEntity();
				$carrito['cliente_id']=$this->request->session()->read('Auth.User.cliente_id');
				$carrito['creado']=date('Y-m-d H:i:s');
				$carrito['cantidad'] = $this->request->data['cantidad'];
				$carrito['articulo_id'] = $this->request->data['articulo_id'];
				$carrito['precio_publico'] = $this->request->data['precio_publico']; 	
				$carrito['descripcion'] = $this->request->data['descripcion']; 	
				$carrito['descuento'] = $this->request->data['descuento']; 	
				$carrito['plazoley_dcto'] = $this->request->data['plazoley_dcto']; 	
				$carrito['unidad_minima'] = $this->request->data['unidad_minima']; 	
				$carrito['tipo_oferta'] = $this->request->data['tipo_oferta']; 	
				$carrito['tipo_oferta_elegida'] = $this->request->data['tipo_venta']; 
				$carrito['tipo_precio'] = $this->request->data['tipo_precio']; 
				$carrito['tipo_precio'] = $this->request->data['categoria_id']; 
				$carrito['compra_max'] = $this->request->data['compra_max']; 
				
				if ($carrito['tipo_precio']=='P' && ($carrito['tipo_oferta']=='TD' || $carrito['tipo_oferta']=='TL' || $carrito['tipo_oferta']=='OR' || $carrito['tipo_oferta']=='OD'||$carrito['tipo_oferta']=='TH')) 
                        $carrito['tipo_fact']= 'TR';
					else
						if ($carrito['tipo_precio']=='F' && ($carrito['tipo_oferta']=='TD' || $carrito['tipo_oferta']=='TL' || $carrito['tipo_oferta']=='OR' || $carrito['tipo_oferta']=='OD'||$carrito['tipo_oferta']=='TH')) 
						
							$carrito['tipo_fact']= 'TL';
						else 
							$carrito['tipo_fact']= 'N';
				
				$cantidad = $carrito['cantidad'];
				$cantidadmax = $carrito['compra_max']; 
				/*
				if ($carrito['categoria_id']!=5 && $carrito['categoria_id']!=4 )
				$cantidadmax = 100;
				else
				$cantidadmax = 500;	*/
				if ($cantidad>$cantidadmax && $this->request->session()->read('Auth.User.grupo')!=33 && $this->request->session()->read('Auth.User.grupo')!=1)
					$carrito['cantidad'] = $cantidadmax ;
				
				if ($this->Carritos->save($carrito))
				{
					if ($cantidad>$cantidadmax && $this->request->session()->read('Auth.User.grupo')!=33 && $this->request->session()->read('Auth.User.grupo')!=1)
					$this->Flash->success('Se agrego al carro correctamente. Solo '.$cantidadmax.' unidades',['key' => 'changepass']);
					else
					$this->Flash->success('Se agrego al carro correctamente.',['key' => 'changepass']);
					$this->redirect($this->referer());
				}
				else
				{
					$this->Flash->error('No se pudo agregar al carro de compras. Intente de nuevo',['key' => 'changepass']);
				}
			}
			else
			{
				foreach ($carritocon2 as $carro):
					$id=$carro['id'];
					$cant = $this->request->data['cantidad'];
				endforeach; 
				$carrito = $this->CarritosTemps->get($id, ['contain' => []]);
				$carrito['cantidad']=$cant;	
				$cantidadmax = $carrito['compra_max']; 
				/*
				$cantidad = $carrito['cantidad'];
				if ($carrito['categoria_id']!=5 && $carrito['categoria_id']!=4 )
				$cantidadmax = 100;
				else
				$cantidadmax = 500;	*/
				if ($cantidad>$cantidadmax && $this->request->session()->read('Auth.User.grupo')!=33 && $this->request->session()->read('Auth.User.grupo')!=1)
					$carrito['cantidad'] = $cantidadmax ;
				
				
				if ($this->CarritosTemps->save($carrito)) {
					if ($cantidad>$cantidadmax && $this->request->session()->read('Auth.User.grupo')!=33 && $this->request->session()->read('Auth.User.grupo')!=1)
						$this->Flash->success('Se  modifico la cantidad importada correctamente. Solo '.$cantidadmax.' unidades',['key' => 'changepass']);
					else
						$this->Flash->success('Se modifico la cantidad importada correctamente.' ,['key' => 'changepass']);
				}
				else
				{
					$this->Flash->error('No se pudo modificar la cantidad importada. Intente de nuevo',['key' => 'changepass']);
				}
				$this->redirect($this->referer());
			}
		}
		else
		{
			$this->loadModel('CarritosTemps');
			
		   
			
			$carritosTemp = $this->CarritosTemps->get($this->request->data['carrito_temp_id']);
			
			if ($this->CarritosTemps->delete($carritosTemp)) {
			$this->Flash->success('Se elimino el producto de los importados.',['key' => 'changepass']);
			}
			$this->redirect($this->referer());
		}
    }
	
	
	public function carritotempaddall()
    {
		$this->loadModel('CarritosTemps');
		$carritos = TableRegistry::get('CarritosTemps');
		$entities = $carritos->newEntities($this->request->data());

		foreach ($entities as $carrito) {
		
		if (($carrito['cantidad']!='0') &&  ($carrito['cantidad']!=''))
		{
			
		if (((int)$carrito['cantidad']>0) && ((int)$carrito['cantidad']<1000))
		{
		$carrito['cliente_id']=$this->request->session()->read('Auth.User.cliente_id');	
			
		$carritocon2 = $this->CarritosTemps->find()
			->where(['cliente_id' => $carrito['cliente_id']])
			->where(['articulo_id' =>  $carrito['articulo_id']]);
		if($carritocon2->count()==0)
			{
				//$carrito = $this->CarritosTemps->newEntity();
				
				$carrito['creado']=date('Y-m-d H:i:s');
				
				
				if ($carrito['tipo_precio']=='P' && ($carrito['tipo_oferta']=='TD' || $carrito['tipo_oferta']=='TL' || $carrito['tipo_oferta']=='OR' || $carrito['tipo_oferta']=='OD'||$carrito['tipo_oferta']=='TH')) 
                        $carrito['tipo_fact']= 'TR';
					else
						if ($carrito['tipo_precio']=='F' && ($carrito['tipo_oferta']=='TD' || $carrito['tipo_oferta']=='TL' || $carrito['tipo_oferta']=='OR' || $carrito['tipo_oferta']=='OD'||$carrito['tipo_oferta']=='TH')) 
						
							$carrito['tipo_fact']= 'TL';
						else 
							$carrito['tipo_fact']= 'N';
						
				$cantidad = $carrito['cantidad'];
				/*if ($carrito['categoria_id']!=5 && $carrito['categoria_id']!=4 )
				$cantidadmax = 100;
				else
				$cantidadmax = 500;	*/
				$cantidadmax = $carrito['compra_max']; 
				if ($cantidad>$cantidadmax && $this->request->session()->read('Auth.User.grupo')!=33 && $this->request->session()->read('Auth.User.grupo')!=1)
					$carrito['cantidad'] = $cantidadmax ;
				if ($this->CarritosTemps->save($carrito))
				{
					if ($cantidad>$cantidadmax && $this->request->session()->read('Auth.User.grupo')!=33 && $this->request->session()->read('Auth.User.grupo')!=1)
						$this->Flash->success('Se agrego correctamente. Solo '.$cantidadmax.' unidades',['key' => 'changepass']);
					else
						$this->Flash->success('Se agrego correctamente',['key' => 'changepass']);
					
					//$this->Flash->success('Se agrego al carro correctamente.',['key' => 'changepass']);
					//$this->redirect($this->referer());
				}
				else
				{
					$this->Flash->error('No se pudo agregar. Intente de nuevo',['key' => 'changepass']);
				}
			}
			else
			{
				foreach ($carritocon2 as $carro):
					$id=$carro['id'];
					$cant = $carrito['cantidad'];
				endforeach; 
				$carrito = $this->CarritosTemps->get($id, ['contain' => []]);
				$carrito['cantidad']=$cant;	
				$cantidad = $carrito['cantidad'];
				$cantidadmax = $carrito['compra_max']; 
				/*if ($carrito['categoria_id']!=5 && $carrito['categoria_id']!=4 )
				$cantidadmax = 100;
				else
				$cantidadmax = 500;	
				*/
				if ($cantidad>$cantidadmax && $this->request->session()->read('Auth.User.grupo')!=33 && $this->request->session()->read('Auth.User.grupo')!=1)
					$carrito['cantidad'] = $cantidadmax ;
				
				if ($this->CarritosTemps->save($carrito)) {
					if ($cantidad>$cantidadmax && $this->request->session()->read('Auth.User.grupo')!=33 && $this->request->session()->read('Auth.User.grupo')!=1)
						$this->Flash->success('Se modifico la cantidad importada correctamente.Máximo unidades'.$cantidadmax,['key' => 'changepass']);	
					else
						$this->Flash->success('Se modifico la cantidad importada correctamente.',['key' => 'changepass']);
					
					//$this->Flash->success('Se modifico la cantidad importada correctamente.',['key' => 'changepass']);
				}
				else
				{
					$this->Flash->error('No se pudo modificar la cantidad importada. Intente de nuevo',['key' => 'changepass']);
				}
				//$this->redirect($this->referer());
			}
		}
		else
			$this->Flash->error('Ingrese un numero que sea menor a 1000. Intente de nuevo',['key' => 'changepass']);
		}
		else
		{
			$this->loadModel('CarritosTemps');
			
		   
			
			$carritosTemp = $this->CarritosTemps->get($carrito['carrito_temp_id']);
			
			if ($this->CarritosTemps->delete($carritosTemp)) {
			$this->Flash->success('Se elimino el producto de los importados.',['key' => 'changepass']);
			}
			
		}
		}
		$this->redirect($this->referer());
    }
	
    /**
     * Edit method
     *
     * @param string|null $id Carrito id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit()
    {
		$carro = $this->Carritos->newEntity();
        $carro = $this->Carritos->get(intval($this->request->data['id']));
		//debug($this->request->data['cantidad']);
        if ($this->request->is(['patch', 'post', 'put'])) {
            if (((int)$this->request->data['cantidad']>0) && ((int)$this->request->data['cantidad']<1000))
			{
				$carro['cantidad'] = $this->request->data['cantidad'];
			}
			else
			{
				$this->Flash->error('Ingrese un numero que sea menor a 1000. Intente de nuevo',['key' => 'changepass']);
				$this->redirect($this->referer());
			}
			$cantidad = $carro['cantidad'];
			$cantidadmax = $carro['compra_max']; 	
				/*if ($carro['categoria_id']!=5 && $carro['categoria_id']!=4 )
				$cantidadmax = 100;
				else
				$cantidadmax = 500;	*/
			if ($cantidad>$cantidadmax && $this->request->session()->read('Auth.User.grupo')!=33 && $this->request->session()->read('Auth.User.grupo')!=1)
				$carro['cantidad'] = $cantidadmax ;
			
            if ($this->Carritos->save($carro)) {
				
				if ($cantidad>$cantidadmax && $this->request->session()->read('Auth.User.grupo')!=33 && $this->request->session()->read('Auth.User.grupo')!=1)
						$this->Flash->success('Se modifico la cantidad correctamente.Máximo unidades'.$cantidadmax,['key' => 'changepass']);	
					else
						$this->Flash->success('Se modifico la cantidad correctamente.',['key' => 'changepass']);
					
                //$this->Flash->success('Se agrego correctamente.',['key' => 'changepass']);
                $this->redirect($this->referer());
            } else {
                
            }
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id Carrito id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post','get', 'delete']);
         $carrito = $this->Carritos->find('all')
		->where(['id'=>$id])
		->first([]);
		if (!empty($carrito))
		{ 
			$conn = ConnectionManager::get('default');
			$conn->query('CALL CopiarCarritoItemDelete('.$id.');');
		if ($this->Carritos->delete($carrito)) {
            $this->Flash->success('Se elimino correctamente del carro.',['key' => 'changepass']);
        } else {
            $this->Flash->error('No se pudo eliminar, intente nuevamente',['key' => 'changepass']);
        }
		}
       $this->redirect($this->referer());
    }
    
	public function vaciar()
    {
			$conn = ConnectionManager::get('default');
			$cliente_id=$this->request->session()->read('Auth.User.cliente_id');
			$conn->query('CALL CopiarCarritoVacio('.$cliente_id.');');
			
        if ($this->deleteCarrito()) {
            $this->Flash->success('El carrito fue vaciado.',['key' => 'changepass']);
			$this->redirect($this->referer());
        } else {
            $this->Flash->error('El carrito no pudo ser vaciado. Intente de nuevo.',['key' => 'changepass']);
			$this->redirect($this->referer());
        }  
    }
	
	public function vaciarimport()
    {
        if ($this->deleteCarritoTemp()) {
            $this->Flash->success('El listado de articulo a importar fue vaciado.',['key' => 'changepass']);
			$this->redirect($this->referer());
        } else {
            $this->Flash->error('El listado no pudo ser vaciado. Intente de nuevo.',['key' => 'changepass']);
			$this->redirect($this->referer());
        }  
    }	
	
	public function deleteCarrito()
	{
		return $this->Carritos->deleteAll(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]);
	}
	
	public function deleteCarritoTemp()
	{
		$this->loadModel('CarritosTemps');
		return $this->CarritosTemps->deleteAll(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]);
	}
	
	public function ofertavc()
    {
		if ($this->request->is('post'))
		{	
	
			if ($this->request->data['categoria_id']!= null)
				$categoriaid = $this->request->data['categoria_id'];
			else
				$categoriaid=0;
			if ($this->request->data['laboratorio_id']!= null)
				$laboratorioid = $this->request->data['laboratorio_id'];
			else
				$laboratorioid =0;
			if ($this->request->data['ofertas']!= null)
				$ofertas = $this->request->data['ofertas'];
			else
				$ofertas =0;

			if (empty($this->request->data['codigobarras']))
				$codigobarras = 0;
			else
				$codigobarras = 1;
			
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
			$this->request->session()->write('codigobarras',$codigobarras);
			$this->request->session()->write('ofertas',$ofertas);
			$this->request->session()->write('termsearch',$termsearch);
			$this->request->session()->write('categoriaid',$categoriaid);	
			$this->request->session()->write('laboratorioid',$laboratorioid);
		}
		else 
		{
			$categoriaid = 0;//$this->request->session()->read('categoriaid');
		    $laboratorioid = 0;//$this->request->session()->read('laboratorioid');
			
			$termsearch = "";//$this->request->session()->read('termsearchvc');
			
			$ofertas = 0;//$this->request->session()->read('ofertas');
			$codigobarras  =  0;//$this->request->session()->read('codigobarras');
		}
		
		$this->categoriaylaboratorio();
		$this->clientecredito();
		$this->sumacarrito();
		
		$this->viewBuilder()->layout('store');
	
		$this->loadModel('Articulos');
		  		
		$articulosA = $this->Articulos->find()
				->contain(['Descuentos'
				=> [
						
						'queryBuilder' => function ($q) {
							return $q->where(['tipo_oferta' => 'VC','tipo_venta' => 'D']); // Full conditions for filtering
						}
					]
				,'Carritos' => [
						
						'queryBuilder' => function ($q) {
							return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); // Full conditions for filtering
						}
					]
				])
				->hydrate(false)
					->join([
						'table' => 'descuentos',
						'alias' => 'd',
						'type' => 'INNER',
						 'conditions' => [
						'd.articulo_id = Articulos.id',
						'd.tipo_venta = "D"',
						'd.tipo_oferta = "VC"'
						]		
					]
					)
					
				->where(['eliminado'=>0,'Articulos.stock <> "F"','Articulos.stock <> "D"','d.dto_drogueria<=30']);
			
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
					else
					{
						if ($ofertas ==0)
						{
							//$articulosA=null;
							//$this->redirect($this->referer());
						}
					}
				}
			}		
		}
		
		//'conditions' => 'd.articulo_id = Articulos.id and CURRENT_DATE() <= d.fecha_hasta and d.tipo_venta in ("D ","  ")',
		
		if ($articulosA!=null)
		{
			$limit =50;
			if ($articulosA->count()<100 && $articulosA->count()>50 )
			{
				$limit = 70;
			}
			if ($articulosA->count()>100 )
			{
				$limit= 70;
			}
			
			$this->paginate = [		
			'contain' => ['Carritos'],
			'limit' => $limit,
			
			'maxLimit' => 1000,
			'offset' => 0, 
			'order' => ['Articulos.descripcion_pag' => 'asc']];
				
			$articulos = $this->paginate($articulosA);
		}
		else
			$articulos = null;
		$this->set(compact('articulos'));
    }
		
	public function sale()
    {
		
		$this->categoriaylaboratorio();
		$this->clientecredito();
		$this->sumacarrito();
		
		
		$this->viewBuilder()->layout('store');
		
		//,'Carritos'
        /*$this->paginate = [		
		'contain' => ['Descuentos','Carritos'],
		'limit' => 100,
		'offset' => 0, 
        'order' => ['Articulos.descripcion_pag' => 'asc']];
		*/
		$this->loadModel('Articulos');

		$fecha = Time::now();
		$fecha->i18nFormat('YYYY-MM-dd');
	  	
		$this->loadModel('Ofertas');
		$sursale= $this->Ofertas->find()->where(['activo' =>'1','oferta_tipo_id'=>9])->order(['id' => 'DESC'])->first();
		$this->set('sursale',$sursale);
		if (!empty($sursale))
		{
			$fechadesde = Time::now();
			$fechadesde = $sursale['fecha_desde'];
			//$fechadesde->i18nFormat('YYYY-MM-dd');
			//$this->request->session()->write('compra_minima',500);		
			
			$fechahasta = Time::now();
			$fechahasta = $sursale['fecha_hasta'];
			$fechahasta-> modify('+1 days');
			//$fechahasta->i18nFormat('YYYY-MM-dd');
				
		}
		else
		{
			$fechadesde = Time::now();
			//$fechadesde = $sursale['fecha_desde'];
			//$fechadesde->i18nFormat('YYYY-MM-dd');
			//$this->request->session()->write('compra_minima',500);		
			
			$fechahasta = Time::now();
			//$fechahasta = $sursale['fecha_hasta'];
			$fechahasta-> modify('+1 days');
			//$fechahasta->i18nFormat('YYYY-MM-dd');
			
		}
		$articulosA = $this->Articulos->find()
				->contain(['Descuentos'=> [
						
						'queryBuilder' => function ($q) {
							return $q->where(['tipo_oferta' => 'SS']); // Full conditions for filtering
						}
					],'Carritos' => [
						
						'queryBuilder' => function ($q) {
							return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); // Full conditions for filtering
						}
					]
				])
				->hydrate(false)
					->join([
						'table' => 'descuentos',
						'alias' => 'd',
						'type' => 'INNER',
						 'conditions' => [
						'd.articulo_id = Articulos.id',
						'd.tipo_venta = "D"',
						
						'd.tipo_oferta in ("SS")'
						]		
					]
					)
					
				->where(['eliminado'=>0,
				'Articulos.stock <> "F"',
			//	"d.fecha_desde BETWEEN '".$fechadesde->i18nFormat('YYYY-MM-dd')."' AND '".$fechahasta->i18nFormat('YYYY-MM-dd')."'",
		//"d.fecha_hasta BETWEEN '".$fechadesde->i18nFormat('YYYY-MM-dd')."' AND '".$fechahasta->i18nFormat('YYYY-MM-dd')."'"
		
		]);
		
		if ($articulosA!=null)
		{
			$limit =50;
			if ($articulosA->count()<100 && $articulosA->count()>50 )
			{
				$limit = 70;
			}
			if ($articulosA->count()>100 )
			{
				$limit= 70;
			}
			
			$this->paginate = [		
			'contain' => ['Carritos'],
			'limit' => $limit,
			'maxLimit' => 1000,
			'offset' => 0, 
			'order' => ['Articulos.descripcion_pag' => 'asc']];
				
		
			$articulos = $this->paginate($articulosA);
		}
		else
			$articulos = null;
		$this->set(compact('articulos'));
    }
	
	public function CargarCarritoCB($termsearch = null)
	{
		
		$fecha = Time::now();
		$fecha->i18nFormat('YYYY-MM-dd');
		$this->loadModel('Articulos');
	  	$articulo = $this->Articulos->find()
					->contain(['Descuentos','Carritos' => [
						
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
						'd.tipo_oferta in ("RV","RR","OR","TD","RL","SS","VC","FR")'
						]		
					]
					)
					->where([
					
					'OR' => [['Articulos.codigo_barras LIKE'=>$termsearch],['Articulos.codigo_barras2 LIKE'=>$termsearch]]
					])
					->where(['eliminado'=>0])
					//->where(['eliminado'=>0,'Articulos.codigo_barras LIKE'=>$termsearch])
					->first();
		
		$this->request->session()->write('articulosaaa',$articulo);
		if (!empty($articulo))
		{
			
			if ($articulo['categoria_id']==7) 
			{
				
				$this->Flash->error('No se puede agregar este producto al carro de compras0. ',['key' => 'changepass']);
				return $this->redirect($this->referer());
			}
		$carritocon2 = $articulo['carritos'];
		
		/*
			$carritocon2 = $this->Carritos->find()
			->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
			->where(['articulo_id' =>  $this->request->data['articulo_id']]);*/
		if(count($carritocon2)==0)
			{
				$carrito = $this->Carritos->newEntity();
				$carrito['cliente_id'] = $this->request->session()->read('Auth.User.cliente_id');
				$carrito['creado'] = date('Y-m-d H:i:s');
				$carrito['cantidad'] = 1;
				$carrito['articulo_id'] = $articulo['id'];
				$carrito['precio_publico'] = $articulo['precio_publico']; 	
				$carrito['descripcion'] = $articulo['descripcion_sist']; 	
				$carrito['categoria_id'] = $articulo['categoria_id'];
				$carrito['compra_max'] = $articulo['compra_max'];
				//$descuentos = $articulo['descuentos']; 	
				$carrito['descuento'] = 0;	
				$carrito['plazoley_dcto'] = 'HABITUAL';	
				$carrito['unidad_minima'] = 1;	
				$carrito['tipo_oferta'] = null;
				$carrito['tipo_oferta_elegida'] = null;
				$carrito['tipo_precio'] = null;
				if (count($articulo['descuentos'])>0)
				{
				if ($articulo['descuentos'][0]['tipo_venta']=='D')
					{
						$carrito['descuento'] =$articulo['descuentos'][0]['dto_drogueria']; 	
						$carrito['plazoley_dcto'] =$articulo['descuentos'][0]['plazo']; 	
						$carrito['unidad_minima'] =$articulo['descuentos'][0]['uni_min']; 	
						$carrito['tipo_oferta'] =$articulo['descuentos'][0]['tipo_oferta']; 
						$carrito['tipo_oferta_elegida'] =$articulo['descuentos'][0]['tipo_venta']; 
						$carrito['tipo_precio'] =$articulo['descuentos'][0]['tipo_precio']; 
					}
					else
					{
						if (count($articulo['descuentos'])>1)
						{
							if ($articulo['descuentos'][0]['tipo_venta']=='D')
							{
								$carrito['descuento'] =$articulo['descuentos'][1]['dto_drogueria']; 	
								$carrito['plazoley_dcto'] =$articulo['descuentos'][1]['plazo']; 	
								$carrito['unidad_minima'] =$articulo['descuentos'][1]['uni_min']; 	
								$carrito['tipo_oferta'] =$articulo['descuentos'][1]['tipo_oferta']; 
								$carrito['tipo_oferta_elegida'] =$articulo['descuentos'][1]['tipo_venta']; 
								$carrito['tipo_precio'] =$articulo['descuentos'][1]['tipo_precio']; 
						
							}
						}
						
						
					else
					{
						if ($articulo['descuentos'][1]['tipo_venta']=='D')
						{
							$carrito['descuento'] =$articulo['descuentos'][1]['dto_drogueria']; 	
							$carrito['plazoley_dcto'] =$articulo['descuentos'][1]['plazo']; 	
							$carrito['unidad_minima'] =$articulo['descuentos'][1]['uni_min']; 	
							$carrito['tipo_oferta'] =$articulo['descuentos'][1]['tipo_oferta']; 
							$carrito['tipo_oferta_elegida'] =$articulo['descuentos'][1]['tipo_venta']; 
							$carrito['tipo_precio'] =$articulo['descuentos'][1]['tipo_precio']; 
					
						}
						
					}
				}
				}		
				if ($carrito['tipo_precio']=='P' && ($carrito['tipo_oferta']=='TD' || $carrito['tipo_oferta']=='TL' || $carrito['tipo_oferta']=='OR' || $carrito['tipo_oferta']=='OD'||$carrito['tipo_oferta']=='TH')) 
                        $carrito['tipo_fact']= 'TR';
					else
						if ($carrito['tipo_precio']=='F' && ($carrito['tipo_oferta']=='TD' || $carrito['tipo_oferta']=='TL' || $carrito['tipo_oferta']=='OR' || $carrito['tipo_oferta']=='OD'||$carrito['tipo_oferta']=='TH')) 
						
							$carrito['tipo_fact']= 'TL';
						else 
							$carrito['tipo_fact']= 'N';
				
				$cantidad = $carrito['cantidad'];
				$cantidadmax = $carrito['compra_max'];
				if ($cantidad>$cantidadmax && $this->request->session()->read('Auth.User.grupo')!=33 && $this->request->session()->read('Auth.User.grupo')!=1)
					$carrito['cantidad'] = $cantidadmax;
								
				if ($this->Carritos->save($carrito))
				{
					if ($cantidad>$cantidadmax && $this->request->session()->read('Auth.User.grupo')!=33 && $this->request->session()->read('Auth.User.grupo')!=1)
					$this->Flash->success('Se agrego al carro correctamente. Solo '.$cantidadmax.' unidades',['key' => 'changepass']);
					else
					$this->Flash->success('Se agrego al carro correctamente.',['key' => 'changepass']);
					
				}
				else
				{
					$this->Flash->error('No se pudo agregar al carro de compras. Intente de nuevo2',['key' => 'changepass']);
				}
			}
			else
			{
				foreach ($carritocon2 as $carro):
					$id=$carro['id'];
					$cant = $carro['cantidad']+1;
				endforeach; 
				$carrito = $this->Carritos->get($id, ['contain' => []]);
				$carrito['cantidad']=$cant;	
				
				
				$cantidad = $carrito['cantidad'];
				$cantidadmax = $carrito['compra_max'];
				if ($cantidad>$cantidadmax && $this->request->session()->read('Auth.User.grupo')!=33 && $this->request->session()->read('Auth.User.grupo')!=1)
					$carrito['cantidad'] = $cantidadmax;
								
				if ($this->Carritos->save($carrito))
				{
					if ($cantidad>$cantidadmax && $this->request->session()->read('Auth.User.grupo')!=33 && $this->request->session()->read('Auth.User.grupo')!=1)
					$this->Flash->success('Se modifico el carro correctamente. Solo '.$cantidadmax.' unidades',['key' => 'changepass']);
					else
					$this->Flash->success('Se modifico el carro correctamente.',['key' => 'changepass']);
					
				}
				else
				{
					$this->Flash->error('No se pudo agregar al carro de compras. Intente de nuevo3',['key' => 'changepass']);
				}
				
			}
		}
		
		
	}
	
	public function search($termsearch = null, $termsearchlab=null)
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
			if (!empty($this->request->data['ofertas']))
			{
				$ofertas = $this->request->data['ofertas'];
			}	
			else
				{
				$ofertas =0;
			}
			
			if (empty($this->request->data['codigobarras']))
			{
				$codigobarras = 0;
				
			}
			else
				$codigobarras = 1;
			
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
			$this->request->session()->write('codigobarras',$codigobarras);
			$this->request->session()->write('ofertas',$ofertas);
			$this->request->session()->write('termsearch',$termsearch);
			$this->request->session()->write('categoriaid',$categoriaid);	
			$this->request->session()->write('laboratorioid',$laboratorioid);
		}
		else 
		{
			$categoriaid = $this->request->session()->read('categoriaid');
		    $laboratorioid = $this->request->session()->read('laboratorioid');
			
			$ofertas = $this->request->session()->read('ofertas');
			$codigobarras  =  $this->request->session()->read('codigobarras');
			$termsearch = "";
			if (!empty($this->request->session()->read('termsearch')))
				$termsearch = $this->request->session()->read('termsearch');
				
			
				if (!empty($this->request->getParam('pass')))
				{
					
					
					$terminocompleto = explode(" ", $this->request->getParam('pass')[0]);
					$termsearch ="";
					if (count($terminocompleto)>1)
					{
							foreach ($terminocompleto as $terminosimple): 
								$termsearch = $termsearch.'%'.$terminosimple.'%';
							endforeach; 
					}
					else
					$termsearch = '%'.$terminocompleto[0].'%';
					
					//$this->request->getParam('pass');
					if (empty($this->request->getParam('pass')[1]))
						$termsearchlab = "";
					else
						$laboratorioid = $termsearchlab;
				}
			
		}
		
		$this->categoriaylaboratorio();
		$this->clientecredito();
		$this->sumacarrito();	
		
		if ($codigobarras && $termsearch!="")
			{
				
				$this->CargarCarritoCB($termsearch);
			}			
				
		$this->viewBuilder()->layout('store');

		$this->loadModel('Articulos');
		
		$fecha = Time::now();
		//$fecha->i18nFormat('YYYY-MM-dd');
	  	$articulosA = $this->Articulos->find()
					->contain([
					'Descuentos' => [					
						'queryBuilder' => function ($q) {
							return $q->where(['tipo_oferta <> "FP"','tipo_oferta <> "VC"']); // Full conditions for filtering
						}
					]
					,'Carritos' => [
						
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
						'd.fecha_hasta >=' => $fecha->i18nFormat('yyyy-MM-dd'),
						'd.tipo_oferta in ("RV","RR","OR","TD","RL","SS","FR")'
						]		
					]
					);
				//->where(['eliminado'=>0]);
					
		//'conditions' => 'd.articulo_id = Articulos.id and CURRENT_DATE() <= d.fecha_hasta and d.tipo_venta in ("D ","  ")',
				
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
					['d.tipo_oferta'=>"RV"],
					['d.tipo_oferta'=>"RL"],
					['d.tipo_oferta'=>"SS"],
					['d.tipo_oferta'=>"FR"]
					
					],
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
					['d.tipo_oferta'=>"RV"],
					['d.tipo_oferta'=>"RL"],
					['d.tipo_oferta'=>"SS"],
					['d.tipo_oferta'=>"FR"]					
					]
				]);
		
			}
		}
			
		if ($articulosA!=null)
		{
			$articulosA->andWhere(['Articulos.eliminado'=>0])->group(['Articulos.id']);
			$limit =25;
			if ($articulosA->count()<100 && $articulosA->count()>50 )
			{
				$limit = 50;
			}
			if ($articulosA->count()>100 )
			{
				$limit= 70;
			}
			
			$this->paginate = [		
			'contain' => ['Carritos'],
			'limit' => $limit,
			'offset' => 0, 
			'order' => ['Articulos.descripcion_pag' => 'asc']];
			
			
			$articulos = $this->paginate($articulosA);
		}
		else
			$articulos = null;
		$this->set(compact('articulos'));
    }
	
	public function searchadd( $termsearch = null)
    {
	
		
		if ($termsearch!="")
			{
				
				$this->CargarCarritoCB($termsearch);
			}			
				
		$this->viewBuilder()->layout('store');
		$this->redirect($this->referer());

		
    }

	public function import()
    {
		$this->viewBuilder()->layout('store');
       
		$this->clientecredito();
		$this->sumacarrito();	
	
		$this->loadModel('Ofertas');
		
		$connection = ConnectionManager::get('default');

		$ofertas = $connection->execute('SELECT ofertas.*, articulos.precio_publico, articulos.categoria_id, articulos.compra_max, 
		  descuentos.dto_drogueria, descuentos.articulo_id, descuentos.plazo, descuentos.uni_min, descuentos.tipo_oferta, descuentos.tipo_venta, descuentos.tipo_precio ,ofertas.oferta_tipo_id 
		  FROM ofertas LEFT JOIN articulos on articulos.id = ofertas.articulo_id INNER JOIN descuentos on descuentos.articulo_id =  articulos.id and 
		  descuentos.tipo_venta = "D" and	descuentos.fecha_hasta >=CURRENT_DATE() and	descuentos.tipo_oferta in ("RV","RR","OR","TD","RL","SS","FR") where ofertas.activo=1 and articulos.stock<>"F" ORDER BY ofertas.id DESC '  )->fetchAll('assoc');
		
		$this->set('ofertas',$ofertas);
		
    }
	
	public function guardarcarritotemp($temp = null)
	{
				//debug($temp);
				$this->loadModel('CarritosTemps');
		
				$descuento_pf = $this->request->session()->read('Auth.User.pf_dcto');
				$condicion = $this->request->session()->read('Auth.User.condicion');
				$condiciongeneral = 100*(1-($descuento_pf * (1-$condicion/100)));

				$tablaped =$this->request->session()->read('tablaped');
				$campotob = $this->request->session()->read('campotob');
				
				$carrito = $this->CarritosTemps->newEntity();
				$carrito['cliente_id']=$this->request->session()->read('Auth.User.cliente_id');
				$carrito['creado']=date('Y-m-d H:i:s');
				
				if (array_key_exists($temp[$campotob], $tablaped)) 
				{
					$carrito['cantidad'] = $tablaped[$temp[$campotob]][0];
				}
				if (array_key_exists($temp['codigo_barras2'], $tablaped)) 
				{
					$carrito['cantidad'] = $tablaped[$temp['codigo_barras2']][0];
				}
				if (array_key_exists($temp['codigo_barras3'], $tablaped)) 
				{
					$carrito['cantidad'] = $tablaped[$temp['codigo_barras3']][0];
				}	
					
				$carrito['articulo_id'] = $temp['id'];
				$carrito['precio_publico'] = $temp['precio_publico']; 	
				$carrito['descripcion'] = $temp['descripcion_pag']; 	
				$carrito['categoria_id'] = $temp['categoria_id']; 	
				$carrito['compra_max'] = $temp['compra_max']; 
				if ($temp['descuentos'] !=null)
				{
					if ($temp['descuentos'][0]['tipo_venta']=='D')
					{

						if ($temp['descuentos'][0]['tipo_oferta']!='TH')
						{
							$carrito['descuento'] = $temp['descuentos'][0]['dto_drogueria']; 	
							
						}
						else
						{
							
							$carrito['descuento'] = $temp['descuentos'][0]['dto_drogueria'] + $condiciongeneral; 	
								
						}

						
					//$carrito['descuento'] = $temp['descuentos'][0]['dto_drogueria']; 	
					$carrito['plazoley_dcto'] = $temp['descuentos'][0]['plazo']; 	
					$carrito['unidad_minima'] = $temp['descuentos'][0]['uni_min']; 	
					$carrito['tipo_oferta'] = $temp['descuentos'][0]['tipo_oferta']; 	
					$carrito['tipo_oferta_elegida'] = $temp['descuentos'][0]['tipo_venta']; 
					$carrito['tipo_precio'] = $temp['descuentos'][0]['tipo_precio']; 
					
				
					}
					else
					{
					$carrito['descuento'] = 0; 	
					$carrito['plazoley_dcto'] = 'HABITUAL'; 	
					$carrito['unidad_minima'] = 1; 	
					$carrito['tipo_oferta'] = null; 	
					$carrito['tipo_oferta_elegida'] = null; 
					$carrito['tipo_precio'] = null; 
					}
				}
				else
				{
					
					$carrito['descuento'] = 0; 	
					$carrito['plazoley_dcto'] = 'HABITUAL'; 	
					$carrito['unidad_minima'] = 1; 	
					$carrito['tipo_oferta'] = null; 	
					$carrito['tipo_oferta_elegida'] = null; 
					$carrito['tipo_precio'] = null; 
									
				}
				if ($carrito['tipo_precio']=='P' && ($carrito['tipo_oferta']=='TD' || $carrito['tipo_oferta']=='TL' || $carrito['tipo_oferta']=='OR' || $carrito['tipo_oferta']=='OD'||$carrito['tipo_oferta']=='TH')) 
                        $carrito['tipo_fact']= 'TR';
					else
						if ($carrito['tipo_precio']=='F' && ($carrito['tipo_oferta']=='TD' || $carrito['tipo_oferta']=='TL' || $carrito['tipo_oferta']=='OR' || $carrito['tipo_oferta']=='OD'||$carrito['tipo_oferta']=='TH')) 
						
							$carrito['tipo_fact']= 'TL';
						else 
							$carrito['tipo_fact']= 'N';
				
				$insertar = $this->CarritosTemps->find('all')
							->where(['articulo_id'=>$temp['id']])
							->andWhere(['cliente_id'=>$carrito['cliente_id']]);
				
				
				
				if ($insertar->first() ==null)
				{
					$cantidad = $carrito['cantidad'];
					$cantidadmax = $carrito['compra_max']; 
					/*
					if ($carrito['categoria_id']!=5 && $carrito['categoria_id']!=4 )
					$cantidadmax = 100;
					else
					$cantidadmax = 500;	*/
					if ($cantidad>$cantidadmax && $this->request->session()->read('Auth.User.grupo')!=33 && $this->request->session()->read('Auth.User.grupo')!=1)
						$carrito['cantidad'] = $cantidadmax ;
					if ($this->CarritosTemps->save($carrito))
					{
						
						//$this->redirect($this->referer());
					}
					else
					{
						
						//$this->redirect($this->referer());
					}
				}
				
			
	}
	
	public function sumacarritotemp()
	{
		$this->loadModel('CarritosTemps');
		$carritocon = $this->CarritosTemps->find('all')
					->contain(['Articulos'])
					->where(['CarritosTemps.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
					->order(['CarritosTemps.id' => 'DESC']);
		//$this->set('carritos', $carritocon->toArray());
		
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
		$this->set('totalitemstemp',$totalitems);
		$this->set('totalcarritotemp',$totalcarrito);
		$this->set('totalunidadestemp',$totalunidades);

		//$this->set('carritos', $carritocon->toArray());
		return $carritocon;
	}
	
	public function importresult()
	{
		$this->viewBuilder()->layout('store');
		$this->loadModel('Articulos');
		$this->paginate = ['contain' => ['Descuentos','CarritosTemps'],
							'limit' => 80,
							 'order' => ['Articulos.descripcion_pag' => 'asc']];
		if ($this->request->is('post'))
		{
			if  (($this->request->data['filetext']!=null)&&($this->request->data['sistfarm']!=null))
			{	
				$file = $this->request->data['filetext'];
				$sistfar = $this->request->data['sistfarm'];
				$codbardde = substr($sistfar,0,2) - 1;
				$codbarlong = substr($sistfar,2,2);
				$cantidaddde = substr($sistfar,4,2) - 1;
				$cantidadlong = substr($sistfar,6,2);
				$descdde = substr($sistfar,8,2) - 1;
				$desclong = substr($sistfar,10,2);
				$tob = substr($sistfar,12,1);
			
				$fecha = Time::now();
				$dia = $fecha->i18nFormat('yyyyMMdd-HHmmss');
				$codigo = str_pad($this->request->session()->read('Auth.User.codigo'), 6, "0", STR_PAD_LEFT);
				$uploadPath = 'temp/importfile/';
                $uploadFile = $uploadPath.$dia.'_'.$codigo.'_'.$sistfar.'.txt';
				$this->request->session()->write('uploadFile',$uploadFile);	
				move_uploaded_file($this->request->data['filetext']['tmp_name'],$uploadFile);

				//if ($tob == 'T') {$campotob = 'troquel';} else {$campotob = 'codigo_barras';}
				if ($tob == 'T') {$campotob = 'troquel';} else {$campotob = 'c_barra';}
				$tablaped =array();
				$listaarray=array();
				foreach (file( $uploadFile) as $line) {
					mb_internal_encoding("UTF-8");
					$codbar = mb_substr($line,$codbardde,$codbarlong);
					$cantidad = mb_substr($line,$cantidaddde,$cantidadlong);
					
					//$codbar = substr($line,$codbardde,$codbarlong);
					//$cantidad = substr($line,$cantidaddde,$cantidadlong);
					  if ($codbar != '' && $codbar != '             ') {
						 $codbar = trim($codbar,' ');
						 //$codbar = trim($codbar, " \t\n\r\0\x0B");
						 $codbar = ltrim($codbar, '0'); 
						 $cantidad = trim($cantidad,' ');
						 
						  if(!is_numeric($codbar)) {
								$this->Flash->error('No es un codigo de barras o cantidad correcta '.$line,['key' => 'changepass']);
							}	
						 if(!is_numeric($cantidad)) {
								$this->Flash->error('No es un codigo de barras o cantidad correcta '.$line,['key' => 'changepass']);
							}
						/*
						 if ($codbar != '')
						 {
						 array_push($listaarray,$codbar);
						 $tablaped[$codbar] = [$cantidad,$line];
						 }*/
						 
						 if ($codbar != '')
						 {
							 if (($tob != 'T') && (is_numeric($codbar)) &&(is_numeric($cantidad)))
							 {
								array_push($listaarray,$codbar);
								$tablaped[$codbar] = [$cantidad,$line];
							 }
							 else
								if (($tob == 'T') && (is_numeric($cantidad)))
								{
									array_push($listaarray,$codbar);
									$tablaped[$codbar] = [$cantidad,$line];
								}
						 }
					  }
				}
				
				$this->request->session()->write('listaarray',$listaarray);
				$this->request->session()->write('tablaped',$tablaped);	
				$this->request->session()->write('campotob',$campotob);	
			}
			else
			{
				 $this->Flash->error('Seleccione el archivo y el tipo de sistema de pedido',['key' => 'changepass']);
				 return $this->redirect($this->referer());
			}
		}
		else 
		{
			$listaarray = $this->request->session()->read('listaarray');
		    $tablaped = $this->request->session()->read('tablaped');
			$campotob = $this->request->session()->read('campotob');
		}
		if ($this->request->is('post'))
		{
			
			$noimportados =array();
			$error="";
			
			$rowarticulos = $this->Articulos->find()
						->contain([
					'Descuentos' => [					
						'queryBuilder' => function ($q) {
							return $q->where(['tipo_oferta <> "FP"','tipo_oferta <> "VC"']); // Full conditions for filtering
						}
					]
						
						])
						->hydrate(false)
						
						->join([
							'table' => 'descuentos',
							'alias' => 'd',
							'type' => 'LEFT',
							'conditions' => 'd.articulo_id = Articulos.id and d.fecha_hasta <= CURRENT_DATE() and d.tipo_venta in ("D ","  ")',
						])
						->where(['Articulos.categoria_id <'=>7])
						->where(['Articulos.eliminado'=>0])
						->where(['Articulos.'.$campotob.' in '=>$listaarray])
						->orWhere(['Articulos.codigo_barras2 in'=>$listaarray])
						->orWhere(['Articulos.codigo_barras3 in'=>$listaarray])
						->where(['Articulos.eliminado'=>0]);
						
						
			foreach ($rowarticulos as $row)
			{
				$this->guardarcarritotemp($row);
				
				$key = array_search($row[$campotob], $listaarray);
				if($key!==false){
					unset($listaarray[$key]);
				}
				else
				{
					$key = array_search($row['codigo_barras2'], $listaarray);
					if($key!==false){
						unset($listaarray[$key]);
					}
					else
					{
						$key = array_search($row['codigo_barras3'], $listaarray);
						if($key!==false){
							unset($listaarray[$key]);
						}
					}
				}
			}
			
			foreach ($listaarray as $row)
			{		$noimportodolinea=array();
					
					$insertrow = $tablaped[$row];
					$insertrow = $tablaped[$row];
					$error .='<tr><td>' .intval($insertrow[0]). '</td>' .
									  '<td>' . substr($insertrow[1],$codbardde,$codbarlong)  . '</td>' .
									  '<td>' . substr($insertrow[1],$descdde,$desclong) . '</td>' .
									  '<td align="right">'.$insertrow[1].'</td></tr>';

										//mb_internal_encoding("UTF-8");
					//$codbar = mb_substr($line,$codbardde,$codbarlong);
					//$cantidad = mb_substr($line,$cantidaddde,$cantidadlong);
									  
					$noimportodolinea[0] =  $insertrow[0];
					$noimportodolinea[2] =  substr($insertrow[1],$codbardde,$codbarlong);
					$noimportodolinea[3] = 	substr($insertrow[1],$descdde,$desclong);	
					$noimportodolinea[1] =  $insertrow[1];					
								 
					array_push($noimportados,$noimportodolinea);
			}
			
			$this->request->session()->write('noimportados',$noimportados);	
			$this->request->session()->write('errorimport',$error);	
		}
		else
		{
			$error = $this->request->session()->read('errorimport');			
		}	

		$articulosA = $this->Articulos->find('all')
					->contain (['CarritosTemps' => [
						
						'queryBuilder' => function ($q) {
							return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); // Full conditions for filtering
						}
					]
				])
					->hydrate(false)
					->join([
						'table' => 'carritos_temps',
						'alias' => 'ct',
						'type' => 'inner',
						
						'conditions' => ['ct.articulo_id = Articulos.id','ct.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]
					])	
					->where(['Articulos.eliminado'=>0])
					->where(['ct.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]);							
					
		if ($articulosA!=null)
		{
			$articulos = $this->paginate($articulosA);
		}
		else
		{
			$articulos = null;
		}

		$this->set('error',$error);		
		
		$this->set(compact('articulos'));	
		
		$this->categoriaylaboratorio();
		$this->clientecredito();
		$this->sumacarrito();	
		$this->sumacarritotemp();
		/*$this->loadModel('CarritosTemps');
		$carritotemp = $this->CarritosTemps->find('all')
						->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]);

		$totalcarritotemp=0;
		$totalitemstemp=0;
		$totalunidadestemp=0;
		foreach ($carritotemp as $carrito): 
			$totalitemstemp+=1;
			if ($carrito['tipo_precio']=="P")
				$totalcarritotemp= $totalcarritotemp + $carrito['cantidad']*$carrito['precio_publico'];
			else
				$totalcarritotemp= $totalcarritotemp + $carrito['cantidad']*round(h($carrito['precio_publico'])*0.807, 3);
			$totalunidadestemp= $totalunidadestemp + $carrito['cantidad'];
		
		endforeach; 
		$this->set('totalitemstemp',$totalitemstemp);
		$this->set('totalcarritotemp',$totalcarritotemp);
		$this->set('totalunidadestemp',$totalunidadestemp);*/
		
	}
		
	public function importresultexcel()
	{
		$this->viewBuilder()->layout('store');
		$this->loadModel('Articulos');
		$this->paginate = ['contain' => ['Descuentos','CarritosTemps'],
							'limit' => 80,
							 'order' => ['Articulos.descripcion_pag' => 'asc']];
		
		
		if ($this->request->is('post'))
		{
			if  (!empty($this->request->data['filetext']))
			{	


				$file = $this->request->data['filetext'];
				if ($file['name'] =='')
				{
				$this->Flash->error('Seleccione el archivo',['key' => 'changepass']);
				return $this->redirect($this->referer());
				}
				//$fini = $this->request->data['fini']; // fila inicio
				//$fend = $this->request->data['fend']; // fila ultima
				$nsheet= $this->request->data['nsheet']; // nombre de la hoja.
				$cean = $this->request->data['cean']; // Columna EAN
				$ccant = $this->request->data['ccant']; // Columna Cantidad
				$cdesc= $this->request->data['cdesc']; // Columna Descripcion
				
				if ($this->request->data['nsheet'] =="" ||  $this->request->data['cean']==""  || $this->request->data['ccant'] =="" || $this->request->data['cdesc']=="")
				{
				$this->Flash->error('Ingrese los datos solicitados.',['key' => 'changepass']);
							return $this->redirect($this->referer());
				}
				else
					{
						
						$cean = strtoupper($cean); // Columna EAN
						$ccant = strtoupper($ccant); // Columna Cantidad
						$cdesc= strtoupper($cdesc); // Columna Descripcion
					}
				/*
				if ($this->request->data['filetext']['type'] =='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
				$tipo = 'Xlsx';
					
				else
					if ($this->request->data['filetext']['type'] =='application/vnd.ms-excel')
						$tipo = 'Xls';
						else
						{
							$this->Flash->error('Seleccione una planilla de excel con extención xls o xlsx',['key' => 'changepass']);
							return $this->redirect($this->referer());
						}
				*/
				$campotob = 'c_barra';
				$this->request->session()->write('campotob', $campotob);		

				$min =  min(array(ord($cean), ord($ccant), ord($cdesc)));
				$max =  max(array(ord($cean), ord($ccant), ord($cdesc)));
                $uploadPath = 'temp/excel/';
                $uploadFile = $uploadPath.$this->request->data['filetext']['name'];
				move_uploaded_file($this->request->data['filetext']['tmp_name'],$uploadFile);

				$tipo = IOFactory::identify($uploadFile);
				if (($tipo == 'Xlsx') || ($tipo == 'Xls'))
				{
					$tipo = IOFactory::identify($uploadFile);		
				}
				else
				{
					$this->Flash->error('Seleccione una planilla de excel con extención xls o xlsx',['key' => 'changepass']);
					return $this->redirect($this->referer());
				}

                //move_uploaded_file($this->request->data['filetext']['tmp_name'],$uploadFile);

				$reader = IOFactory::createReader($tipo);
				//$helper->log('Loading Sheet "' . $sheetname . '" only');
				$consult = $reader->listWorksheetNames( $uploadFile);
				$this->request->session()->write('consult', $consult);

				if (!in_array($nsheet, $consult)) 
					{
						$this->Flash->error('Ingrese el nombre de la hoja correcto',['key' => 'changepass']);
						return $this->redirect($this->referer());
					}
					

				$reader->setLoadSheetsOnly($nsheet);
				
			
				//$helper->log('Loading Sheet using configurable filter');
				//$reader->setReadFilter($filterSubset);
				$spreadsheet = $reader->load($uploadFile);

		
				$dataArray= $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
				$this->request->session()->write('Importado',$dataArray);
				//var_dump($sheetData);	
					
					
				$tablaped =array();
				$listaarray=array();
				foreach ($dataArray  as $row) {
					 $codbar = $row[$cean];
					 
					 $codbar = trim($codbar,' ');
					 $codbar = ltrim($codbar, '0'); 
					 
					 $cantidad =  $row[$ccant];
					 $descripcion = $row[$cdesc];
					 					 
					  if ($cantidad == null)
						  $cantidad =1;
					 if ($codbar != '' && $codbar != null) {
						array_push($listaarray,$codbar);
						$tablaped[$codbar] = [$cantidad,$descripcion,$codbar];
						
					 }
				}
				
				$this->request->session()->write('listaarray',$listaarray);
				$this->request->session()->write('tablaped',$tablaped);	
				
			}
			else
			{
				 $this->Flash->error('Seleccione el archivo',['key' => 'changepass']);
				 return $this->redirect($this->referer());
			}
		}
		else 
		{
			$listaarray = $this->request->session()->read('listaarray');
		    $tablaped = $this->request->session()->read('tablaped');
			//$campotob = $this->request->session()->read('campotob');
		}
		if ($this->request->is('post'))
		{
			
			$noimportados =array();
			$error="";
				$rowarticulos = $this->Articulos->find('all')
						->contain (['Descuentos'])
						->hydrate(false)
						
						->join([
							'table' => 'descuentos',
							'alias' => 'd',
							'type' => 'LEFT',
							'conditions' => 'd.articulo_id = Articulos.id and d.fecha_hasta <= CURRENT_DATE() and d.tipo_venta in ("D ","  ")',
						])
						->where(['Articulos.categoria_id <'=>7])
						->where(['Articulos.eliminado'=>0])
						->where(['Articulos.codigo_barras in '=>$listaarray])
						->orWhere(['Articulos.codigo_barras2 in'=>$listaarray])
						->orWhere(['Articulos.codigo_barras3 in'=>$listaarray])
						->orWhere(['Articulos.c_barra in'=>$listaarray])
						->where(['Articulos.eliminado'=>0]);
				
				$this->request->session()->write('rowarticulos',$rowarticulos->toArray());				
				
			foreach ($rowarticulos as $row)
			{
				$this->guardarcarritotemp($row);
				
				$key = array_search($row['codigo_barras'], $listaarray);
				if($key!==false){
					unset($listaarray[$key]);
				}
				else
				{
					$key = array_search($row['codigo_barras2'], $listaarray);
					if($key!==false){
						unset($listaarray[$key]);
					}
					else
					{
						$key = array_search($row['codigo_barras3'], $listaarray);
						if($key!==false){
							unset($listaarray[$key]);
						}
						else
						{
							$key = array_search($row['c_barra'], $listaarray);
							if($key!==false){
								unset($listaarray[$key]);
							}
						}
					}
				}
			}
			
			foreach ($listaarray as $row)
			{		$noimportodolinea=array();
					
					
					$insertrow = $tablaped[$row];
					$error .='<tr>'.
							 '<td>'.$insertrow[0].'</td>' .
							 '<td>'.$insertrow[1].'</td>' .
							 '<td>'.$insertrow[2].'</td>' .
							'</tr>';
									  
					$noimportodolinea[0] =  $insertrow[0];
					$noimportodolinea[1] =  $insertrow[1];
					$noimportodolinea[2] = 	$insertrow[2];	
					
								 
					array_push($noimportados,$noimportodolinea);

			}
			
			$this->request->session()->write('noimportados',$noimportados);	
			$this->request->session()->write('errorimport',$error);	
			
		}
		else
		{
			$error = $this->request->session()->read('errorimport');			
		}	
		
	

		$articulosA = $this->Articulos->find('all')
					->contain (['CarritosTemps' => [
						
						'queryBuilder' => function ($q) {
							return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); // Full conditions for filtering
						}
					]
				])
					->hydrate(false)
					->join([
						'table' => 'carritos_temps',
						'alias' => 'ct',
						'type' => 'inner',
						
						'conditions' => ['ct.articulo_id = Articulos.id','ct.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]
					])	
					->where(['Articulos.eliminado'=>0])
					->where(['ct.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]);							
					
		if ($articulosA!=null)
		{
			$articulos = $this->paginate($articulosA);
		}
		else
		{
			$articulos = null;
		}

		$this->set('error',$error);		
		
		$this->set(compact('articulos'));	
		
		$this->categoriaylaboratorio();
		$this->clientecredito();
		$this->sumacarrito();	
		$this->sumacarritotemp();

	}
	

	public function importconfirm ()
	{
				
		$this->loadModel('CarritosTemps');
		$carritos = TableRegistry::get('CarritosTemps');
		$entities = $carritos->newEntities($this->request->data());
		foreach ($entities as $carrito) {
		if (($carrito['cantidad']=='0') || ($carrito['cantidad']!=''))
		{
			$carritosTemp = $this->CarritosTemps->get($carrito['carrito_temp_id']);
			if ($this->CarritosTemps->delete($carritosTemp)) {
			}
		}
		}		
		$connection = ConnectionManager::get('default');

		$confirmados = $connection->execute('DELETE FROM ds.carritos WHERE id IN 
		(SELECT * FROM (SELECT c.id FROM carritos_temps ct INNER JOIN carritos c ON (c.articulo_id = ct.articulo_id AND c.cliente_id= ct.cliente_id)  WHERE c.cliente_id='.$this->request->session()->read('Auth.User.cliente_id').') CTP)');
		
		$confirmados = $connection->execute('INSERT INTO carritos (id, cliente_id, 	articulo_id, 	descripcion, 	cantidad, 	precio_publico, 	descuento, 	unidad_minima, 	tipo_precio, 	plazoley_dcto,	combo_id, 	tipo_oferta, 	tipo_oferta_elegida, 	tipo_fact, creado, 	modificado, categoria_id, compra_max) 
			SELECT  NULL, cliente_id, 	articulo_id, 	descripcion, 	cantidad, 	precio_publico, 	descuento, 	unidad_minima, 	tipo_precio, 	plazoley_dcto,	combo_id, 	tipo_oferta, 	tipo_oferta_elegida, 	tipo_fact, creado, 	modificado ,categoria_id, compra_max 
			FROM carritos_temps WHERE cliente_id='.$this->request->session()->read('Auth.User.cliente_id') );
		 $confirmados = $connection->execute('delete from carritos_temps WHERE cliente_id='.$this->request->session()->read('Auth.User.cliente_id') );

		 $this->Flash->success('Se importo correctamente. Puede existir alguna restricion de Unidades',['key' => 'changepass']);
		return $this->redirect(['controller'=>'Carritos','action' => 'importresult']);
	}
	
	public function downloadfile (){
		if ($this->request->session()->read('noimportados')!=null)
		{
			
			$codigo = str_pad($this->request->session()->read('Auth.User.codigo'), 6, "0", STR_PAD_LEFT);
			$file = new File('temp'. DS .$codigo.'.TXT', true, 0777);
			
			foreach ($this->request->session()->read('noimportados') as $row): 
				$file->write($row[1]);

			endforeach; 
		
			$file->close(); // Be sure to close the file when you're done
		

			$this->response->type('txt');

			// Optionally force file download
			//
			//
			//$this->response->file('temp'. DS .'DETFAC'.$codigo.'.TXT');
			$this->response->file(
			'temp'. DS .$codigo.'.TXT',
			['download' => true, 'name' => $codigo.'.TXT']
			);

			return $this->response;
		}
		else
		{
			$this->Flash->error('No se pudo descargar',['key' => 'changepass']);
				 return $this->redirect($this->referer());
			
		}
	}
	
	public function vel()
    {
		$this->viewBuilder()->layout('store');
		//$this->request->session()->write('Auth.User.cliente_id',234526);

    	$this->paginate = [
						'contain' => ['Laboratorios','Categorias'],
						'limit' => 11,
						'order' => ['Articulos.descripcion_pag' => 'asc']];
		$this->loadModel('Articulos');
		$carritocon = $this->Carritos->find('all')	
					->where(['Carritos.cliente_id' => 234526])
					->order(['Carritos.id' => 'DESC']);
		/*$this->loadModel('ClientesCreditos');
		$clientecreditos = $this->ClientesCreditos->find('all')	
					->where(['cliente_id' => 234526]);
		$clientecredito = $clientecreditos->first();*/
		$this->set('creditodisponible',200000.00);
	
		$this->loadModel('Ofertas');
		
		$connection = ConnectionManager::get('default');
		$ofertas = $connection->execute('SELECT ofertas.*, articulos.precio_publico, 
		  descuentos.dto_drogueria, descuentos.articulo_id, descuentos.plazo, descuentos.uni_min, descuentos.tipo_oferta, descuentos.tipo_venta, descuentos.tipo_precio 
		  FROM ofertas LEFT JOIN articulos on articulos.id = ofertas.articulo_id LEFT JOIN descuentos on descuentos.articulo_id =  articulos.id and 
		  descuentos.tipo_venta = "D" and	descuentos.fecha_hasta >=CURRENT_DATE() and	descuentos.tipo_oferta in ("RV","RR","OR","TD","RL","SS","VC") where ofertas.activo=1')->fetchAll('assoc');
		$this->set('ofertas',$ofertas);
	
		$totalcarrito=0;
		$totalitems=0;
		$totalunidades=0;
		/*foreach ($carritocon as $carrito): 
			$totalitems+=1;
			if ($carrito['tipo_precio']=="P")
				$totalcarrito= $totalcarrito + $carrito['cantidad']*$carrito['precio_publico'];
			else
				$totalcarrito= $totalcarrito + $carrito['cantidad']*round(h($carrito['precio_publico'])*0.807, 3);
			
			$totalunidades= $totalunidades + $carrito['cantidad'] ;
		endforeach; */
		$this->set('totalitems',66666.00);
		$this->set('totalcarrito',200000.00);
		$this->set('totalunidades',100.0);
		$this->set('carritos', null);
	    
        $articulos = null;//$this->paginate($this->Articulos);
		$this->set(compact('articulos'));
		if ($this->request->session()->read('Categorias')== null)
		{
			$this->loadModel('Categorias');
			$this->loadModel('Laboratorios');
			$categorias = $this->Categorias->find('list',['keyField' => 'id','valueField'=>'nombre']);
			$laboratorios = $this->Laboratorios->find('list',['keyField' => 'id','valueField'=>'nombre'])->order(['nombre' => 'ASC']);

			$this->request->session()->write('Categorias',$categorias->toArray());
			$this->request->session()->write('Laboratorios',$laboratorios->toArray());
			
		}
		else{
			
			$laboratorios =$this->request->session()->read('Laboratorios');
			$categorias = $this->request->session()->read('Categorias');
		}	
		$this->set('categorias',$categorias );
		$this->set('laboratorios',$laboratorios);
	}
	
	public function excel()
    {
		$this->viewBuilder()->layout('ajax');
		
		$this->loadModel('Articulos');
		$articulosA = $this->Articulos->find('all')
					->contain (['CarritosTemps'])
					->hydrate(false)
					->join([
						'table' => 'carritos_temps',
						'alias' => 'ct',
						'type' => 'inner',
						'conditions' => ['ct.articulo_id = Articulos.id','ct.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]
					])
					->where(['ct.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
					->order(['Articulos.descripcion_sist' => 'ASC']);				
				
		if ($articulosA!=null)
		{
			$articulos = $articulosA->toArray();
		}
		else
		{
			$articulos = null;
		}
		$this->set(compact('articulos'));
		
		
		$this->loadModel('CarritosTemps');
		$carritotemp = $this->CarritosTemps->find('all')
						->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]);

		$totalcarritotemp=0;
		$totalitemstemp=0;
		$totalunidadestemp=0;
		foreach ($carritotemp as $carrito): 
			$totalitemstemp+=1;
			
			if ($carrito['tipo_precio']=="P")
				$totalcarritotemp= $totalcarritotemp + $carrito['cantidad']*$carrito['precio_publico'];
			else
			$totalcarritotemp= $totalcarritotemp + $carrito['cantidad']*round(h($carrito['precio_publico'])*0.807, 3);
			$totalunidadestemp= $totalunidadestemp + $carrito['cantidad'];
		
		endforeach; 
		$this->set('totalitemstemp',$totalitemstemp);
		$this->set('totalcarritotemp',$totalcarritotemp);
		$this->set('totalunidadestemp',$totalunidadestemp);
		$this->response->type('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }
}