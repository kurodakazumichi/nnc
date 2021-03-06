<?php if($logined): ?>
<?php
$datas = [
  'Categories' => [
    'url' => '/categories',
    'sub' => []
  ],
  'Tags' => [
    'url' => '/tags',
    'sub' => []
  ],
  'Modules' => [
    'url' => '/modules',
    'sub' => [
      '新しいモジュール' => '/modules/edit'
    ]
  ],
  'Assets' => [
    'url' => '/assets',
    'sub' => [
      '新しいアセット' => '/assets/edit'
    ]
  ],
  'Notes' => [
    'url' => '/notes',
    'sub' => [
      '新しいノート' => '/notes/edit'
    ]
  ],
  'Articles' => [
    'url' => '/articles',
    'sub' => [
      '新しい記事' => '/articles/edit'
    ]
  ],
  'Books' => [
    'url' => '/books',
    'sub' => [
      '新しいブック' => '/books/edit'
    ]
  ],
  'Sections' => [
    'url' => '/sections',
    'sub' => [
      '新しいセクション' => '/sections/edit'
    ]
  ],
  'SectionNotes' => [
    'url' => '/sections-notes',
    'sub' => []
  ],
  'BookSections' => [
    'url' => '/books-sections',
    'sub' => []
  ],
  'ModuleAssets' => [
    'url' => '/modules-assets',
    'sub' => []
  ],
  'NoteModules' => [
    'url' => '/notes-modules',
    'sub' => []
  ],
  'NoteTags' => [
    'url' => '/notes-tags',
    'sub' => []
  ],
  'Logout' => [
    'url' => '/users/logout',
    'sub' => []
  ],
];
?>
  <nav class="admin">
    <ul>
      <?php foreach ($datas as $name => $data) : ?>
        <li onmouseover="$(this).find('div').show();" onmouseout="$(this).find('div').hide();">
          <?= $this->Html->link($name, $data['url']); ?>
          <div class="sub">
            <ul>
              <?php foreach($data['sub'] as $title => $url): ?>
                <li><?= $this->Html->link($title, $url); ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
  </nav>
<?php endif; ?>
