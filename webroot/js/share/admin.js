"use strict";
$(function () {
    class cUIControll {
        show() {
            this.container.show();
            return this;
        }
        hide() {
            this.container.hide();
            return this;
        }
    }
    class cUIInput extends cUIControll {
        create(selector) {
            this.input = $(selector);
            this.container = this.input.parent();
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
            this.container = $(selector);
            return this;
        }
        text(value) {
            var target = this.container.find('.text');
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
        static updateHiddensByArray(_container, name, datas) {
            var container = $(_container);
            container.empty();
            $.each(datas, function (index, value) {
                $('<input>').attr({
                    type: 'hidden',
                    name: name,
                    value: value
                }).appendTo(container);
            });
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
        static submit(action, method, options = null) {
            var form = $('<form>', {
                'action': action,
                'method': method,
                'accept-charset': 'UTF-8',
                'enctype': 'application/x-www-form-unlencoded',
            });
            $.each(options, function (name, value) {
                $('<input>', {
                    'type': 'hidden',
                    'name': name,
                    'value': value,
                }).appendTo(form);
            });
            $('body').append(form);
            form.submit();
        }
    }
    window.nnc('Admin', cAdmin);
});
