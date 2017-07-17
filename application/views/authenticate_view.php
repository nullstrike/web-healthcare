<!--Login container/wrapper-->
<div class="container" id="login-wrapper">
    <!--Login box -->
    <div id="login-box" class="col-md-6 col-md-offset-3">
        <!--Login Title-->
        <h3>Logged In to System</h3>
        <!--Login Desc-->
        <h5 class="text-muted" title='Username is either "doctor" or staff. Password is default and will need to be changed afterwards for security purposes.'><em>All fields required</em></h5>

        <!--Login Error Display-->
      <div class="ui-widget">
          <div class="ui-state-error ui-corner-all">
              <p><span class="ui-icon ui-icon-alert"></span><p id="error"></p></p>
          </div>
      </div>
        <!--End Login Error Display -->

        <!--Login Form-->
        <form id="loginform" method="post">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Username" name="username" required>
            </div>
            <div class="form-group">
                <input type="password" id="pass" class="form-control" placeholder="Password" name="password">
            </div>
            <button class="btn btn-success form-control" type="button">Login</button>
        </form><!--End Login Form-->
    </div> <!--End Login Box-->
</div> <!--End Login Container/Wrapper-->

<script>
    $(".ui-widget").hide();
    $("button").on('click',function(){
       $.ajax({
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

       });
    })
</script>