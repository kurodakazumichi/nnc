<?php
/*******************************************************************************
* aux_assets.ctp(アセット入力支援)
*
* @引数
* $assets: 関連づいているAssetsの配列
* $kinds : アセットの種類リスト
*******************************************************************************/
?>

<? /************************************************************************/ ?>
<?php $this->append('assets'); ?>
<?= $this->Html->css('share/aux_assets') ?>
<?= $this->Html->script('share/aux_assets') ?>
<?php $this->end(); ?>

<? /************************************************************************/ ?>
<?php $this->append("postfixScripts"); ?>
<script type="text/javascript">
$(function(){ nnc("AuxAssets").create('#aux-assets'); });
</script>
<?php $this->end(); ?>

<? /************************************************************************/ ?>
<div id="aux-assets" class="input">

  <div id="aux-assets-error" class="ui-error">
    <p class="text">Error</p>
  </div>

  <div class="flex">
    <div class="children p1111">
      <b>Related</b>
      <div class="sortable">
        <div id="aux-assets-related" class="tbody">
          <?php foreach($assets as $asset): ?>
            <ul data-id="<?= $asset->id ?>">
              <li style="width:100%"><span><?= $asset->src ?></span></li>
              <li><a data-id="<?= $asset->id ?>">✖</a></li>
            </ul>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
    <div class="children p1111">
      <b>Search</b>
      <input type="text" id="aux-assets-search">
      <ul id="aux-assets-candidate">
        <li data-id="4">/vender/hoge.css</li>
        <li data-id="5">/vender/hoge.js</li>
      </ul>
    </div>
  </div>
  <table id="aux-assets-add">
    <tr>
      <th><label>kind</label></th><th><label>memo</label></th><th><label>src</label></th><th>&nbsp;</th>
    </tr>
    <tr>
      <td>
        <select id="aux-assets-add-kind">
          <?php foreach($kinds as $id => $name): ?>
            <option value="<?= $id ?>"><?= $name ?></option>
          <?php endforeach; ?>
        </select>
      </td>
      <td><input type="text" id="aux-assets-add-memo"></td>
      <td><input type="text" id="aux-assets-add-src"></td>
      <td><button class="nnc green" type="button">登録</button></td>
    </tr>
  </table>

  <div id="aux-assets-input"></div>
</div>
