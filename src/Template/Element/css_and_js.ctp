<?php
foreach($styles as $css) {
  echo $this->Html->css($css);
}

foreach($jscripts as $js) {
  echo $this->Html->script($js);
}
