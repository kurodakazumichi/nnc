<?php
/**
* @var \App\View\AppView $this
* @var \Cake\Datasource\EntityInterface $asset
*/
?>
<div class="admin">
  <section class="inputs">
    <h2 class="m0020"><?= ($asset->id)? "Edit" : "Create" ?> Asset</h2>
    <?= $this->Form->create($asset) ?>
    <fieldset>
      <?php
        echo $this->Form->control('kind', ['empty' => '選択してください。']);
        echo $this->Form->control('memo');
        echo $this->Form->control('src');
      ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?php if($asset->id): ?>
      <li><?= $this->Form->postButton(__('Delete Asset'), ['action' => 'delete', $asset->id], ['confirm' => __('Are you sure you want to delete # {0}?', $asset->id)]) ?> </li>
    <?php endif; ?>
    <?= $this->Form->end() ?>
  </section>
</div>
