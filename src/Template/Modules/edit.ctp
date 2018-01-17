<?php
/*******************************************************************************
* @var \App\View\AppView $this
* @var \Cake\Datasource\EntityInterface $module
*******************************************************************************/
?>
<? /************************************************************************/ ?>
<?php $this->append('assets'); ?>
<?= $this->Html->script('/venders/ace/ace.js'); ?>
<?php $this->end(); ?>

<? /************************************************************************/ ?>
<?php $this->append('postfixScripts'); ?>
<script type="text/javascript">
  $(function(){ nnc("View").create(); });
</script>
<?php $this->end(); ?>

<? /************************************************************************/ ?>
<div class="admin">
  <section class="inputs">
    <h2><?= ($module->id)? "Edit" : "Create" ?> Module</h2>
    <?= $this->Form->create($module, ['id' => 'myform']) ?>
      <fieldset>
        <legend>Assets</legend>
        <?= $this->element('share/aux_assets', ['assets' => $module->assets, 'kinds' => $asset_kinds]); ?>
      </fieldset>
      <fieldset>
        <legend>Module</legend>
        <?= $this->Form->control('name'); ?>

        <div class="flex m0020">
          <div class="children input">
            <label for="prefix_script">PrefixScript</label>
            <div id="prefix-script-editor" class="editor mini"><?= $module->prefix_script ?></div>
          </div>
          <div class="children input">
            <label for="postfix_script">PostfixScript</label>
            <div id="postfix-script-editor" class="editor mini"><?= $module->postfix_script ?></div>
          </div>
        </div>

        <?php
        echo $this->Form->control('prefix_script',['type' => 'hidden']);
        echo $this->Form->control('postfix_script',['type' => 'hidden']);
        ?>
      </fieldset>

      <button id="btn-submit" class="nnc brue">送信</button>
      <?php if($module->id): ?>
        <button id="btn-delete" class="nnc red" data-id="<?= $module->id ?>">削除</button>
      <?php endif; ?>
    </section>
    <?= $this->Form->end() ?>
</div>
