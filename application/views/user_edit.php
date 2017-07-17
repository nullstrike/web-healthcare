<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<div class="loader"></div>
<div class="container  col-md-6 col-md-push-1" id="userform-wrapper">
    <div class="row" id="userform-box">
        <h3 class="lead" style="padding-left:30px;">Update user information</h3>
        <hr>
        <div id="user-error"></div>
        <form action="#" method="post" id='userform' class="form-horizontal">
            <!--first column div-->
            <input type="text" id="user_id" hidden value="<?php echo $this->session->userdata('user_id');?>">
            <div class="col-md-12">

                <!--First Name Input-->
                <div class="form-group">
                    <label for="firstname" class="control-label col-md-3">First&nbsp;Name:</label>
                        <div class="col-md-9">
                            <div class="col-xs-6">     <input type="text" id="firstname" name="firstname" class="form-control"></div>
<?php echo form_error('firstname');?>
                        </div>

                </div>

                <!--Middle Name Input-->
                <div class="form-group">
                    <label for="middlename" class="control-label col-md-3">Middle&nbsp;Name:</label>
                        <div class="col-md-9">
                            <input type="text" name="middlename" class="form-control">
                        </div>
                </div>

                <!--Last Name Input-->
                <div class="form-group">
                    <label for="lastname" class="control-label col-md-3">Last&nbsp;Name:</label>
                        <div class="col-md-9">
                            <input type="text" name="lastname" class="form-control">
                        </div>
                </div>


                <!--Contact Number Input -->
                <div class="form-group">
                    <label for="contact" class="control-label col-md-3">Contact&nbsp;Number:</label>
                    <div class="col-md-9">  <input type="text" name="contact" class="form-control"></div>
                </div>

                <!--Username Input -->
                <div class="form-group">
                    <label for="username" class="control-label col-md-3">Username:</label>
                    <div class="col-md-9">  <input readonly value="<?php echo $this->session->userdata('user_username');?>" type="text" name="username" class="form-control"></div>
                </div>

                <!--Password Input -->
                <div class="form-group">
                    <label for="password" class="control-label col-md-3">Password:</label>
                    <div class="col-md-9">  <input type="text" name="password" class="form-control"></div>
                </div>

                <!--Confirm Password Input -->
                <div class="form-group">
                    <label for="confpassword" class="control-label col-md-3">Confirm&nbsp;Password:</label>
                    <div class="col-md-9">  <input type="text" name="confpassword" class="form-control"></div>
                    <?php echo form_error('password');?>
                </div>
                <!-- end first column div-->
                <div class="pull-right" style="padding-right:20px;">
                    <button type="button" id="user-update" class="btn btn-info btn-md ">Update&nbsp;</button>
                    <button type="button" id="cancel" class="btn btn-danger ">sfa</button></div>

            </div>





        </form>
    </div>
</div>

</div>

<script>
    $(function() {
            var id;
        $('#user-update').click(function(){
            id = $("#user_id").val();

            $.ajax({
               url: "<?php echo site_url('user/user_update');?>",
                data: $('#userform').serialize() + "&id=" + id,
                type: "POST",
                dataType: 'json',
                success: function(data){

                   if(!data.success){
                       if(data.errors){
                        $.each(data.errors,function(key,val){
                            $('input[name="'+ key +'"]', '#userform').after(val);

                        });
                       }
                   }else{
                       alert(data.message);
                        window.location.href = data.page;
                   }
                },
                error: function(data){
                    //console.log(data);
                }
            });
        })
    });
</script>