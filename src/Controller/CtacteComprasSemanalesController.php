<?php
namespace App\Controller;
use Cake\I18n\Time;
use App\Controller\AppController;

/**
 * CtacteComprasSemanales Controller
 *
 * @property \App\Model\Table\CtacteComprasSemanalesTable $CtacteComprasSemanales
 */
class CtacteComprasSemanalesController extends AppController
{
public function isAuthorized()
    {
		if (in_array($this->request->action, ['search','home','index'])) {
       
				if($this->request->session()->read('Auth.User.role')=='admin') 
				{				
					return true;			
				}			
				else 
				{	
					if($this->request->session()->read('Auth.User.role')=='client') 
					{	
						$tiene= $this->tienepermiso('ctacteestados',$this->request->action);
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
		/*
		$this->viewBuilder()->layout('store');
        $this->paginate = [
            'limit' => 100
			
        ];
		
		$this->loadModel('CtacteResumenSemanales');		
		$ctacteresumensemanales = $this->CtacteResumenSemanales->find('all') 
			-> order(['id' => 'DESC']);
		
		$row = $ctacteresumensemanales->first();
		
		$this->set('row', $row);
		
		$ctactecomprassemanales = $this->CtacteComprasSemanales->find('all')	
					->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
					->andWhere(["fecha_factura BETWEEN '".$row['desde']->i18nFormat('yyyy-MM-dd')."' AND '".$row['hasta']->i18nFormat('yyyy-MM-dd')."'"])
					->order(['fecha_factura' => 'ASC']);
					
		$totalmedicamento=0;
		$totalperfumeria=0;
		$totaloferta=0;
		$totaltransfer =0;
		foreach ($ctactecomprassemanales as $ctactecomprassemanale): 
			if ($ctactecomprassemanale->tipo==1)
			$totalmedicamento = $totalmedicamento + $ctactecomprassemanale['importe'];
		    if ($ctactecomprassemanale->tipo==2)
			$totalperfumeria= $totalperfumeria + $ctactecomprassemanale['importe'];
			if ($ctactecomprassemanale->tipo==3)
			$totaloferta= $totaloferta + $ctactecomprassemanale['importe'];
			if ($ctactecomprassemanale->tipo==4)
			$totaltransfer= $totaltransfer + $ctactecomprassemanale['importe'];
		endforeach; 
		
		 $this->set('totalmedicamento', $totalmedicamento);
		 $this->set('totalperfumeria', $totalperfumeria);
		 $this->set('totaloferta', $totaloferta);
		 $this->set('totaltransfer', $totaltransfer);
		 
        $this->set('ctacteComprasSemanales', $this->paginate($ctactecomprassemanales));
        $this->set('_serialize', ['ctacteComprasSemanales']);*/
		$this->viewBuilder()->layout('store');
        $this->paginate = [
            'limit' => 100
			
        ];
		if ($this->request->is('post','get'))
		{	
			
			if ($this->request->data['cliente_id']!= null)
				$cliente_id = $this->request->data['cliente_id'];
			else
				$cliente_id = $this->request->session()->read('Auth.User.cliente_id');

			if ($this->request->data['nro_sistema']!= null)
				$nro_sistema = $this->request->data['nro_sistema'];
			else
				$nro_sistema = 0;

			$this->request->session()->write('nro_sistema',$nro_sistema);
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
			if (!empty($this->request->session()->read('cliente_id')))
				$nro_sistema = $this->request->session()->read('nro_sistema');
			
			else
				$nro_sistema = 0;
		}		
		
		$this->loadModel('CtacteResumenSemanales');		
		$ctacteresumensemanales = $this->CtacteResumenSemanales->find('all'); 
			
		
		if ($nro_sistema > 0)
			$row = $ctacteresumensemanales->where(['nro_sistema'=>$nro_sistema])->first([]);
		else
			$row = $ctacteresumensemanales->order(['id' => 'DESC'])->first([]);
						
		$this->set('row', $row);
		
		/*$ctactecomprassemanales = $this->CtacteComprasSemanales->find('all')	
					->where(['cliente_id' => $cliente_id])
					->andWhere(["fecha_factura BETWEEN '".$row['desde']->i18nFormat('yyyy-MM-dd')."' AND '".$row['hasta']->i18nFormat('yyyy-MM-dd')."'"])
					->order(['fecha_factura' => 'ASC']);*/
		$ctactecomprassemanales = $this->CtacteComprasSemanales->find()
					->select(['CtacteComprasSemanales.id', 
					'CtacteComprasSemanales.cliente_id', 
					'CtacteComprasSemanales.numero', 
					'CtacteComprasSemanales.fecha_factura', 
					'CtacteComprasSemanales.importe', 
					'CtacteComprasSemanales.tipo', 
					'CtacteComprasSemanales.fecha_vencimiento', 
					'CtacteComprasSemanales.tipo_factura', 
					'ce.nota','ce.seccion','ce.cliente_id','ce.nota','ce.numero'])
					
					->join(['ce' => ['table' => 'comprobantes','type' => 'INNER','conditions' => ['ce.cliente_id = CtacteComprasSemanales.cliente_id','ce.nota = CtacteComprasSemanales.numero']]])
					->where(['CtacteComprasSemanales.cliente_id' => $cliente_id])
					->andWhere(["CtacteComprasSemanales.fecha_factura BETWEEN '".$row['desde']->i18nFormat('yyyy-MM-dd')."' AND '".$row['hasta']->i18nFormat('yyyy-MM-dd')."'"])
					->andWhere(["ce.fecha BETWEEN '".$row['desde']->i18nFormat('yyyy-MM-dd')."' AND '".$row['hasta']->i18nFormat('yyyy-MM-dd')."'"])
					->order(['CtacteComprasSemanales.fecha_factura' => 'ASC','ce.numero'=>'ASC']);

					
		$totalmedicamento=0;
		$totalperfumeria=0;
		$totaloferta=0;
		$totaltransfer =0;
		
		$fecha = Time::now();
		$fecha->setDate(1970, 1, 1);
		$fecha->i18nFormat('yyyy-MM-dd');
		foreach ($ctactecomprassemanales as $ctactecomprassemanale): 
			if ($ctactecomprassemanale->tipo==1)
			$totalmedicamento = $totalmedicamento + $ctactecomprassemanale['importe'];
		    if ($ctactecomprassemanale->tipo==2)
			$totalperfumeria= $totalperfumeria + $ctactecomprassemanale['importe'];
			if ($ctactecomprassemanale->tipo==3)
			$totaloferta= $totaloferta + $ctactecomprassemanale['importe'];
			if ($ctactecomprassemanale->tipo==4)
			if ($ctactecomprassemanale['fecha_vencimiento']>$fecha)
					$totaloferta= $totaloferta + $ctactecomprassemanale['importe'];
					else
					$totaltransfer= $totaltransfer + $ctactecomprassemanale['importe'];
		endforeach; 
		
		 $this->set('totalmedicamento', $totalmedicamento);
		 $this->set('totalperfumeria', $totalperfumeria);
		 $this->set('totaloferta', $totaloferta);
		 $this->set('totaltransfer', $totaltransfer);
		  $this->set('ctacteComprasSemanale', $ctactecomprassemanales->toArray());
        $this->set('ctacteComprasSemanales', $this->paginate($ctactecomprassemanales));
        $this->set('_serialize', ['ctacteComprasSemanales']);
		
		$ctactesemanas =$this->CtacteResumenSemanales->find('all')->order(['nro_sistema' => 'DESC']);
			
		$first =0;
		foreach ($ctactesemanas as $opcion) {
			if ($first==0)
			{
				$first=$opcion['nro_sistema'];
				
			}
			$semanas[$opcion['nro_sistema']] = date_format($opcion['desde'],'d-m-Y').' al '.date_format($opcion['hasta'],'d-m-Y'). ' R '.$opcion['nro_sistema'];    
		}	
		$semanas[$first]="Seleccioná la Semana";
		
		
		$this->listadocliente();
        $this->set('ctacteResumenSemanales', $semanas);
		//$this->set('ctacteResumenSemanales', $this->CtacteResumenSemanales);
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
    /**
     * View method
     *
     * @param string|null $id Ctacte Compras Semanale id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $ctacteComprasSemanale = $this->CtacteComprasSemanales->get($id, [
            'contain' => ['Clientes']
        ]);
        $this->set('ctacteComprasSemanale', $ctacteComprasSemanale);
        $this->set('_serialize', ['ctacteComprasSemanale']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $ctacteComprasSemanale = $this->CtacteComprasSemanales->newEntity();
        if ($this->request->is('post')) {
            $ctacteComprasSemanale = $this->CtacteComprasSemanales->patchEntity($ctacteComprasSemanale, $this->request->data);
            if ($this->CtacteComprasSemanales->save($ctacteComprasSemanale)) {
                $this->Flash->success(__('The ctacte compras semanale has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The ctacte compras semanale could not be saved. Please, try again.'));
            }
        }
        $clientes = $this->CtacteComprasSemanales->Clientes->find('list', ['limit' => 200]);
        $this->set(compact('ctacteComprasSemanale', 'clientes'));
        $this->set('_serialize', ['ctacteComprasSemanale']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Ctacte Compras Semanale id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $ctacteComprasSemanale = $this->CtacteComprasSemanales->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ctacteComprasSemanale = $this->CtacteComprasSemanales->patchEntity($ctacteComprasSemanale, $this->request->data);
            if ($this->CtacteComprasSemanales->save($ctacteComprasSemanale)) {
                $this->Flash->success(__('The ctacte compras semanale has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The ctacte compras semanale could not be saved. Please, try again.'));
            }
        }
        $clientes = $this->CtacteComprasSemanales->Clientes->find('list', ['limit' => 200]);
        $this->set(compact('ctacteComprasSemanale', 'clientes'));
        $this->set('_serialize', ['ctacteComprasSemanale']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Ctacte Compras Semanale id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ctacteComprasSemanale = $this->CtacteComprasSemanales->get($id);
        if ($this->CtacteComprasSemanales->delete($ctacteComprasSemanale)) {
            $this->Flash->success(__('The ctacte compras semanale has been deleted.'));
        } else {
            $this->Flash->error(__('The ctacte compras semanale could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
