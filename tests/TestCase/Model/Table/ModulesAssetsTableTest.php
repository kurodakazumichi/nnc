<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ModulesAssetsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ModulesAssetsTable Test Case
 */
class ModulesAssetsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ModulesAssetsTable
     */
    public $ModulesAssets;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.modules_assets',
        'app.modules',
        'app.assets',
        'app.notes',
        'app.categories',
        'app.articles',
        'app.books',
        'app.sections',
        'app.books_sections',
        'app.sections_notes',
        'app.notes_modules',
        'app.tags',
        'app.notes_tags'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ModulesAssets') ? [] : ['className' => ModulesAssetsTable::class];
        $this->ModulesAssets = TableRegistry::get('ModulesAssets', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ModulesAssets);

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
