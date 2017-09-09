


$(function(){ //document ready
    var user_id = $('[name=user_id]').val();


    //show sub menu on sidebar menu
    $('.collapse').on('click', function(e){
          $('.sidebar .collapse-wrapper').each(function() {
              $(this).slideUp();
          });
          var menu = $(this).next('.collapse-wrapper');
          if (menu.is(':visible')) {
              menu.css({
                visibility: 'visible',
                display: 'block'
              }).slideUp('slow');
          } else {
              menu.css({
                visibility: 'visible',
                display: 'none'
              }).slideDown('slow');
          }
      });
     
     
      //get clinic Statistics
   

      if (window.location.pathname === '/healthcare/dashboard/'){
       
          $.ajax({
            url: site_url('statistics/getstats'),
            type: 'get',
            dataType: 'json',
            data: {},
            success: function (response) {
                let quarterDataSet = response.patientquarterstat;
                let dataSet = [];
                for (let i in quarterDataSet) {
                    dataSet.push(quarterDataSet[i]);
                }
                $('#totalpatient').html(response.totalpatient);
                $('#weekpatient').html(response.patientweekstat);
            }
        });
     
        $('#scheduled').fullCalendar({
            defaultView: 'month',
            height: 'auto',
            eventLimit: true,
            editable: false,
            lazyFetching: true,
            allDaySlot: false,
            displayEventTime: false,
            header: {
                   left: 'prev,next,',
                   center: 'title',
                   right: 'today'
           },
            eventSources:[
                {
                      url: site_url('appointment/fetchEvents'),
                      type: 'post',
                      color: '#0fb737',
                      textColor: 'white'
                },
                {
                      url: site_url('appointment/fetchdisabledDates'),
                      type: 'post',
                      color: 'red',
                      textColor: 'white'
                }
            ],
            dayClick: function (start, end, allDay) { 
               
                     var date = moment(start).format('YYYY-MM-DD');
                     var event = $('#scheduled').fullCalendar('clientEvents', function(events){
                      return (moment(events.start).format('YYYY-MM-DD') == date);
                     });
               
                     if (event.length === 0){
                        $('#availability_modal').modal('show');
                        $('#mark_disabled').off('click').on('click', function(){
                            var appoint = {
                                    title: 'Unavailable',
                                    start: start, 
                                    color:'red'
                                };
                            $.ajax({
                                url: site_url('appointment/disabledDate'),
                                data: {na_date : moment(start).format('YYYY-MM-DD')},
                                type: 'post',
                                success: function(){
                                    $('#scheduled').fullCalendar('renderEvent', appoint);
                                },
                                complete: function(){
                                    $('#availability_modal').modal('hide');
                                }
                            });
                     
                        });
                     }
               }
         });
       
      }
     
  
      

      //------------------User dashboard section---------------------//
      if (window.location.pathname === '/healthcare/dashboard/user') {
          //run the user form validation function
          //validate_userform();

          //initialize user datatables
            var user_table =  $('#user_table').DataTable({
                  ajax: site_url('user/getUserRecord'),
                  language:{
                      search: '_INPUT_',
                      searchPlaceholder: 'Search records...'
                    },
          });

          //add custom button in datatables and style the search box
            $('#user_table_filter').prepend('<button class="ui small icon button blue" id="add_user"><i class="add user medium icon"></i> Add user</button>');
            $('#user_table_filter').addClass('icon').append('<i class="search icon"><i>');

         //open the modal when the add button clicks
         //resets the modal content on modal close or hide
            $(document).on('click', '#add_user', function(){
                $('.ui.modal').modal({
                  onHidden: function(){
                      $('#user_form').form('reset');
                      $('.modal-message').removeClass('error').addClass('info');
                      $('#message-icon').removeClass('warning').addClass('info').next().html('<h4>The password is set to "default".</h4>');
                   },
                  autofocus: false
                  }).modal('show');
              });

        } //end of user dashboard section//

      //----------------Patient dashboard section-------------------//
      if (window.location.pathname === '/healthcare/dashboard/patient') {
          var patient_action;
          
          //initialize patient datatables
          var patient_table = $('#patient_table').DataTable({
                ajax: site_url('patient/patientList'),
                autoWidth: false,
                columnDefs:[
                  {'orderable': false, 'searchable': false ,targets: 4}
                ],
                columns:[
                    {'width':'5%', targets:0 },
                    {'width':'25%', targets:1 },
                    {'width':'25%', targets:2 },
                    {'width':'25%', targets:3 },
                    {'width': '20%', targets:4}
                ],
                language:{
                  search: '_INPUT_',
                  searchPlaceholder: 'Search patient records...'
                }
          });

          //add custom button in datatables and style the search box
            $('#patient_table_filter').prepend('<button class="ui icon button blue" id="add_patient"><i class="child icon"></i>Add patient</button>');
            $('#patient_table_filter').addClass('icon').append('<i class="search icon"><i>');

          //open patient modal
          $(document).on('click', '#add_patient', function(){
              patient_action = 'add';
              patient_modal('Add patient', 'Add patient');
          });

          //
          $(document).on('click', '#btnAction', function(){
              if (patient_action === 'add'){
                $.ajax({
                    url: site_url('patient/insertPatient'),
                    data: $('#patient_form').serialize(),
                    dataType: 'json',
                    type: 'post',
                    success: function(response){
                       if (! response.success){
                           if (response.errors){
                                $.each(response.errors, function(index, value){
                                   if ( index === 'firstname'  || index === 'lastname' || index === 'middlename' ||  index === 'address' || index === 'contact'){
                                                if(value !== ''){
                                                    $('[name=' + index + ']').next('span').text(value);                
                                                }     
                                           } else {
                                            $('[name=' + index + ']').parent().next().text(value)
                                           }
                                });
                           } 
                              
                       }else {
                        $('#patient_modal').modal('hide');
                        $('.ui.message').removeClass('hidden').addClass('visible').find('.content').html(response.message);
                        patient_table.ajax.reload();
                       }
                    }
                });
              } else {
                $.ajax({
                    url: site_url('patient/updatePatient'),
                    data: $('#patient_form').serialize(),
                    dataType: 'json',
                    type: 'post',
                    success: function(response){
                        if (! response.success){
                            if (response.errors){
                                 $.each(response.errors, function(index, value){
                                    if ( index === 'firstname'  || index === 'lastname' || index === 'middlename' ||  index === 'address' || index === 'contact'){
                                                 if(value !== ''){
                                                     $('[name=' + index + ']').next('span').text(value);                
                                                 }     
                                            } else {
                                             $('[name=' + index + ']').parent().next().text(value)
                                            }
                                 });
                            }  
                        }else {
                         $('#patient_modal').modal('hide');
                         $('.ui.message').removeClass('hidden').addClass('visible').find('.content').html(response.message);
                         patient_table.ajax.reload();
                        }
                     }
                });
              }
           
          });

          $(document).on('change', '[name=birthdate]', function(){
              var date = $(this).val();
              $('[name=age]').val(get_age(date));
          });

          //
          $(document).on('click', '.update', function(){
            patient_action = 'update';  
            let id = $(this).closest('tr').find('td:eq(0)').text();

            $.ajax({
                url: site_url('patient/getPatient'),
                type: 'post',
                data: {id : id},
                dataType: 'json',
                success: function(response){
                    for (let i in response){
                        $('#patient_form').find('input').each(function(key,val){    
                                $('[name=' + i + ']').val(response[i]);
                        });
                        if (i === 'gender'){
                            $('[name=' + i + ']').dropdown('set selected', response[i]);
                        }
                        if (i === 'bloodtype'){
                            $('[name=' + i + ']').dropdown('set selected', response[i]);
                        }
                    }
                },
                complete: function(){
                    patient_modal('Update patient', 'Update patient');
                }
            });
         
           
          });

          //

          //
          $(document).on('click', '.view', function(){
                alert('test');
          });

          function patient_modal(header, btnlabel)
          { 
            $('#patient_modal .header').text(header);
            $('#btnAction').text(btnlabel);
            $('#patient_modal').modal({
                onHidden: function(){
                    $('#patient_form').form('reset');
                    $('.modal-message').removeClass('error').addClass('info');
                    $('#message-icon').removeClass('warning').addClass('info').next().html('<h4>The password is set to "default".</h4>');
                 },
                autofocus: false
                }).modal('show');
          }
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
      }

      if (window.location.pathname === '/healthcare/dashboard/appointment'){
       
        var id;
        var timerange = [];
        var appointment_action;
        var disabled_dates = [];
        $.ajax({
            url: site_url('appointment/fetchdisabledDates'),
            data: {},
            dataType: 'json',
            type: 'get',
            success: function(data){
              $.each(data, function(index, val){
                  let restrict = moment(val.start).format('DD MM YYYY');
                  disabled_dates.push(restrict);
              });
            },
            complete: function(){
                var datepicker  = $('#appoint_date').Zebra_DatePicker({
                    container: $('body'),
                    position: 'below',
                    offset: [-175,255],
                    show_icon : false,
                    direction: true,
                    disabled_dates: disabled_dates ,
                    first_day_of_week : 7
                });
            }
        });
      
        
        
      $('#dropdown_name').select2({
            placeholder: 'Search patient...',
            minimumResultsForSearch: 5,
            minimumInputLength: 4,
            templateSelection: removeLabel,
            ajax:{
                url : site_url('search/patient'),
                dataType: 'json',
                delay: 250,
                data: function(params){
                        return{
                            q : params.term,
                            page: params.page
                        };
                },
             
                processResults: function(data){
                    return {
                        results: data
                    };
                },
            } 
        });
        function removeLabel(data, container) {
                if (data.text.indexOf('Patient') > 0){
                    return data.text.substring('0', data.text.indexOf('-'));
                }
                return 'Search patient...';
          }
        
         timepickOption();
   
 function timepickOption(){
     $.ajax({
            url: site_url('appointment/getAvailableTime'),
            data: {appointment_date: moment().format('YYYY-MM-DD')},
            type: 'get',
            dataType: 'json',
            success: function(data){
                $('[name=time]').timepicker({
                    disableTextInput: true,
                    orientation: 't',
                    minTime: '09:00',
                    maxTime: '17:00',
                    'disableTimeRanges': data        
                }); 
         }
    });
}   



     function updateAppointment(){
        var date = $('[name=date]').val();
        var time = $('[name=time]').val();
        if (time === ''){
            time = '';
        } else {
            time = moment(time, 'HH:mm a').format('HH:mm:ss');
        }
        if (date === ''){
            date = '';
        } else {
            date = moment($('[name=date]').val()).format('YYYY-MM-DD');
        }
   
        $.ajax({
             url: site_url('appointment/updateEvent' ),
             data: {appointment_time: time, appointment_date: date, appointment_id: id} ,
             type: 'post',
             dataType: 'json',
             success: function(response){
                if(response.success){
                    $('#appointmentModal').modal('hide');
                    $('#message-icon').removeClass('info circle').addClass('check circle outline');
                    $('.info.message').removeClass('hidden info').addClass('visible success').find('.content').html(response.message);
                    appointment_table.ajax.reload();
                    $('#appointmentList').fullCalendar('refetchEvents');
                }
             }
        });   
     }
     function createAppointment(){
        let patient_id = $('#dropdown_name').val();
        var date = $('[name=date]').val();
        var time = $('[name=time]').val();
        if (time === ''){
            time = '';
        } else {
            time = moment(time, 'HH:mm a').format('HH:mm:ss');
        }
        if (date === ''){
            date = '';
        } else {
            date = moment($('[name=date]').val()).format('YYYY-MM-DD');
        }
   
        $.ajax({
             url: site_url('appointment/createEvent' ),
             data: {appointment_time: time, appointment_date: date, user_id : user_id, patient_id: patient_id} ,
             type: 'post',
             dataType: 'json',
             success: function(response){
                if(response.success){
                    $('#appointmentModal').modal('hide');
                    $('#message-icon').removeClass('info circle').addClass('check circle outline');
                    $('.info.message').removeClass('hidden info').addClass('visible success').find('.content').html(response.message);
                    appointment_table.ajax.reload();
                    $('#appointmentList').fullCalendar('refetchEvents');
                } else{
                    $('.error.message').removeClass('hidden').addClass('visible');
                    if (response.errors){
                        var error = [];
                        $.each(response.errors, function(index, val){
                            error.push('<span class="error-message">' + val + '</span>');
                        })
                        $('#message').html(error);
                    }else{
                        $('#message').html(response.message);             
                    }
                    }
             }
        });   
     }
     $(document).on('click', '#appointmentAction', function(e){
         e.preventDefault();
            if (appointment_action === 'add'){
             createAppointment(); 
             timepickOption();   
            } else{
                updateAppointment();
                timepickOption();   
            }
           
     });

      var appointment_table = $('#appointment_table').DataTable({
                    ajax: site_url('appointment/upcomingEvents'),
                    language: {
                        search: '_INPUT_',
                        searchPlaceholder: 'Search records...'
                    },
                    autoWidth: false,
                    columnDefs:[
                        {'visible': false, targets:0},
                        {'visible': false, targets: 1 },
                    ],
                    columns:[
                        {'width' : '5%', targets: 0},
                        {'width' : '5%', targets: 1},
                        {'width' : '25%', targets: 2},
                        {'width' : '13%', targets: 3},
                        {'width' : '5%', targets:4},
                        {'width' : '20%', targets:5},
                        {'width' :  '22%', targets:6}
                    ]
                    
      });
      $('#appointment_table_filter').prepend('<button class="ui small icon button blue" id="addAppointment"><i class="add to calendar icon"></i> Add appointment</button>');
      $('#appointment_table_filter').addClass('icon').append('<i class="search icon"><i>');


      $(document).on('click','#addAppointment', function(){
          appointment_action = 'add';
          timepickOption();
          $('#appointmentModal div.header').html('Add appointment');
          $('#appointmentAction').html('Add appointment');
          $('#dropdown_name').next().show();
          $('#selected_name').hide();
          $('#appointmentModal').modal({
              autofocus: false,
              onHidden: function(){
                  $('.error.message').removeClass('visible').addClass('hidden');
                  $('#appointmentForm')[0].reset();
                  $('#dropdown_name').select2('val', 'All');
              },
              onApprove: function(){
                  return false;
              }
          }).modal('show');
      })

      $(document).on('click', '.update', function(){
        appointment_action = 'update';
        id = appointment_table.row($(this).parents('tr')).data()[0];
        $('#appointmentModal div.header').html('Update appointment');
        $('#appointmentAction').html('Update appointment');
        let name = $(this).closest('tr').find('td:eq(0)').text();
        let date = $(this).closest('tr').find('td:eq(1)').text();
        let time = $(this).closest('tr').find('td:eq(2)').text();
        $('#dropdown_name').next().hide();
        $('#selected_name').val(name).show();
        $('[name=date]').val(date);
        $('[name=time]').val(time);
        $('#appointmentModal').modal({
            autofocus: false,
            onHidden: function(){
                $('.error.message').removeClass('visible').addClass('hidden');
                $('#appointmentForm')[0].reset();
                $('#dropdown_name').select2('val', 'All');
            },
            onApprove: function(){
                return false;
            }
        }).modal('show');
      });

      $('#appointment_table').on('click', '.remove', function(){
        var id = appointment_table.row($(this).parents('tr')).data()[0];  
        var name = appointment_table.row($(this).parents('tr')).data()[2];  
        $('#prompt_modal').modal({
            onApprove: function(){
                $.ajax({
                    url: site_url('appointment/cancelAppointment'),
                    data: {appointment_id : id},
                    type: 'post',
                    dataType: 'json',
                    success: function(response){
                        if (response.success) {
                            $('#appointmentModal').modal('hide');
                            $('.info.message').removeClass('hidden').addClass('visible').find('.content').html('Appointment of ' + name + ' has been called.');
                            appointment_table.ajax.reload();
                        } 
                     return;
                    }
                });
            }
        }).modal('show');
        

       
      });
     $('[name=date]').on('change', function(){
      
        $.ajax({
         url: site_url('appointment/getAvailableTime'),
         data: {appointment_date : $(this).val()},
         type: 'get',
         dataType: 'json',
         success: function(data){
         
             $('[name=time]').timepicker({
                disableTextInput: true,
                 orientation: 't',
                 minTime: '09:00',
                 maxTime: '17:00',
                 'disableTimeRanges': data        
             });
         
             }
      });
    });

    $('#appointmentList').fullCalendar({
        defaultView: 'month',
        height: '600px',
        aspectRatio: 2,
        eventLimit: true,
        editable: false,
        selectable: false,
        allDaySlot: false,
        displayEventTime: false,
        eventBorderColor: "#1fbbee",
        
        eventOrder: "start",
        header: {
               left: 'prev,next,',
               center: 'title',
               right: 'today'
       },
        events:{
           url:site_url('appointment/fetchEvents')
       },
       select: function (start, end, allDay) { 
           alert(start);
       },
       eventClick: function (event) {
      }
     });
   

       
    }

    if (window.location.pathname === '/healthcare/dashboard/consultation'){
        $('em.date').html('Date : ' + moment().format('MMMM DD, YYYY'));
        var today = moment().format('YYYY-MM-DD');
        var app_id, patient_id;
        var wizard = $('#wizard');	
        wizard.children("div").steps({
            headerTag: ".wizard-step",
            bodyTag: ".ui.segment",
            transitionEffect: "fade",
            enablePagination : false,   
        });

       function payment_modal(){
           $('#payment_modal').modal({
               closable: false,
            onHidden: function(){
                $('#payment_form').form('reset');
            },
            autofocus: false
            }).modal('show');
       } 
       var consultation_table =
            $('#consultation_table').DataTable({
                paging: false,
                info : false,
                ordering: false,
                lengthChange: false,
                ajax:{
                    url: site_url('consultation/getlogbyID'),
                    type: 'post',
                    data: function(d){
                        d.patient_id = patient_id;
                    }
                },
                language: {
                    search: '_INPUT_',
                    searchPlaceholder: 'Search log...'
                },
            });
            $('#consultation_table_filter').addClass('icon').append('<i class="search icon"><i>');
            
        // var consultation_table = 
        $('#before-consult').click(function(){
            // $('#steps-uid-0-h-0').css('background-color', '#69cc69');
            wizard.children("div").steps('next');

        })  ;        
        //$('.appoint').addClass('disabled');
        $('.ui.checkbox').checkbox({
            onChecked: function(){
                $('.appoint').addClass('disabled');
                $('#patient_name').parent().slideDown();
                $('#wizard').slideDown();
            },
            onUnchecked: function(){
                $('.appoint').removeClass('disabled');
                $('#patient_name').parent().slideUp();
                $('#wizard').slideUp(); 
            }
        });
        $('#on-consult').on('click', function(){
             
            var data = $('#consultForm').serialize()+'&consultation_date=' + today + '&patient_id=' + $('#patient_id').val() + '&type=' + $('#consult_type').val() + '&appointment_id=' + app_id ;  
           
            $.ajax({
                url: site_url('consultation/insertConsultation'),
                type: 'post',
                data: data,
                dataType: 'json',
                success: function(data){
                   payment_modal();
                }
            });
        });
        $(document).on('click','#btn_payment', function(event){
            event.preventDefault();
            console.log($('#payment_form').serialize());
            $.ajax({
                url : site_url('consultation/payment'),
                data: $('#payment_form').serialize() + '&payment_date=' + today + '&patient_id=' + patient_id,
               
                type: 'post',
                success: function(){
                    $('#consultForm')[0].reset();
                    $('#patientForm')[0].reset();
                    $('#payment_modal').modal('hide');
                    $('#wizard').slideUp();
                    $('.ui.checkbox').checkbox('uncheck');
                    $('#patient_name').select2('val', 'ALL');
                    $('#wizard').children('div').steps('previous');
                    patient_id = '';
                    consultation_table.ajax.reload();

                }
            })
        })
        $.ajax({
            url: site_url('appointment/getAppointmentsToday'),
            type: 'post',
            dataType: 'json',
            data: {},
            success: function(data){
                options = [];
                $.each(data, function(index, val){
                     options.push('<div class="item" data-appointment="' + val[0] + '" data-value="' + val[1] + '">' + val[2] + '</div>');
                });
             $('.appoint').find('.menu').html(options);
             $('.appoint').dropdown('refresh');
            }
        });
        $('.appoint').dropdown({
            onChange: function(key, text,rand){
                patient_id = key;
                $.ajax({
                    url: site_url('patient/getPatient'),
                    data: {id : key},
                    dataType: 'json',
                    type: 'post',
                    success: function(response){
                        for (let i in response){
                            $('[name=' + i +']').val(response[i]);
                        }
                        $('#before-consult').prop('disabled', false);
                        $('#wizard').slideDown();
                        $('#consult_type').val('appointment'); 
                        app_id = $(rand).attr('data-appointment');
                    
                        consultation_table.ajax.reload();
                       
                    }
                });
            }
        })
        $('#patient_name').on('select2:select', function(){
         
            var selected = $(this).find(':selected');
            patient_id = selected[0].value;

            $.ajax({
                url: site_url('patient/getPatient'),
                data: {id : patient_id},
                type: 'post',
                dataType: 'json',
                success: function(response){
                    for (let i in response){
                        $('[name=' + i + ']').val(response[i]);
                    }
                    $('#wizard').slideDown();
                   $('#before-consult').prop('disabled', false);
                   $('#consult_type').val('walk-in');
                  consultation_table.ajax.reload();
                }
            });
         
         
        });
    
        $('#patient_name').select2({
            placeholder: 'Search patient...',
            minimumResultsForSearch: 5,
            minimumInputLength: 4,
            templateSelection: removeLabel,
            ajax:{
                url : site_url('search/patient'),
                dataType: 'json',
                delay: 250,
                data: function(params){
                        return{
                            q : params.term,
                            page: params.page
                        };
                },
             
                processResults: function(data){
                    return {
                        results: data
                    };
                },
            } 
        });
        function removeLabel(data, container) {
                if (data.text.indexOf('Patient') > 0){
                    return data.text.substring('0', data.text.indexOf('-'));
                }
                return 'Search patient...';
          }
        
         

    }




});  //end of document ready

