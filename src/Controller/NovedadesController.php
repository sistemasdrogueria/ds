<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\I18n\Time;
use Cake\Database\Connection;
use Cake\ORM\TableRegistry;
use Cake\Database\Expression\QueryExpression;
use Cake\Datasource\ConnectionManager;

/**
 * Novedades Controller
 *
 * @property \App\Model\Table\NovedadesTable $Novedades
 */
class NovedadesController extends AppController
{
	public function initialize()
	{
		parent::initialize();

		// Include the FlashComponent
		$this->loadComponent('Flash');
		// Load Files model
		$this->loadModel('Files');
	}


	public function isAuthorized()
	{
		if (in_array($this->request->action, ['comunicado', 'edit', 'delete', 'add', 'index', 'delete_admin', 'index_admin', 'add_admin', 'edit_admin', 'view_admin', 'patagoniamed', 'ofertasperfumeria', 'promoespecial2', 'noticia', 'promoespecial', 'promoespecialdownload', 'catalogo', 'perfumeria', 'exhibidores', 'eventos', 'search', 'notasmasleidas', 'notasmasnuevas'])) {

			if ($this->request->session()->read('Auth.User.role') == 'admin') {
				return true;
			} else {
				if ($this->request->session()->read('Auth.User.role') == 'client') {

					$tiene = $this->tienepermiso('novedades', $this->request->action);
					if (!$tiene)
						$this->Flash->error(__('No tiene permisos para ingresar'), ['key' => 'changepass']);
					return $tiene;
				} else {
					if ($this->request->session()->read('Auth.User.role') == 'provider') {
						$this->Flash->error(__('No tiene permisos para ingresar'), ['key' => 'changepass']);
						$this->redirect(['controller' => 'carritos', 'action' => 'index']);
						return false;
					} else {
						$this->Flash->error(__('No tiene permisos para ingresar'), ['key' => 'changepass']);

						$this->redirect(['controller' => 'Pages', 'action' => 'home']);
						return false;
					}
				}
			}
		} else {
			if (in_array($this->request->action, ['view'])) {
				return true;
			} else {
				$this->Flash->error(__('No tiene permisos para ingresar'));
				$this->redirect(['controller' => 'Pages', 'action' => 'home']);
				return false;
			}
		}
		return parent::isAuthorized($user);
	}

	public function beforeFilter(Event $event)
	{
		// allow all action
		//$this->Auth->allow(['exposur', 'view', 'condiciones']);
	}


	public function eventos()
	{
		$this->viewBuilder()->layout('store');
	}

	public function exposur()
	{
		$this->viewBuilder()->layout('store');
	}
	/**
	 * Index method
	 *
	 * @return void
	 */
	public function comunicado()
	{
		$this->viewBuilder()->setLayout('store');

		$this->loadModel('Users');

		$user = $this->Users->get($this->request->getSession()->read('Auth.User.id'), [
			'contain' => ['Clientes']
		]);

		$user['notificacion'] = 0;
		$this->Users->save($user);
		$this->request->getSession()->write('notificacion', 0);

		$this->set('novedades', $this->paginate(
			$this->Novedades->find()
				->where(['activo' => '1'])
				->andWhere(['interno' => '1'])
				->order(['id' => 'DESC'])
		));

		$this->set('novedades2', $this->paginate(
			$this->Novedades->find()
				->where(['activo' => '1'])
				->andWhere(['interno' => '0'])
				->order(['id' => 'DESC'])
		));

		// Obtener los últimos 3 registros
		$destacadas = $this->Novedades->find()
			->order(['Novedades.id' => 'DESC'])
			->where(['Novedades.activo' => 1])
			->limit(3)
			->toArray();



		$novedadescategorias = $this->Novedades->find()
			->order(['Novedades.categorias_novedades_id' => 'ASC', 'Novedades.id' => 'DESC'])
			->where(['activo' => '1'])
			->contain(['CategoriasNovedades'])
			->toArray();

		$agrupadasPorCategoria = [];
		foreach ($novedadescategorias as $novedad) {
			$categoriaId = $novedad->categorias_novedades_id;
			if (!isset($agrupadasPorCategoria[$categoriaId])) {
				if (($novedad->categorias_novedade != null)) {
					$agrupadasPorCategoria[$categoriaId] = [
						'titulo' => $novedad->categorias_novedade->nombre,
						'items' => []
					];
				}
			}
			if ($categoriaId != null) {
				if (count($agrupadasPorCategoria[$categoriaId]['items']) < 8) {
					$agrupadasPorCategoria[$categoriaId]['items'][] = $novedad;
				}
			}
		}


		$this->loadModel('CategoriasNovedades');
		$categorias = $this->CategoriasNovedades->find('list', [
			'keyField' => 'id',
			'valueField' => 'nombre'
		])->toArray();
		$categorias = ['' => 'Categoría'] + $categorias;
		$this->set(compact('categorias'));



		$this->set(compact('destacadas', 'agrupadasPorCategoria'));
		$this->set('_serialize', ['novedades']);
		$this->set('titulo', 'Listado de Noticias');
	}

