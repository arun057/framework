<style>
form { margin: 1.5em 0; }
form.coords label { margin-right: 1em; font-weight: bold; display: inline-block }
form.coords input { width: 3em; }
form.coords #submit { width:200px; cursor: pointer}

</style>

<div style="margin: 20px; position: relative" >
  <h2>Crop thumb for blog:</h2>
  <h3><?= $blog->title ?></h3>

  <div style="margin-top: 40px">
    <img id="target" src="/uploads/images/Blog/<?php echo $blog->thumb ?>" />

    <form id="coords"
          class="coords"
          method="post"
          action="/cms/blog/crop/<?=$blog->id ?>">

      <div style="display:none; ">
        <label>X1 <input type="text" size="4" id="x1" name="x" /></label>
        <label>Y1 <input type="text" size="4" id="y1" name="y" /></label>
        <label>X2 <input type="text" size="4" id="x2" name="x2" /></label>
        <label>Y2 <input type="text" size="4" id="y2" name="y2" /></label>
        <label>W <input type="text" size="4" id="w" name="w" /></label>
        <label>H <input type="text" size="4" id="h" name="h" /></label>
      </div>

      <input id="submit" type="submit" name="submit" value="Crop Thumbnail" />

    </form>
  </div>
</div>

<script type="text/javascript">

     $('#target').Jcrop({
        aspectRatio: <?= $ratio ?>,
        onChange:   showCoords,
        onSelect:   showCoords,
      });

    // Simple event handler, called from onChange and onSelect
    // event handlers, as per the Jcrop invocation above
    function showCoords(c) {
      $('#x1').val(c.x);
      $('#y1').val(c.y);
      $('#x2').val(c.x2);
      $('#y2').val(c.y2);
      $('#w').val(c.w);
      $('#h').val(c.h);
    };

    function clearCoords() {
      $('#coords input').val('');
    };


</script>

