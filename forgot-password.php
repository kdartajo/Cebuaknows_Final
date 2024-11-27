<?php
	include "connection.php";
	
	if(!empty($_SESSION["id"])){
		header("Location: index.php");
	}
	
	//Import PHPMailer classes into the global namespace
	//These must be at the top of your script, not inside a function
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;
	//Load Composer's autoloader
	require 'vendor/autoload.php';
	
	
	
	
	if(isset($_POST['submit'])){
		$email = $_POST['email'];
		
		$stmt = $conn->prepare("Select email, username from users where email = ?");
		$stmt->bind_param('s', $email);
		$stmt->execute();
		$result = $stmt->get_result();
		
		if($result->num_rows > 0){
			$row = mysqli_fetch_assoc($result);
			$searchEmail = $row['email'];
			$username = $row['username'];
			$randomNumber = rand(100000, 999999);
			$_SESSION['randomNumber'] = $randomNumber;
			$_SESSION['username'] = $username;
			$_SESSION['email'] = $searchEmail;
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
				$mail->addAddress($searchEmail, $username);     //Add a recipient
								
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
								
				header("Location: forget-password-verify.php");
								
			} catch (Exception $e){
				echo '<div class="alert alert-danger" role="alert">Message could not be sent. Mailer Error: '.$mail->ErrorInfo.'</div>';
			}
			
			
		}else{
			echo '<div class="alert alert-danger" role="alert">'.$email.' is not Registered</div>';
		}
	}
	
?>


<!DOCTYPE html>
<html>
<head>
    <title>User Login | WIP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style/style3.css">
    <link rel="stylesheet" type="text/css" href="css/style/style4.css">
</head>
<body class="bg-light" style="font-family: sans-serif; font-size: 18px;">
    <div class="container mt-5">
        <div class="row justify-content-center align-items-center h-100">
            <!-- Circular logo container on the left side -->
            <div class="col-lg-6 d-flex flex-column align-items-center text-center mb-4 mb-md-0">
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
            <!-- Login card on the right side -->
            <div class="col-lg-6 col-md-8 col-sm-10 col-12 mx-auto">
				<div class="forgot_card text-dark p-4 shadow">
					<form action="forgot-password.php" method="POST">
						<img src="img/assets/lockForogt.png" alt="lockpad" class="img-fluid d-block mx-auto mb-3" style="max-width: 150px;">
						<h1 class="text-center">Forgot Password</h1>
						<p class="text-center">
							It seems you forgot your password. Enter the email associated with your account.
						</p>
						<div class="form-group mb-3">
							<label for="email"></label>
							<input class="form-control" type="email" name="email" placeholder="Enter email" required>
						</div>
						<div class="d-flex justify-content-center mb-2">
							<button class="btn btn-success" type="submit" name="submit">Send</button>
						</div>
					</form>
				</div>
            </div>
        </div>
    </div>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
