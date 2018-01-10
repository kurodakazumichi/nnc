$(function(){

  class cAdmin
  {
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
