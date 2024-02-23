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
				$this->request->session()->write('compra_minima',$clientecredito['compra_minima']);		
			else
				$this->request->session()->write('compra_minima',500);		
			
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
		else
		{
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
		$this->set('novedades', $this->paginate($this->Novedades->find()->where(['activo' =>'1'])->andWhere(['interno' =>'1','importante'=>'1'])
		->order(['id' => 'DESC'])
		));
		$this->loadModel('Ofertas');
		$this->set('sursale',$this->Ofertas->find()->where(['activo' =>'1','oferta_tipo_id'=>9])->order(['id' => 'DESC'])->first()
		);
		
		
		$this->set(compact('ofertas'));

		
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
            } else 
                $this->Flash->error('No se guardo, intente de nuevo',['key' => 'changepass']);
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
					if ($categoria!=5)
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
							
				if ($carrito['tipo_precio']=='P' && ($carrito['tipo_oferta']=='TD' || $carrito['tipo_oferta']=='TL' || $carrito['tipo_oferta']=='OR' || $carrito['tipo_oferta']=='OD')) 
                        $carrito['tipo_fact']= 'TR';
					else
						if ($carrito['tipo_precio']=='F' && ($carrito['tipo_oferta']=='TD' || $carrito['tipo_oferta']=='TL' || $carrito['tipo_oferta']=='OR' || $carrito['tipo_oferta']=='OD')) 
							$carrito['tipo_fact']= 'TL';
						else 
							$carrito['tipo_fact']= 'N';
						
				if ($this->Carritos->save($carrito))
					$this->Flash->success('Se agrego al carro correctamente.',['key' => 'changepass']);
				else
					$this->Flash->error('No se pudo agregar al carro de compras. Intente de nuevo',['key' => 'changepass']);
				
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
					$cant = $this->request->data['cantidad']+$carro['cantidad'];
				endforeach; 
				$carrito = $this->Carritos->get($id, ['contain' => []]);
				$carrito['cantidad']=$cant;	
				if ($this->Carritos->save($carrito)) {
					$this->Flash->success('Se agrego al carro correctamente.',['key' => 'changepass']);
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
				$carrito['tipo_venta'] = $this->request->data['tipo_venta']; 
				$carrito['tipo_oferta_elegida'] = $this->request->data['tipo_precio']; 
				
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
				if ($this->CarritosTemps->save($carrito)) {
					$this->Flash->success('Se modifico la cantidad importada correctamente.',['key' => 'changepass']);
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
		$carrito['cliente_id']=$this->request->session()->read('Auth.User.cliente_id');	
			
		$carritocon2 = $this->CarritosTemps->find()
			->where(['cliente_id' => $carrito['cliente_id']])
			->where(['articulo_id' =>  $carrito['articulo_id']]);
		if($carritocon2->count()==0)
			{
				//$carrito = $this->CarritosTemps->newEntity();
				
				$carrito['creado']=date('Y-m-d H:i:s');
		
				
				if ($carrito['tipo_precio']=='P' && ($carrito['tipo_oferta']=='TD' || $carrito['tipo_oferta']=='TL' || $carrito['tipo_oferta']=='OR' || $carrito['tipo_oferta']=='OD')) 
                        $carrito['tipo_fact']= 'TR';
					else
						if ($carrito['tipo_precio']=='F' && ($carrito['tipo_oferta']=='TD' || $carrito['tipo_oferta']=='TL' || $carrito['tipo_oferta']=='OR' || $carrito['tipo_oferta']=='OD')) 
						
							$carrito['tipo_fact']= 'TL';
						else 
							$carrito['tipo_fact']= 'N';
				
				
				if ($this->CarritosTemps->save($carrito))
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
				foreach ($carritocon2 as $carro):
					$id=$carro['id'];
					$cant = $carrito['cantidad'];
				endforeach; 
				$carrito = $this->CarritosTemps->get($id, ['contain' => []]);
				$carrito['cantidad']=$cant;	
				if ($this->CarritosTemps->save($carrito)) {
					$this->Flash->success('Se modifico la cantidad importada correctamente.',['key' => 'changepass']);
				}
				else
				{
					$this->Flash->error('No se pudo modificar la cantidad importada. Intente de nuevo',['key' => 'changepass']);
				}
				//$this->redirect($this->referer());
			}
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
            $carro['cantidad'] = $this->request->data['cantidad'];
				if ((int)$carro['compra_multiplo']>1)
					if ((int)$carro['cantidad'] %(int)$carro['compra_multiplo'] != 0)
					{
						$this->Flash->error('No se agrego '.$carro['descripcion']. ' al carro de compras, la cantidad tiene que ser multiplo de '.$carro['compra_multiplo'] ,['key' => 'changepass']);	
						return $this->redirect($this->referer());
					}
				
				
				if ((int)$carro['cantidad'] <(int)$carro['compra_min'])
					{
						$this->Flash->error('No se agrego '.$carro['descripcion']. ' al carro de compras, la cantidad tiene minima de venta es de '.$carro['compra_min'] ,['key' => 'changepass']);	
						return $this->redirect($this->referer());
					}
					
            if ($this->Carritos->save($carro)) {
                $this->Flash->success('Se agrego correctamente.',['key' => 'changepass']);
                $this->redirect($this->referer());
            } else {
                $this->Flash->error('No se pudo agregar, Intente nuevamente.',['key' => 'changepass']);
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
        $carrito = $this->Carritos->get($id);
        if ($this->Carritos->delete($carrito)) {
            $this->Flash->success('Se elimino correctamente del carro.',['key' => 'changepass']);
        } else {
            $this->Flash->error('No se pudo eliminar, intente nuevamente',['key' => 'changepass']);
        }
       $this->redirect($this->referer());
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
	
	public function vaciar()
    {
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
        $this->paginate = [		
		'contain' => ['Descuentos'],
		'limit' => 11,
		'offset' => 0, 
        'order' => ['Articulos.descripcion_pag' => 'asc']];
		$this->loadModel('Articulos');
		
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
			                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                tidad'] = 1;
				
				
				if ((int)$carrito['cantidad'] <(int)$temp['compra_min'])
					{
						$carrito['cantidad']=$temp['compra_min'];
					}
					
				if ((int)$temp['compra_multiplo']>1)
					if ((int)$carrito['cantidad'] %(int)$temp['compra_multiplo'] != 0)
					{
						$carrito['cantidad']=(int)$carrito['cantidad']-((int)$carrito['cantidad']%(int)$temp['compra_multiplo']);
					}
				
				
				
				
				$carrito['articulo_id'] = $temp['id'];
				$carrito['precio_publico'] = $temp['precio_publico']; 	
				$carrito['descripcion'] = $temp['descripcion_pag']; 	
				$this->set('temp',$temp);
				if (isset($temp['descuentos'][0]))
				{
				
					if ($temp['descuentos'][0]['tipo_venta']=='D')
					{
					$carrito['descuento'] = $temp['descuentos'][0]['dto_drogueria']; 	
					$carrito['plazoley_dcto'] = $temp['descuentos'][0]['plazo']; 	
					$carrito['unidad_minima'] = $temp['descuentos'][0]['uni_min']; 	
					$carrito['tipo_oferta'] = $temp['descuentos'][0]['tipo_oferta']; 	
					$carrito['tipo_oferta_elegida'] = $temp['descuentos'][0]['tipo_venta']; 
					$carrito['tipo_precio'] = $temp['descuentos'][0]['tipo_precio']; 
					
				
					}
					else
					{
					$carrito['descuento'] = 0; 	
					$carrito['plazoley_dcto'] = null; 	
					$carrito['unidad_minima'] = null; 	
					$carrito['tipo_oferta'] = null; 	
					$carrito['tipo_oferta_elegida'] = null; 
					$carrito['tipo_precio'] = null; 
					}
				}
				else
				{
										
					$carrito['descuento'] = 0; 	
					$carrito['plazoley_dcto'] = null; 	
					$carrito['unidad_minima'] = null; 	
					$carrito['tipo_oferta'] = null; 	
					$carrito['tipo_oferta_elegida'] = null; 
					$carrito['tipo_precio'] = null; 
									
				}
				if ($carrito['tipo_precio']=='P' && ($carrito['tipo_oferta']=='TD' || $carrito['tipo_oferta']=='TL' || $carrito['tipo_oferta']=='OR' || $carrito['tipo_oferta']=='OD')) 
                        $carrito['tipo_fact']= 'TR';
					else
						if ($carrito['tipo_precio']=='F' && ($carrito['tipo_oferta']=='TD' || $carrito['tipo_oferta']=='TL' || $carrito['tipo_oferta']=='OR' || $carrito['tipo_oferta']=='OD')) 
						
							$carrito['tipo_fact']= 'TL';
						else 
							$carrito['tipo_fact']= 'N';
				
				$insertar = $this->Carritos->find('all')
							->where(['articulo_id'=>$carrito['articulo_id']])
							->andWhere(['cliente_id'=>$carrito['cliente_id']]);
				
				
				if (isset($insertar))
				{	
					$this->set('insertarsi',"ENTRO");
					$row= $insertar->first();
					if ($row != null)
					{
							$this->set('insertars2',"ENTRO2");
						$carrito['cantidad'] = 	$carrito['cantidad'] + $row['cantidad'];
						$carrito['id']=  $row['id'];
					}
					
				}
				
				
				if ($this->Carritos->save($carrito))
				{
					
				}
				}
				}
		
	}
	
	
	public function fraganciaselectiva()
    {
		
		$this->request->session()->write('marcaid',0);
		$this->request->session()->write('termsearch2',"");
		$this->request->session()->write('marcaid',0);		
		$this->loadModel('Marcas');
		$this->loadModel('Generos');
		
		$marcas = $this->Marcas->find('list', ['keyField' => 'id','valueField' => 'nombre'])->order(['nombre' => 'ASC']);
        $generos = $this->Generos->find('list', ['keyField' => 'id','valueField' => 'nombre']);
		$marcas->toArray();
		$generos->toArray();
		$this->set(compact('marcas','generos'));
		
		$this->viewBuilder()->layout('store');
        $this->paginate = [		
		'limit' => 12,
		'order' => ['Fragancias.nombre' => 'asc']];
	
		$carritocon = $this->Carritos->find('all')
					->where(['Carritos.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
					->order(['Carritos.id' => 'DESC']);
		$this->set('carritos', $carritocon->toArray());
        $this->set('_serialize', ['carritos']);		
		
		$this->loadModel('ClientesCreditos');
		$clientecreditos = $this->ClientesCreditos->find('all')	
					->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]);
		$clientecredito                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                y_key_exists($temp['codigo_barras3'], $tablaped)) 
				{
					$carrito['cantidad'] = $tablaped[$temp['codigo_barras3']][0];
				}	
				
				
				if ((int)$carrito['cantidad'] <(int)$temp['compra_min'])
					{
						$carrito['cantidad']=$temp['compra_min'];
					}
					
				if ((int)$temp['compra_multiplo']>1)
					if ((int)$carrito['cantidad'] %(int)$temp['compra_multiplo'] != 0)
					{
						$carrito['cantidad']=(int)$carrito['cantidad']-((int)$carrito['cantidad']%(int)$temp['compra_multiplo']);
					}
				
				
				
				
				$carrito['articulo_id'] = $temp['id'];
				$carrito['precio_publico'] = $temp['precio_publico']; 	
				$carrito['descripcion'] = $temp['descripcion_pag']; 	

				if ($temp['descuentos'] !=null)
				{
					if ($temp['descuentos'][0]['tipo_venta']=='D')
					{
					$carrito['descuento'] = $temp['descuentos'][0]['dto_drogueria']; 	
					$carrito['plazoley_dcto'] = $temp['descuentos'][0]['plazo']; 	
					$carrito['unidad_minima'] = $temp['descuentos'][0]['uni_min']; 	
					$carrito['tipo_oferta'] = $temp['descuentos'][0]['tipo_oferta']; 	
					$carrito['tipo_oferta_elegida'] = $temp['descuentos'][0]['tipo_venta']; 
					$carrito['tipo_precio'] = $temp['descuentos'][0]['tipo_precio']; 
					
				
					}
					else
					{
					$carrito['descuento'] = 0; 	
					$carrito['plazoley_dcto'] = null; 	
					$carrito['unidad_minima'] = null; 	
					$carrito['tipo_oferta'] = null; 	
					$carrito['tipo_oferta_elegida'] = null; 
					$carrito['tipo_precio'] = null; 
					}
				}
				else
				{
					
					$carrito['descuento'] = 0; 	
					$carrito['plazoley_dcto'] = null; 	
					$carrito['unidad_minima'] = null; 	
					$carrito['tipo_oferta'] = null; 	
					$carrito['tipo_oferta_elegida'] = null; 
					$carrito['tipo_precio'] = null; 
									
				}
				if ($carrito['tipo_precio']=='P' && ($carrito['tipo_oferta']=='TD' || $carrito['tipo_oferta']=='TL' || $carrito['tipo_oferta']=='OR' || $carrito['tipo_oferta']=='OD')) 
                        $carrito['tipo_fact']= 'TR';
					else
						if ($carrito['tipo_precio']=='F' && ($carrito['tipo_oferta']=='TD' || $carrito['tipo_oferta']=='TL' || $carrito['tipo_oferta']=='OR' || $carrito['tipo_oferta']=='OD')) 
						
							$carrito['tipo_fact']= 'TL';
						else 
							$carrito['tipo_fact']= 'N';
				
				$insertar = $this->CarritosTemps->find('all')
							->where(['articulo_id'=>$temp['id']])
							->andWhere(['cliente_id'=>$carrito['cliente_id']]);
				
				
				
				if ($insertar->first() ==null)
				if ($this->CarritosTemps->save($carrito))
				{
					
					//$this->redirect($this->referer());
				}
				else
				{
					
					//$this->redirect($this->referer());
				}
				
			
	}

	public function importresult()
	{
		$this->viewBuilder()->layout('store');
		$this->loadModel('Articulos');
		$this->paginate = ['contain' => ['Descuentos','CarritosTemps'],
							'order' => ['Articulos.descripcion_pag' => 'asc'],
							
							'limit' => 90];
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
			
			
				if ($tob == 'T') {$campotob = 'troquel';} else {$campotob = 'codigo_barras';}
				$tablaped =array();
				$listaarray=array();
				foreach (file( $file['tmp_name']) as $line) {
					$codbar = substr($line,$codbardde,$codbarlong);
					$cantidad = substr($line,$cantidaddde,$cantidadlong);
					  if ($codbar != '' && $codbar != '             ') {
						 $codbar = trim($codbar,' ');
						 array_push($listaarray,$codbar);
						 $tablaped[$codbar] = [$cantidad,$line];
					  }
				}
				
				$th