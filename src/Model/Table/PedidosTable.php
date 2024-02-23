<?php
namespace App\Model\Table;

use App\Model\Entity\Pedido;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
// At the top of the file you want to log in.
use Cake\Log\Log;
use Cake\Database\Connection;

/**
 * Pedidos Model
 */
class PedidosTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('pedidos');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('Clientes', [
            'foreignKey' => 'cliente_id'
        ]);
    }

	public function confirmarpedido($cliente_id = null, $envio=null)
	{
		Log::debug($envio);
	
       // $result =$this->query('CALL ConfirmarPedido('.$cliente_id.',0,'.$envio.');');
        $result =$this->query('CALL buscararticuloid(40210221,$numero);');
		Log::debug($this->find('all'));
		/*
		
		if ($envio==0 or $envio==99)
		{
			
			Log::debug('Entro'.$envio);
			$result = $this->Pedidos->execute('CALL ConfirmarPedido('.$cliente_id.',0,'.$envio.');');
			//$this->query('call buscararticuloid(40002536,x);');
			//Log::debug($this->find('all'));
		}
		else
		{
			$result = $this->Pedidos->execute('CALL ConfirmarPedido('.$cliente_id.','.$envio.','.$envio.');');
			Log::debug($this->find('all'));
			// Anywhere that Log has been imported.
			//Log::debug('Entro 2'.$envio);
		}
		*/
	}

	
    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create')
            ->add('creado', 'valid', ['rule' => 'date'])
            ->allowEmpty('creado')
            ->allowEmpty('tipo_fact');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['cliente_id'], 'Clientes'));
        return $rules;
    }
}
