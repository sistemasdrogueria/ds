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
class TiendasController extends AppController
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
        
	
		 if (in_array($this->request->action, ['index','delete_admin','index_admin','add_admin','edit_admin','view_admin','search'])) {
       
            if($this->request->session()->read('Auth.User.role')=='admin') 
            {				
                return true;			
            }			
            else {	
                if($this->request->session()->read('Auth.User.role')=='client') 
                {	
					
						$tiene= $this->tienepermiso('patagoniamed',$this->request->action);
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
		$carritocon = $this->Carritos->find('all')->contain(['Articulos'])
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
		if (empty($this->request->session()->read('Categorias')))
		{
		$this->loadModel('Articulos');
		$fecha = Time::now();
		$articulosA = $this->Articulos->find('list',['keyField' => 'Laboratorios.id','valueField'=>'Laboratorios.nombre'])
			->select(['Laboratorios.id','Laboratorios.nombre'])
					->join([
						'table' => 'descuentos',
						'alias' => 'd',
						'type' => 'INNER',
						 'conditions' => [
						'd.articulo_id = Articulos.id',
						'd.tipo_venta = "D"',
						'd.fecha_hasta >=' => $fecha->i18nFormat('yyyy-MM-dd'),
						'd.tipo_oferta in ("TD","TH")'
						]
					]
					)
					->join([
						'table' => 'laboratorios',
						'alias' => 'Laboratorios',
						'type' => 'INNER',
						 'conditions' => [
							'Laboratorios.id = Articulos.laboratorio_id'
						
						]
					]
					)
					->where(['Articulos.eliminado'=>0, 'Articulos.categoria_id in (1,6,7)'])->group(['Articulos.laboratorio_id'])->order(['Laboratorios.nombre'=>'asc']);
		$this->loadModel('Categorias');
		$categorias = $this->Categorias->find('list',['keyField' => 'id','valueField'=>'nombre']);
		$this->request->session()->write('Laboratorios2',$articulosA->toArray());
		$laboratorios =$this->request->session()->read('Laboratorios2');
		$this->request->session()->write('Categorias',$categorias->toArray());	
		}
		else{
			$this->loadModel('Articulos');
			$fecha = Time::now();
			$articulosA = $this->Articulos->find('list',['keyField' => 'Laboratorios.id','valueField'=>'Laboratorios.nombre'])
				->select(['Laboratorios.id','Laboratorios.nombre'])
				->join([
					'table' => 'descuentos',
					'alias' => 'd',
					'type' => 'INNER',
					 'conditions' => [
					'd.articulo_id = Articulos.id',
					'd.tipo_venta = "D"',
					'd.fecha_hasta >=' => $fecha->i18nFormat('yyyy-MM-dd'),
					'd.tipo_oferta in ("TD","TH")'
					]
				]
				)
				->join([
					'table' => 'laboratorios',
					'alias' => 'Laboratorios',
					'type' => 'INNER',
					 'conditions' => [
					'Laboratorios.id = Articulos.laboratorio_id'
					
					]
				]
				)
				->where(['Articulos.eliminado'=>0, 'Articulos.categoria_id in (1,6,7)'])->group(['Articulos.laboratorio_id'])->order(['Laboratorios.nombre'=>'asc']);
	        $this->request->session()->write('Laboratorios2',$articulosA->toArray());
			$laboratorios =$this->request->session()->read('Laboratorios2');
			$this->loadModel('Categorias');
			$categorias = $this->Categorias->find('list',['keyField' => 'id','valueField'=>'nombre']);
			$this->request->session()->write('Categorias',$categorias->toArray());	
			$categorias = $this->request->session()->read('Categorias');
		}	
		$this->set('categorias',$categorias);
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

	public function index($lab_id = null,$tipo_oferta=null,$termsearch=null,$indice = null ){
		$this->viewBuilder()->layout('store');
		//$this->viewBuilder()->layout('storefp');
		$this->paginate = [		
			'contain' => [],
			'limit' => 200 , 'maxLimit' => 200,
			'offset' => 0, 
			'order' => ['Articulos.descripcion_pag' => 'asc']];			
		$this->clientecredito();
		$this->sumacarrito();	
		$this->loadModel('Articulos');
		$this->loadModel('Carritos');
		
	
		$this->categoriaylaboratorio2();	
		
		$fecha = Time::now();
		if ($tipo_oferta ==1)			
		$articulosA = $this->Articulos->find()
				->contain(['Laboratorios','Descuentos','Carritos' => [				
					'queryBuilder' => function ($q) {return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); }
				]
			])
		->hydrate(false)
			->join([
				'table' => 'descuentos',
				'alias' => 'd',
				'type' => 'LEFT',
				'conditions' => ['d.articulo_id = Articulos.id','d.tipo_venta = "D"','d.fecha_hasta >=' => $fecha->i18nFormat('yyyy-MM-dd'),'d.tipo_oferta in ("TD","OR","RL","RV","TH")']
			]);


		
		if ($tipo_oferta ==2)			
			$articulosA = $this->Articulos->find()
					->contain(['Laboratorios','Descuentos','Carritos' => [				
						'queryBuilder' => function ($q) {return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); }	]
				])
				->join([
					'table' => 'descuentos',
					'alias' => 'd',
					'type' => 'LEFT',
					'conditions' => ['d.articulo_id = Articulos.id','d.tipo_venta = "D"','d.fecha_hasta >=' => $fecha->i18nFormat('yyyy-MM-dd'),'d.tipo_oferta in ("TD","OR","RL","RV","TH")']
				])
				->andWhere(['d.articulo_id is null']);
				
				
		if ($tipo_oferta ==3)			
			$articulosA = $this->Articulos->find()
			->contain(['Laboratorios','Descuentos','Carritos' => [				
					   'queryBuilder' => function ($q) { return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); } ] 
					   ])
			->hydrate(false)
			->join([
				'table' => 'descuentos',
				'alias' => 'd',
				'type' => 'INNER',
				'conditions' => ['d.articulo_id = Articulos.id','d.tipo_venta = "D"','d.fecha_hasta >=' => $fecha->i18nFormat('yyyy-MM-dd'),'d.tipo_oferta in ("TD","OR","RL","RV","TH")']
			]);
							
		$articulosA->andWhere(['Articulos.eliminado'=>0,'Articulos.stock <>"D"','Articulos.laboratorio_id'=>$lab_id]);


		




		if ($termsearch != null) 
		$articulosA->andWhere(['Articulos.descripcion_pag LIKE'=>'%'.$termsearch.'%']);


		if ($lab_id == 505)
		{
			$articulosB = $this->Articulos->find()
			->contain(['Laboratorios','Descuentos','Carritos' => [				
				'queryBuilder' => function ($q) {return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); }
			]
				])
			->hydrate(false)
				->join([
					'table' => 'descuentos',
					'alias' => 'd',
					'type' => 'LEFT',
					'conditions' => ['d.articulo_id = Articulos.id','d.tipo_venta = "D"','d.fecha_hasta >=' => $fecha->i18nFormat('yyyy-MM-dd'),'d.tipo_oferta in ("TD","OR","RL","RV","TH")']
				]);
				$articulosB->andWhere(['Articulos.eliminado'=>0,'Articulos.stock <>"D"', 'Articulos.id = 50191','Articulos.eliminado'=>0])->unionAll($articulosA);

			
			
		}
		else
			$articulosB = null;
		
			if ($articulosB !=null)
			{
				$limit =100;
			if ($articulosB->count()<100 && $articulosB->count()>50 )
			{
				$limit = 150;
			}
			if ($articulosB->count()>100 )
			{
				$limit= 300;
			}
			
			$this->paginate = [		
			'limit' => $limit,
			'offset' => 0, 
			];
		
			if ($tipo_oferta <>2)	
			$articulosB->andWhere(['Articulos.eliminado'=>0])->group(['Articulos.id'])
						->order(['Laboratorios.nombre'=>'asc','d.tipo_precio'=>'asc','Articulos.descripcion_pag' => 'asc']);
			else
			$articulosB->andWhere(['Articulos.eliminado'=>0])->group(['Articulos.id'])
						->order(['Laboratorios.nombre'=>'asc','Articulos.descripcion_pag' => 'asc']);
			
			$articulos = $this->paginate($articulosB);
			}
			else
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
				
					if ($tipo_oferta <>2)	
					$articulosA->andWhere(['Articulos.eliminado'=>0])->group(['Articulos.id'])
								->order(['Laboratorios.nombre'=>'asc','d.tipo_precio'=>'asc','Articulos.descripcion_pag' => 'asc']);
					else
					$articulosA->andWhere(['Articulos.eliminado'=>0])->group(['Articulos.id'])
								->order(['Laboratorios.nombre'=>'asc','Articulos.descripcion_pag' => 'asc']);
					
					$articulos = $this->paginate($articulosA);
		
			}
		
		


		//$this->set('indice',null);
		//$this->set('tipo_oferta',$tipo_oferta);

			
		$this->set(compact('articulos'));
		$this->set('_serialize', 'articulos');
		$this->set('lab_id',$lab_id);
	
	
		}
	 

		public function search($lab_id = null,$termsearch=null,$tipo_oferta = null,$indice = null ){
			$this->viewBuilder()->layout('store');
			//$this->viewBuilder()->layout('storefp');
			$this->paginate = [		
				'contain' => [],
				'limit' => 200 , 'maxLimit' => 200,
				'offset' => 0, 
				'order' => ['Articulos.descripcion_pag' => 'asc']];			
			$this->clientecredito();
			$this->sumacarrito();	
			$this->loadModel('Articulos');
			$this->loadModel('Carritos');
			
		
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
							
									if ($termsearch != null) 
										$articulosA->andWhere(['Articulos.descripcion_pag LIKE'=>'%'.$termsearch.'%']);
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
				
		
				$this->set('indice',$indice);
				$this->set('tipo_oferta',$tipo_oferta);
		
						
					
				$this->set(compact('articulos'));
				$this->set('_serialize', 'articulos');
				$this->set('lab_id',$lab_id);
		
		
			}
	

	
	
    /**
     * View method
     *
     * @param string|null $id Novedade id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
	 
	public function consolidado()
    {
		$this->viewBuilder()->layout('store');
        $this->loadModel('Files');
		
		$file1=$this->Files->find('all')->where(['status'=>2])->order(['created' => 'DESC'])->first();
		$file2=$this->Files->find('all')->where(['status'=>3])->order(['created' => 'DESC'])->first();
		
		$this->set('consolidadodermo',$file1);
		$this->set('consolidadoptm',$file2);
    }
	 
    public function view_admin($id = null)
    {
		$this->viewBuilder()->layout('admin');
        $novedade = $this->Novedades->get($id, [
            'contain' => []
        ]);
        $this->set('novedade', $novedade);
        $this->set('_serialize', ['novedade']);
		$this->set('titulo','Visualizar Noticia');
    }
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
