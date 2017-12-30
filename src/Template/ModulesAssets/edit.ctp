<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $modulesAsset
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $modulesAsset->module_id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $modulesAsset->module_id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Modules Assets'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Modules'), ['controller' => 'Modules', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Module'), ['controller' => 'Modules', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Assets'), ['controller' => 'Assets', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Asset'), ['controller' => 'Assets', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="modulesAssets form large-9 medium-8 columns content">
    <?= $this->Form->create($modulesAsset) ?>
    <fieldset>
        <legend><?= __('Edit Modules Asset') ?></legend>
        <?php
            echo $this->Form->control('order_no');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
