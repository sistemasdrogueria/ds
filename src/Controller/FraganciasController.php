<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Cake\Database\Expression\QueryExpression;
use Cake\Datasource\ConnectionManager;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Helper;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * Fragancias Controller
 *
 * @property \App\Model\Table\FraganciasTable $Fragancias
 */
class FraganciasController extends AppController
{
	public function initialize()
	{
		parent::initialize();

		// Include the FlashComponent
		$this->loadComponent('Flash');
		// Load Files model
		$this->loadModel('Files');
		$this->loadModel('FraganciasPresentaciones');
	}

	public function isAuthorized()
	{
		if (in_array($this->request->action, ['excel', 'edit_admin', 'delete_admin', 'add_admin', 'search_admin', 'index_admin', 'view_admin', 'add_admin_search', 'add_admin_presentacion', 'edit_admin_search', 'edit_fragancias_admin'])) {

			if ($this->request->session()->read('Auth.User.role') == 'admin') {
				return true;
			} else {
				if ($this->request->session()->read('Auth.User.role') == 'client') {
					//$tiene= $this->tienepermiso('carritos',$this->request->action);
					/*if (!$tiene)
							$this->Flash->error(__('No tiene permisos para ingresar'),['key' => 'changepass']);*/
					return false;
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

	public function edit_fragancias_admin()
	{
		$fragancias = TableRegistry::get('Fragancias');
		$entities = $fragancias->newEntities($this->request->getData());

		//$ofertas = TableRegistry::get('Ofertas');
		//$entities = $ofertas->newEntities($this->request->data());
		$this->set('entities', $entities);
		$this->request->session()->write('entities', $entities);
		foreach ($entities as $fragancia) {


			$eliminado = $fragancia['eliminado'];
			$id = $fragancia['id'];

			$fragancia = $this->Fragancias->get($id);

			$fragancia['eliminado'] = $eliminado;

			if ($this->Fragancias->save($fragancia)) {
				$this->Flash->success('Se guardo los cambios correctamente.', ['key' => 'changepass']);
				//$this->redirect($this->referer());
			} else {
				$this->Flash->error('No se pudo guardar los cambios. Intente de nuevo', ['key' => 'changepass']);
			}
		}
		//$this->set('carritos2', $carros);
		$this->redirect($this->referer());
	}
	/**
	 * Index method
	 *
	 * @return void
	 */
	public function index_admin()
	{
		$this->viewBuilder()->layout('admin2');
		$this->paginate = [
			'limit' => 200,
			'maxLimit' => 200,
			'contain' => ['Marcas', 'Generos'],
			'order' => ['Fragancias.id' => 'DESC']
		];


		if ($this->request->is('post', 'get')) {
			if ($this->request->data['terminobusqueda'] != null) {
				$termsearch = '%' . $this->request->data['terminobusqueda'] . '%';
			}
			$this->request->session()->write('termsearch', $termsearch);
			if ($this->request->data['marcas_tipo_id'] != null) {
				$marcas_tipo_id = $this->request->data['marcas_tipo_id'];
			}
			if ($this->request->data['marca_id'] != null) {
				$marcas_id = $this->request->data['marca_id'];
			}
		} else {
			$termsearch = "";
			$marcas_tipo_id = 0;
			$marca_id = 0;
		}

		$fragancias = $this->Fragancias->find('all');

		//marcas_tipo_id
		if ($marcas_tipo_id > 0 || $termsearch != "" || $marca_id>0) {
			if ($marca_id > 0)
				$fragancias->where(['Fragancias.marca_id' => $marca_id]);
			if ($termsearch != "")
				$fragancias->where(['Fragancias.nombre LIKE' => $termsearch]);

				if ($marcas_tipo_id > 0)
				{
				$fragancias->join(
					[
						'table' => 'marcas',
						'alias' => 'm',
						'type' => 'inner',
						'conditions' => [

							'marca_id = m.id',
							'm.marcas_tipos_id' => $marcas_tipo_id
						]
					]

						); 
					}
			$fraganciasa = $this->paginate($fragancias);
		} else {
			$fraganciasa = $this->paginate($fragancias);
		}

		$this->set('fragancias', $fraganciasa);
		$this->set('_serialize', ['fragancias']);
		$this->set('titulo', 'Lista de fragancias');

		$this->loadModel('Marcas');
		if ($marcas_tipo_id ==0)
		$marcas = $this->Marcas->find('list', ['keyField' => 'id', 'valueField' => 'nombre'])
		->andWhere([
			'OR' => [
				['marcas_tipos_id' => 1],
				['marcas_tipos_id' => 18]]]);
		else
		$marcas = $this->Marcas->find('list', ['keyField' => 'id', 'valueField' => 'nombre'])
		->andWhere(['marcas_tipos_id' => $marcas_tipo_id]);
		
		$this->loadModel('MarcasTipos');
		$marcas_tipos = $this->MarcasTipos->find('list', ['keyField' => 'id', 'valueField' => 'nombre'])->where(['id in(1,18)']);
		$this->set('marcas', $marcas->toArray());
		$this->set('_serialize', ['marcas']);
		$this->set('marcas_tipos', $marcas_tipos->toArray());
		$this->set('_serialize', ['marcas_tipos']);
	}

	public function excel()
	{
		$this->viewBuilder()->layout('ajax');

		$this->loadModel('FraganciasPresentaciones');
		/*	
SELECT fp.id, f.nombre, fp.detalle, a.troquel, a.descripcion_sist, a.categoria_id, a.precio_publico FROM 
		
		fragancias_presentaciones fp INNER JOIN articulos a 
		ON fp.articulo_id=a.id INNER JOIN fragancias f ON f.id = fp.fragancia_id WHERE 
  */

		$this->paginate = [
			'contain' => ['fragancias', 'articulos'],
			'limit' => 1000
		];

		$fraganciaspresentaciones = $this->FraganciasPresentaciones->find()->contain(['fragancias', 'articulos']);
		$fraganciaspresentaciones->toArray();

		$this->set(compact('fraganciaspresentaciones'));

		$this->set('_serialize', ['fraganciaspresentaciones']);

		$this->response->type('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	}
	/**
	 * View method
	 *
	 * @param string|null $id Fragancia id.
	 * @return void
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */
	public function view_admin($id = null)
	{
		$this->viewBuilder()->layout('admin2');
		$fragancia = $this->Fragancias->get($id, [
			'contain' => []
		]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$fragancia = $this->Fragancias->patchEntity($fragancia, $this->request->data);
			if ($this->Fragancias->save($fragancia)) {
				$this->Flash->success(__('The fragancia has been saved.'));
				return $this->redirect(['action' => 'index_admin']);
			} else {
				$this->Flash->error(__('The fragancia could not be saved. Please, try again.'));
			}
		}
		$this->request->session()->write('fragancia', $fragancia);
		$marcas = $this->Fragancias->Marcas->find('list', ['keyField' => 'id', 'valueField' => 'nombre'])->order(['nombre' => 'ASC']);
		$generos = $this->Fragancias->Generos->find('list', ['keyField' => 'id', 'valueField' => 'nombre']);
		$this->request->session()->write('fraganciamm', $marcas->toArray());
		if ($fragancia != null) {
			$this->loadModel('FraganciasPresentaciones');
			$fraganciapresentacion = $this->FraganciasPresentaciones->find()
				->contain(['Articulos'])
				->join(
					[
						'table' => 'articulos',
						'alias' => 'a',
						'type' => 'inner',
						'conditions' => [

							'Articulo_id = a.id'

						]
					]

				)
				->where(['fragancia_id' => $fragancia['id']]);

			$this->set('fraganciaspresentaciones', $fraganciapresentacion->toArray());
			$this->set('_serialize', ['fraganciaspresentaciones']);
		} else
			$this->set('fraganciaspresentaciones', null);

		$this->set('titulo', 'Fragancia');
		$fragancia->toArray();
		$this->set('fragancia', $fragancia->toArray());
		$this->set('marcas', $marcas->toArray());
		$this->set('generos', $generos->toArray());
		$this->set('_serialize', ['fragancia']);
	}

	public function search_admin()
	{
		$this->viewBuilder()->layout('admin2');
		$this->paginate = [
			'contain' => ['Marcas', 'Generos']
		];
		$termsearch = "";
		if ($this->request->is('post', 'get')) {
			if ($this->request->data['terminobusqueda'] != null) {
				$termsearch = '%' . $this->request->data['terminobusqueda'] . '%';
			}
			$this->request->session()->write('termsearch', $termsearch);
		} else {
			$termsearch = $this->request->session()->read('termsearch');
		}

		$fragancias = $this->Fragancias->find('all');



		if ($termsearch != "") {
			$fragancias->where(['Fragancias.nombre LIKE' => $termsearch]);
			$fraganciasa = $this->paginate($fragancias);
		} else {
			$fraganciasa = null;
		}


		$this->set('fragancias', $fraganciasa);
		$this->set('_serialize', ['fragancias']);
		$this->set('titulo', 'Lista de fragancias');
	}




	public function add_admin()
	{
		$this->viewBuilder()->layout('admin2');
		$this->set('titulo', 'Fragancias Importadas');
		$fragancia = $this->Fragancias->newEntity();
		if ($this->request->is('post')) {
			$fragancia = $this->Fragancias->patchEntity($fragancia, $this->request->data);
			//$fechadesde = Time::createFromFormat('d/m/Y',$this->request->data['fecha_desde'],'America/Argentina/Buenos_Aires');
			//$fechadesde->i18nFormat('yyyy-MM-dd');
			//	$fechahasta = Time::createFromFormat('d/m/Y',$this->request->data['fecha_hasta'],'America/Argentina/Buenos_Aires');
			//$fechahasta->i18nFormat('yyyy-MM-dd');

			//$fragancia['fecha_desde'] = $fechadesde;
			//$fragancia['fecha_hasta'] = $fechahasta;
			$uploadData = '';
			if (!empty($this->request->data['file']['name'])) {
				$fileName = $this->request->data['file']['name'];

				$uploadPath = 'img/fragancias/';



				$uploadFile = $uploadPath . $fileName;
				$fragancia['imagen'] = $fileName;
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
						//$this->redirect($this->referer());
					}
				} else {
					$this->Flash->error(__('Unable to upload file, please try again.'), ['key' => 'changepass']);
					//$this->redirect($this->referer());
				}
			} else {
				$this->Flash->error(__('Please choose a file to upload.'), ['key' => 'changepass']);
				//$this->redirect($this->referer());
			}

			if ($this->Fragancias->save($fragancia)) {

				$this->Flash->success(__('La fragancia fue cargada correctamente'), ['key' => 'changepass']);
				//return $this->redirect(['action' => 'index_admin']);
			} else {
				$this->Flash->error(__('No se pudo cargar la fragancia, intente nuevamente'), ['key' => 'changepass']);
				//$this->redirect($this->referer());	
			}
			$this->request->session()->write('fragancia', $fragancia);
		}
		$this->loadModel('Marcas');

		$marcas = $this->Fragancias->Marcas->find('list', ['keyField' => 'id', 'valueField' => 'nombre'])->where(['marcas_tipos_id IN (1,18)'])->order(['nombre' => 'ASC']);
		$generos = $this->Fragancias->Generos->find('list', ['keyField' => 'id', 'valueField' => 'nombre'])->order(['nombre' => 'ASC']);
		$marcas->toArray();
		$generos->toArray();

		if ($fragancia != null) {
			$this->loadModel('FraganciasPresentaciones');
			$fraganciapresentacion = $this->FraganciasPresentaciones->find()->where(['fragancia_id' => $fragancia['id']]);

			$this->set('fraganciasPresentaciones', $fraganciapresentacion->toArray());
			$this->set('_serialize', ['fraganciasPresentaciones']);
		} else
			$this->set('fraganciasPresentaciones', null);



		$this->set(compact('fragancia', 'marcas', 'generos'));
	}

	public function add_admin_presentacion()
	{

		$fraganciasPresentacione = $this->FraganciasPresentaciones->newEntity();
		if ($this->request->is('post')) {
			$fraganciasPresentacione = $this->FraganciasPresentaciones->patchEntity($fraganciasPresentacione, $this->request->data);
			if ($this->FraganciasPresentaciones->save($fraganciasPresentacione)) {
				$this->Flash->success(__('The fragancias presentacione has been saved.', ['key' => 'changepass']));
			} else {
				$this->Flash->error(__('The fragancias presentacione could not be saved. Please, try again.', ['key' => 'changepass']));
			}
		}
		//$articulos = $this->FraganciasPresentaciones->Articulos->find('list', ['limit' => 200]);
		//$fragancias = $this->FraganciasPresentaciones->Fragancias->find('list', ['limit' => 200]);
		//$this->set(compact('fraganciasPresentacione', 'articulos', 'fragancias'));
		//$this->set('_serialize', ['fraganciasPresentacione']);
		$this->redirect($this->referer());
	}


	public function add_admin_search()
	{
		$this->loadModel('Articulos');
		$this->set('titulo', 'Fragancias Importadas');
		$this->viewBuilder()->layout('admin2');
		if ($this->request->is('post')) {
			if ($this->request->data['terminobuscar'] != null) {
				$termsearch = '%' . $this->request->data['terminobuscar'] . '%';
			}
			$this->request->session()->write('termsearch', $termsearch);
		} else {
			$termsearch = $this->request->session()->read('termsearch');
		}

		$articulosA = $this->Articulos->find()
			->hydrate(false)
			->andWhere([
				'OR' => [
					['Articulos.laboratorio_id' => 1],
					['Articulos.laboratorio_id' => 9],
					['Articulos.laboratorio_id' => 26],
					['Articulos.laboratorio_id' => 84], //Marce esto lo agregue yo , por aca argenis// benito  fernandez
					['Articulos.laboratorio_id' => 86], //Marce esto lo agregue yo , por aca argenis//  epica, craftmen
					['Articulos.laboratorio_id' => 88],
					['Articulos.laboratorio_id' => 131], //Marce esto lo agregue yo , por aca argenis// estetica francesa 
					['Articulos.laboratorio_id' => 186], //Marce esto lo agregue yo , por aca argenis//  giesso, loval 
					['Articulos.laboratorio_id' => 193], //Marce esto lo agregue yo , por aca argenis// boos, padoc
					['Articulos.laboratorio_id' => 218], //Marce esto lo agregue yo , por aca argenis// La roche posay
					['Articulos.laboratorio_id' => 333], //Marce esto lo agregue yo , por aca argenis//  maison de la parfumaire
					['Articulos.laboratorio_id' => 356], //Marce esto lo agregue yo , por aca argenis//  CHESTER ICE   , cannon puntana
					['Articulos.laboratorio_id' => 411],
					['Articulos.laboratorio_id' => 416],
					['Articulos.laboratorio_id' => 459],
					['Articulos.laboratorio_id' => 464],
					['Articulos.laboratorio_id' => 550],
					['Articulos.laboratorio_id' => 284],
					['Articulos.laboratorio_id' => 520],
					['Articulos.laboratorio_id' => 616],
					['Articulos.laboratorio_id' => 629],
					['Articulos.laboratorio_id' => 362],
					['Articulos.laboratorio_id' => 4],
					['Articulos.laboratorio_id' => 479],
					['Articulos.laboratorio_id' => 428],
					
					
					
				]
			]);

		if ($termsearch != "") {
			$articulosA->andWhere([

				'OR' => [
					['Articulos.descripcion_pag LIKE' => $termsearch],
					['Articulos.troquel LIKE' => $termsearch], ['Articulos.codigo_barras LIKE' => $termsearch]
				]
			]);
		}
		$articulosA->andWhere(['Articulos.eliminado' => 0]);
		$this->paginate = [
			'limit' => 20,
			'offset' => 0,
			'order' => ['Articulos.descripcion_pag' => 'asc']
		];


		if ($articulosA != null)
			$articulos = $this->paginate($articulosA);
		else
			$articulos = null;

		$this->set('articulos', $articulos);
		$fragancia = $this->request->session()->read('fragancia');

		$fraganciaspresentaciones = $this->FraganciasPresentaciones->find()->contain(['Articulos'])->where(['fragancia_id' => $fragancia->id]);
		$fraganciaspresentaciones->toArray();
		$marcas = $this->Fragancias->Marcas->find('list', ['keyField' => 'id', 'valueField' => 'nombre']);
		$generos = $this->Fragancias->Generos->find('list', ['keyField' => 'id', 'valueField' => 'nombre']);
		$marcas->toArray();
		$generos->toArray();
		$this->set(compact('fragancia', 'marcas', 'generos', 'fraganciaspresentaciones'));
		$this->set('_serialize', ['fragancia']);
	}

	/**
	 * Edit method
	 *
	 * @param string|null $id Fragancia id.
	 * @return void Redirects on successful edit, renders view otherwise.
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */
	public function edit_admin($id = null)
	{
		$this->viewBuilder()->layout('admin2');
		$fragancia = $this->Fragancias->get($id, [
			'contain' => []
		]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$fragancia = $this->Fragancias->patchEntity($fragancia, $this->request->data);

			$uploadData = '';
			if (!empty($this->request->data['file']['name'])) {
				$fileName = $this->request->data['file']['name'];

				$uploadPath = 'img/fragancias/';



				$uploadFile = $uploadPath . $fileName;
				$fragancia['imagen'] = $fileName;
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
						//$this->redirect($this->referer());
					}
				} else {
					$this->Flash->error(__('Unable to upload file, please try again.'), ['key' => 'changepass']);
					//$this->redirect($this->referer());
				}
			} else {
				$this->Flash->error(__('Please choose a file to upload.'), ['key' => 'changepass']);
				//$this->redirect($this->referer());
			}




			if ($this->Fragancias->save($fragancia)) {
				$this->Flash->success(__('The fragancia has been saved.'), ['key' => 'changepass']);
				return $this->redirect(['action' => 'index_admin']);
			} else {
				$this->Flash->error(__('The fragancia could not be saved. Please, try again.'), ['key' => 'changepass']);
			}
		}
		$this->request->session()->write('fragancia', $fragancia);
		$marcas = $this->Fragancias->Marcas->find('list', ['keyField' => 'id', 'valueField' => 'nombre'])->order(['nombre' => 'ASC']);
		$generos = $this->Fragancias->Generos->find('list', ['keyField' => 'id', 'valueField' => 'nombre']);
		$marcas->toArray();
		$generos->toArray();
		if ($fragancia != null) {
			$this->loadModel('FraganciasPresentaciones');
			$fraganciapresentacion = $this->FraganciasPresentaciones->find()
				->contain(['Articulos'])
				->join(
					[
						'table' => 'articulos',
						'alias' => 'a',
						'type' => 'inner',
						'conditions' => [

							'Articulo_id = a.id'

						]
					]

				)
				->where(['fragancia_id' => $fragancia['id']]);

			$this->set('fraganciaspresentaciones', $fraganciapresentacion->toArray());
			$this->set('_serialize', ['fraganciaspresentaciones']);
		} else
			$this->set('fraganciaspresentaciones', null);

		$this->set('titulo', 'Editar Fragancia');

		$this->set(compact('fragancia', 'marcas', 'generos'));
		$this->set('_serialize', ['fragancia']);
	}




	public function edit_admin_search()
	{

		$this->set('titulo', 'Fragancias Importadas');
		$this->viewBuilder()->layout('admin2');
		if ($this->request->is('post')) {


			$termsearch = '%' . $this->request->data['terminobuscar'] . '%';
			//$this->request->session()->write('termsearch',$termsearch);


		} else {
			$termsearch = $this->request->session()->read('termsearch');
		}
		$this->loadModel('Articulos');
		$articulosA = $this->Articulos->find()
			->hydrate(false)
			->andWhere([
				'OR' => [
					['Articulos.laboratorio_id' => 1],
					['Articulos.laboratorio_id' => 9],
					['Articulos.laboratorio_id' => 26],
					['Articulos.laboratorio_id' => 84], //Marce esto lo agregue yo , por aca argenis// benito  fernandez
					['Articulos.laboratorio_id' => 86], //Marce esto lo agregue yo , por aca argenis//  epica, craftmen
					['Articulos.laboratorio_id' => 88],
					['Articulos.laboratorio_id' => 131], //Marce esto lo agregue yo , por aca argenis// estetica francesa 
					['Articulos.laboratorio_id' => 186], //Marce esto lo agregue yo , por aca argenis//  giesso, loval 
					['Articulos.laboratorio_id' => 193], //Marce esto lo agregue yo , por aca argenis// boos, padoc
					['Articulos.laboratorio_id' => 218], //Marce esto lo agregue yo , por aca argenis// La roche posay
					['Articulos.laboratorio_id' => 333], //Marce esto lo agregue yo , por aca argenis//  maison de la parfumaire
					['Articulos.laboratorio_id' => 356], //Marce esto lo agregue yo , por aca argenis//  CHESTER ICE   , cannon puntana
					['Articulos.laboratorio_id' => 411],
					['Articulos.laboratorio_id' => 416],
					['Articulos.laboratorio_id' => 459],
					['Articulos.laboratorio_id' => 464],
					['Articulos.laboratorio_id' => 550],
					['Articulos.laboratorio_id' => 520],
					['Articulos.laboratorio_id' => 616],
					['Articulos.laboratorio_id' => 629],
					['Articulos.laboratorio_id' => 362],
					['Articulos.laboratorio_id' => 4],
					['Articulos.laboratorio_id' => 479],
					['Articulos.laboratorio_id' => 428]
				]
			]);

		if ($termsearch != "") {
			$articulosA->andWhere([

				'OR' => [
					['Articulos.descripcion_pag LIKE' => $termsearch],
					['Articulos.troquel LIKE' => $termsearch], ['Articulos.codigo_barras LIKE' => $termsearch]
				],
			]);
		}
		$articulosA->andWhere(['Articulos.eliminado' => 0]);
		$this->paginate = [
			'limit' => 20,
			'offset' => 0,
			'order' => ['Articulos.descripcion_pag' => 'asc']
		];


		if ($articulosA != null)
			$articulos = $this->paginate($articulosA);
		else
			$articulos = null;

		$this->set('articulos', $articulos);
		$fragancia = $this->request->session()->read('fragancia');

		$fraganciaspresentaciones = $this->FraganciasPresentaciones->find()->contain(['Articulos'])->where(['fragancia_id' => $fragancia->id]);
		$fraganciaspresentaciones->toArray();
		$marcas = $this->Fragancias->Marcas->find('list', ['keyField' => 'id', 'valueField' => 'nombre'])->where(['marcas_tipos_id IN (1,18)'])->order(['nombre' => 'ASC']);
		$generos = $this->Fragancias->Generos->find('list', ['keyField' => 'id', 'valueField' => 'nombre']);
		$marcas->toArray();
		$generos->toArray();
		$this->set(compact('fragancia', 'marcas', 'generos', 'fraganciaspresentaciones'));
		$this->set('_serialize', ['fragancia']);
	}

	/**
	 * Delete method
	 *
	 * @param string|null $id Fragancia id.
	 * @return \Cake\Network\Response|null Redirects to index.
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */
	public function delete_admin($id = null)
	{
		$this->viewBuilder()->layout('admin2');
		$id = $this->request->getData('id');
		$this->request->allowMethod(['post', 'get', 'delete', 'ajax']);
		$fragancia = $this->Fragancias->get($id);
		if (!empty($fragancia)) {


			if ($this->Fragancias->delete($fragancia)) {
				$responseData = ['success' => true, 'responseText' => "eliminado", 'status' => 200];

				$this->response->body(json_encode($responseData));


				return $this->response;

				// $this->Flash->success('Se elimino correctamente del carro.',['key' => 'changepass']);
			} else {
				$this->Flash->error('No se pudo eliminar, intente nuevamente', ['key' => 'changepass']);
			}
		}
	}
}
