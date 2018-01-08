<?php
/**
* @var \App\View\AppView $this
* @var \Cake\Datasource\EntityInterface[]|\Cake\Collection\CollectionInterface $assets
*/
?>
<div class="admin">
  <section>
    <h2 class="m0020"><?= __('Assets') ?></h2>
    <table class="multi" cellpadding="0" cellspacing="0">
      <thead>
        <tr>
          <th scope="col"><?= $this->Paginator->sort('id') ?></th>
          <th scope="col"><?= $this->Paginator->sort('kind') ?></th>
          <th scope="col"><?= $this->Paginator->sort('memo') ?></th>
          <th scope="col"><?= $this->Paginator->sort('src') ?></th>
          <th scope="col" class="actions"><?= __('Actions') ?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($assets as $asset): ?>
          <tr>
            <td><?= $this->Number->format($asset->id) ?></td>
            <td><?= h($kinds[$asset->kind]) ?></td>
            <td><?= h($asset->memo) ?></td>
            <td><?= h($asset->src) ?></td>
            <td class="actions">
              <?= $this->Html->link(__('View'), ['action' => 'view', $asset->id]) ?>
              <?= $this->Html->link(__('Edit'), ['action' => 'edit', $asset->id]) ?>
              <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $asset->id], ['confirm' => __('Are you sure you want to delete # {0}?', $asset->id)]) ?>
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
      <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
  </section>


</div>
