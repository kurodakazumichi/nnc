<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $article
 */
?>
<div class="admin">
    <section>
      <h2><?= __('Edit Article') ?></h2>
      <?= $this->Form->create($article) ?>
      <fieldset>
          <legend><?= __('Edit Article') ?></legend>
          <?php
              echo $this->Form->control('note_id', ['options' => $notes]);
              echo $this->Form->control('layer');
              echo $this->Form->control('category_id', ['options' => $categories, 'empty' => true]);
              echo $this->Form->control('published');
          ?>
      </fieldset>
      <?= $this->Form->button(__('Submit')) ?>
      <?= $this->Form->end() ?>
    </section>
</div>
