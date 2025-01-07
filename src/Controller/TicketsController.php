<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Log\Log;
use Cake\I18n\Time;
use Cake\I18n\Date;
use Cake\I18n\FrozenTime;
use Cake\Database\Expression\QueryExpression;
use Cake\Datasource\ConnectionManager;
use Cake\Mailer\Email;
use Cake\Network\Request;
use CakePdf\Pdf\CakePdf;
use CakePdf\Pdf\Engine\WkHtmlToPdfEngine;
use Cake\Chronos\Chronos;
use Cake\ORM\TableRegistry;

class TicketsController extends AppController
{
	public function isAuthorized()
	{
		if (in_array($this->request->action, ['edit_admin', 'delete_admin', 'add_admin', 'index_admin', 'index_admin_search', 'view_admin', 'enviar_ticket_mail', 'ticket_mail', 'sendReclamo', 'excel', 'enviarMensajesAdmin', 'cambiarEstadoReclamo', 'getMensajes'])) {

			if ($this->request->session()->read('Auth.User.role') == 'admin') {
				return true;
			} else {
				$this->redirect(array('controller' => 'carritos', 'action' => 'index'));
				return false;
			}
		} else {
			if (in_array($this->request->action, ['view', 'add', 'index', 'search', 'searchitem', 'add_ticket', 'add_item', 'add_item_reclamo', 'confirm', 'add_comprobante_item', 'ticketpdf', 'resumen', 'recall', 'enviarMensajes', 'getMensajesUser'])) {
				if ($this->request->session()->read('Auth.User.role') == 'client') {
					$tiene = $this->tienepermiso('reclamos', $this->request->action);
					if (!$tiene)
						$this->Flash->error(__('No tiene permisos para ingresar'), ['key' => 'changepass']);
					return $tiene;
				} else {
					if ($this->request->session()->read('Auth.User.role') == 'provider') {
						$this->Flash->error(__('No tiene permisos para ingresar'), ['key' => 'changepass']);
						return false;
					} else {
						return false;
						$this->Flash->error(__('No tiene permisos para ingresar'), ['key' => 'changepass']);
						return $this->redirect(['controller' => 'Pages', 'action' => 'home']);
					}
				}
			} else {
				$this->Flash->error(__('No tiene permisos para ingresar'), ['key' => 'changepass']);
				$this->redirect(['controller' => 'Pages', 'action' => 'home']);
				return false;
			}
		}
		return parent::isAuthorized($user);
	}

	public function initialize()
	{
		parent::initialize();
		$this->loadComponent('RequestHandler');
		$this->loadModel('Reclamos');
	}

	/**
	 * Index method
	 *
	 * @return void
	 */
	/*public function index()
	{
		$this->viewBuilder()->layout('store');
		if ($this->request->is('post')) {

			if ($this->request->data['fechadesde'] != null)
				$fechadesde = $this->request->data['fechadesde'];
			else
				$fechadesde = 0;
			if ($this->request->data['fechahasta'] != null)
				$fechahasta = $this->request->data['fechahasta'];
			else
				$fechahasta = 0;
			if ($this->request->data['terminobuscar'] != null)
				$termsearchp = '%' . $this->request->data['terminobuscar'] . '%';
			else
				$termsearchp = "";
			if ($this->request->data['reclamos_tipo_id'] != null)
				$tiporeclamo = $this->request->data['reclamos_tipo_id'];
			else
				$tiporeclamo = 0;

			$this->request->session()->write('reclamos_tipo_id', $tiporeclamo);
			$this->request->session()->write('termsearchp', $termsearchp);
			$this->request->session()->write('fechadesde', $fechadesde);
			$this->request->session()->write('fechahasta', $fechahasta);
		} else {

			$fechahasta = $this->request->session()->read('fechahasta');
			$fechadesde = $this->request->session()->read('fechadesde');
			$termsearchp = $this->request->session()->read('termsearchp');
			$tiporeclamo = $this->request->session()->read('reclamos_tipo_id');
		}


		$this->paginate = [
			'contain' => ['Clientes', 'ReclamosTipos', 'ReclamosEstados']
		];

		if ($fechahasta != 0) {
			//$fechahasta2 = Time::now();
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
			//$fechahasta2 = $fechahasta2->i18nFormat('yyyy-MM-dd');
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

		if ($this->request->is('post')) {
			if (($fechadesde != 0) || ($fechahasta != 0) || ($termsearchp != "") || ($tiporeclamo != 0)) {
				$reclamos = $this->Reclamos->find('all')

					->contain(['ReclamosTipos', 'ReclamosEstados'])
					->select([
						'id',
						'cliente_id',
						'factura_numero',
						'factura_seccion',
						'reclamos_tipo_id',
						'fecha_recepcion',
						'estado_id',
						'creado',
						'ReclamosEstados.nombre',
						'ReclamosTipos.nombre'
					])
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
			} else {
				$reclamos = $this->Reclamos->find('all')
					->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
					->andWhere(['fecha_recepcion BETWEEN :start AND :end'])
					->bind(':start', $fechadesde2->i18nFormat('yyyy-MM-dd'), 'date')
					->bind(':end',   $fechahasta2->i18nFormat('yyyy-MM-dd'), 'date');
			}
			if ($tiporeclamo != 0)
				$reclamos->where(['Reclamos.reclamos_tipo_id' => $tiporeclamo]);
			if (($fechadesde != 0) || ($fechahasta != 0))
				$reclamos->andWhere(["Reclamos.creado BETWEEN '" . $fechadesde2->i18nFormat('yyyy-MM-dd') . "' AND '" . $fechahasta2->i18nFormat('yyyy-MM-dd') . "'"]);
			if ($termsearchp != "")
				$reclamos->where([
					'OR' => ['a.descripcion_pag LIKE' => $termsearchp, 'a.troquel LIKE' => $termsearchp, 'Reclamos.id' => str_replace("%", "", $termsearchp), 'Reclamos.factura_numero' => str_replace("%", "", $termsearchp)]
				]);

			//$reclamosA->where(['a.descripcion_pag LIKE'=>$termsearchp])->orWhere(['a.troquel LIKE'=>$termsearchp]);


		} else {
			$reclamos = $this->Reclamos->find('all')
				->where(['cliente_id' => $this->request->session()->read('Auth.User.cliente_id')])
				->andWhere(['fecha_recepcion BETWEEN :start AND :end'])
				->bind(':start', $fechadesde2->i18nFormat('yyyy-MM-dd'), 'date')
				->bind(':end',   $fechahasta2->i18nFormat('yyyy-MM-dd'), 'date');
		}
		if ($reclamos != null)
			$reclamos = $this->paginate($reclamos);
		else
			$reclamos = null;

		$this->set('reclamos', $reclamos);
		//$this->set('_serialize', ['reclamos']);		
		$this->loadModel('ReclamosTipos');
		$reclamostipos =  $this->ReclamosTipos->find('list', ['keyField' => 'id', 'valueField' => 'nombre']);
		$this->loadModel('ReclamosEstados');
		$reclamosestados =  $this->ReclamosEstados->find('list', ['keyField' => 'id', 'valueField' => 'nombre']);
		$this->set(compact('reclamostipos'));
		$this->set(compact('reclamosestados'));
		$this->set('reclamostipos2', null);
	}*/

	public function index()
	{
		$this->viewBuilder()->setLayout('store');

		// Lectura de datos del formulario o sesión
		$session = $this->request->getSession();
		$fechadesde = $this->request->getData('fechadesde') ?? $session->read('fechadesde') ?? 0;
		$fechahasta = $this->request->getData('fechahasta') ?? $session->read('fechahasta') ?? 0;
		$termsearchp = $this->request->getData('terminobuscar') ? '%' . $this->request->getData('terminobuscar') . '%' : $session->read('termsearchp') ?? "";
		$tiporeclamo = $this->request->getData('reclamos_tipo_id') ?? $session->read('reclamos_tipo_id') ?? 0;

		// Guardar en sesión
		$session->write(compact('fechadesde', 'fechahasta', 'termsearchp', 'tiporeclamo'));

		// Fechas con validación
		$fechahasta2 = ($fechahasta && FrozenTime::createFromFormat('d/m/Y', $fechahasta))
			? FrozenTime::createFromFormat('d/m/Y', $fechahasta)->addDay()
			: FrozenTime::now()->addDay();

		$fechadesde2 = ($fechadesde && FrozenTime::createFromFormat('d/m/Y', $fechadesde))
			? FrozenTime::createFromFormat('d/m/Y', $fechadesde)
			: FrozenTime::now()->startOfMonth();

		// Consulta
		//dd($fechadesde2 . ' ' . $fechahasta2);
		$clienteId = $this->request->getSession()->read('Auth.User.cliente_id');

		$reclamos = $this->Reclamos->find()
			->contain(['ReclamosTipos', 'ReclamosEstados', 'ReclamosItems', 'ReclamosItems.Articulos'])
			->where(['Reclamos.cliente_id' => $clienteId])
			->andWhere([
				'Reclamos.creado >=' => $fechadesde2->i18nFormat('yyyy-MM-dd'),
				'Reclamos.creado <=' => $fechahasta2->i18nFormat('yyyy-MM-dd'),
			]);

		if ($tiporeclamo) {
			$reclamos->andWhere(['Reclamos.reclamos_tipo_id' => $tiporeclamo]);
		}

		if ($termsearchp) {
			$termsearchp = '%' . trim($termsearchp) . '%';
			$reclamos->andWhere([
				'OR' => [
					'ReclamosItems.Articulos.descripcion_pag LIKE' => $termsearchp,
					'ReclamosItems.Articulos.troquel LIKE' => $termsearchp,
					'Reclamos.id' => str_replace('%', '', $termsearchp),
					'Reclamos.factura_numero' => str_replace('%', '', $termsearchp),
				]
			]);
		}


		$this->paginate = ['order' => ['id' => 'DESC']];
		$reclamos = $this->paginate($reclamos);

		$this->loadModel('ReclamosTipos');
		$this->loadModel('ReclamosEstados');
		$reclamostipos = $this->ReclamosTipos->find('list', ['keyField' => 'id', 'valueField' => 'nombre']);
		$reclamosestados = $this->ReclamosEstados->find('list', ['keyField' => 'id', 'valueField' => 'nombre']);

		$this->set(compact('reclamos', 'reclamostipos', 'reclamosestados'));
	}



