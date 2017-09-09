<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="ui centered grid container"> <!--main container -->
  <div class="six wide column" id="updateWrapper"> <!--main wrapper -->
    <h5 class="ui top attached block header">Update user information</h5>
      <div class="ui bottom attached segment">
            <div class="ui message transition hidden">
                <i class="close icon"></i>
            </div>
          <form class="ui form" method="post" id="updateForm" autocomplete="off">
              <input type="hidden" name="userID" value="<?php echo $this->session->userdata('userID');?>">
              <input type="hidden" name="user" value="<?php echo $this->session->userdata('userName');?>">
              <?php if ($this->session->userdata('userName') === 'doctor'): ?>
                <div class="two fields"> <!-- two field -->
                    <div class="field">
                          <input type="text" name="firstName"  placeholder="First Name">
                    </div>
                    <div class="field">
                          <input type="text" name="lastName" placeholder="Last Name">
                    </div>
                </div> <!--/ two field -->
              <div class="field">
                  <input type="text" name="contactNum" placeholder="Contact Number">
              </div>
                <?php endif; ?>
              <div class="ui disabled field">
                  <input type="text" name="userName" value="<?php echo $this->session->userdata('defaults');?>" placeholder="Username" tabindex="-1">
              </div>
              <div class="field">
                  <input type="password" name="userPass" placeholder="Password">
              </div>
              <div class="field">
                  <input type="password" name="userpassConf" placeholder="Confirm Password">
              </div>
              <button type="submit" class="ui button fluid primary">Update</button>
        </form>
      </div> <!-- end segment div -->
  </div> <!--/ main wrapper -->
</div> <!--/ main container -->
<script>
alert("<?php echo $this->session->userdata('default');?>");
</script>