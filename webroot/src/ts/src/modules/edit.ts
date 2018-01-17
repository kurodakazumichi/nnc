/*******************************************************************************
* Modules/edit.js
*
* @依存外部ライブラリ
* jQuery,ace
*
* @依存自作ライブラリ
* NNC,cAdmin
*
* @機能概要
* prefix,postfixスクリプトをAce EditorでEditorにする。
* 送信ボタンが押されたらformデータを整えた上でsubmitする。
* 削除ボタンが押されたらAjaxでモジュールの削除を行う(/ajaxs/module/$id)
*
* @DOM
* フォーム：form#myform
* PrefixScriptエディタ：div#prefix-script-editor
* PostfixScriptエディタ：div#postfix-script-editor
* 隠し要素：input[name=prefix_script]
* 隠し要素：input[name=postfix_script]
* 送信:#btn-submit
* 削除:#btn-delete
*
* @Events
* 送信ボタン onclick
* 削除ボタン onclick
*******************************************************************************/
$(function(){

  var gAdmin:any = (<any>window).nnc('Admin');

  class cView
  {
    // DOM指定セレクタ
    private at:any;

    // 各種エディタ
    private editors: any;

    //--------------------------------------------------------------------------
    // 生成
    public create() : cView
    {
      // セレクタ定義
      this.at = {
        myform        : '#myform',
        inputPreScript: '#myform input[name=prefix_script]',
        inputPosScript: '#myform input[name=postfix_script]',
        btnSubmit     : '#btn-submit',
        btnDelete     : '#btn-delete',
      };

      // divをEditor化
      this.editors = {};
      this.editors.pre = gAdmin.aceEditor('prefix-script-editor', 'js');
      this.editors.pos = gAdmin.aceEditor('postfix-script-editor', 'js');

      // 初期化
      this.init();
      return this;
    }

    //--------------------------------------------------------------------------
    // 初期化
    private init()
    {
      var me = this;

      // イベントの割り当て
      $(this.at.btnSubmit).on('click', function(){
        me.onclickBtnSubmit(this);
      });
      $(this.at.btnDelete).on('click', function(){
        me.onclickBtnDelete(this);
      });
    }

    //--------------------------------------------------------------------------
    // 送信ボタンがクリックされたとき
    private onclickBtnSubmit(btn)
    {
      // editorの内容をhidden要素にセットする。
      $(this.at.inputPreScript).val(this.editors.pre.getValue());
      $(this.at.inputPosScript).val(this.editors.pos.getValue());
      $(this.at.myform).submit();
    }

    //--------------------------------------------------------------------------
    // 削除ボタンがクリックされたとき
    private onclickBtnDelete(btn)
    {
      // 確認
      if(!confirm('本当に削除してよろしいですか？')) return;

      // サブミット
      var id = $(btn).attr('data-id');
      gAdmin.submit(`/modules/delete/${id}`, "post");
    }
  }

  (<any>window).nnc("View", new cView);

});
