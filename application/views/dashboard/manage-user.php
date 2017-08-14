<div class="row" style="padding-top:10px;">
    <div class="col s12 ">
        <ul class="tabs blue-grey darken-3">
            <div class="indicator red" style="z-index:1"></div>

            <li class="tab col s6 "><a class="active white-text" href="#registerTab">Add user</a></li>
            <li class="tab col s5"><a class="white-text" href="#viewUserTab">View user</a></li>

        </ul>
    </div>
    <div id="registerTab" class="col s12">
        <div class="row" style="padding-top:30px;">
            <div class="col m6 offset-m3 black-text">
                <div class="card white darken-1">
                    <div class="card-content">
                        <form autocomplete="off" id="registerForm">
                            <span class="card-title" style="font-size: 1.2rem;">User Information</span>

                            <div class="row">
                                <div class="input-field col s6">
                                    <label for="First Name">First Name</label>
                                    <input name="firstname"  type="text" class="validate" required>
                                    <span class="red-text"></span>
                                </div>
                                <div class="input-field col s6">
                                    <label for="Last Name">Last Name</label>
                                    <input name="lastname" type="text" class="validate" required>
                                    <span class="red-text"></span>
                                </div>
                                <div class="input-field col s12">
                                    <select name="title" required>
                                        <option value="" disabled selected>Choose your option</option>
                                        <option value="doctor">Doctor</option>
                                        <option value="receptionist">Receptionist</option>
                                    </select>
                                    <label for="Title">Job Type</label>
                                    <span class="red-text"></span>
                                </div>
                                <div class="input-field col s12">
                                    <label for="Username">Username</label>
                                    <input name="username" type="text" class="validate" required>
                                    <span class="red-text"></span>
                                </div>
                            </div>
                    </div>
                    <div class="card-action right-align">
                        <button  type="submit" class="btn blue-grey darken-4  waves-effect waves-light">Add user</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="viewUserTab" class="col s12">
        <div class="container">
            <table class="bordered">
                <tbody>
                <td>test</td>
                </tbody>
            </table>
        </div>
    </div>

</div>
