<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Page principale</title>
  </head>
  <body>
    <div class="">
    <p>
      <?php foreach ($data['titres'] as $key => $value) { ?>
        <a href="<?php echo $data['urls'][$key] ?> ">
        <?php echo $value ?>
      </a>
        <br/>
    <?php   } ?>
    </p>

  </div>
  </body>
</html>
