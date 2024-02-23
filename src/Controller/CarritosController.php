<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Filesystem\File;
use Cake\Network\Request;
use Cake\Database\Expression\QueryExpression;
use Cake\Datasource\ConnectionManager;
use Cake\I18n\Time;
use Cake\Mailer\Email;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Cake\ORM\TableRegistry;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Helper;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Cake\Routing\Router;
use Cake\Http\Client;
use Cake\Core\Configure;
use Cake\Collection\Collection;
require ROOT . DS . 'vendor' . DS . 'phpoffice/phpspreadsheet/src/Bootstrap.php';
/**
 * Carritos Controller
 *
 * @property \App\Model\Table\CarritosTable $Carritos
 */
class CarritosController extends AppController
{
	public function isAuthorized()
	{
		if (in_array($this->request->action, ['enviarsolicitud', 'alternativo', 'searchadd', 'pami', 'ofertavc', 'edit', 'delete', 'delete_temp', 'add', 'search', 'vaciar', 'confirm', 'import', 'importresult', 'importresultexcel', 'index', 'home', 'carritoadd', 'carritoaddall', 'downloadfile', 'carritoaddoferta', 'vaciarimport', 'carritotempadd', 'carritotempaddall', 'importconfirm', 'view', 'excel', 'fraganciaselectiva', 'resultfraganciaselectiva', 'sale', 'removed_admin', 'recover_admin', 'recover_confirm_admin', 'index_admin', 'farmapoint', 'promocion', 'insumos', 'blackfriday', 'search_i', 'hotsale_search', 'primaverasale', 'sur_friday_sale', 'hot_sur_sale', 'dulzura', 'itemupdate', 'itemupdateofertas', 'sumacarrito', 'calcularsubtotales', 'contenidoCarrito', 'clientecredito', 'search_hss', 'search_bf', 'reporte_carro', 'itemupdatetemps', 'importresulttemp', 'deletecarritotemps', 'search_ajax', 'excel_contenido', 'faltas', 'deletefalta', 'updatefaltas', 'variablestmp'])) {

			if ($this->request->session()->read('Auth.User.role') == 'admin') {
				return true;
			} else {
				if ($this->request->session()->read('Auth.User.role') == 'client') {
					$tiene = $this->tienepermiso('carritos', $this->request->action);
					if (!$tiene)
						$this->Flash->error(__('No tiene permisos para ingresar'), ['key' => 'changepass']);
					return $tiene;
				} else {
					if ($this->request->session()->read('Auth.User.role') == 'provider') {
						return false;
					} else {
						$this->Flash->error(__('No tiene permisos para ingresar'), ['key' => 'changepass']);
						return false;
					}
				}
			}
		} else {
			return false;
		}
		return parent::isAuthorized($user);
	}
	public function search_bf($terms_marca = null, $terms_lab = null, $terms = null, $terms_mult = null)
	{
		if ($this->request->is('post')) {
			if (!empty($this->request->data['marca_id'])) {
				$marcaid = $this->request->data['marca_id'];
			} else {
				$marcaid = 0;
			}
			if (!empty($this->request->data['laboratorio_id'])) {
				$laboratorioid = $this->request->data['laboratorio_id'];
			} else {
				$laboratorioid = 0;
			}
			if ($this->request->data['terms_mult'] != null) {
				$terms_m = $this->request->data['terms_mult'];
			} else
				$terms_m = "";

			if ($this->request->data['terminobuscar'] != null) {
				$terminocompleto = explode(" ", $this->request->data['terminobuscar']);
				$terms = "";
				if (count($terminocompleto) > 1) {
					foreach ($terminocompleto as $terminosimple) :
						$terms = $terms . '%' . $terminosimple . '%';
					endforeach;
				} else
					$terms = '%' . $terminocompleto[0] . '%';
			} else {
				$terms = "";
			}
			$this->request->session()->write('termsearch', $terms);
			$this->request->session()->write('marcaid', $marcaid);
		} else {


			$marcaid = 0; //$this->request->session()->read('laboratorioid');
			if (!empty($this->request->session()->read('marcaid')))
				$marcaid = $this->request->session()->read('marcaid');

			$terms_m = "";
			$terms = "";

			if (!empty($this->request->session()->read('termsearch')))
				$terms = $this->request->session()->read('termsearch');


			if (!empty($this->request->getParam('pass'))) {



				if (empty($this->request->getParam('pass')[0]))
					$marcaid = 0;
				else
					$marcaid = $terms_marca;
				if (empty($this->request->getParam('pass')[1]))
					$laboratorioid = "";
				else
					$laboratorioid = $this->request->getParam('pass')[1];

				if (!empty($this->request->getParam('pass')[2])) {
					$terminocompleto = explode(" ", $this->request->getParam('pass')[2]);
					$terms = "";
					if (count($terminocompleto) > 1) {
						foreach ($terminocompleto as $terminosimple) :
							$terms = $terms . '%' . $terminosimple . '%';
						endforeach;
					} else
						$terms = '%' . $terminocompleto[0] . '%';
				} else
					$terms = "";
				if (empty($this->request->getParam('pass')[3]))
					$terms_m = "";
				else
					$terms_m = $this->request->getParam('pass')[3];
			}
		}

		$this->categoriaylaboratorio();
		$this->clientecredito();
		$this->sumacarrito();
		$this->monodrogayaccionterapeutica();


		$this->viewBuilder()->layout('store');

		$this->loadModel('Articulos');

		$fecha = Time::now();
		//$fecha->i18nFormat('YYYY-MM-dd');
		//$list_tipo_dto=array();

		if ($this->request->session()->read('Auth.User.farmapoint') > 0) {
			$list_tipo_dto_dist = 'tipo_oferta <> "VC"';
			$list_tipo_dto = '("RV","RR","OR","TD","RL","HS","FR","TH","PS","FP","SC")';
		} else {
			$list_tipo_dto_dist = '[tipo_oferta <> "FP" , tipo_oferta <> "VC"]';
			$list_tipo_dto = '("RV","RR","OR","TD","RL","HS","FR","TH","PS","SC")';
		}
		$articulosA = $this->Articulos->find()
			->contain([
				'Descuentos' => [
					'queryBuilder' => function ($q) {
						return $q->where(['tipo_oferta <> "VC"']); // Full conditions for filtering
					}
					//'tipo_oferta in ("RV","RR","OR","TD","RL","HS","FR","TH","TD")',

				], 'Carritos' => [

					'queryBuilder' => function ($q) {
						return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); // Full conditions for filtering
					}
				]
			])
			->hydrate(false)
			->join(
				[
					'table' => 'descuentos',
					'alias' => 'd',
					'type' => 'inner',
					'conditions' => [
						'd.articulo_id = Articulos.id',
						'd.tipo_venta = "D"',
						'd.fecha_hasta >=' => $fecha->i18nFormat('yyyy-MM-dd'),
						'd.tipo_oferta in ' . $list_tipo_dto //("RV","RR","OR","TD","RL","HS","FR","TH","PS","FP")'
					]
				]
			);



		if ($terms != "" && $terms_m == "") {
			$articulosA->andWhere([

				'OR' => [
					['Articulos.descripcion_pag LIKE' => $terms],
					['Articulos.troquel LIKE' => $terms], ['Articulos.codigo_barras LIKE' => $terms], ['Articulos.codigo_barras2 LIKE' => $terms]
				],
			]);
		}
		if ($terms_m != "") {
			$articulosA->andWhere(['Articulos.codigo_barras IN (' . $terms_m . ')']);
		}
		if (($marcaid == 0)) {
			switch ($laboratorioid) {
				case 21: /*BAGO*/
					$articulosA->andWhere(['Articulos.codigo_barras IN (7790375268954 )']);
					break;
				case 24: /*BAYER*/
					$articulosA->andWhere(['Articulos.codigo_barras IN (7793640215479 )']);
					break;
				case 157: /*GENOMMA*/
					$articulosA->andWhere(['Articulos.codigo_barras IN (650240035401 )']);
					break;

				case 247: /*GEZZI*/
					$articulosA->andWhere(['Articulos.codigo_barras IN (7792369000328)']);
					break;
				case 121:/* ELEA*/
					$articulosA->andWhere(['Articulos.codigo_barras IN ( 7796285288457
					 )']);
					break;
				case 325: /*SIDUS*/
					$articulosA->andWhere(['Articulos.codigo_barras IN (  7795356001308 )']);
					break;
				case 425:/* COPAHUE*/
					$articulosA->andWhere(['Articulos.codigo_barras IN ( 7798120265913 )']);
					break;
				default: {
						$articulosA->andWhere(['Articulos.laboratorio_id' => $laboratorioid]);
					}
			}
		} else
			$articulosA->andWhere(['Articulos.marca_id' => $marcaid]);




		if ($articulosA != null) {
			$articulosA->andWhere(['Articulos.eliminado' => 0, 'Articulos.stock <>"F"'])->group(['Articulos.id']);
			$limit = 200;


			$this->paginate = [
				'contain' => ['Carritos'],
				'limit' => $limit,
				'offset' => 0,
				'order' => ['Articulos.descripcion_pag' => 'asc']
			];


			$articulos = $this->paginate($articulosA);
		} else
			$articulos = null;
		$this->set(compact('articulos'));

		$this->loadModel('Publications');
		$publicationsearch = $this->Publications->find('all')->where(['fecha_hasta >=CURRENT_DATE()', 'habilitada' => '1', 'ubicacion' => '7'])->order(['id' => 'DESC'])->all();

		$this->set('publicationsearch', $publicationsearch->toArray());
		$this->request->session()->write('publicationsearch', $publicationsearch->toArray());
		if ($marcaid != 0)
			$publicationzocalo = $this->Publications->find('all')->where(['fecha_hasta >=CURRENT_DATE()', 'habilitada' => '1', 'ubicacion' => '12', 'marca_id' => $marcaid])->order(['id' => 'DESC'])->all();
		if ($laboratorioid != 0)
			$publicationzocalo = $this->Publications->find('all')->where(['fecha_hasta >=CURRENT_DATE()', 'habilitada' => '1', 'ubicacion' => '12', 'laboratorio_id' => $laboratorioid])->order(['id' => 'DESC'])->all();
		$this->set('banner_slider', $publicationzocalo->toArray());
		$this->request->session()->write('banner_slider', $publicationzocalo->toArray());

		$this->set('banner_slider', $this->request->session()->read('banner_slider'));
	}

	public function sumacarrito()
	{
		/*
		$carritocon = $this->Carritos->find('all')
					->contain(['Articulos'])
					->where(['Carritos.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
					->order(['Carritos.cantidad  < Carritos.unidad_minima '=> 'DESC','Carritos.id' => 'DESC']);
		
		$this->set('carritos', $carritocon->toArray());
		*/
		$carritocon1 = $this->Carritos->find('all')
			->contain(['Articulos'])
			->where(['Carritos.cliente_id' => $this->request->session()->read('Auth.User.cliente_id'), 'Carritos.cantidad  < Carritos.unidad_minima', 'Carritos.unidad_minima IS NOT NULL'])
			->order(['Carritos.id' => 'DESC']);

		$carritocon2 = $this->Carritos->find('all')
			->contain(['Articulos'])
			->where(['Carritos.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
			->andWhere([

				'OR' => [
					['Carritos.cantidad  >= Carritos.unidad_minima '],
					['Carritos.unidad_minima IS NULL']
				]
			])
			->order(['Carritos.id' => 'DESC']);
		$c1 = $carritocon1->toArray();
		$c2 = $carritocon2->toArray();
		$carritocon = array_merge($c1, $c2);
		$this->set('carritos', $carritocon);



		$descuento_pf = $this->request->session()->read('Auth.User.pf_dcto');
		$descuento_pf2 = $descuento_pf;
		$condicion 	  = $this->request->session()->read('Auth.User.condicion');
		$coef         = $this->request->session()->read('Auth.User.coef');

		$condiciongeneral = 100 * (1 - ($descuento_pf * (1 - $condicion / 100)));
		$totalcarritostock = 0;
		$totalcarrito = 0;
		$totalitems = 0;
		$totalunidades = 0;
		foreach ($carritocon as $carrito) :
			$totalitems += 1;
			/*if ($carrito['tipo_precio']=="P")
				$totalcarrito= $totalcarrito + $carrito['cantidad']*$carrito['precio_publico'];
			else
				$totalcarrito= $totalcarrito + $carrito['cantidad']*round(h($carrito['precio_publico'])*$descuento_pf, 3);*/
			$totalunidades = $totalunidades + $carrito['cantidad'];

			$cant_carrito = $carrito['cantidad'];
			$subtotal = 0;
			//MEDICAMENTOS
			if (($carrito['categoria_id'] != 5) && ($carrito['categoria_id'] != 4)  && ($carrito['categoria_id'] != 3) && ($carrito['categoria_id'] != 2)) {
				if ($carrito['categoria_id'] === 1)	  $coef2 = 1;
				else $coef2 = $coef;
				//if ($carrito['articulo']['laboratorio_id']===15) $coef2 = 0.892; 
				//DESCUENTOS
				if ($carrito['descuento'] > 0) {
					//TIPO_VENTA=D
					if ($carrito['tipo_oferta_elegida'] == 'D') {
						$cant_uni_min = $carrito['unidad_minima'];
						//TIPO_PRECIO P
						if ($carrito['tipo_precio'] == 'P') {

							if ($cant_carrito >= $cant_uni_min) {
								$descuentooferta = $carrito['descuento'];
								$precio = $carrito['precio_publico'] * $coef2;
								$precio -= $precio * $descuentooferta / 100;
								$subtotal = $precio * $cant_carrito;
							} else {
								$precio  = $carrito['precio_publico'];
								if ($carrito['articulo']['iva'] == 1)
									if ($this->request->session()->read('Auth.User.codigo_postal') != 9410 && $this->request->session()->read('Auth.User.codigo_postal') != 9420) {
										$precio = $precio / (1.21);
									}
								$precio  = $precio * $descuento_pf * $coef2;
								if ($carrito['articulo']['msd'] != 1)
									$precio -= $precio * $condicion / 100;
								$subtotal = $precio * $cant_carrito;
							}
						} else {
							//TIPO_PRECIO F
							if ($carrito['tipo_precio'] == 'F') {
								$precio  = $carrito['precio_publico'];
								if ($carrito['articulo']['iva'] == 1)
									if ($this->request->session()->read('Auth.User.codigo_postal') != 9410 && $this->request->session()->read('Auth.User.codigo_postal') != 9420) {
										$precio = $precio / (1.21);
									}

								if ($cant_carrito >= $cant_uni_min) {
									$descuentooferta = $carrito['descuento'];
									$precio  = $precio * $descuento_pf * $coef2;
									if ($carrito['articulo']['msd'] != 1)
										$precio -= $precio * $condicion / 100;
									$precio -= $precio * $descuentooferta / 100;
									$subtotal = $precio * $cant_carrito;
								} else {

									if ($carrito['articulo']['mcdp'] == 0) {
										$precio  = $precio * $descuento_pf * $coef2;
										if ($carrito['articulo']['msd'] != 1) {
											$precio -= $precio * $condicion / 100;
										}
									} else {
										$precio -= $precio * ($condiciongeneral - 1) / 100;
									}
									$subtotal = $precio * $cant_carrito;

									//$subtotal = $precio*$descuento_pf*$coef2*$cant_carrito; 

								}
							}
						}
					} else {
						$precio  = $carrito['precio_publico'];
						if ($carrito['articulo']['mcdp'] == 0) {
							$precio  = $precio * $descuento_pf * $coef2;
							if ($carrito['articulo']['msd'] != 1) {
								$precio -= $precio * $condicion / 100;
							}
						} else {
							$precio -= $precio * ($condiciongeneral - 1) / 100;
						}
						$subtotal = $precio * $cant_carrito;
					}
				} else {
					$precio = $carrito['precio_publico'];
					if ($carrito['articulo']['iva'] == 1)
						if ($this->request->session()->read('Auth.User.codigo_postal') != 9410 && $this->request->session()->read('Auth.User.codigo_postal') != 9420) {
							$precio = $precio / (1.21);
						}

					if ($carrito['articulo']['mcdp'] == 0) {
						$precio  = $precio * $descuento_pf * $coef2;
						if ($carrito['articulo']['msd'] != 1) {
							$precio -= $precio * $condicion / 100;
						}
					} else {
						$precio -= $precio * ($condiciongeneral - 1) / 100;
					}
					$subtotal = $precio * $cant_carrito;

					if ($this->request->session()->read('Auth.User.codigo_postal') == 9410 || $this->request->session()->read('Auth.User.codigo_postal') == 9420) {
						$subtotal = $subtotal * $carrito['articulo']['tf_coef'];
					}
				}
				if ($carrito['articulo']['cadena_frio'] == 1 && $carrito['articulo']['subcategoria_id'] != 10)
					$subtotal = $subtotal * 1.0248;
			} else {
				if ($carrito['descuento'] > 0) {
					if ($carrito['tipo_oferta_elegida'] == 'D') {
						$cant_uni_min = $carrito['unidad_minima'];
						if ($cant_carrito >= $cant_uni_min) {
							$descuentooferta = $carrito['descuento'];
							$precio = $carrito['precio_publico'];
							if ($carrito['tipo_precio'] == 'P') {
								$precio -= $precio * $descuentooferta / 100;
							}
							if ($carrito['tipo_precio'] == 'F') {


								$precio = $precio * $descuento_pf;
								//$precio -= $precio*$condicion/100;
								$precio -= $precio * $descuentooferta / 100;
							}
							$subtotal = $precio * $cant_carrito;
						} else {


							$precio = $carrito['precio_publico'] * $descuento_pf;
							if ($coef != 1)	$precio = $precio * $coef;
							$subtotal = $precio * $cant_carrito;
						}
						if ($this->request->session()->read('Auth.User.codigo_postal') == 9410 || $this->request->session()->read('Auth.User.codigo_postal') == 9420) {
							$subtotal = $subtotal * $carrito['articulo']['tf_coef'];
						}
					}
				} else {
					if ($carrito['articulo']['id'] > 27338 && $carrito['articulo']['id'] < 27345)
						$descuento_pf = 0.807;
					else
						$descuento_pf = $descuento_pf2;

					$precio = $carrito['precio_publico'] * $descuento_pf * $coef;
					$subtotal = $precio * $cant_carrito;
					if ($this->request->session()->read('Auth.User.codigo_postal') == 9410 || $this->request->session()->read('Auth.User.codigo_postal') == 9420) {
						$subtotal = $subtotal * $carrito['articulo']['tf_coef'];
					}
				}
			}
			$totalcarrito = $totalcarrito + $subtotal;
			if (($carrito['articulo']['stock'] == "B") || ($carrito['articulo']['stock'] == "S") || ($carrito['articulo']['stock'] == "R"))
				$totalcarritostock = $totalcarritostock + $subtotal;

		endforeach;
		$this->set('totalitems', $totalitems);
		$this->set('totalcarrito', $totalcarrito);
		$this->set('totalcarritostock', $totalcarritostock);
		$this->set('totalunidades', $totalunidades);
		$this->set('carritos', $carritocon);


		$this->request->session()->write('totalitems', $totalitems);
		$this->request->session()->write('totalcarrito', $totalcarrito);
		$this->request->session()->write('totalcarritostock', $totalcarritostock);
		$this->request->session()->write('totalunidades', $totalunidades);
		$this->request->session()->write('carritos', $carritocon);
		//$this->set('carritos', $carritocon->toArray());
		return $carritocon;
	}

	public function hot_sur_sale($lab_id = null, $tipo_oferta = null, $termsearch = null, $indice = null)
	{
		$this->viewBuilder()->layout('store');
		$this->paginate = [
			'contain' => [],
			'limit' => 82,
			'offset' => 0,
			'order' => ['Articulos.descripcion_pag' => 'asc']
		];
		$this->clientecredito();
		$this->sumacarrito();
		$this->loadModel('Articulos');
		$this->loadModel('Carritos');
		//$this->categoriaylaboratorio2();	
		if ($tipo_oferta != 'TD' && $tipo_oferta != 'TH' && $tipo_oferta != 'OR') {
			$this->categoriaylaboratorio();
			if ($tipo_oferta != 'P') {
				$articulos = $this->Articulos->find('all')
					->contain([
						'Descuentos' => [

							'queryBuilder' => function ($q) {
								return $q->where(['tipo_oferta in ("TD","HS","RV")', 'evento ="HS"']); // Full conditions for filtering
							}
						], 'Carritos' => [

							'queryBuilder' => function ($q) {
								return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); // Full conditions for filtering
							}
						]
					])


					->hydrate(false)
					->join(
						[
							'table' => 'descuentos',
							'alias' => 'd',
							'type' => 'INNER',
							'conditions' => [
								'd.articulo_id = Articulos.id',
								'd.tipo_venta = "D"',
								'evento ="HS"',
								'd.tipo_oferta' => $tipo_oferta
							]
						]
					)

					->where([
						'Articulos.laboratorio_id' => $lab_id, 'Articulos.eliminado' => 0
					])
					->andWhere(['Articulos.descripcion_pag LIKE' => '%' . $termsearch . '%'])
					//->where(['Articulos.imagen NOT IN ("sinimagen.png","perfumeria.jpg","medicamento.jpg")'])
					->order(['Articulos.descripcion_sist' => 'ASC']);

				$this->request->session()->write('articulosxx', $articulos->toArray());
			} else {
				$articulos = $this->Articulos->find('all')
					->contain([
						'Descuentos', 'Carritos' => [

							'queryBuilder' => function ($q) {
								return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); // Full conditions for filtering
							}
						]
					])


					->hydrate(false)
					->join(
						[
							'table' => 'descuentos',
							'alias' => 'd',
							'type' => 'LEFT',
							'conditions' => [
								'd.articulo_id = Articulos.id',
								'd.tipo_venta = "D"',
								'evento ="HS"',
							]
						]
					)

					->where(['Articulos.laboratorio_id' => $lab_id, 'Articulos.eliminado' => 0])
					->andWhere(['Articulos.descripcion_pag LIKE' => $termsearch . '%'])
					//->where(['Articulos.imagen NOT IN ("sinimagen.png","perfumeria.jpg","medicamento.jpg")'])
					->order(['Articulos.descripcion_sist' => 'ASC']);
				$articulos = $this->paginate($articulos);
				$this->request->session()->write('articulosxx', $articulos->toArray());
			}
		} else {
			$this->categoriaylaboratorio2();

			$fecha = Time::now();

			$articulosA = $this->Articulos->find()
				->contain([
					'Laboratorios', 'Descuentos', 'Carritos' => [

						'queryBuilder' => function ($q) {
							return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); // Full conditions for filtering
						}
					]
				])
				->hydrate(false)
				->join(
					[
						'table' => 'descuentos',
						'alias' => 'd',
						'type' => 'INNER',
						'conditions' => [
							'd.articulo_id = Articulos.id',
							'd.tipo_venta = "D"',
							'd.fecha_hasta >=' => $fecha->i18nFormat('yyyy-MM-dd'),
							'd.tipo_oferta in ("TD","OR","RL","RV","TH")',
							'evento ="HS"',
						]
					]
				)
				->where(['Articulos.eliminado' => 0])
				->andWhere(['Articulos.laboratorio_id' => $lab_id]);


			if ($articulosA != null) {
				$limit = 100;
				if ($articulosA->count() < 100 && $articulosA->count() > 50) {
					$limit = 150;
				}
				if ($articulosA->count() > 100) {
					$limit = 300;
				}

				$this->paginate = [
					'limit' => $limit,
					'offset' => 0,
				];

				$articulosA->andWhere(['Articulos.eliminado' => 0])->group(['Articulos.id'])
					->order(['Laboratorios.nombre' => 'asc', 'd.tipo_precio' => 'asc', 'Articulos.descripcion_pag' => 'asc']);
				$articulos = $this->paginate($articulosA);
			}
		}
		$this->set('indice', $indice);
		$this->set('tipo_oferta', $tipo_oferta);


		$this->set(compact('articulos'));
		$this->set('_serialize', 'articulos');
		$this->set('lab_id', $lab_id);
	}

	public function sur_friday_sale($lab_id = null, $tipo_oferta = null, $termsearch = null, $indice = null)
	{
		$this->viewBuilder()->layout('storesfs');
		$this->paginate = [
			'contain' => [],
			'limit' => 82,
			'offset' => 0,
			'order' => ['Articulos.descripcion_pag' => 'asc']
		];
		$this->clientecredito();
		$this->sumacarrito();
		$this->loadModel('Articulos');
		$this->loadModel('Carritos');
		//$this->categoriaylaboratorio2();	
		if ($tipo_oferta != 'TD' && $tipo_oferta != 'TH' && $tipo_oferta != 'OR' && $lab_id != 135) {
			$this->categoriaylaboratorio();

			$articulos = $this->Articulos->find('all')
				->contain([
					'Descuentos' => [

						'queryBuilder' => function ($q) {
							return $q->where(['tipo_oferta in ("SF")']); // Full conditions for filtering
						}
					], 'Carritos' => [

						'queryBuilder' => function ($q) {
							return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); // Full conditions for filtering
						}
					]
				])


				->hydrate(false)
				->join(
					[
						'table' => 'descuentos',
						'alias' => 'd',
						'type' => 'INNER',
						'conditions' => [
							'd.articulo_id = Articulos.id',
							'd.tipo_venta = "D"',
							'd.tipo_oferta' => $tipo_oferta
						]
					]
				);

			if ($lab_id == 387) {
				$articulos->where([
					'Articulos.clave_amp in (2675	,
				10688	,
				28632	,
				23439	,
				23559	,
				24041	,
				23490	,
				29550	)',
					'Articulos.eliminado' => 0, 'Articulos.stock <> "F"', 'Articulos.stock <>"D"'
				])
					->andWhere(['Articulos.descripcion_pag LIKE' => '%' . $termsearch . '%'])

					->order(['Articulos.descripcion_sist' => 'ASC']);
			} else {

				if ($lab_id == 143) {
					$articulosu = $articulos->where(['Articulos.laboratorio_id' => $lab_id, 'Articulos.eliminado' => 0, 'Articulos.stock <> "F"', 'Articulos.stock <>"D"', 'Articulos.descripcion_pag LIKE' => '%' . $termsearch . '%'])
						->order(['Articulos.descripcion_sist' => 'ASC']);

					$articulos = $articulos->where(['Articulos.clave_amp IN (10648,12183)', 'Articulos.eliminado' => 0, 'Articulos.stock <> "F"', 'Articulos.stock <>"D"', 'Articulos.descripcion_pag LIKE' => '%' . $termsearch . '%'])
						->unionAll($articulosu)->order(['Articulos.descripcion_sist' => 'ASC']);
				} else
					$articulos->where(['Articulos.laboratorio_id' => $lab_id, 'Articulos.eliminado' => 0, 'Articulos.stock <> "F"', 'Articulos.stock <>"D"', 'Articulos.descripcion_pag LIKE' => '%' . $termsearch . '%'])
						->order(['Articulos.descripcion_sist' => 'ASC']);
			}


			$this->request->session()->write('articulosxx', $articulos->toArray());
		} else {
			$this->categoriaylaboratorio2();

			$fecha = Time::now();
			if ($lab_id != 143 && $lab_id != 157) {
				$articulosA = $this->Articulos->find()
					->contain([
						'Laboratorios', 'Descuentos', 'Carritos' => [

							'queryBuilder' => function ($q) {
								return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); // Full conditions for filtering
							}
						]
					])
					->hydrate(false)
					->join(
						[
							'table' => 'descuentos',
							'alias' => 'd',
							'type' => 'INNER',
							'conditions' => [
								'd.articulo_id = Articulos.id',
								'd.tipo_venta = "D"',
								'd.fecha_hasta >=' => $fecha->i18nFormat('yyyy-MM-dd'),
								'd.tipo_oferta in ("TD","OR","RL","RV","TH","SF")'
							]
						]
					)
					->where(['Articulos.eliminado' => 0]);
				$articulosA->where(['Articulos.laboratorio_id' => $lab_id, 'Articulos.eliminado' => 0, 'Articulos.stock <> "F"', 'Articulos.stock <>"D"'])
					->order(['Articulos.descripcion_sist' => 'ASC']);
				//->andWhere(['Articulos.laboratorio_id'=>$lab_id]);
			}


			if ($lab_id == 157) {
				$articulosA = $this->Articulos->find()
					->contain([
						'Laboratorios', 'Descuentos', 'Carritos' => [

							'queryBuilder' => function ($q) {
								return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); // Full conditions for filtering
							}
						]
					])
					->hydrate(false)
					->join(
						[
							'table' => 'descuentos',
							'alias' => 'd',
							'type' => 'INNER',
							'conditions' => [
								'd.articulo_id = Articulos.id',
								'd.tipo_venta = "D"',
								'd.fecha_hasta >=' => $fecha->i18nFormat('yyyy-MM-dd'),
								'd.tipo_oferta in ("TD","OR","RL","RV","TH","SF")'
							]
						]
					)
					->where(['Articulos.clave_amp IN (	 15416  ,15373  , 	25606  ,        8592  ,        8611  ,       19991  ,       14482  ,        5320  ,       28191  ,        8939  ,       							21715  )', 'Articulos.eliminado' => 0, 'Articulos.stock <> "F"', 'Articulos.stock <>"D"'])
					->order(['Articulos.descripcion_sist' => 'ASC']);
			}
			if ($lab_id == 143) {
				$articulosx = $this->Articulos->find()
					->contain([
						'Laboratorios', 'Descuentos', 'Carritos' => [

							'queryBuilder' => function ($q) {
								return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); // Full conditions for filtering
							}
						]
					])
					->hydrate(false)
					->join(
						[
							'table' => 'descuentos',
							'alias' => 'd',
							'type' => 'INNER',
							'conditions' => [
								'd.articulo_id = Articulos.id',
								'd.tipo_venta = "D"',
								'd.fecha_hasta >=' => $fecha->i18nFormat('yyyy-MM-dd'),
								'd.tipo_oferta in ("TD","OR","RL","RV","TH","SF")'
							]
						]
					)
					->where(['Articulos.laboratorio_id' => $lab_id, 'Articulos.eliminado' => 0, 'Articulos.stock <> "F"', 'Articulos.stock <>"D"'])
					->order(['Articulos.descripcion_sist' => 'ASC']);


				$articulosA = $this->Articulos->find()
					->contain([
						'Laboratorios', 'Descuentos', 'Carritos' => [

							'queryBuilder' => function ($q) {
								return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); // Full conditions for filtering
							}
						]
					])
					->hydrate(false)
					->join(
						[
							'table' => 'descuentos',
							'alias' => 'd',
							'type' => 'INNER',
							'conditions' => [
								'd.articulo_id = Articulos.id',
								'd.tipo_venta = "D"',
								'd.fecha_hasta >=' => $fecha->i18nFormat('yyyy-MM-dd'),
								'd.tipo_oferta in ("TD","OR","RL","RV","TH","SF")'
							]
						]
					)
					->where(['Articulos.clave_amp IN (10648,12183)', 'Articulos.eliminado' => 0, 'Articulos.stock <> "F"', 'Articulos.stock <>"D"'])->unionAll($articulosx)
					->order(['Articulos.descripcion_sist' => 'ASC']);
			}




			if ($articulosA != null) {
				$limit = 100;
				if ($articulosA->count() < 100 && $articulosA->count() > 50) {
					$limit = 150;
				}
				if ($articulosA->count() > 100) {
					$limit = 300;
				}

				$this->paginate = [
					'limit' => $limit,
					'offset' => 0,
				];

				$articulosA->andWhere(['Articulos.eliminado' => 0])->group(['Articulos.id'])
					->order(['Laboratorios.nombre' => 'asc', 'd.tipo_precio' => 'asc', 'Articulos.descripcion_pag' => 'asc']);
				$articulos = $this->paginate($articulosA);
			}
		}
		$this->set('indice', $indice);
		$this->set('tipo_oferta', $tipo_oferta);

		$this->loadModel('Publications');

		$publication_slider = $this->Publications->find('all')->where(['fecha_hasta >=CURRENT_DATE()', 'habilitada' => '1', 'laboratorio_id' => $lab_id])->order(['id' => 'DESC']);
		//$publication_sin->order(['id' => 'DESC']);
		//		$publication_sin->union($publication_con);



		$this->set('publication_slider', $publication_slider->toArray());


		$this->set(compact('articulos'));
		$this->set('_serialize', 'articulos');
		$this->set('lab_id', $lab_id);
	}

	public function promocion($lab_id = null, $termsearch = null, $tipo_oferta = null, $indice = null)
	{
		$this->viewBuilder()->layout('store');
		$this->paginate = [
			'contain' => [],
			'limit' => 200, 'maxLimit' => 200,
			'offset' => 0,
			'order' => ['Articulos.descripcion_pag' => 'asc']
		];
		$this->clientecredito();
		$this->sumacarrito();
		$this->loadModel('Articulos');
		$this->loadModel('Carritos');


		$this->categoriaylaboratorio2();

		$fecha = Time::now();

		$articulosA = $this->Articulos->find()
			->contain([
				'Laboratorios', 'Descuentos', 'Carritos' => [

					'queryBuilder' => function ($q) {
						return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); // Full conditions for filtering
					}
				]
			])
			->hydrate(false)
			->join(
				[
					'table' => 'descuentos',
					'alias' => 'd',
					'type' => 'INNER',
					'conditions' => [
						'd.articulo_id = Articulos.id',
						'd.tipo_venta = "D"',
						'd.fecha_hasta >=' => $fecha->i18nFormat('yyyy-MM-dd'),
						'd.tipo_oferta in ("TD","OR","RL","RV","TH")'
					]
				]
			)
			->where(['Articulos.eliminado' => 0])
			->andWhere(['Articulos.laboratorio_id' => $lab_id]);
		if ($termsearch != null)
			$articulosA->andWhere(['Articulos.descripcion_pag LIKE' => '%' . $termsearch . '%']);
		if ($articulosA != null) {
			$limit = 100;
			if ($articulosA->count() < 100 && $articulosA->count() > 50) {
				$limit = 150;
			}
			if ($articulosA->count() > 100) {
				$limit = 300;
			}

			$this->paginate = [
				'limit' => $limit,
				'offset' => 0,
			];

			$articulosA->andWhere(['Articulos.eliminado' => 0])->group(['Articulos.id'])
				->order(['Laboratorios.nombre' => 'asc', 'd.tipo_precio' => 'asc', 'Articulos.descripcion_pag' => 'asc']);
			$articulos = $this->paginate($articulosA);
		}


		$this->set('indice', $indice);
		$this->set('tipo_oferta', $tipo_oferta);



		$this->set(compact('articulos'));
		$this->set('_serialize', 'articulos');
		$this->set('lab_id', $lab_id);
	}


	public function faltas()
	{
		$this->viewBuilder()->layout('store');
		//,'Carritos'
		$this->paginate = [
			'contain' => ['Laboratorios', 'Categorias', 'Descuentos', 'CarritosFaltas'],
			'limit' => 100,
			'offset' => 0,
			/*'order' => ['Articulos.descripcion_pag' => 'asc']*/
		];
		$this->categoriaylaboratorio();
		$this->clientecredito();
		$this->sumacarrito();


		$this->loadModel('Articulos');
		$fecha = Time::now();
		$fecha->i18nFormat('yyyy-MM-dd');
		$articulosA = $this->Articulos->find('all')
			->contain([
				'CarritosFaltas' => [

					'queryBuilder' => function ($q) {
						return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); // Full conditions for filtering
					}
				]

			])

			->join([
				'table' => 'carritos_faltas',
				'alias' => 'f',
				'type' => 'inner',
				'conditions' => [
					'f.articulo_id = Articulos.id',
					'f.cliente_id =' => $this->request->session()->read('Auth.User.cliente_id')
				]
			])

			->join(
				[
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
			//->andWhere(['Articulos.eliminado =0'])
			->andWhere(['Articulos.eliminado' => 0])->group(['Articulos.id'])
			->order(
				[
					'(CASE 
			when Articulos.stock = "S" then 1
			WHEN Articulos.stock = "R" then 2
			WHEN Articulos.stock = "B" then 3
			WHEN Articulos.stock = "F" then 4  else 5 END)', 'Articulos.descripcion_pag' => 'ASC'
				]
			);
		//WHEN Articulos.descripcion_pag DESC then 1 

		if ($articulosA != null) {
			//$articulosA->order(['Articulos.descripcion_pag'=>'DESC']);
			//$articulosA->gruop(['Articulos.id']);
			$articulos = $this->paginate($articulosA);
		} else
			$articulos = null;

		$this->set(compact('articulos'));

		$this->loadModel('Users');

		$user = $this->Users->get($this->request->session()->read('Auth.User.id'), [
			'contain' => ['Clientes']
		]);


		$user['notificacionfalta'] = 0;
		$this->Users->save($user);
		$this->request->session()->write('Auth.User.notificacionfalta', 0);
	}

	public function farmapoint()
	{
		//$this->viewBuilder()->layout('storefp');
		$this->viewBuilder()->layout('store');
		if ($this->request->session()->read('Auth.User.farmapoint') == 0)
			$this->redirect($this->referer());

		$this->loadModel('LogsAccesos');
		$logsAcceso = $this->LogsAccesos->newEntity();

		$logsAcceso['fecha'] = date('Y-m-d H:i:s');
		//debug(date('Y-m-d H:i:s'));
		$logsAcceso['usuario_id'] = $this->request->session()->read('Auth.User.id');
		$logsAcceso['ip'] = $this->request->clientIp();
		$logsAcceso['seccion'] = 1;
		if ($this->LogsAccesos->save($logsAcceso)) {
		}
		$this->clientecredito();
		$this->sumacarrito();
		$this->loadModel('Articulos');
		$articulos = $this->Articulos->find('all')
			->contain([
				'Descuentos' => [

					'queryBuilder' => function ($q) {
						return $q->where(['tipo_oferta = "FP"']); // Full conditions for filtering
					}
				]
			])

			->hydrate(false)
			->join(
				[
					'table' => 'descuentos',
					'alias' => 'd',
					'type' => 'INNER',
					'conditions' => [
						'd.articulo_id = Articulos.id',
						'd.tipo_venta = "D"',
						'd.tipo_oferta = "FP"'
					]
				]
			)

			->where(['Articulos.eliminado' => 0, 'Articulos.stock <> "F"', 'Articulos.stock <>"D"'])
			->where(['Articulos.imagen NOT IN ("sinimagen.png","perfumeria.jpg","medicamento.jpg")']);

		$this->request->session()->write('articulosxx', $articulos->toArray());
		if ($this->request->session()->read('marcas2') == null) {
			$this->loadModel('Articulos');
			$articulosA = $this->Articulos->find('list', ['keyField' => rtrim('Marcas.id'), 'valueField' => rtrim('Marcas.nombre')])
				->select([rtrim('Marcas.id'), rtrim('Marcas.nombre')])
				->join(
					[
						'table' => 'descuentos',
						'alias' => 'd',
						'type' => 'INNER',
						'conditions' => [
							'd.articulo_id = Articulos.id',
							'd.tipo_venta = "D"',
							'd.tipo_oferta = "FP"'
						]
					]
				)->join(
					[
						'table' => 'marcas',
						'alias' => 'Marcas',
						'type' => 'INNER',
						'conditions' => [
							'Marcas.id = Articulos.marca_id'
						]
					]
				)
				->where(['Articulos.eliminado' => 0, 'Articulos.stock <> "F"', 'Articulos.stock <>"D"'])
				->where(['Articulos.imagen NOT IN ("sinimagen.png","perfumeria.jpg","medicamento.jpg")'])
				->order(['d.id' => 'DESC', 'Articulos.fp_orden' => 'ASC']);
			$articulosB = $this->Articulos->find('list', ['keyField' => rtrim('Subcategoria.id'), 'valueField' => rtrim('Subcategoria.nombre')])
				->select([rtrim('Subcategoria.id'), rtrim('Subcategoria.nombre')])
				->join(
					[
						'table' => 'descuentos',
						'alias' => 'd',
						'type' => 'INNER',
						'conditions' => [
							'd.articulo_id = Articulos.id',
							'd.tipo_venta = "D"',
							'd.tipo_oferta = "FP"'
						]
					]
				)->join(
					[
						'table' => 'subcategorias',
						'alias' => 'Subcategoria',
						'type' => 'INNER',
						'conditions' => [
							'Subcategoria.id = Articulos.subcategoria_id'
						]
					]
				)
				->where(['Articulos.eliminado' => 0, 'Articulos.stock <> "F"', 'Articulos.stock <>"D"'])
				->where(['Articulos.imagen NOT IN ("sinimagen.png","perfumeria.jpg","medicamento.jpg")'])
				->order(['d.id' => 'DESC', 'Articulos.fp_orden' => 'ASC']);
			$this->request->session()->write('categorias2', $articulosB->toArray());
			$categoriass = $this->request->session()->read('categorias2');
			$this->request->session()->write('marcas2', $articulosA->toArray());
			$marcass = $this->request->session()->read('marcas2');
		} else {
			$this->loadModel('Articulos');
			$articulosA = $this->Articulos->find('list', ['keyField' => rtrim('Marcas.id'), 'valueField' => rtrim('Marcas.nombre')])
				->select([rtrim('Marcas.id'), rtrim('Marcas.nombre')])
				->join(
					[
						'table' => 'descuentos',
						'alias' => 'd',
						'type' => 'INNER',
						'conditions' => [
							'd.articulo_id = Articulos.id',
							'd.tipo_venta = "D"',
							'd.tipo_oferta = "FP"'
						]
					]
				)->join(
					[
						'table' => 'marcas',
						'alias' => 'Marcas',
						'type' => 'INNER',
						'conditions' => [
							'Marcas.id = Articulos.marca_id'
						]
					]
				)
				->where(['Articulos.eliminado' => 0, 'Articulos.stock <> "F"', 'Articulos.stock <>"D"'])
				->where(['Articulos.imagen NOT IN ("sinimagen.png","perfumeria.jpg","medicamento.jpg")'])
				->order(['d.id' => 'DESC', 'Articulos.fp_orden' => 'ASC']);
			$articulosB = $this->Articulos->find('list', ['keyField' => rtrim('Subcategoria.id'), 'valueField' => rtrim('Subcategoria.nombre')])
				->select([rtrim('Subcategoria.id'), rtrim('Subcategoria.nombre')])
				->join(
					[
						'table' => 'descuentos',
						'alias' => 'd',
						'type' => 'INNER',
						'conditions' => [
							'd.articulo_id = Articulos.id',
							'd.tipo_venta = "D"',
							'd.tipo_oferta = "FP"'
						]
					]
				)->join(
					[
						'table' => 'subcategorias',
						'alias' => 'Subcategoria',
						'type' => 'INNER',
						'conditions' => [
							'Subcategoria.id = Articulos.subcategoria_id'
						]
					]
				)
				->where(['Articulos.eliminado' => 0, 'Articulos.stock <> "F"', 'Articulos.stock <>"D"'])
				->where(['Articulos.imagen NOT IN ("sinimagen.png","perfumeria.jpg","medicamento.jpg")'])
				->order(['d.id' => 'DESC', 'Articulos.fp_orden' => 'ASC']);
			$this->request->session()->write('categorias2', $articulosB->toArray());
			$this->request->session()->write('marcas2', $articulosA->toArray());
			$categoriass = $this->request->session()->read('categorias2');
			$marcass = $this->request->session()->read('marcas2');
		}
		$this->set('categorias', $categoriass);
		$this->set('marcass', $marcass);


		$this->articulogrupo();
		//$this->set('articulosxx',$articulos);
		/*
		$connection = ConnectionManager::get('default');

			$ofertas = $connection->execute('SELECT ofertas.*,articulos.id AS articuloid, articulos.precio_publico, articulos.categoria_id, articulos.compra_max, 
		  descuentos.dto_drogueria, descuentos.articulo_id, descuentos.plazo, descuentos.uni_min, descuentos.tipo_oferta, descuentos.tipo_venta, descuentos.tipo_precio ,ofertas.oferta_tipo_id 
		  FROM ofertas LEFT JOIN articulos on articulos.id = ofertas.articulo_id INNER JOIN descuentos on descuentos.articulo_id =  articulos.id and 
		  descuentos.tipo_venta = "D" and	descuentos.fecha_hasta >=CURRENT_DATE() and	descuentos.tipo_oferta in ("RV","RR","OR","TD","RL","FR","FP") where ofertas.activo=1 and articulos.stock<>"F" and articulos.imagen NOT IN ("sinimagen.png","perfumeria.jpg","medicamento.jpg" ORDER BY ofertas.id DESC ' )->fetchAll('assoc');
		*/
		$connection = ConnectionManager::get('default');
		$ofertas = $connection->execute('SELECT ofertas.*,articulos.id AS articuloid, articulos.precio_publico, articulos.laboratorio_id, articulos.categoria_id,  articulos.compra_max, articulos.msd, 
		  descuentos.dto_drogueria, descuentos.articulo_id, descuentos.plazo, descuentos.uni_min, descuentos.tipo_oferta, descuentos.tipo_venta, descuentos.tipo_precio ,ofertas.oferta_tipo_id 
		  FROM ofertas LEFT JOIN articulos on articulos.id = ofertas.articulo_id INNER JOIN descuentos on descuentos.articulo_id =  articulos.id and 
		  descuentos.tipo_venta = "D" and	descuentos.fecha_hasta >=CURRENT_DATE() and	descuentos.tipo_oferta in ("RV","RR","OR","TD","RL","FR") where ofertas.activo=1 and articulos.stock<>"F" ORDER BY ofertas.id DESC ')->fetchAll('assoc');
		$this->set('ofertas', $ofertas);
		$articulos = $articulos->toArray();
		$this->set(compact('articulos'));
		$this->set('_serialize', 'articulos');
	}

	public function articulogrupo()
	{
		if ($this->request->session()->read('grupos2') == null) {
			$this->loadModel('Articulos');
			$articulosA = $this->Articulos->find('list', ['keyField' => 'Grupos.id', 'valueField' => 'Grupos.nombre'])
				->select(['Grupos.id', 'Grupos.nombre'])
				->join(
					[
						'table' => 'descuentos',
						'alias' => 'd',
						'type' => 'INNER',
						'conditions' => [
							'd.articulo_id = Articulos.id',
							'd.tipo_venta = "D"',
							'd.tipo_oferta = "FP"'
						]
					]
				)->join(
					[
						'table' => 'grupos',
						'alias' => 'Grupos',
						'type' => 'INNER',
						'conditions' => [
							'Grupos.id = Articulos.grupo_id'
						]
					]
				)
				->where(['Articulos.eliminado' => 0, 'Articulos.stock <> "F"', 'Articulos.stock <>"D"'])
				->where(['Articulos.imagen NOT IN ("sinimagen.png","perfumeria.jpg","medicamento.jpg")'])
				->order(['d.id' => 'DESC', 'Articulos.fp_orden' => 'ASC']);
			$this->request->session()->write('grupos2', $articulosA->toArray());
			$gruposs = $this->request->session()->read('grupos2');
		} else {
			$this->loadModel('Articulos');
			$articulosA = $this->Articulos->find('list', ['keyField' => 'Grupos.id', 'valueField' => 'Grupos.nombre'])
				->select(['Grupos.id', 'Grupos.nombre'])
				->join(
					[
						'table' => 'descuentos',
						'alias' => 'd',
						'type' => 'INNER',
						'conditions' => [
							'd.articulo_id = Articulos.id',
							'd.tipo_venta = "D"',
							'd.tipo_oferta = "FP"'
						]
					]
				)->join(
					[
						'table' => 'grupos',
						'alias' => 'Grupos',
						'type' => 'INNER',
						'conditions' => [
							'Grupos.id = Articulos.grupo_id'
						]
					]
				)
				->where(['Articulos.eliminado' => 0, 'Articulos.stock <> "F"', 'Articulos.stock <>"D"'])
				->where(['Articulos.imagen NOT IN ("sinimagen.png","perfumeria.jpg","medicamento.jpg")'])
				->order(['d.id' => 'DESC', 'Articulos.fp_orden' => 'ASC']);
			$this->request->session()->write('grupos2', $articulosA->toArray());
			$gruposs = $this->request->session()->read('grupos2');
		}
		$this->set('gruposs', $gruposs);
	}

	public function clientecredito()
	{

		if ($this->request->is(['ajax', 'post'])) {

			if (isset($this->request->data['credito_visualizar'])) {
				$this->loadModel('Clientes');

				$creditoo = $this->request->data['credito_visualizar'];
				if ($creditoo == 2) {

					$cliente = $this->Clientes->get($this->request->session()->read('Auth.User.cliente_id'), [
						'contain' => []
					]);
					$cliente['credito_visualizar'] = $this->request->data['credito_visualizar'];
					if ($this->Clientes->save($cliente)) {
						$this->request->session()->write('creditovisualizar', $creditoo);
					}
				} else {
					$cliente = $this->Clientes->get($this->request->session()->read('Auth.User.cliente_id'), [
						'contain' => []
					]);
					$cliente['credito_visualizar'] = $this->request->data['credito_visualizar'];
					if ($this->Clientes->save($cliente)) {
						$this->request->session()->write('creditovisualizar', $creditoo);
					}
				}
			}
		}

		$this->loadModel('ClientesCreditos');
		/*if ($this->request->session()->read('Auth.User.cliente_id') !=36231)
				 $cliente = $this->request->session()->read('Auth.User.cliente_id');
			 else
				 $cliente = 36230;*/

		$cliente = $this->request->session()->read('Auth.User.cliente_id');
		$clientecreditos = $this->ClientesCreditos->find('all')->where(['cliente_id' => $cliente]);

		$clientecredito = $clientecreditos->first();


		if (is_null($clientecredito)) {
			$this->loadModel('Clientes');
			$cliente = $this->Clientes->find('all')->where(['codigo' => $this->request->session()->read('Auth.User.codigo'), 'id not in' => $this->request->session()->read('Auth.User.cliente_id')])->first();
			//$this->request->session()->write('clientecredito',$clientecredito);

			$clientecreditos = $this->ClientesCreditos->find('all')->where(['cliente_id' => $cliente['id']]);
			$clientecredito = $clientecreditos->first();
		}
		$creditodisponible = $clientecredito['credito_maximo'] - $clientecredito['credito_consumo'];
		if ($creditodisponible < 0)
			$creditodisponible = 0;

		$this->set('creditodisponible', $creditodisponible);

		$this->request->session()->write('creditodisponible', $creditodisponible);

		if ($clientecredito['compra_minima'] != null)
			$this->request->session()->write('compra_minima', $clientecredito['compra_minima']);
		else
			$this->request->session()->write('compra_minima', 1500);
	}

	public function monodrogayaccionterapeutica()
	{
		if (empty($this->request->session()->read('Monodrogas'))) {
			$this->loadModel('AlfabetaMonodrogas');
			$this->loadModel('AlfabetaAccionesFars');
			$Monodrogas = $this->AlfabetaMonodrogas->find('list', ['keyField' => 'id', 'valueField' => 'descripcion'])->where(['categoria' => 1])->order(['descripcion' => 'ASC']);
			$AccionesFars = $this->AlfabetaAccionesFars->find('list', ['keyField' => 'id', 'valueField' => 'descripcion'])->where(['categoria' => 1])->order(['descripcion' => 'ASC']);

			//$this->request->session()->write('Categorias',$categorias->toList(['keyField' => 'id','valueField'=>'nombre']));
			//$this->request->session()->write('Laboratorios',$laboratorios ->toList(['keyField' => 'id','valueField'=>'nombre']));
			$this->request->session()->write('Monodrogas', $Monodrogas->toArray());
			$this->request->session()->write('AccionesFars', $AccionesFars->toArray());
			$Monodrogas = $this->request->session()->read('Monodrogas');
			$AccionesFars = $this->request->session()->read('AccionesFars');
		} else {

			$this->loadModel('AlfabetaMonodrogas');
			$this->loadModel('AlfabetaAccionesFars');
			$Monodrogas = $this->AlfabetaMonodrogas->find('list', ['keyField' => 'id', 'valueField' => 'descripcion'])->where(['categoria' => 1])->order(['descripcion' => 'ASC']);
			$AccionesFars = $this->AlfabetaAccionesFars->find('list', ['keyField' => 'id', 'valueField' => 'descripcion'])->where(['categoria' => 1])->order(['descripcion' => 'ASC']);

			$this->request->session()->write('Monodrogas', $Monodrogas->toArray());
			$this->request->session()->write('AccionesFars', $AccionesFars->toArray());

			$Monodrogas = $this->request->session()->read('Monodrogas');
			$AccionesFars = $this->request->session()->read('AccionesFars');
		}
		$this->set('Monodrogas', $Monodrogas);
		$this->set('AccionesFars', $AccionesFars);
	}

	public function categoriaylaboratorio()
	{
		if ($this->request->session()->read('Categorias') == null) {
			$this->loadModel('Categorias');
			$this->loadModel('Laboratorios');
			$categorias = $this->Categorias->find('list', ['keyField' => 'id', 'valueField' => 'nombre']);
			$laboratorios = $this->Laboratorios->find('list', ['keyField' => 'id', 'valueField' => 'nombre'])->where(['eliminado=0'])->order(['nombre' => 'ASC']);

			$this->request->session()->write('Categorias', $categorias->toArray());
			$this->request->session()->write('Laboratorios', $laboratorios->toArray());
		} else {

			$laboratorios = $this->request->session()->read('Laboratorios');
			$categorias = $this->request->session()->read('Categorias');
		}
		$this->set('categorias', $categorias);
		$this->set('laboratorios', $laboratorios);
	}

	public function categoriaylaboratorio2()
	{
		if ($this->request->session()->read('Categorias') == null) {
			$this->loadModel('Categorias');
			$this->loadModel('Laboratorios');
			$categorias = $this->Categorias->find('list', ['keyField' => 'id', 'valueField' => 'nombre']);
			$laboratorios = $this->Laboratorios->find('list', ['keyField' => 'id', 'valueField' => 'nombre'])->andWhere(['tipo' => 1])->order(['nombre' => 'ASC']);

			$this->request->session()->write('Categorias', $categorias->toArray());
			$this->request->session()->write('Laboratorios2', $laboratorios->toArray());
		} else {
			$this->loadModel('Laboratorios');
			$laboratorios = $this->Laboratorios->find('list', ['keyField' => 'id', 'valueField' => 'nombre'])->andWhere(['tipo' => 1])->order(['nombre' => 'ASC']);
			$this->request->session()->write('Laboratorios2', $laboratorios->toArray());

			$laboratorios = $this->request->session()->read('Laboratorios2');
			$categorias = $this->request->session()->read('Categorias');
		}
		$this->set('categorias', $categorias);
		$this->set('laboratorios', $laboratorios);
	}

	/**
	 * Index method
	 *
	 * @return void
	 *//*
    public function index()
    {
		
		if ($this->request->session()->read('Auth.User.perfile_id')==5)
			return $this->redirect($this->Auth->logout());
		
		$this->viewBuilder()->layout('store');
		$this->clientecredito();
		$this->sumacarrito();
		

		$this->clientecredito();
		$this->sumacarrito();	
		$this->set('articulos',null);
		$this->loadModel('Articulos');
		
		$articulos = $this->Articulos->find('all')
					->contain(['Descuentos' => [
						
						'queryBuilder' => function ($q) {
							return $q->where(['tipo_oferta = "HS"']); // Full conditions for filtering
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
						'd.tipo_oferta = "HS"'
						]		
					]
					)
					
				->where(['Articulos.eliminado'=>0,'Articulos.stock <> "F"','Articulos.stock <>"D"'])
				->where(['Articulos.imagen NOT IN ("sinimagen.png","perfumeria.jpg","medicamento.jpg")']);
				
				$this->request->session()->write('articulosxx',$articulos->toArray());
			
				//$this->set('articulosxx',$articulos);
		
		$connection = ConnectionManager::get('default');

			$ofertas = $connection->execute('SELECT ofertas.*,articulos.id AS articuloid, articulos.precio_publico, articulos.categoria_id, articulos.compra_max, 
		  descuentos.dto_drogueria, descuentos.articulo_id, descuentos.plazo, descuentos.uni_min, descuentos.tipo_oferta, descuentos.tipo_venta, descuentos.tipo_precio ,ofertas.oferta_tipo_id 
		  FROM ofertas LEFT JOIN articulos on articulos.id = ofertas.articulo_id INNER JOIN descuentos on descuentos.articulo_id =  articulos.id and 
		  descuentos.tipo_venta = "D" and	descuentos.fecha_hasta >=CURRENT_DATE() and	descuentos.tipo_oferta in ("RV","RR","OR","TD","RL","FR","FP") where ofertas.activo=1 and articulos.stock<>"F" and articulos.imagen NOT IN ("sinimagen.png","perfumeria.jpg","medicamento.jpg" ORDER BY ofertas.id DESC ' )->fetchAll('assoc');
		
			$connection = ConnectionManager::get('default');
		$ofertas = $connection->execute('SELECT ofertas.*,articulos.id AS articuloid, articulos.precio_publico, articulos.laboratorio_id, articulos.categoria_id,  articulos.compra_max, articulos.msd, articulos.imagen AS imagencb,
		  descuentos.dto_drogueria, descuentos.articulo_id, descuentos.plazo, descuentos.uni_min, descuentos.tipo_oferta, descuentos.tipo_venta, descuentos.tipo_precio ,ofertas.oferta_tipo_id 
		  FROM ofertas LEFT JOIN articulos on articulos.id = ofertas.articulo_id INNER JOIN descuentos on descuentos.articulo_id =  articulos.id and 
		  descuentos.tipo_venta = "D" and	descuentos.fecha_hasta >=CURRENT_DATE() and	descuentos.tipo_oferta in ("RV","RR","OR","TD","RL","FR") where ofertas.activo=1 and articulos.stock<>"F" ORDER BY ofertas.id DESC ' )->fetchAll('assoc');
	
		
		$this->set('ofertas',$ofertas);
		
		$articuloshs = $articulos->toArray();
				
			
		$this->set(compact('articuloshs'));
		$this->set('_serialize', 'articuloshs');
		
		
		$connection = ConnectionManager::get('default'); 
		$ofertas = $connection->execute('SELECT ofertas.id, ofertas.articulo_id, ofertas.descripcion, ofertas.detalle, ofertas.busqueda, ofertas.descuento_producto, ofertas.unidades_minimas, ofertas.fecha_desde, ofertas.fecha_hasta, ofertas.plazos, ofertas.oferta_tipo_id, 
			ofertas.unidades_maximas, ofertas.activo, ofertas.habilitada, ofertas.tipo_precio, ofertas.aplicaen ,articulos.imagen as imagen
			,articulos.id AS articuloid, articulos.precio_publico, articulos.categoria_id, articulos.compra_max,  
		  	descuentos.dto_drogueria, descuentos.articulo_id, descuentos.plazo, descuentos.uni_min, descuentos.tipo_oferta, descuentos.tipo_venta, descuentos.tipo_precio ,ofertas.oferta_tipo_id 
		  FROM ofertas LEFT JOIN articulos on articulos.id = ofertas.articulo_id INNER JOIN descuentos on descuentos.articulo_id =  articulos.id and 
		  descuentos.tipo_venta = "D" and descuentos.fecha_hasta >=CURRENT_DATE() and	descuentos.tipo_oferta in ("RV","RR","OR","RL","FR","TD") where ofertas.activo=1 and articulos.stock<>"F" ORDER BY ofertas.id DESC ' )->fetchAll('assoc');
		
		$this->categoriaylaboratorio();
		//
		if ($this->request->session()->read('ofertaspatagonias')== null)
		{
			$ofertaspatagonias = $connection->execute('SELECT ofertas.*, articulos.precio_publico, 
			descuentos.dto_drogueria, descuentos.articulo_id, descuentos.plazo, descuentos.uni_min, descuentos.tipo_oferta, descuentos.tipo_venta, descuentos.tipo_precio ,ofertas.oferta_tipo_id ,ofertas.detalle, ofertas.busqueda
			FROM ofertas LEFT JOIN articulos on articulos.id = ofertas.articulo_id LEFT JOIN descuentos on descuentos.articulo_id =  articulos.id and 
			descuentos.tipo_venta = "D" and	descuentos.fecha_hasta >=CURRENT_DATE() and	descuentos.tipo_oferta in ("RV","RR","OR","TD","RL","HS","VC") where ofertas.activo=1 and ofertas.oferta_tipo_id = 6' )->fetchAll('assoc');
			$this->request->session()->write('ofertaspatagonias',$ofertaspatagonias);	
		}
		$this->loadModel('Ofertas');
		$ofertasX = $this->Ofertas->find('all')
		->where(['oferta_tipo_id'=>11, 'activo'=>1]);
		$this->set('ofertasX',$this->paginate($ofertasX));

		$this->loadModel('Novedades');
		$noticias = $this->Novedades->find()->where(['activo' =>'1'])->andWhere(['interno' =>'1','importante'=>'1'])
		->order(['id' => 'DESC']);
		$this->set('noticiaimportante',$noticias->first());
		$this->set('novedades',$this->paginate($noticias) );
		$this->loadModel('Publications');
		$publications = $this->Publications->find('all')->where(['habilitada' =>'1'])->order(['id' => 'DESC'])->all();
		
		$this->set('sursale',$publications->first());
		$this->set('sursale2',$publications->skip(1)->first());
		
		$this->loadModel('Cortes');
		$corte = $this->Cortes->find()->where(['codigo' =>$this->request->session()->read('Auth.User.codigo_postal')])->first();
		$this->request->session()->write('Auth.User.cierre',$corte['proximo_h']);

		$this->loadModel('Ofertas');
		
		$this->set('sursale',$this->Ofertas->find()->where(['activo' =>'1','oferta_tipo_id'=>9])->order(['id' => 'DESC'])->first());
		$this->set('sursale2',$this->Ofertas->find()->where(['activo' =>'1','oferta_tipo_id'=>10])->order(['id' => 'DESC'])->first());
		$this->set(compact('ofertas'));

		if (!$this->request->session()->read('Auth.User.actualizo_correo'))
		{
			return $this->redirect(['controller'=>'clientes','action' => 'edit_email']);
		}
		if ($this->request->session()->read('Auth.User.actualizo_gln')<1 && $this->request->session()->read('Auth.User.actualizo_ingreso')<1)
		{
			$this->request->session()->write('Auth.User.actualizo_ingreso',1);
			return $this->redirect(['controller'=>'clientes','action' => 'comunicado']);
		}
    }
*/

	public function blackfriday()
	{
		$this->paginate = [
			'contain' => [],
			'limit' => 82,
			'offset' => 0,
			'order' => ['Articulos.descripcion_pag' => 'asc']
		];

		if ($this->request->session()->read('Auth.User.perfile_id') == 5)
			return $this->redirect($this->Auth->logout());

		$this->viewBuilder()->layout('store');
		$this->clientecredito();
		$this->sumacarrito();


		//$this->clientecredito();
		//$this->sumacarrito();	
		//$this->set('articulos',null);
		$this->loadModel('Articulos');

		$articulosbf = $this->Articulos->find('all')
			->contain([
				'Descuentos' => [

					'queryBuilder' => function ($q) {
						return $q->where(['tipo_oferta = "SF"']); // Full conditions for filtering
					}
				], 'Carritos' => [

					'queryBuilder' => function ($q) {
						return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); // Full conditions for filtering
					}
				]
			])


			->hydrate(false)
			->join(
				[
					'table' => 'descuentos',
					'alias' => 'd',
					'type' => 'INNER',
					'conditions' => [
						'd.articulo_id = Articulos.id',
						'd.tipo_venta = "D"',
						'd.tipo_oferta = "SF"'
					]
				]
			)

			->where(['Articulos.eliminado' => 0, 'Articulos.stock <> "F"', 'Articulos.stock <>"D"'])
			->order(['Articulos.laboratorio_id' => 'DESC', 'Articulos.descripcion_sist' => 'DESC']);

		$articulos = $this->paginate($articulosbf);
		$this->set('articulos', $articulos);
		$this->set('_serialize', 'articulos');

		$this->categoriaylaboratorio();
	}

	public function hotsale()
	{
		$this->paginate = [
			'contain' => [],
			'limit' => 82,
			'offset' => 0,
			'order' => ['Articulos.descripcion_pag' => 'asc']
		];

		if ($this->request->session()->read('Auth.User.perfile_id') == 5)
			return $this->redirect($this->Auth->logout());

		$this->viewBuilder()->layout('store');
		$this->clientecredito();
		$this->sumacarrito();
		$this->monodrogayaccionterapeutica();
		/*
		$this->clientecredito();
		$this->sumacarrito();	*/
		//$this->set('articulos',null);
		$this->loadModel('Articulos');

		$articulosbf = $this->Articulos->find('all')
			->contain([
				'Descuentos' => [

					'queryBuilder' => function ($q) {
						return $q->where(['tipo_oferta = "HS"']); // Full conditions for filtering
					}
				], 'Carritos' => [

					'queryBuilder' => function ($q) {
						return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); // Full conditions for filtering
					}
				]
			])


			->hydrate(false)
			->join(
				[
					'table' => 'descuentos',
					'alias' => 'd',
					'type' => 'INNER',
					'conditions' => [
						'd.articulo_id = Articulos.id',
						'd.tipo_venta = "D"',
						'd.tipo_oferta = "HS"'
					]
				]
			)

			->where(['Articulos.eliminado' => 0, 'Articulos.stock <> "F"', 'Articulos.stock <>"D"'])
			->order(['Articulos.laboratorio_id' => 'DESC', 'Articulos.descripcion_sist' => 'DESC']);

		$articulos = $this->paginate($articulosbf);
		$this->set('articulos', $articulos);
		$this->set('_serialize', 'articulos');

		$this->categoriaylaboratorio();
	}
	public function indexHOTSALE()
	{

		if ($this->request->session()->read('Auth.User.perfile_id') == 5)
			return $this->redirect($this->Auth->logout());
		$this->paginate = [
			'limit' => 100,
		];

		$this->viewBuilder()->layout('store');
		// if ($this->request->is('get')) {
		$this->clientecredito();
		$this->sumacarrito();

		$connection = ConnectionManager::get('default');
		$this->loadModel('Ofertas');
		$ofertasX = $this->Ofertas->find('all')
			->where(['oferta_tipo_id' => 11]);
		$this->set('ofertasX', $this->paginate($ofertasX));


		$this->loadModel('Cortes');
		$corte = $this->Cortes->find()->where(['codigo' => $this->request->session()->read('Auth.User.codigo_postal')])->first();
		$this->request->session()->write('Auth.User.cierre', $corte['proximo_h']);

		$fecha = Time::now();
		$fecha = $fecha->i18nFormat('yyyy-MM-dd');
		$ofertasY = $this->Ofertas->find('all')
			->contain([
				'Articulos', 'articulos.Descuentos' => [
					'queryBuilder' => function ($q) {
						return $q->where([
							'tipo_venta = "D"', 'fecha_hasta >=CURRENT_DATE()', 'tipo_oferta in ("RV","RR","OR","FR","TD","RL")'
						]); // Full conditions for filtering
					}
				]
			])
			->hydrate(false)
			->join(
				[
					'table' => 'descuentos',
					'alias' => 'd',
					'type' => 'left',
					'conditions' => [
						'd.articulo_id = Ofertas.articulo_id',
						'd.tipo_venta = "D"',
						'd.fecha_hasta >=' => $fecha,
						'd.tipo_oferta in ("RV","RR","OR","TD","RL","FR")'
					]
				]
			)
			->where(['Ofertas.activo=1', 'Articulos.stock<>"F"'])
			->where(['Ofertas.fecha_hasta >=' => $fecha])
			->order(['Ofertas.id' => 'DESC']);
		//$ofertasZ =$ofertasY;
		$this->set('ofertasY', $this->paginate($ofertasY));

		$ofertasHOT = $this->Ofertas->find('all')->where(['oferta_tipo_id' => 14, 'activo' => 1, 'fecha_hasta >=CURRENT_DATE()']);

		$this->set('ofertasHOT', $this->paginate($ofertasHOT));


		$this->set('articulos', null);
		$this->loadModel('Articulos');
		/*
		$articulos = $this->Articulos->find('all')
					->contain(['Descuentos' => [
						
						'queryBuilder' => function ($q) {
							return $q->where(['tipo_oferta = "HS"']); // Full conditions for filtering
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
						'd.tipo_oferta = "HS"'
						]		
					]
					)
					
				->where(['Articulos.eliminado'=>0,'Articulos.stock <> "F"','Articulos.stock <>"D"'])
				->where(['Articulos.imagen NOT IN ("sinimagen.png","perfumeria.jpg","medicamento.jpg")']);
				$articuloshs = $articulos->toArray();
				
			
				$this->set(compact('articuloshs'));
				$this->set('_serialize', 'articuloshs'); */

		$this->loadModel('Ofertas');

		$ofertasX = $this->Ofertas->find('all')->where(['oferta_tipo_id' => 11, 'activo' => 1, 'fecha_hasta >=CURRENT_DATE()']);

		$this->set('ofertasX', $this->paginate($ofertasX));

		$articulos = $this->Articulos->find('all')
			->contain([
				'Descuentos' => [

					'queryBuilder' => function ($q) {
						return $q->where(['tipo_oferta in ("HS")']); // Full conditions for filtering
					}
				]
			])
			->hydrate(false)
			->join(
				[
					'table' => 'descuentos',
					'alias' => 'd',
					'type' => 'INNER',
					'conditions' => [
						'd.articulo_id = Articulos.id',
						'd.tipo_venta = "D"',
						'd.tipo_oferta in ("HS")'
					]
				]
			)

			->where(['Articulos.eliminado' => 0, 'Articulos.stock <> "F"', 'Articulos.stock <>"D"'])
			->where(['Articulos.imagen NOT IN ("sinimagen.png","perfumeria.jpg","medicamento.jpg")'])->limit(40);
		$articuloshs = $articulos->toArray();


		$this->set(compact('articuloshs'));
		$this->set('_serialize', 'articuloshs');


		$this->set(compact('articuloshs'));
		$this->set('_serialize', 'articuloshs');

		$this->categoriaylaboratorio();

		/*if ($this->request->session()->read('ofertaspatagonias')== null)
		{
			$ofertaspatagonias = $connection->execute('SELECT ofertas.*, articulos.precio_publico, 
			descuentos.dto_drogueria, descuentos.articulo_id, descuentos.plazo, descuentos.uni_min, descuentos.tipo_oferta, descuentos.tipo_venta, descuentos.tipo_precio ,ofertas.oferta_tipo_id ,ofertas.detalle, ofertas.busqueda
			FROM ofertas LEFT JOIN articulos on articulos.id = ofertas.articulo_id LEFT JOIN descuentos on descuentos.articulo_id =  articulos.id and 
			descuentos.tipo_venta = "D" and	descuentos.fecha_hasta >=CURRENT_DATE() and	descuentos.tipo_oferta in ("RV","RR","OR","TD","RL","HS","VC") where ofertas.activo=1 and ofertas.oferta_tipo_id = 6' )->fetchAll('assoc');
			$this->request->session()->write('ofertaspatagonias',$ofertaspatagonias);	
		}*/


		$this->monodrogayaccionterapeutica();
		/* Horario de Corte */
		$this->loadModel('Cortes');
		$corte = $this->Cortes->find()->where(['codigo' => $this->request->session()->read('Auth.User.codigo_postal')])->first();

		$this->request->session()->write('Auth.User.cierre', $corte['proximo_h']);


		/* Novedades Importes*/
		$this->loadModel('Novedades');
		$noticias = $this->Novedades->find()->where(['activo' => '1'])->andWhere(['interno' => '1', 'importante' => '1'])->order(['id' => 'DESC']);
		$this->set('noticiaimportante', $noticias->first());
		$this->set('novedades', $this->paginate($noticias));
		/* Publicaciones*/
		$this->loadModel('Publications');
		$publications = $this->Publications->find('all')->where(['fecha_hasta >=CURRENT_DATE()', 'habilitada' => '1', 'ubicacion' => '2'])->order(['id' => 'DESC'])->all();
		$this->set('sursale', $publications->first());
		$this->set('sursale2', $publications->skip(1)->first());

		$publications = $this->Publications->find('all')->where(['fecha_hasta >=CURRENT_DATE()', 'habilitada' => '1', 'ubicacion' => '6'])->order(['id' => 'DESC'])->all();
		$this->set('publications', $publications->toArray());
		$this->request->session()->write('publications', $publications->toArray());


		$publicationsearch = $this->Publications->find('all')->where(['fecha_hasta >=CURRENT_DATE()', 'habilitada' => '1', 'ubicacion' => '7'])->order(['id' => 'DESC'])->all();

		$this->set('publicationsearch', $publicationsearch->toArray());
		$this->request->session()->write('publicationsearch', $publicationsearch->toArray());



		if (!$this->request->session()->read('Auth.User.actualizo_correo')) {
			return $this->redirect(['controller' => 'clientes', 'action' => 'edit_email']);
		}
		/*if (!$this->request->session()->read('Auth.User.actualizo_gln') && !$this->request->session()->read('Auth.User.actualizo_ingreso'))
		{
			$this->request->session()->write('Auth.User.actualizo_ingreso',1);
			return $this->redirect(['controller'=>'clientes','action' => 'comunicado']);
		} */
		//}
	}
	/* NUEVO*/
	public function index()
	{
		$this->viewBuilder()->layout('store');

		if ($this->request->session()->read('Auth.User.perfile_id') == 5)
			return $this->redirect($this->Auth->logout());

		$this->paginate = ['limit' => 150, 'offset' => 0];
		//$this->viewBuilder()->layout('store');

		$fecha = Time::now();
		$fecha = $fecha->i18nFormat('yyyy-MM-dd');
		$this->loadModel('Ofertas');

		$ofertasX = $this->Ofertas->find('all')->where(['oferta_tipo_id in (2,4,5,6,7,8,9,10,11,19)', 'activo' => 1, 'fecha_desde <= CURRENT_DATE()', 'fecha_hasta >=CURRENT_DATE()'])->order([/*'oferta_tipo_id'=>'ASC',*/'orden' => 'ASC']);

		$this->set('ofertasX', $this->paginate($ofertasX));

		$ofertasY = $this->Ofertas->find('all')
			->contain([
				'Articulos', 'articulos.Descuentos' => [
					'queryBuilder' => function ($q) {
						return $q->where([
							'tipo_venta = "D"', 'fecha_hasta >=CURRENT_DATE()', 'tipo_oferta in ("RV","RR","OR","FR","TD","RL")'
						]); // Full conditions for filtering
					}
				]
			])
			->hydrate(false)
			->join(
				[
					'table' => 'descuentos',
					'alias' => 'd',
					'type' => 'left',
					'conditions' => [
						'd.articulo_id = Ofertas.articulo_id',
						'd.tipo_venta = "D"',
						'd.fecha_hasta >=' => $fecha,
						'd.tipo_oferta in ("RV","RR","OR","TD","RL","FR")'
					]
				]
			)
			->where(['Ofertas.activo=1', 'Articulos.stock<>"F"', 'Ofertas.fecha_desde <' => $fecha, 'Ofertas.fecha_hasta >=' => $fecha])
			->order(['Ofertas.id' => 'DESC']);
		//$ofertasZ =$ofertasY;
		$this->set('ofertasY', $this->paginate($ofertasY));

		$this->loadModel('OfertasTipos');
		$secciones = $this->OfertasTipos->find('all')->where(['ubicacion=4','activo=1'])->order(['orden' => 'ASC']);
		
		$this->set('secciones',$secciones->toArray());

		$this->set('articulos', null);
		/* Cargar informacion credito y laboratorio*/
		$this->clientecredito();
		$this->sumacarrito();
		$this->categoriaylaboratorio();
		$this->monodrogayaccionterapeutica();
		/* Horario de Corte */
		$this->loadModel('Cortes');
		$corte = $this->Cortes->find()->where(['codigo' => $this->request->session()->read('Auth.User.codigo_postal')])->first();

		$this->request->session()->write('Auth.User.cierre', $corte['proximo_h']);


		/* Novedades Importes*/
		$this->loadModel('Novedades');
		$noticias = $this->Novedades->find()->where(['activo' => '1'])->andWhere(['interno' => '1', 'importante' => '1'])->order(['id' => 'DESC']);
		$this->set('noticiaimportante', $noticias->first());
		$this->set('novedades', $this->paginate($noticias));
		/* Publicaciones*/
		$this->loadModel('Publications');

		//$codigo_postal = $this->request->session()->read('Auth.User.codigo_postal');
		//$publication_con = $this->Publications->find('all')->where(['fecha_hasta >=CURRENT_DATE()','habilitada' =>'1','ubicacion'=>'2','localidad'=>$codigo_postal]);
		//$publication_sin = $this->Publications->find('all')->where(['fecha_hasta >=CURRENT_DATE()','habilitada' =>'1','ubicacion'=>'2','localidad'=>0])->union($publication_con);
		$codigo_postal = $this->request->session()->read('Auth.User.codigo_postal');
		$cliente_id = $this->request->session()->read('Auth.User.cliente_id');
		if (
			36040 == $cliente_id || 36193 == $cliente_id || 36227 == $cliente_id || 36247 == $cliente_id || 36481 == $cliente_id || 36505 == $cliente_id || 36913 == $cliente_id ||  67157 == $cliente_id ||
			36950 == $cliente_id || 36966 == $cliente_id || 38678 == $cliente_id || 67154 == $cliente_id || 67156 == $cliente_id || 67167 == $cliente_id || 74353 == $cliente_id
		)
			$codigo_postal = 9999;
		$publication_sin = $this->Publications->find('all')->where(['fecha_hasta >=CURRENT_DATE()', 'habilitada' => '1', 'ubicacion' => '2', 'localidad' => 0])->order(['orden' => 'ASC'])->limit(2);
		$publication_con = $this->Publications->find('all')->where(['fecha_hasta >=CURRENT_DATE()', 'habilitada' => '1', 'ubicacion' => '2', 'localidad like ' => '%' . $codigo_postal . '%'])->unionAll($publication_sin)->order(['orden' => 'ASC'])->limit(4);
		$publication_con->order(['orden' => 'ASC']);
		/* 
		$publication_singral = $this->Publications->find('all')->where(['fecha_hasta >=CURRENT_DATE()','habilitada' =>'1','ubicacion'=>'2','localidad'=>0])->order(['orden' => 'ASC'])->limit(2);
		$publication_grl = $this->Publications->find('all')->where(['fecha_hasta >=CURRENT_DATE()','habilitada' =>'1','ubicacion'=>'2','localidad'=>'2'])->unionAll($publication_singral)->order(['orden' => 'ASC'])->limit(4);
		if($this->request->session()->read('Auth.User.codigo_postal')==8000 || $this->request->session()->read('Auth.User.codigo_postal') ==8105  || $this->request->session()->read('Auth.User.codigo_postal')==8103 || $this->request->session()->read('Auth.User.codigo_postal') ==8109){} else {  }
       	$this->set('sursale2',$publication_grl->first());
		$this->set('sursale',$publication_grl->skip(1)->first());
		*/
		if (36016 != $this->request->session()->read('Auth.User.cliente_id') && 37981 != $cliente_id) {
			$this->set('sursale2', $publication_con->first());
			$this->set('sursale', $publication_con->skip(1)->first());
		} else {
			$this->set('sursale2', null);
			$this->set('sursale', null);
		}



		//$publications = $this->Publications->find('all')->where(['fecha_hasta >=CURRENT_DATE()','habilitada' =>'1','ubicacion'=>'2'])->order(['orden' => 'DESC'])->all();


		$publications = $this->Publications->find('all')->where(['fecha_hasta >=CURRENT_DATE()', 'habilitada' => '1', 'ubicacion' => '6'])->order(['id' => 'DESC'])->all();
		$this->set('publications', $publications->toArray());
		$this->request->session()->write('publications', $publications->toArray());



		$publicationsearch = $this->Publications->find('all')->where(['fecha_hasta >=CURRENT_DATE()', 'habilitada' => '1', 'ubicacion' => '7'])->order(['id' => 'DESC'])->all();

		$this->set('publicationsearch', $publicationsearch->toArray());
		$this->request->session()->write('publicationsearch', $publicationsearch->toArray());

		$publicationzocalo = $this->Publications->find('all')->where(['fecha_hasta >=CURRENT_DATE()', 'habilitada' => '1', 'ubicacion' => '13'])->order(['orden' => 'ASC'])->all();
		$this->set('banner_slider', $publicationzocalo->toArray());
		$this->request->session()->write('banner_slider', $publicationzocalo->toArray());


		if (!$this->request->session()->read('Auth.User.actualizo_correo')) {
			return $this->redirect(['controller' => 'clientes', 'action' => 'edit_email']);
		}
		/*if (!$this->request->session()->read('Auth.User.actualizo_gln') && !$this->request->session()->read('Auth.User.actualizo_ingreso'))
		{
			$this->request->session()->write('Auth.User.actualizo_ingreso',1);
			return $this->redirect(['controller'=>'clientes','action' => 'comunicado']);
		} */
	}


	public function dulzura($termsearchlab = null, $termsearch = null)
	{
		if ($this->request->is('post')) {

			if (!empty($this->request->getParam('pass'))) {

				$laboratorioid = 0;
				if (empty($this->request->getParam('pass')[1])) {
					$terminocompleto = "";
					$termsearch = "";
				} else {
					$terminocompleto = explode(" ", $this->request->getParam('pass')[1]);
					$termsearch = "";
					if (count($terminocompleto) > 1) {
						foreach ($terminocompleto as $terminosimple) :
							$termsearch = $termsearch . '%' . $terminosimple . '%';
						endforeach;
					} else
						$termsearch = '%' . $terminocompleto[0] . '%';
				}
				//$this->request->getParam('pass');
				if (empty($this->request->getParam('pass')[0]))
					$termsearchlab = "";
				else
					$laboratorioid = $termsearchlab;
			}
		} else {


			$laboratorioid = 0;
			$termsearch = "";
			$laboratorioid = 0;
			if (empty($this->request->getParam('pass')[1])) {
				$terminocompleto = "";
				$termsearch = "";
			} else {
				$terminocompleto = explode(" ", $this->request->getParam('pass')[1]);
				$termsearch = "";
				if (count($terminocompleto) > 1) {
					foreach ($terminocompleto as $terminosimple) :
						$termsearch = $termsearch . '%' . $terminosimple . '%';
					endforeach;
				} else
					$termsearch = '%' . $terminocompleto[0] . '%';
			}
			//$this->request->getParam('pass');
			if (empty($this->request->getParam('pass')[0]))
				$termsearchlab = "";
			else
				$laboratorioid = $termsearchlab;
		}

		$this->categoriaylaboratorio();

		$this->viewBuilder()->layout('store');

		$this->loadModel('Articulos');

		$fecha = Time::now();
		//$fecha->i18nFormat('YYYY-MM-dd');
		$articulosA = $this->Articulos->find()
			->contain([
				'Descuentos' => [
					'queryBuilder' => function ($q) {
						return $q->where(['tipo_oferta <> "FP"', 'tipo_oferta in ("RV","RR","OR","TD","RL","HS","FR","TH")', 'tipo_oferta <> "VC"']); // Full conditions for filtering
					}


				], 'Carritos' => [

					'queryBuilder' => function ($q) {
						return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); // Full conditions for filtering
					}
				]
			])
			->hydrate(false)
			->join(
				[
					'table' => 'descuentos',
					'alias' => 'd',
					'type' => 'INNER',
					'conditions' => [
						'd.articulo_id = Articulos.id',
						'd.tipo_venta = "D"',
						'd.fecha_hasta >=' => $fecha->i18nFormat('yyyy-MM-dd'),
						'd.tipo_oferta in ("RV","RR","OR","TD","RL","HS","FR","TH")'
					]
				]
			);
		//->where(['eliminado'=>0]);

		//'conditions' => 'd.articulo_id = Articulos.id and CURRENT_DATE() <= d.fecha_hasta and d.tipo_venta in ("D ","  ")',




		if ($termsearch != "") {
			$articulosA->andWhere(['Articulos.descripcion_pag LIKE' => $termsearch]);
			if ($laboratorioid != 0)
				$articulosA->andWhere(['Articulos.laboratorio_id' => $laboratorioid]);
		} else {
			if ($laboratorioid != 0) {
				$articulosA->where(['Articulos.laboratorio_id' => $laboratorioid]);
			} else {

				$articulosA = null;
				$this->redirect($this->referer());
			}
		}





		if ($articulosA != null) {


			$articulosA->andWhere(['Articulos.eliminado' => 0])->group(['Articulos.id']);
			$limit = 25;
			if ($articulosA->count() < 100 && $articulosA->count() > 50) {
				$limit = 50;
			}
			if ($articulosA->count() > 100) {
				$limit = 70;
			}

			$this->paginate = [
				'contain' => ['Carritos'],
				'limit' => $limit,
				'offset' => 0,
				'order' => ['Articulos.descripcion_pag' => 'asc']
			];


			$articulos = $this->paginate($articulosA);
		} else
			$articulos = null;
		$this->set(compact('articulos'));

		$this->loadModel('Publications');

		if ($termsearch != "")
			$publicationsearch = $this->Publications->find('all')->where(['url_campo2 like' => $termsearch, 'laboratorio_id' => $laboratorioid, 'fecha_hasta >=CURRENT_DATE()', 'habilitada' => '1', 'ubicacion' => '16'])->order(['id' => 'DESC'])->all();
		else
			$publicationsearch = $this->Publications->find('all')->where(['laboratorio_id' => $laboratorioid, 'fecha_hasta >=CURRENT_DATE()', 'habilitada' => '1', 'ubicacion' => '16'])->order(['id' => 'DESC'])->all();

		$this->set('publication_lab', $publicationsearch->toArray());
		$this->request->session()->write('publication_lab', $publicationsearch->toArray());
		$this->set('lab_id', $laboratorioid);
	}

	public function home()
	{
		$this->viewBuilder()->layout('store');

		if ($this->request->session()->read('Auth.User.perfile_id') == 5)
			return $this->redirect($this->Auth->logout());

		$this->paginate = ['limit' => 100];
		$this->viewBuilder()->layout('store');

		$fecha = Time::now();
		$fecha = $fecha->i18nFormat('yyyy-MM-dd');
		$this->loadModel('Ofertas');

		$ofertasX = $this->Ofertas->find('all')->where(['oferta_tipo_id' => 11, 'activo' => 1]);

		$this->set('ofertasX', $this->paginate($ofertasX));

		$ofertasY = $this->Ofertas->find('all')
			->contain([
				'Articulos', 'articulos.Descuentos' => [
					'queryBuilder' => function ($q) {
						return $q->where([
							'tipo_venta = "D"', 'fecha_hasta >=CURRENT_DATE()', 'tipo_oferta in ("RV","RR","OR","FR","TD","RL")'
						]); // Full conditions for filtering
					}
				]
			])
			->hydrate(false)
			->join(
				[
					'table' => 'descuentos',
					'alias' => 'd',
					'type' => 'left',
					'conditions' => [
						'd.articulo_id = Ofertas.articulo_id',
						'd.tipo_venta = "D"',
						'd.fecha_hasta >=' => $fecha,
						'd.tipo_oferta in ("RV","RR","OR","TD","RL","FR")'
					]
				]
			)
			->where(['Ofertas.activo=1', 'Articulos.stock<>"F"'])
			->where(['Ofertas.fecha_hasta >=CURRENT_DATE()'])
			->order(['Ofertas.id' => 'DESC']);
		//$ofertasZ =$ofertasY;
		$this->set('ofertasY', $this->paginate($ofertasY));
		//$this->set('ofertasZ',$this->paginate($ofertasZ->where(['Ofertas.ubicacion in (1,2)'])->order(['Ofertas.id' => 'DESC'])));
		//$this->set('ofertasY',$this->paginate($ofertasY->where(['Ofertas.ubicacion in (0)'])->order(['Ofertas.id' => 'DESC'])));

		//$this->set(compact('ofertasY'));
		/* Ofertas*/
		$connection = ConnectionManager::get('default');
		/*$ofertas = $connection->execute('SELECT ofertas.id, ofertas.articulo_id, ofertas.descripcion, ofertas.detalle, ofertas.busqueda, ofertas.descuento_producto, ofertas.unidades_minimas, ofertas.fecha_desde, ofertas.fecha_hasta, ofertas.plazos, ofertas.oferta_tipo_id, 
		ofertas.unidades_maximas, ofertas.activo, ofertas.habilitada, ofertas.tipo_precio, ofertas.aplicaen ,articulos.imagen as imagen
		,articulos.id AS articuloid, articulos.precio_publico, articulos.categoria_id, articulos.compra_max, 
		descuentos.dto_drogueria, descuentos.articulo_id, descuentos.plazo, descuentos.uni_min, descuentos.tipo_oferta, descuentos.tipo_venta, descuentos.tipo_precio ,ofertas.oferta_tipo_id 
		FROM ofertas LEFT JOIN articulos on articulos.id = ofertas.articulo_id INNER JOIN descuentos on descuentos.articulo_id =  articulos.id and 
		descuentos.tipo_venta = "D" and	descuentos.fecha_hasta >=CURRENT_DATE() and	descuentos.tipo_oferta in ("RV","RR","OR","FR","TD","RL") where ofertas.activo=1 and articulos.stock<>"F" ORDER BY ofertas.id DESC ' )->fetchAll('assoc');
		$this->set(compact('ofertas'));*/

		$this->set('articulos', null);
		/* Cargar informacion credito y laboratorio*/
		$this->clientecredito();
		$this->sumacarrito();
		$this->categoriaylaboratorio();

		/* Horario de Corte */
		$this->loadModel('Cortes');
		$corte = $this->Cortes->find()->where(['codigo' => $this->request->session()->read('Auth.User.codigo_postal')])->first();
		$this->request->session()->write('Auth.User.cierre', $corte['proximo_h']);


		/* Novedades Importes*/
		$this->loadModel('Novedades');
		$noticias = $this->Novedades->find()->where(['activo' => '1'])->andWhere(['interno' => '1', 'importante' => '1'])->order(['id' => 'DESC']);
		$this->set('noticiaimportante', $noticias->first());
		$this->set('novedades', $this->paginate($noticias));
		/* Publicaciones*/
		$this->loadModel('Publications');
		$publications = $this->Publications->find('all')->where(['habilitada' => '1'])->order(['id' => 'DESC'])->all();
		$this->set('sursale', $publications->first());
		$this->set('sursale2', $publications->skip(1)->first());

		if (!$this->request->session()->read('Auth.User.actualizo_correo')) {
			return $this->redirect(['controller' => 'clientes', 'action' => 'edit_email']);
		}
		/* if (!$this->request->session()->read('Auth.User.actualizo_gln') && !$this->request->session()->read('Auth.User.actualizo_ingreso'))
		{
			$this->request->session()->write('Auth.User.actualizo_ingreso',1);
			return $this->redirect(['controller'=>'clientes','action' => 'comunicado']);
		} */
	}

	public function confirm()
	{

		$this->loadModel('Clientes');
		$cliente = $this->Clientes->get($this->request->session()->read('Auth.User.cliente_id'), [
			'contain' => ['Provincias', 'Localidads']
		]);
		$this->request->session()->write('Auth.User.pf_dcto', $cliente['preciofarmacia_descuento']);
		$this->loadModel('Sucursals');
		$sucursales = $this->Sucursals->find('all')->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
			->contain(['Localidads']);
		$this->set('sucursales', $sucursales);
		$this->set('cliente', $cliente);

		$this->loadModel('Cortes');
		$corte = $this->Cortes->find()->where(['codigo' => $this->request->session()->read('Auth.User.codigo_postal')])->first();
		$this->request->session()->write('Auth.User.cierre', $corte['proximo_h']);

		$this->viewBuilder()->layout('store');

		$this->paginate = [
			'contain' => ['Descuentos'],
			'limit' => 70,
			'offset' => 0,
			'order' => ['Articulos.descripcion_pag' => 'asc']
		];
		$this->loadModel('Articulos');

		$this->clientecredito();
		$this->sumacarrito();

		$fecha = Time::now();
		//$fecha = Time::createFromFormat('d/m/Y',$fecha,'America/Argentina/Buenos_Aires');
		$fecha = $fecha->i18nFormat('yyyy-MM-dd');
		$this->request->session()->write('fechamierda', $fecha);
		$articulosA = $this->Articulos->find()
			->contain([
				'Carritos' => [

					'queryBuilder' => function ($q) {
						return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); // Full conditions for filtering
					}
				]
			])
			->hydrate(false)
			->join(
				[
					'table' => 'descuentos',
					'alias' => 'd',
					'type' => 'LEFT',
					'conditions' => [
						'd.articulo_id = Articulos.id',
						'd.tipo_venta = "D"',
						'd.fecha_hasta >=' => $fecha,
						'd.tipo_oferta in ("RV","RR","OR","TD","RL","HS","VC")'
					]
				]
			)
			->join(
				[
					'table' => 'carritos',
					'alias' => 'c',
					'type' => 'LEFT',
					'conditions' => [

						'c.articulo_id = Articulos.id',
						'c.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')
					]
				]
			)
			->where(['c.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]);
		//'d.articulo_id = Articulos.id and CURRENT_DATE() <= d.fecha_hasta and d.tipo_venta in ("D ","  ")',

		if ($articulosA != null) {
			$articulosA->andWhere(['eliminado' => 0])->group(['Articulos.id']);
			$articulos = $this->paginate($articulosA);
		} else
			$articulos = null;
		$this->set(compact('articulos'));

		$this->categoriaylaboratorio();

		$this->loadModel('Publications');
		$publications = $this->Publications->find('all')->where(['fecha_hasta >=CURRENT_DATE()', 'habilitada' => '1', 'ubicacion' => '3'])->order(['id' => 'DESC'])->all();

		if (
			(36854 != $this->request->session()->read('Auth.User.cliente_id')) &&
			(37468 != $this->request->session()->read('Auth.User.cliente_id')) &&
			(36932 != $this->request->session()->read('Auth.User.cliente_id')) &&
			(36241 != $this->request->session()->read('Auth.User.cliente_id'))
		) {
			$this->set('confirm1', $publications->first());
			$this->set('confirm2', $publications->skip(1)->first());
		} else {
			$this->set('confirm1', null);
			$this->set('confirm2', null);
		}


		//$this->request->session()->write('sumacarrito',$sumacarrito);
	}

	public function delete_temp($id = null)
	{
		$this->loadModel('CarritosTemps');
		$this->request->allowMethod(['post', 'get', 'delete']);
		$carritosTemp = $this->CarritosTemps->get($id);
		if ($this->CarritosTemps->delete($carritosTemp)) {
			$this->Flash->success('Se elimino correctamente.', ['key' => 'changepass']);
		} else {
			$this->Flash->error('No se pudo eliminar, intente nuevamente', ['key' => 'changepass']);
		}
		$this->redirect($this->referer());
	}
	/**
	 * Add method
	 *
	 * @return void Redirects on successful add, renders view otherwise.
	 */
	public function add()
	{
		$carrito = $this->Carritos->newEntity();
		if ($this->request->is('post')) {
			$carrito = $this->Carritos->patchEntity($carrito, $this->request->data);
			if ($this->Carritos->save($carrito)) {
				$this->Flash->success('Se guardo correctamente', ['key' => 'changepass']);
				$this->redirect($this->referer());
			} else
				$this->Flash->error('No se guardo, intente de nuevo', ['key' => 'changepass']);
		}
		$clientes = $this->Carritos->Clientes->find('list', ['limit' => 200]);
		$sucursals = $this->Carritos->Sucursals->find('list', ['limit' => 200]);
		$this->set(compact('carrito', 'clientes', 'sucursals'));
		$this->set('_serialize', ['carrito']);
	}


	public function pami()
	{
		$this->categoriaylaboratorio();
		$this->viewBuilder()->layout('store');
		//,'Carritos'
		$this->paginate = [
			'contain' => ['Descuentos', 'Carritos'],
			'limit' => 11,
			'offset' => 0,
			'order' => ['Articulos.descripcion_pag' => 'asc']
		];
		$this->loadModel('Articulos');
		$this->clientecredito();
		$this->sumacarrito();
		$this->monodrogayaccionterapeutica();
		$fecha = Time::now();
		//$fecha->i18nFormat('YYYY-MM-dd');
		$articulosA = $this->Articulos->find()
			->contain([
				'Carritos' => [

					'queryBuilder' => function ($q) {
						return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); // Full conditions for filtering
					}
				]
			])
			->hydrate(false)
			->join(
				[
					'table' => 'descuentos',
					'alias' => 'd',
					'type' => 'LEFT',
					'conditions' => [
						'd.articulo_id = Articulos.id',
						'd.tipo_venta = "D"',
						'd.fecha_hasta >=' => $fecha->i18nFormat('yyyy-MM-dd'),
						'd.tipo_oferta in ("RV","RR","OR","TD","TL")'
					]
				]
			)
			->where(['Articulos.id in (27339,27340,27341,27342,27343)']);

		if ($articulosA != null) {
			$limit = 25;
			if ($articulosA->count() < 100 && $articulosA->count() > 50) {
				$limit = 50;
			}
			if ($articulosA->count() > 100) {
				$limit = 75;
			}

			$this->paginate = [
				'contain' => ['Descuentos', 'Carritos'],
				'limit' => $limit,
				'offset' => 0,
				'order' => ['Articulos.descripcion_pag' => 'asc']
			];

			$articulosA->andWhere(['eliminado' => 0])->group(['Articulos.id']);
			$articulos = $this->paginate($articulosA);
		} else
			$articulos = null;
		$this->set(compact('articulos'));
	}

	public function insumos()
	{
		$this->categoriaylaboratorio();
		$this->viewBuilder()->layout('store');
		//,'Carritos'
		$this->paginate = [
			'contain' => ['Descuentos', 'Carritos'],
			'limit' => 5000, 'maxLimit' => 5000,
			'offset' => 0,
			'order' => ['Articulos.descripcion_pag' => 'asc']
		];
		$this->loadModel('Articulos');
		$this->clientecredito();
		$this->sumacarrito();
		$this->monodrogayaccionterapeutica();
		$fecha = Time::now();
		//$fecha->i18nFormat('YYYY-MM-dd');
		$articulosA = $this->Articulos->find()
			->contain([
				'Carritos' => [

					'queryBuilder' => function ($q) {
						return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); // Full conditions for filtering
					}
				]
			])
			->hydrate(false)
			->join(
				[
					'table' => 'descuentos',
					'alias' => 'd',
					'type' => 'LEFT',
					'conditions' => [
						'd.articulo_id = Articulos.id',
						'd.tipo_venta = "D"',
						'd.fecha_hasta >=' => $fecha->i18nFormat('yyyy-MM-dd'),
						'd.tipo_oferta in ("RV","RR","OR","TD","RL","HS","VC")'
					]
				]
			)
			->where(['Articulos.subcategoria_id' => 27]);


		if ($articulosA != null) {
			$limit = 100;
			if ($articulosA->count() < 100 && $articulosA->count() > 50) {
				$limit = 100;
			}
			if ($articulosA->count() > 100) {
				$limit = 300;
			}

			$this->paginate = [
				'contain' => ['Descuentos', 'Carritos'],
				'limit' => $limit,
				'offset' => 0,
				'order' => ['Articulos.descripcion_pag' => 'asc']
			];

			$articulosA->andWhere(['eliminado' => 0])->group(['Articulos.id']);
			$articulos = $this->paginate($articulosA);
		} else
			$articulos = null;
		$this->set(compact('articulos'));
	}

	public function carritoadd()
	{
		if ($this->request->data['cantidad'] != '') {
			if (((int)$this->request->data['cantidad'] > 0) && ((int)$this->request->data['cantidad'] < 1000)) {
				if ((int)$this->request->data['categoria_id'] == 7) {

					$this->Flash->error('No se puede agregar este producto al carro de compras. ', ['key' => 'changepass']);
					return $this->redirect($this->referer());
				}

				$carritocon2 = $this->Carritos->find()
					->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
					->where(['articulo_id' =>  $this->request->data['articulo_id']]);
				if ($carritocon2->count() == 0) {
					$carrito = $this->Carritos->newEntity();
					$carrito['cliente_id'] = $this->request->session()->read('Auth.User.cliente_id');
					$carrito['creado'] = date('Y-m-d H:i:s');
					$carrito['cantidad'] = $this->request->data['cantidad'];
					$carrito['articulo_id'] = $this->request->data['articulo_id'];
					$carrito['precio_publico'] = $this->request->data['precio_publico'];
					$carrito['descripcion'] = $this->request->data['descripcion'];
					$carrito['descuento'] = $this->request->data['descuento'];
					$carrito['plazoley_dcto'] = $this->request->data['plazoley_dcto'];
					$carrito['unidad_minima'] = $this->request->data['unidad_minima'];
					$carrito['tipo_oferta'] = $this->request->data['tipo_oferta'];
					$carrito['tipo_oferta_elegida'] = $this->request->data['tipo_venta'];
					$carrito['tipo_precio'] = $this->request->data['tipo_precio'];

					if ($carrito['tipo_precio'] == 'P' && ($carrito['tipo_oferta'] == 'TD' || $carrito['tipo_oferta'] == 'TL' || $carrito['tipo_oferta'] == 'OR' || $carrito['tipo_oferta'] == 'OD' || $carrito['tipo_oferta'] == 'TH'))
						$carrito['tipo_fact'] = 'TR';
					else
						if ($carrito['tipo_precio'] == 'F' && ($carrito['tipo_oferta'] == 'TD' || $carrito['tipo_oferta'] == 'TL' || $carrito['tipo_oferta'] == 'OR' || $carrito['tipo_oferta'] == 'OD' || $carrito['tipo_oferta'] == 'TH'))

						$carrito['tipo_fact'] = 'TL';
					else
						$carrito['tipo_fact'] = 'N';



					if ($this->Carritos->save($carrito)) {
						$this->Flash->success('Se agrego al carro correctamente.', ['key' => 'changepass']);
						$this->redirect($this->referer());
					} else {
						$this->Flash->error('No se pudo agregar al carro de compras. Intente de nuevo', ['key' => 'changepass']);
					}
				} else {
					foreach ($carritocon2 as $carro) :
						$id = $carro['id'];
						$cant = $this->request->data['cantidad'];
					endforeach;
					$carrito = $this->Carritos->get($id, ['contain' => []]);
					$carrito['cantidad'] = $cant;

					if ($this->Carritos->save($carrito)) {
						$this->Flash->success('Se agrego al carro correctamente dos.', ['key' => 'changepass']);
					} else {
						$this->Flash->error('No se pudo agregar al carro de compras. Intente de nuevo', ['key' => 'changepass']);
					}
					$this->redirect($this->referer());
				}
			} else {
				$this->Flash->error('Ingrese un numero que sea menor a 1000. Intente de nuevo', ['key' => 'changepass']);
				$this->redirect($this->referer());
			}
		} else {

			$this->redirect($this->referer());
		}
	}

	public function view()
	{

		$this->viewBuilder()->layout('store');

		$this->paginate = [
			'contain' => [],
			'limit' => 120,
			'offset' => 0,
			'order' => ['Articulos.descripcion_pag' => 'asc']
		];
		$this->loadModel('Articulos');

		if (is_null($this->request->session()->read('Auth.User.cliente_id'))) {
			return $this->redirect(['action' => 'index']);
		}

		$this->clientecredito();
		$this->sumacarrito();

		$fecha = Time::now();
		//$fecha = Time::createFromFormat('d/m/Y',$fecha,'America/Argentina/Buenos_Aires');
		$fecha = $fecha->i18nFormat('yyyy-MM-dd');

		if ($this->request->session()->read('Auth.User.farmapoint')) {
			$articulosA = $this->Articulos->find()
				->contain([
					'Descuentos' => [
						'queryBuilder' => function ($q) {
							return $q->where(['tipo_oferta in ("RV","RR","OR","TD","RL","HS","FR","TH","FP","VC","CM","FF","BF","SC")']); // Full conditions for filtering
						}
						//'tipo_oferta in ("RV","RR","OR","TD","RL","HS","FR","TH","TD")',

					],
					'Carritos' => [

						'queryBuilder' => function ($q) {
							return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); // Full conditions for filtering
						}
					]
				])
				->hydrate(false)
				->join(
					[
						'table' => 'descuentos',
						'alias' => 'd',
						'type' => 'LEFT',
						'conditions' => [
							'd.articulo_id = Articulos.id',
							'd.tipo_venta = "D"',
							'd.fecha_hasta >=' => $fecha,
							'd.tipo_oferta in ("RV","RR","OR","TD","RL","HS","FR","TH","FP","VC","CM","FF","BF","SC")'
						]
					]
				)
				->join(
					[
						'table' => 'carritos',
						'alias' => 'c',
						'type' => 'LEFT',
						'conditions' => [
							'c.articulo_id = Articulos.id',
							'c.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')
						]
					]
				)->where(['c.cliente_id' => $this->request->session()->read('Auth.User.cliente_id'), 'c.cantidad  < c.unidad_minima', 'c.unidad_minima IS NOT NULL'])
				->group(['Articulos.id'])
				->order(['Articulos.descripcion_sist' => 'ASC']);


			$articulosB = $this->Articulos->find()
				->contain([
					'Descuentos' => [
						'queryBuilder' => function ($q) {
							return $q->where(['tipo_oferta in ("RV","RR","OR","TD","RL","HS","FR","TH","FP","VC","CM","FF","BF","SC")']); // Full conditions for filtering
						}
						//'tipo_oferta in ("RV","RR","OR","TD","RL","HS","FR","TH","TD")',

					],
					'Carritos' => [

						'queryBuilder' => function ($q) {
							return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); // Full conditions for filtering
						}
					]
				])
				->hydrate(false)
				->join(
					[
						'table' => 'descuentos',
						'alias' => 'd',
						'type' => 'LEFT',
						'conditions' => [
							'd.articulo_id = Articulos.id',
							'd.tipo_venta = "D"',
							'd.fecha_hasta >=' => $fecha,
							'd.tipo_oferta in ("RV","RR","OR","TD","RL","HS","FR","TH","FP","VC","CM","FF","BF","SC")'
						]
					]
				)
				->join(
					[
						'table' => 'carritos',
						'alias' => 'c',
						'type' => 'LEFT',
						'conditions' => [
							'c.articulo_id = Articulos.id',
							'c.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')
						]
					]
				)
				->where(['c.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
				->andWhere([

					'OR' => [
						['c.cantidad  >= c.unidad_minima '],
						['c.unidad_minima IS NULL']
					]
				])->andWhere(['eliminado' => 0])->group(['Articulos.id'])->order(['Articulos.descripcion_sist' => 'ASC']);
		} else {
			$articulosA = $this->Articulos->find()
				->contain([
					'Descuentos' => [
						'queryBuilder' => function ($q) {
							return $q->where(['tipo_oferta in ("RV","RR","OR","TD","RL","HS","FR","TH","VC","CM","FF","BF","SC")']); // Full conditions for filtering
						}
						//'tipo_oferta in ("RV","RR","OR","TD","RL","HS","FR","TH","TD")',

					],
					'Carritos' => [

						'queryBuilder' => function ($q) {
							return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); // Full conditions for filtering
						}
					]
				])
				->hydrate(false)
				->join(
					[
						'table' => 'descuentos',
						'alias' => 'd',
						'type' => 'LEFT',
						'conditions' => [
							'd.articulo_id = Articulos.id',
							'd.tipo_venta = "D"',
							'd.fecha_hasta >=' => $fecha,
							'd.tipo_oferta in ("RV","RR","OR","TD","RL","HS","FR","TH","VC","CM","FF","BF","SC")'
						]
					]
				)
				->join(
					[
						'table' => 'carritos',
						'alias' => 'c',
						'type' => 'LEFT',
						'conditions' => [
							'c.articulo_id = Articulos.id',
							'c.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')
						]
					]
				)->where(['c.cliente_id' => $this->request->session()->read('Auth.User.cliente_id'), 'c.cantidad  < c.unidad_minima', 'c.unidad_minima IS NOT NULL'])
				->andWhere(['eliminado' => 0])->group(['Articulos.id'])->order(['Articulos.descripcion_sist' => 'ASC']);


			$articulosB = $this->Articulos->find()
				->contain([
					'Descuentos' => [
						'queryBuilder' => function ($q) {
							return $q->where(['tipo_oferta in ("RV","RR","OR","TD","RL","HS","FR","TH","VC","CM","FF","BF","SC")']); // Full conditions for filtering
						}
						//'tipo_oferta in ("RV","RR","OR","TD","RL","HS","FR","TH","TD")',

					],
					'Carritos' => [

						'queryBuilder' => function ($q) {
							return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); // Full conditions for filtering
						}
					]
				])
				->hydrate(false)
				->join(
					[
						'table' => 'descuentos',
						'alias' => 'd',
						'type' => 'LEFT',
						'conditions' => [
							'd.articulo_id = Articulos.id',
							'd.tipo_venta = "D"',
							'd.fecha_hasta >=' => $fecha,
							'd.tipo_oferta in ("RV","RR","OR","TD","RL","HS","FR","TH","VC","CM","FF","BF","SC")'
						]
					]
				)
				->join(
					[
						'table' => 'carritos',
						'alias' => 'c',
						'type' => 'LEFT',
						'conditions' => [
							'c.articulo_id = Articulos.id',
							'c.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')
						]
					]
				)->where(['c.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
				->andWhere([

					'OR' => [
						['c.cantidad  >= c.unidad_minima '],
						['c.unidad_minima IS NULL']
					]
				])->andWhere(['eliminado' => 0])->group(['Articulos.id'])->order(['Articulos.descripcion_sist' => 'ASC']);
		}
		$c1 = $articulosA->toArray();
		$c2 = $articulosB->toArray();
		$carritocon = array_merge($c1, $c2);


		if ($articulosA != null || $articulosB != null) {

			$articulos = $carritocon;
		} else
			$articulos = null;
		$this->set(compact('articulos'));

		$this->categoriaylaboratorio();


		$this->loadModel('Publications');
		$publications = $this->Publications->find('all')->where(['fecha_hasta >=CURRENT_DATE()', 'habilitada' => '1', 'ubicacion' => '4'])->order(['id' => 'DESC'])->all();
		$this->set('view1', $publications->first());
		$this->set('view2', $publications->skip(1)->first());
	}

	public function fraganciaselectiva()
	{

		$this->request->session()->write('marcaid', 0);
		$this->request->session()->write('termsearch2', "");
		$this->request->session()->write('marcaid', 0);
		$this->loadModel('Marcas');
		$this->loadModel('Generos');

		$marcas = $this->Marcas->find('list', ['keyField' => 'id', 'valueField' => 'nombre'])->where(['marcas_tipos_id' => 1])->order(['nombre' => 'ASC']);
		$generos = $this->Generos->find('list', ['keyField' => 'id', 'valueField' => 'nombre']);
		$marcas->toArray();
		$generos->toArray();
		$this->set(compact('marcas', 'generos'));

		$this->viewBuilder()->layout('store');
		$this->paginate = ['limit' => 5];

		$this->clientecredito();
		$this->sumacarrito();

		$this->loadModel('Incorporations');
		$incorporationsA = $this->Incorporations->find('all');
		$incorporationsA->where(['habilitada' => 1, 'incorporations_tipos_id ' => 1])->limit([5])->order(['id' => 'DESC']);
		$incorporations = $this->paginate($incorporationsA);
		$this->set('incorporations', $incorporations);

		$marcas2 = $this->Marcas->find('all')->where(['marcas_tipos_id' => 1]);
		$marcas2->toArray();

		$this->set(compact('marcas2'));
		//$this->Flash->warning('Nos encontramos actualizado la seccion, intente mas tarde',['key' => 'changepass']);     
		//$this->redirect($this->referer());
	}

	public function resultfraganciaselectiva($marcaid = null, $generoid = null)
	{

		if ($this->request->is('post')) {
			$termsearch2 = "";
			if ($this->request->data['terminobuscar'] != null) {
				$terminocompleto = explode(" ", $this->request->data['terminobuscar']);
				$termsearch2 = "";
				if (count($terminocompleto) > 1) {
					foreach ($terminocompleto as $terminosimple) :
						$termsearch2 = $termsearch2 . '%' . $terminosimple . '%';
					endforeach;
				} else
					$termsearch2 = '%' . $terminocompleto[0] . '%';
			}

			$this->request->session()->write('termsearch2', $termsearch2);
		} else {
			$termsearch2 = $this->request->session()->read('termsearch2');
		}
		if (is_null($marcaid)) {
			if (!is_null($this->request->session()->read('marcaid')))
				$marcaid = $this->request->session()->read('marcaid');
			else
				$marcaid = 0;
		} else
			$this->request->session()->write('marcaid', $marcaid);

		if (is_null($generoid)) {
			if (!is_null($this->request->session()->read('generoid')))
				$generoid = $this->request->session()->read('generoid');
			else
				$generoid = 0;
		} else
			$this->request->session()->write('generoid', $generoid);

		$this->loadModel('Marcas');
		$this->loadModel('Generos');

		$marcas = $this->Marcas->find('list', ['keyField' => 'id', 'valueField' => 'nombre'])->where(['marcas_tipos_id' => 1])->order(['nombre' => 'ASC']);
		$generos = $this->Generos->find('list', ['keyField' => 'id', 'valueField' => 'nombre']);
		$marcas->toArray();
		$generos->toArray();
		$this->set(compact('marcas', 'generos'));

		$this->viewBuilder()->layout('store');
		$this->paginate = ['limit' => 16];

		$this->clientecredito();
		$this->sumacarrito();
		$this->loadModel('Fragancias');

		$fragancia = $this->Fragancias->find()
			->contain([
				'FraganciasPresentaciones', 'FraganciasPresentaciones.Articulos',
				'FraganciasPresentaciones.Articulos.Carritos' => [

					'queryBuilder' => function ($q) {
						return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); // Full conditions for filtering
					}
				]
			]);

		if ($marcaid != 0 && $marcaid != 100) {
			$fragancia->where(['marca_id' => $marcaid]);
		}
		if ($generoid != 0) {
			$fragancia->where(['genero_id' => $generoid]);
		}
		if ($termsearch2 != "") {
			$fragancia->where(['nombre LIKE' => $termsearch2]);
		}
		$this->set('fragancias', $this->paginate($fragancia));
	}

	public function sumarvista($entities)
	{
		foreach ($entities as $carrito) {
			$sumavista = 0;
			if ($carrito['combo_id'] > 0) {
				//$this->request->session()->write('Combo',$this->ControlUnidades($carrito));

				foreach ($entities as $carritoX) {
					if ($carrito['combo_id'] == $carritoX['combo_id'] && $carritoX['combo_id'] > 0) {
						$sumavista += $carritoX['cantidad'];;
					}
				}
				$this->request->session()->write('sumavista', $sumavista);
				if ($sumavista < $carrito['multiplo']) {

					$this->Flash->error('No llega al minimo :' . $sumavista . ' Objetivo: ' . $carrito['multiplo'], ['key' => 'changepass']);
					return false;
				} else {
					//$this->Flash->success('EXITO '.$sumavista.' '.$carrito['multiplo'] ,['key' => 'changepass']);
					return true;
				}
				/*
			if (!$this->ControlUnidades($carrito, $sumavista))
				{
					return $this->redirect($this->referer());
				}*/
			}
		}
		return true;
	}


	public function carritoaddall()
	{
		$carritos = TableRegistry::get('Carritos');
		$entities = $carritos->newEntities($this->request->data());
		$this->set('carritos2', $this->request->data);
		$this->loadModel('Articulos');
		/* PARA HOTSALE CONTROL
		if (!$this->sumarvista($entities))
		{
			$this->Flash->error('No se llego objetivo de unidades: ',['key' => 'changepass']);
			
			return $this->redirect($this->referer());
		}
			*/
		foreach ($entities as $carrito) {
			$carrito['cliente_id'] = $this->request->session()->read('Auth.User.cliente_id');

			if ($carrito['cantidad'] != '') {
				$articulo = $this->Articulos->find()
					->where(['id' =>  $carrito['articulo_id']])
					->first();

				if (((int)$carrito['cantidad'] > 0) && ((int)$carrito['cantidad'] < 1000)) {
					$categoria = (int)$articulo['categoria_id'];

					/*
			if ($carrito['articulo_id']==49001)	
				{
				
						$this->Flash->error('Para poder adquirirlo se deben comunicar a directortecnico@drogueriasur.com.ar   donde se les informarán los requisitos para efectuar la compra.',['key' => 'changepass']);
						return $this->redirect($this->referer());					
					
				} */

					if ($this->request->session()->read('Auth.User.habilitado') == 2) {
						if ($categoria == 6 || $categoria == 7) {
							$this->Flash->error('No se puede agregar este producto al carro de compras. ', ['key' => 'changepass']);
							return $this->redirect($this->referer());
						}
					}
					if ($this->request->session()->read('Auth.User.habilitado') == 3) {
						if ($categoria != 5 && $categoria != 4) {
							$this->Flash->error('No se puede agregar este producto al carro de compras. ', ['key' => 'changepass']);
							return $this->redirect($this->referer());
						}
						if ($categoria == 5 && $articulo['restringido_perf'] != 0) {
							$this->Flash->error('No se puede agregar este producto al carro de compras. ', ['key' => 'changepass']);
							return $this->redirect($this->referer());
						}
					}

					if ((int)$carrito['categoria_id'] == 7) {

						$this->Flash->error('No se puede agregar este producto al carro de compras. ', ['key' => 'changepass']);
						//return $this->redirect($this->referer());
					} else {
						$carritocon2 = $this->Carritos->find()
							->where(['cliente_id' => $carrito['cliente_id']])
							->where(['articulo_id' =>  $carrito['articulo_id']]);
						if ($carritocon2->count() == 0) {
							// Inserto Registro al carrito
							// asigno tipo de facturacion.
							if ((int)$articulo['compra_multiplo'] > 1)
								if ((int)$carrito['cantidad'] % (int)$articulo['compra_multiplo'] != 0) {
									$this->Flash->error('No se agrego ' . $carrito['descripcion'] . ' al carro de compras, la cantidad tiene que ser multiplo de ' . $carrito['compra_multiplo'], ['key' => 'changepass']);
									return $this->redirect($this->referer());
								}
							if ((int)$carrito['cantidad'] < (int)$articulo['compra_min']) {
								$this->Flash->error('No se agrego ' . $carrito['descripcion'] . ' al carro de compras, la cantidad tiene minima de venta es de ' . $carrito['compra_min'], ['key' => 'changepass']);
								return $this->redirect($this->referer());
							}
							$carrito['creado'] = date('Y-m-d H:i:s');
							$carrito['tipo_oferta_elegida'] = $carrito['tipo_venta'];
							if ($carrito['tipo_precio'] == 'P' && ($carrito['tipo_oferta'] == 'TD' || $carrito['tipo_oferta'] == 'TL' || $carrito['tipo_oferta'] == 'OR' || $carrito['tipo_oferta'] == 'OD' || $carrito['tipo_oferta'] == 'TH'))
								$carrito['tipo_fact'] = 'TR';
							else
						if ($carrito['tipo_precio'] == 'F' && ($carrito['tipo_oferta'] == 'TD' || $carrito['tipo_oferta'] == 'TL' || $carrito['tipo_oferta'] == 'OR' || $carrito['tipo_oferta'] == 'OD' || $carrito['tipo_oferta'] == 'TH'))
								$carrito['tipo_fact'] = 'TL';
							else
								$carrito['tipo_fact'] = 'N';


							$cantidad = $carrito['cantidad'];
							$cantidadmax = $carrito['compra_max'];
							/*if ($carrito['categoria_id']!=5 && $carrito['categoria_id']!=4 )
				$cantidadmax = 100;
				else
				$cantidadmax = 500;	
				*/
							/*
				if ($carrito['articulo_id']==14114)
				{
					if ($carrito['cantidad'] >20)
							
							if(( $cantidad % 30 ) == 0){
								//
								$calc = intdiv($cantidad, 30);
								
								// es multiplo
								// llevar al resto del combo.
							}else{
			
								 //llevar al multiplo
								 $div = intdiv($cantidad, 30);
								 //$div = number_format($div,0);
								 $calc = $div+1 ;
								 $llevar =  ($calc)* 30;
															  
								 $carrito['cantidad'] = $llevar;
								// Resto del combo
							
								
			
							}

				}
				*/
							if ($cantidad > $cantidadmax && $this->request->session()->read('Auth.User.grupo') != 33 && $this->request->session()->read('Auth.User.grupo') != 1)
								$carrito['cantidad'] = $cantidadmax;
							if ($this->Carritos->save($carrito)) {
								if ($cantidad > $cantidadmax && $this->request->session()->read('Auth.User.grupo') != 33 && $this->request->session()->read('Auth.User.grupo') != 1)
									$this->Flash->success('Se agrego al carro correctamente. Solo ' . $cantidadmax . ' unidades', ['key' => 'changepass']);
								else
									$this->Flash->success('Se agrego al carro correctamente.', ['key' => 'changepass']);
							} else
								$this->Flash->error('No se pudo agregar al carro de compras. Intente de nuevo', ['key' => 'changepass']);
						} else {
							// Modifico la cantidad al carrito
							foreach ($carritocon2 as $carro) :
								$id = $carro['id'];
								$cant = $carrito['cantidad'];
								$carrito2 =  $carrito;
							endforeach;
							$carrito = $this->Carritos->get($id, ['contain' => []]);
							$carrito['cantidad'] = $cant;

							$carrito['modificado'] = date('Y-m-d H:i:s');
							$carrito['tipo_oferta_elegida'] = $carrito2['tipo_venta'];
							$carrito['precio_publico'] = $carrito2['precio_publico'];
							$carrito['descuento'] = $carrito2['descuento'];
							$carrito['plazoley_dcto'] = $carrito2['plazoley_dcto'];
							$carrito['unidad_minima'] = $carrito2['unidad_minima'];
							$carrito['tipo_oferta'] = $carrito2['tipo_oferta'];
							$carrito['compra_max'] = $carrito2['compra_max'];
							$carrito['tipo_precio'] = $carrito2['tipo_precio'];
							//$carrito['tipo_oferta_elegida'] = $carrito2['tipo_venta']; 
							$carrito['categoria_id'] = $carrito2['categoria_id'];



							if ($carrito['tipo_precio'] == 'P' && ($carrito['tipo_oferta'] == 'TD' || $carrito['tipo_oferta'] == 'TL' || $carrito['tipo_oferta'] == 'OR' || $carrito['tipo_oferta'] == 'OD' || $carrito['tipo_oferta'] == 'TH'))
								$carrito['tipo_fact'] = 'TR';
							else
						if ($carrito['tipo_precio'] == 'F' && ($carrito['tipo_oferta'] == 'TD' || $carrito['tipo_oferta'] == 'TL' || $carrito['tipo_oferta'] == 'OR' || $carrito['tipo_oferta'] == 'OD' || $carrito['tipo_oferta'] == 'TH'))
								$carrito['tipo_fact'] = 'TL';
							else
								$carrito['tipo_fact'] = 'N';

							if ((int)$articulo['compra_multiplo'] > 1)
								if ((int)$carrito['cantidad'] % (int)$articulo['compra_multiplo'] != 0) {
									$this->Flash->error('No se agrego ' . $carrito['descripcion'] . ' al carro de compras, la cantidad tiene que ser multiplo de ' . $carrito['compra_multiplo'], ['key' => 'changepass']);
									return $this->redirect($this->referer());
								}
							if ((int)$carrito['cantidad'] < (int)$articulo['compra_min']) {
								$this->Flash->error('No se agrego ' . $carrito['descripcion'] . ' al carro de compras, la cantidad tiene minima de venta es de ' . $carrito['compra_min'], ['key' => 'changepass']);
								return $this->redirect($this->referer());
							}
							$cantidad = $carrito['cantidad'];
							$cantidadmax = $carrito['compra_max'];
							/*if ($carrito['categoria_id']!=5 && $carrito['categoria_id']!=4 )
				$cantidadmax = 100;
				else
				$cantidadmax = 500;	*/
							if ($carrito['articulo_id'] == 14114) {
								if ($carrito['cantidad'] > 20)

									if (($cantidad % 30) == 0) {
										//
										$calc = intdiv($cantidad, 30);

										// es multiplo
										// llevar al resto del combo.
									} else {

										//llevar al multiplo
										$div = intdiv($cantidad, 30);
										//$div = number_format($div,0);
										$calc = $div + 1;
										$llevar =  ($calc) * 30;

										$carrito['cantidad'] = $llevar;
										// Resto del combo



									}
							}


							if ($cantidad > $cantidadmax && $this->request->session()->read('Auth.User.grupo') != 33 && $this->request->session()->read('Auth.User.grupo') != 1)
								$carrito['cantidad'] = $cantidadmax;

							if ($this->Carritos->save($carrito)) {
								if ($cantidad > $cantidadmax && $this->request->session()->read('Auth.User.grupo') != 33 && $this->request->session()->read('Auth.User.grupo') != 1)
									$this->Flash->success('Se modifico la cantidad del producto correctamente. Solo ' . $cantidadmax . ' unidades', ['key' => 'changepass']);
								else
									$this->Flash->success('Se modifico la cantidad del producto correctamente.', ['key' => 'changepass']);
							} else {
								$this->Flash->error('No se pudo agregar al carro de compras. Intente de nuevo', ['key' => 'changepass']);
							}
							//$this->redirect($this->referer());
						}
					}
				} else {
					if ((int)$carrito['cantidad'] == 0) {
						$carritos = $this->Carritos->find('all')
							->where(['cliente_id' => $carrito['cliente_id']])
							->where(['articulo_id' =>  $carrito['articulo_id']])
							->first();
						if ($carritos != null) {
							if ($this->Carritos->delete($carritos))
								$this->Flash->success('Se elimino el producto de carro de compras.', ['key' => 'changepass']);
							//$this->redirect($this->referer());
						}
					} else {
						$this->Flash->error('Ingrese un numero que sea menor a 1000. Intente de nuevo', ['key' => 'changepass']);
						//$this->redirect($this->referer());
					}
				}
			} else {
				if ($carrito['cantidad'] == '') {
					$carritos = $this->Carritos->find('all')
						->where(['cliente_id' => $carrito['cliente_id']])
						->where(['articulo_id' =>  $carrito['articulo_id']])
						->first();
					if ($carritos != null) {
						if ($this->Carritos->delete($carritos))
							$this->Flash->success('Se elimino el producto de carro de compras.', ['key' => 'changepass']);
						//$this->redirect($this->referer());
					}
				} else {
					$this->redirect($this->referer());
				}
			}
		}
		$this->redirect($this->referer());
	}

	public function carritoaddoferta()
	{
		$carritocon2 = $this->Carritos->find()
			->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
			->where(['articulo_id' =>  $this->request->data['articulo_id']]);
		if ($carritocon2->count() == 0) {
			$carrito = $this->Carritos->newEntity();
			$carrito['cliente_id'] = $this->request->session()->read('Auth.User.cliente_id');
			$carrito['creado'] = date('Y-m-d H:i:s');
			$carrito['cantidad'] = $this->request->data['cantidad'];
			$carrito['articulo_id'] = $this->request->data['articulo_id'];
			$carrito['precio_publico'] = $this->request->data['precio_publico'];
			$carrito['descripcion'] = $this->request->data['descripcion'];
			$carrito['descuento'] = $this->request->data['descuento'];
			$carrito['descuento_id'] = $this->request->data['descuento_id'];

			$carrito['plazoley_dcto'] = $this->request->data['plazoley_dcto'];
			$carrito['unidad_minima'] = $this->request->data['unidad_minima'];
			$carrito['tipo_oferta'] = $this->request->data['tipo_oferta'];
			$carrito['tipo_oferta_elegida'] = $this->request->data['tipo_venta'];
			$carrito['tipo_precio'] = $this->request->data['tipo_precio'];
			$carrito['categoria_id'] = $this->request->data['categoria_id'];

			$carrito['compra_max'] = $this->request->data['compra_max'];

			if ($carrito['tipo_precio'] == 'P' && ($carrito['tipo_oferta'] == 'TD' || $carrito['tipo_oferta'] == 'TL' || $carrito['tipo_oferta'] == 'OR' || $carrito['tipo_oferta'] == 'OD' || $carrito['tipo_oferta'] == 'TH'))
				$carrito['tipo_fact'] = 'TR';
			else
						if ($carrito['tipo_precio'] == 'F' && ($carrito['tipo_oferta'] == 'TD' || $carrito['tipo_oferta'] == 'TL' || $carrito['tipo_oferta'] == 'OR' || $carrito['tipo_oferta'] == 'OD' || $carrito['tipo_oferta'] == 'TH'))

				$carrito['tipo_fact'] = 'TL';
			else
				$carrito['tipo_fact'] = 'N';
			$cantidad = $carrito['cantidad'];
			$cantidadmax = $carrito['compra_max'];
			/*if ($carrito['categoria_id']!=5 && $carrito['categoria_id']!=4 )
				$cantidadmax = 100;
				else
				$cantidadmax = 500;	*/

			if ($carrito['articulo_id'] == 14114) {
				if ($carrito['cantidad'] > 20)

					if (($cantidad % 30) == 0) {
						//
						$calc = intdiv($cantidad, 30);

						// es multiplo
						// llevar al resto del combo.
					} else {

						//llevar al multiplo
						$div = intdiv($cantidad, 30);
						//$div = number_format($div,0);
						$calc = $div + 1;
						$llevar =  ($calc) * 30;

						$carrito['cantidad'] = $llevar;
						// Resto del combo



					}
			}
			if ($cantidad > $cantidadmax && $this->request->session()->read('Auth.User.grupo') != 33 && $this->request->session()->read('Auth.User.grupo') != 1)
				$carrito['cantidad'] = $cantidadmax;
			if ($this->Carritos->save($carrito)) {
				if ($cantidad > $cantidadmax && $this->request->session()->read('Auth.User.grupo') != 33 && $this->request->session()->read('Auth.User.grupo') != 1)
					$this->Flash->success('Se agrego al carro correctamente. Solo ' . $cantidadmax . ' unidades', ['key' => 'changepass']);
				else
					$this->Flash->success('Se agrego al carro correctamente.', ['key' => 'changepass']);
			} else {
				$this->Flash->error('No se pudo agregar al carro de compras. Intente de nuevo', ['key' => 'changepass']);
			}
			$this->redirect($this->referer());
		} else {
			foreach ($carritocon2 as $carro) :
				$id = $carro['id'];
				$cant = $this->request->data['cantidad'] + $carro['cantidad'];
			endforeach;
			$carrito = $this->Carritos->get($id, ['contain' => []]);
			$carrito['cantidad'] = $cant;
			$cantidad = $carrito['cantidad'];
			$cantidadmax = $carrito['compra_max'];
			/*if ($carrito['categoria_id']!=5 && $carrito['categoria_id']!=4 )
				$cantidadmax = 100;
				else
				$cantidadmax = 500;	*/
			if ($carrito['articulo_id'] == 14114) {
				if ($carrito['cantidad'] > 20)

					if (($cantidad % 30) == 0) {
						//
						$calc = intdiv($cantidad, 30);

						// es multiplo
						// llevar al resto del combo.
					} else {

						//llevar al multiplo
						$div = intdiv($cantidad, 30);
						//$div = number_format($div,0);
						$calc = $div + 1;
						$llevar =  ($calc) * 30;

						$carrito['cantidad'] = $llevar;
						// Resto del combo



					}
			}
			if ($cantidad > $cantidadmax && $this->request->session()->read('Auth.User.grupo') != 33 && $this->request->session()->read('Auth.User.grupo') != 1)
				$carrito['cantidad'] = $cantidadmax;


			if ($this->Carritos->save($carrito)) {
				if ($cantidad > $cantidadmax && $this->request->session()->read('Auth.User.grupo') != 33 && $this->request->session()->read('Auth.User.grupo') != 1)
					$this->Flash->success('Se modifico el carro correctamente. Solo ' . $cantidadmax . ' unidades', ['key' => 'changepass']);
				else
					$this->Flash->success('Se modifico el carro correctamente.', ['key' => 'changepass']);
			} else {
				$this->Flash->error('No se pudo agregar al carro de compras. Intente de nuevo', ['key' => 'changepass']);
			}
			$this->redirect($this->referer());
		}
	}

	public function carritotempadd()
	{
		if (($this->request->data['cantidad'] != '0') &&  ($this->request->data['cantidad'] != '')) {
			$this->loadModel('CarritosTemps');

			$carritocon2 = $this->CarritosTemps->find()
				->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
				->where(['articulo_id' =>  $this->request->data['articulo_id']]);
			if ($carritocon2->count() == 0) {
				$carrito = $this->CarritosTemps->newEntity();
				$carrito['cliente_id'] = $this->request->session()->read('Auth.User.cliente_id');
				$carrito['creado'] = date('Y-m-d H:i:s');
				$carrito['cantidad'] = $this->request->data['cantidad'];
				$carrito['articulo_id'] = $this->request->data['articulo_id'];
				$carrito['precio_publico'] = $this->request->data['precio_publico'];
				$carrito['descripcion'] = $this->request->data['descripcion'];
				$carrito['descuento'] = $this->request->data['descuento'];
				$carrito['plazoley_dcto'] = $this->request->data['plazoley_dcto'];
				$carrito['unidad_minima'] = $this->request->data['unidad_minima'];
				$carrito['tipo_oferta'] = $this->request->data['tipo_oferta'];
				$carrito['tipo_oferta_elegida'] = $this->request->data['tipo_venta'];
				$carrito['tipo_precio'] = $this->request->data['tipo_precio'];
				$carrito['tipo_precio'] = $this->request->data['categoria_id'];
				$carrito['compra_max'] = $this->request->data['compra_max'];

				if ($carrito['tipo_precio'] == 'P' && ($carrito['tipo_oferta'] == 'TD' || $carrito['tipo_oferta'] == 'TL' || $carrito['tipo_oferta'] == 'OR' || $carrito['tipo_oferta'] == 'OD' || $carrito['tipo_oferta'] == 'TH'))
					$carrito['tipo_fact'] = 'TR';
				else
						if ($carrito['tipo_precio'] == 'F' && ($carrito['tipo_oferta'] == 'TD' || $carrito['tipo_oferta'] == 'TL' || $carrito['tipo_oferta'] == 'OR' || $carrito['tipo_oferta'] == 'OD' || $carrito['tipo_oferta'] == 'TH'))

					$carrito['tipo_fact'] = 'TL';
				else
					$carrito['tipo_fact'] = 'N';

				$cantidad = $carrito['cantidad'];
				$cantidadmax = $carrito['compra_max'];
				/*
				if ($carrito['categoria_id']!=5 && $carrito['categoria_id']!=4 )
				$cantidadmax = 100;
				else
				$cantidadmax = 500;	*/
				if ($cantidad > $cantidadmax && $this->request->session()->read('Auth.User.grupo') != 33 && $this->request->session()->read('Auth.User.grupo') != 1)
					$carrito['cantidad'] = $cantidadmax;

				if ($this->Carritos->save($carrito)) {
					if ($cantidad > $cantidadmax && $this->request->session()->read('Auth.User.grupo') != 33 && $this->request->session()->read('Auth.User.grupo') != 1)
						$this->Flash->success('Se agrego al carro correctamente. Solo ' . $cantidadmax . ' unidades', ['key' => 'changepass']);
					else
						$this->Flash->success('Se agrego al carro correctamente.', ['key' => 'changepass']);
					$this->redirect($this->referer());
				} else {
					$this->Flash->error('No se pudo agregar al carro de compras. Intente de nuevo', ['key' => 'changepass']);
				}
			} else {
				foreach ($carritocon2 as $carro) :
					$id = $carro['id'];
					$cant = $this->request->data['cantidad'];
				endforeach;
				$carrito = $this->CarritosTemps->get($id, ['contain' => []]);
				$carrito['cantidad'] = $cant;
				$cantidadmax = $carrito['compra_max'];
				/*
				$cantidad = $carrito['cantidad'];
				if ($carrito['categoria_id']!=5 && $carrito['categoria_id']!=4 )
				$cantidadmax = 100;
				else
				$cantidadmax = 500;	*/
				if ($cant > $cantidadmax && $this->request->session()->read('Auth.User.grupo') != 33 && $this->request->session()->read('Auth.User.grupo') != 1)
					$carrito['cantidad'] = $cantidadmax;


				if ($this->CarritosTemps->save($carrito)) {
					if ($cant > $cantidadmax && $this->request->session()->read('Auth.User.grupo') != 33 && $this->request->session()->read('Auth.User.grupo') != 1)
						$this->Flash->success('Se  modifico la cantidad importada correctamente. Solo ' . $cantidadmax . ' unidades', ['key' => 'changepass']);
					else
						$this->Flash->success('Se modifico la cantidad importada correctamente.', ['key' => 'changepass']);
				} else {
					$this->Flash->error('No se pudo modificar la cantidad importada. Intente de nuevo', ['key' => 'changepass']);
				}
				$this->redirect($this->referer());
			}
		} else {
			$this->loadModel('CarritosTemps');



			$carritosTemp = $this->CarritosTemps->get($this->request->data['carrito_temp_id']);

			if ($this->CarritosTemps->delete($carritosTemp)) {
				$this->Flash->success('Se elimino el producto de los importados.', ['key' => 'changepass']);
			}
			$this->redirect($this->referer());
		}
	}


	public function carritotempaddall()
	{
		$this->loadModel('CarritosTemps');
		$carritos = TableRegistry::get('CarritosTemps');
		$entities = $carritos->newEntities($this->request->data());

		foreach ($entities as $carrito) {

			if (($carrito['cantidad'] != '0') &&  ($carrito['cantidad'] != '')) {

				if (((int)$carrito['cantidad'] > 0) && ((int)$carrito['cantidad'] < 1000)) {
					$carrito['cliente_id'] = $this->request->session()->read('Auth.User.cliente_id');

					$carritocon2 = $this->CarritosTemps->find()
						->where(['cliente_id' => $carrito['cliente_id']])
						->where(['articulo_id' =>  $carrito['articulo_id']]);
					if ($carritocon2->count() == 0) {
						//$carrito = $this->CarritosTemps->newEntity();

						$carrito['creado'] = date('Y-m-d H:i:s');


						if ($carrito['tipo_precio'] == 'P' && ($carrito['tipo_oferta'] == 'TD' || $carrito['tipo_oferta'] == 'TL' || $carrito['tipo_oferta'] == 'OR' || $carrito['tipo_oferta'] == 'OD' || $carrito['tipo_oferta'] == 'TH'))
							$carrito['tipo_fact'] = 'TR';
						else
						if ($carrito['tipo_precio'] == 'F' && ($carrito['tipo_oferta'] == 'TD' || $carrito['tipo_oferta'] == 'TL' || $carrito['tipo_oferta'] == 'OR' || $carrito['tipo_oferta'] == 'OD' || $carrito['tipo_oferta'] == 'TH'))

							$carrito['tipo_fact'] = 'TL';
						else
							$carrito['tipo_fact'] = 'N';

						$cantidad = $carrito['cantidad'];
						/*if ($carrito['categoria_id']!=5 && $carrito['categoria_id']!=4 )
				$cantidadmax = 100;
				else
				$cantidadmax = 500;	*/
						$cantidadmax = $carrito['compra_max'];
						if ($cantidad > $cantidadmax && $this->request->session()->read('Auth.User.grupo') != 33 && $this->request->session()->read('Auth.User.grupo') != 1)
							$carrito['cantidad'] = $cantidadmax;
						if ($this->CarritosTemps->save($carrito)) {
							if ($cantidad > $cantidadmax && $this->request->session()->read('Auth.User.grupo') != 33 && $this->request->session()->read('Auth.User.grupo') != 1)
								$this->Flash->success('Se agrego correctamente. Solo ' . $cantidadmax . ' unidades', ['key' => 'changepass']);
							else
								$this->Flash->success('Se agrego correctamente', ['key' => 'changepass']);

							//$this->Flash->success('Se agrego al carro correctamente.',['key' => 'changepass']);
							//$this->redirect($this->referer());
						} else {
							$this->Flash->error('No se pudo agregar. Intente de nuevo', ['key' => 'changepass']);
						}
					} else {
						foreach ($carritocon2 as $carro) :
							$id = $carro['id'];
							$cant = $carrito['cantidad'];
						endforeach;
						$carrito = $this->CarritosTemps->get($id, ['contain' => []]);
						$carrito['cantidad'] = $cant;
						$cantidad = $carrito['cantidad'];
						$cantidadmax = $carrito['compra_max'];
						/*if ($carrito['categoria_id']!=5 && $carrito['categoria_id']!=4 )
				$cantidadmax = 100;
				else
				$cantidadmax = 500;	
				*/
						if ($cantidad > $cantidadmax && $this->request->session()->read('Auth.User.grupo') != 33 && $this->request->session()->read('Auth.User.grupo') != 1)
							$carrito['cantidad'] = $cantidadmax;

						if ($this->CarritosTemps->save($carrito)) {
							if ($cantidad > $cantidadmax && $this->request->session()->read('Auth.User.grupo') != 33 && $this->request->session()->read('Auth.User.grupo') != 1)
								$this->Flash->success('Se modifico la cantidad importada correctamente.Máximo unidades' . $cantidadmax, ['key' => 'changepass']);
							else
								$this->Flash->success('Se modifico la cantidad importada correctamente.', ['key' => 'changepass']);

							//$this->Flash->success('Se modifico la cantidad importada correctamente.',['key' => 'changepass']);
						} else {
							$this->Flash->error('No se pudo modificar la cantidad importada. Intente de nuevo', ['key' => 'changepass']);
						}
						//$this->redirect($this->referer());
					}
				} else
					$this->Flash->error('Ingrese un numero que sea menor a 1000. Intente de nuevo', ['key' => 'changepass']);
			} else {
				$this->loadModel('CarritosTemps');



				$carritosTemp = $this->CarritosTemps->get($carrito['carrito_temp_id']);

				if ($this->CarritosTemps->delete($carritosTemp)) {
					$this->Flash->success('Se elimino el producto de los importados.', ['key' => 'changepass']);
				}
			}
		}
		$this->redirect($this->referer());
	}

	/**
	 * Edit method
	 *
	 * @param string|null $id Carrito id.
	 * @return void Redirects on successful edit, renders view otherwise.
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */
	public function edit()
	{
		$carro = $this->Carritos->newEntity();
		$carro = $this->Carritos->get(intval($this->request->data['id']));
		//debug($this->request->data['cantidad']);
		if ($this->request->is(['patch', 'post', 'put'])) {
			if (((int)$this->request->data['cantidad'] > 0) && ((int)$this->request->data['cantidad'] < 1000)) {
				$carro['cantidad'] = $this->request->data['cantidad'];
			} else {
				$this->Flash->error('Ingrese un numero que sea menor a 1000. Intente de nuevo', ['key' => 'changepass']);
				$this->redirect($this->referer());
			}
			$cantidad = $carro['cantidad'];
			$cantidadmax = $carro['compra_max'];
			/*if ($carro['categoria_id']!=5 && $carro['categoria_id']!=4 )
				$cantidadmax = 100;
				else
				$cantidadmax = 500;	*/
			if ($cantidad > $cantidadmax && $this->request->session()->read('Auth.User.grupo') != 33 && $this->request->session()->read('Auth.User.grupo') != 1)
				$carro['cantidad'] = $cantidadmax;

			if ($this->Carritos->save($carro)) {

				if ($cantidad > $cantidadmax && $this->request->session()->read('Auth.User.grupo') != 33 && $this->request->session()->read('Auth.User.grupo') != 1)
					$this->Flash->success('Se modifico la cantidad correctamente.Máximo unidades' . $cantidadmax, ['key' => 'changepass']);
				else
					$this->Flash->success('Se modifico la cantidad correctamente.', ['key' => 'changepass']);

				//$this->Flash->success('Se agrego correctamente.',['key' => 'changepass']);
				$this->redirect($this->referer());
			} else {
			}
		}
	}

	/**
	 * Delete method
	 *
	 * @param string|null $id Carrito id.
	 * @return void Redirects to index.
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */
	/*public function delete($id = null)
    {
        $this->request->allowMethod(['post','get', 'delete']);
         $carrito = $this->Carritos->find('all')
		->where(['id'=>$id])
		->first([]);
		if (!empty($carrito))
		{ 
			$conn = ConnectionManager::get('default');
			$conn->query('CALL CopiarCarritoItemDelete('.$id.');');
		if ($this->Carritos->delete($carrito)) {
            $this->Flash->success('Se elimino correctamente del carro.',['key' => 'changepass']);
        } else {
            $this->Flash->error('No se pudo eliminar, intente nuevamente',['key' => 'changepass']);
        }
		}
       $this->redirect($this->referer());
    }
	*/

	// 06/07/21
	public function delete($id = null)
	{

		$id = $this->request->getData('id');

		$this->request->allowMethod(['post', 'get', 'delete', 'ajax']);
		/*$carrito = $this->Carritos->find('all')
		->where(['id'=>$id])
		->first([]);*/
		$carrito = $this->Carritos->get($id);
		if (!empty($carrito)) {

			$conn = ConnectionManager::get('default');
			$conn->query('CALL CopiarCarritoItemDelete(' . $id . ');');

			if ($this->Carritos->delete($carrito)) {
				$contenidocarrito = $this->contenidoCarrito();
				$subtotales = $this->calcularsubtotales($contenidocarrito);
				$responseData = ['success' => true, 'responseText' => "eliminado", 'status' => 200, 'subtotal' => $subtotales, 'contenidocarro' => $contenidocarrito];

				$this->response->body(json_encode($responseData));
				$totalcarrito = $subtotales[1];
				$totalunidades = $subtotales[3];
				$totalitems = $subtotales[0];
				$carritos = $contenidocarrito;
				$this->request->session()->write('totalcarrito', $totalcarrito);
				$this->request->session()->write('totalunidades', $totalunidades);
				$this->request->session()->write('totalitems', $totalitems);
				$this->request->session()->write('carritos', $carritos);

				return $this->response;

				// $this->Flash->success('Se elimino correctamente del carro.',['key' => 'changepass']);
			} else {
				$this->Flash->error('No se pudo eliminar, intente nuevamente', ['key' => 'changepass']);
			}
		}
	}

	public function deletefalta($id = null)
	{


		$id = $this->request->getData('id');

		$this->request->allowMethod(['post', 'get', 'delete', 'ajax']);
		/*$carrito = $this->Carritos->find('all')
		->where(['id'=>$id])
		->first([]);*/

		$this->loadModel('CarritosFaltas');

		$carrito = $this->CarritosFaltas->find()->where([
			'articulo_id' => $id, 'cliente_id' => $this->request->session()->read('Auth.User.cliente_id')
		])->first();
		if (!empty($carrito)) {

			$conn = ConnectionManager::get('default');
			$conn->query('DELETE FROM ds.carritos_faltas WHERE articulo_id = ' . $id . ' AND  cliente_id = ' . $this->request->session()->read('Auth.User.cliente_id') . ';');

			$responseData = ['success' => true, 'responseText' => "ok", 'status' => 200];

			$this->response->body(json_encode($responseData));

			return $this->response;
			/*
			if ($this->CarritosFaltas->delete($carrito)) {
				$responseData = ['success' => true, 'responseText' => "ok", 'status' => 200];

				$this->response->body(json_encode($responseData));
				return $this->response;

				// $this->Flash->success('Se elimino correctamente del carro.',['key' => 'changepass']);
			} else {
				$responseData = ['success' => false, 'responseText' => "no", 'status' => 200];

				$this->response->body(json_encode($responseData));
				return $this->response;
			}*/
		}


		//die;

	}

	public function vaciar()
	{
		$conn = ConnectionManager::get('default');
		$cliente_id = $this->request->session()->read('Auth.User.cliente_id');
		$conn->query('CALL CopiarCarritoVacio(' . $cliente_id . ');');

		if ($this->deleteCarrito()) {
			$this->Flash->success('El carrito fue vaciado.', ['key' => 'changepass']);
			$this->redirect($this->referer());
		} else {
			$this->Flash->error('El carrito no pudo ser vaciado. Intente de nuevo.', ['key' => 'changepass']);
			$this->redirect($this->referer());
		}
	}

	public function vaciarimport()
	{
		if ($this->deleteCarritoTemp()) {
			$this->Flash->success('El listado de articulo a importar fue vaciado.', ['key' => 'changepass']);
			$this->redirect($this->referer());
		} else {
			$this->Flash->error('El listado no pudo ser vaciado. Intente de nuevo.', ['key' => 'changepass']);
			$this->redirect($this->referer());
		}
	}

	public function deleteCarrito()
	{
		return $this->Carritos->deleteAll(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]);
	}

	public function deleteCarritoTemp()
	{
		$this->loadModel('CarritosTemps');
		return $this->CarritosTemps->deleteAll(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]);
	}

	public function ofertavc()
	{
		if ($this->request->is('post')) {

			if ($this->request->data['categoria_id'] != null)
				$categoriaid = $this->request->data['categoria_id'];
			else
				$categoriaid = 0;
			if ($this->request->data['laboratorio_id'] != null)
				$laboratorioid = $this->request->data['laboratorio_id'];
			else
				$laboratorioid = 0;
			if ($this->request->data['ofertas'] != null)
				$ofertas = $this->request->data['ofertas'];
			else
				$ofertas = 0;

			if (empty($this->request->data['codigobarras']))
				$codigobarras = 0;
			else
				$codigobarras = 1;

			if ($this->request->data['terminobuscar'] != null) {
				$terminocompleto = explode(" ", $this->request->data['terminobuscar']);
				$termsearch = "";
				if (count($terminocompleto) > 1) {
					foreach ($terminocompleto as $terminosimple) :
						$termsearch = $termsearch . '%' . $terminosimple . '%';
					endforeach;
				} else
					$termsearch = '%' . $terminocompleto[0] . '%';
			} else {
				$termsearch = "";
			}
			$this->request->session()->write('codigobarrasvc', $codigobarras);
			$this->request->session()->write('ofertasvc', $ofertas);
			$this->request->session()->write('termsearchvc', $termsearch);
			$this->request->session()->write('categoriaidvc', $categoriaid);
			$this->request->session()->write('laboratorioidvc', $laboratorioid);
		} else {
			$categoriaid = 0; //$this->request->session()->read('categoriaid');
			$laboratorioid = 0; //$this->request->session()->read('laboratorioid');

			$termsearch = ""; //$this->request->session()->read('termsearchvc');

			$ofertas = 0; //$this->request->session()->read('ofertas');
			$codigobarras  =  0; //$this->request->session()->read('codigobarras');
		}
		$this->monodrogayaccionterapeutica();
		$this->categoriaylaboratorio();
		$this->clientecredito();
		$this->sumacarrito();

		$this->viewBuilder()->layout('store');

		$this->loadModel('Articulos');

		$articulosA = $this->Articulos->find()
			->contain([
				'Descuentos'
				=> [

					'queryBuilder' => function ($q) {
						return $q->where(['tipo_oferta' => 'VC', 'tipo_venta' => 'D']); // Full conditions for filtering
					}
				], 'Carritos' => [

					'queryBuilder' => function ($q) {
						return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); // Full conditions for filtering
					}
				]
			])
			->hydrate(false)
			->join(
				[
					'table' => 'descuentos',
					'alias' => 'd',
					'type' => 'INNER',
					'conditions' => [
						'd.articulo_id = Articulos.id',
						'd.tipo_venta = "D"',
						'd.tipo_oferta = "VC"'
					]
				]
			)

			->where(['eliminado' => 0, 'Articulos.stock <> "F"', 'Articulos.stock <> "D"'/*,'d.dto_drogueria>=30'*/]);

		if ($termsearch != "") {
			$articulosA->andWhere([

				'OR' => [
					['Articulos.descripcion_pag LIKE' => $termsearch],
					['Articulos.troquel LIKE' => $termsearch], ['Articulos.codigo_barras LIKE' => $termsearch], ['Articulos.codigo_barras2 LIKE' => $termsearch]
				],
			]);




			if (($categoriaid != 0) && ($laboratorioid != 0)) {
				$articulosA->andWhere(['Articulos.laboratorio_id' => $laboratorioid])
					->andWhere(['Articulos.categoria_id' => $categoriaid]);
			} else {
				if ($laboratorioid != 0) {
					$articulosA->andWhere(['Articulos.laboratorio_id' => $laboratorioid]);
				} else {
					if ($categoriaid != 0) {
						$articulosA->andWhere(['Articulos.categoria_id' => $categoriaid]);
					} else {
						$articulosA->orWhere(['Articulos.codigo_barras LIKE' => $termsearch]);
					}
				}
			}
		} else {
			if (($categoriaid != 0) && ($laboratorioid != 0)) {
				$articulosA->where(['Articulos.laboratorio_id' => $laboratorioid])
					->where(['Articulos.categoria_id' => $categoriaid]);
			} else {
				if ($laboratorioid != 0) {
					$articulosA->where(['Articulos.laboratorio_id' => $laboratorioid]);
				} else {
					if ($categoriaid != 0) {
						$articulosA->where(['Articulos.categoria_id' => $categoriaid]);
					} else {
						if ($ofertas == 0) {
							//$articulosA=null;
							//$this->redirect($this->referer());
						}
					}
				}
			}
		}

		//'conditions' => 'd.articulo_id = Articulos.id and CURRENT_DATE() <= d.fecha_hasta and d.tipo_venta in ("D ","  ")',

		if ($articulosA != null) {
			$limit = 50;
			if ($articulosA->count() < 100 && $articulosA->count() > 50) {
				$limit = 70;
			}
			if ($articulosA->count() > 100) {
				$limit = 70;
			}

			$this->paginate = [
				'contain' => ['Carritos'],
				'limit' => $limit,

				'maxLimit' => 1000,
				'offset' => 0,
				'order' => ['Articulos.descripcion_pag' => 'asc']
			];

			$articulos = $this->paginate($articulosA);
		} else
			$articulos = null;
		$this->set(compact('articulos'));
	}

	public function primaverasale()
	{

		$this->categoriaylaboratorio();
		$this->clientecredito();
		$this->sumacarrito();
		$this->monodrogayaccionterapeutica();

		$this->viewBuilder()->layout('store');

		//,'Carritos'
		/*$this->paginate = [		
		'contain' => ['Descuentos','Carritos'],
		'limit' => 100,
		'offset' => 0, 
        'order' => ['Articulos.descripcion_pag' => 'asc']];
		*/
		$this->loadModel('Articulos');

		$fecha = Time::now();
		$fecha->i18nFormat('YYYY-MM-dd');

		$this->loadModel('Ofertas');
		$sursale = $this->Ofertas->find()->where(['activo' => '1', 'oferta_tipo_id' => 9])->order(['id' => 'DESC'])->first();
		$this->set('sursale', $sursale);
		if (!empty($sursale)) {
			$fechadesde = Time::now();
			$fechadesde = $sursale['fecha_desde'];
			//$fechadesde->i18nFormat('YYYY-MM-dd');
			//$this->request->session()->write('compra_minima',500);		

			$fechahasta = Time::now();
			$fechahasta = $sursale['fecha_hasta'];
			$fechahasta->modify('+1 days');
			//$fechahasta->i18nFormat('YYYY-MM-dd');

		} else {
			$fechadesde = Time::now();
			//$fechadesde = $sursale['fecha_desde'];
			//$fechadesde->i18nFormat('YYYY-MM-dd');
			//$this->request->session()->write('compra_minima',500);		

			$fechahasta = Time::now();
			//$fechahasta = $sursale['fecha_hasta'];
			$fechahasta->modify('+1 days');
			//$fechahasta->i18nFormat('YYYY-MM-dd');

		}

		$articulosB = $this->Articulos->find()
			->contain([
				'Descuentos' => [

					'queryBuilder' => function ($q) {
						return $q->where(['tipo_oferta' => 'TD']); // Full conditions for filtering
					}
				], 'Carritos' => [

					'queryBuilder' => function ($q) {
						return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); // Full conditions for filtering
					}
				]
			])
			->hydrate(false)
			->join(
				[
					'table' => 'descuentos',
					'alias' => 'd',
					'type' => 'INNER',
					'conditions' => [
						'd.articulo_id = Articulos.id',
						'd.tipo_venta = "D"',

						'd.tipo_oferta in ("TD")'
					]
				]
			)
			->where(['eliminado' => 0, 'Articulos.stock <> "F"', 'Articulos.clave_amp IN (913,8939,15276,14711,28191,20383,24166,19975,00493,05320)']);

		$articulosA = $this->Articulos->find()
			->contain([
				'Descuentos' => [

					'queryBuilder' => function ($q) {
						return $q->where(['tipo_oferta IN ("PS","TD")']); // Full conditions for filtering
					}
				], 'Carritos' => [

					'queryBuilder' => function ($q) {
						return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); // Full conditions for filtering
					}
				]
			])
			->hydrate(false)
			->join(
				[
					'table' => 'descuentos',
					'alias' => 'd',
					'type' => 'INNER',
					'conditions' => [
						'd.articulo_id = Articulos.id',
						'd.tipo_venta = "D"',

						'd.tipo_oferta in ("PS")'
					]
				]
			)
			->where(['eliminado' => 0, 'Articulos.stock <> "F"']);

		$articulosA = $articulosA->unionAll($articulosB);


		if ($articulosA != null) {
			$limit = 50;
			if ($articulosA->count() < 100 && $articulosA->count() > 50) {
				$limit = 70;
			}
			if ($articulosA->count() > 100) {
				$limit = 70;
			}

			$this->paginate = [
				'contain' => ['Carritos'],
				'limit' => $limit,
				'maxLimit' => 1000,
				'offset' => 0,
				'order' => ['Articulos.descripcion_pag' => 'asc']
			];


			$articulos = $this->paginate($articulosA);
		} else
			$articulos = null;
		$this->set(compact('articulos'));
	}

	public function sale()
	{

		$this->categoriaylaboratorio();
		$this->clientecredito();
		$this->sumacarrito();
		$this->monodrogayaccionterapeutica();

		$this->viewBuilder()->layout('store');

		//,'Carritos'
		/*$this->paginate = [		
		'contain' => ['Descuentos','Carritos'],
		'limit' => 100,
		'offset' => 0, 
        'order' => ['Articulos.descripcion_pag' => 'asc']];
		*/
		$this->loadModel('Articulos');

		$fecha = Time::now();
		$fecha->i18nFormat('YYYY-MM-dd');

		$this->loadModel('Ofertas');
		$sursale = $this->Ofertas->find()->where(['activo' => '1', 'oferta_tipo_id' => 9])->order(['id' => 'DESC'])->first();
		$this->set('sursale', $sursale);
		if (!empty($sursale)) {
			$fechadesde = Time::now();
			$fechadesde = $sursale['fecha_desde'];
			//$fechadesde->i18nFormat('YYYY-MM-dd');
			//$this->request->session()->write('compra_minima',500);		

			$fechahasta = Time::now();
			$fechahasta = $sursale['fecha_hasta'];
			$fechahasta->modify('+1 days');
			//$fechahasta->i18nFormat('YYYY-MM-dd');

		} else {
			$fechadesde = Time::now();
			//$fechadesde = $sursale['fecha_desde'];
			//$fechadesde->i18nFormat('YYYY-MM-dd');
			//$this->request->session()->write('compra_minima',500);		

			$fechahasta = Time::now();
			//$fechahasta = $sursale['fecha_hasta'];
			$fechahasta->modify('+1 days');
			//$fechahasta->i18nFormat('YYYY-MM-dd');

		}
		$articulosA = $this->Articulos->find()
			->contain([
				'Descuentos' => [

					'queryBuilder' => function ($q) {
						return $q->where(['tipo_oferta' => 'SS']); // Full conditions for filtering
					}
				], 'Carritos' => [

					'queryBuilder' => function ($q) {
						return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); // Full conditions for filtering
					}
				]
			])
			->hydrate(false)
			->join(
				[
					'table' => 'descuentos',
					'alias' => 'd',
					'type' => 'INNER',
					'conditions' => [
						'd.articulo_id = Articulos.id',
						'd.tipo_venta = "D"',

						'd.tipo_oferta in ("HS")'
					]
				]
			)

			->where([
				'eliminado' => 0,
				'Articulos.stock <> "F"',
				//	"d.fecha_desde BETWEEN '".$fechadesde->i18nFormat('YYYY-MM-dd')."' AND '".$fechahasta->i18nFormat('YYYY-MM-dd')."'",
				//"d.fecha_hasta BETWEEN '".$fechadesde->i18nFormat('YYYY-MM-dd')."' AND '".$fechahasta->i18nFormat('YYYY-MM-dd')."'"

			]);

		if ($articulosA != null) {
			$limit = 50;
			if ($articulosA->count() < 100 && $articulosA->count() > 50) {
				$limit = 70;
			}
			if ($articulosA->count() > 100) {
				$limit = 70;
			}

			$this->paginate = [
				'contain' => ['Carritos'],
				'limit' => $limit,
				'maxLimit' => 1000,
				'offset' => 0,
				'order' => ['Articulos.descripcion_pag' => 'asc']
			];


			$articulos = $this->paginate($articulosA);
		} else
			$articulos = null;
		$this->set(compact('articulos'));
	}

	public function CargarCarritoCB($termsearch = null)
	{

		$fecha = Time::now();
		$fecha->i18nFormat('YYYY-MM-dd');
		$this->loadModel('Articulos');
		$articulo = $this->Articulos->find()
			->contain([
				'Descuentos', 'Carritos' => [

					'queryBuilder' => function ($q) {
						return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); // Full conditions for filtering
					}
				]
			])
			->hydrate(false)
			->join(
				[
					'table' => 'descuentos',
					'alias' => 'd',
					'type' => 'LEFT',
					'conditions' => [
						'd.articulo_id = Articulos.id',
						'd.tipo_venta = "D"',
						'd.fecha_hasta >=' => $fecha,
						'd.tipo_oferta in ("RV","RR","OR","TD","RL","HS","VC","FR","PS")'
					]
				]
			)
			->where([

				'OR' => [['Articulos.codigo_barras LIKE' => $termsearch], ['Articulos.codigo_barras2 LIKE' => $termsearch]]
			])
			->where(['eliminado' => 0])
			//->where(['eliminado'=>0,'Articulos.codigo_barras LIKE'=>$termsearch])
			->first();

		$this->request->session()->write('articulosaaa', $articulo);
		if (!empty($articulo)) {

			if ($articulo['categoria_id'] == 7) {

				$this->Flash->error('No se puede agregar este producto al carro de compras0. ', ['key' => 'changepass']);
				return $this->redirect($this->referer());
			}
			$carritocon2 = $articulo['carritos'];

			/*
			$carritocon2 = $this->Carritos->find()
			->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
			->where(['articulo_id' =>  $this->request->data['articulo_id']]);*/
			if (count($carritocon2) == 0) {
				$carrito = $this->Carritos->newEntity();
				$carrito['cliente_id'] = $this->request->session()->read('Auth.User.cliente_id');
				$carrito['creado'] = date('Y-m-d H:i:s');
				$carrito['cantidad'] = 1;
				$carrito['articulo_id'] = $articulo['id'];
				$carrito['precio_publico'] = $articulo['precio_publico'];
				$carrito['descripcion'] = $articulo['descripcion_sist'];
				$carrito['categoria_id'] = $articulo['categoria_id'];
				$carrito['compra_max'] = $articulo['compra_max'];
				//$descuentos = $articulo['descuentos']; 	
				$carrito['descuento'] = 0;
				$carrito['descuento_id'] = 0;
				$carrito['plazoley_dcto'] = 'HABITUAL';
				$carrito['unidad_minima'] = 1;
				$carrito['tipo_oferta'] = null;
				$carrito['tipo_oferta_elegida'] = null;
				$carrito['tipo_precio'] = null;
				if (count($articulo['descuentos']) > 0) {
					if ($articulo['descuentos'][0]['tipo_venta'] == 'D') {
						$carrito['descuento'] = $articulo['descuentos'][0]['dto_drogueria'];
						$carrito['plazoley_dcto'] = $articulo['descuentos'][0]['plazo'];
						$carrito['unidad_minima'] = $articulo['descuentos'][0]['uni_min'];
						$carrito['tipo_oferta'] = $articulo['descuentos'][0]['tipo_oferta'];
						$carrito['tipo_oferta_elegida'] = $articulo['descuentos'][0]['tipo_venta'];
						$carrito['tipo_precio'] = $articulo['descuentos'][0]['tipo_precio'];
						$carrito['descuento_id'] = $articulo['descuentos'][0]['id'];
					} else {
						if (count($articulo['descuentos']) > 1) {
							if ($articulo['descuentos'][1]['tipo_venta'] == 'D') {
								$carrito['descuento'] = $articulo['descuentos'][1]['dto_drogueria'];
								$carrito['plazoley_dcto'] = $articulo['descuentos'][1]['plazo'];
								$carrito['unidad_minima'] = $articulo['descuentos'][1]['uni_min'];
								$carrito['tipo_oferta'] = $articulo['descuentos'][1]['tipo_oferta'];
								$carrito['tipo_oferta_elegida'] = $articulo['descuentos'][1]['tipo_venta'];
								$carrito['tipo_precio'] = $articulo['descuentos'][1]['tipo_precio'];
								$carrito['descuento_id'] = $articulo['descuentos'][1]['id'];
							}
						} else {
							if (count($articulo['descuentos']) > 1) {
								if ($articulo['descuentos'][1]['tipo_venta'] == 'D') {
									$carrito['descuento'] = $articulo['descuentos'][1]['dto_drogueria'];
									$carrito['plazoley_dcto'] = $articulo['descuentos'][1]['plazo'];
									$carrito['unidad_minima'] = $articulo['descuentos'][1]['uni_min'];
									$carrito['tipo_oferta'] = $articulo['descuentos'][1]['tipo_oferta'];
									$carrito['tipo_oferta_elegida'] = $articulo['descuentos'][1]['tipo_venta'];
									$carrito['tipo_precio'] = $articulo['descuentos'][1]['tipo_precio'];
									$carrito['descuento_id'] = $articulo['descuentos'][1]['id'];
								}
							}
						}
					}
				}
				if ($carrito['tipo_precio'] == 'P' && ($carrito['tipo_oferta'] == 'TD' || $carrito['tipo_oferta'] == 'TL' || $carrito['tipo_oferta'] == 'OR' || $carrito['tipo_oferta'] == 'OD' || $carrito['tipo_oferta'] == 'TH'))
					$carrito['tipo_fact'] = 'TR';
				else
						if ($carrito['tipo_precio'] == 'F' && ($carrito['tipo_oferta'] == 'TD' || $carrito['tipo_oferta'] == 'TL' || $carrito['tipo_oferta'] == 'OR' || $carrito['tipo_oferta'] == 'OD' || $carrito['tipo_oferta'] == 'TH'))

					$carrito['tipo_fact'] = 'TL';
				else
					$carrito['tipo_fact'] = 'N';

				$cantidad = $carrito['cantidad'];
				$cantidadmax = $carrito['compra_max'];
				if ($cantidad > $cantidadmax && $this->request->session()->read('Auth.User.grupo') != 33 && $this->request->session()->read('Auth.User.grupo') != 1)
					$carrito['cantidad'] = $cantidadmax;

				if ($this->Carritos->save($carrito)) {
					if ($cantidad > $cantidadmax && $this->request->session()->read('Auth.User.grupo') != 33 && $this->request->session()->read('Auth.User.grupo') != 1)
						$this->Flash->success('Se agrego al carro correctamente. Solo ' . $cantidadmax . ' unidades', ['key' => 'changepass']);
					else
						$this->Flash->success('Se agrego al carro correctamente.', ['key' => 'changepass']);
				} else {
					$this->Flash->error('No se pudo agregar al carro de compras. Intente de nuevo2', ['key' => 'changepass']);
				}
			} else {
				foreach ($carritocon2 as $carro) :
					$id = $carro['id'];
					$cant = $carro['cantidad'] + 1;
				endforeach;
				$carrito = $this->Carritos->get($id, ['contain' => []]);
				$carrito['cantidad'] = $cant;


				$cantidad = $carrito['cantidad'];
				$cantidadmax = $carrito['compra_max'];
				if ($cantidad > $cantidadmax && $this->request->session()->read('Auth.User.grupo') != 33 && $this->request->session()->read('Auth.User.grupo') != 1)
					$carrito['cantidad'] = $cantidadmax;

				if ($this->Carritos->save($carrito)) {
					if ($cantidad > $cantidadmax && $this->request->session()->read('Auth.User.grupo') != 33 && $this->request->session()->read('Auth.User.grupo') != 1)
						$this->Flash->success('Se modifico el carro correctamente. Solo ' . $cantidadmax . ' unidades', ['key' => 'changepass']);
					else
						$this->Flash->success('Se modifico el carro correctamente.', ['key' => 'changepass']);
				} else {
					$this->Flash->error('No se pudo agregar al carro de compras. Intente de nuevo3', ['key' => 'changepass']);
				}
			}
		}
	}
	public function hotsale_search($termsearch = null, $termsearchlab = null)
	{
		if ($this->request->is('post')) {



			if ($this->request->data['monodroga_id'] != null) {
				$monodrogaid = $this->request->data['monodroga_id'];
			} else {
				$monodrogaid = 0;
			}
			if ($this->request->data['accionfar_id'] != null) {
				$accionfarid = $this->request->data['accionfar_id'];
			} else {
				$accionfarid = 0;
			}

			if (!empty($this->request->data['categoria_id'])) {
				$categoriaid = $this->request->data['categoria_id'];
			} else {
				$categoriaid = 0;
			}
			if (!empty($this->request->data['laboratorio_id'])) {
				$laboratorioid = $this->request->data['laboratorio_id'];
			} else {
				$laboratorioid = 0;
			}
			if (!empty($this->request->data['ofertas'])) {
				$ofertas = $this->request->data['ofertas'];
			} else {
				$ofertas = 0;
			}

			if (empty($this->request->data['codigobarras'])) {
				$codigobarras = 0;
			} else
				$codigobarras = 1;

			if ($this->request->data['terminobuscar'] != null) {
				$terminocompleto = explode(" ", $this->request->data['terminobuscar']);
				$termsearch = "";
				if (count($terminocompleto) > 1) {
					foreach ($terminocompleto as $terminosimple) :
						$termsearch = $termsearch . '%' . $terminosimple . '%';
					endforeach;
				} else
					$termsearch = '%' . $terminocompleto[0] . '%';
			} else {
				$termsearch = "";
			}
			$this->request->session()->write('codigobarras', $codigobarras);
			$this->request->session()->write('ofertas', $ofertas);
			$this->request->session()->write('termsearch', $termsearch);
			$this->request->session()->write('categoriaid', $categoriaid);
			$this->request->session()->write('laboratorioid', $laboratorioid);
			$this->request->session()->write('monodrogaid', $monodrogaid);
			$this->request->session()->write('accionfarid', $accionfarid);
		} else {

			$monodrogaid = 0;
			$accionfarid = 0;
			$laboratorioid = 0; //$this->request->session()->read('laboratorioid');
			if (!empty($this->request->session()->read('laboratorioid')))
				$laboratorioid = $this->request->session()->read('laboratorioid');

			if (!empty($this->request->session()->read('accionfarid')))
				$accionfarid = $this->request->session()->read('accionfarid');
			if (!empty($this->request->session()->read('monodrogaid')))
				$monodrogaid = $this->request->session()->read('monodrogaid');



			$categoriaid = $this->request->session()->read('categoriaid');


			$ofertas = $this->request->session()->read('ofertas');
			$codigobarras  =  $this->request->session()->read('codigobarras');
			$termsearch = "";
			if (!empty($this->request->session()->read('termsearch')))
				$termsearch = $this->request->session()->read('termsearch');


			if (!empty($this->request->getParam('pass'))) {


				$terminocompleto = explode(" ", $this->request->getParam('pass')[0]);
				$termsearch = "";
				if (count($terminocompleto) > 1) {
					foreach ($terminocompleto as $terminosimple) :
						$termsearch = $termsearch . '%' . $terminosimple . '%';
					endforeach;
				} else
					$termsearch = '%' . $terminocompleto[0] . '%';

				//$this->request->getParam('pass');
				if (empty($this->request->getParam('pass')[1]))
					$termsearchlab = "";
				else
					$laboratorioid = $termsearchlab;
			}
		}

		$this->categoriaylaboratorio();
		$this->clientecredito();
		$this->sumacarrito();
		$this->monodrogayaccionterapeutica();


		if ($codigobarras && $termsearch != "") {

			$this->CargarCarritoCB($termsearch);
		}

		$this->viewBuilder()->layout('store');

		$this->loadModel('Articulos');

		$fecha = Time::now();
		//$fecha->i18nFormat('YYYY-MM-dd');
		$articulosA = $this->Articulos->find()
			->contain([
				'Descuentos' => [
					'queryBuilder' => function ($q) {
						return $q->where(['tipo_oferta <> "FP"', 'tipo_oferta in ("RV","RR","OR","TD","RL","HS","FR,"PS")', 'tipo_oferta <> "VC"']); // Full conditions for filtering
					}


				], 'Carritos' => [

					'queryBuilder' => function ($q) {
						return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); // Full conditions for filtering
					}
				]
			])
			->hydrate(false)
			->join(
				[
					'table' => 'descuentos',
					'alias' => 'd',
					'type' => 'LEFT',
					'conditions' => [
						'd.articulo_id = Articulos.id',
						'd.tipo_venta = "D"',
						'd.fecha_hasta >=' => $fecha->i18nFormat('yyyy-MM-dd'),
						'd.tipo_oferta in ("RV","RR","OR","TD","RL","HS","FR","PS")'
					]
				]
			);
		//->where(['eliminado'=>0]);

		//'conditions' => 'd.articulo_id = Articulos.id and CURRENT_DATE() <= d.fecha_hasta and d.tipo_venta in ("D ","  ")',




		if ($termsearch != "") {
			$articulosA->andWhere(['Articulos.descripcion_pag LIKE' => $termsearch]);
			/*
					'OR' => [['Articulos.descripcion_pag LIKE'=>$termsearch]
					//['Articulos.troquel LIKE'=>$termsearch],['Articulos.codigo_barras LIKE'=>$termsearch],['Articulos.codigo_barras2 LIKE'=>$termsearch]],
					]);
			*/
			if ($monodrogaid != 0) {
				$this->loadModel('AlfabetaArticulosExtras');
				$listadomonodrogaid = $this->AlfabetaArticulosExtras->find('all')->select(['articulo_id'])->where(['alfabeta_monodroga_id' => $monodrogaid, 'articulo_id>0']);

				$this->set('listadomonodrogaid', $listadomonodrogaid->toArray());
				$articulosA->andWhere(['Articulos.id in' => $listadomonodrogaid]);
			}
			if ($accionfarid != 0) {
				$this->loadModel('AlfabetaArticulosExtras');
				$listadoaccionfarid = $this->AlfabetaArticulosExtras->find('all')->select(['articulo_id'])->where(['alfabeta_accion_far_id' => $accionfarid, 'articulo_id>0']);

				$this->set('listadoaccionfarid', $listadoaccionfarid->toArray());
				$articulosA->andWhere(['Articulos.id in' => $listadoaccionfarid]);
			}


			if (($categoriaid != 0) && ($laboratorioid != 0)) {
				$articulosA->andWhere(['Articulos.laboratorio_id' => $laboratorioid])
					->andWhere(['Articulos.categoria_id' => $categoriaid]);
			} else {
				if ($laboratorioid != 0) {
					$articulosA->andWhere(['Articulos.laboratorio_id' => $laboratorioid]);
				} else {
					if ($categoriaid != 0) {
						$articulosA->andWhere(['Articulos.categoria_id' => $categoriaid]);
					}
					/*else
					{	
						$articulosA->orWhere(['Articulos.codigo_barras LIKE'=>$termsearch]);
						
					}*/
				}
			}
		} else {
			if (($categoriaid != 0) && ($laboratorioid != 0)) {
				$articulosA->where(['Articulos.laboratorio_id' => $laboratorioid])
					->where(['Articulos.categoria_id' => $categoriaid]);
			} else {
				if ($monodrogaid != 0) {
					$this->loadModel('AlfabetaArticulosExtras');
					$listadomonodrogaid = $this->AlfabetaArticulosExtras->find('all')->select(['articulo_id'])->where(['alfabeta_monodroga_id' => $monodrogaid, 'articulo_id>0']);

					$this->set('listadomonodrogaid', $listadomonodrogaid->toArray());
					$articulosA->andWhere(['Articulos.id in' => $listadomonodrogaid]);
				}
				if ($accionfarid != 0) {
					$this->loadModel('AlfabetaArticulosExtras');
					$listadoaccionfarid = $this->AlfabetaArticulosExtras->find('all')->select(['articulo_id'])->where(['alfabeta_accion_far_id' => $accionfarid, 'articulo_id>0']);

					$this->set('listadoaccionfarid', $listadoaccionfarid->toArray());
					$articulosA->andWhere(['Articulos.id in' => $listadoaccionfarid]);
				}




				if ($laboratorioid != 0) {
					$articulosA->where(['Articulos.laboratorio_id' => $laboratorioid]);
				} else {
					if ($categoriaid != 0) {
						$articulosA->where(['Articulos.categoria_id' => $categoriaid]);
					} else {
						if ($monodrogaid == 0 && $accionfarid == 0 && $ofertas == 0 && $laboratorioid == 0 && $categoriaid == 0) {
							$articulosA = null;
							$this->redirect($this->referer());
						}
					}
				}
			}
		}
		if ($ofertas != 0) {
			if ($ofertas == 1) {
				$articulosA->andWhere([

					'OR' => [
						['d.tipo_oferta' => "RR"],
						['d.tipo_oferta' => "RV"],
						['d.tipo_oferta' => "RL"],
						['d.tipo_oferta' => "HS"],
						['d.tipo_oferta' => "FR"],
						['d.tipo_oferta' => "PS"]
					],
				]);
			} else
			if ($ofertas == 2) {
				$articulosA->andWhere([

					'OR' => [
						['d.tipo_oferta' => "OR"],
						['d.tipo_oferta' => "TD"]
					],
				]);
			} else
			if ($ofertas == 3) {
				$articulosA->andWhere([

					'OR' => [
						['d.tipo_oferta' => "OR"],
						['d.tipo_oferta' => "TD"],
						['d.tipo_oferta' => "RR"],
						['d.tipo_oferta' => "RV"],
						['d.tipo_oferta' => "RL"],
						['d.tipo_oferta' => "HS"],
						['d.tipo_oferta' => "FR"],
						['d.tipo_oferta' => "PS"]
					]
				]);
			}
		}


		if ($articulosA != null) {
			if ($this->request->session()->read('Auth.User.venta_restringida') > 0) {
				$articulosA->andWhere(['Articulos.venta_restringida' => 0]);
			}

			$articulosA->andWhere(['Articulos.eliminado' => 0])->group(['Articulos.id']);
			$limit = 25;
			if ($articulosA->count() < 100 && $articulosA->count() > 50) {
				$limit = 50;
			}
			if ($articulosA->count() > 100) {
				$limit = 70;
			}

			$this->paginate = [
				'contain' => ['Carritos'],
				'limit' => $limit,
				'offset' => 0,
				'order' => ['Articulos.descripcion_pag' => 'asc']
			];


			$articulos = $this->paginate($articulosA);
		} else
			$articulos = null;
		$this->set(compact('articulos'));

		$this->loadModel('Publications');
		$publicationsearch = $this->Publications->find('all')->where(['fecha_hasta >=CURRENT_DATE()', 'habilitada' => '1', 'ubicacion' => '7'])->order(['id' => 'DESC'])->all();

		$this->set('publicationsearch', $publicationsearch->toArray());
		$this->request->session()->write('publicationsearch', $publicationsearch->toArray());
	}



	public function search($termsearch = null, $termsearchlab = null)
	{
		if ($this->request->is('post')) {

			if ($this->request->data['monodroga_id'] != null) {
				$monodrogaid = $this->request->data['monodroga_id'];
			} else {
				$monodrogaid = 0;
			}
			$barratexto = 0;
			if(isset($this->request->data['search_barra_texto'])){
			if ($this->request->data['search_barra_texto'] == 1) {
				$barratexto = 1;
			} else {
				$barratexto = 0;
			}
		}

			if ($this->request->data['accionfar_id'] != null) {
				$accionfarid = $this->request->data['accionfar_id'];
			} else {
				$accionfarid = 0;
			}

			if (!empty($this->request->data['categoria_id'])) {
				$categoriaid = $this->request->data['categoria_id'];
			} else {
				$categoriaid = 0;
			}
			if (!empty($this->request->data['laboratorio_id'])) {
				$laboratorioid = $this->request->data['laboratorio_id'];
			} else {
				$laboratorioid = 0;
			}
			if (!empty($this->request->data['ofertas'])) {
				$ofertas = $this->request->data['ofertas'];
			} else {
				$ofertas = 0;
			}

			if (empty($this->request->data['codigobarras'])) {
				$codigobarras = 0;
			} else
				$codigobarras = 1;

			if ($this->request->data['terminobuscar'] != null) {
				$terminobuscar = str_replace("'", "", $this->request->data['terminobuscar']);
				$terminocompleto = explode(" ", $terminobuscar);
				$termsearch = "";
				$palabral6 = "";
				if (count($terminocompleto) > 1) {
					foreach ($terminocompleto as $terminosimple) :
						$termsearch = $termsearch . '%' . $terminosimple . '%';
						if (strlen($terminosimple) > 5) {
							$palabral6 = $palabral6 . '%' . mb_substr($terminosimple, 0, -1) . '%';
						}

					endforeach;
				} else {
					$termsearch = '%' . $terminocompleto[0] . '%';
					if (strlen($terminocompleto[0]) > 5) {
						$palabral6 = $palabral6 . '%' . mb_substr($terminocompleto[0], 0, -1) . '%';
					}
				}
			} else {
				$terminocompleto = "";
				$termsearch = "";
				$palabral6 = "";
				$terminobuscar = "";
			}


			$this->request->session()->write('busqueda.codigobarras', $codigobarras);
			$this->request->session()->write('busqueda.ofertas', $ofertas);
			$this->request->session()->write('busqueda.termsearch', $termsearch);

			$this->request->session()->write('busqueda.palabral6', $palabral6);
			$this->request->session()->write('busqueda.terminobuscar', $terminobuscar);

			$this->request->session()->write('busqueda.categoriaid', $categoriaid);
			$this->request->session()->write('busqueda.laboratorioid', $laboratorioid);
			$this->request->session()->write('busqueda.monodrogaid', $monodrogaid);
			$this->request->session()->write('busqueda.accionfarid', $accionfarid);
		} else {
			            $variablesort = $this->request->getQuery('sort');

			$monodrogaid = 0;
			$accionfarid = 0;
			$laboratorioid = 0;
			$barratexto=0;
			 //$this->request->session()->read('laboratorioid');
			if (!empty($this->request->session()->read('busqueda.laboratorioid')))
				$laboratorioid = $this->request->session()->read('busqueda.laboratorioid');

			if (!empty($this->request->session()->read('busqueda.accionfarid')))
				$accionfarid = $this->request->session()->read('busqueda.accionfarid');
			if (!empty($this->request->session()->read('busqueda.monodrogaid')))
				$monodrogaid = $this->request->session()->read('busqueda.monodrogaid');



			$categoriaid = $this->request->session()->read('busqueda.categoriaid');


			$ofertas = $this->request->session()->read('busqueda.ofertas');
			$codigobarras  =  $this->request->session()->read('busqueda.codigobarras');
			$termsearch = "";
			if (!empty($this->request->session()->read('busqueda.termsearch'))) {
				$termsearch = $this->request->session()->read('busqueda.termsearch');
				$terminobuscar = $this->request->session()->read('busqueda.terminobuscar');
				$palabral6 = $this->request->session()->read('busqueda.palabral6');
			}


			if (!empty($this->request->getParam('pass'))) {
				$terminobuscar = str_replace("'", "", $this->request->getParam('pass')[0]);
				$terminocompleto = explode(" ", $terminobuscar);
				$termsearch = "";
				$palabral6 = "";
				if (count($terminocompleto) > 1) {
					foreach ($terminocompleto as $terminosimple) :
						$termsearch = $termsearch . '%' . $terminosimple . '%';
						if (strlen($terminosimple) > 5) {
							$palabral6 = $palabral6 . '%' . mb_substr($terminosimple, 0, -1) . '%';
						}

					endforeach;
				} else {
					$termsearch = '%' . $terminocompleto[0] . '%';
					if (strlen($terminocompleto[0]) > 5) {
						$palabral6 = $palabral6 . '%' . mb_substr($terminocompleto[0], 0, -1) . '%';
					}
				}
				if (empty($this->request->getParam('pass')[1]))
					$termsearchlab = "";
				else
					$laboratorioid = $termsearchlab;
			}
		}


		/*
		if ($codigobarras && $termsearch!="")
			{
				
				$this->CargarCarritoCB($termsearch);
			}		
			*/

		$this->categoriaylaboratorio();
		$this->clientecredito();
		$this->sumacarrito();
		$this->monodrogayaccionterapeutica();

		$this->viewBuilder()->layout('store');

		$this->loadModel('Articulos');

		$clienteid = $this->request->session()->read('Auth.User.cliente_id');

		$fecha = Time::now();
		//$fecha->i18nFormat('YYYY-MM-dd');

		if ($this->request->session()->read('Auth.User.farmapoint')) {

			$articulosA = $this->Articulos->find()
				->contain([
					'Descuentos' => [
						'queryBuilder' => function ($q) {
							return $q->where(['tipo_oferta <> "VC"']); // Full conditions for filtering
						}
						//'tipo_oferta in ("RV","RR","OR","TD","RL","HS","FR","TH","TD")',

					], 'Carritos' => [

						'queryBuilder' => function ($q) {
							return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); // Full conditions for filtering
						}
					]
				])
				->hydrate(false)
				->join(
					[
						'table' => 'descuentos',
						'alias' => 'd',
						'type' => 'LEFT',
						'conditions' => [
							'd.articulo_id = Articulos.id',
							'd.tipo_venta = "D"',
							'd.fecha_hasta >=' => $fecha->i18nFormat('yyyy-MM-dd'),
							'd.tipo_oferta in ("RV","RR","OR","TD","RL","HS","FR","TH","PS","FP")'
						]
					]
				);
		} else {
			$articulosA = $this->Articulos->find()
				->contain([
					'Descuentos' => [
						'queryBuilder' => function ($q) {
							return $q->where(['tipo_oferta <> "FP"', 'tipo_oferta <> "VC"']); // Full conditions for filtering
						}
						//'tipo_oferta in ("RV","RR","OR","TD","RL","HS","FR","TH","TD")',

					], 'Carritos' => [

						'queryBuilder' => function ($q) {
							return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); // Full conditions for filtering
						}
					]
				])
				->hydrate(false)
				->join(
					[
						'table' => 'descuentos',
						'alias' => 'd',
						'type' => 'LEFT',
						'conditions' => [
							'd.articulo_id = Articulos.id',
							'd.tipo_venta = "D"',
							'd.fecha_hasta >=' => $fecha->i18nFormat('yyyy-MM-dd'),
							'd.tipo_oferta in ("RV","RR","OR","TD","RL","HS","FR","TH","PS")'
						]
					]
				);
		}


		if ($termsearch != "") {
			if ($codigobarras != 0) {
				if ($barratexto == 1) {

					$articulosA->where(['OR' => [
						['Articulos.codigo_barras LIKE' => $termsearch], ['Articulos.codigo_barras2 LIKE' => $termsearch],
						['Articulos.descripcion_pag LIKE' => $termsearch], ['Articulos.descripcion_pag LIKE' => $palabral6],
						['Articulos.codigo_barras3 LIKE' => $termsearch], ['REPLACE(Articulos.troquel,"-","") LIKE ' => $termsearch],
						['Articulos.troquel LIKE' => $termsearch]
					], 'eliminado' => 0])->order('(CASE WHEN Articulos.descripcion_pag LIKE \'' . $terminobuscar . '%\' then 1 
				WHEN Articulos.descripcion_pag LIKE \'%' . $terminobuscar . '%\' then 2
				WHEN Articulos.descripcion_pag LIKE \'%' . $termsearch . '%\' then 3
				WHEN Articulos.descripcion_pag LIKE \'' . $palabral6 . '%\' then 4  else 5 END)');
					$agregarcantidadbarras = 0;
				} else {
					$articulosA->where(['OR' => [['Articulos.codigo_barras LIKE' => $termsearch], ['Articulos.codigo_barras2 LIKE' => $termsearch], ['Articulos.codigo_barras3 LIKE' => $termsearch]], 'eliminado' => 0])
						->first();

					if ($articulosA->isEmpty()) {
						$agregarcantidadbarras = 0;
						$this->set("codigobarras", 1);
					} else {
						$this->set("codigobarras", 1);
						$agregarcantidadbarras = 1;
					}
				}



				$this->set("agregarcantidadbarras", $agregarcantidadbarras);
			} else
				if(empty($variablesort)){
					$articulosA->andwhere(['OR' => [
					['Articulos.descripcion_pag LIKE' => $termsearch], ['Articulos.descripcion_pag LIKE' => $palabral6], ['Articulos.codigo_barras LIKE' => $termsearch], ['Articulos.codigo_barras2 LIKE' => $termsearch], ['Articulos.codigo_barras3 LIKE' => $termsearch], ['REPLACE(Articulos.troquel,"-","") LIKE ' => $termsearch],
					['Articulos.troquel LIKE' => $termsearch]
				], 'eliminado' => 0])
					->order('(CASE WHEN Articulos.descripcion_pag LIKE \'' . $terminobuscar . '%\' then 1 
				WHEN Articulos.descripcion_pag LIKE \'%' . $terminobuscar . '%\' then 2
				WHEN Articulos.descripcion_pag LIKE \'%' . $termsearch . '%\' then 3
				WHEN Articulos.descripcion_pag LIKE \'' . $palabral6 . '%\' then 4  else 5 END)');
				}else{
										
			$articulosA->andwhere(['OR' => [
								['Articulos.descripcion_pag LIKE' => $termsearch], ['Articulos.descripcion_pag LIKE' => $palabral6], ['Articulos.codigo_barras LIKE' => $termsearch], ['Articulos.codigo_barras2 LIKE' => $termsearch], ['Articulos.codigo_barras3 LIKE' => $termsearch], ['REPLACE(Articulos.troquel,"-","") LIKE ' => $termsearch],
								['Articulos.troquel LIKE' => $termsearch]
							], 'eliminado' => 0]);


				}
				/*
				$articulosA->andWhere([
					
					'OR' => [['Articulos.descripcion_pag LIKE'=>$termsearch], ['REPLACE(Articulos.troquel,"-","") LIKE '=>$termsearch],
					['Articulos.troquel LIKE'=>$termsearch],['Articulos.codigo_barras LIKE'=>$termsearch],['Articulos.codigo_barras2 LIKE'=>$termsearch]],
				]);*/

			if ($monodrogaid != 0) {
				$this->loadModel('AlfabetaArticulosExtras');
				$listadomonodrogaid = $this->AlfabetaArticulosExtras->find('all')->select(['articulo_id'])->where(['alfabeta_monodroga_id' => $monodrogaid, 'articulo_id>0']);

				$this->set('listadomonodrogaid', $listadomonodrogaid->toArray());
				$articulosA->andWhere(['Articulos.id in' => $listadomonodrogaid]);
			}
			if ($accionfarid != 0) {
				$this->loadModel('AlfabetaArticulosExtras');
				$listadoaccionfarid = $this->AlfabetaArticulosExtras->find('all')->select(['articulo_id'])->where(['alfabeta_accion_far_id' => $accionfarid, 'articulo_id>0']);

				$this->set('listadoaccionfarid', $listadoaccionfarid->toArray());
				$articulosA->andWhere(['Articulos.id in' => $listadoaccionfarid]);
			}


			if (($categoriaid != 0) && ($laboratorioid != 0)) {
				$articulosA->andWhere(['Articulos.laboratorio_id' => $laboratorioid])
					->andWhere(['Articulos.categoria_id' => $categoriaid]);
			} else {
				if ($laboratorioid != 0) {
					$articulosA->andWhere(['Articulos.laboratorio_id' => $laboratorioid]);
				} else {
					if ($categoriaid != 0) {
						$articulosA->andWhere(['Articulos.categoria_id' => $categoriaid]);
					} else {
						$articulosA->orWhere(['Articulos.codigo_barras LIKE' => $termsearch]);
					}
				}
			}

			if ($this->request->session()->read('Auth.User.grupo') == 30)
				$articulosA->andwhere('Articulos.id <>102940');
		} else {
			if (($categoriaid != 0) && ($laboratorioid != 0)) {
				$articulosA->where(['Articulos.laboratorio_id' => $laboratorioid])
					->where(['Articulos.categoria_id' => $categoriaid]);
			} else {
				if ($monodrogaid != 0) {
					$this->loadModel('AlfabetaArticulosExtras');
					$listadomonodrogaid = $this->AlfabetaArticulosExtras->find('all')->select(['articulo_id'])->where(['alfabeta_monodroga_id' => $monodrogaid, 'articulo_id>0']);

					$this->set('listadomonodrogaid', $listadomonodrogaid->toArray());
					$articulosA->andWhere(['Articulos.id in' => $listadomonodrogaid]);
				}
				if ($accionfarid != 0) {
					$this->loadModel('AlfabetaArticulosExtras');
					$listadoaccionfarid = $this->AlfabetaArticulosExtras->find('all')->select(['articulo_id'])->where(['alfabeta_accion_far_id' => $accionfarid, 'articulo_id>0']);

					$this->set('listadoaccionfarid', $listadoaccionfarid->toArray());
					$articulosA->andWhere(['Articulos.id in' => $listadoaccionfarid]);
				}




				if ($laboratorioid != 0) {
					$articulosA->where(['Articulos.laboratorio_id' => $laboratorioid]);
				} else {
					if ($categoriaid != 0) {
						$articulosA->where(['Articulos.categoria_id' => $categoriaid]);
					} else {
						if ($monodrogaid == 0 && $accionfarid == 0 && $ofertas == 0 && $laboratorioid == 0 && $categoriaid == 0) {
							$articulosA = null;
							$this->redirect($this->referer());
						}
					}
				}
			}
		}
		if ($ofertas != 0) {
			if ($ofertas == 1) {
				$articulosA->andWhere([

					'OR' => [
						['d.tipo_oferta' => "RR"],
						['d.tipo_oferta' => "RV"],
						['d.tipo_oferta' => "RL"],
						['d.tipo_oferta' => "HS"],
						['d.tipo_oferta' => "FR"],
						['d.tipo_oferta' => "PS"]
					],
				]);
			} else
			if ($ofertas == 2) {
				$articulosA->andWhere([

					'OR' => [
						['d.tipo_oferta' => "OR"],
						['d.tipo_oferta' => "TD"]
					],
				]);
			} else
			if ($ofertas == 3) {
				$articulosA->andWhere([

					'OR' => [
						['d.tipo_oferta' => "OR"],
						['d.tipo_oferta' => "TD"],
						['d.tipo_oferta' => "RR"],
						['d.tipo_oferta' => "RV"],
						['d.tipo_oferta' => "RL"],
						['d.tipo_oferta' => "HS"],
						['d.tipo_oferta' => "FR"],
						['d.tipo_oferta' => "PS"]
					]
				]);
			}
		}


		if ($articulosA != null) {
			if ($this->request->session()->read('Auth.User.venta_restringida') > 0) {
				$articulosA->andWhere(['Articulos.venta_restringida' => 0]);
			}

			$articulosA->andWhere(['Articulos.eliminado' => 0])->group(['Articulos.id']);
			$limit = 100;
			if ($articulosA->count() < 100 && $articulosA->count() > 50) {
				$limit = 100;
			}
			if ($articulosA->count() > 100) {
				$limit = 200;
			}

			$this->paginate = [
				'contain' => ['Carritos'],
				'limit' => $limit,
				'maxLimit' => $limit,
				'offset' => 0,
				'order' => ['Articulos.descripcion_pag' => 'asc']
			];


			$articulos = $this->paginate($articulosA);
		} else
			$articulos = null;
		$this->set(compact('articulos'));

		$this->loadModel('Publications');
		$publicationsearch = $this->Publications->find('all')->where(['fecha_hasta >=CURRENT_DATE()', 'habilitada' => '1', 'ubicacion' => '7'])->order(['orden' => 'ASC'])->all();

		$this->set('publicationsearch', $publicationsearch->toArray());
		$this->request->session()->write('publicationsearch', $publicationsearch->toArray());

		$publicationzocalo = $this->Publications->find('all')->where(['fecha_hasta >=CURRENT_DATE()', 'habilitada' => '1', 'ubicacion' => '13'])->order(['orden' => 'ASC'])->all();
		$this->set('banner_slider', $publicationzocalo->toArray());
		$this->request->session()->write('banner_slider', $publicationzocalo->toArray());

		$this->set('banner_slider', $this->request->session()->read('banner_slider'));
	}

	public function search_ajax($termsearch = null, $termsearchlab = null)
	{
		if ($this->request->is('post', 'ajax')) {



			if ($this->request->data['monodroga_id'] != null) {
				$monodrogaid = $this->request->data['monodroga_id'];
			} else {
				$monodrogaid = 0;
			}
			if (isset($this->request->data['search_barra_texto'])) {
				if ($this->request->data['search_barra_texto'] == 1) {
					$barratexto = 1;
				} else {
					$barratexto = 0;
				}
			} else {
				$barratexto = 0;
			}

			if ($this->request->data['accionfar_id'] != null) {
				$accionfarid = $this->request->data['accionfar_id'];
			} else {
				$accionfarid = 0;
			}

			if (!empty($this->request->data['categoria_id'])) {
				$categoriaid = $this->request->data['categoria_id'];
			} else {
				$categoriaid = 0;
			}
			if (!empty($this->request->data['laboratorio_id'])) {
				$laboratorioid = $this->request->data['laboratorio_id'];
			} else {
				$laboratorioid = 0;
			}
			if (!empty($this->request->data['ofertas'])) {
				$ofertas = $this->request->data['ofertas'];
			} else {
				$ofertas = 0;
			}

			$codigobarras = $this->request->data['codigobarras'];


			if ($this->request->data['terminobuscar'] != null) {
				$terminobuscar = str_replace("'", "", $this->request->data['terminobuscar']);
				$terminocompleto = explode(" ", $terminobuscar);
				$termsearch = "";
				$palabral6 = "";
				if (count($terminocompleto) > 1) {
					foreach ($terminocompleto as $terminosimple) :
						$termsearch = $termsearch . '%' . $terminosimple . '%';
						if (strlen($terminosimple) > 5) {
							$palabral6 = $palabral6 . '%' . mb_substr($terminosimple, 0, -1) . '%';
						}

					endforeach;
				} else {
					$termsearch = '%' . $terminocompleto[0] . '%';
					if (strlen($terminocompleto[0]) > 5) {
						$palabral6 = $palabral6 . '%' . mb_substr($terminocompleto[0], 0, -1) . '%';
					}
				}
			} else {
				$terminocompleto = "";
				$termsearch = "";
				$palabral6 = "";
				$terminobuscar = "";
			}


			$this->request->session()->write('busqueda.codigobarras', $codigobarras);
			$this->request->session()->write('busqueda.ofertas', $ofertas);
			$this->request->session()->write('busqueda.termsearch', $termsearch);
			$this->request->session()->write('busqueda.palabral6', $palabral6);
			$this->request->session()->write('busqueda.terminobuscar', $terminobuscar);
			$this->request->session()->write('busqueda.categoriaid', $categoriaid);
			$this->request->session()->write('busqueda.laboratorioid', $laboratorioid);
			$this->request->session()->write('busqueda.monodrogaid', $monodrogaid);
			$this->request->session()->write('busqueda.accionfarid', $accionfarid);
		} else {
			$variablesort = $this->request->getQuery('sort');
			$monodrogaid = 0;
			$accionfarid = 0;
			$laboratorioid = 0; //$this->request->session()->read('laboratorioid');
			if (!empty($this->request->session()->read('busqueda.laboratorioid')))
				$laboratorioid = $this->request->session()->read('busqueda.laboratorioid');
			if (!empty($this->request->session()->read('busqueda.accionfarid')))
				$accionfarid = $this->request->session()->read('busqueda.accionfarid');
			if (!empty($this->request->session()->read('busqueda.monodrogaid')))
				$monodrogaid = $this->request->session()->read('busqueda.monodrogaid');

			$categoriaid = $this->request->session()->read('busqueda.categoriaid');
			$ofertas = $this->request->session()->read('busqueda.ofertas');
			$codigobarras  =  $this->request->session()->read('busqueda.codigobarras');
			$termsearch = "";
			if (!empty($this->request->session()->read('busqueda.termsearch'))) {
				$termsearch = $this->request->session()->read('busqueda.termsearch');
				$terminobuscar = $this->request->session()->read('busqueda.terminobuscar');
				$palabral6 = $this->request->session()->read('busqueda.palabral6');
			}


			if (!empty($this->request->getParam('pass'))) {
				$terminobuscar = str_replace("'", "", $this->request->getParam('pass')[0]);
				$terminocompleto = explode(" ", $terminobuscar);
				$termsearch = "";
				$palabral6 = "";
				if (count($terminocompleto) > 1) {
					foreach ($terminocompleto as $terminosimple) :
						$termsearch = $termsearch . '%' . $terminosimple . '%';
						if (strlen($terminosimple) > 5) {
							$palabral6 = $palabral6 . '%' . mb_substr($terminosimple, 0, -1) . '%';
						}

					endforeach;
				} else {
					$termsearch = '%' . $terminocompleto[0] . '%';
					if (strlen($terminocompleto[0]) > 5) {
						$palabral6 = $palabral6 . '%' . mb_substr($terminocompleto[0], 0, -1) . '%';
					}
				}
				if (empty($this->request->getParam('pass')[1]))
					$termsearchlab = "";
				else
					$laboratorioid = $termsearchlab;
			}
		}

		//proceso de cargar carritocb cuando viene con codigo de barras	
		/* 

		if ($codigobarras && $termsearch!="")
			{
				
				//$this->CargarCarritoCB($termsearch);
			}			
				*/
		$this->categoriaylaboratorio();
		$this->clientecredito();
		$this->sumacarrito();
		$this->monodrogayaccionterapeutica();

		$this->viewBuilder()->layout('ajax');

		$this->loadModel('Articulos');

		$clienteid = $this->request->session()->read('Auth.User.cliente_id');

		$fecha = Time::now();
		//$fecha->i18nFormat('YYYY-MM-dd');

		if ($this->request->session()->read('Auth.User.farmapoint')) {
			$articulosA = $this->Articulos->find()
				->contain([
					'Descuentos' => [
						'queryBuilder' => function ($q) {
							return $q->where(['tipo_oferta <> "VC"']); // Full conditions for filtering
						}
						//'tipo_oferta in ("RV","RR","OR","TD","RL","HS","FR","TH","TD")',

					], 'Carritos' => [

						'queryBuilder' => function ($q) {
							return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); // Full conditions for filtering
						}
					]
				])
				->hydrate(false)
				->join(
					[
						'table' => 'descuentos',
						'alias' => 'd',
						'type' => 'LEFT',
						'conditions' => [
							'd.articulo_id = Articulos.id',
							'd.tipo_venta = "D"',
							'd.fecha_hasta >=' => $fecha->i18nFormat('yyyy-MM-dd'),
							'd.tipo_oferta in ("RV","RR","OR","TD","RL","HS","FR","TH","PS","FP")'
						]
					]
				);
		} else {
			$articulosA = $this->Articulos->find()
				->contain([
					'Descuentos' => [
						'queryBuilder' => function ($q) {
							return $q->where(['tipo_oferta <> "FP"', 'tipo_oferta <> "VC"']); // Full conditions for filtering
						}
						//'tipo_oferta in ("RV","RR","OR","TD","RL","HS","FR","TH","TD")',

					], 'Carritos' => [

						'queryBuilder' => function ($q) {
							return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); // Full conditions for filtering
						}
					]
				])
				->hydrate(false)
				->join(
					[
						'table' => 'descuentos',
						'alias' => 'd',
						'type' => 'LEFT',
						'conditions' => [
							'd.articulo_id = Articulos.id',
							'd.tipo_venta = "D"',
							'd.fecha_hasta >=' => $fecha->i18nFormat('yyyy-MM-dd'),
							'd.tipo_oferta in ("RV","RR","OR","TD","RL","HS","FR","TH","PS")'
						]
					]
				);
		}


		if ($termsearch != "") {

			if ($codigobarras != 0) {

				if ($barratexto == 1) {

					$articulosA->where(['OR' => [
						['Articulos.codigo_barras LIKE' => $termsearch], ['Articulos.codigo_barras2 LIKE' => $termsearch], ['Articulos.descripcion_pag LIKE' => $termsearch], ['Articulos.descripcion_pag LIKE' => $palabral6],
						['Articulos.codigo_barras3 LIKE' => $termsearch], ['REPLACE(Articulos.troquel,"-","") LIKE ' => $termsearch],
						['Articulos.troquel LIKE' => $termsearch]
					], 'eliminado' => 0])->order('(CASE WHEN Articulos.descripcion_pag LIKE \'' . $terminobuscar . '%\' then 1 
				WHEN Articulos.descripcion_pag LIKE \'%' . $terminobuscar . '%\' then 2
				WHEN Articulos.descripcion_pag LIKE \'%' . $termsearch . '%\' then 3
				WHEN Articulos.descripcion_pag LIKE \'' . $palabral6 . '%\' then 4  else 5 END)');
					$agregarcantidadbarras = 0;
				} else {
					$articulosA->where(['OR' => [['Articulos.codigo_barras LIKE' => $termsearch], ['Articulos.codigo_barras2 LIKE' => $termsearch], ['Articulos.codigo_barras3 LIKE' => $termsearch]], 'eliminado' => 0])
						->first();

					if ($articulosA->isEmpty()) {
						$agregarcantidadbarras = 0;
					} else {

						$agregarcantidadbarras = 1;
					}
				}



				$this->set("agregarcantidadbarras", $agregarcantidadbarras);
			} else
						if(empty($variablesort)){
							$articulosA->andwhere(['OR' => [
					['Articulos.descripcion_pag LIKE' => $termsearch], ['Articulos.descripcion_pag LIKE' => $palabral6], ['Articulos.codigo_barras LIKE' => $termsearch], ['Articulos.codigo_barras2 LIKE' => $termsearch], ['Articulos.codigo_barras3 LIKE' => $termsearch], ['REPLACE(Articulos.troquel,"-","") LIKE ' => $termsearch],
					['Articulos.troquel LIKE' => $termsearch]
				], 'eliminado' => 0])
					->order('(CASE WHEN Articulos.descripcion_pag LIKE \'' . $terminobuscar . '%\' then 1 
				WHEN Articulos.descripcion_pag LIKE \'%' . $terminobuscar . '%\' then 2
				WHEN Articulos.descripcion_pag LIKE \'%' . $termsearch . '%\' then 3
				WHEN Articulos.descripcion_pag LIKE \'' . $palabral6 . '%\' then 4  else 5 END)');
			}else{
				$articulosA->andwhere(['OR' => [
					['Articulos.descripcion_pag LIKE' => $termsearch], ['Articulos.descripcion_pag LIKE' => $palabral6], ['Articulos.codigo_barras LIKE' => $termsearch], ['Articulos.codigo_barras2 LIKE' => $termsearch], ['Articulos.codigo_barras3 LIKE' => $termsearch], ['REPLACE(Articulos.troquel,"-","") LIKE ' => $termsearch],
					['Articulos.troquel LIKE' => $termsearch]
				], 'eliminado' => 0]);


			}/*
				$articulosA->andWhere([
					
					'OR' => [['Articulos.descripcion_pag LIKE'=>$termsearch], ['REPLACE(Articulos.troquel,"-","") LIKE '=>$termsearch],
					['Articulos.troquel LIKE'=>$termsearch],['Articulos.codigo_barras LIKE'=>$termsearch],['Articulos.codigo_barras2 LIKE'=>$termsearch]],
				]);*/

			if ($monodrogaid != 0) {
				$this->loadModel('AlfabetaArticulosExtras');
				$listadomonodrogaid = $this->AlfabetaArticulosExtras->find('all')->select(['articulo_id'])->where(['alfabeta_monodroga_id' => $monodrogaid, 'articulo_id>0']);

				$this->set('listadomonodrogaid', $listadomonodrogaid->toArray());
				$articulosA->andWhere(['Articulos.id in' => $listadomonodrogaid]);
			}
			if ($accionfarid != 0) {
				$this->loadModel('AlfabetaArticulosExtras');
				$listadoaccionfarid = $this->AlfabetaArticulosExtras->find('all')->select(['articulo_id'])->where(['alfabeta_accion_far_id' => $accionfarid, 'articulo_id>0']);

				$this->set('listadoaccionfarid', $listadoaccionfarid->toArray());
				$articulosA->andWhere(['Articulos.id in' => $listadoaccionfarid]);
			}


			if (($categoriaid != 0) && ($laboratorioid != 0)) {
				$articulosA->andWhere(['Articulos.laboratorio_id' => $laboratorioid])
					->andWhere(['Articulos.categoria_id' => $categoriaid]);
			} else {
				if ($laboratorioid != 0) {
					$articulosA->andWhere(['Articulos.laboratorio_id' => $laboratorioid]);
				} else {
					if ($categoriaid != 0) {
						$articulosA->andWhere(['Articulos.categoria_id' => $categoriaid]);
					} else {
						$articulosA->orWhere(['Articulos.codigo_barras LIKE' => $termsearch]);
					}
				}
			}


			if ($this->request->session()->read('Auth.User.grupo') == 30)
				$articulosA->andwhere('Articulos.id <>102940');
		} else {
			if (($categoriaid != 0) && ($laboratorioid != 0)) {
				$articulosA->where(['Articulos.laboratorio_id' => $laboratorioid])
					->where(['Articulos.categoria_id' => $categoriaid]);
			} else {
				if ($monodrogaid != 0) {
					$this->loadModel('AlfabetaArticulosExtras');
					$listadomonodrogaid = $this->AlfabetaArticulosExtras->find('all')->select(['articulo_id'])->where(['alfabeta_monodroga_id' => $monodrogaid, 'articulo_id>0']);

					$this->set('listadomonodrogaid', $listadomonodrogaid->toArray());
					$articulosA->andWhere(['Articulos.id in' => $listadomonodrogaid]);
				}
				if ($accionfarid != 0) {
					$this->loadModel('AlfabetaArticulosExtras');
					$listadoaccionfarid = $this->AlfabetaArticulosExtras->find('all')->select(['articulo_id'])->where(['alfabeta_accion_far_id' => $accionfarid, 'articulo_id>0']);

					$this->set('listadoaccionfarid', $listadoaccionfarid->toArray());
					$articulosA->andWhere(['Articulos.id in' => $listadoaccionfarid]);
				}




				if ($laboratorioid != 0) {
					$articulosA->where(['Articulos.laboratorio_id' => $laboratorioid]);
				} else {
					if ($categoriaid != 0) {
						$articulosA->where(['Articulos.categoria_id' => $categoriaid]);
					} else {
						if ($monodrogaid == 0 && $accionfarid == 0 && $ofertas == 0 && $laboratorioid == 0 && $categoriaid == 0) {
							$articulosA = null;
							$this->redirect($this->referer());
						}
					}
				}
			}
		}
		if ($ofertas != 0) {
			if ($ofertas == 1) {
				$articulosA->andWhere([

					'OR' => [
						['d.tipo_oferta' => "RR"],
						['d.tipo_oferta' => "RV"],
						['d.tipo_oferta' => "RL"],
						['d.tipo_oferta' => "HS"],
						['d.tipo_oferta' => "FR"],
						['d.tipo_oferta' => "PS"]
					],
				]);
			} else
			if ($ofertas == 2) {
				$articulosA->andWhere([

					'OR' => [
						['d.tipo_oferta' => "OR"],
						['d.tipo_oferta' => "TD"]
					],
				]);
			} else
			if ($ofertas == 3) {
				$articulosA->andWhere([

					'OR' => [
						['d.tipo_oferta' => "OR"],
						['d.tipo_oferta' => "TD"],
						['d.tipo_oferta' => "RR"],
						['d.tipo_oferta' => "RV"],
						['d.tipo_oferta' => "RL"],
						['d.tipo_oferta' => "HS"],
						['d.tipo_oferta' => "FR"],
						['d.tipo_oferta' => "PS"]
					]
				]);
			}
		}


		if ($articulosA != null) {
			if ($this->request->session()->read('Auth.User.venta_restringida') > 0) {
				$articulosA->andWhere(['Articulos.venta_restringida' => 0]);
			}

			$articulosA->andWhere(['Articulos.eliminado' => 0])->group(['Articulos.id']);
			$limit = 100;
			if ($articulosA->count() < 100 && $articulosA->count() > 50) {
				$limit = 100;
			}
			if ($articulosA->count() > 100) {
				$limit = 1000;
			}

			$this->paginate = [
				'contain' => ['Carritos'],
				'limit' => $limit,
				'maxLimit' => $limit,
				'offset' => 0,
				'order' => ['Articulos.descripcion_pag' => 'asc']
			];

			$articulos = $this->paginate($articulosA);
		} else
			$articulos = null;
		$this->set(compact('articulos'));
		$this->loadModel('Publications');
		$publicationsearch = $this->Publications->find('all')->where(['fecha_hasta >=CURRENT_DATE()', 'habilitada' => '1', 'ubicacion' => '7'])->order(['id' => 'DESC'])->all();
		$this->set('publicationsearch', $publicationsearch->toArray());
		$this->request->session()->write('publicationsearch', $publicationsearch->toArray());

		$publicationzocalo = $this->Publications->find('all')->where(['fecha_hasta >=CURRENT_DATE()', 'habilitada' => '1', 'ubicacion' => '13'])->order(['id' => 'DESC'])->all();
		$this->set('banner_slider', $publicationzocalo->toArray());
		$this->request->session()->write('banner_slider', $publicationzocalo->toArray());

		$this->set('banner_slider', $this->request->session()->read('banner_slider'));
	}

	public function search_i($terms = null, $terms_lab = null, $terms_mult = null)
	{
		if ($this->request->is('post')) {
			if (!empty($this->request->data['laboratorio_id'])) {
				$laboratorioid = $this->request->data['laboratorio_id'];
			} else {
				$laboratorioid = 0;
			}

			if ($this->request->data['terms_mult'] != null) {
				$terms_m = $this->request->data['terms_mult'];
			} else
				$terms_m = "";

			if ($this->request->data['terminobuscar'] != null) {
				$terminocompleto = explode(" ", $this->request->data['terminobuscar']);
				$terms = "";
				if (count($terminocompleto) > 1) {
					foreach ($terminocompleto as $terminosimple) :
						$terms = $terms . '%' . $terminosimple . '%';
					endforeach;
				} else
					$terms = '%' . $terminocompleto[0] . '%';
			} else {
				$terms = "";
			}
			$this->request->session()->write('termsearch', $terms);
			$this->request->session()->write('laboratorioid', $laboratorioid);
		} else {


			$laboratorioid = 0; //$this->request->session()->read('laboratorioid');
			if (!empty($this->request->session()->read('laboratorioid')))
				$laboratorioid = $this->request->session()->read('laboratorioid');

			$terms_m = "";

			$terms = "";
			if (!empty($this->request->session()->read('termsearch')))
				$terms = $this->request->session()->read('termsearch');


			if (!empty($this->request->getParam('pass'))) {


				$terminocompleto = explode(" ", $this->request->getParam('pass')[0]);
				$terms = "";
				if (count($terminocompleto) > 1) {
					foreach ($terminocompleto as $terminosimple) :
						$terms = $terms . '%' . $terminosimple . '%';
					endforeach;
				} else
					$terms = '%' . $terminocompleto[0] . '%';

				//$this->request->getParam('pass');
				if (empty($this->request->getParam('pass')[1]))
					$laboratorioid = 0;
				else
					$laboratorioid = $terms_lab;

				if (empty($this->request->getParam('pass')[2]))
					$terms_m = "";
				else
					$terms_m = $this->request->getParam('pass')[2];
			}
		}

		$this->categoriaylaboratorio();
		$this->clientecredito();
		$this->sumacarrito();
		$this->monodrogayaccionterapeutica();


		$this->viewBuilder()->layout('store');

		$this->loadModel('Articulos');

		$fecha = Time::now();
		//$fecha->i18nFormat('YYYY-MM-dd');
		//$list_tipo_dto=array();

		if ($this->request->session()->read('Auth.User.farmapoint') > 0) {
			$list_tipo_dto_dist = 'tipo_oferta <> "VC"';
			$list_tipo_dto = '("RV","RR","OR","TD","RL","HS","FR","TH","PS","FP")';
		} else {
			$list_tipo_dto_dist = '[tipo_oferta <> "FP" , tipo_oferta <> "VC"]';
			$list_tipo_dto = '("RV","RR","OR","TD","RL","HS","FR","TH","PS")';
		}
		$articulosA = $this->Articulos->find()
			->contain([
				'Descuentos' => [
					'queryBuilder' => function ($q) {
						return $q->where(['tipo_oferta <> "VC"']); // Full conditions for filtering
					}
					//'tipo_oferta in ("RV","RR","OR","TD","RL","HS","FR","TH","TD")',

				], 'Carritos' => [

					'queryBuilder' => function ($q) {
						return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); // Full conditions for filtering
					}
				]
			])
			->hydrate(false)
			->join(
				[
					'table' => 'descuentos',
					'alias' => 'd',
					'type' => 'LEFT',
					'conditions' => [
						'd.articulo_id = Articulos.id',
						'd.tipo_venta = "D"',
						'd.fecha_hasta >=' => $fecha->i18nFormat('yyyy-MM-dd'),
						'd.tipo_oferta in ' . $list_tipo_dto //("RV","RR","OR","TD","RL","HS","FR","TH","PS","FP")'
					]
				]
			);


		if ($terms != "%0%") {
			if ($terms != "" && $terms_m == "") {
				$articulosA->andWhere([

					'OR' => [
						['Articulos.descripcion_pag LIKE' => $terms],
						['Articulos.troquel LIKE' => $terms], ['Articulos.codigo_barras LIKE' => $terms], ['Articulos.codigo_barras2 LIKE' => $terms]
					],
				]);
				if ($this->request->session()->read('Auth.User.grupo') == 30)
					$articulosA->andwhere('Articulos.id <>102940');
			}
		} else
		if ($terms_m != "") {
			$articulosA->andWhere(['Articulos.codigo_barras IN (' . $terms_m . ')']);
		}
		if (($laboratorioid != 0)) {
			if ($laboratorioid != 65)
				$articulosA->andWhere(['Articulos.laboratorio_id' => $laboratorioid]);
			else
				$articulosA->andWhere(['Articulos.laboratorio_id in (65,359,385)']);
		}




		if ($articulosA != null) {
			$articulosA->andWhere(['Articulos.eliminado' => 0])->group(['Articulos.id']);
			$limit = 5000;


			$this->paginate = [
				'contain' => ['Carritos'],
				'limit' => $limit, 'maxLimit' => 5000,
				'offset' => 0,
				'order' => ['Articulos.descripcion_pag' => 'asc']
			];


			$articulos = $this->paginate($articulosA);
		} else
			$articulos = null;
		$this->set(compact('articulos'));

		$this->loadModel('Publications');
		$publicationsearch = $this->Publications->find('all')->where(['fecha_hasta >=CURRENT_DATE()', 'habilitada' => '1', 'ubicacion' => '7'])->order(['orden' => 'ASC'])->all();

		$this->set('publicationsearch', $publicationsearch->toArray());
		$this->request->session()->write('publicationsearch', $publicationsearch->toArray());

		$publicationzocalo = $this->Publications->find('all')->where(['fecha_hasta >=CURRENT_DATE()', 'habilitada' => '1', 'ubicacion' => '13'])->order(['orden' => 'ASC'])->all();
		$this->set('banner_slider', $publicationzocalo->toArray());
		$this->request->session()->write('banner_slider', $publicationzocalo->toArray());

		$this->set('banner_slider', $this->request->session()->read('banner_slider'));
	}

	public function search_hss($terms_lab = null, $terms = null, $terms_mult = null)
	{
		if ($this->request->is('post')) {
			if (!empty($this->request->data['laboratorio_id'])) {
				$laboratorioid = $this->request->data['laboratorio_id'];
			} else {
				$laboratorioid = 0;
			}

			if ($this->request->data['terms_mult'] != null) {
				$terms_m = $this->request->data['terms_mult'];
			} else
				$terms_m = "";

			if ($this->request->data['terminobuscar'] != null) {
				$terminocompleto = explode(" ", $this->request->data['terminobuscar']);
				$terms = "";
				if (count($terminocompleto) > 1) {
					foreach ($terminocompleto as $terminosimple) :
						$terms = $terms . '%' . $terminosimple . '%';
					endforeach;
				} else
					$terms = '%' . $terminocompleto[0] . '%';
			} else {
				$terms = "";
			}
			$this->request->session()->write('termsearch', $terms);
			$this->request->session()->write('laboratorioid', $laboratorioid);
		} else {


			$laboratorioid = 0; //$this->request->session()->read('laboratorioid');
			if (!empty($this->request->session()->read('laboratorioid')))
				$laboratorioid = $this->request->session()->read('laboratorioid');

			$terms_m = "";

			$terms = "";
			if (!empty($this->request->session()->read('termsearch')))
				$terms = $this->request->session()->read('termsearch');


			if (!empty($this->request->getParam('pass'))) {
				if (!empty($this->request->getParam('pass')[1]))
					$terminocompleto = explode(" ", $this->request->getParam('pass')[1]);
				else
					$terminocompleto = array();
				$terms = "";
				if (count($terminocompleto) > 0) {
					if (count($terminocompleto) > 1) {
						foreach ($terminocompleto as $terminosimple) :
							$terms = $terms . '%' . $terminosimple . '%';
						endforeach;
					} else
						$terms = '%' . $terminocompleto[0] . '%';
				}
				//$this->request->getParam('pass');
				if (empty($this->request->getParam('pass')[0]))
					$laboratorioid = 0;
				else
					$laboratorioid = $terms_lab;

				if (empty($this->request->getParam('pass')[2]))
					$terms_m = "";
				else
					$terms_m = $this->request->getParam('pass')[2];
			}
		}

		$this->categoriaylaboratorio();
		$this->clientecredito();
		$this->sumacarrito();
		$this->monodrogayaccionterapeutica();


		$this->viewBuilder()->layout('store');

		$this->loadModel('Articulos');

		$fecha = Time::now();
		//$fecha->i18nFormat('YYYY-MM-dd');
		//$list_tipo_dto=array();

		if ($this->request->session()->read('Auth.User.farmapoint') > 0) {
			$list_tipo_dto_dist = 'tipo_oferta <> "VC"';
			//$list_tipo_dto = '("HS")';
			if ($laboratorioid == 0)
				$list_tipo_dto = '("HS")';
			else
				$list_tipo_dto = '("TD","HS","TH")';
		} else {
			$list_tipo_dto_dist = '[tipo_oferta <> "FP" , tipo_oferta <> "VC"]';
			//$list_tipo_dto = '("TD","HS","TH")';
			//$list_tipo_dto = '("HS")';
			if ($laboratorioid == 0)
				$list_tipo_dto = '("HS")';
			else
				$list_tipo_dto = '("TD","HS","TH")';
		}
		$articulosA = $this->Articulos->find()
			->contain([
				'Descuentos' => [
					'queryBuilder' => function ($q) {
						return $q->where(['tipo_oferta <> "VC"']); // Full conditions for filtering
					}
					//'tipo_oferta in ("RV","RR","OR","TD","RL","HS","FR","TH","TD")',

				], 'Carritos' => [

					'queryBuilder' => function ($q) {
						return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); // Full conditions for filtering
					}
				]
			])
			->hydrate(false)
			->join(
				[
					'table' => 'descuentos',
					'alias' => 'd',
					'type' => 'INNER',
					'conditions' => [
						'd.articulo_id = Articulos.id',
						'd.tipo_venta = "D"',
						'd.fecha_hasta >=' => $fecha->i18nFormat('yyyy-MM-dd'),
						'd.tipo_oferta in ' . $list_tipo_dto //("RV","RR","OR","TD","RL","HS","FR","TH","PS","FP")'
					]
				]
			);


		if ($terms != "%0%") {
			if ($terms != "" && $terms_m == "") {
				$articulosA->andWhere([

					'OR' => [
						['Articulos.descripcion_pag LIKE' => $terms],
						['Articulos.troquel LIKE' => $terms], ['Articulos.codigo_barras LIKE' => $terms], ['Articulos.codigo_barras2 LIKE' => $terms]
					],
				]);
				if ($this->request->session()->read('Auth.User.grupo') == 30)
					$articulosA->andwhere('Articulos.id <>102940');
			}
		} else
		if ($terms_m != "") {
			$articulosA->andWhere(['Articulos.codigo_barras IN (' . $terms_m . ')']);
		}
		if (($laboratorioid != 0)) {
			if ($laboratorioid != 65)
				$articulosA->andWhere(['Articulos.laboratorio_id' => $laboratorioid]);
			else
				$articulosA->andWhere(['Articulos.laboratorio_id in (65,359,385)']);
		}
		if (($laboratorioid != 0)) {

			switch ($laboratorioid) {
				case 157:
					$articulosA->andWhere(['Articulos.codigo_barras IN (7798140257189,7798140257196,7798140256441,7798140256427,7798140256458)']);
					break;
				case 22:
					//$articulosA->andWhere(['Articulos.codigo_barras IN ( )']);
					break;
				case 213:
					//$articulosA->andWhere(['Articulos.codigo_barras IN (7798008190726,7798008190795,7798008190702,7798008190818,7798008191068,7798008191099,7798008190757 )']);
					break;
				case 121:
					//$articulosA->andWhere(['Articulos.codigo_barras IN ( )']);
					break;
				case 24:
					//$articulosA->andWhere(['Articulos.codigo_barras IN ( )']);
					break;
				case 275:
					//$articulosA->andWhere(['Articulos.codigo_barras IN ( )']);
					break;
				case 425:
					//$articulosA->andWhere(['Articulos.codigo_barras IN ( )']);
					break;

				default: {
						$articulosA->andWhere(['Articulos.laboratorio_id' => $laboratorioid]);
					}
			}
		}




		if ($articulosA != null) {

			$articulosA->andWhere(['Articulos.stock <> "F"', 'Articulos.stock <> "D"', 'Articulos.eliminado' => 0])->group(['Articulos.id']);
			$limit = 5000;


			$this->paginate = [
				'contain' => ['Carritos'],
				'limit' => $limit, 'maxLimit' => 5000,
				'offset' => 0,
				'order' => ['Articulos.descripcion_pag' => 'asc']
			];


			$articulos = $this->paginate($articulosA);
		} else
			$articulos = null;
		$this->set(compact('articulos'));

		$this->loadModel('Publications');
		$publicationsearch = $this->Publications->find('all')->where(['fecha_hasta >=CURRENT_DATE()', 'habilitada' => '1', 'ubicacion' => '7'])->order(['id' => 'DESC'])->all();

		$this->set('publicationsearch', $publicationsearch->toArray());
		$this->request->session()->write('publicationsearch', $publicationsearch->toArray());
		//$publicationzocalo = $this->Publications->find('all')->where(['fecha_hasta >=CURRENT_DATE()','habilitada' =>'1','ubicacion'=>'12','laboratorio_id'=>$laboratorioid])->order(['id' => 'DESC'])->all();

		$publicationzocalo = $this->Publications->find('all')->where(['fecha_hasta >=CURRENT_DATE()', 'habilitada' => '1', 'ubicacion' => '13'])->order(['id' => 'DESC'])->all();
		$this->set('banner_slider', $publicationzocalo->toArray());
		$this->request->session()->write('banner_slider', $publicationzocalo->toArray());

		$this->set('banner_slider', $this->request->session()->read('banner_slider'));
	}


	public function search_cm($terms = null, $terms_lab = null, $terms_mult = null)
	{
		if ($this->request->is('post')) {
			if (!empty($this->request->data['laboratorio_id'])) {
				$laboratorioid = $this->request->data['laboratorio_id'];
			} else {
				$laboratorioid = 0;
			}

			if ($this->request->data['terms_mult'] != null) {
				$terms_m = $this->request->data['terms_mult'];
			} else
				$terms_m = "";

			if ($this->request->data['terminobuscar'] != null) {
				$terminocompleto = explode(" ", $this->request->data['terminobuscar']);
				$terms = "";
				if (count($terminocompleto) > 1) {
					foreach ($terminocompleto as $terminosimple) :
						$terms = $terms . '%' . $terminosimple . '%';
					endforeach;
				} else
					$terms = '%' . $terminocompleto[0] . '%';
			} else {
				$terms = "";
			}
			$this->request->session()->write('termsearch', $terms);
			$this->request->session()->write('laboratorioid', $laboratorioid);
		} else {


			$laboratorioid = 0; //$this->request->session()->read('laboratorioid');
			if (!empty($this->request->session()->read('laboratorioid')))
				$laboratorioid = $this->request->session()->read('laboratorioid');

			$terms_m = "";

			$terms = "";
			if (!empty($this->request->session()->read('termsearch')))
				$terms = $this->request->session()->read('termsearch');


			if (!empty($this->request->getParam('pass'))) {


				$terminocompleto = explode(" ", $this->request->getParam('pass')[0]);
				$terms = "";
				if (count($terminocompleto) > 1) {
					foreach ($terminocompleto as $terminosimple) :
						$terms = $terms . '%' . $terminosimple . '%';
					endforeach;
				} else
					$terms = '%' . $terminocompleto[0] . '%';

				//$this->request->getParam('pass');
				if (empty($this->request->getParam('pass')[1]))
					$laboratorioid = 0;
				else
					$laboratorioid = $terms_lab;

				if (empty($this->request->getParam('pass')[2]))
					$terms_m = "";
				else
					$terms_m = $this->request->getParam('pass')[0];
			}
		}

		$this->categoriaylaboratorio();
		$this->clientecredito();
		$this->sumacarrito();
		$this->monodrogayaccionterapeutica();


		$this->viewBuilder()->layout('store_cm');

		$this->loadModel('Articulos');

		$fecha = Time::now();
		//$fecha->i18nFormat('YYYY-MM-dd');
		//$list_tipo_dto=array();

		if ($this->request->session()->read('Auth.User.farmapoint') > 0) {
			$list_tipo_dto_dist = 'tipo_oferta <> "VC"';
			$list_tipo_dto = '("OR","TD","RL","HS","FR","TH","PS","FP","CM","SC")';
		} else {
			$list_tipo_dto_dist = '[tipo_oferta <> "FP" , tipo_oferta <> "VC"]';
			$list_tipo_dto = '("OR","TD","RL","HS","FR","TH","PS","CM","SC")';
		}
		$articulosA = $this->Articulos->find()
			->contain([
				'Descuentos' => [
					'queryBuilder' => function ($q) {
						return $q->where(['tipo_oferta <> "VC"', 'tipo_oferta <> "RR"']); // Full conditions for filtering
					}
					//'tipo_oferta in ("RV","RR","OR","TD","RL","HS","FR","TH","TD")',

				], 'Carritos' => [

					'queryBuilder' => function ($q) {
						return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); // Full conditions for filtering
					}
				]
			])
			->hydrate(false)
			->join(
				[
					'table' => 'descuentos',
					'alias' => 'd',
					'type' => 'INNER',
					'conditions' => [
						'd.articulo_id = Articulos.id',
						'd.tipo_venta = "D"',
						'd.fecha_hasta >=' => $fecha->i18nFormat('yyyy-MM-dd'),
						'd.tipo_oferta in ' . $list_tipo_dto //("RV","RR","OR","TD","RL","HS","FR","TH","PS","FP")'
					]
				]
			);



		if ($terms != "" && $terms_m == "") {
			$articulosA->andWhere([

				'OR' => [
					['Articulos.descripcion_pag LIKE' => $terms],
					['Articulos.troquel LIKE' => $terms], ['Articulos.codigo_barras LIKE' => $terms], ['Articulos.codigo_barras2 LIKE' => $terms]
				],
			]);
		}
		if ($terms_m != "") {
			$articulosA->andWhere(['Articulos.codigo_barras IN (' . $terms_m . ')']);
		}
		if (($laboratorioid != 0)) {

			switch ($laboratorioid) {
				case 157:
					$articulosA->andWhere(['Articulos.codigo_barras IN (650240006647, 
						7798140250425,
						7798140258636,
						0650240011351,
						7798140255024,
						7798140258285,
						7798140251682,
						650240015670)']);
					break;
				case 22:
					$articulosA->andWhere(['Articulos.codigo_barras IN (  7795323002420,
							7795323002437,
							7795323002444,
							7795323002253,
							7795323002239,
							7795323002208
						   )']);
					break;
				case 21:
					$articulosA->andWhere(['Articulos.codigo_barras IN ( 7790375269210,
						7790375260941,
						7790580130718,
						7790580130077
						
					

						
						)']);
					break;
				case 121:
					$articulosA->andWhere(['Articulos.codigo_barras IN (  7796285285135,7796285273941,
						7796285285999,
						7796285286002)']);
					break;
				case 24:
					$articulosA->andWhere(['Articulos.codigo_barras IN (7793640215479	,
							7793640992448	,
							7793640992455	,
							7793640000839	,
							7793640215523)']);
					break;




				case 425:
					$articulosA->andWhere(['Articulos.codigo_barras IN (  7798120265883,
						7798120265869,
						7798120265944,
						7798120265913,
						7798120265616,7798120265951)']);
					break;

				default: {
						$articulosA->andWhere(['Articulos.laboratorio_id' => $laboratorioid]);
					}
			}
		}




		if ($articulosA != null) {
			$articulosA->andWhere(['Articulos.stock <> "F"', 'Articulos.stock <> "D"', 'Articulos.eliminado' => 0])->group(['Articulos.id']);
			$limit = 25;
			if ($articulosA->count() < 100 && $articulosA->count() > 50) {
				$limit = 50;
			}
			if ($articulosA->count() > 100) {
				$limit = 70;
			}

			$this->paginate = [
				'contain' => ['Carritos'],
				'limit' => $limit,
				'offset' => 0,
				'order' => ['Articulos.descripcion_pag' => 'asc']
			];


			$articulos = $this->paginate($articulosA);
		} else
			$articulos = null;
		$this->set(compact('articulos'));

		$this->loadModel('Publications');
		$publicationsearch = $this->Publications->find('all')->where(['fecha_hasta >=CURRENT_DATE()', 'habilitada' => '1', 'ubicacion' => '7'])->order(['id' => 'DESC'])->all();

		$this->set('publicationsearch', $publicationsearch->toArray());
		$this->request->session()->write('publicationsearch', $publicationsearch->toArray());
		$publicationzocalo = $this->Publications->find('all')->where(['fecha_hasta >=CURRENT_DATE()', 'habilitada' => '1', 'ubicacion' => '12', 'laboratorio_id' => $laboratorioid])->order(['id' => 'DESC'])->all();
		$this->set('banner_slider', $publicationzocalo->toArray());
		$this->request->session()->write('banner_slider', $publicationzocalo->toArray());

		$this->set('banner_slider', $this->request->session()->read('banner_slider'));
	}


	public function search_i30072021($terms = null, $terms_lab = null)
	{
		if ($this->request->is('post')) {
			if (!empty($this->request->data['laboratorio_id'])) {
				$laboratorioid = $this->request->data['laboratorio_id'];
			} else {
				$laboratorioid = 0;
			}

			if ($this->request->data['terminobuscar'] != null) {
				$terminocompleto = explode(" ", $this->request->data['terminobuscar']);
				$terms = "";
				if (count($terminocompleto) > 1) {
					foreach ($terminocompleto as $terminosimple) :
						$terms = $terms . '%' . $terminosimple . '%';
					endforeach;
				} else
					$terms = '%' . $terminocompleto[0] . '%';
			} else {
				$terms = "";
			}
			$this->request->session()->write('termsearch', $terms);
			$this->request->session()->write('laboratorioid', $laboratorioid);
		} else {


			$laboratorioid = 0; //$this->request->session()->read('laboratorioid');
			if (!empty($this->request->session()->read('laboratorioid')))
				$laboratorioid = $this->request->session()->read('laboratorioid');


			$terms = "";
			if (!empty($this->request->session()->read('termsearch')))
				$terms = $this->request->session()->read('termsearch');


			if (!empty($this->request->getParam('pass'))) {


				$terminocompleto = explode(" ", $this->request->getParam('pass')[0]);
				$terms = "";
				if (count($terminocompleto) > 1) {
					foreach ($terminocompleto as $terminosimple) :
						$terms = $terms . '%' . $terminosimple . '%';
					endforeach;
				} else
					$terms = '%' . $terminocompleto[0] . '%';

				//$this->request->getParam('pass');
				if (empty($this->request->getParam('pass')[1]))
					$laboratorioid = 0;
				else
					$laboratorioid = $terms_lab;
			}
		}

		$this->categoriaylaboratorio();
		$this->clientecredito();
		$this->sumacarrito();
		$this->monodrogayaccionterapeutica();


		$this->viewBuilder()->layout('store');

		$this->loadModel('Articulos');

		$fecha = Time::now();
		//$fecha->i18nFormat('YYYY-MM-dd');
		//$list_tipo_dto=array();

		if ($this->request->session()->read('Auth.User.farmapoint') > 0) {
			$list_tipo_dto_dist = 'tipo_oferta <> "VC"';
			$list_tipo_dto = '("RV","RR","OR","TD","RL","HS","FR","TH","PS","FP")';
		} else {
			$list_tipo_dto_dist = '[tipo_oferta <> "FP" , tipo_oferta <> "VC"]';
			$list_tipo_dto = '("RV","RR","OR","TD","RL","HS","FR","TH","PS")';
		}
		$articulosA = $this->Articulos->find()
			->contain([
				'Descuentos' => [
					'queryBuilder' => function ($q) {
						return $q->where(['tipo_oferta <> "VC"']); // Full conditions for filtering
					}
					//'tipo_oferta in ("RV","RR","OR","TD","RL","HS","FR","TH","TD")',

				], 'Carritos' => [

					'queryBuilder' => function ($q) {
						return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); // Full conditions for filtering
					}
				]
			])
			->hydrate(false)
			->join(
				[
					'table' => 'descuentos',
					'alias' => 'd',
					'type' => 'LEFT',
					'conditions' => [
						'd.articulo_id = Articulos.id',
						'd.tipo_venta = "D"',
						'd.fecha_hasta >=' => $fecha->i18nFormat('yyyy-MM-dd'),
						'd.tipo_oferta in ' . $list_tipo_dto //("RV","RR","OR","TD","RL","HS","FR","TH","PS","FP")'
					]
				]
			);



		if ($terms != "") {
			$articulosA->andWhere([

				'OR' => [
					['Articulos.descripcion_pag LIKE' => $terms],
					['Articulos.troquel LIKE' => $terms], ['Articulos.codigo_barras LIKE' => $terms], ['Articulos.codigo_barras2 LIKE' => $terms]
				],
			]);
		}

		if (($laboratorioid != 0)) {
			$articulosA->andWhere(['Articulos.laboratorio_id' => $laboratorioid]);
		}




		if ($articulosA != null) {
			$articulosA->andWhere(['Articulos.eliminado' => 0])->group(['Articulos.id']);
			$limit = 25;
			if ($articulosA->count() < 100 && $articulosA->count() > 50) {
				$limit = 50;
			}
			if ($articulosA->count() > 100) {
				$limit = 70;
			}

			$this->paginate = [
				'contain' => ['Carritos'],
				'limit' => $limit,
				'offset' => 0,
				'order' => ['Articulos.descripcion_pag' => 'asc']
			];


			$articulos = $this->paginate($articulosA);
		} else
			$articulos = null;
		$this->set(compact('articulos'));

		$this->loadModel('Publications');
		$publicationsearch = $this->Publications->find('all')->where(['fecha_hasta >=CURRENT_DATE()', 'habilitada' => '1', 'ubicacion' => '7'])->order(['id' => 'DESC'])->all();

		$this->set('publicationsearch', $publicationsearch->toArray());
		$this->request->session()->write('publicationsearch', $publicationsearch->toArray());

		$publicationzocalo = $this->Publications->find('all')->where(['fecha_hasta >=CURRENT_DATE()', 'habilitada' => '1', 'ubicacion' => '13'])->order(['id' => 'DESC'])->all();
		$this->set('banner_slider', $publicationzocalo->toArray());
		$this->request->session()->write('banner_slider', $publicationzocalo->toArray());

		$this->set('banner_slider', $this->request->session()->read('banner_slider'));
	}

	public function searchadd($termsearch = null)
	{


		if ($termsearch != "") {

			$this->CargarCarritoCB($termsearch);
		}

		$this->viewBuilder()->layout('store');
		$this->redirect($this->referer());
	}

	public function alternativo($alternativo_id = null)
	{

		$this->monodrogayaccionterapeutica();
		$this->categoriaylaboratorio();
		$this->clientecredito();
		$this->sumacarrito();


		$this->viewBuilder()->layout('store');

		$this->loadModel('Articulos');
		$this->loadModel('Carritos');
		$this->loadModel('Descuentos');
		$fecha = Time::now();
		//$fecha->i18nFormat('YYYY-MM-dd');
		$articulosA = $this->Articulos->find('all')
			->contain([
				'Descuentos', 'Carritos' => [

					'queryBuilder' => function ($q) {
						return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); // Full conditions for filtering
					}
				]
			])
			->hydrate(false)
			->join(
				[
					'table' => 'descuentos',
					'alias' => 'd',
					'type' => 'LEFT',
					'conditions' => [
						'd.articulo_id = Articulos.id',
						'd.tipo_venta = "D"',
						'd.fecha_hasta >=' => $fecha->i18nFormat('yyyy-MM-dd'),
						'd.tipo_oferta in ("RV","RR","OR","TD","RL","HS","VC","PS")'
					]
				]
			);

		if ($this->request->session()->read('Auth.User.venta_restringida') > 0) {
			$articulosA->andWhere(['Articulos.venta_restringida' => 0]);
		}

		$this->loadModel('AlfabetaArticulosExtras');
		$articuloaf = $this->AlfabetaArticulosExtras->find('all')->where(['articulo_id' => $alternativo_id])->first([]);

		$this->set('articuloaf', $articuloaf);
		if (!empty($articuloaf)) {
			$listadosimilaresid = $this->AlfabetaArticulosExtras->find('all')->select('articulo_id')->where(
				[
					'alfabeta_tamano_id' => $articuloaf['alfabeta_tamano_id'],
					'alfabeta_monodroga_id' => $articuloaf['alfabeta_monodroga_id'],
					'alfabeta_forma_id' => $articuloaf['alfabeta_forma_id'],
					'potencia' => $articuloaf['potencia'],
					'alfabeta_tipo_unidad_id' => $articuloaf['alfabeta_tipo_unidad_id']
				]
			);

			if ($listadosimilaresid != null) {
				$this->set('listadosimilaresid', $listadosimilaresid);
				$articulosA->andWhere(['Articulos.id in' => $listadosimilaresid]);
			} else {
				$this->Flash->error('No se encontro alternativos o equivalentes', ['key' => 'changepass']);
				return $this->redirect($this->referer());
			}
		} else {

			$articulosA = null;
		}

		if ($articulosA != null) {

			$articulosA->andWhere(['Articulos.eliminado' => 0])->group(['Articulos.id']);
			$limit = 25;
			if ($articulosA->count() < 100 && $articulosA->count() > 50) {
				$limit = 50;
			}
			if ($articulosA->count() > 100) {
				$limit = 75;
			}

			$this->paginate = [
				'contain' => ['Carritos'],
				'limit' => $limit,
				'offset' => 0,
				'order' => ['Articulos.descripcion_pag' => 'asc']
			];

			$articulos = $this->paginate($articulosA);
		} else {
			$this->loadModel('Ofertas');

			$connection = ConnectionManager::get('default');
			$ofertas = $connection->execute('SELECT ofertas.*,articulos.id AS articuloid, articulos.precio_publico, articulos.categoria_id,  articulos.compra_max, 
		  descuentos.dto_drogueria, descuentos.articulo_id, descuentos.plazo, descuentos.uni_min, descuentos.tipo_oferta, descuentos.tipo_venta, descuentos.tipo_precio ,ofertas.oferta_tipo_id 
		  FROM ofertas LEFT JOIN articulos on articulos.id = ofertas.articulo_id INNER JOIN descuentos on descuentos.articulo_id =  articulos.id and 
		  descuentos.tipo_venta = "D" and	descuentos.fecha_hasta >=CURRENT_DATE() and	descuentos.tipo_oferta in ("RV","RR","OR","TD","RL") where ofertas.activo=1 and ofertas.oferta_tipo_id = 7 and articulos.stock<>"F" ORDER BY ofertas.id DESC ')->fetchAll('assoc');

			$this->set('ofertas', $ofertas);
			$articulos = null;
		}


		$this->set(compact('articulos'));
		$this->set('_serialize', 'articulos');
	}

	public function import()
	{
		$this->viewBuilder()->layout('store');

		$this->clientecredito();
		$this->sumacarrito();
		/*
		$this->loadModel('Ofertas');
		
		$connection = ConnectionManager::get('default');

		$ofertas = $connection->execute('SELECT ofertas.*, articulos.precio_publico, articulos.categoria_id, articulos.compra_max, 
		  descuentos.dto_drogueria, descuentos.articulo_id, descuentos.plazo, descuentos.uni_min, descuentos.tipo_oferta, descuentos.tipo_venta, descuentos.tipo_precio ,ofertas.oferta_tipo_id 
		  FROM ofertas LEFT JOIN articulos on articulos.id = ofertas.articulo_id INNER JOIN descuentos on descuentos.articulo_id =  articulos.id and 
		  descuentos.tipo_venta = "D" and	descuentos.fecha_hasta >=CURRENT_DATE() and	descuentos.tipo_oferta in ("RV","RR","OR","TD","RL","HS","FR") where ofertas.activo=1 and articulos.stock<>"F" ORDER BY ofertas.id DESC '  )->fetchAll('assoc');
		
		$this->set('ofertas',$ofertas); */
		$this->loadModel('Sistemas');
		$sistemas = $this->Sistemas->find('list', ['keyField' => 'id', 'valueField' => 'nombre']);
		$this->set('sistemas', $sistemas);

		$this->loadModel('Publications');
		$publications = $this->Publications->find('all')->where(['fecha_hasta >=CURRENT_DATE()', 'habilitada' => '1', 'ubicacion' => '5'])->order(['id' => 'DESC'])->all();
		if ((35642 != $this->request->session()->read('Auth.User.cliente_id')) && (36341 != $this->request->session()->read('Auth.User.cliente_id')) && (36932 != $this->request->session()->read('Auth.User.cliente_id')) && (36241 != $this->request->session()->read('Auth.User.cliente_id')) &&
			(74406 !=  $this->request->session()->read('Auth.User.cliente_id')) &&	(35473 !=  $this->request->session()->read('Auth.User.cliente_id'))
		) {
			$this->set('import1', $publications->first());
			$this->set('import2', $publications->skip(1)->first());
		} else {
			$this->set('import1', null);
			$this->set('import2', null);
		}
	}

	public function guardarcarritotemp($temp = null)
	{
		//debug($temp);
		$this->loadModel('CarritosTemps');
		$modificado = false;
		$descuento_pf = $this->request->session()->read('Auth.User.pf_dcto');
		$condicion = $this->request->session()->read('Auth.User.condicion');
		$condiciongeneral = 100 * (1 - ($descuento_pf * (1 - $condicion / 100)));

		$tablaped = $this->request->session()->read('tablaped');
		$campotob = $this->request->session()->read('campotob');

		$carrito = $this->CarritosTemps->newEntity();
		$carrito['cliente_id'] = $this->request->session()->read('Auth.User.cliente_id');
		$carrito['creado'] = date('Y-m-d H:i:s');

		if (array_key_exists($temp[$campotob], $tablaped)) {
			$carrito['cantidad'] = $tablaped[$temp[$campotob]][0];
		}
		if (array_key_exists($temp['codigo_barras2'], $tablaped)) {
			$carrito['cantidad'] = $tablaped[$temp['codigo_barras2']][0];
		}
		if (array_key_exists($temp['codigo_barras3'], $tablaped)) {
			$carrito['cantidad'] = $tablaped[$temp['codigo_barras3']][0];
		}

		$carrito['articulo_id'] = $temp['id'];
		$carrito['precio_publico'] = $temp['precio_publico'];
		$carrito['descripcion'] = $temp['descripcion_pag'];
		$carrito['categoria_id'] = $temp['categoria_id'];
		$carrito['compra_max'] = $temp['compra_max'];
		$carrito['user_id'] = $this->request->session()->read('Auth.User.id');
		if ($temp['descuentos'] != null) {
			if ($temp['descuentos'][0]['tipo_venta'] == 'D') {

				if ($temp['descuentos'][0]['tipo_oferta'] != 'TH') {
					$carrito['descuento'] = $temp['descuentos'][0]['dto_drogueria'];
				} else {

					$carrito['descuento'] = $temp['descuentos'][0]['dto_drogueria'] + $condiciongeneral;
				}
				$carrito['descuento_id'] = $temp['descuentos'][0]['id'];

				//$carrito['descuento'] = $temp['descuentos'][0]['dto_drogueria']; 	
				$carrito['plazoley_dcto'] = $temp['descuentos'][0]['plazo'];
				$carrito['unidad_minima'] = $temp['descuentos'][0]['uni_min'];
				$carrito['tipo_oferta'] = $temp['descuentos'][0]['tipo_oferta'];
				$carrito['tipo_oferta_elegida'] = $temp['descuentos'][0]['tipo_venta'];
				$carrito['tipo_precio'] = $temp['descuentos'][0]['tipo_precio'];
			} else {
				$carrito['descuento'] = 0;
				$carrito['plazoley_dcto'] = 'HABITUAL';
				$carrito['unidad_minima'] = 1;
				$carrito['tipo_oferta'] = null;
				$carrito['tipo_oferta_elegida'] = null;
				$carrito['tipo_precio'] = null;
				$carrito['descuento_id'] = 0;
			}
		} else {
			$carrito['descuento_id'] = 0;
			$carrito['descuento'] = 0;
			$carrito['plazoley_dcto'] = 'HABITUAL';
			$carrito['unidad_minima'] = 1;
			$carrito['tipo_oferta'] = null;
			$carrito['tipo_oferta_elegida'] = null;
			$carrito['tipo_precio'] = null;
		}
		if ($carrito['tipo_precio'] == 'P' && ($carrito['tipo_oferta'] == 'TD' || $carrito['tipo_oferta'] == 'TL' || $carrito['tipo_oferta'] == 'OR' || $carrito['tipo_oferta'] == 'OD' || $carrito['tipo_oferta'] == 'TH'))
			$carrito['tipo_fact'] = 'TR';
		else
						if ($carrito['tipo_precio'] == 'F' && ($carrito['tipo_oferta'] == 'TD' || $carrito['tipo_oferta'] == 'TL' || $carrito['tipo_oferta'] == 'OR' || $carrito['tipo_oferta'] == 'OD' || $carrito['tipo_oferta'] == 'TH'))

			$carrito['tipo_fact'] = 'TL';
		else
			$carrito['tipo_fact'] = 'N';

		$insertar = $this->CarritosTemps->find('all')
			->where(['articulo_id' => $temp['id']])
			->andWhere(['cliente_id' => $carrito['cliente_id']]);



		if ($insertar->first() == null) {
			$cantidad = $carrito['cantidad'];
			$cantidadmax = $carrito['compra_max'];
			/*
					if ($carrito['categoria_id']!=5 && $carrito['categoria_id']!=4 )
					$cantidadmax = 100;
					else
					$cantidadmax = 500;	*/
			if ($cantidad > $cantidadmax && $this->request->session()->read('Auth.User.grupo') != 33 && $this->request->session()->read('Auth.User.grupo') != 1)
				$carrito['cantidad'] = $cantidadmax;

			//* */
			//if ($cantidad>7) $carrito['cantidad']=7;
			if ($cantidad > 0) {
				$cantback = intval($cantidad);
				$idart = $temp['id'];
				if ($temp['restringido_unid'] > 0 || $temp['restringido_unid_w'] > 0) {
					if (!empty($temp['restringido_unid']) && $temp['restringido_unid'] !== 0) {
						$restringidoUni = $temp['restringido_unid'];
					} elseif (!empty($temp['restringido_unid_w']) && $temp['restringido_unid_w'] !== 0) {
						$restringidoUni = $temp['restringido_unid_w'];
					}
					$validarUni =  $this->validarUnidadesRectriciones($idart, $cantidad, $restringidoUni);
					 $carrito['cantidad'] = $validarUni['cantidad'];
					$modificado = true;
					$modificado = 1;
					$arraymodificado = [
						'id' => $idart,
						'cantidad' => $validarUni['cantidad'],
						'cantback' => $cantback,
						'codigo_barras' => $temp['codigo_barras'],
						'descripcion' => $temp['descripcion_pag']
					];
				}
			}
			if ($this->CarritosTemps->save($carrito)) {
				if ($modificado) {
					return $arraymodificado;
				}
			} else {
				//$this->redirect($this->referer());
			}
		}
	}

	public function sumacarritotemp()
	{
		$this->loadModel('CarritosTemps');
		$carritocon = $this->CarritosTemps->find('all')
			->contain(['Articulos'])
			->where(['CarritosTemps.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
			->order(['CarritosTemps.id' => 'DESC']);
		//$this->set('carritos', $carritocon->toArray());

		$descuento_pf = $this->request->session()->read('Auth.User.pf_dcto');
		$condicion 	  = $this->request->session()->read('Auth.User.condicion');
		$coef         = $this->request->session()->read('Auth.User.coef');

		$totalcarrito = 0;
		$totalitems = 0;
		$totalunidades = 0;
		foreach ($carritocon as $carrito) :
			$totalitems += 1;
			/*if ($carrito['tipo_precio']=="P")
				$totalcarrito= $totalcarrito + $carrito['cantidad']*$carrito['precio_publico'];
			else
				$totalcarrito= $totalcarrito + $carrito['cantidad']*round(h($carrito['precio_publico'])*$descuento_pf, 3);*/
			$totalunidades = $totalunidades + $carrito['cantidad'];

			$cant_carrito = $carrito['cantidad'];
			$subtotal = 0;
			//MEDICAMENTOS
			if (($carrito['categoria_id'] != 5) && ($carrito['categoria_id'] != 4)  && ($carrito['categoria_id'] != 3) && ($carrito['categoria_id'] != 2)) {
				if ($carrito['categoria_id'] === 1)	  $coef2 = 1;
				else $coef2 = $coef;
				if ($carrito['articulo']['laboratorio_id'] === 15) $coef2 = 0.892;


				//DESCUENTOS
				if ($carrito['descuento'] > 0) {
					//TIPO_VENTA=D
					if ($carrito['tipo_oferta_elegida'] == 'D') {
						$cant_uni_min = $carrito['unidad_minima'];
						//TIPO_PRECIO P
						if ($carrito['tipo_precio'] == 'P') {

							if ($cant_carrito >= $cant_uni_min) {
								$descuentooferta = $carrito['descuento'];
								$precio = $carrito['precio_publico'] * $coef2;
								$precio -= $precio * $descuentooferta / 100;
								$subtotal = $precio * $cant_carrito;
							} else {
								$precio  = $carrito['precio_publico'];
								$precio  = $precio * $descuento_pf * $coef2;
								$precio -= $precio * $condicion / 100;
								$subtotal = $precio * $cant_carrito;
							}
						} else {
							//TIPO_PRECIO F
							if ($carrito['tipo_precio'] == 'F') {
								$precio = $carrito['precio_publico'] / (1.21);

								if ($cant_carrito >= $cant_uni_min) {
									$descuentooferta = $carrito['descuento'];
									$precio  = $precio * $descuento_pf * $coef2;
									$precio -= $precio * $condicion / 100;
									$precio -= $precio * $descuentooferta / 100;
									$subtotal = $precio * $cant_carrito;
								} else
									$subtotal = $carrito['precio_publico'] * $descuento_pf * $coef2 * $cant_carrito;
							}
						}
					} else {
						$precio = $carrito['precio_publico'] * $descuento_pf * $coef2;
						if ($carrito['articulo']['msd'] != 1) {
							$precio -= $precio * $condicion / 100;
						}
						$subtotal = $precio * $cant_carrito;
					}
				} else {
					$precio = $carrito['precio_publico'] * $descuento_pf * $coef2;
					if ($carrito['articulo']['msd'] != 1) {
						$precio -= $precio * $condicion / 100;
					}
					$subtotal = $precio * $cant_carrito;
				}
			} else {
				if ($carrito['descuento'] > 0) {
					if ($carrito['tipo_oferta_elegida'] == 'D') {
						$cant_uni_min = $carrito['unidad_minima'];
						if ($cant_carrito >= $cant_uni_min) {
							$descuentooferta = $carrito['descuento'];
							$precio = $carrito['precio_publico'];
							if ($carrito['tipo_precio'] == 'P') {
								$precio -= $precio * $descuentooferta / 100;
							}
							if ($carrito['tipo_precio'] == 'F') {
								$precio = $precio * $descuento_pf;
								//$precio -= $precio*$condicion/100;
								$precio -= $precio * $descuentooferta / 100;
							}
							$subtotal = $precio * $cant_carrito;
						} else {
							$precio = $carrito['precio_publico'] * $descuento_pf;
							if ($coef != 1)	$precio = $precio * $coef;
							$subtotal = $precio * $cant_carrito;
						}
					}
				} else {
					$precio = $carrito['precio_publico'] * $descuento_pf * $coef;
					$subtotal = $precio * $cant_carrito;
				}
			}
			$totalcarrito = $totalcarrito + $subtotal;



		endforeach;
		$this->set('totalitemstemp', $totalitems);
		$this->set('totalcarritotemp', $totalcarrito);
		$this->set('totalunidadestemp', $totalunidades);

		//$this->set('carritos', $carritocon->toArray());
		return $carritocon;
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

	public function importresult()
	{
		$this->viewBuilder()->layout('store');
		$this->loadModel('Articulos');
		$this->paginate = [
			'contain' => ['Descuentos', 'CarritosTemps'],
			'limit' => 1000,
			'order' => ['Articulos.descripcion_pag' => 'asc']
		];
		$recaptchaToken = $this->request->getData('g-recaptcha-response');
		$recaptchaValidation = $this->validateRecaptcha($recaptchaToken);
			if ($recaptchaValidation['success']) {
			if ($recaptchaValidation['score'] > 0.5) {
			if ($this->request->is('post')) {
				if (($this->request->data['filetext'] != null) && ($this->request->data['sistfarm'] != null)) {
					$this->loadModel('Sistemas');
					$sistema = $this->Sistemas->find('all')->where(['id' => $this->request->data['sistfarm']])->first();
					//$this->set('sistemas', $sistemas);

					$this->loadModel('ClientesConfiguraciones');
					$clientesConfiguracione = $this->ClientesConfiguraciones->find("all")->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id'), 'sistema_id' => $this->request->data['sistfarm']])->first([]);
					//if $clientesConfiguracione 
					$this->request->session()->write('clientesConfiguracione', $clientesConfiguracione);
					if (empty($clientesConfiguracione)) {

						$clientesConfiguracione = $this->ClientesConfiguraciones->newEntity();
						//$clientesConfiguracione = $this->ClientesConfiguraciones->patchEntity($clientesConfiguracione, $this->request->getData());
						$clientesConfiguracione['cliente_id'] = $this->request->session()->read('Auth.User.cliente_id');
						$clientesConfiguracione['sistema_id'] = $this->request->data['sistfarm'];
						$clientesConfiguracione['coef_pyf'] = $this->request->session()->read('Auth.User.coef_pyf');
						$clientesConfiguracione['credito_visualizar'] = $this->request->session()->read('creditovisualizar');

						if ($this->ClientesConfiguraciones->save($clientesConfiguracione)) {
							$this->request->session()->write('clientesConfiguracione', $clientesConfiguracione);
						}
					}
					$file = $this->request->data['filetext'];
					$sistfar = $sistema['old'];
					//$sistfar = $this->request->data['sistfarm'];
					$codbardde = substr($sistfar, 0, 2) - 1;
					$codbarlong = substr($sistfar, 2, 2);
					$cantidaddde = substr($sistfar, 4, 2) - 1;
					$cantidadlong = substr($sistfar, 6, 2);
					$descdde = substr($sistfar, 8, 2) - 1;
					$desclong = substr($sistfar, 10, 2);
					$tob = substr($sistfar, 12, 1);

					$fecha = Time::now();
					$dia = $fecha->i18nFormat('yyyyMMdd-HHmmss');
					$codigo = str_pad($this->request->session()->read('Auth.User.codigo'), 6, "0", STR_PAD_LEFT);
					$uploadPath = 'temp/importfile/';
					$uploadFile = $uploadPath . $dia . '_' . $codigo . '_' . $sistfar . '.txt';
					$this->request->session()->write('uploadFile', $uploadFile);
					move_uploaded_file($this->request->data['filetext']['tmp_name'], $uploadFile);

					//if ($tob == 'T') {$campotob = 'troquel';} else {$campotob = 'codigo_barras';}
					if ($tob == 'T') {
						$campotob = 'troquel';
					} else {
						$campotob = 'c_barra';
					}
					$tablaped = array();
					$listaarray = array();
					$destarray = [];
					foreach (file($uploadFile) as $line) {
						$line = utf8_decode($line);
						mb_internal_encoding("UTF-8");
						$codbar = mb_substr($line, $codbardde, $codbarlong);
						$cantidad = mb_substr($line, $cantidaddde, $cantidadlong);

						//$codbar = substr($line,$codbardde,$codbarlong);
						//$cantidad = substr($line,$cantidaddde,$cantidadlong);
						if ($codbar != '' && $codbar != '             ') {
							$codbar = trim($codbar, ' ');
							//$codbar = trim($codbar, " \t\n\r\0\x0B");
							$codbar = ltrim($codbar, '0');
							$cantidad = trim($cantidad, ' ');

							if (!is_numeric($codbar)) {
								$this->Flash->error('No es un codigo de barras o cantidad correcta ' . $line, ['key' => 'changepass']);
							}
							if (!is_numeric($cantidad)) {
								$this->Flash->error('No es un codigo de barras o cantidad correcta ' . $line, ['key' => 'changepass']);
							}

							if ($codbar != '') {
								if (($tob != 'T') && (is_numeric($codbar)) && (is_numeric($cantidad))) {
									array_push($listaarray, $codbar);
									$tablaped[$codbar] = [$cantidad, $line];
								} else
							if (($tob == 'T') && (is_numeric($cantidad))) {
									array_push($listaarray, $codbar);
									$tablaped[$codbar] = [$cantidad, $line];
								}
							}
						}
					}
					if (empty($listaarray)) {
						$this->Flash->error('El archivo seleccionado se encuentra vacio', ['key' => 'changepass']);
						return $this->redirect($this->referer());
					}
					$this->request->session()->write('listaarray', $listaarray);
					$this->request->session()->write('tablaped', $tablaped);
					$this->request->session()->write('campotob', $campotob);
				} else {
					$this->Flash->error('Seleccione el archivo y el tipo de sistema de pedido', ['key' => 'changepass']);
					return $this->redirect($this->referer());
				}
			} else {
				$listaarray = $this->request->session()->read('listaarray');
				$tablaped = $this->request->session()->read('tablaped');
				$campotob = $this->request->session()->read('campotob');
			}
			if ($this->request->is('post')) {
				if (empty($listaarray)) {
					$this->Flash->error('El archivo seleccionado se encuentra vacio', ['key' => 'changepass']);
					return $this->redirect($this->referer());
				}
				$noimportados = array();
				$error = "";

				if ($this->request->session()->read('Auth.User.farmapoint')) {
					$rowarticulos = $this->Articulos->find()
						->contain([
							'Descuentos' => [
								'queryBuilder' => function ($q) {
									return $q->where(['tipo_oferta <> "VC"']); // Full conditions for filtering
								}
							]

						])
						->hydrate(false)

						->join([
							'table' => 'descuentos',
							'alias' => 'd',
							'type' => 'LEFT',
							'conditions' => 'd.articulo_id = Articulos.id and d.fecha_hasta <= CURRENT_DATE() and d.tipo_venta in ("D ","  ")',
						])
						->where(['Articulos.categoria_id <' => 7])
						//->where(['Articulos.id <>49001'])
						->where(['Articulos.eliminado' => 0])
						->where(['Articulos.' . $campotob . ' in ' => $listaarray])
						->orWhere(['Articulos.codigo_barras2 in' => $listaarray])
						->orWhere(['Articulos.codigo_barras3 in' => $listaarray])
						->where(['Articulos.eliminado' => 0]);
					if ($this->request->session()->read('Auth.User.grupo') == 30)
						$rowarticulos->andwhere('Articulos.id <>102940');
				} else {
					$rowarticulos = $this->Articulos->find()
						->contain([
							'Descuentos' => [
								'queryBuilder' => function ($q) {
									return $q->where(['tipo_oferta <> "FP"', 'tipo_oferta <> "VC"']); // Full conditions for filtering
								}
							]

						])
						->hydrate(false)

						->join([
							'table' => 'descuentos',
							'alias' => 'd',
							'type' => 'LEFT',
							'conditions' => 'd.articulo_id = Articulos.id and d.fecha_hasta <= CURRENT_DATE() and d.tipo_venta in ("D ","  ")',
						])
						->where(['Articulos.categoria_id <' => 7])
						//->where(['Articulos.id <>49001'])
						->where(['Articulos.eliminado' => 0])
						->where(['Articulos.' . $campotob . ' in ' => $listaarray])
						->orWhere(['Articulos.codigo_barras2 in' => $listaarray])
						->orWhere(['Articulos.codigo_barras3 in' => $listaarray])
						->where(['Articulos.eliminado' => 0]);
					if ($this->request->session()->read('Auth.User.grupo') == 30)
						$rowarticulos->andwhere('Articulos.id <>102940');
				}
				if ($this->request->session()->read('Auth.User.venta_restringida') > 0) {
					$rowarticulos->andWhere(['Articulos.venta_restringida' => 0]);
				}

				$sinstock = array();
				foreach ($rowarticulos as $row) {
					$restpm = $this->guardarcarritotemp($row);

					if (!empty($restpm)) {

						$arraymodificado = ['articulo' => $restpm];
						array_push($destarray, $arraymodificado);
					}

					$key = array_search($row[$campotob], $listaarray);
					if ($key !== false) {
						unset($listaarray[$key]);
					} else {
						$key = array_search($row['codigo_barras2'], $listaarray);
						if ($key !== false) {
							unset($listaarray[$key]);
						} else {
							$key = array_search($row['codigo_barras3'], $listaarray);
							if ($key !== false) {
								unset($listaarray[$key]);
							}
						}
					}
					if ($row['stock'] == "F" || $row['stock'] == "D") {


						if (isset($tablaped[$row['codigo_barras']])) {
							$insertrowf = $tablaped[$row["codigo_barras"]];

							array_push($sinstock, $insertrowf[1]);
						} else {
							if (isset($tablaped[$row['codigo_barras2']])) {
								$insertrowf = $tablaped[$row["codigo_barras2"]];

								array_push($sinstock, $insertrowf[1]);
							} else {
								if (isset($tablaped[$row['codigo_barras3']])) {
									$insertrowf = $tablaped[$row["codigo_barras3"]];

									array_push($sinstock, $insertrowf[1]);
								}
							}
						}
					}
				}
				$this->request->session()->write('sinstock', $sinstock);

				foreach ($listaarray as $row) {
					$noimportodolinea = array();

					//$insertrow = $tablaped[$row];
					$insertrow = $tablaped[$row];
					$error .= '<tr><td>' . intval($insertrow[0]) . '</td>' .
						'<td>' . substr($insertrow[1], $codbardde, $codbarlong)  . '</td>' .
						'<td>' . substr($insertrow[1], $descdde, $desclong) . '</td>' .
						'<td align="right">' . $insertrow[1] . '</td></tr>';

					//mb_internal_encoding("UTF-8");
					//$codbar = mb_substr($line,$codbardde,$codbarlong);
					//$cantidad = mb_substr($line,$cantidaddde,$cantidadlong);

					$noimportodolinea[0] =  $insertrow[0];
					$noimportodolinea[2] =  substr($insertrow[1], $codbardde, $codbarlong);
					$noimportodolinea[3] = 	substr($insertrow[1], $descdde, $desclong);
					$noimportodolinea[1] =  $insertrow[1];

					array_push($noimportados, $noimportodolinea);
				}

				$this->request->session()->write('noimportados', $noimportados);
				$this->request->session()->write('errorimport', $error);
				$this->request->session()->write('destarray', $destarray);
			} else {
				$error = $this->request->session()->read('errorimport');
			}
		} else {
			$this->Flash->error('Fallo el reCAPTCHA, recargue la pagina e intente nuevamente.', ['key' => 'changepass']);
			$error ="";
		}
		} else {
			$error ="";
			$this->loadModel('LogsCatchaFaileds');
			$logscatcha = $this->LogsCatchaFaileds->newEntity();
			//debug(date('Y-m-d H:i:s'));
			$logscatcha['codigo_cliente'] = $this->request->session()->read('Auth.User.codigo');
			$logscatcha['ip'] = $this->request->clientIp();
			$logscatcha['status'] = $recaptchaValidation['message'];
			$logscatcha['host'] = "import";
			if ($this->LogsCatchaFaileds->save($logscatcha)) {
			}
		}
		$articulosA = $this->Articulos->find('all')
			->contain([
				'CarritosTemps' => [

					'queryBuilder' => function ($q) {
						return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); // Full conditions for filtering
					}
				]
			])
			->hydrate(false)
			->join([
				'table' => 'carritos_temps',
				'alias' => 'ct',
				'type' => 'inner',

				'conditions' => ['ct.articulo_id = Articulos.id', 'ct.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]
			])
			->where(['Articulos.eliminado' => 0])
			->where(['ct.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]);


		if ($articulosA != null) {
			$articulos = $this->paginate($articulosA);
			return $this->redirect([
				'controller' => 'Carritos',
				'action' => 'importresulttemp'
			]);
		} else {
			$articulos = null;
		}
		$this->set('error', $error);

		$this->set(compact('articulos'));

		$this->categoriaylaboratorio();
		$this->clientecredito();
		$this->sumacarrito();
		$this->sumacarritotemp();
		/*$this->loadModel('CarritosTemps');
		$carritotemp = $this->CarritosTemps->find('all')
						->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]);

		$totalcarritotemp=0;
		$totalitemstemp=0;
		$totalunidadestemp=0;
		foreach ($carritotemp as $carrito): 
			$totalitemstemp+=1;
			if ($carrito['tipo_precio']=="P")
				$totalcarritotemp= $totalcarritotemp + $carrito['cantidad']*$carrito['precio_publico'];
			else
				$totalcarritotemp= $totalcarritotemp + $carrito['cantidad']*round(h($carrito['precio_publico'])*0.807, 3);
			$totalunidadestemp= $totalunidadestemp + $carrito['cantidad'];
		
		endforeach; 
		$this->set('totalitemstemp',$totalitemstemp);
		$this->set('totalcarritotemp',$totalcarritotemp);
		$this->set('totalunidadestemp',$totalunidadestemp);*/
	}

	public function importresultexcel()
	{
		$this->viewBuilder()->layout('store');
		$this->loadModel('Articulos');
		$this->paginate = [
			'contain' => ['Descuentos', 'CarritosTemps'],
			'limit' => 80,
			'order' => ['Articulos.descripcion_pag' => 'asc']
		];
		$error = "";
		$recaptchaToken = $this->request->getData('g-recaptcha-response');
		$recaptchaValidation = $this->validateRecaptcha($recaptchaToken);

		if ($recaptchaValidation['success']) {
			if ($recaptchaValidation['score'] > 0.5) {

			if ($this->request->is('post')) {
				if (!empty($this->request->data['filetext'])) {
					$file = $this->request->data['filetext'];
					if ($file['name'] == '') {
						$this->Flash->error('Seleccione el archivo', ['key' => 'changepass']);
						return $this->redirect($this->referer());
					}
					//$fini = $this->request->data['fini']; // fila inicio
					//$fend = $this->request->data['fend']; // fila ultima
					$nsheet = $this->request->data['nsheet']; // nombre de la hoja.
					$cean = $this->request->data['cean']; // Columna EAN
					$ccant = $this->request->data['ccant']; // Columna Cantidad
					$cdesc = $this->request->data['cdesc']; // Columna Descripcion

					if ($this->request->data['nsheet'] == "" ||  $this->request->data['cean'] == ""  || $this->request->data['ccant'] == "" || $this->request->data['cdesc'] == "") {
						$this->Flash->error('Ingrese los datos solicitados.', ['key' => 'changepass']);
						return $this->redirect($this->referer());
					} else {

						$cean = strtoupper($cean); // Columna EAN
						$ccant = strtoupper($ccant); // Columna Cantidad
						$cdesc = strtoupper($cdesc); // Columna Descripcion
					}
					/*
				if ($this->request->data['filetext']['type'] =='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
				$tipo = 'Xlsx';
					
				else
					if ($this->request->data['filetext']['type'] =='application/vnd.ms-excel')
						$tipo = 'Xls';
						else
						{
							$this->Flash->error('Seleccione una planilla de excel con extención xls o xlsx',['key' => 'changepass']);
							return $this->redirect($this->referer());
						}
				*/
					$campotob = 'c_barra';
					$this->request->session()->write('campotob', $campotob);

					$min =  min(array(ord($cean), ord($ccant), ord($cdesc)));
					$max =  max(array(ord($cean), ord($ccant), ord($cdesc)));
					$uploadPath = 'temp/excel/';
					$uploadFile = $uploadPath . $this->request->data['filetext']['name'];
					move_uploaded_file($this->request->data['filetext']['tmp_name'], $uploadFile);

					$tipo = IOFactory::identify($uploadFile);
					if (($tipo == 'Xlsx') || ($tipo == 'Xls')) {
						$tipo = IOFactory::identify($uploadFile);
					} else {
						$this->Flash->error('Seleccione una planilla de excel con extención xls o xlsx', ['key' => 'changepass']);
						return $this->redirect($this->referer());
					}

					//move_uploaded_file($this->request->data['filetext']['tmp_name'],$uploadFile);

					$reader = IOFactory::createReader($tipo);
					//$helper->log('Loading Sheet "' . $sheetname . '" only');
					$consult = $reader->listWorksheetNames($uploadFile);
					$this->request->session()->write('consult', $consult);

					if (!in_array($nsheet, $consult)) {
						$this->Flash->error('Ingrese el nombre de la hoja correcto', ['key' => 'changepass']);
						return $this->redirect($this->referer());
					}


					$reader->setLoadSheetsOnly($nsheet);


					//$helper->log('Loading Sheet using configurable filter');
					//$reader->setReadFilter($filterSubset);
					$spreadsheet = $reader->load($uploadFile);

					$worksheet = $spreadsheet->getActiveSheet();

					// Obtiene las dimensiones de todas las filas que tienen dimensiones definidas
					$rowDimensions = $worksheet->getRowDimensions();

					$hiddenRows = [];

					foreach ($rowDimensions as $rowNumber => $rowDimension) {
						if (!$rowDimension->getVisible()) {
							$hiddenRows[] = $rowNumber;
						}
					}

					$dataArray = $worksheet->toArray(null, true, true, true);

					$processedData = [];
					foreach ($dataArray as $rowNumber => $row) {
						if (in_array($rowNumber, $hiddenRows)) {
							continue; // Ignora las filas ocultas
						}
						$processedData[$rowNumber] = $row;
					}

					// Almacenar la data procesada en la sesión
					$this->request->session()->write('Importado', $processedData);
					//var_dump($sheetData);	


					$tablaped = array();
					$listaarray = array();

					foreach ($processedData  as $row) {
						if ($row[$ccant] !== null || $row[$ccant] != "") {

							$codbar = $row[$cean];
							$codbar = trim($codbar, ' ');
							$codbar = ltrim($codbar, '0');

							$cantidad =  $row[$ccant];
							$descripcion = $row[$cdesc];

							if ($cantidad == null)
								$cantidad = 1;
							if ($codbar != '' && $codbar != null) {
								array_push($listaarray, $codbar);
								$tablaped[$codbar] = [$cantidad, $descripcion, $codbar];
							}
						}
					}

					$this->request->session()->write('listaarray', $listaarray);
					$this->request->session()->write('tablaped', $tablaped);
				} else {
					$this->Flash->error('Seleccione el archivo', ['key' => 'changepass']);
					return $this->redirect($this->referer());
				}
			} else {
				$listaarray = $this->request->session()->read('listaarray');
				$tablaped = $this->request->session()->read('tablaped');
				//$campotob = $this->request->session()->read('campotob');
			}
			if ($this->request->is('post')) {
				$destarray = [];
				$noimportados = array();
				$error = "";
				$rowarticulos = $this->Articulos->find('all')
					->contain(['Descuentos'])
					->hydrate(false)

					->join([
						'table' => 'descuentos',
						'alias' => 'd',
						'type' => 'LEFT',
						'conditions' => 'd.articulo_id = Articulos.id and d.fecha_hasta <= CURRENT_DATE() and d.tipo_venta in ("D ","  ")',
					])
					->where(['Articulos.categoria_id <' => 7])
					->where(['Articulos.eliminado' => 0])
					->where(['Articulos.codigo_barras in ' => $listaarray])
					->orWhere(['Articulos.codigo_barras2 in' => $listaarray])
					->orWhere(['Articulos.codigo_barras3 in' => $listaarray])
					->orWhere(['Articulos.c_barra in' => $listaarray])
					->where(['Articulos.eliminado' => 0]);
				if ($this->request->session()->read('Auth.User.grupo') == 30)
					$rowarticulos->andwhere('Articulos.id <>102940');
				$this->request->session()->write('rowarticulos', $rowarticulos->toArray());
				$modificados = [];
				foreach ($rowarticulos as $row) {
					$restpm = $this->guardarcarritotemp($row);

					if (!empty($restpm)) {
						$arraymodificado = ['articulo' => $restpm];
						array_push($destarray,	$restpm);
					}

					$key = array_search($row['codigo_barras'], $listaarray);
					if ($key !== false) {
						unset($listaarray[$key]);
					} else {
						$key = array_search($row['codigo_barras2'], $listaarray);
						if ($key !== false) {
							unset($listaarray[$key]);
						} else {
							$key = array_search($row['codigo_barras3'], $listaarray);
							if ($key !== false) {
								unset($listaarray[$key]);
							} else {
								$key = array_search($row['c_barra'], $listaarray);
								if ($key !== false) {
									unset($listaarray[$key]);
								}
							}
						}
					}
				}

				foreach ($listaarray as $row) {
					$noimportodolinea = array();


					$insertrow = $tablaped[$row];
					$error .= '<tr>' .
						'<td>' . $insertrow[0] . '</td>' .
						'<td>' . $insertrow[1] . '</td>' .
						'<td>' . $insertrow[2] . '</td>' .
						'</tr>';

					$noimportodolinea[0] =  $insertrow[0];
					$noimportodolinea[1] =  $insertrow[1];
					$noimportodolinea[2] = 	$insertrow[2];


					array_push($noimportados, $noimportodolinea);
				}

				$this->request->session()->write('noimportados', $noimportados);
				$this->request->session()->write('errorimport', $error);
				$this->request->session()->write('destarray', $destarray);
			} else {
				$error = $this->request->session()->read('errorimport');
			}
		} else {
			$this->Flash->error('Fallo el reCAPTCHA, recargue la pagina e intente nuevamente.');
			$error = "";
		}
		} else {
			$error = "";
			$this->loadModel('LogsCatchaFaileds');
			$logscatcha = $this->LogsCatchaFaileds->newEntity();
			//debug(date('Y-m-d H:i:s'));
			$logscatcha['codigo_cliente'] = $this->request->session()->read('Auth.User.codigo');
			$logscatcha['ip'] = $this->request->clientIp();
			$logscatcha['status'] = $recaptchaValidation['message'];
			$logscatcha['host'] = "importexcel";
			if ($this->LogsCatchaFaileds->save($logscatcha)) {
			}
		}

		$articulosA = $this->Articulos->find('all')
			->contain([
				'CarritosTemps' => [

					'queryBuilder' => function ($q) {
						return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); // Full conditions for filtering
					}
				]
			])
			->hydrate(false)
			->join([
				'table' => 'carritos_temps',
				'alias' => 'ct',
				'type' => 'inner',

				'conditions' => ['ct.articulo_id = Articulos.id', 'ct.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]
			])
			->where(['Articulos.eliminado' => 0])
			->where(['ct.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]);

		if ($articulosA != null) {
			$articulos = $this->paginate($articulosA);
		} else {
			$articulos = null;
		}

		$this->set('error', $error);

		$this->set(compact('articulos'));

		$this->categoriaylaboratorio();
		$this->clientecredito();
		$this->sumacarrito();
		$this->sumacarritotemp();
	}


	public function importconfirm()
	{

		$this->loadModel('CarritosTemps');
		$carritos = TableRegistry::get('CarritosTemps');
		$entities = $carritos->newEntities($this->request->data());
		foreach ($entities as $carrito) {
			if (($carrito['cantidad'] == '0') || ($carrito['cantidad'] != '')) {
				$carritosTemp = $this->CarritosTemps->get($carrito['carrito_temp_id']);
				if ($this->CarritosTemps->delete($carritosTemp)) {
				}
			}
		}
		$connection = ConnectionManager::get('default');

		$confirmados = $connection->execute('DELETE FROM ds.carritos WHERE id IN 
		(SELECT * FROM (SELECT c.id FROM carritos_temps ct INNER JOIN carritos c ON (c.articulo_id = ct.articulo_id AND c.cliente_id= ct.cliente_id)  WHERE c.cliente_id=' . $this->request->session()->read('Auth.User.cliente_id') . ') CTP)');

		$confirmados = $connection->execute('INSERT INTO carritos (id, cliente_id, 	articulo_id, 	descripcion, 	cantidad, 	precio_publico, 	descuento, 	unidad_minima, 	tipo_precio, 	plazoley_dcto,	combo_id, 	tipo_oferta, 	tipo_oferta_elegida, 	tipo_fact, creado, 	modificado, categoria_id, compra_max, descuento_id,user_id) 
			SELECT  NULL, cliente_id, 	articulo_id, 	descripcion, 	cantidad, 	precio_publico, 	descuento, 	unidad_minima, 	tipo_precio, 	plazoley_dcto,	combo_id, 	tipo_oferta, 	tipo_oferta_elegida, 	tipo_fact, creado, 	modificado ,categoria_id, compra_max ,descuento_id , user_id
			FROM carritos_temps WHERE cliente_id=' . $this->request->session()->read('Auth.User.cliente_id'));

		$confirmados = $connection->execute('INSERT INTO carritos_faltas (cliente_id, 	articulo_id, 	descripcion, 	descuento, 	unidad_minima, 	tipo_precio, 	plazoley_dcto,	combo_id, 	tipo_oferta, 	tipo_oferta_elegida, 	tipo_fact, creado, 	modificado, descuento_id, cantidad_solicitada, user_id) 
		SELECT  cliente_id, 	articulo_id, 	descripcion, 	descuento, 	unidad_minima, 	tipo_precio, 	plazoley_dcto,	combo_id, 	tipo_oferta, 	tipo_oferta_elegida, 	tipo_fact, creado, 	modificado ,descuento_id, cantidad, user_id
		FROM carritos_temps INNER JOIN articulos a ON a.id = articulo_id WHERE  a.eliminado=0 AND a.stock = "F" AND cliente_id =' . $this->request->session()->read('Auth.User.cliente_id'));
		$confirmados = $connection->execute('delete from carritos_temps WHERE cliente_id=' . $this->request->session()->read('Auth.User.cliente_id'));
		$this->Flash->success('Se importo correctamente. Puede existir alguna restricion de Unidades', ['key' => 'changepass']);
		/*return $this->redirect(['controller'=>'Carritos','action' => 'importresult']);*/
		return $this->redirect(['controller' => 'Carritos', 'action' => 'importresulttemp?val=1']);
	}

	public function downloadfile($opcion = null)
	{
		switch ($opcion) {
			case '1':
				if ($this->request->session()->read('noimportados') != null) {

					$codigo = str_pad($this->request->session()->read('Auth.User.codigo'), 6, "0", STR_PAD_LEFT);
					$file = new File('temp' . DS . $codigo . '.TXT', true, 0777);

					foreach ($this->request->session()->read('noimportados') as $row) :
						$file->write($row[1]);
					endforeach;

					$file->close();
					$this->response->type('txt');
					$this->response->file('temp' . DS . $codigo . '.TXT',['download' => true, 'name' => $codigo . '.TXT']);

					return $this->response;
				}
				break;
			case '2':

				if (($this->request->session()->read('sinstock') != null || $this->request->session()->read('noimportados') != null)) {


					$codigo = str_pad($this->request->session()->read('Auth.User.codigo'), 6, "0", STR_PAD_LEFT);
					$file = new File('temp' . DS . $codigo . '.TXT', true, 0777);


					if ($this->request->session()->read('noimportados') != null) {
						foreach ($this->request->session()->read('noimportados') as $row) :
							$file->write($row[1]);
						endforeach;
					}

					foreach ($this->request->session()->read('sinstock') as $row) :
						$file->write($row);
					endforeach;
					$file->close();

					$this->response->type('txt');
					$this->response->file('temp' . DS . $codigo . '.TXT',['download' => true, 'name' => $codigo . '.TXT']);

					return $this->response;
				}
				break;
			case '3':
				if ($this->request->session()->read('noimportados') != null || $this->request->session()->read('sinstock') != null) {

					$cabecera = '0' . str_pad($this->request->session()->read('Auth.User.codigo'), 8, "0", STR_PAD_LEFT) . '  ' . '00000001';
					$file = new File('temp' . DS . 'FALTANTE.ASC', true, 0777);
					$file->write($cabecera . "\r\n");



					/*   Desde Hasta Longitud Detalle                                            *
					*   ----- ----- -------- ----------------------------                       *
					*       1    30       30 Nombre de Producto                                 *
					*      31    31        1 Separador de campo: ","                            *
					*      32    40        9 C�digo de Producto (seg�n Proveedor)               *
					*      41    41        1 Separador de campo: ","                            *
					*      42    45        4 Cantidad  Pedida                                   *
					*      46    46        1 Separador de campo: ","                            *
					*      47    55        9 C�digo de Troquel (Salud P�blica)                  *
					*      56    56        1 Separador de campo: ","                            *
					*      57    69       13 C�digo de Barras                                   *
					*      70    71        2 Carry Return + Line Feed (ascii 13 + ascii 10)     */

					//571342040130B
					if ($this->request->session()->read('noimportados') != null) {
						foreach ($this->request->session()->read('noimportados') as $row) :
							$linea = $row[1];
							$line = utf8_decode($linea);
							mb_internal_encoding("UTF-8");
							$codbar = mb_substr($line, 56, 13);
							$cantidad = mb_substr($line, 41, 4);
							$descripcion = mb_substr($line, 0, 30);
							$newline = $codbar . str_pad($cantidad, 4, "0", STR_PAD_LEFT) . '1' . $descripcion;
							$file->write($newline . "\r\n");
						endforeach;
					}

					if ($this->request->session()->read('sinstock') != null) {
						foreach ($this->request->session()->read('sinstock') as $row) :
							$linea = $row;
							$line = utf8_decode($linea);
							mb_internal_encoding("UTF-8");
							$codbar = mb_substr($line, 56, 13);
							$cantidad = mb_substr($line, 41, 4);
							$descripcion = mb_substr($line, 0, 30);
							$newline = $codbar . str_pad($cantidad, 4, "0", STR_PAD_LEFT) . '4' . $descripcion;
							$file->write($newline . "\r\n");
						endforeach;
					}

					$file->close();

					$this->response->type('txt');
					$this->response->file('temp' . DS . 'FALTANTE.ASC', ['download' => true, 'name' => 'FALTANTE.ASC']);

					return $this->response;
				}
				break;
			default:
				$this->Flash->error('No se pudo descargar', ['key' => 'changepass']);
				return $this->redirect($this->referer());
				break;
		}
	}

	public function vel()
	{
		$this->viewBuilder()->layout('store');
		//$this->request->session()->write('Auth.User.cliente_id',234526);

		$this->paginate = [
			'contain' => ['Laboratorios', 'Categorias'],
			'limit' => 11,
			'order' => ['Articulos.descripcion_pag' => 'asc']
		];
		$this->loadModel('Articulos');
		$carritocon = $this->Carritos->find('all')
			->where(['Carritos.cliente_id' => 234526])
			->order(['Carritos.id' => 'DESC']);
		/*$this->loadModel('ClientesCreditos');
		$clientecreditos = $this->ClientesCreditos->find('all')	
					->where(['cliente_id' => 234526]);
		$clientecredito = $clientecreditos->first();*/
		$this->set('creditodisponible', 200000.00);

		$this->loadModel('Ofertas');

		$connection = ConnectionManager::get('default');
		$ofertas = $connection->execute('SELECT ofertas.*, articulos.precio_publico, 
		  descuentos.dto_drogueria, descuentos.articulo_id, descuentos.plazo, descuentos.uni_min, descuentos.tipo_oferta, descuentos.tipo_venta, descuentos.tipo_precio 
		  FROM ofertas LEFT JOIN articulos on articulos.id = ofertas.articulo_id LEFT JOIN descuentos on descuentos.articulo_id =  articulos.id and 
		  descuentos.tipo_venta = "D" and	descuentos.fecha_hasta >=CURRENT_DATE() and	descuentos.tipo_oferta in ("RV","RR","OR","TD","RL","HS","VC","PS") where ofertas.activo=1')->fetchAll('assoc');
		$this->set('ofertas', $ofertas);

		$totalcarrito = 0;
		$totalitems = 0;
		$totalunidades = 0;
		/*foreach ($carritocon as $carrito): 
			$totalitems+=1;
			if ($carrito['tipo_precio']=="P")
				$totalcarrito= $totalcarrito + $carrito['cantidad']*$carrito['precio_publico'];
			else
				$totalcarrito= $totalcarrito + $carrito['cantidad']*round(h($carrito['precio_publico'])*0.807, 3);
			
			$totalunidades= $totalunidades + $carrito['cantidad'] ;
		endforeach; */
		$this->set('totalitems', 66666.00);
		$this->set('totalcarrito', 200000.00);
		$this->set('totalunidades', 100.0);
		$this->set('carritos', null);

		$articulos = null; //$this->paginate($this->Articulos);
		$this->set(compact('articulos'));
		if ($this->request->session()->read('Categorias') == null) {
			$this->loadModel('Categorias');
			$this->loadModel('Laboratorios');
			$categorias = $this->Categorias->find('list', ['keyField' => 'id', 'valueField' => 'nombre']);
			$laboratorios = $this->Laboratorios->find('list', ['keyField' => 'id', 'valueField' => 'nombre'])->order(['nombre' => 'ASC']);

			$this->request->session()->write('Categorias', $categorias->toArray());
			$this->request->session()->write('Laboratorios', $laboratorios->toArray());
		} else {

			$laboratorios = $this->request->session()->read('Laboratorios');
			$categorias = $this->request->session()->read('Categorias');
		}
		$this->set('categorias', $categorias);
		$this->set('laboratorios', $laboratorios);
	}

	public function excel()
	{
		$this->viewBuilder()->layout('ajax');

		$this->loadModel('Articulos');
		$articulosA = $this->Articulos->find('all')
			->contain(['CarritosTemps'])
			->hydrate(false)
			->join([
				'table' => 'carritos_temps',
				'alias' => 'ct',
				'type' => 'inner',
				'conditions' => ['ct.articulo_id = Articulos.id', 'ct.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]
			])
			->where(['ct.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
			->order(['Articulos.descripcion_sist' => 'ASC']);

		if ($articulosA != null) {
			$articulos = $articulosA->toArray();
		} else {
			$articulos = null;
		}
		$this->set(compact('articulos'));


		$this->loadModel('CarritosTemps');
		$carritotemp = $this->CarritosTemps->find('all')
			->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]);

		$totalcarritotemp = 0;
		$totalitemstemp = 0;
		$totalunidadestemp = 0;
		foreach ($carritotemp as $carrito) :
			$totalitemstemp += 1;

			if ($carrito['tipo_precio'] == "P")
				$totalcarritotemp = $totalcarritotemp + $carrito['cantidad'] * $carrito['precio_publico'];
			else
				$totalcarritotemp = $totalcarritotemp + $carrito['cantidad'] * round(h($carrito['precio_publico']) * 0.807, 3);
			$totalunidadestemp = $totalunidadestemp + $carrito['cantidad'];

		endforeach;
		$this->set('totalitemstemp', $totalitemstemp);
		$this->set('totalcarritotemp', $totalcarritotemp);
		$this->set('totalunidadestemp', $totalunidadestemp);
		$this->response->type('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	}

	public function excel_contenido()
	{
		$this->viewBuilder()->layout('ajax');

		$carritos  = $this->Carritos->find('all')
			->contain([
				'Articulos', 'Articulos.Descuentos',
				'Articulos.Carritos' => [

					'queryBuilder' => function ($q) {
						return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); // Full conditions for filtering
					}
				]
			])
			->join([
				'table' => 'articulos',
				'alias' => 'a',
				'type' => 'inner',
				'conditions' => ['Carritos.articulo_id = a.id']
			])
			->join([
				'table' => 'descuentos',
				'alias' => 'd',
				'type' => 'left',
				'conditions' => ['d.articulo_id = a.id', '']
			])
			->where(['Carritos.cliente_id' => $this->request->session()->read('Auth.User.cliente_id'), 'a.eliminado' => 0])->group(['a.id'])
			->order(['a.descripcion_sist' => 'ASC']);

		$this->loadModel('Users');

		$users = $this->Users->find('list', ['keyField' => 'id', 'valueField' => 'username'])
			->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]);
		$this->set('users', $users->toArray());

		if ($carritos != null) {
			$carritos = $carritos->toArray();
		} else {
			$carritos = null;
		}
		$this->set(compact('carritos'));

		/*$carritotemp = $this->Carritos->find('all')
						->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]);*/
		$totalcarritotemp = 0;
		$totalitemstemp = 0;
		$totalunidadestemp = 0;
		foreach ($carritos as $carrito) :
			$totalitemstemp += 1;
			$totalunidadestemp = $totalunidadestemp + $carrito['cantidad'];
		endforeach;
		$this->set('totalitemsexcel', $totalitemstemp);
		$this->set('totalunidadesexcel', $totalunidadestemp);
		$this->response->type('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	}

	public function reporte_carro()
	{
		$this->viewBuilder()->layout('ajax');

		$articulosA = $this->Carritos->find('all');
		$articulosA->select([
			'unidades' => $articulosA->func()->sum('Carritos.cantidad'),
			'unidades_minimas' => $articulosA->func()->sum('Carritos.unidad_minima'),
			'items' => $articulosA->func()->count('Carritos.cantidad'),
			'cl.codigo', 'cl.razon_social', 'cl.codigo_postal', 'cl.habilitado'
		])
			//->contain(['Clientes'])
			->hydrate(false)
			->join([
				'table' => 'clientes',
				'alias' => 'cl',
				'type' => 'inner',
				'conditions' => ['cl.id = Carritos.cliente_id']
			])
			->where(['cl.habilitado=1 ', 'Carritos.cantidad<Carritos.unidad_minima'])
			->group(['Carritos.cliente_id']);

		if ($articulosA != null) {
			$items = $articulosA->toArray();
		} else {
			$items = null;
		}
		$this->set(compact('items'));

		$this->response->type('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	}

	function enviarsolicitud($mensaje = null)
	{

		$this->loadModel('Clientes');
		$cliente = $this->Clientes->find('all')->where(['id' => $this->request->session()->read('Auth.User.cliente_id')])
			->first();
		$opcion = 1;
		$cont_email = 'mdedios@drogueriasur.com.ar';
		$cont_cuerpo = '';
		$cont_name = $cliente['codigo'] . ' - Solicitud de Preventa ' . $mensaje;

		$this->request->session()->write('para', $cont_email);
		$email = new Email();
		$email->transport('gmail');
		try {
			$para = 'vgonzalez@drogueriasur.com.ar';
			$para2 = 'coubinia@drogueriasur.com.ar';
			$para3 = 'vmontoya@drogueriasur.com.ar';
			$res = $email->from(['sistemas@drogueriasur.com.ar' => 'Drogueria Sur S.A.'])
				->replyTo(['mdedios@drogueriasur.com.ar' => 'Sistemas'])

				->template('solicitudpreventa')
				->emailFormat('html')

				->to([$para, $para2, $para3])
				//->bcc(["cobranzas@drogueriasur.com.ar"=>"cobranzas@drogueriasur.com.ar"])
				->subject($cont_name)
				->viewVars(['cliente' => $cliente, 'mensaje' => $mensaje])
				->send($cont_cuerpo);

			$this->Flash->success(__('Preventa reservada satisfactoriamente, Facturación sujeta a disponibilidad de stock'), ['key' => 'changepass']);
			return $this->redirect($this->referer());
		} catch (Exception $e) {

			echo 'Exception : ',  $e->getMessage(), "\n";
			$this->Flash->error(__('No Se pudo enviar la solicitud correctamente'), ['key' => 'changepass']);
			return $this->redirect($this->referer());
		}
	}
	// 05/07/21
	public function contenidoCarrito()
	{
		$carritocon1 = $this->Carritos->find('all')
			->contain(['Articulos'])
			->where(['Carritos.cliente_id' => $this->request->session()->read('Auth.User.cliente_id'), 'Carritos.cantidad  < Carritos.unidad_minima', 'Carritos.unidad_minima IS NOT NULL'])
			->order(['Carritos.id' => 'DESC']);

		$carritocon2 = $this->Carritos->find('all')
			->contain(['Articulos'])
			->where(['Carritos.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
			->andWhere([

				'OR' => [
					['Carritos.cantidad  >= Carritos.unidad_minima '],
					['Carritos.unidad_minima IS NULL']
				]
			])
			->order(['Carritos.id' => 'DESC']);
		$c1 = $carritocon1->toArray();
		$c2 = $carritocon2->toArray();
		$carritocon = array_merge($c1, $c2);
		$this->set('carritos', $carritocon);
		return $carritocon;
	}
	// 12/07/21
	public function calcularsubtotales($carritocon, $articulo_id_cart = null)
	{

		$descuento_pf = $this->request->session()->read('Auth.User.pf_dcto');
		$descuento_pf2 = $descuento_pf;
		$condicion    = $this->request->session()->read('Auth.User.condicion');
		$coef         = $this->request->session()->read('Auth.User.coef');

		$condiciongeneral = 100 * (1 - ($descuento_pf * (1 - $condicion / 100)));

		$totalcarrito = 0;
		$totalcarritostock = 0;
		$totalitems = 0;
		$totalunidades = 0;
		$subtotalultimo = 0;
		foreach ($carritocon as $carrito) :
			$totalitems += 1;
			/*if ($carrito['tipo_precio']=="P")
                $totalcarrito= $totalcarrito + $carrito['cantidad']*$carrito['precio_publico'];
            else
                $totalcarrito= $totalcarrito + $carrito['cantidad']*round(h($carrito['precio_publico'])*$descuento_pf, 3);*/
			$totalunidades = $totalunidades + $carrito['cantidad'];

			$cant_carrito = $carrito['cantidad'];
			$subtotal = 0;
			//MEDICAMENTOS
			if (($carrito['categoria_id'] != 5) && ($carrito['categoria_id'] != 4)  && ($carrito['categoria_id'] != 3) && ($carrito['categoria_id'] != 2)) {
				if ($carrito['categoria_id'] === 1)   $coef2 = 1;
				else $coef2 = $coef;
				if ($carrito['articulo']['laboratorio_id'] === 15) $coef2 = 0.892;

				//DESCUENTOS
				if ($carrito['descuento'] > 0) {
					//TIPO_VENTA=D
					if ($carrito['tipo_oferta_elegida'] == 'D') {
						$cant_uni_min = $carrito['unidad_minima'];
						//TIPO_PRECIO P
						if ($carrito['tipo_precio'] == 'P') {

							if ($cant_carrito >= $cant_uni_min) {
								$descuentooferta = $carrito['descuento'];
								$precio = $carrito['precio_publico'] * $coef2;
								$precio -= $precio * $descuentooferta / 100;
								$subtotal = $precio * $cant_carrito;
							} else {
								$precio  = $carrito['precio_publico'];
								if ($carrito['articulo']['iva'] == 1)
									if ($this->request->session()->read('Auth.User.codigo_postal') != 9410 && $this->request->session()->read('Auth.User.codigo_postal') != 9420) {
										$precio = $precio / (1.21);
									}


								$precio  = $precio * $descuento_pf * $coef2;
								if ($carrito['articulo']['msd'] != 1)
									$precio -= $precio * $condicion / 100;
								$subtotal = $precio * $cant_carrito;
							}
						} else {
							//TIPO_PRECIO F
							if ($carrito['tipo_precio'] == 'F') {
								$precio  = $carrito['precio_publico'];
								if ($carrito['articulo']['iva'] == 1)
									if ($this->request->session()->read('Auth.User.codigo_postal') != 9410 && $this->request->session()->read('Auth.User.codigo_postal') != 9420) {
										$precio = $precio / (1.21);
									}

								if ($cant_carrito >= $cant_uni_min) {
									$descuentooferta = $carrito['descuento'];
									$precio  = $precio * $descuento_pf * $coef2;
									if ($carrito['articulo']['msd'] != 1)
										$precio -= $precio * $condicion / 100;
									$precio -= $precio * $descuentooferta / 100;
									$subtotal = $precio * $cant_carrito;
								} else {

									if ($carrito['articulo']['mcdp'] == 0) {
										$precio  = $precio * $descuento_pf * $coef2;
										if ($carrito['articulo']['msd'] != 1) {
											$precio -= $precio * $condicion / 100;
										}
									} else {
										$precio -= $precio * ($condiciongeneral - 1) / 100;
									}
									$subtotal = $precio * $cant_carrito;

									//$subtotal = $precio*$descuento_pf*$coef2*$cant_carrito; 

								}
							}
						}
					} else {
						$precio  = $carrito['precio_publico'];
						if ($carrito['articulo']['mcdp'] == 0) {
							$precio  = $precio * $descuento_pf * $coef2;
							if ($carrito['articulo']['msd'] != 1) {
								$precio -= $precio * $condicion / 100;
							}
						} else {
							$precio -= $precio * ($condiciongeneral - 1) / 100;
						}
						$subtotal = $precio * $cant_carrito;
					}
				} else {
					$precio = $carrito['precio_publico'];
					if ($carrito['articulo']['iva'] == 1)
						if ($this->request->session()->read('Auth.User.codigo_postal') != 9410 && $this->request->session()->read('Auth.User.codigo_postal') != 9420) {
							$precio = $precio / (1.21);
						}

					if ($carrito['articulo']['mcdp'] == 0) {
						$precio  = $precio * $descuento_pf * $coef2;
						if ($carrito['articulo']['msd'] != 1) {
							$precio -= $precio * $condicion / 100;
						}
					} else {
						$precio -= $precio * ($condiciongeneral - 1) / 100;
					}
					$subtotal = $precio * $cant_carrito;
					if ($this->request->session()->read('Auth.User.codigo_postal') == 9410 || $this->request->session()->read('Auth.User.codigo_postal') == 9420) {
						$subtotal = $subtotal * $carrito['articulo']['tf_coef'];
					}
				}
				if ($carrito['articulo']['cadena_frio'] == 1 && $carrito['articulo']['subcategoria_id'] != 10)
					$subtotal = $subtotal * 1.0248;
			} else {
				if ($carrito['descuento'] > 0) {
					if ($carrito['tipo_oferta_elegida'] == 'D') {
						$cant_uni_min = $carrito['unidad_minima'];
						if ($cant_carrito >= $cant_uni_min) {
							$descuentooferta = $carrito['descuento'];
							$precio = $carrito['precio_publico'];
							if ($carrito['tipo_precio'] == 'P') {
								$precio -= $precio * $descuentooferta / 100;
							}
							if ($carrito['tipo_precio'] == 'F') {

								$precio = $precio * $descuento_pf;
								//$precio -= $precio*$condicion/100;
								$precio -= $precio * $descuentooferta / 100;
							}
							$subtotal = $precio * $cant_carrito;
						} else {

							$precio = $carrito['precio_publico'] * $descuento_pf;
							if ($coef != 1) $precio = $precio * $coef;
							$subtotal = $precio * $cant_carrito;
						}
					}
				} else {
					if ($carrito['articulo']['id'] > 27338 && $carrito['articulo']['id'] < 27345)
						$descuento_pf = 0.807;
					else
						$descuento_pf = $descuento_pf2;

					$precio = $carrito['precio_publico'] * $descuento_pf * $coef;
					$subtotal = $precio * $cant_carrito;

					if ($this->request->session()->read('Auth.User.codigo_postal') == 9410 || $this->request->session()->read('Auth.User.codigo_postal') == 9420) {
						$subtotal = $subtotal * $carrito['articulo']['tf_coef'];
					}
				}
			}

			$totalcarrito = $totalcarrito + $subtotal;
			if (($carrito['articulo']['stock'] == "B") || ($carrito['articulo']['stock'] == "S") || ($carrito['articulo']['stock'] == "R"))
				$totalcarritostock = $totalcarritostock + $subtotal;

			if (!empty($articulo_id_cart))
				if ($articulo_id_cart == $carrito['articulo']['id'])
					$subtotalultimo = $subtotal;


		endforeach;

		$listaarray = array();
		array_push($listaarray, $totalitems);
		array_push($listaarray, $totalcarrito);
		array_push($listaarray, $totalcarritostock);
		array_push($listaarray, $totalunidades);
		array_push($listaarray, $subtotalultimo);

		$this->set('totalitems', $totalitems);
		$this->set('totalcarrito', $totalcarrito);
		$this->set('totalcarritostock', $totalcarritostock);
		$this->set('totalunidades', $totalunidades);
		$this->set('subtotal', $subtotalultimo);

		return $listaarray;
	}

	// 05/07/21
	public function comboupdate($id = null, $calc = null, $articulo_id = null)
	{
		$this->loadModel('Descuentos');
		$this->loadModel('Articulos');

		$articuloscombos = $this->Articulos->find('all')

			->contain([
				'Laboratorios', 'Descuentos', 'Carritos' => [

					'queryBuilder' => function ($q) {
						return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); // Full conditions for filtering
					}
				]
			])

			->join([
				'table' => 'descuentos',
				'alias' => 'd',
				'type' => 'inner',
				'conditions' => ['d.articulo_id = Articulos.id']
			])


			->where(['d.combo_id' => $id]);
		//,'CarritosPreventas.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')
		foreach ($articuloscombos as $articulo) {
			$descuento = $articulo['decuentos'][0];

			if ($articulo_id <> $articulo['id'])
				if (!empty($articulo['carritos'])) {
					if (!is_null($articulo['carritos'])) {
						//echo json_encode($articulo['carritos']['0']['id']);
						// no vacio
						//$carro = $this->CarritosPreventas->newEntity();
						$carro = $this->Carritos->get($articulo['carritos']['0']['id']);
						//echo json_encode($carro);
						$carro['cantidad'] = $calc * $carro['multiplo'];
						if ($this->Carritos->save($carro)) {
							echo json_encode($carro);
							//$responseData = ['success' => true,'responseText'=>"'Se modifico la cantidad correctamente.'",'status'=>200 ];		


						}
					}
				} else {
					//Vacio

					$carro = $this->Carritos->newEntity();
					$carro['cliente_id'] = $this->request->session()->read('Auth.User.cliente_id');
					$carro['articulo_id'] = $descuento['articulo_id'];
					$carro['descripcion'] = $articulo['descripcion_sist'];
					$carro['descuento_id'] = $descuento['id'];

					$carro['descuento'] = $descuento['dto_drogueria'];
					$carro['unidad_minima'] = $descuento['uni_min'];
					$carro['tipo_precio'] = $descuento['tipo_precio'];
					$carro['plazoley_dcto'] = $descuento['plazo'];
					//$carro['combo'] =$descuento['combo'];
					$carro['combo_id'] = $descuento['combo_id'];
					$carro['tipo_oferta'] = $descuento['tipo_oferta'];

					$carro['tipo_fact'] = 'N';
					$carro['categoria_id'] = $articulo['categoria_id'];
					$carro['compra_min'] = 1;
					$carro['compra_multiplo'] = $descuento['multiplo'];
					$carro['compra_max'] = $descuento['uni_tope'];
					$carro['compra_cerrado'] = $descuento['combo_cerrado'];
					//$carro['proveedor_id'] =$descuento['proveedor_id'];
					$carro['cantidad'] = $calc * $descuento['multiplo'];


					if ($this->Carritos->save($carro)) {

						//echo json_encode($carro);
						//$responseData = ['success' => true,'responseText'=>"'Se modifico la cantidad correctamente.'",'status'=>200 ];		


					}
				}
		}
	}
	// 05/07/21

	private function validarUnidadesRectriciones($art, $unidades, $restringidoUni)
	{

		$fechaInicio = new \DateTimeImmutable('today');
		$fechaFin = (new \DateTimeImmutable('tomorrow'))->modify('-1 second');

		$this->loadModel('PedidosItems');
		$Pedido = $this->PedidosItems->find()
			->contain(['Pedidos'])
			->where([
				'PedidosItems.articulo_id' => $art,
				'Pedidos.cliente_id' => $this->request->session()->read('Auth.User.cliente_id'),
				'Pedidos.creado >=' => $fechaInicio->format('Y-m-d H:i:s'),
				'Pedidos.creado <=' => $fechaFin->format('Y-m-d H:i:s')
			])->toList();

		if (!empty($Pedido)) {
			$totalCantidad = collection($Pedido)->sumOf('cantidad');

			$arrayresult = [];

			if ($totalCantidad >= $restringidoUni) {
				$arrayresult = ['validar' => 0, 'cantidad' => 0, 'limite' => 0];
				return $arrayresult;
			} else {

				$restante = $restringidoUni - $totalCantidad;
				if ($unidades <=  $restante) {

					$arrayresult = ['validar' => 1, 'cantidad' => $unidades, 'limite' => $restringidoUni];
				} else {
					$arrayresult = ['validar' => 1, 'cantidad' => $restante, 'limite' => $restringidoUni];
				}
			}
		} else {
			if ($unidades <=  $restringidoUni) {
				$arrayresult = ['validar' => 1, 'cantidad' => $unidades, 'limite' => $restringidoUni];
			} else {

				$arrayresult = ['validar' => 1, 'cantidad' => $restringidoUni, 'limite' => $restringidoUni];
			}
		}
		return $arrayresult;
	}

	public function itemupdate()
	{
		$responseData = "";
		$this->loadComponent('RequestHandler');
		if ($this->request->is(['ajax', 'post'])) {
			if (!empty($this->request->data)) {
				if (isset($this->request->data['id'])) {
					if (!empty($this->request->data['id'])) {
						$id = $this->request->data['id'];
						$quantity = isset($this->request->data['quantity']) ? $this->request->data['quantity'] : 1;
						$descuento_id = $this->request->data['descuento_id'];
						$validarUni = [];
						$this->loadModel('Descuentos');
						$this->loadModel('Articulos');
						$descuento = $this->Descuentos->find()->where(['id' => $descuento_id])->first([]);
						$this->set("carrito_pv", $descuento);

						$articulo = $this->Articulos->find()->where(['id' => $id])->first([]);
						$this->set("articulo_pv", $articulo);

						if (!empty($articulo)) {

							//$carro = $this->CarritosPreventas->newEntity();
							$carro = $this->Carritos->find()->where(['articulo_id' => $id, 'cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])->first([]);
							//debug($this->request->data['cantidad']);
							$this->set("carrito_pv_carro", $carro);

							if ($quantity > 0) {
								//if (!in_array($articulo['laboratorio_id'], $laboratoriosExcluidos)) {}
								if ($articulo['restringido_unid'] > 0 || $articulo['restringido_unid_w'] > 0) {
									if (!empty($articulo['restringido_unid']) && $articulo['restringido_unid'] !== 0) {
										$restringidoUni = $articulo['restringido_unid'];
									} elseif (!empty($articulo['restringido_unid_w']) && $articulo['restringido_unid_w'] !== 0) {
										$restringidoUni = $articulo['restringido_unid_w'];
									}
									$validarUni =  $this->validarUnidadesRectriciones($id, $quantity, $restringidoUni);
									$quantity = $validarUni['cantidad'];
								}
							}

							if (empty($carro)) {

								$carro = $this->Carritos->newEntity();
								$carro['cliente_id'] = $this->request->session()->read('Auth.User.cliente_id');
								$carro['articulo_id'] = $articulo['id'];
								$carro['descripcion'] = $articulo['descripcion_sist'];
								$carro['descuento_id'] = $articulo['descuento_id'];
								$carro['categoria_id'] = $articulo['categoria_id'];
								$carro['precio_publico'] = $articulo['precio_publico'];
								$carro['descripcion'] = $articulo['descripcion_pag'];
								//$carro['tipo_oferta']  = $articulo['descuentos'][0]['tipo_oferta'];
								$carro['user_id'] = $this->request->session()->read('Auth.User.id');




								if (!empty($descuento)) {
									if (($descuento['tipo_precio'] == 'P') 	&& ($descuento['tipo_oferta'] == 'TH')) {
										$descuento_pf = $this->request->session()->read('Auth.User.pf_dcto');
										$condicion = $this->request->session()->read('Auth.User.condicion');
										$condiciongeneral = 100 * (1 - ($descuento_pf * (1 - $condicion / 100)));
										$descuentooferta = $descuento['dto_drogueria'] + $condiciongeneral;
									} else
										$descuentooferta =  $descuento['dto_drogueria'];
									$carro['descuento'] = $descuentooferta;
									$carro['plazoley_dcto'] = $descuento['plazo'];
									$carro['unidad_minima'] = $descuento['uni_min'];
									$carro['tipo_oferta'] = $descuento['tipo_oferta'];
									$carro['tipo_venta'] = $descuento['tipo_venta'];
									$carro['tipo_precio'] = $descuento['tipo_precio'];
									$carro['combo_tipo_id'] = $descuento['combo_tipo_id'];
									$carro['descuento_id'] = $descuento['id'];
									$carro['tipo_oferta_elegida'] = $descuento['tipo_venta'];
									$carro['combo_id'] = $descuento['combo_id'];
									if ($descuento['multiplo'] > 0)
										$carro['multiplo'] = $descuento['multiplo'];
									else
										$carro['multiplo'] = 1;
								} else {

									$carro['descuento'] = 0;
									$carro['plazoley_dcto'] = 'HABITUAL';
									$carro['unidad_minima'] = 1;
									$carro['tipo_oferta'] = null;
									$carro['tipo_venta'] = null;
									$carro['tipo_precio'] = null;
									$carro['combo_id'] = 0;
									$carro['multiplo'] = 1;
									$carro['combo_tipo_id'] = 0;
									$carro['descuento_id'] = 0;
								}


								$carro['creado'] = date('Y-m-d H:i:s');
								$carro['tipo_oferta_elegida'] = $carro['tipo_venta'];
								if ($carro['tipo_precio'] == 'P' && ($carro['tipo_oferta'] == 'TD' || $carro['tipo_oferta'] == 'TL' || $carro['tipo_oferta'] == 'OR' || $carro['tipo_oferta'] == 'OD' || $carro['tipo_oferta'] == 'TH'))
									$carro['tipo_fact'] = 'TR';
								else
					        	if ($carro['tipo_precio'] == 'F' && ($carro['tipo_oferta'] == 'TD' || $carro['tipo_oferta'] == 'TL' || $carro['tipo_oferta'] == 'OR' || $carro['tipo_oferta'] == 'OD' || $carro['tipo_oferta'] == 'TH'))
									$carro['tipo_fact'] = 'TL';
								else
									$carro['tipo_fact'] = 'N';


								//$carro['proveedor_id'] =$descuento['proveedor_id'];

								$this->request->session()->write('descuento', $descuento);
							}
							/*echo json_encode($quantity); ->pasar datos*/
							if (((int)$quantity > 0) && ((int)$quantity < 10000)) {
								$carro['cantidad'] = $quantity;

								//* 18/10/23 */
								//if ($carro['cantidad']>3) $carro['cantidad']=3;





								if (!empty($descuento)) {

									if ($descuento['evento'] == 'SC') {
										if ($carro['unidad_minima'] > $carro['cantidad'])
											$carro['cantidad'] = $carro['unidad_minima'];
										else
											$carro['cantidad'] = $quantity;
									}
								}


								//if ($carro['unidad_minima'] > $carro['cantidad'])
								//$carro['cantidad'] = $carro['unidad_minima'];
								//else
								//	$carro['cantidad'] = $quantity;

								if ($carro['combo_id'] > 0) {
									if ($carro['combo_tipo_id'] == 3) {
										//bayer
										if (($quantity % $carro['multiplo']) == 0) {
											//
											$calc = intdiv($quantity, $carro['multiplo']);
											//$this->comboupdate($carro['combo_id'], $calc, $carro['articulo_id']);
											// es multiplo
											// llevar al resto del combo.
										} else {

											//llevar al multiplo
											$div = intdiv($quantity, $carro['multiplo']);
											//$div = number_format($div,0);
											$calc = $div + 1;
											$llevar =  ($calc) * $carro['multiplo'];

											$carro['cantidad'] = $llevar;
											// Resto del combo
											//$this->comboupdate($carro['combo_id'], $calc, $carro['articulo_id']);
										}
									}
								}
								$categoria = (int)$articulo['categoria_id'];
								$validar = true;
								if ($this->request->session()->read('Auth.User.habilitado') == 2) {
									if ($categoria == 6 || $categoria == 7) {
										$responseData = ['6 0 7' => true, 'responseText' => "6", 'status' => 200];
										$validar = false;
										//$this->Flash->error('No se puede agregar este producto al carro de compras. ',['key' => 'changepass']);
										//return $this->redirect($this->referer());					
									}
								}
								if ($this->request->session()->read('Auth.User.habilitado') == 3) {
									if ($categoria != 5 && $categoria != 4) {
										$responseData = ['4 o 5' => true, 'responseText' => "5", 'status' => 200];
										//$this->Flash->error('No se puede agregar este producto al carro de compras. ',['key' => 'changepass']);
										//return $this->redirect($this->referer());
										$validar = false;
									}
									if ($categoria == 5 && $articulo['restringido_perf'] != 0) {
										$responseData = ['0' => true, 'responseText' => "0", 'status' => 200];
										//$this->Flash->error('No se puede agregar este producto al carro de compras. ',['key' => 'changepass']);
										//return $this->redirect($this->referer());
										$validar = false;
									}
								}

								if ($this->request->session()->read('Auth.User.gln') == 000000000000 && $articulo['trazable'] == 1) {
									$responseData = ['2 o 4 0 5' => true, 'responseText' => "5", 'status' => 200];
									$validar = false;
								}

								if ($articulo['solo_adherido'] == 1 && $this->request->session()->read('Auth.User.adherido_cofa') == 0) {

									$responseData = ['7' => true, 'responseText' => "7", 'status' => 200];
									$validar = false;
									//$this->Flash->error('No se puede agregar este producto al carro de compras. ',['key' => 'changepass']);
									//return $this->redirect($this->referer());					

								}
								if ($this->request->session()->read('Auth.User.habilitado') == 4) {
									if ($categoria != 5 && $categoria != 4 && $categoria != 2) {
										$responseData = ['2 o 4 0 5' => true, 'responseText' => "5", 'status' => 200];
										$validar = false;
										//$this->Flash->error('No se puede agregar este producto al carro de compras. ',['key' => 'changepass']);
										//return $this->redirect($this->referer());					
									}
								}
								if ($categoria == 7) {
									$responseData = ['7' => true, 'responseText' => "7", 'status' => 200];
									$validar = false;
									//$this->Flash->error('No se puede agregar este producto al carro de compras. ',['key' => 'changepass']);
									//return $this->redirect($this->referer());
								}



								if ($validar) {
									if ($this->Carritos->save($carro)) {
										if ($articulo["stock"] == "F")
											$this->agregarfalta($carro['articulo_id'], $carro['cliente_id'], $carro['cantidad']);
										$contenidocarrito = $this->contenidoCarrito();
										$subtotales = $this->calcularsubtotales($contenidocarrito, $carro['articulo_id']);
										$responseData = ['success' => true, 'responseText' => "ok", 'status' => 200, 'carros' => $carro, 'contenidocarro' => $contenidocarrito, 'subtotal' => $subtotales, 'validarUnidades' => $validarUni];
									} else {
										$responseData = ['success' => false, 'responseText' => "'No se pudo modificar la cantidad correctamente,'", 'status' => 400];
										$this->Flash->error('No se pudo agregar al carro de compras. Intente de nuevo', ['key' => 'changepass']);
									}
								}
							} else {
								$validar = true;
								if ((int)$quantity == 0) {
									$carritos = $this->Carritos->find('all')
										->where(['cliente_id' => $carro['cliente_id']])
										->where(['articulo_id' =>  $carro['articulo_id']])
										->first();
									if ($carritos != null) {

										$conn = ConnectionManager::get('default');
										$conn->query('CALL CopiarCarritoItemDelete(' . $id . ');');

										if ($this->Carritos->delete($carritos))
											$this->sumacarrito();
										$contenidocarrito = $this->contenidoCarrito();
										$subtotales = $this->calcularsubtotales($contenidocarrito, $carro['articulo_id']);
										$responseData = ['success' => true, 'responseText' => "eliminado", 'status' => 200, 'carros' => $carritos, 'contenidocarro' => $contenidocarrito, 'subtotal' => $subtotales, 'validarUnidades' => $validarUni];

										//$this->Flash->success('Se elimino el producto de carro de compras.',['key' => 'changepass']);
										//$this->redirect($this->referer());
									} else {
										$responseData = ['successs' => false, 'responseText' => "Sin datos", 'status' => 400];
									}
								}
							}
						} else {

							$responseData = ['success' => true, 'responseText' => "nosepudoagregar", 'status' => 200, 'carros' => '', 'contenidocarro' => '', 'subtotal' => ''];
						}
					} else {

						$responseData = ['success' => true, 'responseText' => "nosepudoagregar", 'status' => 200, 'carros' => '', 'contenidocarro' => '', 'subtotal' => ''];
					}
				} else {

					$responseData = ['success' => true, 'responseText' => "nosepudoagregar", 'status' => 200, 'carros' => '', 'contenidocarro' => '', 'subtotal' => ''];
				}
			} else {
				$responseData = ['success' => true, 'responseText' => "nosepudoagregar", 'status' => 200, 'carros' => '', 'contenidocarro' => '', 'subtotal' => ''];
			}
			echo json_encode($responseData);
			if (isset($subtotales)) {
				$totalcarrito = $subtotales[1];
				$totalunidades = $subtotales[3];
				$totalitems = $subtotales[0];
				$carritos = $contenidocarrito;
				//echo json_encode($carro);
				$totalcarrito = $subtotales[1];
				$totalunidades = $subtotales[3];
				$totalitems = $subtotales[0];
				$carritos = $contenidocarrito;
				$this->request->session()->write('totalcarrito', $totalcarrito);
				$this->request->session()->write('totalunidades', $totalunidades);
				$this->request->session()->write('totalitems', $totalitems);
				$this->request->session()->write('carritos', $carritos);
			}
			$this->set('responseData', $responseData);
			$this->set('_serialize', ['responseData']);
		}

		die;
	}

	public function agregarfalta($articulo_id, $cliente_id, $cantidad)
	{
		$this->loadModel('CarritosFaltas');
		$carro = $this->CarritosFaltas->newEntity();
		$carro['cliente_id'] = $cliente_id;
		$carro['articulo_id'] = $articulo_id;
		$carro['cantidad_solicitada'] = $cantidad;
		$carro['user_id'] = $this->request->session()->read('Auth.User.id');
		$carro['creado'] = date('Y-m-d H:i:s');
		if ($this->CarritosFaltas->save($carro)) {
		}
	}


	public function itemupdatetemps()
	{
		$this->loadComponent('RequestHandler');
		if ($this->request->is(['ajax', 'post'])) {
			if (!empty($this->request->data)) {
				if (isset($this->request->data['id'])) {
					if (!empty($this->request->data['id'])) {
						$id = $this->request->data['id'];
						$quantity = isset($this->request->data['quantity']) ? $this->request->data['quantity'] : 1;
						$descuento_id = $this->request->data['descuento_id'];
						$validarUni = [];
						$this->loadModel('Descuentos');
						$this->loadModel('Articulos');
						$this->loadModel('CarritosTemps');
						$descuento = $this->Descuentos->find()->where(['id' => $descuento_id])->first([]);
						$this->set("carrito_pv", $descuento);

						$articulo = $this->Articulos->find()->where(['id' => $id])->first([]);
						if (!empty($articulo)) {

							$this->set("articulo_pv", $articulo);

							//$carro = $this->CarritosPreventas->newEntity();
							$carro = $this->CarritosTemps->newEntity();
							$carro = $this->CarritosTemps->find()->where(['articulo_id' => $id, 'cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])->first([]);
							//debug($this->request->data['cantidad']);
							$this->set("carrito_temps_pv_carro", $carro);
							if ($quantity > 0) {
								//if (!in_array($articulo['laboratorio_id'], $laboratoriosExcluidos)) {}
								if ($articulo['restringido_unid'] > 0 || $articulo['restringido_unid_w'] > 0) {
									if (!empty($articulo['restringido_unid']) && $articulo['restringido_unid'] !== 0) {
										$restringidoUni = $articulo['restringido_unid'];
									} elseif (!empty($articulo['restringido_unid_w']) && $articulo['restringido_unid_w'] !== 0) {
										$restringidoUni = $articulo['restringido_unid_w'];
									}
									$validarUni =  $this->validarUnidadesRectriciones($id, $quantity, $restringidoUni);
									$quantity = $validarUni['cantidad'];
								}
							}


							if (empty($carro)) {

								$carro = $this->CarritosTemps->newEntity();
								$carro['cliente_id'] = $this->request->session()->read('Auth.User.cliente_id');
								$carro['articulo_id'] = $articulo['id'];
								$carro['descripcion'] = $articulo['descripcion_sist'];
								$carro['descuento_id'] = $articulo['descuento_id'];
								$carro['categoria_id'] = $articulo['categoria_id'];
								$carro['precio_publico'] = $articulo['precio_publico'];
								$carro['descripcion'] = $articulo['descripcion_pag'];
								//$carro['tipo_oferta']  = $articulo['descuentos'][0]['tipo_oferta'];
								$carro['user_id'] = $this->request->session()->read('Auth.User.id');
								if (!empty($descuento)) {


									if (($descuento['tipo_precio'] == 'P') 	&& ($descuento['tipo_oferta'] == 'TH')) {
										$descuento_pf = $this->request->session()->read('Auth.User.pf_dcto');
										$condicion = $this->request->session()->read('Auth.User.condicion');
										$condiciongeneral = 100 * (1 - ($descuento_pf * (1 - $condicion / 100)));
										$descuentooferta = $descuento['dto_drogueria'] + $condiciongeneral;
									} else
										$descuentooferta =  $descuento['dto_drogueria'];

									$carro['descuento'] = $descuentooferta;
									$carro['plazoley_dcto'] = $descuento['plazo'];
									$carro['unidad_minima'] = $descuento['uni_min'];
									$carro['tipo_oferta'] = $descuento['tipo_oferta'];
									$carro['tipo_venta'] = $descuento['tipo_venta'];
									$carro['tipo_precio'] = $descuento['tipo_precio'];
									$carro['combo_tipo_id'] = $descuento['combo_tipo_id'];
									$carro['descuento_id'] = $descuento['id'];
									$carro['tipo_oferta_elegida'] = $descuento['tipo_venta'];
									$carro['combo_id'] = 0;
								} else {

									$carro['descuento'] = 0;
									$carro['plazoley_dcto'] = 'HABITUAL';
									$carro['unidad_minima'] = 1;
									$carro['tipo_oferta'] = null;
									$carro['tipo_venta'] = null;
									$carro['tipo_precio'] = null;
									$carro['combo_id'] = 0;
									$carro['multiplo'] = 1;
									$carro['combo_tipo_id'] = 0;
									$carro['descuento_id'] = 0;
								}



								//$carro['proveedor_id'] =$descuento['proveedor_id'];

								$this->request->session()->write('descuento', $descuento);
							}
							/*echo json_encode($quantity); ->pasar datos*/
							if (((int)$quantity > 0) && ((int)$quantity < 10000)) {
								$carro['cantidad'] = $quantity;
								$validar = true;

								//if ($carro['cantidad'] >7)  $carro['cantidad'] =7;
								/*
					if ($carro['unidad_minima'] > $carro['cantidad'])
					$carro['cantidad'] = $carro['unidad_minima'];*/
								//else
								//	$carro['cantidad'] = $quantity;

								if ($carro['combo_id'] > 0) {
									if ($carro['compra_multiplo'] > 1 && $carro['compra_cerrado'] > 0) {
										//bayer
										if (($quantity % $carro['compra_multiplo']) == 0) {
											//
											$calc = intdiv($quantity, $carro['compra_multiplo']);

											//$this->comboupdate($carro['combo_id'], $calc, $carro['articulo_id']);

											// es multiplo
											// llevar al resto del combo.
										} else {

											//llevar al multiplo
											$div = intdiv($quantity, $carro['compra_multiplo']);
											//$div = number_format($div,0);
											$calc = $div + 1;
											$llevar =  ($calc) * $carro['compra_multiplo'];

											$carro['cantidad'] = $llevar;
											// Resto del combo
											//$this->comboupdate($carro['combo_id'], $calc, $carro['articulo_id']);
										}
									}
								}
								$categoria = (int)$articulo['categoria_id'];



								if ($this->request->session()->read('Auth.User.habilitado') == 2) {
									if ($categoria == 6 || $categoria == 7) {
										$responseData = ['6 0 7' => true, 'responseText' => "6", 'status' => 200];
										$validar = false;
									}
								}
								if ($this->request->session()->read('Auth.User.habilitado') == 3) {
									if ($categoria != 5 && $categoria != 4) {
										$responseData = ['4 o 5' => true, 'responseText' => "5", 'status' => 200];
										$validar = false;
									}
									if ($categoria == 5 && $articulo['restringido_perf'] != 0) {
										$responseData = ['0' => true, 'responseText' => "0", 'status' => 200];
										$validar = false;
									}
								}
								if ($this->request->session()->read('Auth.User.habilitado') == 4) {
									if ($categoria != 5 && $categoria != 4 && $categoria != 2) {
										$responseData = ['2 o 4 0 5' => true, 'responseText' => "5", 'status' => 200];
										$validar = false;
									}
								}
								if ($categoria == 7) {
									$validar = false;
								}



								if ($validar) {
									if ($this->CarritosTemps->save($carro)) {
										$contenidocarritotemps = $this->contenidoCarritoTemps();
										$subtotales = $this->calcularsubtotales($contenidocarritotemps);
										$responseData = ['success' => true, 'responseText' => "ok", 'status' => 200, 'subtotal' => $subtotales, 'contenidocarrotemps' => $contenidocarritotemps, 'validarUnidades' => $validarUni];
									} else {
										$responseData = ['success' => false, 'responseText' => "'No se pudo modificar la cantidad correctamente,'", 'status' => 400];
										$this->Flash->error('No se pudo agregar al carro de compras. Intente de nuevo', ['key' => 'changepass']);
									}
								}
							} else {
								$validar = true;
								if ((int)$quantity == 0) {
									$carritos = $this->CarritosTemps->find('all')
										->where(['cliente_id' => $carro['cliente_id']])
										->where(['articulo_id' =>  $carro['articulo_id']])
										->first();
									if ($carritos != null) {

										$conn = ConnectionManager::get('default');
										$conn->query('CALL CopiarCarritoItemDelete(' . $id . ');');

										if ($this->CarritosTemps->delete($carritos))
											$this->sumacarritotemp();
										$contenidocarritotemps = $this->contenidoCarritoTemps();
										$subtotales = $this->calcularsubtotales($contenidocarritotemps);
										$responseData = ['success' => true, 'responseText' => "eliminado", 'status' => 200, 'carros' => $carritos, 'contenidocarrotemps' => $contenidocarritotemps, 'subtotal' => $subtotales, 'validarUnidades' => $validarUni];

										//$this->Flash->success('Se elimino el producto de carro de compras.',['key' => 'changepass']);
										//$this->redirect($this->referer());
									} else {
										$responseData = ['successs' => false, 'responseText' => "Sin datos", 'status' => 400];
									}
								} else
									$responseData = ['successs' => false, 'responseText' => "Sin datos", 'status' => 400];
							}
						} else {

							$responseData = ['success' => true, 'responseText' => "nosepudoagregar", 'status' => 200, 'carros' => '', 'contenidocarro' => '', 'subtotal' => ''];
						}
					} else {
						$responseData = ['success' => true, 'responseText' => "nosepudoagregar", 'status' => 200, 'carros' => '', 'contenidocarro' => '', 'subtotal' => ''];
					}
				} else {
					$responseData = ['success' => true, 'responseText' => "nosepudoagregar", 'status' => 200, 'carros' => '', 'contenidocarro' => '', 'subtotal' => ''];
				}
			} else {
				$responseData = ['success' => true, 'responseText' => "nosepudoagregar", 'status' => 200, 'carros' => '', 'contenidocarro' => '', 'subtotal' => ''];
			}
			echo json_encode($responseData);

			//echo json_encode($carro);
			$this->set('responseData', $responseData);
			$this->set('_serialize', ['responseData']);

		}


		die;
	}

	public function contenidoCarritotemps()
	{
		$carritocon1 = $this->CarritosTemps->find('all')
			->contain(['Articulos'])
			->where(['CarritosTemps.cliente_id' => $this->request->session()->read('Auth.User.cliente_id'), 'CarritosTemps.cantidad  < CarritosTemps.unidad_minima', 'CarritosTemps.unidad_minima IS NOT NULL'])
			->order(['CarritosTemps.id' => 'DESC']);

		$carritocon2 = $this->CarritosTemps->find('all')
			->contain(['Articulos'])
			->where(['CarritosTemps.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
			->andWhere([

				'OR' => [
					['CarritosTemps.cantidad  >= CarritosTemps.unidad_minima '],
					['CarritosTemps.unidad_minima IS NULL']
				]
			])
			->order(['CarritosTemps.id' => 'DESC']);
		$c1 = $carritocon1->toArray();
		$c2 = $carritocon2->toArray();
		$carritocon = array_merge($c1, $c2);

		$this->set('carritos', $carritocon);
		return $carritocon;
	}



	// 12/07/21
	public function itemupdateofertas()
	{
		$this->loadComponent('RequestHandler');
		if ($this->request->is(['ajax', 'post'])) {
			if (!empty($this->request->data)) {
				if (isset($this->request->data['id'])) {
					if (!empty($this->request->data['id'])) {
						$id = $this->request->data['id'];
						$quantity = isset($this->request->data['quantity']) ? $this->request->data['quantity'] : 1;
						$descuento_id = $this->request->data['descuento_id'];
						$validarUni = [];
						$this->loadModel('Descuentos');
						$this->loadModel('Articulos');
						$descuento = $this->Descuentos->find()->where(['id' => $descuento_id])->first([]);
						$this->set("carrito_pv", $descuento);

						$articulo = $this->Articulos->find()->where(['id' => $id])->first([]);
						if (!empty($articulo)) {
							$this->set("articulo_pv", $articulo);

							//$carro = $this->CarritosPreventas->newEntity();
							$carro = $this->Carritos->find()->where(['articulo_id' => $id, 'cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])->first([]);
							//debug($this->request->data['cantidad']);
							$this->set("carrito_pv_carro", $carro);
							if ($quantity > 0) {
								//if (!in_array($articulo['laboratorio_id'], $laboratoriosExcluidos)) {}
								if ($articulo['restringido_unid'] > 0 || $articulo['restringido_unid_w'] > 0) {
									if (!empty($articulo['restringido_unid']) && $articulo['restringido_unid'] !== 0) {
										$restringidoUni = $articulo['restringido_unid'];
									} elseif (!empty($articulo['restringido_unid_w']) && $articulo['restringido_unid_w'] !== 0) {
										$restringidoUni = $articulo['restringido_unid_w'];
									}
									$validarUni =  $this->validarUnidadesRectriciones($id, $quantity, $restringidoUni);
									$quantity = $validarUni['cantidad'];
								}
							}

							if (empty($carro)) {

								$carro = $this->Carritos->newEntity();
								$carro['cliente_id'] = $this->request->session()->read('Auth.User.cliente_id');
								$carro['articulo_id'] = $articulo['id'];
								$carro['descripcion'] = $articulo['descripcion_sist'];
								$carro['descuento_id'] = $articulo['descuento_id'];
								$carro['categoria_id'] = $articulo['categoria_id'];
								$carro['precio_publico'] = $articulo['precio_publico'];
								$carro['descripcion'] = $articulo['descripcion_pag'];
								//$carro['tipo_oferta']  = $articulo['descuentos'][0]['tipo_oferta'];
								$carro['user_id'] = $this->request->session()->read('Auth.User.id');
								if (!empty($descuento)) {


									if (($descuento['tipo_precio'] == 'P') 	&& ($descuento['tipo_oferta'] == 'TH')) {
										$descuento_pf = $this->request->session()->read('Auth.User.pf_dcto');
										$condicion = $this->request->session()->read('Auth.User.condicion');
										$condiciongeneral = 100 * (1 - ($descuento_pf * (1 - $condicion / 100)));

										$descuentooferta = $descuento['dto_drogueria'] + $condiciongeneral;
									} else
										$descuentooferta =  $descuento['dto_drogueria'];

									$carro['descuento'] = $descuentooferta;
									$carro['plazoley_dcto'] = $descuento['plazo'];
									$carro['unidad_minima'] = $descuento['uni_min'];
									$carro['tipo_oferta'] = $descuento['tipo_oferta'];
									$carro['tipo_venta'] = $descuento['tipo_venta'];
									$carro['tipo_precio'] = $descuento['tipo_precio'];
									$carro['combo_tipo_id'] = $descuento['combo_tipo_id'];
									$carro['descuento_id'] = $descuento['id'];
									$carro['tipo_oferta_elegida'] = $descuento['tipo_venta'];
									$carro['combo_id'] = 0;
								} else {

									$carro['descuento'] = 0;
									$carro['plazoley_dcto'] = 'HABITUAL';
									$carro['unidad_minima'] = 1;
									$carro['tipo_oferta'] = null;
									$carro['tipo_venta'] = null;
									$carro['tipo_precio'] = null;
									$carro['combo_id'] = 0;
									$carro['multiplo'] = 1;
									$carro['combo_tipo_id'] = 0;
									$carro['descuento_id'] = 0;
								}


								$carro['creado'] = date('Y-m-d H:i:s');
								$carro['tipo_oferta_elegida'] = $carro['tipo_venta'];
								if ($carro['tipo_precio'] == 'P' && ($carro['tipo_oferta'] == 'TD' || $carro['tipo_oferta'] == 'TL' || $carro['tipo_oferta'] == 'OR' || $carro['tipo_oferta'] == 'OD' || $carro['tipo_oferta'] == 'TH'))
									$carro['tipo_fact'] = 'TR';
								else
								if ($carro['tipo_precio'] == 'F' && ($carro['tipo_oferta'] == 'TD' || $carro['tipo_oferta'] == 'TL' || $carro['tipo_oferta'] == 'OR' || $carro['tipo_oferta'] == 'OD' || $carro['tipo_oferta'] == 'TH'))
									$carro['tipo_fact'] = 'TL';
								else
									$carro['tipo_fact'] = 'N';

								//$carro['proveedor_id'] =$descuento['proveedor_id'];

								$this->request->session()->write('descuento', $descuento);
							}
							/*echo json_encode($quantity); ->pasar datos*/
							if (((int)$quantity > 0) && ((int)$quantity < 10000)) {
								$carro['cantidad'] = $quantity;

								if ($carro['unidad_minima'] > $carro['cantidad'])
									$carro['cantidad'] = $carro['unidad_minima'];
								//else
								//	$carro['cantidad'] = $quantity;
								/* 18/10/2023 */
								//if	($carro['cantidad']>7) 	$carro['cantidad']=7;

								if ($carro['combo_id'] > 0) {
									if ($carro['compra_multiplo'] > 1 && $carro['compra_cerrado'] > 0) {
										//bayer
										if (($quantity % $carro['compra_multiplo']) == 0) {
											//
											$calc = intdiv($quantity, $carro['compra_multiplo']);

											//$this->comboupdate($carro['combo_id'], $calc, $carro['articulo_id']);

											// es multiplo
											// llevar al resto del combo.
										} else {

											//llevar al multiplo
											$div = intdiv($quantity, $carro['compra_multiplo']);
											//$div = number_format($div,0);
											$calc = $div + 1;
											$llevar =  ($calc) * $carro['compra_multiplo'];

											$carro['cantidad'] = $llevar;
											// Resto del combo
											//$this->comboupdate($carro['combo_id'], $calc, $carro['articulo_id']);
										}
									}
								}
								$categoria = (int)$articulo['categoria_id'];
								$validar = true;
								if ($this->request->session()->read('Auth.User.habilitado') == 2) {
									if ($categoria == 6 || $categoria == 7) {
										$responseData = ['6 0 7' => true, 'responseText' => "6", 'status' => 200];
										$validar = false;
									}
								}
								if ($this->request->session()->read('Auth.User.habilitado') == 3) {
									if ($categoria != 5 && $categoria != 4) {
										$responseData = ['4 o 5' => true, 'responseText' => "5", 'status' => 200];
										$validar = false;
									}
									if ($categoria == 5 && $articulo['restringido_perf'] != 0) {
										$responseData = ['0' => true, 'responseText' => "0", 'status' => 200];
										$validar = false;
									}
								}
								if ($this->request->session()->read('Auth.User.habilitado') == 4) {
									if ($categoria != 5 && $categoria != 4 && $categoria != 2) {
										$responseData = ['2 o 4 0 5' => true, 'responseText' => "5", 'status' => 200];
										$validar = false;
									}
								}
								if ($categoria == 7) {
									$validar = false;
								}



								if ($validar) {
									if ($this->Carritos->save($carro)) {
										if ($articulo["stock"] == "F")
											$this->agregarfalta($carro['articulo_id'], $carro['cliente_id'], $carro['cantidad']);

										$contenidocarrito = $this->contenidoCarrito();
										$subtotales = $this->calcularsubtotales($contenidocarrito, $carro['articulo_id']);
										$responseData = ['success' => true, 'responseText' => "ok", 'status' => 200, 'carros' => $carro, 'contenidocarro' => $contenidocarrito, 'subtotal' => $subtotales, 'validarUnidades' => $validarUni];
									} else {
										$responseData = ['success' => false, 'responseText' => "'No se pudo modificar la cantidad correctamente,'", 'status' => 400];
										$this->Flash->error('No se pudo agregar al carro de compras. Intente de nuevo', ['key' => 'changepass']);
									}
								}
							} else {
								$validar = true;
								if ((int)$quantity == 0) {
									$carritos = $this->Carritos->find('all')
										->where(['cliente_id' => $carro['cliente_id']])
										->where(['articulo_id' =>  $carro['articulo_id']])
										->first();
									if ($carritos != null) {

										$conn = ConnectionManager::get('default');
										$conn->query('CALL CopiarCarritoItemDelete(' . $id . ');');

										if ($this->Carritos->delete($carritos))
											$this->sumacarrito();
										$contenidocarrito = $this->contenidoCarrito();
										$subtotales = $this->calcularsubtotales($contenidocarrito, $carro['articulo_id']);
										$responseData = ['success' => true, 'responseText' => "eliminado", 'status' => 200, 'carros' => $carritos, 'contenidocarro' => $contenidocarrito, 'subtotal' => $subtotales, 'validarUnidades' => $validarUni];

										//$this->Flash->success('Se elimino el producto de carro de compras.',['key' => 'changepass']);
										//$this->redirect($this->referer());
									} else {
										$responseData = ['successs' => false, 'responseText' => "Sin datos", 'status' => 400];
									}
								}
							}
						} else {
							$responseData = ['success' => true, 'responseText' => "nosepudoagregar", 'status' => 200, 'carros' => '', 'contenidocarro' => '', 'subtotal' => ''];
						}
					} else {
						$responseData = ['success' => true, 'responseText' => "nosepudoagregar", 'status' => 200, 'carros' => '', 'contenidocarro' => '', 'subtotal' => ''];
					}
				} else {
					$responseData = ['success' => true, 'responseText' => "nosepudoagregar", 'status' => 200, 'carros' => '', 'contenidocarro' => '', 'subtotal' => ''];
				}
			} else {

				$responseData = ['success' => true, 'responseText' => "nosepudoagregar", 'status' => 200, 'carros' => '', 'contenidocarro' => '', 'subtotal' => ''];
			}
			echo json_encode($responseData);
			if (isset($subtotales)) {
				$totalcarrito = $subtotales[1];
				$totalunidades = $subtotales[3];
				$totalitems = $subtotales[0];
				$carritos = $contenidocarrito;
				$totalcarrito = $subtotales[1];
				$totalunidades = $subtotales[3];
				$totalitems = $subtotales[0];
				$carritos = $contenidocarrito;
				$this->request->session()->write('totalcarrito', $totalcarrito);
				$this->request->session()->write('totalunidades', $totalunidades);
				$this->request->session()->write('totalitems', $totalitems);
				$this->request->session()->write('carritos', $carritos);
			}
			$this->set('responseData', $responseData);
			$this->set('_serialize', ['responseData']);
		}

		die;
	}

	public function importresulttemp()
	{
		$this->viewBuilder()->layout('store');
		$this->loadModel('Articulos');
		$this->paginate = [
			'contain' => ['Descuentos', 'CarritosTemps'],
			'limit' => 5000, 'maxLimit' => 5000,
			'order' => ['Articulos.descripcion_pag' => 'asc']
		];
		if ($this->request->is('post')) {
			if (!empty($this->request->data['filetext']) && (!empty($this->request->data['sistfarm']))) {
				$file = $this->request->data['filetext'];
				$sistfar = $this->request->data['sistfarm'];
				$codbardde = substr($sistfar, 0, 2) - 1;
				$codbarlong = substr($sistfar, 2, 2);
				$cantidaddde = substr($sistfar, 4, 2) - 1;
				$cantidadlong = substr($sistfar, 6, 2);
				$descdde = substr($sistfar, 8, 2) - 1;
				$desclong = substr($sistfar, 10, 2);
				$tob = substr($sistfar, 12, 1);
				$destarray = [];
				$codigo = str_pad($this->request->session()->read('Auth.User.codigo'), 6, "0", STR_PAD_LEFT);
				$fecha = Time::now();
				//$fecha = Time::createFromFormat('d/m/Y',$fecha,'America/Argentina/Buenos_Aires');
				$dia = $fecha->i18nFormat('yyyyMMdd-HHmmss');
				$uploadPath = 'temp/importfile/';
				$uploadFile = $uploadPath . $dia . '_' . $codigo . '_' . $sistfar . '.txt';
				$this->request->session()->write('uploadFile', $uploadFile);
				move_uploaded_file($this->request->data['filetext']['tmp_name'], $uploadFile);

				//if ($tob=='T') {$campotob = 'troquel';} else {$campotob = 'codigo_barras';}
				if ($tob == 'T') {
					$campotob = 'troquel';
				} else {
					$campotob = 'c_barra';
				}
				$tablaped = array();
				$listaarray = array();
				$vacio = 0;
				foreach (file($uploadFile) as $line) {
					$line = utf8_decode($line);
					mb_internal_encoding("UTF-8");
					$codbar = mb_substr($line, $codbardde, $codbarlong);
					$cantidad = mb_substr($line, $cantidaddde, $cantidadlong);
					$vacio = 1;
					//$codbar = substr($line,$codbardde,$codbarlong);
					//$cantidad = substr($line,$cantidaddde,$cantidadlong);
					if ($codbar != '' && $codbar != '             ') {
						$codbar = trim($codbar, ' ');
						//$codbar = trim($codbar, " \t\n\r\0\x0B");
						$codbar = ltrim($codbar, '0');
						$cantidad = trim($cantidad, ' ');

						if (!is_numeric($codbar)) {
							$this->Flash->error('No es un codigo de barras o cantidad correcta ' . $line, ['key' => 'changepass']);
						}
						if (!is_numeric($cantidad)) {
							$this->Flash->error('No es un codigo de barras o cantidad correcta ' . $line, ['key' => 'changepass']);
						}
						/*
						 if ($codbar != '')
						 {
						 array_push($listaarray,$codbar);
						 $tablaped[$codbar] = [$cantidad,$line];
						 }*/
						if ($codbar != '') {
							if (($tob != 'T') && (is_numeric($codbar)) && (is_numeric($cantidad))) {
								array_push($listaarray, $codbar);
								$tablaped[$codbar] = [$cantidad, $line];
							} else
								if (($tob == 'T') && (is_numeric($cantidad))) {
								array_push($listaarray, $codbar);
								$tablaped[$codbar] = [$cantidad, $line];
							}
						}
					}
				}
				if ($vacio == 0) {
					$this->Flash->error('El archivo seleccionado se encuentra vacio', ['key' => 'changepass']);
					return $this->redirect($this->referer());
				}
				if (empty($listaarray)) {
					$this->Flash->error('El archivo seleccionado se encuentra vacio', ['key' => 'changepass']);
					return $this->redirect($this->referer());
				}
				$this->request->session()->write('listaarray', $listaarray);
				$this->request->session()->write('tablaped', $tablaped);
				$this->request->session()->write('campotob', $campotob);
			} else {
				$this->Flash->error('Seleccione el archivo y el tipo de sistema de pedido', ['key' => 'changepass']);
				return $this->redirect($this->referer());
			}
		} else {
			$listaarray = $this->request->session()->read('listaarray');
			$tablaped = $this->request->session()->read('tablaped');
			$campotob = $this->request->session()->read('campotob');
		}
		if ($this->request->is('post')) {

			$noimportados = array();
			$error = "";
			$rowarticulos = $this->Articulos->find()
				->contain(['Descuentos'])
				->hydrate(false)

				->join([
					'table' => 'descuentos',
					'alias' => 'd',
					'type' => 'LEFT',
					'conditions' => 'd.articulo_id = Articulos.id and d.fecha_hasta <= CURRENT_DATE() and d.tipo_venta in ("D ","  ")',
				])
				->where(['Articulos.categoria_id <' => 7])
				->where(['Articulos.eliminado' => 0])
				->where(['Articulos.' . $campotob . ' in ' => $listaarray])
				->orWhere(['Articulos.codigo_barras2 in' => $listaarray])
				->orWhere(['Articulos.codigo_barras3 in' => $listaarray])
				->where(['Articulos.eliminado' => 0]);

			foreach ($rowarticulos as $row) {
				$restpm = $this->guardarcarritotemp($row);

				if (!empty($restpm)) {
					$arraymodificado = ['articulo' => $restpm];
					array_push($destarray,	$arraymodificado);
				}


				$key = array_search($row[$campotob], $listaarray);
				if ($key !== false) {
					unset($listaarray[$key]);
				} else {
					$key = array_search($row['codigo_barras2'], $listaarray);
					if ($key !== false) {
						unset($listaarray[$key]);
					} else {
						$key = array_search($row['codigo_barras3'], $listaarray);
						if ($key !== false) {
							unset($listaarray[$key]);
						}
					}
				}
			}
			foreach ($listaarray as $row) {
				$noimportodolinea = array();

				$insertrow = $tablaped[$row];
				$insertrow = $tablaped[$row];
				$error .= '<tr><td>' . intval($insertrow[0]) . '</td>' .
					'<td>' . substr($insertrow[1], $codbardde, $codbarlong)  . '</td>' .
					'<td>' . substr($insertrow[1], $descdde, $desclong) . '</td>' .
					'<td align="right">' . $insertrow[1] . '</td></tr>';

				//mb_internal_encoding("UTF-8");
				//$codbar = mb_substr($line,$codbardde,$codbarlong);
				//$cantidad = mb_substr($line,$cantidaddde,$cantidadlong);

				$noimportodolinea[0] =  $insertrow[0];
				$noimportodolinea[2] =  substr($insertrow[1], $codbardde, $codbarlong);
				$noimportodolinea[3] = 	substr($insertrow[1], $descdde, $desclong);
				$noimportodolinea[1] =  $insertrow[1];

				array_push($noimportados, $noimportodolinea);
			}

			$this->request->session()->write('noimportados', $noimportados);
			$this->request->session()->write('errorimport', $error);
			$this->request->session()->write('destarray', $destarray);
		} else {
			$error = $this->request->session()->read('errorimport');
		}

		$articulosA = $this->Articulos->find('all')
			->contain([
				'CarritosTemps' => [

					'queryBuilder' => function ($q) {
						return $q->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]); // Full conditions for filtering
					}
				]
			])
			->hydrate(false)
			->join([
				'table' => 'carritos_temps',
				'alias' => 'ct',
				'type' => 'inner',

				'conditions' => ['ct.articulo_id = Articulos.id', 'ct.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]
			])
			->where(['Articulos.eliminado' => 0])
			->where(['ct.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]);

		if ($articulosA != null) {
			$articulos = $this->paginate($articulosA);
		} else {
			$articulos = null;
		}

		$this->set('error', $error);

		$this->set(compact('articulos'));

		$this->categoriaylaboratorio();
		$this->clientecredito();
		$this->sumacarrito();
		$this->sumacarritotemp();
	}

	public function deletecarritotemps()
	{
		$this->loadModel('CarritosTemps');
		$id = $this->request->getData('id');

		$this->request->allowMethod(['post', 'get', 'delete', 'ajax']);

		$carritotemp = $this->CarritosTemps->get($id);
		if (!empty($carritotemp)) {

			if ($this->CarritosTemps->delete($carritotemp)) {
				$contenidocarritotemps = $this->contenidoCarritoTemps();
				$subtotales = $this->calcularsubtotales($contenidocarritotemps);
				//$subtotales = $this->calcularsubtotales($contenidocarrito);
				$responseData = ['success' => true, 'responseText' => "eliminado", 'status' => 200, 'subtotal' => $subtotales, 'contenidocarrotemps' => $contenidocarritotemps];

				$this->response->body(json_encode($responseData));

				return $this->response;
			} else {
				$this->Flash->error('No se pudo eliminar, intente nuevamente', ['key' => 'changepass']);
			}
		}
	}

	public function updatefaltas()
	{
		$this->viewBuilder()->layout('vacio');
		$this->request->allowMethod(['post', 'get', 'delete', 'ajax']);

		$this->loadModel('Users');
		$user = $this->Users->find()->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])->select('notificacionfalta')->first([]);
		$this->response->body(json_encode($user));
		return $this->response;
		//echo json_encode($user);
	}
}
