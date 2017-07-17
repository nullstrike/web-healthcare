/**
 * Created by n3far1ous on 7/12/17.
 */
$(window).on('load',function() {
    $(".loader").fadeOut(2000,function(){
        $(".main-wrapper").fadeIn(1000);
    });
});
var site_url = function(urlText){
    var url = "<?php echo site_url('" + urlText + "'); ?>";
    return url;
}