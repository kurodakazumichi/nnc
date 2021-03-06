<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\NotesTagsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\NotesTagsTable Test Case
 */
class NotesTagsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\NotesTagsTable
     */
    public $NotesTags;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.notes_tags',
        'app.notes',
        'app.categories',
        'app.articles',
        'app.books',
        'app.sections',
        'app.books_sections',
        'app.sections_notes',
        'app.modules',
        'app.assets',
        'app.modules_assets',
        'app.notes_modules',
        'app.tags'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('NotesTags') ? [] : ['className' => NotesTagsTable::class];
        $this->NotesTags = TableRegistry::get('NotesTags', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->NotesTags);

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
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
