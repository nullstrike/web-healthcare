
//
// $('a').on('click', function () {
// 	$('#forgotPW').modal('show');
// })
//
// $('#findPW').on('click', function(){
// 	$('#forgotPW form').find('.field').fadeOut();
// });

$('#loginForm').on('submit', function(e){
	e.preventDefault();
	//user authentication
	$.ajax({
		url:  site_url('user/authenticate'),
		data: $(this).serialize(),
		type: 'post',
		dataType: 'json',
		success: function(response){
					 if (! response.success) {
						 if (response.errors) {
							 $errors = [];
							 $.each(response.errors, function(index, val) {
								$errors.push('<span>' + val + '</span>');
							 });

							 $('.ui.message.transition').addClass('negative visible	').removeClass('hidden').find('.validation_message').html($errors);
						 }
						 $('.ui.message.transition').addClass('negative visible	').removeClass('hidden').find('.validation_message').html(response.message);
					 } else {
					 		window.location.href = response.page;
					 }
			}
		});
});

$(function(){


		//update function
		function doDoctorUpdate(user_id) {
			$.ajax({
					url		 : site_url('user/updateDoctor/'+ user_id),
					data     : $('#updateForm').serialize(),
					type     : 'post',
					dataType : 'json',
					success: function(response){
							if (response.success === false) {
											if (response.errors){
														$('.ui.message.transition').addClass('negative').removeClass('hidden').find('.validation_message').html(response.errors);
											}
								 }
								 else {
												window.location.href = response.page;
								 }
						 }
			});
		}

		function doUserUpdate(user_id, data) {
			$.ajax({
					url		 : site_url('user/updateUser/'+ user_id),
					data     : data,
					type     : 'post',
					dataType : 'json',
					success: function(response){
							if (response.success === false) {
											if (response.errors){
												errors = [];
												for (let error in response.errors) {
													errors.push('<span>' + response.errors[error] + '</span>');
												}
												$('.ui.message.transition').addClass('negative').removeClass('hidden').find('.validation_message').html(errors);
											}
								}
								else {
												window.location.href = response.page;
								}
						}
			});
		}
		//update doctor information
		$('#updateForm').on('submit', function(event) {
			event.preventDefault();
				var user = $('[name=user]').val();
				var id = $('[name=userID]').val();
				var password = $('[name=userPass]').val();
				var passconf = $('[name=userpassConf]').val();

				if (user === 'doctor') {
					doDoctorUpdate(id);
				} else {
					var data = {
								userPass	  : password,
								userpassConf : passconf
							};

						doUserUpdate(id, data);
						sessionStorage.setItem('message', 'Successfully updated user. You may login now');

				}

		});

		//dismissable message box
		$('.message .close').on('click', function() {
			$(this).closest('.message').transition('fade');
		});

		//Display alert message on successful update
		var successMsg = sessionStorage.getItem('message');
		// if (successMsg && window.location.pathname === '/healthcare/') {
		// 	$('.ui.message.transition').addClass('positive').removeClass('hidden').find('h3').addClass('header').html(successMsg);
		// }

		//remove the message when page refreshes
		function removeMessage(){
				sessionStorage.removeItem('message');
		}
		window.onbeforeunload = removeMessage();
});
