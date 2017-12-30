<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $section
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Section'), ['action' => 'edit', $section->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Section'), ['action' => 'delete', $section->id], ['confirm' => __('Are you sure you want to delete # {0}?', $section->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Sections'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Section'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Books'), ['controller' => 'Books', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Book'), ['controller' => 'Books', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Notes'), ['controller' => 'Notes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Note'), ['controller' => 'Notes', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="sections view large-9 medium-8 columns content">
    <h3><?= h($section->title) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Title') ?></th>
            <td><?= h($section->title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Memo') ?></th>
            <td><?= h($section->memo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($section->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Order No') ?></th>
            <td><?= $this->Number->format($section->order_no) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Books') ?></h4>
        <?php if (!empty($section->books)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Layer') ?></th>
                <th scope="col"><?= __('Category Id') ?></th>
                <th scope="col"><?= __('Title') ?></th>
                <th scope="col"><?= __('Description') ?></th>
                <th scope="col"><?= __('Published') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($section->books as $books): ?>
            <tr>
                <td><?= h($books->id) ?></td>
                <td><?= h($books->layer) ?></td>
                <td><?= h($books->category_id) ?></td>
                <td><?= h($books->title) ?></td>
                <td><?= h($books->description) ?></td>
                <td><?= h($books->published) ?></td>
                <td><?= h($books->created) ?></td>
                <td><?= h($books->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Books', 'action' => 'view', $books->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Books', 'action' => 'edit', $books->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Books', 'action' => 'delete', $books->id], ['confirm' => __('Are you sure you want to delete # {0}?', $books->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Notes') ?></h4>
        <?php if (!empty($section->notes)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Memo') ?></th>
                <th scope="col"><?= __('Title') ?></th>
                <th scope="col"><?= __('Body') ?></th>
                <th scope="col"><?= __('Css') ?></th>
                <th scope="col"><?= __('Js') ?></th>
                <th scope="col"><?= __('Search Word') ?></th>
                <th scope="col"><?= __('Description') ?></th>
                <th scope="col"><?= __('Category Id') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($section->notes as $notes): ?>
            <tr>
                <td><?= h($notes->id) ?></td>
                <td><?= h($notes->memo) ?></td>
                <td><?= h($notes->title) ?></td>
                <td><?= h($notes->body) ?></td>
                <td><?= h($notes->css) ?></td>
                <td><?= h($notes->js) ?></td>
                <td><?= h($notes->search_word) ?></td>
                <td><?= h($notes->description) ?></td>
                <td><?= h($notes->category_id) ?></td>
                <td><?= h($notes->status) ?></td>
                <td><?= h($notes->created) ?></td>
                <td><?= h($notes->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Notes', 'action' => 'view', $notes->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Notes', 'action' => 'edit', $notes->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Notes', 'action' => 'delete', $notes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $notes->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
