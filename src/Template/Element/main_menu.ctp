<?php
  // ちゃんねるデータを定義
  $data = [
    [
      "title" => "新着記事", "ch" => "1ch", "url" => "/1ch", "img" => "green",
      'desc' => 'IT系のあれこれを記事にまとめて掲載しています。'
    ],
    [
      "title" => "技術書",  "ch" => "2ch", "url" => "/2ch", "img" => "lime",
      "desc"  => "技術本形式で主にプログラムの情報をお届け。"
    ],
    [
      "title" => "教育", "ch" => "3ch", "url" => "/3ch", "img" => "blue",
      "desc"  => "プログラムを学んでみたい、そんな人におすすめ。"
    ],
    [
      "title" => "特訓", "ch" => "4ch", "url" => "/4ch", "img" => "pink",
      "desc"  => "スキルアップコンテンツを提供中。"
    ],
    [
      "title" => "日常", "ch" => "5ch", "url" => "/5ch", "img" => "red",
      "desc"  => "Nekonecodeの何気ない日常を綴っています。"
    ],
    [
      "title" => "スキル", "ch" => "6ch", "url" => "/6ch", "img" => "yellow",
      "desc"  => "管理人のスキルセットを掲載しています。"
    ],
    [
      "title" => "ゲーム", "ch" => "7ch", "url" => "/7ch", "img" => "purple",
      /*"desc"  => "ブラウザで遊べる色々なゲームを公開しています。"*/
      "desc" => "準備中"
    ],
    [
      "title" => "小技集", "ch" => "8ch", "url" => "/8ch", "img" => "orange",
      "desc"  => "細かいテクニック集"
    ]
  ];
?>
<?php if($mode == 1): ?>
  <nav class="ch">
    <ul>
      <?php foreach($data as $val): ?>
        <li><?= $this->Html->link($val['title'] . "(${val['ch']})", $val['url']); ?></li>
      <?php endforeach; ?>
    </ul>
  </nav>
<?php endif; ?>

<?php if($mode == 2): ?>
  <div class="container channels">
    <?php foreach($data as $val): ?>
      <div class="monitor">
        <?= $this->Html->image("pages/home/cat.${val['img']}.svg", ["alt" => $val["title"]]); ?>
        <div class="display">
            <?= $this->Html->link("<span class='tt'>${val['ch']}</span><span class='ut'>${val['desc']}</span>", $val['url'], ["escape" => false]); ?>
        </div>
        <div style="text-align:center; font-size:2em; margin-top:1.5em;">
          <b><?= $val['title'] ?></b>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

<?php endif;?>