	public function search($categoria_id = null)
	{
		$this->viewBuilder()->setLayout('store');

		$termino = $this->request->getData('termino') ?: $this->request->getQuery('termino');
		$fecha = $this->request->getData('fecha') ?: $this->request->getQuery('fecha');
		$categoria = $this->request->getData('categoria') ?: $this->request->getQuery('categoria');



		if ($this->request->is('post', 'get')) {

			if ($this->request->getData('fecha') != null)
				$fecha = $this->request->getData('fecha');
			else
				$fecha = null;
			if ($this->request->getData('categoria') != null)
				$categoria = $this->request->getData('categoria');
			else
				$categoria = null;
			if ($this->request->getData('termino') != null)
				$termino = '%' . $this->request->getData('termino') . '%';
			else
				$termino = "";


			$this->request->session()->write('Novedades.termino', $termino);
			$this->request->session()->write('Novedades.categoria', $categoria);
			$this->request->session()->write('Novedades.fecha', $fecha);
		} else {
			$termino = $this->request->session()->read('Novedades.termino');
			$categoria = $this->request->session()->read('Novedades.categoria');
			$fecha = $this->request->session()->read('Novedades.fecha');
		}



		if (!empty($termino)) {
			$termsearch = '';
			$terminocompleto = explode(" ", $termino);

			if (count($terminocompleto) > 1) {
				foreach ($terminocompleto as $terminosimple) {
					$termsearch .= '%' . $terminosimple . '%';
				}
			} else {
				$termsearch = is_numeric($terminocompleto[0]) ? $terminocompleto[0] : '%' . $terminocompleto[0] . '%';
			}

			$result = $this->Novedades->find('all')
				->order(['Novedades.id' => 'DESC'])
				->where(['Novedades.titulo LIKE' => $termsearch, 'Novedades.activo' => 1]);



			if (!empty($fecha)) {
				$result->where(['Novedades.fecha' => $fecha]);
			}

			if (!empty($categoria)) {
				$result->where(['Novedades.categorias_novedades_id' => $categoria]);
			}
		} else if ($categoria <> null) {
			$result = $this->Novedades->find('all')
				->order(['Novedades.id' => 'DESC'])
				->where(['Novedades.categorias_novedades_id' => $categoria, 'Novedades.activo' => 1]);

			if (!empty($fecha)) {
				$result->where(['Novedades.fecha' => $fecha]);
			}
		} else if ($fecha <> null) {
			$result = $this->Novedades->find('all')
				->order(['Novedades.id' => 'DESC'])
				->where(['Novedades.fecha' => $fecha, 'Novedades.activo' => 1]);
		} else if ($categoria_id <> null) {
			$result = $this->Novedades->find('all')
				->order(['Novedades.id' => 'DESC'])
				->where(['Novedades.categorias_novedades_id' => $categoria_id, 'Novedades.activo' => 1]);
		} else {
			$this->redirect(['controller' => 'Novedades', 'action' => 'comunicado']);
			$this->Flash->error(__('Su busqueda esta vacio.'));
		}

		$this->paginate = [
			'limit' => 100,
		];

		$notasbuscadas = $this->paginate($result);

		$this->loadModel('CategoriasNovedades');
		$categorias = $this->CategoriasNovedades->find('list', [
			'keyField' => 'id',
			'valueField' => 'nombre'
		])->toArray();
		$categorias = ['' => 'Categoría'] + $categorias;
		$this->set(compact('categorias'));

		$this->set(compact('notasbuscadas', 'termino'));
	}

