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
class ComunidadSurController extends AppController
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
					
						$tiene= $this->tienepermiso('comunidad',$this->request->action);
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
	

/*	 
	public function index()
    {
		if ($this->request->is('post'))
		{	
			if ($this->request->data['laboratorio_id']!= null)
				$laboratorioid = $this->request->data['laboratorio_id'];
			else
				$laboratorioid =0;
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
				$termsearch ="";
			$this->request->session()->write('termsearchpt',$termsearch);
			$this->request->session()->write('laboratorioid',$laboratorioid);
		}
		else 
		{
		    $laboratorioid = $this->request->session()->read('laboratorioid');
			$termsearch = $this->request->session()->read('termsearchpt');
		}
		
		$this->categoriaylaboratorio();
		$this->clientecredito();
		$this->sumacarrito();	
				
		if ($termsearch!="")
			{
				//$this->CargarCarritoCB($termsearch);
			}		
		$this->viewBuilder()->layout('store');
       
		$this->loadModel('Articulos');
		$this->loadModel('Carritos');
		
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
						'd.tipo_oferta in ("RV","RR","OR","TD","RL","SS","FR")'
						]
					]
					)
					->where(['Articulos.eliminado'=>0]);
					
		if ($termsearch!="")
		{
			$articulosA->andWhere([
					
					'OR' => [['Articulos.descripcion_pag LIKE'=>$termsearch], 
					['Articulos.troquel LIKE'=>$termsearch],['Articulos.codigo_barras LIKE'=>$termsearch],['Articulos.codigo_barras2 LIKE'=>$termsearch]],
				]);
		}
		if ($laboratorioid !=0)
				$articulosA->andWhere(['Articulos.laboratorio_id'=>$laboratorioid]);
	

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
			//'order' => ['Articulos.descripcion_pag' => 'asc']
			$articulosA->andWhere(['Articulos.eliminado'=>0])->group(['Articulos.id'])
						->order(['Laboratorios.nombre'=>'asc','d.tipo_precio'=>'asc','Articulos.descripcion_pag' => 'asc']);
			$articulos = $this->paginate($articulosA);
		}
		else
			$articulos = null;
		
		$this->set(compact('articulos'));
		
		$this->set('_serialize', ['articulos']);	
    }
*/
	public function index()
    {
		
		//$this->request->session()->write('marcaid',0);
		$this->request->session()->write('termsearch2',"");
		$this->request->session()->write('marcaid',0);		
		$this->loadModel('Marcas');
		//$this->loadModel('Generos');
		
		$marcas = $this->Marcas->find('list', ['keyField' => 'id','valueField' => 'nombre'])->where(['marcas_tipos_id'=>5])->order(['nombre' => 'ASC']);
        //$generos = $this->Generos->find('list', ['keyField' => 'id','valueField' => 'nombre']);
		$marcas->toArray();
		//$generos->toArray();
		$this->set(compact('marcas'));
		
		$this->viewBuilder()->layout('store');
        $this->paginate = ['limit' => 5];
		
		$this->clientecredito();
		$this->sumacarrito();
			
		$this->loadModel('Incorporations');
		$incorporationsA = $this->Incorporations->find('all');
		$incorporationsA->where(['habilitada'=>1,'incorporations_tipos_id '=>10])->limit([5])->order(['id' => 'DESC']);
		$incorporations = $this->paginate($incorporationsA);
        $this->set('incorporations', $incorporations);

		$marcas2 = $this->Marcas->find('all')->where(['marcas_tipos_id'=>10])->order(['nombre'=>'ASC']);
		$marcas2->toArray();
		
		$this->set(compact('marcas2'));

		$this->loadModel('Publications');
		$publications = $this->Publications->find('all')->where(['fecha_hasta >=CURRENT_DATE()','habilitada' =>'1','ubicacion'=>'11'])->order(['id' => 'DESC'])->all();
		$this->set('publications_partner',$publications->toArray());
		
		$this->request->session()->write('publications_nutricion',$publications->toArray());
	  //$this->Flash->warning('Nos encontramos actualizado la seccion, intente mas tarde',['key' => 'changepass']);     
       //$this->redirect($this->referer());
	}
	
	public function search($marcaid =null, $generoid=null)
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
		
		$marcas = $this->Marcas->find('list', ['keyField' => 'id','valueField' => 'nombre'])->where(['marcas_tipos_id'=>5])->order(['nombre' => 'ASC']);
		$marcas->toArray();
		$this->set(compact('marcas'));
		
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
				if ($marcaid !=0)
				{
						  $articulosA->where(['Articulos.marca_id'=>$marcaid]);
				}
	
		 
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
