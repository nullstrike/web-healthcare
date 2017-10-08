<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $user_type = $this->session->userdata('userTitle'); ?>

<div class="ui  inverted blue menu" id="header">

        <div class="header middle aligned item">
        <p id="brand">Aguilar Clinic</p>
            <!-- <img src="<?php echo base_url('vendor/fireblight/images/aguilar-clinic-logo.png');?>" alt="Aguilar Clinic" class="ui small image"> -->
          </div>

        <div class="right menu">
          <div class="ui dropdown item" id="upcoming">
            <i class="alarm outline large icon"></i>
            <div class=" ui green small label" id="upcoming_count"></div>
            <div class="ui menu  relaxed divided list " id="count_wrapper">
            <div class="header" style="font-weight:normal">
              <span class="" style="font-size:1.39rem; text-transform:none;">Upcoming Appointments</span>
            </div>
            <div class="ui divider"></div>
            </div>
         </div>
        </div>
          <div class="ui simple dropdown item">
            <?php echo $this->session->userdata('userName');?>
              <i class="dropdown icon"></i>
              <div class="menu">
                  <?php if ($this->session->userdata('userTitle') === 'doctor') : ?>
                   <a href="<?php echo base_url('user/log');?>" class="item">
                     <i class="book icon"></i>
                     Userlog
                   </a>
                 <?php endif; ?>
                   <!-- <a href="#" class="item"> <i class="setting icon"></i>Manage Account</a> -->
                   <a href="<?php echo base_url('user/userLogout');?>" class="item">
                       <i class="sign out icon"></i>
                       Sign out
                   </a>

             </div>
          </div>
        </div>
      </div>

      <div class="ui grid" style="margin-top:0; " id="content-wrapper">
        <div class="three wide column" id="sidebar" style="padding-top:0;padding-bottom:0;background:rgba(0,0,0,.03);" >
                <div class="ui inverted vertical menu" id="" style="min-height:100vh;height:100%;border-radius:0;width:16.5em !important;" >
                  <div class="item" id="welcome-info">
                      <span>Welcome, <b><?php echo $this->session->userdata('name');?></b> </span>
                  </div>
                  <a class="item" href="<?php echo site_url('dashboard/');?>">
                    <i class="dashboard icon"></i>
                    Dashboard
                  </a>

                  <?php if ($user_type === 'doctor'): ?>
                  <a class="item" href="<?php echo site_url('dashboard/user');?>">
                    <i class="user outline icon"></i>
                    User
                  </a>
                  <?php endif; ?>

                  <a class="item" href="<?php echo site_url('dashboard/patient');?>">
                    <i class="first aid icon"></i>
                    Patient
                  </a>

                  <a class="item" href="<?php echo site_url('dashboard/appointment');?>">
                    <i class="add to calendar icon"></i>
                    Appointment
                  </a>

                  <?php if ($user_type === 'doctor'): ?>
                  <a class="item" href="<?php echo site_url('dashboard/consultation');?>">
                    <i class="treatment icon"></i>
                    Consultation
                  </a>
                  <?php endif;?>
                  <a class="item" href="<?php echo site_url('dashboard/reports');?>">
                       <i class="pie chart icon "></i>
                       Reports
                  </a>
                </div>

        </div>
