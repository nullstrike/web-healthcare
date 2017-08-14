//global variables
var action_type,id,fname,mname,lname;
var name_data = {};
var name_key = [];



$('#datatable').on('click', '#consultPatient',function(){
   id = $(this).parent().closest('tr').find('td:first').text();
   var name = '';
   $.ajax({
            url: site_url('patient/getPatient'),
            data: {patient_id:id},
            dataType: 'json',
            type: 'get',
            success: function(response){
                name=response;
            }
    }); 
  return false;
});


$(document).ready(function(){
  
    //initialize materialize components
    $('.collapsible').collapsible();
    $('select').material_select();
    $('.modal').modal();
    $('#patientDate').pickadate({
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
                    $('#appointmentModal').modal('open');
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
              
        },

        eventClick: function (event) {
           
        },
    }); 
  
    //initialize materialize design DataTables
    $('#datatable').dataTable({
        ajax: {
               type:'post',
               url: site_url('patient/patientList')
        },
        columnDefs: [
              {"orderable": false, "width": "14%", "targets":4},
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

    //-----helpers-----//
    
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
    $('#patient_name').on('change', function(){

        //set input element to a variable
        var input = $(this).val();
        
        //strip the prefix value from the autocomplete
        //value, trim the leading spaces and set the
        //final value to the element
        $(this).val($.trim(input.substr(input.indexOf('-') + 1)));

        //check input value against the autocomplete array source
        //disables if the value is not in the array and enables if
        //there is using setting the buttons disabled property
        if (name_key.indexOf(input) > -1) {
          $('#appoint').prop('disabled', false);
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


    //Add new patient
    
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
        $('#calendar').fullCalendar('renderEvent', events);
        $.ajax({
            url: site_url('appointment/createEvent'),
            data: {patient_id: patient_id, appointment_date: appointment_date},
            type: 'post',
            dataType: 'json',
            success: function(response) {
                console.log(response);
            }
        });

    });
      
});
  
/*--------------------------------------------------------------------------------------------
USER SECTION
---------------------------------------------------------------------------------------------*/

//Adding user




//patient section variables
var id,fname,mname,lname,age,gender,birthdate,bloodtype,height,weight,address,contact;
//patient_table variables
var patient_id,height = $('#height').val(),weight = $('#weight').val();

/*--------------------------------------------------------------------------------------------
PATIENT SECTION
---------------------------------------------------------------------------------------------*/

$('#addPatient').on('click', function(){
    action_type = "add";
    $('.modal-title').html('Add patient');
    $('#patient_action').html('Add patient');
    on_modal_close();
});

function addPatient()
{
    var patientForm = $('#patientForm').serialize();
    $.ajax({
        url: site_url('patient/insertPatient'),
        data: patientForm,
        type: 'post',
        dataType: 'json',
       success: function(response){
              if (response.success === false) {
                    if (response.errors) {
                        $.each(response.errors, function(key, val) {
                             $('input[name=' + key + ']').removeClass().addClass('validate invalid').next().html(val).addClass('red-text');
                        });
                    }
                    Materialize.toast(response.message, 2000, 'red');
               }
               else {

                    Materialize.toast(response.message, 2000, 'green');
                    setTimeout(function() {
                       window.location.reload();
                    }, 2000);
               }
            }
    });
}

function updatePatient()
{
     var patientForm = $('#patientForm').serialize();
    $.ajax({
        url: site_url('patient/updatePatient'),
        data: $('#patientForm').serialize(),
        type: 'post',
        dataType: 'json',
       success: function(response){
              if (response.success === false) {
                    if (response.errors) {
                        $.each(response.errors, function(key, val) {
                             $('input[name=' + key + ']').removeClass().addClass('validate invalid').next().html(val).addClass('red-text');
                        });
                    }
                    Materialize.toast(response.message, 2000, 'red');
               }
               else {

                    Materialize.toast(response.message, 2000, 'green');
                    setTimeout(function() {
                       window.location.reload();
                    }, 2000);
               }
            }   
    });
}

$('#patientForm').on('submit', function(event){
     event.preventDefault();
    if(action_type === "add"){
       addPatient();
    }else{
       updatePatient();
    }
});

$('#consult').on('click', function(){
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
});

$('#datatable').on('click', '#fetchPatient', function(event){
    event.preventDefault();
    action_type = "update";
    $('.modal-title').html('Update patient');
    $('#patient_action').html('Update patient');
    $('#patientForm ').find('input,select').each(function(){
              $(this).val(' ').prev().addClass('active').next().next().addClass('active');
           });
    id = $(this).parent().closest('tr').find('td:first').text();

    $.ajax({
            url: site_url('patient/getPatient'),
            data: {patient_id:id},
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
                on_modal_close();    
        }
    });

});

 
//Autocompute age based on birthdate field change
$('#patientForm').on('change',"input[name='birthdate']",function(){
        $date = $(this).val();
        $age = get_age($date);
        $("input[name='age']").val($age);
});

//Add patient via Ajax
function patient_add(){
    $.ajax({
        url: site_url('patient/patient_add'),
        data: $('#patient_form').serialize(),
        type: 'post',
        dataType: 'json',
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
function patient_old_data(){
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
}
    
//Patient action validation
$('#patient_form').on('click','#patient_action',function(){
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

//Modal for patient add
function patient_add_modal(){
    action_type = "add";
    $('.modal-title').html('Add patient');
    $('#patient_action').html('Add patient');
    $('#patient_modal').modal('show');

}

//Modal for patient edit
function patient_update_modal(){
    action_type = "update";
    $('.modal-title').html('Update patient');
    $('#patient_action').html('Update patient');
    fetch_patient_input();
    select_gender();
   /* $('select[name="bloodtype"]').val("AB-");*/
    $('#patient_modal').modal('show');
}



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





 $('select[name=appointment_time]').on('change',function(){
     $(this).next().empty();
     $(this).parent().removeClass();
 })

$('input[name=appointment_date]').on('change',function(){
   $(this).next().empty();
   $(this).parent().removeClass();
});

$('input[name=patient_id]').on('change',function(){
   $(this).next().empty();
   $(this).parent().removeClass();
});


$('#appointmentModal').on('hidden.bs.modal',function(){
    $('#patient_form')[0].reset();
    $('#patient_id').next().empty().parent().removeClass();
    $('#dates').next().empty().parent().removeClass();
    $('#times').next().empty().parent().removeClass();
});
