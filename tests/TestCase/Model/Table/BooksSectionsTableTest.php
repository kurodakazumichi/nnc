<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BooksSectionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BooksSectionsTable Test Case
 */
class BooksSectionsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\BooksSectionsTable
     */
    public $BooksSections;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.books_sections',
        'app.books',
        'app.categories',
        'app.articles',
        'app.notes',
        'app.modules',
        'app.assets',
        'app.modules_assets',
        'app.notes_modules',
        'app.tags',
        'app.notes_tags',
        'app.sections',
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
        $config = TableRegistry::exists('BooksSections') ? [] : ['className' => BooksSectionsTable::class];
        $this->BooksSections = TableRegistry::get('BooksSections', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->BooksSections);

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
