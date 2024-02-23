<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\Filesystem\File;
use Cake\Network\Request;
/**
 * FacturasCabeceras Controller
 *
 * @property \App\Model\Table\FacturasCabecerasTable $FacturasCabeceras
 */
class EstadisticasController extends AppController
{
	public function isAuthorized()
    {
		if (in_array($this->request->action, ['search','home','index','provincia'])) {
       
				if($this->request->session()->read('Auth.User.role')=='admin') 
				{				
					return true;			
				}			
				else 
				{	
					if($this->request->session()->read('Auth.User.role')=='client') 
					{	
						$tiene= $this->tienepermiso('esteticas',$this->request->action);
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
		$clientes=Array();
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

}
