<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface[]|\Cake\Collection\CollectionInterface $categories
 */

$this->Form->create($category);
?>


<div class="admin">
  <section>
      <h2 class="m0020">カテゴリ一覧</h2>
      <table id="categories" class="multi">
          <thead>
              <tr>
                  <th class="id"><?= $this->Paginator->sort('id', 'ID') ?></th>
                  <th class="id"><?= $this->Paginator->sort('order_no', '表示順') ?></th>
                  <th class="name"><?= $this->Paginator->sort('name', '名称') ?></th>
                  <th class="note_count"><?= $this->Paginator->sort('note_count', 'ノート') ?></th>
                  <th class="article_count"><?= $this->Paginator->sort('article_count', '記事') ?></th>
                  <th class="book_count"><?= $this->Paginator->sort('book_count', '書籍') ?></th>
                  <th class="actions">&nbsp;</th>
              </tr>
          </thead>
          <tbody>
              <?php foreach ($categories as $category): ?>
              <tr id="category-id-<?= $category->id ?>">
                  <?php /* Category.id */ ?>
                  <td class="id" style="width:7%;">
                    <?= $this->Number->format($category->id) ?>
                  </td>
                  <td class="id" style="width:10%;">
                    <?= $this->Number->format($category->order_no) ?>
                  </td>

                  <?php /* Category.name */ ?>
                  <td class="name" style="width:50%;">
                    <div class="ui-error hide">
                      <p>Error</p>
                    </div>
                    <div class="ui-text editable" data-id="<?= $category->id ?>">
                      <?= h($category->name) ;?>
                    </div>
                    <div class="ui-input hide">
                      <?= $this->Form->control('name', ['label' => false, "data-id" => $category->id]); ?>
                    </div>
                  </td>

                  <?php /* Category.note_count */ ?>
                  <td class="note_count" style="width:10%;">
                    <?= $category->note_count ?>
                  </td>

                  <?php /* Category.article_count */ ?>
                  <td class="article_count" style="width:10%;">
                    <?= $category->article_count ?>
                  </td>

                  <?php /* Category.book_count */ ?>
                  <td class="book_count" style="width:10%;">
                    <?= $category->book_count ?>
                  </td>

                  <?php /* Delete control */ ?>
                  <td>
                    <?php if($category->note_count == 0 && $category->article_count == 0 && $category->book_count == 0): ?>
                      <ul class="icons ui-widget ui-helper-clearfix">
                        <li class="delete ui-state-default ui-corner-all" data-id="<?= $category->id ?>"><span class="ui-icon ui-icon-circle-close"></span></li>
                      </ul>
                    <?php else: ?>
                      &nbsp;
                    <?php endif; ?>
                  </td>
              </tr>
              <?php endforeach; ?>
          </tbody>
      </table>
  </section>
  <section>
    <h2 class="m0020">カテゴリ追加</h2>

    <div class="error hide m0010">
      <p id="error-new">Error</p>
    </div>

    <table class="single">
      <tr id="new-category">
        <td><?= $this->Form->control('name', ['label' => false, 'autofocus']); ?></td>
        <td><button type="button" class="ui-button ui-corner-all ui-widget">登録</button></td>
      </tr>
    </table>
  </section>
</div>
