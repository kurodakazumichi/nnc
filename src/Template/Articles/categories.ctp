<?php foreach($grouping as $id => $articles): ?>
  <section>
    <h2><?= $categories[$id] ?></h2>
  </section>

  <?php foreach($articles as $article): ?>
    <?= $article->note->title ;?><br>
  <?php endforeach; ?>

<?php endforeach; ?>
