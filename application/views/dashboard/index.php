
<div class="ui menu "> <!--statistic wrapper-->
	  <div class="item header ">
		  Clinic Statistics
	  </div>
	  <div class="right menu inflex" id="stats"> <!--statistics section-->
  		<div class="active red item">
  			    Total Patient
  			    <div class="ui red large label" id="totalpatient"></div>
  		</div>
      <div class="active red item">
  			Patient Visited this Week
  			    <div class="ui red large label" id="weekpatient"></div>
  		</div>
	 </div> <!--/ statistics section -->
</div> <!--/ statistic wrapper -->
<div class="ui grid">
<div class="ten wide column">
  <div class="ui fluid card" style="height:450px; padding:2em">
  <div id="scheduled"></div>
  </div>
</div>
<div class="six wide column">
  <div class="ui fluid card">

	<div class="content">
	<div class="header">Patient Visit Type</div>

	</div>
	<canvas id="visitTypeChart" ></canvas>
  </div>
</div>

</div>
<div class="ui mini modal" id="availability_modal">
<div class="header">Disable date</div>

<div class="actions">
<button class="ui cancel button">
		Cancel
	</button>
	<button id="mark_disabled" class="ui icon right labeled red button">
		<i class="delete calendar icon"></i>
		Mark as Unavailable
	</button>

</div>
</div>
