"use strict";
$(function () {
    var nnc = window.nnc;
    var gUI = nnc('UI');
    var gAdmin = nnc('Admin');
    var gProcessing;
    class cNew {
        create() {
            this.section = $('.new-category');
            this.error = gUI.text(this.section.find('.ui-error'));
            this.name = gUI.input(this.section.find('input[name=name]'));
            this.button = $(this.section.find('button'));
            return this;
        }
        init() {
            this.button.on('click', this.submit.bind(this));
        }
        submit() {
            if (gProcessing)
                return false;
            var conf = gAdmin.ajaxConf('post', '/categories/add');
            conf.data = { name: this.name.val() };
            conf.success = function (msg, status, responce) {
                msg = JSON.parse(msg);
                if (msg.status == "ok") {
                    location.reload();
                }
                else {
                    this.error.text(msg.msg).show();
                }
            }.bind(this);
            $.ajax(conf);
        }
    }
    class cList {
        create() {
            this.table = $('#categories2');
            this.tbody = this.table.find('.tbody');
            return this;
        }
        init() {
            gUI.icons(".icons li");
            this.initSort();
            this.initDeletes();
            this.initNames();
        }
        getRow(id) {
            return $("#category-id-" + id);
        }
        initSort() {
            this.tbody.sortable({
                start: this.startSort.bind(this),
                stop: this.stopSort.bind(this),
                update: this.updateSort.bind(this)
            });
        }
        startSort(event, ui) {
            ui.item.addClass("active");
        }
        stopSort(event, ui) {
            ui.item.removeClass("active");
        }
        updateSort(event, ui) {
            var conf = gAdmin.ajaxConf('put', '/categories/reorder');
            conf.data = this.serializeSort();
            conf.success = function () {
                location.reload();
            };
            conf.complete = function () {
                this.enableSort();
            }.bind(this);
            this.disableSort();
            $.ajax(conf);
        }
        disableSort() {
            this.tbody.sortable("disable");
        }
        enableSort() {
            this.tbody.sortable("enable");
        }
        serializeSort() {
            return this.tbody.sortable("serialize");
        }
        initDeletes() {
            var me = this;
            this.tbody.find(".icons li.delete").click(function () {
                me.clickDelete($(this).attr('data-id'), $(this));
            });
        }
        clickDelete(id, ui) {
            if (confirm('カテゴリを削除してよろしいですか？') == false)
                return;
            var row = this.getRow(id);
            var conf = gAdmin.ajaxConf('delete', '/categories/delete/' + id);
            conf.success = function () {
                row.remove();
            }.bind(this);
            conf.complete = function () {
                this.enableSort();
            }.bind(this);
            this.disableSort();
            $.ajax(conf);
        }
        initNames() {
            var me = this;
            this.tbody.find(".name .ui-text").click(function () {
                me.clickTextOfName($(this).attr('data-id'), $(this));
            });
            this.tbody.find(".name .ui-input input")
                .focus(function () {
                me.focusInputOfName($(this).attr('data-id'), $(this));
            })
                .blur(function () {
                me.blurInputOfName($(this).attr('data-id'), $(this));
            });
        }
        clickTextOfName(id, ui) {
            if (gProcessing)
                return;
            this.showInputOfName(ui, this.getRow(id).find(".name .ui-input"));
        }
        focusInputOfName(id, ui) {
            this.disableSort();
        }
        blurInputOfName(id, ui) {
            var row = this.getRow(id);
            var ui_text = row.find(".name .ui-text");
            var ui_input = row.find(".name .ui-input");
            var ui_error = row.find(".name .ui-error");
            if (ui_text.text().trim() != ui.val().trim()) {
                this.blurChangeOfName(id, ui, ui_text, ui_input, ui_error);
            }
            else {
                this.blurFinalizeOfName(ui_text, ui_input, ui_error);
            }
        }
        blurChangeOfName(id, ui, text, input, error) {
            gProcessing = true;
            var conf = gAdmin.ajaxConf('pust', '/categories/edit/' + id);
            conf.data = { name: ui.val().trim() };
            conf.success = function (msg, status) {
                msg = JSON.parse(msg);
                if (msg.status == "ok") {
                    text.text(msg.msg);
                    this.blurFinalizeOfName(text, input, error);
                }
                else {
                    error.show().find("p").text(msg.msg);
                    ui.focus();
                }
            }.bind(this);
            conf.error = function (msg, status) {
                error.show().find("p").text(msg.statusText);
                text.show();
                input.hide();
            }.bind(this);
            $.ajax(conf);
        }
        blurFinalizeOfName(text, input, error) {
            this.showTextOfName(text, input);
            error.hide();
            this.enableSort();
            gProcessing = false;
        }
        showTextOfName(text, input) {
            text.show();
            input.hide();
        }
        showInputOfName(text, input) {
            text.hide();
            input.show().find('input').focus().val(text.text().trim());
        }
    }
    (new cNew).create().init();
    (new cList).create().init();
});
