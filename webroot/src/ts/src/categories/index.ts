/**
* categories/index.ts
* カテゴリ一覧テーブルの制御、ソートやAjaxによる非同期更新の制御。

* @依存外部ライブラリ
* jQuery,jQuery-ui
*
* @依存自作ライブラリ
* NNC,cAdmin,cUI
*
*/
$(function()
{
  /*****************************************************************************
  * 関数内グローバル変数を定義
  *****************************************************************************/
  var nnc = (<any>window).nnc;
  var gUI = nnc('UI');
  var gAdmin = nnc('Admin');

  // 処理中フラグ、他の処理をされたくない場合などの排他制御で使用する。
  var gProcessing: boolean;

  /*****************************************************************************
  * カテゴリ新規登録に関するクラス
  *****************************************************************************/
  class cNew
  {
    private section :any; // 全体を包括するsection
    private error   :any; // エラーメッセージ領域
    private name    :any; // 名称入力領域
    private button  :any; // 送信ボタン

    //--------------------------------------------------------------------------
    // 生成
    public create(): cNew
    {
      this.section = $('.new-category');
      this.error = gUI.text(this.section.find('.ui-error'));
      this.name = gUI.input(this.section.find('input[name=name]'));
      this.button = $(this.section.find('button'));
      return this;
    }

    //--------------------------------------------------------------------------
    // 初期化
    public init()
    {
      this.button.on('click', this.submit.bind(this));
    }

    //--------------------------------------------------------------------------
    // 送信
    private submit ()
    {
      // 処理中はイベントを無視。
      if(gProcessing) return false;

      var conf = gAdmin.ajaxConf('post', '/categories/add');

      // データをセット
      conf.data = { name:this.name.val() };

      // 通信成功時の処理
      conf.success = function(this:cNew, msg, status, responce)
      {
        msg = JSON.parse(msg);
        if(msg.status == "ok") {
          location.reload();
        } else {
          this.error.text(msg.data).show();
        }
      }.bind(this);

      // 発火
      $.ajax(conf);
    }
  }


  /*****************************************************************************
  * カテゴリ一覧クラス
  *****************************************************************************/
  class cList
  {
    private table:any;
    private tbody:any;

    //--------------------------------------------------------------------------
    // 生成
    public create(): cList
    {
      // DOM取得
      this.table = $('#categories2');
      this.tbody = this.table.find('.tbody');
      return this;
    }

    //--------------------------------------------------------------------------
    // 初期化
    public init() : void
    {
      gUI.icons(".icons li");
      this.initSort();
      this.initDeletes();
      this.initNames();
    }

    //--------------------------------------------------------------------------
    // 行を取得
    private getRow(id){
      return $("#category-id-" + id);
    }

    //==========================================================================
    // ソート関連
    //==========================================================================

    //--------------------------------------------------------------------------
    // ソートテーブルの初期化
    private initSort()
    {
      this.tbody.sortable({
        start :this.startSort.bind(this),
        stop  :this.stopSort.bind(this),
        update:this.updateSort.bind(this)
      });
    }

    //--------------------------------------------------------------------------
    // ソート開始時はソート中の行のスタイルを変更
    private startSort(event, ui) {
      ui.item.addClass("active");
    }

    //--------------------------------------------------------------------------
    // ソート終了時はソート中の行のスタイルを元に戻す
    private stopSort(event, ui) {
      ui.item.removeClass("active");
    }

    //--------------------------------------------------------------------------
    // 並び替えが発生した場合はAjaxでデータ更新。
    private updateSort(event, ui)
    {
      // Ajax設定
      var conf = gAdmin.ajaxConf('put', '/categories/reorder');
      conf.data = this.serializeSort();

      // 成功時はリロードする。
      conf.success = function(){
        location.reload();
      }

      // 成否を問わずソートを有効にする。
      conf.complete = function(this:cList) {
        this.enableSort();
      }.bind(this);

      // ソートを無効にして通信開始。
      this.disableSort();
      $.ajax(conf);
    }

    //--------------------------------------------------------------------------
    // ソートを無効にする
    private disableSort() {
      this.tbody.sortable("disable");
    }

    //--------------------------------------------------------------------------
    // ソートを有効にする
    private enableSort() {
      this.tbody.sortable("enable");
    }

    //--------------------------------------------------------------------------
    // ソートデータのシリアライズ
    private serializeSort() {
      return this.tbody.sortable("serialize");
    }

    //==========================================================================
    // 削除関連
    //==========================================================================

    //--------------------------------------------------------------------------
    // 削除アイコンの処理を設定。
    private initDeletes()
    {
      var me = this;
      this.tbody.find(".icons li.delete").click(function(this:any){
        me.clickDelete($(this).attr('data-id'), $(this));
      });
    }

    //--------------------------------------------------------------------------
    // 削除アイコンが押されたらAjaxでデータ更新
    private clickDelete(id, ui)
    {
      if(confirm('カテゴリを削除してよろしいですか？') == false) return;

      var row = this.getRow(id);
      var conf = gAdmin.ajaxConf('delete', '/categories/delete/' + id);

      conf.success = function() {
        row.remove();
      }.bind(this);

      conf.complete = function (this:cList) {
        this.enableSort();
      }.bind(this);

      this.disableSort();
      $.ajax(conf);
    }

    //==========================================================================
    // カテゴリ名変更
    //==========================================================================

    //--------------------------------------------------------------------------
    // カテゴリ名のテキストをクリックすると入力フォームを表示
    // 入力フォームからフォーカスが外れたタイミングでAjaxによる更新処理
    private initNames() {
      var me = this;
      this.tbody.find(".name .ui-text").click(function(this:any){
        me.clickTextOfName($(this).attr('data-id'), $(this));
      });
      this.tbody.find(".name .ui-input input")
      .focus(function(this:any){
        me.focusInputOfName($(this).attr('data-id'), $(this));
      })
      .blur(function(this:any){
        me.blurInputOfName($(this).attr('data-id'), $(this));
      });

    }

    private clickTextOfName(id, ui)
    {
      if(gProcessing) return;
      this.showInputOfName(ui, this.getRow(id).find(".name .ui-input"));
    }

    private focusInputOfName(id, ui)
    {
      this.disableSort();
    }

    private blurInputOfName(id, ui)
    {
      var row = this.getRow(id);
      var ui_text  = row.find(".name .ui-text");
      var ui_input = row.find(".name .ui-input");
      var ui_error = row.find(".name .ui-error");

      if(ui_text.text().trim() != ui.val().trim()) {
        this.blurChangeOfName(id, ui, ui_text, ui_input, ui_error);
      } else {
        this.blurFinalizeOfName(ui_text, ui_input, ui_error);
      }
    }

    private blurChangeOfName(id, ui, text, input, error) {
      gProcessing = true;

      var conf = gAdmin.ajaxConf('pust', '/categories/edit/' + id);


      conf.data = {name: ui.val().trim() };
      conf.success = function(this:cList, msg, status){
        msg = JSON.parse(msg);
        if(msg.status == "ok") {
          text.text(msg.data);
          this.blurFinalizeOfName(text, input, error);
        } else {
          error.show().find("p").text(msg.data);
          ui.focus();
        }
      }.bind(this);


      conf.error = function(this:cList, msg, status) {
        error.show().find("p").text(msg.statusText);
        text.show();
        input.hide();
      }.bind(this);

      $.ajax(conf);
    }
    private blurFinalizeOfName(text, input, error) {
      this.showTextOfName(text, input);
      error.hide();
      this.enableSort();
      gProcessing = false;
    }
    private showTextOfName(text, input) {
      text.show();
      input.hide();
    }
    private showInputOfName(text, input) {
      text.hide();
      input.show().find('input').focus().val(text.text().trim());
    }
  }


  (new cNew).create().init();
  (new cList).create().init();
});
