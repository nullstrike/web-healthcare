$(function() {
    $('.ui.dropdown').dropdown();
    $('em.date').html('Date : ' + moment().format('MMMM DD, YYYY'));

    var today = moment().format('YYYY-MM-DD');
    var app_id, patient_id, consult_id;
    var uri = document.location.href;
    var uri_id = uri.split('/');
    var patientSession = localStorage.getItem('patient_id');

    if (! uri_id[6]) {
        $('#choice').show();
        $('#info-wrapper').hide();

    } else {
        if (patientSession !== null) {
            $('#consult_type').val('walk-in');
            var new_patient = localStorage.getItem('patient_id');
            $.ajax({
            url: site_url('patient/getPatient/' + new_patient),
            data: {},
            type: 'get',
            dataType: 'json',
            beforeSend: function(){
                $('#info-wrapper').show();
                $('#info-wrapper input').val('Retrieving...');

            },
            success: function(response){
                for (let i in response){
                    $('[name=' + i +']').val(response[i]);
                }
                $('#before-consult').prop('disabled', false);
            },
        });
      }else {
        window.location.href = site_url('dashboard/consultation');
      }
    }

    // var uri = window.location.href;
    // var uri_string = uri.split('/');
    // var new_id = uri_string[6];


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

            ordering: false,
            lengthChange: false,
            pageLength: 3,
            ajax:{
                url: site_url('consultation/getConsultationbyID'),
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

    $('#before-consult').on('click',function(){

        $('#consulting-wrapper').fadeIn();
        $('#info-wrapper').fadeOut();

    })  ;

    $('.ui.checkbox').checkbox({
        onChecked: function(){
            $('.appoint').addClass('disabled');
            $('#patient_name').parent().slideDown();
        },
        onUnchecked: function(){
            $('.appoint').removeClass('disabled');
            $('#patient_name').parent().slideUp();
        }
    });
    $('#on-consult').on('click', function(){

        var consultation_data = $('#consultForm').serialize()+'&consultation_date=' + today + '&patient_id=' + $('#patient_id').val() + '&type=' + $('#consult_type').val();

        $.ajax({
            url: site_url('consultation/createConsultation/' + app_id),
            type: 'post',
            data: consultation_data,
            dataType: 'json',
            success: function(response){
                if (response.success) {
                  consult_id = response.id;
                  $('#info-wrapper').fadeOut();
                  $('#consulting-wrapper').fadeOut();
                  $('[name=payee]').val(getName());
                  $('#choice').hide();
                  $('#payment').css('display', 'flex');
                } else {

                  if (response.errors){
                      for (let i in response.errors){
                        if (i === 'weight' ||  i === 'height') {
                          $('[name=' + i + ']').parent().next().html(response.errors[i]);
                        } else {
                          $('[name='+ i +']').next().html(response.errors[i]);
                        }
                      }
                  }
                }

            }
        });
    });
    $(document).on('click','#on-pay', function(event){
        event.preventDefault();
        $('[data-name=patientName]').text(getName());
        $('[data-name=payment_amount]').text($('[name=payment_amount]').val());
        $('[data-name=payment_given]').text($('[name=payment_given]').val());
        $('[data-name=date], [data-name=date_printed]').text(moment(today).format('MMMM DD, YYYY'));
        var payment_data = 'consultation_id=' + consult_id + '&payment_given='  + $('[name=payment_given]').val()
                            + '&payment_amount=' + $('[name=payment_amount]').val() + '&payment_date=' + today;
        $.ajax({
            url : site_url('consultation/createPayment'),
            data: payment_data,
            type: 'post',
            dataType: 'json',
            success: function(response){
                if (response.success){
                  $('#consultForm')[0].reset();
                  $('#patientForm')[0].reset();
                  $('.ui.checkbox').checkbox('uncheck');
                  $('#patient_name').select2('val', 'ALL');
                  patient_id = '';
                  print();
                  consultation_table.ajax.reload();
                  localStorage.removeItem('patient_id');
                  window.location.href = site_url('dashboard/consultation');
                } else {
                   if(response.errors){
                        $.each(response.errors, function(index, val) {
                            $('[name=' + index +']').parent().next().text(val);
                        });
                   }
                }


            },



        })
    })
    $.ajax({
        url: site_url('appointment/getCurrentAppointments'),
        type: 'post',
        dataType: 'json',
        data: {},
        success: function(data){
            options = [];
            $.each(data, function(index, val){
                 options.push('<div class="item" data-appointment="' + val[0] + '" data-value="' + val[1] + '">' + val[2] + '</div>');
            });
            if (options.length === 0) {
                $('.appoint').dropdown('set text', 'No appointments today');
            }
         $('.appoint').find('.menu').html(options);
         $('.appoint').dropdown('refresh');
        }
    });
    $('.appoint').dropdown({
        onChange: function(key, text,rand){
            patient_id = key;
            $.ajax({
                url: site_url('patient/getPatient/' + key),
                data: {},
                dataType: 'json',
                type: 'post',
                success: function(response){
                    for (let i in response){
                        $('[name=' + i +']').val(response[i]);
                    }
                    $('#before-consult').prop('disabled', false);
                    $('#info-wrapper').fadeIn();
                    $('#consulting-wrapper').fadeOut();
                    $('#payment').fadeOut();
                    $('#consultForm')[0].reset();
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
            url: site_url('patient/getPatient/' + patient_id),
            data: {},
            type: 'post',
            dataType: 'json',
            success: function(response){
                for (let i in response){
                    $('[name=' + i + ']').val(response[i]);
                }

                $('#consulting-wrapper').fadeOut();
                $('#info-wrapper').slideDown();
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

    function getChange() {
            var amount = parseInt($('[name=payment_amount]').val()),
                given  = parseInt($('[name=payment_given]').val()),
                change = '';

            if ($.trim(amount) !== '' && $.trim(given) !== '') {
                if (amount > given) {
                    change = '';
                    $('[name=payment_change]').closest('.field').addClass('error');
                } else {
                    $('[name=payment_change]').closest('.field').removeClass('error');
                    change = parseFloat(given - amount).toFixed(2);
                }
            }
            return change;
    }



    $('[name=payment_given]').on('blur', function(){
        var amount = $(this).val();
        if (parseInt(amount)) {
            if (amount.indexOf('.') === -1){
                $(this).val(amount + '.00');
            }else {
                return false;
            }
        }


    });


    $(document).on('change', '[name=payment_given],[name=payment_amount]', function() {
        let amount = $('[name=payment_amount]').val();
        let given = $('[name=payment_given]').val();
        if (parseInt(amount) && amount !== '' && $.trim(given) !== ''){
              $('[name=payment_change]').val(getChange());
        } else {
            $('[name=payment_change]').val('');
        }

      });

      $('#consultForm').find('textarea, input').on('change', function() {
        let name = $(this)[0].name;

        if (name === 'weight' ||  name === 'height') {
          $('[name=' + name + ']').parent().next().html('');
        } else {
          $('[name='+ name +']').next().html('');
        }
      })

    function getName() {
        let fname = $('[name=firstname]').val(),
            mname = $('[name=middlename]').val(),
            lname = $('[name=lastname]').val();
        return (fname + ' ' + mname + ', ' + lname);
    }

$('[name=payment_given]').on('change', function() {
    $(this).parent().next().text('');
})



});

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
