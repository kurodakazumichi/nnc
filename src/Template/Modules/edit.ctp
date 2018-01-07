<?php
/**
* @var \App\View\AppView $this
* @var \Cake\Datasource\EntityInterface $module
*/
?>
<div class="admin">
  <section class="inputs">
    <h2><?= ($module->id)? "Edit" : "Create" ?> Module</h2>
    <?= $this->Form->create($module) ?>
    <fieldset>

      <?php
      echo $this->Form->control('name');
      echo $this->Form->control('prefix_script');
      echo $this->Form->control('postfix_script');
      echo $this->Form->control('order_no');
      echo $this->Form->control('assets._ids', ['options' => $assets]);
      echo $this->Form->control('notes._ids', ['options' => $notes]);
      ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?php if($module->id): ?>
      <?= $this->Form->postButton(
        __('Delete'),
        ['action' => 'delete', $module->id],
        ['confirm' => __('Are you sure you want to delete # {0}?', $module->id)]
        )
        ?>
      <?php endif; ?>
      <?= $this->Form->end() ?>
    </section>
</div>
