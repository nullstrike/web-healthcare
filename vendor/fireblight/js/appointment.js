$(function() {

    //variables for storing data
    var user_id = $('[name=user_id]').val(),
        appointment_id,
        patient_id,
        appointment_action,
        disabled_dates = [],
        time,
        date,
        restricted;


    $.ajax({
        url: site_url('appointment/getDisabledDates'),
        data    : {},
        dataType: 'json',
        type    : 'get',
        success : function(data){
                $.each(data, function(index, val){
                    var restrict = moment(val.start).format('DD MM YYYY');
                    disabled_dates.push(restrict);
                });
        },
        complete: function(){

            //initialize datepicker component
            var datepicker  = $('#appoint_date').Zebra_DatePicker({
                container: $('body'),
                position: 'below',
                offset: [-175,255],
                show_icon : false,
                direction: true,
                disabled_dates: disabled_dates ,
                first_day_of_week : 7,
                onSelect : function(date) {
                    date = moment($('[name=date]').val()).format('YYYY-MM-DD');
                    $('[name=time]').val('');

                    $.ajax({
                        url     : site_url('appointment/getUnavailableTime/'+ date),
                        data    : { },
                        type    : 'get',
                        dataType: 'json',
                        success : function(timeslot){
                                   restricted = timeslot;
                                   $('[name=time]').timepicker('remove');
                        },
                        complete: function(){

                            //refreshes the disableTimeRanges setting on date change
                            $('[name=time]').timepicker({
                                disableTextInput: true,
                                orientation: 't',
                                minTime: '09:00',
                                maxTime: '17:00',
                                disableTimeRanges: restricted
                             });
                        }
                   });
                }
            });
        }
    });


    //initialize dropdown search component
    //performs a query to the patient controller
    $('#dropdown_name').select2({
        placeholder             : 'Search patient...',
        minimumResultsForSearch : 5,
        minimumInputLength      : 4,
        templateSelection       : removeLabel,
                    ajax:{
                                url     : site_url('search/patient'),
                                dataType: 'json',
                                delay   : 250,
                                data    : function(params){
                                 return{
                                    q   : params.term,
                                    page: params.page
                                    };
                                },
                                processResults : function(data){
                                 return {
                                    results: data
                                  };
                                },
                  }
    });

    //trim patient id label and set the dropdown to the placeholder when it is empty
    function removeLabel(data, container) {
            if (data.text.indexOf('Patient') > 0){
                return data.text.substring('0', data.text.indexOf('-'));
            }
            return 'Search patient...';
      }

    //initialize timepicker component and set the disabledTimeRanges
    //settings based on the response received from the ajax request

        $.ajax({
        url: site_url('appointment/getUnavailableTime/' + moment().format('YYYY-MM-DD')),
        data: { },
        type: 'get',
        dataType: 'json',
        success: function(restrictedTimeSlot){
            $('[name=time]').timepicker({
                disableTextInput: true,
                orientation: 't',
                minTime: '09:00',
                maxTime: '17:00',
                disableTimeRanges: restrictedTimeSlot
            });
        }
    });


    //performs update appointment
    function updateAppointment(){
        time = $('[name=time]').val();
        date = $('#appoint_date').val();

        //converts time to 24-hours am/pm format ;
        format_time = moment(time, 'HH:mm a').format('HH:mm:ss');

        //perform an ajax request
        $.ajax({
                url      : site_url('appointment/updateAppointment/' + appointment_id ),
                data     :
                    {
                            appointment_time: time,
                            appointment_date: date,

                    },
                type     : 'post',
                dataType : 'json',
                beforeSend: function() {
                    $('#count_wrapper').children('.header.item').remove();
                },
                success  : function(response) {
                            if(response.success) {
                                $('#appointmentModal').modal('hide');
                                $('#message-icon').removeClass('info circle').addClass('check circle outline');
                                $('.info.message').removeClass('hidden info').addClass('visible success').find('.content').html(response.message);
                                $('#appointmentList').fullCalendar('refetchEvents');
                                appointment_table.ajax.reload();
                                upcoming_notify();
                            }
            }
        });
    }



    //performs create appointment
    function createAppointment(){
        time = moment($('[name=time]').val(),'HH:mm a').format('HH:mm');
        date = $('#appoint_date').val();
        patient_id = $('#dropdown_name').val();
        //converts time to 24-hours AM/PM format ;
       // format_time = moment($('[name=time]').val(), 'HH:mm a').format('HH:mm:ss');

        //perform an ajax request
        $.ajax({
                url     : site_url('appointment/createAppointment' ),
                data    : {
                            appointment_time: time,
                            appointment_date: date,
                            user_id : user_id,
                            patient_id: patient_id
                           } ,
                type    : 'post',
                dataType: 'json',
                success : function(response) {
                           if(response.success) {
                             console.log(response);
                               //alert(response.message);
                             $('#appointmentModal').modal('hide');
                             $('#message-icon').removeClass('info circle').addClass('check circle outline');
                             $('.info.message').removeClass('hidden info').addClass('visible success').find('.content').html(response.message);
                             $('#appointmentList').fullCalendar('refetchEvents');
                             appointment_table.ajax.reload();
                             $('#count_wrapper').children('.header.item').remove();
                             upcoming_notify();
                             //window.location.reload();
                           } else {
                             console.log(response.errors);
                             $('.error.message').removeClass('hidden').addClass('visible');
                                 if (response.errors){
                                     var error = [];
                                     $.each(response.errors, function(index, val){
                                       error.push('<span class="error-message">' + val + '</span>');
                                     });
                                     $('#message').html(error);
                                 } else {
                                     $('#message').html(response.message);
                                 }
                          }
                  }
           });
    }

    //perform update or add based on patient_action variable
    $(document).on('click', '#appointmentAction', function(event){
         event.preventDefault();
         if (appointment_action === 'add'){
              createAppointment();
         } else {
              updateAppointment();
         }
    });

    //initialize appointment datatables
    var appointment_table = $('#appointment_table').DataTable({
                     ajax    : site_url('appointment/getAllAppointments'),
                     language: {
                             search  : '_INPUT_',
                             searchPlaceholder: 'Search records...'
                     },
                    autoWidth: false,
                    columnDefs:[
                              {visible: false, targets:0},
                              {visible: false, targets: 1 },
                              {orderable: false, searchable: false,
                               data: null, defaultContent:'<button class="ui icon mini orange button update"><i class="repeat icon"></i>Reschedule</button>' +
                                                          '<button class="ui icon mini red button remove"><i class="delete calendar icon"></i>Cancel Appointment</button>',
                               targets: -1}
                    ],
                    columns:[

                        {'width' : '25%', targets: 0},
                        {'width' : '24%', targets: 1},
                        {'width' : '15%', targets: 2},
                        {'width' : '7%', targets: 3},
                        {'width' : '7%', targets:4},
                        {'width' : '10%', targets:5},
                        {'width' :  '12%', targets:6}
                    ]
    });

    //add custom button in datatables and style the search box
    $('#appointment_table_filter').prepend('<button class="ui small icon button blue" id="addAppointment"><i class="add to calendar icon"></i> Add appointment</button>');
    $('#appointment_table_filter').addClass('icon').append('<i class="search icon"><i>');


  $(document).on('click','#addAppointment', function(){

        //set the action flag to add
        appointment_action = 'add';

        //change modal header text
        $('#appointmentModal div.header').html('Add appointment');

        //change button text
        $('#appointmentAction').html('Add appointment');

        //show the dropdown element
        $('#dropdown_name').next().show();

        //hide the selected name input
        $('#selected_name').hide();

        //open the appointment modal
        $('#appointmentModal').modal({
            autofocus: false,
            onHidden : function(){
                  $('.error.message').removeClass('visible').addClass('hidden');
                  $('#appointmentForm')[0].reset();
                  $('#dropdown_name').select2('val', 'All');
            },
           onApprove: function(){
                  return false;
            }
        }).modal('show');
  });

  $(document).on('click', '.update', function(){

        //set the action flag to update
        appointment_action = 'update';

        //assign value to appointment_id variable
        appointment_id = appointment_table.row($(this).parents('tr')).data()[0];

        //change modal header text
        $('#appointmentModal div.header').html('Update appointment');

        //change button text
        $('#appointmentAction').html('Update appointment');

        //assign value to each variable
        var selected_name = $(this).closest('tr').find('td:eq(0)').text();
        var selected_date = $(this).closest('tr').find('td:eq(1)').text();
        var selected_time = $(this).closest('tr').find('td:eq(2)').text();

        //hide the dropdown element
        $('#dropdown_name').next().hide();

        //populate form input based on the variable above
        $('#selected_name').val(selected_name).show();
        $('[name=date]').val(selected_date);
        $('[name=time]').val(selected_time);

        //open the appointment modal
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

   //performs cancellation of appointment
   $('#appointment_table').on('click', '.remove', function(){

        //assign value to appointment_id variable
        appointment_id = appointment_table.row($(this).parents('tr')).data()[0];

        //temporary variable to hold patient name
        var name = appointment_table.row($(this).parents('tr')).data()[2];

        $('#prompt_modal').modal({

            //callback function when the cancel appointment is clicked
            onApprove: function(){
                $.ajax({
                         url     : site_url('appointment/cancelAppointment/' + appointment_id),
                         data    : {},
                         type    : 'post',
                         dataType: 'json',
                         beforeSend: function(){
                            $('#count_wrapper').children('.header.item').remove();

                        },
                         success : function(response){
                                     if (response.success) {
                                       $('#appointmentModal').modal('hide');
                       //                $('.info.message').removeClass('hidden').addClass('visible').find('.content')
                         //                               .html('Appointment of ' + name + ' has been called.');
                         $('.info.message').remove();
                                      appointment_table.ajax.reload();
                                      upcoming_notify();
                                      $('#appointmentList').fullCalendar('refetchEvents');
                                    }
                         }
                    });
            }
        }).modal('show');
    });


    //initialize calendar component
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
        eventSources:[
            {
                  url: site_url('appointment/calendarAppointments'),
                  type: 'post',
                  color: '#0fb737',
                  textColor: 'white'
            },
            {
                  url: site_url('appointment/getDisabledDates'),
                  type: 'post',
                  color: 'red',
                  textColor: 'white'
            }
        ],
        dayClick: function (start, end, allDay) {
            var date = moment(start).format('YYYY-MM-DD');
            var today = moment().format('YYYY-MM-DD');
            var event = $('#appointmentList').fullCalendar('clientEvents', function(events){
                         return (moment(events.start).format('YYYY-MM-DD') == date);
            });

        if (today > date){
          return false;
        } else {
          if (event.length === 0 && $('[name=user_type]').val() === 'doctor'){
          $('#availability_modal').modal('show');
          $('#mark_disabled').off('click').on('click', function(){
              var appoint = {
                      title : 'Unavailable',
                      start : start,
                      color :'red'
                  };
              $.ajax({
                  url: site_url('appointment/disabledDate/' + moment(start).format('YYYY-MM-DD') + '/' + $('[name=user_id]').val()),
                  type: 'post',
                  success: function(){
                    $('#appointmentList').fullCalendar('renderEvent', appoint);

                  },
                  complete: function(){
                    $('#appointmentList').fullCalendar('refetchEvents');
                    $('#availability_modal').modal('hide');
                  }
              });

          });
        }
        }

           },

    });


});
