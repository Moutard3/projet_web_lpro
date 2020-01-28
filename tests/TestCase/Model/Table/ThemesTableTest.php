<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ThemesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ThemesTable Test Case
 */
class ThemesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ThemesTable
     */
    protected $Themes;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Themes',
        'app.Questions',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Themes') ? [] : ['className' => ThemesTable::class];
        $this->Themes = TableRegistry::getTableLocator()->get('Themes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Themes);

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
}
