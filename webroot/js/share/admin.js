"use strict";
$(function () {
    class cUIControll {
        show() {
            this.folder.show();
            return this;
        }
        hide() {
            this.folder.hide();
            return this;
        }
    }
    class cUIInput extends cUIControll {
        create(selector) {
            this.input = $(selector);
            this.folder = this.input.parent();
            return this;
        }
        val(value) {
            if (value) {
                this.input.val(value);
                return this;
            }
            else {
                return this.input.val();
            }
        }
    }
    class cUIText extends cUIControll {
        create(selector) {
            this.folder = $(selector);
            return this;
        }
        text(value) {
            var target = this.folder.find('.text');
            if (value) {
                target.text(value);
                return this;
            }
            else {
                return target.text();
            }
        }
    }
    class cUI {
        static text(selector) {
            return (new cUIText).create(selector);
        }
        static input(selector) {
            return (new cUIInput).create(selector);
        }
        static icons(selector) {
            $(selector).hover(function () { $(this).addClass("ui-state-active"); }, function () { $(this).removeClass("ui-state-active"); });
        }
    }
    window.nnc("UI", cUI);
    class cAdmin {
        static ajaxConf(method, url) {
            var conf = {
                type: method,
                url: url,
                data: {},
                error: function (msg) {
                    var text = "通信エラーが発生しました。\n" + msg.statusText;
                    alert(text);
                }
            };
            return conf;
        }
        static updateStyle(id, css) {
            $('#' + id).remove();
            $('head').append('<style id="' + id + '">' + css + '</script>');
        }
        static aceEditor(id, kind) {
            if (!ace) {
                console.error("ace is not found.");
                return null;
            }
            var editor = ace.edit(id);
            editor.$blockScrolling = Infinity;
            switch (kind) {
                case 'js':
                    editor.getSession().setMode('ace/mode/javascript');
                    break;
                case 'css':
                    editor.getSession().setMode('ace/mode/css');
                    break;
                case 'md':
                    editor.getSession().setMode('ace/mode/markdown');
                    break;
            }
            return editor;
        }
    }
    window.nnc('Admin', cAdmin);
});