	public function search()
	{
		$this->viewBuilder()->layout('store');
		if ($this->request->is('post')) {

			if ($this->request->data['fechadesde'] != null)
				$fechadesde = $this->request->data['fechadesde'];
			else
				$fechadesde = 0;
			if ($this->request->data['fechahasta'] != null)
				$fechahasta = $this->request->data['fechahasta'];
			else
				$fechahasta = 0;
			if ($this->request->data['terminobuscar'] != null)
				$termsearchp = '%' . $this->request->data['terminobuscar'] . '%';
			else
				$termsearchp = "";
			if ($this->request->data['reclamos_tipo_id'] != null)
				$tiporeclamo = $this->request->data['reclamos_tipo_id'];
			else
				$tiporeclamo = 0;

			$this->request->session()->write('reclamos_tipo_id', $tiporeclamo);
			$this->request->session()->write('termsearchp', $termsearchp);
			$this->request->session()->write('fechadesde', $fechadesde);
			$this->request->session()->write('fechahasta', $fechahasta);
		} else {
			$fechahasta = $this->request->session()->read('fechahasta');
			$fechadesde = $this->request->session()->read('fechadesde');
			$termsearchp = $this->request->session()->read('termsearchp');
			$tiporeclamo = $this->request->session()->read('reclamos_tipo_id');
		}

		$this->paginate = [
			'limit' => 11,
		];

		if ($fechahasta != 0) {
			//$fechahasta2 = Time::now();
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
			//$fechahasta2 = $fechahasta2->i18nFormat('yyyy-MM-dd');
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

		if (($fechadesde != 0) || ($fechahasta != 0) || ($termsearchp != "") || ($tiporeclamo != 0)) {
			$reclamosA = $this->Reclamos->find('all')

				->contain(['ReclamosTipos', 'ReclamosEstados'])
				->select([
					'id',
					'cliente_id',
					'factura_numero',
					'guia_numero',
					'reclamos_tipo_id',
					'transporte',
					'observaciones',
					'fecha_recepcion',
					'estado_id',
					'creado',
					'ReclamosEstados.nombre',
					'ReclamosTipos.nombre'
				])
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
		} else {
			$reclamosA = null;
			$this->redirect($this->referer());
		}
		if ($tiporeclamo != 0)
			$reclamosA->where(['Reclamos.reclamos_tipo_id' => $tiporeclamo]);
		if (($fechadesde != 0) || ($fechahasta != 0))
			$reclamosA->andWhere(["Reclamos.creado BETWEEN '" . $fechadesde2->i18nFormat('yyyy-MM-dd') . "' AND '" . $fechahasta2->i18nFormat('yyyy-MM-dd') . "'"]);
		if ($termsearchp != "")
			$reclamosA->where([
				'OR' => ['a.descripcion_pag LIKE' => $termsearchp, 'a.troquel LIKE' => $termsearchp, 'Reclamos.id' => str_replace("%", "", $termsearchp), 'Reclamos.factura_numero' => str_replace("%", "", $termsearchp)]
			]);

		//$reclamosA->where(['a.descripcion_pag LIKE'=>$termsearchp])->orWhere(['a.troquel LIKE'=>$termsearchp]);
		if ($reclamosA != null)
			$reclamos = $this->paginate($reclamosA);
		else
			$reclamos = null;

		//debug($pedidos);
		$this->set('reclamos', $reclamos);

		$this->loadModel('ReclamosTipos');
		$reclamostipos =  $this->ReclamosTipos->find('list', ['keyField' => 'id', 'valueField' => 'nombre']);

		$reclamostipos2 =  $this->ReclamosTipos->find('all');
		$this->set('reclamostipos', $reclamostipos->toArray());
		$this->set('reclamostipos2', $reclamostipos2->toArray());
	}

	public function recall()
	{
		$this->viewBuilder()->layout('store');

		$this->loadModel('Recalls');
		$recalls = $this->Recalls->find('all')->contain(['RecallsFiles'])->order(['fecha' => 'DESC']);


		$this->set('recalls', $this->paginate($recalls));
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
			'contain' => ['Clientes', 'ReclamosTipos', 'ReclamosEstados', 'ReclamosMensajes', 'ReclamosMensajes.Clientes']
		]);

		/*$reclamo = $this->Reclamos->find()
			->where(['Reclamos.id' => $id])
			->contain(['Clientes', 'ReclamosTipos', 'ReclamosEstados', 'ReclamosMensajes', 'ReclamosMensajes.Clientes'])
			->first();

		if (!$reclamo) {
			return $this->redirect(['action' => 'index']);
		}*/

		if ($reclamo->cliente_id != $this->request->getSession()->read('Auth.User.cliente_id')) {
			return $this->redirect(['action' => 'index']);
		}

		if ($reclamo->cantidad_notificaciones > 0) {
			$reclamo->cantidad_notificaciones = 0;
			if ($this->Reclamos->save($reclamo)) {
			}
		}

		$mostrarModal = false;
		if ($reclamo->aparicion_modal == 0) {
			$mostrarModal = true;

			$reclamo->aparicion_modal = 1;
			if ($this->Reclamos->save($reclamo)) {
			}
		}

		$this->set(compact('mostrarModal'));

		$this->loadModel('ReclamosItems');
		$reclamositems = $this->ReclamosItems->find()
			->select([
				'ReclamosItems.id',
				'ReclamosItems.reclamo_id',
				'ReclamosItems.articulo_id',
				'ReclamosItems.cantidad',
				'ReclamosItems.detalle',
				'ReclamosItems.fecha_vencimiento',
				'ReclamosItems.lote',
				'ReclamosItems.serie',
			])
			->innerJoinWith('Articulos')
			->contain(['Articulos', 'Articulos.Categorias', 'Articulos.Subcategorias', 'Articulos.Marcas', 'Articulos.Laboratorios', 'Articulos.Proveedors'])
			->where(['ReclamosItems.reclamo_id' => $id])
			->toArray();

