<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Aguilar Clinic</title>
        <link rel="stylesheet" href="<?php echo base_url('vendor/materialize/css/materialize.min.css');?>">
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
          <div class="row" id="loginBox"> <!--Login Box -->
              <div class="col s4 push-s4"> <!--Center align login box -->
                  <div class="z-depth-5 card-content white darken-4 black-text" id="loginWrapper"> <!--Login styling class-->
                      <img id="header-image" align="middle" src="<?php echo base_url('vendor/fireblight/images/aguilar-clinic-logo.png');?>" class="responsive-img" alt="Aguilar Clinic"> <!--Header Image -->
                          <form autocomplete="off" id="loginForm"> <!-- Login Form -->
                              <div class="row"> <!-- User field-->
                                  <div class="col s12">
                                      <label for="last_name" class="active" data-error="Username is required" >Username</label>
                                      <input name="username" id="uName" type="text" class="validate"  required>
                                      <span class="red-text"></span>
                                  </div>
                              </div> <!--End User Field-->
                              <div class="row" > <!-- Password Field -->
                                  <div class="col s12" >
                                      <label for="last_name" class="active" >Password</label>
                                      <input name="password" type="password" class="validate" required>
                                      <span class="red-text"></span>
                                  </div>
                              </div> <!--End Password Field -->
                             <!--  <h6 style="padding-left: 10px;" ><a tabindex="-1" href="#" class="white-text"><i>Change password</i></a></h6> -->
                             <div class="row"> <!-- Login Action -->
                                  <div id="loginAction">
                                      <button type="submit" id="loginBtn" class="btn-flat amber darken-2 waves-effect waves-light col s12 white-text"> Login</button>
                                  </div>
                            </div> <!--End Login Action -->
            </form> <!--End Login Form-->
        </div> <!--End Login styling classes-->
    </div> <!--End Center align login box-->
</div> <!--End Login Box-->

 <script src="<?php echo base_url('vendor/materialize/js/materialize.min.js');?>"></script>
 <script src="<?php echo base_url('vendor/fireblight/js/user.js');?>"></script>

</body>
</html>
