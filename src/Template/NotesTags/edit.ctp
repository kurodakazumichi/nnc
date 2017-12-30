<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $notesTag
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $notesTag->note_id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $notesTag->note_id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Notes Tags'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Notes'), ['controller' => 'Notes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Note'), ['controller' => 'Notes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Tags'), ['controller' => 'Tags', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Tag'), ['controller' => 'Tags', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="notesTags form large-9 medium-8 columns content">
    <?= $this->Form->create($notesTag) ?>
    <fieldset>
        <legend><?= __('Edit Notes Tag') ?></legend>
        <?php
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
