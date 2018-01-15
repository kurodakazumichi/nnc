"use strict";
$(function () {
    var gAdmin = window.nnc('Admin');
    class cInputTags {
        static create(id) {
            return new cInputTags(id);
        }
        constructor(id) {
            this.at = {
                wrapper: id,
                relatedContainer: id + "-related",
                relatedItem: id + "-related li",
                relatedNames: id + "-related li span",
                relatedDeletes: id + "-related li a",
                searchForm: id + "-search",
                listContainer: id + "-list",
                listItem: id + "-list li",
                inputContainer: id + "-input",
                inputItem: id + "-input input"
            };
            this.searchTimer = null;
            this.init();
        }
        init() {
            var me = this;
            $(document).on('click', this.at.relatedDeletes, function () {
                $(this).parent().remove();
                me.updateInputDatas();
            });
            $(document).on('click', this.at.listItem, function () {
                me.clickListItem($(this));
            });
            $(this.at.searchForm).on('keyup', function (e) {
                if (e.which == 116)
                    return;
                if (me.searchTimer) {
                    clearTimeout(me.searchTimer);
                }
                me.searchTimer = setTimeout(me.search.bind(me), 150);
            })
                .on('blur', function () {
                me.removeListItem();
            });
        }
        serialize() {
            var results = [];
            var items = $(this.at.relatedItem);
            for (var i = 0; i < items.length; ++i) {
                var id = items.eq(i).attr('data-id');
                results.push(id);
            }
            return results;
        }
        updateInputDatas() {
            $(this.at.inputItem).remove();
            var datas = this.serialize();
            for (var i = 0; i < datas.length; ++i) {
                $('<input>').attr({
                    type: 'hidden',
                    name: 'tags[_ids][]',
                    value: datas[i]
                }).appendTo(this.at.inputContainer);
            }
        }
        search() {
            var conf = gAdmin.ajaxConf('get', '/tags/search');
            conf.data = { name: $(this.at.searchForm).val() };
            conf.success = function (msg, status, response) {
                var json = JSON.parse(msg);
                if (json.status = "ok") {
                    this.createList(json.msg);
                }
            }.bind(this);
            $.ajax(conf);
        }
        createList(datas) {
            this.removeListItem();
            var container = $(this.at.listContainer);
            $.each(datas, function (key, val) {
                $(`<li>${val.name}(${val.count})</li>`)
                    .attr({
                    'data-id': val.id,
                    'data-name': val.name,
                })
                    .appendTo(container);
            }.bind(this));
        }
        removeListItem() {
            $(this.at.listItem).remove();
        }
        addRelatedTag(id, name) {
            $('<li>')
                .attr({ 'data-id': id, 'data-name': name })
                .append(`<span>${name}</span>`)
                .append('<a>✖</a>')
                .appendTo(this.at.relatedContainer);
            this.updateInputDatas();
        }
        addNewTag(name) {
            var conf = gAdmin.ajaxConf('post', '/tags/add');
            conf.data = { name: name.trim() };
            conf.success = function (data, status, responce) {
                data = JSON.parse(data);
                if (data.status = "ok") {
                    this.addRelatedTag(data.msg.id, data.msg.name);
                }
            }.bind(this);
            $.ajax(conf);
        }
        clickListItem(target) {
            var id = target.attr('data-id');
            var name = target.attr('data-name');
            if (0 <= id) {
                this.addRelatedTag(id, name);
            }
            else {
                this.addNewTag(name);
            }
        }
    }
    window.nnc("InputTags", cInputTags);
});
