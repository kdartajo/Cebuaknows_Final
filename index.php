<?php 
    include 'connection.php';
	
	if(!empty($_SESSION['id'])){
		header("Location: index.php");
	}
	
	
?>
	<!Doctype html>
	<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width,initial-scale=1.0">
		<link rel="stylesheet" href="css/style/index.css">
		<title>CebuaKnows</title>
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
		<style>
		@media (max-width: 991px) {
			#navbarNav {
				background-color: rgba(var(--bs-light-rgb), var(--bs-bg-opacity)) !important;
				padding: 15px;
				border-raduis: 5px;
			}
		}
		
		.navbar {
			width: 100%;
			height: 10vh;
		}
		
		html {
			scroll-behavior: smooth;
		}
		/* Basic styling for the banner */
		/* Basic styling for the banner */
			/*.banner {
				position: relative;
				overflow: hidden;
			}*/

			/* Make the banner image take full width and adjust its height */
			/*.banner img {
				width: 100%;
				height: auto; /* Keeps the aspect ratio */
			/*}

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
			/*.banner img {
				height: 250px; /* Adjust height for mobile screens */
				/*object-fit: cover;*/
				/*}
			}*/
		
		 /* Hide the image by default */
			

			/* Show the image only on screens smaller than 991px */
			@media (max-width: 991px) {
				.mobile-only {
					display: block;
					margin-top: 5px;
				}
			}
		
		
		</style>
	</head>

	<body>
		<br>
		<br>
		<nav class="position-fixed z-1 top-0 navbar navbar-expand-lg navbar-light bg-light">
			<div class="container" id="container">
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
				<img src="img/land-img/logo.png" alt="Logo" width="50" height="50">
				<div class="collapse navbar-collapse" id="navbarNav">
					<ul class="navbar-nav me-auto">
						<li class="nav-item"> <a class="nav-link" href="#home">Home</a> </li>
						<li class="nav-item"> <a class="nav-link" href="#about">About</a> </li>
						<li class="nav-item"> <a class="nav-link" href="#news">News</a> </li>
						<li class="nav-item"> <a class="nav-link" href="#contact">Contact Us</a> </li>
					</ul>
					<!-- Separate Login and Join Buttons -->
					<ul class="navbar-nav ms-auto" >
						<li class="nav-item mobile-only"> <a class="btn btn-outline-primary me-2" href="login.php">Login</a> </li>
						<li class="nav-item mobile-only"> <a class="btn btn-primary" href="Registration.php">Join</a> </li>
					</ul>
				</div>
			</div>
		</nav>
		<br>
		<br>
		<!-- Banner Image -->
		<section class="banner" id="home">
			<div class="image-container">
				<img src="img/assets/banner.png" class="img-fluid w-100" alt="Banner">
			</div> 
		</section>
		<br>
		<!-- About Us -->
		<section class="container py-5" id="about">
		  <div class="text-center mb-5">
			<h1 class="fw-bold display-4">About Us</h1>
			<p class="text-muted">Discover Cebu’s rich heritage and history with CebuaKnows.</p>
		  </div>
		  
		  <!-- Our Mission Section -->
		  <div class="row align-items-center mb-5">
			<div class="col-md-6">
			  <h2 class="fw-bold">Our Mission</h2>
			  <p class="text-muted">
				CebuaKnows is an educational platform dedicated to showcasing the rich history and cultural heritage of Cebu's historical places. Our mission is to educate and inspire people of all ages, especially students, to appreciate and understand the significance of these historical landmarks in shaping Cebu’s identity.
			  </p>
			</div>
			<div class="col-md-6">
			  <img src="img/assets/yap.jpg" alt="Cebu Historical Site" class="img-fluid rounded">
			</div>
		  </div>

		  <!-- What We Offer Section -->
		  <div class="row align-items-center mb-5">
			<div class="col-md-6 order-md-2">
			  <h2 class="fw-bold">What We Offer</h2>
			  <p class="text-muted">
				We provide a user-friendly platform where users can explore various historical sites in Cebu, complete with photos, descriptions, and historical background. Whether you're a student working on a project or a history enthusiast, CebuaKnows is your go-to resource for learning more about Cebu's historical treasures.
			  </p>
			</div>
			<div class="col-md-6 order-md-1">
			  <img src="img/assets/museo.jpg" alt="Cebu Historical Site" class="img-fluid rounded">
			</div>
		  </div>

		  <!-- Our Vision Section -->
		  <div class="row align-items-center mb-5">
			<div class="col-md-6">
			  <h2 class="fw-bold">Our Vision</h2>
			  <p class="text-muted">
				We envision a community that is well-informed about Cebu's history and actively participates in preserving and promoting its heritage for future generations.
			  </p>
			</div>
			<div class="col-md-6">
			  <img src="img/assets/casa.jpg" alt="Cebu Historical Site" class="img-fluid rounded">
			</div>
		  </div>

		  <!-- Meet the Team Section -->
		  <div class="text-center mb-5">
			<h2 class="fw-bold">Meet the Team</h2>
			<p class="text-muted">
			  CebuaKnows was developed by a passionate team of students from <strong>University of Cebu - Main Campus</strong>, guided by their adviser, <strong>Mr. Nonito O. Odjinar</strong>.
			</p>
			<ul class="list-unstyled">
			  <li>Artajo, Klien Dominic T.</li>
			  <li>Binghay, Aaron Gregg D.</li>
			  <li>Ruiz, Vince C.</li>
			  <li>Tajan, Jemil R.</li>
			  <li>Tallo, Kristian Marpe M.</li>
			</ul>
		  </div>

		  <!-- Contact Us Section -->
		  <div class="text-center">
			<h2 class="fw-bold">Contact Us</h2>
			<p class="text-muted">
			  If you have any questions, feedback suggestions, or would like to collaborate with us, feel free to reach out at: <strong>thisiscebuaknows@gmail.com</strong>.
			</p>
		  </div>
		</section>
		<!-- Contact Section -->
		<section class="container my-5 py-5 border shadow" id="contact">
			<h1 class="text-center mb-4"><strong>Meet the Team</strong></h1>
			<p class="text-center mb-5">Feel free to contact any of our team members below:</p>
			<!-- First Row: Team Members 1, 2, and 3 -->
			<div class="row gy-4 justify-content-center">
				<!-- Team Member 1 -->
				<div class="col-md-6 col-lg-4 text-center">
					<div class="card border-0"> <img src="img/assets/artajo.jpg" alt="Artajo Klien Dominic T." class="card-img-top rounded-circle mx-auto" style="width: 150px; height: 150px; object-fit: cover;">
						<div class="card-body">
							<h5 class="card-title"><a href="https://github.com/kdartajo">Artajo Klien Dominic T.</a></h5>
							<p class="card-text">klienartajo@gmail.com
								<br>+639150141501 </p>
						</div>
					</div>
				</div>
				<!-- Team Member 2 -->
				<div class="col-md-6 col-lg-4 text-center">
					<div class="card border-0"> <img src="img/assets/binghay.png" alt="Binghay Aaron Gregg D." class="card-img-top rounded-circle mx-auto" style="width: 150px; height: 150px; object-fit: cover;">
						<div class="card-body">
							<h5 class="card-title"><a href="https://github.com/AaronGewgg">Binghay Aaron Gregg D.</a></h5>
							<p class="card-text">binghaygregg@gmail.com
								<br>+639983110968 </p>
						</div>
					</div>
				</div>
				<!-- Team Member 3 -->
				<div class="col-md-6 col-lg-4 text-center">
					<div class="card border-0"> <img src="img/assets/ruiz.png" alt="Ruiz Vince C." class="card-img-top rounded-circle mx-auto" style="width: 150px; height: 150px; object-fit: cover;">
						<div class="card-body">
							<h5 class="card-title"><a href="https://github.com/VinceRuiz">Ruiz Vince C.</a></h5>
							<p class="card-text">vinceruizvrz@gmail.com
								<br>+639983110968 </p>
						</div>
					</div>
				</div>
			</div>
			<!-- Second Row: Team Members 4 and 5 (Centered) -->
			<div class="row gy-4 justify-content-center mt-4">
				<!-- Team Member 4 -->
				<div class="col-md-6 col-lg-4 text-center">
					<div class="card border-0"> <img src="img/assets/tajan.png" alt="Tajan Jemil R." class="card-img-top rounded-circle mx-auto" style="width: 150px; height: 150px; object-fit: cover;">
						<div class="card-body">
							<h5 class="card-title"><a href="https://github.com/jemiltajan">Tajan Jemil R.</a></h5>
							<p class="card-text">jemiltajan5@gmail.com
								<br>+639452594907 </p>
						</div>
					</div>
				</div>
				<!-- Team Member 5 -->
				<div class="col-md-6 col-lg-4 text-center">
					<div class="card border-0"> <img src="img/assets/tallo.png" alt="Tallo Kristian Marpe M." class="card-img-top rounded-circle mx-auto" style="width: 150px; height: 150px; object-fit: cover;">
						<div class="card-body">
							<h5 class="card-title"><a href="https://github.com/SanjiDezu">Tallo Kristian Marpe M.</a></h5>
							<p class="card-text">tallokristian1@gmail.com
								<br>+639497411700 </p>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- News Section -->
		<section class="container my-5" id="news">
			<h1 class="text-center mb-4"><strong>Latest News and Updates</strong></h1>
			<!-- News Items -->
			<div class="row g-4">
				<!-- News Item 1 -->
				<div class="col-md-6 col-lg-4">
					<div class="card h-100 shadow-sm"><a href="https://www.rappler.com/life-and-style/travel/126302-magellans-cross-church-restored-cebu/"><img src="img/assets/magellan1.jpg" class="card-img-top" alt="Historical Site 1"></a>
						<div class="card-body">
							<h3 class="card-title h5">Update on the Restoration of Magellan’s Cross</h3>
							<p> <strong>Date:</strong> September 15, 2024 </p>
							<p>The iconic Magellan’s Cross in Cebu City is undergoing restoration to preserve its historic value. The restoration project will focus on cleaning and reinforcing the structure to ensure that it remains a symbol of Cebu's rich history for future generations.</p>
						</div>
					</div>
				</div>
				<!-- News Item 2 -->
				<div class="col-md-6 col-lg-4">
					<div class="card h-100 shadow-sm"><a href="https://cebudailynews.inquirer.net/340030/fort-san-pedro-in-cebu-city-reopens#:~:text=CEBU%20CITY%2C%20Philippines%20%E2%80%94%20Fort%20San%20Pedro%2C%20the,due%20to%20the%20Coronavirus%20Disease%202019%20%28COVID-19%29%20pandemic."><img src="img/assets/image1.jpg" class="card-img-top" alt="Historical Site 2"></a>
						<div class="card-body">
							<h3 class="card-title h5">Fort San Pedro Now Open to the Public</h3>
							<p> <strong>Date:</strong> August 25, 2024 </p>
							<p>After months of renovation, Fort San Pedro has reopened its gates to visitors. The historical site now features a newly designed museum that showcases Cebu’s colonial past. Visitors can explore the fort and enjoy guided tours.</p>
						</div>
					</div>
				</div>
				<!-- News Item 3 -->
				<div class="col-md-6 col-lg-4">
					<div class="card h-100 shadow-sm"><a href="https://www.mycebu.ph/article/hertiage-of-cebu-monument/"><img src="img/assets/image2.jpg" class="card-img-top" alt="Historical Site 3"></a>
						<div class="card-body">
							<h3 class="card-title h5">New Discoveries at Cebu Heritage Monument</h3>
							<p> <strong>Date:</strong> July 30, 2024 </p>
							<p>Archaeologists have made new discoveries at the Cebu Heritage Monument, shedding light on previously unknown aspects of the region's history. The findings are set to be included in the monument’s permanent exhibit, drawing interest from historians and tourists alike.</p>
						</div>
					</div>
				</div>
			</div>
		</section>
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
							<li> <a href="#home" class="text-white ">Home</a> </li>
							<li> <a href="#about" class="text-white ">About</a> </li>
							<li> <a href="#news" class="text-white ">News</a> </li>
							<li> <a href="#contact" class="text-white ">Contact</a> </li>
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
	</body>
</html>