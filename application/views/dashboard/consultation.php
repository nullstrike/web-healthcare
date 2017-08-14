 <div class="row">
 <div class="col s8 offset-s2 card-panel" style="padding-top:20px;">
 <form id="consultForm" autocomplete="off">
        <div class="row">
            <div class="col s6">
                <div class="input-field">
                     <input type="text" name="patient_fname" value=" ">
                     <label class="active">First Name</label>
                </div>
            </div>
             <div class="col s6">
                <div class="input-field">
                     <input type="text" name="patient_lname" value=" ">
                     <label class="active">Last Name</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s3">
                <div class="input-field">
                    <input type="text" name="patient_bloodtype" value=" ">
                    <label class="active">Gender</label>
                </div>
            </div>
            <div class="col s3">
                <div class="input-field">
                    <input type="text" name="patient_bloodtype" value=" ">
                    <label class="active">Blood&nbsp;type</label>
                </div>
            </div>
            <div class="col s3">
                <div class="input-field">
                    <input type="text" name="patient_weight" value=" ">
                    <label>Weight</label>
                </div>
            </div>
            <div class="col s3">
                <div class="input-field">
                    <input type="text" name="patient_height" value=" ">  
                    <label class="active">Height</label>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col s12 ">
                <div class="input-field">
                 
                     <label for="diagnosis">Diagnosis</label>
                    <textarea name="diagnosis" class="materialize-textarea"></textarea>
                   
                   
                </div>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <label for="prescription">Prescription</label>
                <textarea name="prescription" class="materialize-textarea"></textarea>   
                </div>
            </div>
        <div class="row">
            <button type="button" id="consult" class="btn-flat red darken-4 waves-effect waves-white white-text right">Add consultation</button>
        </div>
      </form>
      </div>
      </div>