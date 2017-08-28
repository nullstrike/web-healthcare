<div class="row">
      <div class="col s12 m10 offset-m1" style="padding-top:40px;">
        <div class="card-panel white">
            <div id="calendar"></div>
        </div>
      </div>
    </div>

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
  <div id="appointmentDetail" class="modal">
    <div class="modal-content white-text  blue-grey darken-4">Create consultation -  <span id="date"></span> </div>
    <div class="modal-content" id="patient_info">
 
  
	 			<div class="row" id="patient_header_view">
					 <div class="left">
						 <h3 id="patient_name"></h3>
						 <div class="divider" id="patient_header_divider"></div>
					 </div>
					 <div class="right" id="patient_health_info">
						 <ul>
					 	 <li>Patient ID: <label id="patient_id"></label></li>
					     <li>Height: <label id="patient_height"></label><span style="color:#957E7E"> cm</span></li>
						 <li>Weight: <label id="patient_weight" ></label><span style="color:#957E7E"> kg</span></li>
						 <li>BloodType: <label id="patient_bloodtype"></label></li>			
						</ul>
					 </div>
				 </div>
			<div id="patient_info" class="row blue-grey darken-4 white-text " style="padding-bottom:10px">
					 <div class="col s2">
						 Gender: <label id="patient_gender" class="white-text"></label>
					 </div>
					 <div class="col s2">
             Birthdate:<label id="patient_bdate" class="white-text"></label>
					 </div>
					<div class="col s1">
             Age: <label id="patient_age" class="white-text"></label>
					</div>
					<div class="col s4">
             Address: <label id="patient_address" class="white-text"></label>
					</div>
					<div class="col s3">
             Contact: <label id="patient_contact" class="white-text"></label>
					</div>
			</div>	
			<div class="row">
					<div class="col s12">
						<form autocomplete="off" id="consultForm">
							<div class="input-field">
								<textarea  class="materialize-textarea" name="diagnosis" id="" cols="30" rows="10"></textarea>
								<label for="diagnosis">Diagnosis</label>
							</div>
							<div class="input-field">
								<textarea class="materialize-textarea" name="prescription" id="" cols="30" rows="10"></textarea>
								<label for="prescription">Prescription</label>
							</div>
							<button class="btn-flat right red waves-effect waves-light white-text">Add Consultation</button>
						</form>
			
	
	
 		 </div>

    </div>
  </div>
  <div id="appointmentFullDetail" class="modal">
    <div class="modal-content ">
    <ul class="collection with-header" id="list_appoint">
        <li class="collection-header"><span id="appoint_title"></span></li>
      </ul>
    </div>
  </div>
