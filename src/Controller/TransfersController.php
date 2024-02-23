<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\I18n\Time;
use Cake\Database\Connection;
use Cake\Datasource\ConnectionManager;

use Cake\Filesystem\File;
use Cake\Network\Request;
use Cake\Database\Expression\QueryExpression;
use Cake\ORM\TableRegistry;
/*use PhpOffice\PhpSpreadsheet\IOFactory;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Helper;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
require ROOT.DS.'vendor' .DS. 'phpoffice/phpspreadsheet/src/Bootstrap.php';*/

/**
 * Preventas Controller
 *
 * @property \App\Model\Table\PreventasTable $Preventas
 *
 * @method \App\Model\Entity\Preventa[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 *//*
 class MyReadFilter implements \PhpOffice\PhpSpreadsheet\Reader\IReadFilter
{
    private $startRow = 0;
    private $endRow   = 0;
    private $columns  = [];

	
	public function isAuthorized()
    {
           if (in_array($this->request->action, ['readCell'])) {
                return true;			
			}
			else
			{
				$this->Flash->error(__('No tiene permisos para ingresar'),['key' => 'changepass']);
				$this->redirect($this->referer());
				return false;	
			}
				
		return parent::isAuthorized($user);
    }
	
    /**  Get the list of rows and columns to read  
    public function __construct($startRow, $endRow, $columns) {
        $this->startRow = $startRow;
        $this->endRow   = $endRow;
        $this->columns  = $columns;
    }

    public function readCell($column, $row, $worksheetName = '') {
        //  Only read the rows and columns that were configured
        if ($row >= $this->startRow && $row <= $this->endRow) {
            if (in_array($column,$this->columns)) {
                return true;
            }
        }
        return false;
    }
} */

 
class TransfersController extends AppController
{
	public function isAuthorized()
    {
        if (in_array($this->request->action, ['index','view','import','importresult','add','add_transfer','carritoaddall','vaciar','confirm','confirm_transfer','realizados','view','vaciar_import', 'import_confirm','change_password','delete','delete_transfer','exceldetalle','excelresumen'])) {
       
            if($this->request->session()->read('Auth.User.role')=='provider') 	
                return true;			
            else 
				$this->Flash->error(__('No tiene permisos para ingresar'),['key' => 'changepass']);
				$this->redirect($this->referer());
				return false;
				
			}
			else
			{
				
							$this->Flash->error(__('No tiene permisos para ingresar'),['key' => 'changepass']);
							$this->redirect($this->referer());
							return false;	
							
						
			}
				
		return parent::isAuthorized($user);
    }

