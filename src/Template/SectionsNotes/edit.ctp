<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $sectionsNote
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $sectionsNote->section_id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $sectionsNote->section_id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Sections Notes'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Sections'), ['controller' => 'Sections', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Section'), ['controller' => 'Sections', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Notes'), ['controller' => 'Notes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Note'), ['controller' => 'Notes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="sectionsNotes form large-9 medium-8 columns content">
    <?= $this->Form->create($sectionsNote) ?>
    <fieldset>
        <legend><?= __('Edit Sections Note') ?></legend>
        <?php
            echo $this->Form->control('order_no');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
