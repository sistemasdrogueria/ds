<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\Filesystem\File;
use Cake\Network\Request;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;


class BienestarController extends AppController
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
						$tiene= $this->tienepermiso('bienestar',$this->request->action);
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


	

	public function search($grupoid =null)
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
	 
			if ($this->request->data['grupo_id']!= null)
			{
				$grupoid = $this->request->data['grupo_id'];
				
			}	
		
	 


			$this->request->session()->write('termsearch2',$termsearch2);
		}
		else
		{
			$termsearch2 = $this->request->session()->read('termsearch2');
		}
		if (is_null($grupoid))
		{
			if (!is_null($this->request->session()->read('grupoid'))) 
			$grupoid = $this->request->session()->read('grupoid');
			else
			$grupoid=0;
		}
		else
			$this->request->session()->write('grupoid',$grupoid);
			


		$this->loadModel('Grupos');
		
		$gruposf = $this->Grupos->find('list', ['keyField' => 'id','valueField' => 'nombre'])->where(['grupos_tipos_id IN (8,10)'])->order(['nombre' => 'ASC']);
		$gruposf->toArray();
		$this->set(compact('gruposf'));
		
		$this->viewBuilder()->layout('store');
        //$this->paginate = [	'limit' => 15];
		$this->categoriaylaboratorio();
		$this->clientecredito();
		$this->sumacarrito();		
		$this->loadModel('Articulos');
	    $fecha = Time::now();
		//$fecha->i18nFormat('YYYY-MM-dd');
		$articulosA = $this->Articulos->find('all')
		->contain(['Descuentos','Carritos' => [	'queryBuilder' => function ($q) {
		return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); } ]])
		->hydrate(false)
		->join([
				'table' => 'descuentos',
				'alias' => 'd',
				'type' => 'LEFT',
				'conditions' => [
				'd.articulo_id = Articulos.id',
				'd.tipo_venta = "D"',
				'd.fecha_hasta >=' => $fecha->i18nFormat('yyyy-MM-dd'),
				'd.tipo_oferta in ("RV","RR","OR","TD","RL","SS","VC")'] 
				]);
	 
				  if ($termsearch2!="")
				  {
					  $articulosA->andWhere([
							  
							  'OR' => [['Articulos.descripcion_pag LIKE'=>$termsearch2], 
							  ['Articulos.troquel LIKE'=>$termsearch2],['Articulos.codigo_barras LIKE'=>$termsearch2],['Articulos.codigo_barras2 LIKE'=>$termsearch2]],
						  ]);
				  }
				if ($grupoid !=0)
				{
						  $articulosA->where(['Articulos.grupo_id'=>$grupoid]);
				}
				else
				$articulosA->where(['Articulos.grupo_id in (select id from grupos where grupos_tipos_id IN (8,10))']);
	
		 
				if ($articulosA!=null)
				{
					$articulosA->andWhere(['Articulos.eliminado'=>0,'Articulos.stock<>"D"'])->group(['Articulos.id']);
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


	public function index()
    {
		$this->categoriaylaboratorio();
		$this->viewBuilder()->layout('store');
		//,'Carritos'
        $this->paginate = [		
		'contain' => ['Descuentos','Carritos'],
		'limit' => 50,
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
					->where(['Articulos.subcategoria_id'=>26]);
					
					
		if ($articulosA!=null)
		{
			$limit =75;
			if ($articulosA->count()<100 && $articulosA->count()>50 )
			{
				$limit = 75;
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
		
		
		$this->loadModel('Grupos');
		//$this->loadModel('Generos');
		
		$gruposf = $this->Grupos->find('list', ['keyField' => 'id','valueField' => 'nombre'])->where(['grupos_tipos_id IN (8,10)'])->order(['nombre' => 'ASC']);
		//$generos = $this->Generos->find('list', ['keyField' => 'id','valueField' => 'nombre']);
		$gruposf->toArray();
		//$generos->toArray();
		$this->set(compact('gruposf'));
		//$this->loadModel('Generos');
		$grupos = $this->Grupos->find('all')->where(['grupos_tipos_id IN (8,10)'])->order(['nombre' => 'ASC']);
		//$generos = $this->Generos->find('list', ['keyField' => 'id','valueField' => 'nombre']);
		$grupos->toArray();

		$this->set(compact('grupos'));

		$this->set(compact('articulos'));

		$this->loadModel('Incorporations');
		$incorporationsA = $this->Incorporations->find('all');
		$incorporationsA->where(['habilitada'=>1,'incorporations_tipos_id '=>15])->limit([5])->order(['id' => 'DESC']);
		$incorporations = $incorporationsA->toArray();
        $this->set('incorporations', $incorporations);
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
