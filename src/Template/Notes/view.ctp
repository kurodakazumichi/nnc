<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Note $note
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Note'), ['action' => 'edit', $note->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Note'), ['action' => 'delete', $note->id], ['confirm' => __('Are you sure you want to delete # {0}?', $note->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Notes'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Note'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Tags'), ['controller' => 'Tags', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Tag'), ['controller' => 'Tags', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="notes view large-9 medium-8 columns content">
    <h3><?= h($note->title) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Title') ?></th>
            <td><?= h($note->title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Search Word') ?></th>
            <td><?= h($note->search_word) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Description') ?></th>
            <td><?= h($note->description) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Category') ?></th>
            <td><?= $note->has('category') ? $this->Html->link($note->category->name, ['controller' => 'Categories', 'action' => 'view', $note->category->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= h($note->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($note->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($note->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($note->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Body') ?></h4>
        <?= $this->Text->autoParagraph(h($note->body)); ?>
    </div>
    <div class="row">
        <h4><?= __('Css') ?></h4>
        <?= $this->Text->autoParagraph(h($note->css)); ?>
    </div>
    <div class="row">
        <h4><?= __('Js') ?></h4>
        <?= $this->Text->autoParagraph(h($note->js)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Tags') ?></h4>
        <?php if (!empty($note->tags)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($note->tags as $tags): ?>
            <tr>
                <td><?= h($tags->id) ?></td>
                <td><?= h($tags->name) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Tags', 'action' => 'view', $tags->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Tags', 'action' => 'edit', $tags->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Tags', 'action' => 'delete', $tags->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tags->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
