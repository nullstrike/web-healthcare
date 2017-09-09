<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div id="choice" style="padding:1em 0">

<label for="">Appointments for today:</label>
<select name="" class="ui dropdown appoint"  id="appointlist">

</select>

<div class="ui checkbox" style="padding-left:1em;">
    <input type="checkbox" name="" id="walk_in">
    <label for="">Walk in Patient?</label>
</div>

<input type="hidden" name="id" id="patient_id">
<input type="hidden" id="consult_type">
<div style="padding-left:27em;padding-top:0.5em;display:none">
<select  name="patient_name" style="width:50%;" id="patient_name">
                </select>
</div>


</div>

<div style="display:none;" id="walk_in_picker">
    <select name="walk_in" class="ui dropdown" id=""></select>
</div>

<div class="ui centered grid" style="padding-top:0.5em;display:none;" id="wizard">

<div class="fourteen wide column" style="padding-bottom:0" >

       <div class="wizard-step">
   
            <div class="header">
                <h3>Patient Information</h3>
            </div>
 

       </div>
    <div class="ui segment">
            <div class="ui grid" style="padding-bottom:1em;" >
                 <div class="twelve wide column" >
                        <h3>Consultation</h3>
                 </div>
                 <div class="four wide column" style="padding-left:4em">
                         <em class="date"></em>
                 </div>
            </div>
            <form class="ui form" id="patientForm">
                 <div class="ui attached segment">
            <h4>Personal Information</h4>
            <div class="fields">
                <div class="six wide field">
                    <label>First Name</label>
                    <input type="text" name="firstname" id="" readonly>
                </div>
                <div class="six wide field">
                    <label>Middle Name</label>
                    <input type="text" name="middlename" id="" readonly>
                </div>
                <div class="six wide field">
                    <label>Last Name</label>
                    <input type="text" name="lastname" id="" readonly>
                </div>
            </div>
            <div class="fields">
                <div class="six wide field">
                    <label>Gender</label>
                    <input type="text" name="gender" id="" readonly>
                </div>
                <div class="six wide field">
                    <label>Date of Birth</label>
                    <input type="text" name="birthdate" id="" readonly>
                </div>
                <div class="six wide field">
                    <label>Age</label>
                    <input type="text" name="age" id="" readonly>
                </div>
            </div>
        </div>
        <div class="ui attached bottom segment">
            <h4>Health-Related Information</h4>
            <div class="fields">
                <div class="six wide field">
                    <label>Blood Group</label>
                    <input type="text" name="bloodtype" readonly id="">
                </div>
                <div class="six wide field">
                    <label>Height</label>
                    <div class="ui input right labeled">
                    <input type="text" name="height" readonly id="">
                    <div class="ui basic label">
                        cm
                    </div>
                    </div>
                    </div>
                <div class="six wide field">
                    <label>Weight</label>
                    <div class="ui input right labeled">
                    <input type="text" name="weight" readonly id="">
                        <div class="ui basic label">
                            kg
                        </div>
                    </div>
                </div>
            </div>
</form>  
        
        <div class="ui grid" style="padding-top:1em;">
                <div class="three column row first-step" >
                    <div class="right floated column" style="padding-right:0">          
                    <button id="before-consult" disabled type="button" class="ui right labeled icon small primary button">
                        <i class="right arrow icon"></i>
                        Proceed to consultation
                    </button>
                 
                    </div>
                </div>
        </div>
</div>
    
</div>
<div class="wizard-step">
        <div class="header">
             <h3>Consultation</h3>
        </div>


</div>
<div class="ui segment">
<div class="ui grid" style="padding-bottom:1em;" >
                 <div class="twelve wide column" >
                        <h3>Consultation</h3>
                 </div>
                 <div class="four wide column"  id="step-two-date">
                         <em class="date"></em>
                 </div>
            </div>
<form class="ui form" id="consultForm">

                <div class="field">
                    <label>Diagnosis</label>
                    <input type="text" name="diagnosis">
                </div>
                <div class="field">
                    <label>Findings</label>
                    <input type="text" name="findings">
                </div>
                <div class="field">
                    <label>Medication</label>
                    <textarea rows="3" name="medication"></textarea>
                </div>
                <div class="field">
                    <label>Note</label>
                    <textarea rows="3" name="note"></textarea>
                </div>
 
</form>
<div class="ui segment">

    <div class="header"><h3>Consultation Log</h3></div>

 
  <table class="ui celled striped table" id="consultation_table" width="100%">
<thead>
  <tr>
    <th>Consultation Date</th>
    <th>Diagnosis</th>
    <th>Findings</th>
    <th>Medication</th>
    <th>Note</th>
  </tr>
</thead>
</table>

 
</div>

<div class="ui grid" style="padding-top:1em;">
                <div class="three column row" style="padding-left: 20.9em!important;margin-left: 1;">
                    <div class="right floated column">          
                    <button id="on-consult" type="button" class="ui right labeled icon small primary button">
                        <i class="treatment icon"></i>
                        Save consultation
                    </button>

                    </div>
                </div>
        </div>  
</div>


<div class="ui mini modal" id="payment_modal">
    <div class="header">Payment details</div>
    <div class="content">
        <form id="payment_form" class="ui equal width form">
            <div class="inline field">
                <h3>Patient Name:   <span id="payee">Jhefrey Sajot</span></h3>
              
            </div>
            <div class="field">
                 <h4>Service Fee</h4>
                 <div class="ui labeled input">
                 <div class="ui basic label">
                      ₱
                    </div>

                 <input type="text" name="payment_amount">
                 </div>
               
            </div>
            <div class=" field">
                <h4>Amount Given</h4>
                <div class="ui labeled input">
                <div class="ui basic label">
                      ₱
                    </div>

                <input type="text" name="payment_given">
                 </div>
            </div>
        </form>
    </div>
    <div class="actions">
      
          
            <button class="ui right labeled icon small primary button" type="button" id="btn_payment">
            <i class="money icon"></i>Save payment</button>
  
       
      </div>
</div>

<!-- 
 <div class="wizard-step">
       <div class="header">
           <h3>Payment</h3>
       </div>
 </div>
        <div class="ui segment">
            <div class="ui grid" style="padding-bottom:1em;" >
                 <div class="twelve wide column" >
                        <h3>Payment details</h3>
                 </div>
            </div>
            <div class="ui  centered grid">
                <div class="eight wide column">
                         <table class="ui very basic single line table">
         <tbody>
    <tr>
      <td> <h3>Patient Name</h3>
     </td>
      <td>
       Ricardo Immortal Dalisayssssssssssssssssssssssss
      </td>
    </tr>
    <tr>
      <td>
      <h3>Service Fee</h3>
 </td>
      <td>
      ₱500
      </td>
    </tr>
    <tr>
      <td>
      <h3>Amount Received</h3>
 </td>
      <td>
        <div class="ui small input left labeled">
            <div class="ui basic label">
            ₱
            </div>
            <input type="text" name="" id="">
        </div>
      </td>
    </tr> 
    <tr>
     <td><h3>Payment Date</h3>
         </td>
         <td>
             September 06, 2017
             </td>   
</tr>     
  </tbody>
</table>
                </div>
           
            </div>
                     
                   
         
</div>

</div> -->
