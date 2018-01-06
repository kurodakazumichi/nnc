<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface[]|\Cake\Collection\CollectionInterface $notes
 */
?>
<div class="admin">

  <section>
      <h2 class="m0020"><?= __('Notes') ?></h3>
      <table class="multi" style="font-size:0.6em;" cellpadding="0" cellspacing="0">
          <thead>
              <tr>
                  <th style="width:2em;" scope="col"><?= $this->Paginator->sort('id', 'ID') ?></th>
                  <th scope="col">
                    <?= $this->Paginator->sort('title', 'タイトル') ?> / <?= $this->Paginator->sort('memo', 'メモ') ?>
                  </th>
                  <th style="width:10em;" scope="col"><?= $this->Paginator->sort('category_id', 'カテゴリ') ?></th>
                  <th style="width:4em;" scope="col"><?= $this->Paginator->sort('status', '状態') ?></th>
                  <th style="width:10em;" scope="col"><?= $this->Paginator->sort('modified', '更新日') ?></th>
                  <th style="width:5em;" scope="col" class="actions">&nbsp;</th>
              </tr>
          </thead>
          <tbody>
              <?php foreach ($notes as $note): ?>
              <tr>
                  <td><?= $this->Number->format($note->id) ?></td>
                  <td>
                    <?= h($note->title) ?><br>
                    (<?= h($note->memo) ?>)
                  </td>

                  <td><?= $note->has('category') ? $note->category->name : '' ?></td>
                  <td><?= h($statuses[$note->status]) ?></td>
                  <td><?= h($note->modified) ?></td>
                  <td class="actions">
                    <ul class="icons ui-widget ui-helper-clearfix">
                      <li class="delete ui-state-default ui-corner-all" onclick="location.href='/notes/view/<?= $note->id ?>';"><span class="ui-icon ui-icon-circle-arrow-e"></span></li>
                      <li class="delete ui-state-default ui-corner-all" onclick="location.href='/notes/edit/<?= $note->id ?>';"><span class="ui-icon ui-icon-document"></span></li>
                    </ul>
                  </td>
              </tr>
              <?php endforeach; ?>
          </tbody>
      </table>
      <div class="paginator">
          <ul class="pagination">
              <?= $this->Paginator->first('<< ' . __('first')) ?>
              <?= $this->Paginator->prev('< ' . __('previous')) ?>
              <?= $this->Paginator->numbers() ?>
              <?= $this->Paginator->next(__('next') . ' >') ?>
              <?= $this->Paginator->last(__('last') . ' >>') ?>
          </ul>
          <p><?= $this->Paginator->counter(['format' => __('{{page}} / {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
      </div>
  </section>
</div>
