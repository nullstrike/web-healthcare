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

<!--Load Specific Page Js File -->
<?php if ($section === 'dashboard'): ?>
    <script src="<?php echo base_url('vendor/fullcalendar/js/moment.js');?>"></script>
    <script src="<?php echo base_url('vendor/fullcalendar/js/fullcalendar.min.js');?>"></script>
    <script src="<?php echo base_url('vendor/chartjs/chart.js');?>"></script>
    <script src="<?php echo base_url('vendor/fireblight/js/dashboard.js');?>"></script>
<?php endif; ?>

<?php if ($section === 'user'): ?>
    <script src="<?php echo base_url('vendor/datatables/js/jquery.dataTables.min.js');?>"></script>
    <script src="<?php echo base_url('vendor/datatables/js/dataTables.semanticui.min.js');?>"></script>
    <script src="<?php echo base_url('vendor/fireblight/js/user.js');?>"></script>
<?php endif; ?>

<?php if ($section === 'patient'): ?>
    <script src="<?php echo base_url('vendor/datatables/js/jquery.dataTables.min.js');?>"></script>
    <script src="<?php echo base_url('vendor/datatables/js/dataTables.semanticui.min.js');?>"></script>
    <script src="<?php echo base_url('vendor/datepicker/zebra_datepicker.min.js');?>"></script>
    <script src="<?php echo base_url('vendor/fireblight/js/patient.js');?>"></script>
<?php endif; ?>

<?php if ($section === 'appointment'): ?>
    <script src="<?php echo base_url('vendor/fullcalendar/js/moment.js');?>"></script>
    <script src="<?php echo base_url('vendor/fullcalendar/js/fullcalendar.min.js');?>"></script>
    <script src="<?php echo base_url('vendor/datatables/js/jquery.dataTables.min.js');?>"></script>
    <script src="<?php echo base_url('vendor/datatables/js/dataTables.semanticui.min.js');?>"></script>
    <script src="<?php echo base_url('vendor/timepicker/jquery.timepicker.min.js');?>"></script>
    <script src="<?php echo base_url('vendor/select2/js/select2.min.js');?>"></script>
    <script src="<?php echo base_url('vendor/datepicker/zebra_datepicker.min.js');?>"></script>
    <script src="<?php echo base_url('vendor/fireblight/js/appointment.js');?>"></script>
<?php endif; ?>

<?php if ($section === 'consultation'): ?>
    <script src="<?php echo base_url('vendor/datatables/js/jquery.dataTables.min.js');?>"></script>
    <script src="<?php echo base_url('vendor/datatables/js/dataTables.semanticui.min.js');?>"></script>
    <script src="<?php echo base_url('vendor/select2/js/select2.min.js');?>"></script>
    <script src="<?php echo base_url('vendor/fullcalendar/js/moment.js');?>"></script>
    <script src="<?php echo base_url('vendor/fireblight/js/consultation.js');?>"></script>
<?php endif; ?>

<?php if ($section === 'report'): ?>
    <script src="<?php echo base_url('vendor/fullcalendar/js/moment.js');?>"></script>
    <script src="<?php echo base_url('vendor/datatables/js/jquery.dataTables.min.js');?>"></script>
    <script src="<?php echo base_url('vendor/datatables/js/dataTables.semanticui.min.js');?>"></script>
    <script src="<?php echo base_url('vendor/fireblight/js/report.js');?>"></script>
<?php endif; ?>

<?php if ($section === 'userlog') : ?>
  <script src="<?php echo base_url('vendor/datatables/js/jquery.dataTables.min.js');?>"></script>
  <script src="<?php echo base_url('vendor/datatables/js/dataTables.semanticui.min.js');?>"></script>
  <script src="<?php echo base_url('vendor/fireblight/js/misc.js');?>"></script>
<?php endif; ?>
