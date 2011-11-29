<?php

$attributes = array('id' => 'my_form', 'name' => 'my_form');

if ($id)
    echo form_open_multipart("/cms/blog/edit/$id", $attributes);
else 
    echo form_open_multipart('/cms/blog/new_blog', $attributes);

$data = array('name' => 'submit','value' => 'Save changes','class' => 'submit');
echo form_submit($data);

echo '<div id="admin_edit">';
echo "<div id='admin_title'>";
echo form_label('Title:', 'title');
echo form_input('title', $blog->title);
echo "</div>";

?>
<input type="hidden" name="parent_id" value="<?= $parent_id ?>" />

<div class="sidebar">
  <div class="block cms_blue">

    <div class="status clear"><h3>Status:
      <?php
      $options = array(
                  'draft'  => 'Draft',
                  'publish'    => 'Publish',
                  'private'   => 'Private',
                  'trash'   => 'Trash',
                );

      echo form_dropdown('status', $options, $blog->status); 
      echo '</h3>';

      if (!isset($hide_block['Blog_Featured'])) {
          echo '<h3>Featured Order<input  style="width:80px;margin-left: 20px" id="featured_blog" type="text" name="order" value="';
          echo $blog->order . '"/></h3>';
      }

      if (!isset($hide_block['Blog_Sticky'])) 
        echo '<h3><input type="checkbox" name="sticky"' . (($blog->sticky) ? 'checked' : ''). ' />Sticky</h3>';

      if ($blog->id) {
            echo "<a href=\"/blog/preview/{$blog->name}\" target=\"_preview\">preview</a>";
            
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
            		
            		echo "<br/><a href=\"$siteURL/blog/preview/{$blog->name}\" target=\"_preview\">$siteId</a>";
            	}
            }
      }
      ?>
    </div>
    
    <div class="status clear" ><h3>Author:
        <?php echo form_dropdown('author', $authors, $blog->author);      ?>
        </h3>
    </div>

    <div class="status clear">
      <h3>Thumbnail:</h3>
      <div id="blog_photo">
          <?php if ($blog->thumb) {?>

        <img width="100" class="image" src="/uploads/images/Blog/<?php echo $blog->thumb ?>" />
        <?php if ($allow_crop) { ?>
        <br /><a href="/cms/blog/crop/<?= $blog->id?>">crop this image</a>
        <?php } ?>
        <div id="photo_upload">
          <h5>Replace Thumbnail:</h5>
          <input type="file" name="userfile" style="font-size:11px" />
        </div>
        <?php } else { ?>
        <div id="photo_upload">
          <h5>Upload a Thumbnail:</h5>
          <input type="file" name="userfile" />
        </div>
        <?php } ?>
      </div>
    </div>

    <div class="status clear cms_categorys" ><h3 style="color: white">Categories:</h3>
      <div style="height: 200px; overflow: auto">
        <?php include_once('includes/category_helper.php'); ?>
        <?php list_categories($all_categories, 1, 0, $all_categories, $blog->categories); ?>
      </div>
<!--      <div class="cms_new_category"><span>+</span><input type="text" name="new_category" value="" placeholder="new category[, new category]..." /> </div> -->
    </div>

    <div class="status clear cms_tags" ><h3>Tags:</h3>
      <div style="height: 200px; overflow: auto">
      <?php 
      foreach( $tags as $aTag ) {
          if( empty( $aTag->tag_name )) continue;

          $checked =  (isset($blog->tag_list)) ? ( array_search( $aTag->tag_name, $blog->tag_list ) !== FALSE ? 'checked' : '' ) : '';

          print '<div class="cms_tag"> <input type="checkbox" name="tags[]" value="' . $aTag->id . '" ' . 
          $checked . ' />' . $aTag->tag_name . '</div>';
      }
      echo '</div>';
      echo '<div class="cms_new_tag"><span>+</span><input type="text" name="new_tag" value="" placeholder="new tag[, new tag]..." /> </div>';
      ?>
    </div>

    <div class="status clear"><h3>Date/time:</h3>
      <div class="blogdate">
        <input id="blogdateinput" type="text" name="date" value="<?php echo $blog->date ?>"/>
      </div>

      <div class="blogdate">
        <label for="blog_publish_on">Publish on:</label>
        <input class="cms-date-field" id="blog_publish_on" type="text" name="publish_on" value="<?php echo $blog->publish_on ?>" />
      </div>

      <div class="blogdate">
        <label for="blog_unpublish_on">Unpublish on:</label>
        <input class="cms-date-field" id="blog_unpublish_on" type="text" name="unpublish_on" value="<?php echo $blog->unpublish_on ?>"/>
      </div>

    </div>
  </div>
</div>

<div id="edit_template" style="clear:left; ">

  <?php

if (!isset($hide_block['Blog_Excerpt'])) {

    echo form_label('Excerpt:', 'excerpt');
    $data = array(
        'name'        => 'excerpt',
        'value'       => $blog->excerpt,
        'rows'        => '4',
        'cols'       => '60',
        'style'      => 'width: 650px; height: 50px; margin-bottom: 20px;'
    );

    echo form_textarea($data);
}

echo form_label('Blog:', 'content');
echo form_textarea('content', $blog->content);

echo display_ckeditor($ckeditor); 

echo "</div>";

$data = array('name' => 'submit','value' => 'Save changes','class' => 'submit');
echo form_submit($data);

echo form_close();

?>

