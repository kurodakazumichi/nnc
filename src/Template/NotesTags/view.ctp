<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $notesTag
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Notes Tag'), ['action' => 'edit', $notesTag->note_id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Notes Tag'), ['action' => 'delete', $notesTag->note_id], ['confirm' => __('Are you sure you want to delete # {0}?', $notesTag->note_id)]) ?> </li>
        <li><?= $this->Html->link(__('List Notes Tags'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Notes Tag'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Notes'), ['controller' => 'Notes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Note'), ['controller' => 'Notes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Tags'), ['controller' => 'Tags', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Tag'), ['controller' => 'Tags', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="notesTags view large-9 medium-8 columns content">
    <h3><?= h($notesTag->note_id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Note') ?></th>
            <td><?= $notesTag->has('note') ? $this->Html->link($notesTag->note->title, ['controller' => 'Notes', 'action' => 'view', $notesTag->note->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tag') ?></th>
            <td><?= $notesTag->has('tag') ? $this->Html->link($notesTag->tag->name, ['controller' => 'Tags', 'action' => 'view', $notesTag->tag->id]) : '' ?></td>
        </tr>
    </table>
</div>
