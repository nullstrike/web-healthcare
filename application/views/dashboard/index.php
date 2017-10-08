
<div class="ui menu "> <!--statistic wrapper-->
	  <div class="item large header ">
		  Clinic Statistics
	  </div>
	  <div class="right menu inflex" id="stats"> <!--statistics section-->
  		<div class="active red item">
  			    Total Patient
  			    <div class="ui red large label" id="totalpatient"></div>
  		</div>
      <div class="active red item">
  			Patient Visits this Week
  			    <div class="ui red large label" id="weekpatient"></div>
  		</div>
	 </div> <!--/ statistics section -->
</div> <!--/ statistic wrapper -->
<div class="ui grid">
<div class="eleven wide column">

  <div class="ui fluid card" id="quarterWrapper">


	<h3 class="header" id="quarterTitle">Quarterly Visit Statistics</h3>
	<div class="content">
	<canvas id="quarterChart" width="700" height="300"></canvas>
	<div class="ui four column grid">
		<div class="column"> January - March    </div>
		<div class="column"> April - June 		  </div>
		<div class="column"> July  - September  </div>
		<div class="column"> October - December </div>
	</div>
	</div>

  </div>
</div>
<div class="five wide column">
  <div class="ui fluid card" id="visitWrapper">


	<h3 class="header" id="visitTitle">Patient Visit Type</h3>
	<div class="content">
	<canvas id="visitTypeChart" width="300" height="320"  ></canvas>
	</div>

  </div>
</div>

</div>
