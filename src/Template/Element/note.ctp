<?php /* CSS VIEW BLOCK */ ?>
<?php $this->append("css"); ?>
<style media="screen">
  <?= $article->note->css; ?>
</style>
<?php $this->end(); ?>

<?php /* POSTFIX SCRIPTS VIEW BLOCK */ ?>
<?php $this->append("postfixScripts"); ?>
<script type="text/javascript">
  $(function(){
    var n = note.create("#article");
    n.draw();
  });

  <?php foreach($modules as $module): ?>
    <?= $module->module->postfix_script ?>
  <?php endforeach; ?>

  <?= $article->note->js; ?>

</script>
<?php $this->end(); ?>

<?php /* MAIN CONTENTS */ ?>
<article id="article" class="note" style="display:none;">
  <?= $article->note->body; ?>
</article>
