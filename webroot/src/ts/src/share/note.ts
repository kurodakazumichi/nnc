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
(function(){

var cNote = {
  // constructor
  create(selector)
  {
    var obj = Object.create(cNote.prototype);
    obj.folder = $(selector);
    obj.initRenderer();
    return obj;
  },

  // members
  prototype: {
    initRenderer ()
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
    },
    draw() {

      var text = marked(this.folder.html());
      this.folder.html(text).find("h2, h3, h4, h5, h6").each(function(){
         var a = $(this);
         a.nextUntil(a.prop("tagName")).addBack().wrapAll("<section></section>");
      });

      this.folder.show();
    }
  }
};

(<any>window).note = cNote;

})();
