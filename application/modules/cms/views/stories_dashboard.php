<?php 

include(APPPATH.'config/osm_mapping.php');  

echo '<div class="breadcrumbs">' . $page_title . '</div>';

if (isset($js_grid))
    echo $js_grid;
?>
<style>
#story_search {
    float: left;
    margin-bottom: 40px;
    background-color: white;
    padding: 20px;  
}

#story_search div {
    float: left;
    padding: 0 20px;
}
</style>


<?php 
// if either topic or state selection is allowed, show this narrow-by box unless it is press and no selections allowed
if (((!($permissions['topic'])) || (!($permissions['state']))) || 
    (!(($permissions['topic']) && ($permissions['state']) && ($permissions['permission'] == 'PRESS')))) { ?>
<div id="story_search">
<h2>Narrow by:</h2><br/>
     <form method="POST" action="/cms/member_stories/search">

      <div>Type:
         <?php  echo form_dropdown('stype', $this->node_types, $stype); ?>
      </div>

      <div>Sticky:
         <?php  echo form_dropdown('ssticky', array( '0' => 'not sticky', '1' => 'sticky' ), $ssticky ); ?>
      </div>


      <?php if ($permissions['permission'] != 'PRESS') { ?>
      <div>Status:
         <?php  echo form_dropdown('sstatus', $this->node_statuses, $sstatus); ?>
      </div>
      <?php } else { ?>
      <input type="hidden" name="sstatus" value="1" />
      <?php } ?>

      <?php if (!($permissions['topic'])) { ?>
      <div>Topic:
         <?php  echo form_dropdown('stopic', $topics, $stopic); ?>
      </div>
      <?php } else { ?>
      <input type="hidden" name="stopic" value="<?php echo $stopic ?>" />
      <?php } ?>

      <?php if (!($permissions['state'])) { ?>
      <div>State:
         <?php  echo form_dropdown('sstate', $state_list, $sstate); ?>
      </div>
      <?php } else { ?>
      <input type="hidden" name="sstate" value="<?php echo $sstate ?>" />
      <?php } ?>

      <span class="create_button"><input type="submit" value="Apply"></span>
      </form>
</div>
<?php } ?>

<table id="Grid" style="display:none"></table>

<script>

$(document).ready(function() {

        // set it to full width
        $('.wrapper').width('98%');
    });

</script>
