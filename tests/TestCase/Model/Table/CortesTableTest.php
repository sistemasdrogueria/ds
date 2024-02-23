<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CortesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CortesTable Test Case
 */
class CortesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CortesTable
     */
    public $Cortes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.cortes',
        'app.provincias',
        'app.clientes',
        'app.localidads',
        'app.proveedors',
        'app.ofertas',
        'app.articulos',
        'app.categorias',
        'app.laboratorios',
        'app.carritos_items',
        'app.carritos',
        'app.combos',
        'app.pedidos_items',
        'app.pedidos',
        'app.descuentos',
        'app.reclamos_items',
        'app.reclamos',
        'app.reclamos_tipos',
        'app.reclamos_estados',
        'app.carritos_temps',
        'app.preventas',
        'app.carritos_preventas',
        'app.pedidos_preventas_items',
        'app.pedidos_preventas',
        'app.ofertas_tipos',
        'app.sucursals',
        'app.facturas_pedidos',
        'app.clientes_creditos',
        'app.logs_accesos',
        'app.users',
        'app.salida_ns',
        'app.salida_ds'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Cortes') ? [] : ['className' => CortesTable::class];
        $this->Cortes = TableRegistry::get('Cortes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Cortes);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
