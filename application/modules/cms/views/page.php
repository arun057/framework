<?php

$attributes = array('id' => 'my_form', 'name' => 'my_form');

if ($id)
    echo form_open_multipart("/cms/pages/edit/$id", $attributes);
else 
    echo form_open_multipart('/cms/pages/new_page', $attributes);

$data = array('name' => 'submit','value' => 'Save changes','class' => 'submit');
echo form_submit($data);

if (isset($show_msg))
   echo "<div class='show-msg-action-completed'>" . $show_msg . "</div>";

echo '<div id="admin_edit">';
echo "<div id='admin_title'>";
echo form_label('Title:', 'title');
echo form_input('title', $page->title);
echo "</div>";

echo '<div class="sidebar">';
  echo '<div class="block cms_blue">';

    echo '<div class="status clear"><h3>Status:';
      echo form_dropdown('status', $this->node_statuses, $page->status);
      echo '</h3>';
    echo '</div>';

    echo '<div class="status"><h3>Page Type:';
        echo form_dropdown('menu', $page_type_options, $page->menu);
        echo '</h3>';
        echo '<h3>New Page Type:</h3>';
        echo form_input('new_page_type', ''); 
    echo '</div>';

    echo '<div class="status clear"><h3>';
      echo form_checkbox('allow_comments', $page->allow_comments, $page->allow_comments);
      echo '&nbsp;Allow Comments:</h3>';
    echo '</div>';

    ?>

    <div class="status clear cms_categorys" ><h3 style="color: white">Categories:</h3>
      <div style="height: 200px; overflow: auto">
        <?php include_once('includes/category_helper.php'); ?>
        <?php list_categories($all_categories, 1, 0, $all_categories, $page->categories); ?>
      </div>
<!--      <div class="cms_new_category"><span>+</span><input type="text" name="new_category" value="" placeholder="new category[, new category]..." /> </div> -->
    </div>

    <?php
    if ((isset($sidebar_blocks)) && (!isset($hide_block['Page_Sidebar_Blocks']))) { ?>
    <div id="sidebar_blocks" class="status">
      <h3>Sidebar: <span style="font-size: 9px">(drag&drop to reorder)</span>
        <ul style="list-style-type: none; padding: 0">
            <?php $s_value = '';
            foreach ($sidebar_blocks as $type => $info) { 
              $s_value .= ($s_value) ? '&' : '';
              $s_value .= 'sidebar_block[]=' . $type;
            ?>
          <li id="sidebar_block_<?= $type ?>">
            <input type="checkbox" name="sidebar_block_<?= $type ?>" <?= ($info[2]) ? 'checked' : '' ?> ><?= $info[1] ?>
          </li>
          <?php } ?>
        </ul>        
        <input id="sidebar_blocks_sorted" name="sidebar_blocks_sorted" type="hidden" value="<?= $s_value ?>" />
      </h3>
      <a target="_newblock" href="/cms/block/sidebar">Edit sidebar blocks</a>
    </div>
    <?php } ?>

    <?php
    if ((isset($page_blocks)) && (!isset($hide_block['Page_Blocks']))) { ?>
    <div id="page_blocks" class="status">
      <h3>Blocks: <span style="font-size: 9px">(drag&drop to reorder)</span>
        <ul style="list-style-type: none; padding: 0">
            <?php $s_value = '';
            foreach ($page_blocks as $type => $info) { 
              $s_value .= ($s_value) ? '&' : '';
              $s_value .= 'page_block[]=' . $type;
            ?>
          <li id="page_block_<?= $type ?>">
            <input type="checkbox" name="page_block_<?= $type ?>" <?= ($info[2]) ? 'checked' : '' ?> ><?= $info[1] ?>
          </li>
          <?php } ?>
        </ul>        
        <input id="page_blocks_sorted" name="page_blocks_sorted" type="hidden" value="<?= $s_value ?>" />
      </h3>
      <a target="_newblock" href="/cms/block/page">Edit page blocks</a>
    </div>
    <?php } ?>

    <?php if (!isset($hide_block['Page_Video'])) { ?>
    <div class="status clear"><h3>Video:</h3>
       <div class=""> <?php echo form_input('video', $page->video); ?></div>
    </div>
    <?php } ?>

    <?php if (!isset($hide_block['Page_Article'])) {?>
    <div class="status clear"><h3>Article Source:</h3>
       <div class=""> <?php echo form_input('content_source', $page->content_source); ?></div>
    </div>
    <?php } ?>

    <div class="status clear"><h3>Monthly Theme Year:</h3>
       <div class=""> <?php echo form_input('monthly_theme_year', $page->monthly_theme_year); ?></div>
       <h3>Monthly Theme Month:</h3>
       <div class=""> <?php echo form_input('monthly_theme_month', $page->monthly_theme_month); ?></div>
    </div>

    <div class="status clear">
        <h3>URL:</h3>
        <?php 
        $page_type = preg_replace('/[^0-9a-z ]+/i', '', $page->menu); 
        $page_type = str_replace(' ', '-', strtolower($page_type));

        $page_url = '/page/' . (($page_type) ? $page_type . '/' : '');  

        if ($page->status != 'publish') { ?>
            <a href="/page/preview/<?= $page->name ?>" target="_preview" 
                title="preview: <?= $page_url . $page->name ?>" alt="preview: <?= $page_url . $page->name ?>">preview</a>
	    <br /><br />
            <span style="font-size: 0.7em;float:left;" ><?= $page_url ?></span>
            <input type="text" name="name" value="<?= $page->name ?>" 
                style="float: left; border: none; padding: 2px; padding-left: 0px; width: 150px;" />
       
        <?php } else echo '<a target="_preview" href="' . $page_url . $page->name . '"><span style="float: left;">' . $page_url . $page->name . '</a>';
            $sites = $this->config->item( 'sites' );
            
            if( is_array( $sites )) {
            	$sites = array_unique( array_values( $sites ));
            } else {
            	$sites = array();
            }
            
        	foreach( $sites as $siteId ) {
            	$siteDef = $this->config->item( $siteId );
            	
            	if( is_array( $siteDef )) {
            		$siteURL = $siteDef[ 'base_url' ];
            		
            		echo "<br/><a style='clear: both; float: left;' href=\"$siteURL/page/preview/{$page->name}\" target=\"_preview\">$siteId</a>";
            	}
            }
            print "<div class='clear'></div>";
        
     echo '</div>';
  echo '</div>';
