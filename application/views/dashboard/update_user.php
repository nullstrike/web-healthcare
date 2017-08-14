<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Aguilar Clinic</title>
        <link rel="stylesheet" href="<?php echo base_url('vendor/materialize/css/materialize.min.css');?>">
        <script src="<?php echo base_url('vendor/jquery/jquery-3.1.1.min.js');?>"></script>
        <script>
            var site_url = function(urlText){
                var url = "<?php echo site_url('" + urlText + "'); ?>";
                return url;
            }
        </script>
    </head>

    <body class="teal accent-2">
<?php if ($this->session->userdata('userName') !== 'doctor'): ?>
<div class="row" id="login-box" style="padding-top:140px">
    <div class="col s4 offset-s4">
        <div class="z-depth-5 card-panel blue-grey darken-4 white-text">
            <h4 class="center">Change your password</h4>
            <form autocomplete="off" id="changePassForm">
                <div class="row">
                    <input type="hidden" name="userid" value="<?php echo $this->session->userdata('userID');?>">
                    <div class="input-field col s12">
                        <label for="last_name">Username</label>
                        <input id="username" name="username" type="text" style="font-size: 1.3rem;" class="white-text" disabled value="<?php echo $this->session->userdata('userName');?>">
                        <span class="red-text"></span>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="password">New Password</label>
                            <input id="password" name="password" type="password" class="validate">
                            <span class="red-text"></span>
                        </div>
                        <div class="input-field col s12">
                            <label for="passwordconf">Confirm Password</label>
                            <input name="passconf" id="passconf" type="password" class="validate">
                            <span class="red-text"></span>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 0px;">
                        <button type="submit" id="btn_changepass" class="btn red darken-4 waves-effect waves-light col s12"> Change Password</button>
                    </div>
            </form>
        </div>
    </div>
</div>
<?php else: ?>

    <div class="row" id="login-box" style="padding-top:100px">
        <div class="col s8 offset-s2">
            <div class="z-depth-5 card-panel blue-grey darken-4 white-text">
                <h4 class="center-text">Update user information</h4>
                <form autocomplete="off" id="updateUserForm">
                    <div class="col s6">
                        <input type="hidden" name="userID" value="<?php echo $this->session->userdata('userID');?>">
                         <div class="input-field col s12">
                            <label for="firstname">First Name</label>
                            <input id="firstname" name="firstname" type="text" >
                            <span class="red-text"></span>
                         </div>
                         <div class="input-field col s12">
                            <label for="lastname">Last Name</label>
                            <input id="lastname" name="lastname" type="text">
                            <span class="red-text"></span>
                         </div>
                         <div class="input-field col s12">
                            <label for="contact">Contact Number</label>
                            <input id="contact" maxlength="11" name="contact" type="text">
                            <span class="red-text"></span>
                         </div>
                         </div>
                         <div class="col s6">
                         <div class="input-field col s12">
                            <label for="username">Username</label>
                            <input id="username" name="username" type="text" style="font-size: 1.3rem;" class="white-text" disabled value="<?php echo $this->session->userdata('userName');?>">
                            <span class="red-text"></span>
                         </div>
                         <div class="row">
                             <div class="input-field col s12">
                                <label for="password">New Password</label>
                                <input id="password" name="password" type="password" class="validate">
                                <span class="red-text"></span>
                             </div>
                             <div class="input-field col s12">
                                <label for="passwordconf">Confirm Password</label>
                                <input name="passconf" type="password" class="validate">
                                <span class="red-text"></span>
                             </div>
                         </div>
                         </div>
                        <div class="row" style="margin-bottom: 0px;">
                           <button type="submit"  class="btn red darken-4 waves-effect waves-light col s3 right"> Update User</button>
                        </div>
                        <p><span class="grey-text"><i>Contact number is used for sending messages to patient via sms.</i></span></p>
                         
                </form>
            </div>
        </div>
    </div>




<?php endif; ?>
<script>
    $(window).on('load', function(){
        $('body').addClass('teal accent-4');
    });

</script>
 <script src="<?php echo base_url('vendor/materialize/js/materialize.min.js');?>"></script>
 <script src="<?php echo base_url('vendor/fireblight/js/user.js');?>"></script>
</body>
</html>