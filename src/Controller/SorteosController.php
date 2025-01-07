<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Filesystem\File;
use Cake\Event\Event;
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
 *Sorteos Controller
 * *
 * @method \App\Model\Entity\Sorteo[] paginate($object = null, array $settings = []) */
class SorteosController extends AppController
{

    public function isAuthorized()
    {
        if (in_array($this->request->action, ['diaMadre', 'saveSessionPregunta', 'validarParticipacion', 'participando', 'participandoVista'])) {

            if ($this->request->session()->read('Auth.User.role') == 'admin') {
                return true;
            } else {
                if ($this->request->session()->read('Auth.User.role') == 'client') {
                    $tiene = $this->tienepermiso('sorteos', $this->request->action);
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

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $sorteos = $this->paginate($this->Sorteos);

        $this->set(compact('sorteos'));
        $this->set('_serialize', ['sorteos']);
    }

    /**
     * View method
     *
     * @param string|null $idSorteo id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $sorteo = $this->Sorteos->get($id, [
            'contain' => []
        ]);

        $this->set('sorteo', $sorteo);
        $this->set('_serialize', ['sorteo']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $sorteo = $this->Sorteos->newEntity();
        if ($this->request->is('post')) {
            $sorteo = $this->Sorteos->patchEntity($sorteo, $this->request->getData());
            if ($this->Sorteos->save($sorteo)) {
                $this->Flash->success(__('Thesorteo has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Thesorteo could not be saved. Please, try again.'));
        }
        $this->set(compact('sorteo'));
        $this->set('_serialize', ['sorteo']);
    }

    /**
     * Edit method
     *
     * @param string|null $idSorteo id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $sorteo = $this->Sorteos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $sorteo = $this->Sorteos->patchEntity($sorteo, $this->request->getData());
            if ($this->Sorteos->save($sorteo)) {
                $this->Flash->success(__('Thesorteo has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Thesorteo could not be saved. Please, try again.'));
        }
        $this->set(compact('sorteo'));
        $this->set('_serialize', ['sorteo']);
    }

    /**
     * Delete method
     *
     * @param string|null $idSorteo id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $sorteo = $this->Sorteos->get($id);
        if ($this->Sorteos->delete($sorteo)) {
            $this->Flash->success(__('Thesorteo has been deleted.'));
        } else {
            $this->Flash->error(__('Thesorteo could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function diaMadre()
    {
        $this->loadModel("RespuestasSorteoDiaMadre");
        $this->viewBuilder()->layout('store');
        $cliente_id = $this->request->getSession()->read('Auth.User.cliente_id');
        $respuestas = $this->RespuestasSorteoDiaMadre->find('all')
            ->where(['cliente_id' => $cliente_id])->order('sorteo_dia_madre_id', 'DESC')->toArray();
        // Validar que existan al menos 3 respuestas y que el campo participando sea 1 en las 3
        if (count($respuestas) >= 3) {
            // Obtener los tres primeros elementos
            $primerasTresRespuestas = array_slice($respuestas, 0, 3);

            // Validar si en los tres registros el campo 'participando' es igual a 1
            $todosParticipando = array_reduce($primerasTresRespuestas, function ($carry, $respuesta) {
                return $carry && ($respuesta->participando == 1);
            }, true);

            // Si todos están participando, redirigir a otra ruta
            if ($todosParticipando) {
                return $this->redirect(['controller' => 'Sorteos', 'action' => 'participandoVista']);
            }
        }

        $this->set('respuestas', $respuestas);
    }

    public function saveSessionPregunta()
    {
        //$this->loadModel("SorteoDiaMadre");
        $this->viewBuilder()->layout('vacio');
        $this->loadModel('RespuestasSorteoDiaMadre');

        if ($this->request->is('post')) {
            $respuesta = $this->request->getData('texto');
            $pregunta  = $this->request->getData('pregunta');
            $cliente_id = $this->request->getSession()->read('Auth.User.cliente_id');
            $respuestasorteodiamadre = $this->RespuestasSorteoDiaMadre->find('all')
                ->where([
                    'sorteo_dia_madre_id' => $pregunta,
                    'cliente_id' => $cliente_id,
                ])->first();

            if (!empty($respuestasorteodiamadre)) {
                $respuestasorteodiamadre->texto_generado = $respuesta;

                if ($this->RespuestasSorteoDiaMadre->save($respuestasorteodiamadre)) {
                    $responseData = ['success' => true, 'responseText' => "almacenado", 'status' => 200];
                    return $this->response->withType('application/json')
                        ->withStringBody(json_encode($responseData));
                }
            } else {
                $respuestasorteodiamadre = $this->RespuestasSorteoDiaMadre->newEntity();

                $respuestasorteodiamadre->cliente_id = $cliente_id;
                $respuestasorteodiamadre->sorteo_dia_madre_id = $pregunta;
                $respuestasorteodiamadre->texto_generado = $respuesta;

                if ($this->RespuestasSorteoDiaMadre->save($respuestasorteodiamadre)) {
                    $responseData = ['success' => true, 'responseText' => "almacenado", 'status' => 200];
                    return $this->response->withType('application/json')
                        ->withStringBody(json_encode($responseData));
                }
            }
        }
    }
    public function validarParticipacion()
    {
        $this->viewBuilder()->setLayout('vacio');
        $this->loadModel('RespuestasSorteoDiaMadre');

        if ($this->request->is('post')) {
            $cliente_id = $this->request->getSession()->read('Auth.User.cliente_id');
            $respuestasSorteoDiaMadre =  $this->RespuestasSorteoDiaMadre->find()
                ->where(['cliente_id' => $cliente_id]);
            $respuestasCount = $respuestasSorteoDiaMadre
                ->count();

            // Si tiene exactamente 3 registros, actualizar el campo 'participando'
            if ($respuestasCount === 3) {

                $responseData = ['success' => true, 'responseText' => "Puedes Participar", 'status' => 200, 'respuestas' => ''];
            } else {

                $responseData = ['success' => false, 'responseText' => "Faltan respuestas", 'status' => 200, 'respuestas' => $respuestasSorteoDiaMadre->toArray()];
            }
        }

        $this->response = $this->response->withType('application/json')
            ->withStringBody(json_encode($responseData));

        return $this->response;
    }

    public function participando()
    {
        // Usar layout vacío
        $this->viewBuilder()->setLayout('vacio');
        $this->loadModel('RespuestasSorteoDiaMadre');

        if ($this->request->is('post')) {

            $cliente_id = $this->request->getSession()->read('Auth.User.cliente_id');

            // Contar cuántos registros tiene el cliente en la tabl

            $this->RespuestasSorteoDiaMadre->updateAll(
                ['participando' => true],    // Campos a actualizar
                ['cliente_id' => $cliente_id]  // Condiciones
            );

            $responseData = ['success' => true, 'responseText' => "Participando", 'status' => 200];

            // Devolver la respuesta como JSON
            $this->response = $this->response->withType('application/json')
                ->withStringBody(json_encode($responseData));

            return $this->response;
        }
    }

    public function participandoVista()
    {

        $this->loadModel("RespuestasSorteoDiaMadre");
        $this->viewBuilder()->layout('ajax');
        $cliente_id = $this->request->getSession()->read('Auth.User.cliente_id');
        $respuestas = $this->RespuestasSorteoDiaMadre->find('all')
            ->where(['cliente_id' => $cliente_id])->order('sorteo_dia_madre_id', 'DESC')->toArray();

        // Verificar que haya al menos 3 respuestas
        if (count($respuestas) >= 3) {
            // Tomar las tres primeras respuestas
            $primerasTresRespuestas = array_slice($respuestas, 0, 3);

            // Verificar si al menos una respuesta tiene 'participando' igual a 0
            $algunoParticipandoCero = array_reduce($primerasTresRespuestas, function ($carry, $respuesta) {
                return $carry || ($respuesta->participando == 0);
            }, false);

            // Si al menos uno tiene participando == 0, redirigir
            if ($algunoParticipandoCero) {
                return $this->redirect(['controller' => 'Sorteos', 'action' => 'diaMadre']);
            }
        } else {
            // Si no hay suficientes respuestas (menos de 3), redirigir a 'diaMadre'
            return $this->redirect(['controller' => 'Sorteos', 'action' => 'diaMadre']);
        }
        $this->set('respuestas', $respuestas);
    }
}
