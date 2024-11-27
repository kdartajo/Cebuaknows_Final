<?php
	include "connection.php";
	
	if(!empty($_SESSION["id"])){
		$id = $_SESSION["id"];
		$result = mysqli_query($conn, "SELECT * FROM users WHERE user_id = '$id' ");
		$row = mysqli_fetch_assoc($result);
		if($row['role'] != 'Historian'){
				exit('user-type cannot access this page');
			}
	}else{
		header("Location: login.php");
		exit();
	}

	

	if(isset($_POST['post_forum'])){
		$forum_topic = $_POST['forum_topic'];
		$forum_description = $_POST['forum_description'];
		$user_id = $row['user_id'];
		$content_id = $_GET['get_content_id'];
		
		$stmt = $conn->prepare("INSERT INTO forum(forum_topic, user_id, content_id, forum_description) values(?,?,?,?)");
		$stmt->bind_param('ssss', $forum_topic, $user_id, $content_id, $forum_description);
		$stmt->execute();
		$result = $stmt->get_result();
		
		if($result){
			echo '<div class="alert alert-success" role="alert">
			  Forum Posted!
			</div>';
			header('location: forum-historian.php?get_content_id='. $_GET['get_content_id']);
			exit;
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
				<hr>
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
						<img src="img/land-img/logo.png" alt="Logo" width="100" height="100">
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
				
			
		</div>
        <br>
			<div class="p-4 bg-light rounded shadow-sm text-center">
					<h1 class="fw-bold mb-3">Welcome to Forums</h1>
					<p class="col-md-8 fs-4 mx-auto">
						Dive into discussions, share your thoughts, and connect with a vibrant community. Start your journey by creating a new forum or exploring existing ones!
					</p>
					<button type="button" data-bs-toggle="modal" data-bs-target="#myModal" class="btn btn-primary btn-lg">
						<i class="fas fa-plus-circle"></i> Create Forum
					</button>
				</div>
			<br>
			<br>
			<br>
			<br>
		<div class="container">
				<?php
					$content_id = $_GET['get_content_id'];
					$sql = "SELECT * FROM forum INNER JOIN users ON forum.user_id = users.user_id where content_id = '$content_id'";
					$result = mysqli_query($conn, $sql);
					
			
					
				?>
			
				
				<br>
				
				<br>
				<br>
			<div class="row">
				<?php	
					if($result){
						echo '<div class="row">';
						while($row = mysqli_fetch_assoc($result)){
							echo '
								 
									<div class="col-md-4">
									
									  <div class="card mb-4 p-3 box-shadow">
										<h5 class="card-title">'. $row['forum_topic'] .'</h5>
										<div class="card-body">
											
											<p class="card-text truncate">'.$row['forum_description'].'</p>
										  <div class="d-flex justify-content-between align-items-center">
											<div class="btn-group">
											 
											  <a  href="forum_page-historian.php?forum_id='.$row['forum_id'].'" class="btn btn-sm btn-outline-primary"><i class="fas fa-newspaper"></i> View Forum</a>
										 
											</div>
											<small class="text-muted">'.$row['lastname'].', '.$row['firstname'].'</small>
										  </div>
										</div>
									  </div>
									</div>
							';
							//<button type="button" class="btn btn-sm btn-outline-secondary">Edit</button> this is not for user page; user cannot edit a post.
						}
						echo '</div>';
					}else{
						echo "No datas yet";
					}
				
				?>
			</div>
			
		</div>
		<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Create Forum</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			  </div>
			  <div class="modal-body">
				<form action='forum-historian.php?get_content_id=<?php echo $_GET['get_content_id']?>' method="post">
				  <div class="mb-3">
					<label class="form-label">Forum Topic</label>
					<input type="text" name="forum_topic" class="form-control" placeholder="Enter forum topic" required>
					
				  </div>
				  <div class="mb-3">
					<label class="form-label">What can you say?</label>
					<textarea name="forum_description" rows="3"  class="form-control" required></textarea>
				  </div>
				  <button type="submit" name="post_forum" class="btn btn-primary">Post Forum</button>
				</form>
			  </div>
			</div>
		  </div>
		</div>
		<br>
		<br>
		<br>
		<br>
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
							<li><a href="dashboard-historian.php" class="text-white ">Home</a></li>
							<li><a href="about-historian.php" class="text-white ">About</a></li>
							<li><a href="news-historian.php" class="text-white ">News</a></li>
							<li><a href="contact-historian.php" class="text-white ">Contact</a></li>
							<li><a href="advertisement.php" class="text-white ">add your Advertisement</a></li>
						</ul>
					</div>

					<!-- Contact Us -->
					<div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
						<h5 class="text-uppercase fw-bold">Contact Us</h5>
						<ul class="list-unstyled">
							<li>info@cebuaknows.com</li>
							<li>+1 234 567 890></li>
							<li>123 Main St, City, Country</li>
						</ul>
					</div>

					<!-- Social Media -->
					<div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
						<h5 class="text-uppercase fw-bold">Follow Us</h5>
						<div class="d-flex justify-content-start">
							<a href="#" class="text-white me-4"><i class="fab fa-facebook-f"></i></a>
							<a href="#" class="text-white me-4"><i class="fab fa-twitter"></i></a>
							<a href="#" class="text-white me-4"><i class="fab fa-instagram"></i></a>
							<a href="#" class="text-white"><i class="fab fa-linkedin-in"></i></a>
						</div>
					</div>
				</div>
			</div>

			<div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
				© 2024 Your Website. All rights reserved.
			</div>
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