	public function initialize(){
        parent::initialize();
        
        // Include the FlashComponent
        $this->loadComponent('Flash');
        // Load Files model
        $this->loadModel('Files');
    }

	
	public function change_password()
    {
		
		$this->viewBuilder()->layout('preventa');
		$this->loadModel('Users');
		$this->loadModel('Clientes');
		$cliente = $this->Clientes->get($this->request->session()->read('Auth.User.cliente_id'), [
            'contain' => ['Provincias','Localidads']
        ]);
        /*$user = $this->Users->get($this->request->session()->read('Auth.User.id'), [
            'contain' => ['clientes']
        ]);*/
		$this->set(compact('cliente'));
        if ($this->request->is(['patch', 'post', 'put'])) {
            //Se verifican 2 cosas: 
            //  1º Si la clave actual proporcionada coincide con la del usuario registrado 	
            //  2º Si la clave nueva coincide con la confirmación				
            if (empty($this->request->data['current_password']) &&
                empty($this->request->data['password']) && 	
                empty($this->request->data['confirm_new_password'])) 
            {
                 $this->Flash->error('Ingrese los campos correctamente',['key' => 'changepass']);  //,['key' => 'changepass']
            }
            else
            {
            //paso 1    
				//$user = $this->Users->patchEntity($user, $this->request->data);
				$user = $this->Auth->identify();
				if ($user) 
                {
                    // paso 2
                    if  ($this->request->data['current_password'] == $this->request->data['confirm_new_password']) 
                    {
						    $user2 = $this->Users->get($this->request->session()->read('Auth.User.id'));
						    $user2 = $this->Users->patchEntity($user2, $this->request->data);
							$user2['password']=$this->request->data['current_password'];
 						    if ($this->Users->save($user2)) {
								$this->Flash->success('El usuario se modifico.',['key' => 'changepass']);
								return $this->redirect(['controller'=>'Transfers','action' => 'index']);
							} else {
								$this->Flash->error('El usuario no se guardo. Por favor pruebe nuevamente.',['key' => 'changepass']);//,['key' => 'changepass']
							}
                    }
                    
                     else
                     {
                          $this->Flash->error('Las contraseñas no son iguales, vuelva a escribirlas',['key' => 'changepass']);
                          //$this->Session->setFlash(__('<div class="success canhide">El usuario fue guardado correctamente.</div>', true));
                     }
                }
                else
                {
                    $this->Flash->error('La contraseña actual no es correcta, vuelva a intentar',['key' => 'changepass']);    
                }
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
		//$this->set('titulo','Editar Usuario');
    }
  
	
	public function categoriaylaboratorio()
	{
		if (empty($this->request->session()->read('Categorias')))
		{
		$this->loadModel('Categorias');
		$this->loadModel('Laboratorios');
		$categorias = $this->Categorias->find('list',['keyField' => 'id','valueField'=>'nombre']);
		//$laboratorios = $this->Laboratorios->find('list',['keyField' => 'id','valueField'=>'nombre'])->order(['nombre' => 'ASC']);
		$laboratorios = $this->Laboratorios->find('list',['keyField' => 'id','valueField'=>'nombre'])->andWhere(['expo'=>1])->order(['nombre' => 'ASC']);

		$this->request->session()->write('Categorias',$categorias->toArray());
		$this->request->session()->write('Laboratorios2',$laboratorios ->toArray());
			
		}
		else{
			
			
			$this->loadModel('Laboratorios');
			$laboratorios = $this->Laboratorios->find('list',['keyField' => 'id','valueField'=>'nombre'])->andWhere(['expo'=>1])->order(['nombre' => 'ASC']);
			$this->request->session()->write('Laboratorios2',$laboratorios ->toArray());
			
			$laboratorios =$this->request->session()->read('Laboratorios2');
			$categorias = $this->request->session()->read('Categorias');
		}	
		$this->set('categorias',$categorias );
		$this->set('laboratorios',$laboratorios);
		
	}
	
	public function listadocategoria()
	{
		if (empty($this->request->session()->read('Categorias')))
		{
		$this->loadModel('Categorias');
		
		$categorias = $this->Categorias->find('list',['keyField' => 'id','valueField'=>'nombre']);
		//$laboratorios = $this->Laboratorios->find('list',['keyField' => 'id','valueField'=>'nombre'])->order(['nombre' => 'ASC']);
		
		$this->request->session()->write('Categorias',$categorias->toArray());
		$categorias = $this->request->session()->read('Categorias');
		}
		else{
			
			$this->loadModel('Categorias');
		
		$categorias = $this->Categorias->find('list',['keyField' => 'id','valueField'=>'nombre']);
		//$laboratorios = $this->Laboratorios->find('list',['keyField' => 'id','valueField'=>'nombre'])->order(['nombre' => 'ASC']);
		
		$this->request->session()->write('Categorias',$categorias->toArray());
		$categorias = $this->request->session()->read('Categorias');
			
		}	
		$this->set('categorias',$categorias);
	
		
	}
	 
	public function import()
    {
		$this->viewBuilder()->layout('preventa');
	
	} 
	
	public function import_confirm()
    {
		$this->viewBuilder()->layout('preventa');
		$conn = ConnectionManager::get('default');
			
			//$cliente_id=$this->request->session()->read('cliente_id');
			$proveedor_id = $this->request->session()->read('Auth.User.proveedor_id');
			 
			$conn->query('UPDATE preventas SET chequeo =0 WHERE proveedor_id = '.$proveedor_id.';');
			//$conn->query('CALL actualizarcarritosindescuento('.$cliente_id.');');
							
			$this->Flash->warning(__(' Se Importo correctamente.'),['key' => 'changepass']);
			return $this->redirect(['controller'=>'Transfers','action' => 'index']);
	
	} 

	public function guardarcarritotemp($temp = null)
	{
				
				$this->loadModel('Preventas');
		
				$tablaped =$this->request->session()->read('tablaped');
				
				
				$preventa = $this->Preventas->newEntity();
				//$preventa['cliente_id']=$this->request->session()->read('Auth.User.cliente_id');
				$preventa['creado']=date('Y-m-d H:i:s');
				
				if (array_key_exists($temp['codigo_barras'], $tablaped)) 
				{
					$preventa['dto_drogueria'] = $tablaped[$temp['codigo_barras']][0];
					$preventa['plazo'] = $tablaped[$temp['codigo_barras']][1];
					$preventa['uni_min'] = $tablaped[$temp['codigo_barras']][2];
					$preventa['combo'] = $tablaped[$temp['codigo_barras']][5];
				}
				if (array_key_exists($temp['codigo_barras2'], $tablaped)) 
				{
					$preventa['dto_drogueria'] = $tablaped[$temp['codigo_barras2']][0];
					$preventa['plazo'] = $tablaped[$temp['codigo_barras2']][1];
					$preventa['uni_min'] = $tablaped[$temp['codigo_barras2']][2];
					$preventa['combo'] = $tablaped[$temp['codigo_barras2']][5];
				}
				if (array_key_exists($temp['codigo_barras3'], $tablaped)) 
				{
					$preventa['dto_drogueria'] = $tablaped[$temp['codigo_barras3']][0];
					$preventa['plazo'] = $tablaped[$temp['codigo_barras3']][1];
					$preventa['uni_min'] = $tablaped[$temp['codigo_barras3']][2];
					$preventa['combo'] = $tablaped[$temp['codigo_barras3']][5];
				}	
				if (array_key_exists($temp['c_barra'], $tablaped)) 
				{
					$preventa['dto_drogueria'] = $tablaped[$temp['c_barra']][0];
					$preventa['plazo'] = $tablaped[$temp['c_barra']][1];
					$preventa['uni_min'] = $tablaped[$temp['c_barra']][2];
					$preventa['combo'] = $tablaped[$temp['c_barra']][5];
					//$preventa['dto_drogueria'] = $tablaped[$temp['codigo_barras3']][3];
				}	
				
				$preventa['articulo_id'] = $temp['id'];		
				$preventa['tipo_venta'] = "D"; 	
				$preventa['uni_max'] = null; 	
				$preventa['uni_tope'] = null; 	
				$preventa['tipo_oferta'] = "ES"; 	
				$preventa['tipo_precio'] = "F"; 
				$preventa['chequeo']=1;
				$preventa['proveedor_id']=$this->request->session()->read('Auth.User.proveedor_id');
				
				$insertar = $this->Preventas->find()->where(['articulo_id' => $temp['id']]);
				
				$insertar = $insertar->first();
				if ($insertar ==null)
				{
													
				if ($this->Preventas->save($preventa))
				{
					
					//$this->redirect($this->referer());
				}
				else
				{
					
					//$this->redirect($this->referer());
				}
				}
				else
				{
					
					
						$preventa['id'] = $insertar['id'];
						if ($this->Preventas->save($preventa)) {
							

							
						}
						else
						$this->Flash->error(__('The preventa could not be saved. Please, try again.'));
					
					
					
				}
				
			
	}
	
	/*public function importresult()
	{
		$this->viewBuilder()->layout('preventa');
		$this->loadModel('Articulos');$this->loadModel('Preventas');
		$this->paginate = [ 'contain' => ['Preventas'],'limit' => 80];
							 //'order' => ['Articulos.descripcion_pag' => 'asc']];
		if ($this->request->is('post'))
		{
			if  (!empty($this->request->data['filetext']))
			{	
				$file = $this->request->data['filetext'];
				$fini = $this->request->data['fini']; // fila inicio
				$fend = $this->request->data['fend']; // fila ultima
				$nsheet= $this->request->data['nsheet']; // nombre de la hoja.
				$cean = $this->request->data['cean']; // Columna EAN
				$cdto = $this->request->data['cdto']; // Columna Descuento
				$cdesc= $this->request->data['cdesc']; // Columna Descripcion
				$cplazo=$this->request->data['cplazo']; // Columna plazo
				$cumin =$this->request->data['cumin']; // Columna Descuento 
				$ccomb = $this->request->data['ccomb'];
				
                $uploadPath = 'temp/excel/';
                $uploadFile = $uploadPath.$this->request->data['filetext']['name'];
				
                move_uploaded_file($this->request->data['filetext']['tmp_name'],$uploadFile);
					
				$filterSubset = new MyReadFilter($fini, $fend, ['A','B','C','D','E','H']);//range($cean, $cumin));
				
				$filename = $uploadFile;
				$info = pathinfo($filename, PATHINFO_EXTENSION);
				$this->request->session()->write('info',$info);	
				//$helper->log('Loading file ' . pathinfo($inputFileName, PATHINFO_BASENAME) . ' using IOFactory with a defined reader type of ' . $inputFileType);
				//$info = new SplFileInfo($uploadFile);
				if ($info=="xls")
					$reader = IOFactory::createReader('Xls');
				else
				if ($info=="xlsx")
				{
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
					//$spreadsheet = $reader->load("05featuredemo.xlsx");
				//$reader = IOFactory::createReader('Xlsx');
				}
				
				else
				{
					$this->Flash->error('No es un archivo excel',['key' => 'changepass']);
							return $this->redirect($this->referer());
				}
				//$helper->log('Loading Sheet "' . $sheetname . '" only');
				$reader->setLoadSheetsOnly($nsheet);
				//$helper->log('Loading Sheet using configurable filter');
				//$reader->setReadFilter($filterSubset);
				$spreadsheet = $reader->load($uploadFile);
				$rango = $cean.$fini.":".$cplazo.$fend;
				//$this->request->session()->write('ImportadoFILT',$spreadsheet);
				$dataArray = $spreadsheet->getActiveSheet()
					->rangeToArray(
						$rango,     // The worksheet range that we want to retrieve
						NULL,        // Value that should be returned for empty cells
						TRUE,        // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
						TRUE,        // Should values be formatted (the equivalent of getFormattedValue() for each cell)
						TRUE         // Should the array be indexed by cell row and cell column
					);
				$this->request->session()->write('ImportadoA',$dataArray);
				
				$sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
				$this->request->session()->write('Importado',$sheetData);
				//var_dump($sheetData);	
					
					
				$tablaped =array();
				$listaarray=array();
				foreach ($dataArray  as $row) {
					 $codbar = $row[$cean];
					 $combo = $row[$ccomb];
					 $codbar = trim($codbar,' ');
					 $codbar = ltrim($codbar, '0'); 
					 
					 $descuento =  $row[$cdto];
					 $descripcion = $row[$cdesc];
					 $plazo = $row[$cplazo];
					 if ($plazo == null)
							$plazo = 'Habitual';
					 $uni_min = $row[$cumin]; 
					  if ($uni_min == null)
						  $uni_min =1;
					 if ($codbar != '' && $codbar != null) {
						array_push($listaarray,$codbar);
						$tablaped[$codbar] = [$descuento,$plazo,$uni_min,$descripcion,$codbar,$combo];
						
					 }
				}
				
				$this->request->session()->write('listaarray',$listaarray);
				$this->request->session()->write('tablaped',$tablaped);	
				
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
			//$campotob = $this->request->session()->read('campotob');
		}
		if ($this->request->is('post'))
		{
			
			$noimportados =array();
			$error="";
			
			$rowarticulos = $this->Articulos->find('all')
						->where(['Articulos.categoria_id <'=>7])
						->where(['Articulos.eliminado'=>0])
						->where(['Articulos.codigo_barras in'=>$listaarray])
						->orWhere(['Articulos.codigo_barras2 in'=>$listaarray])
						->orWhere(['Articulos.codigo_barras3 in'=>$listaarray])
						->orWhere(['Articulos.c_barra in'=>$listaarray])
						->where(['Articulos.eliminado'=>0]);
				$this->request->session()->write('rowarticulos',$rowarticulos->toArray());				
				
			foreach ($rowarticulos as $row)
			{
				$this->guardarcarritotemp($row->toArray());
				
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
					$error .='<tr><td>' .($insertrow[4]). '</td>' .
									  
									  '<td>'.$insertrow[3].'</td>' .
									  '<td>'.$insertrow[0].'</td>' .
									  '<td>'.$insertrow[1].'</td>' .
									  '<td>'.$insertrow[2].'</td>' .
									  
									  '</tr>';

									  
									  
				
			
										//mb_internal_encoding("UTF-8");
					//$codbar = mb_substr($line,$codbardde,$codbarlong);
					//$cantidad = mb_substr($line,$cantidaddde,$cantidadlong);
									  
					$noimportodolinea[0] =  $insertrow[0];
					$noimportodolinea[2] =  $insertrow[1];
					$noimportodolinea[3] = 	$insertrow[2];	
					$noimportodolinea[1] =  $insertrow[3];					
								 
					array_push($noimportados,$noimportodolinea);
			}
			
			$this->request->session()->write('noimportados',$noimportados);	
			$this->request->session()->write('errorimport',$error);	
			
		}
		else
		{
			//$error = $this->request->session()->read('errorimport');			
		}	
		
		$articulosA = $this->Articulos->find('all')
					->contain (['Preventas'
					
					
					])/* => [
						
						'queryBuilder' => function ($q) {
							return $q->where(['Articulos.id' => 'Preventas.articulo_id']); // Full conditions for filtering
						}
					]
				])
					->hydrate(false)
					->join([
						'table' => 'preventas',
						'alias' => 'pv',
						'type' => 'inner',
						
						'conditions' => ['pv.articulo_id = Articulos.id'
						
						]
					])	
					->where(['Articulos.eliminado'=>0, 'Articulos.proveedor_id' =>$this->request->session()->read('Auth.User.proveedor_id')]);
												
					
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
		
	
	}
*/
	public function vaciar_import()
    {
        if ($this->deleteCarritoTemp()) {
            $this->Flash->success('El listado de articulo a importar fue vaciado.',['key' => 'changepass']);
			$this->redirect($this->referer());
        } else {
            $this->Flash->error('El listado no pudo ser vaciado. Intente de nuevo.',['key' => 'changepass']);
			$this->redirect($this->referer());
        }  
    }	
	
	public function index()
    {
		$this->loadModel('PedidosPreventas');
		$this->viewBuilder()->layout('preventa');
        $this->paginate = [
            'contain' => ['Clientes']
        ];
		
		
		
		
		$pedidos = $this->PedidosPreventas->find('all')
					->contain(['Clientes'])
					->where(['proveedor_id'=>$this->request->session()->read('Auth.User.proveedor_id')]);

        $pedidosPreventas = $this->paginate($pedidos);

        $this->set(compact('pedidosPreventas'));	
    }

	public function view($id = null)
	{
		$this->viewBuilder()->layout('preventa');
       
        if ($this->request->is('post')) {
				
			
        }
		$this->loadModel('PedidosPreventas');
		$pedido = $this->PedidosPreventas->find('all')
		->contain(['Clientes'=> [
						
						'queryBuilder' => function ($q) {
							return $q->where(['cliente_id = Clientes.id ']); // Full conditions for filtering
						}
					]])
				->where(['PedidosPreventas.id' => $id	])->first([]);
			
			
		
		$cliente = $pedido['cliente'];	
			$this->set('cliente',$cliente);
		
		$this->loadModel('PedidosPreventasItems');
		
	        
		$articulosA = $this->PedidosPreventasItems->find('all')
									
				->contain(['PedidosPreventas','PedidosPreventas.Clientes'=> [
						
						'queryBuilder' => function ($q) {
							return $q->where(['PedidosPreventas.cliente_id = Clientes.id ']); // Full conditions for filtering
						}
					],			
				'Articulos.Laboratorios','Articulos' => [
						
						'queryBuilder' => function ($q) {
							return $q->where(['Articulos.id = articulo_id']); // Full conditions for filtering
						}
					]
				])
				/*->join([
						'table' => 'pedidos_preventas',
						'alias' => 'pv',
						'type' => 'INNER',
						'conditions' => [
						
						'pv.cliente_id' => $this->request->session()->read('cliente_id')
						]
						])*/
				/*->join([
						'table' => 'articulos',
						'alias' => 'a',
						'type' => 'INNER',
						'conditions' => [
						'PedidosPreventasItems.articulo_id = a.id',
						'PedidosPreventasItems.pedidos_preventa_id = pv.id',
						
						]
						
					])	*/
					/*
					//->hydrate(false)
					/*->join([
						'table' => 'preventas',
						'alias' => 'pv',
						'type' => 'inner',
						'conditions' => ['pv.articulo_id = Articulos.id']
					])	*/
					
					
					->where([
					'pedidos_preventa_id' => $id,
					'Articulos.eliminado'=>0,'PedidosPreventas.proveedor_id'=>$this->request->session()->read('Auth.User.proveedor_id')]);
		

		
		if (!empty($articulosA))
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
			//'order' => ['Articulos.descripcion_pag' => 'asc']andWhere(['Articulos.eliminado'=>0])-
			$articulosA->group(['Articulos.id'])
					   ->order(['Laboratorios.nombre'=>'asc','Articulos.descripcion_pag' => 'asc']);
			$articulos = $this->paginate($articulosA);
		}
		else
			$articulos = null;
		
	
		
		$this->listadocategoria();
		
        $this->set(compact('articulos'));
		
	}

	public function add_transfer()
    {
		
		$this->viewBuilder()->layout('preventa');
       
        if ($this->request->is('post')) {
			
			
        }
		
		$cliente = $this->request->session()->read('cliente');	
		$this->request->session()->write('cliente_id',$cliente['id']);	
		
		$this->set('cliente',$cliente);
		
		
		$this->loadModel('Articulos');
		$this->loadModel('Preventas');
		if ($this->request->session()->read('Auth.User.proveedor_id')!=524) 
		{
		$articulosA = $this->Articulos->find('all')
									
				->contain(['Laboratorios','Preventas','CarritosPreventas' => [
						
						'queryBuilder' => function ($q) {
							return $q->where(['cliente_id' => $this->request->session()->read('cliente_id')]); // Full conditions for filtering
						}
					]
				])
				/*->join([
						'table' => 'carritos_preventas',
						'alias' => 'c',
						'type' => 'inner',
						'conditions' => ['c.cliente_id' => $cliente['id']]
					])	*/
					
					//->hydrate(false)
					->join([
						'table' => 'preventas',
						'alias' => 'pv',
						'type' => 'inner',
						'conditions' => ['pv.articulo_id = Articulos.id']
					])	
					->where(['Articulos.eliminado'=>0,'pv.proveedor_id'=>$this->request->session()->read('Auth.User.proveedor_id')]);
		}
		else
		{
			$articulosA = $this->Articulos->find('all')
									
				->contain(['Laboratorios','Preventas','CarritosPreventas' => [
						
						'queryBuilder' => function ($q) {
							return $q->where(['cliente_id' => $this->request->session()->read('cliente_id')]); // Full conditions for filtering
						}
					]
				])
				
					->join([
						'table' => 'preventas',
						'alias' => 'pv',
						'type' => 'inner',
						'conditions' => ['pv.articulo_id = Articulos.id']
					])	
					->where(['pv.proveedor_id'=>$this->request->session()->read('Auth.User.proveedor_id')]);
		}	

		if (!empty($articulosA))
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
			//'order' => ['Articulos.descripcion_pag' => 'asc']andWhere(['Articulos.eliminado'=>0])-
			$articulosA->group(['Articulos.id'])
						->order(['pv.combo'=>'asc','Articulos.descripcion_pag' => 'asc']);
			$articulos = $this->paginate($articulosA);
		}
		else
			$articulos = null;
		
	
		
		$this->listadocategoria();
		
        $this->set(compact('articulos'));
    }
 
