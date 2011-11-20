<?php echo '<div class="breadcrumbs">' . $page_title . '</div>'; ?>
<div class="block blue">
  <div class="status"></div>
  <ul class="clear">
    <?php 
    foreach ($templates as $template) {
      echo '<li><a href="/cms/templates/edit/' . $template['dir'] . '/' . $template['name'] . '">' . $template['name'] . '</a></li>';
    }
    ?>
  </ul>
</div>