//initialize chartjs component
function quarterChart(){
  var ctx = document.getElementById("visitTypeChart").getContext('2d');
  var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
          labels: ["1st Quarter", "2nd Quarter"],
          datasets: [{
              label: 'Number of Patient',
              data: ['12','51'],
              backgroundColor: [
                  'rgba(255, 99, 132, 0.2)',
                  'rgba(54, 162, 235, 0.2)',
                  'rgba(255, 206, 86, 0.2)',
                  'rgba(75, 192, 192, 0.2)',
                  'rgba(153, 102, 255, 0.2)',
                  'rgba(255, 159, 64, 0.2)'
              ],
              borderColor: [
                  'rgba(255,99,132,1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(255, 206, 86, 1)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(153, 102, 255, 1)',
                  'rgba(255, 159, 64, 1)'
              ],
              borderWidth: 1,
              fill: false
          }]
      },
      options: {
          legend:{
            display: false
          },
          scales: {
              yAxes: [{
                  ticks: {
                      beginAtZero:true
                  }
              }]
          }
      }
  });
}


$('#patient_form').find('input,select').on('change', function(){
    var index = $(this).attr('name');                   
    if (index === 'firstname'  || index === 'lastname' || index === 'middlename' ||  index === 'address' || index === 'contact'){
        $(this).next('span').html('');   
    } else {
        $(this).parent().next().html('');
    }
   
});

    // var ctx = document.getElementById("visitTypeChart").getContext('2d');
    //      var myChart = new Chart(ctx, {
    //          type: 'pie',
    //          data: {
    //              labels: ["1st Quarter", "2nd Quarter"],
    //              datasets: [{
    //                  label: 'Number of Patient',
    //                  data: ['12','51'],
    //                  backgroundColor: [
    //                      'rgba(255, 99, 132, 0.2)',
    //                      'rgba(54, 162, 235, 0.2)'
    //                  ],
    //                  borderColor: [
    //                      'rgba(255,99,132,1)',
    //                      'rgba(54, 162, 235, 1)'
    //                  ],
    //                  borderWidth: 1,
    //                  fill: false
    //              }]
    //          },
    //          options: {
    //              legend:{
    //                display: false
    //              },
    //              scales: {
    //                  yAxes: [{
    //                      ticks: {
    //                          beginAtZero:true
    //                      }
    //                  }]
    //              }
    //          }
    //      });