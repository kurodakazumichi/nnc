<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $article
 */
?>

<div class="admin">
  <section>
    <h2 class="m0020"><?= h($article->id) ?></h2>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Note') ?></th>
            <td><?= $article->has('note') ? $this->Html->link($article->note->title, ['controller' => 'Notes', 'action' => 'view', $article->note->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Category') ?></th>
            <td><?= $article->has('category') ? $this->Html->link($article->category->name, ['controller' => 'Categories', 'action' => 'view', $article->category->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($article->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Layer') ?></th>
            <td><?= $this->Number->format($article->layer) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Published') ?></th>
            <td><?= $article->published ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
  </section>


</div>
