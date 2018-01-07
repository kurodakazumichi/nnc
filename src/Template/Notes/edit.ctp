<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $note
 */
?>
<?php $this->start("script"); ?>
<script src="/venders/ace/ace.js"></script>
<script src="/venders/ace/mode-javascript.js"></script>
<?php $this->end(); ?>


<script type="text/javascript">
  $(function(){
    $("#tabs").tabs();




    var md_editor = ace.edit("md-editor");

    md_editor.getSession().setMode("ace/mode/markdown");
    md_editor.$blockScrolling = Infinity;

    var js_editor = ace.edit("js-editor");
    js_editor.getSession().setMode("ace/mode/javascript");
    js_editor.$blockScrolling = Infinity;

    var css_editor = ace.edit("css-editor");
    css_editor.getSession().setMode("ace/mode/css");
    css_editor.$blockScrolling = Infinity;

    var style = document.createElement('style');
    document.head.appendChild(style);

    var func = function() {
      var r = new marked.Renderer();
      r.heading = function(text, level) {
        level += 1;
        level = Math.max(2, level);
        return '<h'+level+'>'+text+'</h'+level+'>';
      };

      marked.setOptions({
        gfm:false,
        renderer:r
      });

      var htmlText = marked(md_editor.getValue());

      $('#preview').html(htmlText);

      $('#preview').find("h2, h3, h4, h5, h6").each(function(){
        var a = $(this);

        a.nextUntil(a.prop("tagName")).addBack().wrapAll("<section></section>");

      });
    };

    func();

    md_editor.on("change", function(e){
      func();
    });

    // $("#ui-body").on("keypress blur", function(e){
    //
    //   if(e.type == "blur" || e.type == "keypress" && e.which == 13) {
    //     func();
    //   }
    //
    // });


    $("#apply-css").on("click", function(){
      if(style.sheet.cssRules.length != 0) {
        style.sheet.deleteRule(0);
      }

      var css = css_editor.getValue();
      try{
        if(css != "") {
          style.sheet.insertRule(css, 0);
        }
      } catch(e) {
        alert(e);
      }

    });

    $("#apply-js").on("click", function(){
      var e = ace.edit("js-editor");
      eval(e.getValue());
    });

    // $("#ui-body").blur(function(){
    //   console.log("blur");
    //   $('#preview').html($(this).val());
    // });

    $("#submit").on("click", function(){
      $("#ui-body").val(md_editor.getValue());
      $("#ui-css").val(css_editor.getValue());
      $("#ui-js").val(js_editor.getValue());
      return true;
    });
  });



</script>
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
          <div id="md-editor" class="editor"><?= $note->body ?></div>
          <input type="hidden" id="ui-body" name="body" value="">
        </div>
      	<div id="tabs-2">
          <div id="css-editor" class="editor"><?= $note->css ?></div>
          <input type="hidden" id="ui-css" name="css" value="">
          <button type="button" name="button" id="apply-css">Apply</button>
        </div>
        <div id="tabs-3">
          <div id="js-editor" class="editor"><?= $note->js ?></div>
          <input type="hidden" id="ui-js" name="js" value="">
          <button type="button" name="button" id="apply-js">Apply</button>
        </div>
        <div id="tabs-4">
          <?php
            echo $this->Form->control('memo');
            echo $this->Form->control('search_word');
            echo $this->Form->control('description', ['type' => "textarea"]);
            echo $this->Form->control('category_id', ['options' => $categories, 'empty' => true]);
            echo $this->Form->control('status');
            echo $this->Form->control('modules._ids', ['options' => $modules]);
            echo $this->Form->control('tags._ids', ['options' => $tags]);
          ?>
        </div>
      </div>
      <?= $this->Form->button(__('Submit'), ['id' => "submit"]) ?>
      <?php if($note->id): ?>
        <?= $this->Form->postButton(__('Delete'), ['action' => 'delete', $note->id], ['confirm' => __('「{0}」を削除しますか?', $note->title)]) ?>
      <?php endif; ?>
      <?= $this->Form->end() ?>
    </section>
  </div>
  <div style="width:47.5%">
    <article id="preview" class="note">
      <?= $note->body; ?>
    </article>
  </div>
</div>
