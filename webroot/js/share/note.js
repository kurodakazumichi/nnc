"use strict";
$(function () {
    class cNote {
        static create(selector) {
            return new cNote(selector);
        }
        constructor(selector) {
            this.folder = $(selector);
            this.markdown = this.folder.html();
            this.markdown = this.markdown.replace(/&gt;/g, '>');
            this.init();
        }
        setMarkdown(text) {
            this.markdown = text;
            return this;
        }
        init() {
            var r = new marked.Renderer();
            r.heading = function (text, level) {
                level += 1;
                level = Math.max(2, level);
                return `<h${level}>${text}</h${level}>`;
            };
            r.link = function (href, title, text) {
                return `<a href=${href} target="_blank">${text}</a>`;
            };
            marked.setOptions({
                gfm: false,
                renderer: r,
            });
        }
        draw() {
            var text = marked(this.markdown);
            this.folder.html(text).find("h2, h3, h4, h5, h6").each(function () {
                var block = $(this);
                block.nextUntil(block.prop("tagName")).addBack().wrapAll("<section></section>");
            });
            this.folder.show();
        }
    }
    window.nnc("Note", cNote);
});
