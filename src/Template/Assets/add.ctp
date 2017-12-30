<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $asset
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Assets'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Modules'), ['controller' => 'Modules', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Module'), ['controller' => 'Modules', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="assets form large-9 medium-8 columns content">
    <?= $this->Form->create($asset) ?>
    <fieldset>
        <legend><?= __('Add Asset') ?></legend>
        <?php
            echo $this->Form->control('kind');
            echo $this->Form->control('memo');
            echo $this->Form->control('src');
            echo $this->Form->control('modules._ids', ['options' => $modules]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
