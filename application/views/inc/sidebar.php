<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>


<div class="ui inverted blue menu" id="header">

        <div class="header middle aligned active item">
        <p id="brand">Aguilar Clinic</p>
            <!-- <img src="<?php echo base_url('vendor/fireblight/images/aguilar-clinic-logo.png');?>" alt="Aguilar Clinic" class="ui small image"> -->
          </div>

        <div class="right menu">
          <div class="ui simple dropdown item">
            <?php echo $this->session->userdata('name');?>
              <i class="dropdown icon"></i>
              <div class="menu">
                   <!-- <a href="#" class="item">  
                     <i class="book icon"></i>
                     Userlog
                   </a> -->
                   <a href="<?php echo base_url('user/user_logout');?>" class="item">
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
                  <a class="item" href="<?php echo site_url('dashboard/user');?>">
                    <i class="user outline icon"></i>
                    User
                  </a>

                  <a class="item" href="<?php echo site_url('dashboard/patient');?>">
                    <i class="first aid icon"></i>
                    Patient
                  </a>
                  <a class="item" href="<?php echo site_url('dashboard/appointment');?>">
                    <i class="add to calendar icon"></i>
                    Appointment
                  </a>
                  <a class="item" href="<?php echo site_url('dashboard/consultation');?>">
                    <i class="treatment icon"></i>
                    Consultation
                  </a>
                  <a class="ui item collapse">
                       <i class="pie chart icon "></i>
                       Reports
                  </a>
                  <div class="collapse-wrapper" >
                          <div class="ui secondary vertical menu">
                              <a class="item" href="<?php echo site_url('dashboard/reports/diagnostic');?>">
                                  <i class="book icon"></i>
                                    Prescription
                              </a>
                              <a class="item">
                                  <i class="hospital icon"></i>
                                    Diagnosis
                              </a>
                              <a class="item">
                                  <i class="payment icon"></i>
                                    Payment
                              </a>
                        </div>
                  </div>
                </div>

        </div>
