<?php
namespace App\Test\TestCase\Controller;

use App\Controller\CategoriesController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\CategoriesController Test Case
 */
class CategoriesControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.categories',
        'app.articles',
        'app.books',
        'app.notes',
        'app.modules',
        'app.notes_modules',
        'app.tags',
        'app.notes_tags',
        'app.sections',
        'app.sections_notes'
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
