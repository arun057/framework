<div class="content">
  <div class="block">
    <div class="block-content">
      <h1 class="title"><?php echo $member_story->title ?></h1>
      <div class="gray-bordered">
        <div id="node-<?php echo $member_story->id ?>" class="inner-content ">
          <div style="font-style: italic; width: 600px;" class="mrstory-body">
            <?php
               $photos = explode(',', $member_story->photos);
               foreach ($photos as $photo) {
               if ($photo) 
                 echo '<img align="right" src="/uploads/images/Story/' . $photo . '" />';
               }
               echo str_replace("\n", '<p>', $member_story->story_body); 
              ?> 
            <div class="author">
              <?php $attrib = ($member_story->anonymous == 'Anonymous') ? 'Anonymous' : 
              $member_story->first_name; 
                if (!$attrib) $attrib = 'Anonymous'; ?>
              <strong> &mdash;<?php echo $attrib ?></strong><?php echo $member_story->state ?>
            </div>
            <div style="clear:both; height: 10px"></div>
          </div>
        </div>
      </div>

      <div id="contact-info">
        <?php if ((($this->data['permissions']['permission'] == 'PRESS') && ($member_story->share_media_ok == 'Yes')) ||
            ($this->data['permissions']['permission'] != 'PRESS')) { ?>

       <h1>Contact info:</h1>
           <div>
              <div class="clabel">Email:</div><a href="mailto:<?php echo $member_story->email ?>"><?php echo $member_story->email ?></a>
           </div>
           <div>
              <div class="clabel">Cell:</div><?php echo $member_story->cell ?>
           </div>
           <div>
              <div class="clabel">Name:</div><?php echo $member_story->first_name . ' ' . $member_story->last_name ?></a>                                         </div>
           <div>
              <div class="clabel">Address:</div><?php echo $member_story->city . ', ' . $member_story->state . ' ' . $member_story->zip ?>
           </div>
           <div>
              <div class="clabel">District:</div>
           </div>

      <?php } ?>
      </div>

    </div>
  </div>
</div>

