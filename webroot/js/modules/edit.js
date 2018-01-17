"use strict";
$(function () {
    var gAdmin = window.nnc('Admin');
    class cView {
        create() {
            this.at = {
                myform: '#myform',
                inputPreScript: '#myform input[name=prefix_script]',
                inputPosScript: '#myform input[name=postfix_script]',
                btnSubmit: '#btn-submit',
                btnDelete: '#btn-delete',
            };
            this.editors = {};
            this.editors.pre = gAdmin.aceEditor('prefix-script-editor', 'js');
            this.editors.pos = gAdmin.aceEditor('postfix-script-editor', 'js');
            this.init();
            return this;
        }
        init() {
            var me = this;
            $(this.at.btnSubmit).on('click', function () {
                me.onclickBtnSubmit(this);
            });
            $(this.at.btnDelete).on('click', function () {
                me.onclickBtnDelete(this);
            });
        }
        onclickBtnSubmit(btn) {
            $(this.at.inputPreScript).val(this.editors.pre.getValue());
            $(this.at.inputPosScript).val(this.editors.pos.getValue());
            $(this.at.myform).submit();
        }
        onclickBtnDelete(btn) {
            if (!confirm('本当に削除してよろしいですか？'))
                return;
            var id = $(btn).attr('data-id');
            gAdmin.submit(`/modules/delete/${id}`, "post");
        }
    }
    window.nnc("View", new cView);
});
