<?php if($element['relatedLinks']): ?>
<div class="gadget">
  <div class="header">
    関連メニュー
  </div>
  <div class="body">
    <ul class="side-nav">
      <?php foreach($element['relatedLinks'] as $link): ?>
        <li><?= $this->Html->link($link[0], $link[1]) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
</div>
<?php endif; ?>
