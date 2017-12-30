<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface[]|\Cake\Collection\CollectionInterface $booksSections
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Books Section'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Books'), ['controller' => 'Books', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Book'), ['controller' => 'Books', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Sections'), ['controller' => 'Sections', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Section'), ['controller' => 'Sections', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="booksSections index large-9 medium-8 columns content">
    <h3><?= __('Books Sections') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('book_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('section_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('order_no') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($booksSections as $booksSection): ?>
            <tr>
                <td><?= $booksSection->has('book') ? $this->Html->link($booksSection->book->title, ['controller' => 'Books', 'action' => 'view', $booksSection->book->id]) : '' ?></td>
                <td><?= $booksSection->has('section') ? $this->Html->link($booksSection->section->title, ['controller' => 'Sections', 'action' => 'view', $booksSection->section->id]) : '' ?></td>
                <td><?= $this->Number->format($booksSection->order_no) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $booksSection->book_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $booksSection->book_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $booksSection->book_id], ['confirm' => __('Are you sure you want to delete # {0}?', $booksSection->book_id)]) ?>
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
