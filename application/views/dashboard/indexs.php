<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!--for loader-->
<div class="loader"></div>

<!--content start-->
<div class="col-md-4 col-md-push-4" id="userform-wrapper">
    <div id="userform-box">
        <form id="new-userform" method="post" action="<?php echo site_url('user/user_add');?> ">
            <div class="form-group">
                <label for="firstName">First name</label>
                <input type="text" name="firstname" class="form-control" placeholder="First name">
                <span class="text-danger"></span>
            </div>
            <div class="form-group">
                <label for="middleName">Middle name - <i class="text-muted">Optional</i></label>
                <input type="text" name="middlename" class="form-control" placeholder="Middle name">
                <span class="text-danger"></span>
            </div>
            <div class="form-group">
                <label for="lastName">Last name</label>
                <input type="text" name="lastname" class="form-control" placeholder="Last name" required>
                <span class="text-danger"></span>
            </div>
            <div class="form-group" >

                <label >Job Type</label>

                    <div class="form-check" >
                    <label class="radio-inline">
                        <input name="job" type="radio" value="doctor">
                        Doctor
                    </label>
                    <label class="radio-inline">
                        <input name="job" type="radio" value="receptionist">
                        Receptionist
                    </label>

                    </div>
                <div>
                <input type="radio" name="job" value="" checked hidden>
                <span class="text-danger"></span>

                </div>

            </div>

            <h3>Account</h3>
            <hr>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Username">
                <span class="text-danger"></span>
            </div>
            <label class="small text-muted"><i> -Password is set to "default"</i></label>
           <!-- <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" value="default" class="form-control" placeholder="Password">
            </div>-->
            <hr>
            <button type="submit" id="add-user" class="btn btn-primary form-control">Add new user</button>
        </form>
</div>
</div>


