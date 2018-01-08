<?php
use App\Model\Table\AssetsTableEx;
?>
<?php if(isset($element['assets'])): ?>
  <?php
  foreach($element['assets'] as $asset)
  {
    $src = $asset['src'];

    switch($asset['kind']){
      case AssetsTableEx::KIND_JS  : echo $this->Html->script($src); break;
      case AssetsTableEx::KIND_CSS : echo $this->Html->css($src); break;
    }
  }
  ?>
<?php endif; ?>
