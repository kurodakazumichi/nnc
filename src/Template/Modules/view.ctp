<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $module
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Module'), ['action' => 'edit', $module->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Module'), ['action' => 'delete', $module->id], ['confirm' => __('Are you sure you want to delete # {0}?', $module->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Modules'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Module'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Assets'), ['controller' => 'Assets', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Asset'), ['controller' => 'Assets', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Notes'), ['controller' => 'Notes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Note'), ['controller' => 'Notes', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="modules view large-9 medium-8 columns content">
    <h3><?= h($module->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($module->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($module->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Order No') ?></th>
            <td><?= $this->Number->format($module->order_no) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Prefix Script') ?></h4>
        <?= $this->Text->autoParagraph(h($module->prefix_script)); ?>
    </div>
    <div class="row">
        <h4><?= __('Postfix Script') ?></h4>
        <?= $this->Text->autoParagraph(h($module->postfix_script)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Assets') ?></h4>
        <?php if (!empty($module->assets)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Kind') ?></th>
                <th scope="col"><?= __('Memo') ?></th>
                <th scope="col"><?= __('Src') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($module->assets as $assets): ?>
            <tr>
                <td><?= h($assets->id) ?></td>
                <td><?= h($assets->kind) ?></td>
                <td><?= h($assets->memo) ?></td>
                <td><?= h($assets->src) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Assets', 'action' => 'view', $assets->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Assets', 'action' => 'edit', $assets->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Assets', 'action' => 'delete', $assets->id], ['confirm' => __('Are you sure you want to delete # {0}?', $assets->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Notes') ?></h4>
        <?php if (!empty($module->notes)): ?>
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
            <?php foreach ($module->notes as $notes): ?>
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
