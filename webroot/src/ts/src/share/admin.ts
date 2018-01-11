$(function(){

  class cUIControll
  {
    protected folder: any;
    public show(): cUIControll{
      this.folder.show();
      return this;
    }
    public hide(): cUIControll{
      this.folder.hide();
      return this;
    }
  }

  class cUIInput extends cUIControll
  {
    private input:any;
    public create(selector): cUIInput
    {
      this.input = $(selector);
      this.folder = this.input.parent();
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

  class cUIText extends cUIControll
  {
    public create(selector): cUIText
    {
      this.folder = $(selector);
      return this;
    }

    public text(value?:string): any
    {
      var target = this.folder.find('.text');
      if(value) {
        target.text(value);
        return this;
      } else {
        return target.text();
      }
    }

  }

  class cUI
  {
    static text(selector: string): cUIText
    {
      return (new cUIText).create(selector);
    }

    static input(selector: string): cUIInput
    {
      return (new cUIInput).create(selector);
    }

    static icons(selector: string): void
    {
      $(selector).hover(
      	function() { $( this ).addClass("ui-state-active");	},
      	function() { $( this ).removeClass("ui-state-active"); }
      );
    }
  }



  (<any>window).nnc("UI", cUI);

  class cAdmin
  {
    //==========================================================================
    // デフォルトのAjaxConfigオブジェクトを返す
    //==========================================================================
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
    /**
    * 指定スタイルシートの内容を更新する。
    */
    static updateStyle(id: string, css:string)
    {
      $('#' + id).remove();
      $('head').append(
        '<style id="' + id + '">' + css + '</script>'
      );
    }

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
  }

  (<any>window).nnc('Admin', cAdmin);


});
