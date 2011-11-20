<?php
if ($id)
    echo form_open_multipart("/cms/actions/edit/$id");
else 
    echo form_open_multipart('/cms/actions/new_action');
?>

<div id="cms-action-editor" >

<div id="admin_edit" style="float: left; width: 660px;" >
	<div id='admin_title'>
	  <h2>Action: </h2>
	</div>
	
	<?= form_label('Title:', 'title') ?>
	<?= form_input(array( 'name' => 'title', 'value' => $content->title, 'size' => 100, 'class' => 'ccc-input-title' )) ?>
	<br /><br />
	<?= form_label('About:', 'about') ?>
	<?= form_textarea('about', $content->about) ?>
	<br /><br />
	<?= form_label('Action page HTML:', 'statement') ?>
	<?= form_textarea('statement', $content->statement) ?>
	 <br /><br />
	 <?= form_label('Thanks page HTML:', 'thankyou') ?>
	 <?= form_textarea('thankyou', $content->thankyou) ?>
     <br /><br />
     <?= form_label('Thanks page tweet:', 'taf_tweet') ?>
     <?= form_textarea('taf_tweet', $content->taf_tweet) ?>
	<br /><br />
</div>
    
<div class="sidebar" class="height: 100%;" >
    <?= form_submit( array('name' => 'submit','value' => 'Save changes','class' => 'submit submit-action'))?>
    <div class="status clear">
      <h3>Status:
      <?php
      $options = array(
                  'draft'  => 'Draft',
                  'publish'    => 'Publish',
                  'private'   => 'Private',
                  'trash'   => 'Trash',
                );

             echo form_dropdown('status', $options, $content->status); 
      ?>
    </h3></div>

 	<?php /* TODO : http://www.quirksmode.org/dom/inputfile.html */ ?>
 
    <div class="status clear">
      <h3>Image:</h3>
      <div id="content_photo">
        <?php if ($content->image) { ?>
          <img width="100" class="image" src="/uploads/images/Action/<?php echo $content->image ?>" />
          <div id="photo_upload"><br /><br />
            <h5>Replace Image:</h5>
            <input type="file" name="userfile" style="font-size:11px" />
          </div>
        <?php } else { ?>
          <div id="photo_upload">
            <h5>Upload a Image:</h5>
            <input type="file" name="userfile" />
          </div>
        <?php } ?>
       </div>
    </div>

    <div class="status clear">
       <h3>Rank:</h3>
        <input type="text" name="rank" value="<?php echo $content->rank ?>" />
    </div>
    
    <br/>    
    Preview <a href="/actions/act/<?= $content->name ?>&preview=1" target="_newPreview" >Action page</a>
    <br/>    
    Preview <a href="/actions/thanks/<?= $content->name ?>&preview=1" target="_newPreview" >Thanks Page</a>


    <br/><br/>    
    <?= form_submit(array('name' => 'submit','value' => 'Save changes','class' => 'submit submit-action')) ?>
</div>
</div>
<?php
echo form_close();
?>
