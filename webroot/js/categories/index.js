$(function(){

  // カテゴリテーブル
  var cCategories = {
    create() {
      var obj = Object.create(cCategories.prototype);
      obj.table = null;
      obj.body  = null;
      obj.processing = false;
      return obj;
    },
    prototype: {
      /**
       * 汎用
       */
      ajaxError(msg) {
        alert(msg.statusText);
      },
      getRow(id){
        return $("#category-id-" + id);
      },
      /**
       * 初期化関連
       */
      init(id) {
        this.table = $(id);
        this.body  = this.table.find("tbody");
        this.initSort();
        this.initNames();
        this.initDeletes();
      },
      /**
       * ソート関連
       */
      initSort() {
        this.body.sortable({
          start :this.startSort.bind(this),
          stop  :this.stopSort.bind(this),
          update:this.updateSort.bind(this)
        });
      },
      startSort(event, ui) {
        ui.item.addClass("active");
      },
      stopSort(event, ui) {
        ui.item.removeClass("active");
      },
      updateSort(event, ui) {
        this.disableSort();

        var c = {};
        c.type = "put";
        c.url  = "/categories/reorder";
        c.data = this.serializeSort();
        c.success = function(msg) {
        }.bind(this);
        c.error = this.ajaxError.bind(this);
        c.complete = function() {
          this.enableSort();
        }.bind(this);

        $.ajax(c);
      },

      disableSort() {
        this.body.sortable("disable");
      },
      enableSort() {
        this.body.sortable("enable");
      },
      serializeSort() {
        return this.body.sortable("serialize");
      },

      /**
       * 削除関連
       */
      initDeletes() {
        var me = this;
        this.body.find(".icons li.delete").click(function(){
          me.clickDelete($(this).attr('data-id'), $(this));
        });
      },
      clickDelete(id, ui) {
        if(confirm('カテゴリを削除してよろしいですか？') == false) return;

        var row = this.getRow(id);
        this.disableSort();
        var c = {};
        c.type = "delete";
        c.url  = "/categories/delete/" + id;

        c.success = function() {
          row.remove();
        }.bind(this);

        c.error = this.ajaxError.bind(this);

        c.complete = function () {
          this.enableSort();
        }.bind(this);

        $.ajax(c);
      },

      /**
       * 名称変更関連
       */
      initNames() {
        var me = this;
        this.body.find(".name .ui-text").click(function(){
          me.clickTextOfName($(this).attr('data-id'), $(this));
        });
        this.body.find(".name .ui-input input")
          .focus(function(){
            me.focusInputOfName($(this).attr('data-id'), $(this));
          })
          .blur(function(){
            me.blurInputOfName($(this).attr('data-id'), $(this));
          });

      },
      clickTextOfName(id, ui) {
        if(this.processing) return;
        this.showInputOfName(ui, this.getRow(id).find(".name .ui-input"));
      },
      focusInputOfName(id, ui) {
        this.disableSort();
      },
      blurInputOfName(id, ui) {
        var row = this.getRow(id);
        var ui_text  = row.find(".name .ui-text");
        var ui_input = row.find(".name .ui-input");
        var ui_error = row.find(".name .ui-error");

        if(ui_text.text().trim() != ui.val().trim()) {
          this.blurChangeOfName(id, ui, ui_text, ui_input, ui_error);
        } else {
          this.blurFinalizeOfName(ui_text, ui_input, ui_error);
        }
      },

      blurChangeOfName(id, ui, text, input, error) {
        this.processing = true;

        var c = {};
        c.type = "put";
        c.url  = "/categories/edit/" + id;
        c.data = {name: ui.val().trim() };
        c.success = function(msg, status){
          msg = JSON.parse(msg);
          if(msg.status == "ok") {
            text.text(msg.msg);
            this.blurFinalizeOfName(text, input, error);
          } else {
            error.show().find("p").text(msg.msg);
            ui.focus();
          }
        }.bind(this);


        c.error = function(msg, status) {
          this.ajaxError(msg);
          text.show();
          input.hide();
        }.bind(this);

        $.ajax(c);
      },
      blurFinalizeOfName(text, input, error) {
        this.showTextOfName(text, input);
        error.hide();
        this.enableSort();
        this.processing = false;
      },
      showTextOfName(text, input) {
        text.show();
        input.hide();
      },
      showInputOfName(text, input) {
        text.hide();
        input.show().find('input').focus().val(text.text().trim());
      }


    }
  };

  var categories = cCategories.create();
  categories.init("#categories");


  // 新規登録処理
  (function(id){
    var name = $(id).find("input[name=name]");

    // set click event to add button.
    $(id).find("button").click(function(){

      var config = {
         type     : "post"
        ,url      : "/categories/add"
        ,data     : {name:name.val()}
        ,success  : function(msg, status, responce){
          msg = JSON.parse(msg);
          if(msg.status == "ok") {
            location.reload();
          } else {
            $("#error-new").text(msg.msg).parent().show();
          }
        }
      }
      $.ajax(config);
    });
  })("#new-category");



  // Hover states on the static widgets
  $( ".icons li" ).hover(
  	function() {
  		$( this ).addClass( "ui-state-active" );
  	},
  	function() {
  		$( this ).removeClass( "ui-state-active" );
  	}
  );

});
