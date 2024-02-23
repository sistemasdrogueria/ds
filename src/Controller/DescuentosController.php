<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Network\Request;
use Cake\Database\Expression\QueryExpression;
use Cake\Datasource\ConnectionManager;
/**
 * Descuentos Controller
 *
 * @property \App\Model\Table\DescuentosTable $Descuentos
 */
class DescuentosController extends AppController
{

public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }
	
	public function isAuthorized()
    {
		if (in_array($this->request->action, ['index_admin','index_hss_admin','excel','excelclientes','excelventasclientes','excelventastodosclientes'])) {
       
				if($this->request->session()->read('Auth.User.role')=='admin') 
				{				
					return true;			
				}			
				else 
				{								
					$this->Flash->error(__('No tiene permisos para ingresar'),['key' => 'changepass']);
					return false;	
						
						
				}		
            }		
		else 
			{			    		
				return false;		
			}	
		return parent::isAuthorized($user);
    }
	
	
	public function index_admin()
    {
		$this->set('titulo','FARMA POINT');
		
		$this->viewBuilder()->layout('admin');
		$descuentos =$this->Descuentos->find()->where(['tipo_oferta in ("FP")']);
        $this->paginate = [
            'contain' => ['Articulos'],
			'limit' => 500 , 
            'maxLimit' => 1000,
			'sortWhitelist' => [
                'Articulos.stock',
                'Articulos.descripcion_sist',
                'Articulos.fp_orden',
            ],
        ];
        $this->set('descuentos', $this->paginate($descuentos));
        $this->set('_serialize', ['descuentos']);


        
		

        /** Por laboratorio **/




    }

    public function index_hss_admin()
    {
		$this->set('titulo','HOT SUR SALE');
		
		$this->viewBuilder()->layout('admin');
        	$this->loadModel('Laboratorios');          		
            $laboratorios = $this->Laboratorios->find('list',['keyField' => 'id','valueField'=>'nombre'])->where(['eliminado=0'])->order(['nombre' => 'ASC']);
		$descuentos =$this->Descuentos->find()->where(['evento' => "SC"])->group(['Articulos.id']);
        $this->paginate = [
            'contain' => ['Articulos'],
			
			'limit' => 200,
            'sortWhitelist' => [
                'Articulos.stock',
                'Articulos.descripcion_sist',
                'Articulos.fp_orden',
            ],
        ];
        $this->set('descuentos', $this->paginate($descuentos));
        $this->set('_serialize', ['descuentos']);

        $connection = ConnectionManager::get('default');
        $subtotales = $connection->execute("SELECT  SUM(cantidad) AS subtotal, l.nombre,a.laboratorio_id FROM pedidos_items ppi INNER JOIN articulos a ON (ppi.articulo_id = a.id) INNER JOIN laboratorios l ON l.id = a.laboratorio_id  WHERE a.eliminado=0 and agregado BETWEEN '2022-05-30 00:00:00' AND '2022-06-05 23:59:59' AND  articulo_id IN (
          837,1511,3435,4488,7301,7689,8588,8600,8632,8760,8911,9468,9731,9756,9853,9930,9953,9962,9965,10390,10391,10392,11538,13034,13965,13967,14163,14348,14486,14700,15433,
18225,18813,20044,20112,21267,21955,22994,23143,26385,47225,47956,48747,49777,49978,50091,50246,50249,50343,50412,104625,109618,293,775,932,1003,1036,1822,2128,
2723,2862,3352,3465,3827,3870,3892,3921,3988,4061,4124,4164,4170,4349,4597,4901,5222,5421,6153,6689,7074,7687,7874,7875,8499,8609,9640,9721,9722,9725,11008,11449,
11805,11873,12322,12344,12381,12383,13121,14684,15686,16420,16525,16542,17524,17912,18270,18569,19072,19279,19289,19290,19301,19302,19461,19585,20066,21308,21311,
21609,21711,21817,21861,22157,22161,22318,22538,22697,22707,22962,23037,23039,23348,23966,24516,25188,25328,25329,25707,25771,47248,47440,47514,47532,47534,47729,47748,
47843,48010,48013,48171,48221,48253,48687,48688,48699,48743,49447,49725,50159,50203,50241,50252,50334,50872,50950,50952,51001,51257,51779,107418,107419 )GROUP BY (laboratorio_id) order by subtotal desc; ");

        $this->set('subtotales',$subtotales);

        $total =0;
        foreach ($subtotales as $sub) {
            $total =$total+ $sub['subtotal'];

        }


        $this->set('total',$total);

        $this->request->session()->write('laboratoriosb',$laboratorios->toArray());
    }

    public function excel()
	{        
	    $this->viewBuilder()->layout('ajax');
		ini_set('memory_limit', '-1');

		$this->loadModel('PedidosItems');
		//$this->loadModel('Articulos');
		$query2 = $this->PedidosItems->find('all');
		//->contain(['PedidosPreventas','Articulos']);
		$query2->select([
			'total' => $query2->func()->sum('CANTIDAD'),'Articulos.descripcion_sist','Articulos.codigo_barras','articulo_id',
							'descuento','plazoley_dcto','Articulos.troquel','Articulos.laboratorio_id','Articulos.precio_publico','Articulos.categoria_id'					
			])
			->contain(['Pedidos','Articulos'])
			// passing the table instance to the `select` function, selects all fields
          
			->where([  'eliminado'=>0, 'PedidosItems.descuento>0',
				"PedidosItems.agregado BETWEEN '2022-05-30 00:00:00' AND '2022-06-05 23:59:59'",
                'PedidosItems.articulo_id IN  (837,1511,3435,4488,7301,7689,8588,8600,8632,8760,8911,9468,9731,9756,9853,9930,9953,9962,9965,10390,10391,10392,11538,13034,13965,13967,14163,14348,14486,14700,15433,
                18225,18813,20044,20112,21267,21955,22994,23143,26385,47225,47956,48747,49777,49978,50091,50246,50249,50343,50412,104625,109618,293,775,932,1003,1036,1822,2128,
                2723,2862,3352,3465,3827,3870,3892,3921,3988,4061,4124,4164,4170,4349,4597,4901,5222,5421,6153,6689,7074,7687,7874,7875,8499,8609,9640,9721,9722,9725,11008,11449,
                11805,11873,12322,12344,12381,12383,13121,14684,15686,16420,16525,16542,17524,17912,18270,18569,19072,19279,19289,19290,19301,19302,19461,19585,20066,21308,21311,
                21609,21711,21817,21861,22157,22161,22318,22538,22697,22707,22962,23037,23039,23348,23966,24516,25188,25328,25329,25707,25771,47248,47440,47514,47532,47534,47729,47748,
                47843,48010,48013,48171,48221,48253,48687,48688,48699,48743,49447,49725,50159,50203,50241,50252,50334,50872,50950,50952,51001,51257,51779,107418,107419)'

               ])
			->group(['codigo_barras'])
			->order(['Articulos.descripcion_sist'=>'ASC']);
		$query2->execute();
		$this->set('resumen',$query2);
        $this->request->session()->write('resumen',$query2->toArray());
        		$this->response->type('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	}
    
    public function excelventasclientes()
	{
		$this->viewBuilder()->layout('ajax');
        $laboratorioid =  $this->request->data['laboratorioid'];
        	
        $connection = ConnectionManager::get('default');
        $articulosb = $connection->execute("SELECT ppi.pedido_ds,ppi.cantidad_facturada,ppi.descuento,l.id,c.nombre,c.codigo,c.preciofarmacia_descuento,a.descripcion_pag,a.troquel,a.codigo_barras,a.precio_publico,a.precio_publico  FROM facturas_cuerpos_items ppi INNER JOIN facturas_cabeceras p ON (ppi.facturas_encabezados_id = p.id) INNER JOIN clientes c ON (p.cliente_id = c.id)INNER JOIN articulos a ON (ppi.articulo_id = a.id) INNER JOIN laboratorios l ON l.id = a.laboratorio_id WHERE l.id = ".$laboratorioid." and a.eliminado=0 and fecha BETWEEN '2022-05-30 00:00:00' AND '2022-06-05 23:59:59' AND  articulo_id IN (
            837,1511,3435,4488,7301,7689,8588,8600,8632,8760,8911,9468,9731,9756,9853,9930,9953,9962,9965,10390,10391,10392,11538,13034,13965,13967,14163,14348,14486,14700,15433,
            18225,18813,20044,20112,21267,21955,22994,23143,26385,47225,47956,48747,49777,49978,50091,50246,50249,50343,50412,104625,109618,293,775,932,1003,1036,1822,2128,
            2723,2862,3352,3465,3827,3870,3892,3921,3988,4061,4124,4164,4170,4349,4597,4901,5222,5421,6153,6689,7074,7687,7874,7875,8499,8609,9640,9721,9722,9725,11008,11449,
            11805,11873,12322,12344,12381,12383,13121,14684,15686,16420,16525,16542,17524,17912,18270,18569,19072,19279,19289,19290,19301,19302,19461,19585,20066,21308,21311,
            21609,21711,21817,21861,22157,22161,22318,22538,22697,22707,22962,23037,23039,23348,23966,24516,25188,25328,25329,25707,25771,47248,47440,47514,47532,47534,47729,47748,
            47843,48010,48013,48171,48221,48253,48687,48688,48699,48743,49447,49725,50159,50203,50241,50252,50334,50872,50950,50952,51001,51257,51779,107418,107419) order by l.nombre asc;");
         $this->set('articulosb',$articulosb);
		$this->response->type('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	}
     
    public function excelventastodosclientes()
	{
		$this->viewBuilder()->layout('ajax');
               	
        $connection = ConnectionManager::get('default');
        $articulosb = $connection->execute("SELECT ppi.pedido_ds,ppi.cantidad_facturada,ppi.descuento,l.id,c.nombre,c.codigo,c.preciofarmacia_descuento,a.descripcion_pag,a.troquel,a.codigo_barras,a.precio_publico,a.precio_publico  FROM facturas_cuerpos_items ppi INNER JOIN facturas_cabeceras p ON (ppi.facturas_encabezados_id = p.id) INNER JOIN clientes c ON (p.cliente_id = c.id)INNER JOIN articulos a ON (ppi.articulo_id = a.id) INNER JOIN laboratorios l ON l.id = a.laboratorio_id WHERE a.eliminado=0 and fecha BETWEEN '2022-05-30 00:00:00' AND '2022-06-05 23:59:59' AND  articulo_id IN (
           837,1511,3435,4488,7301,7689,8588,8600,8632,8760,8911,9468,9731,9756,9853,9930,9953,9962,9965,10390,10391,10392,11538,13034,13965,13967,14163,14348,14486,14700,15433,
18225,18813,20044,20112,21267,21955,22994,23143,26385,47225,47956,48747,49777,49978,50091,50246,50249,50343,50412,104625,109618,293,775,932,1003,1036,1822,2128,
2723,2862,3352,3465,3827,3870,3892,3921,3988,4061,4124,4164,4170,4349,4597,4901,5222,5421,6153,6689,7074,7687,7874,7875,8499,8609,9640,9721,9722,9725,11008,11449,
11805,11873,12322,12344,12381,12383,13121,14684,15686,16420,16525,16542,17524,17912,18270,18569,19072,19279,19289,19290,19301,19302,19461,19585,20066,21308,21311,
21609,21711,21817,21861,22157,22161,22318,22538,22697,22707,22962,23037,23039,23348,23966,24516,25188,25328,25329,25707,25771,47248,47440,47514,47532,47534,47729,47748,
47843,48010,48013,48171,48221,48253,48687,48688,48699,48743,49447,49725,50159,50203,50241,50252,50334,50872,50950,50952,51001,51257,51779,107418,107419) order by l.nombre asc;");
         $this->set('articulosb',$articulosb);
		$this->response->type('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	}

    public function excelclientes()
	{
		$this->viewBuilder()->layout('ajax');
        $laboratorioid =  $this->request->data['laboratorioid'];
        $this->set('laboratorioid',$laboratorioid);
        $connection = ConnectionManager::get('default');
        $articulosb = $connection->execute("SELECT c.nombre,c.codigo,c.codigo_postal,c.domicilio,c.id FROM pedidos_items ppi INNER JOIN pedidos p ON (ppi.pedido_id = p.id) INNER JOIN clientes c ON (p.cliente_id = c.id)INNER JOIN articulos a ON (ppi.articulo_id = a.id) INNER JOIN laboratorios l ON l.id = a.laboratorio_id WHERE ppi.descuento>0 and l.id = ".$laboratorioid." and a.eliminado=0 and agregado BETWEEN '2022-05-30 00:00:00' AND '2022-06-05 23:59:59' AND  articulo_id IN (
            837,1511,3435,4488,7301,7689,8588,8600,8632,8760,8911,9468,9731,9756,9853,9930,9953,9962,9965,10390,10391,10392,11538,13034,13965,13967,14163,14348,14486,14700,15433,
            18225,18813,20044,20112,21267,21955,22994,23143,26385,47225,47956,48747,49777,49978,50091,50246,50249,50343,50412,104625,109618,293,775,932,1003,1036,1822,2128,
            2723,2862,3352,3465,3827,3870,3892,3921,3988,4061,4124,4164,4170,4349,4597,4901,5222,5421,6153,6689,7074,7687,7874,7875,8499,8609,9640,9721,9722,9725,11008,11449,
            11805,11873,12322,12344,12381,12383,13121,14684,15686,16420,16525,16542,17524,17912,18270,18569,19072,19279,19289,19290,19301,19302,19461,19585,20066,21308,21311,
            21609,21711,21817,21861,22157,22161,22318,22538,22697,22707,22962,23037,23039,23348,23966,24516,25188,25328,25329,25707,25771,47248,47440,47514,47532,47534,47729,47748,
            47843,48010,48013,48171,48221,48253,48687,48688,48699,48743,49447,49725,50159,50203,50241,50252,50334,50872,50950,50952,51001,51257,51779,107418,107419) GROUP BY c.id;");
         $this->set('articulosb',$articulosb);
		$this->response->type('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	}
    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Articulos']
        ];
        $this->set('descuentos', $this->paginate($this->Descuentos));
        $this->set('_serialize', ['descuentos']);
    }

    /**
     * View method
     *
     * @param string|null $id Descuento id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $descuento = $this->Descuentos->get($id, [
            'contain' => ['Articulos']
        ]);
        $this->set('descuento', $descuento);
        $this->set('_serialize', ['descuento']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $descuento = $this->Descuentos->newEntity();
        if ($this->request->is('post')) {
            $descuento = $this->Descuentos->patchEntity($descuento, $this->request->data);
            if ($this->Descuentos->save($descuento)) {
                $this->Flash->success('The descuento has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The descuento could not be saved. Please, try again.');
            }
        }
        $articulos = $this->Descuentos->Articulos->find('list', ['limit' => 200]);
        $this->set(compact('descuento', 'articulos'));
        $this->set('_serialize', ['descuento']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Descuento id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $descuento = $this->Descuentos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $descuento = $this->Descuentos->patchEntity($descuento, $this->request->data);
            if ($this->Descuentos->save($descuento)) {
                $this->Flash->success('The descuento has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The descuento could not be saved. Please, try again.');
            }
        }
        $articulos = $this->Descuentos->Articulos->find('list', ['limit' => 200]);
        $this->set(compact('descuento', 'articulos'));
        $this->set('_serialize', ['descuento']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Descuento id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $descuento = $this->Descuentos->get($id);
        if ($this->Descuentos->delete($descuento)) {
            $this->Flash->success('The descuento has been deleted.');
        } else {
            $this->Flash->error('The descuento could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
