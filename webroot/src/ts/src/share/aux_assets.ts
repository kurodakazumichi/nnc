/*******************************************************************************
* aux_assets.ts
*
* @依存外部ライブラリ
* jQuery,jQueryUI
*
* @依存自作ライブラリ
* NNC,cAdmin,cUI
*
* @機能概要
* 既存のアセットを検索し、候補を表示、モジュールへの割り当てを行う。
* アセットを新規登録しつつ、モジュールへの割り当てを行う。
* 割り当てられているアセットの削除やロード順の変更。
*
* @At
* #{id}                             : 全体
* #{id}-error                       : エラーテキスト
* #{id}-related                     : 関連アセットコンテナ
* #{id}-related ul                  : 関連アセットアイテム
* #{id}-related ul li a             : 関連アセット削除ボタン
* #{id}-search                      : 検索フォーム
* #{id}-candidate                   : アセット候補コンテナ
* #{id}-candidate li                : アセット候補アイテム
* #{id}-add                         : 新規登録コンテナ
* #{id}-add select[name={id}-kind]  : アセット種類選択肢
* #{id}-add input[name={id}-memo]   : アセットメモ入力欄
* #{id}-add input[name={id}-src]    : アセットパス入力欄
* #{id}-add button                  : 登録ボタン
* #{id}-input                       : 関連アセットのポストデータコンテナ
*
* @Event Functions
* onStartSortRelated   : 関連アセットのソートが開始された
* onStopSortRelated    : 関連アセットのソートが停止した
* onUpdateSortRelated  : 関連アセットの並びが更新された
* onClickRelatedDelete : 関連アセットの削除ボタンが押された
* onKeyupSearch        : 検索入力でキーが押された
* onBlurSearch         : 検索入力からフォーカスが外れた
* onClickCandidateItem : アセット候補がクリックされた
* onClickAddButton     : アセット登録ボタンが押された
*
* @General Functions
* removeRelated         : 関連アセットの削除
* addRelated            : 関連アセットを追加。
* ajaxSearch            : Ajaxによる検索
* ajaxAdd               : Ajaxによる新規アセット登録
* serialize             : 関連アセットIDを配列にシリアライズする
* updateInput           : ポストデータを更新する
* removeCandidate       : 候補を削除する。
*
*******************************************************************************/
$(function(){

  //============================================================================
  // 関数スコープ変数
  //============================================================================
  var gAdmin = (<any>window).nnc('Admin');
  var gUI    = (<any>window).nnc('UI');

  /*****************************************************************************
  * タグ入力フォームの処理クラス
  *****************************************************************************/
  class cAuxAssets
  {
    //==========================================================================
    // 静的メソッド
    //==========================================================================

    //--------------------------------------------------------------------------
    // 生成
    static create(id:string): cAuxAssets
    {
      return new cAuxAssets(id);
    }

    //==========================================================================
    // メンバ
    //==========================================================================

    // DOM指定子
    private at: any;

    // UI error
    private uiError: any;

    // 検索タイマー(Ajaxの通信が走りすぎないための対策)
    private searchTimer: any;

    //==========================================================================
    // メソッド
    //==========================================================================

    //--------------------------------------------------------------------------
    // コンストラクタ
    constructor(id: any)
    {
      this.searchTimer = null;
      this.initAt(id);
      this.initEvents();
    }

    //--------------------------------------------------------------------------
    // DOM指定子を初期化
    private initAt(id:string)
    {
      // HTML Elementアクセス子
      this.at = {
        wrapper               : id,
        error                 : id+"-error",
        relatedContainer      : id+"-related",
        relatedDeletes        : id+"-related li a",
        searchForm            : id+"-search",
        candidateContainer    : id+"-candidate",
        candidateItem         : id+"-candidate li",
        addContainer          : id+"-add",
        addItemKind           : id+"-add-kind",
        addItemMemo           : id+"-add-memo",
        addItemSrc            : id+"-add-src",
        addButton             : id+"-add button",
        inputContainer        : id+"-input",
        inputItem             : id+"-input input"
      };
    }

    //--------------------------------------------------------------------------
    // 初期化、各種DOMの制御、イベント割り当て
    private initEvents():void
    {
      var me = this;

      // エラーを非表示
      this.uiError = gUI.text(this.at.error);
      this.uiError.hide();

      // 関連アセットコンテナ
      $(this.at.relatedContainer)
        .sortable({
          start :this.onStartSortRelated.bind(this),
          stop  :this.onStopSortRelated.bind(this),
          update:this.onUpdateSortRelated.bind(this)
        });

      // 関連アセット削除ボタン(動的要素)
      $(document)
        .on('click', this.at.relatedDeletes, function(){
          me.onClickRelatedDelete(this);
        });

      // 検索フォーム
      $(this.at.searchForm)
        .on('keyup', function(){
          me.onKeyupSearch();
        })
        .on('blur', function(){
          me.onBlurSearch();
        });

      // アセット候補
      $(document)
        .on('click', this.at.candidateItem, function(){
          me.onClickCandidateItem(this);
        });

      // 新規登録ボタン
      $(this.at.addButton).on('click', function(){
        me.onClickAddButton();
      });
    }

    //==========================================================================
    // @Event Functions

    //--------------------------------------------------------------------------
    // 関連アセットのソートが開始された
    private onStartSortRelated(event, ui)
    {
      // ソート行のスタイルをアクティブにする。
      ui.item.addClass("active");
    }

    //--------------------------------------------------------------------------
    // 関連アセットのソートが停止した
    private onStopSortRelated(event, ui)
    {
      // ソート行のスタイルを非アクティブにする。
      ui.item.removeClass("active");
    }

    //--------------------------------------------------------------------------
    // 関連アセットの並びが更新された
    private onUpdateSortRelated(event, ui)
    {
      // 関連アセットの内容をもとにinput要素を更新する。
      this.updateInput();
    }

    //--------------------------------------------------------------------------
    // 関連アセットの削除ボタンが押された
    private onClickRelatedDelete(target){
      this.removeRelated($(target).attr('data-id'));
      this.updateInput();
    }

    //--------------------------------------------------------------------------
    // 検索入力でキーが押された
    private onKeyupSearch(){
      console.log("onKeyupSearch");
      if(this.searchTimer) {
        clearTimeout(this.searchTimer);
      }
      this.searchTimer = setTimeout(this.ajaxSearch.bind(this), 200);
    }

    //--------------------------------------------------------------------------
    // 検索入力からフォーカスが外れた
    private onBlurSearch (){
      console.log("onBlurSearch");
    }

    //--------------------------------------------------------------------------
    // アセット候補がクリックされた
    private onClickCandidateItem (_target)
    {
      var target = $(_target);
      var id = target.attr('data-id');
      var text = target.text().trim();
      this.addRelated(id, text);
      this.updateInput();
    }

    //--------------------------------------------------------------------------
    // アセット登録ボタンが押された
    private onClickAddButton(){

      var data = {
        kind: $(this.at.addItemKind).val(),
        memo: $(this.at.addItemMemo).val(),
        src : $(this.at.addItemSrc).val()
      };

      console.log(data);

      this.ajaxAdd(data);
    }

    //==========================================================================
    // @General Functions

    // 関連アセットの削除
    private removeRelated(id)
    {
      console.log("removeRelated");
      $(this.at.relatedContainer).find(`[data-id=${id}]`).remove();
    }

    //--------------------------------------------------------------------------
    // 関連アセットを追加。
    private addRelated(id, text)
    {
      $(`<ul data-id="${id}"><li>${text}</li><li><a data-id="${id}">✖</a></li></ul>"`)
        .appendTo($(this.at.relatedContainer));
    }

    //--------------------------------------------------------------------------
    // Ajaxによる検索
    private ajaxSearch(){
      console.log("ajaxSearch");
    }

    //--------------------------------------------------------------------------
    // Ajaxによる新規アセット登録
    private ajaxAdd(data){
      console.log("ajaxAdd");
    }

    //--------------------------------------------------------------------------
    // 関連アセットIDを配列にシリアライズする
    private serialize(){
      return $(this.at.relatedContainer).sortable("toArray", {attribute: 'data-id'});
    }

    //--------------------------------------------------------------------------
    // ポストデータを更新する
    private updateInput()
    {
      gAdmin.updateHiddensByArray(
        this.at.inputContainer,
        "assets[_ids][]",
        this.serialize()
      );
    }

    // 候補を削除する。
    private removeCandidate(){
      $(this.at.candidateContainer).empty();
    }
  }

  // 登録
  (<any>window).nnc("AuxAssets", cAuxAssets);

});
