
      <div class="ui container middle aligned center aligned grid" id="loginWrapper" >
      <div class="six wide column">
        <form class="ui form" autocomplete="off" id="loginForm">
          <div class="ui stacked segment">
              <img src="<?php echo base_url('vendor/fireblight/images/aguilar-clinic-logo.png');?>" class="ui image">
              <div class="ui message transition hidden">
                    <i class="close icon"></i>
                  <h3 class="header"></h3>
              </div>

            <div class="field">
              <div class="ui medium labeled left icon input">
                <i class="user icon"></i>
                <input type="text" name="username" placeholder="Username">
                <div class="ui corner label">
                    <i class="asterisk icon"></i>
                </div>
              </div>
            </div>
            <div class="field">
              <div class="ui medium labeled left icon input">
                <i class="lock icon"></i>
                <input type="password" name="password" placeholder="Password">
                <div class="ui corner label">
                    <i class="asterisk icon"></i>
                </div>
              </div>
            </div>
            <button class="ui fluid large blue button">Login</button>
          </div>
        </form>
      </div>
    </div>
