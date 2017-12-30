<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BooksTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BooksTable Test Case
 */
class BooksTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\BooksTable
     */
    public $Books;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
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
        $config = TableRegistry::exists('Books') ? [] : ['className' => BooksTable::class];
        $this->Books = TableRegistry::get('Books', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Books);

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
