<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $tag
 */
 $this->start("gadgets");
 echo $this->element("gadget/related_menu");
 $this->end();
?>
<div class="admin">
  <section>
    <h2><?= __('Add Tag') ?></h2>
    <div class="tags form large-9 medium-8 columns content">
        <?= $this->Form->create($tag) ?>
        <fieldset>
            <legend><?= __('Add Tag') ?></legend>
            <?php
                echo $this->Form->control('name');
                echo $this->Form->control('notes._ids', ['options' => $notes]);
            ?>
        </fieldset>
        <?= $this->Form->button(__('Submit')) ?>
        <?= $this->Form->end() ?>
    </div>
  </section>

</div>
