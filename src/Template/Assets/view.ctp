<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $asset
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Asset'), ['action' => 'edit', $asset->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Asset'), ['action' => 'delete', $asset->id], ['confirm' => __('Are you sure you want to delete # {0}?', $asset->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Assets'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Asset'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Modules'), ['controller' => 'Modules', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Module'), ['controller' => 'Modules', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="assets view large-9 medium-8 columns content">
    <h3><?= h($asset->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Kind') ?></th>
            <td><?= h($asset->kind) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Memo') ?></th>
            <td><?= h($asset->memo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Src') ?></th>
            <td><?= h($asset->src) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($asset->id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Modules') ?></h4>
        <?php if (!empty($asset->modules)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Prefix Script') ?></th>
                <th scope="col"><?= __('Postfix Script') ?></th>
                <th scope="col"><?= __('Order No') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($asset->modules as $modules): ?>
            <tr>
                <td><?= h($modules->id) ?></td>
                <td><?= h($modules->name) ?></td>
                <td><?= h($modules->prefix_script) ?></td>
                <td><?= h($modules->postfix_script) ?></td>
                <td><?= h($modules->order_no) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Modules', 'action' => 'view', $modules->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Modules', 'action' => 'edit', $modules->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Modules', 'action' => 'delete', $modules->id], ['confirm' => __('Are you sure you want to delete # {0}?', $modules->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
