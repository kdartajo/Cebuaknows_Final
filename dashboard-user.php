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
	
	if (isset($_SESSION['success_message'])) {
		echo '<div class="alert alert-success" role="alert">' . $_SESSION['success_message'] . '</div>';
		// Unset the session variable after displaying the message
		unset($_SESSION['success_message']);
	}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
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
			
			
			/*card_size*/
			.card-img-top {
    			width: 100%; /* Makes the image take up the full width of the card */
    			height: 200px; /* Set a fixed height for all images */
    			object-fit: cover; /* Ensures the image covers the area while maintaining aspect ratio */
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
            .navbar{
                width:100%;
				height:10vh;
            }

			.image-container {
				position: relative;
				width: 100%;
				overflow: hidden; /* Prevents any part of the image from overflowing the container */
			}

			.image-container img {
				width: 100%;
				height: auto;
				object-fit: cover; /* Ensures the image covers the container while maintaining aspect ratio */
				object-position: center; /* Centers the image in the container */
			}
			
			
			/* Basic styling for the banner */
			/*.banner {
			  position: relative;
			  overflow: hidden;
			}*/

			/* Make the banner image take full width and adjust its height */
			/*.banner img {
			  width: 100%;
			  height: auto; /* Keeps the aspect ratio */
			/*}*/

			/* Optional: If you want a minimum height for larger screens */
			/*@media (min-width: 768px) {
			  .banner img {
				height: auto; /* Adjust height for larger screens */
				/*object-fit: cover; /* Ensures the image covers the area without distortion */
				/*object-position: top;
			  }
			}*/

			/* Optional: For smaller screens, you might want a smaller height */
			/*@media (max-width: 767px) {
			  .banner img {
				height: 250px; /* Adjust height for mobile screens */
				/*object-fit: cover;
			  }
			}*/
			
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
			.active>.page-link, .page-link.active{
				z-index:0;
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
						<li class="navigation-list-item">
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
						
							<img src="img/land-img/logo.png" alt="Logo" width="100" height="100">
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
        <!-- Banner Image -->
        <section class="banner" id="home">
			<div class="image-container">
				<img src="img/assets/banner.png" class="img-fluid w-100" alt="Banner">
			</div> 
		</section>
        <br>
		<div class="row justify-content-center align-items-center p-2">
			<div class="col-md-6 mx-auto ">
				<form action="dashboard-user.php" method="post" class="input-group">
					<input type="text" class="form-control" placeholder="Search Content" aria-label="Search" name="searchContent">
					<button style="z-index:0;" class="btn btn-primary" type="submit" name="submit"><i class="fas fa-search"></i> Search</button>
				</form>
			</div>
		</div>
		<br>
		
		<div class="container ">
				<div class="row justify-content-center align-items-center">
				<?php
					if(isset($_POST['submit'])){
						$searchContent = $_POST['searchContent'];
						
						$sql = "SELECT * FROM content INNER JOIN media ON content.media_id = media.media_id where status = 'ACCEPTED' AND content_title LIKE '%$searchContent%' ORDER BY updated_at DESC";
						$result = mysqli_query($conn, $sql);
						
						
						
						if($result->num_rows > 0){
							echo '<div class="row align-items-center">';
							while($row = mysqli_fetch_assoc($result)){
								
								echo '
									
										<div class="col-lg-3 col-md-6 " >
										<h5 class="card-title p-2">'.$row['content_title'].'</h5>
										<div class="card mb-4 box-shadow">
											<img class="card-img-top" src="'.$row['image'].'" alt="Card image cap">
											<div class="card-body">
												<p class="card-text truncate">'.$row['description'].'</p>
												<div class="d-flex justify-content-between align-items-center">
													<div class="btn-group">
														<a href="historical_site.php?contentId='. $row['content_id'].'" class="btn btn-sm btn-outline-primary">View</a>
													</div>
													<small class="text-muted">'. $row['created_at'].'</small>
												</div>
											</div>
										</div>
									</div>

									
								
								';
								//<button type="button" class="btn btn-sm btn-outline-secondary">Edit</button> this is not for user page; user cannot edit a post.
							}
							echo '</div>';
						}else{
							echo '<h2>No result for '.$searchContent.'</h2>';
						}
					}else{
						// Pagination variables
						$limit = 3; // Number of records per page
						$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page
						if ($page < 1) $page = 1;
						$offset = ($page - 1) * $limit;

						// Fetch total number of records
						$total_results = $conn->query("SELECT COUNT(*) as count FROM content INNER JOIN media ON content.media_id = media.media_id where status = 'ACCEPTED'")->fetch_assoc()['count'];
						$total_pages = ceil($total_results / $limit);

						// Fetch records for the current page
						$pagination_stmt = $conn->prepare("SELECT * FROM content INNER JOIN media ON content.media_id = media.media_id where status = 'ACCEPTED' ORDER BY updated_at DESC LIMIT ? OFFSET ?");
						$pagination_stmt->bind_param("ii", $limit, $offset);
						$pagination_stmt->execute();
						$pagination_result = $pagination_stmt->get_result();

						// Display records
						echo '<div class="row">';
						while ($row_pagination = $pagination_result->fetch_assoc()) {
							echo '
									
										<div class="col-md-4">
										<h5 class="card-title p-2">'.$row_pagination['content_title'].'</h5>
										<div class="card mb-4 box-shadow">
											<img class="card-img-top" src="'.$row_pagination['image'].'" alt="Card image cap">
											<div class="card-body">
												<p class="card-text truncate">'.$row_pagination['description'].'</p>
												<div class="d-flex justify-content-between align-items-center">
													<div class="btn-group">
														<a href="historical_site.php?contentId='. $row_pagination['content_id'].'" class="btn btn-sm btn-outline-primary">View</a>
													</div>
													<small class="text-muted">'. $row_pagination['created_at'].'</small>
												</div>
											</div>
										</div>
									</div>

									
								
								';
						}
						echo '</div>';
						echo '<br>
							<br>
							<br>
							<nav class="container d-flex">
							<ul class="pagination ms-auto">';

							// Previous Page Link
							echo '<li class="page-item ' . ($page <= 1 ? 'disabled' : '') . '">
									<a class="page-link" href="?page=' . ($page - 1) . '" aria-label="Previous">
									<span aria-hidden="true">&laquo;</span>
									</a>
								</li>';

							// Page Numbers
							for ($i = 1; $i <= $total_pages; $i++) {
								echo '<li class="page-item ' . ($i == $page ? 'active' : '') . '">
										<a class="page-link" href="?page=' . $i . '">' . $i . '</a>
									</li>';
							}

							// Next Page Link
							echo '<li class="page-item ' . ($page >= $total_pages ? 'disabled' : '') . '">
									<a class="page-link" href="?page=' . ($page + 1) . '" aria-label="Next">
									<span aria-hidden="true">&raquo;</span>
									</a>
								</li>';

							echo '</ul>
							</nav>';


						
						
						/* $sql = "SELECT * FROM content INNER JOIN media ON content.media_id = media.media_id where status = 'ACCEPTED' ORDER BY updated_at DESC LIMIT 3";
						$result = mysqli_query($conn, $sql);
						
						
						
						if($result){
							echo '<div class="row">';
							while($row = mysqli_fetch_assoc($result)){
								
								echo '
								
										<div class="col-md-4">
										<h5 class="card-title p-2">'.$row['content_title'].'</h5>
										<div class="card mb-4 box-shadow">
											<img class="card-img-top" src="'.$row['image'].'" alt="Card image cap">
											<div class="card-body">
												<p class="card-text truncate">'.$row['description'].'</p>
												<div class="d-flex justify-content-between align-items-center">
													<div class="btn-group">
														<a href="historical_site.php?contentId='. $row['content_id'].'" class="btn btn-sm btn-outline-primary">View</a>
													</div>
													<small class="text-muted">'. $row['created_at'].'</small>
												</div>
											</div>
										</div>
									</div>

									
								
								';
								//<button type="button" class="btn btn-sm btn-outline-secondary">Edit</button> this is not for user page; user cannot edit a post.
							}
							echo '</div>';
						} */
					}
				
				
					
				
				?>
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