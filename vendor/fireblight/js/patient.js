$(function() {

    //action flag
    var patient_action, patient_id;

    //initialize dropdown component
    $('.ui.dropdown').dropdown();

    //initialize patient datatables
    var patient_table = $('#patient_table').DataTable({
          ajax: site_url('patient/getPatientList'),
          autoWidth: false,

          //order by latest patient

          // order : [
          //   [0 , 'desc']
          // ],
          columnDefs:[
            {
              orderable: false, searchable: false ,
              data: null,
              defaultContent: '<button class="ui mini icon button orange update"><i class="edit icon"></i>Edit</button>',
              targets: 10
            },
            {
                className: 'details-control',
                orderable:      false,
                data:           null,
                defaultContent: '',
                targets: 11
            },
            {orderable: false, searchable: false, targets: -1},
            {visible: false, orderable: false, searchable: false, targets: 4},
            {visible: false, orderable: false, searchable: false, targets: 5},
            {visible: false, orderable: false, searchable: false, targets: 6},
            {visible: false, orderable: false, searchable: false, targets: 7},
            {visible: false, orderable: false, searchable: false, targets: 8},
            {visible: false, orderable: false, searchable: false, targets: 9}
          ],

            columns: [

              { data: "id", targets: 0 },
              { data: "firstname", targets: 1 },
              { data: "middlename", targets: 2 },
              { data: "lastname", targets: 3 },
              { data: "gender", targets: 4},
              { data: "birthdate", targets: 5},
              { data: "age", targets: 6},
              { data: "bloodtype", targets: 7},
              { data: "address", targets: 8},
              { data: "contact", targets: 9},
              { width: "8%", targets: 10}


          ],
          language:{
            search: '_INPUT_',
            searchPlaceholder: 'Search patient records...'
          }
    });

    $('#patient_table tbody').on('click', 'td.details-control', function () {
      var tr = $(this).closest('tr');
      var row = patient_table.row( tr );

      if ( row.child.isShown() ) {
          row.child.hide();
          tr.removeClass('shown');
      }
      else {

          var pro = tr.hasClass('shown');
          $(row).removeClass('shown');
          if (patient_table.row('.shown').length){
            $('.details-control', patient_table.row( '.shown' ).node()).click();
          }
          row.child( patientextraInfo(row.data()) ).show();
          tr.addClass('shown');

      }
  } );


    //add custom button in datatables and style the search box
    $('#patient_table_filter').prepend('<button class="ui icon button blue" id="add_patient"><i class="child icon"></i>Add patient</button>');
    $('#patient_table_filter').addClass('icon').append('<i class="search icon"><i>');

    //open patient modal
    $(document).on('click', '#add_patient', function(){
        patient_action = 'add';
        patient_modal('Add patient', 'Add patient');
    });

    //initalize datepicker component
    $('#birthdate').Zebra_DatePicker(
          {
              container: $('body'),
              position: 'top',
              offset: [-190,0],
              show_icon : false,
              direction: false,
              first_day_of_week : 7,
              onSelect: function(date){
                  var date = new Date(date);
                   $('[name=age]').val(get_age(date));
                   $(this).parent().next('span').html('').closest('.field').removeClass('error');
              }
          }
     );

    //display extra info in the patient fucking table
    function patientextraInfo(d) {
        return '<table class="ui single line padded celled table" width="100%">' +
               '<tr>' +
                    '<td>Gender: ' + d.gender + '</td>' +
                    '<td>BloodType: ' + d.bloodtype + '</td>' +
                '</tr>' +
                '<tr>' +
                    '<td>Weight: ' + d.weight  + '</td>' +
                    '<td>Height: ' + d.height + '</td>' +
                '</tr>' +
                '<tr>' +
                    '<td>Birthdate: ' + d.birthdate + '</td>' +
                    '<td>Age: ' + d.age + '</td>' +
                '</tr>' +
                '<tr>' +
                    '<td>Address: ' + d.address + '</td>' +
                    '<td>Contact Number: ' + d.contact + '</td>' +
                '</tr>' +
                '</table>';
    }

    //perform update or add based on patient_action variable
    $(document).on('click', '#btnAction', function(){
        if (patient_action === 'add'){
            doInsert();
        } else {
            doUpdate();
        }
    });

    $(document).on('click', '.update', function(){
      patient_action = 'update';
      patient_id = $(this).closest('tr').find('td:eq(0)').text();
      doRetrieve(patient_id);
    });

    $(document).on('click', '.view', function(){
          alert('test');
    });

    function patient_modal(header, btnlabel)
    {
      $('#patient_modal .header').text(header);
      $('#btnAction').text(btnlabel);
      $('#patient_modal').modal({
          onHidden: function(){
              $('#patient_form')[0].reset();
              $('#patient_form ').find('.ui.dropdown').dropdown('restore placeholder text');
              $('.modal-message').removeClass('error').addClass('info');
              $('#message-icon').removeClass('warning').addClass('info').next().html('<h4>The password is set to "default".</h4>');
              $('#patient_form').find('input').next('span').text('');
              $('#patient_form').find('select').parent().next().text('');
              $('#patient_form').find('[name=birthdate]').parent().next().text('');
              $('#patient_form').find('.field').removeClass('error');
          },
          autofocus: false
          }).modal('show');
    }
    function doRetrieve(patient_id)
    {
        $.ajax({
            url     : site_url('patient/getPatient/' + patient_id),
            type    : 'post',
            dataType: 'json',
            success: function(response){
                for (var name in response){
                    $('#patient_form').find('input').each(function(key,val){
                            $('[name=' + name + ']').val(response[name]);
                    });
                    if (name === 'gender'){
                        $('[name=' + name + ']').dropdown('set selected', response[name]);
                    }
                    if (name === 'bloodtype'){
                        $('[name=' + name + ']').dropdown('set selected', response[name]);
                    }
                }
            },
            complete: function(){
                patient_modal('Update patient', 'Update patient');
            }
        });
    }
    function doInsert()
    {
        $.ajax({
            url: site_url('patient/createPatient'),
            data: $('#patient_form').serialize(),
            dataType: 'json',
            type: 'post',
            success: function(response){
               if (! response.success){
                   if (response.errors){
                        $.each(response.errors, function(index, value){
                           if (index === 'firstname'  || index === 'lastname' || index === 'middlename' ||  index === 'address' || index === 'contact'){
                                        if(value !== ''){
                                            $('[name=' + index + ']').next('span').text(value).parent('.field').addClass('error');
                                        }
                                   } else if (index === 'birthdate' || index === 'gender' || index === 'bloodtype') {
                                       $('[name=' + index + ']').parent().next().text(value).parent('.field').addClass('error');
                                   }
                        });
                   }

               }else {
                $('#patient_modal').modal('hide');
                //$('.ui.message').removeClass('hidden').addClass('visible').find('.content').html(response.message);
               patient_table.ajax.reload();
               localStorage.setItem('patient_id', response.id);
               //console.log(localStorage.getItem('patient_id'));
                if ($('[name=user_type]').val() === 'doctor')
               window.location.href = site_url('dashboard/consultation/' + response.id);

               }
            }
        });
    }
    function doUpdate()
    {
        $.ajax({
            url: site_url('patient/updatePatient/' + patient_id),
            data: $('#patient_form').serialize(),
            dataType: 'json',
            type: 'post',
            success: function(response){
                if (! response.success){
                    if (response.errors){
                         $.each(response.errors, function(index, value){
                            if ( index === 'firstname'  || index === 'lastname' || index === 'middlename' ||  index === 'address' || index === 'contact'){
                                         if(value !== ''){
                                            $('[name=' + index + ']').next('span').text(value).parent('.field').addClass('error');
                                        }
                                    } else {
                                        $('[name=' + index + ']').parent().next().text(value).parent('.field').addClass('error');
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

    $('#patient_form').find('input,select').on('change', function(){
         var index = $(this).attr('name');
        if (index === 'firstname'  || index === 'lastname' || index === 'middlename' ||  index === 'address' || index === 'contact'){
            $(this).next('span').html('').closest('.field').removeClass('error');
        }  else if (index === 'gender' || index === 'bloodtype') {
           $('[name=' + index + ']').parent().next().text('').closest('.field').removeClass('error');
        }
    });

    //disallow numbers for name inputs

    // $('[name=firstname], [name=middlename], [name=lastname]').on('keydown', function(e){
    //   let key = e.keyCode;
    // 	if (!((key === 9) || (key === 32) || (key >= 35  && key <= 40) || (key === 46) || (key >= 65 && key <= 90) )) {
    // 		e.preventDefault();
    // 	}
    // });

    //disallow alphabet and symbols for contact inputs

    // // $('[name=contact]').on('keydown', function(e){
    // 	let key = e.keyCode;
    // 	if (! ((key === 9) || (key === 8) || (key === 32) ||   (key >= 35  && key <= 40) || (key === 46) || ((key >= 48 && key <= 57) || (key >= 96 && key <= 105)))) {
    // 		e.preventDefault();
    // 	}
    // });

    //specify maximum length for contact

    // $('[name=contact]').attr('maxLength', 11);
});
