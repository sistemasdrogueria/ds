<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\Filesystem\File;
use Cake\Network\Request;
use Cake\Collection\Collection;
use Cake\Core\Configure;
use Cake\Http\Client;
/**
 * FacturasCabeceras Controller
 *
 * @property \App\Model\Table\FacturasCabecerasTable $FacturasCabeceras
 */
class EstadisticasController extends AppController
{
	public function isAuthorized()
    {
		if (in_array($this->request->action, ['search','home','index','provincia', 'ranking', 'viewOfertsToLose', 'searchOfertsToLose', 'validateRecaptcha', 'excelToDownload'])) {
       
				if($this->request->session()->read('Auth.User.role')=='admin') 
				{				
					return true;			
				}			
				else 
				{	
					if($this->request->session()->read('Auth.User.role')=='client') 
					{	
						$tiene= $this->tienepermiso('estadisticas',$this->request->action);
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

	public function provincia()
	{
		$this->viewBuilder()->layout('storeestadistica');
		
		$this->loadModel('VentasDiarias');
		
			
		$fechadesde = Time::now();
		$fechadesde->setDate($fechadesde->year, $fechadesde->month, 1);
		$fechahasta = Time::now();
		$fechahasta->setDate($fechahasta->year, $fechahasta->month, 1);
		$fechadesde-> modify('-1 year');
		$fechahasta-> modify('-1 day');
		
		//$fechadesde->i18nFormat('yyyy-MM-dd');
		
		
		$resultventas = $this->VentasDiarias->find('all')
						->select(['anio'=>'YEAR(fecha)','mes' =>'MONTH(fecha)','total_u'=>'SUM(u_1)+SUM(u_2)+SUM(u_6)+SUM(u_7)+SUM(u_3)+SUM(u_4)+SUM(u_5)','total_m'=>'SUM(u_1)+SUM(u_2)+SUM(u_6) + SUM(u_7)',
						'total_pya'=>'SUM(u_3)+SUM(u_4)+SUM(u_5)', 'total_transf' =>'SUM(u_t)' ])										
						
						->andWhere(["fecha BETWEEN '".$fechadesde->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta->i18nFormat('yyyy-MM-dd')."'"])
						->group(['YEAR(fecha), MONTH(fecha)']);
		
		
/*
		$query = $articles->find(); $resultventas->toArray()
		$query->select(['count' => $query->func()->count('*')]);*/
		$this->set('resultventas', $this->paginate($resultventas));
		
		$fila = array();
		$respestadistica=array();
		
		foreach ($resultventas as $resultventa): 
		
		
			$respartcompras = array();
			$respartcompras['total_u']= $resultventa['total_u'];
			$respartcompras['total_m.']= $resultventa['total_m'];
			$respartcompras['total_pya']= $resultventa['total_pya'];
			$respartcompras['total_transf']= $resultventa['total_transf'];
			
			$indice = $resultventa['anio'].str_pad($resultventa['mes'], 2, "0", STR_PAD_LEFT);
			$respestadistica[$indice]=$respartcompras;
		endforeach;  
		$this->set('respestadistica', $respestadistica);
		

        //$this->set('ventasdiarias', $this->paginate($ventasdiarias));
        $this->set('_serialize', ['ventasdiarias']);
		
	}

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
		$this->viewBuilder()->layout('store_estadistica');
		
        $this->paginate = [
            
			'limit' => 100
        ];
		$fecha = Time::now();
		$fecha->setDate($fecha->year, $fecha->month, 1);
		
		if ($this->request->is('post'))
		{	
			
			if (!empty($this->request->data['fechadesde']))
				$fechad = $this->request->data['fechadesde'];
			else
				$fechad=0;
			if (!empty($this->request->data['fechahasta']))
				$fechah = $this->request->data['fechahasta'];
			else
				$fechah =0;
			if ($this->request->data['meses']!= null)
				$meses = $this->request->data['meses'];
			else
				$meses = 0; 
			$this->request->session()->write('meses',$meses);
			$this->request->session()->write('fechadesde',$fechad);	
			$this->request->session()->write('fechahasta',$fechah);
		}
		else 
		{
			$fechah = $this->request->session()->read('fechahasta');
		    $fechad = $this->request->session()->read('fechadesde');
			$meses = $this->request->session()->read('meses');
		}
		
		if ($this->request->is('post','get'))
		{	
			$cliente_id = $this->request->session()->read('Auth.User.cliente_id');
		    $this->request->session()->write('cliente_id',$cliente_id);
		}
		else 
		{
			/*if (!empty($this->request->session()->read('cliente_id')))
				$cliente_id = $this->request->session()->read('cliente_id');
			else			
			{*/
				$cliente_id = $this->request->session()->read('Auth.User.cliente_id');
				$this->request->session()->write('cliente_id',$cliente_id);
			//}
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
		*/
		/*
		if ($this->request->session()->read('Auth.User.role')=='admin')
		{
			$this->loadModel('Clientes');
			$Clientes = $this->Clientes->find('all')->Select(['id','codigo','nombre']);
			$first =0;
			foreach ($Clientes as $opcion) {
			
				$clientes[$opcion['id']] = $opcion['codigo'].' - '.$opcion['nombre'];    
			}
		} 

		$this->set('clientes',$clientes);*/
		$fecha2 = Time::now();
		$fecha2->modify('+1 days');
		
		if ($fechah!=0)
		{
			$fechahasta = Time::createFromFormat('d/m/Y',$fechah,'America/Argentina/Buenos_Aires');
			$fechahasta->modify('+1 days');
			//$fechahasta2->i18nFormat('yyyy-MM-dd');
			
		}
		else
		{
			$fechahasta = Time::now();
			$fechahasta-> modify('+1 days');
		}
		if ($fechad!=0)
		{
			$fechadesde = Time::createFromFormat('d/m/Y',$fechad,'America/Argentina/Buenos_Aires');
			//$fechadesde2->i18nFormat('yyyy-MM-dd');
		}
		else
		{
			//$fechadesde = Time::now();
			if ($fechah!=0)
			{
				$fechadesde = Time::now();
				$fechadesde->setDate($fechadesde->year, $fechadesde->month, 1);
			

			}
			else
			{
				$fechadesde = Time::now();
				$fechadesde->setDate($fechadesde->year, $fechadesde->month, 1);
			}
				//$fechadesde2->i18nFormat('yyyy-MM-dd');
		}

		
		
		
		$this->loadModel('VentasDiarias');
		/*	
		$ventasdiarias = $this->VentasDiarias->find('all')	
					->where(['cliente_id' => $cliente_id])
					->andWhere(["fecha BETWEEN '".$fechadesde2->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta2->i18nFormat('yyyy-MM-dd')."'"]);
					
		*/
					

		//$this->request->session()->write('ventasdiarias',$this->paginate($ventasdiarias));
		
		if ($this->request->is('post'))
		{
			if ($fechah==0) {
		$fechadesde = Time::now();
		$fechadesde->setDate($fechadesde->year, $fechadesde->month, 1);
		$fechahasta = Time::now();
		//$fechahasta->setDate($fechahasta->year, $fechahasta->month, 1);
		$fechadesde-> modify('-1 year');
		$fechahasta-> modify('-1 day');
			}
		}
		//$fechadesde->i18nFormat('yyyy-MM-dd');
		if ($meses!=0)
		{
			
		$fechadesde = Time::now();
		$fechadesde->setDate($fechadesde->year, $fechadesde->month, 1);
		$fechahasta = Time::now();
		//$fechahasta->setDate($fechahasta->year, $fechahasta->month, 1);
		$fechadesde-> modify('-'.(12 - $meses).' month');
		$fechahasta-> modify('-1 day');
			
		}
		
		$resultventas = $this->VentasDiarias->find('all')
						->select(['anio'=>'YEAR(fecha)','mes' =>'MONTH(fecha)','total_u'=>'SUM(u_1)+SUM(u_2)+SUM(u_6)+SUM(u_7)+SUM(u_3)+SUM(u_4)+SUM(u_5)','total_m'=>'SUM(u_1)+SUM(u_2)+SUM(u_6) + SUM(u_7)',
						'total_pya'=>'SUM(u_3)+SUM(u_4)+SUM(u_5)', 'total_transf' =>'SUM(u_t)' ])										
						->where(['cliente_id' => $cliente_id])
						->andWhere(["fecha BETWEEN '".$fechadesde->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta->i18nFormat('yyyy-MM-dd')."'"])
						->group(['YEAR(fecha), MONTH(fecha)']);
		
		$resultventas2 = $this->VentasDiarias->find('all')
						->select(['anio'=>'YEAR(fecha)','mes' =>'MONTH(fecha)','total_u'=>'SUM(i_1)+SUM(i_2)+SUM(i_6)+SUM(i_7)+SUM(i_3)+SUM(i_4)+SUM(i_5)','total_m'=>'SUM(i_1)+SUM(i_2)+SUM(i_6) + SUM(i_7)',
						'total_pya'=>'SUM(i_3)+SUM(i_4)+SUM(i_5)', 'total_transf' =>'SUM(transfer)' ])										
						->where(['cliente_id' => $cliente_id])
						->andWhere(["fecha BETWEEN '".$fechadesde->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta->i18nFormat('yyyy-MM-dd')."'"])
						->group(['YEAR(fecha), MONTH(fecha)']);

/*
		$query = $articles->find(); $resultventas->toArray()
		$query->select(['count' => $query->func()->count('*')]);*/
		$this->set('resultventas', $this->paginate($resultventas));
		$this->set('resultventas2', $this->paginate($resultventas2));
		$fila = array();
		$respestadistica=array();
		
		foreach ($resultventas as $resultventa): 
		
		
			$respartcompras = array();
			$respartcompras['total_u']= $resultventa['total_u'];
			$respartcompras['total_m.']= $resultventa['total_m'];
			$respartcompras['total_pya']= $resultventa['total_pya'];
			$respartcompras['total_transf']= $resultventa['total_transf'];
			
			$indice = $resultventa['anio'].str_pad($resultventa['mes'], 2, "0", STR_PAD_LEFT);
			$respestadistica[$indice]=$respartcompras;
		endforeach;  
		$this->set('respestadistica', $respestadistica);
		
		$respestadistica2=array();
		
		foreach ($resultventas2 as $resultventa): 
		
		
			$respartcompras = array();
			$respartcompras['total_u']= $resultventa['total_u'];
			$respartcompras['total_m.']= $resultventa['total_m'];
			$respartcompras['total_pya']= $resultventa['total_pya'];
			$respartcompras['total_transf']= $resultventa['total_transf'];
			
			$indice = $resultventa['anio'].str_pad($resultventa['mes'], 2, "0", STR_PAD_LEFT);
			$respestadistica2[$indice]=$respartcompras;
		endforeach;  
		$this->set('respestadistica2', $respestadistica2);
	

        //$this->set('ventasdiarias', $this->paginate($ventasdiarias));
        //$this->set('_serialize', ['ventasdiarias']);
		
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
		
		$this->viewBuilder()->layout('storeestadistica');
        
				
		$this->loadModel('FacturasCabeceras');
        $this->paginate = [
            'contain' => ['Comprobantes'],
			'limit' => 100
        ];
		
		if ($this->request->session()->read('Auth.User.cuentaprincipal')==1)
		{
			$this->loadModel('Clientes');
			$Clientes = $this->Clientes->find('all')->Select(['id','codigo','nombre'])->where(['grupo_id'=>$this->request->session()->read('Auth.User.grupo')]);
			foreach ($Clientes as $opcion) {
				$clientes[$opcion['id']] = $opcion['codigo'].' - '.$opcion['nombre'];    
			}	
		}
		else
		{
			$clientes[$this->request->session()->read('Auth.User.cliente_id')] = $this->request->session()->read('Auth.User.codigo').' - '.$this->request->session()->read('Auth.User.razon');
		}
		$this->set('clientes',$clientes);
		
		$query = $this->FacturasCabeceras->find('all')	
					->hydrate(false)
					->join([
						'table' => 'comprobantes',
						'alias' => 'c',
						'type' => 'LEFT',
						'conditions' => ['FacturasCabeceras.comprobante_id = c.id']		
					])
					->where(['FacturasCabeceras.cliente_id' => $cliente_id]);

		if ($fechahasta!=0)
		{
			$fechahasta2 = Time::createFromFormat('d/m/Y',$fechahasta,'America/Argentina/Buenos_Aires');
			$fechahasta2->modify('+1 days');
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
		
			$facturascabeceras = $this->paginate($query);
		
		else
			$facturascabeceras = null;
		
		$this->request->session()->write('facturascabeceras',$facturascabeceras);
        $this->set('facturasCabeceras', $facturascabeceras);
        $this->set('_serialize', ['facturasCabeceras']);
	}

	public function excel(){
		$this->viewBuilder()->layout('ajax');
	
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
		
		if ($this->request->is('post','get'))
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
		
		$this->loadModel('FacturasCabeceras');
        $this->paginate = [
            'contain' => ['Comprobantes'],
			'limit' => 1000
        ];
		
		if ($fechahasta!=0)
		{
			$fecha2 = Time::createFromFormat('d/m/Y',$fechahasta,'America/Argentina/Buenos_Aires');
			$fecha2->modify('+1 days');
		}
		else
		{
			$fecha2 = Time::now();
			$fecha2-> modify('+1 days');
		}
		if ($fechadesde!=0)
		{
			$fecha= Time::createFromFormat('d/m/Y',$fechadesde,'America/Argentina/Buenos_Aires');
		}
		else
		{
			$fecha = Time::now();
			if ($fechahasta!=0)
				$fecha->setDate($fecha2->year, $fecha2->month, 1);
			else
				$fecha->setDate($fecha->year, $fecha->month, 1);
			//$fechadesde2->i18nFormat('yyyy-MM-dd');
		}
		
		$facturascabeceras = $this->FacturasCabeceras->find('all')	
					->join([
					'c' => [
						'table' => 'comprobantes',
						'type' => 'LEFT',
						'conditions' => 'FacturasCabeceras.comprobante_id = c.id',
					]
					])
					
					->where(['FacturasCabeceras.cliente_id' => $cliente_id])
					->andWhere(["FacturasCabeceras.fecha BETWEEN '".$fecha->i18nFormat('yyyy-MM-dd')."' AND '".$fecha2->i18nFormat('yyyy-MM-dd')."'"])
					->order(['FacturasCabeceras.fecha' => 'ASC']);
		if ($termsearch!="")
		{
			$facturascabeceras->andWhere([
					'OR' => [['c.nota'=>$termsearch], 
					['c.numero'=>$termsearch]],
				]);
			
		}
		$this->loadModel('NotasCabeceras');
		$notascabeceras = $this->NotasCabeceras->find('all')	
					->contain(['Comprobantes'
					])
					->join([
					'c' => [
						'table' => 'comprobantes',
						'type' => 'LEFT',
						'conditions' => 'NotasCabeceras.comprobante_id = c.id',
					]
					])
					
					->where(['NotasCabeceras.cliente_id' => $cliente_id])
					->andWhere(["NotasCabeceras.fecha BETWEEN '".$fecha->i18nFormat('yyyy-MM-dd')."' AND '".$fecha2->i18nFormat('yyyy-MM-dd')."'"])
					->order(['NotasCabeceras.fecha' => 'ASC']);
		
		//$facturascabeceras->order(['FacturasCabeceras.fecha' => 'ASC']);
		$clientes=array();
		if ($this->request->session()->read('Auth.User.cuentaprincipal')==1)
		{
			$this->loadModel('Clientes');
			$Clientes = $this->Clientes->find('all')->Select(['id','codigo','nombre'])->where(['grupo_id'=>$this->request->session()->read('Auth.User.grupo')]);
			foreach ($Clientes as $opcion) {
				$clientes[$opcion['id']] = $opcion['codigo'];    
			}	
		}
		else
			$clientes[$this->request->session()->read('Auth.User.cliente_id')] = $this->request->session()->read('Auth.User.codigo');
		
		$this->set('clientes',$clientes);
		$this->request->session()->write('notasCabeceras',$notascabeceras->toArray());
		$this->request->session()->write('facturasCabeceras',$this->paginate($facturascabeceras));
		
        $this->set('facturasCabeceras', $this->paginate($facturascabeceras));
        $this->set('_serialize', ['facturasCabeceras']);
		
		$this->response->type('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	}
	
	
    public function view($id = null)
    {
		$this->viewBuilder()->layout('storeestadistica');
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

	public function searchOfertsToLose()
	{
		$this->viewBuilder()->setLayout('store');
		$this->loadModel('FacturasCabeceras');
				$this->paginate = [
			'limit' => 200,
			'maxLimit' => 200,
		];

		$fechadesde = $this->request->getData('fechadesde') ?? $this->request->session()->read('fechadesde');
		$fechahasta = $this->request->getData('fechahasta') ?? $this->request->session()->read('fechahasta');
		$perdidas = $this->request->getData('perdidas') ?? $this->request->session()->read('perdidas');
        $termsearch = $this->request->getData('terminobuscar') ?? $this->request->session()->read('termsearch');

		// Validar si se recibieron fechas, de lo contrario asignar valores por defecto
		if (empty($fechadesde)) {
			$timeDesde = (new Time('-1 month'))->i18nFormat('yyyy-MM-dd');
			$timeDesdeVariable = (new Time())->i18nFormat('dd-MM-yyyy');
		} else {
			$timeDesde = Time::createFromFormat('d/m/Y', $fechadesde)->i18nFormat('yyyy-MM-dd');
			$timeDesdeVariable = $fechadesde;
		}

		if (empty($fechahasta)) {
			$timeHasta = (new Time())->i18nFormat('yyyy-MM-dd');
			$timeHastaVariable = (new Time())->i18nFormat('dd-MM-yyyy');
		} else {
			$timeHasta = Time::createFromFormat('d/m/Y', $fechahasta)->i18nFormat('yyyy-MM-dd');
			$timeHastaVariable = $fechahasta;
		}

		// Guardar valores en la sesión
		$this->request->getSession()->write('termsearch', $termsearch);
		$this->request->getSession()->write('fechadesde', $timeDesdeVariable);
		$this->request->getSession()->write('fechahasta', $timeHastaVariable);
	    $this->request->getSession()->write('perdidas', $perdidas);
		// Query
		$query = $this->FacturasCabeceras->find('all')
			->select([
				'a.id',
				'a.categoria_id',
				'a.codigo_barras',
				'a.descripcion_pag',
				'd.dto_patagonia',
				'd.dto_drogueria',
				'fci.cantidad_facturada',
				'd.uni_min',
				'd.tipo_venta',
			    'd.tipo_oferta',
				'fci.creado',
				'dd.id',
				'dd.uni_min',
				'dd.fecha_desde',
				'dd.fecha_hasta',
				'dd.dto_patagonia',
				'dd.tipo_venta',
				'dd.tipo_oferta',

			])
			->contain(['FacturasCuerposItems', 'FacturasCuerposItems.Articulos', 'FacturasCuerposItems.Articulos.Laboratorios'])
			->join([
				'fci' => [
					'table' => 'facturas_cuerpos_items',
					'type' => 'INNER',
					'conditions' => 'FacturasCabeceras.id = fci.facturas_encabezados_id',
				],
				'a' => [
					'table' => 'articulos',
					'type' => 'INNER',
					'conditions' => ['fci.articulo_id = a.id', 'categoria_id in (1,2,7,6)', 'a.eliminado = 0']
				],
				'd' => [
					'table' => 'descuentos',
					'type' => 'INNER',
					'conditions' => [
						'd.articulo_id = a.id',
					'd.tipo_venta = "D"',
					'd.tipo_oferta in ("RV","RR","OR","FR","TD","RL")'],
				],
				'dd' => [
					'table' => 'descuentos_delete',
					'type' => 'LEFT', // Puedes ajustar el tipo de join dependiendo de tus necesidades
					'conditions' => [
						'dd.articulo_id = a.id',
						'fci.creado BETWEEN dd.fecha_desde AND dd.fecha_hasta',
						'dd.tipo_venta = "D"',
					    'dd.tipo_oferta in ("RV","RR","OR","FR","TD","RL")'
					]
				]
			])
			->where(['FacturasCabeceras.cliente_id' => $this->request->session()->read('Auth.User.cliente_id'), 'fci.cantidad_facturada > 0', 'a.eliminado'=>0])
			->andWhere(["FacturasCabeceras.fecha BETWEEN '" . $timeDesde . "' AND '" . $timeHasta . "'"]);
		if (isset($perdidas) && $perdidas == 'on') {
			// Agregar la condición de "pérdidas" solo si el checkbox está marcado
		 $query->andWhere(['fci.cantidad_facturada < d.uni_min']);
		}
		$query->group(['a.id', 'FacturasCabeceras.id'])
			->order(['a.descripcion_pag' => 'ASC']);
		$paginatedResults = $this->paginate($query);
		$collection = new Collection($paginatedResults);

		$articulsByGrade = $collection->groupBy('a.id');

		$this->set('data', $articulsByGrade);
	}
	
	public function excelToDownload()
	{

		$recaptchaToken = $this->request->getData('recaptcha');
		$recaptchaValidation = $this->validateRecaptcha($recaptchaToken);
		if ($recaptchaValidation['success']) {
			if ($recaptchaValidation['score'] > 0.5) {

				$this->viewBuilder()->setLayout('ajax');

				$this->loadModel('FacturasCabeceras');

				$fechadesde = $this->request->getData('fechadesde') ?? $this->request->session()->read('fechadesde');
				$fechahasta = $this->request->getData('fechahasta') ?? $this->request->session()->read('fechahasta');
				$termsearch = $this->request->getData('terminobuscar') ?? $this->request->session()->read('termsearch');
				if (empty($fechadesde)) {
					$fechadesde = (new Time('-1 month'))->i18nFormat('yyyy-MM-dd');
				} else {

					$timeDesde = Time::createFromFormat('d/m/Y', $fechadesde);
				}
				if (empty($fechahasta)) {
					$fechahasta = (new Time())->i18nFormat('yyyy-MM-dd');
				} else {
					$timeHasta = Time::createFromFormat('d/m/Y', $fechahasta);
				}
				$this->request->getSession()->write('termsearch', $termsearch);
				$this->request->getSession()->write('fechadesde', $fechadesde);
				$this->request->getSession()->write('fechahasta', $fechahasta);

				$query = $this->FacturasCabeceras->find('all')
					->select([
						'a.id',
						'a.categoria_id',
						'a.descripcion_pag',
						'a.codigo_barras',
						'd.dto_patagonia',
						'd.dto_drogueria',
						'fci.cantidad_facturada',
						'd.uni_min',
						'd.tipo_venta',
			            'd.tipo_oferta',
						'fci.creado',
						'dd.id',
						'dd.uni_min',
						'dd.fecha_desde',
						'dd.fecha_hasta',
						'dd.dto_patagonia',
						'dd.tipo_venta',
				        'dd.tipo_oferta',
					])
					->contain(['FacturasCuerposItems', 'FacturasCuerposItems.Articulos', 'FacturasCuerposItems.Articulos.Laboratorios']) //,'Articulos'
					->join([

						'fci' => [
							'table' => 'facturas_cuerpos_items',
							'type' => 'INNER',
							'conditions' => ['FacturasCabeceras.id = fci.facturas_encabezados_id'],
						],
						'a' => [
							'table' => 'articulos',
							'type' => 'INNER',
							'conditions' => ['fci.articulo_id = a.id', 'categoria_id in (1,2,7,6)', 'a.eliminado =0']
						],
						'd' => [
							'table' => 'descuentos',
							'type' => 'INNER',
							'conditions' => [
								'd.articulo_id = a.id',
								'd.tipo_venta = "D"',
					            'd.tipo_oferta in ("RV","RR","OR","FR","TD","RL")']
						],
						'dd' => [
							'table' => 'descuentos_delete',
							'type' => 'LEFT', // Puedes ajustar el tipo de join dependiendo de tus necesidades
							'conditions' => [
								'dd.articulo_id = a.id',
								'fci.creado BETWEEN dd.fecha_desde AND dd.fecha_hasta',
								'dd.tipo_venta = "D"',
					            'dd.tipo_oferta in ("RV","RR","OR","FR","TD","RL")'
							]
						]

					])
					->where(['FacturasCabeceras.cliente_id' => $this->request->session()->read('Auth.User.cliente_id'), 'fci.cantidad_facturada>0', 'd.uni_min>fci.cantidad_facturada','a.eliminado'=>0])
					->andWhere(["FacturasCabeceras.fecha BETWEEN'" . $timeDesde->i18nFormat('yyyy-MM-dd') . "' AND '" . $timeHasta->i18nFormat('yyyy-MM-dd') . "'"])
					->group('a.id','FacturasCabeceras.id')
			        ->order(['a.descripcion_pag' => 'ASC']);


				$collection = new Collection($query);
				$articulsByGrade = $collection->groupBy('a.id');
				$this->set('data', $articulsByGrade->toArray());


				$this->response->withType('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			} else {
				$this->Flash->error('Fallo el reCAPTCHA, recargue la pagina e intente nuevamente.');
				$error = "";
			}
		} else {

			$this->loadModel('LogsCatchaFaileds');
			$logscatcha = $this->LogsCatchaFaileds->newEntity();
			//debug(date('Y-m-d H:i:s'));
			$logscatcha['codigo_cliente'] = $this->request->session()->read('Auth.User.codigo');
			$logscatcha['ip'] = $this->request->clientIp();
			$logscatcha['status'] = $recaptchaValidation['message'];
			$logscatcha['host'] = "descargas";
			if ($this->LogsCatchaFaileds->save($logscatcha)) {
			}
		}
	}

	private function validateRecaptcha($token)
	{
		$secretKey = Configure::read('Recaptcha.secret_key');
		$client = new Client();

		$response = $client->post('https://www.google.com/recaptcha/api/siteverify', [
			'secret' => $secretKey,
			'response' => $token
		]);

		if (!$response->isOk()) {
			return ['success' => false, 'message' => 'Error al conectar con el servicio de reCAPTCHA.'];
		}
		$responseData = json_decode($response->body(), true);


		if (isset($responseData['success']) && $responseData['success'] === true) {

			// Verificar que la puntuación es mayor a 0.5
			if (isset($responseData['score']) && $responseData['score'] > 0.5) {

				return ['success' => true, 'score' => $responseData['score'], 'hostname' => $responseData['hostname'], 'action' => $responseData['action']];
			} else {
				// Si la puntuación es 0.5 o menos, asumir que podría ser un bot
				return ['success' => false, 'message' => 'La puntuación de reCAPTCHA indica que podrías ser un bot.'];
			}
		} elseif (isset($responseData['error-codes']) && is_array($responseData['error-codes'])) {
			if (in_array('timeout-or-duplicate', $responseData['error-codes'])) {
				return ['success' => false, 'message' => 'El token de reCAPTCHA ha expirado o es duplicado. Por favor, inténtalo de nuevo.'];
			}
			// Aquí puedes añadir otros códigos de error específicos si es necesario
			return ['success' => false, 'message' => 'Error de reCAPTCHA. Por favor, inténtalo de nuevo.'];
		}

		return ['success' => false, 'message' => 'Error desconocido al validar reCAPTCHA.'];
	}
	public function viewOfertsToLose()
	{
		$this->viewBuilder()->setLayout('store');
		$this->loadModel('FacturasCabeceras');
				$this->paginate = [
			'limit' => 300,
			'maxLimit' => 300,
		];

		$date = Time::now();

		$day = $date->day;
		if ($day == 1) {
			$DateWithTheFirstDay = $date->i18nFormat('yyyy-MM-dd');
			$DateWithTheFirstDayVariable = $date->i18nFormat('dd-MM-yyyy');
		} else {

			$DateWithTheFirstDay = $date->startOfMonth()->i18nFormat('yyyy-MM-dd');
			$DateWithTheFirstDayVariable =  $date->startOfMonth()->i18nFormat('dd/MM/yyyy');
		}

		$today = Time::now()->i18nFormat('yyyy-MM-dd');

		$this->request->getSession()->write('fechadesde', $DateWithTheFirstDayVariable);
		$this->request->getSession()->write('fechahasta', Time::now()->i18nFormat('dd/MM/yyyy'));
		$query = $this->FacturasCabeceras->find('all')
			->select([
				'a.id',
				'a.categoria_id',
				'a.codigo_barras',
				'a.descripcion_pag',
				'd.dto_patagonia',
				'd.dto_drogueria',
				'd.tipo_venta',
			    'd.tipo_oferta',
				'fci.cantidad_facturada',
				 'fci.pedido_ds',
				'd.uni_min',
				'fci.creado',
				'dd.id',
				'dd.uni_min',
				'dd.fecha_desde',
				'dd.fecha_hasta',
				'dd.dto_patagonia',
				'dd.tipo_venta',
			    'dd.tipo_oferta',
			])
			->contain(['FacturasCuerposItems', 'FacturasCuerposItems.Articulos', 'FacturasCuerposItems.Articulos.Laboratorios']) //,'Articulos'
			->hydrate(false)
			->join([

				'fci' => [
					'table' => 'facturas_cuerpos_items',
					'type' => 'INNER',
					'conditions' => 'FacturasCabeceras.id = fci.facturas_encabezados_id',
				],
				'a' => [
					'table' => 'articulos',
					'type' => 'INNER',
					'conditions' => ['fci.articulo_id = a.id', 'categoria_id in (1,2,7,6)', 'a.eliminado =0']
				],
				'd' => [
					'table' => 'descuentos',
					'type' => 'INNER',
					'conditions' => [
					'd.articulo_id = a.id',
					'd.tipo_venta = "D"',
					'd.tipo_oferta in ("RV","RR","OR","FR","TD","RL")'],
				],
						'dd' => [
							'table' => 'descuentos_delete',
							'type' => 'LEFT', // Puedes ajustar el tipo de join dependiendo de tus necesidades
							'conditions' => [
								'dd.articulo_id = a.id',
								'fci.creado BETWEEN dd.fecha_desde AND dd.fecha_hasta',
								'dd.tipo_venta = "D"',
					            'dd.tipo_oferta in ("RV","RR","OR","FR","TD","RL")'
							]
						]
			])
			->where(['FacturasCabeceras.cliente_id' => $this->request->session()->read('Auth.User.cliente_id'), 'fci.cantidad_facturada>0','a.eliminado'=>0])
			->andWhere(["FacturasCabeceras.fecha BETWEEN '" . $DateWithTheFirstDay . "' AND '" . $today . "'"])
			->group('a.id','FacturasCabeceras.id')
			->order(['a.descripcion_pag' => 'ASC']);
		$paginatedResults = $this->paginate($query);
		$collection = new Collection($paginatedResults);
		$articulsByGrade = $collection->groupBy('a.id');
		$this->set('data', $articulsByGrade);
	}
}
