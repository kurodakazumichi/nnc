<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $this->fetch('title') ?>:Nekonecode
    </title>
    <?= $this->Html->meta('icon') ?>
    <?= $this->fetch('meta') ?>
    <?= $this->element("css_and_js"); ?>

    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>

</head>
<body ontouchstart="">
  <div id="wrapper">
    <header>
      <?= $this->element("breadcrumb"); ?>
      <nav>
        <ul style="display:flex; justify-content:space-around; margin:0; background:#E1DBC9;">
          <li><?= $this->Html->link("Categories", "/categories"); ?></li>
          <li><?= $this->Html->link("Sections", "/sections"); ?></li>
          <li><?= $this->Html->link("Tags", "/tags"); ?></li>
          <li><?= $this->Html->link("Modules", "/modules"); ?></li>
          <li><?= $this->Html->link("Assets", "/assets"); ?></li>
          <li><?= $this->Html->link("Notes", "/notes"); ?></li>
          <li><?= $this->Html->link("Articles", "/articles"); ?></li>
          <li><?= $this->Html->link("Books", "/books"); ?></li>
          <li><?= $this->Html->link("SectionNotes", "/sections-notes"); ?></li>
          <li><?= $this->Html->link("BookSections", "/books-sections"); ?></li>
          <li><?= $this->Html->link("ModuleAssets", "/modules-assets"); ?></li>
          <li><?= $this->Html->link("NoteModules", "/notes-modules"); ?></li>
          <li><?= $this->Html->link("NoteTags", "/notes-tags"); ?></li>
        </ul>
      </nav>
    </header>
    <main>
      <div class="contents">
        <?= $this->fetch('content') ?>
      </div>
      <div class="gadgets">
        <?= $this->fetch('gadgets') ?>
      </div>
    </main>
    <footer>
      ©Copyright Since 2017 Nekonecode All rights reserved.
    </footer>
</body>
<script type="text/javascript">
  <?= $this->fetch('postfixScripts') ?>
</script>

</html>
