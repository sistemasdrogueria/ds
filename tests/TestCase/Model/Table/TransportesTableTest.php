<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TransportesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TransportesTable Test Case
 */
class TransportesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\TransportesTable
     */
    public $Transportes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.transportes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Transportes') ? [] : ['className' => TransportesTable::class];
        $this->Transportes = TableRegistry::get('Transportes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Transportes);

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
}
