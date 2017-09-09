<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="ui padded segment boxed" id="dashboard-info"> <!--dashboard info wrapper -->
      <h5 class="ui header">Manage User</h5>
      <label>This is where you can manage users like updating and adding users.</label>
</div> <!--/ dashboard info wrapper -->

<!-- alert message -->
<div class="ui icon positive message hidden">
  <i class="check circle outline green icon"></i>
  <div class="content">
    <div class="header">
    </div>
  </div>
</div>
<!--/ alert message -->

<div id="user_table_wrapper" class="ui segment ">
  <table id="user_table" class="ui selectable celled compact table " cellspacing="0" width="100%">
          <thead>
              <tr>
                  <th>ID</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Username</th>
                  <th>User Title</th>
              </tr>
          </thead>

      </table>
</div>
<div class="ui mini modal" id="user_modal">

  <div class="header">
    Add user
  </div>
  <div class="ui icon tiny info message modal-message">
    <i class="info circle icon" id="message-icon"></i>
    <div class="content">
          <h4>The password is set to "default".</h4>
    </div>

  </div>
  <div class="content">
    <form class="ui form"  id="user_form" autocomplete="off">
      <div class="ui fluid required  field">
        <label>First Name</label>
        <input type="text" name="firstname"  placeholder="First Name">
      </div>
      <div class="ui fluid required field">
        <label>Last name</label>
        <input type="text" name="lastname" placeholder="Last Name">
      </div>
      <div class="ui fluid required field">
        <label>Username</label>
        <input type="text" name="username" placeholder="Username">
      </div>

    </div>
    <div class="actions">
          <button class="ui button blue" id="btnAction" type="submit">Add user</button>
          </form>
    </div>

</div>
