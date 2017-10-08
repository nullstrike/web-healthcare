<script src="<?php echo base_url('vendor/jquery/jquery-3.1.1.min.js');?>"></script>
<script src="<?php echo base_url('vendor/semantic-ui/semantic.min.js');?>"></script>
<script type="text/javascript">
    var site_url = function(url){
        var getUrl = "<?php echo site_url('" + url + "'); ?>";
        return getUrl;
    }

    $('#upcoming').dropdown({
        action: 'nothing'
    });
    function upcoming_notify() {$.ajax({
        url: site_url('appointment/upcomingappointments'),
        type: 'post',
        dataType: 'json',
        data: {},
        success: function(response){
            var result = [];
            $('#upcoming_count').text(response.length);
            for (let i in response) {

                    result.push('<div class="header item">' +
                                                            '<div class="content">' +
                                                                '<div class="header">' + response[i].patient  +'</div>' +
                                                                    '<div class="description">'+ response[i].schedule +'</div>' +
                                                          '</div></div></div>');

            }
            $('#count_wrapper .ui.divider').after(result);
        }
    });
}

  upcoming_notify();
</script>


</body>
</html>
