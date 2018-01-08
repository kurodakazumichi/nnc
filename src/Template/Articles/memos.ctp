<?php foreach($datas as $category_id => $articles): ?>
  <section class="m0020" style="box-shadow: 0 0 10px 0 rgba(0, 0,0, 0.2);">
    <h2 style="background:#ddd;"><?= $categories[$category_id] ?></h2>

    <?php foreach($articles as $article): ?>
      <div class="">
      <?= $this->Html->link($article->note->title, ['controller' => 'Articles', 'action' => 'memo', $article->id]); ?>
      </div>
    <?php endforeach; ?>

    <?= $this->Html->link("もっと見る", ['controller' => 'Articles', 'action' => 'memos', $category_id]) ?>
  </section>

<?php endforeach; ?>
