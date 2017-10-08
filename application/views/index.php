
      <div class="ui container middle aligned center aligned grid" id="loginWrapper" >
      <div class="six wide column">
        <form class="ui form" autocomplete="off" id="loginForm" method="post">
          <div class="ui stacked segment">
              <img src="<?php echo base_url('vendor/fireblight/images/aguilar-clinic-logo-main.png');?>" class="ui image">
              <div class="ui message transition hidden">
                    <i class="close icon"></i>
                    <div class="validation_message"></div>
              </div>

            <div class="field username">
              <div class="ui medium icon input">
                <i class="user icon"></i>
                <input type="text" name="username" placeholder="Username">

              </div>
            </div>
            <div class="field password">
              <div class="ui medium icon input">
                <i class="lock icon"></i>
                <input type="password" name="password" placeholder="Password">

              </div>
            </div>
                <!-- <a href="#" class="pull-left">Forgot Password?</a> -->
            <button class="ui fluid large blue button">Login</button>
          </div>
        </form>
      </div>
    </div>

<!-- <div id="forgotPW" class="ui mini modal">
<div class="header">Forgot Password</div>
<div class="content">
  <form action="" class="ui form">
    <div class="field">
      <label>Username: </label>
      <input type="text" name="" value="">
    </div>
    <div class="field">
      <label>Security Question</label>
      <select class="ui simple dropdown" name="">
        <option value="1">What is your maiden name?</option>
        <option value="2">Where is your birthplace?</option>
        <option value="3">What province/city did you come from?</option>
        <option value="4">What is your nickname?</option>
        <option value="5">What is your favorite color?</option>
      </select>
    </div>
    <div class="field">
      <label>Answer: </label>
      <input type="text" name="" value="">
    </div>
  </form>
</div>
<div class="actions">
  <button id="findPW" type="button" class="ui positive right labeled icon button">
    Check user
    <i class="find icon"></i>
  </button>
</div>

</div> -->
