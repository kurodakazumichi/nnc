<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface[]|\Cake\Collection\CollectionInterface $modulesAssets
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Modules Asset'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Modules'), ['controller' => 'Modules', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Module'), ['controller' => 'Modules', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Assets'), ['controller' => 'Assets', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Asset'), ['controller' => 'Assets', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="modulesAssets index large-9 medium-8 columns content">
    <h3><?= __('Modules Assets') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('module_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('asset_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('order_no') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($modulesAssets as $modulesAsset): ?>
            <tr>
                <td><?= $modulesAsset->has('module') ? $this->Html->link($modulesAsset->module->name, ['controller' => 'Modules', 'action' => 'view', $modulesAsset->module->id]) : '' ?></td>
                <td><?= $modulesAsset->has('asset') ? $this->Html->link($modulesAsset->asset->id, ['controller' => 'Assets', 'action' => 'view', $modulesAsset->asset->id]) : '' ?></td>
                <td><?= $this->Number->format($modulesAsset->order_no) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $modulesAsset->module_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $modulesAsset->module_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $modulesAsset->module_id], ['confirm' => __('Are you sure you want to delete # {0}?', $modulesAsset->module_id)]) ?>
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
