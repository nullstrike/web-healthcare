<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!--Load Header File -->

<?php if ($type === 'login')  include('index_header.php'); ?>
<?php if ($type === 'dashboard') include('header.php'); ?>


<!--Load Sidebar File For Dashboard--> 
<?php if ($type === 'dashboard') include('sidebar.php'); ?>

<!--Load Main File -->
<?php if ($type === 'dashboard') include('main.php'); ?>
<?php if ($type === 'login') echo $content; ?>

<!--Load Footer File -->
<?php if ($type === 'login')  include('index_footer.php'); ?>
<?php if ($type === 'dashboard') include('footer.php'); ?>
