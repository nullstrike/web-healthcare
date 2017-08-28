<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row"> <!--Grid -->
  <div class="row" id="greet_wrapper"> <!--Greet Wrapper-->
      <div class="col s12 m12 l12" id="greet_block"> <!--Greet Block -->
        <div class="left"> <!-- Greet Name section-->
          <span id="greet_name" >Welcome <?php echo $this->session->userdata('name');?></span>
        </div> <!--End Greet Name section-->
        <div class="right"> <!--Greet Desc section-->
          <span>Check upcoming appointments, patient visits, clinic analytic insights and more.</span>
        </div> <!--End Greet Desc section-->
      </div> <!--End Greet Block -->
  </div> <!--End Greet Wrapper -->

  <div class="col s8"> <!--First column -->
      <div class="row">
        <div class="col s4">
          <div class="card horizontal">
            <div class="card-image valign-wrapper blue darken-2">
              <i class="material-icons md-75 white-text">person</i>
            </div>
            <div class="card-stacked blue">
              <div class="card-content white-text">
                <p for="patient_num" id="label_patient">Total Patients</p>
                <p class="figures" id="patient_num"></p>
              </div>
            </div>
          </div>
        </div>
        <div class="col s4">
          <div class="card horizontal">
            <div class="card-image valign-wrapper red darken-2">
              <i class="material-icons md-75 white-text">local_hospital</i>
            </div>
            <div class="card-stacked red lighten-1 ">
              <div class="card-content white-text">
                <p for="patient_num" id="label_patient">Visits this Week</p>
                <p class="figures" id="patient_week-visit"></p>
              </div>
            </div>
          </div>
        </div>
        <div class="col s4">
          <div class="card horizontal">
            <div class="card-image valign-wrapper green darken-2">
              <i class="material-icons md-75 white-text">trending_up</i>
            </div>
            <div class="card-stacked green ">
              <div class="card-content white-text">
                <p for="patient_num" id="label_patient">New Patients</p>
                <p class="figures" id="new_patient_num">s</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row"> <!--First Nested Column -->
        <div class="card-panel"> <!-- Chart block -->
            <canvas id="quarterInfoChart" ></canvas> <!-- Canvas for chart -->
        </div> <!--End Chart block -->
      </div> <!--End First Nested Column -->
      <div class="row">
            <div class="col s7">
                <canvas id="commonDiagChart" width="300" height="300"></canvas>

            </div>
            <div class="col s5">
              <div class="card-panel white">
                <canvas id="typeInfoCharts" width="300" height="300"></canvas>
              </div>

            </div>
      </div>
  </div> <!-- End First column -->

  <div class="col s4"> <!--Second column -->
    <ul class="collection">
      <li class="collection-item block-header"><h5>Clinic Visit Type</h5></li>
      <li>
        <div class="card-panel card-wrapper">
            <canvas id="typeInfoChart" width="200" height="150"></canvas>
        </div>

</li>
    </ul>




    <ul class="collection" id="appointList">
      <li class="collection-item block-header">
        <h5>Upcoming Appointments</h5>
      </li>

    </ul>

  </div> <!--End Second column-->
</div> <!--End Grid -->
