"use strict";
$(function () {
    class cAdmin {
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
