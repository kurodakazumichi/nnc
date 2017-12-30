<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $booksSection
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Books Section'), ['action' => 'edit', $booksSection->book_id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Books Section'), ['action' => 'delete', $booksSection->book_id], ['confirm' => __('Are you sure you want to delete # {0}?', $booksSection->book_id)]) ?> </li>
        <li><?= $this->Html->link(__('List Books Sections'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Books Section'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Books'), ['controller' => 'Books', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Book'), ['controller' => 'Books', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sections'), ['controller' => 'Sections', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Section'), ['controller' => 'Sections', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="booksSections view large-9 medium-8 columns content">
    <h3><?= h($booksSection->book_id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Book') ?></th>
            <td><?= $booksSection->has('book') ? $this->Html->link($booksSection->book->title, ['controller' => 'Books', 'action' => 'view', $booksSection->book->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Section') ?></th>
            <td><?= $booksSection->has('section') ? $this->Html->link($booksSection->section->title, ['controller' => 'Sections', 'action' => 'view', $booksSection->section->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Order No') ?></th>
            <td><?= $this->Number->format($booksSection->order_no) ?></td>
        </tr>
    </table>
</div>
