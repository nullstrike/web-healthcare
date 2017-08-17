<div class="row">
  <div id="admin" class="col s12">
    <div class="card material-table">
      <div class="table-header">
        <span class="table-title">Patient List</span>
        <div class="actions">
          <a class="waves-effect btn-flat nopadding" id="addPatient"><i class="material-icons">person_add</i></a>
          <a class="search-toggle waves-effect btn-flat nopadding"><i class="material-icons">search</i></a>
        </div>
      </div>
      <table id="patientList">
        <thead>
          <tr>
            <th>Patient ID</th>
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Last Name</th>
            <th></th>
          </tr>
        </thead>
   
      </table>
    </div>
  </div>
</div>
  <div id="patientModal" class="modal">
    <div class="modal-content blue-grey darken-4 white-text">
        <h4 class="modal-title"></h4>
    </div>
    <div class="modal-content">
    <form autocomplete="off" id="patientForm">
   
    <input type="hidden" name="patient_id">
     <div class="row">
        <div class="input-field col s4">
                <label for="firstname">First Name</label>
                <input type="text" name="firstname" value="" required class="validate">
                <span></span>
        </div> 
         <div class="input-field col s4">
                <label for="middlename">Middle Name</label>
                <input type="text" name="middlename"  class="validate">
                <span></span>
        </div>  
         <div class="input-field col s4">
                <label for="lastname">Last Name</label>
                <input type="text" name="lastname" required class="validate">
                <span></span>
        </div>    
    </div>
    <div class="row">
        <div class="col s5 input-field">
                <select name="gender" required class="validate">
                    <option value=" " disabled selected>Select the gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
                <label>Gender</label>
        </div>
       
        <div class="col s5 select-field"  >
               <label>Birthdate</label>
                <input type="text" name="birthdate" id="patientDate" class="datepicker" style="padding:0;margin-top:-7px;" required>          
                   
        
        </div>
        <div class="col s2 input-field" >
                <input type="text" name="age" value=" " readonly>
                <label>Age</label>
        </div>
        
    </div>
    <div class="row">
        <div class="input-field col s3">
                <label for="firstname">Height (cm)</label>
                <input type="text" name="height" maxlength="5" required class="validate">
                <span></span>
        </div> 
         <div class="input-field col s3">
                <label for="middlename">Weight (kg)</label>
                <input type="text" name="weight" maxlength="5" required class="validate">
                <span></span>
        </div>  
         <div class="input-field col s6">
                <select name="bloodtype" required class="validate">
                    <option value=" " disabled selected>Select the blood type</option>
                    <option value="A-">Blood Type A - Negative</option>
                    <option value="A+">Blood Type A - Positive</option>
                    <option value="B-">Blood Type B - Negative</option>
                    <option value="B+">Blood Type B - Positive</option>
                    <option value="AB-">Blood Type AB - Negative </option>
                    <option value="AB+">Blood Type AB - Positive</option>
                    <option value="O-">Blood Type O - Negative</option>
                    <option value="O+">Blood Type O - Positive </option>
                </select>
                <label>Blood Type</label>
                <span></span>
        </div>    
    </div>
    <div class="row">
        <div class="input-field col s7">
                <label>Address</label>
                <input type="text" name="address" required class="validate">
                <span></span>
        </div> 
         <div class="input-field col s5">
                <label>Contact Number</label>
                <input type="text" name="contact" required class="validate">
                <span></span>
        </div>    
    </div>
    <div class="modal-footer">
        <button class="btn blue darken-4" type="submit" id="patient_action"></button>
    </div>
  </div>
  </form>
</div>

<div class="modal" role="dialog" id="consultDialog">
    <div class="modal-content teal white-text" id="header">
        <span class="modal-title ">Consultation Form</span>
    </div>
    <div class="modal-content">
    <form id="consultForm" autocomplete="off">
        <div class="row">
            <div class="col s6">
                <div class="input-field">
                     <input type="hidden" name="patient_id" >
                     <input type="text" name="patient_fname" value=" " readonly>
                     <label class="active">First Name</label>
                </div>
            </div>
             <div class="col s6">
                <div class="input-field">
                     <input type="text" name="patient_lname" value=" " readonly>
                     <label class="active">Last Name</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s3">
                <div class="input-field">
                    <input type="text" name="patient_gender" value=" " readonly>
                    <label class="active">Gender</label>
                </div>
            </div>
            <div class="col s3">
                <div class="input-field">
                    <input type="text" name="patient_bloodtype" value=" " readonly>
                    <label class="active">Blood&nbsp;type</label>
                </div>
            </div>
            <div class="col s3">
                <div class="input-field">
                    <input type="text" name="patient_weight" value=" " readonly>
                    <label>Weight</label>
                </div>
            </div>
            <div class="col s3">
                <div class="input-field">
                    <input type="text" name="patient_height" value=" " readonly>  
                    <label class="active">Height</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
                <div class="input-field">
                    <textarea name="diagnosis" class="materialize-textarea"></textarea>
                    <label for="diagnosis">Diagnosis</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <label for="prescription">Prescription</label>
                <textarea name="prescription" class="materialize-textarea"></textarea>   
                </div>
            </div>

      </form>
    </div>
    <div class="modal-footer">
        <button id="consult" class="btn-flat red white-text waves-effect waves-light">Add Consultation</button>
    </div>
</div>
