<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $note
 */
?>

<div class="admin">
  <section>
    <h2 class="m0020">ノートを編集する。</h2>
    <?= $this->Form->create($note) ?>
    <fieldset>

        <?php
            echo $this->Form->control('memo');
            echo $this->Form->control('title');
            echo $this->Form->control('body');
            echo $this->Form->control('css');
            echo $this->Form->control('js');
            echo $this->Form->control('search_word');
            echo $this->Form->control('description');
            echo $this->Form->control('category_id', ['options' => $categories, 'empty' => true]);
            echo $this->Form->control('status');
            echo $this->Form->control('modules._ids', ['options' => $modules]);
            echo $this->Form->control('tags._ids', ['options' => $tags]);
            echo $this->Form->control('sections._ids', ['options' => $sections]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
  </section>
</div>
