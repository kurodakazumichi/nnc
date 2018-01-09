<?php foreach($datas as $category_id => $notes): ?>
  <section class="m0020" style="box-shadow: 0 0 10px 0 rgba(0, 0,0, 0.2);">
    <h2 style="background:#ddd;"><?= $categories[$category_id] ?></h2>

    <?php foreach($notes as $note): ?>
      <div class="">
      <?= $this->Html->link($note->title, ['controller' => 'Notes', 'action' => 'note', $note->id]); ?>
      </div>
    <?php endforeach; ?>

    <?= $this->Html->link("もっと見る", ['controller' => 'Notes', 'action' => 'notes', $category_id]) ?>
  </section>

<?php endforeach; ?>
