"use strict";
$(function () {
    var gAdmin = window.nnc('Admin');
    class cView {
        create() {
            this.at = {
                body: "#ui-body",
                css: "#ui-css",
                js: "#ui-js",
                markdownEditor: "#md-editor"
            };
            this.note = window.nnc("Note").create("#preview");
            $("#tabs").tabs();
            this.editors = {};
            this.editors.md = gAdmin.aceEditor('md-editor', 'md');
            this.editors.js = gAdmin.aceEditor('js-editor', 'js');
            this.editors.css = gAdmin.aceEditor('css-editor', 'css');
            return this;
        }
        init() {
            this.marked(true);
            this.editors.md.on("change", function (e) {
                this.marked(false);
            }.bind(this));
            var mde = $(this.at.markdownEditor);
            mde.on("dragenter", function (e) {
                this.onDragEnterMdEditor(e, mde);
            }.bind(this))
                .on("dragover", function (e) {
                this.onDragOverMdEditor(e, mde);
            }.bind(this))
                .on("dragleave", function (e) {
                this.onDragLeaveMdEditor(e, mde);
            }.bind(this))
                .on("drop", function (e) {
                this.onDropMdEditor(e, mde);
            }.bind(this));
            this.editors.css.on("change", function (e) {
                this.onChangeCssEditor();
            }.bind(this));
            this.editors.js.on("click", function () {
                this.onClickJsEditor();
            }.bind(this));
            $("#submit").on("click", function () {
                return this.onClickSubmit();
            }.bind(this));
        }
        onChangeMdEditor() {
            this.marked(false);
        }
        onDragEnterMdEditor(e, target) {
            target.addClass("emission");
            e.stopPropagation();
            e.preventDefault();
        }
        onDragOverMdEditor(e, target) {
            target.addClass("emission");
            e.originalEvent.dataTransfer.dropEffect = 'link';
            e.stopPropagation();
            e.preventDefault();
        }
        onDragLeaveMdEditor(e, target) {
            target.removeClass("emission");
        }
        onDropMdEditor(e, target) {
            e.stopPropagation();
            e.preventDefault();
            target.removeClass("emission");
            var fd = new FormData();
            $.each(e.originalEvent.dataTransfer.files, function (key, file) {
                fd.append("files[]", file);
            });
            var conf = gAdmin.ajaxConf("post", "/notes/image");
            conf.data = fd;
            conf.processData = false;
            conf.contentType = false;
            conf.success = function (_datas, status, res) {
                console.log(_datas);
                var datas = JSON.parse(_datas);
                var text = "";
                if (datas.status = "ok") {
                    $.each(datas.msg, function (key, url) {
                        text += `![テスト](${url})\n`;
                    });
                }
                this.editors.md.session.insert(this.editors.md.getCursorPosition(), text);
            }.bind(this);
            $.ajax(conf);
        }
        onChangeCssEditor() {
            this.updateStyle();
        }
        onClickJsEditor() {
            var ant = this.editors.js.getSession().getAnnotations();
            var error = "";
            $.each(ant, function (key, val) {
                error += `[${val.type}] ${val.raw}(${val.row},${val.column})\n`;
            });
            if (error != "") {
                alert("[JS Editor Syntax Error]\n" + error);
                return;
            }
            eval(this.editors.js.getValue());
        }
        onClickSubmit() {
            $(this.at.body).val(this.editors.md.getValue());
            $(this.at.css).val(this.editors.css.getValue());
            $(this.at.js).val(this.editors.js.getValue());
            return true;
        }
        marked(first = false) {
            this.note.setMarkdown(this.editors.md.getValue()).draw();
            (first) ? SyntaxHighlighter.all() : SyntaxHighlighter.highlight();
        }
        updateStyle() {
            gAdmin.updateStyle('note-css', this.editors.css.getValue());
        }
    }
    window.nnc("View", new cView);
});
