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
		$id = $_SESSION["id"];
		$result = mysqli_query($conn, "SELECT * FROM users WHERE user_id = '$id' ");
		$row = mysqli_fetch_assoc($result);
	}else{
		header("Location: login.php");
		exit();
	}
	
	if(isset($_POST['submit'])){
		$gmail = $_POST['gmail'];
		$company_name = $_POST['company_name'];
		$message = $_POST['message'];
		$advertisement_package = $_POST['advertisement_package'];
		$image = $_FILES['image']['name'];
		$imagePath = 'uploads/img/' . basename($image);
		$user_id = $row['user_id'];
		move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
		
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

			
			$mail->setFrom($gmail, $company_name);		//sender
			$mail->addAddress('thisiscebuaknows@gmail.com', 'CebuaKnows');     //Add a recipient
			
			
		   /*  $mail->addAddress('ellen@example.com');               //Name is optional
			$mail->addReplyTo('info@example.com', 'Information');
			$mail->addCC('cc@example.com');
			$mail->addBCC('bcc@example.com'); */

			//Attachments
			/* $mail->addAttachment('/var/tmp/file.tar.gz');    */      //Add attachments
			$mail->addAttachment($imagePath, 'ad.jpg');    //Optional name

			//Content
			$mail->isHTML(true);                                  //Set email format to HTML
			$mail->Subject = 'Advertisement Application';
			$mail->Body    = $message . ' This is the Advertisement Package we choose: <b>' . $advertisement_package . '.</b> From: '.$gmail;
			$mail->AltBody = $message;

			
			
			//send the data into the database
			$stmt = $conn->prepare("INSERT INTO advertisement(company_name, advertisement_image, gmail_message, advertisement_package, user_id) values(?,?,?,?,?)");
			$stmt->bind_param('sssss', $company_name, $imagePath, $message, $advertisement_package, $user_id);
			$result = $stmt->execute();
			
			if($result){
				$mail->send();
				echo '<div class="alert alert-success" role="alert">Your advertisement application was successfully sent! please wait for cebuaKnows to respond to your email</div>';
				
			}
		} catch (Exception $e) {
			
			echo '<div class="alert alert-info" role="alert">Message could not be sent. Mailer Error: '.$mail->ErrorInfo.'</div>';
		}
	}
	
