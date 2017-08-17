<ul id="slide-out" class="side-nav fixed z-depth-4 blue accent-3" >
    <li class="center no-padding">
        <div id="nav-left-fixed">
            <div class="row">
                <img alt="aguilar clinic logo here" id="img-logo" src="<?php echo base_url('vendor/fireblight/images/Aguilar Clinic.png');?>" class=" responsive-img" />
            </div>
        </div>
    </li>

    <a href="<?php echo site_url('dashboard');?>">
    <li id="dashboard">
        <div class="collapsible-header waves-effect">
            <i class="material-icons">dashboard</i>
            <!--<b>Dashboard</b>-->
            Dashboard
        </div>
    </li>
    </a>
    <a href="<?php echo site_url('dashboard/user');?>">
    <li id="user">
        <div class="collapsible-header waves-effect">
            <i class="material-icons">group</i>
            <b>Users</b>
          </div>
    </li>
    </a>
    <a href="<?php echo site_url('dashboard/patient');?>">
    <li id="patient">
        <div class="collapsible-header waves-effect">
            <i class="material-icons">assignment_ind</i>
            <b>Patient</b>
        </div>
    </li>
    </a>
    <a href="<?php echo site_url('dashboard/appointment');?>">
    <li id="appointment">
        <div class="collapsible-header waves-effect">
            <i class="material-icons">event_note</i>
            <b>Appointments</b>
        </div>
    </li>
    </a>
   <!--   <a href="<?php echo site_url('dashboard/consultation');?>">
    <li id="consultation">
        <div class="collapsible-header waves-effect">
            <i class="material-icons">local_hospital</i>
            <b>Consultations</b>
        </div>
    </li>
    </a> -->
    <div id="attribution">
   <span>Aguilar Clinic &copy; 2017</span>
   </div>
</ul>
</ul>

<header>

    <nav class="blue darken-3" role="navigation">
        <div class="nav-wrapper">
            <a href="#" data-activates="slide-out" class="button-collapse show-on-medium"><i class="material-icons">menu</i></a>
            <a href="#" id="brand-logo" class="brand-logo">Healthcare Management System</a>
            <ul class="right hide-on-med-and-down" id="nav-menu">
                <li>
                    <a class='dropdown-button white-text' href='#' data-activates="dropdown" data-beloworigin="true"><i class=' material-icons right'>arrow_drop_down</i><?php echo $this->session->userdata('userName');?></a>
                </li>
            </ul>

            <a href="#" data-activates="slide-out" class="button-collapse"><i class="mdi-navigation-menu"></i></a>
        </div>
    </nav>

    <ul id='dropdown' class='dropdown-content'>
        <li><a href="#!"><i class="material-icons">timelapse</i>User Log</a></li>
        <li><a href="<?php echo base_url('user/user_logout/');?>"><i class="material-icons">exit_to_app</i>Logout</a></li>

    </ul>
</header>
<div class="divider"></div>
<main id="content-wrapper" class="grey lighten-4">
<?php echo $content; ?>
</main>
