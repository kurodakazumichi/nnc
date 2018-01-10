"use strict";
(function () {
    class cView {
        create() {
            this.admin = window.nnc("Admin");
            this.note = window.nnc("Note").create("#preview");
            $("#tabs").tabs();
            this.editors = {};
            this.editors.md = this.admin.aceEditor('md-editor', 'md');
            this.editors.js = this.admin.aceEditor('js-editor', 'js');
            this.editors.css = this.admin.aceEditor('css-editor', 'css');
            return this;
        }
        init() {
            this.marked(true);
            this.editors.md.on("change", function (e) {
                console.log(e);
                this.marked(false);
            }.bind(this));
            this.editors.css.on("change", function (e) {
                this.applyStyle();
            }.bind(this));
            this.editors.js.on("click", function () {
                eval(this.editors.js.getValue());
            }.bind(this));
            $("#submit").on("click", function () {
                $("#ui-body").val(this.editors.md.getValue());
                $("#ui-css").val(this.editors.css.getValue());
                $("#ui-js").val(this.editors.js.getValue());
                return true;
            }.bind(this));
        }
        marked(first = false) {
            this.note.setMarkdown(this.editors.md.getValue()).draw();
            (first) ? SyntaxHighlighter.all() : SyntaxHighlighter.highlight();
        }
        applyStyle() {
            this.admin.updateStyle('note-css', this.editors.css.getValue());
        }
    }
    window.nnc("View", new cView);
})();
