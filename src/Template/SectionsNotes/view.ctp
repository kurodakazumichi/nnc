<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $sectionsNote
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Sections Note'), ['action' => 'edit', $sectionsNote->section_id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Sections Note'), ['action' => 'delete', $sectionsNote->section_id], ['confirm' => __('Are you sure you want to delete # {0}?', $sectionsNote->section_id)]) ?> </li>
        <li><?= $this->Html->link(__('List Sections Notes'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sections Note'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sections'), ['controller' => 'Sections', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Section'), ['controller' => 'Sections', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Notes'), ['controller' => 'Notes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Note'), ['controller' => 'Notes', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="sectionsNotes view large-9 medium-8 columns content">
    <h3><?= h($sectionsNote->section_id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Section') ?></th>
            <td><?= $sectionsNote->has('section') ? $this->Html->link($sectionsNote->section->title, ['controller' => 'Sections', 'action' => 'view', $sectionsNote->section->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Note') ?></th>
            <td><?= $sectionsNote->has('note') ? $this->Html->link($sectionsNote->note->title, ['controller' => 'Notes', 'action' => 'view', $sectionsNote->note->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Order No') ?></th>
            <td><?= $this->Number->format($sectionsNote->order_no) ?></td>
        </tr>
    </table>
</div>