echo '</div>';
echo '</div>';

echo '<div style="clear:left; width: 700px;">';

echo form_label('Page Content:', 'content');
echo form_textarea('content', $page->content);
echo display_ckeditor($ckeditor); 

echo "</div>";
?>
<div class="page-images-block">
    <div class="status clear">
      <h3>Thumbnail:</h3>
      <div id="page_photo">
          <?php if ($page->thumb) {?>

        <img width="100" class="image" src="/uploads/images/Page/<?php echo $page->thumb ?>" />
        <?php if (0) { //if ($allow_crop) { ?>
        <br /><a href="/cms/page/crop/<?= $page->id?>">crop this image</a>
        <?php } ?>
        <div id="photo_upload">
          <h5>Replace Thumbnail:</h5>
          <input type="file" name="thumb_image" style="font-size:11px" />
        </div>
        <?php } else { ?>
        <div id="photo_upload">
          <h5>Upload a Thumbnail:</h5>
          <input type="file" name="thumb_image" />
        </div>
        <?php } ?>
      </div>
    </div>

    <div class="status clear">
      <h3>Large Image:</h3>
      <div id="page_photo">
          <?php if ($page->large_image) {?>
        <img class="image" src="/uploads/images/Page/<?php echo $page->large_image ?>" />
        <?php if (0) { //if ($allow_crop) { ?>
        <br /><a href="/cms/page/crop/<?= $page->id?>">crop this image</a>
        <?php } ?>
        <div id="photo_upload">
          <h5>Replace Large image:</h5>
          <input type="file" name="large_image" style="font-size:11px" />
        </div>
        <?php } else { ?>
        <div id="photo_upload">
          <h5>Upload a Large image:</h5>
          <input type="file" name="large_image" />
        </div>
        <?php } ?>
      </div>
    </div>
</div>
<?
$data = array('name' => 'submit','value' => 'Save changes','class' => 'submit');
echo form_submit($data);
echo form_close();


?>

<script type="text/javascript">

$(document).ready(function() { 	

   $(function() {
        $("#sidebar_blocks ul").sortable({ opacity: 0.8, cursor: 'move', update: function() {
                $('#sidebar_blocks_sorted').val($(this).sortable("serialize"));
              }								  
        });

        $("#page_blocks ul").sortable({ opacity: 0.8, cursor: 'move', update: function() {
                $('#page_blocks_sorted').val($(this).sortable("serialize"));
              }								  
        });
   });
});	

</script>
