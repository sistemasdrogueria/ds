<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\Filesystem\File;
use Cake\Network\Request;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;


class OrtopediasController extends AppController
{
public function isAuthorized()
    {
       	if (in_array($this->request->action, ['search','home','index','view'])) {
				if($this->request->session()->read('Auth.User.role')=='admin') 
				{				
					return true;			
				}			
				else 
				{	
					if($this->request->session()->read('Auth.User.role')=='client') 
					{	
						$tiene= $this->tienepermiso('facturas',$this->request->action);
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



	public function sumacarrito()
	{
		/*
		$carritocon = $this->Carritos->find('all')
					->contain(['Articulos'])
					->where(['Carritos.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
					->order(['Carritos.cantidad  < Carritos.unidad_minima '=> 'DESC','Carritos.id' => 'DESC']);
		
		$this->set('carritos', $carritocon->toArray());
		*/
		$this->loadModel('Carritos');
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
				
	public function clientecredito()
	{
		$this->loadModel('ClientesCreditos');
		if ($this->request->session()->read('Auth.User.cliente_id') !=36231)
			 $cliente = $this->request->session()->read('Auth.User.cliente_id');
		 else
			 $cliente = 36230;
		
		$clientecreditos = $this->ClientesCreditos->find('all')		->where(['cliente_id' => $cliente]);
		
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


	
	public function search()
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
			{
				$cliente_id = $this->request->session()->read('Auth.User.cliente_id');
				$this->request->session()->write('cliente_id',$cliente_id);
			}			
		}
		/*
		if ($this->request->session()->read('Auth.User.cuentaprincipal')==1)
		{
			$this->loadModel('Clientes');
			
			$Clientes = $this->Clientes->find('all')->Select(['id','codigo','nombre'])->where(['grupo_id'=>$this->request->session()->read('Auth.User.grupo')]);
			$first =0;
			foreach ($Clientes as $opcion) {
			
				$clientes[$opcion['id']] = $opcion['codigo'].' - '.$opcion['nombre'];    
			}	
		}
		else
		{
			$clientes[$this->request->session()->read('Auth.User.cliente_id')] = $this->request->session()->read('Auth.User.codigo').' - '.$this->request->session()->read('Auth.User.razon');
		}
		$this->set('clientes',$clientes);
		*/
		$this->listadocliente();
		$this->viewBuilder()->layout('store');
		$this->loadModel('FacturasCabeceras');
        $this->paginate = [
            'contain' => ['Comprobantes'],
			'limit' => 80
        ];
		$query = $this->FacturasCabeceras->find('all')	
					->hydrate(false)
					->join([
						'table' => 'comprobantes',
						'alias' => 'c',
						'type' => 'LEFT',
						'conditions' => ['FacturasCabeceras.comprobante_id = c.id']		
					])
					->where(['FacturasCabeceras.cliente_id' => $this->request->session()->read('cliente_id')])
					->group('FacturasCabeceras.pedido_ds');
		if ($fechahasta!=0)
		{
			$fechahasta2 = Time::createFromFormat('d/m/Y',$fechahasta,'America/Argentina/Buenos_Aires');
			//$fechahasta2->modify('+1 days');
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

		$query->andWhere(["FacturasCabeceras.fecha BETWEEN '".$fechadesde2->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta2->i18nFormat('yyyy-MM-dd')."'"]);
		
		if ($termsearch!="")
		{
			$query->andWhere([
					'OR' => [['c.nota'=>$termsearch], 
					['c.numero'=>$termsearch]],
				]);
			
		}
        else
		{
		}
		if ($query!=null)
		{
			
			$facturascabeceras = $this->paginate($query);
		}
		else
			$facturascabeceras = null;
		
		$this->request->session()->write('facturascabeceras',$facturascabeceras);
        $this->set('facturasCabeceras', $facturascabeceras);
        $this->set('_serialize', ['facturasCabeceras']);
	}

	public function index()
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
					->where(['Articulos.subcategoria_id'=>12]);
					
					
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

	/**
     * View method
     *
     * @param string|null $id Facturas Cabecera id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
		$this->viewBuilder()->layout('store');
		$this->loadModel('FacturasCabeceras');
        $facturasCabecera = $this->FacturasCabeceras->get($id, ['contain' => ['Clientes', 'Comprobantes']]);
		
		$this->paginate = [
            'contain' => ['FacturasCabeceras', 'Articulos']
        ];
        $this->loadModel('FacturasCuerposItems');
		$facturasCuerposItems =	$this->FacturasCuerposItems->find('all')->where(['facturas_encabezados_id' => $id]);
										
		$this->set('facturasCuerposItems', $this->paginate($facturasCuerposItems));
        $this->set('_serialize', ['facturasCuerposItems']);
		
		
        $this->set('facturasCabecera', $facturasCabecera);
        $this->set('_serialize', ['facturasCabecera']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */

}
