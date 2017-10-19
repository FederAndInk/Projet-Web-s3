<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Actus du RSS</title>
  </head>
  <h1>Actus du RSS</h1>
  <body>
    <?php foreach($data['titres'] as $key => $value){   ?>

        <a href="<?php echo $data['urls'][$key] ?> ">
          <?php echo "$value" ?>
        </a>
        <br>
<?php } ?>
  </body>
</html>
