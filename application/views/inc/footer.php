<script src="<?php echo base_url('vendor/jquery/jquery-3.1.1.min.js');?>"></script>
<script src="<?php echo base_url('vendor/semantic-ui/semantic.min.js');?>"></script>
<script src="<?php echo base_url('vendor/fullcalendar/js/moment.js');?>"></script>
<script src="<?php echo base_url('vendor/fullcalendar/js/fullcalendar.min.js');?>"></script>
<script src="<?php echo base_url('vendor/chartjs/chart.js');?>"></script>
<script src="<?php echo base_url('vendor/datatables/js/jquery.dataTables.min.js');?>"></script>
<script src="<?php echo base_url('vendor/datatables/js/dataTables.semanticui.min.js');?>"></script>
<script src="<?php echo base_url('vendor/fireblight/js/fireblight.js');?>"></script>
<script src="<?php echo base_url('vendor/timepicker/jquery.timepicker.min.js');?>"></script>
<script src="<?php echo base_url('vendor/select2/js/select2.min.js');?>"></script>
<script src="<?php echo base_url('vendor/jquery-steps/jquery.steps.min.js');?>"></script>
<script src="<?php echo base_url('vendor/datepicker/zebra_datepicker.min.js');?>"></script>
<script type="text/javascript">
    var site_url = (url) => {
        var getUrl = "<?php echo site_url('" + url + "'); ?>";
        return getUrl;
    }
    $('#mytest').dropdown({
      action: 'nothing'
    });
    $('.ui.checkbox').checkbox();
</script>


</body>
</html>
