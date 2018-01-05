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


?>

<?= $this->element('main_menu', ['mode' => 2]); ?>

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
