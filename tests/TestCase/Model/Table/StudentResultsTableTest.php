<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\StudentResultsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\StudentResultsTable Test Case
 */
class StudentResultsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\StudentResultsTable
     */
    protected $StudentResults;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.StudentResults',
        'app.Users',
        'app.Forms',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('StudentResults') ? [] : ['className' => StudentResultsTable::class];
        $this->StudentResults = TableRegistry::getTableLocator()->get('StudentResults', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->StudentResults);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
