<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface[]|\Cake\Collection\CollectionInterface $categories
 */

$this->Form->create($category);
?>


<div class="admin">
  <section>
      <h2>カテゴリ一覧</h2>
      <div id="categories2" class="sortable">
        <div class="thead">
          <ul>
            <li class="id" style="width:10%"><?= $this->Paginator->sort('id', 'ID') ?></li>
            <li class="order_no" style="width:10%"><?= $this->Paginator->sort('order_no', '表示順') ?></li>
            <li class="name" style="width:40%"><?= $this->Paginator->sort('name', '名称') ?></li>
            <li class="note_count" style="width:10%"><?= $this->Paginator->sort('note_count', 'ノート') ?></li>
            <li class="article_count" style="width:10%"><?= $this->Paginator->sort('article_count', '記事') ?></li>
            <li class="book_count" style="width:10%"><?= $this->Paginator->sort('book_count', '書籍') ?></li>
            <li class="actions" style="width:10%">&nbsp;</li>
          </ul>
        </div>
        <div class="tbody">
          <?php foreach ($categories as $category): ?>
            <ul id="category-id-<?= $category->id ?>">
              <?php /* Category.id */ ?>
              <li class="id" style="width:10%;">
                <?= $this->Number->format($category->id) ?>
              </li>
              <li class="id" style="width:10%;">
                <?= $this->Number->format($category->order_no) ?>
              </li>

              <?php /* Category.name */ ?>
              <li class="name" style="width:40%;">
                <div class="ui-error hide">
                  <p>Error</p>
                </div>
                <div class="ui-text editable" data-id="<?= $category->id ?>">
                  <?= h($category->name) ;?>
                </div>
                <div class="ui-input hide">
                  <?= $this->Form->control('name', ['label' => false, "data-id" => $category->id]); ?>
                </div>
              </li>

              <?php /* Category.note_count */ ?>
              <li class="note_count" style="width:10%;">
                <?= $category->note_count ?>
              </li>

              <?php /* Category.article_count */ ?>
              <li class="article_count" style="width:10%;">
                <?= $category->article_count ?>
              </li>

              <?php /* Category.book_count */ ?>
              <li class="book_count" style="width:10%;">
                <?= $category->book_count ?>
              </li>

              <?php /* Delete control */ ?>
              <li style="width:10%;">
                <?php if($category->note_count == 0 && $category->article_count == 0 && $category->book_count == 0): ?>
                  <ul class="icons ui-widget ui-helper-clearfix">
                    <li class="delete ui-state-default ui-corner-all" data-id="<?= $category->id ?>"><span class="ui-icon ui-icon-circle-close"></span></li>
                  </ul>
                <?php else: ?>
                  &nbsp;
                <?php endif; ?>
              </li>
            </ul>
          <?php endforeach; ?>
        </div>

      </div>

  </section>
  <section class="new-category">
    <h2>カテゴリ追加</h2>

    <div class="ui-error hide m0010">
      <p class="text" id="error-new">Error</p>
    </div>

    <table class="single">
      <tr id="new-category">
        <td><?= $this->Form->control('name', ['label' => false, 'autofocus']); ?></td>
        <td><button type="button" class="ui-button ui-corner-all ui-widget">登録</button></td>
      </tr>
    </table>
  </section>
</div>
