<?php $this->append('assets'); ?>
<?= $this->Html->css('share/candidate_tags') ?>
<?= $this->Html->script('share/candidate_tags') ?>
<?php $this->end(); ?>

<div id="candidate-tags" class="input">
  <label>Tags</label>
  <?php /*
  * liをinline-block指定すると謎の隙間が生まれる。
  * 原因はHTML内の改行がスペースを生み出している。
  * 後から動的に要素を追加した場合、隙間の間隔がばらけて見栄えが悪い。
  * 親要素のulにfont-size:0を指定して解決も可能だが、レスポンシブをしているので都合が悪い。
  * 対策としてli要素間を<!-- -->でコメントでつなぐ事で改行をなくして対応。
  */?>
  <?php if($tags): ?>
  <ul id="candidate-tags-related">
    <?php foreach($tags as $tag): ?><!--
    --><li data-id="<?= $tag->id ?>"><span><?= $tag->name ?></span><a>✖</a></li><!--
    --><?php endforeach; ?><!--
  --></ul>
  <?php endif; ?>
  <input type="text" id="candidate-tags-search" autocomplete="off">

  <ul id="candidate-tags-list" class="stripe"></ul>
  <div id="candidate-tags-input"></div>
</div>

<?php $this->append("postfixScripts"); ?>
<script type="text/javascript">
$(function(){
  nnc("InputTags").create('#candidate-tags');
});
</script>
<?php $this->end(); ?>
