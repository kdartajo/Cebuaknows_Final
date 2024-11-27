<?php
	include "connection.php";
	
	if(!empty($_SESSION["id"])){
		$id = $_SESSION["id"];
		$result = mysqli_query($conn, "SELECT * FROM users WHERE user_id = '$id' ");
		$row = mysqli_fetch_assoc($result);
		if($row['role'] != 'Historian'){
			exit('User cannot access this page');
		}
	}else{
		header("Location: login.php");
		exit();
	}
	
	
	if(isset($_POST['profile-edit'])){
		$id = $_SESSION["id"];
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$mobile = $_POST['mobile'];
		$address = $_POST['address'];
		$bio = $_POST['bio'];
		$username = $_POST['username'];
		
		$profile_picture = $_FILES['profile_picture'];
		$imagePath = 'img/'. basename($profile_picture['name']);
		
		if(move_uploaded_file($profile_picture['tmp_name'], $imagePath)){
			$stmt = $conn->prepare("UPDATE users SET firstname = ?, lastname = ?, mobile = ?, address = ?, bio = ?, profile_picture = ?, username = ? WHERE user_id = '$id'");
			$stmt->bind_param('sssssss', $firstname, $lastname, $mobile, $address, $bio, $imagePath, $username);
			$result = $stmt->execute();
			
			if($result){
				
				header("Location: profile-historian.php");
			}else{
				echo "failed";
			}
		
		}else{
			$stmt = $conn->prepare("UPDATE users SET firstname = ?, lastname = ?, mobile = ?, address = ?, bio = ?, username = ? WHERE user_id = '$id'");
			$stmt->bind_param('ssssss', $firstname, $lastname, $mobile, $address, $bio, $username);
			$result = $stmt->execute();
			
			if($result){
				
				header("Location: profile-historian.php");
			}else{
				echo "failed";
			}
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
		
        <!-- Bootstrap CSS -->
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
				left: -250px; /* Start hidden */
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
                margin: 10px 0px;
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
            .navbar{
                width:100%;
				height:10vh;;
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
						<div class="logo-container">
							<img class="logo-sidebar" src="<?php echo $row['profile_picture']; ?>" alt="logo"/>
						</div>
						<div class="brand-name-container">
							<p class="brand-name">
								<?php echo $row['firstname']; ?><br />
								<span class="brand-subname"><?php echo $row['lastname']; ?></span>
							</p>
						</div>
					</div>
				</div>
				<div class="sidebar-body">
					<ul class="navigation-list">
						<li class="navigation-list-item active">
							<a class="navigation-link" href="dashboard-historian.php">
								<i class="fas fa-tachometer-alt"></i> Dashboard
							</a>
						</li>
						<li class="navigation-list-item">
                            <a class="navigation-link" href="profile-historian.php">
                                <div class="row">
                                    <div class="col-2">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <div class="col-9">
                                        Profile
                                    </div>
                                </div>
                            </a>
                        </li>
						
						<li class="navigation-list-item">
							<a class="navigation-link" href="ContentList-historian.php">
								<i class="fas fa-solid fa-scroll"></i> Content Approval
							</a>
						</li>
                        <li class="navigation-list-item">
                            <a class="navigation-link" href="analytics-historian.php">
                                <div class="row">
                                    <div class="col-2">
                                        <i class="fas fa-chart-pie"></i>
                                    </div>
                                    <div class="col-9">
                                        Analytics
                                    </div>
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
						<button id="sidebarToggle" class="btn sidebarToggle">
							<i class="fas fa-bars"></i>
						</button>
						<div style="display: flex; align-items: center;">
							<small class="mobile-only px-2"><?php echo $row['username'] ?> </small>
							<img src="<?php echo $row['profile_picture']; ?>" class="rounded-circle mobile-only" alt="Profile Picture" width="30" height="30">
						</div>
						<div class="collapse navbar-collapse" id="navbarNav">
						
							<a href="dashboard-historian.php"><img src="img/land-img/logo.png" alt="Logo" width="100" height="100"></a>
					
							<ul class="navbar-nav me-auto">
								<li class="nav-item"><a class="nav-link" href="dashboard-historian.php">Home</a></li>
								<li class="nav-item"><a class="nav-link" href="about-historian.php">About</a></li>
								<li class="nav-item"><a class="nav-link" href="news-historian.php">News</a></li>
								<li class="nav-item"><a class="nav-link" href="contact-historian.php">Contact Us</a></li>
							</ul>
							<ul class="navbar-nav ms-auto">
								<li class="nav-item"><p class="nav-link" style="margin:0;">Welcome, <?php echo $row["username"]; ?></p></li>
								
							</ul>
						</div>
					</div>
				</nav>
				<!-- Your content goes here -->
				
			<section style="background-color: #eee;">
			
			  <div class="container y-5">
				<h1>Edit Profile</h1>
				<div class="row">
				  <div class="col-lg-4">
					<div class="card mb-4">
					  <div class="card-body text-center">
						<img src="<?php echo $row['profile_picture']; ?>" alt="avatar"
						  class="rounded-circle img-fluid" style="width: 150px;">
						<h5 class="my-3"><?php echo $row['username'] ?></h5>
						<!--<p class="text-muted mb-1">Full Stack Developer</p>-->
						<p class="text-muted mb-4"><?php echo $row['address'] ?></p>
						<div class="d-flex justify-content-center mb-2">
						  <button  type="button" class="btn btn-primary" disabled><i class="fas fa-edit"></i></button>
						  
						</div>
					  </div>
					</div>
					
				  </div>
				  <div class="col-lg-8">
					<div class="card mb-4">
					<form action="profile-edit-historian.php" method="post" enctype="multipart/form-data">
					  <div class="card-body">
					    <div class="row">
						  <div class="col-sm-3">
							<p class="mb-0">Profile Picture</p>
						  </div>
						  <div class="col-sm-9">
							<input type="file" class="form-control" name="profile_picture" aria-label="Default" aria-describedby="inputGroup-sizing-default" value="<?php echo $row['profile_picture'] ?>">
						  </div>
						</div>
						<hr>
						<div class="row">
						  <div class="col-sm-3">
							<p class="mb-0">First Name</p>
						  </div>
						  <div class="col-sm-9">
							<input type="text" class="form-control" name="firstname" aria-label="Default" aria-describedby="inputGroup-sizing-default" value="<?php echo $row['firstname'] ?>" required>
						  </div>
						</div>
						<hr>
						<div class="row">
						  <div class="col-sm-3">
							<p class="mb-0">Last Name</p>
						  </div>
						  <div class="col-sm-9">
							<input type="text" class="form-control" name="lastname" aria-label="Default" aria-describedby="inputGroup-sizing-default" value="<?php echo $row['lastname'] ?>" required>
						  </div>
						</div>
						<hr>
						<div class="row">
						  <div class="col-sm-3">
							<p class="mb-0">Username</p>
						  </div>
						  <div class="col-sm-9">
							<input type="text" class="form-control" name="username" aria-label="Default" aria-describedby="inputGroup-sizing-default" value="<?php echo $row['username'] ?>" required>
						  </div>
						</div>
						<hr>
						<div class="row">
						  <div class="col-sm-3">
							<p class="mb-0">Email</p>
						  </div>
						  <div class="col-sm-9">
							<p class="text-muted mb-0"><?php echo $row['email'] ?></p>
						  </div>
						</div>
						<hr>
						<div class="row">
						  <div class="col-sm-3">
							<p class="mb-0">Mobile</p>
						  </div>
						  <div class="col-sm-9">
							<input type="text" class="form-control" name="mobile" aria-label="Default" aria-describedby="inputGroup-sizing-default" value="<?php echo $row['mobile'] ?>" required>
						  </div>
						</div>
						<hr>
						<div class="row">
						  <div class="col-sm-3">
							<p class="mb-0">Address</p>
						  </div>
						  <div class="col-sm-9">
							<input type="text" class="form-control" name="address" aria-label="Default" aria-describedby="inputGroup-sizing-default" value="<?php echo $row['address'] ?>" required>
						  </div>
						</div>
						<hr>
						<div class="row">
						  <div class="col-sm-3">
							<p class="mb-0">Role</p>
						  </div>
						  <div class="col-sm-9">
							<p class="text-muted mb-0"><?php echo $row['role'] ?></p>
						  </div>
						</div>
						<hr>
						<div class="row">
						  <div class="col-sm-3">
							<p class="mb-0">Bio</p>
						  </div>
						  <div class="col-sm-9">
							<textarea class="form-control" name="bio" id="exampleFormControlTextarea1" rows="3"><?php echo $row['bio'] ?></textarea>
						  </div>
						</div>
						<hr>
						
						<button class="btn btn-success" name="profile-edit">Edit Profile</button>
						<a class="btn btn-primary" href="profile-historian.php">Cancel</a>
					  </div>
					  </form>
					</div>
				  </div>
				</div>
			  </div>
			  
			</section>
				
			
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
							<li> <a href="dashboard-historian.php" class="text-white ">Home</a> </li>
							<li> <a href="about-historian.php" class="text-white ">About</a> </li>
							<li> <a href="news-historian.php" class="text-white ">News</a> </li>
							<li> <a href="contact-historian.php" class="text-white ">Contact</a> </li>
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
				if (!sidebar.contains(event.target) && !sidebarToggle.contains(event.target)) {
					document.body.classList.remove("active");
					sidebarToggle.style.display = "block";
				}
			});
		});
		</script>
    </body>
</html>