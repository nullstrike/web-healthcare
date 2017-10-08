<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- alert message -->
<div class="ui icon positive message hidden">
  <i class="check circle outline green icon"></i>
  <div class="content">
    <div class="header">
      asdasdasdasdasdasdasdasd
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
      <div class="ui fluid field">
        <label>First Name</label>
        <input type="text" name="firstname"  placeholder="First Name">
        <span class="error text"></span>
      </div>
      <div class="ui fluid field">
        <label>Last name</label>
        <input type="text" name="lastname" placeholder="Last Name">
        <span class="error text"></span>
      </div>
      <div class="ui fluid field">
        <label>Username</label>
        <input type="text" name="username" placeholder="Username">
        <span class="error text"></span>
      </div>

    </div>
    <div class="actions">
          <button class="ui button blue" id="btnAction" type="submit">Add user</button>
          </form>
    </div>

</div>