		$this->set('reclamositemstemps', $reclamositems);
		$this->set('reclamo', $reclamo);
		$this->set('_serialize', ['reclamo']);
		$this->set('_serialize', ['reclamositemstemps']);
		$this->loadModel('Laboratorios');
		$this->set('laboratorios', $this->Laboratorios->find('list', ['keyField' => 'id', 'valueField' => 'nombre'])
			->order(['nombre' => 'ASC']));
	}


	public function resumen($id = null)
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
				'a.codigo_barras',
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
		$this->set('laboratorios', $this->Laboratorios->find('list', ['keyField' => 'id', 'valueField' => 'nombre'])
			->order(['nombre' => 'ASC']));
	}

	public function ticketpdf($id = null)
	{

		//$this->viewBuilder()->layout('pdf/ticket');
		$reclamo = $this->Reclamos->get($id, [
			'contain' => ['Clientes', 'Clientes.Provincias', 'Clientes.Localidads', 'ReclamosTipos', 'ReclamosEstados']
		]);
		$this->loadModel('ReclamosItems');
		$reclamositems = $this->ReclamosItems->find('all')
			->select([
				'ReclamosItems.id',
				'ReclamosItems.reclamo_id',
				'ReclamosItems.articulo_id',
				'a.laboratorio_id',
				'a.codigo_barras',
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
		$this->set('laboratorios', $this->Laboratorios->find('list', ['keyField' => 'id', 'valueField' => 'nombre'])
			->order(['nombre' => 'ASC']));


		$this->viewBuilder()->options([
			'pdfConfig' => [
				'orientation' => 'portrait',
				'filename' => 'Ticket' . $reclamo->id . '.pdf'
			]
		])
			->setLayout('ticket');
	}
	/**
	 * 
	 * method
	 *
	 * @return void Redirects on successful add, renders view otherwise.
	 */
	public function add_ticket($articulos = null)
	{
		$this->viewBuilder()->layout('store');
		$reclamo = $this->Reclamos->newEntity();

		if ($this->request->session()->read('articulos') != null) {
			$articulos = $this->request->session()->read('articulos');
			$laboratoriosTable = TableRegistry::getTableLocator()->get('Laboratorios');
			$categoriasTable = TableRegistry::getTableLocator()->get('Categorias');

			foreach ($articulos as &$articulo) {
				$laboratorioId = $articulo['articulo']['laboratorio_id'] ?? null;
				$categoriaId = $articulo['articulo']['categoria_id'] ?? null;
				if ($laboratorioId) {
					$laboratorio = $laboratoriosTable->find()
						->select(['nombre'])
						->where(['id' => $laboratorioId])
						->first();
					$articulo['laboratorio_nombre'] = $laboratorio ? $laboratorio->nombre : 'No definido';
				} else {
					$articulo['laboratorio_nombre'] = 'No definido';
				}


				if ($categoriaId) {
					$categoria = $categoriasTable->find()
						->select(['nombre'])
						->where(['id' => $categoriaId])
						->first();
					$articulo['categoria_nombre'] = $categoria ? $categoria->nombre : 'No definido';
				} else {
					$articulo['categoria_nombre'] = 'No definido';
				}
			}
		} else
			$articulos = null;

		if ($this->request->session()->read('reclamo') != null)
			$reclamo = $this->request->session()->read('reclamo');
		else
			$reclamo = null;

		if ($this->request->session()->read('comprobante') != null) {
			$comprobante = $this->request->session()->read('comprobante');
		} else
			$comprobante = null;

		if ($this->request->is('post', 'get')) {

			$this->loadModel('FacturasCabeceras');
			$query = $this->FacturasCabeceras->find('all')
				->contain(['FacturasCuerposItems', 'FacturasCuerposItems.Articulos' => [
					'queryBuilder' => function ($q) {
						return $q->where(['FacturasCuerposItems.Articulos.eliminado =0']);
					}
				]])
				->hydrate(false)

				->where(['FacturasCabeceras.cliente_id' => $this->request->session()->read('Auth.User.cliente_id'), 'FacturasCabeceras.pedido_ds' => $reclamo['factura_numero']])
				->first([]);
			$listart = array();
			if (!empty($query)) {
				$this->request->session()->write('queryfact', $query);
				foreach ($query['facturas_cuerpos_items'] as $fci):
					array_push($listart, $fci['articulo_id']);
				endforeach;
				$this->loadModel('Articulos');

				$articulos = $this->Articulos->find()
					->contain(['Laboratorios', 'Categorias'])
					->where(['Articulos.id in' => $listart, 'eliminado' => 0]);
				$articulos = $articulos->toArray();
				$this->request->session()->write('articulos', $articulos);
			} else {

				$this->loadModel('Pedidos');
				$query = $this->Pedidos->find('all')
					->contain(['PedidosItems', 'PedidosItems.Articulos'])
					->hydrate(false)

					->where(['Pedidos.cliente_id' => $this->request->session()->read('Auth.User.cliente_id'), 'Pedidos.nro_pedido_ds' => $reclamo['factura_numero']]);

				if (!empty($query)) {
					$this->request->session()->write('queryfact', $query);
					foreach ($query as $p):
						foreach ($p['pedidos_items'] as $fci):
							array_push($listart, $fci['articulo_id']);
						endforeach;
					endforeach;
					$this->loadModel('Articulos');

					$articulos = $this->Articulos->find()
						->contain(['Laboratorios', 'Categorias'])
						->where(['Articulos.id in' => $listart, 'eliminado' => 0]);
					$articulos = $articulos->toArray();
					$this->request->session()->write('articulos', $articulos);
				} else {
					$this->Flash->error('Número de Factura ' . $reclamo['factura_seccion'] . '-' . $reclamo['factura_numero'] . ' NO valido', ['key' => 'changepass']);
					return $this->redirect($this->referer());
					//return $this->redirect(['action' => 'add']);//$this->referer());
				}
				$this->request->session()->write('reclamo', $reclamo);
			}
		}

		if ($this->request->session()->read('reclamo') != null)
			$reclamo = $this->request->session()->read('reclamo');
		else
			$reclamo = null;

		$this->loadModel('ReclamosTipos');
		$reclamostipos =  $this->ReclamosTipos->find('list', ['keyField' => 'id', 'valueField' => 'nombre']);
		$this->set('comprobante', $comprobante);
		$this->set(compact('reclamo', 'reclamostipos'));
		$this->set('_serialize', ['reclamo']);
		$this->loadModel('Laboratorios');
		$this->loadModel('ReclamosItemsTemps');
		$reclamositemstemps = $this->ReclamosItemsTemps->find('all')
			->select([
				'ReclamosItemsTemps.id',
				'ReclamosItemsTemps.cliente_id',
				'ReclamosItemsTemps.articulo_id',
				'ReclamosItemsTemps.cantidad',
				'ReclamosItemsTemps.detalle',
				'ReclamosItemsTemps.fecha_vencimiento',
				'ReclamosItemsTemps.lote',
				'ReclamosItemsTemps.serie',
				'ReclamosItemsTemps.creado'
			])
			->innerJoinWith('Articulos')
			->contain(['Articulos', 'Articulos.Laboratorios'])
			->where(['ReclamosItemsTemps.cliente_id' => $this->request->session()->read('Auth.User.cliente_id')]);
		$this->set('reclamositemstemps', $reclamositemstemps);
		$this->set('articulos', $articulos);
	}

	public function add_item_reclamo($articulos = null)
	{
		$this->viewBuilder()->layout('store');
		$reclamo = $this->Reclamos->newEntity();
		if ($this->request->is('post', 'get')) {

			$reclamo = $this->Reclamos->patchEntity($reclamo, $this->request->data);
			$reclamo['cliente_id'] = $this->request->session()->read('Auth.User.cliente_id');
			$reclamo['fecha_recepcion'] = $this->request->data['fecha_recepcion'];
			$fecha = Time::createFromFormat('d/m/Y', $this->request->data['fecha_recepcion'], 'America/Argentina/Buenos_Aires');
			$fecha->i18nFormat('yyyy-MM-dd');
			$reclamo['fecha_recepcion']  = $fecha;
			if ($this->Reclamos->save($reclamo)) {
				$this->Flash->success('Se reclamo fue guardado', ['key' => 'changepass']);

				return $this->redirect(['controller' => 'Tickets', 'action' => 'index']);
			} else {
				$this->Flash->error('El ticket no fue guardado, intente nuevamente.');
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
		} else
			$articulos = null;

		$this->loadModel('ReclamosTipos');
		$reclamostipos =  $this->ReclamosTipos->find('list', ['keyField' => 'id', 'valueField' => 'nombre']);
		$this->set(compact('reclamo', 'reclamostipos'));
		$this->set('_serialize', ['reclamo']);
		$this->loadModel('Categorias');
		$this->set('categorias', $this->Categorias->find('list', ['keyField' => 'id', 'valueField' => 'nombre']));
		$this->loadModel('Laboratorios');
		$this->set('laboratorios', $this->Laboratorios->find('list', ['keyField' => 'id', 'valueField' => 'nombre'])
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
		$this->set('articulos', $articulos);
	}

	public function add_comprobante_item($comprobante = null)
	{
		$comprobante = null;
		$articulos = null;
		if ($this->request->is('post')) {

			$this->layout = 'ajax';


			//$reclamo = $this->Reclamos->patchEntity($reclamo, $this->request->data);
			//$reclamo['cliente_id']=$this->request->session()->read('Auth.User.cliente_id');
			$f_seccion = ltrim(substr($comprobante, 0, 4), '0');
			$f_numero = ltrim(substr($comprobante, 5, 8), '0');
			$f_cliente = $this->request->session()->read('Auth.User.cliente_id');

			$this->loadModel('Comprobantes');
			$query = $this->Comprobantes->find('all')
				->contain(['ComprobantesTipos'])
				->where(['cliente_id' => $f_cliente, 'seccion' => $f_seccion, 'numero' => $f_numero])
				->first([]);
			if ($query != null) {
				$comprobante = $query;
				$this->loadModel('FacturasCuerposItems');
				$query = $this->FacturasCuerposItems->find('all')
					->contain(['FacturasCabeceras', 'Articulos']) //,'Articulos'
					//->hydrate(false)

					->join([

						'fc' => [
							'table' => 'facturas_cabeceras',
							'type' => 'INNER',
							'conditions' => 'fc.id = FacturasCuerposItems.facturas_encabezados_id',
						]
					])
					->where(['fc.cliente_id' => $f_cliente])
					->where(['FacturasCabeceras.comprobante_id' => $query['id']])
					->order(['fc.fecha' => 'ASC'])

					->group('FacturasCuerposItems.articulo_id');
				if ($query != null)
					$articulos = $query->toArray();
				else
					$articulos = null;
			} else {
				$comprobante = null;
				$articulos = null;
			}
			$json_data = json_encode($articulos);
			$response = $this->response->withType('json')->withStringBody($json_data);
			return $response;
		}
		$this->set('comprobante', $comprobante);
		$this->set('articulos', $articulos);
	}

	public function add_item2()
	{
		$this->viewBuilder()->layout('ajax');
		$this->loadModel('ReclamosItemsTemps');
		$reclamosItemsTemp = $this->ReclamosItemsTemps->newEntity();
		if ($this->request->is('post')) {
			$reclamosItemsTemp['cliente_id'] = $this->request->session()->read('Auth.User.cliente_id');
			$reclamosItemsTemp['articulo_id'] = $this->request->data['articulo_id'];
			$reclamosItemsTemp['cantidad'] = $this->request->data['cantidad'];
			$reclamosItemsTemp['detalle'] = $this->request->data['descripcion'];
			if ($this->request->data['fecha_vencimiento'] != null) {

				$fv = $this->request->data['fecha_vencimiento'];
				$fvp = explode("/", $fv);
				echo $fvp[0]; // porción1
				echo $fvp[1]; // porción2

				$fecha_vencimiento = Time::now();
				$fecha_vencimiento->setDate($fvp[1], $fvp[0], 1);

				$fecha_vencimiento->i18nFormat('yyyy-MM-dd');

				/*$fecha_vencimiento = Time::createFromFormat('d/m/Y',$this->request->data['fecha_vencimiento'],'America/Argentina/Buenos_Aires');
				$fecha_vencimiento->i18nFormat('yyyy-MM-dd');*/
			} else
				$fecha_vencimiento = $this->request->data['fecha_vencimiento'];
			$reclamosItemsTemp['fecha_vencimiento'] =  $fecha_vencimiento;
			$reclamosItemsTemp['lote'] = $this->request->data['lote'];
			$reclamosItemsTemp['serie'] = $this->request->data['serie'];

			$creado = Time::now();
			$creado->i18nFormat('yyyy-MM-dd H:i:s');
			$reclamosItemsTemp['creado'] = $creado;

			if ($this->ReclamosItemsTemps->save($reclamosItemsTemp)) {

				$this->Flash->success(__('Se agrego el item al ticket.'), ['key' => 'changepass']);

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

				/*$resultJ = json_encode(array('result' => array('reclamositemstemps' => $reclamositemstemps)));
				$this->response->type('json');
				$this->response->body($resultJ);
				return $this->response;*/
				//return $this->redirect($this->referer());
				//return $this->redirect(['action' => 'add']);
			} else {
				$this->Flash->error(__('No se pudo agregar el itme al ticket, intente de nuevo.'), ['key' => 'changepass']);
			}
		}
		$this->set(compact('reclamosItemsTemp'));
		$this->set('_serialize', ['reclamosItemsTemp']);
		//$this->redirect($this->referer());
		//$this->redirect(['action' => 'add']);
	}

	public function confirm()
	{
		$this->viewBuilder()->layout('store');
		$reclamo = $this->Reclamos->newEntity();
		if ($this->request->is('post')) {
			//$reclamo = $this->Reclamos->patchEntity($reclamo, $this->request->data);
			if ($this->request->session()->read('reclamo') != null)
				$reclamo = $this->request->session()->read('reclamo');
			$reclamo['observaciones'] = $this->request->data['observaciones'];

			$creado = Time::now();
			$creado->i18nFormat('yyyy-MM-dd H:i:s');
			$reclamo['creado'] = $creado;
			/*
				$fecha = Time::createFromFormat('d/m/Y',$reclamo['fecha_recepcion'],'America/Argentina/Buenos_Aires');
				$fecha->i18nFormat('yyyy-MM-dd');
				$reclamo['fecha_recepcion']  = $fecha;*/


			$this->loadModel('ReclamosItemsTemps');
			$reclamo_items = $this->ReclamosItemsTemps->find()->where(['cliente_id' => $reclamo['cliente_id']]);
			if ($reclamo_items != null) {
				if ($reclamo_items->count() > 0) {
					if ($this->Reclamos->save($reclamo)) {
						$connection = ConnectionManager::get('default');
						$id = $this->Reclamos->find()->where(['cliente_id' => $reclamo['cliente_id']])
							->order(['id' => 'DESC'])->first();
						//debug($id);

						$confirmados = $connection->execute('
					INSERT INTO reclamos_items (id, reclamo_id, articulo_id, cantidad, detalle, fecha_vencimiento, lote, serie)
					SELECT null, ' . $id['id'] . ' , articulo_id, cantidad, detalle, fecha_vencimiento, lote, serie 
					FROM reclamos_items_temps WHERE cliente_id=' . $this->request->session()->read('Auth.User.cliente_id'));
						$confirmados2 = $connection->execute('DELETE FROM reclamos_items_temps WHERE cliente_id=' . $this->request->session()->read('Auth.User.cliente_id'));

						$this->Flash->success('El reclamo devolución fue enviado.', ['key' => 'changepass']);

						return $this->redirect(['controller' => 'Tickets', 'action' => 'view', $id['id']]);
					} else {
						$this->Flash->error(__('El ticket no fue guardado, intente nuevamente.'), ['key' => 'changepass']);
					}
				} else {
					$this->Flash->error(__('El ticket no tiene cargado ningun item'), ['key' => 'changepass']);
					$this->redirect($this->referer());
				}
			} else {

				$this->Flash->error(__('El ticket no tiene cargado ningun item'), ['key' => 'changepass']);
				$this->redirect($this->referer());
			}
		}
		$this->loadModel('ReclamosTipos');
		$reclamostipos =  $this->ReclamosTipos->find('list', ['keyField' => 'id', 'valueField' => 'nombre']);
		$this->set(compact('reclamo', 'reclamostipos'));
		$this->set('_serialize', ['reclamo']);
		$this->loadModel('Categorias');
		$this->set('categorias', $this->Categorias->find('list', ['keyField' => 'id', 'valueField' => 'nombre']));
		$this->loadModel('Laboratorios');
		$this->set('laboratorios', $this->Laboratorios->find('list', ['keyField' => 'id', 'valueField' => 'nombre']));
	}

	public function add()
	{
		$this->viewBuilder()->layout('store');
		$reclamo = $this->Reclamos->newEntity();
		$comprobante = null;
		$articulos = null;
		if ($this->request->is('post', 'get')) {
			$reclamo = $this->Reclamos->patchEntity($reclamo, $this->request->data);

			$reclamo['factura_seccion'] = ltrim(substr($this->request->data['factura_numero'], 0, 4), '0');
			$reclamo['factura_numero'] = ltrim(substr($this->request->data['factura_numero'], 5, 8), '0');
			//$f_cliente = $this->request->session()->read('Auth.User.cliente_id');
			$reclamo['cliente_id'] = $this->request->session()->read('Auth.User.cliente_id');
			$reclamo['tipo'] = $this->request->data['tipo'];
			$this->loadModel('Comprobantes');
			$query = $this->Comprobantes->find('all')
				->contain(['ComprobantesTipos'])
				->where(['cliente_id' => $reclamo['cliente_id'], 'seccion' => $reclamo['factura_seccion'], 'numero' => $reclamo['factura_numero']])
				->first([]);
			$this->set('queryX', $query);
			if ($query != null) {
				$comprobante = $query;
				$reclamo['fecha_recepcion'] = $comprobante['fecha'];
				$reclamo['pedido_numero'] = $comprobante['nota'];
				$fecha = Time::createFromFormat('d/m/y', $comprobante['fecha'], 'America/Argentina/Buenos_Aires');
				$fecha->i18nFormat('yyyy-MM-dd');
				$reclamo['fecha_recepcion']  = $fecha;

				$this->loadModel('FacturasCuerposItems');
				$query = $this->FacturasCuerposItems->find('all')
					->contain(['FacturasCabeceras', 'Articulos']) //,'Articulos'
					//->hydrate(false)
					->join([
						'fc' => [
							'table' => 'facturas_cabeceras',
							'type' => 'INNER',
							'conditions' => 'fc.id = FacturasCuerposItems.facturas_encabezados_id',
						]
					])
					->where(['fc.cliente_id' => $reclamo['cliente_id']])
					->where(['FacturasCabeceras.comprobante_id' => $query['id']])
					->order(['fc.fecha' => 'ASC'])

					->group('FacturasCuerposItems.articulo_id');
				if ($query != null)
					$articulos = $query->toArray();
				else
					$articulos = null;
				$this->request->session()->write('reclamo', $reclamo);
				//$time = new Time($reclamo['fecha_recepcion']);
				$timerecep = new Time($reclamo['fecha_recepcion']);

				$time = Date::create()->year($timerecep->year)->month($timerecep->month)->day($timerecep->day)->hour(00)->minute(01);

				$control = 3;
				if ($this->request->session()->read('Auth.User.provincia_id') == 20)
					$control = $control + 2;
				if ($time->isFriday() || $time->isThursday())
					$control = $control + 1;
				/*
				if ($time->isFriday() ||$time->isThursday())
					$control =4;
				else
					$control =3;*/
				if (!$timerecep->wasWithinLast($control)) {
					if ($this->request->session()->read('Auth.User.codigo_postal') == 9405 || $this->request->session()->read('Auth.User.codigo_postal') == 9410 || $this->request->session()->read('Auth.User.codigo_postal') == 9420) {
						$this->request->session()->write('comprobante', $comprobante);
						$this->request->session()->write('articulos', $articulos);
						return $this->redirect(['action' => 'add_ticket']);
					} else {
						$comprobante = null;
						$articulos = null;
						if ($reclamo['tipo'] == 0)
							$tipo = 'la Devolución';
						else
							$tipo = 'el Reclamo';
						$this->Flash->error('Pasaron las 72 horas para realizar ' . $tipo, ['key' => 'changepass']);
					}
				} else {
					$this->request->session()->write('comprobante', $comprobante);
					$this->request->session()->write('articulos', $articulos);
					return $this->redirect(['action' => 'add_ticket']);
				}
			} else {
				$comprobante = null;
				$articulos = null;
				$this->Flash->error('Comprobante no valido, intente nuevamente.', ['key' => 'changepass']);
			}
		} else {
			if (!empty($this->request->session()->read('reclamo')))
				$reclamo = $this->request->session()->read('reclamo');
		}
		$this->set('comprobante', $comprobante);
		$this->set('articulos', $articulos);
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

		$this->loadModel('ReclamosTipos');
		$reclamostipos =  $this->ReclamosTipos->find('list', ['keyField' => 'id', 'valueField' => 'nombre']);
		$this->set(compact('reclamo', 'reclamostipos'));
		$this->set('_serialize', ['reclamo']);
		$this->loadModel('Categorias');
		$this->set('categorias', $this->Categorias->find('list', ['keyField' => 'id', 'valueField' => 'nombre']));
		$this->loadModel('Laboratorios');
		$this->set('laboratorios', $this->Laboratorios->find('list', ['keyField' => 'id', 'valueField' => 'nombre']));
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
			$cant_fact = $this->request->data['cantidad_facturada'];
			if ($reclamosItemsTemp['cantidad'] > $cant_fact) {
				$this->Flash->error(__('Ingreso más unidades que figuran en la factura.'), ['key' => 'changepass']);
				return $this->redirect(['controller' => 'Tickets', 'action' => 'add_ticket']);
			}
			if ($this->request->data['fecha_vencimiento'] != null) {

				$fv = $this->request->data['fecha_vencimiento'];
				$fvp = explode("/", $fv);
				echo $fvp[0]; // porción1
				echo $fvp[1]; // porción2

				$fecha_vencimiento = Time::now();
				$fecha_vencimiento->setDate($fvp[1], $fvp[0], 1);

				$fecha_vencimiento->i18nFormat('yyyy-MM-dd');
			} else
				$fecha_vencimiento = null;
			$reclamosItemsTemp['fecha_vencimiento'] =  $fecha_vencimiento;
			$reclamosItemsTemp['lote'] = $this->request->data['lote'];
			$reclamosItemsTemp['serie'] = $this->request->data['serie'];

			$creado = Time::now();
			$creado->i18nFormat('yyyy-MM-dd H:i:s');
			$reclamosItemsTemp['creado'] = $creado;

			if ($this->ReclamosItemsTemps->save($reclamosItemsTemp)) {
				$this->Flash->success(__('Se agrego el item al ticket.'), ['key' => 'changepass']);
				return $this->redirect(['controller' => 'Tickets', 'action' => 'add_ticket']);
			} else {
				$this->Flash->error(__('No se pudo agregar el itme al ticket, intente de nuevo.'), ['key' => 'changepass']);
			}
		}
		$this->set(compact('reclamosItemsTemp'));
		$this->set('_serialize', ['reclamosItemsTemp']);
		$this->redirect(['controller' => 'Tickets', 'action' => 'add_ticket']);
	}

	public function searchitem()
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

			if ($this->request->data['terminobuscar'] != null) {
				$terminocompleto = explode(" ", $this->request->data['terminobuscar']);
				$termsearch = "";
				if (count($terminocompleto) > 1) {
					foreach ($terminocompleto as $terminosimple):
						$termsearch = $termsearch . '%' . $terminosimple . '%';
					endforeach;
				} else
					$termsearch = '%' . $terminocompleto[0] . '%';
			} else {
				$termsearch = "";
			}

			$this->request->session()->write('termsearch', $termsearch);
			$this->request->session()->write('categoriaid', $categoriaid);
			$this->request->session()->write('laboratorioid', $laboratorioid);
		} else {
			$categoriaid = $this->request->session()->read('categoriaid');
			$laboratorioid = $this->request->session()->read('laboratorioid');
			$termsearch = $this->request->session()->read('termsearch');
		}
		$this->viewBuilder()->layout('store');
		$this->paginate = [
			'contain' => ['Laboratorios', 'Categorias'],
			'limit' => 10,
			'order' => ['Articulos.descripcion_pag' => 'asc']
		];

		$this->loadModel('Articulos');
		$categorias = $this->Articulos->Categorias->find('list', ['limit' => 200]);


		$articulosA = $this->Articulos->find()
			->where(['eliminado' => 0]);

		if ($termsearch != "") {
			$articulosA->andWhere([

				'OR' => [
					['Articulos.descripcion_pag LIKE' => $termsearch],
					['Articulos.troquel LIKE' => $termsearch],
					['Articulos.codigo_barras LIKE' => $termsearch]
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

						$articulosA = null;
						$this->redirect($this->referer());
					}
				}
			}
		}

		if ($articulosA != null) {
			$articulos = $this->paginate($articulosA);
		} else {
			$articulos = null;
		}

		$this->request->session()->write('articulos', $articulos);
		return $this->redirect(['action' => 'add_ticket']);
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
		$this->viewBuilder()->layout('admin2');
		$this->paginate = [
			'order' => ['Reclamos.id' => 'DESC'],
			'limit' => 100,
			'contain' => ['Clientes', 'ReclamosTipos', 'ReclamosEstados']
		];
		$fechahasta2 = Time::now();

		$fechahasta2->modify('+1 days');
		$fechahasta2->i18nFormat('yyyy-MM-dd');

		$fechadesde2 = Time::now();
		$fechadesde2->i18nFormat('yyyy-MM-dd');

		$reclamos = $this->Reclamos->find('all')
			->where(["Reclamos.creado BETWEEN '" . $fechadesde2->i18nFormat('yyyy-MM-dd') . "' AND '" . $fechahasta2->i18nFormat('yyyy-MM-dd') . "'"]);

		$this->loadModel('ReclamosEstados');
		$ReclamosEstados = $this->Reclamos->ReclamosEstados->find('list', ['keyField' => 'id', 'valueField' => 'nombre']);
		$ReclamosEstados->toArray();
		$this->set(compact('ReclamosEstados'));

		$this->set('reclamos', $this->paginate($reclamos));

		$this->loadModel('ReclamosTipos');
		$reclamosTipos = $this->ReclamosTipos->find('list', ['keyField' => 'id', 'valueField' => 'nombre']);
		$this->set('ReclamosTipos', $reclamosTipos->toArray());


		$this->set('_serialize', ['reclamos']);
		$this->set('titulo', 'Lista de Tickets');
	}

	public function index_admin_search()
	{
		$this->viewBuilder()->layout('admin2');
		$this->paginate = [
			'order' => ['Reclamos.id' => 'DESC'],
			'limit' => 100,
			'contain' => ['Clientes', 'ReclamosTipos', 'ReclamosEstados']
		];

		if ($this->request->is('post')) {

			if ($this->request->data['fechadesde'] != null)
				$fechadesde = $this->request->data['fechadesde'];
			else
				$fechadesde = 0;
			if ($this->request->data['fechahasta'] != null)
				$fechahasta = $this->request->data['fechahasta'];
			else
				$fechahasta = 0;


			if ($this->request->data['termino'] != null) {
				$termnumero =  $this->request->data['termino'];
			} else
				$termnumero = 0;

			if ($this->request->data['termino2'] != null) {
				$terminocompleto = explode(" ", $this->request->data['termino2']);
				$termcliente = "";
				if (count($terminocompleto) > 1) {
					foreach ($terminocompleto as $terminosimple):
						$termcliente = $termcliente . '%' . $terminosimple . '%';
					endforeach;
				} else
					$termcliente = '%' . $terminocompleto[0] . '%';
			} else {
				$termcliente = "";
			}

			if ($this->request->data['termino3'] != null) {
				$terminocompleto = explode(" ", $this->request->data['termino3']);
				$termsearchp = "";
				if (count($terminocompleto) > 1) {
					foreach ($terminocompleto as $terminosimple):
						$termsearchp = $termsearchp . '%' . $terminosimple . '%';
					endforeach;
				} else
					$termsearchp = '%' . $terminocompleto[0] . '%';
			} else {
				$termsearchp = "";
			}


			if ($this->request->data['reclamos_tipo_id'] != null)
				$tiporeclamo = $this->request->data['reclamos_tipo_id'];
			else
				$tiporeclamo = 0;

			$this->request->session()->write('reclamos_tipo_id', $tiporeclamo);
			$this->request->session()->write('termsearchp', $termsearchp);
			$this->request->session()->write('termcliente', $termcliente);
			$this->request->session()->write('termnumero', $termnumero);
			$this->request->session()->write('fechadesde', $fechadesde);
			$this->request->session()->write('fechahasta', $fechahasta);
		} else {
			$fechahasta = $this->request->session()->read('fechahasta');
			$fechadesde = $this->request->session()->read('fechadesde');
			$termsearchp = $this->request->session()->read('termsearchp');
			$termnumero = $this->request->session()->read('termnumero');
			$termcliente = $this->request->session()->read('termcliente');
			$tiporeclamo = $this->request->session()->read('reclamos_tipo_id');
		}
		if (isset($this->request->data['btnexcel'])) {
			//$this->excel();
			return $this->redirect(['action' => 'excel']);
		}
		if ($fechahasta != 0) {
			//$fechahasta2 = Time::now();
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
			//$fechahasta2 = $fechahasta2->i18nFormat('yyyy-MM-dd');
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

		if (($fechadesde != 0) || ($fechahasta != 0) || ($termsearchp != "") || ($termcliente != "") || ($termnumero != 0) || ($tiporeclamo != 0)) {
			$reclamosA = $this->Reclamos->find()
				->contain(['Clientes', 'ReclamosTipos', 'ReclamosEstados'])
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
		} else {
			$reclamosA = null;
			$this->redirect($this->referer());
		}

		if ($tiporeclamo != 0)
			$reclamosA->where(['Reclamos.reclamos_tipo_id' => $tiporeclamo]);
		if (($fechadesde != 0) || ($fechahasta != 0))
			$reclamosA->andWhere(["Reclamos.creado BETWEEN '" . $fechadesde2->i18nFormat('yyyy-MM-dd') . "' AND '" . $fechahasta2->i18nFormat('yyyy-MM-dd') . "'"]);


		if ($termsearchp != "") {
			$termsearchp2 = $termsearchp;
			$termsearchp = "%" . $termsearchp . "%";
			$reclamosA->where(['a.descripcion_pag LIKE' => $termsearchp])->orWhere(['a.troquel LIKE' => $termsearchp]);
		}
		if ($termcliente != "") {
			$reclamosA->where(['c.codigo' => str_replace("%", "", $termcliente)])->orWhere(['c.razon_social LIKE' => $termcliente]);
		}

		if ($termnumero != 0) {
			$reclamosA->where(['Reclamos.id' => $termnumero]);
		}


		if ($reclamosA != null)
			$reclamos = $this->paginate($reclamosA);
		else
			$reclamos = null;


		$this->loadModel('ReclamosEstados');
		$ReclamosEstados = $this->Reclamos->ReclamosEstados->find('list', ['keyField' => 'id', 'valueField' => 'nombre']);
		$ReclamosEstados->toArray();
		$this->set(compact('ReclamosEstados'));


		$this->set('reclamos', $reclamos);

		$this->loadModel('ReclamosTipos');
		$reclamosTipos = $this->ReclamosTipos->find('list', ['keyField' => 'id', 'valueField' => 'nombre']);
		$this->set('ReclamosTipos', $reclamosTipos->toArray());
		$this->set('_serialize', ['reclamos']);
		$this->set('titulo', 'Lista de reclamos');
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
		$this->viewBuilder()->layout('admin2');
		if ($id == null) {
			$id = $this->request->session()->read('reclamoid');
		}

		/*$reclamo = $this->Reclamos->get($id, [
			'contain' => ['Clientes', 'ReclamosTipos', 'ReclamosEstados', 'ReclamosMensajes', 'ReclamosMensajes.Clientes']
		]);*/

		$reclamo = $this->Reclamos->find()
			->where(['Reclamos.id' => $id])
			->contain(['Clientes', 'ReclamosTipos', 'ReclamosEstados', 'ReclamosMensajes', 'ReclamosMensajes.Clientes'])
			->first();

		if (!$reclamo) {
			return $this->redirect(['action' => 'index_admin']);
		}

		if ($reclamo->cantidad_notificaciones_admin > 0) {
			$reclamo->cantidad_notificaciones_admin = 0;
			if ($this->Reclamos->save($reclamo)) {
			}
		}

		$this->loadModel('ReclamosItems');

		$reclamositems = $this->ReclamosItems->find()
			->select([
				'ReclamosItems.id',
				'ReclamosItems.reclamo_id',
				'ReclamosItems.articulo_id',
				'ReclamosItems.cantidad',
				'ReclamosItems.detalle',
				'ReclamosItems.fecha_vencimiento',
				'ReclamosItems.lote',
				'ReclamosItems.serie',
			])
			->innerJoinWith('Articulos')
			->contain(['Articulos', 'Articulos.Categorias', 'Articulos.Subcategorias', 'Articulos.Marcas', 'Articulos.Laboratorios', 'Articulos.Proveedors'])
			->where(['ReclamosItems.reclamo_id' => $id])
			->toArray();

		$this->set('reclamoid', $id);
		$this->set('reclamositemstemps', $reclamositems);
		$this->set('reclamo', $reclamo);
		$this->set('_serialize', ['reclamo']);
		$this->set('_serialize', ['reclamositemstemps']);


		//$reclamo = $this->Reclamos->newEntity();
		if ($reclamo['estado_id'] < 2)
			$reclamo['estado_id']  = 2;
		$reclamo['leido']  = 1;
		if ($this->Reclamos->save($reclamo)) {
		}

		if ($this->request->session()->read('Categorias') == null) {
			$this->loadModel('Categorias');
			$this->loadModel('Laboratorios');
			$categorias = $this->Categorias->find('list', ['keyField' => 'id', 'valueField' => 'nombre']);
			$laboratorios = $this->Laboratorios->find('list', ['keyField' => 'id', 'valueField' => 'nombre'])->order(['nombre' => 'ASC']);
			$categorias = $categorias->toArray();
			$laboratorios = $laboratorios->toArray();
			$this->request->session()->write('Categorias', $categorias);
			$this->request->session()->write('Laboratorios', $laboratorios);
		} else {
			$laboratorios = $this->request->session()->read('Laboratorios');
			$categorias = $this->request->session()->read('Categorias');
		}

		$this->loadModel('ReclamosEstados');
		$reclamosEstados = $this->Reclamos->ReclamosEstados->find('list', ['keyField' => 'id', 'valueField' => 'nombre']);
		$reclamosEstados->toArray();
		$this->set(compact('reclamosEstados'));
		$this->set('laboratorios', $laboratorios);
		$this->set('_serialize', ['reclamo']);
		$this->set('titulo', 'Visualizar Ticket');
	}

	public function ticket_mail($id = null)
	{
		$this->viewBuilder()->layout('admin2');
		if ($id == null) {
			$id = $this->request->session()->read('reclamoid');
		}

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
				'a.codigo_barras',
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
		$this->set('reclamoid', $id);
		$this->set('reclamositemstemps', $reclamositems);
		$this->set('reclamo', $reclamo);
		$this->set('_serialize', ['reclamo']);
		$this->set('_serialize', ['reclamositemstemps']);

		$this->request->session()->write('reclamositemstemps', $reclamositems->toArray());


		//$reclamo = $this->Reclamos->newEntity();
		if ($reclamo['estado_id'] < 2)
			$reclamo['estado_id']  = 2;
		$reclamo['leido']  = 1;
		if ($this->Reclamos->save($reclamo)) {
		}
		$this->request->session()->write('reclamo', $reclamo->toArray());
		if ($this->request->session()->read('Categorias') == null) {
			$this->loadModel('Categorias');
			$this->loadModel('Laboratorios');
			$categorias = $this->Categorias->find('list', ['keyField' => 'id', 'valueField' => 'nombre']);
			$laboratorios = $this->Laboratorios->find('list', ['keyField' => 'id', 'valueField' => 'nombre'])->order(['nombre' => 'ASC']);
			$categorias = $categorias->toArray();
			$laboratorios = $laboratorios->toArray();
			$this->request->session()->write('Categorias', $categorias);
			$this->request->session()->write('Laboratorios', $laboratorios);
		} else {

			$laboratorios = $this->request->session()->read('Laboratorios');
			$categorias = $this->request->session()->read('Categorias');
		}

		$this->loadModel('ReclamosEstados');
		$ReclamosEstados = $this->Reclamos->ReclamosEstados->find('list', ['keyField' => 'id', 'valueField' => 'nombre']);
		$ReclamosEstados->toArray();
		//$this->request->session()->write('ReclamosEstados',$ReclamosEstados);

		$this->set(compact('ReclamosEstados'));

		$this->set('laboratorios', $laboratorios);


		$this->set('titulo', 'Detalles del Ticket');
	}

	/**
	 * Edit method
	 *
	 * @param string|null $id Reclamo id.
	 * @return void Redirects on successful edit, renders view otherwise.
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */
	public function edit_admin($id = null, $estado = null)
	{
		$this->viewBuilder()->layout('admin2');
		$reclamo = $this->Reclamos->get($id, [
			'contain' => ['Clientes', 'ReclamosTipos', 'ReclamosEstados']
		]);



		$estadoAnterior = $reclamo->reclamos_estado->nombre ?? 'Sin estado';

		$nuevoEstado = $this->Reclamos->ReclamosEstados->get($estado)->nombre;


		if ($this->request->is(['patch', 'post', 'put', 'get'])) {
			$reclamo = $this->Reclamos->patchEntity($reclamo, $this->request->data);
			$reclamo['estado_id'] = $estado;
			if ($this->Reclamos->save($reclamo)) {
				$this->Flash->success('Se modifico el estado del ticket', ['key' => 'changepass']);
				//$this->Flash->success('The reclamo has been saved.');
				return $this->redirect(['action' => 'index_admin']);
			} else {
				$this->Flash->error('No se pudo modificar el estado del ticket', ['key' => 'changepass']);
			}
		}
		$clientes = $this->Reclamos->Clientes->find('list', ['limit' => 200]);
		$reclamosTipos = $this->Reclamos->ReclamosTipos->find('list', ['limit' => 200]);
		$this->loadModel('ReclamosEstados');
		$ReclamosEstados = $this->Reclamos->ReclamosEstados->find('list', ['keyField' => 'id', 'valueField' => 'nombre']);
		$ReclamosEstados->toArray();

		$this->set(compact('reclamo', 'clientes', 'reclamosTipos', 'ReclamosEstados'));
		$this->set('_serialize', ['reclamo']);
		$this->set('titulo', 'Cambiar estado del reclamo');
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

	public function enviar_ticket_mail()
	{
		$this->loadModel('Contactos');
		$contacto = $this->Contactos->newEntity();
		if ($this->request->is('post')) {
			$contacto = $this->Contactos->patchEntity($contacto, $this->request->data);
			if (is_null($contacto['email'])) {
				$this->Flash->error('ingrese un correo electronico', ['key' => 'changepass']);
				return $this->redirect($this->referer());
			}
			if (is_null($contacto['nombre'])) {
				$this->Flash->error('ingrese un asunto', ['key' => 'changepass']);
				return $this->redirect($this->referer());
			}
			if (is_null($contacto['detalle']))
				$contacto['detalle'] = "";

			$this->request->session()->write('contacto', $contacto);
			$this->sendReclamo($contacto['email'], $contacto['detalle'], $contacto['nombre']);
			return $this->redirect($this->referer());
			//$this->redirect(['controller'=>'pages','action' => 'display']);
			/*if ($this->Contactos->save($contacto)) {
                                                  
				
				$this->Flash->success('The contacto has been saved.');
                
            } else {
                $this->Flash->error('The contacto could not be saved. Please, try again.');
				//return $this->redirect(['controller' => 'contactos','action' => 'add']);
            }*/
		}
		$this->set(compact('contacto'));
		$this->set('_serialize', ['contacto']);
	}

	function sendReclamo($cont_email, $cont_cuerpo, $cont_name)
	{
		/*
				switch ($quien) {
					
					    case 0: $para = 'ventas@drogueriasur.com.ar'; break;
						case 1: $para = 'cobranzas@drogueriasur.com.ar'; break;
						case 2: $para = 'compras@drogueriasur.com.ar'; break;
						case 3: $para = 'ventas@drogueriasur.com.ar'; break;
						case 4: $para = 'perfumeria@drogueriasur.com.ar'; break;
						case 5: $para = 'sistemas@drogueriasur.com.ar'; break;
						//case 5:break;
						
					}
				*/
		//$para = 'mdedios@drogueriasur.com.ar'; 
		$this->request->session()->write('para', $cont_email);
		$email = new Email();
		$email->transport('reclamo');
		//$email->transport('gmail');
		try {
			$res = $email->from(['reclamos@drogueriasur.com.ar' => 'Drogueria Sur'])
				//->replyTo(['reclamos@drogueriasur.com.ar' => ' Drogueria Sur'])
				->replyTo(['reclamos@drogueriasur.com.ar' => 'Reclamos y devoluciones Drogueria Sur'])
				->template('ticket', 'ticket')
				->emailFormat('html')
				->to([$cont_email => $cont_email])
				->bcc(["reclamos@drogueriasur.com.ar" => "reclamos@drogueriasur.com.ar"])
				->subject($cont_name)
				->viewVars([
					'reclamo' => $this->request->session()->read('reclamo'),
					'reclamositemstemps' => $this->request->session()->read('reclamositemstemps'),
					'laboratorios' => $this->request->session()->read('Laboratorios')
				])
				->send($cont_cuerpo);
		} catch (Exception $e) {

			echo 'Exception : ',  $e->getMessage(), "\n";
		}
	}

	public function excel()
	{
		$this->viewBuilder()->layout('ajax');
		ini_set('memory_limit', '-1');

		$this->paginate = [
			'order' => ['Reclamos.id' => 'DESC'],
			'limit' => 5000,
			'maxLimit' => 5000,

		];

		if ($this->request->is('post')) {

			if ($this->request->data['fechadesde'] != null)
				$fechadesde = $this->request->data['fechadesde'];
			else
				$fechadesde = 0;
			if ($this->request->data['fechahasta'] != null)
				$fechahasta = $this->request->data['fechahasta'];
			else
				$fechahasta = 0;


			if ($this->request->data['termino'] != null) {
				$termnumero =  $this->request->data['termino'];
			} else
				$termnumero = 0;

			if ($this->request->data['termino2'] != null) {
				$terminocompleto = explode(" ", $this->request->data['termino2']);
				$termcliente = "";
				if (count($terminocompleto) > 1) {
					foreach ($terminocompleto as $terminosimple):
						$termcliente = $termcliente . '%' . $terminosimple . '%';
					endforeach;
				} else
					$termcliente = '%' . $terminocompleto[0] . '%';
			} else {
				$termcliente = "";
			}

			if ($this->request->data['termino3'] != null) {
				$terminocompleto = explode(" ", $this->request->data['termino3']);
				$termsearchp = "";
				if (count($terminocompleto) > 1) {
					foreach ($terminocompleto as $terminosimple):
						$termsearchp = $termsearchp . '%' . $terminosimple . '%';
					endforeach;
				} else
					$termsearchp = '%' . $terminocompleto[0] . '%';
			} else {
				$termsearchp = "";
			}


			if ($this->request->data['reclamos_tipo_id'] != null)
				$tiporeclamo = $this->request->data['reclamos_tipo_id'];
			else
				$tiporeclamo = 0;

			$this->request->session()->write('reclamos_tipo_id', $tiporeclamo);
			$this->request->session()->write('termsearchp', $termsearchp);
			$this->request->session()->write('termcliente', $termcliente);
			$this->request->session()->write('termnumero', $termnumero);
			$this->request->session()->write('fechadesde', $fechadesde);
			$this->request->session()->write('fechahasta', $fechahasta);
			$simple = 0;
		} else {
			$fechahasta = $this->request->session()->read('fechahasta');
			$fechadesde = $this->request->session()->read('fechadesde');
			$termsearchp = $this->request->session()->read('termsearchp');
			$termnumero = $this->request->session()->read('termnumero');
			$termcliente = $this->request->session()->read('termcliente');
			$tiporeclamo = $this->request->session()->read('reclamos_tipo_id');
			$simple = 1;
		}

		if ($fechahasta != 0) {
			//$fechahasta2 = Time::now();
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
			//$fechahasta2 = $fechahasta2->i18nFormat('yyyy-MM-dd');
		}
		if ($fechadesde != 0) {
			//$fechadesde2 = Time::now();
			$fechadesde2 = Time::createFromFormat('d/m/Y', $fechadesde, 'America/Argentina/Buenos_Aires');
			$fechadesde2->i18nFormat('yyyy-MM-dd');
		} else {
			$fechadesde2 = Time::now();

			/*if ($fechahasta!=0)
				$fechadesde2->setDate($fechadesde2->year, $fechahasta2->month, 1);
			else
				$fechadesde2->setDate($fechadesde2->year, $fechadesde2->month, 1);*/
			$fechadesde2->i18nFormat('yyyy-MM-dd');
		}

		if (($fechadesde != 0) || ($fechahasta != 0) || ($termsearchp != "") || ($termcliente != "") || ($termnumero != 0) || ($tiporeclamo != 0)) {
			$reclamosA = $this->Reclamos->find()
				->contain(['Clientes', 'ReclamosTipos', 'ReclamosEstados', 'ReclamosItems', 'ReclamosItems.Articulos'])
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
		} else {


			if ($simple == 1) {
				$reclamosA = $this->Reclamos->find('all')
					->contain(['Clientes', 'ReclamosTipos', 'ReclamosEstados', 'ReclamosItems', 'ReclamosItems.Articulos'])
					->where(["Reclamos.creado BETWEEN '" . $fechadesde2->i18nFormat('yyyy-MM-dd') . "' AND '" . $fechahasta2->i18nFormat('yyyy-MM-dd') . "'"]);
				if ($reclamosA != null)
					$reclamos = $this->paginate($reclamosA);
				else
					$reclamos = null;
			} else {
				$reclamosA = null;
				$this->redirect($this->referer());
			}
		}

		if ($simple == 0) {
			if ($tiporeclamo != 0)
				$reclamosA->where(['Reclamos.reclamos_tipo_id' => $tiporeclamo]);
			if (($fechadesde != 0) || ($fechahasta != 0))
				$reclamosA->andWhere(["Reclamos.creado BETWEEN '" . $fechadesde2->i18nFormat('yyyy-MM-dd') . "' AND '" . $fechahasta2->i18nFormat('yyyy-MM-dd') . "'"]);


			if ($termsearchp != "") {
				$termsearchp2 = $termsearchp;
				$termsearchp = "%" . $termsearchp . "%";
				$reclamosA->where(['a.descripcion_pag LIKE' => $termsearchp])->orWhere(['a.troquel LIKE' => $termsearchp]);
			}
			if ($termcliente != "") {
				$reclamosA->where(['c.codigo LIKE' => str_replace("%", "", $termcliente)])->orWhere(['c.razon_social LIKE' => $termcliente]);
			}

			if ($termnumero != 0) {
				$reclamosA->where(['Reclamos.id' => $termnumero]);
			}
		}


		if ($reclamosA != null)
			$reclamos = $this->paginate($reclamosA);
		else {
			if ($simple == 1) {
				$reclamosA = $this->Reclamos->find('all')
					->contain(['Clientes', 'ReclamosTipos', 'ReclamosEstados'])
					->where(["Reclamos.creado BETWEEN '" . $fechadesde2->i18nFormat('yyyy-MM-dd') . "' AND '" . $fechahasta2->i18nFormat('yyyy-MM-dd') . "'"]);
				if ($reclamosA != null)
					$reclamos = $this->paginate($reclamosA);
				else
					$reclamos = null;
			} else {
				$reclamos = null;
			}
		}



		$this->loadModel('ReclamosEstados');
		$ReclamosEstados = $this->Reclamos->ReclamosEstados->find('list', ['keyField' => 'id', 'valueField' => 'nombre']);
		$ReclamosEstados->toArray();
		$this->set(compact('ReclamosEstados'));


		$this->set('reclamos', $reclamos);

		$this->loadModel('ReclamosTipos');
		$reclamosTipos = $this->ReclamosTipos->find('list', ['keyField' => 'id', 'valueField' => 'nombre']);
		$this->set('ReclamosTipos', $reclamosTipos->toArray());
		$this->set('_serialize', ['reclamos']);
		$this->response->type('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	}


	public function enviarMensajes()
	{
		$this->loadModel('ReclamosMensajes');
		$mensajesSugerencia = $this->ReclamosMensajes->newEntity();

		if ($this->request->is('post')) {
			$mensajesSugerencia = $this->ReclamosMensajes->patchEntity($mensajesSugerencia, $this->request->getData());
			$mensajesSugerencia->cliente_id = $this->request->getSession()->read('Auth.User.cliente_id');


			$imagen = $this->request->getData('imagen');
			if ((!empty($imagen['name'])) || ($imagen['name'] != '')) {
				$allowedTypes = ['image/png', 'image/jpeg'];
				if (!in_array($imagen['type'], $allowedTypes)) {
					$this->Flash->error(__('El archivo debe ser una imagen PNG o JPG.'));
					return $this->redirect(['action' => 'view', $mensajesSugerencia->reclamo_id]);
				}

				$maxFileSize = 2 * 1024 * 1024; // 2 MB
				if ($imagen['size'] > $maxFileSize) {
					$this->Flash->error(__('El archivo no debe superar los 2 MB.'));
					return $this->redirect(['action' => 'view', $mensajesSugerencia->reclamo_id]);
				}

				$uploadDir = WWW_ROOT . 'reclamos' . DS . $mensajesSugerencia->reclamo_id . DS . 'imagen';
				if (!is_dir($uploadDir)) {
					mkdir($uploadDir, 0777, true);
				}

				$filename = time() . '_' . $imagen['name'];
				$filepath = $uploadDir . DS . $filename;

				try {
					if (move_uploaded_file($imagen['tmp_name'], $filepath)) {
						$mensajesSugerencia->imagen =  $filename;
					} else {
						$this->Flash->error(__('No se puede cargar el archivo, inténtelo de nuevo.'));
						return $this->redirect(['action' => 'view', $mensajesSugerencia->reclamo_id]);
					}
				} catch (\Exception $e) {
					$this->Flash->error(__('Error al guardar la imagen: ' . $e->getMessage()));
					return $this->redirect(['action' => 'view', $mensajesSugerencia->reclamo_id]);
				}
			}


			if ((empty($imagen['name']) || $imagen['name'] == '') && (empty($mensajesSugerencia->mensaje) || $mensajesSugerencia->mensaje == '')) {
				$this->Flash->error(__('El mensaje o la imagen no se han enviado, por favor rellene algún campo.'));
				return $this->redirect(['action' => 'view', $mensajesSugerencia->reclamo_id]);
			}


			if ($this->ReclamosMensajes->save($mensajesSugerencia)) {
				$reclamo = $this->Reclamos->get($mensajesSugerencia->reclamo_id, [
					'contain' => [],
				]);

				$reclamo->cantidad_notificaciones_admin = $reclamo->cantidad_notificaciones_admin + 1;

				if ($this->Reclamos->save($reclamo)) {
					return $this->redirect(['action' => 'view', $mensajesSugerencia->reclamo_id]);
					$this->Flash->success(__('El mensaje ha sido enviado.'));
				}
			}

			$this->Flash->error(__('El mensaje no ha podido ser enviado, intente nuevamente.'));
			return $this->redirect(['action' => 'view_admin', $mensajesSugerencia->reclamo_id]);
		}
	}

	public function enviarMensajesAdmin()
	{
		$this->loadModel('ReclamosMensajes');
		$mensajesSugerencia = $this->ReclamosMensajes->newEntity();

		if ($this->request->is('post')) {
			$mensajesSugerencia = $this->ReclamosMensajes->patchEntity($mensajesSugerencia, $this->request->getData());
			$mensajesSugerencia->cliente_id = $this->request->getSession()->read('Auth.User.cliente_id');

			if ($this->request->getSession()->read('Auth.User.cliente_id') == 34525) {
				$mensajesSugerencia->tipo = 'admin';
			}

			$imagen = $this->request->getData('imagen');

			if ((!empty($imagen['name'])) || ($imagen['name'] != '')) {
				$allowedTypes = ['image/png', 'image/jpeg'];
				if (!in_array($imagen['type'], $allowedTypes)) {
					$this->Flash->error(__('El archivo debe ser una imagen PNG o JPG.'));
					return $this->redirect(['action' => 'view', $mensajesSugerencia->reclamo_id]);
				}

				$maxFileSize = 2 * 1024 * 1024; // 2 MB
				if ($imagen['size'] > $maxFileSize) {
					$this->Flash->error(__('El archivo no debe superar los 2 MB.'));
					return $this->redirect(['action' => 'view', $mensajesSugerencia->reclamo_id]);
				}

				$uploadDir = WWW_ROOT . 'reclamos' . DS . $mensajesSugerencia->reclamo_id . DS . 'imagen';
				if (!is_dir($uploadDir)) {
					mkdir($uploadDir, 0777, true);
				}

				$filename = time() . '_' . $imagen['name'];
				$filepath = $uploadDir . DS . $filename;

				try {
					if (move_uploaded_file($imagen['tmp_name'], $filepath)) {
						$mensajesSugerencia->imagen =  $filename;
					} else {
						$this->Flash->error(__('No se puede cargar el archivo, inténtelo de nuevo.'));
						return $this->redirect(['action' => 'view', $mensajesSugerencia->reclamo_id]);
					}
				} catch (\Exception $e) {
					$this->Flash->error(__('Error al guardar la imagen: ' . $e->getMessage()));
					return $this->redirect(['action' => 'view', $mensajesSugerencia->reclamo_id]);
				}
			}



			if ($this->ReclamosMensajes->save($mensajesSugerencia)) {
				if ($this->request->getSession()->read('Auth.User.cliente_id') == 34525) {
					$reclamo = $this->Reclamos->get($mensajesSugerencia->reclamo_id, [
						'contain' => [],
					]);

					$reclamo->cantidad_notificaciones = $reclamo->cantidad_notificaciones + 1;

					if ($this->Reclamos->save($reclamo)) {
						return $this->redirect(['action' => 'view_admin', $reclamo->id]);
						$this->Flash->success(__('El mensaje ha sido enviado.'));
					}
				}
			}
			$this->Flash->error(__('El mensaje no ha podido ser enviado, intente nuevamente.'));
			return $this->redirect(['action' => 'view_admin', $mensajesSugerencia->reclamo_id]);
		}
	}

	public function cambiarEstadoReclamo($id = null)
	{
		if ($this->request->is('post')) {

			$estadoId = $this->request->getData('estado_id');

			$reclamo = $this->Reclamos->get($id, ['contain' => ['ReclamosEstados']]);
			$estadoAnterior = $reclamo->reclamos_estado->nombre ?? 'Sin estado';
			$nuevoEstado = $this->Reclamos->ReclamosEstados->get($estadoId)->nombre;

			$reclamo->estado_id = $estadoId;

			if ($this->Reclamos->save($reclamo)) {
				$mensajeSistema = $this->Reclamos->ReclamosMensajes->newEntity([
					'reclamo_id' => $reclamo->id,
					'cliente_id' => null,
					'tipo' => 'system',
					'mensaje' => "El estado del reclamo cambió de '$estadoAnterior' a '$nuevoEstado'.",
				]);
				$this->Reclamos->ReclamosMensajes->save($mensajeSistema);



				$this->Flash->success(__('El estado del reclamo ha sido actualizado.'));
			} else {
				$this->Flash->error(__('No se pudo actualizar el estado del reclamo.'));
			}

			return $this->redirect($this->referer());
		} else {
			return $this->redirect(['action' => 'view_admin', $id]);
		}
	}

	public function getMensajes($reclamoId)
	{
		$this->request->allowMethod(['get']);

		$mensajes = $this->Reclamos->ReclamosMensajes->find()
			->where(['reclamo_id' => $reclamoId])
			->order(['ReclamosMensajes.id' => 'DESC'])
			->contain(['Clientes', 'Reclamos'])
			->select(['ReclamosMensajes.id', 'ReclamosMensajes.mensaje', 'ReclamosMensajes.tipo', 'ReclamosMensajes.creado', 'ReclamosMensajes.cliente_id', 'ReclamosMensajes.imagen', 'Clientes.razon_social', 'Reclamos.id'])
			->toArray();



		$this->set([
			'mensajes' => $mensajes,
			'_serialize' => ['mensajes']
		]);
	}

	public function getMensajesUser($reclamoId)
	{
		$this->request->allowMethod(['get']);

		$mensajes = $this->Reclamos->ReclamosMensajes->find()
			->where(['reclamo_id' => $reclamoId])
			->order(['ReclamosMensajes.id' => 'DESC'])
			->contain(['Clientes', 'Reclamos'])
			->select(['ReclamosMensajes.id', 'ReclamosMensajes.mensaje', 'ReclamosMensajes.tipo', 'ReclamosMensajes.creado', 'ReclamosMensajes.cliente_id', 'ReclamosMensajes.imagen', 'Clientes.razon_social', 'Reclamos.id'])
			->toArray();


		$reclamo = $this->Reclamos->get($reclamoId, []);
		if ($reclamo->cantidad_notificaciones > 0) {
			$reclamo->cantidad_notificaciones = 0;
			if ($this->Reclamos->save($reclamo)) {
			}
		}


		$this->set([
			'mensajes' => $mensajes,
			'_serialize' => ['mensajes']
		]);
	}
}
