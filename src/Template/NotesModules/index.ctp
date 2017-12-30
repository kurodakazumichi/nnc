<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface[]|\Cake\Collection\CollectionInterface $notesModules
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Notes Module'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Notes'), ['controller' => 'Notes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Note'), ['controller' => 'Notes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Modules'), ['controller' => 'Modules', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Module'), ['controller' => 'Modules', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="notesModules index large-9 medium-8 columns content">
    <h3><?= __('Notes Modules') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('note_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('module_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($notesModules as $notesModule): ?>
            <tr>
                <td><?= $notesModule->has('note') ? $this->Html->link($notesModule->note->title, ['controller' => 'Notes', 'action' => 'view', $notesModule->note->id]) : '' ?></td>
                <td><?= $notesModule->has('module') ? $this->Html->link($notesModule->module->name, ['controller' => 'Modules', 'action' => 'view', $notesModule->module->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $notesModule->note_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $notesModule->note_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $notesModule->note_id], ['confirm' => __('Are you sure you want to delete # {0}?', $notesModule->note_id)]) ?>
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
