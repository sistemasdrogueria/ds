<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Log\Log;
use Cake\I18n\Time;
use Cake\Database\Expression\QueryExpression;
use Cake\Datasource\ConnectionManager;
/**
 * Reclamos Controller
 *
 * @property \App\Model\Table\ReclamosTable $Reclamos
 */
class ReclamosController extends AppController
{
	public function isAuthorized()
    {
		 if (in_array($this->request->action, ['edit_admin', 'delete_admin','add_admin','index_admin','index_admin_search','view_admin'])) {
       
				if($this->request->session()->read('Auth.User.role')=='admin') 
				{				
					return true;			
				}			
				else 
				{	
					$this->redirect(array('controller' => 'carritos', 'action' => 'index'));	
					return false;						
				}		
            }		
			else 
			{		
				if (in_array($this->request->action, ['view', 'add','index','search','searchitem','add_reclamo','add_item','add_item_reclamo','confirm'])) {
				if($this->request->session()->read('Auth.User.role')=='client') 
                {	
					$tiene= $this->tienepermiso('reclamos',$this->request->action);
					return $tiene;			
                }	
                else 
				{
					if($this->request->session()->read('Auth.User.role')=='provider') 
					{
						$this->Flash->error(__('No tiene permisos para ingresar'),['key' => 'changepass']);
						return false;						
					}
					else {
						return false;	
						$this->Flash->error(__('No tiene permisos para ingresar'),['key' => 'changepass']);
						return $this->redirect(['controller' => 'Pages', 'action' => 'home']);
					}
                }	
				}
				else
				{
					$this->Flash->error(__('No tiene permisos para ingresar'),['key' => 'changepass']);		
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
    public function index()
    {
		$this->viewBuilder()->layout('store');
        $this->paginate = [
            'contain' => ['Clientes', 'ReclamosTipos', 'ReclamosEstados']
        ];
		$fech = Time::now();
		$fech->setDate($fech->year, $fech->month, 1);
		$fech->i18nFormat('yyyy-MM-dd');
		$fech2 = Time::now();
		$fech2->i18nFormat('yyyy-MM-dd');
		$fech2->modify('+1 days');	
		$reclamos = $this->Reclamos->find('all')
								->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
								->andWhere(['fecha_recepcion BETWEEN :start AND :end'])
								->bind(':start', $fech, 'date')
								->bind(':end',   $fech2, 'date');
        $this->set('reclamos', $this->paginate($reclamos));
        $this->set('_serialize', ['reclamos']);		
		$this->loadModel('ReclamosTipos');
		$reclamostipos =  $this->ReclamosTipos->find('list', ['keyField' => 'id','valueField' => 'nombre']);
        $this->set(compact('reclamostipos'));
		$this->set('reclamostipos2',null);
    }

	public function search()
    {
		$this->viewBuilder()->layout('store');
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
				$termsearchp = '%'.$this->request->data['terminobuscar'].'%';
			else
				$termsearchp ="";
			if ($this->request->data['reclamos_tipo_id']!= null)
				$tiporeclamo = $this->request->data['reclamos_tipo_id'];
			else
				$tiporeclamo =0;
			
			$this->request->session()->write('reclamos_tipo_id',$tiporeclamo);
			$this->request->session()->write('termsearchp',$termsearchp);
			$this->request->session()->write('fechadesde',$fechadesde);	
			$this->request->session()->write('fechahasta',$fechahasta);
		}
		else 
		{
			$fechahasta = $this->request->session()->read('fechahasta');
		    $fechadesde = $this->request->session()->read('fechadesde');
			$termsearchp = $this->request->session()->read('termsearchp');
			$tiporeclamo = $this->request->session()->read('reclamos_tipo_id');
		}
		
        $this->paginate = [		
		'limit' => 11,
		];
		
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

		if (($fechadesde !=0) || ($fechahasta !=0) || ($termsearchp !="") || ($tiporeclamo !=0) )
		{	
			$reclamosA = $this->Reclamos->find('all')
				->select(['id', 
						'cliente_id', 
						'factura_numero', 
						'guia_numero', 
						'reclamos_tipo_id', 
						'transporte', 
						'observaciones', 
						'fecha_recepcion', 
						'estado_id','creado'])
				->hydrate(false)
				->join([
					'ri' => [
						'table' => 'reclamos_items',
						'type' => 'left',
						'conditions' => 'ri.reclamo_id = Reclamos.id',
					],
					'a' => [
						'table' => 'articulos',
						'type' => 'left',
						'conditions' => 'a.id = ri.articulo_id',
					]
				])
				->where(['Reclamos.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
				->group('Reclamos.id');
		}
		else
			{
				$reclamosA=null;
				$this->redirect($this->referer());
			}		
		if ($tiporeclamo!=0)
			$reclamosA->where(['Reclamos.reclamos_tipo_id' => $tiporeclamo]);
		if (($fechadesde !=0) || ($fechahasta !=0))
			$reclamosA->andWhere(["Reclamos.creado BETWEEN '".$fechadesde2->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta2->i18nFormat('yyyy-MM-dd')."'"]);
	  	if ($termsearchp!="")
			$reclamosA->where(['a.descripcion_pag LIKE'=>$termsearchp])->orWhere(['a.troquel LIKE'=>$termsearchp]);
		if ($reclamosA!=null)
			$reclamos = $this->paginate($reclamosA);
		else
			$reclamos = null;
		
		//debug($pedidos);
		$this->set('reclamos',$reclamos);
		
		$this->loadModel('ReclamosTipos');
		$reclamostipos =  $this->ReclamosTipos->find('list', ['keyField' => 'id','valueField' => 'nombre']);
       
		$reclamostipos2 =  $this->ReclamosTipos->find('all');
		$this->set('reclamostipos',$reclamostipos->toArray());
		$this->set('reclamostipos2',$reclamostipos2->toArray());
		
    }

    /**
     * View method
     *
     * @param string|null $id Reclamo id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
		$this->viewBuilder()->layout('store');
        $reclamo = $this->Reclamos->get($id, [
            'contain' => ['Clientes', 'ReclamosTipos', 'ReclamosEstados']
        ]);
		$this->loadModel('ReclamosItems');
		$reclamositems = $this->ReclamosItems->find('all')
				->select([
						'ReclamosItems.id', 
						'ReclamosItems.reclamo_id', 
						'ReclamosItems.articulo_id', 
						'a.laboratorio_id',
						'ReclamosItems.cantidad', 
						'ReclamosItems.detalle', 
						'ReclamosItems.fecha_vencimiento', 
						'ReclamosItems.lote', 
						'ReclamosItems.serie'

						])
				->hydrate(false)
				->join([
					'a' => [
						'table' => 'articulos',
						'type' => 'left',
						'conditions' => 'a.id = ReclamosItems.articulo_id',
					]
				])
				->where(['ReclamosItems.reclamo_id' => $id]);

		$this->set('reclamositemstemps', $reclamositems);
        $this->set('reclamo', $reclamo);
        $this->set('_serialize', ['reclamo']);
        $this->set('_serialize', ['reclamositemstemps']);
		$this->loadModel('Laboratorios');
		$this->set('laboratorios',$this->Laboratorios->find('list',['keyField' => 'id','valueField'=>'nombre'])
		->order(['nombre' => 'ASC']));
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add_reclamo($articulos = null)
    {
		$this->viewBuilder()->layout('store');
        $reclamo = $this->Reclamos->newEntity();
        if ($this->request->is('post','get')) {
			$reclamo['cliente_id']=$this->request->session()->read('Auth.User.cliente_id');
		    /*
			$fecha = Time::createFromFormat('d/m/Y',,'America/Argentina/Buenos_Aires');
			$fecha->i18nFormat('yyyy-MM-dd');*/
			$reclamo['fecha_recepcion']  =$this->request->data['fecha_recepcion'];
			$reclamo['observaciones']  = $this->request->data['observaciones'];
			$reclamo['reclamos_tipo_id']  = $this->request->data['reclamos_tipo_id'];
			$reclamo['factura_numero']  = $this->request->data['factura_numero'];
			
			$this->request->session()->write('reclamo',$reclamo);
        }
		
		if  ( $this->request->session()->read('articulos')!=null)		
			$articulos = $this->request->session()->read('articulos');
		else
				$articulos= null;
			
		if  ( $this->request->session()->read('reclamo')!=null)		
			$reclamo = $this->request->session()->read('reclamo');
		else
			$reclamo= null;	
		
		$this->loadModel('ReclamosTipos');
		$reclamostipos =  $this->ReclamosTipos->find('list', ['keyField' => 'id','valueField' => 'nombre']);
        $this->set(compact('reclamo', 'reclamostipos'));
        $this->set('_serialize', ['reclamo']);
		$this->loadModel('Categorias');
		$this->set('categorias', $this->Categorias->find('list', ['keyField' => 'id','valueField' => 'nombre']));
		$this->loadModel('Laboratorios');
		$this->set('laboratorios',$this->Laboratorios->find('list',['keyField' => 'id','valueField'=>'nombre'])
		->order(['nombre' => 'ASC']));
		$this->loadModel('ReclamosItemsTemps');
	    $reclamositemstemps = $this->ReclamosItemsTemps->find('all')
				->select([
						'ReclamosItemsTemps.id', 
						'ReclamosItemsTemps.cliente_id', 
						'ReclamosItemsTemps.articulo_id', 
						'a.laboratorio_id',
						'ReclamosItemsTemps.cantidad', 
						'ReclamosItemsTemps.detalle', 
						'ReclamosItemsTemps.fecha_vencimiento', 
						'ReclamosItemsTemps.lote', 
						'ReclamosItemsTemps.serie', 
						'ReclamosItemsTemps.creado'
						])
				->hydrate(false)
				->join([
					'a' => [
						'table' => 'articulos',
						'type' => 'left',
						'conditions' => 'a.id = ReclamosItemsTemps.articulo_id',
					]
				])
				->where(['ReclamosItemsTemps.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]);
		$this->set('reclamositemstemps', $reclamositemstemps);
		$this->set('articulos',$articulos);
    }

	public function add_item_reclamo($articulos = null)
    {
		$this->viewBuilder()->layout('store');
        $reclamo = $this->Reclamos->newEntity();
        if ($this->request->is('post','get')) {
			
    		$reclamo = $this->Reclamos->patchEntity($reclamo, $this->request->data);
			$reclamo['cliente_id']=$this->request->session()->read('Auth.User.cliente_id');
		    $reclamo['fecha_recepcion']=$this->request->data['fecha_recepcion'];
			$fecha = Time::createFromFormat('d/m/Y',$this->request->data['fecha_recepcion'],'America/Argentina/Buenos_Aires');
			$fecha->i18nFormat('yyyy-MM-dd');
			$reclamo['fecha_recepcion']  = $fecha;
			if ($this->Reclamos->save($reclamo)) {
				$this->Flash->success('Se reclamo fue guardado',['key' => 'changepass']);
                
                return $this->redirect(['controller'=>'Reclamos','action' => 'index']);
            } else {
                $this->Flash->error('El reclamo no fue guardado, intente nuevamente.');
            }
			/*
			if ($this->request->session()->read('reclamostipoid')!=null)
				$reclamostipoid= $this->request->session()->read('reclamostipoid');
			if ($this->request->session()->read('fecharecepcion')!=null)
				$fecharecepcion= $this->request->session()->read('fecharecepcion');	
			if ($this->request->session()->read('facturanumero')!=null)
				$facturanumero = $this->request->session()->read('facturanumero');
			if ($this->request->session()->read('observaciones')!=null)
				$observaciones = $this->request->session()->read('observaciones');*/
			$articulos = $this->request->session()->read('articulos');
        }
		else
			$articulos= null;
		
		$this->loadModel('ReclamosTipos');
		$reclamostipos =  $this->ReclamosTipos->find('list', ['keyField' => 'id','valueField' => 'nombre']);
        $this->set(compact('reclamo', 'reclamostipos'));
        $this->set('_serialize', ['reclamo']);
		$this->loadModel('Categorias');
		$this->set('categorias', $this->Categorias->find('list', ['keyField' => 'id','valueField' => 'nombre']));
		$this->loadModel('Laboratorios');
		$this->set('laboratorios',$this->Laboratorios->find('list',['keyField' => 'id','valueField'=>'nombre'])
		->order(['nombre' => 'ASC']));
		$this->loadModel('ReclamosItemsTemps');
	    $reclamositemstemps = $this->ReclamosItemsTemps->find('all')
				->select([
						'ReclamosItemsTemps.id', 
						'ReclamosItemsTemps.cliente_id', 
						'ReclamosItemsTemps.articulo_id', 
						'a.laboratorio_id',
						'ReclamosItemsTemps.cantidad', 
						'ReclamosItemsTemps.detalle', 
						'ReclamosItemsTemps.fecha_vencimiento', 
						'ReclamosItemsTemps.lote', 
						'ReclamosItemsTemps.serie', 
						'ReclamosItemsTemps.creado'
						])
				->hydrate(false)
				->join([
					'a' => [
						'table' => 'articulos',
						'type' => 'left',
						'conditions' => 'a.id = ReclamosItemsTemps.articulo_id',
					]
				])
				->where(['ReclamosItemsTemps.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]);
		$this->set('reclamositemstemps', $reclamositemstemps);
		$this->set('articulos',$articulos);
    }

	
	public function add_item()
    {
		$this->loadModel('ReclamosItemsTemps');
        $reclamosItemsTemp = $this->ReclamosItemsTemps->newEntity();
        if ($this->request->is('post')) {
            $reclamosItemsTemp['cliente_id'] = $this->request->session()->read('Auth.User.cliente_id');
			$reclamosItemsTemp['articulo_id'] = $this->request->data['articulo_id'];
			$reclamosItemsTemp['cantidad'] = $this->request->data['cantidad'];
			$reclamosItemsTemp['detalle'] = $this->request->data['descripcion']; 	
			if ($this->request->data['fecha_vencimiento']!=null)
			{
				$fecha_vencimiento = Time::createFromFormat('d/m/Y',$this->request->data['fecha_vencimiento'],'America/Argentina/Buenos_Aires');
				$fecha_vencimiento->i18nFormat('yyyy-MM-dd');
			}
			else
				$fecha_vencimiento=$this->request->data['fecha_vencimiento'];
			$reclamosItemsTemp['fecha_vencimiento'] =  $fecha_vencimiento;
			$reclamosItemsTemp['lote'] = $this->request->data['lote'];
			$reclamosItemsTemp['serie'] = $this->request->data['serie'];

			$creado = Time::now();
			$creado->i18nFormat('yyyy-MM-dd H:i:s');
			$reclamosItemsTemp['creado'] = $creado;

			if ($this->ReclamosItemsTemps->save($reclamosItemsTemp)) {
                $this->Flash->success(__('Se agrego el item al reclamo.'),['key' => 'changepass']);
                return $this->redirect(['action' => 'searchitem']);
            } 
			else {
                $this->Flash->error(__('No se pudo agregar el itme al reclamo, intente de nuevo.'),['key' => 'changepass']);
            }
        }
        $this->set(compact('reclamosItemsTemp'));
        $this->set('_serialize', ['reclamosItemsTemp']);
		$this->redirect(['action' => 'searchitem']);
    }

	public function confirm()
    {
		$this->viewBuilder()->layout('store');
        $reclamo = $this->Reclamos->newEntity();
        if ($this->request->is('post')) {
            //$reclamo = $this->Reclamos->patchEntity($reclamo, $this->request->data);
 			if  ( $this->request->session()->read('reclamo')!=null)		
				$reclamo2 = $this->request->session()->read('reclamo');
								$reclamo['cliente_id']  = $reclamo2['cliente_id'];
				$fecha = Time::createFromFormat('d/m/Y',$reclamo2['fecha_recepcion'],'America/Argentina/Buenos_Aires');
			$fecha->i18nFormat('yyyy-MM-dd');
			$reclamo['fecha_recepcion']  = $fecha;
			
				$reclamo['observaciones']  = $reclamo2['observaciones'];
				$reclamo['reclamos_tipo_id']  = $reclamo2['reclamos_tipo_id'];
				$reclamo['factura_numero']  = $reclamo2['factura_numero'];
				
			if ($this->Reclamos->save($reclamo)) {
				$connection = ConnectionManager::get('default');
				$id = $this->Reclamos->find()->where(['cliente_id'=>$reclamo2['cliente_id']])
					->order(['id'=>'DESC']) ->first(); 
				debug($id);
				//
				$confirmados = $connection->execute('
				INSERT INTO reclamos_items (id, reclamo_id, articulo_id, cantidad, detalle, fecha_vencimiento, lote, serie)
				SELECT null, '.$id['id'].' , articulo_id, cantidad, detalle, fecha_vencimiento, lote, serie 
				FROM reclamos_items_temps WHERE cliente_id='.$this->request->session()->read('Auth.User.cliente_id') );
				$confirmados2 = $connection->execute('DELETE FROM reclamos_items_temps WHERE cliente_id='.$this->request->session()->read('Auth.User.cliente_id') );
				
				$this->Flash->success('El reclamo devolución fue enviado.',['key' => 'changepass']);
                
                return $this->redirect(['controller'=>'Reclamos','action' => 'index']);
            } else {
                $this->Flash->error('El reclamo no fue guardado, intente nuevamente.');
            }
        }
		$this->loadModel('ReclamosTipos');
		$reclamostipos =  $this->ReclamosTipos->find('list', ['keyField' => 'id','valueField' => 'nombre']);
        $this->set(compact('reclamo', 'reclamostipos'));
        $this->set('_serialize', ['reclamo']);
		$this->loadModel('Categorias');
		$this->set('categorias', $this->Categorias->find('list', ['keyField' => 'id','valueField' => 'nombre']));
		$this->loadModel('Laboratorios');
		$this->set('laboratorios',$this->Laboratorios->find('list',['keyField' => 'id','valueField'=>'nombre']));
    }
	
	public function add()
    {
		$this->viewBuilder()->layout('store');
        $reclamo = $this->Reclamos->newEntity();
        if ($this->request->is('post')) {
            $reclamo = $this->Reclamos->patchEntity($reclamo, $this->request->data);
			$reclamo['cliente_id']=$this->request->session()->read('Auth.User.cliente_id');
		    $reclamo['fecha_recepcion']=$this->request->data['fecha_recepcion'];
			$fecha = Time::createFromFormat('d/m/Y',$this->request->data['fecha_recepcion'],'America/Argentina/Buenos_Aires');
			$fecha->i18nFormat('yyyy-MM-dd');
			$reclamo['fecha_recepcion']  = $fecha;
			if ($this->Reclamos->save($reclamo)) {
                $this->Flash->success('El reclamo fue guardado.');
                return $this->redirect(['controller'=>'Reclamos','action' => 'index']);
            } else {
                $this->Flash->error('El reclamo no fue guardado, intente nuevamente.');
            }
        }
		$this->loadModel('ReclamosTipos');
		$reclamostipos =  $this->ReclamosTipos->find('list', ['keyField' => 'id','valueField' => 'nombre']);
        $this->set(compact('reclamo', 'reclamostipos'));
        $this->set('_serialize', ['reclamo']);
		$this->loadModel('Categorias');
		$this->set('categorias', $this->Categorias->find('list', ['keyField' => 'id','valueField' => 'nombre']));
		$this->loadModel('Laboratorios');
		$this->set('laboratorios',$this->Laboratorios->find('list',['keyField' => 'id','valueField'=>'nombre']));
    }
		
	public function searchitem()
    {
		if ($this->request->is('post'))
		{	
			/*if ($this->request->data['reclamos_tipo_id']!= null)
				$reclamostipoid = $this->request->data['reclamos_tipo_id'];
			else
				$reclamostipoid=0;
			
			if ($this->request->data['fecharecepcion']!= null)
				$fecharecepcion = $this->request->data['fecharecepcion'];
			else
				$fecharecepcion =0;

			if ($this->request->data['observaciones']!= null)
				$observaciones = $this->request->data['observaciones'];
			else
				$observaciones ="";
			
			if ($this->request->data['factura_numero']!= null)
				$facturanumero = $this->request->data['factura_numero'];
			else
				$facturanumero =0;
	*/
			if ($this->request->data['categoria_id']!= null)
				$categoriaid = $this->request->data['categoria_id'];
			else
				$categoriaid=0;
			if ($this->request->data['laboratorio_id']!= null)
				$laboratorioid = $this->request->data['laboratorio_id'];
			else
				$laboratorioid =0;

			if ($this->request->data['terminobuscar']!= null)
				$termsearch = '%'.$this->request->data['terminobuscar'].'%';
			else
				$termsearch ="";
			/*
			$this->request->session()->write('reclamostipoid',$reclamostipoid);
			$this->request->session()->write('fecharecepcion',$fecharecepcion);	
			$this->request->session()->write('facturanumero',$facturanumero);
			$this->request->session()->write('observaciones',$observaciones);*/
			
			$this->request->session()->write('termsearch',$termsearch);
			$this->request->session()->write('categoriaid',$categoriaid);	
			$this->request->session()->write('laboratorioid',$laboratorioid);
		}
		else 
		{
			$categoriaid = $this->request->session()->read('categoriaid');
		    $laboratorioid = $this->request->session()->read('laboratorioid');
			$termsearch = $this->request->session()->read('termsearch');
		}
		$this->viewBuilder()->layout('store');
        $this->paginate = [		
		'contain' => ['Laboratorios','Categorias'],
		'limit' => 4,
        'order' => ['Articulos.descripcion_pag' => 'asc']];

		$this->loadModel('Articulos');
	    $categorias = $this->Articulos->Categorias->find('list', ['limit' => 200]);
		
		if (($termsearch!="") || ($categoriaid !=0) || ($laboratorioid !=0))
		{
			$articulosA = $this->Articulos->find();
			if ($termsearch!="")
				$articulosA->where(['Articulos.descripcion_pag LIKE'=>$termsearch])
						->orWhere(['Articulos.codigo_barras LIKE'=>$termsearch])
						->orWhere(['Articulos.troquel LIKE'=>$termsearch]);

			if ($categoriaid !=0)
				$articulosA->where(['Articulos.categoria_id'=>$categoriaid]);
			
			if ($laboratorioid !=0)
				$articulosA->where(['Articulos.laboratorio_id'=>$laboratorioid]);
		}
        else
		{
			$articulosA=null;
			$this->redirect($this->referer());
		}
		
		if ($articulosA!=null)
		{
			$articulos = $this->paginate($articulosA);
		}
		else
		{
			$articulos = null;
		}
/*	
		//$this->set('articulos',$articulos);
		$this->loadModel('ReclamosTipos');
		$reclamostipos =  $this->ReclamosTipos->find('list', ['keyField' => 'id','valueField' => 'nombre']);
        $this->set(compact('reclamo', 'reclamostipos'));
        $this->set('_serialize', ['reclamo']);
		$this->loadModel('Categorias');
		$this->set('categorias', $this->Categorias->find('list', ['keyField' => 'id','valueField' => 'nombre']));
		$this->loadModel('Laboratorios');
		$this->set('laboratorios',$this->Laboratorios->find('list',['keyField' => 'id','valueField'=>'nombre'])
		->order(['nombre' => 'ASC']));
		$this->loadModel('ReclamosItemsTemps');
	    $reclamositemstemps = $this->ReclamosItemsTemps->find('all')
				->select([
						'ReclamosItemsTemps.id', 
						'ReclamosItemsTemps.cliente_id', 
						'ReclamosItemsTemps.articulo_id', 
						'a.laboratorio_id',
						'ReclamosItemsTemps.cantidad', 
						'ReclamosItemsTemps.detalle', 
						'ReclamosItemsTemps.fecha_vencimiento', 
						'ReclamosItemsTemps.lote', 
						'ReclamosItemsTemps.serie', 
						'ReclamosItemsTemps.creado'
						])
				->hydrate(false)
				->join([
					'a' => [
						'table' => 'articulos',
						'type' => 'left',
						'conditions' => 'a.id = ReclamosItemsTemps.articulo_id',
					]
				])
				->where(['ReclamosItemsTemps.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]);
		$this->set('reclamositemstemps', $reclamositemstemps);*/
		$this->request->session()->write('articulos',$articulos);
		return $this->redirect(['action' => 'add_reclamo']);
		
	}
	
    /**
     * Edit method
     *
     * @param string|null $id Reclamo id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
	public function index_admin()
    {
		$this->viewBuilder()->layout('admin');
        $this->paginate = [
			          
			'limit' => 10,
            'contain' => ['Clientes', 'ReclamosTipos', 'ReclamosEstados']
        ];
			$fechahasta2 = Time::now();
			
			$fechahasta2->modify('+1 days');
			$fechahasta2->i18nFormat('yyyy-MM-dd');
		
			$fechadesde2 = Time::now();
			$fechadesde2->i18nFormat('yyyy-MM-dd');

		$reclamos = $this->Reclamos->find('all')
		
		->where(["Reclamos.creado BETWEEN '".$fechadesde2->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta2->i18nFormat('yyyy-MM-dd')."'"]);
					
       	$this->loadModel('ReclamosEstados');
		$ReclamosEstados = $this->Reclamos->ReclamosEstados->find('list',['keyField' => 'id','valueField'=>'nombre']);
        $ReclamosEstados->toArray();	
		$this->set(compact('ReclamosEstados')); 
		
		$this->set('reclamos', $this->paginate($reclamos));
		
				$this->loadModel('ReclamosTipos');
		$reclamosTipos = $this->ReclamosTipos->find('list',['keyField' => 'id','valueField'=>'nombre']);
		$this->set('ReclamosTipos', $reclamosTipos->toArray());
		
		
		$this->set('_serialize', ['reclamos']);
		$this->set('titulo','Lista de reclamos');
	
    }

	public function index_admin_search()
    {
        $this->viewBuilder()->layout('admin');
		$this->paginate = [
			          
			'limit' => 10,
            'contain' => ['Clientes', 'ReclamosTipos', 'ReclamosEstados']
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
			if ($this->request->data['termino']!= null)
				$termsearchp = '%'.$this->request->data['termino'].'%';
			else
				$termsearchp ="";
			if ($this->request->data['reclamos_tipo_id']!= null)
				$tiporeclamo = $this->request->data['reclamos_tipo_id'];
			else
				$tiporeclamo =0;
			
			$this->request->session()->write('reclamos_tipo_id',$tiporeclamo);
			$this->request->session()->write('termsearchp',$termsearchp);
			$this->request->session()->write('fechadesde',$fechadesde);	
			$this->request->session()->write('fechahasta',$fechahasta);
		}
		else 
		{
			$fechahasta = $this->request->session()->read('fechahasta');
		    $fechadesde = $this->request->session()->read('fechadesde');
			$termsearchp = $this->request->session()->read('termsearchp');
			$tiporeclamo = $this->request->session()->read('reclamos_tipo_id');
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

		if (($fechadesde !=0) || ($fechahasta !=0) || ($termsearchp !="") || ($tiporeclamo !=0) )
		{	
			$reclamosA = $this->Reclamos->find()

				->hydrate(false)
				->join([
					'c' => [
						'table' => 'clientes',
						'type' => 'left',
						'conditions' => 'c.id = Reclamos.cliente_id',
					],
					'ri' => [
						'table' => 'reclamos_items',
						'type' => 'left',
						'conditions' => 'ri.reclamo_id = Reclamos.id',
					],
					'a' => [
						'table' => 'articulos',
						'type' => 'left',
						'conditions' => 'a.id = ri.articulo_id',
					]
					
				])
				
				->group('Reclamos.id');
		}
		else
			{
				$reclamosA=null;
				$this->redirect($this->referer());
			}		
		if ($tiporeclamo!=0)
			$reclamosA->where(['Reclamos.reclamos_tipo_id' => $tiporeclamo]);
		if (($fechadesde !=0) || ($fechahasta !=0))
			$reclamosA->andWhere(["Reclamos.creado BETWEEN '".$fechadesde2->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta2->i18nFormat('yyyy-MM-dd')."'"]);
	  	if ($termsearchp!="")
			$reclamosA->where(['a.descripcion_pag LIKE'=>$termsearchp])->orWhere(['a.troquel LIKE'=>$termsearchp])->orWhere(['c.codigo LIKE'=>$termsearchp])->orWhere(['c.razon_social LIKE'=>$termsearchp]);
		
		if ($reclamosA!=null)
			$reclamos = $this->paginate($reclamosA);
		else
			$reclamos = null;
		
		
		 $this->loadModel('ReclamosEstados');
		$ReclamosEstados = $this->Reclamos->ReclamosEstados->find('list',['keyField' => 'id','valueField'=>'nombre']);
        $ReclamosEstados->toArray();	
		$this->set(compact('ReclamosEstados'));
		
		 	
		$this->set('reclamos',$reclamos);
		
		$this->loadModel('ReclamosTipos');
		$reclamosTipos = $this->ReclamosTipos->find('list',['keyField' => 'id','valueField'=>'nombre']);
		$this->set('ReclamosTipos', $reclamosTipos->toArray());
		$this->set('_serialize', ['reclamos']);
		$this->set('titulo','Lista de reclamos');

    }

	
    /**
     * View method
     *
     * @param string|null $id Reclamo id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view_admin($id = null)
    {
        $this->viewBuilder()->layout('admin');
		$reclamo = $this->Reclamos->get($id, [
            'contain' => ['Clientes', 'ReclamosTipos', 'ReclamosEstados']
        ]);
		$this->loadModel('ReclamosItems');
 
		$reclamositems = $this->ReclamosItems->find('all')
				->select([
						'ReclamosItems.id', 
						'ReclamosItems.reclamo_id', 
						'ReclamosItems.articulo_id', 
						'a.laboratorio_id',
						'ReclamosItems.cantidad', 
						'ReclamosItems.detalle', 
						'ReclamosItems.fecha_vencimiento', 
						'ReclamosItems.lote', 
						'ReclamosItems.serie'

						])
				->hydrate(false)
				->join([
					'a' => [
						'table' => 'articulos',
						'type' => 'left',
						'conditions' => 'a.id = ReclamosItems.articulo_id',
					]
				])
				->where(['ReclamosItems.reclamo_id' => $id]);

		$this->set('reclamositemstemps', $reclamositems);
        $this->set('reclamo', $reclamo);
        $this->set('_serialize', ['reclamo']);
        $this->set('_serialize', ['reclamositemstemps']);
	
		$reclamo['leido']  = 1;
		if ($this->Reclamos->save($reclamo)) {}
		
		if ($this->request->session()->read('Categorias')== null)
		{
		$this->loadModel('Categorias');
		$this->loadModel('Laboratorios');
		$categorias = $this->Categorias->find('list',['keyField' => 'id','valueField'=>'nombre']);
		$laboratorios = $this->Laboratorios->find('list',['keyField' => 'id','valueField'=>'nombre'])->order(['nombre' => 'ASC']);
		$categorias= $categorias->toArray();
		$laboratorios=$laboratorios->toArray();
		$this->request->session()->write('Categorias',$categorias);
		$this->request->session()->write('Laboratorios',$laboratorios);
			
		}
		else{
			
			$laboratorios =$this->request->session()->read('Laboratorios');
			$categorias = $this->request->session()->read('Categorias');
		}	
		
		$this->loadModel('ReclamosEstados');
		$ReclamosEstados = $this->Reclamos->ReclamosEstados->find('list',['keyField' => 'id','valueField'=>'nombre']);
        $ReclamosEstados->toArray();	
		$this->set(compact('ReclamosEstados'));
				
		$this->set('laboratorios',$laboratorios);
		
        $this->set('_serialize', ['reclamo']);
		$this->set('titulo','Visualizar de reclamo');
    }

    /**
     * Edit method
     *
     * @param string|null $id Reclamo id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit_admin($id = null)
    {
        $this->viewBuilder()->layout('admin');
		$reclamo = $this->Reclamos->get($id, [
            'contain' => ['Clientes', 'ReclamosTipos', 'ReclamosEstados']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $reclamo = $this->Reclamos->patchEntity($reclamo, $this->request->data);
            if ($this->Reclamos->save($reclamo)) {
                $this->Flash->success('The reclamo has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The reclamo could not be saved. Please, try again.');
            }
        }
        $clientes = $this->Reclamos->Clientes->find('list', ['limit' => 200]);
        $reclamosTipos = $this->Reclamos->ReclamosTipos->find('list', ['limit' => 200]);
        $this->loadModel('ReclamosEstados');
		$ReclamosEstados = $this->Reclamos->ReclamosEstados->find('list',['keyField' => 'id','valueField'=>'nombre']);
        $ReclamosEstados->toArray();
        
		$this->set(compact('reclamo', 'clientes', 'reclamosTipos', 'ReclamosEstados'));
        $this->set('_serialize', ['reclamo']);
		$this->set('titulo','Cambiar estado del reclamo');
    }

    /**
     * Delete method
     *
     * @param string|null $id Reclamo id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete_admin($id = null)
    {
		$this->viewBuilder()->layout('admin');	
        $this->request->allowMethod(['post', 'delete']);
        $reclamo = $this->Reclamos->get($id);
        if ($this->Reclamos->delete($reclamo)) {
            $this->Flash->success('The reclamo has been deleted.');
        } else {
            $this->Flash->error('The reclamo could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }

}
