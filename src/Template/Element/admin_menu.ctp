<?php if($logined): ?>
  <nav class="admin">
    <ul>
      <li><?= $this->Html->link("Categories", "/categories"); ?></li>
      <li><?= $this->Html->link("Tags", "/tags"); ?></li>
      <li><?= $this->Html->link("Modules", "/modules"); ?></li>
      <li><?= $this->Html->link("Assets", "/assets"); ?></li>
      <li><?= $this->Html->link("Notes", "/notes"); ?></li>
      <li><?= $this->Html->link("Articles", "/articles"); ?></li>
      <li><?= $this->Html->link("Books", "/books"); ?></li>
      <li><?= $this->Html->link("Sections", "/sections"); ?></li>      
      <li><?= $this->Html->link("SectionNotes", "/sections-notes"); ?></li>
      <li><?= $this->Html->link("BookSections", "/books-sections"); ?></li>
      <li><?= $this->Html->link("ModuleAssets", "/modules-assets"); ?></li>
      <li><?= $this->Html->link("NoteModules", "/notes-modules"); ?></li>
      <li><?= $this->Html->link("NoteTags", "/notes-tags"); ?></li>
      <li><?= $this->Html->link("Logout", "/users/logout"); ?></li>
    </ul>
  </nav>
<?php endif; ?>
