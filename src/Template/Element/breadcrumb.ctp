<?php
//------------------------------------------------------------------------------
// パンくずリストエレメント
//
// How to Add Link.
// Use addCrumb method in AppController.
//
// [Syntax]
// addCrumb($title, $url)
//
// No Specific $url parametor then not create tag of anchor.
//------------------------------------------------------------------------------
// navとdivで構成されるようにテンプレートを設定。
$this->Breadcrumbs->templates([
  'wrapper' => "<nav{{attrs}}>{{content}}</nav>"
  ,'item' => '<div class="box"><a href="{{url}}"{{innerAttrs}}>{{title}}</a></div>'
  ,'itemWithoutLink' => '<div class="box"><h1>{{title}}</h1></div>'
  ,'separator' => ''
]);

// トップページはデフォルトで追加する。
$this->Breadcrumbs->add("Nekonecode", "/");

// 登録されているリンクを追加。
foreach($element['breadcrumbs'] as $v) {
  $this->Breadcrumbs->add($v['title'], $v['url']);
}
?>

<?=
  // パンくずリストを描画する。
  $this->Breadcrumbs->render(['class' => 'breadcrumb']);
?>
