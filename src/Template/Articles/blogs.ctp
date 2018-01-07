<?php foreach($grouping as $id => $articles): ?>
  <section>
    <h2><?= $categories[$id] ?></h2>
  </section>

  <?php foreach($articles as $article): ?>
    <?= $this->Html->link($article->note->title, "/5ch/view/$article->id") ?>
  <?php endforeach; ?>

  <?= $this->Html->link("もっと見る", "/5ch/$id") ?>

<?php endforeach; ?>
