<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $modulesAsset
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Modules Asset'), ['action' => 'edit', $modulesAsset->module_id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Modules Asset'), ['action' => 'delete', $modulesAsset->module_id], ['confirm' => __('Are you sure you want to delete # {0}?', $modulesAsset->module_id)]) ?> </li>
        <li><?= $this->Html->link(__('List Modules Assets'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Modules Asset'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Modules'), ['controller' => 'Modules', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Module'), ['controller' => 'Modules', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Assets'), ['controller' => 'Assets', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Asset'), ['controller' => 'Assets', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="modulesAssets view large-9 medium-8 columns content">
    <h3><?= h($modulesAsset->module_id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Module') ?></th>
            <td><?= $modulesAsset->has('module') ? $this->Html->link($modulesAsset->module->name, ['controller' => 'Modules', 'action' => 'view', $modulesAsset->module->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Asset') ?></th>
            <td><?= $modulesAsset->has('asset') ? $this->Html->link($modulesAsset->asset->id, ['controller' => 'Assets', 'action' => 'view', $modulesAsset->asset->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Order No') ?></th>
            <td><?= $this->Number->format($modulesAsset->order_no) ?></td>
        </tr>
    </table>
</div>
