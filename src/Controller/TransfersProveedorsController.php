<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\Estado;
use Cake\ORM\Query;
use Cake\Log\Log;
//use App\Model\Entity\Pedido;
use Cake\Database\Connection;
use Cake\Datasource\ConnectionManager;
use Cake\I18n\Time;
use Cake\Filesystem\File;

use PhpOffice\PhpSpreadsheet\IOFactory;
use Cake\ORM\TableRegistry;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Helper;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Cake\Routing\Router;
use Cake\Collection\Collection;
//require ROOT.DS.'vendor' .DS. 'phpoffice/phpspreadsheet/src/Bootstrap.php';
/**
 * TransfersProveedors Controller
 *
 * @property \App\Model\Table\TransfersProveedorsTable $TransfersProveedors
 *
 * @method \App\Model\Entity\TransfersProveedor[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */

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
				
		//return parent::isAuthorized($user);
    }
	
    /**  Get the list of rows and columns to read  */
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
} 

class TransfersProveedorsController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
		
    }

	public function isAuthorized()
    {
           if (in_array($this->request->action, ['explusive_admin','sinfalta_admin','import_linea_txt','importresulttxt','itemupdateimport','itemupdate','pedidos_all_admin','faltas_admin','index_admin','file_admin','view_admin','index_admin_search','add_admin','importresultexcel','import_linea_excel','downloadfiletxt','import_admin','import_result_admin','procesar_admin','controlar_admin','pasarcarrito_admin','carrito_admin','pasarpedido','pasarpedido_admin','confirmcarrito_admin','pedidos_admin','delete_item_admin','delete_import_admin','sincronizarestado_admin','ingresos_admin','downloadfiletxtfortransfer','volver_enviar_admin','downloadfiletxtforday'])) {
       
            if($this->request->session()->read('Auth.User.role')=='admin') 	
                return true;
            else 
				$this->Flash->error(__('No tiene permisos para ingresar'),['key' => 'changepass']);
				return false;
			}
			else
			{
				/*
			
				if (in_array($this->request->action, ['index','edit', 'carritoadd','delete','add','downloadfilefaltastxt','confirmarpedido','search','import','faltas','view','searchproduct','downloadfiletxt']))			
				{
					if($this->request->session()->read('Auth.User.role')=='client') 
					{
						$tiene= $this->tienepermiso('pedidos',$this->request->action);
						if (!$tiene)
							$this->Flash->error(__('No tiene permisos para ingresar'),['key' => 'changepass']);
						return $tiene;	
						
					}
								
					else
					{
						$this->Flash->error(__('No tiene permisos para ingresar'),['key' => 'changepass']);
						return false;
					}	
					
				}
				else
				{
                            */
					$this->Flash->error(__('No tiene permisos para ingresar'),['key' => 'changepass']);
					return false;	
				//}
	
			}
				
		return parent::isAuthorized($user);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index_admin()
    {
        $this->set('titulo','Transfer Importados de Proveedores');
        $this->viewBuilder()->setLayout('admin2');

        if ($this->request->is('post'))
		{	
	
			if ($this->request->data['fechadesde']!= null)
			{
				$fechadesde = $this->request->data['fechadesde'];
			}	
			else
			{
				$fechadesde=0;
			}
			if ($this->request->data['fechahasta']!= null)
			{
				$fechahasta = $this->request->data['fechahasta'];
			}	
			else
			{
				$fechahasta =0;
			}
			if ($this->request->data['termino']!= null)
			{
				$termino = $this->request->data['termino'];
			}	
			else
			{
				$termino ="";
			}	
			if ($this->request->data['tfl_id']!= null)
			{
				$tfl_id = $this->request->data['tfl_id'];
			}	
			else
			{
				$tfl_id =0;
			}	
		

            

			$this->request->session()->write('termino',$termino);
			$this->request->session()->write('tfl_id',$tfl_id);
			
			$this->request->session()->write('fechadesde',$fechadesde);	
			$this->request->session()->write('fechahasta',$fechahasta);
		}
		else 
		{
			$fechahasta = $this->request->session()->read('fechahasta');
		    $fechadesde = $this->request->session()->read('fechadesde');
			$termino = $this->request->session()->read('termino');
			$tfl_id = $this->request->session()->read('tfl_id');
			
		}
		if ($fechahasta!=0)
		{
			//$fechahasta2 = Time::now();
			$fechahasta2 = Time::createFromFormat(
			'd/m/Y',
			$fechahasta,
			'America/Argentina/Buenos_Aires');
			$fechahasta2->modify('+1 days');
			$fechahasta2->i18nFormat('yyyy-MM-dd');
		}
		else
		{
			$fechahasta2 = Time::now();
			$fechahasta2-> modify('+1 days');
			//$fechahasta2 = $fechahasta2->i18nFormat('yyyy-MM-dd');
		}
		if ($fechadesde!=0)
		{
			//$fechadesde2 = Time::now();
			$fechadesde2 = Time::createFromFormat('d/m/Y', $fechadesde,'America/Argentina/Buenos_Aires');
			$fechadesde2->i18nFormat('yyyy-MM-dd');
		}
		else
		{
			$fechadesde2 = Time::now();
            $fechadesde2-> modify('-30 days');
			$fechadesde2->i18nFormat('yyyy-MM-dd');
		}

        $this->loadModel('TransfersFilesLaboratorios');
		//$tfl = $this->TransfersFilesLaboratorios->find('all');
        $tfl = $this->TransfersFilesLaboratorios->find('list', ['keyField' => 'id', 'valueField' => 'nombre_laboratorio']);
        $this->set('tfl',$tfl->toArray());

        $this->loadModel('TransfersImports');

        $this->paginate = [
            'contain' => ['TransfersFilesLaboratorios', 'Proveedors'],
            'limit' => 200,
			 'maxLimit' => 200,
             'order' => ['TransfersImports.id' => 'DESC']
        ];
       
       
        $ti = $this->TransfersImports->find('all');

		
	  	if ($termino!="")
		{
			$ti->where(['TransfersImports.id'=>$termino]);
		}
		
		if (($fechadesde !=0) && ($fechahasta !=0))
		    	$ti->andWhere(["TransfersImports.importado BETWEEN '".$fechadesde2->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta2->i18nFormat('yyyy-MM-dd')."'"]);
		else
				$ti->andWhere(["TransfersImports.importado BETWEEN '".$fechadesde2->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta2->i18nFormat('yyyy-MM-dd')."'"]);

		if ($tfl_id!=0)
		{
				$ti->where(['TransfersImports.transfers_files_laboratorio_id'=>$tfl_id]);
		}
	


        $transfersImports = $this->paginate($ti);


        $this->set(compact('transfersImports'));
    }

    public function import_result_admin($transfersimport_id = null)
    {
       
        $this->viewBuilder()->setLayout('admin2');
        $this->paginate = [
            'contain' => ['Proveedors'],
            'limit' => 500,
            'maxLimit' => 500
        ];
        $transfersProveedors = $this->paginate(
            $this->TransfersProveedors->find()->where(['transfers_import_id'=>$transfersimport_id])
        );


        $this->loadModel('TransfersImports');
        $transfersImports = $this->TransfersImports->find('all')
        ->contain(['TransfersFilesLaboratorios'])->where(['TransfersImports.id'=>$transfersimport_id])->first();
       
        $this->set('titulo','RESULTADO DE LA IMPORTACION DE TRANSFER - '.$transfersImports['transfers_files_laboratorio']['nombre_laboratorio'] .' - '. date_format($transfersImports['importado'],'d-m-Y H:i:s').' '.' - nro: '.$transfersimport_id );


       
        $this->set(compact('transfersProveedors'));
    }

    public function explusive_admin($transferimport_id = null, $opcion= null)
    {
        $conn = ConnectionManager::get('default');


        if ($opcion ==1)
        {
            $conn->query('UPDATE transfers_proveedors SET transfer = SUBSTRING(numero_pedido_proveedor,LENGTH(numero_pedido_proveedor)-5) WHERE transfers_import_id = '.$transferimport_id.';');
            $conn->query('UPDATE transfers_proveedors SET  cbarra = SUBSTRING(ean, 3) WHERE transfers_import_id = '.$transferimport_id.';');
            $this->Flash->warning(__(' Se proceso los campos cbarra y transfer'),['key' => 'changepass']);
        }
        if ($opcion ==2)
        {

            $conn->query('CALL ProcesarTransferPendientesROFINA("2023-01-01","2023-02-01",'.$transferimport_id.')');


        }
        if ($opcion ==3)
        {}
        if ($opcion ==4)
        {}
        if ($opcion ==5)
        {
            $conn->query('UPDATE transfers_proveedors SET precio_neto =  ROUND(precio_unitario * (1-descuento/100),2) WHERE transfers_import_id = '.$transferimport_id.';');
            $conn->query('UPDATE transfers_proveedors SET precio_neto =0.00 WHERE precio_neto IS NULL AND transfers_import_id = '.$transferimport_id.';');
        }
        if ($opcion ==6)
            $conn->query('CALL ProcesarTransferClientesProvincias('.$transferimport_id.');');
            
        
        
            return $this->redirect($this->referer());

    }


    public function sinfalta_admin($transferimport_id)
    {
 
        $this->loadModel('TransfersImports');
        $transfersImport = $this->TransfersImports->get($transferimport_id, [
            'contain' => []
        ]);
        $transfersImport['estado'] = 0;
        $this->TransfersImports->save($transfersImport);
        $this->Flash->warning(__(' Se modifico el estado de Falta correctamente'),['key' => 'changepass']);
        return $this->redirect($this->referer());
    }

    public function ingresos_admin()
    {
        $this->set('titulo','Transfer - Ingresos de la semana');
        $this->viewBuilder()->setLayout('admin2');

        $this->paginate = [
            
            'limit' => 400,
			 'maxLimit' => 400,
             
        ];
        
        $fechadesde = Time::now();
        $fechadesde-> modify('-30 days');
        $fechadesde->i18nFormat('yyyy-MM-dd');
    
        $fechahasta =  Time::now();
        $fechahasta->modify('+1 days');
        $fechahasta->i18nFormat('yyyy-MM-dd');
        $this->loadModel('PedidosTransfersItems');
	
        $articulosA = $this->PedidosTransfersItems->find('all')
									
                    ->contain(['PedidosTransfers','PedidosTransfers.Clientes'=> [
                            
                            'queryBuilder' => function ($q) {
                                return $q->where(['PedidosTransfers.cliente_id = Clientes.id ']); // Full conditions for filtering
                            }
                        ],			
                    'Articulos.Laboratorios','Articulos' => [
                            
                            'queryBuilder' => function ($q) {
                                return $q->where(['Articulos.id = articulo_id']); // Full conditions for filtering
                            }
                        ]
                    ])
                    
                        
                        
                    ->where(['PedidosTransfers.pedidos_status_id IN(1,5,7,11)', 'PedidosTransfersItems.pedidos_items_status_id =1' ,
                	"PedidosTransfers.creado BETWEEN '".$fechadesde->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta->i18nFormat('yyyy-MM-dd')."'"
				    ,"PedidosTransfersItems.cantidad_facturada<PedidosTransfersItems.cantidad " ,'Articulos.stock'=>'S']);
				
        $this->loadModel('PedidosItemsStatus');
        $itemstatus = $this->PedidosItemsStatus->find('list',['keyField' => 'id','valueField'=>'nombre']);
        $this->set('itemstatus', $itemstatus->toArray());

		if ($articulosA!=null)
		{
			//$articulosA->gruop(['Articulos.id']);
			$pedidosItems = $this->paginate($articulosA);
		}
		else
			$pedidosItems = null;
		
		$this->set(compact('pedidosItems'));

    }

    public function procesar_admin($transferimport_id = null)
    {
        $this->set('titulo','Transfer Importados de Proveedores');
        $this->viewBuilder()->setLayout('admin');

        
        $this->loadModel('TransfersImports');

        $this->paginate = [
            'contain' => ['TransfersFilesLaboratorios', 'Proveedors'],
            'limit' => 200,
			 'maxLimit' => 200
        ];
        $transfersImports = $this->paginate($this->TransfersImports);

        $this->set(compact('transfersImports'));

    }

    public function confirmcarrito_admin($transferimport_id = null )
    {
        $this->paginate = [
            'contain' => ['Proveedors'],
			'limit' => 200,
			 'maxLimit' => 200
        ];
        $this->set('titulo','Transfers Proveedores');
        $this->viewBuilder()->setLayout('admin');
        $conn = ConnectionManager::get('default');
        
        $this->loadModel('TransfersImports');
        $transfersImport = $this->TransfersImports->get($transferimport_id, [
            'contain' => []
        ]);
        if (is_null($transfersImport['procesado']))
            {
                $this->Flash->error(__('Todavia No se proceso lo importado, procesar antes.'),['key' => 'changepass']);
                return $this->redirect(['action' =>  'index_admin']);
            }


        if (is_null($transfersImport['en_carro']))
            {
                $this->Flash->error(__('Todavia No se envio al carro'),['key' => 'changepass']);
                return $this->redirect(['action' => 'index_admin']);
            }

        if (!is_null($transfersImport['en_pedido']))
        {
            $this->Flash->error(__('Ya se envio el carro a pedidos'),['key' => 'changepass']);
            return $this->redirect(['action' => 'index_admin']);
        }  
        /*
        try{
            $conn->query('CALL PasarTransferACarritoTransfer('.$proveedor_id.');');
            $this->Flash->warning(__(' Se paso al carro correctamente'),['key' => 'changepass']);
			return $this->redirect(['action' => 'index_admin']);
            
        
       }catch(Exception $e){
            echo 'Error:'.$e->getMessage();
            return $this->redirect(['action' => 'index_admin']);
            
       }
       */
        $comentario = "TRANSFER";
       $this->loadModel('CarritosTransfers');
       $carritotr = $this->CarritosTransfers->find('all')->select(['nro_transfer','cliente_id','tipo_fact','plazoley_dcto','transfer_numero','c.codigo_postal'])
       
       ->distinct(['nro_transfer','tipo_fact','plazoley_dcto'])
       //->distinct(['cliente_id','tipo_fact','plazoley_dcto'])
       ->join([
        'table' => 'clientes',
        'alias' => 'c',
        'type' => 'inner',
        'conditions' => ['c.id = CarritosTransfers.cliente_id']
        ])
       ->where(['transfers_import_id' => $transferimport_id]);
       $this->request->session()->write('carritotr', $carritotr->toArray());
       try{ 
       if ($carritotr->count()>0)		{
    
        foreach ($carritotr as $carrito): 
                $cliente_id = $carrito['cliente_id'];
                $transfer = $carrito['nro_transfer'];
                $tipo_fact = $carrito['tipo_fact'];
                $plazo = $carrito['plazoley_dcto'];
                $transfer_numero = $carrito['transfer_numero'];
                $fecha = date('Y-m-d H:i:s');


                $conn->query('CALL CopiarCarritoTransferVacio('.$cliente_id.','.$transferimport_id.','.$transfer.',"'.$tipo_fact.'");');
                if ($carrito['c']['codigo_postal'] != 9410 && $carrito['c']['codigo_postal'] != 9420)
                $this->AgregarPedidoTransfer($cliente_id,$fecha,$tipo_fact,$comentario,$plazo,$transfer,$transferimport_id,$transfer_numero);
                else
                $this->AgregarPedidoTransferTDF($cliente_id,$fecha,$tipo_fact,$comentario,$plazo,$transfer,$transferimport_id,$transfer_numero);
                
                //$conn->query('CALL AgregarPedidoTransfer('.$cliente_id.',"'.$fecha.'","'.$tipo_fact.'","'.$comentario .'","'.$plazo.'",'.$transfer.','.$transferimport_id.',"'.$transfer_numero.'");');
                $conn->query('CALL ProcesarTransferImportClientesProvincias('.$transferimport_id.');');
                //`AgregarPedidoTransfer`(IN cliente_id INT,IN fecha DATETIME,IN tipo_factura VARCHAR(2),IN comentario VARCHAR(200),IN oferta_plazo VARCHAR(10),IN transferx INT, IN proveedor_id INT)
        endforeach;	
            
        $fecha = date('Y-m-d H:i:s');
            $conn->query('UPDATE transfers_imports SET en_pedido ="'.$fecha.'" where id= '.$transferimport_id.';');

            $conn->query('UPDATE transfers_proveedors SET status  = 23 WHERE status=22 and transfers_import_id = '.$transferimport_id.';');
            $this->Flash->warning(__('Ya se envio a pedidos'),['key' => 'changepass']);
        }
            }catch(Exception $e){
                echo 'Error:'.$e->getMessage();
                return $this->redirect(['action' => 'index_admin']);
                
        }
        //CALL PasarTransferACarritoTransfer(296);

        //$transfersProveedors = $this->paginate($this->TransfersProveedors);

        return $this->redirect(['action' => 'index_admin']);
        $this->set(compact('transfersProveedors'));
    }


    public function AgregarPedidoTransfer($cliente_id =null,$fecha =null,$tipo_fact =null,$comentario =null,$plazo =null,$transfer=null,$transferimport_id =null,$transfer_numero =null)
    {
        

        $conn = ConnectionManager::get('default');
        $this->loadModel('CarritosTransfers');
        $this->loadModel('PedidosTransfers');
        $this->loadModel('PedidosTransfersItems');
	
		$carritosA = $this->CarritosTransfers->find('all')
                ->where(['cliente_id'=> $cliente_id, 'tipo_fact' =>$tipo_fact , 'nro_transfer' =>$transfer,  'plazoley_dcto' =>$plazo, 'transfers_import_id' => $transferimport_id]);
        

                $pedido = $this->PedidosTransfers->newEntity();
                $pedido['creado']= $fecha;
                $pedido['cliente_id']= $cliente_id;
                $pedido['tipo_fact']= $tipo_fact;
                $pedido['oferta_plazo']= $plazo;
                $pedido['forma_envio']= 0;
                $pedido['comentario']= $comentario;
                $pedido['transfer']= $transfer;
                $pedido['transfers_import_id']= $transferimport_id;
                $pedido['transfer_numero']= $transfer_numero;

                //$result = $this->PedidosTransfers->save($pedido)
                if ($this->PedidosTransfers->save($pedido)) {
                    $pedido_id = $pedido->id;
                    //$pedido_id = $this->PedidosTransfers->getLastInsertID();
                   
                    $this->request->session()->write('pedido_id',$pedido_id) ;
                    $cantidad_item =0;
           $suma_total_pedido =0;
                    foreach ($carritosA as $carrito): 

                        $result = $this->PedidosTransfersItems->find('all')->where(['pedidos_transfer_id'=>$pedido_id,'articulo_id'=>$carrito['articulo_id']])->first([]);
                        /*
                        IN  agregado DATETIME,IN  pedido_id INT(11) ,IN  articulo_id INT(11) ,
                        IN  cantidad DOUBLE ,IN  precio_publico DOUBLE ,IN  descuento DOUBLE ,IN  unidad_minima SMALLINT(6) ,IN  tipo_precio VARCHAR(1) ,IN  plazoley_dcto VARCHAR(10) ,
                        IN  combo_id INT(11) ,	IN  tipo_oferta VARCHAR(2) ,IN  tipo_oferta_elegida VARCHAR(2) ,IN  tipo_fact VARCHAR(2) , IN posicion_transfer VARCHAR(16)
                        */
                        if ($carrito['categoria_id'] !=2 &&  $carrito['categoria_id'] !=3 && $carrito['categoria_id'] !=4  && $carrito['categoria_id'] !=5)
                        $subtotal_item = $carrito['cantidad'] *($carrito['precio_publico'] - ($carrito['precio_publico'] * $carrito['descuento'] /100));
                        else
                        $subtotal_item = $carrito['cantidad'] *($carrito['precio_publico'] - ($carrito['precio_publico'] * $carrito['descuento'] /100))*1.21;
                        if ($suma_total_pedido+$subtotal_item >90000000)
                        {
                            $pedidoUpMaxPrice = $this->PedidosTransfers->newEntity();
                            $pedidoUpMaxPrice['creado']= $fecha;
                            $pedidoUpMaxPrice['cliente_id']= $cliente_id;
                            $pedidoUpMaxPrice['tipo_fact']= $tipo_fact;
                            $pedidoUpMaxPrice['oferta_plazo']= $plazo;
                            $pedidoUpMaxPrice['forma_envio']= 0;
                            $pedidoUpMaxPrice['comentario']= $comentario;
                            $pedidoUpMaxPrice['transfer']= $transfer;
                            $pedidoUpMaxPrice['transfers_import_id']= $transferimport_id;
                            $pedidoUpMaxPrice['transfer_numero']= $transfer_numero;

                            if ($this->PedidosTransfers->save($pedidoUpMaxPrice)) {
                                $pedido_id = $pedidoUpMaxPrice->id;
                                $suma_total_pedido=0;
                            }

                        }   
                        else
                        {
                            $suma_total_pedido+=$subtotal_item;
                        }
                    if (empty($result) )
                    //.$cliente_id.','.$cliente_id.','.$envio.','.$envio.',"'.$fecha.'","TR","'.$comentario .'","'.$plazo.'",0,0);');
                            $conn->query('CALL InsertarPedidoTransferItem("'.$fecha.'",'.$pedido_id.','.$carrito['articulo_id'].','. $carrito['cantidad'].','. $carrito['precio_publico']
                             .','.  $carrito['descuento'].','.  $carrito['unidad_minima'].',"'. $carrito['tipo_precio'].'","'.  $carrito['plazoley_dcto'].'",'.  $carrito['combo_id']
                             .',"'. $carrito['tipo_oferta'].'","'.$carrito['tipo_oferta_elegida'].'","'.$carrito['tipo_fact'].'","'.$carrito['transfer_posicion'].'");');
                        else
                        {
                            $cantidad_item=$cantidad_item-1;
                            /*
                            $conn->query('CALL InsertarPedidoTransfer(fecha,cliente_id,tipo_factura,0,oferta_plazo,comentario,transferx,proveedor_id,numero_transfer,pedido2_id);');
                            $conn->query('CALL InsertarPedidoTransferItem(l_creado,pedido2_id, l_articulo_id, l_cantidad, l_precio_publico, l_descuento, l_unidad_minima, l_tipo_precio, l_plazoley_dcto, l_combo_id, l_tipo_oferta, l_tipo_oferta_elegida, l_tipo_fact,l_transfer_posicion);');*/
                            $pedido2 = $this->PedidosTransfers->newEntity();
                            $pedido2['creado']= $fecha;
                            $pedido2['cliente_id']= $cliente_id;
                            $pedido2['tipo_fact']= $tipo_fact;
                            $pedido2['oferta_plazo']= $plazo;
                            $pedido2['forma_envio']= 0;
                            $pedido2['comentario']= $comentario;
                            $pedido2['transfer']= $transfer;
                            $pedido2['transfers_import_id']= $transferimport_id;
                            $pedido2['transfer_numero']= $transfer_numero;

                            if ($this->PedidosTransfers->save($pedido2)) {
                                $pedido2_id = $pedido2->id;
                                //$pedido2_id = $this->PedidosTransfers->getLastInsertID();
                                //$result->id;

                                $conn->query('CALL InsertarPedidoTransferItem("'.$fecha.'",'.$pedido2_id.','. $carrito['articulo_id'].','.  $carrito['cantidad'] .','.  $carrito['precio_publico']
                                .','.  $carrito['descuento'].','.  $carrito['unidad_minima'].',"'. $carrito['tipo_precio'].'","'.  $carrito['plazoley_dcto'].'",'.  $carrito['combo_id'].',"'. $carrito['tipo_oferta'].'","'.
                                $carrito['tipo_oferta_elegida'].'","'.  $carrito['tipo_fact'].'","'.$carrito['transfer_posicion'].'");');
                                }
                              
                            $conn->query('CALL ActualizarPedidoTransferFin('.$pedido2_id.',1);');

                        }
                        
                        /*$conn->query('CALL CopiarCarritoTransferRegistro(l_id);');*/
                    
                        $cantidad_item=$cantidad_item+1;
                    endforeach;	
    
            }
         $conn->query('CALL VaciarCarritoTransfer('.$cliente_id.','.$transfer .',"'. $plazo .'","'. $tipo_fact.'");');
         $conn->query('CALL ActualizarPedidoTransferFin('.$pedido_id.','.$cantidad_item.');');
    


    }

    public function AgregarPedidoTransferTDF($cliente_id =null,$fecha =null,$tipo_fact =null,$comentario =null,$plazo =null,$transfer=null,$transferimport_id =null,$transfer_numero =null)
    {
        

        $conn = ConnectionManager::get('default');
        $this->loadModel('CarritosTransfers');
        $this->loadModel('PedidosTransfers');
        $this->loadModel('PedidosTransfersItems');
	
		$carritosA = $this->CarritosTransfers->find('all')
            ->contain(['Articulos'])->select(["Articulos.exportacion_avion","cliente_id","articulo_id","cantidad","precio_publico","descuento","unidad_minima","tipo_precio","plazoley_dcto","combo_id","tipo_oferta","tipo_oferta_elegida","tipo_fact","transfer_posicion"])
            /*->join([
            'table' => 'articulos',
            'alias' => 'a',
            'type' => 'inner',
            'conditions' => ['a.id = CarritosTransfers.articulo_id']
            ])   */
            ->where(['cliente_id'=> $cliente_id, 'tipo_fact' =>$tipo_fact , 'nro_transfer' =>$transfer,  'plazoley_dcto' =>$plazo, 'transfers_import_id' => $transferimport_id]);
        

                $pedido = $this->PedidosTransfers->newEntity();
                $pedido['creado']= $fecha;
                $pedido['cliente_id']= $cliente_id;
                $pedido['tipo_fact']= $tipo_fact;
                $pedido['oferta_plazo']= $plazo;
                $pedido['forma_envio']= 0;
                $pedido['comentario']= $comentario;
                $pedido['transfer']= $transfer;
                $pedido['transfers_import_id']= $transferimport_id;
                $pedido['transfer_numero']= $transfer_numero;

                //$result = $this->PedidosTransfers->save($pedido)
                if ($this->PedidosTransfers->save($pedido)) {
                    $pedido_id = $pedido->id;
                    //$pedido_id = $this->PedidosTransfers->getLastInsertID();
                    $this->request->session()->write('carritosA',$carritosA->toArray()) ;
                    $this->request->session()->write('pedido_id',$pedido_id) ;
                    $cantidad_item =0;
                    $suma_total_pedido =0;
                   foreach ($carritosA as $carrito):

                $result = $this->PedidosTransfersItems->find('all')->where(['pedidos_transfer_id' => $pedido_id, 'articulo_id' => $carrito['articulo_id']])->first([]);
                /*
                        IN  agregado DATETIME,IN  pedido_id INT(11) ,IN  articulo_id INT(11) ,
                        IN  cantidad DOUBLE ,IN  precio_publico DOUBLE ,IN  descuento DOUBLE ,IN  unidad_minima SMALLINT(6) ,IN  tipo_precio VARCHAR(1) ,IN  plazoley_dcto VARCHAR(10) ,
                        IN  combo_id INT(11) ,	IN  tipo_oferta VARCHAR(2) ,IN  tipo_oferta_elegida VARCHAR(2) ,IN  tipo_fact VARCHAR(2) , IN posicion_transfer VARCHAR(16)
                        */
                if ($carrito['categoria_id'] != 2 &&  $carrito['categoria_id'] != 3 && $carrito['categoria_id'] != 4  && $carrito['categoria_id'] != 5)
                    $subtotal_item = $carrito['cantidad'] * ($carrito['precio_publico'] - ($carrito['precio_publico'] * $carrito['descuento'] / 100));
                else
                    $subtotal_item = $carrito['cantidad'] * ($carrito['precio_publico'] - ($carrito['precio_publico'] * $carrito['descuento'] / 100)) * 1.21;
                if ($suma_total_pedido + $subtotal_item > 90000000) {
                    if ($this->PedidosTransfers->save($pedido)) {
                        $pedido_id = $pedido->id;
                        $suma_total_pedido = 0;
                    }
                } else {
                    $suma_total_pedido += $subtotal_item;
                }
                if (empty($result)) {
                        if ($carrito['articulo']['exportacion_avion'])
                        {
                            $conn->query('CALL InsertarPedidoTransferItem("'.$fecha.'",'.$pedido_id.','.$carrito['articulo_id'].','. $carrito['cantidad'].','. $carrito['precio_publico']
                            .','.  $carrito['descuento'].','.  $carrito['unidad_minima'].',"'. $carrito['tipo_precio'].'","'.  $carrito['plazoley_dcto'].'",'.  $carrito['combo_id']
                            .',"'. $carrito['tipo_oferta'].'","'.$carrito['tipo_oferta_elegida'].'","'.$carrito['tipo_fact'].'","'.$carrito['transfer_posicion'].'");');

                        }
                        else
                        {
                            $cantidad_item=$cantidad_item-1;
                            /*
                            $conn->query('CALL InsertarPedidoTransfer(fecha,cliente_id,tipo_factura,0,oferta_plazo,comentario,transferx,proveedor_id,numero_transfer,pedido2_id);');
                            $conn->query('CALL InsertarPedidoTransferItem(l_creado,pedido2_id, l_articulo_id, l_cantidad, l_precio_publico, l_descuento, l_unidad_minima, l_tipo_precio, l_plazoley_dcto, l_combo_id, l_tipo_oferta, l_tipo_oferta_elegida, l_tipo_fact,l_transfer_posicion);');*/
                            $pedido3 = $this->PedidosTransfers->newEntity();
                            $pedido3['creado']= $fecha;
                            $pedido3['cliente_id']= $cliente_id;
                            $pedido3['tipo_fact']= $tipo_fact;
                            $pedido3['oferta_plazo']= $plazo;
                            $pedido3['forma_envio']= 0;
                            $pedido3['comentario']= $comentario." T";
                            $pedido3['transfer']= $transfer;
                            $pedido3['transfers_import_id']= $transferimport_id;
                            $pedido3['transfer_numero']= $transfer_numero;

                            if ($this->PedidosTransfers->save($pedido3)) {
                                $pedido3_id = $pedido3->id;
                                //$pedido2_id = $this->PedidosTransfers->getLastInsertID();
                                //$result->id;

                                $conn->query('CALL InsertarPedidoTransferItem("'.$fecha.'",'.$pedido3_id.','. $carrito['articulo_id'].','.  $carrito['cantidad'] .','.  $carrito['precio_publico']
                                .','.  $carrito['descuento'].','.  $carrito['unidad_minima'].',"'. $carrito['tipo_precio'].'","'.  $carrito['plazoley_dcto'].'",'.  $carrito['combo_id'].',"'. $carrito['tipo_oferta'].'","'.
                                $carrito['tipo_oferta_elegida'].'","'.  $carrito['tipo_fact'].'","'.$carrito['transfer_posicion'].'");');
                                }
                              
                            $conn->query('CALL ActualizarPedidoTransferFin('.$pedido3_id.',1);');
                        }
                        }
                        else
                        {
                            $cantidad_item=$cantidad_item-1;
                            /*
                            $conn->query('CALL InsertarPedidoTransfer(fecha,cliente_id,tipo_factura,0,oferta_plazo,comentario,transferx,proveedor_id,numero_transfer,pedido2_id);');
                            $conn->query('CALL InsertarPedidoTransferItem(l_creado,pedido2_id, l_articulo_id, l_cantidad, l_precio_publico, l_descuento, l_unidad_minima, l_tipo_precio, l_plazoley_dcto, l_combo_id, l_tipo_oferta, l_tipo_oferta_elegida, l_tipo_fact,l_transfer_posicion);');*/
                            $pedido2 = $this->PedidosTransfers->newEntity();
                            $pedido2['creado']= $fecha;
                            $pedido2['cliente_id']= $cliente_id;
                            $pedido2['tipo_fact']= $tipo_fact;
                            $pedido2['oferta_plazo']= $plazo;
                            $pedido2['forma_envio']= 0;
                            $pedido2['comentario']= $comentario;
                            $pedido2['transfer']= $transfer;
                            $pedido2['transfers_import_id']= $transferimport_id;
                            $pedido2['transfer_numero']= $transfer_numero;

                            if ($this->PedidosTransfers->save($pedido2)) {
                                $pedido2_id = $pedido2->id;
                                //$pedido2_id = $this->PedidosTransfers->getLastInsertID();
                                //$result->id;

                                $conn->query('CALL InsertarPedidoTransferItem("'.$fecha.'",'.$pedido2_id.','. $carrito['articulo_id'].','.  $carrito['cantidad'] .','.  $carrito['precio_publico']
                                .','.  $carrito['descuento'].','.  $carrito['unidad_minima'].',"'. $carrito['tipo_precio'].'","'.  $carrito['plazoley_dcto'].'",'.  $carrito['combo_id'].',"'. $carrito['tipo_oferta'].'","'.
                                $carrito['tipo_oferta_elegida'].'","'.  $carrito['tipo_fact'].'","'.$carrito['transfer_posicion'].'");');
                                }
                              
                            $conn->query('CALL ActualizarPedidoTransferFin('.$pedido2_id.',1);');

                        }
                        
                        /*$conn->query('CALL CopiarCarritoTransferRegistro(l_id);');*/
                    
                        $cantidad_item=$cantidad_item+1;
                    endforeach;	
    
            }
         $conn->query('CALL VaciarCarritoTransfer('.$cliente_id.','.$transfer .',"'. $plazo .'","'. $tipo_fact.'");');
         $conn->query('CALL ActualizarPedidoTransferFin('.$pedido_id.','.$cantidad_item.');');
    


    }


    public function pasarcarrito_admin( $transferimport_id = null)
    {
        $this->paginate = [
            'contain' => ['Proveedors'],
			'limit' => 200,
			 'maxLimit' => 200
        ];
        $this->set('titulo','Transfers Proveedores');
        $this->viewBuilder()->setLayout('admin');
        $conn = ConnectionManager::get('default');

        $this->loadModel('TransfersImports');
        $transfersImport = $this->TransfersImports->get($transferimport_id, [
            'contain' => []
        ]);
        if (is_null($transfersImport['procesado']))
            {
                $this->Flash->error(__('Todavia No se proceso lo importado, procesar antes.'),['key' => 'changepass']);
                return $this->redirect(['action' =>  'index_admin']);
            }


        if (!is_null($transfersImport['en_carro']))
            {
                $this->Flash->error(__('Ya se envio anteriormente al carro'),['key' => 'changepass']);
                return $this->redirect(['action' => 'index_admin']);
            }

        try{
            /*if(!$validUser){
                 throw new Exception('Invalid User');
            }*/
            $conn->query('CALL PasarTransferACarritoTransfer('.$transferimport_id.');');
            $this->Flash->warning(__(' Se paso al carro correctamente'),['key' => 'changepass']);

            $fecha = date('Y-m-d H:i:s');
            $conn->query('UPDATE transfers_imports SET en_carro ="'.$fecha.'" where id= '.$transferimport_id.';');
			return $this->redirect(['action' => 'index_admin']);
            
        
       }catch(Exception $e){
            echo 'Error:'.$e->getMessage();
            return $this->redirect(['action' => 'index_admin']);
            
       }

        //CALL PasarTransferACarritoTransfer(296);
        

     /*
        $carritotr = $this->Carritos->find('all')->select(['plazoley_dcto'])->distinct(['plazoley_dcto'])->where(['Carritos.cliente_id' => $cliente_id])
        ->andWhere(['Carritos.tipo_fact'=>'TR']);
        if ($carritotr->count()>0)		{
    
        foreach ($carritotr as $carrito): 
                        $conn->query('CALL ProcesarTransferACarritoPreventaPreventa('.$cliente_id.','.$cliente_id.','.$envio.','.$envio.',"'.$fecha.'","TR","'.$comentario .'","'.$plazo.'",0,0);');
        endforeach;			}
     */
        $transfersProveedors = $this->paginate($this->TransfersProveedors);

        $this->set(compact('transfersProveedors'));
    }


    public function faltas_admin($id = null)
	{
		$this->viewBuilder()->setLayout('admin2');
       
        if ($this->request->is('post')) {
				
			
        }
        
		
        $this->loadModel('TransfersImports');
        $transfersImports = $this->TransfersImports->find('all')
        ->contain(['TransfersFilesLaboratorios'])->where(['TransfersImports.id'=>$id])->first();
        $this->set('transfersImports',$transfersImports->toArray());
        $this->set('titulo','Faltas de Transfer - '.$transfersImports['transfers_files_laboratorio']['nombre_laboratorio'] .' - '. date_format($transfersImports['importado'],'d-m-Y H:i:s').' '.' - nro: '.$id );
        $this->set('transfersImports', $transfersImports->toArray());
		$this->loadModel('PedidosTransfersItems');
        $this->loadModel('PedidosItemsStatus');
		$itemstatus = $this->PedidosItemsStatus->find('list',['keyField' => 'id','valueField'=>'nombre']);
		$this->set('itemstatus', $itemstatus->toArray());
		
	        
		$articulosA = $this->PedidosTransfersItems->find('all')
									
				->contain(['PedidosTransfers','PedidosTransfers.Clientes'=> [
						
						'queryBuilder' => function ($q) {
							return $q->where(['PedidosTransfers.cliente_id = Clientes.id ']); // Full conditions for filtering
						}
					],			
				'Articulos.Laboratorios','Articulos' => [
						
						'queryBuilder' => function ($q) {
							return $q->where(['Articulos.id = articulo_id']); // Full conditions for filtering
						}
					]
				])
				
					
					
					->where(['PedidosTransfers.pedidos_status_id IN(1,5,7,11)', 'PedidosTransfers.transfers_import_id' => $id,'PedidosTransfersItems.pedidos_items_status_id<>0' ]);

		if (!empty($articulosA))
		{
			
			
		
			$this->paginate = [		
			'limit' => 300,
            'maxLimit' => 300,
			'offset' => 0, 
			];
			//'order' => ['Articulos.descripcion_pag' => 'asc']andWhere(['Articulos.eliminado'=>0])-
			$articulosA->order(['Laboratorios.nombre'=>'asc','Articulos.descripcion_pag' => 'asc']);
			$pedidosItems = $this->paginate($articulosA);
		}
		else
        {
			$pedidosItems = null;
            $this->Flash->warning(__('No hay faltas'),['key' => 'changepass']);
            return $this->redirect(['action' => 'index_admin']);

        }
        if ($articulosA->count()<1)
            {
                $this->Flash->warning(__('No hay faltas'),['key' => 'changepass']);
                return $this->redirect(['action' => 'index_admin']);
            }
		
		$this->categoriaylaboratorio();
		
        $this->set(compact('pedidosItems'));
		

        $this->loadModel('TransfersProveedors');

        $transfersProveedors = $this->TransfersProveedors->find()->contain(['Proveedors'])->where(['transfers_import_id'=>$id,'status>1','status!=8','status!=24','status!=71']);
        $transfersProveedors = $transfersProveedors->toArray();
        $this->set(compact('transfersProveedors'));
        $this->set('titulo2','Inconsitencias Transfer - '.$transfersImports['transfers_files_laboratorio']['nombre_laboratorio'] .' - '. date_format($transfersImports['importado'],'d-m-Y H:i:s').' '.' - nro: '.$id );
        


        $this->set('titulo_pedido','Pedidos con limite/faltas - '.$transfersImports['transfers_files_laboratorio']['nombre_laboratorio'] .' - '. date_format($transfersImports['importado'],'d-m-Y H:i:s').' '.' - nro: '.$id );
       

        $this->loadModel('PedidosTransfers');

		$pedidos = $this->PedidosTransfers->find('all')->contain(['Clientes'])->where(['transfers_import_id'=>$id, 'pedidos_status_id IN(1,5,7,11)']);

        $pedidostransfers = $this->paginate($pedidos);

        $this->set(compact('pedidostransfers'));	


	}

    public function pasarpedido_admin($transferimport_id = null)
    {
        $this->set('titulo','Transfers Proveedores');
        $this->viewBuilder()->setLayout('admin');
        $conn = ConnectionManager::get('default');
        $this->loadModel('TransfersImports');
        $transfersImport = $this->TransfersImports->get($transferimport_id, [
            'contain' => []
        ]);
        if (is_null($transfersImport['procesado']))
        {
            $this->Flash->error(__('Todavia No se proceso lo importado, procesar antes.'),['key' => 'changepass']);
            return $this->redirect(['action' =>  'index_admin']);
        }

        if (is_null($transfersImport['en_carro']))
            {
                $this->Flash->error(__('Todavia No se envio al carro'),['key' => 'changepass']);
                return $this->redirect(['action' => 'index_admin']);
            }

        if (is_null($transfersImport['en_pedido']))
        {
            $this->Flash->error(__('Todavia No se envio el carro a pedidos'),['key' => 'changepass']);
            return $this->redirect(['action' => 'index_admin']);
        }  

        if (!is_null($transfersImport['facturado']))
        {
            $this->Flash->error(__('Ya se mando los pedidos'),['key' => 'changepass']);
            return $this->redirect(['action' => 'index_admin']);
        }  

        try{
          
            $conn->query('CALL CopiarTransferPorImport('.$transferimport_id.');');
            $fecha = date('Y-m-d H:i:s');
            $conn->query('UPDATE transfers_imports SET facturado ="'.$fecha.'" where id= '.$transferimport_id.';');
            $this->Flash->warning(__(' Se proceso correctamente'),['key' => 'changepass']);
			return $this->redirect(['action' => 'index_admin']);

       }catch(Exception $e){
            echo 'Error:'.$e->getMessage();
            return $this->redirect(['action' => 'index_admin']);
            
       }
    }

    public function volver_enviar_admin($pedido_id = null)
    {
        $this->viewBuilder()->setLayout('admin');
        $conn = ConnectionManager::get('default');
        $this->loadModel('PedidosTransfers');
        $transfersImport = $this->PedidosTransfers->get($pedido_id, [
            'contain' => []
        ]);
        try{
            if ($transfersImport['pedidos_status_id'] !=1)
            $conn->query('CALL CopiarPedidoTransferFaltas('.$pedido_id.');');
            else
            $conn->query('CALL CopiarPedidoTransferNohabilitado('.$pedido_id.');');

            $fecha = date('Y-m-d H:i:s');
            $estado = 0;
            if ($transfersImport['pedidos_status_id'] ==5)
            $estado= 25 ;
            if ($transfersImport['pedidos_status_id'] ==7)
            $estado= 27;  
            if ($transfersImport['pedidos_status_id'] ==1)
            $estado= 31;

            if ($transfersImport['pedidos_status_id'] !=1)
            $conn->query('UPDATE pedidos_transfers SET pedidos_status_id ='.$estado.' where id= '.$pedido_id.';');
            else
            $conn->query('UPDATE pedidos_transfers SET pedidos_status_id ='.$estado.', estado_id =3 where id= '.$pedido_id.';');
            // creo un nuevo pedido mismas caracteristicas
            // copio los 
            //$conn->query('UPDATE transfers_imports SET facturado ="'.$fecha.'" where id= '.$transferimport_id.';');
            $this->Flash->warning(__(' Se proceso correctamente'),['key' => 'changepass']);
			return $this->redirect($this->referer());

       }catch(Exception $e){
            echo 'Error:'.$e->getMessage();
            return $this->redirect($this->referer());
            
       }

    }


    public function sincronizarestadotransfer_admin($transferimport_id = null)
    {
    
        $this->loadModel('PedidosTransfers');
	

        $this->loadModel('TransfersImports');
        $transfersImports = $this->TransfersImports->find('all')->contain(['TransfersFilesLaboratorios'])->where(['TransfersImports.id'=>$transferimport_id])->first();
       
        
		$pedidos = $this->PedidosTransfers->find('all')
					->contain(['Clientes'])->where(['pedidos_status_id>0','transfers_import_id'=>$transferimport_id]);
                    $estado = 0;
                   
                    foreach ($pedidos as $row): 
                    if ($row['pedidos_status_id'] !=27 && $row['pedidos_status_id'] !=25 && $row['pedidos_status_id'] !=31)
                    {
                       
                       if (($row['pedidos_status_id']  == 5 && $estado == 7) || ($row['pedidos_status_id']  == 7 && $estado == 5))
                       {
                         $estado = 57;
                       }
                       else
                       {
                        if (($row['pedidos_status_id']  == 5 && $estado == 1))
                        $estado = 51;
                        else
                        if ($estado != 57 &&  $estado != 51)
                        $estado = $row['pedidos_status_id'];


                       }
                    } 

                    endforeach;

                    $transfersImports['estado'] = $estado;
                    $this->TransfersImports->save($transfersImports);

    }

    public function sincronizarestado_admin($transferimport_id = null)
    {
        $this->paginate = [
            'contain' => ['Proveedors'],
			'limit' => 500,
			 'maxLimit' => 500
        ];
        $this->set('titulo','Transfers Proveedores');
        $this->viewBuilder()->setLayout('admin');
        $conn = ConnectionManager::get('default');
       

        $this->loadModel('TransfersImports');
        $transfersImport = $this->TransfersImports->get($transferimport_id, [
            'contain' => []
        ]);
      
        
        if (is_null($transfersImport['procesado']))
        {
            $this->Flash->error(__('Todavia No se proceso lo importado, procesar antes.'),['key' => 'changepass']);
            return $this->redirect(['action' =>  'index_admin']);
        }

        if (is_null($transfersImport['en_carro']))
            {
                $this->Flash->error(__('Todavia No se envio al carro'),['key' => 'changepass']);
                return $this->redirect(['action' => 'index_admin']);
            }

        if (is_null($transfersImport['en_pedido']))
        {
            $this->Flash->error(__('Todavia No se envio el carro a pedidos'),['key' => 'changepass']);
            return $this->redirect(['action' => 'index_admin']);
        }  

        if (is_null($transfersImport['facturado']))
        {
            $this->Flash->error(__('Todavia no se envio a facturar los pedidos'),['key' => 'changepass']);
            return $this->redirect(['action' => 'index_admin']);
        }  
        
        /*
        if (!is_null($transfersImport['sincronizar_estado']))
        {
            $this->Flash->error(__('Ya se sincronizo los pedidos con la información del sistema'),['key' => 'changepass']);
            return $this->redirect(['action' => 'index_admin']);
        }  */

        try{
            
            $this->loadModel('TransfersImports');
            $transfersImport = $this->TransfersImports->get($transferimport_id, [
                'contain' => []
            ]);

            $conn->query('CALL SincronizarPedidosConPedidosTransfers('.$transferimport_id.');');
            $conn->query('CALL SincronizarPedidosTransfersConTransfers('.$transferimport_id.');');
            $conn->query('CALL SincronizarFacturasconPedidoTransfers('.$transferimport_id.');');
            
            $this->sincronizarestadotransfer_admin($transferimport_id);

            $this->Flash->warning(__(' Se proceso correctamente'),['key' => 'changepass']);
            $fecha = date('Y-m-d H:i:s');
            //if ($transfersImport['transfers_files_laboratorio_id'] == 1)
            
            //$conn->query('UPDATE transfers_proveedors SET transfer = SUBSTRING(numero_pedido_proveedor,LENGTH(numero_pedido_proveedor)-5) where transfers_import_id ='.$transferimport_id.';');
                
            $conn->query('UPDATE transfers_imports SET sincronizar_estado ="'.$fecha.'" where id= '.$transferimport_id.';');

			return $this->redirect(['action' => 'index_admin']);
            
        
       }catch(Exception $e){
            echo 'Error:'.$e->getMessage();
            return $this->redirect(['action' => 'index_admin']);
            
       }


        $transfersProveedors = $this->paginate($this->TransfersProveedors);

        $this->set(compact('transfersProveedors'));
    }


    public function procesar_transfer_importado($transfersimport_id = null, $tfl_id = null, $procesado = null )
    {

        $transfersProveedors =$this->TransfersProveedors->find("all")->select(["id","transfer","fecha_factura","fecha_transfer","cliente", "ean","descuento", "descuento_especial","unidades","descripcion","status"])->where(["transfers_import_id" =>$transfersimport_id]);

        //$this->set(compact('transfersProveedors'));

        $this->loadModel('Clientes');
        $this->loadModel('Articulos');
		if (empty($transfersProveedors))
		{ 
            $this->Flash->error(__('Momentaneamente no disponible, intente mas tarde.'),['key' => 'changepass']);
			$this->redirect($this->referer());}
		else
		{
            $conn = ConnectionManager::get('default');
            foreach ($transfersProveedors as $row): 
                $codigo_cliente = $row['cliente'];
                $ean = $row["ean"];
                $l_id = $row['id'];
                $descuento_especial = $row["descuento_especial"];
                $descuento = $row["descuento"];
                if (is_null($procesado))
                if ($tfl_id ==6 || $tfl_id == 10 || $tfl_id == 25) // descuento dividir por 100
                {
                    $descuento = $descuento/100;

                }
			    $cliente = $this->Clientes->find('all')->select(["id","razon_social","codigo","condicion_descuento","preciofarmacia_descuento","provincia_id"])->where(['codigo' => $codigo_cliente])->first();
                if (empty($cliente))
                {
                    if ($tfl_id ==6 || $tfl_id == 10 || $tfl_id == 25) 

                    $conn->query('UPDATE transfers_proveedors SET status = 52, descuento = '.$descuento.' WHERE id = '.$l_id.';');
                    else
                    $conn->query('UPDATE transfers_proveedors SET status = 52 WHERE id = '.$l_id.';');
                }
                else
                {
                    $cliente_id = $cliente['id'];
                    
                    if ($tfl_id != 23)
                    $conn->query('UPDATE transfers_proveedors SET status = 20 , cliente_id ='. $cliente_id.' WHERE id = '.$l_id.';');
                    else
                    {
                        $razon_social = $cliente['razon_social']; 
                        $conn->query('UPDATE transfers_proveedors SET status = 20 , cliente_id ='. $cliente_id.' , nombre ="'.$razon_social.'" WHERE id = '.$l_id.';');

                    }
                    $articulo = $this->Articulos->find("all")->select(["id","categoria_id","iva","precio_publico","ean_prov","paq","venta_paq","descripcion_pag"])
                    ->where(['Articulos.codigo_barras  LIKE '  => '' . $ean . ''])
                    ->orWhere(['Articulos.codigo_barras2 LIKE' => '' . $ean . ''])
                    ->orWhere(['Articulos.codigo_barras3 LIKE' => '' . $ean . ''])
                    ->orWhere(['Articulos.ean_prov LIKE' => '' . $ean . ''])
                    ->where(['Articulos.eliminado' => 0])->first();
                    
                    if (empty($articulo))
                    {
                        if ($tfl_id ==6 || $tfl_id == 10 || $tfl_id == 25) 
                        $conn->query('UPDATE transfers_proveedors SET status = 41, descuento = '.$descuento.' WHERE id = '.$l_id.';');
                        else
                        $conn->query('UPDATE transfers_proveedors SET status = 41 WHERE id = '.$l_id.';');
                    }
                    else
                    {
                        if ($tfl_id !=23)
                        {
                        if ($articulo["iva"])
                            {

                                    if ($tfl_id ==3)
                                    {if ($descuento !=31)
                                    $descuento_cal= (1-((1-$descuento/100)/(1-0.3095)))*100;
                                        else
                                        $descuento_cal =0;
                                    }
                                    else
                                    $descuento_cal = $descuento;

                                    $unidades = $row["unidades"];
                                    if ((!$articulo["venta_paq"]) && ($ean === $articulo["ean_prov"]))
                                     {
                                      
                                            $cantidad =intdiv($unidades,$articulo["paq"]);
                                            $this->request->session()->write('ean_prov',$articulo["ean_prov"] ." ".$unidades. " ".$cantidad) ;
                                     }  
                                    else
                                        $cantidad = $unidades;

                                        if (!is_null($procesado) && $row["status"] == 21)
                                        {
                                            $descuento_cal = $descuento;
                                        }
                                        if ($tfl_id ==8)
                                         $descuento_cal = $descuento;

                                        if ($descuento_cal<0) 
                                            $descuento_cal = $descuento;
                                        if (is_null($row["descripcion"]))
                                        $conn->query('UPDATE transfers_proveedors SET status = 21, tipo_fact="TL", tipo_precio="F" ,descuento = '.$descuento_cal.', categoria_id = '.$articulo["categoria_id"].', unidades = '.$cantidad. ' , articulo_id  = '.$articulo["id"].' , precio_unitario=' .$articulo["precio_publico"].', descripcion = "'.str_replace( '"', "",$articulo['descripcion_pag']).'"  WHERE id = '.$l_id.';');    
                                        else
                                        $conn->query('UPDATE transfers_proveedors SET status = 21, tipo_fact="TL", tipo_precio="F" ,descuento = '.$descuento_cal.', categoria_id = '.$articulo["categoria_id"].', unidades = '.$cantidad. ' , articulo_id  = '.$articulo["id"].' , precio_unitario=' .$articulo["precio_publico"].' WHERE id = '.$l_id.';');
                                
                            }   
                            else
                            {
                                $condicion= $cliente["condicion_descuento"];
                                $descuento_pf = $cliente["preciofarmacia_descuento"];
                                
                                
                                
                                if ($descuento_especial>0)		
                                                     
                                    if  ($descuento>1.45 && $descuento<5.01)//100*(1-($descuento_pf * (1-$condicion/100)));
                                        $descuento_cal = 100*(1-($descuento_pf * (1-$condicion/100))) + ($descuento/1.45);

                                    else
                                        if ($descuento<1.46 && $descuento>0)
                                        $descuento_cal = 100*(1-($descuento_pf * (1-$condicion/100))) + $descuento;
                                        else
                                        $descuento_cal = 100*(1-($descuento_pf * (1-$condicion/100)));
                                else
                                    $descuento_cal = (1 - ((1-0.3095)*(1-$descuento/100)))*100;
                                
                                if ($tfl_id ==3 || $tfl_id ==20)
                                    
                                    {
                                        if  ($descuento >0)
                                        $descuento_cal = $descuento;
                                        else
                                        $descuento_cal = 30.95;
                                    }
                                
                                if (($cliente["provincia_id"]==23) && ($descuento_cal>99))
                                    $descuento_cal = 91.14;

                                    if (!is_null($procesado) && $row["status"] == 21 )
                                    {
                                        $descuento_cal = $descuento;
                                    }
                                    if ($tfl_id ==8)
                                        $descuento_cal = $descuento;
                                    if ($descuento_cal<0) 
                                        $descuento_cal = $descuento;
                                if (is_null($row["descripcion"]))
                                $conn->query('UPDATE transfers_proveedors SET status = 21, tipo_fact="TR", tipo_precio="P" , categoria_id = '.$articulo["categoria_id"].', descripcion = "'.str_replace( '"', "",$articulo['descripcion_pag']).'" ,  
                                articulo_id  = '.$articulo["id"].' , precio_unitario=' .$articulo["precio_publico"].',descuento = '.$descuento_cal.'  WHERE id = '.$l_id.';');
                           
                                else
                                $conn->query('UPDATE transfers_proveedors SET status = 21, tipo_fact="TR", tipo_precio="P" , categoria_id = '.$articulo["categoria_id"].', 
                                    articulo_id  = '.$articulo["id"].' , precio_unitario=' .$articulo["precio_publico"].',descuento = '.$descuento_cal.'  WHERE id = '.$l_id.';');
                                


                            }   
                        }
                        else
                        {
                                $descuento_cal = $descuento;
                                $cantidad = $row["unidades"];
                                
                                if (is_null($row["descripcion"]))
                                        $conn->query('UPDATE transfers_proveedors SET status = 21, tipo_fact="TL", tipo_precio="F" ,descuento = '.$descuento_cal.', categoria_id = '.$articulo["categoria_id"].', unidades = '.$cantidad. ' , articulo_id  = '.$articulo["id"].' , precio_unitario=' .$articulo["precio_publico"].', descripcion = "'.str_replace( '"', "",$articulo['descripcion_pag']).'"  WHERE id = '.$l_id.';');    
                                        else
                                        $conn->query('UPDATE transfers_proveedors SET status = 21, tipo_fact="TL", tipo_precio="F" ,descuento = '.$descuento_cal.', categoria_id = '.$articulo["categoria_id"].', unidades = '.$cantidad. ' , articulo_id  = '.$articulo["id"].' , precio_unitario=' .$articulo["precio_publico"].' WHERE id = '.$l_id.';');

                        }             

                    }

                }

            endforeach;  
        
        }

    }


    public function controlar_admin($transferimport_id = null)
    {
        $this->paginate = [
            'contain' => ['Proveedors'],
			'limit' => 500,
			'maxLimit' => 500
        ];
        $this->set('titulo','Transfers Proveedores');
        $this->viewBuilder()->setLayout('admin');
        $conn = ConnectionManager::get('default');
       
        
        $this->loadModel('TransfersImports');
        $transfersImport = $this->TransfersImports->get($transferimport_id, [
            'contain' => []
        ]);
        if (!is_null($transfersImport['en_carro']))
        {
            $this->Flash->error(__('Ya se proceso lo importado.'),['key' => 'changepass']);
            return $this->redirect(['action' => 'index_admin']);
        }

        
        try{
            
            $this->loadModel('TransfersImports');
            $transfersImport = $this->TransfersImports->get($transferimport_id, [
                'contain' => []
            ]);

            $this->procesar_transfer_importado($transferimport_id,$transfersImport['transfers_files_laboratorio_id'],$transfersImport['procesado']);
            //$conn->query('CALL ProcesarTransferACarritoTransfer('.$transferimport_id.');');
            $this->Flash->warning(__(' Se proceso correctamente'),['key' => 'changepass']);
            $fecha = date('Y-m-d H:i:s');
            if ($transfersImport['transfers_files_laboratorio_id'] == 1)
            $conn->query('UPDATE transfers_proveedors SET transfer = SUBSTRING(numero_pedido_proveedor,LENGTH(numero_pedido_proveedor)-5) where transfers_import_id ='.$transferimport_id.';');
                
            $conn->query('UPDATE transfers_imports SET procesado ="'.$fecha.'" where id= '.$transferimport_id.';');

            if ($transfersImport['transfers_files_laboratorio_id'] == 6)
            $conn->query('
            UPDATE transfers_proveedors tp INNER JOIN (SELECT tp.id FROM transfers_proveedors tp  INNER JOIN articulos a ON a.id= tp.articulo_id INNER JOIN clientes c ON tp.cliente_id = c.id
            WHERE tp.transfers_import_id = '. $transferimport_id.'    AND c.codigo_postal IN (8109,7500) AND a.laboratorio_id = 25) AS subquery ON tp.id = subquery.id
            SET tp.plazo = "45 DIAS" WHERE tp.transfers_import_id ='.$transferimport_id.';');
            
            //UPDATE transfers_proveedors SET transfer = SUBSTRING(numero_pedido_proveedor,LENGTH(numero_pedido_proveedor)-5) where transfers_import_id ='.$transferimport_id.';');
            

			return $this->redirect(['action' => 'index_admin']);
            
        
       }catch(Exception $e){
            echo 'Error:'.$e->getMessage();
            return $this->redirect(['action' => 'index_admin']);
            
       }

        //CALL PasarTransferACarritoTransfer(296);
        

        /*
            $carritotr = $this->Carritos->find('all')->select(['plazoley_dcto'])->distinct(['plazoley_dcto'])->where(['Carritos.cliente_id' => $cliente_id])
            ->andWhere(['Carritos.tipo_fact'=>'TR']);
            if ($carritotr->count()>0)		{
        
            foreach ($carritotr as $carrito): 
                            $conn->query('CALL ProcesarTransferACarritoPreventaPreventa('.$cliente_id.','.$cliente_id.','.$envio.','.$envio.',"'.$fecha.'","TR","'.$comentario .'","'.$plazo.'",0,0);');
            endforeach;			}
        */
        $transfersProveedors = $this->paginate($this->TransfersProveedors);

        $this->set(compact('transfersProveedors'));
    }

	public function categoriaylaboratorio()
	{
		if (empty($this->request->session()->read('Categorias'))) {
			$this->loadModel('Categorias');
			$this->loadModel('Laboratorios');
			$categorias = $this->Categorias->find('list', ['keyField' => 'id', 'valueField' => 'nombre']);
			$laboratorios = $this->Laboratorios->find('list', ['keyField' => 'id', 'valueField' => 'nombre'])->where(['eliminado=0'])->order(['nombre' => 'ASC']);

			//$this->request->session()->write('Categorias',$categorias->toList(['keyField' => 'id','valueField'=>'nombre']));
			//$this->request->session()->write('Laboratorios',$laboratorios ->toList(['keyField' => 'id','valueField'=>'nombre']));
			$this->request->session()->write('Categorias', $categorias->toArray());
			$this->request->session()->write('Laboratorios', $laboratorios->toArray());
			$laboratorios = $this->request->session()->read('Laboratorios');
			$categorias = $this->request->session()->read('Categorias');
		    } else {

			$this->loadModel('Categorias');
			$this->loadModel('Laboratorios');
			$categorias = $this->Categorias->find('list', ['keyField' => 'id', 'valueField' => 'nombre']);
			$laboratorios = $this->Laboratorios->find('list', ['keyField' => 'id', 'valueField' => 'nombre'])->order(['nombre' => 'ASC']);

			$this->request->session()->write('Categorias', $categorias->toArray());
			$this->request->session()->write('Laboratorios', $laboratorios->toArray());


			$laboratorios = $this->request->session()->read('Laboratorios');
			$categorias = $this->request->session()->read('Categorias');
		}
		$this->set('categorias', $categorias);
		$this->set('laboratorios', $laboratorios);
	}

	public function carrito_admin($transferimport_id = null)
	{

		$this->set('titulo', 'Carritos Transfers');

		$this->viewBuilder()->setLayout('admin2');

		$this->paginate = [
			'contain' => ['Clientes'],
			'limit' => 500,
            'maxLimit' => 500,
			'offset' => 0,
			'order' => ['CarritosTransfers.cliente_id' => 'asc']
		];
        /*
		if ($this->request->is(['patch', 'post', 'put'])) {
			if ($this->request->data['fechadesde'] != null) {
				$fechadesde = $this->request->data['fechadesde'];
			} else {
				$fechadesde = 0;
			}
			if ($this->request->data['fechahasta'] != null) {
				$fechahasta = $this->request->data['fechahasta'];
			} else {
				$fechahasta = 0;
			}
			if ($this->request->data['termino'] != null) {
				$termino = '%' . $this->request->data['termino'] . '%';
			} else {
				$termino = "";
			}

            if ($this->request->data['proveedor_id'] != null) {
				$proveedor_id = $this->request->data['proveedor_id'];
			} else {
				$proveedor_id = "";
			}
            $this->request->session()->write('proveedor_id', $proveedor_id);
			$this->request->session()->write('termino', $termino);
			$this->request->session()->write('fechadesde', $fechadesde);
			$this->request->session()->write('fechahasta', $fechahasta);
		} else {
			$fechahasta = $this->request->session()->read('fechahasta');
			$fechadesde = $this->request->session()->read('fechadesde');
			$termino = $this->request->session()->read('termino');
            $proveedor_id = $this->request->session()->read('proveedor_id');
           
		}
		if ($fechahasta != 0) {
		
			$fechahasta2 = Time::createFromFormat(
				'd/m/Y',
				$fechahasta,
				'America/Argentina/Buenos_Aires'
			);
			$fechahasta2->modify('+1 days');
			$fechahasta2->i18nFormat('yyyy-MM-dd');
		} else {
			$fechahasta2 = Time::now();
			$fechahasta2->modify('+1 days');
		
		}
		if ($fechadesde != 0) {
		
			$fechadesde2 = Time::createFromFormat(
				'd/m/Y',
				$fechadesde,
				'America/Argentina/Buenos_Aires'
			);
			$fechadesde2->i18nFormat('yyyy-MM-dd');
		} else {
			$fechadesde2 = Time::now();
			$fechadesde2->i18nFormat('yyyy-MM-dd');
		}
        */
		$this->loadModel('CarritosTransfers');
        
	
		$carritosA = $this->CarritosTransfers->find()
				->contain(['Articulos',  'Clientes'])
                ->where(['CarritosTransfers.transfers_import_id' => $transferimport_id]);
                
		

        
		if ($carritosA != null) {

			$carritos = $this->paginate($carritosA);
		} else
			$carritos = null;
		$this->set(compact('carritos'));

		$this->categoriaylaboratorio();
	}

    /**
     * View method
     *
     * @param string|null $id Transfers Proveedor id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->viewBuilder()->setLayout('admin');
        $transfersProveedor = $this->TransfersProveedors->get($id, [
            'contain' => ['Proveedors']
        ]);

        $this->set('transfersProveedor', $transfersProveedor);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add_admin()
    {
        $this->set('titulo','Cargar Planilla - Transfers Proveedores');
        
        $this->viewBuilder()->setLayout('admin');
        $this->loadModel('TransfersFilesLaboratorios');
		//$tfl = $this->TransfersFilesLaboratorios->find('all');
        $tfl = $this->TransfersFilesLaboratorios->find('list', ['keyField' => 'id', 'valueField' => 'nombre_laboratorio']);
        $this->set('tfl',$tfl->toArray());

  
    }

    public function pedidos_admin($transferimport_id = null)
    {
		$this->loadModel('PedidosTransfers');
		$this->viewBuilder()->setLayout('admin2');
        $this->paginate = [
			'contain' => ['Clientes'],
			'limit'=>500,
            'maxLimit' => 500,
        ];
		

        $this->loadModel('TransfersImports');
        $transfersImports = $this->TransfersImports->find('all')
        ->contain(['TransfersFilesLaboratorios'])->where(['TransfersImports.id'=>$transferimport_id])->first();
        $this->set('transfersImports',$transfersImports->toArray());
        $this->set('titulo','Pedidos Transfers - '.$transfersImports['transfers_files_laboratorio']['nombre_laboratorio'] .' - '. date_format($transfersImports['importado'],'d-m-Y H:i:s').' '.' - nro: '.$transferimport_id );
	
		
		$pedidos = $this->PedidosTransfers->find('all')
					->contain(['Clientes'])->where(['transfers_import_id'=>$transferimport_id]);
					

        $pedidostransfers = $this->paginate($pedidos);

        $this->set(compact('pedidostransfers'));	
    }

    public function view_admin($id = null)
	{
		$this->viewBuilder()->setLayout('admin2');
       
        if ($this->request->is('post')) {
				
			
        }
        $this->set('titulo','Pedido Transfer '.$id);
		$this->loadModel('PedidosTransfers');
		$pedido = $this->PedidosTransfers->find('all')
		->contain(['Clientes'=> [
						
						'queryBuilder' => function ($q) {
							return $q->where(['cliente_id = Clientes.id ']); // Full conditions for filtering
						}
					]])
				->where(['PedidosTransfers.id' => $id	])->first([]);
			
			
		
		$cliente = $pedido['cliente'];	
			$this->set('cliente',$cliente);
            $this->set('pedido',$pedido); 
		$this->loadModel('PedidosTransfersItems');
        $this->loadModel('PedidosItemsStatus');
		$itemstatus = $this->PedidosItemsStatus->find('list',['keyField' => 'id','valueField'=>'nombre']);
		$this->set('itemstatus', $itemstatus->toArray());
		
	        
		$articulosA = $this->PedidosTransfersItems->find('all')
									
				->contain(['PedidosTransfers','PedidosTransfers.Clientes'=> [
						
						'queryBuilder' => function ($q) {
							return $q->where(['PedidosTransfers.cliente_id = Clientes.id ']); // Full conditions for filtering
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
					
					
					->where(['pedidos_transfer_id' => $id]);
		

		
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
			$pedidosItems = $this->paginate($articulosA);
		}
		else
			$pedidosItems = null;
		
	
		
		$this->categoriaylaboratorio();
		
        $this->set(compact('pedidosItems'));
		
	}

    public function pedidos_all_admin($id = null)
	{
		$this->viewBuilder()->setLayout('admin2');
       
        if ($this->request->is('post')) {
				
			
        }
        $this->loadModel('TransfersImports');
        $transfersImports = $this->TransfersImports->find('all')
        ->contain(['TransfersFilesLaboratorios'])->where(['TransfersImports.id'=>$id])->first();
        $this->set('transfersImports',$transfersImports->toArray());
        $this->set('titulo','Pedidos Transfers - '.$transfersImports['transfers_files_laboratorio']['nombre_laboratorio'] .' - '. date_format($transfersImports['importado'],'d-m-Y H:i:s').' '.' - nro: '.$id );
	
	
		$this->loadModel('PedidosTransfersItems');
        $this->loadModel('PedidosItemsStatus');
		$itemstatus = $this->PedidosItemsStatus->find('list',['keyField' => 'id','valueField'=>'nombre']);
		$this->set('itemstatus', $itemstatus->toArray());
		
	        
		$articulosA = $this->PedidosTransfersItems->find('all')
									
				->contain(['PedidosTransfers','PedidosTransfers.Clientes'=> [
						
						'queryBuilder' => function ($q) {
							return $q->where(['PedidosTransfers.cliente_id = Clientes.id ']); // Full conditions for filtering
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
					
					
					->where(['PedidosTransfers.transfers_import_id' => $id]);
		

		
		if (!empty($articulosA))
		{
				
			$this->paginate = [		
            
			'limit' => 500,
            'maxLimit' => 500,
			'offset' => 0, 
			];
			//'order' => ['Articulos.descripcion_pag' => 'asc']andWhere(['Articulos.eliminado'=>0])-
			$articulosA->order(['PedidosTransfers.id'=>'asc','Articulos.descripcion_pag' => 'asc']);
			$pedidosItems = $this->paginate($articulosA);
		}
		else
			$pedidosItems = null;
		
	
		
		$this->categoriaylaboratorio();
		
        $this->set(compact('pedidosItems'));
		
	}
    public function import_admin()
    {
   

        $this->set('titulo','Importar Planilla - Transfers Proveedores');
        
        $this->viewBuilder()->setLayout('admin2');
        $this->loadModel('TransfersFilesLaboratorios');
		//$tfl = $this->TransfersFilesLaboratorios->find('all');
        $tfl = $this->TransfersFilesLaboratorios->find('list', ['keyField' => 'id', 'valueField' => 'nombre_laboratorio']);
        $this->set('tfl',$tfl->toArray());

    }

    public function file_admin($transfersimport_id = null)
    {
        $this->set('titulo','Generar Archivo Resultado de Planilla - Transfers Proveedores');
        
        $this->viewBuilder()->setLayout('admin');
        $this->set('transfersimport_id', $transfersimport_id);
        $this->loadModel('TransfersFilesLaboratorios');
		//$tfl = $this->TransfersFilesLaboratorios->find('all');
        $tfl = $this->TransfersFilesLaboratorios->find('list', ['keyField' => 'id', 'valueField' => 'nombre_laboratorio']);
        $this->set('tfl',$tfl->toArray());
        /*
        $transfersProveedor = $this->TransfersProveedors->newEntity();
        if ($this->request->is('post')) {
            $transfersProveedor = $this->TransfersProveedors->patchEntity($transfersProveedor, $this->request->getData());
            if ($this->TransfersProveedors->save($transfersProveedor)) {
                $this->Flash->success(__('The transfers proveedor has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The transfers proveedor could not be saved. Please, try again.'));
       
        }
        $proveedors = $this->TransfersProveedors->Proveedors->find('list', ['limit' => 200]);
        */
    }
    
    public function import_linea_txt($line,$tfl, $transfersimport_id , $tfl_id )
    {

            $transfer = $this->TransfersProveedors->newEntity();
           
            $transfer['lab']= rtrim( mb_substr($line,0,4),' ');
            $transfer['drogueria']= rtrim(mb_substr($line,4,8),' ');
            $transfer['cliente']= rtrim(mb_substr($line,16,20),' ');
            
            $fecha_s=  mb_substr($line,36,8);
            $fecha = Time::createFromFormat("Ymd", $fecha_s,'America/Argentina/Buenos_Aires');
            $transfer['fecha_factura'] = $fecha;
            $acuerdo = mb_substr($line,500,540); 
            $pos = strpos($acuerdo, 'PLAZO ');
            if ($pos ==false) 
            $transfer['plazo']  = "30 DIAS";
            else
            {
                $transfer['plazo']  =  mb_substr($acuerdo,$pos+6 ,3);  
                if ($transfer['plazo'] == 'HABITUAL' || $transfer['plazo'] == 'HAB' || $transfer['plazo']=='PLAZO HAB')
                    $transfer['plazo']  = "30 DIAS";
            }
            $transfer['transfer']  = mb_substr($line,44,8);
            $transfer['numero_pedido_proveedor']=rtrim( mb_substr($line,52,10),' ');
            
            $transfer['ean']  = rtrim(mb_substr($line,62,14),' ');
            $transfer['cbarra']  = rtrim(mb_substr($line,62,14),' ');
            
            $transfer['descripcion']  =rtrim( mb_substr($line,90,40),' ');
            $transfer['unidades']  = rtrim( mb_substr($line,130,8),' ');
        
            $transfer['cuit']  = rtrim( mb_substr($line,146,13),' ');
           
            $transfer['nombre'] = rtrim(mb_substr($line,159,100),' ');
            
            $transfer['proveedor_id']  = $tfl['proveedor_id'];
            $transfer['transfers_import_id']= $transfersimport_id;
            $transfer['domicilio']  =  rtrim(mb_substr($line,259,100),' ');
       
            $transfer['localidad']  = rtrim(mb_substr($line,359,30),' ');
            $transfer['provincia']  =  rtrim(mb_substr($line,427,40),' ');
            $transfer['codigo_postal']  = rtrim(mb_substr($line,389,8),' ');
            $transfer['telefono']  = rtrim(mb_substr($line,397,30),' ');

            $transfer['descuento']  =  floatval(rtrim(mb_substr($line,480,3).'.'.mb_substr($line,483,2),' '));        
          

            if ($this->TransfersProveedors->save($transfer)) {                    }

            return $transfer;
    }

    public function importresulttxt($tfl_id =null )
	{
		$this->viewBuilder()->setLayout('admin');
        $file = $this->request->session()->read('file');
                  
			if  (!empty($file))
			{	

                $filename = $file['name'];
                $uploadPath = 'temp/excel/';
                $uploadFile = $uploadPath.$filename;

                $this->loadModel('TransfersFilesLaboratorios');
		        //$tfl = $this->TransfersFilesLaboratorios->find('all');
                $tfl = $this->TransfersFilesLaboratorios->find('all')->where(['id'=>$tfl_id])->first([]);

                $this->loadModel('TransfersImports');
                $transfersImport = $this->TransfersImports->newEntity();
                $transfersImport['transfers_files_laboratorio_id'] = $tfl_id;
                $transfersImport['nombre_file']= $filename;
                $transfersImport['proveedor_id'] = $tfl['proveedor_id'];
                $fecha = date('Y-m-d H:i:s');
                $transfersImport['importado'] = $fecha;
                if ($this->TransfersImports->save($transfersImport)) 
                    $transfersimport_id = $transfersImport['id'];
                else
                    $transfersimport_id =100;
            
                $this->set('transfersimport_id',$transfersimport_id);
                $listaarray=array();
                foreach (file( $uploadFile) as $line) {
                    $line= utf8_decode($line);
                    mb_internal_encoding("UTF-8");
                  
                    $pos = strpos($line, '<CONTROL>');
                    if ($pos ==false) 
                    {
                        $transfer = $this->import_linea_txt($line,$tfl,$transfersimport_id, $tfl_id );
                    }
                    
                    array_push($listaarray,$line);
                 }
                 $this->request->session()->write('listatxt',$listaarray);
			}
			else
			{
				 $this->Flash->error('Seleccione el archivo y el tipo de sistema de pedido',['key' => 'changepass']);
				 return $this->redirect($this->referer());
			}
            return $this->redirect(['action' => 'import_result_admin',$transfersimport_id]);
	}
     public function searchTransfersProveedors($indices)
    {
        $transferIndate =  $this->TransfersProveedors->find('all')->select(['proveedor_id', 'cliente', 'transfer', 'ean', 'unidades'])->where([
            'transfer in' => $indices
        ])->toArray();
        if (!empty($transferIndate)) {
            return $transferIndate;
        }
    }

    public function import_linea_excel($row,$tfl, $transfersimport_id , $tfl_id )
    {
            $transfer = $this->TransfersProveedors->newEntity();
            $format = $tfl['formato_fecha'];
            if ($tfl['id']==4)
            {
                if (!is_null($tfl['numero_pedido_proveedor'] ))  
                       $transfer['numero_pedido_proveedor']= str_pad($row[$tfl['numero_posicion']], 4, "0", STR_PAD_LEFT). str_pad($row[$tfl['numero_pedido_proveedor']], 8, "0", STR_PAD_LEFT);
            }
            else
            {
                if (!is_null($tfl['numero_pedido_proveedor'] ))  $transfer['numero_pedido_proveedor']= $row[$tfl['numero_pedido_proveedor']];
            }
            if ($tfl['id']!=4)    
                if (!is_null($tfl['numero_posicion'] )) $transfer['numero_posicion'] = $row[$tfl['numero_posicion']];
            if (!is_null($tfl['status'] ))  $transfer['status']  = $row[$tfl['status']];
            if (!is_null($tfl['fecha_factura'] )) {
                $fecha_s= $row[$tfl['fecha_factura']];
                if (strlen($fecha_s)<8) $fecha_s= '0'.$fecha_s;
                $fecha = Time::createFromFormat($format, $fecha_s,'America/Argentina/Buenos_Aires');
                $transfer['fecha_factura'] = $fecha;
            }
            if (!is_null($tfl['drogueria'])) $transfer['drogueria']= $row[$tfl['drogueria']];

            if (!is_null($tfl['lab'])) $transfer['lab']= $row[$tfl['lab']];
            if (!is_null($tfl['numero_pedido'])) {
                $transfer['numero_pedido']= $row[$tfl['numero_pedido']];
                $transfer['numero_pedido'] = str_replace( "'", "",$transfer['numero_pedido']);
            }
            if (!is_null($tfl['fecha_transfer'] )){
                $fecha_s= $row[$tfl['fecha_transfer']];
                if (strlen($fecha_s)<8) $fecha_s= '0'.$fecha_s;
                $fecha = Time::createFromFormat($format, $fecha_s,'America/Argentina/Buenos_Aires');
                $transfer['fecha_transfer'] = $fecha;
            }
            if (!is_null($tfl['cliente'] )) {
                
                $codigo_cliente= str_replace( "/", "",$row[$tfl['cliente']]);
                $transfer['cliente']= $codigo_cliente;
                $transfer['cliente'] = str_replace( "'", "",$transfer['cliente']);
            }
            if (!is_null($tfl['nombre'] ))    $transfer['nombre']  = $row[$tfl['nombre']];
            if (!is_null($tfl['ean'] )) { $transfer['ean']  = $row[$tfl['ean']] ;$transfer['cbarra']  = $row[$tfl['ean']];}
            if (!is_null($tfl['descripcion'] ))  { 
                $transfer['descripcion']  = $row[$tfl['descripcion']];
                $transfer['descripcion'] = str_replace( "'", "",$transfer['descripcion']);
                $transfer['descripcion'] = str_replace( '"', "",$transfer['descripcion']);
            }
            if (!is_null($tfl['unidades'] ))  
            {
                $transfer['unidades']  = $row[$tfl['unidades']];
                $transfer['unidades'] = str_replace( "'", "",$transfer['unidades']);
            }
            
            if (!is_null($tfl['descuento'] ))   
            {
                $transfer['descuento']  = str_replace( "'", "",$row[$tfl['descuento']]);
                $transfer['descuento'] = str_replace( ",", ".",$transfer['descuento']);
                
            }
            //if (!is_null($tfl['contacto'] ))   $transfer['contacto']  = $row[$tfl['contacto']];
            //if (!is_null($tfl['telefono'] ))   $transfer['telefono']  = $row[$tfl['telefono']];
            if (!is_null($tfl['cuit'] ))   $transfer['cuit']  = $row[$tfl['cuit']];
            if (!is_null($tfl['domicilio'] ))   $transfer['domicilio']  = $row[$tfl['domicilio']];
            if (!is_null($tfl['codigo_postal'] ))   $transfer['codigo_postal']  = $row[$tfl['codigo_postal']];
            if (!is_null($tfl['localidad'] ))   $transfer['localidad']  = $row[$tfl['localidad']];
            if (!is_null($tfl['provincia'] ))   $transfer['provincia']  = $row[$tfl['provincia']];
            if (!is_null($tfl['transfer'] ))   {

                $transferValue = (int)$row[$tfl['transfer']]; 
                
                $transfer['transfer'] = $transferValue % 1000000000;   
            }
            
            
            if (!is_null($tfl['plazo'] ))  { 
                if (!is_null($row[$tfl['plazo']])) 
                { 
                    if ($row[$tfl['plazo']] =="Habitual" || $row[$tfl['plazo']] =="habitual" || $row[$tfl['plazo']] =="HABITUAL" || $row[$tfl['plazo']] ==0)
                    $transfer['plazo']  = "30 DIAS";
                    else
                    {
                        if (is_numeric($row[$tfl['plazo']]))
                        {
                            $transfer['plazo']  = $row[$tfl['plazo']]." DIAS";
                        }
                        else
                            $transfer['plazo']  = $row[$tfl['plazo']];
                    }
                }
                }
            if (!is_null($tfl['cliente'] )) {
               
                if  ($codigo_cliente == 51225 ) {
                    $transfer['plazo']  = "45 DIAS";
                }
            }    
            if (!is_null($tfl['nro_lote'] ))   $transfer['nro_lote']  = $row[$tfl['nro_lote']];
            if (!is_null($tfl['descuento_especial'] ))   {$transfer['descuento_especial']  = strlen($row[$tfl['descuento_especial']])>0;}
            //$transfer['descuento_especial']=0;
            $transfer['proveedor_id']  = $tfl['proveedor_id'];
            $transfer['transfers_import_id']= $transfersimport_id;
            if ($tfl_id==8)
            {
                
                $ean =str_replace( " ", "",$transfer['cbarra']);
                $transfer['cbarra'] = $ean;
                $transfer['ean'] = $ean;
                $this->loadModel('Articulos');
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
						'type' => 'INNER',
						'conditions' => 'd.articulo_id = Articulos.id and d.tipo_venta in ("D ","  ")',
					])
					->where(['Articulos.categoria_id <'=>7])
					->where(['Articulos.eliminado'=>0])
                    ->where(['Articulos.codigo_barras  LIKE '  => '' . $ean . ''])
                    ->orWhere(['Articulos.codigo_barras2 LIKE' => '' . $ean . ''])->first();
				
                if (!is_null($rowarticulos))
                        {   
                            if (!is_null($tfl['descuento'] ))
                            {   
                                if ($transfer['descuento'] < $rowarticulos['descuentos'][0]['dto_drogueria'])
                                        $transfer['descuento'] = $rowarticulos['descuentos'][0]['dto_drogueria'];
                            }
                            else
                                $transfer['descuento'] = $rowarticulos['descuentos'][0]['dto_drogueria'];
                        }
                        
                $transfer['plazo']= "45 DIAS";

            }

            if ($this->TransfersProveedors->save($transfer)) {                    }

            return $transfer;
    }

    public function importresultexcel()
	{
		$this->viewBuilder()->setLayout('admin');
				
		if ($this->request->is('post'))
		{
			if  (!empty($this->request->data['filetext']))
			{	


				$file = $this->request->data['filetext'];

				$fini = "";//$this->request->data['fini']; // fila inicio
				$fend = "";//$this->request->data['fend']; // fila ultima
				$nsheet= "";//$this->request->data['nsheet']; // nombre de la hoja.
                
                $tfl_id = $this->request->data['tfl_id']; // 
                $uploadPath = 'temp/excel/';
                $uploadFile = $uploadPath.$this->request->data['filetext']['name'];
                move_uploaded_file($this->request->data['filetext']['tmp_name'],$uploadFile);
                if ($tfl_id ==17)
                {
                    $this->request->session()->write('file',$file);
                  
                    return $this->redirect(['action' => 'importresulttxt',$tfl_id]);
                }
                else
                    {
                    $this->loadModel('TransfersFilesLaboratorios');
                    //$tfl = $this->TransfersFilesLaboratorios->find('all');
                    $tfl = $this->TransfersFilesLaboratorios->find('all')->where(['id'=>$tfl_id])->first([]);
                    //if ($this->request->data['cini'] == "" ||  $this->request->data['cend'] == "" ) {
                        $cini = $tfl['col_desde']; // columna inicio
                        $cend = $tfl['col_hasta']; // columna ultima
                        $ffirst =$tfl['fil_first'];
                    /*}
                    else
                    {
                            $cini = $this->request->data['cini']; // columna inicio
                            $cend = $this->request->data['cend']; // columna ultima
                            $ffirst = 1;
                    }*/

                    //if ($transfersImport  )

                    //$sistema = $this->request->data['cend']; // Sistema.
                                    
                    $this->loadModel('TransfersImports');
                    $transfersImport = $this->TransfersImports->newEntity();
                    $transfersImport['transfers_files_laboratorio_id'] = $tfl_id;
                    $transfersImport['nombre_file']= $this->request->data['filetext']['name'];
                    $transfersImport['proveedor_id'] = $tfl['proveedor_id'];
                    $fecha = date('Y-m-d H:i:s');
                    $transfersImport['importado'] = $fecha;
                    
                        if ($this->TransfersImports->save($transfersImport)) {
                            $transfersimport_id = $transfersImport['id'];
                            
                        }
                        else
                        $transfersimport_id =100;

                    //$helper->log('Loading file ' . pathinfo($inputFileName, PATHINFO_BASENAME) . ' using IOFactory with a defined reader type of ' . $inputFileType);

                    $tipo = IOFactory::identify($uploadFile);
                    if (($tipo == 'Xlsx') || ($tipo == 'Xls')) {
                        $tipo = IOFactory::identify($uploadFile);
                    } else {
                        $this->Flash->error('Seleccione una planilla de excel con extención xls o xlsx', ['key' => 'changepass']);
                        return $this->redirect($this->referer());
                    }
                    
                    $reader = IOFactory::createReader($tipo);

                    
                    if (strlen($nsheet)==0)
                    {
                    $worksheetList = $reader->listWorksheetNames($uploadFile);
                    $sheetname = $worksheetList[0]; 

                    }
                    else
                    $sheetname = $nsheet;
                    
                    $reader->setLoadSheetsOnly($sheetname);

                    //$reader->setReadFilter($filterSubset);
                    $spreadsheet = $reader->load($uploadFile);
                    $rango = $cini.$fini.":".$cend.$fend;
                    
                    //if ($this->request->data['fini'] == "" ||  $this->request->data['fend'] == "" ) 
                        $dataArray = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
                        /*
                        else

                        $dataArray = $spreadsheet->getActiveSheet()
                        ->rangeToArray(
                            $rango,     // The worksheet range that we want to retrieve
                            NULL,        // Value that should be returned for empty cells
                            TRUE,        // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
                            TRUE,        // Should values be formatted (the equivalent of getFormattedValue() for each cell)
                            TRUE         // Should the array be indexed by cell row and cell column
                        );*/
                    
                    $this->request->session()->write('ImportadoEXCEL',$dataArray);
                        


                    $listaarray=array();
                    $contadorDuplicados = 0;
                    $duplicados = [];
                    $inicio =0;
                      $searchIndices = [];
                    $contadorIndices = 0;
                     if (!empty($tfl) && !empty($dataArray)) {

                        $arrayItems = new Collection($dataArray);
                        $grouped = $arrayItems->groupBy($tfl['numero_pedido_proveedor'])->toArray();
                        $indices = array_keys($grouped);
                        foreach ($indices as $indice) {
                             $contadorIndices++;
                            if ($contadorIndices > 0) {
                                array_push($searchIndices, $indice);
                            }
                           
                        }

                        // Verifica las claves
                    }
                 $acuerdoTotales = $this->searchTransfersProveedors($searchIndices);

                    foreach ($dataArray  as $row) {
                        if ($inicio< $ffirst)
                            {
                                $inicio++;
                            }
                            else
                            {
                                //$leeryguardar($row);
                                $inicio++;
                            
                        if (!empty($acuerdoTotales)) {

                                if (!is_null($tfl['cliente'])) {

                                    $codigo_cliente_validate = str_replace("/", "", $row[$tfl['cliente']]);

                                    $codigo_cliente = str_replace("'", "", $codigo_cliente_validate);
                                }


                                // Buscar si el registro ya existe en $acuerdoTotales
                                $existe = array_filter($acuerdoTotales, function ($acuerdo) use ($row, $tfl, $codigo_cliente) {
                                    return
                                        $acuerdo['proveedor_id'] == $tfl['proveedor_id'] &&
                                        $acuerdo['cliente'] == $codigo_cliente &&
                                        $acuerdo['transfer'] == $row[$tfl['numero_pedido_proveedor']] &&
                                        $acuerdo['ean'] == $row[$tfl['ean']] &&
                                        $acuerdo['unidades'] == $row[$tfl['unidades']];
                                });

                                // Si ya existe, omitir este registro
                                if (!empty($existe)) {
                                    $contadorDuplicados++;
                                    continue;
                                }
                            }
                        $transfer = $this->import_linea_excel($row,$tfl,$transfersimport_id, $tfl_id);
                        array_push($listaarray,$transfer);
                    }		
				}
				if ($contadorDuplicados > 0) {
                        //  dd(['contador'=> $inicio, 'duplicados'=> $contadorDuplicados]);
                        if ($inicio - 1 == $contadorDuplicados) {
                            $this->Flash->error('Este tranfer contiene todos los "ITEMS DUPLICADOS" ', ['key' => 'changepass']);

                            $this->delete_import_admin($transfersImport->id);
                            $this->request->session()->write('eanDuplicados', $duplicados);
                        } else {
                            $this->Flash->error('Este tranfer contiene algunos "ITEMS DUPLICADOS" ', ['key' => 'changepass']);
                        }
                        }
                    
				$this->request->session()->write('listaarray',$listaarray);
				return $this->redirect(['action' => 'import_result_admin', $transfersimport_id]);
            }
			}
			else
			{
				 $this->Flash->error('Seleccione el archivo y el tipo de sistema de pedido',['key' => 'changepass']);
				 return $this->redirect($this->referer());
			}
		}
	//	return $this->redirect(['action' => 'import_result_admin',$transfersimport_id]);
	}

    /**
     * Edit method
     *
     * @param string|null $id Transfers Proveedor id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $transfersProveedor = $this->TransfersProveedors->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $transfersProveedor = $this->TransfersProveedors->patchEntity($transfersProveedor, $this->request->getData());
            if ($this->TransfersProveedors->save($transfersProveedor)) {
                $this->Flash->success(__('The transfers proveedor has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The transfers proveedor could not be saved. Please, try again.'));
        }
        $proveedors = $this->TransfersProveedors->Proveedors->find('list', ['limit' => 200]);
        $this->set(compact('transfersProveedor', 'proveedors'));
    }

    public function itemupdateimport() {
		$this->loadComponent('RequestHandler');
        if ($this->request->is(['ajax','post'])) {
            $id = $this->request->data['id'];
            $codigo = isset($this->request->data['codigo']) ? $this->request->data['codigo'] : 1;
    		$ean = $this->request->data['ean'];	
            $dcto = $this->request->data['dcto'];	
           
            $import = $this->TransfersProveedors->find('all')->where(['id'=>$id])->first();

			$responseData = ['success' => false,'responseText'=>"''",'status'=>400 ];		


                if (empty($import))
                {
                    $responseData = ['success' => false, 'responseText'=>"'No se pudo modificar correctamente,'",'status'=>400 ];
                }
		
			    /*echo json_encode($quantity); ->pasar datos*/
				if (((int)$codigo>0) && ((int)$codigo<999999))
				{
                    $import['ean'] = $ean;
					$import['cliente'] = $codigo;
                    $import['descuento'] = $dcto;

				if ($this->TransfersProveedors->save($import)) {
							$responseData = ['success' => true,'responseText'=>"'Se modifico correctamente.'",'status'=>200,'import'=>$import ];						
				} 
				else
				{
							$responseData = ['success' => false, 'responseText'=>"'No se pudo modificar correctamente,'",'status'=>400 ];
										
				}

				}

				echo json_encode($responseData);

				//echo json_encode($carro);
				$this->set('responseData', $responseData);
				$this->set('cart', $import);
				$this->set('_serialize', ['responseData','cart']);
				

			
				//echo json_encode($carro);
			//$product = $this->Cart->add($id, $quantity, $productmodId);
        }
        //$cart = $this->CarritosPreventas->getcart();
        
        die;
    }

    public function itemupdate() {
		$this->loadComponent('RequestHandler');
        if ($this->request->is(['ajax','post'])) {
            $id = $this->request->data['id'];
            $quantity = isset($this->request->data['quantity']) ? $this->request->data['quantity'] : 1;
    		$plazo = $this->request->data['plazo'];	

			$this->loadModel('CarritosTransfers');

			$carro = $this->CarritosTransfers->find()->where(['id'=>$id])->first([]);

			$responseData = ['success' => false,'responseText'=>"''",'status'=>400 ];		


                if (empty($carro))
                {
                    $responseData = ['success' => false, 'responseText'=>"'No se pudo modificar correctamente,'",'status'=>400 ];
                }
		
			    /*echo json_encode($quantity); ->pasar datos*/
				if (((int)$quantity>0) && ((int)$quantity<10000))
				{
                    $carro['plazoley_dcto'] = $plazo;
					$carro['cantidad'] = $quantity;

				if ($this->CarritosTransfers->save($carro)) {
							$responseData = ['success' => true,'responseText'=>"'Se modifico correctamente.'",'status'=>200,'carro'=>$carro ];						
				} 
				else
				{
							$responseData = ['success' => false, 'responseText'=>"'No se pudo modificar correctamente,'",'status'=>400 ];
										
				}

				}
				else
				{
					
					if ((int)$quantity==0)
					{
						
						$carro =$this->CarritosTransfers->find('all')
										->where(['id' => $id])			
										->first();
						if ($carro !=null)
						{	
							
							if ($this->CarritosTransfers->delete($carro)) 
							$responseData = ['success' => true,'responseText'=>"'Se modifico la cantidad correctamente.'",'status'=>200,'carro'=>$carro];		
						}

					}
				}
				echo json_encode($responseData);

				//echo json_encode($carro);
				$this->set('responseData', $responseData);
				$this->set('cart', $carro);
				$this->set('_serialize', ['responseData','cart']);
				

			
				//echo json_encode($carro);
			//$product = $this->Cart->add($id, $quantity, $productmodId);
        }
        //$cart = $this->CarritosPreventas->getcart();
        
        die;
    }


    /**
     * Delete method
     *
     * @param string|null $id Transfers Proveedor id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */

    public function downloadfiletxt()
    {
		

        $this->set('titulo','Generar txt');
        $this->viewBuilder()->setLayout('admin');
        $this->paginate = [
            'contain' => ['Proveedors']
        ];
        $transfersProveedors =$this->TransfersProveedors->find();

        //$this->set(compact('transfersProveedors'));


		if (empty($transfersProveedors))
		{ $this->Flash->error(__('Momentaneamente no disponible, intente mas tarde.'),['key' => 'changepass']);
			$this->redirect($this->referer());}
		else
		{
            $ultimonumero = $this->request->data['ultimo'];
            $periodo = $this->request->data['periodo'];//201908
            $unidades =0;
            $items = 0;  
            foreach ($transfersProveedors as $row): 
                $unidades += $row['unidades'];
                $items++;
			endforeach;    
			$nombreArchivo= 'TR_010378_'.str_pad($periodo, 4, "0", STR_PAD_LEFT).'_'.str_pad($unidades, 6, "0", STR_PAD_LEFT).'_'.str_pad($items, 6, "0", STR_PAD_LEFT).'_'.str_pad($ultimonumero+1, 3, "0", STR_PAD_LEFT);
			$file = new File('temp'. DS .'Comprobantes'. DS .$nombreArchivo.'.TXT', true, 0777);
			//$file->write("\n",'w');
				 /*
					$line =   '0'.
						str_pad($this->request->session()->read('Auth.User.codigo'), 8, "0", STR_PAD_LEFT).
						str_pad("", 2," ").
						str_pad($id, 8, 0,STR_PAD_LEFT)."\r\n";
				$file->write($line,'w');
                */
              
			foreach ($transfersProveedors as $row): 
                if ($row['status']>1)
                    $x='00.00';
                    else
                    $x =   strval($row['descuento']);
                    $precio_n = strval($row['precio_neto']);
                    $descripcion = str_replace("Ñ", "N", $row['descripcion']);
                    $descripcion = str_replace("Á", "A", $descripcion);
                    $descripcion = str_replace("É", "E", $descripcion);
                    $descripcion = str_replace("Í", "I", $descripcion);
                    $descripcion = str_replace("Ó", "O", $descripcion);
                    $descripcion = str_replace("Ú", "U", $descripcion);
                    $descripcion = str_replace("Ü", "U", $descripcion);

                    $domicilio = str_replace("Ñ", "N", $row['domicilio']);
                    $domicilio = str_replace("Á", "A", $domicilio);
                    $domicilio = str_replace("É", "E", $domicilio);
                    $domicilio = str_replace("Í", "I", $domicilio);
                    $domicilio = str_replace("Ó", "O", $domicilio);
                    $domicilio = str_replace("Ú", "U", $domicilio);
                    $domicilio = str_replace("°", " ", $domicilio);

                    $localidad = str_replace("Ñ", "N", $row['localidad']);
                    $localidad = str_replace("Á", "A", $localidad);
                    $localidad = str_replace("É", "E", $localidad);
                    $localidad = str_replace("Í", "I", $localidad);
                    $localidad = str_replace("Ó", "O", $localidad);
                    $localidad = str_replace("Ú", "U", $localidad);

                    $razon = str_replace("Ñ", "N", $row['nombre']);
                    $razon = str_replace("Á", "A", $razon);
                    $razon = str_replace("É", "E", $razon);
                    $razon = str_replace("Í", "I", $razon);
                    $razon = str_replace("Ó", "O", $razon);
                    $razon = str_replace("Ú", "U", $razon);

                    
                $factura = str_pad($row['factura_seccion'], 4, "0", STR_PAD_LEFT).'A'.str_pad($row['factura_numero'], 8, "0", STR_PAD_LEFT);
				$line = 
                str_pad($row['numero_pedido_proveedor'], 16,0,STR_PAD_LEFT).
                str_pad($row['numero_posicion'], 16,0,STR_PAD_LEFT).
                str_pad($row['drogueria'], 6,0,STR_PAD_LEFT).
                date_format($row['fecha_factura'],'dmY').
                $factura.
                str_pad($row['cliente'], 10, "0", STR_PAD_LEFT).
                str_pad($row['ean'], 15, "0", STR_PAD_LEFT).
                str_pad($descripcion, 40," ",STR_PAD_RIGHT).
                str_pad($row['unidades'], 6, "0", STR_PAD_LEFT).     
                str_pad($row['status'], 3, "0", STR_PAD_LEFT).   
                str_pad(number_format($precio_n,2, '.', ''), 10, "0", STR_PAD_LEFT). 
                str_pad(number_format($row['descuento'],2, '.', ''), 5, "0", STR_PAD_LEFT).$periodo.
                str_pad($razon, 35," ",STR_PAD_RIGHT). 
                str_pad($row['cuit'], 11).  
                str_pad($row['codigo_postal'], 8, " ", STR_PAD_LEFT).  
                str_pad($domicilio, 40, " ", STR_PAD_RIGHT).  
                str_pad($localidad, 40, " ", STR_PAD_RIGHT).  
                str_pad($row['provincia'], 2, "0", STR_PAD_LEFT).  
                "1".
                str_pad(number_format($precio_n,2, '.', ''), 16, "0", STR_PAD_LEFT). 
                "\r\n";
				$file->write($line,'w');
				
			endforeach; 
			$file->close(); // Be sure to close the file when you're done
            
            
            $this->response->type('txt');
			$nombre_fichero = 'temp'. DS .'Comprobantes'. DS .$nombreArchivo.'.TXT';

				if (file_exists($nombre_fichero)) {
					$this->response->file(
					'temp'. DS .'Comprobantes'. DS .$nombreArchivo.'.TXT',
					['download' => true, 'name' => $nombreArchivo.'.TXT']
					);
				}

			return $this->response;
			
		}
	   
    }

    public function downloadfiletxtfortransfer($transfersimport_id = null )
    {
		

        $this->set('titulo','Generar txt');
        $this->viewBuilder()->setLayout('admin');
        $this->paginate = [
            'contain' => ['Proveedors']
        ];
        $transfersProveedors =$this->TransfersProveedors->find()->where(["transfers_import_id" =>$transfersimport_id]);

        //$this->set(compact('transfersProveedors'));


		if (empty($transfersProveedors))
		{ $this->Flash->error(__('Momentaneamente no disponible, intente mas tarde.'),['key' => 'changepass']);
			$this->redirect($this->referer());}
		else
		{
            $ultimonumero = $this->request->data['ultimo'];
            $periodo = $this->request->data['periodo'];//201908
            $unidades =0;
            $items = 0;  
            foreach ($transfersProveedors as $row): 
                $unidades += $row['unidades'];
                $items++;
			endforeach;    
			$nombreArchivo= 'TR_010378_'.str_pad($periodo, 4, "0", STR_PAD_LEFT).'_'.str_pad($unidades, 6, "0", STR_PAD_LEFT).'_'.str_pad($items, 6, "0", STR_PAD_LEFT).'_'.str_pad($ultimonumero+1, 3, "0", STR_PAD_LEFT);
			$file = new File('temp'. DS .$nombreArchivo.'.TXT', true, 0777);
			//$file->write("\n",'w');
				 /*
					$line =   '0'.
						str_pad($this->request->session()->read('Auth.User.codigo'), 8, "0", STR_PAD_LEFT).
						str_pad("", 2," ").
						str_pad($id, 8, 0,STR_PAD_LEFT)."\r\n";
				$file->write($line,'w');
                */
              
			foreach ($transfersProveedors as $row): 
                if ($row['status']>1)
                    $x='00.00';
                    else
                    $x =   strval($row['descuento']);
                    $precio_n = strval($row['precio_neto']);
                    $descripcion = str_replace("Ñ", "N", $row['descripcion']);
                    $descripcion = str_replace("Á", "A", $descripcion);
                    $descripcion = str_replace("É", "E", $descripcion);
                    $descripcion = str_replace("Í", "I", $descripcion);
                    $descripcion = str_replace("Ó", "O", $descripcion);
                    $descripcion = str_replace("Ú", "U", $descripcion);
                    $descripcion = str_replace("Ü", "U", $descripcion);

                    $domicilio = str_replace("Ñ", "N", $row['domicilio']);
                    $domicilio = str_replace("Á", "A", $domicilio);
                    $domicilio = str_replace("É", "E", $domicilio);
                    $domicilio = str_replace("Í", "I", $domicilio);
                    $domicilio = str_replace("Ó", "O", $domicilio);
                    $domicilio = str_replace("Ú", "U", $domicilio);
                    $domicilio = str_replace("°", " ", $domicilio);

                    $localidad = str_replace("Ñ", "N", $row['localidad']);
                    $localidad = str_replace("Á", "A", $localidad);
                    $localidad = str_replace("É", "E", $localidad);
                    $localidad = str_replace("Í", "I", $localidad);
                    $localidad = str_replace("Ó", "O", $localidad);
                    $localidad = str_replace("Ú", "U", $localidad);

                    $razon = str_replace("Ñ", "N", $row['nombre']);
                    $razon = str_replace("Á", "A", $razon);
                    $razon = str_replace("É", "E", $razon);
                    $razon = str_replace("Í", "I", $razon);
                    $razon = str_replace("Ó", "O", $razon);
                    $razon = str_replace("Ú", "U", $razon);

                    
                    $factura = str_pad($row['factura_seccion'], 5, "0", STR_PAD_LEFT).'A'.str_pad($row['factura_numero'], 8, "0", STR_PAD_LEFT);
				$line = 
                str_pad($row['numero_pedido_proveedor'], 16,0,STR_PAD_LEFT).
                str_pad($row['numero_posicion'], 16,0,STR_PAD_LEFT).
                str_pad($row['drogueria'], 6,0,STR_PAD_LEFT).
                date_format($row['fecha_factura'],'dmY').
                $factura.
                str_pad($row['cliente'], 10, "0", STR_PAD_LEFT).
                str_pad($row['ean'], 15, "0", STR_PAD_LEFT).
                str_pad($descripcion, 40," ",STR_PAD_RIGHT).
                str_pad($row['unidades'], 6, "0", STR_PAD_LEFT).     
                str_pad($row['status'], 3, "0", STR_PAD_LEFT).   
                str_pad(number_format($precio_n,2, '.', ''), 10, "0", STR_PAD_LEFT). 
                str_pad(number_format($row['descuento'],2, '.', ''), 5, "0", STR_PAD_LEFT).$periodo.
                str_pad($razon, 35," ",STR_PAD_RIGHT). 
                str_pad($row['cuit'], 11).  
                str_pad($row['codigo_postal'], 8, " ", STR_PAD_LEFT).  
                str_pad($domicilio, 40, " ", STR_PAD_RIGHT).  
                str_pad($localidad, 40, " ", STR_PAD_RIGHT).  
                str_pad($row['provincia_id'], 2, "0", STR_PAD_LEFT).  
                "1".
                "\r\n";
				$file->write($line,'w');
				
			endforeach; 
			$file->close(); // Be sure to close the file when you're done
            
            $conn = ConnectionManager::get('default');
            $fecha = date('Y-m-d H:i:s');
            $conn->query('UPDATE transfers_imports SET txt_generado ="'.$fecha.'" where id= '.$transfersimport_id.';');


            $this->response->type('txt');
			$nombre_fichero = 'temp'. DS .$nombreArchivo.'.TXT';

				if (file_exists($nombre_fichero)) {
					$this->response->file(
					'temp'. DS .$nombreArchivo.'.TXT',
					['download' => true, 'name' => $nombreArchivo.'.TXT']
					);
				}

			return $this->response;
			
		}
	   
    }

    public function downloadfiletxtforday()
    {
		



        $this->set('titulo','Generar txt');
        $this->viewBuilder()->setLayout('admin');
        $this->paginate = [
            'contain' => ['Proveedors']
        ];


        $option_prov = $this->request->data['option_prov'];
        $ultimo = $this->request->data['ultimo'];
        $periodo =$this->request->data['periodo'];
        $fechadesde = $this->request->data['fechadesde'];
        $fechahasta = $this->request->data['fechahasta'];

        $conn = ConnectionManager::get('default');
           
        $conn->query('UPDATE transfers_proveedors SET precio_neto =0.00 WHERE precio_neto IS NULL;');
        
           

        if ($this->request->data['fechahasta']!= null)
		{
			//$fechahasta2 = Time::now();
			$fechahasta2 = Time::createFromFormat(
			'd/m/Y',
			$fechahasta,
			'America/Argentina/Buenos_Aires');
			$fechahasta2->modify('+1 days');
			$fechahasta2->i18nFormat('yyyy-MM-dd');
		}
		else
		{
			$fechahasta2 = Time::now();
			$fechahasta2-> modify('+1 days');
			//$fechahasta2 = $fechahasta2->i18nFormat('yyyy-MM-dd');
		}

		if ($this->request->data['fechadesde']!= null)
		{
			//$fechadesde2 = Time::now();
			$fechadesde2 = Time::createFromFormat(
				'd/m/Y',
			$fechadesde,
			'America/Argentina/Buenos_Aires');
			$fechadesde2->i18nFormat('yyyy-MM-dd');
		}
		else
		{
			$fechadesde2 = Time::now();
			$fechadesde2->i18nFormat('yyyy-MM-dd');
		}


        $transfersProveedors =$this->TransfersProveedors->find()
        ->join([
            'table' => 'transfers_imports',
            'alias' => 'i',
            'type' => 'inner',
            'conditions' => ['i.id = TransfersProveedors.transfers_import_id']
        ])           
        ->where(["i.transfers_files_laboratorio_id" =>$option_prov])
        ->andWhere(["TransfersProveedors.procesado BETWEEN '".$fechadesde2->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta2->i18nFormat('yyyy-MM-dd')."'"]);

        if ($option_prov ==1)
        $transfersProveedors->andWhere(["TransfersProveedors.status>1"]);


        
        
		if (empty($transfersProveedors))
		{ $this->Flash->error(__('Momentaneamente no disponible, intente mas tarde.'),['key' => 'changepass']);
			$this->redirect($this->referer());}
		else
		{
            $this->set('transfersProveedors',$transfersProveedors->toArray());
            $ultimonumero = $this->request->data['ultimo'];
            $periodo = $this->request->data['periodo'];//201908
            $unidades =0;
            $items = 0;  
            foreach ($transfersProveedors as $row): 
                $unidades += $row['unidades'];
                $items++;
			endforeach;    
			$nombreArchivo= 'TR_010378_'.str_pad($periodo, 4, "0", STR_PAD_LEFT).'_'.str_pad($unidades, 6, "0", STR_PAD_LEFT).'_'.str_pad($items, 6, "0", STR_PAD_LEFT).'_'.str_pad($ultimonumero+1, 3, "0", STR_PAD_LEFT);
			$file = new File('temp'. DS .$nombreArchivo.'.TXT', true, 0777);
			//$file->write("\n",'w');
				 /*
					$line =   '0'.
						str_pad($this->request->session()->read('Auth.User.codigo'), 8, "0", STR_PAD_LEFT).
						str_pad("", 2," ").
						str_pad($id, 8, 0,STR_PAD_LEFT)."\r\n";
				$file->write($line,'w');
                */
              
			foreach ($transfersProveedors as $row): 
                if ($row['status']>1)
                    $x='00.00';
                    else
                    $x =   strval($row['descuento']);
                    $precio_n = strval($row['precio_neto']);
                    $descripcion = str_replace("Ñ", "N", $row['descripcion']);
                    $descripcion = str_replace("Á", "A", $descripcion);
                    $descripcion = str_replace("É", "E", $descripcion);
                    $descripcion = str_replace("Í", "I", $descripcion);
                    $descripcion = str_replace("Ó", "O", $descripcion);
                    $descripcion = str_replace("Ú", "U", $descripcion);
                    $descripcion = str_replace("Ü", "U", $descripcion);

                    $domicilio = str_replace("Ñ", "N", $row['domicilio']);
                    $domicilio = str_replace("Á", "A", $domicilio);
                    $domicilio = str_replace("É", "E", $domicilio);
                    $domicilio = str_replace("Í", "I", $domicilio);
                    $domicilio = str_replace("Ó", "O", $domicilio);
                    $domicilio = str_replace("Ú", "U", $domicilio);
                    $domicilio = str_replace("°", " ", $domicilio);

                    $localidad = str_replace("Ñ", "N", $row['localidad']);
                    $localidad = str_replace("Á", "A", $localidad);
                    $localidad = str_replace("É", "E", $localidad);
                    $localidad = str_replace("Í", "I", $localidad);
                    $localidad = str_replace("Ó", "O", $localidad);
                    $localidad = str_replace("Ú", "U", $localidad);

                    $razon = str_replace("Ñ", "N", $row['nombre']);
                    $razon = str_replace("Á", "A", $razon);
                    $razon = str_replace("É", "E", $razon);
                    $razon = str_replace("Í", "I", $razon);
                    $razon = str_replace("Ó", "O", $razon);
                    $razon = str_replace("Ú", "U", $razon);

                    
                    $factura = str_pad($row['factura_seccion'], 5, "0", STR_PAD_LEFT).'A'.str_pad($row['factura_numero'], 8, "0", STR_PAD_LEFT);
				$line = 
                str_pad($row['numero_pedido_proveedor'], 16,0,STR_PAD_LEFT).
                str_pad($row['numero_posicion'], 16,0,STR_PAD_LEFT).
                str_pad($row['drogueria'], 6,0,STR_PAD_LEFT).
                date_format($row['fecha_factura'],'dmY').
                $factura.
                str_pad($row['cliente'], 10, "0", STR_PAD_LEFT).
                str_pad($row['ean'], 15, "0", STR_PAD_LEFT).
                str_pad($descripcion, 40," ",STR_PAD_RIGHT).
                str_pad($row['unidades'], 6, "0", STR_PAD_LEFT).     
                str_pad($row['status'], 3, "0", STR_PAD_LEFT).   
                str_pad(number_format($precio_n,2, '.', ''), 10, "0", STR_PAD_LEFT). 
                str_pad(number_format($row['descuento'],2, '.', ''), 5, "0", STR_PAD_LEFT).$periodo.
                str_pad($razon, 35," ",STR_PAD_RIGHT). 
                str_pad($row['cuit'], 11).  
                str_pad($row['codigo_postal'], 8, " ", STR_PAD_LEFT).  
                str_pad($domicilio, 40, " ", STR_PAD_RIGHT).  
                str_pad($localidad, 40, " ", STR_PAD_RIGHT).  
                str_pad($row['provincia_id'], 2, "0", STR_PAD_LEFT).  
                "1".
                "\r\n";
				$file->write($line,'w');
				
			endforeach; 
			$file->close(); // Be sure to close the file when you're done
            
            

            $this->response->type('txt');
			$nombre_fichero = 'temp'. DS .$nombreArchivo.'.TXT';

				if (file_exists($nombre_fichero)) {
					$this->response->file(
					'temp'. DS .$nombreArchivo.'.TXT',
					['download' => true, 'name' => $nombreArchivo.'.TXT']
					);
				}

			return $this->response;
			
		}
	   
    }


    public function delete_item_admin($transfer_proveedors_id = null, $transfersimport_id =null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $conn = ConnectionManager::get('default');
        
        $this->loadModel('TransfersImports');
        $transfersImport = $this->TransfersImports->get($transfersimport_id, [
            'contain' => []
        ]);
        if (!is_null($transfersImport['facturado']))
        {
            $this->Flash->error(__('No se puede Eliminar, poque ya se mando los pedidos a facturar'),['key' => 'changepass']);
            return $this->redirect(['action' => 'import_result_admin',$transfersimport_id]);
        }  

        if ($transfersImport['proveedor_id'] !=443) 
        {
        $conn->query('DELETE FROM carritos_transfers where transfer_proveedor_id = '.$transfer_proveedors_id.';');
        $conn->query('DELETE FROM transfers_proveedors where id = '.$transfer_proveedors_id.';');
        }
        else
    
        {

            //action="/ds/transfers_proveedors/delete_item_admin/909154/7046"
            
            $conn->query('UPDATE transfers_proveedors SET status= 61 where id = '.$transfer_proveedors_id.';');

        }   

        
        $this->Flash->success(__('Se elimino los registros importados n°: '.$transfer_proveedors_id ),['key' => 'changepass']);
        return $this->redirect($this->referer());
        //return $this->redirect(['action' => 'import_result_admin',$transfersimport_id]);
        
    }

    public function delete_import_admin($transfersimport_id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $conn = ConnectionManager::get('default');
        
        $this->loadModel('TransfersImports');
        $transfersImport = $this->TransfersImports->get($transfersimport_id, [
            'contain' => []
        ]);
        if (!is_null($transfersImport['facturado']))
        {
            $this->Flash->error(__('No se puede Eliminar, poque ya se mando los pedidos a facturar'),['key' => 'changepass']);
            return $this->redirect(['action' => 'index_admin']);
        }  

        $conn->query('DELETE FROM carritos_transfers where transfers_import_id = '.$transfersimport_id.';');
        $conn->query('DELETE FROM transfers_proveedors where transfers_import_id = '.$transfersimport_id.';');
        $conn->query('DELETE FROM transfers_imports where id = '.$transfersimport_id.';');
        
        $this->Flash->success(__('Se elimino los registros importados n°: '.$transfersimport_id ),['key' => 'changepass']);
        

        return $this->redirect(['action' => 'index_admin']);
    }
}
