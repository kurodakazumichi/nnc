<?php foreach($grouping as $id => $articles): ?>
  <section>
    <h2><?= $categories[$id] ?></h2>
  </section>

  <?php foreach($articles as $article): ?>
    <?= $this->Html->link($article->note->title, ['controller' => 'articles', 'action' => 'display', $article->id]); ?>
  <?php endforeach; ?>

  <?= $this->Html->link("もっと見る", ['controller' => 'articles', 'action' => 'articles', $id]) ?>

<?php endforeach; ?>
