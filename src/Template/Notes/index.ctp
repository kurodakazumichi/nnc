<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface[]|\Cake\Collection\CollectionInterface $notes
 */
$this->start("gadgets");
echo $this->element("gadget/related_menu");
$this->end();
?>
<div class="admin">

  <section>
      <h2 class="m0020"><?= __('Notes') ?></h3>
      <table class="multi" style="font-size:0.5em;" cellpadding="0" cellspacing="0">
          <thead>
              <tr>
                  <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                  <th scope="col"><?= $this->Paginator->sort('memo') ?></th>
                  <th scope="col"><?= $this->Paginator->sort('title') ?></th>
                  <th scope="col"><?= $this->Paginator->sort('search_word') ?></th>
                  <th scope="col"><?= $this->Paginator->sort('description') ?></th>
                  <th scope="col"><?= $this->Paginator->sort('category_id') ?></th>
                  <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                  <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                  <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                  <th scope="col" class="actions"><?= __('Actions') ?></th>
              </tr>
          </thead>
          <tbody>
              <?php foreach ($notes as $note): ?>
              <tr>
                  <td><?= $this->Number->format($note->id) ?></td>
                  <td><?= h($note->memo) ?></td>
                  <td><?= h($note->title) ?></td>
                  <td><?= h($note->search_word) ?></td>
                  <td><?= h($note->description) ?></td>
                  <td><?= $note->has('category') ? $this->Html->link($note->category->name, ['controller' => 'Categories', 'action' => 'view', $note->category->id]) : '' ?></td>
                  <td><?= h($note->status) ?></td>
                  <td><?= h($note->created) ?></td>
                  <td><?= h($note->modified) ?></td>
                  <td class="actions">
                      <?= $this->Html->link(__('View'), ['action' => 'view', $note->id]) ?>
                      <?= $this->Html->link(__('Edit'), ['action' => 'edit', $note->id]) ?>
                      <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $note->id], ['confirm' => __('Are you sure you want to delete # {0}?', $note->id)]) ?>
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
