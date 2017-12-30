<?php
namespace App\Shell\Task;

use Bake\Shell\Task\SimpleBakeTask;

class EntityExTask extends SimpleBakeTask
{
    public $pathFragment = 'Model/Entity/';

    public function name()
    {
        return 'EntityEx';
    }

    public function fileName($name)
    {
        return $name . 'Ex.php';
    }

    public function template()
    {
        return 'Model/entity_ex';
    }

}
