<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div id="choice" style="padding:1em 0">
    <label for="">Appointments for today:</label>
    <select name="" class="ui dropdown appoint"  id="appointlist"></select>
    <div class="ui checkbox" style="padding-left:1em;">
         <input type="checkbox" name="" id="walk_in">
         <label for="">Walk in Patient?</label>
    </div>

    <input type="hidden" name="id" id="patient_id">
    <input type="hidden" id="consult_type">
    <div style="padding-left:27em;padding-top:0.5em;display:none">
        <select  name="patient_name" style="width:50%;" id="patient_name"></select>
    </div>
</div>


<div style="display:none;" id="walk_in_picker">
    <select name="walk_in" class="ui dropdown" id=""></select>
</div>

<!--receipt-->
    <div class="ui grid sheet" id="consult-receipt" style="display:none">
            <div class="ui centered grid row huge header report-header">Payment receipt</div>

            <div class="ui large header">
                Aguilar Clinic
                <div class="ui sub header" >
                Manuel Sossa Street,
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

<div class="fourteen wide column" style="padding-bottom:0; margin-bottom:0; padding-top:1em !important"  >

    <div id="info-wrapper" style="display:none;">
        <div class="ui top attached block header"><h3>Patient Information</h3></div>
        <div class="ui attached segment">
            <div class="ui grid" style="padding-bottom:1em;" >
             <div class="twelve wide column" ><h3>Consultation</h3></div>
             <div class="four wide column" style="padding-left:4em"><em class="date"></em></div>
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
                    <div class="six wide field">
                        <label>Blood Group</label>
                        <input type="text" name="bloodtype" readonly id="">
                    </div>
                </div>
            </div>
        </form>
        <div class="ui attached bottom segment">
            <div class="ui grid" style="padding-top:1em;">
                <div class="four column row" >
                    <div class="right floated column">
                        <button id="before-consult" disabled type="button" class="ui right labeled icon small primary button">
                             <i class="right arrow icon"></i>
                             Proceed to consultation
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div><!--Info wrapper close-->

    <!--consultation wrapper-->
    <div id="consulting-wrapper" style="margin-bottom:0;display:none;padding-bottom:1em;">
        <div class="ui top attached block header"><h3>Patient Consultation</h3></div>
        <div class="ui attached segment" style="margin-bottom:0;">
            <div class="ui grid" style="padding-bottom:1em;" >
                 <div class="thirteen wide column" ><h3>Consultation</h3></div>
                 <div class="three wide column"><em class="date"></em></div>
            </div>
            <form class="ui form" id="consultForm">
                  <div class="two fields">
                    <div class="field">
                      <label>Height</label>
                      <div class="ui right labeled input">
                        <input type="text" name="height" placeholder="Enter height..">
                          <div class="ui basic label">cm</div>
                      </div>
                      <span class="error text"></span>
                  </div>
                  <div class="field">
                    <label>Weight</label>
                    <div class="ui right labeled input">
                      <input type="text" name="weight" placeholder="Enter weight..">
                        <div class="ui basic label">kg</div>
                    </div>
                    <span class="error text"></span>
                  </div>
                 </div>
                 <div class="field">
                    <label>Diagnosis</label>
                    <input type="text" name="diagnosis">
                    <span class="error text"></span>
                 </div>
                 <div class="field">
                    <label>Medication</label>
                    <textarea rows="3" name="medication"></textarea>
                    <span class="error text"></span>
                 </div>
                 <div class="field">
                    <label>Note</label>
                    <textarea rows="3" name="note"></textarea>
                    <span class="error text"></span>
                 </div>


            </form>
            <div class="ui segment">
                <div class="header"><h3>Consultation Log</h3></div>
                <table class="ui celled striped table" id="consultation_table" width="100%">
                    <thead>
                        <tr>
                            <th>Consultation Date</th>
                            <th>Diagnosis</th>
                            <th>Medication</th>
                            <th>Note</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="ui five column grid" style="padding-top:1em;margin-bottom:0;">
                <div class="right floated column">
                    <button id="on-consult" type="button" class="ui right labeled icon small primary button">
                        <i class="treatment icon"></i>
                        Save consultation
                    </button>
                </div>
            </div>
        </div>
    </div> <!--consult wrapper close -->
    <!--payment wrapper-->
    <div class="ui centered grid" id="payment" style="margin-bottom:0;text-align:left;">
    <div  id="payment-wrapper"  style="padding: 1em 0;width:450px;">
        <div class="ui top attached block header"><h3>Payment Details</h3></div>
        <div class="ui attached segment">
            <form class="ui form" id="paymentForm">
                 <div class="field">
                    <label>Patient Name:</label>
                    <input type="text" name="payee" readonly>
                 </div>
                 <div class="field">
                    <label>Consultation Fee</label>

                        <select class="ui dropdown" name="payment_amount" id="">
                            <option value="150">₱150</option>
                            <option value="200">₱200</option>
                            <option value="250">₱250</option>
                            <option value="300">₱300</option>
                            <option value="350">₱350</option>
                            <option value="400">₱400</option>
                        </select>
                    </div>

                 <div class="field">
                 <label>Amount Received</label>
                    <div class="ui left labeled input">
                        <div class="ui basic label">₱</div>
                        <input type="text" name="payment_given">
                    </div>
                      <span class="error text"></span>
                 </div>

                 <div class="field">
                 <label>Change</label>
                    <div class="ui left labeled input">
                        <div class="ui basic label">₱</div>
                        <input type="text" name="payment_change" readonly>

                    </div>
                 </div>
            </form>
            <div class="ui three column grid" style="padding-top:1em;">
                <div class="right floated column">
                    <button id="on-pay" type="button" class="ui right labeled icon small primary button">
                        <i class="print icon"></i>
                        Print Receipt
                    </button>
                </div>
            </div>
        </div>
        </div>
    </div> <!--payment wrapper close -->
</div>
