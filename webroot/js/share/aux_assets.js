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
                .on('keyup', function () {
                me.onKeyupSearch();
            })
                .on('blur', function () {
                me.onBlurSearch();
            });
            $(document)
                .on('click', this.at.candidateItem, function () {
                me.onClickCandidateItem(this);
            });
            $(this.at.addButton).on('click', function () {
                me.onClickAddButton();
            });
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
        onKeyupSearch() {
            console.log("onKeyupSearch");
            if (this.searchTimer) {
                clearTimeout(this.searchTimer);
            }
            this.searchTimer = setTimeout(this.ajaxSearch.bind(this), 200);
        }
        onBlurSearch() {
            console.log("onBlurSearch");
        }
        onClickCandidateItem(_target) {
            var target = $(_target);
            var id = target.attr('data-id');
            var text = target.text().trim();
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
            console.log("removeRelated");
            $(this.at.relatedContainer).find(`[data-id=${id}]`).remove();
        }
        addRelated(id, text) {
            $(`<ul data-id="${id}"><li>${text}</li><li><a data-id="${id}">✖</a></li></ul>"`)
                .appendTo($(this.at.relatedContainer));
        }
        ajaxSearch() {
            console.log("ajaxSearch");
        }
        ajaxAdd(data) {
            console.log("ajaxAdd");
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
    }
    window.nnc("AuxAssets", cAuxAssets);
});
