<style type="text/css">
.clf_form {}
.clf_form label {width:200px;  display:block; float:left}
     .clf_form input, .clf_form textarea {width:400px; border: none; }
</style>


<div class="sidebar">
  <div class="block cms_blue">

    <div class="status clear"><h3>Notes</h3>
      <textarea style="width: 240px" name="notes"><?php echo $form->notes ?></textarea>
    </div>
  </div>
</div>

<div style="padding: 40px">

<form class="clf_form">

<h1><?php echo $form->form_key ?></h1>

<?php

function form_value($key, $value) {

     if (strlen($value) > 80)
         echo "<p>
         <label for='$key'>$key</label> <textarea type='text' name='$key' readonly >$value</textarea></p>";
     else 
         echo "<p>
         <label for='$key'>$key</label> <input type='text' name='$key' readonly value='$value'></p>";
 }


foreach ($form as $key => $value) {

    if ($key == 'form_key') continue;
    if ($key == 'id') continue;

    if ($key == 'form_json') {

        $content = json_decode($value);
        foreach ($content as $k => $v) 
            form_value($k, $v);
    }
    else form_value($key, $value);
}

?>
</form>

</div>