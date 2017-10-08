<!--diagnosis report -->
<div class="ui grid sheet" id="report-diagnosis" >
	<div class="ui centered grid row huge header report-header">Diagnosis report</div>
		<div class="ui large header">Aguilar Clinic
			<div class="ui sub header" >Manuel Sosa Street,</div>
			<div class="ui sub header">Poblacion Barili, Cebu</div>
		</div>
		<div class="print_divider" ></div>
			<table class="ui very basic very compact  table" cellspacing="0" cellpadding="0" width="100%">
						<tbody>
								<tr>
									<td class="ten wide" style="padding-top:0; padding-bottom:0;">
										<span class="report-fields" >Patient Name: </span>
										<span data-name="patientName"></span>
									</td>
									<td class="six wide" style="padding-top:0; padding-bottom:0;">
										<span class="report-fields">Blood Type: </span>
										<span data-name="bloodtype"></span>
									</td>
								</tr>
								<tr>
									<td class="twelve wide" style="padding-top:0; padding-bottom:0;">
										<span class="report-fields">Birthdate: </span>
										<span data-name="birthdate"></span> (<b>Age</b>: <span data-name="age"></span>)
									</td>
									<td class="four wide" style="padding-top:0; padding-bottom:0;">
										<span class="report-fields">Weight: </span>
										<span data-name="weight"></span> kg
									</td>
								</tr>
								<tr>
									<td class="twelve wide" style="padding-top:0; padding-bottom:0;">
										<span class="report-fields">Gender: </span>
										<span data-name="gender"></span>
									</td>
									<td class="four wide" style="padding-top:0; padding-bottom:0;">
										<span class="report-fields">Height: </span>
										<span data-name="height"></span> cm
									</td>
								</tr>
						</tbody>
			</table>



			<table class="ui very basic very compact  table" cellspacing="0" cellpadding="0" width="100%">
						<tbody>
								<tr>
									<td>
										<span class="report-fields">Diagnosis: </span>
										<p data-name="diagnosis"></p>
									</td>
								</tr>
						</tbody>
			</table>
			<table class="ui very basic compact  table" cellspacing="0" cellpadding="0" width="100%">
			<tbody>
				<tr>
					<td class="nine wide">
						<small>Date Consulted:
							<span data-name="date"></span>
						</small>
					</td>
					<td class="seven wide">
						<small>Date Printed:
							<span data-name="date_printed"></span>
						</small>
					</td>
					</tr>
			</tbody>
		</table>
</div>


<!--for prescription-->
	<div class="ui sheet" id="report-prescription">

		<div class="ui centered grid row huge header report-header">Prescription slip</div>
			<div class="ui large header">
				Aguilar Clinic
			<div class="ui sub header" >Manuel Sosa Street,</div>
			<div class="ui sub header">Poblacion Barili, Cebu</div>
			</div>
			<div class="print_divider" ></div>
				<table class="ui very basic very compact  table" cellspacing="0" cellpadding="0" width="100%">
						<tbody>
								<tr>
									<td class="report-padless-top eight wide ">
										<span class="report-fields">Patient Name: </span>
										<span data-name="patientName"></span>
									</td>
									<td class="report-padless-top eight wide" >
										<span class="report-fields">Date Printed: </span>
										<span data-name="date"></span>
									</td>
								</tr>
								<tr>
									<td colspan="2" class="report-padless-top">
										<span class="report-fields">Address: </span>
										<span data-name="address"></span>
									</td>
								</tr>
								<tr>
				  					<td>
										<img class="ui mini image" src="<?php echo base_url('vendor/fireblight/images/rx-new.png');?>" >
									</td>
								</tr>
			 					<tr>
				 					<td class="report-padded"><p data-name="medication"></p></td>
			 					</tr>
			  					<tr>
									<td style="padding-bottom:4em;"><b>Note:</b><p><span data-name="note"></span></p></td>
								</tr>
				 				<tr>
									<td class="eight wide">
										Signature: <div class="report-fill"></div>
									</td>
									<td class="eight wide">
										Date Printed: <span data-name="date_printed"></span>
									</td>
								</tr>
						</tbody>
				</table>
	</div>

<!--for receipt -->
	<div class="ui grid sheet" id="report-receipt">
		<div class="ui centered grid row huge header report-header">Payment receipt</div>

		<div class="ui large header">
			Aguilar Clinic
			<div class="ui sub header" >
			Manuel Sosa Street,
			</div>
			<div class="ui sub header">
			Poblacion Barili, Cebu
			</div>
		</div>

		<div class="report-body">

				<table class="ui very basic compact  table" cellspacing="0" width="100%">
					<tbody>
					  <tr>
						<td class="five wide">
							<b>Patient Name</b>
						</td>
						<td class="eleven wide">
							<span data-name="patientName"></span>
						</td>
			 		  </tr>
					  <tr>
			 		    <td class="five wide">
							 <b>Amount Received </b>
						</td>
			  			<td class="eleven wide">
							  P <span data-name="payment_given"></span>
						</td>
			 		  </tr>
			          <tr>
						<td class="five wide">
							<b>Amount to Pay</b>
						</td>
						<td class="eleven wide">
							  P <span data-name="payment_amount"></span>
						</td>
					   </tr>
			     	</tbody>
				</table>

		  		<table class="ui very basic compact  table" cellspacing="0" cellpadding="0" width="100%">
					<tbody>
						<tr>
							<td class="nine wide">
								<small>Date Consulted:
									<span data-name="date"></span>
								</small>
							</td>
							<td class="seven wide">
								<small>Date Printed:
									<span data-name="date_printed"></span>
								</small>
							</td>
					    </tr>
					</tbody>
				</table>
	</div>
</div>


<table id="reportTable" class="ui selectable very small compact celled table" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>ID</th>
			<th>Name</th>
			<th>Date</th>
			<th>Print</th>
		</tr>
	</thead>

</table>
