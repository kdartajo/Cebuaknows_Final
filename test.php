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
	
	$quiz_id = $_GET['quiz_id'] ?? null;
	
	//check if the user is the creator of the quiz
	$check_userid = $conn->prepare("Select user_id from user_quiz_details where quiz_id = ?");
	$check_userid->bind_param('s', $quiz_id);
	$check_userid->execute();
	$check_userid_result = $check_userid->get_result();
	
	if($check_userid_result->num_rows > 0){
		$user_row = mysqli_fetch_assoc($check_userid_result);
		if($user_row['user_id'] == $row['user_id']){
			echo '<div class="alert alert-success" role="alert">
					 Creator of the Quiz cannot take the Quiz
					</div>';
			exit;
		}
		
	}
	
	
	
	// Initialize or retrieve the current score and question index
	if (!isset($_SESSION['score'])) {
		$_SESSION['score'] = 0;
	}
	if (!isset($_SESSION['current_question'])) {
		$_SESSION['current_question'] = 0;
	}

	$score = $_SESSION['score'];
	$current_question = $_SESSION['current_question'];
	
	// Check if form was submitted
	if (isset($_POST['submit'])) {
		$selected_answer = $_POST['choices'];
		$question_id = $_POST['question_id'];
		
		// Check if the selected answer is correct
		$stmt = $conn->prepare("SELECT * FROM choice_answer WHERE choice_answer_id = ? AND question_id = ?");
		$stmt->bind_param('ii', $selected_answer, $question_id);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->num_rows > 0) {
			$_SESSION['score']++; // Increase score if the answer is correct
		}

		// Move to the next question
		$_SESSION['current_question']++;
		$current_question = $_SESSION['current_question'];
	}

	// Fetch questions and choices from the database
	$sql = "SELECT uqd.user_quiz_detail_id, uqd.user_id, uqd.question_id, q.quiz_title, question.question, c.description, uqd.choices_id
			FROM user_quiz_details uqd
			INNER JOIN choices c ON uqd.choices_id = c.choices_id
			INNER JOIN quiz q ON uqd.quiz_id = q.quiz_id
			INNER JOIN question ON uqd.question_id = question.question_id
			WHERE uqd.quiz_id = ?";  // Adjust user_id and quiz_id as needed

	$stmt = $conn->prepare($sql);
	$stmt->bind_param('s', $quiz_id);
	$stmt->execute();
	$result = $stmt->get_result();

	$questions = [];
	while ($row_user_quiz_details = $result->fetch_assoc()) {
		$questions[$row_user_quiz_details['question_id']]['quiz_title'] = $row_user_quiz_details['quiz_title'];
		$questions[$row_user_quiz_details['question_id']]['question'] = $row_user_quiz_details['question'];
		$questions[$row_user_quiz_details['question_id']]['choices'][] = $row_user_quiz_details['description'];
		$questions[$row_user_quiz_details['question_id']]['choices_id'][] = $row_user_quiz_details['choices_id'];
	}

	// Check if there are any more questions
	$total_questions = count($questions);

?>

