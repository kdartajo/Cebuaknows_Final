<!DOCTYPE html>
    <html>
        <head>
            <title>CebuaKnows | Email Verification</title>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta charset="UTF-8">
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
				include "connection.php";
				//Import PHPMailer classes into the global namespace
				//These must be at the top of your script, not inside a function
				use PHPMailer\PHPMailer\PHPMailer;
				use PHPMailer\PHPMailer\SMTP;
				use PHPMailer\PHPMailer\Exception;
				//Load Composer's autoloader
				require 'vendor/autoload.php';
				
				if(!empty($_SESSION["id"])){
					header("Location: index.php");
				}
				
				if(isset($_POST['verify'])){
					if(!isset($_SESSION['username']) || !isset($_SESSION['email']) || !isset($_SESSION['password']) || !isset($_SESSION['confirm_password']) || !isset($_SESSION['randomNumber'])){
						echo '<div class="alert alert-info" role="alert">Invalid Details</div>';
					}else{
						$username = $_SESSION['username'] ;
					$email = $_SESSION['email'];
					$password = $_SESSION['password'];
					$confirm_password = $_SESSION['confirm_password'];
					$randomNumber = $_SESSION['randomNumber'];
					$otp = $_POST['otp'];
					
					if($randomNumber == $otp){
						$hashed_password = password_hash($password, PASSWORD_DEFAULT);
							$stmt = $conn->prepare("insert into users(username,email,password,confirm_password) values(?,?,?,?)");
							$stmt->bind_param("ssss",$username,$email,$hashed_password,$confirm_password);
							$result = $stmt->execute();
							
							if($result){
								echo '<script>
										Swal.fire({
                                            "title": "Successfully Registered",
                                            "text": "Login now!",
                                            "icon": "success"
										});
									</script>	';
								unset($username);
								unset($email);
								unset($password);
								unset($password);
								unset($confirm_password);
								unset($randomNumber);
								header("location: login.php");
							}else{
								die(mysqli_error($conn));
							}
					}else{
						echo '<div class="alert alert-danger" role="alert">Incorrect Verification Number</div>';
					}
					}
					
					
					
					
				}
				
				
				if(isset($_POST['resendOTP'])){
					$username = $_SESSION['username'] ;
					$email = $_SESSION['email'];
					
					$randomNumber = rand(100000, 999999);
					$_SESSION['randomNumber'] = $randomNumber;
					
					if(!isset($_SESSION['username']) || !isset($_SESSION['email']) || !isset($_SESSION['password']) || !isset($_SESSION['confirm_password']) || !isset($_SESSION['randomNumber'])){
						echo '<div class="alert alert-info" role="alert">Invalid Details</div>';
					}else{
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
						$mail->Body    = 'Verify your email with this number <b>'.$_SESSION['randomNumber'].'</b>';
						$mail->AltBody = 'Email Verification';

						$mail->send();
						echo '<div class="alert alert-info" role="alert">One Time Password sent</div>';
									
						
									
						} catch (Exception $e){
							echo '<div class="alert alert-danger" role="alert">Message could not be sent. Mailer Error: '.$mail->ErrorInfo.'</div>';
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
                    <div class="col-lg-6 col-md-8 col-sm-10 col-12 mx-auto"> 
						<div class="register_card text-dark p-4 shadow">
							<form action="verify.php" method="POST">
								
									<!-- Responsive and Centered Image -->
									<img src="img/assets/otp.png" alt="otp" class="img-fluid d-block mx-auto mb-3" style="max-width: 150px;">
									
									<h1 class="text-center">OTP Verification</h1>
									<p class="text-center">Thank you for registering with us. Please type the OTP as shared on your email.</p>
									
									<div class="form-group mb-3">
										<label for="otp"></label>
										<input class="form-control" type="number" name="otp" placeholder="Enter OTP" required>
									</div>
									
									<div class="d-flex justify-content-center mb-2">
										<input class="btn btn-primary" type="submit" name="verify" value="Verify">
									</div>
									
									
								
							</form>
						</div>
                    </div>
                </div>
            </div>	
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    </body>
</html>