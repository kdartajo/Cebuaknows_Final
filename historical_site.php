<?php
	include "connection.php";
	
	if(!empty($_SESSION["id"])){
		$id = $_SESSION["id"];
		$result = mysqli_query($conn, "SELECT * FROM users WHERE user_id = '$id' ");
		$row = mysqli_fetch_assoc($result);
	}else{
		header("Location: login.php");
		exit();
	}
	
	if(isset($_POST['takequiz'])){
		$disabled = "disable";
			$check_stmt = $conn->prepare("select * from quiz_leaderboard where user_id = ?");
			$check_stmt->bind_param('s', $row['user_id']);
			$check_stmt->execute();
			$check_result = $check_stmt->get_result();
			
			if($check_result->num_rows > 0){
				
			}
			
	}
	
	
	if(isset($_GET['contentId'])){
		$content_id = $_GET['contentId'];
		
		$stmt = $conn->prepare("Select * from location 
								INNER JOIN content ON content.location_id = location.location_id 
								INNER JOIN media ON content.media_id = media.media_id 
								INNER JOIN users ON content.user_id = users.user_id 
								where content.content_id = ?");
		$stmt->bind_param('s', $content_id);
		$stmt->execute();
		$result = $stmt->get_result();
		
		if($result){
			$content_row = mysqli_fetch_assoc($result);
			$content_id = $content_row['content_id'];
			$content_title = $content_row['content_title'];
			$content_description = $content_row['description'];
			$content_location = $content_row['location'];
			$content_image = $content_row['image'];
			$content_video = $content_row['video'];
			$content_created_at = $content_row['created_at'];
			$username = $content_row['username'];
			$email = $content_row['email'];
			$user_picture = $content_row['profile_picture'];
			$user_role = $content_row['role'];
			$quiz_id = $content_row['quiz_id'];
		
			
			
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
					    display: -webkit-box;        /* Enables flexbox behavior */
    -webkit-box-orient: vertical; /* Sets the box to be vertically oriented */
    -webkit-line-clamp: 2;       /* Limits the text to 3 lines */
    overflow: hidden;            /* Hides overflow content */
    text-overflow: ellipsis;     /* Adds ellipsis (...) for overflowing text */
    max-width: 100%;             /* Set the maximum width */
				  }
			
			
			/* sidebar */
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
				height: 100%;
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
			.active>.page-link, .page-link.active {
				z-index: 0;
				
			}

            /* navbar */
            .navbar{
                width:100%;
				height:10vh;
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
				
				.video_size{
					width:auto;
					height:300;
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
						<li class="navigation-list-item">
							<a class="navigation-link" href="dashboard-user.php">
								<i class="fas fa-tachometer-alt"></i> Dashboard
							</a>
						</li>
						<li class="navigation-list-item">
                            <a class="navigation-link" href="profile.php">
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
						<li class="navigation-list-item active">
							<a class="navigation-link" href="uploadContent.php">
								<i class="fas fa-solid fa-upload"></i> Upload Content
							</a>
						</li>
						<li class="navigation-list-item">
							<a class="navigation-link" href="myContents.php">
								<i class="fas fa-solid fa-scroll"></i> My Contents
							</a>
						</li>
						<li class="navigation-list-item">
							<a class="navigation-link" href="addQuizzesPage.php">
								<i class="fas fa-plus-circle"></i> Add Quizzes
							</a>
						</li>
						<li class="navigation-list-item">
							<a class="navigation-link" href="leaderDash.php">
								<i class="fas fa-trophy"></i> Leaderboards
							</a>
						</li>
						<li class="navigation-list-item">
							<a class="navigation-link" href="myAds.php">
								<i class="fas fa-ad"></i> My Advertisements
							</a>
						</li>
                        <li class="navigation-list-item">
                            <a class="navigation-link" href="analytics.php">
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
		<?php
			
			
			//this algorithm loops through different random numbers from ALL advertisement_ids until it gets the advertisement id that has a mode of active using rand() function
			/* $retryCount = 0;
			$maxRetries = 10; // Set a reasonable limit for retries

			do {
				$randomNumber = rand(1, $numAd);

				$stmt = $conn->prepare("SELECT * FROM advertisement WHERE advertisement_id = ? AND mode = 'activate'");
				$stmt->bind_param('s', $randomNumber);
				$stmt->execute();
				$result = $stmt->get_result();

				$retryCount++;
				//echo $randomNumber . ',';
			} while ($result->num_rows == 0 && $retryCount < $maxRetries);

			if ($result->num_rows > 0) {
				$ad_row = $result->fetch_assoc();
				$ad_image = $ad_row['advertisement_image'];
				$ad_name = $ad_row['company_name'];
				//echo $ad_image;
			} else {
				// Handle case where no valid advertisement was found after retries
				$ad_image = 'uploads/img/logo.png'; // Or provide a default fallback
				$ad_name = "Advertisement";
			}
			 */
			
			//this algorithm loops through advertisement ids that has a active mode using array and rand() function
			$ad_stmt = $conn->prepare("SELECT advertisement_id FROM advertisement where mode = 'activate'");
			$ad_stmt->execute();
			$ad_result = $ad_stmt->get_result();
			$ad_image = 'uploads/img/logo.png'; // Or provide a default fallback
			$ad_name = "Advertisement";
			
			if($ad_result->num_rows > 0){
				$ad_ids = [];
				while($row_ad = mysqli_fetch_assoc($ad_result)){
					$ad_ids[] = $row_ad['advertisement_id'];  
					//echo $ad_ids;
				}
				
				$randomIndex = array_rand($ad_ids);
				$randonNumber = $ad_ids[$randomIndex];
				
				$stmt = $conn->prepare("SELECT * FROM advertisement WHERE advertisement_id = ?");
				$stmt->bind_param('s', $randonNumber);
				$stmt->execute();
				$adResult = $stmt->get_result();
				
				if($adResult->num_rows > 0){
					$row = mysqli_fetch_assoc($adResult);
					$ad_image = $row['advertisement_image'];
					$ad_name = $row['company_name'];
				}else{
					$ad_image = 'uploads/img/logo.png'; // Or provide a default fallback
					$ad_name = "Advertisement";
				}
				
			}
			
			
			
		?>
		<!-- Modal -->
		<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<h1 class="modal-title fs-5" id="exampleModalLabel"><?php echo $ad_name ?></h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			  </div>
			  <div class="modal-body">
				<img src="<?php echo $ad_image ?>" style="width:100%;height:auto;max-width:auto;max-height:300px;border:solid black 1px;"/>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
			  </div>
			</div>
		  </div>
		</div>
        <section class="banner" style="position:relative;  width: 100%;">
            <img src="<?php echo isset($content_image) ? $content_image : ''; ?>" class="img-fluid" alt="Banner" style="width:100%;height:60vh; object-fit:cover;">
			
			<button style="position: absolute; bottom:0; right:0; margin: 10px" class="btn btn-primary" onclick="takequiz()">Take Quiz</button>
			
			<button style="position: absolute; bottom: 0; right: 100px; margin: 10px;" class="btn btn-success">
				<a href='forum.php?get_content_id=<?php echo $content_id;?>' style="color: white; text-decoration: none;">Forum</a>
			</button>
		</section>
        <br>
        <br>
        <br>
		<div class="container my-5">
			<div class="row justify-content-center">
				<!-- Content Section -->
				<div class="col-lg-8 col-md-10 col-sm-12">
					<!-- Title and Location -->
					<h1 class="text-center text-primary mb-3"><?php echo $content_title ?></h1>
					<p class="text-center text-muted"><?php echo $content_location ?>, Philippines</p>

					<!-- Description Section -->
					<hr class="my-4">
					<figure>
						<blockquote class="blockquote text-center">
							<p class="lead"><?php echo $content_description; ?></p>
							<footer class="blockquote-footer"><?php echo $username; ?> <cite title="Source Title">Author</cite></footer>
							<p class="text-muted">Email: <?php echo $email; ?></p>
						</blockquote>
					</figure>

					<!-- Video Section -->
					<div class="text-center mb-4">
						<video class="img-fluid rounded shadow" controls>
							<source src="<?php echo $content_video ?>" type="video/mp4">
							Your browser does not support the video tag.
						</video>
					</div>
				</div>
			</div>
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
		// Ensure the page is fully loaded before triggering the modal
		  document.addEventListener('DOMContentLoaded', function () {
			var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
			myModal.show(); // Automatically show the modal
		  });
		
		
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
		
		
		function takequiz(){
			let text = "Are you sure you want to take the quiz now?";
			if(confirm(text) == true){
				window.location.href = "test.php?quiz_id=<?php echo $quiz_id?>";
			}else{
				window.location.href = "historical_site.php?contentId=<?php echo $content_id?>";
			}
		}
		
		</script>
    </body>
</html>