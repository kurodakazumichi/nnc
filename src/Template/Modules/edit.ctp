<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $module
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $module->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $module->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Modules'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Assets'), ['controller' => 'Assets', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Asset'), ['controller' => 'Assets', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Notes'), ['controller' => 'Notes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Note'), ['controller' => 'Notes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="modules form large-9 medium-8 columns content">
    <?= $this->Form->create($module) ?>
    <fieldset>
        <legend><?= __('Edit Module') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('prefix_script');
            echo $this->Form->control('postfix_script');
            echo $this->Form->control('order_no');
            echo $this->Form->control('assets._ids', ['options' => $assets]);
            echo $this->Form->control('notes._ids', ['options' => $notes]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
