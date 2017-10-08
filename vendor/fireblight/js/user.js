$(function() {
    
    //initialize user data table
    var user_table =  $('#user_table').DataTable({
        ajax: site_url('user/getUsers'),
        language:{
            search: '_INPUT_',
            searchPlaceholder: 'Search records...'
          },
        columnDefs: [
            {orderable: false, targets: -1}
        ]
    });

    //append custom button inside the user data table
    $('#user_table_filter').prepend('<button class="ui small icon button blue" id="add_user"><i class="add user medium icon"></i> Add user</button>');
    $('#user_table_filter').addClass('icon').append('<i class="search icon"><i>');

    //toggle user modal
    $(document).on('click', '#add_user', function(){
        $('.ui.mini.modal').modal({
            onHidden: function(){
                $('#user_form')[0].reset();
                $('#user_modal input').next().html('').parent().removeClass('error');   
            },
            autofocus: false
            }).modal('show');
    });


    //insert user to the database
    $('#user_form').on('submit', function(event){
        event.preventDefault();
        $.ajax({
            url: site_url('user/createUser'),
            data: $(this).serialize(),
            type: 'post',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('.ui.mini.modal').modal('hide');
                    $('.ui.message').removeClass('hidden').find('.header').text(response.message);
                    user_table.ajax.reload();
                } else {
                    if (response.errors) {
                        $.each(response.errors, function(index, val){
                            $('[name=' + index + ']').next().html(val).parent().addClass('error');
                        });
                    }
                }
            }
        });
    });
    $('#user_form').find('input').on('change', function(){
        var index = $(this).attr('name');                   
       if (index === 'firstname'  || index === 'lastname' || index === 'username'){
           $(this).next().html('').parent().removeClass('error');   
       }  
   });
    // $('#user_form').on('change', '[name=lastname]', function(){
    //     var first = $('[name=firstname]').val().slice(0,4);
    //     var last = $(this).val().slice(0,4);    
    //     $('[name=username]').val(first + last);
    // });
});