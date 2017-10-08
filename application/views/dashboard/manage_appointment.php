<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="ui icon info message hidden ">
  <i class="info circle icon" id="message-icon"></i>
  <div class="content"></div>
</div>

<div class="ui bottom attached segment quick fix">
<table id="appointment_table" class="ui selectable very small compact celled table" cellspacing="0" width="100%">
<thead>
  <tr>
    <th>Appointment ID</th>
    <th>Patient ID</th>
    <th>Patient Name</th>
    <th>Date</th>
    <th>Time</th>
    <th>Created By</th>
    <th>Actions</th>

  </tr>
</thead>
</table>
</div>

<div class="ui segment">
  <div id="appointmentList">

  </div>
</div>


<div class="ui mini modal" id="appointmentModal">
    <div class="header">
    </div>
    <div class="content">
        <div class="ui error small hidden  message icon">
          <i class="warning circle icon"></i>
          <div class="content" id="message">
          </div>
        </div>
        <form class="ui form" id="appointmentForm">
            <div class="field">
                <label>Patient Name</label>
                <select  name="patient_id" style="width:100%;" id="dropdown_name">
                </select>
                <input type="text" readonly id="selected_name">
            </div>
            <div class="fields">
            <div class="nine wide field">
                <label>Appointment Date</label>
                <input type="text" id="appoint_date" name="date">
            </div>
            <div class="seven wide field">
                <label>Appointment Time</label>
                <input name="time" type="text" class="time ui-timepicker-input" autocomplete="off">
            </div>
            </div>
        </form>
    </div>
    <div class="actions">
            <button class="ui button small positive" type="button" id="appointmentAction"></button>
    </div>
</div>


<div class="ui basic modal" id="prompt_modal">

<div class="ui icon header">
  <i class="warning circle red icon"></i>
 Appointment Cancellation Notice
</div>

<div class="content">
  <h4 style="padding-left: 17.5em;">Do you want to cancel the selected appointment?</h4>
</div>
<div class="actions" style="
    padding-right: 20em;
">

  <div class="ui basic green ok inverted button">
    <i class="checkmark icon"></i>
    Yes
  </div>
  <div class="ui red  cancel inverted button">
    <i class="remove icon"></i>
    No
  </div>
</div>
</div>
<div class="ui mini modal" id="availability_modal">
<div class="header">Disable date</div>

<div class="actions">
	<button class="ui cancel button">Cancel</button>
	<button id="mark_disabled" class="ui icon right labeled red button">
		<i class="delete calendar icon"></i>
		Mark as Unavailable
	</button>

</div>
</div>
