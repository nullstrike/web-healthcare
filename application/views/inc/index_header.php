<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title><?php echo $pagetitle;?></title>
        <link rel="stylesheet" href="<?php echo base_url('vendor/semantic-ui/semantic.min.css');?>">
        <link rel="stylesheet" href="<?php echo base_url('vendor/fireblight/css/user.css');?>">
        <script src="<?php echo base_url('vendor/jquery/jquery-3.1.1.min.js');?>"></script>
        <script>
            var site_url = function(urlText){
                var url = "<?php echo site_url('" + urlText + "'); ?>";
                return url;
            }
        </script>
    </head>
    <body>
