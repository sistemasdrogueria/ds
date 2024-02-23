<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
/**
 * Ofertas Controller
 *
 * @property \App\Model\Table\OfertasTable $Ofertas
 */
class OfertasController extends AppController
{
	public function isAuthorized()
    {
	if (in_array($this->request->action, ['index_admin','add_admin','edit_admin','view_admin','index_admin_search','add_admin_search','add_admin_oferta'])) {
       
            if($this->request->session()->read('Auth.User.role')=='admin') 
            {				
                return true;			
            }			
            else 
				{	
						$this->Flash->error(__('No tiene permisos para ingresar'),['key' => 'changepass']);
						$this->redirect($this->referer());
								
					
						return false;	
						
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
	 
	 
	public function index_admin_search()
    {
		$this->viewBuilder()->layout('admin');
        $this->paginate = [
            'contain' => ['Articulos']
        ];
        $this->set('ofertas', $this->paginate($this->Ofertas));
        $this->set('_serialize', ['ofertas']);
		$this->set('titulo','Lista de Resultado de ofertas');
    }
    
	public function index_admin()
    {
		$this->viewBuilder()->layout('admin');
        $this->paginate = [
            'contain' => ['Articulos']
        ];
		
		$this->loadModel('OfertasTipos');
		
		
		$this->set('ofertastipos',$this->OfertasTipos->find()->toArray());
		
        $this->set('ofertas', $this->paginate($this->Ofertas));
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
		$this->viewBuilder()->layout('admin');
      		
		if ($this->request->session()->read('Categorias')== null)
		{
			$this->loadModel('Categorias');
			$this->loadModel('Laboratorios');
			$categorias = $this->Categorias->find('list',['keyField' => 'id','valueField'=>'nombre']);
			$laboratorios = $this->Laboratorios->find('list',['keyField' => 'id','valueField'=>'nombre'])->order(['nombre' => 'ASC']);
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
						'd.tipo_oferta in ("RV","RR","OR","TD")'
						]		
					]
					)
					->where(['Articulos.id'=>$this->request->data['articulo_id']]);
		
		$articulo = $articulosA->first();
		$this->loadModel('OfertasTipos');
		$ofertatipo = $this->OfertasTipos->find('list',['keyField' => 'id','valueField'=>'nombre']);
		$this->set('ofertastipos',$ofertatipo->toArray());
		$this->set('articulo',$articulo);
        $this->set(compact('oferta'));
        $this->set('_serialize', ['oferta']);
		$this->set('titulo','Agregar de Oferta');
    }
	
	public function add_admin()
    {
		$this->viewBuilder()->layout('admin');
        $oferta = $this->Ofertas->newEntity();
        if ($this->request->is('post')) {
           if  ($this->request->data['terminobuscar']!=null || $this->request->data['categoria_id']!=null  ||
		   $this->request->data['laboratorio_id']!=null  || $this->request->data['ofertas']!=null)
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

        $this->paginate = [		
		'contain' => ['Descuentos'],
		'limit' => 11,
		'offset' => 0, 
        'order' => ['Articulos.descripcion_pag' => 'asc']];
		
		$this->loadModel('Articulos');

		$fecha = Time::now();
		$fecha->i18nFormat('yyyy-MM-dd');
	  	$articulosA = $this->Articulos->find()
				
				->hydrate(false)
					->join([
						'table' => 'descuentos',
						'alias' => 'd',
						'type' => 'LEFT',
						 'conditions' => [
						'd.articulo_id = Articulos.id',
						'd.tipo_venta = "D"',
						'd.fecha_hasta >=' => $fecha,
						'd.tipo_oferta in ("RV","RR","OR","TD")'
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
					['d.tipo_oferta'=>"RV"]],
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
					['d.tipo_oferta'=>"RV"]					
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
			
		}
		else
				$articulos = null;	
        
		

		if ($this->request->session()->read('Categorias')== null)
		{
		$this->loadModel('Categorias');
		$this->loadModel('Laboratorios');
		$categorias = $this->Categorias->find('list',['keyField' => 'id','valueField'=>'nombre']);
		$laboratorios = $this->Laboratorios->find('list',['keyField' => 'id','valueField'=>'nombre'])->order(['nombre' => 'ASC']);

		$this->request->session()->write('Categorias',$categorias->toArray());
		$this->request->session()->write('Laboratorios',$laboratorios ->toArray());
			
		}
		else{
			
			$laboratorios =$this->request->session()->read('Laboratorios');
			$categorias = $this->request->session()->read('Categorias');
		}	

		$this->set('categorias',$categorias );

		$this->set('laboratorios',$laboratorios);
		
       
        $this->set(compact('oferta', 'articulos'));
        $this->set('_serialize', ['oferta']);
		$this->set('titulo','Agregar de Oferta');
    }

	 public function add_admin_oferta()
    {
		$this->viewBuilder()->layout('admin');
        $oferta = $this->Ofertas->newEntity();
        if ($this->request->is('post')) {
            $oferta = $this->Ofertas->patchEntity($oferta, $this->request->data);
            if ($this->Ofertas->save($oferta)) {
                $this->Flash->success(__('The oferta has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
				$this->Flash->error(__('NO SE PUDO'),['key' => 'changepass']);
                //$this->Flash->error(__('The oferta could not be saved. Please, try again.'));
            }
        }
        $articulos = $this->Ofertas->Articulos->find('list', ['limit' => 200]);
        $ofertasTipos = $this->Ofertas->OfertasTipos->find('list', ['limit' => 200]);
        $this->set(compact('oferta', 'articulos', 'ofertasTipos'));
        $this->set('_serialize', ['oferta']);
		
		/*$ofertas = $this->Ofertas->newEntity();
        if ($this->request->is('post')) {
            $ofertas = $this->Ofertas->patchEntity($ofertas, $this->request->data);
            if ($this->Ofertas->save($ofertas)) {
                $this->Flash->success(__('The ofertas tipo has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The ofertas tipo could not be saved. Please, try again.'));
				//		
				return $this->redirect($this->referer());	
            }
        }*/
        //$this->set(compact('ofertas'));
        //$this->set('_serialize', ['ofertas']);
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
        if ($this->request->is(['patch', 'post', 'put'])) {
            $oferta = $this->Ofertas->patchEntity($oferta, $this->request->data);
            if ($this->Ofertas->save($oferta)) {
                $this->Flash->success(__('The oferta has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The oferta could not be saved. Please, try again.'));
            }
        }
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
        $this->request->allowMethod(['post', 'delete']);
        $oferta = $this->Ofertas->get($id);
        if ($this->Ofertas->delete($oferta)) {
            $this->Flash->success(__('The oferta has been deleted.'));
        } else {
            $this->Flash->error(__('The oferta could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
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
		$laboratorios = $this->Laboratorios->find('list',['keyField' => 'id','valueField'=>'nombre'])->order(['nombre' => 'ASC']);

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
						'd.tipo_oferta in ("RV","RR","OR","TD")'
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
					['d.tipo_oferta'=>"RV"]],
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
					['d.tipo_oferta'=>"RV"]					
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
