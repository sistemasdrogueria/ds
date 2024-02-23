<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LogsEstadisticasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LogsEstadisticasTable Test Case
 */
class LogsEstadisticasTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\LogsEstadisticasTable
     */
    public $LogsEstadisticas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.logs_estadisticas',
        'app.clientes',
        'app.provincias',
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
        'app.permisos',
        'app.perfiles',
        'app.usuarios',
        'app.permisos_perfiles'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('LogsEstadisticas') ? [] : ['className' => LogsEstadisticasTable::class];
        $this->LogsEstadisticas = TableRegistry::get('LogsEstadisticas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->LogsEstadisticas);

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
