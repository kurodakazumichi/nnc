<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AssetsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AssetsTable Test Case
 */
class AssetsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AssetsTable
     */
    public $Assets;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.assets',
        'app.modules',
        'app.modules_assets',
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
        $config = TableRegistry::exists('Assets') ? [] : ['className' => AssetsTable::class];
        $this->Assets = TableRegistry::get('Assets', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Assets);

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
