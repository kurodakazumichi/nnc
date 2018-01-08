"use strict";
(function () {
    var cNote = {
        create(selector) {
            var obj = Object.create(cNote.prototype);
            obj.folder = $(selector);
            obj.initRenderer();
            return obj;
        },
        prototype: {
            initRenderer() {
                var r = new marked.Renderer();
                r.heading = function (text, level) {
                    level += 1;
                    level = Math.max(2, level);
                    return '<h' + level + '>' + text + '</h' + level + '>';
                };
                marked.setOptions({
                    gfm: false,
                    renderer: r,
                });
            },
            draw() {
                var text = marked(this.folder.html());
                this.folder.html(text).find("h2, h3, h4, h5, h6").each(function () {
                    var a = $(this);
                    a.nextUntil(a.prop("tagName")).addBack().wrapAll("<section></section>");
                });
                this.folder.show();
            }
        }
    };
    window.note = cNote;
})();