	public function carritoaddall($control = null)
    {
		$this->loadModel('CarritosPreventas');
		
		$carritos = TableRegistry::get('CarritosPreventas');
		$entities = $carritos->newEntities($this->request->data());
		$this->set('carritos2', $this->request->data);
		$this->loadModel('Articulos');
		
		foreach ($entities as $carrito) {
		$carrito['cliente_id'] = $this->request->session()->read('cliente_id');

		if ($carrito['cantidad']!='')
		{
			$articulo = $this->Articulos->find()
								->where(['id' =>  $carrito['articulo_id']])
								->first();
								
		if (((int)$carrito['cantidad']>0) && ((int)$carrito['cantidad']<1000))			
			{
			
			$carrito['categoria_id'] = $articulo['categoria_id'];	
			$carrito['descripcion'] = $articulo['descripcion_sist'];
			
			if ((int)$carrito['cantidad']<(int)$carrito['unidad_minima'])
				$carrito['cantidad'] = $carrito['unidad_minima'];
			
			if ((int)$carrito['categoria_id']==7) 
			{
				
				$this->Flash->error('No se puede agregar este producto al carro de compras. ',['key' => 'changepass']);
				//return $this->redirect($this->referer());
			}
			else
			{
			$carritocon2 = $this->CarritosPreventas->find()
								->where(['cliente_id' => $carrito['cliente_id']])
								->where(['articulo_id' =>  $carrito['articulo_id']]);
		    if($carritocon2->count()==0)
			{
				// Inserto Registro al carrito
				// asigno tipo de facturacion.
				/*
				if ((int)$carrito['cantidad'] <(int)$articulo['compra_min'])
					{
						$this->Flash->error('No se agrego '.$carrito['descripcion']. ' al carro de compras, la cantidad tiene minima de venta es de '.$carrito['compra_min'] ,['key' => 'changepass']);	
						return $this->redirect($this->referer());
					}*/
				$carrito['creado'] = date('Y-m-d H:i:s');
							
				if ($carrito['tipo_precio']=='P' && ($carrito['tipo_oferta']=='TD' || $carrito['tipo_oferta']=='TL' || $carrito['tipo_oferta']=='OR' || $carrito['tipo_oferta']=='OD')) 
                        $carrito['tipo_fact']= 'TR';
					else
						if ($carrito['tipo_precio']=='F' && ($carrito['tipo_oferta']=='TD' || $carrito['tipo_oferta']=='TL' || $carrito['tipo_oferta']=='OR' || $carrito['tipo_oferta']=='OD')) 
							$carrito['tipo_fact']= 'TL';
						else 
							$carrito['tipo_fact']= 'N';
				$cantidad = $carrito['cantidad'];
				
				if ($this->CarritosPreventas->save($carrito))
				{
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
				endforeach; 
				$carrito = $this->CarritosPreventas->get($id, ['contain' => []]);
				
				$carrito['cantidad']=$cant;	/*
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
				*/
				$cantidad = $carrito['cantidad'];
				
				if ($this->CarritosPreventas->save($carrito)) {
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
				$carritos =$this->CarritosPreventas->find('all')
								->where(['cliente_id' => $carrito['cliente_id']])
								->where(['articulo_id' =>  $carrito['articulo_id']])
								->first();
				if ($carritos !=null)
				{	
					if ($this->CarritosPreventas->delete($carritos)) 
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
				$carritos =$this->CarritosPreventas->find('all')
								->where(['cliente_id' => $carrito['cliente_id']])
								->where(['articulo_id' =>  $carrito['articulo_id']])
								->first();
				if ($carritos !=null)
				{	
						if ($this->CarritosPreventas->delete($carritos)) 
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

    public function add()
    {
		
		$this->viewBuilder()->layout('preventa');
        $this->loadModel('Clientes');
        if ($this->request->is('post')) {
			$termsearch ="";
			if ($this->request->data['codigo']!= null)
			{
				$terminocompleto = explode(" ", $this->request->data['codigo']);
				
				if (count($terminocompleto)>1)
				{
						foreach ($terminocompleto as $terminosimple): 
							$termsearch = $termsearch.'%'.$terminosimple.'%';
						endforeach; 
				}
				else
					if (is_numeric($terminocompleto[0]))
						$termsearch=$terminocompleto[0];
					else
						$termsearch = '%'.$terminocompleto[0].'%';
				
			}	
				
			if (is_numeric($termsearch))
				$result = $this->Clientes->find('all')->where(['codigo ='=>$termsearch])->first();	
			
			
			
			if (!empty($result))

					{
						if ($result!=null)
						{
							$this->request->session()->write('cliente',$result);
							return $this->redirect(['action' => 'add_transfer']);
						}
						else
						{
							$cliente = null;
							$this->Flash->error('Cliente no valido',['key' => 'changepass']);
							return $this->redirect($this->referer());
						}
						
					}				
					else	
					{						
										
						$this->Flash->error('Cliente no valido',['key' => 'changepass']);
						return $this->redirect($this->referer());
					}
			
        }
		
    }

	public function vaciar()
    {
			$conn = ConnectionManager::get('default');
			$cliente_id=$this->request->session()->read('cliente_id');
			//$conn->query('CALL CopiarCarritoVacio('.$cliente_id.');');
			
        if ($this->deleteCarrito()) {
            $this->Flash->success('Se vacio correctamente.',['key' => 'changepass']);
			$this->redirect($this->referer());
        } else {
            $this->Flash->error('No pudo ser vaciado. Intente de nuevo.',['key' => 'changepass']);
			$this->redirect($this->referer());
        }  
    }
	
	public function deleteCarrito()
	{
			$this->loadModel('CarritosPreventas');
		return $this->CarritosPreventas->deleteAll(['cliente_id' => $this->request->session()->read('cliente_id')]);
	}
	
	public function deleteCarritoTemp()
	{
		$this->loadModel('Preventas');
		return $this->Preventas->deleteAll(['proveedor_id' => $this->request->session()->read('Auth.User.proveedor_id')]);
	}

    public function realizados()
    {
		
		$this->loadModel('PedidosPreventas');
		$this->viewBuilder()->layout('preventa');
        $this->paginate = [
            'contain' => ['Clientes']
        ];
		
		
		
		
		$pedidos = $this->PedidosPreventas->find('all')
					->contain(['Clientes'])
					->where(['proveedor_id'=>$this->request->session()->read('Auth.User.proveedor_id')]);

        $pedidosPreventas = $this->paginate($pedidos);

        $this->set(compact('pedidosPreventas'));
    }

    public function edit($id = null)
    {
        $preventa = $this->Preventas->get($id, [
            'contain' => ['Carritos', 'Pedidos']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $preventa = $this->Preventas->patchEntity($preventa, $this->request->getData());
            if ($this->Preventas->save($preventa)) {
                $this->Flash->success(__('The preventa has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The preventa could not be saved. Please, try again.'));
        }
        $articulos = $this->Preventas->Articulos->find('list', ['limit' => 200]);
      
        $this->set(compact('preventa', 'articulos'));
    }

    public function delete_transfer($id = null)
    {
        
		$this->request->allowMethod(['post', 'delete']);
  		$this->loadModel('PedidosPreventasItems');
		if ($this->PedidosPreventasItems->deleteAll(['pedidos_preventa_id' => $id]))
		{
			//$this->redirect($this->referer());
        } else {
            $this->Flash->error('No pudo ser vaciado. Intente de nuevo.',['key' => 'changepass']);
			$this->redirect($this->referer());
		}
		$this->loadModel('PedidosPreventas');
		
		$pedidosPreventa = $this->PedidosPreventas->get($id);
        if ($this->PedidosPreventas->delete($pedidosPreventa)) {
           $this->Flash->success('Se borro correctamente.',['key' => 'changepass']);
        } else {
           $this->Flash->error('No pudo se pudo borrar. Intente de nuevo.',['key' => 'changepass']);
        }

        return $this->redirect(['action' => 'index']);
    }

	public function confirm()
    {
		
		$this->viewBuilder()->layout('preventa');
       
        if ($this->request->is('post')) {
				
			
        }
		
		$cliente = $this->request->session()->read('cliente');	
		$this->request->session()->write('cliente_id',$cliente['id']);	
		
		$this->set('cliente',$cliente);
		
		
		$this->loadModel('PedidosPreventasItems');
		
	        
		$articulosA = $this->PedidosPreventasItems->find('all')
									
				->contain(['PedidosPreventas'
				=> [
						
						'queryBuilder' => function ($q) {
							return $q->where(['PedidosPreventas.cliente_id '=> $this->request->session()->read('cliente_id')]); // Full conditions for filtering
						}
					],
				/*,'Preventas',=> [
						
						'queryBuilder' => function ($q) {
							return $q->where(['Preventas.articulo_id = articulo_id']); // Full conditions for filtering
						}
					],
				*/
				
				'Articulos.Laboratorios','Articulos' => [
						
						'queryBuilder' => function ($q) {
							return $q->where(['Articulos.id = articulo_id']); // Full conditions for filtering
						}
					]
				])
				/*->join([
						'table' => 'pedidos_preventas',
						'alias' => 'pv',
						'type' => 'INNER',
						'conditions' => [
						
						'pv.cliente_id' => $this->request->session()->read('cliente_id')
						]
						])*/
				/*->join([
						'table' => 'articulos',
						'alias' => 'a',
						'type' => 'INNER',
						'conditions' => [
						'PedidosPreventasItems.articulo_id = a.id',
						'PedidosPreventasItems.pedidos_preventa_id = pv.id',
						
						]
						
					])	*/
					
					//->hydrate(false)
					/*
					->join([
						'table' => 'preventas',
						'alias' => 'pv',
						'type' => 'inner',
						'conditions' => ['pv.articulo_id = Articulos.id']
					])	*/
					
					
					->where([
					'PedidosPreventas.cliente_id' => $this->request->session()->read('cliente_id'),
					'Articulos.eliminado'=>0,'PedidosPreventas.proveedor_id'=>$this->request->session()->read('Auth.User.proveedor_id')]);
		if (!empty($articulosA))
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
			//'order' => ['Articulos.descripcion_pag' => 'asc']andWhere(['Articulos.eliminado'=>0])-
			$articulosA->group(['Articulos.id'])
					   ->order(['PedidosPreventas.proveedor_id'=>'asc','Articulos.descripcion_pag' => 'asc']);
			$articulos = $this->paginate($articulosA);
		}
		else
			$articulos = null;
		
	
		
		$this->listadocategoria();
		
        $this->set(compact('articulos'));
    }
 
	public function exceldetalle(){
		$this->viewBuilder()->layout('ajax');
		ini_set('memory_limit', '-1');
		$this->loadModel('PedidosPreventas');
		$query = $this->PedidosPreventas->find('all')	
					->contain(['PedidosPreventasItems','PedidosPreventasItems.Articulos','Clientes'])
			->where(['proveedor_id'=>$this->request->session()->read('Auth.User.proveedor_id')]);
		//$query = $this->PedidosPreventasItems->find();
		//$query->select([
			//	'TOTAL' => $query->func()->sum('CANTIDAD')
		//	])
			// passing the table instance to the `select` function, selects all fields
		//	->select($this->PedidosPreventasItems);

		//$query->execute();
		$this->paginate = [
         	'limit' => 50000,
			'maxLimit' => 50000,
        ];
        $pvs = $this->paginate($query);

        $this->set(compact('pvs'));

		
		$this->response->type('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	}
 
 	public function excelresumen(){
		$this->viewBuilder()->layout('ajax');
		ini_set('memory_limit', '-1');

		$this->loadModel('PedidosPreventasItems');
		//$this->loadModel('Articulos');
		$query2 = $this->PedidosPreventasItems->find('all');
		//->contain(['PedidosPreventas','Articulos']);
		$query2->select([
			'TOTAL' => $query2->func()->sum('CANTIDAD'),'Articulos.descripcion_sist','Articulos.codigo_barras','articulo_id',
							'descuento','plazoley_dcto','Articulos.troquel'			
			])
			->contain(['PedidosPreventas','Articulos'])
			// passing the table instance to the `select` function, selects all fields
			->where(['PedidosPreventas.proveedor_id'=>$this->request->session()->read('Auth.User.proveedor_id')])
			->group(['articulo_id']);
		$query2->execute();
		$this->set('resumen',$query2);
		
		$this->response->type('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	}
 
	public function confirm_transfer()
	{
		
		$this->loadModel('CarritosPreventas');
		$carritocon = $this->CarritosPreventas->find('all')
					
					->join([
						'table' => 'articulos',
						'alias' => 'a',
						'type' => 'INNER',
						'conditions' => ['a.id = CarritosPreventas.articulo_id']
					])	
					->join([
						'table' => 'preventas',
						'alias' => 'pv',
						'type' => 'inner',
						'conditions' => ['pv.articulo_id = CarritosPreventas.articulo_id']
					])
					->where(['CarritosPreventas.cliente_id' => $this->request->session()->read('cliente_id'),
							 'pv.proveedor_id' => $this->request->session()->read('Auth.User.proveedor_id')]);
							 
		//$this->request->session()->write('carritocon',$carritocon);
		
		if ($carritocon->count()>0)
		{
			$conn = ConnectionManager::get('default');
			
			$cliente_id=$this->request->session()->read('cliente_id');
			$envio = 0;//$this->request->data['enviodomicilio'];
			$comentario = "";//$this->request->data['observaciones'];
			$fecha = date('Y-m-d H:i:s');
			//$conn->query('CALL CopiarCarrito('.$cliente_id.');');
			//$conn->query('CALL actualizarcarritosindescuento('.$cliente_id.');');
			// Separo los items el Tipo Oferta TR
			
			
			$carritotr = $this->CarritosPreventas->find('all')->select(['plazoley_dcto'])->distinct(['plazoley_dcto'])
					//->contain(['articulos']) 
					->join([
						'table' => 'articulos',
						'alias' => 'a',
						'type' => 'INNER',
						'conditions' => ['a.id= CarritosPreventas.articulo_id']
					])	
					->join([
						'table' => 'preventas',
						'alias' => 'pv',
						'type' => 'inner',
						'conditions' => ['pv.articulo_id = CarritosPreventas.articulo_id']
					])
					
					->where(['CarritosPreventas.cliente_id' => $this->request->session()->read('cliente_id'),
							 'pv.proveedor_id' => $this->request->session()->read('Auth.User.proveedor_id')]);
				if ($carritotr->count()>0)
				{
					foreach ($carritotr as $carrito): 
						$plazo = $carrito['plazoley_dcto'];
						$conn->query('CALL AgregarPedidoPreventa('.$cliente_id.','.$cliente_id.','.$envio.','.$envio.',"'.$fecha.'","N","'.$comentario .'","'.$plazo.'",0,0,'.$this->request->session()->read('Auth.User.proveedor_id').');');
					endforeach;	
				}
			
			
			
			$this->Flash->warning(__(' Se envio correctamente.'),['key' => 'changepass']);
			return $this->redirect(['controller'=>'Transfers','action' => 'confirm']);
		}
		else
		{
			$this->Flash->error(__('No tiene productos cargados'),['key' => 'changepass']);
			$this->redirect($this->referer());
		}
	}
	
}
