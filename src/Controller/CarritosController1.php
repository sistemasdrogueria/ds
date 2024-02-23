<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Filesystem\File;
use Cake\Network\Request;
use Cake\Database\Expression\QueryExpression;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;
/**
 * Carritos Controller
 *
 * @property \App\Model\Table\CarritosTable $Carritos
 */
class CarritosController extends AppController
{
	public function isAuthorized()
    {
		if (in_array($this->request->action, ['edit', 'delete','delete_temp','add','search','vaciar','confirm','import','importresult','index','home','carritoadd','carritoaddall','downloadfile','carritoaddoferta','vaciarimport','carritotempadd','carritotempaddall','importconfirm','view','excel','fraganciaselectiva','resultfraganciaselectiva','sale'])) {
       
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

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
		$this->viewBuilder()->layout('store');
		$this->loadModel('Articulos');
		$carritocon = $this->Carritos->find('all')	
					->where(['Carritos.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
					->order(['Carritos.id' => 'DESC']);

		$this->loadModel('ClientesCreditos');
		$clientecreditos = $this->ClientesCreditos->find('all')	
					->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]);
		$clientecredito = $clientecreditos->first();
		
		$this->set('creditodisponible',$clientecredito['credito_maximo']-$clientecredito['credito_consumo']);
		if ($clientecredito['compra_minima']!=null)
			{
				$this->request->session()->write('compra_minima',$clientecredito['compra_minima']);		
			}
			else
			{
				$this->request->session()->write('compra_minima',500);		
			}
		$totalcarrito=0;
		$totalitems=0;
		$totalunidades=0;
		foreach ($carritocon as $carrito): 
			$totalitems+=1;
			if ($carrito['tipo_precio']=="P")
				$totalcarrito= $totalcarrito + $carrito['cantidad']*$carrito['precio_publico'];
			else
				$totalcarrito= $totalcarrito + $carrito['cantidad']*round(h($carrito['precio_publico'])*0.807, 3);
			
			$totalunidades= $totalunidades + $carrito['cantidad'] ;
		endforeach; 
		
		$this->set('totalitems',$totalitems);
		$this->set('totalcarrito',$totalcarrito);
		$this->set('totalunidades',$totalunidades);
		$this->set('carritos', $carritocon->toArray());

		$connection = ConnectionManager::get('default');
		$ofertas = $connection->execute('SELECT ofertas.*, articulos.precio_publico, 
		  descuentos.dto_drogueria, descuentos.articulo_id, descuentos.plazo, descuentos.uni_min, descuentos.tipo_oferta, descuentos.tipo_venta, descuentos.tipo_precio ,ofertas.oferta_tipo_id 
		  FROM ofertas LEFT JOIN articulos on articulos.id = ofertas.articulo_id LEFT JOIN descuentos on descuentos.articulo_id =  articulos.id and 
		  descuentos.tipo_venta = "D" and	descuentos.fecha_hasta >=CURRENT_DATE() and	descuentos.tipo_oferta in ("RV","RR","OR","TD") where ofertas.activo=1 and ofertas.oferta_tipo_id = 7' )->fetchAll('assoc');
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
		
		$this->set('articulos',null);
			
		if ($this->request->session()->read('ofertaspatagonias')== null)
		{
			$ofertaspatagonias = $connection->execute('SELECT ofertas.*, articulos.precio_publico, 
			descuentos.dto_drogueria, descuentos.articulo_id, descuentos.plazo, descuentos.uni_min, descuentos.tipo_oferta, descuentos.tipo_venta, descuentos.tipo_precio ,ofertas.oferta_tipo_id ,ofertas.detalle, ofertas.busqueda
			FROM ofertas LEFT JOIN articulos on articulos.id = ofertas.articulo_id LEFT JOIN descuentos on descuentos.articulo_id =  articulos.id and 
			descuentos.tipo_venta = "D" and	descuentos.fecha_hasta >=CURRENT_DATE() and	descuentos.tipo_oferta in ("RV","RR","OR","TD") where ofertas.activo=1 and ofertas.oferta_tipo_id = 6' )->fetchAll('assoc');
			$this->request->session()->write('ofertaspatagonias',$ofertaspatagonias);
				
		}
		$this->loadModel('Novedades');
		$this->set('novedades', $this->paginate(
		$this->Novedades->find()
		->where(['activo' =>'1'])
		->andWhere(['interno' =>'1','importante'=>1])
		->order(['id' => 'DESC'])
		));
		
		$this->loadModel('Ofertas');
		$this->set('sursale',$this->Ofertas->find()->where(['activo' =>'1','oferta_tipo_id'=>9])->order(['id' => 'DESC'])->first()
		);
		
		$this->set(compact('ofertas'));
		
		$this->loadModel('Clientes');
		if (!$this->request->session()->read('Auth.User.actualizo_correo'))
		{
			return $this->redirect(['controller'=>'clientes','action' => 'edit_email']);
		}
    }

	public function home()
    {
		$this->viewBuilder()->layout('store');
        $this->paginate = [
						'contain' => ['Laboratorios','Categorias'],
						'limit' => 11,
						'order' => ['Articulos.descripcion_pag' => 'asc']];
		$this->loadModel('Articulos');
		$carritocon = $this->Carritos->find('all')	
					->where(['Carritos.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
					->order(['Carritos.id' => 'DESC']);
		$this->loadModel('ClientesCreditos');
		$clientecreditos = $this->ClientesCreditos->find('all')	
					->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]);
		$clientecredito = $clientecreditos->first();
		$this->set('creditodisponible',$clientecredito['credito_maximo']-$clientecredito['credito_consumo']);
	
		$this->loadModel('Ofertas');
		
		$connection = ConnectionManager::get('default');
		$ofertas = $connection->execute('SELECT ofertas.*, articulos.precio_publico, 
		  descuentos.dto_drogueria, descuentos.articulo_id, descuentos.plazo, descuentos.uni_min, descuentos.tipo_oferta, descuentos.tipo_venta, descuentos.tipo_precio 
		  FROM ofertas LEFT JOIN articulos on articulos.id = ofertas.articulo_id LEFT JOIN descuentos on descuentos.articulo_id =  articulos.id and 
		  descuentos.tipo_venta = "D" and	descuentos.fecha_hasta >=CURRENT_DATE() and	descuentos.tipo_oferta in ("RV","RR","OR","TD") where ofertas.activo=1')->fetchAll('assoc');
		$this->set('ofertas',$ofertas);
	
		$totalcarrito=0;
		$totalitems=0;
		$totalunidades=0;
		foreach ($carritocon as $carrito): 
			$totalitems+=1;
			if ($carrito['tipo_precio']=="P")
				$totalcarrito= $totalcarrito + $carrito['cantidad']*$carrito['precio_publico'];
			else
				$totalcarrito= $totalcarrito + $carrito['cantidad']*round(h($carrito['precio_publico'])*0.807, 3);
			
			$totalunidades= $totalunidades + $carrito['cantidad'] ;
		endforeach; 
		$this->set('totalitems',$totalitems);
		$this->set('totalcarrito',$totalcarrito);
		$this->set('totalunidades',$totalunidades);
		$this->set('carritos', $carritocon->toArray());
	    
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
 
	public function confirm()
    {
		$this->viewBuilder()->layout('store');
        $this->paginate = [	'contain' => ['Articulos'],'limit' => 500 ,
		  'order'=>(['Articulos.descripcion_sist' => 'ASC'])
		];
		$carritos = $this->Carritos->find('all')
					->where(['Carritos.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]);
		$totalcarrito=0;
		$totalitems=0;
		$totalunidades=0;	
		foreach ($carritos as $carrito): 
			$totalitems+=1;
			if ($carrito['tipo_precio']=="P")
				$totalcarrito= $totalcarrito + $carrito['cantidad']*$carrito['precio_publico'];
			else
				$totalcarrito= $totalcarrito + $carrito['cantidad']*round(h($carrito['precio_publico'])*0.807, 3);
			
			$totalunidades= $totalunidades + $carrito['cantidad'] ;
		endforeach; 	
		$this->loadModel('Clientes');
		$cliente = $this->Clientes->get($this->request->session()->read('Auth.User.cliente_id'), [
            'contain' => ['Provincias','Localidads']
        ]);
		$this->loadModel('Sucursals');
		$sucursales= $this->Sucursals->find('all')->where(['cliente_id'=>$this->request->session()->read('Auth.User.cliente_id')])
		->contain(['Localidads']);
		$this->set('sucursales',$sucursales);
		$this->set('cliente',$cliente);
		$this->set('totalitems',$totalitems);
		$this->set('totalcarrito',$totalcarrito);
		$this->set('totalunidades',$totalunidades);
		$this->set('carritos', $this->paginate($carritos));
		$this->set(compact('carritos'));
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
            } else {
                $this->Flash->error('No se guardo, intente de nuevo',['key' => 'changepass']);
            }
        }
        $clientes = $this->Carritos->Clientes->find('list', ['limit' => 200]);
        $sucursals = $this->Carritos->Sucursals->find('list', ['limit' => 200]);
        $this->set(compact('carrito', 'clientes', 'sucursals'));
        $this->set('_serialize', ['carrito']);
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
				$carrito = $this->Carritos->n                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                error('No se puede agregar este producto al carro de compras. ',['key' => 'changepass']);
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
				if ((int)$carrito['compra_multiplo']>1)
					if ((int)$carrito['cantidad'] %(int)$carrito['compra_multiplo'] != 0)
					{
						$this->Flash->error('No se agrego '.$carrito['descripcion']. ' al carro de compras, la cantidad tiene que ser multiplo de '.$carrito['compra_multiplo'] ,['key' => 'changepass']);	
						return $this->redirect($this->referer());
					}
				if ((int)$carrito['cantidad'] <(int)$carrito['compra_min'])
					{
						$this->Flash->error('No se agrego '.$carrito['descripcion']. ' al carro de compras, la cantidad tiene minima de venta es de '.$carrito['compra_min'] ,['key' => 'changepass']);	
						return $this->redirect($this->referer());
					}
				$carrito['creado'] = date('Y-m-d H:i:s');
				if ($carrito['tipo_precio']=='P' && ($carrito['tipo_oferta']=='TD' || $carrito['tipo_oferta']=='TL' || $carrito['tipo_oferta']=='OR' || $carrito['tipo_oferta']=='OD')) 
                        $carrito['tipo_fact']= 'TR';
					else
						if ($carrito['tipo_precio']=='F' && ($carrito['tipo_oferta']=='TD' || $carrito['tipo_oferta']=='TL' || $carrito['tipo_oferta']=='OR' || $carrito['tipo_oferta']=='OD')) 
							$carrito['tipo_fact']= 'TL';
						else 
							$carrito['tipo_fact']= 'N';
						
				if ($this->Carritos->save($carrito))
				{
					$this->Flash->success('Se agrego al carro correctamente.',['key' => 'changepass']);
					//$this->redirect($this->referer());
				}
				else
				{
					$this->Flash->error('No se pudo agregar al carro de compras. Intente de nuevo',['key' => 'changepass']);
				}
			}
			else
			{
				
				
				// Modifico la cantidad al carrito
				foreach ($carritocon2 as $carro):
					$id=$carro['id'];
					$cant = $carrito['cantidad'];
				endforeach; 
				$carrito = $this->Carritos->get($id, ['contain' => []]);
				$carrito['cantidad']=$cant;	
				if ((int)$carrito['compra_multiplo']>1)
					if ((int)$carrito['cantidad'] %(int)$carrito['compra_multiplo'] != 0)
					{
						$this->Flash->error('No se agrego '.$carrito['descripcion']. ' al carro de compras, la cantidad tiene que ser multiplo de '.$carrito['compra_multiplo'] ,['key' => 'changepass']);	
						return $this->redirect($this->referer());
					}
				
				
				if ((int)$carrito['cantidad'] <(int)$carrito['compra_min'])
					{
						$this->Flash->error('No se agrego '.$carrito['descripcion']. ' al carro de compras, la cantidad tiene minima de venta es de '.$carrito['compra_min'] ,['key' => 'changepass']);	
						return $this->redirect($this->referer());
					}
					
				if ($this->Carritos->save($carrito)) {
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
								->where(['cl                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                rritos','action' => 'importresult']);
			//$this->redirect($this->referer());
        } else {
            $this->Flash->error('El listado no pudo ser vaciado. Intente de nuevo.',['key' => 'changepass']);
			return $this->redirect(['controller'=>'carritos','action' => 'importresult']);
			//$this->redirect($this->referer());
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
			$codigobarras = $this->request->session()->read('codigobarras');
			$categoriaid = $this->request->session()->read('categoriaid');
		    $laboratorioid = $this->request->session()->read('laboratorioid');
			$termsearch = $this->request->session()->read('termsearch');
			$ofertas = $this->request->session()->read('ofertas');
		}
		if ($this->request->session()->read('Categorias')== null)
		{
		$this->loadModel('Categorias');
		
		$categorias = $this->Categorias->find('list',['keyField' => 'id','valueField'=>'nombre']);
		

		$this->request->session()->write('Categorias',$categorias->toArray());
		
			
		}
		else{
			
			
			$categorias = $this->request->session()->read('Categorias');
		}	
		if ($this->request->session()->read('Laboratorios')== null)
		{
		
		$this->loadModel('Laboratorios');
		
		$laboratorios = $this->Laboratorios->find('list',['keyField' => 'id','valueField'=>'nombre'])->order(['nombre' => 'ASC']);
		$this->request->session()->write('Laboratorios',$laboratorios ->toArray());
			
		}
		else{
			
			$laboratorios =$this->request->session()->read('Laboratorios');
			
		}	
		$this->set('categorias',$categorias );
		$this->set('laboratorios',$laboratorios);
		if ($codigobarras && $termsearch!="")
			{
				$this->CargarCarritoCB($termsearch);
			}	
		
		$this->viewBuilder()->layout('store');
		//,'Carritos'
        $this->paginate = [		
		'contain' => ['Descuentos'],
		'limit' => 20,
		'offset' => 0, 
        'order' => ['Articulos.descripcion_pag' => 'asc']];
		$this->loadModel('Articulos');
		$carritocon = $this->Carritos->find('all')
					->where(['Carritos.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
					->order(['Carritos.id' => 'DESC']);
		$this->set('carritos', $carritocon->toArray());
        $this->set('_serialize', ['carrit                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                