<?php
/**
 * Created by PhpStorm.
 * User: n3far1ous
 * Date: 7/10/17
 * Time: 1:29 PM
 */
?>

<div class="loader"></div>
<div class="col-md-4 col-md-push-4" id="userform-wrapper">
    <div id="userform-box">
        <!--<h3 class="lead" style="padding-left:30px;"></h3>
        <hr>-->

        <form id="new-userform">
            <div class="form-group">
                <label for="firstName">First name</label>
                <input type="text" name="firstname" class="form-control" placeholder="First name">
            </div>
            <div class="form-group">
                <label for="middleName">Middle name - <i class="text-muted">Optional</i></label>
                <input type="text" name="middlename" class="form-control" placeholder="Middle name">
            </div>
            <div class="form-group">
                <label for="lastName">Last name</label>
                <input type="text" name="lastname" class="form-control" placeholder="Last name">
            </div>
            <div class="form-group">
                <label >Job Type</label>
                    <div class="form-check">
                    <label class="radio-inline">
                        <input name="job" type="radio" value="doctor">
                        Doctor
                    </label>
                    <label class="radio-inline">
                        <input name="job" type="radio" value="receptionist">
                        Receptionist
                    </label>
                    </div>
            </div>



            <h3>Account</h3>
            <hr>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Username">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Password">
            </div>
            <div class="form-group">
                <label for="confpassword">Verify Password</label>
                <input type="password" name="confpassword" class="form-control" placeholder="Password Again">
            </div>
            <hr>
            <button type="button" id="add-user" class="btn btn-primary form-control">Add new user</button>
        </form>
</div>
</div>
<script>
    $(function(){
        $("#add-user").on('click',function(){
           $.ajax({
              url: '<?php echo site_url("user/user_add")?>',
               data: $('#new-userform').serialize(),
               dataType:'json',
               type:'POST',
               success: function (data) {
                   alert(data);
               }
           });
        });
    })
</script>
