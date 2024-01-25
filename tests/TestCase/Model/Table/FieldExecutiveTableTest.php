<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FieldExecutiveTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FieldExecutiveTable Test Case
 */
class FieldExecutiveTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FieldExecutiveTable
     */
    protected $FieldExecutive;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.FieldExecutive',
        'app.SurveyData',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('FieldExecutive') ? [] : ['className' => FieldExecutiveTable::class];
        $this->FieldExecutive = $this->getTableLocator()->get('FieldExecutive', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->FieldExecutive);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\FieldExecutiveTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\FieldExecutiveTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
