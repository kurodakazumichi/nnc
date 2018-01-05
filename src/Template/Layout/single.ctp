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
        Nekonecode:
        <?= $this->fetch('title') ?>
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
      <?= $this->element("main_menu", ["mode" => 1]) ?>
      <?= $this->element("admin_menu"); ?>
    </header>
    <main>
        <?= $this->fetch('content') ?>
    </main>
    <footer>
      ©Copyright Since 2017 Nekonecode All rights reserved<a href="/users/login" style="text-decoration:none; cursor:none; color:white;">.</a>
    </footer>
</body>
</html>