	public function catalogo()
	{
		$this->viewBuilder()->layout('store');
	}




	public function ofertasperfumeria()
	{
		$this->viewBuilder()->layout('store');
	}

	public function promoespecial()
	{
		$this->viewBuilder()->layout('magazine2');
	}

	public function promoespecial2()
	{
		$this->viewBuilder()->layout('magazine3');
	}

	public function promoespecialdownload()
	{
		$this->response->type('xlsx');

		// Optionally force file download
		//
		//
		//$this->response->file('temp'. DS .'DETFAC'.$codigo.'.TXT');

		$this->response->file(
			'file' . DS . 'Catalogo_Solares_17-18.xlsx',
			['download' => true, 'name' => 'Catalogo_Solares_17.xlsx']
		);

		return $this->response;

		return $this->redirect($this->referer());
	}

	/**
	 * View method
	 *
	 * @param string|null $id Novedade id.
	 * @return void
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */


	public function view($id = null)
	{
		$this->viewBuilder()->layout('default');
		$novedade = $this->Novedades->find()->where(['id' => $id])->first([]);
		if (is_null($novedade))
			return $this->redirect(['controller' => 'Pages', 'action' => 'home']);
		$this->set('novedade', $novedade);
		$this->set('_serialize', ['novedade']);


		$this->loadModel('Ofertas');
		$ofertasX = $this->Ofertas->find('all')
			->contain([
				'Articulos',
				'articulos.Descuentos' => [
					'queryBuilder' => function ($q) {
						return $q->where([
							'tipo_venta = "D"',
							'fecha_hasta >=CURRENT_DATE()',
							'tipo_oferta in ("RV","RR","OR","FR","TD","RL")'
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
						'd.fecha_hasta >=CURRENT_DATE()',
						'd.tipo_oferta in ("RV","RR","OR","TD","RL","FR")'
					]
				]
			)
			->where(['Ofertas.activo=1', 'Ofertas.fecha_hasta >=CURRENT_DATE()', 'Ofertas.oferta_tipo_id' => 3])
			->order(['Ofertas.id' => 'DESC'])->limit('4');

		//$ofertasX = $this->Ofertas->find('all')->where(['activo'=>1,'fecha_hasta >=CURRENT_DATE()','ubicacion'=>3])->limit('4');  

		$this->set('ofertasX', $ofertasX->toArray());

		$this->loadModel('Publications');
		$publications = $this->Publications->find('all')->where(['fecha_hasta >=CURRENT_DATE()', 'habilitada' => '1', 'ubicacion' => '1'])->order(['orden' => 'asc'])->all();
		$this->set('inicio_slider', $publications->toArray());
	}

	public function noticia($id = null)
	{
		$this->viewBuilder()->setLayout('store');

		$novedade = $this->Novedades->get($id, [
			'contain' => []
		]);

		$novedade->visitas = $novedade->visitas + 1;

		if ($this->Novedades->save($novedade)) {
		}

		$this->set('novedade', $novedade);
		$this->set('_serialize', ['novedade']);

		$relacionadas = $this->Novedades->find()
			->where(['activo' => '1', 'categorias_novedades_id' => $novedade->categorias_novedades_id])
			->order(['id' => 'DESC'])
			->select(['id', 'titulo', 'descripcion', 'img_file', 'fecha'])
			->limit(6)
			->toArray();
		$this->set('relacionadas', $relacionadas);

		$this->loadModel('CategoriasNovedades');
		$categorias = $this->CategoriasNovedades->find('list', [
			'keyField' => 'id',
			'valueField' => 'nombre'
		])->toArray();
		$categorias = ['' => 'Categoría'] + $categorias;
		$this->set(compact('categorias'));
	}

	public function notasmasleidas()
	{
		$this->viewBuilder()->setLayout(false);
		$this->request->allowMethod(['ajax', 'get']);
		$this->response = $this->response->withType('application/json');

		$masleido = $this->Novedades->find()
			->where(['activo' => 1])
			->order(['visitas' => 'DESC', 'fecha' => 'DESC'])
			->limit(4)
			->select(['id', 'titulo', 'descripcion', 'img_file', 'visitas', 'fecha'])
			->toArray();

		$data = [];
		foreach ($masleido as $masleido) {
			$data[] = [
				'id' => $masleido->id,
				'titulo' => $masleido->titulo,
				'descripcion' => $masleido->descripcion,
				'img_file' => $masleido->img_file,
				'fecha' => $masleido->fecha,
			];
		}
		echo json_encode($data);

		if (empty($masleido)) {
			return $this->response->withStatus(404)->withStringBody(json_encode(['error' => 'No hay datos disponibles']));
		}

		$this->set('masleido', $masleido);
		$this->set('_serialize', ['masleido']);
	}

	public function notasmasnuevas()
	{
		$this->viewBuilder()->setLayout(false);
		$this->request->allowMethod(['ajax', 'get']);
		$this->response = $this->response->withType('application/json');

		$masnueva = $this->Novedades->find()
			->where(['activo' => 1])
			->order(['id' => 'DESC'])
			->limit(4)
			->select(['id', 'titulo', 'descripcion', 'img_file', 'visitas', 'fecha'])
			->toArray();

		$data = [];
		foreach ($masnueva as $masleido) {
			$data[] = [
				'id' => $masleido->id,
				'titulo' => $masleido->titulo,
				'descripcion' => $masleido->descripcion,
				'img_file' => $masleido->img_file,
				'fecha' => $masleido->fecha,
			];
		}
		echo json_encode($data);

		if (empty($masleido)) {
			return $this->response->withStatus(404)->withStringBody(json_encode(['error' => 'No hay datos disponibles']));
		}

		$this->set('masleido', $masleido);
		$this->set('_serialize', ['masleido']);
	}
	/*public function index_admin()
	{
		$this->set('titulo', 'Listado de Noticias');
		$this->viewBuilder()->layout('admin');
		$this->paginate = [
			'limit' => 250,
			'maxLimit' => 250,
		];

		if ($this->request->is('post', 'get')) {

			if ($this->request->data['fechadesde'] != null)
				$fechadesde = $this->request->data['fechadesde'];
			else
				$fechadesde = 0;
			if ($this->request->data['fechahasta'] != null)
				$fechahasta = $this->request->data['fechahasta'];
			else
				$fechahasta = 0;
			if ($this->request->data['termino'] != null)
				$termsearchp = '%' . $this->request->data['termino'] . '%';
			else
				$termsearchp = "";
			if ($this->request->getData('categoria') != null)
				$categoria = $this->request->getData('categoria');
			else
				$categoria = "";

			//dd($categoria);

			$this->request->session()->write('termsearchp', $termsearchp);
			$this->request->session()->write('fechadesde', $fechadesde);
			$this->request->session()->write('fechahasta', $fechahasta);
			$this->request->session()->write('categoria',$categoria);

			if ($fechahasta != 0) {
				//$fechahasta2 = Time::now();
				$fechahasta2 = Time::createFromFormat('d/m/Y', $fechahasta, 'America/Argentina/Buenos_Aires');
				$fechahasta2->modify('+1 days');
				$fechahasta2->i18nFormat('yyyy-MM-dd');
			} else {
				$fechahasta2 = Time::now();
				$fechahasta2->modify('+1 days');
				$fechahasta2 = $fechahasta2->i18nFormat('yyyy-MM-dd');
			}
			if ($fechadesde != 0) {
				//$fechadesde2 = Time::now();
				$fechadesde2 = Time::createFromFormat('d/m/Y', $fechadesde, 'America/Argentina/Buenos_Aires');
				$fechadesde2->i18nFormat('yyyy-MM-dd');
			} else {
				$fechadesde2 = Time::now();
				if ($fechahasta != 0)
					$fechadesde2->setDate($fechadesde2->year, $fechahasta2->month, 1);
				else
					$fechadesde2->setDate($fechadesde2->year, $fechadesde2->month, 1);
				$fechadesde2->i18nFormat('yyyy-MM-dd');
			}

			if (($fechadesde != 0) || ($fechahasta != 0) || ($termsearchp != "")) {
				$novedades = $this->Novedades->find('all');
			} else {
				$novedades = null;
				//$this->redirect($this->referer());
			}
			


			if (($fechadesde != 0) || ($fechahasta != 0))
				$novedades->andWhere(["Novedades.fecha BETWEEN '" . $fechadesde2->i18nFormat('yyyy-MM-dd') . "' AND '" . $fechahasta2->i18nFormat('yyyy-MM-dd') . "'"]);
			if ($termsearchp != "")

				$novedades->andWhere([

					'OR' => [
						['Novedades.descripcion LIKE' => $termsearchp],
						['Novedades.titulo LIKE' => $termsearchp],
						['Novedades.descripcion_completa LIKE' => $termsearchp]

					]
				]);
				


			if ($novedades != null)
				$novedades = $this->paginate($novedades);
			else
				$novedades = null;
		} else {

			$fechahasta = $this->request->session()->read('fechahasta');
			$fechadesde = $this->request->session()->read('fechadesde');
			$termsearchp = $this->request->session()->read('termsearchp');
			$categoria = $this->request->session()->read('categoria');
			$novedades = $this->paginate($this->Novedades->find('all')->order(['id' => 'DESC']));
		}

		$this->loadModel('Categorias_Novedades');
		$categorias = $this->Categorias_Novedades->find('list', [
			'keyField' => 'id',
			'valueField' => 'nombre'
		])->toArray();
		$categorias = ['' => 'Categoría'] + $categorias;
		$this->set(compact('categorias'));


		$this->set('novedades', $novedades);
		$this->set('_serialize', ['novedades']);
	}*/

	public function index_admin()
	{
		$this->set('titulo', 'Listado de Noticias');
		$this->viewBuilder()->setLayout('admin2');

		$this->paginate = [
			'limit' => 250,
			'maxLimit' => 250,
		];

		if ($this->request->is(['post', 'get'])) {
			$fechadesde = $this->request->getData('fechadesde') ?: 0;
			$fechahasta = $this->request->getData('fechahasta') ?: 0;
			$termsearchp = $this->request->getData('termino') ? '%' . $this->request->getData('termino') . '%' : "";
			$categoria = $this->request->getData('categoria') ?: "";

			$this->request->getSession()->write('termsearchp', $termsearchp);
			$this->request->getSession()->write('fechadesde', $fechadesde);
			$this->request->getSession()->write('fechahasta', $fechahasta);
			$this->request->getSession()->write('categoria', $categoria);

			$fechahasta2 = $fechahasta != 0 ? Time::createFromFormat('d/m/Y', $fechahasta, 'America/Argentina/Buenos_Aires')->modify('+1 days')->i18nFormat('yyyy-MM-dd') : Time::now()->modify('+1 days')->i18nFormat('yyyy-MM-dd');
			$fechadesde2 = $fechadesde != 0 ? Time::createFromFormat('d/m/Y', $fechadesde, 'America/Argentina/Buenos_Aires')->i18nFormat('yyyy-MM-dd') : Time::now()->setDate((int)date('Y'), (int)date('m'), 1)->i18nFormat('yyyy-MM-dd');

			$novedades = $this->Novedades->find('all')->contain(['CategoriasNovedades'])->order(['Novedades.id' => 'DESC']);

			if ($fechadesde != 0 || $fechahasta != 0) {
				$novedades->where(["Novedades.fecha BETWEEN :startDate AND :endDate"])
					->bind(':startDate', $fechadesde2, 'date')
					->bind(':endDate', $fechahasta2, 'date');
			}

			if (!empty($termsearchp)) {
				$novedades->andWhere([
					'OR' => [
						['Novedades.descripcion LIKE' => $termsearchp],
						['Novedades.titulo LIKE' => $termsearchp],
						['Novedades.descripcion_completa LIKE' => $termsearchp]
					]
				]);
			}

			if ($categoria === 'sincategoria') {
				$novedades->andWhere(['Novedades.categorias_novedades_id IS' => null]);
			} elseif (!empty($categoria)) {
				$novedades->andWhere(['Novedades.categorias_novedades_id' => $categoria]);
			}


			$novedades = $this->paginate($novedades);
		} else {
			$fechahasta = $this->request->getSession()->read('fechahasta');
			$fechadesde = $this->request->getSession()->read('fechadesde');
			$termsearchp = $this->request->getSession()->read('termsearchp');
			$categoria = $this->request->getSession()->read('categoria');

			$novedades = $this->paginate(
				$this->Novedades->find('all')->order(['id' => 'DESC'])
			);
		}

		$this->loadModel('CategoriasNovedades');
		$categorias = $this->CategoriasNovedades->find('list', [
			'keyField' => 'id',
			'valueField' => 'nombre'
		])->toArray();
		$categorias = ['' => 'Categoría', 'sincategoria' => 'Sin categoría'] + $categorias;
		$this->set(compact('categorias', 'novedades'));
	}

	/**
	 * View method
	 *
	 * @param string|null $id Novedade id.
	 * @return void
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */
	public function view_admin($id = null)
	{
		$this->viewBuilder()->layout('admin2');
		$novedade = $this->Novedades->get($id, [
			'contain' => []
		]);
		$this->set('novedade', $novedade);
		$this->set('_serialize', ['novedade']);
		$this->set('titulo', 'Visualizar Noticia');
	}
	/**
	 * Add method
	 *
	 * @return void Redirects on successful add, renders view otherwise.
	 */
	public function add_admin()
	{
		$this->viewBuilder()->layout('admin2');
		$novedade = $this->Novedades->newEntity();

		if ($this->request->is('post')) {

			$novedade = $this->Novedades->patchEntity($novedade, $this->request->data);
			$fecha = Time::createFromFormat('d/m/Y', $this->request->data['fecha'], 'America/Argentina/Buenos_Aires');
			$fecha->i18nFormat('yyyy-MM-dd');

			$categoria = $this->request->getData('categorias_novedades_id');
			$novedade->categorias_novedades_id = $categoria;



			if (!empty($this->request->data['file']['name'])) {
				$fileName = $this->request->data['file']['name'];

				$uploadPath = 'img/novedades/';

				$uploadFile = $uploadPath . $fileName;
				$novedade['img_file'] = $fileName;
				if (move_uploaded_file($this->request->data['file']['tmp_name'], $uploadFile)) {
					$uploadData = $this->Files->newEntity();
					$uploadData->name = $fileName;
					$uploadData->path = $uploadPath;
					$uploadData->created = date("Y-m-d H:i:s");
					$uploadData->modified = date("Y-m-d H:i:s");
					if ($this->request->data['file']['type'] == 'application/pdf')
						$novedade['archivopdf'] = 1;
					if ($this->Files->save($uploadData)) {
						//$this->Flash->success(__('File has been uploaded and inserted successfully.'),['key' => 'changepass']);
					} else {
						$this->Flash->error(__('Unable to upload file, please try again.'), ['key' => 'changepass']);
						$this->redirect($this->referer());
					}
				} else {
					$this->Flash->error(__('Unable to upload file, please try again.'), ['key' => 'changepass']);
					$this->redirect($this->referer());
				}
			} else {
				$this->Flash->error(__('Please choose a file to upload.'), ['key' => 'changepass']);
				$this->redirect($this->referer());
			}

			if (!empty($this->request->data['file2']['name'])) {
				$fileName2 = $this->request->data['file2']['name'];

				$uploadPath2 = 'img/novedades/';

				$uploadFile2 = $uploadPath2 . $fileName2;
				$novedade['img_file2'] = $fileName2;
				if (move_uploaded_file($this->request->data['file2']['tmp_name'], $uploadFile2)) {
					$uploadData2 = $this->Files->newEntity();
					$uploadData2->name = $fileName2;
					$uploadData2->path = $uploadPath2;
					$uploadData2->created = date("Y-m-d H:i:s");
					$uploadData2->modified = date("Y-m-d H:i:s");
					if ($this->request->data['file2']['type'] == 'application/pdf')
						$novedade['archivopdf'] = 1;
					if ($this->Files->save($uploadData2)) {
						//$this->Flash->success(__('File has been uploaded and inserted successfully.'),['key' => 'changepass']);
					} else {
						$this->Flash->error(__('Unable to upload file, please try again.'), ['key' => 'changepass']);
						$this->redirect($this->referer());
					}
				} else {
					$this->Flash->error(__('Unable to upload file, please try again.'), ['key' => 'changepass']);
					$this->redirect($this->referer());
				}
			}

			$novedade['fecha'] = $fecha;
			if ($this->Novedades->save($novedade)) {
				$this->Flash->success('Se guardaron los cambios.', ['class' => 'alert_success']);

				$conn = ConnectionManager::get('default');
				$conn->query('CALL actualizarnovedadesnotificacion();');
				//	<h4 class="alert_warning">A Warning Alert</h4>

				//<h4 class="alert_error">An Error Message</h4>

				//<h4 class="alert_success">A Success Message</h4>


				return $this->redirect($this->referer());
				//return $this->redirect(['action' => 'index_admin']);
			} else {
				$this->Flash->error('No se puedo guardar la publicacion. Por favor intente de nuevo', ['class' => 'alert_error']);
			}
		}

		$this->loadModel('CategoriasNovedades');
		$categorias = $this->CategoriasNovedades->find('list', [
			'keyField' => 'id',
			'valueField' => 'nombre'
		])->toArray();

		$this->set(compact('categorias'));


		$this->set(compact('novedade'));
		$this->set('_serialize', ['novedade']);
		$this->set('titulo', 'Agregar Noticia');
	}

	/**
	 * Edit method
	 *
	 * @param string|null $id Novedade id.
	 * @return void Redirects on successful edit, renders view otherwise.
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */
	public function edit_admin($id = null)
	{
		$this->viewBuilder()->layout('admin2');
		$novedade = $this->Novedades->get($id, [
			'contain' => []
		]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$novedade = $this->Novedades->patchEntity($novedade, $this->request->data);
			$fecha = Time::createFromFormat('d/m/Y', $this->request->data['fecha'], 'America/Argentina/Buenos_Aires');
			$fecha->i18nFormat('yyyy-MM-dd');
			$novedade->fecha = $fecha;
			$categoria = $this->request->getData('categorias_novedades_id');
			$novedade->categorias_novedades_id = $categoria;



			if (!empty($this->request->data['file']['name'])) {
				$fileName = $this->request->data['file']['name'];

				$uploadPath = 'img/novedades/';

				$uploadFile = $uploadPath . $fileName;
				$novedade['img_file'] = $fileName;
				if (move_uploaded_file($this->request->data['file']['tmp_name'], $uploadFile)) {
					$uploadData = $this->Files->newEntity();
					$uploadData->name = $fileName;
					$uploadData->path = $uploadPath;
					$uploadData->created = date("Y-m-d H:i:s");
					$uploadData->modified = date("Y-m-d H:i:s");
					if ($this->Files->save($uploadData)) {
						//$this->Flash->success(__('File has been uploaded and inserted successfully.'),['key' => 'changepass']);
					} else {
						$this->Flash->error(__('Unable to upload file, please try again.'), ['key' => 'changepass']);
						$this->redirect($this->referer());
					}
				} else {
					$this->Flash->error(__('Unable to upload file, please try again.'), ['key' => 'changepass']);
					$this->redirect($this->referer());
				}
			}

			if (!empty($this->request->data['file2']['name'])) {
				$fileName2 = $this->request->data['file2']['name'];

				$uploadPath2 = 'img/novedades/';

				$uploadFile2 = $uploadPath2 . $fileName2;
				$novedade['img_file2'] = $fileName2;
				if (move_uploaded_file($this->request->data['file2']['tmp_name'], $uploadFile2)) {
					$uploadData2 = $this->Files->newEntity();
					$uploadData2->name = $fileName2;
					$uploadData2->path = $uploadPath2;
					$uploadData2->created = date("Y-m-d H:i:s");
					$uploadData2->modified = date("Y-m-d H:i:s");
					if ($this->Files->save($uploadData2)) {
						//$this->Flash->success(__('File has been uploaded and inserted successfully.'),['key' => 'changepass']);
					} else {
						$this->Flash->error(__('Unable to upload file, please try again.'), ['key' => 'changepass']);
						$this->redirect($this->referer());
					}
				} else {
					$this->Flash->error(__('Unable to upload file, please try again.'), ['key' => 'changepass']);
					$this->redirect($this->referer());
				}
			}

			if ($this->Novedades->save($novedade)) {
				$this->Flash->success('Se modifico correctamente.', ['class' => 'alert_success']);

				return $this->redirect(['action' => 'index_admin']);
			} else {
				$this->Flash->error('No se puedo modificar la publicacion. Por favor intente de nuevo', ['class' => 'alert_error']);
			}
		}

		$this->loadModel('CategoriasNovedades');
		$categorias = $this->CategoriasNovedades->find('list', [
			'keyField' => 'id',
			'valueField' => 'nombre'
		])->toArray();

		$this->set(compact('categorias'));

		$this->set(compact('novedade'));
		$this->set('_serialize', ['novedade']);
		$this->set('titulo', 'Editar Noticia');
	}

	/**
	 * Delete method
	 *
	 * @param string|null $id Novedade id.
	 * @return void Redirects to index.
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */

	public function delete_admin($id = null)
	{
		$this->viewBuilder()->layout('admin');
		$id = $this->request->getData('id');
		$this->request->allowMethod(['post', 'get', 'delete', 'ajax']);
		$novedade = $this->Novedades->get($id);
		if (!empty($novedade)) {


			if ($this->Novedades->delete($novedade)) {
				$responseData = ['success' => true, 'responseText' => "eliminado", 'status' => 200];

				$this->response->body(json_encode($responseData));


				return $this->response;

				// $this->Flash->success('Se elimino correctamente del carro.',['key' => 'changepass']);
			} else {
				$this->Flash->error('No se pudo eliminar, intente nuevamente', ['key' => 'changepass']);
			}
		}
	}


	public function exhibidores()
	{
		$this->viewBuilder()->layout('store');
		$this->paginate = [
			'limit' => 500

		];
		$fechahasta2 = Time::now();
		$fechahasta2->modify('+1 days');
		$fechahasta2 = $fechahasta2->i18nFormat('yyyy-MM-dd');
		$fechahasta = Time::now();
		$this->loadModel('Incorporations');
		$incorporationsA = $this->Incorporations->find('all');
		$incorporationsA->where(['habilitada' => 1, 'incorporations_tipos_id ' => 5])
			->andWhere(["Incorporations.fecha_hasta > '" . $fechahasta->i18nFormat('yyyy-MM-dd') . "'"])
			->order(['id' => 'DESC']);
		$incorporations = $this->paginate($incorporationsA);

		$this->loadModel('IncorporationsTipos');
		$IncorporationsTipos =  $this->IncorporationsTipos->find('list', ['keyField' => 'id', 'valueField' => 'nombre']);
		$this->set('incorporationstipos', $IncorporationsTipos->toArray());

		$this->set('incorporations', $incorporations);
		$this->set('_serialize', ['incorporations']);
	}

	public function perfumeria()
	{
		$this->viewBuilder()->layout('store');
		$this->paginate = [
			'limit' => 500

		];
		$fechahasta2 = Time::now();
		$fechahasta2->modify('+1 days');
		$fechahasta2 = $fechahasta2->i18nFormat('yyyy-MM-dd');
		$fechahasta = Time::now();
		$this->loadModel('Incorporations');
		$incorporationsA = $this->Incorporations->find('all');
		$incorporationsA->where(['habilitada' => 1, 'incorporations_tipos_id <' => 7])
			->andWhere(["Incorporations.fecha_hasta > '" . $fechahasta->i18nFormat('yyyy-MM-dd') . "'"])
			->order(['id' => 'DESC']);
		$incorporations = $this->paginate($incorporationsA);

		$this->loadModel('IncorporationsTipos');
		$IncorporationsTipos =  $this->IncorporationsTipos->find('list', ['keyField' => 'id', 'valueField' => 'nombre']);
		$this->set('incorporationstipos', $IncorporationsTipos->toArray());

		$this->set('incorporations', $incorporations);
		$this->set('_serialize', ['incorporations']);
	}


	public function condiciones()
	{
		$this->viewBuilder()->layout('store');
	}
}
