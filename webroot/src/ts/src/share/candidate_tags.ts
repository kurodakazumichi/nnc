/*******************************************************************************
* candidate_tags.js
* ノートにタグを関連付ける入力補助ツールの処理を記述。
* 関連タグの表示、及び削除。
* 新規タグの登録、及びノートへの関連付け。
*/
$(function(){

  var gAdmin = (<any>window).nnc('Admin');

  /*****************************************************************************
  * タグ入力フォームの処理クラス
  *****************************************************************************/
  class cInputTags
  {
    //--------------------------------------------------------------------------
    // 生成
    static create(id:string): cInputTags
    {
      return new cInputTags(id);
    }

    // 各種セレクター
    private at: any;

    // 検索タイマー(Ajaxの通信が走りすぎないための対策)
    private searchTimer: any;

    //--------------------------------------------------------------------------
    // 生成
    constructor(id: any)
    {
      // HTML Elementアクセス子
      this.at = {
        wrapper          : id,
        relatedContainer : id+"-related",
        relatedItem      : id+"-related li",
        relatedNames     : id+"-related li span",
        relatedDeletes   : id+"-related li a",
        searchForm       : id+"-search",
        listContainer    : id+"-list",
        listItem         : id+"-list li",
        inputContainer   : id+"-input",
        inputItem        : id+"-input input"
      };

      this.searchTimer = null;
      this.init();
    }

    //--------------------------------------------------------------------------
    // 初期化、各種DOMへのイベント割り当て
    private init():void
    {
      var me = this;

      // 関連タグの削除ボタンイベントを設定。
      $(document).on('click', this.at.relatedDeletes, function(){
        $(this).parent().remove();
        me.updateInputDatas();
      });

      // 検索結果要素の選択イベントを設定。
      $(document).on('click', this.at.listItem, function(){
        me.clickListItem($(this));
      });


      // 検索フォームのイベントを設定(最後の入力から一定時間待ちをいれる)
      $(this.at.searchForm).on('keyup', function(e)
      {
        //  F5キーが押された場合は無視。(ブラウザの更新と競合するため)
        if(e.which == 116) return;

        // タイマーが存在したらいったん解除
        if(me.searchTimer) {
          clearTimeout(me.searchTimer);
        }

        // 500ms後に検索を開始
        me.searchTimer = setTimeout(me.search.bind(me), 150);
      })
      .on('blur', function(){
        me.removeListItem();
      });
    }

    //--------------------------------------------------------------------------
    // 現在関連付けされているタグのIDリストを生成する。
    private serialize()
    {
      var results:any = [];

      // 関連タグIDリストを生成
      var items = $(this.at.relatedItem);

      for(var i = 0; i < items.length; ++i) {
        var id = items.eq(i).attr('data-id');
        results.push(id);
      }

      return results;
    }

    //--------------------------------------------------------------------------
    // 送信データを更新する。
    // 関連付けされているタグIDを送信するための隠しinput要素を生成。
    private updateInputDatas(): void
    {
      // いったんinput要素を全て削除。
      $(this.at.inputItem).remove();

      // 関連タグIDの数だけinput要素を生成。
      var datas = this.serialize();
      for(var i = 0; i < datas.length; ++i)
      {
        // <input type="hidden" name="tags[_ids][]" value="{tag_id}">
        $('<input>').attr({
          type : 'hidden',
          name : 'tags[_ids][]',
          value: datas[i]
        }).appendTo(this.at.inputContainer);
      }
    }

    //--------------------------------------------------------------------------
    // 検索処理(Ajax)
    private search(): void
    {
      // Ajax準備
      var conf:any = gAdmin.ajaxConf('get', '/tags/search');
      conf.data = {name: $(this.at.searchForm).val()};

      // 成功時の処理
      conf.success = function(this:cInputTags, msg, status, response)
      {
        var json = JSON.parse(msg);
        if(json.status = "ok") {
          this.createList(json.msg);
        }
      }.bind(this);

      // Ajax開始
      $.ajax(conf);
    }

    //--------------------------------------------------------------------------
    // 検索結果からリストを生成する。
    private createList(datas:any)
    {
      // 既にあるリストアイテムを削除。
      this.removeListItem();

      // リストアイテムを格納するコンテナ要素
      var container = $(this.at.listContainer);

      // タグのリストアイテムを生成する。
      $.each(datas, function(key, val)
      {
        $(`<li>${val.name}(${val.count})</li>`)
          .attr({
            'data-id'  : val.id,
            'data-name': val.name,
          })
          .appendTo(container);
      }.bind(this));
    }

    //--------------------------------------------------------------------------
    // リストアイテムを削除する。
    private removeListItem(): void
    {
      $(this.at.listItem).remove();
    }

    //--------------------------------------------------------------------------
    // 選択されたタグを関連タグとして追加する。
    private addRelatedTag(id, name):void
    {
      $('<li>')
        .attr({'data-id' : id, 'data-name' : name})
        .append(`<span>${name}</span>`)
        .append('<a>✖</a>')
        .appendTo(this.at.relatedContainer);

      this.updateInputDatas();
    }

    //--------------------------------------------------------------------------
    // 新たにタグを登録したうえで関連
    private addNewTag(name): void
    {
      // Ajax準備
      var conf:any = gAdmin.ajaxConf('post', '/tags/add');
      conf.data = {name: name.trim()};

      // 成功時の処理
      conf.success = function(this: cInputTags, data, status, responce)
      {
        data = JSON.parse(data);
        if(data.status = "ok") {
          this.addRelatedTag(data.msg.id, data.msg.name);
        }
      }.bind(this);

      // Ajax開始
      $.ajax(conf);
    }

    //--------------------------------------------------------------------------
    // タグアイテムをクリックしたときの処理
    private clickListItem(target): void
    {
      var id   = target.attr('data-id');
      var name = target.attr('data-name');

      if(0 <= id) {
        this.addRelatedTag(id, name);
      } else {
        this.addNewTag(name);
      }
    }
  }

  // 登録
  (<any>window).nnc("InputTags", cInputTags);

});
