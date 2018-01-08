<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ModulesAssetsFixture
 *
 */
class ModulesAssetsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'module_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'asset_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'order_no' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'modules_assets_asset_id_idx' => ['type' => 'index', 'columns' => ['asset_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['module_id', 'asset_id'], 'length' => []],
            'modules_assets_asset_id' => ['type' => 'foreign', 'columns' => ['asset_id'], 'references' => ['assets', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'modules_assets_module_id' => ['type' => 'foreign', 'columns' => ['module_id'], 'references' => ['modules', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8mb4_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'module_id' => 1,
            'asset_id' => 1,
            'order_no' => 1
        ],
    ];
}
