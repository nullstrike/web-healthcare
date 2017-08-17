<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
	<div class="col s12 m12">
  		<div class="card white">
			<div class="card-content black-text">
	 			<div class="row" id="patient_header_view">
					 <div class="left">
						 <h3 id="patient_name">NAME</h3>
						 <div class="divider" id="patient_header_divider"></div>
					 </div>
					 <div class="right" id="patient_health_info">
						 <ul>
					 	 <li><label id="patient_id" >Patient ID: </label></li>
					     <li> <label id="patient_height">Height: </label><span> cm</span></li>
						 <li><label id="patient_weight" >Weight: </label><span> kg</span></li>
						 <li> <label id="patient_bloodtype">BloodType: </label></li>			
						</ul>
					 </div>
				 </div>
			<div id="patient_info" class="row blue-grey darken-4 " style="padding-bottom:10px">
					 <div class="col s2">
						 <label id="patient_gender" class="white-text">Gender: </label>
					 </div>
					 <div class="col s2">
						 <label id="patient_bdate" class="white-text">Birthdate: </label>
					 </div>
					<div class="col s2">
						<label id="patient_age" class="white-text">Age: </label>
					</div>
					<div class="col s4">
						<label id="patient_address" class="white-text">Address: </label>
					</div>
					<div class="col s2">
						<label id="patient_contact" class="white-text">Contact: </label>
					</div>
			</div>	
			<div class="row">
				<h5 id="consultation_date">Consultation Date: <span id="date"></span></h5>
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
							<button id="foo" class="btn-flat right red waves-effect waves-light white-text">Add Consultation</button>
						</form>
					</div>
			</div>
	
	
 		 </div>
		  <div class="row " style="height:350px; overflow-y:scroll;">
	<div class="col m12 ">
		<h1 class="card-title">Consultation Log</h1>
		<table class="bordered striped highlight">
				<thead>
					<tr>
						<th>Patient ID</th>
						<th>Consultation Date</th>
						<th>Prescription</th>
						<th>Diagnosis</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Stupid csdunts</td>
						<td>Red Flesh</td>
						<td>Stupid cdsunts</td>
						<td>Red Flesh</td>
					</tr>
					<tr>
						<td>Red Splash</td>
						<td>This sting</td>
						<td>Stupid csdunts</td>
						<td>Red Flesh</td>
					</tr>
					<tr>
						<td>Stupid csdunts</td>
						<td>Red Flesh</td>
						<td>Stupid csdunts</td>
						<td>Red Flesh</td>
					</tr>
					<tr>
						<td>Red Splash</td>
						<td>This sting</td>
						<td>Stupid csdunts</td>
						<td>Red Flesh</td>
					</tr>
					<tr>
						<td>Stupid sdcunts</td>
						<td>Red Flesh</td>
						<td>Stupid csdunts</td>
						<td>Red Flesh</td>
					</tr>
					<tr>
						<td>Red Splash</td>
						<td>This sting</td>
						<td>Stupid csdunts</td>
						<td>Red Flesh</td>
					</tr>
				</tbody>
			</table>
	
</div>
</div>
	</div>
</div>