<!DOCTYPE html>
<html lang="en">
<head>
	
    <meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multiple Choice Quiz</title>
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
			
        .quiz-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            width: 50%;
            max-width: 600px;
            text-align: center;
        }

		.quiz-card {
			background-color: #f9f9f9;
			border-radius: 8px;
			box-shadow: 0 4px 8px rgba(0,0,0,0.1);
		}



		h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }
        .question {
            /*font-size: 18px;
            margin-bottom: 15px;*/
			font-size: 1.2rem;
			font-weight: 500;
        }
        .choices {
            /*text-align: left;
            margin-bottom: 20px;*/
			margin-top: 20px;
        }
        .choices label {
            display: block;
            margin-bottom: 10px;
            font-size: 16px;
        }

		.choice-option:hover {
			background-color: #f0f0f0;
			cursor: pointer;
			border-radius: 5px;
		}

		.choice-option input {
			margin-right: 10px;
		}

		.choice-text {
			font-size: 1rem;
			display: inline-block;
		}

        .choices input {
            margin-right: 10px;
        }
        .submit-button {
            /*background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;*/
			padding: 10px 20px;
			background-color: #007bff;
			color: white;
			border: none;
			border-radius: 5px;
			font-size: 1rem;
        }
        .submit-button:hover {
            /*background-color: #0056b3;*/
			background-color: #0056b3;
			cursor: pointer;
        }

		.btn-success {
			padding: 10px 30px;
			font-size: 1.2rem;
		}

		.progress {
			height: 10px;
			border-radius: 5px;
			margin-bottom: 20px;
		}

		.progress-bar {
			background-color: #28a745;
		}

		.btn-primary {
			padding: 10px 20px;
			text-align: center;
		}

		.btn-primary, .btn-success, .btn-lg {
			padding: 12px 30px;
			font-size: 1.1rem;
		}

		.btn-primary:hover, .btn-success:hover {
			background-color: #218838;
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
							<a class="navigation-link" href="leaderDash.php"> <i class="fas fa-trophy"></i> Leaderboards </a>
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
		<div class="container d-flex flex-column justify-content-center align-items-center py-4">
			<?php
			$check_stmt = $conn->prepare("SELECT * FROM user_quiz_details WHERE quiz_id = ?");
			$check_stmt->bind_param('s', $quiz_id);
			$check_stmt->execute();
			$check_result = $check_stmt->get_result();

			if ($check_result->num_rows > 0) {
				if ($current_question < $total_questions) {
					// Get the current question details
					$question_ids = array_keys($questions);
					$question_id = $question_ids[$current_question];
					$question_data = $questions[$question_id];

					// Display the question and choices inside a card layout
					echo '<div class="card quiz-card p-4 shadow-lg w-100 w-md-75 w-lg-50">';
					echo "<h1 class='text-center mb-4'>" . $question_data['quiz_title'] . "</h1>";
					echo "<h3 class='question mb-4'>" . $question_data['question'] . "</h3>";

					// Display progress bar
					$progress = ($current_question / $total_questions) * 100;
					echo '<div class="progress mb-4">
							<div class="progress-bar" role="progressbar" style="width: ' . $progress . '%;" aria-valuenow="' . $progress . '" aria-valuemin="0" aria-valuemax="100"></div>
						</div>';

					// Display choices
					echo '<form action="test.php?quiz_id=' . $quiz_id . '" method="post" class="w-100">';
					echo '<input type="hidden" value="' . $question_id . '" name="question_id" />';

					echo "<div class='choices'>";
					foreach ($question_data['choices'] as $index => $choice) {
						echo '<label class="choice-option d-block mb-3">';
						echo '<input type="radio" value="' . $question_data['choices_id'][$index] . '" name="choices" class="form-check-input" required /> ';
						echo '<span class="choice-text">' . $choice . '</span>';
						echo '</label>';
					}
					echo "</div>";

					// Check if this is the last question
					$button_text = ($current_question == $total_questions - 1) ? 'Submit' : 'Next Question';

					// Display submit button with appropriate text
					echo "<div class='mt-4 text-center'>";
					echo "<input type='submit' class='btn btn-success btn-lg' name='submit' value='$button_text' />";
					echo "</div>";
					echo "</form>";
					echo '</div>';
					
					


				} else if ($quiz_id == null) {
					echo "<h2>No Quiz Uploaded Yet!</h2>";
				} else {
					// No more questions, display final score
					echo "<div class='card quiz-card p-4 shadow-lg text-center w-100 w-md-75 w-lg-50'>";
					echo "<h2>Quiz Completed!</h2>";
					echo "<p>Your final score is: " . $_SESSION['score'] . " out of " . $total_questions . "</p>";

					$check_stmt = $conn->prepare("SELECT * FROM quiz_leaderboard WHERE user_id = ? AND quiz_id = ?");
					$check_stmt->bind_param('ss', $row['user_id'], $quiz_id);
					$check_stmt->execute();
					$check_result = $check_stmt->get_result();

					if ($check_result->num_rows > 0) {
						$stmt = $conn->prepare("UPDATE quiz_leaderboard SET score = ?, updated_at = NOW() WHERE user_id = ?");
						$stmt->bind_param('ss', $_SESSION['score'], $row['user_id']);
						$result = $stmt->execute();

						if ($result) {
							echo "<p>Your score has been updated</p>";
							echo '<a href="dashboard-user.php" class="btn btn-primary btn-lg">Return</a>';
						} else {
							echo "<p>Your score was not saved, take the quiz again.</p>";
						}

						unset($_SESSION['score']);
						unset($_SESSION['current_question']);

					} else {
						$stmt = $conn->prepare("INSERT INTO quiz_leaderboard(score, total_questions, user_id, quiz_id, updated_at) VALUES(?,?,?,?, NOW())");
						$stmt->bind_param('ssss', $_SESSION['score'], $total_questions, $row['user_id'], $quiz_id);
						$result = $stmt->execute();

						if ($result) {
							echo "<p>Your score has been saved</p>";
							echo '<a href="dashboard-user.php" class="btn btn-primary btn-lg">Return</a>';
						} else {
							echo "<p>Your score was not saved, take the quiz again.</p>";
						}

						unset($_SESSION['score']);
						unset($_SESSION['current_question']);
					}
					echo '</div>';
				}
			} else {
				echo "<h2>No Quiz Uploaded Yet!</h2>";
			}
			?>
		</div>
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

<?php
$conn->close();
?>
