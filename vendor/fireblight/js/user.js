//user authentication
$('#loginForm').on('submit', function(event){
	event.preventDefault();
	$.ajax({
		url:  site_url('user/authenticate'),
		data: $(this).serialize(),
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
	           	    	window.location.href = response.page;
			   }
			}
	  });
});

//update doctor information
$('#updateUserForm').on('submit', function(event) {
	event.preventDefault();
	$.ajax({
		url: site_url('user/doctorupdate'),
		data: $(this).serialize(),
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
           	    	window.location.href = response.page;
           }
		}
	});
});

//update user information
$('#changePassForm').on('submit', function(event){
	event.preventDefault();
	$.ajax({
		url: site_url('user/userupdate'),
		data: $(this).serialize(),
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
           	    	window.location.href = response.page;
           }
       }
    });
});

$('input').on('change', function() {
	$(this).next().removeClass().html('');
});
