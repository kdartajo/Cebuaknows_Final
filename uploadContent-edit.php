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
		
	if(isset($_GET['content_id'])){
		$content_id = $_GET['content_id'];
		
		
		$stmt = $conn->prepare("Select * from location 
								INNER JOIN content ON content.location_id = location.location_id 
								INNER JOIN media ON content.media_id = media.media_id 
								INNER JOIN users ON content.user_id = users.user_id 
								
								where content.content_id = ?;");
		$stmt->bind_param('s', $content_id);
		$stmt->execute();
		$result = $stmt->get_result();
		
		if($result){
			
			while($content_row = mysqli_fetch_assoc($result)){
				$content_id = $content_row['content_id'];
				$content_title = $content_row['content_title'];
				$content_description = $content_row['description'];
				$content_location = $content_row['location'];
				$content_url = $content_row['url'];
				$content_video = $content_row['video'];
				$content_image = $content_row['image'];
				
				//$content_question = $content_row['question'];
				
			}
		}
	}
	
	 if (isset($_POST['submit'])) {
		
		$content_id = $_GET['content_id'];
		
		$check_stmt = $conn->prepare("select * from content 
									INNER JOIN location ON content.location_id = location.location_id 
									INNER JOIN media ON content.media_id = media.media_id
									where content_id = ?");
		$check_stmt->bind_param('s', $content_id);
		$check_stmt->execute();
		$check_result = $check_stmt->get_result();
		
		if($check_result->num_rows > 0){
			while($row_newcontent = mysqli_fetch_assoc($check_result)){
				$location_id =$row_newcontent['location_id'];
				$media_id =$row_newcontent['media_id'];
			}
		}
		
        // Retrieve form inputs
        $contentTitle = $_POST['contentTitle'] ?? null;
        $description = $_POST['description'] ?? null;
        $location = $_POST['locationDropdown'] ?? null; // Assume this is the LOCATION_ID
        $url = $_POST['url'] ?? null;
		
		$user_id = $id;
		$video = $_FILES['video']['name'];
		$videoPath = 'uploads/vid/' . basename($video);
		$image = $_FILES['image']['name'];
		$imagePath = 'uploads/img/' . basename($image);
		
		move_uploaded_file($_FILES['video']['tmp_name'], $videoPath);
		
		move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
		

        // update into location table
        $location_sql = "UPDATE location set location = ? where location_id = ?";
        $location_stmt = $conn->prepare($location_sql);
		$location_stmt->bind_param('ss',$location, $location_id);
		$location_stmt->execute();
		
		
        // update into media table
        $media_sql = "UPDATE media set url = ?, video =?, image = ?, last_update = NOW() where media_id = ?";
        $media_stmt = $conn->prepare($media_sql);
		$media_stmt->bind_param('ssss',$url, $videoPath, $imagePath, $media_id);
		$media_stmt->execute();

        $content_sql = "UPDATE content set content_title = ?, description = ?, location_id = ?, media_id = ?, user_id = ?, updated_at = NOW() where content_id = ?";
		$stmt = $conn->prepare($content_sql);
		$stmt->bind_param('ssssss', $contentTitle, $description, $location_id, $media_id, $user_id, $content_id);
		$content_result = $stmt->execute();

        if ($content_result) {
            $content_id = mysqli_insert_id($conn);
			$_SESSION['success_message'] = "Content Updated Succesfully";
			header("Location: dashboard-user.php");
			
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        // Close the connection
        //mysqli_close($conn);
    }

?>

<!Doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <title>Upload Content</title>
        <style type="text/css">
            #regiration_form fieldset:not(:first-of-type) {
            display: none;
        }
        </style>
		<!-- Online Bootstrap -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
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
			
			.navbar .container{
				height:5vh;
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
								</i> <i class="fas fa-plus-circle"></i> Add Quizzes
							</a>
						</li>
						<li class="navigation-list-item">
							<a class="navigation-link" href="leaderDash.php">
								<i class="fas fa-trophy"></i> Leaderboards
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
	
	
	<br>
	<br>
	
	
        <div class="progress">
            <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <form id="regiration_form" action="uploadContent-edit.php?content_id=<?php echo $_GET['content_id'] ?>"  method="post" style="padding: 50px;" enctype="multipart/form-data">
            <fieldset>
                <h2>Share Historical Content</h2>
                <div class="form-group my-2">
                    <label for="contentTitle">TITLE</label>
                    <input type="text" class="form-control" id="contentTitle" name="contentTitle" placeholder="Enter Title" value="<?php echo isset($content_title) ? $content_title : ''; ?>" required>
                </div>
                <div class="form-group my-2">
                    <label for="description">DESCRIPTION</label>
                    <!--<input type="text" class="form-control" id="description" name="description" placeholder="Enter Description">-->
					<textarea class="form-control" id="description" name="description" placeholder="Enter Description of Historical Site" rows="3" required><?php echo isset($content_description) ? $content_description : ''; ?></textarea>
                </div> 
                <div class="form-group my-2"> 
                    <label for="location">LOCATION</label> 
					<input type="text" class="form-control" id="locationDropdown" name="locationDropdown" placeholder="Location" required value="<?php echo isset($content_location) ? $content_location : ''; ?>"/>
					<small>Include street, Barangay and ZIP code</small>

                    
                </div>
                <input type="button" name="next" class="next btn btn-info" value="Next" />
            </fieldset>
            <fieldset>
                <h2>Upload Media</h2>
                <div class="form-group my-2">
                    <label for="url">URL</label>
                    <input type="text" class="form-control" name="url" id="url" placeholder="Paste Url" value="<?php echo isset($content_url) ? $content_url : ''; ?>" >
                </div>
                <div class="form-group my-2">
                    <label for="video">VIDEO</label>
                    <input type="file" class="form-control" name="video" id="video" placeholder="Upload Video" value="<?php echo isset($content_video) ? $content_video : ''; ?>">
                </div>
                <div class="form-group my-2">
                    <label for="image">IMAGE</label>
                    <input type="file" class="form-control" name="image" id="image" placeholder="Upload Picture" value="<?php echo isset($content_image) ? $content_image : ''; ?>" required>
                </div>
				
                <input type="button" name="previous" class="previous btn btn-secondary my-2" value="Previous" />
                <input type="button" name="next" class="next2 next btn btn-info" value="Next" />
				
            </fieldset>
           
			<fieldset>
                <h2>Upload Summary</h2>
               
    
				<h4>Content Title:</h4>
				<p id="summaryContentTitle"></p>
				
				<h4>Description:</h4>
				<p id="summaryDescription"></p>
				
				<h4>Location:</h4>
				<p id="summaryLocation"></p>
				
				<h4>Youtube Url:</h4>
				<p id="summaryUrl"></p>
				
				<h4>Video:</h4>
				<p id="summaryVideo"></p>
				
				<h4>Image:</h4>
				<p id="summaryImage"></p>
				
				
    
                <input type="button" name="previous" class="previous btn btn-secondary" value="Previous" />
                
				<input type="submit" name="submit" class="submit btn btn-success" value="Submit" />
            </fieldset>
        </form>
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
    </body>
</html>
<script type="text/javascript">
    $(document).ready(function(){
        var current = 1,current_step,next_step,steps;
        steps = $("fieldset").length;
        $(".next").click(function(){
            current_step = $(this).parent();
            next_step = $(this).parent().next();
            next_step.show();
            current_step.hide();
            setProgressBar(++current);
        });
        $(".previous").click(function(){
            current_step = $(this).parent();
            next_step = $(this).parent().prev();
            next_step.show();
            current_step.hide();
            setProgressBar(--current);
        });
        setProgressBar(current);
        // Change progress bar action
        function setProgressBar(curStep){
            var percent = parseFloat(100 / steps) * curStep;
            percent = percent.toFixed();
            $(".progress-bar")
                .css("width",percent+"%")
                .html(percent+"%");		
        }
    });
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
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
		
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Capture the values from the previous steps and display them in the final summary step
        document.querySelector('.next').addEventListener('click', function () {
            // Get content title
            let contentTitle = document.getElementById('contentTitle').value;
			if(contentTitle != ''){
				document.getElementById('summaryContentTitle').style.color = "black";
				document.getElementById('summaryContentTitle').innerText = contentTitle;
			}else{
				document.getElementById('summaryContentTitle').style.color = "red";
				document.getElementById('summaryContentTitle').innerText = "*Please input a Content Title";
			}
           
            // Get description
            let description = document.getElementById('description').value;
			if(description != ""){
				document.getElementById('summaryDescription').style.color = "black";
				document.getElementById('summaryDescription').innerText = description;
			}else{
				document.getElementById('summaryDescription').style.color = "red";
				document.getElementById('summaryDescription').innerText = "*Please input a description for your content";
			}
			
            // Get location
            let location = document.getElementById('locationDropdown').value;
			if(location != ""){
				document.getElementById('summaryLocation').style.color = "black";
				document.getElementById('summaryLocation').innerText = location;
			}else{
				document.getElementById('summaryLocation').style.color = "red";
				document.getElementById('summaryLocation').innerText = "*Please put a location of your content";
			}
        });
        
        document.querySelector('.next2').addEventListener('click', function () {
            // Get media URLs (Video and Image)
                let video = document.getElementById('video').value.split('\\').pop();  // Just get the filename
                let image = document.getElementById('image').value.split('\\').pop();  // Just get the filename
                let url = document.getElementById('url').value;
				
				if(image != ""){
					document.getElementById('summaryImage').style.color = "black";
					document.getElementById('summaryImage').innerText = image;
				}else{
					document.getElementById('summaryImage').style.color = "red";
					document.getElementById('summaryImage').innerText = "*Please put an image for the cover of your content";
				}
				
				if(video != ""){
					document.getElementById('summaryVideo').style.color = "black";
					document.getElementById('summaryVideo').innerText = video;
				}else{
					document.getElementById('summaryVideo').style.color = "red";
					document.getElementById('summaryVideo').innerText = "*Please put a video for your content (optional)";
				}
				
				if(url != ""){
					document.getElementById('summaryUrl').style.color = "black";
					document.getElementById('summaryUrl').innerText = url;
				}else{
					document.getElementById('summaryUrl').style.color = "red";
					document.getElementById('summaryUrl').innerText = "*Please put a youtube url for your content (optional)";
				}
               
                
               
        });
        
    });
</script>

