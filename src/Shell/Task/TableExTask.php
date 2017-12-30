<?php
namespace App\Shell\Task;

use Bake\Shell\Task\SimpleBakeTask;

class TableExTask extends SimpleBakeTask
{
    public $pathFragment = 'Model/Table/';

    public function name()
    {
        return 'TableEx';
    }

    public function fileName($name)
    {
        return $name . 'TableEx.php';
    }

    public function template()
    {
        return 'Model/table_ex';
    }

}
