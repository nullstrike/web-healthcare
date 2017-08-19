//global variables
var action_type,id,fname,mname,lname;
var name_data = {};
var name_key = [];



$(document).ready(function(){
  
    //initialize materialize components
    $('.collapsible').collapsible();
    $('select').material_select();
    $('.modal').modal();
    $('#date_from,#date_to').pickadate({
        max: new Date(),
        container: 'html',
        format: 'mmmm dd, yyyy',
        formatSubmit: 'yyyy/mm/dd',
        closeOnSelect: true,
        selectMonths: true,
        selectYears: 20
    });
    $('#patientDate').pickadate({
        max: new Date(),
        container: 'body',
        format: 'yyyy/mm/dd',
        selectMonths: true, 
        selectYears: 60,
        closeOnSelect: true
    });
    $('#appointmentDate').pickadate({
        container: 'body',  
        min: new Date(),
        selectMonths: false,
        format: 'You selecte!d: dddd,  mmmm dd, yyyy',
        formatSubmit: 'yyyy/mm/dd',
        hiddenName: true,
        closeOnSelect: true 
    });
    $(".button-collapse").sideNav({
        menuWidth: 300, // Default is 300
      edge: 'left', // Choose the horizontal origin
      closeOnClick: true, // Closes side-nav on <a> clicks, useful for Angular/Meteor
      draggable: true, // Choose whether you can drag to open on touch screens,

    });
    
    //initialize fullCalendar
    $('#calendar').fullCalendar({
         defaultView: 'month',
         eventLimit: true,
         editable: false,
         selectable: true,
         allDaySlot: false,
         displayEventTime: false,
         eventBorderColor: "#1fbbee",
         eventOrder: "start",
         customButtons:{
           appointmentButton:{
               text: 'Add appointment',
               click: function(){
                    form_modal('#appointmentModal', '#appointmentForm', '');
                    $('#appoint').prop('disabled', true);
               },
           }
        },
         header: {
                left: 'prev,next',
                center: 'title',
                right: 'today, ,appointmentButton'
        },
         events:{
            url:site_url('appointment/fetchEvents')
        },
        select: function (start, end, allDay) {

          var date = moment(start).format('YYYY-MM-DD');
          var event = $('#calendar').fullCalendar('clientEvents', function(events){
           return (moment(events.start).format('YYYY-MM-DD') == date);
          });
          for(var i= 0; i< event.length; i++){
             $('#list_appoint').append('<li class="collection-item">' +'Patient ID: ' + event[i].patient_id+ '  '
                                + event[i].title.substr(16, event[i].title.indexOf(',')-1)  + '<span class="badge blue white-text">' + (i + 1) +  '</span></li>' );
         }
        $('#appoint_title').html('Appointments on ' + moment(start).format('MMMM DD, YYYY'));
        if (event.length > 0){
            $('#appointmentFullDetail').modal({
                complete: function(){
                    $('#list_appoint > li:not(:first-child)').remove();
                }
            })
            $('#appointmentFullDetail').modal('open');
        }
       
        },

        eventClick: function (event) {
            var start = moment(event.start).format('MMMM DD, YYYY');
            $('#appointmentDetail #patient_name').html(event.title);
            $('#appointmentDetail #patient_schedule').html('Scheduled on ' + start);
            $('#appointmentDetail').modal('open');
        },
    }); 
 
    //initialize materialize design DataTables
    $('#patientList').dataTable({
        ajax: {
               type:'post',
               url: site_url('patient/patientList')
        },
        columnDefs: [
              {"orderable": false, "width": "10%", "targets":4},
              {"width" : "8%", "targets": 0}
        ],
        pageLength: 10,
        oLanguage: {
              sStripClasses: "",
              sSearch: "",
              sSearchPlaceholder: "Enter patient's first name, middle name or last name here",
              sInfo: "_START_ -_END_ of _TOTAL_",
         },
        bAutoWidth: false
    });
 
      var consultTable =  $('#consultLog').DataTable({
               
          ajax:  {
              url:site_url('consultation/getlogbyID'),
              type: 'post',
              data: function(d){
                $.extend({}, d);
                d.patient_id = localStorage.getItem('patient_id');
                var search_key = $('#consultLog').data('searchDate');
                if (search_key){
                    $.extend(d, search_key);
                }
              }
          },
         columnDefs: [
              {"orderable": false, "width": "36%", "targets":4},
              {"orderable": false, "width": "36%", "targets":3},
              {"width": "12%", "targets":2},
              {"orderable": false, "width": "8%", "targets":1},
              {"width" : "8%", "targets": 0}
        ],
        order:{
            3: 'desc'
        },
        oLanguage: {
            sStripClasses: "",
            sSearch: "",
            sSearchPlaceholder: "",
            sInfo: "_START_ -_END_ of _TOTAL_",
       },
        pageLength:10,
        bAutoWidth: false
    }); 
    //Search consultation by Date//
    /* $('#date_to').on('change', function(){
        if ($('#date_to').val() !== '' || $('#date_from').val() !== '')
            {
                var searchkey = {patient_id: $('#patient_id').text(), start_date: $('#date_from').val(), end_date: $('#date_to').val()};
                $('#consultLog').data('searchDate',searchkey);
                consultTable.ajax.url(site_url('consultation/getlogbydate')).load();
            }
            else {
                
                consultTable.ajax.url(site_url('consultation/getLogbyID')).load();
            }
    
    }); */
    //End of Search consultation section//
    
    //-----helpers-----//
    function getEventsByFilter(filter){        
        var allevents = new Array();
        var filterevents = new Array();
        allevents = getCalendarEvents(null);

        for(var j in allevents){ 
            if(allevents[j].eventtype === filter)
            {
                filterevents.push(allevents[j]);
            }
        }           

        return filterevents;
    } 
    function getCalendarEvents(filter){
        
                var events = new Array();      
                    if(filter == null)
                    {
                        events = $('#calendar').fullCalendar('clientEvents');
                    }
                    else
                    {
                        events = getEventsByFilter(filter);                 
                    }           
                return events;                 
            }
    //function for auto-determined age based on given date
    function get_age($date)
    {
        var today = new Date();
        var birthDate = new Date($date);
        var age = today.getFullYear() - birthDate.getFullYear();
        var months = today.getMonth() - birthDate.getMonth();
        if (months < 0 || (months === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        return age;
    }

    //load json source feed for the autocomplete component
    $.ajax({
        url: site_url('appointment/getPatientName'),
        type: 'get',
        success: function(response){
            var input = $('#patient_name').val();
            $.each(response, function(key, val){     
                name_data[key] = val;  
                name_key.push(key);
            });
            $('input.autocomplete').autocomplete({
                data: name_data,
                limit:5
            });
        },
    });
    //prevents appointment without name
    $('#patient_name, #appointdatepicker').on('change', function(){

        //set input element to a variable
        var input = $('#patient_name').val();
        var appoint = $('#appointmentDate').val();
        //strip the prefix value from the autocomplete
        //value, trim the leading spaces and set the
        //final value to the element
        $(this).val($.trim(input.substr(input.indexOf('-') + 1)));

        //check input value against the autocomplete array source
        //disables if the value is not in the array and enables if
        //there is using setting the buttons disabled property
        if (name_key.indexOf(input) > -1 ) {
            if ($.trim(appoint) !== ''){
                $('#appoint').prop('disabled', false);
            }

        } else {
          $('#appoint').prop('disabled', true);
        }
    });

    //prevents appointment without date
    $('#appointmentDate').on('change', function(){
        
         //set input element to a variable
         var input = $(this);

        //check input value if it is empty or not disables the button
        //if the value is empty and enables it if there a value
        //using setting the buttons disabled property
        if ($.trim(input.val()) !== '') {
            $('#appoint').prop('disabled', false);
        } else {
            $('#appoint').prop('disabled', true);
        }
    });

    //Resets form input on modal close or hide
    function form_modal(modal, modalForm, modalExcept) {
        $(modal).modal({
                complete: function(){
                    $(modalForm)[0].reset();
                    $('select').material_select();
                    $(modalForm).not(modalExcept).find('input, select').each(function(){
                        $(this).prev().removeClass('active');
                    });
                }
        });
        $(modal).modal('open');
    }

    //Remove validation error message and invalid class when input value is change
    $('#registerForm input').on('change', function(){
        $(this).removeClass().addClass('validate valid')
               .next().removeClass().html('');
    });

    //Display the patient's information on the patient info
    //page using localStorage and clears it afterwards
    if (document.location.pathname === '/healthcare/dashboard/patient_info'){
        var fname, mname, lname, id;
        $.each(localStorage, function(key, val){
            if (key === 'patient_fname'){
                fname = val;
            }
            if (key === 'patient_mname'){
                if ($.trim(val) !== '' ){
                    mname = ' ' + val +', ' ;
                }
                else{
                    mname = ', ';
                }
            }
            if (key === 'patient_lname'){
                lname = val ;
            }
            if (key === 'patient_id'){
                $('#patient_id').text(val);
            }
            $('#' + key).not('#patient_name,#patient_id').append(val);
            $('#patient_name').html(fname + mname + lname);
            
        });
        window.localStorage.clear();
    }
    //Set the consultation date
    $date = moment().format("MMMM DD, YYYY");
    $('#date').html($date);

    //-----End of Helpers-----//


    //-----Functionalities-----//

    //Start of User Section//
    
    //Add user function
    $('#registerForm').on('submit', function(event){
        event.preventDefault();
            $.ajax({
                url: site_url('user/userInsert'),
                data: $(this).serialize(),
                type: 'post',
                dataType: 'json',
                success: function(response) {
                    if (! response.success) {
                        if (response.errors) {
                            $.each(response.errors, function (key, val){
                                $('input[name="'+ key + '"]').removeClass().addClass('validate invalid')
                                                             .next().html(val).addClass('red-text');
                            });
                        }
                    } else {
                        $('#registerForm')[0].reset();
                        Materialize.toast(response.message, 2000, 'green');
                    }
                }
            });
    });

    //End of User Section//

    
    //Start of Patient Section//

    //Patient Variables
    //store patient id container
    //parse the int in the text 
      /*   var el_patient_id = $('#consult_patient_id').text();
        var patient_id = parseInt(el_patient_id.match(/\d+/)[0],10); */
    //store the patient form element
        patientForm = $('#patientForm'),
    //store the old height
        height = $('#height').val(), 
    //store the old weight    
        weight = $('#weight').val(); 


    //Set the action type of the button 
    //to call the add new patient function
    //and open the patient form modal
    $('#addPatient').on('click', function(){
        action_type = "add";
        $('.modal-title').html('Add patient');
        $('#patient_action').html('Add patient');
        form_modal('#patientModal','#patientForm','');
    });

    //function to call for adding new patient
    function addPatient()
    {
        $.ajax({
            url: site_url('patient/insertPatient'),
            data: patientForm.serialize(),
            type: 'post',
            dataType: 'json',
            success: function(response){
                if (! response.success) {
                    if (response.errors) {
                        $.each(response.errors, function(key, val) {
                            $('input[name="' + key + '"]').removeClass().addClass('validate invalid')
                                                          .next().html(val).addClass('red-text');
                        });
                    }
                } else {
                    Materialize.toast(response.message, 2000, 'green');
                    $('#patientModal').modal('close');
                    $('#patientList').DataTable().ajax.reload();
                }
            }
        });
    }
    


    //function to fetch patient's information
    //from the database based on patient id
    function retrievePatientInfo(patient_id)
    {
        $.ajax({
            url: site_url('patient/getPatient'),
            data: {patient_id:patient_id},
            type: 'post',
            dataType: 'json',
            success: function(response){
                $('[name=patient_id]').val(response.patient_id);
                $('[name=firstname]').val(response.patient_fname);
                $('[name=middlename]').val(response.patient_mname);
                $('[name=lastname]').val(response.patient_lname);
                $('[name=gender]').val(response.patient_gender).prop('selected', true);
                $('[name=birthdate]').val(response.patient_bdate);
                $('[name=age]').val(response.patient_age);
                $('[name=height]').val(response.patient_height);
                $('[name=weight]').val(response.patient_weight);
                $('[name=bloodtype]').val(response.patient_bloodtype).prop('selected',true); 
                $('[name=address]').val(response.patient_address);
                $('[name=contact]').val(response.patient_contact);  
                $('select').material_select();
            }
         });
    }

    //Set the action type of the button to call the update 
    //patient function and retrieve patient info from database
    //and open the patient form with the info retrieved
    $('#patientList').on('click', '#fetchPatient', function(event){
        event.preventDefault();
        action_type = "update";
        patient_id = $(this).parent().closest('tr').find('td:first').text();
        $('.modal-title').html('Update patient');
        $('#patient_action').html('Update patient');
        $('#patientForm').find('input,select').each(function() {
                $(this).val(' ').prev().addClass('active').next().next().addClass('active');
        });
        retrievePatientInfo(patient_id);
        form_modal('#patientModal', '#patientForm', 'name[patient_id]');
    });
    
    //function to call for updating patient information
    function updatePatient()
    {
        $.ajax({
            url: site_url('patient/updatePatient'),
            data: patientForm.serialize(),
            type: 'post',
            dataType: 'json',
            success: function(response){
                if (! response.success) {
                    if (response.errors) {
                        $.each(response.errors, function(key, val){
                            $('input[name=' + key + ']').removeClass().addClass('validate invalid')
                            .next().html(val).addClass('red-text');
                        });
                    }
                } else {
                    Materialize.toast(response.message, 2000, 'green');
                    $('#patientModal').modal('close');
                    $('#patientList').DataTable().ajax.reload();
                }
            }
        });
    }

    //Autocompute age based on birthdate field change
    $('#patientForm').on('change','input[name=birthdate]',function(){
         var date = $(this).val();
         var age = get_age(date);
         $("input[name='age']").val(age);
    });
    
    //Submit the form and the call the function based
    //on what the current action type value is
    $('#patientForm').on('submit', function(event){
        event.preventDefault();
        if (action_type === 'add') {
            addPatient();
        } else {
            updatePatient();
        }
    });

    //Fetches specific patient based on current rows first cell
    $('#patientList').on('click', '#consultPatient',function(){
        patient_id = $(this).parent().closest('tr').find('td:first').text();
        $.ajax({
                 url: site_url('patient/getPatient'),
                 data: {patient_id:patient_id},
                 dataType: 'json',
                 type: 'post',
                 success: function(response){
                    $.each(response, function(key, val){
                         localStorage.setItem(key, val);
                    });
                   window.location.href = site_url('dashboard/patient_info');   
                 }
         }); 
     });
     
    
    //add consultation upon submitting the consultForm element
    $('#consultForm').on('submit', function(event){
        event.preventDefault();
        var id = $('#patient_id').text();
        var unformat_date = $('#date').text();
        var patient_id = parseInt(id.match(/\d+/)[0],10);
        var date = moment(unformat_date).format('YYYY-MM-DD');
        $.ajax({
            url: site_url('consultation/insertConsultation'),
            data: $(this).serialize() + '&patient_id=' + patient_id + '&consultation_date=' + date,
            type: 'post',
            dataType: 'json',
            success: function(response){
                console.log(response);
            }
        });
        
    });

    //Render events on the calendar based on name and date
    //Sends the form input to the controller
    $('#appointmentForm').on('submit', function(event){
        event.preventDefault();
        var patient_id = $('[name=patient_name]').attr('data-id');
        var appointment_date = $('[name=appointmentDate').val();
        var events = {
            title: 'Appointment for ' + $('#patient_name').val(),
            start: new Date(appointment_date)
        };
        
        $.ajax({
            url: site_url('appointment/createEvent'),
            data: {patient_id: patient_id, appointment_date: appointment_date},
            type: 'post',
            dataType: 'json',
            success: function(response) {
                if (! response.success){
                    if (response.errors){
                        console.log(response.errors);
                    } else {
                        Materialize.toast(response.message,2000,'red');
                    }
                } else {
                    $('#calendar').fullCalendar('renderEvent', events);
                    Materialize.toast(response.message, 2000, 'green');
                    $('#appointmentModal').modal('close');
                }
            }
        });
    });
      
});






/* $('#consult').on('click', function(){
    var patient_id = $('[name=patient_id]').val();
     var diagnosis = $('[name=diagnosis]').val();
      var prescription = $('[name=prescription]').val();
      $.ajax({
        url: site_url('patient/addConsultation'),
        data:{patient_id:patient_id, diagnosis: diagnosis, prescription:prescription},
        type: 'post',
        success: function(){
          window.location.reload();
        }
      });
}); */


 




//Patient asynchronus update function
function patient_edit(){

   var formdata = $('#patient_form').serialize() +
                     "&old_weight=" + weight + "&old_height=" + height
       $.ajax({
        url: site_url('patient/patient_update'),
        data: formdata,
        dataType: 'json',
        type:"POST",
        success: function(response){
        if(response.status === true){
            $('#patient_modal').modal('hide');
            dialog(' fa fa-check-circle-o','green',response.message,true);
            setTimeout(function(){window.location.href = response.page;},3000);
        }else{
                if(response.status === false){
                $.each(response.errors,function(key,val){
                    $('input[name="' + key + '"]').next().html(val).addClass('has-error');
                    $('select[name="' + key + '"]').next().html(val).addClass('has-error');
                });
            }
            }
        }
    });
}

//Patient asynchronous add function
//for variable values e.g. height and weight
/* function patient_old_data(){
     var extra_data = "&id=" + $('input[name="id"]').val() +
                     "&old_weight=" + weight + "&old_height=" + height; 
    $.ajax({
         url: site_url('patient/patient_old_data'),
        data: extra_data,
        dataType: 'json',
        type:"POST",
        success:function(data){
        }
    });
} */
    
//Patient action validation
/* $('#patient_form').on('click','#patient_action',function(){
     if(action_type == "add"){
        patient_add();
    }else{
        $height = $('input[name="height"]').val() + ' cm';
        $weight = $('input[name="weight"]').val() + ' kg';
        if($height == height && $weight == weight){
           patient_edit();
           // alert('no change on var');
        }else{
           patient_edit();
           patient_old_data();
        }
       
    }
});



var formdata = "id=" + $('#patient_id').val() + "&old_height=" + height + "&old_weight=" + weight;

function old_data(){
    $.ajax({
        url: site_url('patient/past_data'),
        data: "id=" + $('#patient_id').val() + "&old_height=" + height + "&old_weight=" + weight,
        dataType:'json',
        type:'POST',
         success: function (data) {
            if(data.status === true){
                alert(data.message);
            }else{
                $.each(data.errors, function (key,val) {
                    $('input[name="' + key + '"]').next().html(val).parent().addClass('has-error');

                })

            }
        }
    });
}
 */


