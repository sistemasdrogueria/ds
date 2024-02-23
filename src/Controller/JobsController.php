<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;

/**
 * Jobs Controller
 *
 * @property \App\Model\Table\JobsTable $Jobs
 *
 * @method \App\Model\Entity\Job[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class JobsController extends AppController
{
	 public function beforeFilter(Event $event)
    {
       // allow all action
        $this->Auth->allow(['index','view']);
    }
	
	public function isAuthorized()
    {

					if (in_array($this->request->action, ['index_admin','view_admin','edit_admin','delete_admin','add_admin'])) {
       
					if($this->request->session()->read('Auth.User.role')=='adminR') 	
							return true;			
					else
						$this->Flash->error('No tiene permisos para ingresar - No Direct',['key' => 'changepass']);    
						
					$this->redirect(['controller' => 'Pages', 'action' => 'home']);  		
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
		$this->viewBuilder()->layout('job');
        $this->paginate = [
            'contain' => ['Puestos','Sectors']
        ];
        $jobs = $this->paginate($this->Jobs->find('all')
								->where(['activo'=>1])->order(['fecha' => 'DESC']));

        $this->set(compact('jobs'));
    }

	public function index_admin()
    {
		$this->viewBuilder()->layout('admin3');
        $this->paginate = [
            'contain' => ['Puestos','Sectors'],
            'limit' => 5000, 'maxLimit' => 5000,
        ];
		  if ($this->request->is('post')) {
			if ($this->request->data['fechadesde']!= null)
				$fechadesde = $this->request->data['fechadesde'];			
			else
				$fechadesde=0;
			
			if ($this->request->data['fechahasta']!= null)
				$fechahasta = $this->request->data['fechahasta'];				
			else
				$fechahasta =0;
			
			if ($this->request->data['termino']!= null)
				$termino = '%'.$this->request->data['termino'].'%';
			else
				$termino ="";
				
			if ($this->request->data['sector_id']!= null)
				$sector_id = $this->request->data['sector_id'];
			else
				$sector_id =0;
				
		if ($fechahasta!=0)
		{
			$fechahasta2 = Time::createFromFormat('d/m/Y',$fechahasta,'America/Argentina/Buenos_Aires');
			$fechahasta2->modify('+1 days');
			$fechahasta2->i18nFormat('yyyy-MM-dd');
		}
		else
		{
			$fechahasta2 = Time::now();
			$fechahasta2-> modify('+1 days');
			$fechahasta2-> i18nFormat('yyyy-MM-dd');
		}
		if ($fechadesde!=0)
		{
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
	
				
			$jobs = $this->Jobs->find('all');
			if ($sector_id!=0)
				$jobs->where(['sector_id'=>$sector_id]);
			if ($termino !="")
				$jobs->where(['titulo LIKE'=>$termino]); 
			if (($fechadesde !=0) || ($fechahasta !=0))
				$jobs->where(["fecha BETWEEN '".$fechadesde2->i18nFormat('yyyy-MM-dd')."' AND '".$fechahasta2->i18nFormat('yyyy-MM-dd')."'"]);
				
			$jobs->order(['fecha' => 'DESC']);
					
		  }
		  else
			  $jobs = $this->Jobs->find('all')->order(['fecha' => 'DESC']);
		
		$sectors =  $this->Jobs->Sectors->find('list', ['keyField' => 'id','valueField' => 'nombre']);
		$sectors=$sectors ->toArray();
        
        
		$jobs = $this->paginate($jobs);
		$this->set(compact('jobs', 'sectors'));
			$this->set('titulo','Listado de Vacantes');
    }
    /**
     * View method
     *
     * @param string|null $id Job id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		$this->viewBuilder()->layout('job');
        $job = $this->Jobs->get($id, [
            'contain' => ['Puestos','Sectors']
        ]);

        $this->set('job', $job);
    }

	public function view_admin($id = null)
    {
		
		$this->viewBuilder()->layout('admin3');
        $job = $this->Jobs->get($id, [
            'contain' => ['Puestos','Sectors']
        ]);
		$sector = [''];

        $this->set('job', $job);
		$this->set('titulo','Puesto Vacantes');
    }
	
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add_admin()
    {
		$this->viewBuilder()->layout('admin3');
        $job = $this->Jobs->newEntity();
        if ($this->request->is('post')) {
            $job = $this->Jobs->patchEntity($job, $this->request->getData());
			
		
			$fecha = Time::createFromFormat('d/m/Y',$this->request->data['fecha'],'America/Argentina/Buenos_Aires');
			$fecha->i18nFormat('yyyy-MM-dd');
			
			$job['fecha'] = $fecha;
			
			
            if ($this->Jobs->save($job)) {
                $this->Flash->success(__('The job has been saved.'));

                return $this->redirect(['action' => 'index_admin']);
            }
            $this->Flash->error(__('The job could not be saved. Please, try again.'),['key' => 'changepass']);
        }
        $puestos =  $this->Jobs->Puestos->find('list', ['keyField' => 'id','valueField' => 'nombre']);
		$puestos=$puestos->toArray();
		$sectors =  $this->Jobs->Sectors->find('list', ['keyField' => 'id','valueField' => 'nombre']);
		$sectors=$sectors->toArray();
	
        $this->set(compact('job', 'puestos','sectors'));
		$this->set('titulo','Carga de Vacante');
    }

    /**
     * Edit method
     *
     * @param string|null $id Job id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit_admin($id = null)
    {
        $this->loadModel('Puestos');
		$this->viewBuilder()->layout('admin3');
        $job = $this->Jobs->get($id, [
            'contain' => []
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $job = $this->Jobs->patchEntity($job, $this->request->getData());

            
			$fecha = Time::createFromFormat('d/m/Y',$this->request->data['fecha'],'America/Argentina/Buenos_Aires');
			$fecha->i18nFormat('yyyy-MM-dd');
			
			$job['fecha'] = $fecha;
            
            if ($this->Jobs->save($job)) {
                $this->Flash->success(__('The job has been saved.'),['key' => 'changepass']);

                return $this->redirect(['action' => 'index_admin']);
            }
            $this->Flash->error(__('The job could not be saved. Please, try again.'),['key' => 'changepass']);
        }
             $puestos = $this->Jobs->Puestos->find('list', ['limit' => 200]);
            $puesto = $this->Puestos->find('list',['keyField' => rtrim('id'), 'valueField' => rtrim('nombre')], ['limit' => 200]);
        
            $puestos =  $this->Jobs->Puestos->find('list', ['keyField' => 'id','valueField' => 'nombre']);
            $puestos=$puestos->toArray();
            $sectors =  $this->Jobs->Sectors->find('list', ['keyField' => 'id','valueField' => 'nombre']);
            $sectors=$sectors->toArray();
        
            $this->set(compact('job', 'puestos','sectors'));
            
        
            $this->set(compact('job', 'puestos','sectors'));
        
		$this->set('titulo','Edit de Vacante');
    }

    /**
     * Delete method
     *
     * @param string|null $id Job id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete_admin($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $job = $this->Jobs->get($id);
        if ($this->Jobs->delete($job)) {
            $this->Flash->success(__('The job has been deleted.'),['key' => 'changepass']);
        } else {
            $this->Flash->error(__('The job could not be deleted. Please, try again.'),['key' => 'changepass']);
        }

        return $this->redirect(['action' => 'index_admin']);
    }
}
