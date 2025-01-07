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

/**
 *Outlets Controller
 * *
 * @method \App\Model\Entity\Outlets[] paginate($object = null, array $settings = []) */
class OutletsController extends AppController
{
  

    public function isAuthorized()
    {


        if (in_array($this->request->action, ['index', 'delete_admin', 'index_admin', 'add_admin', 'validateArticlesAdmin', 'edit_admin', 'view_admin', 'search', 'searchArticulos'])) {

            if ($this->request->getSession()->read('Auth.User.role') == 'admin') {
                return true;
            } else {
                if ($this->request->getSession()->read('Auth.User.role') == 'client') {
                    $tiene = $this->tienepermiso('outlets', $this->request->action);
                    if (!$tiene)
                        $this->Flash->error(__('No tiene permisos para ingresar'), ['key' => 'changepass']);
                    return $tiene;
                } else {
                    if ($this->request->getSession()->read('Auth.User.role') == 'provider') {
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
           
                return false;
            
        }
        return parent::isAuthorized($user);
    }
    public function categoriaylaboratorio()
    {
        if ($this->request->getSession()->read('Categorias') == null) {
            $this->loadModel('Categorias');
            $this->loadModel('Laboratorios');
            $categorias = $this->Categorias->find('list', ['keyField' => 'id', 'valueField' => 'nombre']);
            $laboratorios = $this->Laboratorios->find('list', ['keyField' => 'id', 'valueField' => 'nombre'])->where(['eliminado=0'])->order(['nombre' => 'ASC']);

            $this->request->getSession()->write('Categorias', $categorias->toArray());
            $this->request->getSession()->write('Laboratorios', $laboratorios->toArray());
        } else {

            $laboratorios = $this->request->getSession()->read('Laboratorios');
            $categorias = $this->request->getSession()->read('Categorias');
        }
        $this->set('categorias', $categorias);
        $this->set('laboratorios', $laboratorios);
    }

    public function searchArticulos()
    {
        $this->viewBuilder()->setLayout('vacio');
        $this->loadModel('Articulos');

        if ($this->request->getData('descripcion') != null) {
            $terminocompleto = explode(" ", $this->request->getData('descripcion'));
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

        $articulos = $this->Articulos->find('all')
            ->select(['Articulos.id', 'Articulos.descripcion_sist'])
            ->where([
                'Articulos.eliminado' => 0
            ])->andWhere([
                'OR' => [
                    ['Articulos.descripcion_pag LIKE' => $termsearch],
                    ['Articulos.troquel LIKE' => $termsearch],
                    ['Articulos.codigo_barras LIKE' => $termsearch],
                    ['Articulos.codigo_barras2 LIKE' => $termsearch],
                    ['Articulos.codigo_barras3 LIKE' => $termsearch]
                ],
            ])
            ->toArray();
        if (!empty($articulos)) {
            $responseData = ['success' => true, 'responseText' => "error", 'status' => 200, 'resultados' => [], 'articulos' => $articulos];
            $this->response->body(json_encode($responseData));
        } else {
            $responseData = ['success' => false, 'responseText' => "error", 'status' => 400, 'resultados' => [], 'articulos' => []];
            $this->response->body(json_encode($responseData));
        }



        return $this->response;
    }
    public function index_admin()
    {
        $this->viewBuilder()->setLayout('admin');
        $hoy = new \DateTime();
        $hoy->modify('+3 hours'); // Resta 3 horas a la fecha actual
        $hoy = $hoy->format('Y-m-d H:i:s');

        $outlets = $this->Outlets->find('all')
            ->contain('Articulos')
            ->select(['Outlets.id', 'Outlets.articulo_id', 'Outlets.condicion', 'Outlets.descuento_por_condicion', 'Outlets.fecha_inicio', 'Outlets.venc', 'Outlets.fecha_final', 'Articulos.descripcion_sist', 'Articulos.troquel', 'Articulos.imagen', 'Articulos.codigo_barras'])
            ->where([
                'Outlets.fecha_inicio <=' => $hoy,
                'Outlets.fecha_final  >=' => $hoy
            ])
            ->toArray();
        $this->set('outlets', $outlets);
    }

    public function validateArticlesAdmin()
    {
        $this->viewBuilder()->setLayout('vacio');
        $arrayExcel = $this->request->getData('arrayExcel');
        $arrayWithProduct = [];
        $arrayWithoutCoincidence = [];
        $datasave = [];

        foreach ($arrayExcel as $outlets):
            if ($outlets[0] != "Troquel") {

                $articulos = $this->searchProductoToTroquel($outlets[0]);
                $descripcion = $outlets[2];
                $vcto =  $outlets[1];
                if (!empty($articulos)) {

                    similar_text($descripcion, $articulos['descripcion_sist'], $percent);

                    if ($percent >= 70) {

                        $fechaInicio = $outlets[3];
                        $dateInicio = new \DateTime('1899-12-30');
                        $dateInicio->modify("+{$fechaInicio} days");
                        $formattedDateInicio = $dateInicio->format('Y-m-d'); 
                        $fechafinalizado = $outlets[4];

                        if (empty($fechafinalizado)) {
                            $fechaConvertida = \DateTime::createFromFormat('m/y', $outlets[1]);
                            if ($fechaConvertida) {
                                // Establece el primer día del mes
                                $fechaConvertida->setDate($fechaConvertida->format('Y'), $fechaConvertida->format('m'), 1);
                                $formattedDate = $fechaConvertida->format('Y-m-d'); // Fecha en el formato adecuado
                            }
                        } else {
                            // Suponiendo que $fechafinalizado contiene un número de días desde "1899-12-30"
                            $date = new \DateTime('1899-12-30');
                            $date->modify("+{$fechafinalizado} days");
                            $formattedDate = $date->format('Y-m-d'); // Fecha calculada en formato adecuado
                        }

                        // Empezar desde la fecha base para Excel


                        if (isset($outlets[9])) {
                            $condicion = $outlets[9];
                        } else {
                            $condicion = "";
                        }
                        if (isset($outlets[11])) {
                            $descuento_por_condicion = $outlets[11];
                        } else {
                            $descuento_por_condicion = "";
                        }

                        $activo = true;
                        if (isset($outlets[10])) {
                            $unidades_stock = $outlets[10];
                        } else {
                            $unidades_stock = "";
                        }
                        $outletArray = [
                            'articulo_id' => $articulos['id'],
                            'fecha_inicio' =>$formattedDateInicio,
                            'fecha_final' => $formattedDate,
                            'condicion' => $condicion,
                            'descuento_por_condicion' => $descuento_por_condicion,
                            'activo' => $activo,
                            'unidades_stock' => $unidades_stock,
                            'venc' => $vcto,
                            'descripcion_sist' => $articulos['descripcion_sist'],
                             'categoria_id' => $articulos['categoria_id']
                        ];
                        array_push($arrayWithProduct, $outletArray);
                    } else {
                        array_push($arrayWithoutCoincidence, $outlets);
                    }
                } else {
                    array_push($arrayWithoutCoincidence, $outlets);
                }
            }
        endforeach;


        if (!empty($arrayWithProduct)) {
            $datasave =  $this->addAllAdmin($arrayWithProduct);
            $responseData = ['success' => true, 'responseText' => "Almacenado", 'status' => 200, 'resultados' => $datasave, 'sinprocesar' => $arrayWithoutCoincidence];
            $this->response->body(json_encode($responseData));
        } else {
            $responseData = ['success' => false, 'responseText' => "error", 'status' => 400, 'resultados' => [], 'sinprocesar' => $arrayWithoutCoincidence];
            $this->response->body(json_encode($responseData));
        }

        return $this->response;
    }


    public function searchProductoToTroquel($troquel)
    {
        $this->loadModel('Articulos');
        $articulos = $this->Articulos->find('all')->select(['descripcion_sist', 'descripcion_pag', 'troquel', 'id','categoria_id'])->where(['troquel' => $troquel, 'eliminado' => 0])->first();
        if (empty($articulos)) {

            return "";
        }

        return $articulos;
    }


    public function addAllAdmin($articulos)
    {
        // Inicializa arrays para almacenar el resultado de cada operación
        $failedEntities = [];
        $successEntities = [];

        if ($this->request->is('post')) {
            // Itera sobre cada artículo en el array
            foreach ($articulos as $articulo) {

                // Verifica si ya existe un registro con el mismo articulo_id
                $existingOutlet = $this->Outlets->find()
                    ->where(['articulo_id' => $articulo['articulo_id']])
                    ->first();

                if ($existingOutlet) {
                    // Si existe, actualiza la entidad existente
                    $outlets = $this->Outlets->patchEntity($existingOutlet, $articulo);
                } else {
                    // Si no existe, crea una nueva entidad
                    $outlets = $this->Outlets->newEntity($articulo);
                }

                // Intenta guardar la entidad (ya sea nueva o actualizada)
                if ($this->Outlets->save($outlets)) {
                    $outlets->descripcion_sist = $articulo['descripcion_sist'];
                    $successEntities[] = $outlets;
                       if ($articulo['descuento_por_condicion'] > 0) {
                        $this->createOrUpdateDiscount($articulo['articulo_id'], $articulo['categoria_id'], $articulo['descuento_por_condicion'], $articulo['unidades_stock'], $articulo['fecha_inicio'], $articulo['fecha_final']);
                    }
                } else {
                    $failedEntities[] = $outlets;
                }
            }

            // Prepara los datos de respuesta con las entidades guardadas y fallidas
            $dataOutlet = ['noalmacenados' => $failedEntities, 'almacenados' => $successEntities];
            return $dataOutlet;
        }
    }

    public function createOrUpdateDiscount($articulo_id, $categoria_id, $descuentoNumber, $uni_max, $desde, $hasta)
    {
        $this->loadModel('Descuentos');
        $tipo_precio = $this->getTipoPrecio($categoria_id);
  if (empty($uni_max)) {
            $uni_max = 0;
        }
        $descuento = $this->Descuentos->find('all')->where(['articulo_id' => $articulo_id])->first();
       $tipoOferta = "VC";
        $tipoVenta = "D";        
        if (!empty($descuento)) {
            $descuento = $this->Descuentos->patchEntity($descuento, [
            'fecha_desde' => $desde,
            'fecha_hasta' => $hasta,
        'tipo_oferta' => $tipoOferta,
                'tipo_venta' => $tipoVenta,
            'tipo_precio' => $tipo_precio,
            'uni_min' => 1,
            'uni_max' => $uni_max,
            'uni_tope' => 0,
            'dto_patagonia' => $descuentoNumber,
            'dto_drogueria' => $descuentoNumber,
            'plazo' => "HABITUAL",
            'discrimina_iva' => NULL,
            'evento' => 0
        ]);
        } else {
           
            $articuloWithAll = [
                'fecha_desde' => $desde,
                'fecha_hasta' => $hasta,
                'articulo_id' => $articulo_id,
                'tipo_oferta' => $tipoOferta,
                'tipo_venta' => $tipoVenta,
                'tipo_precio' => $tipo_precio,
                'uni_min' => 1,
                'uni_max' => $uni_max,
                'uni_tope' => 0,
                'dto_patagonia' => $descuentoNumber,
                'dto_drogueria' => $descuentoNumber,
                'plazo' => "HABITUAL",
               'discrimina_iva' => NULL,
                'evento' => 0
            ];

            $descuento = $this->Descuentos->newEntity($articuloWithAll);
        }
       if (!$this->Descuentos->save($descuento)) {
        throw new \Exception("Error al guardar el descuento.");
    }
    }

    private function getTipoPrecio($categoria_id)
{
    if (in_array($categoria_id, [1, 6, 7])) {
        return "P";
    } elseif (in_array($categoria_id, [2, 3, 4, 5])) {
        return "F";
    }
    return "N/A";
}

    public function index()
    {  
        // dd($this->request->getSession()->read('Auth.User.cliente_id'));

        $this->request->getSession()->write('termsearch2', "");
        $this->request->getSession()->write('marcaid', 0);
        $this->loadModel('Marcas');
        $this->loadModel('Grupos');
        $this->viewBuilder()->layout('store');
        $this->paginate = ['limit' => 5];
        $this->categoriaylaboratorio();
        $this->clientecredito();
        $this->sumacarrito();

        $this->loadModel('Incorporations');
        $incorporationsA = $this->Incorporations->find('all');
        $incorporationsA->where(['habilitada' => 1, 'incorporations_tipos_id ' => 8])->limit([5])->order(['id' => 'DESC']);
        $incorporations = $this->paginate($incorporationsA);
        $this->set('incorporations', $incorporations);

        $marcas2 = $this->Marcas->find('all')->where(['marcas_tipos_id' => 5])->order(['nombre' => 'ASC']);
        $marcas2->toArray();
        $grupos2 = $this->Grupos->find('all')->where(['grupos_tipos_id' => 5])->order(['nombre' => 'ASC']);
        $grupos2->toArray();

        $this->loadModel('Publications');

        $codigo_postal = $this->request->getSession()->read('Auth.User.codigo_postal');
        $publication_sin = $this->Publications->find('all')->where(['fecha_hasta >=CURRENT_DATE()', 'habilitada' => '1', 'ubicacion' => '17', 'localidad' => 0])->order(['orden' => 'ASC'])->limit(2);
        $publication_con = $this->Publications->find('all')->where(['fecha_hasta >=CURRENT_DATE()', 'habilitada' => '1', 'ubicacion' => '17', 'localidad like ' => '%' . $codigo_postal . '%'])->unionAll($publication_sin)->order(['orden' => 'ASC'])->limit(4);

        $this->loadModel('Articulos');

        $articulosA = $this->Articulos->find()
            ->contain([
                'Descuentos'
                => [

                    'queryBuilder' => function ($q) {
                        return $q->where(['tipo_oferta' => 'VC', 'tipo_venta' => 'D']); // Full conditions for filtering
                    }
                ],
                'Carritos' => [

                    'queryBuilder' => function ($q) {
                        return $q->where(['cliente_id' => $this->request->getSession()->read('Auth.User.cliente_id')]); // Full conditions for filtering
                    }
                ],
                'Marcas',
                'SubCategorias'
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

            $articulos = $this->paginate($articulosA->order(['Articulos.fv' => 'ASC']));

            $outlets =  $this->getArticlesAreInOutlet();
            $articulos = array_merge($outlets, $articulosA->toArray());

            // Combina y agrupa por `id`
            $mergedArticulos = (new Collection($articulos))
                ->indexBy('id') // Agrupa por `id` eliminando duplicados
                ->sortBy('fv_cerca')
                ->toArray();


            $articulos = $mergedArticulos;
        } else {
            $articulos = null;

            $outlets =  $this->getArticlesAreInOutlet();
            $articulos = $outlets;
            //    $articulos = (new Collection($outlets))->indexBy('id')->toArray(); 
        }
        $marcasOutlet = $this->getMarcas($articulos);
        $marcas = "";
        $subcategorias = $this->getSubCategorias($articulos);
        $articulosConDescuento = $this->CalculatePrices($articulos);
        $articulos = new Collection($articulosConDescuento);


        $this->set(compact('articulos'));
        $this->set('sursale2', $publication_con->first());
        $this->set('sursale', $publication_con->skip(1)->first());
        $this->set(compact('marcas'));
        $this->set(compact('marcasOutlet'));
        $this->set('categoriasOutlet', $subcategorias);
        $this->set(compact('grupos2'));

        $publications = $this->Publications->find('all')->where(['fecha_hasta >=CURRENT_DATE()', 'habilitada' => '1', 'ubicacion' => '8'])->order(['id' => 'DESC'])->all();
        $this->set('publications_nutricion', $publications->toArray());

        $this->request->getSession()->write('publications_nutricion', $publications->toArray());
        $publicationzocalon = $this->Publications->find('all')->where(['fecha_hasta >=CURRENT_DATE()', 'habilitada' => '1', 'ubicacion' => '22'])->order(['orden' => 'ASC'])->all();
        $this->set('banner_slider_n', $publicationzocalon->toArray());
        $this->request->getSession()->write('banner_slider_n', $publicationzocalon->toArray());
    }

    public function getArticlesAreInOutlet()
    {

        $hoy = new \DateTime();
        $hoy->modify('-3 hours'); // Resta 3 horas a la fecha actual
        $hoy = $hoy->format('Y-m-d H:i:s');

        $fecha = Time::now();
        $fecha = $fecha->i18nFormat('yyyy-MM-dd');



        $articulosA = $this->Outlets->find()
            ->contain([
                'Articulos' => [
                    'queryBuilder' => function ($l) {
                        return $l->where(['eliminado' => 0, 'stock <> "F"', 'stock <>"D"']);
                    }
                ],
                'Articulos.Descuentos' => [
                    'queryBuilder' => function ($q) {
                        return $q->where(['tipo_oferta <> "VC"']); // Full conditions for filtering
                    }
                    //'tipo_oferta in ("RV","RR","OR","TD","RL","HS","FR","TH","TD")',

                ],
                'Articulos.Carritos' => [

                    'queryBuilder' => function ($q) {
                        return $q->where(['cliente_id' => $this->request->getSession()->read('Auth.User.cliente_id')]); // Full conditions for filtering
                    }
                ],
                'Articulos.Marcas',
                'Articulos.SubCategorias'
            ])
            ->hydrate(false)
            ->join([
                [
                    'table' => 'descuentos',
                    'alias' => 'd',
                    'type' => 'left',
                    'conditions' => [
                        'd.articulo_id = Outlets.articulo_id',
                        'd.tipo_venta' => 'D',
                        'd.fecha_hasta >=' => $fecha,
                        'd.tipo_oferta IN' => ["RV", "RR", "OR", "TD", "RL", "HS", "FR", "TH", "PS", "FP"]
                    ]
                ],

            ])->toArray();
        $articulosArray = [];
        foreach ($articulosA as $item) {
            if (isset($item['articulo'])) {
                $articulo = $item['articulo'];
                $articulo['outlet_venc'] = $item['venc'] ?? null; // Agrega el campo 'venc' si está disponible
                $articulo['descuento_por_condicion'] = $item['descuento_por_condicion'] ?? null;
                $articulo['unidades_stock'] = $item['unidades_stock'] ?? null;
                $articulo['outlet_condicion'] = $item['condicion'] ?? null;
                $articulosArray[] = $articulo;
            }
        }
        return  $articulosArray;
    }



    public function CalculatePrices($articulos)
    {

        $descuento_pf = $this->request->session()->read('Auth.User.pf_dcto');
        $condicion = $this->request->session()->read('Auth.User.condicion');
        $coef = $this->request->session()->read('Auth.User.coef');
        $condiciongeneral = 100 * (1 - ($descuento_pf * (1 - $condicion / 100)));
        $condiciongeneralmsd = 100 * (1 - ($descuento_pf));
        $condiciongeneralcf = 100 * (1 - ($descuento_pf * 1.0248 * (1 - $condicion / 100)));
        $condiciongeneralaz = 100 * (1 - ($descuento_pf * 0.892));
        $coef_pyf = $this->request->session()->read('Auth.User.coef_pyf');

        $resultadosCalculados = [];


        foreach ($articulos as $articulo) {
            $precio_con_dcto = 0;
            if (($articulo['categoria_id'] != 5) && ($articulo['categoria_id'] != 4)  && ($articulo['categoria_id'] != 3) && ($articulo['categoria_id'] != 2)) {
                if ($articulo['categoria_id'] === 1)    $coef2 = 1;
                else $coef2 = $coef;
                //if ($articulo['laboratorio_id']==15) $coef2 = 0.892; 

                if ($articulo['descuentos'] != null) {
                    if ($articulo['descuentos'][0]['tipo_venta'] == 'D' && $articulo['stock'] != 'F') {
                        //if ($articulo['descuentos'][0]['dto_drogueria'] == $articulo['carritos'][0]['descuento'])
                        $descuentooferta = $articulo['descuentos'][0]['dto_drogueria'];
                        /*else
		if (count($articulo['descuentos'])>1)
			$descuentooferta = $articulo['descuentos'][1]['dto_drogueria'];
			else
			$descuentooferta= $articulo['carritos'][0]['descuento'];
		*/
                        if ($articulo['descuentos'][0]['tipo_precio'] == 'P') {
                            if ($articulo['descuentos'][0]['tipo_oferta'] == 'TH')
                                $descuentooferta = $articulo['descuentos'][0]['dto_drogueria'] + $condiciongeneral;


                            $precio  = $articulo['precio_publico'];
                            $precio -= $precio * $descuentooferta / 100;
                        }
                        if ($articulo['descuentos'][0]['tipo_precio'] == 'F') {
                            $precio = $articulo['precio_publico'];
                            if ($articulo['iva'] == 1)
                                if ($this->request->session()->read('Auth.User.codigo_postal') != 9410 && $this->request->session()->read('Auth.User.codigo_postal') != 9420) {
                                    $precio = $precio / (1.21);
                                }
                            $precio  = $precio * $descuento_pf;
                            if ($articulo['msd'] != 1)
                                $precio -= $precio * $condicion / 100;
                            $precio -= $precio * $descuentooferta / 100;
                        }
                        $precio_con_dcto  = $precio;
                    } else {
                        $precio = $articulo['precio_publico'];
                        if ($articulo['iva'] == 1)
                            if ($this->request->session()->read('Auth.User.codigo_postal') != 9410 && $this->request->session()->read('Auth.User.codigo_postal') != 9420) {
                                $precio = $precio / (1.21);
                            }
                        $precio = $precio * $descuento_pf * $coef2;
                        if ($articulo['msd'] != 1) {
                            $precio -= $precio * $condicion / 100;
                        }


                        if ($articulo['mcdp'] == 1) {
                            $precio = $articulo['precio_publico'];
                            $precio -= $precio * ($condiciongeneral - 1) / 100;
                        }
                        $precio_con_dcto = $precio;
                    }
                } else {
                    $precio = $articulo['precio_publico'];
                    if ($articulo['iva'] == 1)
                        if ($this->request->session()->read('Auth.User.codigo_postal') != 9410 && $this->request->session()->read('Auth.User.codigo_postal') != 9420) {
                            $precio = $precio / (1.21);
                        }
                    if ($articulo['msd'] != 1) {
                        $precio = $precio * $descuento_pf * $coef2;
                        if ($condicion > 0) $precio -= $precio * $condicion / 100;
                        $precio_con_dcto = $precio;
                    } else {
                        $precio_con_dcto = $precio * $descuento_pf * $coef2;
                    }
                    if ($articulo['mcdp'] == 1) {
                        $precio = $articulo['precio_publico'];
                        $precio -= $precio * ($condiciongeneral - 1) / 100;
                        $precio_con_dcto = $precio;
                    }
                }

                if ($precio_con_dcto != 0 && $articulo['cadena_frio'] == 1 && $articulo['subcategoria_id'] != 10)
                    $precio_con_dcto = $precio_con_dcto * 1.0248;
            } else {
                if ($articulo['descuentos'] != null) {
                    if ($articulo['descuentos'][0]['tipo_venta'] == 'D' && $articulo['stock'] != 'F') {

                        $descuentooferta = $articulo['descuentos'][0]['dto_drogueria'];


                        $precio = $articulo['precio_publico'];
                        if ($articulo['descuentos'][0]['tipo_precio'] == 'P') {
                            if ($articulo['descuentos'][0]['tipo_oferta'] == 'TH')

                                $descuentooferta = $articulo['descuentos'][0]['dto_drogueria'] + $condiciongeneral;

                            $precio -= $precio * $descuentooferta / 100;
                        }
                        if ($articulo['descuentos'][0]['tipo_precio'] == 'F') {
                            if ($articulo['id'] > 27338 && $articulo['id'] < 27345)
                                $descuento_pf = 0.807;
                            $precio = $precio * $descuento_pf;
                            //$precio -= $precio*$condicion/100;
                            $precio -= $precio * $descuentooferta / 100;
                        }
                        $precio_con_dcto = $precio;
                        if ($this->request->session()->read('Auth.User.codigo_postal') == 9410 || $this->request->session()->read('Auth.User.codigo_postal') == 9420) {
                            $precio_con_dcto = $precio_con_dcto * $articulo['tf_coef'];
                        }
                    } else {
                        if ($articulo['id'] > 27338 && $articulo['id'] < 27345)
                            $descuento_pf = 0.807;

                        $precio = $articulo['precio_publico'] * $descuento_pf;
                        if ($coef != 1)    $precio = $precio * $coef;
                        $precio_con_dcto = $precio;
                        if ($this->request->session()->read('Auth.User.codigo_postal') == 9410 || $this->request->session()->read('Auth.User.codigo_postal') == 9420) {
                            $precio_con_dcto = $precio_con_dcto * $articulo['tf_coef'];
                        }
                    }
                } else {
                    if ($articulo['id'] > 27338 && $articulo['id'] < 27345)
                        $descuento_pf = 0.807;

                    $precio = $articulo['precio_publico'] * $descuento_pf;
                    if ($coef != 1)    $precio = $precio * $coef;
                    $precio_con_dcto = $precio;
                    if ($this->request->session()->read('Auth.User.codigo_postal') == 9410 || $this->request->session()->read('Auth.User.codigo_postal') == 9420) {
                        $precio_con_dcto = $precio_con_dcto * $articulo['tf_coef'];
                    }
                }
            }

            // CALCULAR PRECIO PUBLICO
            $pp = "";
            if (($articulo['categoria_id'] != 5) && ($articulo['categoria_id'] != 4)  && ($articulo['categoria_id'] != 3) && ($articulo['categoria_id'] != 2)) {
                if ($articulo['iva'] == 0)
                    $pp = number_format($articulo['precio_publico'], 2, ',', '.');
            } else {

                if ($articulo['id'] > 27338 && $articulo['id'] < 27345)
                    $descuento_pf = 0.807;

                $precio = $articulo['precio_publico'] * $descuento_pf;
                if ($coef != 1)    $precio = $precio * $coef;
                $precio_con_dcto_pp = $precio * 1.21 * $coef_pyf;
                if ($this->request->session()->read('Auth.User.codigo_postal') == 9410 || $this->request->session()->read('Auth.User.codigo_postal') == 9420) {
                    $precio_con_dcto_pp = $precio_con_dcto_pp * $articulo['tf_coef'];
                }
                $pp = number_format($precio_con_dcto_pp, 2, ',', '.');
            }


            //CALCULAR PRECIO 

            $precio_farmacia = 0;
            if ($articulo['categoria_id'] != 1 && $articulo['categoria_id'] != 6 && $articulo['categoria_id'] != 7)
                $precio_farmacia = $articulo['precio_publico'] * $descuento_pf;
            else {
                $precio = $articulo['precio_publico'];
                $precio = $precio * $descuento_pf;
                if ($condicion > 0)
                    $precio -= $precio * $condicion / 100;
                $precio_farmacia = $precio;
            }

            $articulo['p_tach'] = number_format($precio_farmacia, 2, ',', '.');
            $articulo['p_p'] = $pp;

            if ($precio_con_dcto != 0)
                $articulo['pc_dto'] = number_format($precio_con_dcto, 2, ',', '.');
            $resultadosCalculados[] = $articulo;
        }
        return $resultadosCalculados;
    }



    public function getMarcas($articulos)
    {

        $artcolec = new Collection($articulos);

        //$marcas_id = $artcolec->extract('marca_id');
        $marcas = $artcolec
            ->map(function ($articulo) {
                return $articulo['marca'] ?? null; // Obtener la información de la marca
            })
            ->filter() // Eliminar valores nulos (si algún artículo no tiene marca)
            ->groupBy('id') // Agrupar por el ID de la marca
            ->map(function ($grupo) {
                $marca = $grupo[0]; // Tomar cualquier elemento del grupo
                return [
                    'id' => $marca['id'],
                    'nombre' => $marca['nombre'],
                ];
            })
            ->toArray();

        return $marcas;
    }


    public function getSubCategorias($articulos)
    {
        $artcolec = new Collection($articulos);

        //$marcas_id = $artcolec->extract('marca_id');
        $categorias = $artcolec
            ->map(function ($articulo) {
                return $articulo['Subcategorias'] ?? null; // Obtener la información de la marca
            })
            ->filter() // Eliminar valores nulos (si algún artículo no tiene marca)
            ->groupBy('id') // Agrupar por el ID de la marca
            ->map(function ($grupo) {
                $categoria = $grupo[0]; // Tomar cualquier elemento del grupo
                return [
                    'id' => $categoria['id'],
                    'nombre' => $categoria['nombre'],
                ];
            })
            ->toArray();

        return $categorias;
    }
    public function sumacarrito()
    {
        $this->loadModel('Carritos');
        $carritocon = $this->Carritos->find('all')->contain(['Articulos'])
            ->where(['Carritos.cliente_id' => $this->request->getSession()->read('Auth.User.cliente_id')])
            ->order(['Carritos.id' => 'DESC']);
        $this->set('carritos', $carritocon->toArray());
        $descuento_pf = $this->request->getSession()->read('Auth.User.pf_dcto');
        $totalcarrito = 0;
        $totalitems = 0;
        $totalunidades = 0;
        foreach ($carritocon as $carrito):
            $totalitems += 1;
            if ($carrito['tipo_precio'] == "P")
                $totalcarrito = $totalcarrito + $carrito['cantidad'] * $carrito['precio_publico'];
            else
                $totalcarrito = $totalcarrito + $carrito['cantidad'] * round(h($carrito['precio_publico']) * $descuento_pf, 3);
            $totalunidades = $totalunidades + $carrito['cantidad'];
        endforeach;
        $this->set('totalitems', $totalitems);
        $this->set('totalcarrito', $totalcarrito);
        $this->set('totalunidades', $totalunidades);
        $this->set('carritos', $carritocon->toArray());
        $this->request->getSession()->write('totalitems', $totalitems);
        $this->request->getSession()->write('totalcarrito', $totalcarrito);
        $this->request->getSession()->write('totalunidades', $totalunidades);
        return $carritocon;
    }

    /**
     * View method
     *
     * @param string|null $idOutlet id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $outlets = $this->Outlets->get($id, [
            'contain' => []
        ]);

        $this->set('outlets', $outlets);
        $this->set('_serialize', ['outlets']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */

    public function clientecredito()
    {
        $this->loadModel('ClientesCreditos');
        $clientecreditos = $this->ClientesCreditos->find('all')
            ->where(['cliente_id' => $this->request->getSession()->read('Auth.User.cliente_id')]);
        $clientecredito = $clientecreditos->first();
        $this->set('creditodisponible', $clientecredito['credito_maximo'] - $clientecredito['credito_consumo']);
        if ($clientecredito['compra_minima'] != null)
            $this->request->getSession()->write('compra_minima', $clientecredito['compra_minima']);
        else
            $this->request->getSession()->write('compra_minima', 500);
    }

    public function add_admin()
    {
        $this->viewBuilder()->setLayout('admin');
        $outlets = $this->Outlets->newEntity();
        if ($this->request->is('post')) {
            $outlets = $this->Outlets->patchEntity($outlets, $this->request->getData());
            if ($this->Outlets->save($outlets)) {
                $this->Flash->success(__('Theoutlet has been saved.'));

                return $this->redirect(['controller' => 'Outlets', 'action' => 'index_admin']);
            }
            $this->Flash->error(__('Theoutlet could not be saved. Please, try again.'));
        }
        $this->set(compact('outlets'));
        $this->set('_serialize', ['outlets']);
    }

    /**
     * Edit method
     *
     * @param string|null $idOutlet id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */


    /**
     * Delete method
     *
     * @param string|null $idOutlet id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete_admin($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $outlets = $this->Outlets->get($id);
        if ($this->Outlets->delete($outlets)) {
            $this->Flash->success(__('Theoutlet has been deleted.'));
        } else {
            $this->Flash->error(__('Theoutlet could not be deleted. Please, try again.'));
        }

        return $this->redirect(['controller' => 'Outlets', 'action' => 'index_admin']);
    }


    /**
     * View method
     *
     * @param string|null $idOutlet id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */

    /**
     * Edit method
     *
     * @param string|null $idOutlet id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit_admin($id = null)
    {

        $this->viewBuilder()->setLayout("admin");
        $outlets = $this->Outlets->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $outlets = $this->Outlets->patchEntity($outlets, $this->request->getData());
            if ($this->Outlets->save($outlets)) {
                $this->Flash->success(__('Theoutlet has been saved.'));

                return $this->redirect(['controller' => 'Outlets', 'action' => 'index_admin']);
            }
            $this->Flash->error(__('Theoutlet could not be saved. Please, try again.'));
        }
        $articulos = $this->Outlets->Articulos->find('list', ['limit' => 200]);
        $this->set(compact('outlets', 'articulos'));
        $this->set('_serialize', ['outlets']);
    }

    /**
     * Delete method
     *
     * @param string|null $idOutlet id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
}
