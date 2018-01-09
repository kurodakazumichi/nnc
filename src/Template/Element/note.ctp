<?php /* CSS VIEW BLOCK */ ?>
<?php $this->append("css"); ?>
<?= $this->Html->css('note'); ?>
<style media="screen">
  <?= $note->css; ?>
</style>
<?php $this->end(); ?>

<?php /* PREFIX SCRIPT VIEW BLOCK */ ?>
<?php $this->append("script"); ?>
  <?= $this->Html->script('/venders/marked/marked.min.js'); ?>
  <?= $this->Html->script('share/note'); ?>
  <?php foreach($modules as $module): ?>
    <?= $module->prefix_script ?>
  <?php endforeach; ?>
<?php $this->end(); ?>

<?php /* POSTFIX SCRIPTS VIEW BLOCK */ ?>
<?php $this->append("postfixScripts"); ?>
<script type="text/javascript">
  $(function(){
    var n = note.create("#article");
    n.draw();
  });

  <?php foreach($modules as $module): ?>
    <?= $module->postfix_script ?>
  <?php endforeach; ?>

  <?= $note->js; ?>

</script>
<?php $this->end(); ?>

<?php /* MAIN CONTENTS */ ?>
<article id="article" class="note" style="display:none;">
  <?= $note->body; ?>
</article>
