/**
 * note.js
 * @dependence
 *
 * 1. jquery.js(3.2.1)
 * https://jquery.com/download/
 *
 * 2. marked.js
 * https://github.com/chjj/marked
 */
$(function(){

class cNote
{
  /**
  * builder method.
  */
  static create(selector: string)
  {
    return new cNote(selector);
  }

  // Note内容を包括する親要素
  private folder: JQuery;

  // Markdownテキスト(変換前)
  private markdown: string;

  /**
  * コンストラクター
  */
  constructor(selector: string)
  {
    this.folder = $(selector);
    this.markdown = this.folder.html();
    this.init();
  }

  public setMarkdown(text: string): cNote
  {
    this.markdown = text;
    return this;
  }

  private init():void
  {
    // markedの描画ルールをカスタマイズしていく。
    var r = new marked.Renderer();

    // h1タグはページヘッダで使用するためmarkedではh2から始まるように
    // デフォルトのレベルを変更。
    r.heading = function(text, level)
    {
      level += 1;
      level = Math.max(2, level);
      return '<h'+level+'>'+text+'</h'+level+'>';
    };

    marked.setOptions({
      gfm:false,
      renderer:r,
    });
  }

  public draw(): void
  {
    var text = marked(this.markdown);
    this.folder.html(text).find("h2, h3, h4, h5, h6").each(function(){
       var block = $(this);
       block.nextUntil(block.prop("tagName")).addBack().wrapAll("<section></section>");
    });

    this.folder.show();
  }

}

// 登録
(<any>window).nnc("Note", cNote);

});
