/*******************************************************************************
* admin.ts
*
* @依存外部ライブラリ
* jQuery,(ace)
*
* @依存自作ライブラリ
* NNC
*
* @機能概要
* 管理者用の共通機能を定義。
*******************************************************************************/
$(function(){

  /*****************************************************************************
  * UIの基底クラス
  *****************************************************************************/
  class cUIControll
  {
    protected container: any;
    public show(): cUIControll{
      this.container.show();
      return this;
    }
    public hide(): cUIControll{
      this.container.hide();
      return this;
    }
  }

  /*****************************************************************************
  * UI INPUT
  *
  * @構造
  * <container><input=selector></container>
  *****************************************************************************/
  class cUIInput extends cUIControll
  {
    private input:any;
    public create(selector): cUIInput
    {
      this.input = $(selector);
      this.container = this.input.parent();
      return this;
    }

    public val(value?:string): any
    {
      if(value) {
        this.input.val(value);
        return this;
      } else {
        return this.input.val();
      }
    }

  }

  /*****************************************************************************
  * UI TEXT
  *
  * @構造
  * <selector><any class="text"></selector>
  *****************************************************************************/
  class cUIText extends cUIControll
  {
    public create(selector): cUIText
    {
      this.container = $(selector);
      return this;
    }

    public text(value?:string): any
    {
      var target = this.container.find('.text');
      if(value) {
        target.text(value);
        return this;
      } else {
        return target.text();
      }
    }
  }

  /*****************************************************************************
  * UIクラス
  *****************************************************************************/
  class cUI
  {
    //--------------------------------------------------------------------------
    // UI TEXTを生成する
    static text(selector: string): cUIText {
      return (new cUIText).create(selector);
    }

    //--------------------------------------------------------------------------
    // UI INPUTを生成する
    static input(selector: string): cUIInput {
      return (new cUIInput).create(selector);
    }

    //--------------------------------------------------------------------------
    // ICONのデフォルトイベントを設定する
    static icons(selector: string): void {
      $(selector).hover(
      	function() { $( this ).addClass("ui-state-active");	},
      	function() { $( this ).removeClass("ui-state-active"); }
      );
    }
  }

  (<any>window).nnc("UI", cUI);

  /*****************************************************************************
  * 管理者用クラス
  *****************************************************************************/
  class cAdmin
  {
    //--------------------------------------------------------------------------
    // デフォルトのAjaxConfigオブジェクトを返す
    static ajaxConf(method: string, url:string): any
    {
      var conf = {
        type : method,
        url  : url,
        data : {},
        error: function(msg)
        {
          var text = "通信エラーが発生しました。\n" + msg.statusText;
          alert(text);
        }
      };
      return conf;
    }

    //--------------------------------------------------------------------------
    // 指定したスタイルタグの内容を更新する。
    static updateStyle(id: string, css:string)
    {
      $('#' + id).remove();
      $('head').append(
        '<style id="' + id + '">' + css + '</script>'
      );
    }

    //--------------------------------------------------------------------------
    // 配列をもとにcontainer要素内のinput hidden要素を更新する。
    static updateHiddensByArray(_container:string, name:string, datas:any[])
    {
      // コンテナをjQuery<HTMLElement>にしておく
      var container = $(_container);
      container.empty();

      $.each(datas, function(index, value)
      {
        // <input type="hidden" name="name" value="datas[i]">
        $('<input>').attr({
          type : 'hidden',
          name : name,
          value: value
        }).appendTo(container);
      });

    }

    //--------------------------------------------------------------------------
    // Ace Editorを適用する。
    static aceEditor(id: string, kind:string) : any
    {
      if(!ace) {
        console.error("ace is not found.");
        return null;
      }
      var editor = ace.edit(id);
      editor.$blockScrolling = Infinity;

      switch(kind) {
        case 'js'  : editor.getSession().setMode('ace/mode/javascript'); break;
        case 'css' : editor.getSession().setMode('ace/mode/css'); break;
        case 'md'  : editor.getSession().setMode('ace/mode/markdown'); break;
      }

      return editor;
    }

    //--------------------------------------------------------------------------
    // submitする
    static submit(action, method, options=null):void
    {
      // form生成
      var form = $('<form>', {
        'action'         : action,
        'method'        : method,
        'accept-charset': 'UTF-8',
        'enctype'       :'application/x-www-form-unlencoded',
      });

      // optionsをhidden要素に変換
      $.each(options, function(name, value){
        $('<input>', {
          'type' : 'hidden',
          'name' : name,
          'value': value,
        }).appendTo(form);
      });

      // bodyに存在しないformはsubmitがキャンセルされるので追加した上でsubmit。
      $('body').append(form);
      form.submit();
    }
  }

  (<any>window).nnc('Admin', cAdmin);


});
