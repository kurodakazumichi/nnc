<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $section
 */
?>
<div class="admin">
  <section class="inputs">
    <h2 class="m0020"><?= ($section->id)? "Edit" : "Create" ?> Section</h2>
    <?= $this->Form->create($section) ?>
    <fieldset>
        <?php
            echo $this->Form->control('title');
            echo $this->Form->control('memo');
            echo $this->Form->control('order_no');
            echo $this->Form->control('books._ids', ['options' => $books]);
            echo $this->Form->control('notes._ids', ['options' => $notes]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
  </section>

</div>
