<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SectionsNotesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SectionsNotesTable Test Case
 */
class SectionsNotesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\SectionsNotesTable
     */
    public $SectionsNotes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.sections_notes',
        'app.sections',
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
        'app.books_sections'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('SectionsNotes') ? [] : ['className' => SectionsNotesTable::class];
        $this->SectionsNotes = TableRegistry::get('SectionsNotes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SectionsNotes);

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
