
<form action="#" method="post" id='userform' class="form-horizontal">
    <!--first column div-->
    <input type="text" id="user_id" hidden value="<?php echo $this->session->userdata('user_id');?>">


    <!--First Name Input-->
    <div class="form-group">
        <label for="firstname">First&nbsp;Name:</label>
        <input type="text" id="firstname" name="firstname" class="form-control">
    </div>

    <!--Middle Name Input-->
    <div class="form-group">
        <label for="middlename" class="control-label col-md-3">Middle&nbsp;Name:</label>
        <div class="col-md-9">

            <input type="text" name="middlename" class="form-control">

        </div>
    </div>

    <!--Last Name Input-->
    <div class="form-group">
        <label for="lastname" class="control-label col-md-3">Last&nbsp;Name:</label>
        <div class="col-md-9">

            <input type="text" name="lastname" class="form-control">

        </div>
    </div>


    <!--Contact Number Input -->
    <div class="form-group">
        <label for="contact" class="control-label col-md-3">Contact&nbsp;Number:</label>
        <div class="col-md-8">
            <input type="text" name="contact" class="form-control">
        </div>
    </div>

    <!--Username Input -->
    <div class="form-group">
        <label for="username" class="control-label col-md-3">Username:</label>
        <div class="col-md-9">

            <input type="text" name="username" class="form-control">

        </div>
    </div>

    <!--Password Input -->
    <div class="form-group">
        <label for="password" class="control-label col-md-3">Password:</label>
        <div class="col-md-9">

            <input type="text" name="password" class="form-control">

        </div>
    </div>

    <!--Confirm Password Input -->
    <div class="form-group">
        <label for="confpassword" class="control-label col-md-3">Confirm&nbsp;Password:</label>
        <div class="col-md-9">

            <input type="text" name="confpassword" class="form-control">

        </div>
        <?php echo form_error('password');?>
    </div>

    <!--User type Select-->
    <div class="form-group">
        <label for="user_type" class="control-label col-md-3">User Type:</label>
        <div class="col-md-9">

            <select name="user_type" class="form-control">
                <option hidden selected></option>
                <option value="doctor">Doctor</option>
                <option value="staff">Staff</option>
            </select>

            <?php echo form_error('confpassword');?>
        </div>
        <!-- end first column div-->
        <!--<div class="pull-right" style="padding-right:20px;">
            <button type="button" id="user-update" class="btn btn-info btn-md ">Update&nbsp;</button>
            <button type="button" id="cancel" class="btn btn-danger ">sfa</button></div>

    </div>
-->



        <button type="button" class="btn btn-primary btn-sm"><span class="ui-icon ui-icon-plus"></span>Add new user</button>
</form>