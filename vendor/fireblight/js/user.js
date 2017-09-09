//client side validation

//login form validation
$('#loginForm').form({
			fields: {
				username : 'empty',
				password : 'empty'
			},
			on : 'blur',
			onSuccess: function(e){
				e.preventDefault();

				//user authentication
				$.ajax({
					url:  site_url('user/authenticate'),
					data: $(this).serialize(),
					type: 'post',
					dataType: 'json',
					success: function(response){
								 if (! response.success){
													if (response.message !== undefined){
														$('.ui.message.transition').addClass('negative').removeClass('hidden').find('h3').html(response.message);
														$('input').closest('.field').addClass('error');
													}
									} else {
										window.location.href = response.page;
									}
						}
					});
			}

});

//update form validation
$('#updateForm').form({
		fields: {
				firstName    : {
					optional: true,
					rules: [
									{
										type  : 'empty',
										prompt: 'Please enter your first name'
									}
							]
				},
				lastName    : {
					optional: true,
					rules: [
									{
										type  : 'empty',
										prompt: 'Please enter your last name'
									}
							]
				},
				contactNum    : {
					optional: true,
					rules: [
									{
										type   : 'exactLength[11]',
										prompt : 'Contact number must be in 11-digit character'
									},
									{
										type   : 'number',
										prompt : 'Please enter a number',
									},
									{
										type   : 'empty',
										prompt : 'Please enter your contact number'
									}
							]
				},
				userPass    : {
					rules: [
									{
										type   : 'empty',
										prompt : 'Please enter your desired password'
									},
									{
										type   : 'minLength[6]',
										prompt : 'Password must be greater than five characters'
									}
							]
				},
				userpassConf : {
					rules: [
							   {
									type  : 'match[userPass]',
									prompt: 'The password do not match'
							   }
						   ]
				}
		},
		on : 'blur',
		inline : true
});

$(function(){

		//persistent field error
		$('#loginForm').find('input').on('change', function(){
			var input = $(this);
			if ($.trim(input.val()) === ''){
					input.next().html('<div class="ui corner label">' +
														'<i class="asterisk icon"></i>' +
														'</div>');
					}
	  });


		//update function
		function doUpdate(action, data = $('#updateForm').serialize()) {
			$.ajax({
					url			 : site_url('user/' + action),
					data     : data,
					type     : 'post',
					dataType : 'json',
					success: function(response){
							if (response.success === false) {
											if (response.errors){
													$.each(this, function(key, val){
															$('.ui.message.transition').addClass('negative').removeClass('hidden').find('h3').html(val);
													});
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
					doUpdate('doctorupdate', $(this).serialize());
				} else {
					var data = {
								userId       : id,
								userPass	  : password,
								userpassConf : passconf
							};
					doUpdate('userupdate', data );
				}
				sessionStorage.setItem('message', 'Successfully updated user. You may login now');

		});

		//dismissable message box
		$('.message .close').on('click', function() {
			$(this).closest('.message').transition('fade');
		});

		//Display alert message on successful update
		var successMsg = sessionStorage.getItem('message');
		if (successMsg) {
			$('.ui.message.transition').addClass('positive').removeClass('hidden').find('h3').html(successMsg);
		}

		//remove the message when page refreshes
		function removeMessage(){
				sessionStorage.removeItem('message');
		}
		window.onbeforeunload = removeMessage();
});
