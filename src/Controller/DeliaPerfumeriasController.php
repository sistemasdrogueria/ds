<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\I18n\Time;
use Cake\Database\Connection;
use Cake\Datasource\ConnectionManager;
/**
 * Novedades Controller
 *
 * @property \App\Model\Table\NovedadesTable $Novedades
 */
class DeliaPerfumeriasController extends AppController
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
        
	
		 if (in_array($this->request->action, ['index','delete_admin','index_admin','add_admin','edit_admin','view_admin','fragancia','resultfragancia','dermo','makeup','solares','itemupdate','resultdermo','resultsolares','resultmakeup','estetica','resultestetica'])) {
       
            if($this->request->session()->read('Auth.User.role')=='admin') 
            {				
                return true;			
            }			
            else {	
                if($this->request->session()->read('Auth.User.role')=='client') 
                {	
					
						$tiene= $this->tienepermiso('deliaperfumerias',$this->request->action);
						if (!$tiene)
							$this->Flash->error(__('No tiene permisos para ingresar'),['key' => 'changepass']);
						return $tiene;			
                }	
                else {
					if($this->request->session()->read('Auth.User.role')=='provider') 
					{
						$this->Flash->error(__('No tiene permisos para ingresar'),['key' => 'changepass']);
						$this->redirect(['controller' => 'carritos', 'action' => 'index']);	
						return false;						
					}
					else {
						$this->Flash->error(__('No tiene permisos para ingresar'),['key' => 'changepass']);
						
						$this->redirect(['controller' => 'Pages', 'action' => 'home']);
						return false;	
					}
                    
                }	
            }		
            }		
			else 
			{
				if (in_array($this->request->action, ['view']))
				{
					return true;
				}
				else
				{
					$this->Flash->error(__('No tiene permisos para ingresar'));		
					$this->redirect(['controller' => 'Pages', 'action' => 'home']);  		
					return false;	
				}
			}
		return parent::isAuthorized($user);
    }

  /**
     * Index method
     *
     * @return void
     */
	
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
		//$laboratorios = $this->Laboratorios->find('list',['keyField' => 'id','valueField'=>'nombre'])->order(['nombre' => 'ASC']);
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
	
	 
	public function index()
    {
		
		$this->viewBuilder()->layout('store_delia');
		 $this->paginate = [
			'limit' => 500
			
		];
		$fechahasta2 = Time::now();
				$fechahasta2-> modify('+1 days');
				$fechahasta2 = $fechahasta2->i18nFormat('yyyy-MM-dd');
			$fechahasta = Time::now();
		$this->loadModel('Incorporations');
		$incorporationsA = $this->Incorporations->find('all');
		$incorporationsA->where(['habilitada'=>1,'incorporations_tipos_id <'=>6])
				->andWhere(["Incorporations.fecha_hasta > '".$fechahasta->i18nFormat('yyyy-MM-dd')."'"])
				 ->order(['id' => 'DESC','incorporations_tipos_id'=>'ASC']);
		$incorporations = $this->paginate($incorporationsA);
		
		$this->loadModel('IncorporationsTipos');
		$IncorporationsTipos =  $this->IncorporationsTipos->find('list', ['keyField' => 'id','valueField' => 'nombre']);
		
		$this->loadModel('Marcas');
		$marcas2 = $this->Marcas->find('all')->where(['orden>0','marcas_tipos_id'=>1])->order(['nombre'=>'ASC']);
		$marcas2->toArray();
		
		$this->set(compact('marcas2'));
		
		$this->set('incorporationstipos',$IncorporationsTipos ->toArray());
		
        $this->set('incorporations', $incorporations);
		$this->set('_serialize', ['incorporations']);
		

    }

	
	
	public function fragancia($tipo = null)
    {
		
		$this->request->session()->write('marcaid',0);
		$this->request->session()->write('termsearch2',"");
		$this->request->session()->write('marcaid',0);		
		$this->loadModel('Marcas');
		$this->loadModel('Generos');
		
		if ($tipo=="select")
		$marcas = $this->Marcas->find('list', ['keyField' => 'id','valueField' => 'nombre'])->where(['marcas_tipos_id'=>1])->order(['nombre' => 'ASC']);
		if ($tipo=="semiselect")
		$marcas = $this->Marcas->find('list', ['keyField' => 'id','valueField' => 'nombre'])->where(['marcas_tipos_id'=>18])->order(['nombre' => 'ASC']);
		if (is_null($tipo))
			$marcas = null;
		$generos = $this->Generos->find('list', ['keyField' => 'id','valueField' => 'nombre']);
		if (!is_null($tipo))
		$marcas->toArray();
		$generos->toArray();
		$this->set(compact('generos'));
		$this->set('marcas',$marcas);
		$this->viewBuilder()->layout('store_delia');
        $this->paginate = ['limit' => 10];
		
		$this->clientecredito();
		$this->sumacarrito();
			
		$this->loadModel('Incorporations');
		$incorporationsA = $this->Incorporations->find('all');
		$incorporationsA->where(['habilitada'=>1,'incorporations_tipos_id '=>1])->limit([10])->order(['id' => 'DESC']);
		$incorporations = $this->paginate($incorporationsA);
        $this->set('incorporations', $incorporations);
		if ($tipo=="select")
		$marcas2 = $this->Marcas->find('all')->where(['marcas_tipos_id'=>1])->order(['nombre'=>'ASC']);
		if ($tipo=="semiselect")	
		$marcas2 = $this->Marcas->find('all')->where(['marcas_tipos_id'=>18])->order(['nombre'=>'ASC']);
		if (is_null($tipo))
		$marcas2 = null;

		if (!is_null($tipo))
		$marcas2->toArray();
			
		$this->set('marcas2',$marcas2);
		$this->set('pass',$tipo);
	  //$this->Flash->warning('Nos encontramos actualizado la seccion, intente mas tarde',['key' => 'changepass']);     
       //$this->redirect($this->referer());
	}


	public function estetica()
    {
		
		//$this->request->session()->write('marcaid',0);
		$this->request->session()->write('termsearch2',"");
		$this->request->session()->write('grupoid',0);		
		$this->request->session()->write('subgrupoid',0);		
		//$this->loadModel('Marcas');
		$this->loadModel('Grupos');
		$this->loadModel('Subgrupos');
		
		//$marcas = $this->Marcas->find('list', ['keyField' => 'id','valueField' => 'nombre'])->where(['marcas_tipos_id in (6)'])->order(['nombre' => 'ASC']);
		$grupos = $this->Grupos->find('list', ['keyField' => 'id','valueField' => 'nombre'])->where(['grupos_tipos_id IN (9,10)'])->order(['nombre' => 'ASC']);
		$subgrupos = $this->Subgrupos->find('list', ['keyField' => 'id','valueField' => 'nombre'])->where(['grupo_id in (1,2,3,4)']);
		//$marcas->toArray();
		$grupos->toArray();
		$subgrupos->toArray();
		$this->set(compact('grupos','subgrupos'));
	
		$this->viewBuilder()->layout('store_delia');
        $this->paginate = ['limit' => 5];
		
		$this->clientecredito();
		$this->sumacarrito();
			
		$this->loadModel('Incorporations');
		$incorporationsA = $this->Incorporations->find('all');
		$incorporationsA->where(['habilitada'=>1,'incorporations_tipos_id '=>14])->limit([5])->order(['id' => 'DESC']);
		$incorporations = $this->paginate($incorporationsA);
        $this->set('incorporations', $incorporations);

		$grupos2 = $this->Grupos->find('all')->where(['grupos_tipos_id in (9,10)'])->order(['nombre'=>'ASC']);
		$grupos2->toArray();
		
		$this->set(compact('grupos2'));
	  //$this->Flash->warning('Nos encontramos actualizado la seccion, intente mas tarde',['key' => 'changepass']);     
       //$this->redirect($this->referer());
	}


	public function dermo()
    {
		
		$this->request->session()->write('marcaid',0);
		$this->request->session()->write('termsearch2',"");
		$this->request->session()->write('grupoid',0);		
		$this->request->session()->write('subgrupoid',0);		
		$this->loadModel('Marcas');
		$this->loadModel('Grupos');
		$this->loadModel('Subgrupos');
		
		$marcas = $this->Marcas->find('list', ['keyField' => 'id','valueField' => 'nombre'])->where(['marcas_tipos_id in (2,15,16)'])->order(['nombre' => 'ASC']);
		$grupos = $this->Grupos->find('list', ['keyField' => 'id','valueField' => 'nombre'])->where(['grupos_tipos_id'=>2]);
		$subgrupos = $this->Subgrupos->find('list', ['keyField' => 'id','valueField' => 'nombre'])->where(['grupo_id in (1,2,3,4)']);
		$marcas->toArray();
		$grupos->toArray();
		$subgrupos->toArray();
		$this->set(compact('marcas','grupos','subgrupos'));
	
		$this->viewBuilder()->layout('store_delia');
        $this->paginate = ['limit' => 5];
		
		$this->clientecredito();
		$this->sumacarrito();
			
		$this->loadModel('Incorporations');
		$incorporationsA = $this->Incorporations->find('all');
		$incorporationsA->where(['habilitada'=>1,'incorporations_tipos_id '=>3])->limit([5])->order(['id' => 'DESC']);
		$incorporations = $this->paginate($incorporationsA);
        $this->set('incorporations', $incorporations);

		$marcas2 = $this->Marcas->find('all')->where(['marcas_tipos_id in (2,15,16)'])->order(['nombre'=>'ASC']);
		$marcas2->toArray();
		
		$this->set(compact('marcas2'));
	  //$this->Flash->warning('Nos encontramos actualizado la seccion, intente mas tarde',['key' => 'changepass']);     
       //$this->redirect($this->referer());
	}

	public function makeup()
    {
		
		$this->request->session()->write('marcaid',0);
		$this->request->session()->write('termsearch2',"");
		$this->request->session()->write('grupoid',0);		
			
		$this->loadModel('Marcas');
		$this->loadModel('Grupos');
	
		
		$marcas = $this->Marcas->find('list', ['keyField' => 'id','valueField' => 'nombre'])->where(['marcas_tipos_id in (4,16)'])->order(['nombre' => 'ASC']);
		$grupos = $this->Grupos->find('list', ['keyField' => 'id','valueField' => 'nombre'])->where(['grupos_tipos_id'=>4]);
		//$subgrupos = $this->Subgrupos->find('list', ['keyField' => 'id','valueField' => 'nombre'])->where(['grupo_id in (1,2,3,4)']);
		$marcas->toArray();
		$grupos->toArray();
		//$subgrupos->toArray();
		$this->set(compact('marcas','grupos'));
	
		$this->viewBuilder()->layout('store_delia');
        $this->paginate = ['limit' => 50];
		
		$this->clientecredito();
		$this->sumacarrito();
			
		$this->loadModel('Incorporations');
		$incorporationsA = $this->Incorporations->find('all');
		$incorporationsA->where(['habilitada'=>1,'incorporations_tipos_id'=>4])->limit([5])->order(['id' => 'DESC']);
		$incorporations = $this->paginate($incorporationsA);
        $this->set('incorporations', $incorporations);

		$marcas2 = $this->Marcas->find('all')->where(['marcas_tipos_id in (4,16)'])->order(['nombre'=>'ASC']);
		$marcas2->toArray();
		
		$this->set(compact('marcas2'));
	  //$this->Flash->warning('Nos encontramos actualizado la seccion, intente mas tarde',['key' => 'changepass']);     
       //$this->redirect($this->referer());
	}
	
	public function solares()
    {
		
		$this->request->session()->write('marcaid',0);
		$this->request->session()->write('termsearch2',"");
		$this->request->session()->write('grupoid',0);		
			
		$this->loadModel('Marcas');
		$this->loadModel('Grupos');
	
		
		$marcas = $this->Marcas->find('list', ['keyField' => 'id','valueField' => 'nombre'])->where(['marcas_tipos_id in (3,15)'])->order(['nombre' => 'ASC']);
		$grupos = $this->Grupos->find('list', ['keyField' => 'id','valueField' => 'nombre'])->where(['grupos_tipos_id'=>3]);
		//$subgrupos = $this->Subgrupos->find('list', ['keyField' => 'id','valueField' => 'nombre'])->where(['grupo_id in (1,2,3,4)']);
		$marcas->toArray();
		$grupos->toArray();
		//$subgrupos->toArray();
		$this->set(compact('marcas','grupos'));
	
		$this->viewBuilder()->layout('store_delia');
        $this->paginate = ['limit' => 50];
		
		$this->clientecredito();
		$this->sumacarrito();
			
		$this->loadModel('Incorporations');
		$incorporationsA = $this->Incorporations->find('all');
		$incorporationsA->where(['habilitada'=>1,'incorporations_tipos_id'=>5])->limit([5])->order(['id' => 'DESC']);
		$incorporations = $this->paginate($incorporationsA);
        $this->set('incorporations', $incorporations);

		$marcas2 = $this->Marcas->find('all')->where(['marcas_tipos_id in (3,15)'])->order(['nombre'=>'ASC']);
		$marcas2->toArray();
		
		$this->set(compact('marcas2'));
	  //$this->Flash->warning('Nos encontramos actualizado la seccion, intente mas tarde',['key' => 'changepass']);     
       //$this->redirect($this->referer());
	}

	
	public function resultmakeup($marcaid =null)
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
			}else{

				$this->request->data['terminobuscar']=0; 
			}	
	 
			if ($this->request->data['marca_id']!= null)
			{
				$marcaid = $this->request->data['marca_id'];
				
			} else{
				$this->request->data['marca_id']=0;

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


		$this->loadModel('Marcas');
		$this->loadModel('Grupos');
		
		$marcas = $this->Marcas->find('list', ['keyField' => 'id','valueField' => 'nombre'])->where(['marcas_tipos_id in(4,16)'])->order(['nombre' => 'ASC']);
        $grupos = $this->Grupos->find('list', ['keyField' => 'id','valueField' => 'nombre'])->where(['grupos_tipos_id'=>4]);
		
		$marcas->toArray();
		$grupos->toArray();
		$this->set(compact('marcas','grupos'));
		
		$this->viewBuilder()->layout('store_delia');
        
		
		$this->clientecredito();
		$this->sumacarrito();		

		$this->loadModel('Articulos');

		$fecha = Time::now();
		$makeup = $this->Articulos->find()
										  ->contain(['Descuentos' => [
												'queryBuilder' => function ($q) {
												return $q->where(['tipo_oferta <> "FP"', 'tipo_oferta <> "VC"']); // Full conditions for filtering
												}],  
											'Carritos' => [
												'queryBuilder' => function ($q) {
												return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); // Full conditions for filtering
												}]
				  ])
				  ->join(
					[
						'table' => 'descuentos',
						'alias' => 'd',
						'type' => 'LEFT',
						'conditions' => [
							'd.articulo_id = Articulos.id',
							'd.tipo_venta = "D"',
							'd.fecha_hasta >=' => $fecha->i18nFormat('yyyy-MM-dd'),
							'd.tipo_oferta in ("RV","RR","OR","TD","RL","SS","FR")'
						]
						]);

						
		if ($marcaid!=0 && $marcaid!=100)
		{
			 $makeup->where(['subcategoria_id'=>4,'marca_id'=>$marcaid]);			
		}
	
		if ($termsearch2 !="")
		{
			$makeup->where(['subcategoria_id'=>4,'descripcion_pag LIKE'=>$termsearch2]);
		}
		$makeup->andWhere(['Articulos.stock<>"D"','Articulos.eliminado' => 0])->group(['Articulos.id']);
						$limit = 100;
						
			
						$this->paginate = [
							'contain' => ['Carritos'],
							'limit' => $limit,
							'offset' => 0,
							'order' => ['Articulos.stock_fisico' => 'desc']
						];
		$this->set('makeup',$this->paginate($makeup) );
		

	}

	public function resultsolares($marcaid =null)
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
			}else{

				$this->request->data['terminobuscar']=0; 
			}	
	 
			if ($this->request->data['marca_id']!= null)
			{
				$marcaid = $this->request->data['marca_id'];
				
			} else{
				$this->request->data['marca_id']=0;

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


		$this->loadModel('Marcas');
		$this->loadModel('Grupos');
		
		$marcas = $this->Marcas->find('list', ['keyField' => 'id','valueField' => 'nombre'])->where(['marcas_tipos_id in(3,15,16)'])->order(['nombre' => 'ASC']);
        $grupos = $this->Grupos->find('list', ['keyField' => 'id','valueField' => 'nombre'])->where(['grupos_tipos_id'=>3]);
		
		$marcas->toArray();
		$grupos->toArray();
		$this->set(compact('marcas','grupos'));
		
		$this->viewBuilder()->layout('store_delia');
        
		
		$this->clientecredito();
		$this->sumacarrito();		

		$this->loadModel('Articulos');

		$fecha = Time::now();
		$solares = $this->Articulos->find()
										  ->contain(['Descuentos' => [
												'queryBuilder' => function ($q) {
												return $q->where(['tipo_oferta <> "FP"', 'tipo_oferta <> "VC"']); // Full conditions for filtering
												}],  
											'Carritos' => [
												'queryBuilder' => function ($q) {
												return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); // Full conditions for filtering
												}]
				  ])
				  ->join(
					[
						'table' => 'descuentos',
						'alias' => 'd',
						'type' => 'LEFT',
						'conditions' => [
							'd.articulo_id = Articulos.id',
							'd.tipo_venta = "D"',
							'd.fecha_hasta >=' => $fecha->i18nFormat('yyyy-MM-dd'),
							'd.tipo_oferta in ("RV","RR","OR","TD","RL","SS","FR")'
						]
						]);

						
		if ($marcaid!=0 && $marcaid!=100)
		{
			 $solares->where(['subcategoria_id'=>3,'marca_id'=>$marcaid]);			
		}
	
		if ($termsearch2 !="")
		{
			$solares->where(['subcategoria_id'=>3,'descripcion_pag LIKE'=>$termsearch2]);
		}
		$solares->andWhere(['Articulos.stock<>"D"','Articulos.eliminado' => 0])->group(['Articulos.id']);
						$limit = 100;
						
			
						$this->paginate = [
							'contain' => ['Carritos'],
							'limit' => $limit,
							'offset' => 0,
							'order' => ['Articulos.stock_fisico' => 'desc']
						];
		$this->set('solares',$this->paginate($solares) );
		

	}

	public function resultdermo($marcaid =null)
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
			}else{

				$this->request->data['terminobuscar']=0; 
			}	
	 
			if ($this->request->data['marca_id']!= null)
			{
				$marcaid = $this->request->data['marca_id'];
				
			} else{
				$this->request->data['marca_id']=0;

			}	
			
	 


			$this->request->session()->write('termsearch2',$termsearch2);
		}
		else
		{
			$termsearch2 = $this->request->session()->read('termsearch2');
		}
		if (is_null($marcaid))
		{
			if (!is_null($this->request->session()->read('marcaid'))) 
			$marcaid = $this->request->session()->read('marcaid');
			else
			$marcaid=0;
		}
		else
			$this->request->session()->write('marcaid',$marcaid);


		$this->loadModel('Marcas');
		$this->loadModel('Grupos');
		
		$marcas = $this->Marcas->find('list', ['keyField' => 'id','valueField' => 'nombre'])->where(['marcas_tipos_id in (2,15,16)'])->order(['nombre' => 'ASC']);
        $grupos = $this->Grupos->find('list', ['keyField' => 'id','valueField' => 'nombre'])->where(['grupos_tipos_id'=>3]);
		
		$marcas->toArray();
		$grupos->toArray();
		$this->set(compact('marcas','grupos'));
		
		$this->viewBuilder()->layout('store_delia');
        
		
		$this->clientecredito();
		$this->sumacarrito();		

		$this->loadModel('Articulos');

		$fecha = Time::now();
		$dermo = $this->Articulos->find()
										  ->contain(['Descuentos' => [
												'queryBuilder' => function ($q) {
												return $q->where(['tipo_oferta <> "FP"', 'tipo_oferta <> "VC"']); // Full conditions for filtering
												}],  
											'Carritos' => [
												'queryBuilder' => function ($q) {
												return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); // Full conditions for filtering
												}]
				  ])
				  ->join(
					[
						'table' => 'descuentos',
						'alias' => 'd',
						'type' => 'LEFT',
						'conditions' => [
							'd.articulo_id = Articulos.id',
							'd.tipo_venta = "D"',
							'd.fecha_hasta >=' => $fecha->i18nFormat('yyyy-MM-dd'),
							'd.tipo_oferta in ("RV","RR","OR","TD","RL","SS","FR")'
						]
						]);

						
		if ($marcaid!=0 && $marcaid!=100)
		{
			 $dermo->where(['subcategoria_id'=>2,'marca_id'=>$marcaid]);			
		}
	
		if ($termsearch2 !="")
		{
			$dermo->where(['subcategoria_id'=>2,'descripcion_pag LIKE'=>$termsearch2]);
		}
		$dermo->andWhere(['Articulos.stock<>"D"','Articulos.eliminado' => 0])->group(['Articulos.id']);
						$limit = 100;
						
			
						$this->paginate = [
							'contain' => ['Carritos'],
							'limit' => $limit,
							'offset' => 0,
							'order' => ['Articulos.stock_fisico' => 'desc']
						];
		$this->set('dermos',$this->paginate($dermo) );
		

	}

	public function resultestetica($grupoid =null)
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
			}else{

				$this->request->data['terminobuscar']=0; 
			}	
	 
			if ($this->request->data['grupo_id']!= null)
			{
				$grupoid = $this->request->data['grupo_id'];
				
			} else{
				$this->request->data['grupo_id']=0;

			}	
			
	 


			$this->request->session()->write('termsearch2',$termsearch2);
		}
		else
		{
			$termsearch2 = $this->request->session()->read('termsearch2');
		}
		IF (is_null($grupoid))
		{
			if (!is_null($this->request->session()->read('grupoid'))) 
			$grupoid = $this->request->session()->read('grupoid');
			else
			$grupoid=0;
		}
		else
			$this->request->session()->write('grupoid',$grupoid);


		//$this->loadModel('Marcas');
		$this->loadModel('Grupos');
		
		//$marcas = $this->Marcas->find('list', ['keyField' => 'id','valueField' => 'nombre'])->where(['marcas_tipos_id in (2,15,16)'])->order(['nombre' => 'ASC']);
        $grupos = $this->Grupos->find('list', ['keyField' => 'id','valueField' => 'nombre'])->where(['grupos_tipos_id'=>9]);
		
		//$marcas->toArray();
		$grupos->toArray();
		$this->set(compact('grupos'));
		
		$this->viewBuilder()->layout('store_delia');
        
		
		$this->clientecredito();
		$this->sumacarrito();		

		$this->loadModel('Articulos');

		$fecha = Time::now();
		$result = $this->Articulos->find()
										  ->contain(['Descuentos' => [
												'queryBuilder' => function ($q) {
												return $q->where(['tipo_oferta <> "FP"', 'tipo_oferta <> "VC"']); // Full conditions for filtering
												}],  
											'Carritos' => [
												'queryBuilder' => function ($q) {
												return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); // Full conditions for filtering
												}]
				  ])
				  ->join(
					[
						'table' => 'descuentos',
						'alias' => 'd',
						'type' => 'LEFT',
						'conditions' => [
							'd.articulo_id = Articulos.id',
							'd.tipo_venta = "D"',
							'd.fecha_hasta >=' => $fecha->i18nFormat('yyyy-MM-dd'),
							'd.tipo_oferta in ("RV","RR","OR","TD","RL","SS","FR")'
						]
						]);

						
		if ($grupoid!=0 && $grupoid!=100)
		{
			/*if ($grupoid == 65)
				$grupoid =1;*/
			 $result->where(['subcategoria_id'=>14,'grupo_id'=>$grupoid]);			

			 
		}
	
		if ($termsearch2 !="")
		{
			$result->where(['subcategoria_id'=>14,'descripcion_pag LIKE'=>$termsearch2]);
		}
		$result->andWhere(['Articulos.stock<>"D"','Articulos.eliminado' => 0])->group(['Articulos.id']);
						$limit = 100;
						
			
						$this->paginate = [
							'contain' => ['Carritos'],
							'limit' => $limit,
							'offset' => 0,
							'order' => ['Articulos.stock_fisico' => 'desc']
						];
		$this->set('result',$this->paginate($result) );
		

	}


	public function resultfragancia($tipo = null, $marcaid =null, $generoid=null)
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
	 
			if ($this->request->data['marca_id']!= null)
			{
				$marcaid = $this->request->data['marca_id'];
				
			} else{
				$this->request->data['marca_id']=0;

			}	
			if ($this->request->data['genero_id']!= null)
			{
				$generoid = $this->request->data['genero_id'];
			
			}else{
				$this->request->data['genero_id']=0;
			}	
	 


			$this->request->session()->write('termsearch2',$termsearch2);
		}
		else
		{
			$termsearch2 = $this->request->session()->read('termsearch2');
		}
		if (is_null($marcaid))
		{
			if (!is_null($this->request->session()->read('marcaid'))) 
			$marcaid = $this->request->session()->read('marcaid');
			else
			$marcaid=0;
		}
		else
			$this->request->session()->write('marcaid',$marcaid);
			
		if (is_null($generoid))
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
		
		if ($tipo=="select")
		$marcas = $this->Marcas->find('list', ['keyField' => 'id','valueField' => 'nombre'])->where(['marcas_tipos_id'=>1])->order(['nombre' => 'ASC']);
		if ($tipo=="semiselect")
		$marcas = $this->Marcas->find('list', ['keyField' => 'id','valueField' => 'nombre'])->where(['marcas_tipos_id'=>18])->order(['nombre' => 'ASC']);
		$generos = $this->Generos->find('list', ['keyField' => 'id','valueField' => 'nombre']);
		$marcas->toArray();
		$generos->toArray();
		$this->set(compact('marcas','generos'));
		
		$this->viewBuilder()->layout('store_delia');
        $this->paginate = [	'contain' => ['FraganciasPresentaciones'],
		'limit' => 82,
		'offset' => 0, 
		//		'order' => ['Fragancias.nombre' => 'asc','FraganciasPresentaciones.detalle'=>'ASC']
		];	
		
		$this->clientecredito();
		$this->sumacarrito();		
		$this->loadModel('Fragancias');
		$fragancia = $this->Fragancias->find('all')->contain(['FraganciasPresentaciones'=> ['sort' => ['FraganciasPresentaciones.detalle' => 'ASC']],
										'FraganciasPresentaciones.Articulos' => [
											'queryBuilder' => function ($q) {
											return $q->where(['stock <> "D"','eliminado=0']); // Full conditions for filtering
											}],
										'FraganciasPresentaciones.Articulos.Descuentos' => [
										'queryBuilder' => function ($q) {
										return $q->where(['tipo_oferta <> "FP"', 'tipo_oferta <> "VC"']); // Full conditions for filtering
										}],
										'FraganciasPresentaciones.Articulos.Carritos' => [
										'queryBuilder' => function ($q) {
										return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); // Full conditions for filtering
										}]
				  ])->order(['Fragancias.nombre' => 'ASC' ]);

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
		$this->set('pass',$tipo);
		$this->set('marcas2',null);
	}
    /**
     * View method
     *
     * @param string|null $id Novedade id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
	 
    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add_admin()
    {
		$this->viewBuilder()->layout('admin');
        $novedade = $this->Novedades->newEntity();

        if ($this->request->is('post')) {
            	
			$novedade = $this->Novedades->patchEntity($novedade, $this->request->data);
			$fecha = Time::createFromFormat('d/m/Y',$this->request->data['fecha'],'America/Argentina/Buenos_Aires');
			$fecha->i18nFormat('yyyy-MM-dd');
			if(!empty($this->request->data['file']['name'])){
                $fileName = $this->request->data['file']['name'];
				
				$uploadPath = 'img/novedades/';

                $uploadFile = $uploadPath.$fileName;
				$novedade['img_file']= $fileName;
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
            }else{
                $this->Flash->error(__('Please choose a file to upload.'),['key' => 'changepass']);
				$this->redirect($this->referer());
            }
			$novedade['fecha'] = $fecha;
			if ($this->Novedades->save($novedade)) {
                $this->Flash->success('Se guardaron los cambios.',['class'=>'alert_success']);
				//$conn = ConnectionManager::get('default');
				//$conn->query('CALL actualizarnovedadesnotificacion();');
				//	<h4 class="alert_warning">A Warning Alert</h4>
				
				//<h4 class="alert_error">An Error Message</h4>
				
				//<h4 class="alert_success">A Success Message</h4>
			
			
				
                return $this->redirect(['action' => 'index_admin']);
            } else {
                $this->Flash->error('No se puedo guardar la publicacion. Por favor intente de nuevo',['key' => 'changepass']);
            }
        }
        $this->set(compact('novedade'));
        $this->set('_serialize', ['novedade']);
		$this->set('titulo','Agregar Noticia');
    }

    /**
     * Edit method
     *
     * @param string|null $id Novedade id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit_admin($id = null)
    {
	$this->viewBuilder()->layout('admin');
        $novedade = $this->Novedades->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $novedade = $this->Novedades->patchEntity($novedade, $this->request->data);
			$fecha = Time::createFromFormat('d/m/Y',$this->request->data['fecha'],'America/Argentina/Buenos_Aires');
			$fecha->i18nFormat('yyyy-MM-dd');
			$novedade->fecha=$fecha;
            if ($this->Novedades->save($novedade)) {
                $this->Flash->success('The novedade has been saved.');
                return $this->redirect(['action' => 'index_admin']);
            } else {
                $this->Flash->error('The novedade could not be saved. Please, try again.',['key' => 'changepass']);
            }
        }
        $this->set(compact('novedade'));
        $this->set('_serialize', ['novedade']);
		$this->set('titulo','Editar Noticia');
    }

    /**
     * Delete method
     *
     * @param string|null $id Novedade id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete_admin($id = null)
    {
	$this->viewBuilder()->layout('admin');
        $this->request->allowMethod(['post', 'delete']);
        $novedade = $this->Novedades->get($id);
        if ($this->Novedades->delete($novedade)) {
            $this->Flash->success('The novedade has been deleted.');
        } else {
            $this->Flash->error('The novedade could not be deleted. Please, try again.',['key' => 'changepass']);
        }
        return $this->redirect(['action' => 'index_admin']);
    }
	
}
