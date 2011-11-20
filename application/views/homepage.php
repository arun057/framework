<div class="cols-c intro">
	<div class="col-a"> 
	      <div class="feature-a"> 
<? if (count($features)>0):  
	             $top_feature = array_slice($features,0,1);
     foreach ($top_feature as $feature) { ?>
      <p class="s1" style="background: url(/uploads/images/feature/<?=$feature->image?>) top right no-repeat;">
  
            <strong><?php echo $feature->title ?></strong>
            <span><?php echo $feature->description ?></span>
            <a href="<?php echo $feature->link ?>">Read more &raquo;</a>
     
    </p>   
    <?php } ?>
</div>


<ul class="feature-b">
   <?php 
   $features = array_slice($features,1);
   foreach ($features as $feature) { ?>
      <li>
        <a href="<?= $feature->link ?>">
          <img src="/uploads/images/feature/<?php echo $feature->image ?>" width="220" height="180" alt="<?php echo $feature->title ?>" />
         <span><?php echo $feature->title ?> &raquo;</span>
        </a> 
      </li>
  <?php } ?>
    
</ul>     
<? endif; ?>  
</div>
