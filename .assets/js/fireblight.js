//Global Functions

$(window).on('load',function() {
    $(".loader").fadeOut(2000,function(){
        $(".content").fadeIn(1000);
    });
});


//User Processes

/* For Updating Default User */
   /* $("#new-userform").on('click','#add-user',function(e){
        e.preventDefault();
        $.ajax({
            url: site_url('user/user_add'),
            data: $('#new-userform').serialize(),
            dataType:'json',
            type:'POST',
            success: function (data) {
                if(data.status === true){
                    alert(data.message);
                }else{
                    $.each(data.errors, function (key,val) {
                       $('input[name="' + key + '"]').next().html(val).parent().addClass('has-error');

                    })

                }
            }
        });
    });*/

var patient_id,height = $('#height').val(),weight = $('#weight').val();
$('#example tbody').on('click', 'tr', function() {
    patient_id = patient_table.cell(this,0).data();
    height = patient_table.cell(this,8).data();
    weight = patient_table.cell(this,9).data();
});

$('#test').click(function(){
    alert(patient_id);
})
var formdata = "id=" + $('#patient_id').val() + "&old_height=" + height + "&old_weight=" + weight;

function old_data(){
    $.ajax({
        url: site_url('patient/past_data'),
        data: "id=" + $('#patient_id').val() + "&old_height=" + height + "&old_weight=" + weight,
        dataType:'json',
        type:'POST',
         success: function (data) {
            if(data.status === true){
                alert(data.message);
            }else{
                $.each(data.errors, function (key,val) {
                    $('input[name="' + key + '"]').next().html(val).parent().addClass('has-error');

                })

            }
        }
    });
}


function update_data(){
    $.ajax({
        url: site_url('patient/update'),
        data: $('#patient_edit').serialize(),
        dataType:'json',
        type:'POST',
        success: function (data) {
            if(data.status === true){
                alert(data.message);
            }else{
                $.each(data.errors, function (key,val) {
                    $('input[name="' + key + '"]').next().html(val).parent().addClass('has-error');

                })

            }
        }
    });
}
$(function(){
    $('#update').on('click',function(){
        old_data();
        update_data();

    })
})

/* $.ajax({
 url: "<?php echo site_url('user/authenticate');?>",
 data: $('#loginform').serialize(),
 type: "post",
 dataType: "json",
 success: function(data){

 if(data.success) {
 console.log(data);
 window.location.href = data.page;
 }
 else{
 console.log(data.message);
 $(".ui-widget").show().find("#error").html(data.message);
 }
 }

 });*/