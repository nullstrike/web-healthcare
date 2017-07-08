<?php
/**
 * Created by PhpStorm.
 * User: n3far1ous
 * Date: 7/8/17
 * Time: 12:15 AM
 */
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container">
    <form action="<?php echo site_url('user/user_update');?>" method="post">
        <div class="form-group">
            <label for="lname" class="control-label">First Name:</label>
            <div class="col-md-9">  <input type="text" name="lname" class="form-control"></div>

            <button class="btn btn-danger">Submit</button>
        </div>
    </form>
</div>