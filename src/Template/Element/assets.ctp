<?php
use App\Model\Table\AssetsTableEx;

foreach($element['styles'] as $css) {
  echo $this->Html->css($css);
}

foreach($element['jscripts'] as $js) {
  echo $this->Html->script($js);
}

if(isset($element['assets']))
{
  foreach($element['assets'] as $asset)
  {
    $src = $asset['src'];

    switch($asset['kind']){
      case AssetsTableEx::KIND_JS  : echo $this->Html->script($src); break;
      case AssetsTableEx::KIND_CSS : echo $this->Html->css($src); break;
    }
  }
}
