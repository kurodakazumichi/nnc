<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $section
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Sections'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Books'), ['controller' => 'Books', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Book'), ['controller' => 'Books', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Notes'), ['controller' => 'Notes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Note'), ['controller' => 'Notes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="sections form large-9 medium-8 columns content">
    <?= $this->Form->create($section) ?>
    <fieldset>
        <legend><?= __('Add Section') ?></legend>
        <?php
            echo $this->Form->control('title');
            echo $this->Form->control('memo');
            echo $this->Form->control('order_no');
            echo $this->Form->control('books._ids', ['options' => $books]);
            echo $this->Form->control('notes._ids', ['options' => $notes]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
