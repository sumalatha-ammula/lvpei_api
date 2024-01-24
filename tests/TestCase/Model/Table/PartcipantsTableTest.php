<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PartcipantsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PartcipantsTable Test Case
 */
class PartcipantsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PartcipantsTable
     */
    protected $Partcipants;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Partcipants',
        'app.Survey',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Partcipants') ? [] : ['className' => PartcipantsTable::class];
        $this->Partcipants = $this->getTableLocator()->get('Partcipants', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Partcipants);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\PartcipantsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
