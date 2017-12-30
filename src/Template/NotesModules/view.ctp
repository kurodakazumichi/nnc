<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $notesModule
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Notes Module'), ['action' => 'edit', $notesModule->note_id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Notes Module'), ['action' => 'delete', $notesModule->note_id], ['confirm' => __('Are you sure you want to delete # {0}?', $notesModule->note_id)]) ?> </li>
        <li><?= $this->Html->link(__('List Notes Modules'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Notes Module'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Notes'), ['controller' => 'Notes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Note'), ['controller' => 'Notes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Modules'), ['controller' => 'Modules', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Module'), ['controller' => 'Modules', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="notesModules view large-9 medium-8 columns content">
    <h3><?= h($notesModule->note_id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Note') ?></th>
            <td><?= $notesModule->has('note') ? $this->Html->link($notesModule->note->title, ['controller' => 'Notes', 'action' => 'view', $notesModule->note->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Module') ?></th>
            <td><?= $notesModule->has('module') ? $this->Html->link($notesModule->module->name, ['controller' => 'Modules', 'action' => 'view', $notesModule->module->id]) : '' ?></td>
        </tr>
    </table>
</div>
