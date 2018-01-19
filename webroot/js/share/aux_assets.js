"use strict";
$(function () {
    var gAdmin = window.nnc('Admin');
    var gUI = window.nnc('UI');
    class cAuxAssets {
        static create(id) {
            return new cAuxAssets(id);
        }
        constructor(id) {
            this.searchTimer = null;
            this.initAt(id);
            this.initEvents();
        }
        initAt(id) {
            this.at = {
                wrapper: id,
                error: id + "-error",
                relatedContainer: id + "-related",
                relatedDeletes: id + "-related li a",
                searchForm: id + "-search",
                candidateContainer: id + "-candidate",
                candidateItem: id + "-candidate li",
                addContainer: id + "-add",
                addItemKind: id + "-add-kind",
                addItemMemo: id + "-add-memo",
                addItemSrc: id + "-add-src",
                addButton: id + "-add button",
                inputContainer: id + "-input",
                inputItem: id + "-input input"
            };
        }
        initEvents() {
            var me = this;
            this.uiError = gUI.text(this.at.error);
            this.uiError.hide();
            $(this.at.relatedContainer)
                .sortable({
                start: this.onStartSortRelated.bind(this),
                stop: this.onStopSortRelated.bind(this),
                update: this.onUpdateSortRelated.bind(this)
            });
            $(document)
                .on('click', this.at.relatedDeletes, function () {
                me.onClickRelatedDelete(this);
            });
            $(this.at.searchForm)
                .on('keyup', function (e) {
                me.onKeyupSearch(e);
            });
            $(document)
                .on('click', this.at.candidateItem, function () {
                me.onClickCandidateItem(this);
            });
            $(this.at.addButton).on('click', function () {
                me.onClickAddButton();
            });
            this.updateInput();
        }
        onStartSortRelated(event, ui) {
            ui.item.addClass("active");
        }
        onStopSortRelated(event, ui) {
            ui.item.removeClass("active");
        }
        onUpdateSortRelated(event, ui) {
            this.updateInput();
        }
        onClickRelatedDelete(target) {
            this.removeRelated($(target).attr('data-id'));
            this.updateInput();
        }
        onKeyupSearch(e) {
            if (this.searchTimer) {
                clearTimeout(this.searchTimer);
            }
            this.searchTimer = setTimeout(this.ajaxSearch.bind(this), 200);
        }
        onClickCandidateItem(_target) {
            var target = $(_target);
            var id = target.attr('data-id');
            var text = target.attr('data-src');
            this.removeCandidate();
            this.addRelated(id, text);
            this.updateInput();
        }
        onClickAddButton() {
            var data = {
                kind: $(this.at.addItemKind).val(),
                memo: $(this.at.addItemMemo).val(),
                src: $(this.at.addItemSrc).val()
            };
            console.log(data);
            this.ajaxAdd(data);
        }
        removeRelated(id) {
            $(this.at.relatedContainer).find(`[data-id=${id}]`).remove();
        }
        addRelated(id, text) {
            $(`<ul data-id="${id}"><li>${text}</li><li><a data-id="${id}">✖</a></li></ul>"`)
                .appendTo($(this.at.relatedContainer));
        }
        ajaxSearch() {
            var conf = gAdmin.ajaxConf('get', '/ajaxs/asset');
            conf.data = { keyword: $(this.at.searchForm).val() };
            conf.usually = function (data) {
                this.updateCandidate(data);
            }.bind(this);
            gAdmin.ajax(conf);
        }
        ajaxAdd(data) {
            var conf = gAdmin.ajaxConf('post', '/ajaxs/asset');
            conf.data = data;
            conf.usually = function (data) {
                this.addRelated(data.id, data.src);
                this.updateInput();
            }.bind(this);
            conf.warning = function (data) {
                let text = "";
                $.each(data, function (name, errors) {
                    $.each(errors, function (type, error) {
                        text += `[${name}]${error}<br>`;
                    });
                });
                this.uiError.html(text).show();
            }.bind(this);
            gAdmin.ajax(conf);
        }
        serialize() {
            return $(this.at.relatedContainer).sortable("toArray", { attribute: 'data-id' });
        }
        updateInput() {
            gAdmin.updateHiddensByArray(this.at.inputContainer, "assets[_ids][]", this.serialize());
        }
        removeCandidate() {
            $(this.at.candidateContainer).empty();
        }
        updateCandidate(datas) {
            this.removeCandidate();
            var container = $(this.at.candidateContainer);
            $.each(datas, function (key, data) {
                $('<li>')
                    .attr({
                    'data-id': data.id,
                    'data-src': data.src,
                })
                    .text(`${data.src}\n(${data.memo})`)
                    .appendTo(container);
            }.bind(this));
        }
    }
    window.nnc("AuxAssets", cAuxAssets);
});
