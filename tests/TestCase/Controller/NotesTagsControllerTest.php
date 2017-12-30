<?php
namespace App\Test\TestCase\Controller;

use App\Controller\NotesTagsController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\NotesTagsController Test Case
 */
class NotesTagsControllerTest extends IntegrationTestCase
{

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
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
