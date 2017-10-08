<!DOCTYPE html>
<html>
  <head>
   <link rel="stylesheet" type="text/css" href="<?php echo base_url('vendor/fireblight/css/error.css');?>">
    <title><?php echo $title;?></title>
  </head>
  <body class="sign error-page-wrapper background-color background-image">
    <div class="sign-container">
  <div class="nob"></div>
  <div class="post left"></div>
  <div class="post right"></div>
  <div class="pane">
    <div class="headline sign-text-color">
      404
    </div>
    <div class="context sign-text-color">
      Oops, the page you're<br>
      looking for does not exist.
    </div>
  </div>
</div>
<div class="text-container">
  <div class="headline secondary-text-color">
    404
  </div>
  <div class="context primary-text-color">
    <p>
      You may want to head back to the homepage.<br>
    </p>
  </div>
  <div class="buttons-container">
    <a class="border-button" style="" href="<?php echo base_url();?>"><span class="fa fa-home"></span> Home Page</a>
  </div>
</div>
  </body>
</html>
