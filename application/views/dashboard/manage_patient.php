<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="ui padded segment boxed" id="dashboard-info"> <!--dashboard info wrapper -->
      <h5 class="ui header">Manage Patient</h5>
      <label>This is where you can manage patient like updating and adding patient information.</label>
</div> <!--/ dashboard info wrapper -->

<!-- alert message -->
<div class="ui icon positive message hidden">
  <i class="check circle outline green icon"></i>
  <div class="content"></div>
</div>
<!--/ alert message -->

<div id="patient_table_wrapper" class="ui padded segment ">
  <table id="patient_table" class="ui selectable very small compact celled table" cellspacing="0" width="100%">
      <thead>
        <tr>
          <th>ID</th>
          <th>First Name</th>
          <th>Middle Name</th>
          <th>Last Name</th>
          <th>Actions</th>
        </tr>
      </thead>
  </table>
</div>

<div class="ui small modal" id="patient_modal">
  <div class="header"></div>
  <div class="content">
    <form class="ui form"  id="patient_form" autocomplete="off">
        <input type="hidden" name="id">
        <div class="fields">
          <div class="six wide field">
            <label>First Name</label>
            <input type="text"  name="firstname"   placeholder="First Name">
            <span class="error text"></span>
          </div>
          <div class="four wide field">
            <label>Middle Name</label>
            <input type="text" name="middlename" placeholder="Middle Name">
            <span class="error text"></span>
          </div>
          <div class="six wide field">
            <label>Last Name</label>
            <input type="text" name="lastname" placeholder="Last Name">
            <span class="error text"></span>
          </div>
       </div>
       <div class="fields">
          <div class="six wide field">
                <label>Gender</label>
                <select name="gender" class="ui dropdown" data-title="asd">
                  <option value="">Gender</option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                </select>
                <span class="error text"></span>
          </div>
          <div class="six wide field">
                <label>Birthdate</label>
                <div class="ui input left icon">
                  <i class="calendar icon"></i>
                  <input type="date" name="birthdate" placeholder="Enter your birthdate">
                </div> 
                <span class="error text"></span>         
          </div>
          <div class="four wide field">
              <label>Age</label>
              <input type="text" name="age" readonly>
          </div>
       </div>
      <div class="fields">
          <div class="six wide field">
                <label>Weight</label>
                <div class="ui right labeled input">
                   <input type="text" name="weight" placeholder="Enter weight">
                   <div class="ui basic label">kg</div>
                </div>
                <span class="error text"></span>
          </div>
          <div class="five wide field">
                <label>Height</label>
                <div class="ui right labeled input">
                   <input type="text" name="height" placeholder="Enter height">
                   <div class="ui basic label">cm</div>
 
                </div>
                <span class="error text"></span>
          </div>
          <div class="five wide field">
                <label>Blood Type</label>
                <select name="bloodtype" class="ui dropdown">
                    <option value="">Select the blood type</option>
                    <option value="A-">Blood Type A - Negative</option>
                    <option value="A+">Blood Type A - Positive</option>
                    <option value="B-">Blood Type B - Negative</option>
                    <option value="B+">Blood Type B - Positive</option>
                    <option value="AB-">Blood Type AB - Negative </option>
                    <option value="AB+">Blood Type AB - Positive</option>
                    <option value="O-">Blood Type O - Negative</option>
                    <option value="O+">Blood Type O - Positive </option>
                </select>
                <span class="error text"></span>
          </div>  
      </div>
      <div class="fields">
          <div class="nine wide field">
                <label>Address</label>
                <input type="text" name="address" placeholder="Enter address...">
                <span class="error text"></span>
          </div>

          <div class="seven wide field">
                <label>Contact Number</label>
                <input type="text" name="contact" placeholder="Enter contact number...">
                <span class="error text"></span>
          </div>
      </div>
      </form>
    </div>
    <div class="actions">
          <button class="ui button blue" id="btnAction" data-content="rtes"  type="submit"></button>
    </div>

</div>
