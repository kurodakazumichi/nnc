<?php foreach($grouping as $id => $articles): ?>
  <section class="m0020" style="box-shadow: 0 0 10px 0 rgba(0, 0,0, 0.2);">
    <h2 style="background:#ddd;"><?= $categories[$id] ?></h2>

    <?php foreach($articles as $article): ?>
      <div class="">
      <?= $this->Html->link($article->note->title, "/1ch/view/$article->id"); ?>
      </div>
    <?php endforeach; ?>

    <?= $this->Html->link("もっと見る", "/1ch/$id") ?>
  </section>

<?php endforeach; ?>
