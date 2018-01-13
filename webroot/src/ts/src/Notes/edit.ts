/**
* Notes/edit.js
* タブ表示やテキストエディター、シンタックスハイライトやマークダウンの制御
* リアルタイムプレビュー、フォームサブミット時のデータ整形処理
*
* @依存外部ライブラリ
* jQuery,jQuery-ui,Marked,syntaxhighlighter,ace
*
* @依存自作ライブラリ
* NNC,cAdmin,cNote
*
*/
(function(){

  class cView
  {
    private admin: any;
    private note: any;
    private editors: any;
    private editorJs: AceAjax.Editor;
    private editorCss: AceAjax.Editor;
    public create() : cView
    {
      this.admin = (<any>window).nnc("Admin");

      this.note = (<any>window).nnc("Note").create("#preview");

      // editorより先にtabsを呼ばないとダメ。
      $("#tabs").tabs();

      this.editors = {};
      this.editors.md = this.admin.aceEditor('md-editor', 'md');
      this.editors.js = this.admin.aceEditor('js-editor', 'js');
      this.editors.css = this.admin.aceEditor('css-editor', 'css');

      return this;
    }
    public init()
    {
      this.marked(true);

      this.editors.md.on("change", function(this: cView, e){
        console.log(e);
        this.marked(false);
      }.bind(this));

      this.editors.css.on("change", function(this: cView, e){
        this.applyStyle();
      }.bind(this));

      this.editors.js.on("click", function(this: cView){
        eval(this.editors.js.getValue());
      }.bind(this));

      $("#submit").on("click", function(this: cView){
        $("#ui-body").val(this.editors.md.getValue());
        $("#ui-css").val(this.editors.css.getValue());
        $("#ui-js").val(this.editors.js.getValue());
        return true;
      }.bind(this));
    }

    private marked (first = false): void
    {
      this.note.setMarkdown(this.editors.md.getValue()).draw();
      (first)? SyntaxHighlighter.all() : SyntaxHighlighter.highlight();
    }



    private applyStyle(): void
    {
      this.admin.updateStyle('note-css', this.editors.css.getValue());
    }
  }

  (<any>window).nnc("View", new cView);

})();
