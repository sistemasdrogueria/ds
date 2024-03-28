<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\Filesystem\File;
use Cake\Network\Request;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;

/**
 * FacturasCabeceras Controller
 *
 * @property \App\Model\Table\FacturasCabecerasTable $FacturasCabeceras
 */
class FacturasController extends AppController
{
public function isAuthorized()
    {
       	if (in_array($this->request->action, ['search','home','index','exportar','view','excel','exceldetalle','excelpm','excelcompleto','pami','excelpami','transfer', 'import', 'importresult','importajax','importresultredirect','importajaxcompleto'])) {
				if($this->request->session()->read('Auth.User.role')=='admin') 
				{				
					return true;			
				}			
				else 
				{	
					if($this->request->session()->read('Auth.User.role')=='client') 
					{	
						$tiene= $this->tienepermiso('facturas',$this->request->action);
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
		$this->loadModel('FacturasCabeceras');
        $this->paginate = [
            'contain' => ['Comprobantes'],
			'limit' => 80
        ];
		$fecha = Time::now();
		$fecha->setDate($fecha->year, $fecha->month, 1);
		$fecha2 = Time::now();
		$fecha2->modify('+1 days');
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
		/*if ($this->request->session()->read('Auth.User.cuentaprincipal')==1)
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
		*/
		
		$this->listadocliente();
		$facturascabeceras = $this->FacturasCabeceras->find('all')	
					->where(['FacturasCabeceras.cliente_id' => $this->request->session()->read('cliente_id')])
					->andWhere(["FacturasCabeceras.fecha BETWEEN '".$fecha->i18nFormat('yyyy-MM-dd')."' AND '".$fecha2->i18nFormat('yyyy-MM-dd')."'"])
	
					->order(['FacturasCabeceras.fecha' => 'ASC', 'FacturasCabeceras.pedido_ds' => 'ASC'])
					->group('FacturasCabeceras.pedido_ds');
		$this->request->session()->write('facturasCabeceras',$this->paginate($facturascabeceras));
		
        $this->set('facturasCabeceras', $this->paginate($facturascabeceras));
        $this->set('_serialize', ['facturasCabeceras']);
    }

	public function import()
	{
		$this->viewBuilder()->layout('admin');
			$this->loadModel('Laboratorios');
			$this->loadModel('Provincias');
			$this->loadModel('Localidads');
		   $laboratorios = $this->Laboratorios->find('list', ['keyField' => 'id', 'valueField' => 'nombre'])->order(['nombre' => 'ASC']);
			$provincias = $this->Provincias->find('list', ['keyField' => 'id', 'valueField' => 'nombre'])->order(['nombre' => 'ASC']);
			$localidads = $this->Localidads->find('list', ['keyField' => 'codigo', 'valueField' => 'nombre'])->order(['nombre' => 'ASC']);

			$this->request->session()->write('laboratorios', $laboratorios->toArray());
			$this->request->session()->write('provincias',$provincias->toArray());
			$this->request->session()->write('localidads',$localidads->toArray());
		
	}


	public function importresult()
	{
		$this->viewBuilder()->layout('ajax');
		if ($this->request->is(['ajax', 'post'])) {

			$this->request->allowMethod(['ajax', 'post']);
		$this->loadModel('Laboratorios');
		$this->loadModel('Provincias');
		$this->loadModel('Localidads');


		}$this->response->type('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	}

		public function importresultredirect()
	{
		
		$this->viewBuilder()->layout('admin');
	//$this->response->type('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
return $this->redirect(['action' => 'importresult']);
	
	}


	public function importajax()
	{
		$this->viewBuilder()->layout('vacio');
		if ($this->request->is(['ajax', 'post'])) {
			$this->request->allowMethod(['ajax', 'post']);
			$this->loadModel('FacturasCuerposItems');
			$this->loadModel('FacturasC');
			$this->loadModel('articulos');
			$this->loadModel('Laboratorios');
			$this->loadModel('Provincias');
			$this->loadModel('clientes');
			
			$codigobarras = $this->request->data('codigobarras');
			$claveamp = $this->request->data('claveamp');
			$fechain = $this->request->data('fechain');
			$fechafi = $this->request->data('fechafi');
			$laboratorios = $this->Laboratorios->find('list', ['keyField' => 'id', 'valueField' => 'nombre'])->order(['nombre' => 'ASC']);
			$provincias = $this->Provincias->find('list', ['keyField' => 'id', 'valueField' => 'nombre'])->order(['nombre' => 'ASC']);

			if ($codigobarras != 0) {
				$query = $this->FacturasCuerposItems->find('all')
				->select([
					'FacturasCabeceras.fecha', 'FacturasCuerposItems.cantidad_facturada', 'FacturasCuerposItems.descuento', 'FacturasCuerposItems.precio_total', 'FacturasCuerposItems.pedido_ds', 'Articulos.troquel', 'Articulos.descripcion_sist', 'Articulos.categoria_id', 'Articulos.codigo_barras', 'Articulos.laboratorio_id', 'Clientes.razon_social', 'Clientes.codigo_postal', 'Clientes.provincia_id', 'Clientes.cuit', 'Clientes.codigo'
				])
					->contain(['FacturasCabeceras.Clientes', 'FacturasCabeceras', 'Articulos'])
					->hydrate(false)
					->where([
						'Clientes.farmapoint = 1',
						'FacturasCabeceras.fecha BETWEEN  "' . $fechain . '" AND "' . $fechafi . '" AND Articulos.codigo_barras IN (' . str_replace(' ', '', $codigobarras) . ')'
					]);


				$this->request->session()->write('resultadobarras', $query->toArray());
				$responseData = ['3' => true, 'responseText' => "2", 'status' => 200, 'resultadobarras' => $query, 'laboratorios' => $laboratorios, 'provincias' => $provincias];
				$this->set('resultadosbarras', $query);
			}else{

				$query = null;
			}

			if (!empty($claveamp)) {

				$queryamp = $this->FacturasCuerposItems->find('all')
				->select([
					'FacturasCabeceras.fecha', 'FacturasCuerposItems.cantidad_facturada', 'FacturasCuerposItems.descuento', 'FacturasCuerposItems.precio_total', 'FacturasCuerposItems.pedido_ds', 'Articulos.troquel', 'Articulos.descripcion_sist', 'Articulos.categoria_id', 'Articulos.codigo_barras', 'Articulos.laboratorio_id', 'Clientes.razon_social', 'Clientes.codigo_postal', 'Clientes.provincia_id', 'Clientes.cuit', 'Clientes.codigo'
				])

					->contain(['FacturasCabeceras.Clientes', 'FacturasCabeceras', 'Articulos'])
					->hydrate(false)
					->where([
						'Clientes.farmapoint = 1',
						'FacturasCabeceras.fecha BETWEEN  "' . $fechain . '" AND "' . $fechafi . '" AND Articulos.clave_amp IN (' . str_replace(' ', '', $claveamp) . ')'
					]);
				$this->request->session()->write('resultadoamp', $queryamp->toArray());
				$responseData = ['3' => true, 'responseText' => "3", 'status' => 200, 'resultadoamp' => $queryamp, 'laboratorios' => $laboratorios, 'provincias' => $provincias];
				$this->set('resultadoamp', $queryamp);
			}else{

				$queryamp = null;
			}
					if (!empty($queryamp) && !empty($query) ) {
				if(!is_null($queryamp) && !is_null($query)){

					$arrquerynew = [];
					$arrquery =	$query->toArray();
					$arrqueryamp = 	$queryamp->toArray();
					$arraynew = array_merge($arrquerynew, $arrquery, $arrqueryamp);

					$this->request->session()->write('combinados', $arraynew);
					$responseData = ['2' => true, 'responseText' => "4", 'status' => 200, 'resultadocombinado' => $arraynew, 'laboratorios' => $laboratorios, 'provincias' => $provincias];
					$this->set('combinados', $query);
					
					}
			}
							$this->response->type('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			echo json_encode($responseData);

		}
	}

		public function importajaxcompleto()
	{
		$this->viewBuilder()->layout('vacio');
		if ($this->request->is(['ajax', 'post'])) {
			$this->request->allowMethod(['ajax', 'post']);
			$this->loadModel('FacturasCuerposItems');
			$this->loadModel('FacturasC');
			$this->loadModel('articulos');
			$this->loadModel('Laboratorios');
			$this->loadModel('Provincias');
			$this->loadModel('clientes');
			$codigobarras = $this->request->data('codigobarras');
			$claveamp = $this->request->data('claveamp');
			$fechain = $this->request->data('fechain');
			$fechafi = $this->request->data('fechafi');
			$laboratorios = $this->Laboratorios->find('list', ['keyField' => 'id', 'valueField' => 'nombre'])->order(['nombre' => 'ASC']);
			$provincias = $this->Provincias->find('list', ['keyField' => 'id', 'valueField' => 'nombre'])->order(['nombre' => 'ASC']);

			if ($codigobarras != 0) {
				$query = $this->FacturasCuerposItems->find('all')
				
					->contain(['FacturasCabeceras.Clientes', 'FacturasCabeceras', 'Articulos'])
					->hydrate(false)
					->where([
						'FacturasCabeceras.fecha BETWEEN  "' . $fechain . '" AND "' . $fechafi . '" AND Articulos.codigo_barras IN (' . str_replace(' ', '', $codigobarras) . ')'
					]);


				$this->request->session()->write('resultadobarras', $query->toArray());
				$responseData = ['3' => true, 'responseText' => "2", 'status' => 200, 'resultadobarras' => $query, 'laboratorios' => $laboratorios, 'provincias' => $provincias];
				$this->set('resultadosbarras', $query);
			}else{

				$query = null;
			}

			if (!empty($claveamp)) {

				$queryamp = $this->FacturasCuerposItems->find('all')

					->contain(['FacturasCabeceras.Clientes', 'FacturasCabeceras', 'Articulos'])
					->hydrate(false)
					->where([
						'FacturasCabeceras.fecha BETWEEN  "' . $fechain . '" AND "' . $fechafi . '" AND Articulos.clave_amp IN (' . str_replace(' ', '', $claveamp) . ')'
					]);
				$this->request->session()->write('resultadoamp', $queryamp->toArray());
				$responseData = ['3' => true, 'responseText' => "3", 'status' => 200, 'resultadoamp' => $queryamp, 'laboratorios' => $laboratorios, 'provincias' => $provincias];
				$this->set('resultadoamp', $queryamp);
			}else{

				$queryamp = null;
			}
					if (!empty($queryamp) && !empty($query) ) {
				if(!is_null($queryamp) && !is_null($query)){

					$arrquerynew = [];
					$arrquery =	$query->toArray();
					$arrqueryamp = 	$queryamp->toArray();
					$arraynew = array_merge($arrquerynew, $arrquery, $arrqueryamp);

					$this->request->session()->write('combinados', $arraynew);
					$responseData = ['2' => true, 'responseText' => "4", 'status' => 200, 'resultadocombinado' => $arraynew, 'laboratorios' => $laboratorios, 'provincias' => $provincias];
					$this->set('combinados', $query);
					
					}
			}
							$this->response->type('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			echo json_encode($responseData);

		}
	}





	public function listadocliente()
	{
		$clientes=Array();
		if ($this->request->session()->read('Auth.User.cuentaprincipal')==1)
		{
			$this->loadModel('Clientes');
			if ($this->request->session()->read('Auth.User.grupo') >0)
			
			$Clientes = $this->Clientes->find('all')->Select(['id','codigo','nombre'])->where(['grupo_id'=>$this->request->session()->read('Auth.User.grupo')]);
			else
			$Clientes = $this->Clientes->find('all')->Select(['id','codigo','nombre'])->where(['id'=>$this->request->session()->read('Auth.User.cliente_id')]);
			
			foreach ($Clientes as $opcion) {
				$clientes[$opcion['id']] = $opcion['codigo'].' - '.$opcion['nombre'];    
			}	 
		}
		else
		{
			$clientes[$this->request->session()->read('Auth.User.cliente_id')] = $this->request->session()->read('Auth.User.codigo').' - '.$this->request->session()->read('Auth.User.razon');
			$this->loadModel('Clientes');
			if ($this->request->session()->read('Auth.User.codigo_postal')==9410 || $this->request->session()->read('Auth.User.codigo_postal')==9420)
			{
				if ($this->request->session()->read('Auth.User.codigo')>71000)
				{
				$Clientes = $this->Clientes->find('all')
					->Select(['Clientes.id','Clientes.codigo','Clientes.nombre','ce.cliente_export_id','ce.cta_comun','ce.cliente_comun_id'])
					->join(['ce' => ['table' => 'clientes_exports','type' => 'INNER','conditions' => 'ce.cliente_export_id = Clientes.id']])
					->where(['Clientes.id'=>$this->request->session()->read('Auth.User.cliente_id')]);
				foreach ($Clientes as $opcion) {
					$clientes[$opcion['ce']['cliente_comun_id']] = $opcion['ce']['cta_comun'].' - '.$this->request->session()->read('Auth.User.razon');    
				}	 
				}
					
			}
		}
		$this->set('clientes',$clientes);
		
		$this->request->session()->write('clientes',$clientes);
		return $clientes;
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
		$this->set('clientes',$clientes);
		*/
		$this->listadocliente();
		$this->viewBuilder()->layout('store');
		$this->loadModel('FacturasCabeceras');
        $this->paginate = [
            'contain' => ['Comprobantes'],
			'limit' => 80
        ];
		$query = $this->FacturasCabeceras->find('all')	
					->hydrate(false)
					->join([
						'table' => 'comprobantes',
						'alias' => 'c',
						'type' => 'LEFT',
						'conditions' => ['FacturasCabeceras.comprobante_id = c.id']		
					])
					->where(['FacturasCabeceras.cliente_id' => $this->request->session()->read('cliente_id')])
					->group('FacturasCabeceras.pedido_ds');
		if ($fechahasta!=0)
		{
			$fechahasta2 = Time::createFromFormat('d/m/Y',$fechahasta,'America/Argentina/Buenos_Aires');
			//$fechahasta2->modify('+1 days');
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
		{
			
			$facturascabeceras = $this->paginate($query);
		}
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
		$this->loadModel('FacturasCabeceras');
        $this->paginate = [
            'contain' => ['Comprobantes'],
			'limit' => 1000,
			'maxLimit' => 2000
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
					
					->where(['FacturasCabeceras.cliente_id' => $this->request->session()->read('cliente_id')])
					->andWhere(["FacturasCabeceras.fecha BETWEEN '".$fecha->i18nFormat('yyyy-MM-dd')."' AND '".$fecha2->i18nFormat('yyyy-MM-dd')."'"])
					->order(['FacturasCabeceras.fecha' => 'ASC','FacturasCabeceras.pedido_ds' => 'ASC'])
					//->order(['FacturasCabeceras.fecha' => 'ASC','FacturasCabeceras.pedido_ds' => 'ASC' ])
					->group('FacturasCabeceras.pedido_ds');
		if ($termsearch!="")
		{
			$facturascabeceras->andWhere([
					'OR' => [['c.nota'=>$termsearch], 
					['c.numero'=>$termsearch]],
				]);
			
		}
		//$facturascabeceras->order(['FacturasCabeceras.fecha' => 'ASC']);
		
		$this->request->session()->write('facturasCabeceras',$this->paginate($facturascabeceras));
		
        $this->set('facturasCabeceras', $this->paginate($facturascabeceras));
        $this->set('_serialize', ['facturasCabeceras']);
		
		$this->response->type('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	}
	
	
	public function transfer()
    {
		$this->viewBuilder()->layout('store');
		$this->loadModel('FacturasCabeceras');
        $this->paginate = [
            'contain' => ['Comprobantes'],
			'limit' => 1000,
			
        ];
		/*$fecha = Time::now();
		$fecha->setDate($fecha->year, $fecha->month, 1);
		*/
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
		}/*
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
		}*/
		$this->listadocliente();
		
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
		/*
		$fecha2 = Time::now();
		$fecha2->modify('+1 days');*/

		$facturascabeceras = $this->FacturasCabeceras->find('all')	
					->contain(['FacturasCuerposItems','Comprobantes','FacturasCuerposItems.Articulos','FacturasCuerposItems.Articulos.Laboratorios'])
					->where(['FacturasCabeceras.cliente_id' => $cliente_id])
					->where(['FacturasCabeceras.transfer>0'])
					->andWhere(["FacturasCabeceras.fecha BETWEEN '".$fechadesde2->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta2->i18nFormat('yyyy-MM-dd')."'"])
	
					->order(['FacturasCabeceras.fecha' => 'DESC'])
					->group('FacturasCabeceras.pedido_ds');
		$this->request->session()->write('facturasCabeceras',$this->paginate($facturascabeceras));
		
        $this->set('facturasCabeceras', $this->paginate($facturascabeceras));
        $this->set('_serialize', ['facturasCabeceras']);
		
    }
	

	
	public function pami()
    {
		$this->viewBuilder()->layout('store');
		$this->loadModel('FacturasCabeceras');
        $this->paginate = [
           // 'contain' => ['Comprobantes'],
			'limit' => 200,
			'maxLimit' => 200
        ];
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
				
			if ($fechahasta!=0)
			{
				$fechahasta2 = Time::createFromFormat('d/m/Y',$fechahasta,'America/Argentina/Buenos_Aires');
				$fechahasta2->modify('+1 days');
			}
			else
			{
				$fechahasta2 = Time::now();	$fechahasta2-> modify('+1 days');
			}
			if ($fechadesde!=0)
				$fechadesde2 = Time::createFromFormat('d/m/Y',$fechadesde,'America/Argentina/Buenos_Aires');
			else
			{
				$fechadesde2 = Time::now();
				if ($fechahasta!=0)
					$fechadesde2->setDate($fechadesde2->year, $fechahasta2->month, 1);
				else
					$fechadesde2->setDate($fechadesde2->year, $fechadesde2->month, 1);
				
			}
			
										
		}
		else
		{
			
			
		
			
		$fechadesde2 = Time::now();
		$fechadesde2->setDate($fechadesde2->year, $fechadesde2->month, 1);
	
		
		$fechahasta2 = Time::now();
		$fechahasta2->modify('+1 days');
		
					
		}		

					$facturascabeceras = $this->FacturasCabeceras->find('all')	
					->contain(['FacturasCuerposItems','Comprobantes','FacturasCuerposItems.Articulos'])//,'Articulos'Comprobantes
					//->hydrate(false)
					->join([
					'ci' => [
						'table' => 'facturas_cuerpos_items',
						'type' => 'LEFT',
						'conditions' => 'FacturasCabeceras.id = ci.facturas_encabezados_id and  ci.articulo_id>27338 and ci.articulo_id<27344',
					]
					
					])
					->where(['FacturasCabeceras.cliente_id' => $this->request->session()->read('Auth.User.cliente_id'), 'Comprobantes.anulado=0'])
					//->andWhere(["FacturasCabeceras.fecha BETWEEN '".$fechadesde2->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta2->i18nFormat('yyyy-MM-dd')."'"])
					->andWhere(["FacturasCabeceras.fecha BETWEEN '".$fechadesde2->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta2->i18nFormat('yyyy-MM-dd')."'",
					'ci.articulo_id>27338','ci.articulo_id<27344'])
					->order(['FacturasCabeceras.fecha' => 'ASC'])
					->group('FacturasCabeceras.pedido_ds');



		
		//$this->request->session()->write('facturasCabeceras',$this->paginate($facturascabeceras));
		
        $this->set('facturasCabeceras', $this->paginate($facturascabeceras));
        //$this->set('_serialize', ['facturasCabeceras']);
		
    }
	
	public function excelpami()
	{
		$this->viewBuilder()->layout('ajax');
		
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
		$this->loadModel('FacturasCuerposItems');
		/*$this->paginate = [
            'contain' => ['Comprobantes','FacturasCuerposItems'],
			'limit' => 1000
        ];*/
		
		$query = $this->FacturasCabeceras->find('all')	
					->contain(['FacturasCuerposItems','Comprobantes','FacturasCuerposItems.Articulos'])//,'Articulos'Comprobantes
					->hydrate(false)
					/*->join([
						'table' => 'comprobantes',
						'alias' => 'c',
						'type' => 'LEFT',
						'conditions' => ['FacturasCabeceras.comprobante_id = c.id']		
						
					
					])*/
					->join([
					'c' => [
						'table' => 'comprobantes',
						'type' => 'LEFT',
						'conditions' => 'FacturasCabeceras.comprobante_id = c.id',
					],
					'ci' => [
						'table' => 'facturas_cuerpos_items',
						'type' => 'LEFT',
						'conditions' => 'FacturasCabeceras.id = ci.facturas_encabezados_id',
					],
					/*'a' => [
						'table' => 'articulos',
						'type' => 'LEFT',
						'conditions' => 'a.id = ci.articulo_id',
					]*/
					])
					->where(['FacturasCabeceras.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
					->group('FacturasCabeceras.id');

		if ($fechahasta!=0 and $fechahasta!=null)
		{
			$fechahasta2 = Time::createFromFormat('d/m/Y',$fechahasta,'America/Argentina/Buenos_Aires');
			$fechahasta2->modify('+1 days');
		}
		else
		{
			$fechahasta2 = Time::now();
			$fechahasta2-> modify('+1 days');
		}
		if ($fechadesde!=0 and $fechahasta!=null)
		{
			$fechadesde2 = Time::createFromFormat('d/m/Y',$fechadesde,'America/Argentina/Buenos_Aires');
		}
		else
		{
			$fechadesde2 = Time::now();
			if ($fechahasta!=0)
				$fechadesde2->setDate($fechadesde2->year, $fechahasta2->month, 1);
			else
				$fechadesde2->setDate($fechadesde2->year, $fechadesde2->month, 1);
			//$fechadesde2->i18nFormat('yyyy-MM-dd');
		}

		$query->andWhere(["FacturasCabeceras.fecha BETWEEN '".$fechadesde2->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta2->i18nFormat('yyyy-MM-dd')."'"]);
		
		if ($termsearch!="" and $fechahasta!=null)
		{
			$query->andWhere([
					'OR' => [['c.nota'=>$termsearch], 
					['c.numero'=>$termsearch]],
				]);
			
		}
		
      
		if ($query!=null)
		
			$facturascabeceras = $query->toArray();
		
		else
			$facturascabeceras = null;
		
		$this->request->session()->write('facturascabeceras',$facturascabeceras);
		$this->set('facturascabeceras',$facturascabeceras);
		
	
		$this->response->type('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	}
	

	public function exceldetalle()
	{
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
		$this->loadModel('FacturasCuerposItems');
			
	
		$query = $this->FacturasCabeceras->find('all')	
					->contain(['FacturasCuerposItems','Comprobantes','FacturasCuerposItems.Articulos'])//,'Articulos'Comprobantes
					->hydrate(false)
				
					->join([
					'c' => [
						'table' => 'comprobantes',
						'type' => 'LEFT',
						'conditions' => 'FacturasCabeceras.comprobante_id = c.id',
					],
					'ci' => [
						'table' => 'facturas_cuerpos_items',
						'type' => 'LEFT',
						'conditions' => 'FacturasCabeceras.id = ci.facturas_encabezados_id',
					],
					/*'a' => [
						'table' => 'articulos',
						'type' => 'LEFT',
						'conditions' => 'a.id = ci.articulo_id',
					]*/
					])
					->where(['c.cliente_id' => $this->request->session()->read('cliente_id')])
					->where(['FacturasCabeceras.cliente_id' => $this->request->session()->read('cliente_id')])
					->order(['FacturasCabeceras.fecha' => 'ASC','FacturasCabeceras.pedido_ds' => 'ASC','ci.descripcion'=>'ASC' ])
					->group('FacturasCabeceras.pedido_ds');
		
		if ($fechahasta!=0)
		{
			$fechahasta2 = Time::createFromFormat('d/m/Y',$fechahasta,'America/Argentina/Buenos_Aires');
			//$fechahasta2->modify('+1 days');
		}
		else
		{
			$fechahasta2 = Time::now();
			$fechahasta2-> modify('+1 days');
		}
		if ($fechadesde!=0)
		{
			$fechadesde2 = Time::createFromFormat('d/m/Y',$fechadesde,'America/Argentina/Buenos_Aires');
		}
		else
		{
			$fechadesde2 = Time::now();
			if ($fechahasta!=0)
				$fechadesde2->setDate($fechadesde2->year, $fechahasta2->month, 1);
			else
				$fechadesde2->setDate($fechadesde2->year, $fechadesde2->month, 1);
			//$fechadesde2->i18nFormat('yyyy-MM-dd');
		}

		$query->andWhere(["FacturasCabeceras.fecha BETWEEN '".$fechadesde2->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta2->i18nFormat('yyyy-MM-dd')."'"]);
		
		if ($termsearch!="")
		{
			$query->andWhere([
					'OR' => [['c.nota'=>$termsearch], 
					['c.numero'=>$termsearch]],
				]);
			
		}
		//$query->order(['FacturasCabeceras.fecha' => 'ASC']);
        
		if ($query!=null)
		{
			
			$facturascabeceras = $query->toArray();
		}
		else
			$facturascabeceras = null;
		
		$clientes=Array();
		if ($this->request->session()->read('Auth.User.cuentaprincipal')==1)
		{
			$this->loadModel('Clientes');
			
			$Clientes = $this->Clientes->find('all')->Select(['id','codigo'])->where(['grupo_id'=>$this->request->session()->read('Auth.User.grupo')]);
			foreach ($Clientes as $opcion) {
					$clientes[$opcion['id']] = $opcion['codigo'];    
			}	
			 
		}
		else
		{
			$clientes[$this->request->session()->read('Auth.User.cliente_id')] = $this->request->session()->read('Auth.User.codigo');
		}
		$this->set('clientes',$clientes);
		
		$this->request->session()->write('facturascabeceras',$facturascabeceras);
		$this->set('facturascabeceras',$facturascabeceras);
		//$this->set('_serialize', ['facturascabeceras']);
	
		$this->response->type('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	}
		
	public function exportar()
	{
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
		
		$this->viewBuilder()->layout('store');
		$this->loadModel('Clientes');
		$client = $this->Clientes->get($this->request->session()->read('cliente_id'));
		$this->loadModel('FacturasCabeceras');
		$this->loadModel('FacturasCuerposItems');
		$this->paginate = [
            'contain' => ['Comprobantes'],
        ];
		
		$query = $this->FacturasCabeceras->find('all')	
					->contain(['FacturasCuerposItems','Comprobantes','FacturasCuerposItems.Articulos'])//,'Articulos'
					->hydrate(false)
					/*->join([
						'table' => 'comprobantes',
						'alias' => 'c',
						'type' => 'LEFT',
						'conditions' => ['FacturasCabeceras.comprobante_id = c.id']		
						
					
					])*/
					/*->join([
					'c' => [
						'table' => 'comprobantes',
						'type' => 'INNER',
						'conditions' => 'FacturasCabeceras.comprobante_id = c.id',
					],
					'ci' => [
						'table' => 'facturas_cuerpos_items',
						'type' => 'INNER',
						'conditions' => 'FacturasCabeceras.id = ci.facturas_encabezados_id',
					],
					'a' => [
						'table' => 'articulos',
						'type' => 'INNER',
						'conditions' => 'a.id = ci.articulo_id',
					]
					])*/
					->where(['FacturasCabeceras.cliente_id' => $this->request->session()->read('cliente_id')])
					->group('FacturasCabeceras.pedido_ds');
		if ($fechahasta!=0)
		{
			$fechahasta2 = Time::createFromFormat('d/m/Y',$fechahasta,'America/Argentina/Buenos_Aires');
			//$fechahasta2->modify('+1 days');
		}
		else
		{
			$fechahasta2 = Time::now();
			$fechahasta2-> modify('+1 days');
		}
		if ($fechadesde!=0)
		{
			$fechadesde2 = Time::createFromFormat('d/m/Y',$fechadesde,'America/Argentina/Buenos_Aires');
		}
		else
		{
			$fechadesde2 = Time::now();
			if ($fechahasta!=0)
				$fechadesde2->setDate($fechadesde2->year, $fechahasta2->month, 1);
			else
				$fechadesde2->setDate($fechadesde2->year, $fechadesde2->month, 1);
			//$fechadesde2->i18nFormat('yyyy-MM-dd');
		}

		$query->andWhere(["FacturasCabeceras.fecha BETWEEN '".$fechadesde2->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta2->i18nFormat('yyyy-MM-dd')."'"]);
		
		if ($termsearch!="")
		{
			$query->andWhere([
					'OR' => [['c.nota'=>$termsearch], 
					['c.numero'=>$termsearch]],
				]);
			
		}
      
		if ($query!=null)
		{
			
			$facturascabeceras = $query->toArray();
		}
		else
			$facturascabeceras = null;
		
		$this->request->session()->write('facturascabeceras2',$facturascabeceras);
		
			
		$codigo = str_pad($client['codigo'], 6, "0", STR_PAD_LEFT);
		$nombrearhivodirectorio = 'temp'. DS ;
		$nombrearhivo = 'Factura_detalle_'.$codigo.'.TXT';
		
		
		$file = new File($nombrearhivodirectorio.$nombrearhivo, true, 0777);
		
		/*foreach ($facturascabeceras as $fc): 
			$espacio = "\t";
			$item = 'C'.$espacio;
			$item .= $codigo.$espacio;
			$item .= str_pad($fc['comprobante']['seccion'], 4, "0", STR_PAD_LEFT);
			$item .= $fc['letra'];
			$item .= str_pad($fc['comprobante']['numero'], 8, "0", STR_PAD_LEFT).$espacio;
			$item .= str_pad($this->request->session()->read('Auth.User.razon'), 30, " ", STR_PAD_RIGHT).$espacio;
			$item .= 'AUT'.$espacio;  
			$imp = $fc['imp_gravado'];
			$item .= str_pad(str_replace(".", "",$imp ), 15, "0", STR_PAD_LEFT).$espacio;
			$imp = $fc['imp_exento'];
			$item .= str_pad(str_replace(".", "",$imp ), 15, "0", STR_PAD_LEFT).$espacio;
			$imp = $fc['imp_iva'];
			$item .= str_pad(str_replace(".", "",$imp ), 13, "0", STR_PAD_LEFT).$espacio;
			$imp = $fc['imp_rg3337'];
			$item .= str_pad(str_replace(".", "",$imp ), 13, "0", STR_PAD_LEFT).$espacio;
			$imp = $fc['imp_ingreso_bruto'];
			$item .= str_pad(str_replace(".", "",$imp ), 13, "0", STR_PAD_LEFT).$espacio;
			$imp = $fc['total'];
			$item .= str_pad(str_replace(".", "",$imp ), 15, "0", STR_PAD_LEFT).$espacio;
			$item .= date_format($fc['fecha'],'dmY').$espacio;
			$item .= str_pad($fc['pedido_ds'], 6, "0", STR_PAD_LEFT);
			
			
			$file->write($item. PHP_EOL);
			foreach ($fc['facturas_cuerpos_items'] as $fci): 
				$itemart = 'D'.$espacio;	
				$itemart .= $codigo.$espacio;
				$itemart .= str_pad($fc['comprobante']['seccion'], 4, "0", STR_PAD_LEFT);
				$itemart .= $fc['letra'];
				$itemart .= str_pad($fc['comprobante']['numero'], 8, "0", STR_PAD_LEFT).$espacio;
					
				$itemart .= str_pad('01', 2, "0", STR_PAD_LEFT).$espacio;
				
				$itemart .= str_pad($fci['codigo_barra'], 13, "0", STR_PAD_LEFT).$espacio;
				
				$itemart .= str_pad($fci['descripcion'], 30, " ", STR_PAD_RIGHT).$espacio;
				
				if ($fci['iva'])
				$itemart .= '1';
				else
				$itemart .= '0';
				
				$itemart .= $espacio. str_pad($fci['cantidad_facturada'], 6, "0", STR_PAD_LEFT).$espacio;
				$imp = $fci['precio_unitario'];
				$itemart .= str_pad(str_replace(".", "",$imp ), 13, "0", STR_PAD_LEFT).$espacio;
				$imp = $fci['precio_publico'];
				$itemart .= str_pad(str_replace(".", "",$imp ), 11, "0", STR_PAD_LEFT).$espacio;
				$imp = $fci['precio_total'];
				$itemart .= str_pad(str_replace(".", "",$imp ), 15, "0", STR_PAD_LEFT).$espacio;
				
				$file->write($itemart. PHP_EOL);
			endforeach; 
			//$file->append(utf8_encode($string));
			//$file->create('I am overwriting the contents of this file');
			
			
		endforeach; 
		*/
		
		foreach ($facturascabeceras as $fc): 
			$espacio = "\t";
			$item = 'C'.$espacio;
			$item .= $codigo.$espacio;
			$item .= str_pad($fc['comprobante']['seccion'], 4, "0", STR_PAD_LEFT);
			$item .= $fc['letra'];
			$item .= str_pad($fc['comprobante']['numero'], 8, "0", STR_PAD_LEFT).$espacio;
			$item .= str_pad($client['nombre'], 30, " ", STR_PAD_RIGHT).$espacio;
			$item .= 'AUT'.$espacio;  
			$imp = (int)($fc['imp_gravado']* 100);
			
			$item .= str_pad($imp, 15, "0", STR_PAD_LEFT).$espacio;
			$imp = (int)($fc['imp_exento']*100);
			$item .= str_pad($imp, 15, "0", STR_PAD_LEFT).$espacio;
			$imp = (int)($fc['imp_iva']*100);
			//$imp = number_format($fc['imp_iva'],2,'.','');
			$item .= str_pad($imp, 13, "0", STR_PAD_LEFT).$espacio;
			$imp = (int)($fc['imp_rg3337']*100);
			$item .= str_pad($imp, 13, "0", STR_PAD_LEFT).$espacio;
			$imp = (int)($fc['imp_ingreso_bruto']*100);
			$item .= str_pad($imp , 13, "0", STR_PAD_LEFT).$espacio;
			$imp = (int)($fc['total']*100);
			//$imp = number_format($fc['total'],2,'.','');
			
			$item .= str_pad($imp , 15, "0", STR_PAD_LEFT).$espacio;
			$item .= date_format($fc['fecha'],'dmY').$espacio;
			$item .= str_pad($fc['pedido_ds'], 6, "0", STR_PAD_LEFT);
			
			
			$file->write($item. PHP_EOL);
			foreach ($fc['facturas_cuerpos_items'] as $fci): 
				$itemart = 'D'.$espacio;	
				$itemart .= $codigo.$espacio;
				$itemart .= str_pad($fc['comprobante']['seccion'], 4, "0", STR_PAD_LEFT);
				$itemart .= $fc['letra'];
				$itemart .= str_pad($fc['comprobante']['numero'], 8, "0", STR_PAD_LEFT).$espacio;
					
				
				$itemart .= str_pad('0'.$fci['articulo']['categoria_id'], 2, "0", STR_PAD_LEFT).$espacio;
				$itemart .= str_pad($fci['articulo']['codigo_barras'], 13, "0", STR_PAD_LEFT).$espacio;
				
				$itemart .= str_pad($fci['articulo']['descripcion_sist'], 30, " ", STR_PAD_RIGHT).$espacio;
				
				if ($fci['iva'])
				$itemart .= '1';
				else
				$itemart .= '0';
				
				$itemart .= $espacio. str_pad($fci['cantidad_facturada'], 6, "0", STR_PAD_LEFT).$espacio;
				//$imp = $fci['precio_unitario'];
				$imp = (int)($fci['precio_unitario']*100);// number_format($fci['precio_unitario'],2,'.','');
				$itemart .= str_pad($imp , 13, "0", STR_PAD_LEFT).$espacio;
				$imp = (int)($fci['precio_publico']*100);//$imp = number_format($fci['precio_publico'],2,'.','');
				//$imp = $fci['precio_publico'];
				$itemart .= str_pad($imp , 11, "0", STR_PAD_LEFT).$espacio;
				
				$imp = (int)($fci['precio_total']*100);//number_format($fci['precio_total'],2,'.','');
				//$imp = $fci['precio_total'];
				$itemart .= str_pad($imp , 15, "0", STR_PAD_LEFT).$espacio;
				
				$file->write($itemart. PHP_EOL);
			endforeach; 
			//$file->append(utf8_encode($string));
			//$file->create('I am overwriting the contents of this file');
			
			
		endforeach; 
		
		// $file->append('I am adding to the bottom of this file.');
		// $file->delete(); // I am deleting this file
		$file->close(); // Be sure to close the file when you're done
		

		$this->response->type('txt');

		$this->response->file(
		$nombrearhivodirectorio.$nombrearhivo,
		['download' => true, 'name' => $nombrearhivo]
		);

		return $this->response;
		
		
	}
	
	public function excelpm()
	{
		$this->viewBuilder()->layout('ajax');
		
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
		$this->loadModel('Clientes');
		$cliente_id = $this->request->session()->read('Auth.User.cliente_id');
	
		$grupo = array();
		$client = $this->Clientes->get($cliente_id);
		if 	($client['cuentaprincipal']>0)
		{
			$grupo = $this->Clientes->find('all')->where(['grupo_id'=>$client['grupo_id']])->select('id');
			//$grupo = $clientes->toArray();
		}
		else
		{
			$grupo[1]=$client['id'];
		}
		$query = $this->FacturasCabeceras->find('all')	
					->contain([
					 'FacturasCuerposItems' => function(\Cake\ORM\Query $q) {
						return $q->where(['FacturasCuerposItems.descuento >0'])/*->group('FacturasCuerposItems.articulo_id')*/;
					  },
					
					  'Clientes','Comprobantes','FacturasCuerposItems.Articulos','FacturasCuerposItems.Articulos.Laboratorios'
				       ])
					->hydrate(false)
					->where(['FacturasCabeceras.cliente_id in' => $grupo])
					->order(['FacturasCabeceras.fecha' => 'ASC', 'FacturasCabeceras.pedido_ds' => 'ASC'])
					->group('FacturasCabeceras.pedido_ds');
		if ($fechahasta!=0 and $fechahasta!=null)
		{
			$fechahasta2 = Time::createFromFormat('d/m/Y',$fechahasta,'America/Argentina/Buenos_Aires');
			//$fechahasta2->modify('+1 days');
		}
		else
		{
			$fechahasta2 = Time::now();
			$fechahasta2-> modify('+1 days');
		}
		if ($fechadesde!=0 and $fechahasta!=null)
		{
			$fechadesde2 = Time::createFromFormat('d/m/Y',$fechadesde,'America/Argentina/Buenos_Aires');
		}
		else
		{
			$fechadesde2 = Time::now();
			if ($fechahasta!=0)
				$fechadesde2->setDate($fechadesde2->year, $fechahasta2->month, 1);
			else
				$fechadesde2->setDate($fechadesde2->year, $fechadesde2->month, 1);
			//$fechadesde2->i18nFormat('yyyy-MM-dd');
		}

		$query->andWhere(["FacturasCabeceras.fecha BETWEEN '".$fechadesde2->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta2->i18nFormat('yyyy-MM-dd')."'"]);
		
		if ($termsearch!="" and $fechahasta!=null)
		{
			$query->andWhere([
					'OR' => [['c.nota'=>$termsearch], 
					['c.numero'=>$termsearch]],
				]);
			
		}
		
        
		if ($query!=null)
		
			$facturascabeceras = $query->toArray();
		
		else
			$facturascabeceras = null;
		
		$this->request->session()->write('facturascabeceras',$facturascabeceras);
		$this->set('facturascabeceras',$facturascabeceras);
		//$this->set('_serialize', ['facturascabeceras']);
	
		$this->response->type('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		
	}
	
	public function excelcompleto()
	{
		$this->viewBuilder()->layout('ajax');
		
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
			$this->loadModel('Clientes');
		$cliente_id = $this->request->session()->read('Auth.User.cliente_id');
	
		$grupo = array();
		$client = $this->Clientes->get($cliente_id);
		if 	($client['cuentaprincipal']>0)
		{
			$grupo = $this->Clientes->find('all')->where(['grupo_id'=>$client['grupo_id']])->select('id');
			//$grupo = $grupo->toArray();
			//$grupo[1]=$client['id'];
		}
		else
		{
			$grupo[1]=$client['id'];
		}
		$query = $this->FacturasCabeceras->find('all')	
					->contain([
					 'FacturasCuerposItems','Clientes','Comprobantes','FacturasCuerposItems.Articulos','FacturasCuerposItems.Articulos.Laboratorios'
				       ])
					->hydrate(false)
					->where(['FacturasCabeceras.cliente_id in' => $grupo])
					->order(['FacturasCabeceras.fecha' => 'ASC','FacturasCabeceras.pedido_ds' => 'ASC'])
					->group('FacturasCabeceras.pedido_ds');
		if ($fechahasta!=0 and $fechahasta!=null)
		{
			$fechahasta2 = Time::createFromFormat('d/m/Y',$fechahasta,'America/Argentina/Buenos_Aires');
			$fechahasta2->modify('+1 days');
		}
		else
		{
			$fechahasta2 = Time::now();
			$fechahasta2-> modify('+1 days');
		}
		if ($fechadesde!=0 and $fechahasta!=null)
		{
			$fechadesde2 = Time::createFromFormat('d/m/Y',$fechadesde,'America/Argentina/Buenos_Aires');
		}
		else
		{
			$fechadesde2 = Time::now();
			if ($fechahasta!=0)
				$fechadesde2->setDate($fechadesde2->year, $fechahasta2->month, 1);
			else
				$fechadesde2->setDate($fechadesde2->year, $fechadesde2->month, 1);
			//$fechadesde2->i18nFormat('yyyy-MM-dd');
		}

		$query->andWhere(["FacturasCabeceras.fecha BETWEEN '".$fechadesde2->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta2->i18nFormat('yyyy-MM-dd')."'"]);
		
		if ($termsearch!="" and $fechahasta!=null)
		{
			$query->andWhere([
					'OR' => [['c.nota'=>$termsearch], 
					['c.numero'=>$termsearch]],
				]);
			
		}
		
        
		if ($query!=null)
		
			$facturascabeceras = $query->toArray();
		
		else
			$facturascabeceras = null;
		
		$this->request->session()->write('facturascabeceras',$facturascabeceras);
		$this->set('facturascabeceras',$facturascabeceras);
		//$this->set('_serialize', ['facturascabeceras']);
	
		$this->response->type('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		
	}
	
	
	
     /*
	public function excelpm()
	{
		$this->viewBuilder()->layout('ajax');
		
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

		$this->loadModel('Clientes');
		$cliente_id = $this->request->session()->read('Auth.User.cliente_id');
	
		$grupo = array();
		$client = $this->Clientes->get($cliente_id);
		if 	($client['cuentaprincipal']>0)
		{
			$grupo = $this->Clientes->find('all')->where(['grupo_id'=>$client['grupo_id']])->select('id');
			//$grupo = $clientes->toArray();
		}
		else
		{
			$grupo[1]=$client['id'];
		}
		$query = $this->FacturasCabeceras->find('all')	
					->contain([
					 'FacturasCuerposItems' => function(\Cake\ORM\Query $q) {
						return $q->where(['FacturasCuerposItems.descuento >0'])->group('FacturasCuerposItems.articulo_id');
					  },
					
					  'Clientes','Comprobantes','FacturasCuerposItems.Articulos','FacturasCuerposItems.Articulos.Laboratorios'
				       ])
					->hydrate(false)
					->where(['FacturasCabeceras.cliente_id in' => $grupo]);

		if ($fechahasta!=0 and $fechahasta!=null)
		{
			$fechahasta2 = Time::createFromFormat('d/m/Y',$fechahasta,'America/Argentina/Buenos_Aires');
			//$fechahasta2->modify('+1 days');
		}
		else
		{
			$fechahasta2 = Time::now();
			//$fechahasta2-> modify('+1 days');
		}
		if ($fechadesde!=0 and $fechahasta!=null)
		{
			$fechadesde2 = Time::createFromFormat('d/m/Y',$fechadesde,'America/Argentina/Buenos_Aires');
		}
		else
		{
			$fechadesde2 = Time::now();
			if ($fechahasta!=0)
				$fechadesde2->setDate($fechadesde2->year, $fechahasta2->month, 1);
			else
				$fechadesde2->setDate($fechadesde2->year, $fechadesde2->month, 1);
			//$fechadesde2->i18nFormat('yyyy-MM-dd');
		}

		$query->andWhere(["FacturasCabeceras.fecha BETWEEN '".$fechadesde2->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta2->i18nFormat('yyyy-MM-dd')."'"]);
		
		if ($termsearch!="" and $fechahasta!=null)
		{
			$query->andWhere([
					'OR' => [['c.nota'=>$termsearch], 
					['c.numero'=>$termsearch]],
				]);
			
		}
		
        
		if ($query!=null)
		{	$facturascabeceras->group('FacturasCabeceras.pedido_ds');
			$facturascabeceras = $query->toArray();
		}
		else
			$facturascabeceras = null;
		
		$this->request->session()->write('facturascabeceras',$facturascabeceras);
		$this->set('facturascabeceras',$facturascabeceras);
		//$this->set('_serialize', ['facturascabeceras']);
	
		$this->response->type('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		
	}
	*/
	/*
	public function excelpm()
	{
		$this->viewBuilder()->layout('ajax');
		
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
			$this->loadModel('Clientes');
		$cliente_id = $this->request->session()->read('Auth.User.cliente_id');
	
		$grupo = array();
		$client = $this->Clientes->get($cliente_id);
		if 	($client['cuentaprincipal']>0)
		{
			$grupo = $this->Clientes->find('all')->where(['grupo_id'=>$client['grupo_id']])->select('id');
			//$grupo = $clientes->toArray();
		}
		else
		{
			$grupo[1]=$client['id'];
		}
		$query = $this->FacturasCabeceras->find('all')	
					->contain([
					 'FacturasCuerposItems' => function(\Cake\ORM\Query $q) {
						return $q->where(['FacturasCuerposItems.descuento >0'])->group('FacturasCuerposItems.articulo_id');
					  },
					
					  'Clientes','Comprobantes','FacturasCuerposItems.Articulos','FacturasCuerposItems.Articulos.Laboratorios'
				       ])
					->hydrate(false)
					->where(['FacturasCabeceras.cliente_id in' => $grupo]);

		if ($fechahasta!=0 and $fechahasta!=null)
		{
			$fechahasta2 = Time::createFromFormat('d/m/Y',$fechahasta,'America/Argentina/Buenos_Aires');
			$fechahasta2->modify('+1 days');
		}
		else
		{
			$fechahasta2 = Time::now();
			$fechahasta2-> modify('+1 days');
		}
		if ($fechadesde!=0 and $fechahasta!=null)
		{
			$fechadesde2 = Time::createFromFormat('d/m/Y',$fechadesde,'America/Argentina/Buenos_Aires');
		}
		else
		{
			$fechadesde2 = Time::now();
			if ($fechahasta!=0)
				$fechadesde2->setDate($fechadesde2->year, $fechahasta2->month, 1);
			else
				$fechadesde2->setDate($fechadesde2->year, $fechadesde2->month, 1);
			//$fechadesde2->i18nFormat('yyyy-MM-dd');
		}

		$query->andWhere(["FacturasCabeceras.fecha BETWEEN '".$fechadesde2->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta2->i18nFormat('yyyy-MM-dd')."'"]);
		
		if ($termsearch!="" and $fechahasta!=null)
		{
			$query->andWhere([
					'OR' => [['c.nota'=>$termsearch], 
					['c.numero'=>$termsearch]],
				]);
			
		}
		
        
		if ($query!=null)
		
			$facturascabeceras = $query->toArray();
		
		else
			$facturascabeceras = null;
		
		$this->request->session()->write('facturascabeceras',$facturascabeceras);
		$this->set('facturascabeceras',$facturascabeceras);
		//$this->set('_serialize', ['facturascabeceras']);
	
		$this->response->type('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		
	}
	*/
	/*public function exportar()
	{
	
		//$file = new File('temp' . DS . 'JONT');
		//$facturasCabeceras = $this->request->session()->read('facturasCabeceras');
		//$this->loadModel('Comprobantes');
		$this->loadModel('FacturasCabeceras');
		$this->loadModel('FacturasCuerposItems');
		$this->paginate = [
            'contain' => ['Comprobantes'],
			
        ];
	
			$facturasCabeceras = $this->FacturasCabeceras->	find('all')
					->contain(['FacturasCuerposItems','Comprobantes'])

					->where(['FacturasCabeceras.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]);
		
		
		//$this->request->session()->write('facturasCabeceras2',$this->paginate($facturasCabeceras));
		$this->request->session()->write('facturasCabeceras2',$facturasCabeceras->toArray());
		
		//$contents = $file->read();
		$codigo = str_pad($this->request->session()->read('Auth.User.codigo'), 6, "0", STR_PAD_LEFT);
		$file = new File('temp'. DS .'DETFAC'.$codigo.'.TXT', true, 0777);
		//$file->create('I am overwriting the contents of this file');
		foreach ($facturasCabeceras as $fc): 
			$espacio = "\t";
			$item = 'C'.$espacio;
			$item .= $codigo.$espacio;
			$item .= str_pad($fc['comprobante']['seccion'], 4, "0", STR_PAD_LEFT);
			$item .= $fc['letra'];
			$item .= str_pad($fc['comprobante']['numero'], 8, "0", STR_PAD_LEFT).$espacio;
			$item .= str_pad($this->request->session()->read('Auth.User.razon'), 30, " ", STR_PAD_RIGHT).$espacio;
			$item .= 'AUT'.$espacio;  
			$imp = $fc['imp_gravado'];
			$item .= str_pad(str_replace(".", "",$imp ), 15, "0", STR_PAD_LEFT).$espacio;
			$imp = $fc['imp_exento'];
			$item .= str_pad(str_replace(".", "",$imp ), 15, "0", STR_PAD_LEFT).$espacio;
			$imp = $fc['imp_iva'];
			$item .= str_pad(str_replace(".", "",$imp ), 13, "0", STR_PAD_LEFT).$espacio;
			$imp = $fc['imp_rg3337'];
			$item .= str_pad(str_replace(".", "",$imp ), 13, "0", STR_PAD_LEFT).$espacio;
			$imp = $fc['imp_ingreso_bruto'];
			$item .= str_pad(str_replace(".", "",$imp ), 13, "0", STR_PAD_LEFT).$espacio;
			$imp = $fc['total'];
			$item .= str_pad(str_replace(".", "",$imp ), 15, "0", STR_PAD_LEFT).$espacio;
			$item .= date_format($fc['fecha'],'dmY').$espacio;
			$item .= str_pad($fc['pedido_ds'], 6, "0", STR_PAD_LEFT);
			
			//$string = implode('|', $item) . PHP_EOL;
			//$string = implode('|', $item) . PHP_EOL;
			$file->write($item. PHP_EOL);
			foreach ($fc['facturas_cuerpos_items'] as $fci): 
				$itemart = 'D'.$espacio;	
				$itemart .= $codigo.$espacio;
				$itemart .= str_pad($fc['comprobante']['seccion'], 4, "0", STR_PAD_LEFT);
				$itemart .= $fc['letra'];
				$itemart .= str_pad($fc['comprobante']['numero'], 8, "0", STR_PAD_LEFT).$espacio;
					
				$itemart .= str_pad('01', 2, "0", STR_PAD_LEFT).$espacio;
				
				$itemart .= str_pad($fci['codigo_barra'], 13, "0", STR_PAD_LEFT).$espacio;
				
				$itemart .= str_pad($fci['descripcion'], 30, " ", STR_PAD_RIGHT).$espacio;
				
				if ($fci['iva'])
				$itemart .= '1';
				else
				$itemart .= '0';
				
				$itemart .= $espacio. str_pad($fci['cantidad_facturada'], 6, "0", STR_PAD_LEFT).$espacio;
				$imp = $fci['precio_unitario'];
				$itemart .= str_pad(str_replace(".", "",$imp ), 13, "0", STR_PAD_LEFT).$espacio;
				$imp = $fci['precio_publico'];
				$itemart .= str_pad(str_replace(".", "",$imp ), 11, "0", STR_PAD_LEFT).$espacio;
				$imp = $fci['precio_total'];
				$itemart .= str_pad(str_replace(".", "",$imp ), 15, "0", STR_PAD_LEFT).$espacio;
				
				$file->write($itemart. PHP_EOL);
			endforeach; 
			//$file->append(utf8_encode($string));
			//$file->create('I am overwriting the contents of this file');
			
			
		endforeach; 
		
		// $file->append('I am adding to the bottom of this file.');
		// $file->delete(); // I am deleting this file
		$file->close(); // Be sure to close the file when you're done
		

    $this->response->type('txt');

    // Optionally force file download
    //
	//
	//$this->response->file('temp'. DS .'DETFAC'.$codigo.'.TXT');
	$this->response->file(
    'temp'. DS .'DETFAC'.$codigo.'.TXT',
    ['download' => true, 'name' => 'DETFAC'.$codigo.'.TXT']
	);

    return $this->response;
		//return $this->redirect(['action' => 'index']);
		
	}
	*/
	
	
	/**
     * View method
     *
     * @param string|null $id Facturas Cabecera id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
		$this->viewBuilder()->layout('store');
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

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $facturasCabecera = $this->FacturasCabeceras->newEntity();
        if ($this->request->is('post')) {
            $facturasCabecera = $this->FacturasCabeceras->patchEntity($facturasCabecera, $this->request->data);
            if ($this->FacturasCabeceras->save($facturasCabecera)) {
                $this->Flash->success(__('The facturas cabecera has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The facturas cabecera could not be saved. Please, try again.'));
            }
        }
        $clientes = $this->FacturasCabeceras->Clientes->find('list', ['limit' => 200]);
        $comprobantes = $this->FacturasCabeceras->Comprobantes->find('list', ['limit' => 200]);
        $this->set(compact('facturasCabecera', 'clientes', 'comprobantes'));
        $this->set('_serialize', ['facturasCabecera']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Facturas Cabecera id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $facturasCabecera = $this->FacturasCabeceras->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $facturasCabecera = $this->FacturasCabeceras->patchEntity($facturasCabecera, $this->request->data);
            if ($this->FacturasCabeceras->save($facturasCabecera)) {
                $this->Flash->success(__('The facturas cabecera has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The facturas cabecera could not be saved. Please, try again.'));
            }
        }
        $clientes = $this->FacturasCabeceras->Clientes->find('list', ['limit' => 200]);
        $comprobantes = $this->FacturasCabeceras->Comprobantes->find('list', ['limit' => 200]);
        $this->set(compact('facturasCabecera', 'clientes', 'comprobantes'));
        $this->set('_serialize', ['facturasCabecera']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Facturas Cabecera id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $facturasCabecera = $this->FacturasCabeceras->get($id);
        if ($this->FacturasCabeceras->delete($facturasCabecera)) {
            $this->Flash->success(__('The facturas cabecera has been deleted.'));
        } else {
            $this->Flash->error(__('The facturas cabecera could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