?>
	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width,initial-scale=1.0">
		<title>CebuaKnows</title>
		<!-- Online Bootstrap -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
		<!-- Font Awesome -->
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
		<!-- Google Fonts -->
		<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
		<!-- jQuery -->
		<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
		<!-- Styles -->
		<style>
		/* Illipsis */
		
		.truncate {
			display: -webkit-box;
			/* Enables flexbox behavior */
			-webkit-box-orient: vertical;
			/* Sets the box to be vertically oriented */
			-webkit-line-clamp: 2;
			/* Limits the text to 3 lines */
			overflow: hidden;
			/* Hides overflow content */
			text-overflow: ellipsis;
			/* Adds ellipsis (...) for overflowing text */
			max-width: 100%;
			/* Set the maximum width */
		}
		/* sidebar */
		
		::-webkit-scrollbar {
			width: 5px;
		}
		
		::-webkit-scrollbar-track {
			box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.1);
			border-radius: 10px;
		}
		
		::-webkit-scrollbar-thumb {
			background: rgba(69, 162, 158, 0.2);
			border-radius: 10px;
		}
		
		::-webkit-scrollbar-thumb:hover {
			background: rgba(69, 162, 158, 0.6);
			cursor: pointer;
		}
		
		.page .sidebar {
			position: fixed;
			left: -250px;
			/* Start hidden */
			width: 250px;
			height: 100vh;
			background: linear-gradient(35deg, #66fcf1, #45a29e);
			transition: left 0.3s ease;
			z-index: 1;
		}
		
		.page .content {
			margin-left: 250px;
			transition: all 0.3s ease;
		}
		
		.page .content .container {
			/* margin: 30px; */
			background: #fff;
			/* padding: 50px; */
			line-height: 28px;
		}
		
		body.active .page .sidebar {
			left: 0px;
		}
		
		body.active .page .content {
			margin-left: 0;
			width: 100%;
		}
		
		.sidebar-header {
			padding: 10px 25px 10px 15px;
		}
		
		.sidebar-logo-container {
			background-color: rgba(0, 0, 0, 0.2);
			border-radius: 8px;
			padding-left: 3px;
			display: flex;
		}
		
		.logo-container {
			max-width: 40px;
			background-color: rgba(255, 255, 255, 0.1);
			border-radius: 5px;
			margin: 8px;
			padding: 6px 8px;
		}
		
		.brand-name-container {
			margin: 10px 55px 0px 2px;
			padding: 0px;
		}
		
		.logo-sidebar {
			width: 100%;
			height: auto;
		}
		
		.brand-name {
			color: white;
			margin: 0px;
			line-height: 1.1rem;
			font-size: 16px;
			letter-spacing: 1px;
			font-family: 'Roboto', sans-serif;
		}
		
		.brand-subname {
			font-weight: 300;
			font-size: 14px;
		}
		
		.navigation-list {
			list-style-type: none;
			padding: 0px 18px;
			margin-top: 30px;
		}
		
		.navigation-list-item {
			padding: 12px 18px 12px 25px;
			margin: 0px 0px;
			border-radius: 8px;
		}
		
		.navigation-list-item:hover {
			background: rgba(0, 0, 0, 0.05);
			cursor: pointer;
		}
		
		.navigation-list-item.active {
			background: rgba(0, 0, 0, 0.1);
		}
		
		.navigation-link {
			color: rgba(31, 40, 51, 0.8);
			letter-spacing: 0.5px;
			font-weight: 400;
			text-decoration: none;
			font-size: 16px;
			font-family: 'Roboto', sans-serif;
		}
		
		.navigation-link i {
			font-size: 18px;
		}
		
		.navigation-list-item:hover .navigation-link {
			color: rgba(255, 255, 255, 0.7);
		}
		
		.navigation-list-item.active .navigation-link {
			color: rgba(255, 255, 255, 0.8);
			font-weight: 500;
		}
		
		.sidebarToggle {
			font-size: 16px;
			color: rgba(0, 0, 0, 0.8);
			z-index: 999;
			background-color: #e6e6e6;
			transition: all 0.3s ease;
			border-radius: 50px;
		}
		
		.sidebarToggle.active {
			/* margin-left: 10px; */
		}
		
		.sidebarToggle:hover {
			color: white;
		}
		/* navbar */
		
		.navbar {
			width: 100%;
			height: 10vh;
		}
		
		  /* Hide the image by default */
			.mobile-only {
				display: none;
			}

			/* Show the image only on screens smaller than 991px */
			@media (max-width: 991px) {
				.mobile-only {
					display: block;
				}
			}
			
		</style>
	</head>
	<body>
		<div class="page">
			<!-- Sidebar -->
			<div class="sidebar">
				<div class="sidebar-header">
					<div class="sidebar-logo-container">
						<div class="logo-container"> <img class="logo-sidebar" src="<?php echo $row['profile_picture']; ?>" alt="logo" /> </div>
						<div class="brand-name-container">
							<p class="brand-name">
								<?php echo $row['firstname']; ?>
									<br /> <span class="brand-subname"><?php echo $row['lastname']; ?></span> </p>
						</div>
					</div>
				</div>
				<hr>
				<div class="sidebar-body">
					<ul class="navigation-list">
						<li class="navigation-list-item active">
							<a class="navigation-link" href="dashboard-user.php"> <i class="fas fa-tachometer-alt"></i> Dashboard </a>
						</li>
						<li class="navigation-list-item">
							<a class="navigation-link" href="profile.php">
								<div class="row">
									<div class="col-2"> <i class="fas fa-users"></i> </div>
									<div class="col-9"> Profile </div>
								</div>
							</a>
						</li>
						<li class="navigation-list-item">
							<a class="navigation-link" href="uploadContent.php"> <i class="fas fa-solid fa-upload"></i> Upload Content </a>
						</li>
						<li class="navigation-list-item">
							<a class="navigation-link" href="myContents.php"> <i class="fas fa-solid fa-scroll"></i> My Contents </a>
						</li>
						<li class="navigation-list-item">
							<a class="navigation-link" href="addQuizzesPage.php"> <i class="fas fa-plus-circle"></i> Add Quizzes </a>
						</li>
						<li class="navigation-list-item">
							<a class="navigation-link" href="leaderDash.php"> <i class="fas fa-trophy"></i> Leaderboards </a>
						</li>
						<li class="navigation-list-item">
							<a class="navigation-link" href="myAds.php"> <i class="fas fa-ad"></i> My Advertisements </a>
						</li>
						<li class="navigation-list-item">
							<a class="navigation-link" href="analytics.php">
								<div class="row">
									<div class="col-2"> <i class="fas fa-chart-pie"></i> </div>
									<div class="col-9"> Analytics </div>
								</div>
							</a>
						</li>
						<li class="navigation-list-item">
							<a class="navigation-link" href="logout.php">
								<i class="fas fa-sign-out-alt"></i> Logout
							</a>
						</li>
						<!-- Add more links here -->
					</ul>
				</div>
			</div>
			<!-- Sidebar End -->
			<!-- Content -->
			<nav class="navbar navbar-expand-lg navbar-light bg-light">
				<div class="container">
					<button id="sidebarToggle" class="btn sidebarToggle"> <i class="fas fa-bars"></i> </button>
					<div style="display: flex; align-items: center;">
							<small class="mobile-only px-2"><?php echo $row['username'] ?> </small>
							<img src="<?php echo $row['profile_picture']; ?>" class="rounded-circle mobile-only" alt="Profile Picture" width="30" height="30">
						</div>
					<div class="collapse navbar-collapse" id="navbarNav">
						<a href="dashboard-user.php"><img src="img/land-img/logo.png" alt="Logo" width="100" height="100"></a>
						<ul class="navbar-nav me-auto">
							<li class="nav-item"><a class="nav-link" href="dashboard-user.php">Home</a></li>
							<li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
							<li class="nav-item"><a class="nav-link" href="news.php">News</a></li>
							<li class="nav-item"><a class="nav-link" href="contact.php">Contact Us</a></li>
						</ul>
						<ul class="navbar-nav ms-auto">
							<li class="nav-item"><p class="nav-link" style="margin:0;">Welcome, <?php echo $row["username"]; ?></p></li>
						</ul>
					</div>
				</div>
			</nav>
			<!-- Your content goes here -->
		</div>
		<br>
		<div class="p-3 mb-4 bg-light rounded-3">
			<div class="container-fluid py-5 text-center">
				<!-- Added text-center class here -->
				<h1 class="display-5 fw-bold"><i class="fas fa-ad"></i> Advertisement</h1>
				<p class="col-md-8 fs-4 mx-auto">
					<!-- Added mx-auto to center the text block -->Looking to showcase your brand or service? This is your opportunity! Apply to have your advertisement featured on our website and reach a wider audience. Simply fill out the form below to submit your application, and let’s help your business grow. </p>
			</div>
		</div>
		<div class="container mt-5">
			<form action="advertisement.php" method="post" enctype="multipart/form-data">
				<!-- Company Name -->
				<div class="mb-3">
					<label for="company_name" class="form-label">Company Name</label>
					<input type="text" class="form-control" name="company_name" placeholder="Enter company name" required> </div>
				<!-- Gmail -->
				<div class="mb-3">
					<label for="gmail" class="form-label">Gmail</label>
					<input type="email" class="form-control" name="gmail" placeholder="Enter company Gmail" required> </div>
				<!-- Message -->
				<div class="mb-3">
					<label for="message" class="form-label">Message</label>
					<textarea class="form-control" name="message" rows="4" placeholder="Enter your message" required></textarea>
				</div>
				<!-- File Input 1 -->
				<div class="mb-3">
					<label for="image" class="form-label">Upload Advertisement Image</label>
					<input class="form-control" type="file" name="image" required> </div>
				<!-- File Input 2 -->
				<!--<div class="mb-3">
				<label for="video" class="form-label">Upload Advertisement Video</label>
				<input class="form-control" type="file" id="video" name="video">
				</div>-->
				<input type="hidden" name="user_id" value="<?php echo $user_id?>">
				<!-- Option Selection -->
				<div class="mb-3">
					<label for="advertisement_package" class="form-label">Select an Advertisement Package</label>
					<select class="form-select" name="advertisement_package" required>
						<option value="" selected>Select an option</option>
						<option value="1">1 week</option>
						<option value="2">2 weeks</option>
						<option value="3">3 weeks</option>
						<option value="4">1 Day</option>
					</select>
				</div>
				<!-- Submit Button -->
				<button type="submit" class="btn btn-primary" name="submit">Submit</button>
			</form>
		</div>
		<br>
		<br>
		<br>
		<br>
		<!-- Footer -->
		<footer class="bg-dark text-white pt-5 pb-4">
			<div class="container text-center text-md-start">
				<div class="row text-center text-md-start">
					<!-- About Us -->
					<div class="col-md-3 col-lg-3 col-xl-3 mx-auto mb-4">
						<h5 class="text-uppercase fw-bold">About Us</h5>
						<p>We provide a user-friendly platform where users can explore various historical sites in Cebu City, complete with photos, descriptions, and historical background.</p>
					</div>
					<!-- Quick Links -->
					<div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
						<h5 class="text-uppercase fw-bold">Quick Links</h5>
						<ul class="list-unstyled">
							<li> <a href="dashboard-user.php" class="text-white ">Home</a> </li>
							<li> <a href="about.php" class="text-white ">About</a> </li>
							<li> <a href="news.php" class="text-white ">News</a> </li>
							<li> <a href="contact.php" class="text-white ">Contact</a> </li>
							<li> <a href="advertisement.php" class="text-white ">Add your Advertisement</a></li>
						</ul>
					</div>
					<!-- Contact Us -->
					<div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
						<h5 class="text-uppercase fw-bold">Contact Us</h5>
						<ul class="list-unstyled">
							<li>thisiscebuaknows@gmail.com</li>
							<li>+1 234 567 890</li>
							<li>Sanciangko St, Cebu City, 6000 Philippines.</li>
						</ul>
					</div>
					<!-- Social Media -->
					<div class="col-12 col-md-4 col-lg-3 mx-auto mb-4">
						<h5 class="text-uppercase fw-bold text-center text-md-start">Follow Us</h5>
						<div class="d-flex justify-content-center justify-content-md-start">
							<a href="#" class="text-white me-3"> 
								<i class="fab fa-facebook-f"></i> 
							</a>
							<a href="#" class="text-white me-3"> 
								<i class="fab fa-twitter"></i> 
							</a>
							<a href="#" class="text-white me-3"> 
								<i class="fab fa-instagram"></i> 
							</a>
							<a href="#" class="text-white"> 
								<i class="fab fa-linkedin-in"></i> 
							</a>
						</div>
					</div>
				</div>
			</div>
			<div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);"> © 2024 CebuaKnows. All rights reserved. </div>
		</footer>
		<!-- Bootstrap JS -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
		<!-- Script to toggle sidebar -->
		<script>
		document.addEventListener("DOMContentLoaded", function() {
			let sidebarToggle = document.querySelector(".sidebarToggle");
			let sidebar = document.querySelector(".sidebar");
			sidebarToggle.addEventListener("click", function() {
				document.body.classList.toggle("active");
				sidebarToggle.style.display = "none";
			});
			// Hide sidebar when clicking outside
			document.addEventListener("click", function(event) {
				if(!sidebar.contains(event.target) && !sidebarToggle.contains(event.target)) {
					document.body.classList.remove("active");
					sidebarToggle.style.display = "block";
				}
			});
		});
		</script>
	</body>
	</html>