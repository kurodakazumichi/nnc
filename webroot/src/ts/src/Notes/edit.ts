/*******************************************************************************
* Notes/edit.js
* タブ表示やテキストエディター、シンタックスハイライトやマークダウンの制御
* リアルタイムプレビュー、フォームサブミット時のデータ整形処理
*
* @依存外部ライブラリ
* jQuery,jQuery-ui,Marked,syntaxhighlighter,ace
*
* @依存自作ライブラリ
* NNC,cAdmin,cNote
*******************************************************************************/
$(function(){

  var gAdmin:any = (<any>window).nnc('Admin');

  class cView
  {
    // noteライブラリ
    private note: any;

    // 各種エディタ
    private editors: any;

    // DOM指定セレクタ
    private at:any;

    public create() : cView
    {
      // セレクタ定義
      this.at = {
        body          : "#ui-body",
        css           : "#ui-css",
        js            : "#ui-js",
        markdownEditor: "#md-editor"
      };

      // ノート
      this.note = (<any>window).nnc("Note").create("#preview");

      // editorより先にtabsを呼ばないとダメ。
      $("#tabs").tabs();

      this.editors = {};
      this.editors.md = gAdmin.aceEditor('md-editor', 'md');
      this.editors.js = gAdmin.aceEditor('js-editor', 'js');
      this.editors.css = gAdmin.aceEditor('css-editor', 'css');

      return this;
    }

    //--------------------------------------------------------------------------
    // 初期化
    public init()
    {
      // markdownを展開。
      this.marked(true);

      // markdown editorのイベントを設定
      this.editors.md.on("change", function(this: cView, e){
        this.marked(false);
      }.bind(this));

      var mde = $(this.at.markdownEditor);

      // markdown editorのドラッグ&ドロップイベントを設定
      mde.on("dragenter", function(this:cView, e){
        this.onDragEnterMdEditor(e, mde);
      }.bind(this))
      .on("dragover", function(this:cView, e){
        this.onDragOverMdEditor(e, mde);
      }.bind(this))
      .on("dragleave", function(this:cView, e){
        this.onDragLeaveMdEditor(e, mde);
      }.bind(this))
      .on("drop", function(this:cView, e){
        this.onDropMdEditor(e, mde);
      }.bind(this));

      // css editorのイベントを設定
      this.editors.css.on("change", function(this: cView, e){
        this.onChangeCssEditor();
      }.bind(this));

      // js editorのイベントを設定
      this.editors.js.on("click", function(this: cView){
        this.onClickJsEditor();
      }.bind(this));

      // submitボタンのイベントを設定
      $("#submit").on("click", function(this: cView){
        return this.onClickSubmit();
      }.bind(this));
    }

    //--------------------------------------------------------------------------
    // Markdown Editorの内容が変更されたときの処理
    private onChangeMdEditor():void
    {
      this.marked(false);
    }

    private onDragEnterMdEditor(e, target): void
    {
      target.addClass("emission");
      e.stopPropagation();
      e.preventDefault();
    }

    private onDragOverMdEditor(e, target): void {
      target.addClass("emission");
      e.originalEvent.dataTransfer.dropEffect = 'link';
      e.stopPropagation();
      e.preventDefault();
    }

    private onDragLeaveMdEditor(e, target): void {
      target.removeClass("emission");

    }

    private onDropMdEditor(e, target): void {
      e.stopPropagation();
      e.preventDefault();
      target.removeClass("emission");
      var fd = new FormData();

      $.each(e.originalEvent.dataTransfer.files, function(key, file){
        fd.append("files[]", file);
      });

      var conf:any = gAdmin.ajaxConf("post", "/notes/image");
      conf.data = fd;

      conf.processData = false;
      conf.contentType =false;
      conf.success = function (this:cView, _datas, status, res) {
        console.log(_datas);
        var datas = JSON.parse(_datas);
        var text = "";

        if(datas.status = "ok") {
          $.each(datas.msg, function(key, url) {
            text += `![テスト](${url})\n`;
          });
        }

        this.editors.md.session.insert(this.editors.md.getCursorPosition(), text);
      }.bind(this);
      $.ajax(conf);


    }

    //--------------------------------------------------------------------------
    // CSS Editorの内容が変更されたときの処理
    private onChangeCssEditor():void
    {
      this.updateStyle();
    }

    //--------------------------------------------------------------------------
    // JS Editorがクリックされたときの処理
    private onClickJsEditor():void
    {
      // アノテーションを取得
      var ant = this.editors.js.getSession().getAnnotations();

      // アノテーションからエラーメッセージを生成
      var error = "";
      $.each(ant, function(key, val){
        error += `[${val.type}] ${val.raw}(${val.row},${val.column})\n`;
      });

      // エラーがあれば表示して終了、Scriptを評価しない。
      if(error != "") {
        alert("[JS Editor Syntax Error]\n" + error);
        return;
      }

      // Scriptを再評価
      eval(this.editors.js.getValue());
    }

    //--------------------------------------------------------------------------
    // 送信ボタンがクリックされたときの処理
    private onClickSubmit()
    {
      $(this.at.body).val(this.editors.md.getValue());
      $(this.at.css).val(this.editors.css.getValue());
      $(this.at.js).val(this.editors.js.getValue());
      return true;
    }

    //--------------------------------------------------------------------------
    // markdownをHTMLに展開し、SyntaxHighlightする。
    private marked (first = false): void
    {
      this.note.setMarkdown(this.editors.md.getValue()).draw();
      (first)? SyntaxHighlighter.all() : SyntaxHighlighter.highlight();
    }

    //--------------------------------------------------------------------------
    // CSS Editorに記載されたstyleで更新する。
    private updateStyle(): void
    {
      gAdmin.updateStyle('note-css', this.editors.css.getValue());
    }
  }

(<any>window).nnc("View", new cView);

});
