<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Cake\Database\Expression\QueryExpression;
use Cake\Datasource\ConnectionManager;

/**
 * Ofertas Controller
 *
 * @property \App\Model\Table\OfertasTable $Ofertas
 */
class OfertasController extends AppController
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
	if (in_array($this->request->action, ['cambiarfechas_admin','deshabilitar_admin','habilitar_admin','index_admin','add','otros_admin','edit_admin','delete_admin','view_admin','index_admin_search','add_admin_search','add_admin_perfumeria','add_admin_oferta','edit_oferta','perfumeria','index','add_admin_oferta_laboratorio'])) {
       
            if($this->request->session()->read('Auth.User.role')=='admin') 
            {				
                return true;			
            }			
            else 
				{	
						if($this->request->session()->read('Auth.User.role')=='client') 
						{	
						$tiene= $this->tienepermiso('ofertas',$this->request->action);
						if (!$tiene)
							$this->Flash->error(__('No tiene permisos para ingresar'),['key' => 'changepass']);
						return $tiene;			
						}	
						else
						{
						$this->Flash->error(__('No tiene permisos para ingresar'),['key' => 'changepass']);
						$this->redirect($this->referer());
								
					
						return false;	
						}
				}		
            }		
			else 
			{			
				$this->Flash->error(__('No tiene permisos para ingresar'),['key' => 'changepass']);		
				$this->redirect($this->referer());	
				return false;	
				
			}
		return parent::isAuthorized($user);
	}
    /**
     * Index method
     *
     * @return void
     */
	 
	 /*
	public function index_admin()
    {
		$this->viewBuilder()->layout('admin');
        $this->paginate = [
            'contain' => ['Articulos']
        ];
        $this->set('ofertas', $this->paginate($this->Ofertas));
        $this->set('_serialize', ['ofertas']);
		$this->set('titulo','Lista de Resultado de ofertas');
    }*/
    
	public function perfumeria()
	{
		$this->viewBuilder()->layout('store');
		 $this->paginate = [
			'limit' => 100
			
		];
		$fechahasta2 = Time::now();
				$fechahasta2-> modify('+1 days');
				$fechahasta2 = $fechahasta2->i18nFormat('yyyy-MM-dd');
			$fechahasta = Time::now();
		$ofertasA = $this->Ofertas->find('all');
		$ofertasA->where(['habilitada'=>1,'activo'=>1,'oferta_tipo_id <'=>6])
				->andWhere(["Ofertas.fecha_hasta > '".$fechahasta->i18nFormat('yyyy-MM-dd')."'"])
				 ->order(['id' => 'DESC']);
		$ofertas = $this->paginate($ofertasA);
		
		$this->loadModel('OfertasTipos');
		$OfertasTipos =  $this->OfertasTipos->find('list', ['keyField' => 'id','valueField' => 'nombre']);
		$this->set('ofertastipos',$OfertasTipos ->toArray());
		
        $this->set('ofertas', $ofertas);
        $this->set('_serialize', ['ofertas']);

	}
	
	public function edit_oferta()
    {
		$this->loadModel('CarritosTemps');

		$ofertas = TableRegistry::get('Ofertas');
		$entities = $ofertas->newEntities($this->request->data());
		$this->loadModel('Laboratorios');
		$laboratorios =$this->Laboratorios->find('list',['keyField' => 'id','valueField'=>'nombre'])
										->order(['nombre' => 'ASC']);	
		$this->set(compact('laboratorios'));
		$conn = ConnectionManager::get('default');

		foreach ($entities as $oferta) {
				
				
				$habilitada= $oferta['habilitada'];
				$id=$oferta['id'];
				
				$oferta2 = $this->Ofertas->get($id);
				
				$oferta2['activo']= $habilitada;
				$oferta2['habilitada']=$habilitada;				
				
				if (isset($this->request->data['btn2'])) {
					if ($oferta2['habilitada'])
					{
					$conn->query('CALL CopiarOfertaDelete('.$id.');');	
					if ($this->Ofertas->delete($oferta2)) {
						$this->Flash->success('La oferta se borro correctamente.',['key' => 'changepass']);
					   
						
					} else {
						$this->Flash->error('La oferta se puedo borrar correctamente, intente de nuevo.',['key' => 'changepass']);
						
						
					}
					}
				}
				else if (isset($this->request->data['btn1'])) {
					// btn2 was clicked
			
				if ($this->Ofertas->save($oferta2))
				{
					$this->Flash->success('Se guardo los cambios correctamente.',['key' => 'changepass']);
					//$this->redirect($this->referer());
				}
				else
				{
					$this->Flash->error('No se pudo guardar los cambios. Intente de nuevo',['key' => 'changepass']);
				}
				}
		
		}

		//$this->set('carritos2', $carros);
		$this->redirect($this->referer());
    }

	public function index()
    {
		$this->viewBuilder()->layout('store');
        $this->paginate = [
			'limit' => 100,
			
		];
		$this->redirect($this->referer());
		if ($this->request->is('post','get')) {
			
			if ($this->request->data['fechadesde']!= null)
				$fechadesde = $this->request->data['fechadesde'];
			else
				$fechadesde=0;
			if ($this->request->data['fechahasta']!= null)
				$fechahasta = $this->request->data['fechahasta'];
			else
				$fechahasta =0;
			if ($this->request->data['termino']!= null)
				$termsearchp = '%'.$this->request->data['termino'].'%';
			else
				$termsearchp ="";
			if ($this->request->data['ofertatipo']!= null)
				$ofertatipo = $this->request->data['ofertatipo'];
			else
				$ofertatipo=0;
			
			
			$this->request->session()->write('ofertatipo',$ofertatipo);
			
			$this->request->session()->write('termsearchp',$termsearchp);
			$this->request->session()->write('fechadesde',$fechadesde);	
			$this->request->session()->write('fechahasta',$fechahasta);
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
				$fechahasta2 = $fechahasta2->i18nFormat('yyyy-MM-dd');
			}
			if ($fechadesde!=0)
			{
				//$fechadesde2 = Time::now();
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
			if (($fechadesde !=0) || ($fechahasta !=0) || ($termsearchp !="") || ($ofertatipo!=0))
				{	
					$ofertasA = $this->Ofertas->find('all');
				}
			else
				{
					$ofertasA=null;
					//$this->redirect($this->referer());
				}	
			
		if ($ofertatipo!=0)
		{
			$ofertasA->andWhere(['Ofertas.oferta_tipo_id'=>$ofertatipo]);
		}
		if (($fechadesde !=0) || ($fechahasta !=0))
			$ofertasA->andWhere(["Ofertas.fecha_desde BETWEEN '".$fechadesde2->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta2->i18nFormat('yyyy-MM-dd')."'"]);
	  	if ($termsearchp!="")
			$ofertasA->where(['Ofertas.descripcion LIKE'=>$termsearchp])->orWhere(['Ofertas.detalle LIKE'=>$termsearchp]);
			if ($ofertasA!=null)
				$ofertas = $this->paginate($ofertasA);
			else
				$ofertas = null;		
		}
		else
		{
			$ofertatipo =  $this->request->session()->read('ofertatipo');
			$fechahasta = $this->request->session()->read('fechahasta');
		    $fechadesde = $this->request->session()->read('fechadesde');
			$termsearchp = $this->request->session()->read('termsearchp');
			$ofertas = $this->paginate($this->Ofertas->find());
		}
		$this->loadModel('OfertasTipos');
		$OfertasTipos =  $this->OfertasTipos->find('list', ['keyField' => 'id','valueField' => 'nombre']);
		$this->set('ofertastipos2',$OfertasTipos ->toArray());
				
		$this->set('ofertastipos',$this->OfertasTipos->find()->toArray());
        $this->set('ofertas', $ofertas);
        $this->set('_serialize', ['ofertas']);
		$this->set('titulo','Lista de Ofertas');
    }

 
	public function index_admin()
    {
		$this->viewBuilder()->layout('admin2');
        $this->paginate = [
			'limit' => 200,
			'contain'=>['OfertasTipos','Articulos']
		];
		
		if ($this->request->is('post','get')) {
			
			if ($this->request->data['fechadesde']!= null)
				$fechadesde = $this->request->data['fechadesde'];
			else
				$fechadesde=0;
			if ($this->request->data['fechahasta']!= null)
				$fechahasta = $this->request->data['fechahasta'];
			else
				$fechahasta =0;
			if ($this->request->data['termino']!= null)
				$termsearchoff = '%'.$this->request->data['termino'].'%';
			else
				$termsearchoff ="";
			if ($this->request->data['ofertatipo']!= null)
				$ofertatipo = $this->request->data['ofertatipo'];
			else
				$ofertatipo=0;
			
			
			$this->request->session()->write('ofertatipo',$ofertatipo);
			
			$this->request->session()->write('termsearchoff',$termsearchoff);
			$this->request->session()->write('fechadesde',$fechadesde);	
			$this->request->session()->write('fechahasta',$fechahasta);
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
				$fechahasta2 = $fechahasta2->i18nFormat('yyyy-MM-dd');
			}
			if ($fechadesde!=0)
			{
				//$fechadesde2 = Time::now();
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
			if (($fechadesde !=0) || ($fechahasta !=0) || ($termsearchoff !="") || ($ofertatipo!=0))
				{	
					$ofertasA = $this->Ofertas->find('all')
					->contain(['OfertasTipos','Articulos']);
				}
			else
				{
					$ofertasA=null;
					//$this->redirect($this->referer());
				}	
			
		if ($ofertatipo!=0)
		{
			$ofertasA->andWhere(['Ofertas.oferta_tipo_id'=>$ofertatipo]);
		}
		if (($fechadesde !=0) || ($fechahasta !=0))
			$ofertasA->andWhere(["Ofertas.fecha_desde BETWEEN '".$fechadesde2->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta2->i18nFormat('yyyy-MM-dd')."'"]);
	  	if ($termsearchoff!="" && $termsearchoff!="%%" )
			$ofertasA->where(['Ofertas.descripcion LIKE'=>$termsearchoff])->orWhere(['Ofertas.detalle LIKE'=>$termsearchoff]);
		if ($ofertasA!=null)
				$ofertas = $this->paginate($ofertasA->order(['Ofertas.id'=>'DESC']));
			else
				$ofertas = null;	
		}
		else
		{
			$ofertatipo =  $this->request->session()->read('ofertatipo');
			$fechahasta = $this->request->session()->read('fechahasta');
			$fechadesde = $this->request->session()->read('fechadesde');
			$termsearchp = $this->request->session()->read('termsearchp');
			$ofertas = $this->paginate($this->Ofertas->find('all')->order(['Ofertas.id'=>'DESC']));
		}
		$this->loadModel('OfertasTipos');
		$OfertasTipos =  $this->OfertasTipos->find('list', ['keyField' => 'id','valueField' => 'nombre']);
		$this->set('ofertastipos2',$OfertasTipos ->toArray());
				
		$this->set('ofertastipos',$this->OfertasTipos->find()->toArray());
        $this->set('ofertas', $ofertas);
        $this->set('_serialize', ['ofertas']);
		$this->set('titulo','Lista de Ofertas');
    }

 
    /**
     * View method
     *
     * @param string|null $id Oferta id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view_admin($id = null)
    {
		$this->viewBuilder()->layout('admin');
        $oferta = $this->Ofertas->get($id, [
            'contain' => ['Articulos']
        ]);
        $this->set('oferta', $oferta);
        $this->set('_serialize', ['oferta']);
		$this->set('titulo','Visualización de Ofertas');
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add_admin_search()
    {
		$this->viewBuilder()->layout('admin2');
		if ($this->request->session()->read('Categorias')== null)
		{
			$this->loadModel('Categorias');
			$this->loadModel('Laboratorios');
			$categorias = $this->Categorias->find('list',['keyField' => 'id','valueField'=>'nombre']);
			$laboratorios = $this->Laboratorios->find('list',['keyField' => 'id','valueField'=>'nombre'])->where(['eliminado=1'])->order(['nombre' => 'ASC']);
			$this->request->session()->write('Categorias',$categorias->toArray());
			$this->request->session()->write('Laboratorios',$laboratorios ->toArray());
		}
		else{
			$laboratorios =$this->request->session()->read('Laboratorios');
			$categorias = $this->request->session()->read('Categorias');
		}	
		
		$this->set('categorias',$categorias );

		$this->set('laboratorios',$laboratorios);
		
		$this->loadModel('Admin');
		$this->loadModel('Articulos');
		$fecha = Time::now();
		$fecha->i18nFormat('yyyy-MM-dd');
	  	$articulosA = $this->Articulos->find('all')
					->contain(['Descuentos'])
					->join([
						'table' => 'descuentos',
						'alias' => 'd',
						'type' => 'LEFT',
						 'conditions' => [
						'd.articulo_id = Articulos.id',
						'd.tipo_venta = "D"',
						'd.fecha_hasta >=' => $fecha,
						'd.tipo_oferta in ("RV","RR","OR","TD","RL")'
						]		
					]
					)
					->where(['Articulos.eliminado=0','Articulos.id'=>$this->request->data['articulo_id']]);
		
		$articulo = $articulosA->first();
		$this->loadModel('OfertasTipos');
		$ofertatipo = $this->OfertasTipos->find('list',['keyField' => 'id','valueField'=>'nombre']);
		$this->set('ofertastipos',$ofertatipo->toArray());
		$this->set('articulo',$articulo);
        $this->set(compact('oferta'));
        $this->set('_serialize', ['oferta']);
		$this->set('titulo','Agregar de Oferta');
    }
	
	public function add()
    {
		$this->viewBuilder()->layout('admin2');
		$categoriaid = 0;
		$laboratorioid = 0;
		$termsearch = "";
		$tipoofertas = 0;	
		
		if ($this->request->is('post')) {
           if  ($this->request->data['terminosearch']!=null || $this->request->data['categoria_id']!=null  ||
		   $this->request->data['laboratorio_id']!=null  || $this->request->data['tipoofertas']!=null)
		    {
				
			if ($this->request->data['categoria_id']!= null)
			{
				$categoriaid = $this->request->data['categoria_id'];
			}	
			
			if ($this->request->data['laboratorio_id']!= null)
			{
				$laboratorioid = $this->request->data['laboratorio_id'];
			}	
			else
			
			if ($this->request->data['tipoofertas']!= null)
			{
				$tipoofertas = $this->request->data['tipoofertas'];
			}	
			
			
			if ($this->request->data['terminosearch']!= null)
			{
				$termsearch = '%'.$this->request->data['terminosearch'].'%';
			}	

			$this->request->session()->write('tipoofertas',$tipoofertas);
			$this->request->session()->write('termsearch',$termsearch);
			$this->request->session()->write('categoriaid',$categoriaid);	
			$this->request->session()->write('laboratorioid',$laboratorioid);
			
			}
			else 
			{
			$categoriaid = $this->request->session()->read('categoriaid');
		    $laboratorioid = $this->request->session()->read('laboratorioid');
			$termsearch = $this->request->session()->read('termsearch');
			$tipoofertas = $this->request->session()->read('tipoofertas');	
			}
		}

		$fecha = Time::now();
		$fecha->i18nFormat('yyyy-MM-dd');
		$this->loadModel('Articulos');
		  $articulosA = $this->Articulos->find('all')
					->contain(['Descuentos' => [
						
						'queryBuilder' => function ($q) {
							return $q->where(['tipo_oferta not in ("TL")']); // Full conditions for filtering
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
						'd.tipo_oferta in ("RV","RR","OR","TD","RL")'
						]		
					]
					);
				
		if ($termsearch!="")
		{
			$articulosA->andWhere([
					
					'OR' => [['Articulos.descripcion_pag LIKE'=>$termsearch], ['Articulos.descripcion_sist LIKE'=>$termsearch], 
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
						if ($tipoofertas ==0)
						{
							$articulosA=null;
							//$this->redirect($this->referer());
						}
					}
				}
			}		
		}
		if ($tipoofertas!=0)
		{			
			if ($tipoofertas==1)			
			{
				$articulosA->andWhere([
					
					'OR' => [['d.tipo_oferta'=>"RR"], 
					['d.tipo_oferta'=>"RV"],
					['d.tipo_oferta'=>"RL"]],
				]);
				
			}
			else
			if ($tipoofertas==2)			
			{
				$articulosA->andWhere([
					
					'OR' => [['d.tipo_oferta'=>"OR"], 
					['d.tipo_oferta'=>"TD"]],
				]);
		
			}
			else
			if ($tipoofertas==3)			
			{
				$articulosA->andWhere([
					
					'OR' => [['d.tipo_oferta'=>"OR"], 
					['d.tipo_oferta'=>"TD"],
					['d.tipo_oferta'=>"RR"], 
					['d.tipo_oferta'=>"RV"],				
					['d.tipo_oferta'=>"RL"]	
					]
				]);
		
			}
		}	
		
		$this->paginate = [		
		'contain' => ['Descuentos'],
		'limit' => 100,
		'offset' => 0, 
        'order' => ['Articulos.descripcion_pag' => 'asc']];	
		
			if ($articulosA!=null)
			{
				$articulosA->andWhere(['Articulos.eliminado=0']);
				$articulos = $this->paginate($articulosA);
			}
			else
				$articulos = null;
		
		
        
		
		//$articulos = null;
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
		
        $this->set('articulos', $articulos);
       
		$this->set('titulo','Agregar de Oferta');
		
    }

	public function add_admin_oferta_laboratorio()
    {
		$this->viewBuilder()->layout('admin2');
		$this->set('titulo','Perfumeria');
		$this->loadModel('Laboratorios');
		$laboratorios =$this->Laboratorios->find('list',['keyField' => 'id',
		
		'valueField' => function ($row) {
            return $row['nombre'] . ' - ' . $row['codigo']; // Unir los dos campos
		}
		])
										->order(['nombre' => 'ASC']);	
		$this->set(compact('laboratorios'));
		$this->loadModel('Marcas');
		$marcas =$this->Marcas->find('list',['keyField' => 'id','valueField'=>'nombre'])
										->order(['nombre' => 'ASC']);	
		$this->set(compact('marcas'));


		$oferta = $this->Ofertas->newEntity();
        if ($this->request->is('post')) {
            $oferta = $this->Ofertas->patchEntity($oferta, $this->request->data);
			$fechadesde = Time::createFromFormat('d/m/Y',$this->request->data['fecha_desde'],'America/Argentina/Buenos_Aires');
			$fechadesde->i18nFormat('yyyy-MM-dd');
			$fechahasta = Time::createFromFormat('d/m/Y',$this->request->data['fecha_hasta'],'America/Argentina/Buenos_Aires');
			$fechahasta->i18nFormat('yyyy-MM-dd');
			
			$oferta['fecha_desde'] = $fechadesde;
			$oferta['fecha_hasta'] = $fechahasta;
			$uploadData = '';
			if(!empty($this->request->data['file']['name'])){
                $fileName = $this->request->data['file']['name'];
				$uploadPath = 'img/ofertas/';
                $uploadFile = $uploadPath.$fileName;
				$oferta['imagen']= $fileName;
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
			if(!empty($this->request->data['file2']['name'])){
                $fileName = $oferta['busqueda'].'.jpg';
                $uploadPath = 'img/logos/';
                $uploadFile = $uploadPath.$fileName;
				
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


            if ($this->Ofertas->save($oferta)) {

                $this->Flash->success(__('La oferta fue cargada correctamente'),['key' => 'changepass']);
                return $this->redirect(['action' => 'index_admin']);
            } else {
				$this->Flash->error(__('No se pudo cargar la oferta, intente nuevamente'),['key' => 'changepass']);
                $this->redirect($this->referer());	
            }
        }
		$this->loadModel('OfertasTipos');
        $OfertasTipos =  $this->OfertasTipos->find('list', ['keyField' => 'id','valueField' => 'nombre']);
		$this->set('ofertastipos',$OfertasTipos->toArray());
        $this->set(compact('oferta'));
        $this->set('_serialize', ['oferta']);
    }

	public function deshabilitar_admin()
    {

		$this->viewBuilder()->layout('admin');
        if ($this->request->data['oferta_tipo_id'] !=null)
		{
			$connection = ConnectionManager::get('default');

			$confirmados = $connection->execute('call deshabilitaroferta('. $this->request->data['oferta_tipo_id'].');');
			//$this->request->session()->write('confirmados',$confirmados);	
			//debug($confirmados);
			//$confirmados = $connection->execute('delete from carritos_temps WHERE cliente_id='.$this->request->session()->read('Auth.User.cliente_id'));

			$this->Flash->success('Se importo correctamente '.$this->request->data['oferta_tipo_id'],['key' => 'changepass']);
			return $this->redirect($this->referer());
		}
    }
	
	
	 public function cambiarfechas_admin()
    {
		if ($this->request->is('post')) {
			
			if ($this->request->data['fechadesde']!= null)
				$fechadesde = $this->request->data['fechadesde'];
			else
				$fechadesde=0;
			if ($this->request->data['fechahasta']!= null)
				$fechahasta = $this->request->data['fechahasta'];
			else
				$fechahasta =0;
			
			
			$this->request->session()->write('fechadesde',$fechadesde);	
			$this->request->session()->write('fechahasta',$fechahasta);
			if ($fechahasta!=0)
			{
				//$fechahasta2 = Time::now();
				$fechahasta2 = Time::createFromFormat('d/m/Y',$fechahasta,'America/Argentina/Buenos_Aires');
			
				$fechahasta2->i18nFormat('yyyy-MM-dd');
			}
			else
			{
				$fechahasta2 = Time::now();
				$fechahasta2-> modify('+1 days');
				$fechahasta2 = $fechahasta2->i18nFormat('yyyy-MM-dd');
			}
			if ($fechadesde!=0)
			{
				//$fechadesde2 = Time::now();
				$fechadesde2 = Time::createFromFormat('d/m/Y',$fechadesde,'America/Argentina/Buenos_Aires');
				$fechadesde2->i18nFormat('yyyy-MM-dd');
			}
			else
			{
				$fechadesde2 = Time::now();
				$fechadesde2->i18nFormat('yyyy-MM-dd');
			}
		}
		
		$this->viewBuilder()->layout('admin');
     
			$connection = ConnectionManager::get('default');

			$confirmados = $connection->execute("call actualizaroferta(". $this->request->data['oferta_tipo_id'].",'".$fechadesde2->i18nFormat('yyyy-MM-dd')."','".$fechahasta2->i18nFormat('yyyy-MM-dd')."');");
			//$this->request->session()->write('confirmados',$confirmados);	
			//debug($confirmados);
			//$confirmados = $connection->execute('delete from carritos_temps WHERE cliente_id='.$this->request->session()->read('Auth.User.cliente_id'));

			$this->Flash->success('Se actualizo correctamente '.$this->request->data['oferta_tipo_id']. ' '.$fechadesde2->i18nFormat('yyyy-MM-dd').' '.$fechahasta2->i18nFormat('yyyy-MM-dd'),['key' => 'changepass']);
			return $this->redirect($this->referer());
		
    }
	
	public function add_admin_oferta()
    {
		$this->viewBuilder()->layout('admin');
        $oferta = $this->Ofertas->newEntity();
        if ($this->request->is('post')) {
            $oferta = $this->Ofertas->patchEntity($oferta, $this->request->data);
			$fechadesde = Time::createFromFormat('d/m/Y',$this->request->data['fecha_desde'],'America/Argentina/Buenos_Aires');
			$fechadesde->i18nFormat('yyyy-MM-dd');
			$fechahasta = Time::createFromFormat('d/m/Y',$this->request->data['fecha_hasta'],'America/Argentina/Buenos_Aires');
			$fechahasta->i18nFormat('yyyy-MM-dd');
			$oferta['articulo_id'] = $this->request->data['articulo_id'];
			$oferta['fecha_desde'] = $fechadesde;
			$oferta['fecha_hasta'] = $fechahasta;
			$uploadData = '';
			if(!empty($this->request->data['file']['name'])){
				if ($this->request->data['oferta_tipo_id']>11)
				$fileName = $this->request->data['file']['name'];
				else
				$fileName = $this->request->data['codigo_barras'].'.jpg';
				
				
				$uploadPath = 'img/ofertas/';
                $uploadFile = $uploadPath.$fileName;
				$oferta['imagen']= $fileName;
				
                if(move_uploaded_file($this->request->data['file']['tmp_name'],$uploadFile)){
					
					$uploadData = $this->Files->newEntity();
                    $uploadData->name = $fileName;
                    $uploadData->path = $uploadPath;
                    $uploadData->created = date("Y-m-d H:i:s");
                    $uploadData->modified = date("Y-m-d H:i:s");
                    if ($this->Files->save($uploadData)) {
						if ($oferta['ubicacion']==0)
						{
						$uploadPath = 'img/productos/';
						$nuevo_fichero = $uploadPath.$this->request->data['codigo_barras'].'.jpg';
				
				
						if (!copy($uploadFile, $nuevo_fichero)) {
							$this->Flash->error(__('Error al copiar.'),['key' => 'changepass']);
							//echo "Error al copiar $fichero...\n";
						}
						}
                        //$this->Flash->success(__('File has been uploaded and inserted successfully.'),['key' => 'changepass']);
                    }else{
                        $this->Flash->error(__('Unable to upload file, please try again.'),['key' => 'changepass']);
						$this->redirect($this->referer());
                    }
					
				
                }else{
                    $this->Flash->error(__('Unable to upload file, please try again. '.$uploadFile),['key' => 'changepass']);
					//$this->redirect($this->referer());
                }
            }else{
                $this->Flash->error(__('Please choose a file to upload.3'),['key' => 'changepass']);
				//$this->redirect($this->referer());
            }

            if ($this->Ofertas->save($oferta)) {

                $this->Flash->success(__('La oferta fue cargada correctamente'),['key' => 'changepass']);
                return $this->redirect(['action' => 'index_admin']);
            } else {
				$this->Flash->error(__('No se pudo cargar la oferta, intente nuevamente'),['key' => 'changepass']);
                $this->redirect($this->referer());	
            }
        }
        
		
		
        
            
        $articulos = $this->Ofertas->Articulos->find('list', ['limit' => 200]);
        $OfertasTipos =  $this->OfertasTipos->find('list', ['keyField' => 'id','valueField' => 'nombre']);
		$this->set('ofertastipos',$OfertasTipos ->toArray());
        $this->set(compact('oferta', 'articulos', 'ofertastipos'));
        $this->set('_serialize', ['oferta']);
    }
  
	public function add_admin_perfumeria()
    {
		$this->viewBuilder()->layout('admin');
		$this->set('titulo','Perfumeria');
        $oferta = $this->Ofertas->newEntity();
        if ($this->request->is('post')) {
            $oferta = $this->Ofertas->patchEntity($oferta, $this->request->data);
			$fechadesde = Time::createFromFormat('d/m/Y',$this->request->data['fecha_desde'],'America/Argentina/Buenos_Aires');
			$fechadesde->i18nFormat('yyyy-MM-dd');
			$fechahasta = Time::createFromFormat('d/m/Y',$this->request->data['fecha_hasta'],'America/Argentina/Buenos_Aires');
			$fechahasta->i18nFormat('yyyy-MM-dd');
			
			$oferta['fecha_desde'] = $fechadesde;
			$oferta['fecha_hasta'] = $fechahasta;
			$uploadData = '';
			if(!empty($this->request->data['file']['name'])){
                $fileName = $this->request->data['file']['name'];
				
				$uploadPath = 'img/';
				switch ($this->request->data['oferta_tipo_id']) {
							case 1:
								$uploadPath = $uploadPath.'selectivas/' ;
								break;
							case 2:
								$uploadPath = $uploadPath.'semiselectivas/' ;
								break;
							case 3:
								$uploadPath = $uploadPath.'perfumerias/' ;
								break;
							case 4:
								$uploadPath = $uploadPath.'cosmeticas/' ;
								break;
							case 5:
								$uploadPath = $uploadPath.'especiales/' ;
								break;
								
								default:
									$uploadPath = $uploadPath.'ofertas/';
								   
						}
				
				
              
                $uploadFile = $uploadPath.$fileName;
				$oferta['imagen']= $fileName;
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

            if ($this->Ofertas->save($oferta)) {

                $this->Flash->success(__('La oferta fue cargada correctamente'),['key' => 'changepass']);
                return $this->redirect(['action' => 'index_admin']);
            } else {
				$this->Flash->error(__('No se pudo cargar la oferta, intente nuevamente'),['key' => 'changepass']);
                $this->redirect($this->referer());	
            }
        }
		$this->loadModel('OfertasTipos');
        $OfertasTipos =  $this->OfertasTipos->find('list', ['keyField' => 'id','valueField' => 'nombre']);
		$this->set('ofertastipos',$OfertasTipos ->toArray());
        $this->set(compact('oferta','ofertastipos'));
        $this->set('_serialize', ['oferta']);
    }
  

  
    /**
     * Edit method
     *
     * @param string|null $id Oferta id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit_admin($id = null)
    {
		$this->viewBuilder()->layout('admin');
        $oferta = $this->Ofertas->get($id, [
            'contain' => []
        ]);
		$this->loadModel('Laboratorios');
		$laboratorios =$this->Laboratorios->find('list',['keyField' => 'id','valueField'=>'nombre'])
										->order(['nombre' => 'ASC']);	
		$this->set(compact('laboratorios'));
		$this->loadModel('Marcas');
		$marcas =$this->Marcas->find('list',['keyField' => 'id','valueField'=>'nombre'])
										->order(['nombre' => 'ASC']);	
		$this->set(compact('marcas'));
		if ($this->request->is(['patch', 'post', 'put'])) {
            $oferta = $this->Ofertas->patchEntity($oferta, $this->request->data);
            $fechadesde = Time::createFromFormat('d/m/Y',$this->request->data['fecha_desde'],'America/Argentina/Buenos_Aires');
			$fechadesde->i18nFormat('yyyy-MM-dd');
			$fechahasta = Time::createFromFormat('d/m/Y',$this->request->data['fecha_hasta'],'America/Argentina/Buenos_Aires');
			$fechahasta->i18nFormat('yyyy-MM-dd');
		
			
			$oferta['fecha_desde'] = $fechadesde;
			$oferta['fecha_hasta'] = $fechahasta;
			
			
			$uploadData = '';
			if(!empty($this->request->data['file']['name'])){
                $fileName = $this->request->data['file']['name'];
                $uploadPath = 'img/';
				switch ($this->request->data['oferta_tipo_id']) {
							case 1:
								$uploadPath = $uploadPath.'ofertas/' ;
								break;
							case 2:
								$uploadPath = $uploadPath.'ofertas/' ;
								break;
							case 3:
								$uploadPath = $uploadPath.'ofertas/' ;
								break;
							case 4:
								$uploadPath = $uploadPath.'ofertas/' ;
								break;
							case 5:
								$uploadPath = $uploadPath.'ofertas/' ;
								break;
							case 6:
								 $uploadPath = $uploadPath.'ofertas/';
								break;
							case 7:
								 $uploadPath = $uploadPath.'ofertas/';
								break;
								case 11:
								 $uploadPath = $uploadPath.'ofertas/';
								break;
								default:
								$uploadPath = $uploadPath.'ofertas/';
								
						}
						
                $uploadFile = $uploadPath.$fileName;
				$oferta['imagen']= $fileName;
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
                    $this->Flash->error(__('Unable to upload file, please try again 2. '.$fileName.' '.$uploadPath),['key' => 'changepass']);
					$this->redirect($this->referer());
                }
            }
			
			if ($this->Ofertas->save($oferta)) {
                
				$this->Flash->success('La oferta se guardo correctamente.',['key' => 'changepass']);
                return $this->redirect(['action' => 'index_admin']);
            } else {
                $this->Flash->error('La oferta no se guardo.',['key' => 'changepass']);
            }
        }
		$this->loadModel('OfertasTipos');
		$ofertatipo = $this->OfertasTipos->find('list',['keyField' => 'id','valueField'=>'nombre']);
		$this->set('ofertastipos',$ofertatipo->toArray());
		
        $articulos = $this->Ofertas->Articulos->find('list', ['limit' => 200]);
        $this->set(compact('oferta', 'articulos'));
        $this->set('_serialize', ['oferta']);
		$this->set('titulo','Modificar Oferta');
    }

    /**
     * Delete method
     *
     * @param string|null $id Oferta id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */

    public function delete_admin($id = null)
    {
		$this->viewBuilder()->layout('admin');
		$id = $this->request->getData('id');
		$this->request->allowMethod(['post', 'get', 'delete', 'ajax']);
		$oferta = $this->Ofertas->get($id);
		if (!empty($oferta)) {

			
			if ($this->Ofertas->delete($oferta)) {
				$responseData = ['success' => true, 'responseText' => "eliminado", 'status' => 200];

				$this->response->body(json_encode($responseData));
				

				return $this->response;

				// $this->Flash->success('Se elimino correctamente del carro.',['key' => 'changepass']);
			}
			 else {
				$this->Flash->error('No se pudo eliminar, intente nuevamente', ['key' => 'changepass']);
			}
    }
	}

	
	public function otros_admin()
    {
		$this->viewBuilder()->layout('admin');

		$this->loadModel('OfertasTipos');
		$OfertasTipos =  $this->OfertasTipos->find('list', ['keyField' => 'id','valueField' => 'nombre']);
		$this->set('ofertastipos',$OfertasTipos ->toArray());
		$this->set('titulo','Otras Opciones de Ofertas');
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
		
		$this->viewBuilder()->layout('admin');
		//,'Carritos'
        $this->paginate = [		
		'contain' => ['Descuentos'],
		'limit' => 5,
		'offset' => 0, 
        'order' => ['Articulos.descripcion_pag' => 'asc']];
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
						'd.fecha_hasta >=' => 'CURRENT_DATE',
						'd.tipo_oferta in ("RV","RR","OR","TD","RL")'
						]		
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
					['d.tipo_oferta'=>"RV"],
					['d.tipo_oferta'=>"RL"]	],
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
					['d.tipo_oferta'=>"RL"]						
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
	
}
