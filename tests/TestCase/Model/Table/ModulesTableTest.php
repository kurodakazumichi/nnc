<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ModulesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ModulesTable Test Case
 */
class ModulesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ModulesTable
     */
    public $Modules;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.modules',
        'app.assets',
        'app.modules_assets',
        'app.notes',
        'app.categories',
        'app.articles',
        'app.books',
        'app.notes_modules',
        'app.tags',
        'app.notes_tags',
        'app.sections',
        'app.books_sections',
        'app.sections_notes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Modules') ? [] : ['className' => ModulesTable::class];
        $this->Modules = TableRegistry::get('Modules', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Modules);

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
