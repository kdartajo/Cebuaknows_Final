<!DOCTYPE html> 
<html>
    <head>
        <meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width,initial-scale=1.0">
        <title>User Login | WIP</title>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/style/style3.css">
        <link rel="stylesheet" type="text/css" href="css/style/style4.css">
        <script src="js/custom/script.js" defer></script>
        <style>
            input.btn-custom {
                background-color: #6c757d;
                border: none;
                border-radius: 8px;
                padding: 10px 20px;
                color: #ffffff;
                transition: all 0.1s ease;
            }

            input.btn-custom:hover {
                background-color: #ffffff !important;
                color: #000000 !important;
                border: 1px solid #000000 !important;
            }
        </style>
    </head>
    <body class="bg-light" style="font-family: sans-serif, sans-serif; font-size: 18px;">
        <div>
            <?php
                include "connection.php";
                
                if(!empty($_SESSION["id"])){
                    header("Location: index.php");
                }
				
				// Initialize error message variable
				$errorMessage = "";
				
                
                if(isset($_POST["submit"])){
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    
                    $result = mysqli_query($conn, "select * from users where email = '$email'");
                    $row = mysqli_fetch_assoc($result);
                    if(mysqli_num_rows($result) > 0){
                        if(password_verify($password, $row['password'])){
                            if($row['role'] == "Admin"){
                                $_SESSION["login"] = true;
                                $_SESSION["id"] = $row["user_id"];
                                header("Location: analytics-admin.php");
                            }else if($row['role'] == "Historian"){
                                $_SESSION["login"] = true;
                                $_SESSION["id"] = $row["user_id"];
                                header("Location: dashboard-historian.php");
                            }else if($row['role'] == "Deactivate"){
                                $_SESSION["login"] = false;
                                echo '<div class="alert alert-danger" role="alert">Your Account has been deactivated by the Admin. Please email thisiscebuaknows@gmail.com for further information </div>';
                            }else{
                                $_SESSION["login"] = true;
                                $_SESSION["id"] = $row["user_id"];
                                header("Location: dashboard-user.php");
                            }
                        }else{
                            $errorMessage = '<div class="alert alert-danger" role="alert">Incorrect password</div>';
                        }
                    }else{
                        $errorMessage = '<div class="alert alert-danger" role="alert">User not registered</div>';
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
                <!-- Login card on the right side -->
                <div class="col-lg-6 col-md-12" >
                    <form action="login.php" method="POST" id="loginForm">
                        <div class="card p-4 shadow tile-card text-dark" >
                            <h1 class="text-center">SIGN IN</h1>
                            <p class="text-center mt-3">Fill up this form with correct credentials being asked.</p>
							
							<?php if (!empty($errorMessage)) echo $errorMessage; ?>
							
                            <div class="form-group mb-3">
                                <label for="email">Email Address <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="email" placeholder="Enter your email address" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="password">Password <span class="text-danger">*</span></label>
                                <div class="password-container position-relative">
                                    <input class="form-control" type="password" name="password" id="password" placeholder="Enter your password" required>
                                    <span id="toggle-password" class="position-absolute" style="right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;">
                                        <i class="fas fa-eye" id="toggleIcon"></i>
                                    </span>
                                </div>
                            </div>
                            <p class="text-center"><a href="forgot-password.php" class="login-link">Forgot password?</a></p>
                            <div class="d-flex justify-content-center">
                                <input class="btn btn-custom" type="submit" name="submit" value="Sign In">
                            </div>
                            <p class="text-center mt-3">
                                Don't have an Account? <a href="Registration.php" class="login-link">Register</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script>
            const togglePassword = document.querySelector('#toggle-password');
            const passwordInput = document.querySelector('#password');
            const toggleIcon = document.querySelector('#toggleIcon');

            togglePassword.addEventListener('click', function () {
                // Toggle the type attribute
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                // Toggle the icon
                toggleIcon.classList.toggle('fa-eye');
                toggleIcon.classList.toggle('fa-eye-slash');
            });
			
			// Client-side email validation
			document.getElementById('loginForm').addEventListener('submit', function(e) {
				const email = document.getElementById('email').value;
				const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;

				if (!emailPattern.test(email)) {
					e.preventDefault();
					alert('Please enter a valid email address');
				}
			});
        </script>
    </body>
</html>