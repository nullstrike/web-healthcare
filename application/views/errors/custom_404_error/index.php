<!DOCTYPE html>
<html>
  <head>
    <script src="<?php echo base_url('vendor/jquery/jquery-3.1.1.min.js');?>"></script>
    <script src="<?php echo base_url('vendor/jquery-ui/js/jquery-ui.min.js');?>"></script>
    <link rel="stylesheet" media="screen" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600" />
    <link rel="stylesheet" media="screen" href="<?php echo base_url('vendor/font-awesome/css/font-awesome.min.css');?>" />
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
    <a class="border-button" style="width:350px;" href="<?php echo base_url();?>"><span class="fa fa-home"></span> Home Page</a>
  </div>
</div>

  <script src="<?php echo base_url('vendor/fireblight/js/error.js');?>"></script>
  </body>
</html>
