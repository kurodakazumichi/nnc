<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $booksSection
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $booksSection->book_id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $booksSection->book_id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Books Sections'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Books'), ['controller' => 'Books', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Book'), ['controller' => 'Books', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Sections'), ['controller' => 'Sections', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Section'), ['controller' => 'Sections', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="booksSections form large-9 medium-8 columns content">
    <?= $this->Form->create($booksSection) ?>
    <fieldset>
        <legend><?= __('Edit Books Section') ?></legend>
        <?php
            echo $this->Form->control('order_no');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
