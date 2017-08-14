
    <div class="col-sm-9 col-md-9">
        <div class="well">
            <h1 class="page-header">Welcome and <?php echo $this->session->userdata('userID');?></h1>
        </div>
    </div>

    <div class="row">
    <div class="col s12">
      <div class="row">
        <div class="input-field col s12">
          <i class="material-icons prefix">textsms</i>
          <input type="text" id="autocomplete-input" class="autocomplete">
          <label for="autocomplete-input">Autocomplete</label>
        </div>
      </div>
    </div>
  </div>
<button id="foo">TEST</button>

<div id="appointmentModal" class="modal">
    <div class="modal-content">
      <h4 class="modal-title">Create appointment</h4>
      <form autocomplete="off" id="appointmentForm">
         <input type="hidden" name="user_id" value="<?php echo $this->session->userdata('user_id');?>">
         <input type="hidden" name="patient_id" disabled="" value="">
         <div class="row">
            
                  <div class="input-field s7">
                        <input type="text" name="patient_name" id="patient_name" class="autocomplete" required>
                        <label>Patient Name</label>
                  </div>
  
        </div>
         <div id="appointdatepicker">
              <label>Appointment Date</label>
              <input style="margin-bottom: 0;" name="appointmentDate" type="text" class="datepicker" id="appointmentDate" placeholder="Select appointment date" required>
         </div>
    </div>
    <div class="modal-footer">
        <button id='appoint' class="btn-flat blue-grey darken-4 waves-effect waves-red white-text" disabled>Create Appointment</button>
    </div>
    </form>
  </div>