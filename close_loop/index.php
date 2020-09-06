<?php

 

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Closeloop technologies Assignment </title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.min.js"></script>

	<style>
		.help-block {
			color: red !important;
		}
		.error {
			color: red !important;
		}
	</style>

</head>

<body>

	<nav class="navbar navbar-inverse">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
			<div class="collapse navbar-collapse" id="myNavbar">
				<ul class="nav navbar-nav">
					<li class="active"><a href="#">Home</a></li>
				</ul>

			</div>
		</div>
	</nav>


	<div class="container text-left">
		<h3>Student Form</h3><br>

		<div class="row text">

			<form id="student_form" method="POST">
				<table style="padding: 5px; width: 30%;">

					<tbody id="tableBody">
						<tr>
							<td>

							
							<div id="formDiv">
								<h3>Form 1</h3>
								<hr>
								<div class="form-group">
									<label for="subject">Subject </label>
									<select class="form-control student_subject" id="subject" name="subject">
										<option value="">--Subject--</option>
										<option value="Math">Math</option>
										<option value="Science">Science</option>
										<option value="English">English</option>
										<option value="Hindi">Hindi</option>
									</select>
								</div>
								<div class="form-group">
									<label for="name">Name: </label>
									<input type="text" class="form-control name" name="name" id="name" placeholder="Name">
								</div>
								<div class="form-group">
									<label for="gender">Gender: </label>
									<div>
										<input class="gender" type="radio" name="gender" id="male"> Male
										<input class="gender" type="radio" name="gender" id="female"> Female
									</div>
								</div>
								<hr style="border:1px solid blue;">
							</div>




							</td>

						</tr>

						<tr>
							<td>

								<div style="float: left; width:40%;">
									<input type="submit" id="submit_btn" class="btn btn-success btn-sm" value=" Submit ">
								</div>

								<div style="float: left; width:60%; text-align:right;">
									<input type="button" class="btn btn-primary btn-xs add-student" value="Add more student">
								</div>

							</td>
						</tr>
					</tbody>
				</table>

			</form>

		</div>

	</div>
	<br>

	<footer class="container-fluid text-center">&nbsp;</footer>



	<script>
		$(document).ready(function() {

			//$("#submit_btn").trigger('click');
			var numRow = 1;
			$(".add-student").click(function() {
				numRow++;
				var markup = '<h3>Form ' + numRow + '</h3><hr>' +
					'<div class="form-group"><label for="subject">Subject </label>' +
					'<select class="form-control student_subject" id="subject' + numRow + '" name="subject' + numRow + '"><option value="">--Subject--</option>' +
					'<option value="Math">Math</option>' +
					'<option value="Science">Science</option>' +
					'<option value="English">English</option>' +
					'<option value="Hindi">Hindi</option>' +
					'</select>' +
					'</div>' +
					'<div class="form-group"><label for="name">Name: </label>' +
					'<input type="text" class="form-control name" name="name' + numRow + '" id="name' + numRow + '" placeholder="Name">' +
					'</div>' +
					'<div class="form-group"><label for="gender">Gender: </label>' +
					'<input class="gender" type="radio" name="gender' + numRow + '" id="male' + numRow + '"> Male' +
					'<input class="gender" type="radio" name="gender' + numRow + '" id="female' + numRow + '"> Female' +
					'</div><hr style="border:1px solid blue;">';

				$("#formDiv").append(markup);
				initValidator();

				if (numRow >=5) {
					$(".add-student").hide();
				}
			});

			initValidator();

			
			function initValidator(){
				$('form#student_form').validate({
						errorElement: "em",
						errorPlacement: function(error, element) {
							error.addClass("help-block");
							if (element.prop("type") === "radio") {
								error.insertAfter(element.parent("div"));
							} else {
								error.insertAfter(element);
							}
						},
						highlight: function(element, errorClass, validClass) {
							$(element).parents(".form-group").addClass("has-error").removeClass("has-success");
						},
						unhighlight: function(element, errorClass, validClass) {
							$(element).parents(".form-group").addClass("has-success").removeClass("has-error");
						},

						submitHandler: function() {
							alert("Success");
						}
				});

				$('.student_subject').each(function() {
					$(this).rules("add", 
						{
							required: true,
							messages: {
								required: "Subject is required",
							}
						});
				});
				$('.name').each(function() {
					$(this).rules("add", 
						{
							required: true,
							messages: {
								required: "Name is required",
							}
						});
				});

				$('.gender').each(function() {
					$(this).rules("add", 
						{
							required: true,
							messages: {
								required: "Gender is required",
							},
							
						},
					);
				});
			}

			$("body").on("submit", "#student_form", function(e) {

				initValidator();
				
				return false;
			});

			


		});
	</script>

</body>

</html>