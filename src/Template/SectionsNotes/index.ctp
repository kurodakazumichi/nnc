<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface[]|\Cake\Collection\CollectionInterface $sectionsNotes
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Sections Note'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Sections'), ['controller' => 'Sections', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Section'), ['controller' => 'Sections', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Notes'), ['controller' => 'Notes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Note'), ['controller' => 'Notes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="sectionsNotes index large-9 medium-8 columns content">
    <h3><?= __('Sections Notes') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('section_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('note_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('order_no') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sectionsNotes as $sectionsNote): ?>
            <tr>
                <td><?= $sectionsNote->has('section') ? $this->Html->link($sectionsNote->section->title, ['controller' => 'Sections', 'action' => 'view', $sectionsNote->section->id]) : '' ?></td>
                <td><?= $sectionsNote->has('note') ? $this->Html->link($sectionsNote->note->title, ['controller' => 'Notes', 'action' => 'view', $sectionsNote->note->id]) : '' ?></td>
                <td><?= $this->Number->format($sectionsNote->order_no) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $sectionsNote->section_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $sectionsNote->section_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $sectionsNote->section_id], ['confirm' => __('Are you sure you want to delete # {0}?', $sectionsNote->section_id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
