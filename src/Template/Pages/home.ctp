<?php
/**
 * TOPページ
 */
// ページタイトルを設定
$this->assign("title", "Home");

// cssブロックを作成する。
$this->start('css');
echo $this->Html->css('pages/home.css');
$this->end();

// ちゃんねるデータを定義
$data = [
   ["title" => "IT記事", "ch" => "1ch", "url" => "/", "img" => "green"]
  ,["title" => "本棚",  "ch" => "2ch", "url" => "/", "img" => "lime"]
  ,["title" => "レッスン", "ch" => "3ch", "url" => "/", "img" => "blue"]
  ,["title" => "日常", "ch" => "4ch", "url" => "/", "img" => "red"]
  ,["title" => "ステータス", "ch" => "5ch", "url" => "/", "img" => "pink"]
  ,["title" => "スキル", "ch" => "6ch", "url" => "/", "img" => "yellow"]
  ,["title" => "ゲーム", "ch" => "7ch", "url" => "/", "img" => "purple"]
  ,["title" => "問合せ", "ch" => "8ch", "url" => "/", "img" => "orange"]
];
?>

<div class="container channels">
  <?php foreach($data as $val): ?>
    <div class="monitor">
      <?= $this->Html->image("pages/home/cat.${val['img']}.svg", ["alt" => $val["title"]]); ?>
      <div class="display">
          <?= $this->Html->link("<span class='tt'>${val['ch']}</span><span class='ut'>${val['title']}</span>", [], ["escape" => false]); ?>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<div class="container misc">

  <section>
    <h2 class="profile">プロフィール</h2>
    <div class="p0101">
      <table class="d1" style="margin-bottom:1em;">
        <tr>
          <th><div>屋号</div></th>
          <td>：</td>
          <td>Nekonecode(ねこねこーど)</td>
        </tr>
        <tr>
          <th><div>代表者</div></th>
          <td>：</td>
          <td>黒田　一道</td>
        </tr>
      </table>

      <p>
        関東圏で活動するフリープログラマー。<br>
        WEB、ゲーム、業務系の開発と教育の経験を経て独立。<br>
        現在はゲームの面白さとWEBの利便性を活かした教育分野での活動を目指して奮闘中。<br>
      </p>
    </div>
  </section>
  <section>
    <h2 class="recent">近況</h2>
    <div class="p0101">
      <ul class="d1">
        <li>オンライン講師始めました。</li>
        <li>HTMLメールの作成依頼対応</li>
        <li>埼玉のとある企業様にて、業務システムのリプレイスをサポート。</li>
        <li>イベント用システム開発やLPサイトの構築</li>
      </ul>
    </div>
  </section>
  <section>
    <h2 class="history">沿革</h2>
    <div class="p0101">
      <table class="d1">
        <tr>
          <th style="width:4em;"><div>2007年</div></td>
          <td>：</td>
          <td>サン・コスモス株式会社</td>
        </tr>
        <tr>
          <th><div>2012年</div></th>
          <td>：</td>
          <td>株式会社スーパーソフトウェア</td>
        </tr>
        <tr>
          <th><div>2013年</div></th>
          <td>：</td>
          <td>プログラミング講師</td>
        </tr>
        <tr>
          <th><div>2014年</div></th>
          <td>：</td>
          <td>株式会社カプコン</td>
        </tr>
        <tr>
          <th><div>2017年</div></th>
          <td>：</td>
          <td>Nekonecodeを開業</td>
        </tr>
      </table>
    </div>
  </section>
</div>
