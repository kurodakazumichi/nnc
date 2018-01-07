<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $book
 */
?>
<div class="admin">
  <section class="inputs">
    <h2 class="m0020"><?= ($book->id)? 'Edit' : 'Create' ?> Book</h2>
    <?= $this->Form->create($book) ?>
    <fieldset>
        <?php
            echo $this->Form->control('layer');
            echo $this->Form->control('category_id', ['options' => $categories, 'empty' => true]);
            echo $this->Form->control('title');
            echo $this->Form->control('description', ['type' => 'textarea']);
            echo $this->Form->control('published');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?php if($book->id): ?>
      <?= $this->Form->postButton(__('Delete'), ['action' => 'delete', $book->id], ['confirm' => __('Are you sure you want to delete # {0}?', $book->id)]) ?>
    <?php endif; ?>
    <?= $this->Form->end() ?>
  </section>
</div>
