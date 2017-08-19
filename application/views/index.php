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
<div class="row" id="login-box" style="padding-top:140px">
    <div class="col s4 offset-s4">
        <div class="z-depth-5 card-panel blue-grey darken-4 white-text">
            <h4 class="center">Login to your Account</h4>
            <form autocomplete="off" id="loginForm">
                <div class="row">
                    <div class="input-field col s12">
                        <label for="last_name">Username</label>
                        <input name="username" type="text" class="validate" required>
                        <span class="red-text"></span>
                    </div>
                <div class="row">
                    <div class="input-field col s12">
                        <label for="last_name">Password</label>
                        <input name="password" type="password" class="validate" required>
                        <span class="red-text"></span>
                    </div>
                   <!--  <h6 style="padding-left: 10px;" ><a tabindex="-1" href="#" class="white-text"><i>Change password</i></a></h6> -->
                </div>  
                <div class="row" style="margin-bottom: 0px;">
                        <button type="submit" id="login" class="btn green waves-effect waves-light col s12"> Login</button>
                    </div>
            </form>
        </div>
    </div>
</div>
 <script src="<?php echo base_url('vendor/materialize/js/materialize.min.js');?>"></script>
 <script src="<?php echo base_url('vendor/fireblight/js/user.js');?>"></script>
</body>
</html>