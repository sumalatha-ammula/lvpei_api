<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SurveyDataTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SurveyDataTable Test Case
 */
class SurveyDataTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SurveyDataTable
     */
    protected $SurveyData;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.SurveyData',
        'app.SurveyQuestions',
        'app.Partcipants',
        'app.Survey',
        'app.FieldExecutive',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('SurveyData') ? [] : ['className' => SurveyDataTable::class];
        $this->SurveyData = $this->getTableLocator()->get('SurveyData', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->SurveyData);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\SurveyDataTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\SurveyDataTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
