<?php
foreach($element['styles'] as $css) {
  echo $this->Html->css($css);
}

foreach($element['jscripts'] as $js) {
  echo $this->Html->script($js);
}
