<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width,initial-scale=1.0">
        <title>User Registration | WIP</title>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/style/style2.css">
        <link rel="stylesheet" type="text/css" href="css/style/style4.css">
		<script src="js/custom/sweetalert2.js"></script>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
		<!--<script src="js/custom/script.js" defer></script>-->
    </head>
    <body class="bg-light" style="font-family: sans-serif, sans-serif; font-size: 18px;">
        <div>
            <?php
				//Import PHPMailer classes into the global namespace
				//These must be at the top of your script, not inside a function
				use PHPMailer\PHPMailer\PHPMailer;
				use PHPMailer\PHPMailer\SMTP;
				use PHPMailer\PHPMailer\Exception;
				//Load Composer's autoloader
				require 'vendor/autoload.php';
				
				include "connection.php";
				
				if(!empty($_SESSION["id"])){
					header("Location: index.php");
				}
				
                if (isset($_POST['create'])) {
                    $username = $_POST['username'];
                    $email = $_POST['email'];
                    $password = $_POST['password'];
					$confirm_password = $_POST['confirm_password'];
					$_SESSION['username'] = $username;
					$_SESSION['email'] = $email;
					$_SESSION['password'] = $password;
					$_SESSION['confirm_password'] = $confirm_password;
					
					$check_stmt = $conn->prepare("select * from users where username = ?");
					$check_stmt->bind_param('s',$username);
					$check_stmt->execute();
					$check_result = $check_stmt->get_result();
					
					if($check_result->num_rows > 0){
						echo '
							<script>
								Swal.fire({
									"title": "Username Already Exist",
									"text": "Please pick another username",
									"icon": "warning"
								});	
							</script>
						';			
					}else{
						if($password == $confirm_password){
							$randomNumber = rand(100000, 999999);
							$_SESSION['randomNumber'] = $randomNumber;
							//Create an instance; passing `true` enables exceptions
							$mail = new PHPMailer(true);

							try {
								//Server settings
								//$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
								$mail->isSMTP();                                            //Send using SMTP
								$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
								
								$mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
								$mail->Username   = 'thisiscebuaknows@gmail.com';                     //SMTP username
								$mail->Password   = 'tlhhukzqeebacuyg';                               //SMTP password
								$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //ENCRYPTION_SMTPS - Enable implicit TLS encryption
								$mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

								//Recipients
								$mail->setFrom('thisiscebuaknows@gmail.com', 'CebuaKnows');		//sender
								$mail->addAddress($email, $username);     //Add a recipient
								
							   /*  $mail->addAddress('ellen@example.com');               //Name is optional
								$mail->addReplyTo('info@example.com', 'Information');
								$mail->addCC('cc@example.com');
								$mail->addBCC('bcc@example.com'); */

								//Attachments
								/* $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
								$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name */

								//Content
								$mail->isHTML(true);                                  //Set email format to HTML
								$mail->Subject = 'Verification Number';
								$mail->Body    = 'Verify your email with this number <b>'.$randomNumber.'</b>';
								$mail->AltBody = 'Email Verification';

								$mail->send();
								
								header("Location: verify.php");
								
							} catch (Exception $e){
								echo '<div class="alert alert-danger" role="alert">Message could not be sent. Mailer Error: '.$mail->ErrorInfo.'</div>';
							}
						}else{
							echo "Password does not match";
						}
					}
				}
			?>
		</div>
        <div class="container mt-5">
            <div class="row justify-content-center align-items-center h-100">
                <!-- Circular logo container on the left side -->
				<div class="col-lg-6 col-md-6 d-flex flex-column align-items-center text-center mb-4 mb-md-0">
                    <div class="logo-container">
                        <img src="img/loginp.jpg" alt="Logo" class="img-fluid">
                    </div>
                    <div class="logo-text mt-3">
                        <img src="img/cebu_b.png" alt="Logo" class="img-fluid">
                    </div>
                    <div class="logo-text mt-3">
                        Educational platform for Cebu’s Historical Places.
                    </div>
                </div>
                <!-- Registration card on the right side -->
				<div class="col-lg-6 col-md-6">
					<form action="Registration.php" method="POST">
						<div class="card p-4 shadow tile-card text-dark">
							<h1 class="text-center">SIGN UP</h1>
							<p class="text-center mt-3">Fill up this form with correct credentials being asked.</p>
							<div class="form-group mb-3">
								<label for="username">User Name <span class="text-danger">*</span></label>
								<input class="form-control" type="text" name="username" placeholder="Enter your username" required>
							</div>
							<div class="form-group mb-3">
								<label for="email">Email Address <span class="text-danger">*</span></label>
								<input class="form-control" type="email" name="email" placeholder="Enter your email address" required>
							</div>
							<div class="form-group mb-3">
								<label for="password">Password <span class="text-danger">*</span></label>
								<div class="password-container">
									<input class="form-control" type="password" name="password" id="password" onkeyup="check();" placeholder="Create your password" required>
									<span id="toggle-password" class="position-absolute" style="right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;">
										<i class="fas fa-eye" id="toggleIconPassword"></i>
									</span>
								</div>
							</div>
							<div class="form-group mb-3">
								<label for="confirm_password">Confirm Password <span class="text-danger">*</span></label>
								<div class="password-container">
									<input class="form-control" type="password" name="confirm_password" id="confirm_password" onkeyup="check();" placeholder="Re-type your password" required>
									<span id="toggle-confirm-password" class="position-absolute" style="right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;">
										<i class="fas fa-eye" id="toggleIconConfirm"></i>
									</span>
								</div>
							</div>
							<div class="d-flex justify-content-center">
								<input class="btn btn-custom" type="submit" name="create" value="Sign Up">
							</div>
							<p class="text-center mt-3">
								Already have an account? <a href="login.php" class="login-link">Login</a>
							</p>
						</div>
					</form>
				</div>
            </div>
        </div>
		<script>
            // Toggle password visibility for the password field
			const togglePassword = document.querySelector('#toggle-password');
			const passwordInput = document.querySelector('#password');
			const toggleIconPassword = document.querySelector('#toggleIconPassword');

			togglePassword.addEventListener('click', function () {
				// Toggle the type attribute
				const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
				passwordInput.setAttribute('type', type);
				
				// Toggle the icon
				toggleIconPassword.classList.toggle('fa-eye');
				toggleIconPassword.classList.toggle('fa-eye-slash');
			});

			// Toggle password visibility for the confirm password field
			const toggleConfirmPassword = document.querySelector('#toggle-confirm-password');
			const confirmPasswordInput = document.querySelector('#confirm_password');
			const toggleIconConfirm = document.querySelector('#toggleIconConfirm');

			toggleConfirmPassword.addEventListener('click', function () {
				// Toggle the type attribute
				const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
				confirmPasswordInput.setAttribute('type', type);
				
				// Toggle the icon
				toggleIconConfirm.classList.toggle('fa-eye');
				toggleIconConfirm.classList.toggle('fa-eye-slash');
			});
        </script>
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    </body>
</html>