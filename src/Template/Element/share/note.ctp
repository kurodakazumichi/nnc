<?php
use App\Model\Table\NotesTableEx;

// 修正中の場合
if(!$logined && $note->status != NotesTableEx::STATUS_PUBLIC) {
  echo "修正中";
  return;
}
?>

<?php /* ASSETS VIEW BLOCK */ ?>
<?php $this->append("assets"); ?>
  <?= $this->Html->css('share/note'); ?>
  <style media="screen"><?= $note->css; ?></style>
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
  var n = nnc('Note').create("#article");
  n.draw();

  <?php foreach($modules as $module): ?>
    <?= $module->postfix_script ?>
  <?php endforeach; ?>

  <?= $note->js; ?>
});
</script>
<?php $this->end(); ?>

<?php /* MAIN CONTENTS */ ?>
<article id="article" class="note" style="display:none;"><?= $note->body; ?></article>
