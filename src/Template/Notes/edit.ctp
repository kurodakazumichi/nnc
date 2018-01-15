<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $note
 */

$this->append('assets');
echo $this->Html->script('/venders/marked/marked.min.js');
echo $this->Html->css('share/note');

echo $this->Html->css('/venders/syntaxhighlighter/styles/shCoreDefault.css');
echo $this->Html->script('/venders/syntaxhighlighter/scripts/shCore.js');

/* shBrushXXXX.jsはace.jsを使う場合は直接書く、autoloaderを使うとうまくいかない。*/
echo $this->Html->script('/venders/syntaxhighlighter/scripts/shBrushPlain.js');
echo $this->Html->script('/venders/syntaxhighlighter/scripts/shBrushXml.js');
echo $this->Html->script('/venders/syntaxhighlighter/scripts/shBrushCss.js');
echo $this->Html->script('/venders/syntaxhighlighter/scripts/shBrushJScript.js');
echo $this->Html->script('/venders/syntaxhighlighter/scripts/shBrushPhp.js');

/* ace.jsはSyntaxhighlighterより後に読み込まないとばぐる、can't find brush... */
echo $this->Html->script('/venders/ace/ace.js');
echo $this->Html->script('share/note');

?>
<style media="screen">
#preview {
  display:none;
  overflow:scroll;
  overflow-x:hidden;
  height:50vw;
  font-size:0.96em;
}
</style>

<style id="note-css" media="screen"><?= $note->css ?></style>





<?php $this->end(); ?>

<?php $this->append("postfixScripts"); ?>

<script type="text/javascript">
$(function(){
  nnc('View').create().init();
});
</script>
<?php $this->end(); ?>



<div style="display:flex; flex-wrap:nowrap; justify-content: space-around;">
  <div class="admin" style="width:47.5%;">
      <?= $this->Form->create($note) ?>
    <section class="inputs">
      <h2 class="m0020">ノートを<?= ($note->id)? "編集" :"作成" ?>する。</h2>
      <div id="tabs" style="font-size:0.7em;">
      	<ul>
      		<li><a href="#tabs-1">Body</a></li>
      		<li><a href="#tabs-2">CSS</a></li>
          <li><a href="#tabs-3">Javascript</a></li>
          <li><a href="#tabs-4">Options</a></li>
      	</ul>
      	<div id="tabs-1">
          <?= $this->Form->control('title'); ?>
          <?= $this->Form->error('body'); ?>
          <div id="md-editor" class="editor"><?= h($note->body) ?></div>
          <input type="hidden" id="ui-body" name="body" value="">
        </div>
      	<div id="tabs-2">
          <div id="css-editor" class="editor"><?= $note->css ?></div>
          <input type="hidden" id="ui-css" name="css" value="">
          <button type="button" name="button" id="apply-css">Apply</button>
        </div>
        <div id="tabs-3">
          <div id="js-editor" class="editor" title="クリックで適用"><?= $note->js ?></div>
          <input type="hidden" id="ui-js" name="js" value="">
        </div>
        <div id="tabs-4">
          <?php
            echo $this->Form->control('memo');
            echo $this->Form->control('search_word');
            echo $this->Form->control('description', ['type' => "textarea"]);
            echo $this->Form->control('category_id', ['options' => $categories, 'empty' => true]);
            echo $this->Form->control('status');
            echo $this->Form->control('modules._ids', ['options' => $modules]);
            echo $this->element('share/candidate_tags', ['tags' => $note->tags]);
          ?>
        </div>
      </div>
      <?= $this->Form->button(__('Submit'), ['id' => "submit"]) ?>
      <?= $this->Form->end() ?>
      <?php if($note->id): ?>
        <?= $this->Form->postButton(__('Delete'), ['action' => 'delete', $note->id], ['confirm' => __('「{0}」を削除しますか?', $note->title)]) ?>
      <?php endif; ?>
    </section>
  </div>
  <div style="width:47.5%">
    <article id="preview" class="note"><?= $note->body; ?></article>
  </div>
</div>
