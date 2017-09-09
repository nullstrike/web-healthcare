
		<style>

			.report-title{

				font-size: 25pt !important;
			}

			.report-content{
				padding: 10px;
				background-color: #e3e5e6 !important;
				min-height: 250px !important;
			}

			footer{
				margin-top: 30px;
			}

			.report-header{

				font-size: 40pt !important;
				margin-bottom: 30px !important;
			}

			.report-text-header{
				font-weight: bold;
				font-size: 13pt;
				background-color: #e3e5e6
			}
			.report-sub{
				margin-top: 50px;
			}
				@media print{

					#menu{
						display: none;
					}

					.ui.centered.card:last-child{
						page-break-after: auto;
					}
					#header, #sidebar{
						display:none;
					}
					img{
						height: 100px !important;
					}

					h4{
						font-size: 0.8rem !important;
		             	color: #6f6f6f !important;
		             	float: right;
		             	page-break-after: avoid;
					}
					thead{
						-webkit-print-color-adjust: exact;
						background-color: #F9FAFB !important;
					}
					.report-text-header{
						font-weight: bold;
						-webkit-print-color-adjust: exact;
						background-color: #e3e5e6
					}

					.report-content{
						-webkit-print-color-adjust: exact;
						background-color: #e3e5e6 !important;
					}
					.report-text{
		                font-size: 10pt !important;
		                color: red !important;
		                float: left;
		            }

					@page {
						size: letter;
						margin: 0pt;
					}
				}
		</style>

		
		<!-- Diagnosis Report -->
		<div class="ui centered raised card" style="width: 80%;min-height: 800px;">
			<div class="content">
				<div class="ui grid">
					<div class="column">
						<img src="<?=base_url('assets/images/aclogo.png')?>" style="height: 100px;">
					</div>
				</div>
				<hr>
				<center><h3 class="report-header">Diagnosis Report</h3></center>
				<h3>Name of patient: <span>Emmanuel Jay Mumar</span></h3>
				<div>
					<!-- <h5>Name of patient: </h5><h3 style="text-indent: 50px">Emmanuel Jay F. Mumar</h3> -->
					<div class="ui grid" style="text-align: center;">
						<div class="equal width row report-text-header">
							<div class="column">Address</div>
							<div class="column">Birthdate</div>
							<div class="column">Age</div>
							<div class="column">Contact</div>
						</div>
						<div class="equal width row">
							<div class="column"><span>Gahig ulo, Cebu City</span></div>
							<div class="column"><span>September 13, 2017</span></div>
							<div class="column"><span>40</span></div>
							<div class="column"><span>090909</span></div>
						</div>

						<div class="equal width row report-text-header">
							<div class="column">Gender</div>
							<div class="column">Height(cm)</div>
							<div class="column">Weight(kg)</div>
							<div class="column">Bloodtype</div>
						</div>
						<div class="equal width row">
							<div class="column"><span>Male</span></div>
							<div class="column"><span>210</span></div>
							<div class="column"><span>120</span></div>
							<div class="column"><span>0+</span></div>
						</div>
					</div>
					<!-- <table class="ui single line table">
						<thead>
							<tr>
								<th>Address</th>
								<th>Birthdate</th>
								<th>Age</th>
								<th>Contact</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><span class="report-text">Cebu City, Baid Barili, Cebu</span></td>
								<td><span>September 13, 2017</span></td>
								<td><span>19</span></td>
								<td><span>090909090909</span></td>
							</tr>
						</tbody>
					</table> -->
					<!-- <table class="ui single line table">
						<thead>
							<tr>
								<th>Gender</th>
								<th>Height</th>
								<th>Weight</th>
								<th>Bloodtype</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><span>Male</span></td>
								<td><span>240</span></td>
								<td><span>140</span></td>
								<td><span>M+</span></td>
							</tr>
						</tbody>
					</table> -->
				</div>

				<div>
				<div class="report-sub">
					<div class="ui divider horizontal"><p class="report-title">Content</p></div>
				</div>
					<div class="report-content">
						<p><span>Lorem	sinta	buko	nalangpapaya		</span></p>
					</div>
				</div>
				<footer style="font-style: italic;color: #888484">
					<div class="ui equal width grid">
						<div class="column">
							<h5>Consultation Date:</h5>
							<span>September 13, 2017</span>
						</div>
						<div class="column">
							<h5>Date Printed:</h5>
							<span>September 17, 2017</span>
						</div>
						<div class="column">
							<h5>Printed By:</h5>
							<span>Ako nalang</span>
						</div>
					</div>
				</footer>
			</div>
		</div>

		<!-- Receipt -->
		<!--<div class="ui centered raised card" style="width: 80%;min-height: 500px;">
			<div class="content">
				<div class="ui grid">
					<div class="row">
						<div class="column">
							<img src="<?=base_url('assets/images/aclogo.png')?>" style="height: 100px">
						</div>
					</div>
				</div>
				<hr>
				<center><p class="report-header">Receipt</p></center>
				<div>
					<h5>Name of patient: </h5><h3 style="text-indent: 50px">Emmanuel Jay F. Mumar</h3>
					<table class="ui single line table">
						<thead>
							<tr>
								<th>Diagnosis</th>
								<th>Prescription</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><span class="report-text">Stressed Out</span></td>
								<td><span>Matulog 5 years</span></td>
							</tr>
						</tbody>
					</table>

						<table class="ui very basic table">
							<thead>
								<tr>
									<th>Amount Received</th>
									<th>Amount Paid</th>
									<th>Change</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><span>1000</span></td>
									<td><span>999.99</span></td>
									<td><span>0.01</span></td>
								</tr>
							</tbody>
						</table>

				</div>

				<footer style="font-style: italic;color: #888484">
					<div class="ui equal width grid">
						<div class="column">
							<h5>Consultation Date:</h5>
							<span>September 13, 2017</span>
						</div>
						<div class="column">
							<h5>Date Printed:</h5>
							<span>September 17, 2017</span>
						</div>
						<div class="column">
							<h5>Printed By:</h5>
							<span>Ako nalang</span>
						</div>
					</div>
				</footer>			</div>
		</div>-->








		<script type="text/javascript" src="<?= base_url('assets/semantic/jquery.min.js')?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/semantic/semantic.js')?>"></script>
	</body>
</html>